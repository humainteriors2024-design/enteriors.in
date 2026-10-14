<?php
/* =====================================================================
   ENTERIORS — LEAD FORM HANDLER (every form on the site posts here)
   Settings: includes/config.php → LEADS. Checks: includes/leads.php.

   A lead is accepted only if it passes, in this order:
     1 POST request            5 IP rate limit (LEADS['rate_limit'] per hour)
     2 same-site origin        6 name looks real
     3 honeypot field empty    7 valid Indian mobile number
     4 form key genuine, not   8 no links / HTML / spam words in any text field
       too fast, not too old   9 not a duplicate of the same mobile within LEADS['duplicate_hours']
   Accepted leads are saved to leads/leads.csv (one folder ABOVE public_html),
   emailed to LEADS['notify_email'] and, if set, sent to LEADS['webhook'].
   On staging they go to leads-test.csv and the email subject starts with [TEST].
   Replies with JSON to the site's JavaScript, otherwise redirects to the thank-you page.
   ===================================================================== */
require __DIR__ . '/../includes/site.php';
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
function reply($ok, $msg, $code = 200, $extra = []) {
  global $wantsJson;
  http_response_code($code);
  if ($wantsJson) { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['ok' => $ok, 'message' => $msg] + $extra); exit; }
  if ($ok) { header('Location: ' . LEADS['thank_you']); exit; }
  header('Content-Type: text/html; charset=utf-8');
  echo '<p>' . htmlspecialchars($msg) . '</p><p><a href="javascript:history.back()">Go back</a></p>'; exit;
}
$thanks = 'Thank you — request received. ' . LEADS['promise'];
$log = function ($why) {   // rejected attempts, for you to review (never shown to visitors)
  @file_put_contents(leads_dir() . '/rejected.log', date('c') . "\t" . ($_SERVER['REMOTE_ADDR'] ?? '') . "\t$why\t" . substr(json_encode(array_diff_key($_POST, ['fk' => 1])), 0, 500) . "\n", FILE_APPEND | LOCK_EX);
};

/* 1. POST only */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') reply(false, 'Method not allowed.', 405);

/* 2. Must come from a form on this website */
if (!same_site_request()) { $log('origin'); reply(false, 'Please submit the form from our website.', 403); }

/* 3. Honeypot: a hidden field only bots fill in. Pretend success so they do not retry. */
if (trim((string) ($_POST['website'] ?? '')) !== '') { $log('honeypot'); reply(true, $thanks); }

/* 4. Form key */
$form = preg_replace('/[^a-z0-9\-]/', '', strtolower((string) ($_POST['form'] ?? '')));
switch (lead_key_problem($_POST['fk'] ?? '', $form)) {
  case 'bad':     $log('key-bad');  reply(false, 'This form could not be verified. Please reload the page and try again.', 400, ['code' => 'key']);
  case 'expired': reply(false, 'This form was open for a long time. Please send it again.', 400, ['code' => 'key']);
  case 'fast':    $log('key-fast'); reply(true, $thanks);   // sent faster than a person can type
}

/* 5. Rate limit per IP address */
$dir = leads_dir();
$ip  = $_SERVER['REMOTE_ADDR'] ?? '';
$ipFile = $dir . '/rate_' . md5($ip) . '.txt';
$hits = array_filter(explode("\n", (string) @file_get_contents($ipFile)), fn($t) => (int) $t > time() - 3600);
if (count($hits) >= LEADS['rate_limit']) { $log('rate'); reply(false, 'Too many requests from this connection. Please call or email us instead.', 429); }

/* 6–8. Clean and validate the fields */
$clean = fn($k, $max) => mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags((string) ($_POST[$k] ?? '')))), 0, $max);
$name  = $clean('name', 60);
$phone = normalise_mobile($_POST['phone'] ?? '');
$email = $clean('email', 120);
$errors = [];
if (!valid_name($name)) $errors['name'] = 'Please enter your name (letters only).';
if ($phone === '')      $errors['phone'] = 'Please enter a valid 10-digit Indian mobile number.';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Please check the email address.';
if ($errors) reply(false, implode(' ', $errors), 422, ['fields' => $errors]);

// Calculator estimate: only the server-signed one is trusted (see includes/calc/engine.php)
require_once __DIR__ . '/../includes/calc/engine.php';
$est = calc_token_read($_POST['calc_token'] ?? '');
$source = $clean('source', 200);
$pillar = lead_pillar($_POST['pillar'] ?? '', $source);
$leadId = date('ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

$lead = [
  'time'     => date('Y-m-d H:i:s'),
  'lead_id'  => $leadId,
  'form'     => $form,
  'name'     => $name,
  'phone'    => $phone,
  'email'    => $email,
  'city'     => $clean('city', 40),
  'home'     => $clean('home', 30),
  'service'  => $clean('service', 60),
  'budget'   => $clean('budget', 30),
  'timeline' => $clean('timeline', 30),
  'call_slot' => $clean('call_slot', 30),
  'notes'    => $clean('notes', 1000),
  'estimate' => $est ? $est['s'] : '',
  'estimate_total' => $est ? (string) (int) $est['v'] : '',
  'source'   => $source,
  'pillar'   => $pillar,
  'landing'  => $clean('landing', 200),
  'referrer' => $clean('referrer', 200),
  'utm'      => $clean('utm', 300),
  'ip'       => $ip,
];
foreach (['name', 'city', 'home', 'service', 'notes', 'source'] as $k) {
  if ($why = spam_reason($_POST[$k] ?? '')) { $log("spam-$why"); reply(false, 'Please remove links or code from your message and send it again.', 422, ['fields' => [$k => 'No links please.']]); }
}

/* Count this submission towards the rate limit */
$hits[] = time();
@file_put_contents($ipFile, implode("\n", $hits), LOCK_EX);

/* 9. Duplicate: the same mobile again within the window is thanked but not emailed twice */
$dupFile = $dir . '/recent.json';
$recent  = array_filter((array) json_decode((string) @file_get_contents($dupFile), true), fn($t) => $t > time() - LEADS['duplicate_hours'] * 3600);
$key     = hash('sha256', $phone . LEADS['secret']);
$isDup   = isset($recent[$key]);
$recent[$key] = time();
@file_put_contents($dupFile, json_encode($recent), LOCK_EX);

/* Save: CSV outside public_html */
$staging = is_staging();
$lead['status'] = $staging ? 'test' : ($isDup ? 'duplicate' : 'new');
csv_append($dir . ($staging ? '/leads-test.csv' : '/leads.csv'), $lead);

/* Email + optional webhook (skipped for duplicates) */
if (!$isDup) {
  $oneLine = fn($v) => str_replace(["\r", "\n"], ' ', (string) $v);
  $subject = ($staging ? '[TEST] ' : '') . 'New ' . SITE['name'] . ' lead: ' . $oneLine($name) . ' (' . $oneLine(trim($lead['home'] . ', ' . $lead['city'], ', ')) . ')';
  $body = '';
  foreach ($lead as $k => $v) if ($v !== '') $body .= str_pad(ucfirst(str_replace('_', ' ', $k)) . ':', 12) . $v . "\n";
  $body .= "\nCall: tel:+91$phone\nWhatsApp: https://wa.me/91$phone\n";
  $host = preg_replace('/^www\.|:\d+$/', '', $_SERVER['HTTP_HOST'] ?? parse_url(SITE['url'], PHP_URL_HOST));
  $headers = 'From: ' . SITE['name'] . ' <no-reply@' . $host . ">\r\nContent-Type: text/plain; charset=utf-8"
           . ($email ? "\r\nReply-To: " . $oneLine($email) : '') . (LEADS['notify_cc'] ? "\r\nCc: " . LEADS['notify_cc'] : '');
  @mail(LEADS['notify_email'], $subject, $body, $headers);

  if (LEADS['webhook'] && !$staging) {
    @file_get_contents(LEADS['webhook'], false, stream_context_create(['http' => [
      'method' => 'POST', 'header' => "Content-Type: application/json\r\n", 'content' => json_encode($lead), 'timeout' => 4, 'ignore_errors' => true,
    ]]));
  }
  track_server_lead($lead, $leadId);   // GA4 Measurement Protocol + Meta Conversions API (when configured)
}

reply(true, $thanks, 200, ['form' => $form, 'lead_id' => $leadId]);
