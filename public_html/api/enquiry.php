<?php
/* =====================================================================
   ENTERIORS — OTP-VERIFIED ENQUIRIES
   The "Contact" and "Mail" buttons on trending designs and directory profiles post here.
   Settings: config.php → ENQUIRY and LEADS. Listings: includes/finder.php. Mail: includes/mailer.php.

     action=start   the details form → checks → a 6-digit code is emailed to the visitor
     action=resend  a new code for the same request (limited, with a wait between codes)
     action=verify  the code → the enquiry is emailed to the firm (Reply-To = the visitor),
                    a copy goes to LEADS['notify_email'], a confirmation to the visitor

   Checks on start, in order: POST → same-site origin → honeypot → form key (genuine, not too
   fast, not too old) → connection limit → fields (name, Indian mobile, email that can receive
   mail, location, message, consent) → no links/HTML/spam words → the listing exists →
   per-email, per-mobile and site-wide limits. After the code is verified: not sent twice to
   the same firm within ENQUIRY['repeat_hours'].

   Codes are never stored, only a keyed hash; each works for ENQUIRY['otp_minutes'], allows
   ENQUIRY['otp_attempts'] tries and works once. Requests are kept in the private leads folder
   one level above public_html (leads/otp/). A firm's own email is never sent to the browser:
   while a firm has no verified email in pros.php, its enquiries go to LEADS['notify_email'].
   ===================================================================== */
require __DIR__ . '/../includes/site.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');

function out($ok, $msg, $code = 200, $extra = []) {
  http_response_code($code);
  echo json_encode(['ok' => $ok, 'message' => $msg] + $extra, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  exit;
}
$dir    = leads_dir();
$otpDir = $dir . '/otp';
$limDir = $dir . '/limits';
foreach ([$otpDir, $limDir] as $d) if (!is_dir($d)) @mkdir($d, 0700, true);
$ip  = $_SERVER['REMOTE_ADDR'] ?? '';
$log = function ($why) use ($dir, $ip) {   // rejected attempts, for you to review (never shown to visitors)
  @file_put_contents($dir . '/rejected.log', date('c') . "\t$ip\tenquiry-$why\t" . substr(json_encode(array_diff_key($_POST, ['fk' => 1, 'code' => 1, 'token' => 1]), JSON_UNESCAPED_UNICODE), 0, 500) . "\n", FILE_APPEND | LOCK_EX);
};

/* ---------- small helpers ---------- */
// sliding-window counter: one file per key, holding the times of recent hits
function lim_file($bucket, $key) { global $limDir; return $limDir . '/' . $bucket . '_' . substr(hash_hmac('sha256', (string) $key, LEADS['secret']), 0, 32) . '.txt'; }
function lim_count($bucket, $key, $window) {
  return count(array_filter(array_map('intval', explode("\n", (string) @file_get_contents(lim_file($bucket, $key)))), fn($t) => $t > time() - $window));
}
function lim_add($bucket, $key, $window) {
  $f = lim_file($bucket, $key);
  $h = array_filter(array_map('intval', explode("\n", (string) @file_get_contents($f))), fn($t) => $t > time() - $window);
  $h[] = time();
  @file_put_contents($f, implode("\n", $h), LOCK_EX);
}
function otp_path($token) { global $otpDir; return preg_match('/^[a-f0-9]{32}$/', (string) $token) ? "$otpDir/$token.json" : ''; }
function otp_hash($token, $code) { return hash_hmac('sha256', $token . '|' . $code, LEADS['secret']); }
function otp_code() { return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT); }
function otp_write($path, $s) { @file_put_contents($path, json_encode($s, JSON_UNESCAPED_UNICODE), LOCK_EX); @chmod($path, 0600); }
// open a pending request with an exclusive lock (so two tries at once cannot both pass): [handle, state] or [null, null]
function otp_open($token) {
  $p = otp_path($token);
  if (!$p || !is_file($p) || !($fh = @fopen($p, 'r+'))) return [null, null];
  flock($fh, LOCK_EX);
  $s = json_decode((string) stream_get_contents($fh), true);
  return is_array($s) ? [$fh, $s] : [$fh, null];
}
function otp_close($fh, $s = null) {   // save (or, with null, leave) and unlock
  if ($s !== null) { ftruncate($fh, 0); rewind($fh); fwrite($fh, json_encode($s, JSON_UNESCAPED_UNICODE)); fflush($fh); }
  flock($fh, LOCK_UN); fclose($fh);
}
function mask_email($e) { [$u, $d] = explode('@', $e, 2); return mb_substr($u, 0, min(2, max(1, mb_strlen($u) - 1))) . str_repeat('•', 3) . '@' . $d; }

// What the visitor is asking about, worked out on the server from our own data
function enquiry_target($kind, $key) {
  if ($kind === 'design' && ($d = design($key)) && ($p = pro($d['company'])))
    return ['kind' => 'design', 'key' => $key, 'pro_key' => $d['company'], 'pro' => $p, 'name' => $p['name'], 'about' => $d['title'],
            'url' => SITE['url'] . design_url($key), 'path' => design_url($key), 'sample' => !empty($d['sample']) || !empty($p['sample'])];
  if ($kind === 'pro' && ($p = pro($key)))
    return ['kind' => 'pro', 'key' => $key, 'pro_key' => $key, 'pro' => $p, 'name' => $p['name'], 'about' => 'Directory profile: ' . $p['name'],
            'url' => SITE['url'] . pro_url($key), 'path' => pro_url($key), 'sample' => !empty($p['sample'])];
  return null;
}
// Where it goes: the firm's own verified email on the live site, otherwise our inbox (to forward)
function enquiry_recipient($t) {
  $own = mail_address($t['pro']['email'] ?? '');
  if ($own && !empty($t['pro']['verified']) && !$t['sample'] && !is_staging()) return [$own, true];
  return [mail_address(LEADS['notify_email']), false];
}
// Email the code (and, if set up, send it by SMS too)
function send_code($s, $code) {
  $mins = (int) ENQUIRY['otp_minutes'];
  $body = "Your " . SITE['name'] . " verification code is:\n\n    $code\n\n"
        . "It works for $mins minutes. Enter it in the form to send your enquiry to " . mail_line($s['target_name'], 80) . ".\n\n"
        . "Did not ask for this? You can ignore this email: nothing is sent without the code.\n\n— " . SITE['name'] . ', ' . SITE['url'] . "\n";
  $ok = site_mail($s['email'], (is_staging() ? '[TEST] ' : '') . "$code is your " . SITE['name'] . ' verification code', $body);
  if (is_staging()) {   // staging only: the code is also written to the private leads folder so you can test without email
    @file_put_contents(leads_dir() . '/otp-test.log', date('c') . "\t" . $s['email'] . "\t$code\n", FILE_APPEND | LOCK_EX);
    $ok = true;
  }
  if (ENQUIRY['sms_webhook'] && !is_staging()) {
    @file_get_contents(ENQUIRY['sms_webhook'], false, stream_context_create(['http' => ['method' => 'POST', 'header' => "Content-Type: application/json\r\n",
      'content' => json_encode(['phone' => '+91' . $s['phone'], 'code' => $code, 'minutes' => $mins]), 'timeout' => 4, 'ignore_errors' => true]]));
  }
  return $ok;
}
// An email domain that can receive mail (and is not a throw-away inbox)
function email_domain_ok($email) {
  $d = strtolower(substr(strrchr($email, '@'), 1));
  if (!str_contains($d, '.') || in_array($d, array_map('strtolower', ENQUIRY['block_domains']), true)) return false;
  if (!function_exists('checkdnsrr') || is_staging()) return true;
  return checkdnsrr($d, 'MX') || checkdnsrr($d, 'A');
}
function email_limits_ok($email) {
  return lim_count('mail_hour', $email, 3600) < ENQUIRY['per_email_hour'] && lim_count('mail_day', $email, 86400) < ENQUIRY['per_email_day']
      && lim_count('site_day', date('Ymd'), 86400) < ENQUIRY['daily_cap'];
}
function email_limits_add($email) { lim_add('mail_hour', $email, 3600); lim_add('mail_day', $email, 86400); lim_add('site_day', date('Ymd'), 86400); }

/* ---------- 1. POST from this website only ---------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(false, 'Method not allowed.', 405);
if (!same_site_request()) { $log('origin'); out(false, 'Please send this from our website.', 403); }
$in = fn($k) => is_scalar($_POST[$k] ?? null) ? (string) $_POST[$k] : '';   // a posted value as text (arrays are ignored)
$action = $in('action');
$tok    = $in('token');

// tidy now and then: expired requests and old counters
if (random_int(1, 25) === 1) {
  foreach (glob("$otpDir/*.json") ?: [] as $f) if (filemtime($f) < time() - 3600) @unlink($f);
  foreach (glob("$limDir/*.txt") ?: [] as $f) if (filemtime($f) < time() - 2 * 86400) @unlink($f);
}

/* =====================================================================
   START: check the details, then email a code
   ===================================================================== */
if ($action === 'start') {
  if (trim($in('website')) !== '') { $log('honeypot'); out(true, 'Code sent.', 200, ['token' => bin2hex(random_bytes(16)), 'email' => '', 'resend_in' => ENQUIRY['resend_seconds']]); }
  switch (lead_key_problem($in('fk'), 'enquiry')) {
    case 'bad':     $log('key-bad');  out(false, 'This form could not be verified. Please reload the page and try again.', 400, ['code' => 'key']);
    case 'expired': out(false, 'This form was open for a long time. Please send it again.', 400, ['code' => 'key']);
    case 'fast':    $log('key-fast'); out(true, 'Code sent.', 200, ['token' => bin2hex(random_bytes(16)), 'email' => '', 'resend_in' => ENQUIRY['resend_seconds']]);
  }
  if (lim_count('ip_hour', $ip, 3600) >= ENQUIRY['per_ip_hour']) { $log('rate-ip'); out(false, 'Too many requests from this connection. Please try again in an hour, or email ' . NAP['email'] . '.', 429); }

  $line = fn($k, $max) => mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags($in($k)))), 0, $max);
  $mode     = in_array($in('mode'), ['contact', 'mail'], true) ? $in('mode') : 'contact';
  $name     = $line('name', 60);
  $phone    = normalise_mobile($in('phone'));
  $email    = mail_address($in('email'));
  $location = $line('location', 60);
  $message  = mb_substr(trim(preg_replace(["/\r\n?/", "/[^\P{C}\n]+/u", "/\n{3,}/"], ["\n", '', "\n\n"], strip_tags($in('message')))), 0, 1000);
  $kind     = in_array($in('kind'), ['design', 'pro'], true) ? $in('kind') : '';
  $key      = preg_match('/^[a-z0-9\-]{1,100}$/', $in('target')) ? $in('target') : '';

  $err = [];
  if (!valid_name($name)) $err['name'] = 'Please enter your name (letters only).';
  if ($phone === '') $err['phone'] = 'Please enter a valid 10-digit Indian mobile number.';
  if ($email === '') $err['email'] = 'Please enter a valid email address.';
  elseif (!email_domain_ok($email)) $err['email'] = 'Please use an email address that can receive mail (not a temporary inbox).';
  if (mb_strlen($location) < 2 || !preg_match("/^[\p{L}\p{M}\p{N} .,'()\/\-]+$/u", $location)) $err['location'] = 'Please enter your city or area.';
  if ($mode === 'mail' && mb_strlen($message) < 10) $err['message'] = 'Please write a short message (at least 10 characters).';
  if ($in('consent') !== '1') $err['consent'] = 'Please tick the box to allow us to share your details with this firm.';
  if ($err) out(false, 'Please check the highlighted fields.', 422, ['fields' => $err]);
  foreach (['name' => $name, 'location' => $location, 'message' => $message] as $k => $v)
    if ($why = spam_reason($v)) { $log("spam-$why"); out(false, 'Please remove links or code and try again.', 422, ['fields' => [$k => 'No links or code, please.']]); }

  $t = enquiry_target($kind, $key);
  if (!$t) { $log('target'); out(false, 'This listing is no longer available. Please reload the page.', 404); }

  lim_add('ip_hour', $ip, 3600);   // counts towards the connection limit from here on
  if (lim_count('phone_day', $phone, 86400) >= ENQUIRY['per_phone_day']) { $log('rate-phone'); out(false, 'Too many enquiries from this mobile number today. Please try again tomorrow.', 429); }
  if (!email_limits_ok($email)) { $log('rate-email'); out(false, 'Too many codes have been sent to this email address. Please try again later.', 429); }

  $clean = fn($k, $max) => $line($k, $max);
  $token = bin2hex(random_bytes(16));
  $code  = otp_code();
  $s = [
    'created' => time(), 'exp' => time() + ENQUIRY['otp_minutes'] * 60, 'hash' => otp_hash($token, $code), 'tries' => 0, 'resends' => 0, 'sent' => time(),
    'ip' => $ip, 'kind' => $kind, 'target' => $key, 'target_name' => $t['name'], 'mode' => $mode,
    'name' => $name, 'phone' => $phone, 'email' => $email, 'location' => $location, 'message' => $message,
    'source' => $clean('source', 200), 'pillar' => $clean('pillar', 40), 'landing' => $clean('landing', 200), 'referrer' => $clean('referrer', 200), 'utm' => $clean('utm', 300),
  ];
  if (!send_code($s, $code)) out(false, 'We could not send the code just now. Please try again in a minute, or email ' . NAP['email'] . '.', 503);
  otp_write(otp_path($token), $s);
  email_limits_add($email);
  lim_add('phone_day', $phone, 86400);
  out(true, 'We have emailed a 6-digit code to ' . mask_email($email) . '.', 200, ['token' => $token, 'email' => mask_email($email), 'resend_in' => ENQUIRY['resend_seconds'], 'minutes' => ENQUIRY['otp_minutes']]);
}

/* =====================================================================
   RESEND: a new code for the same request
   ===================================================================== */
if ($action === 'resend') {
  [$fh, $s] = otp_open($tok);
  if (!$s) { if ($fh) otp_close($fh); out(false, 'This request has expired. Please fill in the form again.', 410, ['code' => 'gone']); }
  if ($s['resends'] >= ENQUIRY['otp_resends']) { otp_close($fh); out(false, 'No more codes can be sent for this request. Please start again later.', 429, ['code' => 'max']); }
  if (($wait = $s['sent'] + ENQUIRY['resend_seconds'] - time()) > 0) { otp_close($fh); out(false, "Please wait $wait seconds before asking for another code.", 429, ['resend_in' => $wait]); }
  if (!email_limits_ok($s['email'])) { otp_close($fh); $log('rate-email'); out(false, 'Too many codes have been sent to this email address. Please try again later.', 429); }
  $code = otp_code();
  $token = $tok;
  if (!send_code($s, $code)) { otp_close($fh); out(false, 'We could not send the code just now. Please try again in a minute.', 503); }
  $s = array_merge($s, ['hash' => otp_hash($token, $code), 'tries' => 0, 'exp' => time() + ENQUIRY['otp_minutes'] * 60, 'sent' => time(), 'resends' => $s['resends'] + 1]);
  otp_close($fh, $s);
  email_limits_add($s['email']);
  out(true, 'A new code is on its way to ' . mask_email($s['email']) . '.', 200, ['resend_in' => ENQUIRY['resend_seconds'], 'left' => ENQUIRY['otp_resends'] - $s['resends']]);
}

/* =====================================================================
   VERIFY: the code → send the enquiry
   ===================================================================== */
if ($action === 'verify') {
  if (lim_count('verify_ip', $ip, 3600) >= ENQUIRY['per_ip_hour'] * ENQUIRY['otp_attempts']) { $log('rate-verify'); out(false, 'Too many attempts from this connection. Please try again later.', 429); }
  lim_add('verify_ip', $ip, 3600);
  $token = $tok;
  [$fh, $s] = otp_open($token);
  if (!$s) { if ($fh) otp_close($fh); out(false, 'This request has expired. Please fill in the form again.', 410, ['code' => 'gone']); }
  $path = otp_path($token);
  if ($s['tries'] >= ENQUIRY['otp_attempts']) { otp_close($fh); @unlink($path); out(false, 'Too many wrong codes. Please fill in the form again.', 429, ['code' => 'gone']); }
  if ($s['exp'] < time()) { otp_close($fh); out(false, 'This code has expired. Ask for a new one below.', 400, ['code' => 'expired']); }
  $code = preg_replace('/\D/', '', $in('code'));
  if (strlen($code) !== 6 || !hash_equals($s['hash'], otp_hash($token, $code))) {
    $s['tries']++;
    $left = ENQUIRY['otp_attempts'] - $s['tries'];
    if ($left <= 0) { otp_close($fh); @unlink($path); $log('otp-locked'); out(false, 'Too many wrong codes. Please fill in the form again.', 429, ['code' => 'gone']); }
    otp_close($fh, $s);
    out(false, 'That code is not right. ' . $left . ' ' . ($left === 1 ? 'try' : 'tries') . ' left.', 400, ['code' => 'otp', 'fields' => ['code' => 'Wrong code.']]);
  }
  // correct: the request is used up now, so it can never be sent twice
  otp_close($fh); @unlink($path);

  $t = enquiry_target($s['kind'], $s['target']);
  if (!$t) out(false, 'This listing is no longer available, so nothing was sent. Please contact us instead.', 404);
  // already sent to this firm recently (checked only now, after the code proves the email is theirs, so nobody can probe it)
  if (lim_count('repeat', $s['email'] . '|' . $t['pro_key'], ENQUIRY['repeat_hours'] * 3600))
    out(true, 'You already contacted ' . $t['name'] . ' in the last ' . ENQUIRY['repeat_hours'] . ' hours, so we have not sent it twice. They have your details and will be in touch.', 200, ['code' => 'repeat']);
  [$to, $direct] = enquiry_recipient($t);
  $staging = is_staging();
  $ref  = 'ENQ-' . date('ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
  $when = date('j M Y, g:i a');
  $wants = $s['mode'] === 'mail' ? 'A reply by email' : 'A call back';

  /* the enquiry, to the firm (or to us, to forward) */
  $body = ($direct ? '' : "FOR: {$t['name']}\nThis firm has no verified email on file yet. Forward this enquiry to them, or reply to the customer yourself.\n\n")
        . "New enquiry from " . SITE['name'] . "\n\n"
        . "About:     {$t['about']}\nLink:      {$t['url']}\nWants:     $wants\n\n"
        . "Name:      {$s['name']}\nMobile:    +91 {$s['phone']}\nEmail:     {$s['email']} (verified with a one-time code)\nLocation:  {$s['location']}\n"
        . ($s['message'] !== '' ? "\nMessage:\n{$s['message']}\n" : '')
        . "\nReference: $ref\nSent:      $when\n\nReply to this email to answer the customer directly. Call: tel:+91{$s['phone']}  WhatsApp: https://wa.me/91{$s['phone']}\n";
  $subject = ($staging ? '[TEST] ' : '') . ($direct ? '' : '[For: ' . mail_line($t['name'], 60) . '] ') . 'Enquiry from ' . mail_line($s['name'], 40) . ', ' . mail_line($s['location'], 40) . ' (' . $ref . ')';
  $bcc = ENQUIRY['copy_admin'] && $direct ? LEADS['notify_email'] : '';
  $sent = site_mail($to, $subject, $body, ['reply_to' => $s['email'], 'bcc' => $bcc, 'cc' => $direct ? '' : LEADS['notify_cc']]);
  if (!$sent && !$staging) { $log('mail-fail'); out(false, 'Your email is verified, but the message could not be sent just now. Please try again or email ' . NAP['email'] . " (reference $ref).", 503); }

  /* a copy for the visitor */
  if (ENQUIRY['confirm_user']) {
    $copy = "Hello {$s['name']},\n\nYour enquiry has been sent to {$t['name']}" . ($direct ? '' : ' through the ' . SITE['name'] . ' team') . ". Expect a " . ($s['mode'] === 'mail' ? 'reply by email' : 'call') . " soon.\n\n"
          . "About:     {$t['about']}\nLink:      {$t['url']}\nMobile:    +91 {$s['phone']}\nLocation:  {$s['location']}\n" . ($s['message'] !== '' ? "\nYour message:\n{$s['message']}\n" : '')
          . "\nReference: $ref\n\nDid not send this? Reply to this email and we will remove your details.\n\n— " . SITE['name'] . ', ' . SITE['url'] . "\n";
    site_mail($s['email'], ($staging ? '[TEST] ' : '') . 'Your enquiry to ' . mail_line($t['name'], 60) . " ($ref)", $copy, ['reply_to' => NAP['email']]);
  }

  /* records: enquiries.csv (full detail) and the main leads.csv (so /admin/ reports count it) */
  lim_add('repeat', $s['email'] . '|' . $t['pro_key'], ENQUIRY['repeat_hours'] * 3600);
  csv_append($dir . ($staging ? '/enquiries-test.csv' : '/enquiries.csv'), [
    'time' => date('Y-m-d H:i:s'), 'ref' => $ref, 'status' => $staging ? 'test' : ($direct ? 'sent-to-firm' : 'sent-to-us'), 'kind' => $t['kind'], 'listing' => $t['key'],
    'firm' => $t['name'], 'firm_key' => $t['pro_key'], 'about' => $t['about'], 'mode' => $s['mode'], 'name' => $s['name'], 'phone' => $s['phone'], 'email' => $s['email'],
    'location' => $s['location'], 'message' => $s['message'], 'source' => $s['source'], 'landing' => $s['landing'], 'referrer' => $s['referrer'], 'utm' => $s['utm'], 'ip' => $s['ip'],
  ]);
  $lead = [
    'time' => date('Y-m-d H:i:s'), 'lead_id' => $ref, 'form' => 'enquiry-' . $t['kind'], 'name' => $s['name'], 'phone' => $s['phone'], 'email' => $s['email'],
    'city' => $s['location'], 'home' => '', 'service' => 'Enquiry: ' . $t['name'], 'budget' => '', 'timeline' => '', 'call_slot' => '', 'notes' => $s['message'],
    'estimate' => '', 'estimate_total' => '', 'source' => $s['source'] ?: $t['path'], 'pillar' => lead_pillar($s['pillar'], $s['source']), 'landing' => $s['landing'],
    'referrer' => $s['referrer'], 'utm' => $s['utm'], 'ip' => $s['ip'], 'status' => $staging ? 'test' : 'new',
  ];
  csv_append($dir . ($staging ? '/leads-test.csv' : '/leads.csv'), $lead);
  track_server_lead($lead, $ref);

  out(true, 'Your enquiry has been sent to ' . $t['name'] . ($direct ? '' : ' through our team') . '. A copy is in your inbox. Reference: ' . $ref . '.', 200, ['ref' => $ref, 'form' => 'enquiry-' . $t['kind']]);
}

out(false, 'Unknown request.', 400);
