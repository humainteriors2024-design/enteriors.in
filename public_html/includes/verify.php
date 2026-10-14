<?php
/* =====================================================================
   ENTERIORS — FORM VERIFICATION, CAPTCHA AND DAILY LIMITS (every form on the site)
   Used by api/lead.php (the one handler every form posts to), verify/index.php (the one-click
   link in the email) and the form markup (includes/components/lead-form.php, enquiry_dialog()).
   Settings: config.php → TURNSTILE, FORM_LIMITS, FORM_GROUPS, VERIFY.

   The flow, for every form:
     1 details   name, mobile, email, city (+ the form's own fields) and a captcha
                 → checks → one email to the visitor with a 6-digit code AND a one-click link
     2 verify    the code typed into the form, or the link clicked in the email (either works)
                 → the submission is emailed to LEADS['notify_email'] and saved
   Pending requests live in the private leads folder one level above public_html (leads/otp/);
   the code and the link key are never stored, only keyed hashes of them.
   ===================================================================== */

/* ---------- who is asking ---------- */
function client_ip() { return (string) ($_SERVER['REMOTE_ADDR'] ?? ''); }

/* ---------- counters: one small file per key in leads/limits/, holding the times of recent hits ---------- */
function lim_dir() { $d = leads_dir() . '/limits'; if (!is_dir($d)) @mkdir($d, 0700, true); return $d; }
function lim_file($bucket, $key) { return lim_dir() . '/' . $bucket . '_' . substr(hash_hmac('sha256', strtolower((string) $key), LEADS['secret']), 0, 32) . '.txt'; }
function lim_times($bucket, $key) { return array_values(array_filter(array_map('intval', explode("\n", (string) @file_get_contents(lim_file($bucket, $key)))))); }
function lim_count($bucket, $key, $window) { return count(array_filter(lim_times($bucket, $key), fn($t) => $t > time() - $window)); }
function lim_add($bucket, $key, $keep = 2 * 86400) {
  $f = lim_file($bucket, $key);
  $h = array_filter(lim_times($bucket, $key), fn($t) => $t > time() - $keep);
  $h[] = time();
  @file_put_contents($f, implode("\n", $h), LOCK_EX);
}
// hits on today's date in India (IST), for the daily limits
function ist_day($ts = null) { return (new DateTime('@' . ($ts ?? time())))->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('Ymd'); }
function lim_today($bucket, $key) { $d = ist_day(); return count(array_filter(lim_times($bucket, $key), fn($t) => ist_day($t) === $d)); }
// tidy now and then: old counters and finished requests
function verify_tidy() {
  if (random_int(1, 30) !== 1) return;
  foreach (glob(lim_dir() . '/*.txt') ?: [] as $f) if (filemtime($f) < time() - 3 * 86400) @unlink($f);
  foreach (glob(pending_dir() . '/*.json') ?: [] as $f) if (filemtime($f) < time() - max(2 * 3600, VERIFY['code_minutes'] * 120)) @unlink($f);
}

/* ---------- daily limits per person: IP address, email and mobile, each counted separately ---------- */
function form_group($form) { return FORM_GROUPS[$form] ?? 'other'; }
function form_daily_cap($form) { return (int) (FORM_LIMITS[form_group($form)] ?? 3); }
// counters are shared by every form in the 'consultation' group; every other form has its own
function form_bucket($form) { return 'day_' . (form_group($form) === 'consultation' ? 'consultation' : preg_replace('/[^a-z0-9]/', '', $form)); }
function daily_limit_hit($form, $ip, $email, $phone) {
  $cap = form_daily_cap($form); $b = form_bucket($form);
  foreach (['ip' => $ip, 'email' => $email, 'phone' => $phone] as $what => $v)
    if ($v !== '' && lim_today($b . '_' . $what, $v) >= $cap) return $what;
  return '';
}
function daily_limit_add($form, $ip, $email, $phone) {
  $b = form_bucket($form);
  foreach (['ip' => $ip, 'email' => $email, 'phone' => $phone] as $what => $v) if ($v !== '') lim_add($b . '_' . $what, $v);
}
function daily_limit_message($form) {
  $n = form_daily_cap($form);
  return "You have reached today's limit of $n " . ($n === 1 ? 'request' : 'requests') . ' for this form. We already have your details and will be in touch soon. '
       . 'You can send a new request tomorrow' . (NAP['email'] ? ', or email us at ' . NAP['email'] : '') . '.';
}

/* ---------- email address checks ---------- */
// a likely typo in a big provider's name: returns the corrected address, or ''
function email_typo($email) {
  [$u, $d] = array_pad(explode('@', strtolower($email), 2), 2, '');
  $fix = ['gmial.com' => 'gmail.com', 'gmai.com' => 'gmail.com', 'gamil.com' => 'gmail.com', 'gmail.co' => 'gmail.com', 'gmail.con' => 'gmail.com', 'gmail.in' => 'gmail.com',
          'gnail.com' => 'gmail.com', 'gmal.com' => 'gmail.com', 'gmaill.com' => 'gmail.com', 'gmail.cm' => 'gmail.com', 'yaho.com' => 'yahoo.com', 'yahoo.co' => 'yahoo.com',
          'yahooo.com' => 'yahoo.com', 'hotmial.com' => 'hotmail.com', 'hotmail.co' => 'hotmail.com', 'outlok.com' => 'outlook.com', 'outlook.co' => 'outlook.com',
          'rediffmail.co' => 'rediffmail.com', 'redifmail.com' => 'rediffmail.com', 'iclod.com' => 'icloud.com', 'icloud.co' => 'icloud.com'];
  return isset($fix[$d]) ? "$u@{$fix[$d]}" : '';
}
// '' when the address can receive mail, otherwise what is wrong with it
function email_problem($email) {
  if ($email === '') return 'Please enter a valid email address.';
  if ($t = email_typo($email)) return "Did you mean $t? Please check the email address.";
  $d = strtolower(substr(strrchr($email, '@'), 1));
  if (!str_contains($d, '.') || in_array($d, array_map('strtolower', VERIFY['block_domains']), true)) return 'Please use an email address you can receive mail on (not a temporary inbox).';
  if (function_exists('checkdnsrr') && !is_staging() && !checkdnsrr($d, 'MX') && !checkdnsrr($d, 'A')) return 'This email domain cannot receive mail. Please check the address.';
  return '';
}
function mask_email($e) { [$u, $d] = array_pad(explode('@', $e, 2), 2, ''); return mb_substr($u, 0, min(2, max(1, mb_strlen($u) - 1))) . '•••@' . $d; }
// a city or area typed by the visitor
function valid_place($s) { return mb_strlen($s) >= 2 && mb_strlen($s) <= 60 && preg_match("/^[\p{L}\p{M}][\p{L}\p{M}\p{N} .,'()\/\-]*$/u", $s) && preg_match_all('/\p{L}/u', $s) >= 2; }

/* =====================================================================
   CAPTCHA — Cloudflare Turnstile when both keys are in config.php, otherwise a built-in picture captcha
   ===================================================================== */
function captcha_mode() { return (TURNSTILE['site_key'] !== '' && TURNSTILE['secret_key'] !== '') ? 'turnstile' : 'builtin'; }

// The captcha block for a form ($id keeps element ids unique on the page)
function captcha_field($id) {
  if (captcha_mode() === 'turnstile') {
    static $script = false;
    $h = '<div class="captcha captcha--ts"><div class="cf-turnstile" data-sitekey="' . e(TURNSTILE['site_key']) . '" data-size="flexible" data-appearance="interaction-only" data-theme="light"></div>'
       . '<p class="field__error" data-err="captcha" hidden></p></div>';
    if (!$script) { $script = true; $h .= '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>'; }
    return $h;
  }
  [$token, $svg] = captcha_new();
  return '<div class="captcha" data-captcha>'
       . '<label for="' . e($id) . '-cap">Add the numbers</label>'
       . '<div class="captcha__row"><span class="captcha__img" data-captcha-img>' . $svg . '</span>'
       . '<input class="input captcha__input" id="' . e($id) . '-cap" name="captcha_answer" inputmode="numeric" pattern="[0-9]{1,2}" maxlength="2" required autocomplete="off" placeholder="?">'
       . '<button class="captcha__new" type="button" data-captcha-new aria-label="Show different numbers" title="Different numbers">↻</button></div>'
       . '<input type="hidden" name="captcha_token" value="' . e($token) . '"><p class="field__error" data-err="captcha" hidden></p></div>';
}

/* Built-in captcha: two numbers drawn as jittered strokes (no text in the page to read), signed so the
   server needs no storage: token = "<time>.<nonce>.<signature of time|nonce|answer>". Each token works once. */
function captcha_new() {
  $a = random_int(2, 9); $b = random_int(1, 9);
  $ts = time(); $nonce = bin2hex(random_bytes(6));
  $sig = substr(hash_hmac('sha256', "$ts|$nonce|" . ($a + $b), LEADS['secret'] . '|captcha'), 0, 24);
  return ["$ts.$nonce.$sig", captcha_svg("$a+$b=")];
}
function captcha_svg($text) {
  // seven-segment strokes for each character: segments a b c d e f g on a 10×18 cell
  $seg = ['a' => [[1, 1], [9, 1]], 'b' => [[9, 1], [9, 9]], 'c' => [[9, 9], [9, 17]], 'd' => [[1, 17], [9, 17]], 'e' => [[1, 9], [1, 17]], 'f' => [[1, 1], [1, 9]], 'g' => [[1, 9], [9, 9]]];
  $digits = ['0' => 'abcdef', '1' => 'bc', '2' => 'abdeg', '3' => 'abcdg', '4' => 'bcfg', '5' => 'acdfg', '6' => 'acdefg', '7' => 'abc', '8' => 'abcdefg', '9' => 'abcdfg'];
  $j = fn($v) => $v + random_int(-12, 12) / 10;
  $paths = ''; $x = 8;
  foreach (str_split($text) as $ch) {
    $lines = [];
    if (isset($digits[$ch])) foreach (str_split($digits[$ch]) as $s) $lines[] = $seg[$s];
    elseif ($ch === '+') $lines = [[[1, 9], [9, 9]], [[5, 5], [5, 13]]];
    elseif ($ch === '=') $lines = [[[1, 7], [9, 7]], [[1, 12], [9, 12]]];
    $rot = random_int(-14, 14); $y = random_int(5, 9);
    $d = '';
    foreach ($lines as [[$x1, $y1], [$x2, $y2]]) $d .= 'M' . round($j($x1), 1) . ' ' . round($j($y1), 1) . 'L' . round($j($x2), 1) . ' ' . round($j($y2), 1);
    $paths .= '<path transform="translate(' . $x . ' ' . $y . ') rotate(' . $rot . ' 5 9)" d="' . $d . '"/>';
    $x += random_int(15, 18);
  }
  $noise = '';
  for ($i = 0; $i < 3; $i++) $noise .= '<path d="M' . random_int(0, 20) . ' ' . random_int(4, 30) . ' Q' . random_int(30, 60) . ' ' . random_int(0, 34) . ' ' . random_int(80, 100) . ' ' . random_int(4, 30) . '"/>';
  return '<svg viewBox="0 0 ' . ($x + 4) . ' 34" width="' . ($x + 4) . '" height="34" role="img" aria-label="Captcha picture: two numbers to add" focusable="false">'
       . '<g fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">' . $paths . '</g>'
       . '<g fill="none" stroke="currentColor" stroke-width=".8" opacity=".45">' . $noise . '</g></svg>';
}

/* Check the captcha on a submission. Returns '' when it passed, otherwise the message to show.
   $consume = false only checks the built-in answer (it is marked as used once the request is accepted). */
function captcha_check($post, $consume = true) {
  if (captcha_mode() === 'turnstile') {
    $resp = is_scalar($post['cf-turnstile-response'] ?? null) ? (string) $post['cf-turnstile-response'] : '';
    if ($resp === '') return 'Please wait for the security check to finish, then send again.';
    $body = http_build_query(['secret' => TURNSTILE['secret_key'], 'response' => $resp, 'remoteip' => client_ip()]);
    $raw = @file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, stream_context_create(['http' => [
      'method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $body, 'timeout' => 6, 'ignore_errors' => true]]));
    if ($raw === false) {   // Cloudflare could not be reached: let it through (email verification and limits still apply) and note it
      @file_put_contents(leads_dir() . '/rejected.log', date('c') . "\t" . client_ip() . "\tturnstile-unreachable (allowed)\n", FILE_APPEND | LOCK_EX);
      return '';
    }
    $r = json_decode((string) $raw, true);
    return !empty($r['success']) ? '' : 'The security check did not pass. Please try again.';
  }
  $token = is_scalar($post['captcha_token'] ?? null) ? (string) $post['captcha_token'] : '';
  $ans   = preg_replace('/\D/', '', is_scalar($post['captcha_answer'] ?? null) ? (string) $post['captcha_answer'] : '');
  [$ts, $nonce, $sig] = array_pad(explode('.', $token, 3), 3, '');
  if (!ctype_digit($ts) || !preg_match('/^[a-f0-9]{12}$/', $nonce) || time() - (int) $ts > 3 * 3600) return 'The captcha has expired. Please answer the new one.';
  if ($ans === '' || !hash_equals(substr(hash_hmac('sha256', "$ts|$nonce|$ans", LEADS['secret'] . '|captcha'), 0, 24), $sig)) return 'The captcha answer is not right. Please add the two numbers again.';
  if (lim_count('cap', $nonce, 4 * 3600)) return 'This captcha was already used. Please answer the new one.';
  if ($consume) lim_add('cap', $nonce, 4 * 3600);
  return '';
}
function captcha_consume($post) {
  if (captcha_mode() !== 'builtin') return;
  $nonce = explode('.', is_scalar($post['captcha_token'] ?? null) ? (string) $post['captcha_token'] : '', 3)[1] ?? '';
  if (preg_match('/^[a-f0-9]{12}$/', $nonce)) lim_add('cap', $nonce, 4 * 3600);
}

/* =====================================================================
   PENDING REQUESTS — waiting for the code or the link
   ===================================================================== */
function pending_dir() { $d = leads_dir() . '/otp'; if (!is_dir($d)) @mkdir($d, 0700, true); return $d; }
function pending_path($token) { return preg_match('/^[a-f0-9]{32}$/', (string) $token) ? pending_dir() . "/$token.json" : ''; }
function pending_hash($token, $what, $secret) { return hash_hmac('sha256', "$token|$what|$secret", LEADS['secret'] . '|verify'); }
function new_code() { return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT); }
function pending_write($token, $s) { $p = pending_path($token); @file_put_contents($p, json_encode($s, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), LOCK_EX); @chmod($p, 0600); }
// open with an exclusive lock (two tries at once cannot both pass): [handle, state] or [null, null]
function pending_open($token) {
  $p = pending_path($token);
  if (!$p || !is_file($p) || !($fh = @fopen($p, 'r+'))) return [null, null];
  flock($fh, LOCK_EX);
  $s = json_decode((string) stream_get_contents($fh), true);
  return [$fh, is_array($s) ? $s : null];
}
function pending_close($fh, $s = null) {   // save (or, with null, leave) and unlock
  if ($s !== null) { ftruncate($fh, 0); rewind($fh); fwrite($fh, json_encode($s, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); fflush($fh); }
  flock($fh, LOCK_UN); fclose($fh);
}
// the one-click link in the email: on the live site SITE['url'], on staging the address the form was sent from
function site_base() {
  if (!is_staging()) return SITE['url'];
  $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
  return preg_match('/^[a-z0-9.\-]+(:\d+)?$/', $host) ? ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://') . $host : SITE['url'];
}
function verify_link($token, $key) { return site_base() . '/verify/?t=' . $token . '&k=' . $key; }

/* Email the code and the link to the visitor (and, if set up, the code by SMS). Returns true when handed to the mail server. */
function send_verification($s, $token, $code, $key) {
  $mins = (int) VERIFY['code_minutes'];
  $link = verify_link($token, $key);
  $what = $s['what'] ?? 'your request';
  $body = "Hello {$s['name']},\n\nPlease confirm your email address to send $what.\n\n"
        . "Either type this code in the form:\n\n    $code\n\n"
        . "or open this link (one click, on any device):\n\n    $link\n\n"
        . "Both work for $mins minutes. Nothing is sent until you do one of them.\n\n"
        . "Did not ask for this? Ignore this email: nothing happens without the code or the link.\n\n— " . SITE['name'] . ', ' . SITE['url'] . "\n";
  $ok = site_mail($s['email'], (is_staging() ? '[TEST] ' : '') . "$code is your " . SITE['name'] . ' verification code', $body);
  if (is_staging()) {   // staging: the code and link are also written to the private leads folder, so you can test without email
    @file_put_contents(leads_dir() . '/otp-test.log', date('c') . "\t{$s['email']}\t$code\t$link\n", FILE_APPEND | LOCK_EX);
    $ok = true;
  }
  if (VERIFY['sms_webhook'] && !is_staging() && !empty($s['phone'])) {
    @file_get_contents(VERIFY['sms_webhook'], false, stream_context_create(['http' => ['method' => 'POST', 'header' => "Content-Type: application/json\r\n",
      'content' => json_encode(['phone' => '+91' . $s['phone'], 'code' => $code, 'minutes' => $mins]), 'timeout' => 4, 'ignore_errors' => true]]));
  }
  return $ok;
}
function email_limits_ok($email) {
  return lim_count('mail_hour', $email, 3600) < VERIFY['per_email_hour'] && lim_today('mail_day', $email) < VERIFY['per_email_day']
      && lim_today('site_day', 'all') < VERIFY['site_daily_cap'];
}
function email_limits_add($email) { lim_add('mail_hour', $email); lim_add('mail_day', $email); lim_add('site_day', 'all'); }

/* Finish a verified request: re-check the daily limit, deliver it (includes/leads.php) and record the result
   in the pending file so the form that started it (and any other tab) can show it.
   Returns ['ok' => bool, 'message' => …, 'ref' => …, 'form' => …]. Called with the request locked. */
function pending_finish($fh, $s) {
  if (!empty($s['done'])) { pending_close($fh); return ['ok' => true, 'message' => $s['done_msg'], 'ref' => $s['done'], 'form' => $s['form'], 'again' => true]; }
  if ($hit = daily_limit_hit($s['form'], $s['ip'], $s['email'], $s['phone'])) {
    pending_close($fh); @unlink(pending_path($s['token']));
    return ['ok' => false, 'message' => daily_limit_message($s['form']), 'code' => 'limit'];
  }
  $r = $s['type'] === 'enquiry' ? enquiry_deliver($s) : lead_deliver($s);
  if (!$r['ok']) { pending_close($fh); return $r; }
  daily_limit_add($s['form'], $s['ip'], $s['email'], $s['phone']);
  $s['done'] = $r['ref']; $s['done_msg'] = $r['message']; $s['done_at'] = time();
  foreach (['name', 'phone', 'email', 'fields', 'message'] as $k) unset($s[$k]);   // the details now live in the leads CSV, not here
  pending_close($fh, $s);
  return $r + ['form' => $s['form']];
}

/* =====================================================================
   MARKUP shared by every form: one field, and steps 2 (code) and 3 (done)
   ===================================================================== */
function vfield($id, $name, $label, $input, $cls = '') {
  return '<div class="field field--' . e($name) . ($cls ? ' ' . $cls : '') . '"><label for="' . e($id . '-' . $name) . '">' . $label . '</label>' . $input
       . '<p class="field__error" data-err="' . e($name) . '" hidden></p></div>';
}
// the four details every form asks for, with the same names, checks and hints everywhere
function vfields_core($id, $cityName = 'city') {
  static $dl = false;
  $list = '';
  if (!$dl) { $dl = true; $list = '<datalist id="city-list">' . implode('', array_map(fn($c) => '<option value="' . e($c) . '">', LEADS['cities'])) . '</datalist>'; }
  return vfield($id, 'name', 'Name', '<input class="input" id="' . e($id) . '-name" name="name" required minlength="2" maxlength="60" autocomplete="name" placeholder="Your name">')
       . vfield($id, 'phone', 'Mobile', '<input class="input" id="' . e($id) . '-phone" name="phone" type="tel" inputmode="tel" required maxlength="16" pattern="[+]?[0-9\s\-]{10,16}" title="10-digit Indian mobile number" placeholder="98765 43210" autocomplete="tel-national">')
       . vfield($id, 'email', 'Email', '<input class="input" id="' . e($id) . '-email" name="email" type="email" required maxlength="120" autocomplete="email" spellcheck="false" placeholder="you@example.com">')
       . vfield($id, $cityName, 'City / area', '<input class="input" id="' . e($id) . '-' . $cityName . '" name="' . $cityName . '" required minlength="2" maxlength="60" list="city-list" autocomplete="address-level2" placeholder="e.g. HSR Layout, Bengaluru">' . $list);
}
function verify_steps($id, $closeButton = false) {
  return '<form class="form vstep" data-step="verify" method="post" action="' . e(LEADS['endpoint']) . '" hidden novalidate>'
       . '<p class="form__title">Check your email</p>'
       . '<p class="form__text">We sent a 6-digit code and a link to <strong data-v-email></strong>. Type the code here, or just tap the link in the email.</p>'
       . vfield($id, 'code', '6-digit code', '<input class="input vcode" id="' . e($id) . '-code" name="code" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" required>')
       . '<button class="btn btn--primary btn--block" type="submit">Verify and send →</button>'
       . '<p class="vlinks"><button type="button" class="link-btn" data-v-resend disabled>Resend code</button> · <button type="button" class="link-btn" data-v-back>Change details</button></p>'
       . '<p class="form__note">Not there? Check spam or promotions. The code and link work for ' . (int) VERIFY['code_minutes'] . ' minutes.</p>'
       . '</form>'
       . '<div class="vstep vdone" data-step="done" hidden role="status" tabindex="-1"><p class="form__title">✓ Sent</p><p data-v-done></p>'
       . ($closeButton ? '<button class="btn btn--outline btn--block" type="button" data-enq-close>Close</button>' : '') . '</div>';
}
