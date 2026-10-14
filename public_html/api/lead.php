<?php
/* =====================================================================
   ENTERIORS — THE FORM HANDLER (every form on the site posts here)
   Free consultation, call back, get 3 quotes, the pop-up form and Contact / Mail on trending designs
   and designer profiles. Settings: config.php → LEADS, TURNSTILE, FORM_LIMITS, VERIFY, ENQUIRY.
   Checks: includes/leads.php. Verification, captcha and limits: includes/verify.php.

     action=start     the details → checks → one email to the visitor with a 6-digit code and a one-click link
     action=verify    the code typed in the form          ┐ either one sends the submission to
     action=confirm   the link from the email (verify/)   ┘ LEADS['notify_email'] and saves it
     action=resend    a new code for the same request (limited, with a wait between codes)
     action=status    has this request been verified yet? (the form asks every few seconds, so a link
                      clicked on the phone also completes the form left open on the computer)

   Checks on start, in order: POST → same-site origin → honeypot → form key (genuine, not too fast,
   not too old) → connection limit → fields (name, Indian mobile, a real email, city, the form's own
   fields) → no links/HTML/spam words → (enquiries: the listing exists) → daily limit for this form
   (IP address, email and mobile, each) → captcha → limits on emails sent.
   Replies with JSON to the site's JavaScript; without JavaScript it moves between plain pages.
   ===================================================================== */
require __DIR__ . '/../includes/site.php';
require_once __DIR__ . '/../includes/calc/engine.php';
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, nofollow');

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
function reply($ok, $msg, $code = 200, $extra = []) {
  global $wantsJson;
  http_response_code($code);
  if ($wantsJson) { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['ok' => $ok, 'message' => $msg] + $extra, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); exit; }
  // no JavaScript: the code is typed on the verify page; a finished request goes to the thank-you page
  if ($ok && ($extra['step'] ?? '') === 'verify') { header('Location: /verify/?t=' . ($extra['token'] ?? ''), true, 303); exit; }
  if ($ok) { header('Location: ' . LEADS['thank_you'] . (!empty($extra['ref']) ? '?ref=' . rawurlencode($extra['ref']) : ''), true, 303); exit; }
  header('Content-Type: text/html; charset=utf-8');
  echo '<!doctype html><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex">'
     . '<title>Please check the form</title><body style="font:16px/1.6 system-ui,sans-serif;max-width:560px;margin:3rem auto;padding:0 1rem">'
     . '<p>' . htmlspecialchars($msg) . '</p><p><a href="javascript:history.back()">← Go back to the form</a></p>';
  exit;
}
$ip  = client_ip();
$log = function ($why) use ($ip) {   // rejected attempts, for you to review (never shown to visitors)
  @file_put_contents(leads_dir() . '/rejected.log', date('c') . "\t$ip\t$why\t" . substr(json_encode(array_diff_key($_POST, ['fk' => 1, 'code' => 1, 'token' => 1, 'key' => 1, 'cf-turnstile-response' => 1, 'captcha_token' => 1]), JSON_UNESCAPED_UNICODE), 0, 500) . "\n", FILE_APPEND | LOCK_EX);
};

if ($_SERVER['REQUEST_METHOD'] !== 'POST') reply(false, 'Method not allowed.', 405);
if (!same_site_request()) { $log('origin'); reply(false, 'Please send the form from our website.', 403); }
verify_tidy();
$in     = fn($k) => is_scalar($_POST[$k] ?? null) ? (string) $_POST[$k] : '';   // a posted value as text (arrays are ignored)
$line   = fn($k, $max) => mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags($in($k)))), 0, $max);
$action = $in('action') ?: 'start';
$token  = $in('token');

/* =====================================================================
   START: check the details, then email the code and the link
   ===================================================================== */
if ($action === 'start') {
  $form  = preg_replace('/[^a-z0-9\-]/', '', strtolower($in('form')));
  $isEnq = $form === 'enquiry';
  $fake  = fn() => reply(true, 'Code sent.', 200, ['step' => 'verify', 'token' => bin2hex(random_bytes(16)), 'email' => '', 'resend_in' => VERIFY['resend_seconds'], 'minutes' => VERIFY['code_minutes']]);
  if (trim($in('website')) !== '') { $log('honeypot'); $fake(); }   // only bots fill the hidden field: pretend it worked
  switch (lead_key_problem($in('fk'), $form)) {
    case 'bad':     $log('key-bad');  reply(false, 'This form could not be checked. Please reload the page and try again.', 400, ['code' => 'key']);
    case 'expired': reply(false, 'This form was open for a long time. Please send it again.', 400, ['code' => 'key']);
    case 'fast':    $log('key-fast'); $fake();   // sent faster than a person can type
  }
  if (lim_count('start_ip', $ip, 3600) >= VERIFY['per_ip_hour']) { $log('rate-ip'); reply(false, 'Too many requests from this connection. Please try again in an hour' . (NAP['email'] ? ', or email ' . NAP['email'] : '') . '.', 429, ['code' => 'rate']); }

  // the four details every form asks for
  $name  = $line('name', 60);
  $phone = normalise_mobile($in('phone'));
  $email = mail_address($in('email'));
  $city  = $line($isEnq ? 'location' : 'city', 60);
  $err = [];
  if (!valid_name($name)) $err['name'] = 'Please enter your name (letters only).';
  if ($phone === '') $err['phone'] = 'Please enter a valid 10-digit Indian mobile number.';
  if ($email === '') $err['email'] = 'Please enter a valid email address.';
  elseif ($why = email_problem($email)) $err['email'] = $why;
  if (!valid_place($city)) $err[$isEnq ? 'location' : 'city'] = 'Please enter your city or area.';

  // each form's own fields (optional, and only values from the lists in config.php)
  $pick = fn($k, $list) => in_array($v = $line($k, 60), $list, true) ? $v : '';
  $fields = []; $message = ''; $mode = 'contact'; $kind = ''; $target = '';
  if ($isEnq) {
    $mode    = in_array($in('mode'), ['contact', 'mail'], true) ? $in('mode') : 'contact';
    $message = mb_substr(trim(preg_replace(["/\r\n?/", "/[^\P{C}\n]+/u", "/\n{3,}/"], ["\n", '', "\n\n"], strip_tags($in('message')))), 0, 1000);
    $kind    = in_array($in('kind'), ['design', 'pro'], true) ? $in('kind') : '';
    $target  = preg_match('/^[a-z0-9\-]{1,100}$/', $in('target')) ? $in('target') : '';
    if ($mode === 'mail' && mb_strlen($message) < 10) $err['message'] = 'Please write a short message (at least 10 characters).';
    if ($in('consent') !== '1') $err['consent'] = 'Please tick the box so we can share your details with this firm.';
  } else {
    $fields = array_filter([
      'home' => $pick('home', LEADS['home_types']), 'service' => $pick('service', LEADS['services']), 'budget' => $pick('budget', LEADS['budgets']),
      'timeline' => $pick('timeline', LEADS['timelines']), 'call_slot' => $pick('call_slot', LEADS['call_slots']), 'notes' => $line('notes', 1000),
    ], fn($v) => $v !== '');
  }
  if ($err) reply(false, 'Please check the highlighted fields.', 422, ['fields' => $err]);
  foreach (['name' => $name, ($isEnq ? 'location' : 'city') => $city, ($isEnq ? 'message' : 'notes') => $isEnq ? $message : ($fields['notes'] ?? '')] as $k => $v)
    if ($why = spam_reason($v)) { $log("spam-$why"); reply(false, 'Please remove links or code and send it again.', 422, ['fields' => [$k => 'No links or code, please.']]); }

  $t = null;
  if ($isEnq && !($t = enquiry_target($kind, $target))) { $log('target'); reply(false, 'This listing is no longer available. Please reload the page.', 404); }
  if ($hit = daily_limit_hit($form, $ip, $email, $phone)) { $log("limit-$hit"); reply(false, daily_limit_message($form), 429, ['code' => 'limit']); }
  if ($why = captcha_check($_POST, false)) { $log('captcha'); reply(false, $why, 400, ['code' => 'captcha', 'fields' => ['captcha' => $why]]); }
  if (!email_limits_ok($email)) { $log('rate-email'); reply(false, 'Too many codes have been sent to this email address. Please try again later' . (NAP['email'] ? ' or email ' . NAP['email'] : '') . '.', 429, ['code' => 'rate']); }

  $source = $line('source', 200);
  $est = $isEnq ? null : calc_token_read($in('calc_token'));   // calculator estimate: only the server-signed one is trusted
  $token = bin2hex(random_bytes(16)); $code = new_code(); $key = bin2hex(random_bytes(16));
  $s = [
    'token' => $token, 'type' => $isEnq ? 'enquiry' : 'lead', 'form' => $form, 'created' => time(), 'exp' => time() + VERIFY['code_minutes'] * 60,
    'codes' => [pending_hash($token, 'code', $code)], 'links' => [pending_hash($token, 'link', $key)], 'tries' => 0, 'resends' => 0, 'sent' => time(),
    'ip' => $ip, 'name' => $name, 'phone' => $phone, 'email' => $email, 'city' => $city, 'fields' => $fields,
    'mode' => $mode, 'message' => $message, 'kind' => $kind, 'target' => $target,
    'estimate' => $est ? $est['s'] : '', 'estimate_total' => $est ? (string) (int) $est['v'] : '',
    'source' => $source, 'pillar' => lead_pillar($in('pillar'), $source), 'landing' => $line('landing', 200), 'referrer' => $line('referrer', 200), 'utm' => $line('utm', 300),
    'what' => $isEnq ? 'your enquiry about ' . $t['name'] : 'your request to ' . SITE['name'],
  ];
  if (!send_verification($s, $token, $code, $key)) reply(false, 'We could not send the code just now. Please try again in a minute' . (NAP['email'] ? ', or email ' . NAP['email'] : '') . '.', 503);
  pending_write($token, $s);
  captcha_consume($_POST);
  email_limits_add($email);
  lim_add('start_ip', $ip);
  // every started request is kept privately too, so a visitor who mistyped the email is not lost
  csv_append(leads_dir() . (is_staging() ? '/started-test.csv' : '/started.csv'), ['time' => date('Y-m-d H:i:s'), 'form' => $form, 'name' => $name, 'phone' => $phone,
    'email' => $email, 'city' => $city, 'about' => $t['name'] ?? '', 'source' => $source, 'ip' => $ip, 'request' => substr($token, 0, 8)]);
  reply(true, 'We have emailed a 6-digit code and a link to ' . mask_email($email) . '.', 200,
    ['step' => 'verify', 'token' => $token, 'email' => mask_email($email), 'resend_in' => VERIFY['resend_seconds'], 'minutes' => VERIFY['code_minutes']]);
}

/* =====================================================================
   VERIFY (code) and CONFIRM (link): either one sends the submission
   ===================================================================== */
if ($action === 'verify' || $action === 'confirm') {
  if (lim_count('verify_ip', $ip, 3600) >= VERIFY['per_ip_hour'] * VERIFY['code_attempts']) { $log('rate-verify'); reply(false, 'Too many attempts from this connection. Please try again later.', 429); }
  lim_add('verify_ip', $ip, 3600);
  [$fh, $s] = pending_open($token);
  if (!$s) { if ($fh) pending_close($fh); reply(false, 'This request has expired or was already used. Please fill in the form again.', 410, ['code' => 'gone']); }
  if (!empty($s['done'])) { $r = pending_finish($fh, $s); reply(true, $r['message'], 200, ['state' => 'done', 'ref' => $r['ref'], 'form' => $r['form']]); }
  if ($s['tries'] >= VERIFY['code_attempts']) { pending_close($fh); @unlink(pending_path($token)); reply(false, 'Too many wrong codes. Please fill in the form again.', 429, ['code' => 'gone']); }
  if ($s['exp'] < time()) { pending_close($fh); reply(false, $action === 'confirm' ? 'This link has expired. Please fill in the form again.' : 'This code has expired. Ask for a new one below.', 400, ['code' => $action === 'confirm' ? 'gone' : 'expired']); }
  $secret = $action === 'confirm' ? strtolower($in('key')) : preg_replace('/\D/', '', $in('code'));
  $valid  = $action === 'confirm'
          ? preg_match('/^[a-f0-9]{32}$/', $secret) && in_array(pending_hash($token, 'link', $secret), $s['links'], true)
          : strlen($secret) === 6 && array_filter($s['codes'], fn($h) => hash_equals($h, pending_hash($token, 'code', $secret)));
  if (!$valid) {
    $s['tries']++;
    $left = VERIFY['code_attempts'] - $s['tries'];
    if ($left <= 0) { pending_close($fh); @unlink(pending_path($token)); $log('otp-locked'); reply(false, 'Too many wrong codes. Please fill in the form again.', 429, ['code' => 'gone']); }
    pending_close($fh, $s);
    if ($action === 'confirm') reply(false, 'This link is not valid. Please use the latest email we sent, or type the code in the form.', 400, ['code' => 'link']);
    reply(false, 'That code is not right. ' . $left . ' ' . ($left === 1 ? 'try' : 'tries') . ' left.', 400, ['code' => 'otp', 'fields' => ['code' => 'Wrong code.']]);
  }
  $r = pending_finish($fh, $s);
  if (!$r['ok']) reply(false, $r['message'], ($r['code'] ?? '') === 'limit' ? 429 : 503, ['code' => $r['code'] ?? 'error']);
  reply(true, $r['message'], 200, ['state' => 'done', 'ref' => $r['ref'], 'form' => $r['form']]);
}

/* =====================================================================
   RESEND: a new code (and link) for the same request
   ===================================================================== */
if ($action === 'resend') {
  [$fh, $s] = pending_open($token);
  if (!$s || !empty($s['done'])) { if ($fh) pending_close($fh); reply(false, 'This request has expired or was already sent. Please fill in the form again.', 410, ['code' => 'gone']); }
  if ($s['resends'] >= VERIFY['resends']) { pending_close($fh); reply(false, 'No more codes can be sent for this request. Use the code or link from the emails you have, or start again later.', 429, ['code' => 'max']); }
  if (($wait = $s['sent'] + VERIFY['resend_seconds'] - time()) > 0) { pending_close($fh); reply(false, "Please wait $wait seconds before asking for another code.", 429, ['resend_in' => $wait]); }
  if (!email_limits_ok($s['email'])) { pending_close($fh); $log('rate-email'); reply(false, 'Too many codes have been sent to this email address. Please try again later.', 429); }
  $code = new_code(); $key = bin2hex(random_bytes(16));
  if (!send_verification($s, $token, $code, $key)) { pending_close($fh); reply(false, 'We could not send the code just now. Please try again in a minute.', 503); }
  $s['codes'][] = pending_hash($token, 'code', $code); $s['links'][] = pending_hash($token, 'link', $key);   // earlier codes and links keep working
  $s = array_merge($s, ['exp' => time() + VERIFY['code_minutes'] * 60, 'sent' => time(), 'resends' => $s['resends'] + 1]);
  pending_close($fh, $s);
  email_limits_add($s['email']);
  reply(true, 'A new code is on its way to ' . mask_email($s['email']) . '.', 200, ['resend_in' => VERIFY['resend_seconds'], 'left' => VERIFY['resends'] - $s['resends']]);
}

/* =====================================================================
   STATUS: verified yet? (asked every few seconds while the code box is open)
   ===================================================================== */
if ($action === 'status') {
  $p = pending_path($token);
  $s = $p && is_file($p) ? json_decode((string) @file_get_contents($p), true) : null;
  if (!$s) reply(false, 'This request has expired. Please fill in the form again.', 200, ['state' => 'gone']);
  if (!empty($s['done'])) reply(true, $s['done_msg'], 200, ['state' => 'done', 'ref' => $s['done'], 'form' => $s['form']]);
  reply(true, 'Waiting for the code or the link.', 200, ['state' => 'pending']);
}

reply(false, 'Unknown request.', 400);
