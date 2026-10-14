<?php
/* =====================================================================
   ENTERIORS — COMPANY ACCOUNTS (interior firms sign in with a one-time code sent to their email)
   Pages:  /company/                sign in (email → 6-digit code) and edit the company profile
           /company/approve.php     one-click approve / reject links emailed to you (signed, expire)
           /admin/companies.php     the same approvals behind the admin password (config.php → ADMIN)
   Data:   leads/companies/<key>.json, one level ABOVE public_html (never reachable from the web)
           Each file: email, status (pending | approved | rejected), claim (existing listing key or ''),
           data (the profile fields below), created, updated, log.
   Live:   an APPROVED profile is merged into the directory (includes/finder.php → pros_db()), so the
           company page /services/find-designer/<key>/ shows it straight away. Pending and rejected
           profiles are never shown. Settings: config.php → COMPANY.
   Who can edit what:
     • an email set in includes/data/pros.php with 'verified' => true signs in to that listing, approved at once
     • any other verified email can register a new firm or claim a listing; you approve it once
   ===================================================================== */

/* ---------- the profile form: key => [label, type, required, extra] ----------
   types: text, textarea, int, year, url, select, multi, radio, pincode, gst, date, rating */
function company_fields() {
  static $f = null;
  if ($f !== null) return $f;
  $T = trends_db(); $C = places_db()['cities'];
  uasort($C, fn($a, $b) => strcmp($a['name'], $b['name']));
  $cities = array_map(fn($c) => $c['name'] . ', ' . state_name($c['state']), $C);
  $services = array_map(fn($t) => $t['label'], $T['types']);
  return $f = [
    // ---- 1. The essentials (all required) ----
    'name'          => ['Company name', 'text', true, ['max' => 80]],
    'segment'       => ['Segment', 'select', true, ['options' => company_segments(), 'help' => 'The kind of homes and budgets you mostly work on.']],
    'office_city'   => ['Main city (office)', 'select', true, ['options' => $cities]],
    'office_area'   => ['Main area / locality (office)', 'text', true, ['max' => 60, 'help' => 'For example HSR Layout, Electronic City or Chandapura. Used for "near me" filtering.']],
    'office_pincode'=> ['Office pincode', 'pincode', true, []],
    'office_address'=> ['Office address', 'textarea', true, ['max' => 240, 'rows' => 2, 'help' => 'Building, street and landmark, as on your Google Business Profile.']],
    'office_map'    => ['Office location on Google Maps', 'url', false, ['hosts' => ['google.com', 'goo.gl', 'g.page', 'maps.app.goo.gl'], 'help' => 'Share link from Google Maps (optional).']],
    'factory'       => ['Factory / own manufacturing', 'radio', true, ['options' => ['own' => 'Own factory', 'partner' => 'Partner factory', 'onsite' => 'Carpentry on site', 'none' => 'Design only, no manufacturing']]],
    'factory_location' => ['Factory location', 'text', false, ['max' => 120, 'help' => 'Area and city of the factory, e.g. Bommasandra Industrial Area, Bengaluru.']],
    'team'          => ['Design team size', 'int', true, ['min' => 1, 'max' => 2000, 'help' => 'Designers and architects only.']],
    'since'         => ['Started in (year)', 'year', true, ['min' => 1950, 'max' => (int) date('Y')]],
    'projects'      => ['Projects completed', 'int', true, ['min' => 0, 'max' => 100000]],
    'gst'           => ['GST number (GSTIN)', 'gst', true, ['help' => '15 characters, e.g. 29ABCDE1234F1Z5. Shown on your page so homeowners can check it.']],
    'specialised'   => ['Specialised in', 'multi', true, ['options' => $services]],
    'warranty_years'=> ['Warranty (years)', 'int', true, ['min' => 0, 'max' => 30]],
    'warranty_text' => ['What the warranty covers', 'textarea', false, ['max' => 240, 'rows' => 2, 'help' => 'For example: 10 years on carcass and shutters, 1 year on workmanship, hardware as per brand.']],
    'models'        => ['How you work', 'multi', true, ['options' => ['bespoke' => 'Bespoke', 'turnkey' => 'Turnkey', 'customisation' => 'Customisation']]],
    'end_to_end'    => ['End-to-end home interiors', 'radio', true, ['options' => ['yes' => 'Yes, design to handover (civil, electrical, painting, woodwork)', 'no' => 'No, woodwork and design only']]],
    'usp1'          => ['USP 1', 'text', true, ['max' => 90, 'help' => 'What makes you different, in one line each.']],
    'usp2'          => ['USP 2', 'text', true, ['max' => 90]],
    'usp3'          => ['USP 3', 'text', true, ['max' => 90]],
    // ---- 2. Offers, prices and materials ----
    'offer'         => ['Ongoing offer', 'text', false, ['max' => 120, 'help' => 'For example: Free 3D design for bookings this month. Leave blank if none.']],
    'offer_till'    => ['Offer valid till', 'date', false, []],
    'price_sqft'    => ['Starting price, ₹ per sq ft', 'int', false, ['min' => 100, 'max' => 20000]],
    'price_2bhk'    => ['2 BHK package from, ₹', 'int', false, ['min' => 10000, 'max' => 50000000]],
    'price_note'    => ['What the price includes', 'textarea', false, ['max' => 200, 'rows' => 2]],
    'mat_board'     => ['Boards you use', 'text', false, ['max' => 120, 'help' => 'For example: BWP IS:710 in kitchen, MR IS:303 elsewhere (brand names welcome).']],
    'mat_finish'    => ['Finishes you offer', 'text', false, ['max' => 120, 'help' => 'For example: laminate, acrylic, PU, veneer.']],
    'mat_hardware'  => ['Hardware brands', 'text', false, ['max' => 120]],
    // ---- 3. About, reach and reviews ----
    'about'         => ['About the company', 'textarea', false, ['max' => 700, 'rows' => 4]],
    'website'       => ['Website', 'url', false, []],
    'serves'        => ['Other cities you work in', 'multi', false, ['options' => $cities, 'max_pick' => 12]],
    'areas'         => ['Localities you cover', 'text', false, ['max' => 240, 'help' => 'Comma separated, e.g. Electronic City, Chandapura, Bommasandra, Hosur Road.']],
    'instagram'     => ['Instagram page', 'url', false, ['hosts' => ['instagram.com']]],
    'facebook'      => ['Facebook page', 'url', false, ['hosts' => ['facebook.com', 'fb.com']]],
    'google'        => ['Google reviews link', 'url', false, ['hosts' => ['google.com', 'goo.gl', 'g.page', 'maps.app.goo.gl'], 'help' => 'The link to your Google Business Profile reviews.']],
    'google_rating' => ['Google rating', 'rating', false, ['help' => 'As shown on your Google profile, e.g. 4.7.']],
    'google_count'  => ['Number of Google reviews', 'int', false, ['min' => 0, 'max' => 100000]],
  ];
}
function company_segments() {
  return ['budget' => 'Basic', 'mid' => 'Mid-range', 'premium' => 'Premium', 'luxury' => 'Luxury', 'traditional' => 'Traditional', 'other' => 'Others'];
}
// Field groups for the form
function company_groups() {
  return [
    'The essentials (required)' => ['name', 'segment', 'office_city', 'office_area', 'office_pincode', 'office_address', 'office_map', 'factory', 'factory_location', 'team', 'since', 'projects', 'gst', 'specialised', 'warranty_years', 'warranty_text', 'models', 'end_to_end', 'usp1', 'usp2', 'usp3'],
    'Offers, prices and materials' => ['offer', 'offer_till', 'price_sqft', 'price_2bhk', 'price_note', 'mat_board', 'mat_finish', 'mat_hardware'],
    'About, reach and reviews' => ['about', 'website', 'serves', 'areas', 'instagram', 'facebook', 'google', 'google_rating', 'google_count'],
  ];
}

/* ---------- validation: returns [clean data, errors] ---------- */
function company_clean($in) {
  $F = company_fields(); $out = []; $err = [];
  $line = fn($v, $max) => mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags((string) $v))), 0, $max);
  foreach ($F as $k => [$label, $type, $req, $x]) {
    $raw = $in[$k] ?? ($type === 'multi' ? [] : '');
    if ($type !== 'multi' && !is_scalar($raw)) $raw = '';
    $v = '';
    switch ($type) {
      case 'text':     $v = $line($raw, $x['max'] ?? 120); break;
      case 'textarea': $v = mb_substr(trim(preg_replace(["/\r\n?/", "/[^\P{C}\n]+/u", "/\n{3,}/"], ["\n", '', "\n\n"], strip_tags((string) $raw))), 0, $x['max'] ?? 600); break;
      case 'int': case 'year':
        $d = preg_replace('/[^\d]/', '', (string) $raw);
        if ($d !== '') { $n = (int) $d; if ($n < ($x['min'] ?? 0) || $n > ($x['max'] ?? PHP_INT_MAX)) $err[$k] = $label . ': enter a number between ' . ($x['min'] ?? 0) . ' and ' . ($x['max'] ?? '') . '.'; else $v = $n; }
        break;
      case 'rating':
        $r = str_replace(',', '.', trim((string) $raw));
        if ($r !== '') { if (!is_numeric($r) || $r < 1 || $r > 5) $err[$k] = 'Google rating: a number from 1.0 to 5.0.'; else $v = round((float) $r, 1); }
        break;
      case 'pincode':
        $p = preg_replace('/\s/', '', (string) $raw);
        if ($p !== '') { if (!preg_match('/^[1-9]\d{5}$/', $p)) $err[$k] = 'Pincode: 6 digits.'; else $v = $p; }
        break;
      case 'gst':
        $g = strtoupper(preg_replace('/\s/', '', (string) $raw));
        if ($g !== '') { if (!preg_match('/^\d{2}[A-Z]{5}\d{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/', $g)) $err[$k] = 'GSTIN: 15 characters, e.g. 29ABCDE1234F1Z5.'; else $v = $g; }
        break;
      case 'date':
        $dt = trim((string) $raw);
        if ($dt !== '') { if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dt) || !strtotime($dt)) $err[$k] = $label . ': choose a date.'; else $v = $dt; }
        break;
      case 'url':
        $u = trim((string) $raw);
        if ($u !== '') {
          if (!preg_match('#^https?://#i', $u)) $u = 'https://' . $u;
          $host = strtolower((string) parse_url($u, PHP_URL_HOST));
          $okHost = !isset($x['hosts']) || array_filter($x['hosts'], fn($h) => $host === $h || str_ends_with($host, '.' . $h));
          if (!filter_var($u, FILTER_VALIDATE_URL) || strlen($u) > 300 || !$okHost) $err[$k] = $label . ': paste the full link' . (isset($x['hosts']) ? ' (' . $x['hosts'][0] . ')' : '') . '.';
          else $v = $u;
        }
        break;
      case 'select': case 'radio':
        $v = array_key_exists((string) $raw, $x['options']) ? (string) $raw : '';
        break;
      case 'multi':
        $v = array_values(array_intersect(array_map('strval', (array) $raw), array_map('strval', array_keys($x['options']))));
        if (isset($x['max_pick'])) $v = array_slice($v, 0, $x['max_pick']);
        break;
    }
    if ($req && ($v === '' || $v === [] ) && !isset($err[$k])) $err[$k] = $label . ' is required.';
    if (in_array($type, ['text', 'textarea'], true) && $v !== '' && spam_reason($v) === 'html') $err[$k] = $label . ': no HTML, please.';
    $out[$k] = $v;
  }
  if (in_array($out['factory'] ?? '', ['own', 'partner'], true) && ($out['factory_location'] ?? '') === '') $err['factory_location'] = 'Factory location is required when you have a factory.';
  if (($out['since'] ?? '') !== '' && ($out['projects'] ?? '') !== '' && $out['projects'] > 0 && (int) date('Y') - $out['since'] < 0) $err['since'] = 'Started in: check the year.';
  return [$out, $err];
}

/* ---------- storage ---------- */
function company_dir() { $d = leads_dir() . '/companies'; if (!is_dir($d)) @mkdir($d, 0700, true); return $d; }
function company_file($key) { return preg_match('/^[a-z0-9\-]{2,100}$/', (string) $key) ? company_dir() . "/$key.json" : ''; }
function company_load($key) { $f = company_file($key); return $f && is_file($f) ? (json_decode((string) file_get_contents($f), true) ?: null) : null; }
function company_save($key, $rec) {
  $f = company_file($key); if (!$f) return false;
  $rec['updated'] = date('c');
  $ok = @file_put_contents($f, json_encode($rec, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), LOCK_EX) !== false;
  @chmod($f, 0600);
  return $ok;
}
function company_all() {
  $out = [];
  foreach (glob(company_dir() . '/*.json') ?: [] as $f) { $r = json_decode((string) file_get_contents($f), true); if ($r) $out[basename($f, '.json')] = $r; }
  return $out;
}
function company_slug($name, $cityKey) {
  $s = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string) $name) ?: (string) $name), '-'));
  $s = substr($s ?: 'company', 0, 60) . ($cityKey ? '-' . $cityKey : '');
  $base = $s; $i = 2;
  while (isset(pros_db_raw()['pros'][$s]) || is_file(company_file($s))) $s = $base . '-' . $i++;
  return $s;
}

/* Listings an email may edit: [key => ['status' => …, 'source' => 'pros'|'file']] */
function company_keys_for_email($email) {
  $email = mail_address($email); if ($email === '') return [];
  $keys = [];
  foreach (pros_db_raw()['pros'] as $k => $p)
    if (!empty($p['verified']) && mail_address($p['email'] ?? '') === $email) $keys[$k] = ['status' => 'approved', 'source' => 'pros'];
  foreach (company_all() as $k => $r)
    if (mail_address($r['email'] ?? '') === $email && ($r['status'] ?? '') !== 'rejected') $keys[$k] = ['status' => $r['status'] ?? 'pending', 'source' => 'file'];
  return $keys;
}

/* ---------- turning a saved profile into a directory listing (used by pros_db()) ---------- */
function company_to_pro($key, $rec, $base = null) {
  $d = $rec['data'] ?? [];
  $city = $d['office_city'] ?? ($base['city'] ?? '');
  $areas = array_values(array_filter(array_map('trim', explode(',', (string) ($d['areas'] ?? '')))));
  $reqs = ['designer'];
  if (($d['warranty_years'] ?? 0) > 0) $reqs[] = 'warranty';
  if (($d['factory'] ?? '') === 'own') $reqs[] = 'factory';
  if (($d['end_to_end'] ?? '') === 'yes') array_push($reqs, 'end-to-end', 'civil', 'plumbing', 'electrical');
  $p = array_merge($base ?? [
    'type' => 'designer', 'rating' => 0, 'reviews' => 0, 'languages' => [], 'apartments' => [], 'team_names' => [],
    'reply' => 'Usually replies within a day', 'sample_reviews' => [], 'email' => '', 'verified' => false,
  ], [
    'name' => $d['name'] ?? ($base['name'] ?? ''), 'city' => $city, 'area' => $d['office_area'] ?? '', 'pincode' => $d['office_pincode'] ?? '',
    'serves' => array_values(array_unique(array_merge([$city], (array) ($d['serves'] ?? [])))),
    'areas' => $areas ?: array_filter([$d['office_area'] ?? '']),
    'segment' => $d['segment'] ?? 'mid', 'since' => (int) ($d['since'] ?? date('Y')), 'projects' => (int) ($d['projects'] ?? 0), 'team' => (int) ($d['team'] ?? 1),
    'warranty' => (int) ($d['warranty_years'] ?? 0), 'reqs' => array_values(array_unique(array_merge($base['reqs'] ?? [], $reqs))),
    'services' => $d['specialised'] ?: ($base['services'] ?? []),
    'price' => !empty($d['price_sqft']) ? 'From ₹' . number_format((int) $d['price_sqft']) . ' per sq ft' : (!empty($d['price_2bhk']) ? '2 BHK from ' . money_short($d['price_2bhk']) : ($base['price'] ?? 'Ask for a quote')),
    'about' => $d['about'] ?: ($base['about'] ?? ''),
    'email' => $rec['email'] ?? '', 'verified' => true, 'sample' => false, 'sample_reviews' => [], 'company' => $d + ['updated' => $rec['updated'] ?? ''],
  ]);
  if (!empty($d['google_rating'])) { $p['rating'] = (float) $d['google_rating']; $p['reviews'] = (int) ($d['google_count'] ?? 0); $p['rating_source'] = 'Google'; }
  if (empty($d['google_rating'])) { $p['rating'] = 0; $p['reviews'] = 0; }
  return $p;
}
function company_merge($db) {
  if (!function_exists('leads_dir')) return $db;
  foreach (company_all() as $key => $rec) {
    if (($rec['status'] ?? '') !== 'approved' || empty($rec['data']['name']) || empty($rec['data']['office_city'])) continue;
    if (!isset(places_db()['cities'][$rec['data']['office_city']])) continue;
    $target = $rec['claim'] ?: $key;
    $db['pros'][$target] = company_to_pro($target, $rec, $db['pros'][$target] ?? null);
  }
  return $db;
}

/* ---------- sign-in: session, codes, limits ---------- */
function company_session() {
  if (session_status() === PHP_SESSION_ACTIVE) return;
  session_name('ent_co');
  session_set_cookie_params(['lifetime' => COMPANY['session_days'] * 86400, 'path' => COMPANY['url'], 'secure' => !is_staging() || !empty($_SERVER['HTTPS']), 'httponly' => true, 'samesite' => 'Lax']);
  ini_set('session.use_strict_mode', '1');
  ini_set('session.gc_maxlifetime', (string) (COMPANY['session_days'] * 86400));
  $dir = leads_dir() . '/sessions'; if (!is_dir($dir)) @mkdir($dir, 0700, true);
  if (is_dir($dir) && is_writable($dir)) session_save_path($dir);
  session_start();
  if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
function company_csrf_field() { return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf'] ?? '') . '">'; }
function company_csrf_ok() { return is_string($_POST['csrf'] ?? null) && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']); }
function company_user() { return $_SESSION['co_email'] ?? ''; }

function co_lim_file($bucket, $key) { $d = leads_dir() . '/limits'; if (!is_dir($d)) @mkdir($d, 0700, true); return $d . '/co_' . $bucket . '_' . substr(hash_hmac('sha256', (string) $key, LEADS['secret']), 0, 32) . '.txt'; }
function co_lim_count($bucket, $key, $window) { return count(array_filter(array_map('intval', explode("\n", (string) @file_get_contents(co_lim_file($bucket, $key)))), fn($t) => $t > time() - $window)); }
function co_lim_add($bucket, $key, $window) {
  $f = co_lim_file($bucket, $key);
  $h = array_filter(array_map('intval', explode("\n", (string) @file_get_contents($f))), fn($t) => $t > time() - $window);
  $h[] = time(); @file_put_contents($f, implode("\n", $h), LOCK_EX);
}
function company_send_code($email) {
  $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
  $_SESSION['co_pending'] = ['email' => $email, 'hash' => hash_hmac('sha256', $email . '|' . $code, LEADS['secret'] . '|co'), 'exp' => time() + COMPANY['otp_minutes'] * 60, 'tries' => 0, 'sent' => time()];
  $mins = (int) COMPANY['otp_minutes'];
  $body = "Your " . SITE['name'] . " company sign-in code is:\n\n    $code\n\nIt works for $mins minutes. Enter it on " . SITE['url'] . COMPANY['url'] . " to update your company profile.\n\n"
        . "Did not ask for this? Ignore this email: nobody can sign in without the code.\n\n— " . SITE['name'] . "\n";
  $ok = site_mail($email, (is_staging() ? '[TEST] ' : '') . "$code is your " . SITE['name'] . ' company sign-in code', $body);
  if (is_staging()) { @file_put_contents(leads_dir() . '/otp-test.log', date('c') . "\tcompany\t$email\t$code\n", FILE_APPEND | LOCK_EX); $ok = true; }
  return $ok;
}
function company_check_code($code) {
  $p = $_SESSION['co_pending'] ?? null;
  if (!$p) return 'gone';
  if (time() > $p['exp']) { unset($_SESSION['co_pending']); return 'expired'; }
  if ($p['tries'] >= COMPANY['otp_attempts']) { unset($_SESSION['co_pending']); return 'tries'; }
  $_SESSION['co_pending']['tries']++;
  if (!preg_match('/^\d{6}$/', (string) $code) || !hash_equals($p['hash'], hash_hmac('sha256', $p['email'] . '|' . $code, LEADS['secret'] . '|co'))) return 'wrong';
  session_regenerate_id(true);
  $_SESSION['co_email'] = $p['email'];
  unset($_SESSION['co_pending']);
  return '';
}

/* ---------- approval links for the site owner (signed; valid for 30 days) ---------- */
function company_approve_link($key, $action) {
  $ts = time();
  return SITE['url'] . '/company/approve.php?k=' . rawurlencode($key) . '&a=' . $action . '&ts=' . $ts . '&s=' . substr(hash_hmac('sha256', "$key|$action|$ts", LEADS['secret'] . '|approve'), 0, 32);
}
function company_approve_ok($key, $action, $ts, $sig) {
  return in_array($action, ['approve', 'reject'], true) && ctype_digit((string) $ts) && time() - (int) $ts < 30 * 86400
      && hash_equals(substr(hash_hmac('sha256', "$key|$action|$ts", LEADS['secret'] . '|approve'), 0, 32), (string) $sig);
}
function company_notify_admin($subject, $lines) {
  if (empty(COMPANY['notify_admin'])) return;
  site_mail(LEADS['notify_email'], (is_staging() ? '[TEST] ' : '') . $subject, implode("\n", $lines) . "\n\n— " . SITE['name'] . " company accounts\n");
}
