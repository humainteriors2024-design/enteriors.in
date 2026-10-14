<?php
/* =====================================================================
   ENTERIORS — LEAD FORM SECURITY, VALIDATION AND DELIVERY
   Shared by the forms (includes/components/lead-form.php, enquiry_dialog() in finder.php) and the
   one handler every form posts to (api/lead.php). Settings: config.php → LEADS, ENQUIRY.
   Email verification, captcha and daily limits: includes/verify.php.

   Every form carries these hidden fields:
     form     which form, e.g. "compact" (it also picks the daily limit: config.php → FORM_GROUPS)
     fk       the form key: "<time>.<signature>" signed with LEADS['secret']
     website  an empty "honeypot" field that only bots fill in
   Once the visitor's email is verified, lead_deliver() / enquiry_deliver() email the submission to
   LEADS['notify_email'] (the one inbox for every form) and save it to leads/leads.csv.
   ===================================================================== */

// Form key for a form name: "<unix time>.<signature>"
function lead_key($form, $ts = null) {
  $ts = $ts ?? time();
  return $ts . '.' . substr(hash_hmac('sha256', $ts . '|' . $form, LEADS['secret']), 0, 32);
}

// Check a form key. Returns '' when fine, otherwise the reason: bad | fast | expired
function lead_key_problem($key, $form) {
  [$ts, $sig] = array_pad(explode('.', (string) $key, 2), 2, '');
  if (!ctype_digit($ts) || !hash_equals(lead_key($form, (int) $ts), $ts . '.' . $sig)) return 'bad';
  $age = time() - (int) $ts;
  if ($age < LEADS['min_seconds']) return 'fast';
  if ($age > LEADS['max_key_age']) return 'expired';
  return '';
}

// Hidden fields every form needs
function lead_hidden_fields($form) {
  global $hub;   // the pillar of the page the form sits on (set in head.php)
  return '<input type="hidden" name="form" value="' . e($form) . '">'
       . '<input type="hidden" name="fk" value="' . e(lead_key($form)) . '">'
       . '<input type="hidden" name="source" value="' . e(current_path()) . '">'
       . '<input type="hidden" name="pillar" value="' . e($hub['key'] ?? '') . '">'
       . '<input class="hp" type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">';
}

// Indian mobile number → 10 digits, or '' if it is not a valid mobile
function normalise_mobile($raw) {
  $d = preg_replace('/\D/', '', (string) $raw);
  if (strlen($d) === 12 && str_starts_with($d, '91')) $d = substr($d, 2);
  if (strlen($d) === 11 && $d[0] === '0') $d = substr($d, 1);
  if (!preg_match('/^[6-9]\d{9}$/', $d)) return '';
  if (preg_match('/^(\d)\1{9}$/', $d) || in_array($d, ['9876543210', '9123456789', '9012345678', '8888888888'], true)) return '';   // 9999999999 and other dummies
  return $d;
}

// A real-looking name: 2–60 characters, letters (any script), spaces, . ' and - only
function valid_name($name) {
  $name = trim((string) $name);
  if (mb_strlen($name) < 2 || mb_strlen($name) > 60) return false;
  if (!preg_match("/^[\p{L}\p{M}][\p{L}\p{M} .'\-]*$/u", $name)) return false;      // no digits, symbols or links
  if (preg_match('/(.)\1{3,}/u', $name)) return false;                              // "aaaa"
  return preg_match_all('/\p{L}/u', $name) >= 2;
}

// Links, HTML or BBCode in free text = spam
function spam_reason($text) {
  $text = (string) $text;
  if ($text === '') return '';
  if (preg_match('/<[^>]+>|\[(url|link)\b/i', $text)) return 'html';
  $links = preg_match_all('#https?://|www\.#i', $text);
  if ($links > LEADS['max_links']) return 'links';
  if (preg_match('/\b(seo services|backlinks?|casino|crypto|bitcoin|viagra|loan offer|guest post|rank your website)\b/i', $text)) return 'words';
  return '';
}

// Same-site check: the browser's Origin (or Referer) must be this site
function same_site_request() {
  $allowed = array_filter([strtolower($_SERVER['HTTP_HOST'] ?? ''), strtolower((string) parse_url(SITE['url'], PHP_URL_HOST))]);
  $allowed = array_merge($allowed, array_map(fn($h) => 'www.' . $h, $allowed));
  foreach (['HTTP_ORIGIN', 'HTTP_REFERER'] as $h) {
    if (empty($_SERVER[$h])) continue;
    $host = strtolower((string) parse_url($_SERVER[$h], PHP_URL_HOST));
    $port = parse_url($_SERVER[$h], PHP_URL_PORT);
    return in_array($host, $allowed, true) || in_array($host . ($port ? ':' . $port : ''), $allowed, true);
  }
  return false;   // neither header: not a browser form
}

// The pillar a lead or calculation belongs to: the key the page sent (if it is a real pillar), else from the URL
function lead_pillar($posted, $source) {
  if (is_scalar($posted) && $posted !== '' && hub((string) $posted)) return (string) $posted;
  return hub_for(rtrim($source ?: '/', '/') . '/')['key'] ?? '';
}

// Append one row to a CSV in the leads folder; a new file starts with a UTF-8 marker so Excel shows ₹ correctly
function csv_append($file, $row) {
  $new = !is_file($file);
  if (!($fh = @fopen($file, 'a'))) return;
  flock($fh, LOCK_EX);
  if ($new) { fwrite($fh, "\xEF\xBB\xBF"); fputcsv($fh, array_keys($row)); }
  fputcsv($fh, array_map(fn($v) => preg_match('/^[=+\-@]/', (string) $v) ? "'" . $v : $v, $row));   // stop spreadsheet formulas
  flock($fh, LOCK_UN); fclose($fh);
}

// Private folder for leads, one level ABOVE public_html (never reachable from the web)
function leads_dir() {
  $dir = dirname(rtrim($_SERVER['DOCUMENT_ROOT'] ?: dirname(__DIR__), '/')) . '/leads';
  if (!is_dir($dir)) @mkdir($dir, 0700, true);
  return $dir;
}

/* =====================================================================
   DELIVERY — called once the visitor has verified their email (includes/verify.php → pending_finish)
   ===================================================================== */
// columns of leads/leads.csv (keep the order: /admin/ reads the file by these names)
function lead_row($r) {
  $cols = ['time', 'lead_id', 'form', 'name', 'phone', 'email', 'city', 'home', 'service', 'budget', 'timeline', 'call_slot', 'notes',
           'estimate', 'estimate_total', 'source', 'pillar', 'landing', 'referrer', 'utm', 'ip', 'status'];
  return array_combine($cols, array_map(fn($c) => (string) ($r[$c] ?? ''), $cols));
}
function lead_ref($prefix) { return $prefix . '-' . date('ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5)); }
function mail_headers_from_visitor($email) { return ['reply_to' => $email, 'cc' => LEADS['notify_cc']]; }

// A consultation, call-back or quote form
function lead_deliver($s) {
  $staging = is_staging();
  $f = $s['fields'] ?? [];
  $ref = lead_ref('ENT');
  // the same mobile again within a day is still delivered, marked as a repeat
  $repeat = lim_count('lead_phone', $s['phone'], 86400) > 0;
  lim_add('lead_phone', $s['phone']);
  $lead = lead_row([
    'time' => date('Y-m-d H:i:s'), 'lead_id' => $ref, 'form' => $s['form'], 'name' => $s['name'], 'phone' => $s['phone'], 'email' => $s['email'],
    'city' => $s['city'], 'notes' => $f['notes'] ?? '', 'estimate' => $s['estimate'] ?? '', 'estimate_total' => $s['estimate_total'] ?? '',
    'source' => $s['source'], 'pillar' => $s['pillar'], 'landing' => $s['landing'], 'referrer' => $s['referrer'], 'utm' => $s['utm'], 'ip' => $s['ip'],
    'status' => $staging ? 'test' : ($repeat ? 'repeat' : 'new'),
  ] + $f);
  csv_append(leads_dir() . ($staging ? '/leads-test.csv' : '/leads.csv'), $lead);

  $subject = ($staging ? '[TEST] ' : '') . ($repeat ? '[Repeat] ' : '') . 'New ' . SITE['name'] . ' lead: ' . mail_line($s['name'], 40)
           . ' (' . mail_line(trim(($f['home'] ?? '') . ', ' . $s['city'], ', '), 60) . ')';
  $body = "New request from the " . lead_form_label($s['form']) . " form. The email address is verified.\n\n";
  foreach ($lead as $k => $v) if ($v !== '' && !in_array($k, ['status'], true)) $body .= str_pad(ucfirst(str_replace('_', ' ', $k)) . ':', 16) . $v . "\n";
  $body .= "\nCall: tel:+91{$s['phone']}\nWhatsApp: https://wa.me/91{$s['phone']}\nReply to this email to answer the visitor directly.\n";
  $sent = site_mail(LEADS['notify_email'], $subject, $body, mail_headers_from_visitor($s['email']));
  if (!$sent && !$staging) @file_put_contents(leads_dir() . '/rejected.log', date('c') . "\t{$s['ip']}\tmail-fail\t$ref\n", FILE_APPEND | LOCK_EX);   // still saved in leads.csv

  if (LEADS['webhook'] && !$staging) {
    @file_get_contents(LEADS['webhook'], false, stream_context_create(['http' => [
      'method' => 'POST', 'header' => "Content-Type: application/json\r\n", 'content' => json_encode($lead), 'timeout' => 4, 'ignore_errors' => true,
    ]]));
  }
  track_server_lead($lead, $ref);   // GA4 Measurement Protocol + Meta Conversions API (when configured)
  if (VERIFY['confirm_user']) {
    site_mail($s['email'], ($staging ? '[TEST] ' : '') . 'We have your request (' . $ref . ')',
      "Hello {$s['name']},\n\nThank you. Your request has reached the " . SITE['name'] . " team. " . LEADS['promise'] . "\n\n"
      . "Mobile:    +91 {$s['phone']}\nCity:      {$s['city']}\n" . (($f['home'] ?? '') !== '' ? "Home:      {$f['home']}\n" : '')
      . "Reference: $ref\n\nDid not send this? Reply to this email and we will delete your details.\n\n— " . SITE['name'] . ', ' . SITE['url'] . "\n",
      ['reply_to' => NAP['email']]);
  }
  return ['ok' => true, 'ref' => $ref, 'message' => 'Thank you — your email is verified and your request is sent (reference ' . $ref . '). ' . LEADS['promise']];
}
function lead_form_label($form) {
  return ['full' => 'free consultation', 'compact' => 'call-back', 'inline' => 'call-back strip', 'callback' => 'call-back', 'quote' => 'get 3 quotes', 'enquiry' => 'Contact / Mail'][$form] ?? $form;
}

// What a Contact / Mail enquiry is about, worked out on the server from our own data
function enquiry_target($kind, $key) {
  if ($kind === 'design' && ($d = design($key)) && ($p = pro($d['company'])))
    return ['kind' => 'design', 'key' => $key, 'pro_key' => $d['company'], 'pro' => $p, 'name' => $p['name'], 'about' => $d['title'],
            'url' => SITE['url'] . design_url($key), 'path' => design_url($key), 'sample' => !empty($d['sample']) || !empty($p['sample'])];
  if ($kind === 'pro' && ($p = pro($key)))
    return ['kind' => 'pro', 'key' => $key, 'pro_key' => $key, 'pro' => $p, 'name' => $p['name'], 'about' => 'Directory profile: ' . $p['name'],
            'url' => SITE['url'] . pro_url($key), 'path' => pro_url($key), 'sample' => !empty($p['sample'])];
  return null;
}

// A Contact / Mail enquiry about a design or a directory profile: always to our inbox, with the firm's name to forward it
function enquiry_deliver($s) {
  $t = enquiry_target($s['kind'], $s['target']);
  if (!$t) return ['ok' => false, 'message' => 'This listing is no longer available, so nothing was sent. Please use the contact page instead.', 'code' => 'gone'];
  if (lim_count('repeat', $s['email'] . '|' . $t['pro_key'], ENQUIRY['repeat_hours'] * 3600))
    return ['ok' => true, 'ref' => 'repeat', 'message' => 'You already contacted ' . $t['name'] . ' in the last ' . ENQUIRY['repeat_hours'] . ' hours, so we have not sent it twice. We have your details and will be in touch.'];
  $staging = is_staging();
  $ref = lead_ref('ENQ');
  $wants = $s['mode'] === 'mail' ? 'A reply by email' : 'A call back';
  $body = "FOR: {$t['name']}\nForward this enquiry to the firm, or reply to the customer yourself.\n\n"
        . "About:     {$t['about']}\nLink:      {$t['url']}\nWants:     $wants\n\n"
        . "Name:      {$s['name']}\nMobile:    +91 {$s['phone']}\nEmail:     {$s['email']} (verified)\nLocation:  {$s['city']}\n"
        . ($s['message'] !== '' ? "\nMessage:\n{$s['message']}\n" : '')
        . "\nReference: $ref\nSent:      " . date('j M Y, g:i a') . "\n\nCall: tel:+91{$s['phone']}  WhatsApp: https://wa.me/91{$s['phone']}\n";
  $subject = ($staging ? '[TEST] ' : '') . '[For: ' . mail_line($t['name'], 60) . '] Enquiry from ' . mail_line($s['name'], 40) . ', ' . mail_line($s['city'], 40) . " ($ref)";
  $sent = site_mail(LEADS['notify_email'], $subject, $body, mail_headers_from_visitor($s['email']));
  if (!$sent && !$staging) return ['ok' => false, 'message' => 'Your email is verified, but the message could not be sent just now. Please try again in a minute or email ' . NAP['email'] . " (reference $ref).", 'code' => 'mail'];

  if (VERIFY['confirm_user']) {
    site_mail($s['email'], ($staging ? '[TEST] ' : '') . 'Your enquiry to ' . mail_line($t['name'], 60) . " ($ref)",
      "Hello {$s['name']},\n\nYour enquiry about {$t['name']} has reached the " . SITE['name'] . " team. Expect a " . ($s['mode'] === 'mail' ? 'reply by email' : 'call') . " soon.\n\n"
      . "About:     {$t['about']}\nLink:      {$t['url']}\nMobile:    +91 {$s['phone']}\nLocation:  {$s['city']}\n" . ($s['message'] !== '' ? "\nYour message:\n{$s['message']}\n" : '')
      . "\nReference: $ref\n\nDid not send this? Reply to this email and we will remove your details.\n\n— " . SITE['name'] . ', ' . SITE['url'] . "\n",
      ['reply_to' => NAP['email']]);
  }
  lim_add('repeat', $s['email'] . '|' . $t['pro_key'], ENQUIRY['repeat_hours'] * 3600);
  csv_append(leads_dir() . ($staging ? '/enquiries-test.csv' : '/enquiries.csv'), [
    'time' => date('Y-m-d H:i:s'), 'ref' => $ref, 'status' => $staging ? 'test' : 'sent-to-inbox', 'kind' => $t['kind'], 'listing' => $t['key'],
    'firm' => $t['name'], 'firm_key' => $t['pro_key'], 'about' => $t['about'], 'mode' => $s['mode'], 'name' => $s['name'], 'phone' => $s['phone'], 'email' => $s['email'],
    'location' => $s['city'], 'message' => $s['message'], 'source' => $s['source'], 'landing' => $s['landing'], 'referrer' => $s['referrer'], 'utm' => $s['utm'], 'ip' => $s['ip'],
  ]);
  $lead = lead_row([
    'time' => date('Y-m-d H:i:s'), 'lead_id' => $ref, 'form' => 'enquiry-' . $t['kind'], 'name' => $s['name'], 'phone' => $s['phone'], 'email' => $s['email'],
    'city' => $s['city'], 'service' => 'Enquiry: ' . $t['name'], 'notes' => $s['message'], 'source' => $s['source'] ?: $t['path'],
    'pillar' => lead_pillar($s['pillar'], $s['source']), 'landing' => $s['landing'], 'referrer' => $s['referrer'], 'utm' => $s['utm'], 'ip' => $s['ip'], 'status' => $staging ? 'test' : 'new',
  ]);
  csv_append(leads_dir() . ($staging ? '/leads-test.csv' : '/leads.csv'), $lead);
  track_server_lead($lead, $ref);
  return ['ok' => true, 'ref' => $ref, 'message' => 'Your email is verified and your enquiry about ' . $t['name'] . ' is sent (reference ' . $ref . '). A copy is in your inbox.'];
}
