<?php
/* =====================================================================
   COMPANY LOGIN AND PROFILE — /company/
   Interior firms sign in with their email and a 6-digit one-time code (no passwords),
   then fill in or update their company profile. Engine and fields: includes/company.php.
   Settings: config.php → COMPANY. Profiles are saved one level above public_html (leads/companies/).
   Steps:  email → code → (new firm: register or claim a listing) → profile form → saved
   Every form posts back to this page; each POST is checked for the site origin and a session token.
   ===================================================================== */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
company_session();

$self   = COMPANY['url'];
$in     = fn($k) => is_scalar($_POST[$k] ?? null) ? trim((string) $_POST[$k]) : '';
$flash  = function ($msg, $type = 'ok') { $_SESSION['co_flash'] = [$type, $msg]; };
$go     = function ($q = '') use ($self) { header('Location: ' . $self . ($q ? '?' . $q : ''), true, 303); exit; };
$ip     = $_SERVER['REMOTE_ADDR'] ?? '';
$email  = company_user();
$errors = []; $values = null;

/* =================== POST actions =================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!same_site_request() || !company_csrf_ok()) { $flash('Your session expired. Please try again.', 'err'); $go(); }
  $action = $in('action');

  if ($action === 'send' || $action === 'resend') {                       // 1. email → code
    $to = $action === 'resend' ? ($_SESSION['co_pending']['email'] ?? '') : mail_address($in('email'));
    if ($to === '') { $flash('Please enter a valid email address.', 'err'); $go(); }
    if ($action === 'resend' && time() - ($_SESSION['co_pending']['sent'] ?? 0) < COMPANY['resend_seconds']) { $flash('Please wait a few seconds before asking for another code.', 'err'); $go('step=code'); }
    if (co_lim_count('ip', $ip, 3600) >= COMPANY['per_ip_hour'] || co_lim_count('mail', $to, 3600) >= COMPANY['per_email_hour']) { $flash('Too many codes requested. Please try again in an hour.', 'err'); $go(); }
    co_lim_add('ip', $ip, 3600); co_lim_add('mail', $to, 3600);
    if (!company_send_code($to)) { $flash('We could not send the code just now. Please try again in a minute, or email ' . NAP['email'] . '.', 'err'); $go(); }
    $go('step=code');
  }

  if ($action === 'verify') {                                              // 2. code → signed in
    $why = company_check_code(preg_replace('/\D/', '', $in('code')));
    if ($why === '') { $flash('You are signed in.'); $go(); }
    $flash(['wrong' => 'That code is not right. Check the latest email and try again.', 'expired' => 'That code has expired. Please ask for a new one.', 'tries' => 'Too many wrong codes. Please ask for a new one.', 'gone' => 'Please enter your email again.'][$why], 'err');
    $go($why === 'wrong' ? 'step=code' : '');
  }

  if ($action === 'logout') { $_SESSION = []; session_regenerate_id(true); $_SESSION['csrf'] = bin2hex(random_bytes(16)); $flash('You are signed out.'); $go(); }

  if ($email === '') { $flash('Please sign in first.', 'err'); $go(); }
  $mine = company_keys_for_email($email);

  if ($action === 'register') {                                            // 3. a new firm, or a claim on a listing
    $mode = $in('mode') === 'claim' ? 'claim' : 'new';
    $name = mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags($in('name')))), 0, 80);
    $city = array_key_exists($in('city'), places_db()['cities']) ? $in('city') : '';
    $claim = $mode === 'claim' && isset(pros_db_raw()['pros'][$in('claim')]) && empty(pros_db_raw()['pros'][$in('claim')]['sample']) ? $in('claim') : '';
    if ($mode === 'claim' && !$claim) { $flash('Please choose the listing you want to claim.', 'err'); $go('step=register'); }
    if ($mode === 'new' && (mb_strlen($name) < 2 || !$city)) { $flash('Please enter the company name and its main city.', 'err'); $go('step=register'); }
    if (count($mine) >= 5) { $flash('This email already manages five companies. Write to ' . NAP['email'] . ' to add more.', 'err'); $go(); }
    $key = $claim ? $claim : company_slug($name, $city);
    if ($claim && company_load($claim)) { $flash('Someone has already asked to manage this listing. Write to ' . NAP['email'] . ' and we will sort it out.', 'err'); $go('step=register'); }
    $base = $claim ? pros_db_raw()['pros'][$claim] : null;
    $rec = ['email' => $email, 'status' => 'pending', 'claim' => $claim, 'created' => date('c'), 'log' => [[date('c'), 'registered', $ip]],
            'data' => $claim ? ['name' => $base['name'], 'office_city' => $base['city'], 'office_area' => $base['area'], 'office_pincode' => $base['pincode']] : ['name' => $name, 'office_city' => $city]];
    company_save($key, $rec);
    company_notify_admin('Company ' . ($claim ? 'claim' : 'registration') . ': ' . $rec['data']['name'], [
      ($claim ? 'A firm asked to manage the listing "' . $base['name'] . '" (' . pro_url($claim) . ').' : 'A new firm registered: ' . $name . ', ' . city_name($city) . '.'),
      'Email (verified with a code): ' . $email, '',
      'Approve: ' . company_approve_link($key, 'approve'), 'Reject:  ' . company_approve_link($key, 'reject'), '',
      'Or review it at ' . SITE['url'] . '/admin/companies.php',
    ]);
    $flash('Thank you. Fill in your profile now; it goes live as soon as we approve your account (usually within one working day).');
    $go('k=' . rawurlencode($key));
  }

  if ($action === 'save') {                                                // 4. the profile
    $key = $in('key');
    if (!isset($mine[$key])) { $flash('You cannot edit that listing.', 'err'); $go(); }
    [$data, $errors] = company_clean($_POST);
    if (!$errors) {
      $rec = company_load($key) ?? ['email' => $email, 'status' => $mine[$key]['status'], 'claim' => '', 'created' => date('c'), 'log' => []];
      $before = $rec['data'] ?? [];
      $rec['data'] = $data;
      $rec['log'] = array_slice(array_merge($rec['log'] ?? [], [[date('c'), 'saved', $ip]]), -20);
      company_save($key, $rec);
      $changed = array_keys(array_filter($data, fn($v, $k) => ($before[$k] ?? null) != $v, ARRAY_FILTER_USE_BOTH));
      if ($changed) company_notify_admin('Company profile updated: ' . $data['name'], [
        $data['name'] . ' (' . $email . ') updated: ' . implode(', ', array_map(fn($k) => company_fields()[$k][0], $changed)) . '.',
        'Status: ' . $rec['status'] . ($rec['status'] === 'approved' ? ' (the changes are live: ' . SITE['url'] . pro_url($rec['claim'] ?: $key) . ')' : ''),
        $rec['status'] === 'pending' ? "\nApprove: " . company_approve_link($key, 'approve') . "\nReject:  " . company_approve_link($key, 'reject') : '',
      ]);
      $flash($rec['status'] === 'approved' ? 'Saved. Your company page is updated.' : 'Saved. Your profile will go live once your account is approved.');
      $go('k=' . rawurlencode($key));
    }
    $values = $data;   // show the form again with the errors
  }
}

/* =================== what to show =================== */
$step  = is_scalar($_GET['step'] ?? null) ? (string) $_GET['step'] : '';
$mine  = $email ? company_keys_for_email($email) : [];
$key   = is_scalar($_GET['k'] ?? null) ? (string) $_GET['k'] : ($_POST['key'] ?? '');
if ($email && !isset($mine[$key])) $key = count($mine) === 1 ? array_key_first($mine) : '';
$flashMsg = $_SESSION['co_flash'] ?? null; unset($_SESSION['co_flash']);

$rec = $key ? company_load($key) : null;
if ($email && $key && $values === null) {
  $values = $rec['data'] ?? [];
  $src = pros_db_raw()['pros'][$rec['claim'] ?? $key] ?? (pros_db_raw()['pros'][$key] ?? null);
  if ($src && empty($rec['data']['segment'])) $values += ['name' => $src['name'], 'segment' => $src['segment'], 'office_city' => $src['city'], 'office_area' => $src['area'], 'office_pincode' => $src['pincode'],
      'team' => $src['team'], 'since' => $src['since'], 'projects' => $src['projects'], 'warranty_years' => $src['warranty'], 'specialised' => $src['services'], 'about' => $src['about'],
      'factory' => in_array('factory', $src['reqs'], true) ? 'own' : '', 'end_to_end' => in_array('end-to-end', $src['reqs'], true) ? 'yes' : ''];
}
$status = $key ? ($rec['status'] ?? ($mine[$key]['status'] ?? 'pending')) : '';
$publicKey = $key ? (($rec['claim'] ?? '') ?: $key) : '';

$page = [
  'type' => 'page', 'title' => 'Company login', 'seo_title' => 'Company login for interior firms', 'noindex' => true, 'css' => ['company'],
  'description' => 'Interior design firms: sign in with your email and a one-time code to update your company profile on Enteriors.',
  'crumb' => 'Company login',
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';

/* one form field */
$field = function ($k) use ($values, $errors) {
  [$label, $type, $req, $x] = company_fields()[$k];
  $v = $values[$k] ?? ($type === 'multi' ? [] : '');
  $id = 'co-' . $k; $err = $errors[$k] ?? '';
  $h = '<div class="field co-field co-field--' . $type . ($err ? ' has-error' : '') . '">';
  $lab = e($label) . ($req ? ' <span class="co-req" aria-hidden="true">*</span>' : ' <small>(optional)</small>');
  $help = !empty($x['help']) ? '<p class="co-help">' . e($x['help']) . '</p>' : '';
  $attr = ' id="' . $id . '" name="' . e($k) . '"' . ($req && !in_array($type, ['multi', 'radio'], true) ? ' required' : '') . ($err ? ' aria-invalid="true"' : '');
  switch ($type) {
    case 'textarea': $h .= '<label for="' . $id . '">' . $lab . '</label><textarea class="input"' . $attr . ' rows="' . (int) ($x['rows'] ?? 3) . '" maxlength="' . (int) ($x['max'] ?? 600) . '">' . e($v) . '</textarea>'; break;
    case 'select':
      $h .= '<label for="' . $id . '">' . $lab . '</label><select class="input"' . $attr . '><option value="">Choose…</option>';
      foreach ($x['options'] as $ok => $ol) $h .= '<option value="' . e($ok) . '"' . ((string) $ok === (string) $v ? ' selected' : '') . '>' . e($ol) . '</option>';
      $h .= '</select>'; break;
    case 'radio': case 'multi':
      $h .= '<fieldset class="co-opts"><legend>' . $lab . '</legend>';
      foreach ($x['options'] as $ok => $ol) {
        $on = $type === 'multi' ? in_array((string) $ok, array_map('strval', (array) $v), true) : (string) $ok === (string) $v;
        $h .= '<label class="co-opt"><input type="' . ($type === 'multi' ? 'checkbox' : 'radio') . '" name="' . e($k) . ($type === 'multi' ? '[]' : '') . '" value="' . e($ok) . '"' . ($on ? ' checked' : '') . '><span>' . e($ol) . '</span></label>';
      }
      $h .= '</fieldset>'; break;
    default:
      $t = ['int' => 'number', 'year' => 'number', 'url' => 'url', 'date' => 'date', 'rating' => 'number'][$type] ?? 'text';
      $extra = match ($type) {
        'int', 'year' => ' inputmode="numeric" min="' . (int) ($x['min'] ?? 0) . '" max="' . (int) ($x['max'] ?? 999999999) . '"',
        'rating' => ' step="0.1" min="1" max="5" inputmode="decimal"',
        'pincode' => ' inputmode="numeric" pattern="[1-9][0-9]{5}" maxlength="6" autocomplete="postal-code"',
        'gst' => ' pattern="[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z][1-9A-Za-z][Zz][0-9A-Za-z]" maxlength="15" style="text-transform:uppercase"',
        'url' => ' placeholder="https://"',
        default => isset($x['max']) ? ' maxlength="' . (int) $x['max'] . '"' : '',
      };
      $h .= '<label for="' . $id . '">' . $lab . '</label><input class="input" type="' . $t . '"' . $attr . ' value="' . e($v) . '"' . $extra . '>';
  }
  return $h . $help . ($err ? '<p class="field__error">' . e($err) . '</p>' : '') . '</div>';
};
?>
<section class="section co">
  <div class="container co__wrap">
    <?= component('breadcrumbs', ['crumbs' => $crumbs]) ?>
    <header class="co__head">
      <span class="eyebrow">For interior design firms</span>
      <h1><?= $email ? 'Your company profile' : 'Company login' ?></h1>
      <p class="subheading"><?= $email ? 'Signed in as <strong>' . e($email) . '</strong>' : 'No password needed: we email you a 6-digit code each time you sign in.' ?></p>
    </header>

<?php if ($flashMsg): ?>
    <p class="co-flash co-flash--<?= e($flashMsg[0]) ?>" role="<?= $flashMsg[0] === 'err' ? 'alert' : 'status' ?>"><?= e($flashMsg[1]) ?></p>
<?php endif; ?>

<?php if (!$email && $step === 'code' && !empty($_SESSION['co_pending'])): /* ---------- code ---------- */ ?>
    <form class="form co-card" method="post" action="<?= e($self) ?>">
      <p class="form__title">Check your email</p>
      <p class="form__text">We sent a 6-digit code to <strong><?= e($_SESSION['co_pending']['email']) ?></strong>. It works for <?= (int) COMPANY['otp_minutes'] ?> minutes. Check spam if it has not arrived.</p>
      <div class="field"><label for="co-code">Sign-in code</label><input class="input co-code" id="co-code" name="code" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" required autofocus></div>
      <?= company_csrf_field() ?><input type="hidden" name="action" value="verify">
      <button class="btn btn--primary btn--block" type="submit">Sign in →</button>
    </form>
    <form class="co-links" method="post" action="<?= e($self) ?>"><?= company_csrf_field() ?><input type="hidden" name="action" value="resend"><button class="link-btn" type="submit">Send a new code</button> · <a href="<?= e($self) ?>">Use another email</a></form>

<?php elseif (!$email): /* ---------- email ---------- */ ?>
    <div class="co-split">
      <form class="form co-card" method="post" action="<?= e($self) ?>">
        <p class="form__title">Sign in with your work email</p>
        <div class="field"><label for="co-email">Email</label><input class="input" id="co-email" name="email" type="email" required maxlength="120" autocomplete="email" spellcheck="false" placeholder="you@yourcompany.com"></div>
        <?= company_csrf_field() ?><input type="hidden" name="action" value="send">
        <button class="btn btn--primary btn--block" type="submit">Email me a sign-in code →</button>
        <p class="form__note">New here? Use the same button: after the code, you can register your company or claim an existing listing.</p>
      </form>
      <div class="co-why">
        <h2>What you can do</h2>
        <ul class="ticks">
          <li>Keep your segment, office and factory locations, team, projects and GST number up to date</li>
          <li>List your USPs, warranties, materials, prices and ongoing offers</li>
          <li>Show your Instagram, Facebook and Google reviews</li>
          <li>Get homeowner enquiries, each one verified by email first</li>
        </ul>
        <p class="muted">Your email address is never shown on the site. Enquiries reach you through our verified enquiry form.</p>
      </div>
    </div>

<?php elseif (!$key && ($step === 'register' || !$mine)): /* ---------- register or claim ---------- */
    $cities = places_db()['cities']; uasort($cities, fn($a, $b) => strcmp($a['name'], $b['name']));
    $listings = array_filter(pros_db_raw()['pros'], fn($l) => empty($l['sample'])); uasort($listings, fn($a, $b) => strcmp($a['name'], $b['name'])); ?>
    <div class="co-split">
      <form class="form co-card" method="post" action="<?= e($self) ?>">
        <p class="form__title">Register your company</p>
        <input type="hidden" name="mode" value="new">
        <div class="field"><label for="co-rname">Company name</label><input class="input" id="co-rname" name="name" required maxlength="80"></div>
        <div class="field"><label for="co-rcity">Main city</label><select class="input" id="co-rcity" name="city" required><option value="">Choose…</option><?php foreach ($cities as $ck => $c) echo '<option value="' . e($ck) . '">' . e($c['name'] . ', ' . state_name($c['state'])) . '</option>'; ?></select></div>
        <?= company_csrf_field() ?><input type="hidden" name="action" value="register">
        <button class="btn btn--primary btn--block" type="submit">Continue to the profile →</button>
      </form>
<?php if ($listings): ?>
      <form class="form co-card" method="post" action="<?= e($self) ?>">
        <p class="form__title">Or claim an existing listing</p>
        <p class="form__text">If your firm is already listed, claim it to manage it. We check every claim before it goes live.</p>
        <input type="hidden" name="mode" value="claim">
        <div class="field"><label for="co-claim">Listing</label><select class="input" id="co-claim" name="claim" required><option value="">Choose…</option><?php foreach ($listings as $lk => $l) echo '<option value="' . e($lk) . '">' . e($l['name'] . ' — ' . city_name($l['city'])) . '</option>'; ?></select></div>
        <?= company_csrf_field() ?><input type="hidden" name="action" value="register">
        <button class="btn btn--outline btn--block" type="submit">Claim this listing →</button>
      </form>
<?php else: ?>
      <div class="co-why"><h2>What happens next</h2><ol><li>Register with your company name and city.</li><li>Fill in the profile: the required fields take about ten minutes.</li><li>We check your details (usually within one working day) and your page goes live.</li></ol></div>
<?php endif; ?>
    </div>

<?php elseif (!$key): /* ---------- several companies: pick one ---------- */ ?>
    <div class="co-card">
      <p class="form__title">Choose a company</p>
      <ul class="co-list"><?php foreach ($mine as $k => $m) { $r = company_load($k); $n = $r['data']['name'] ?? (pros_db_raw()['pros'][$k]['name'] ?? $k); echo '<li><a href="' . e($self . '?k=' . rawurlencode($k)) . '">' . e($n) . '</a> <span class="co-status co-status--' . e($m['status']) . '">' . e(ucfirst($m['status'])) . '</span></li>'; } ?></ul>
      <p><a class="link-arrow" href="<?= e($self . '?step=register') ?>">Register another company</a></p>
    </div>

<?php else: /* ---------- the profile form ---------- */ ?>
    <div class="co-status-bar">
      <span class="co-status co-status--<?= e($status) ?>"><?= e(['approved' => 'Live', 'pending' => 'Waiting for approval', 'rejected' => 'Not approved'][$status] ?? $status) ?></span>
<?php if ($status === 'approved' && !phase2_hidden(FINDER['pros_url'])): ?>
      <a class="link-arrow" href="<?= e(pro_url($publicKey)) ?>" target="_blank" rel="noopener">View your company page</a>
<?php elseif ($status === 'approved'): ?>
      <span class="muted">Your page goes public when the directory launches. Keep your details ready.</span>
<?php else: ?>
      <span class="muted">You can fill everything in now; it goes live once approved.</span>
<?php endif; ?>
      <?php if (count($mine) > 1): ?><a href="<?= e($self) ?>">Switch company</a><?php endif; ?>
    </div>
<?php if ($errors): ?>
    <p class="co-flash co-flash--err" role="alert">Please check the <?= count($errors) ?> highlighted field<?= count($errors) === 1 ? '' : 's' ?> below.</p>
<?php endif; ?>
    <form class="form co-form" method="post" action="<?= e($self . '?k=' . rawurlencode($key)) ?>" novalidate>
<?php $n = 0; foreach (company_groups() as $title => $keys): $n++; ?>
      <fieldset class="co-group">
        <legend><span><?= $n ?></span><?= e($title) ?></legend>
        <div class="co-grid">
<?php foreach ($keys as $k) echo '          ' . $field($k) . "\n"; ?>
        </div>
      </fieldset>
<?php endforeach; ?>
      <?= company_csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="key" value="<?= e($key) ?>">
      <div class="co-save">
        <button class="btn btn--primary" type="submit">Save profile</button>
        <p class="form__note">Fields marked * are required. By saving you confirm the details are true and that you may publish them for this firm.</p>
      </div>
    </form>
<?php endif; ?>

<?php if ($email): ?>
    <form class="co-links" method="post" action="<?= e($self) ?>"><?= company_csrf_field() ?><input type="hidden" name="action" value="logout"><button class="link-btn" type="submit">Sign out</button></form>
<?php endif; ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
