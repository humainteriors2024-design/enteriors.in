<?php
/* =====================================================================
   ENTERIORS — SENDING EMAIL
   One function for every email the site sends (OTP codes, enquiries, copies).
   Uses PHP mail() like the lead form. Every header value is stripped of line
   breaks and every address is validated, so form input can never add headers
   or recipients. To send through SMTP later, change only site_mail().
   ===================================================================== */

// One line, no CR/LF (header-injection safe), trimmed to $max characters
function mail_line($s, $max = 200) { return mb_substr(trim(preg_replace('/[\r\n\t]+/', ' ', (string) $s)), 0, $max); }

// A single, plain email address or '' (no names, no lists, no line breaks)
function mail_address($s) {
  $s = trim((string) $s);
  if ($s === '' || preg_match('/[\r\n,;<>"\s]/', $s) || strlen($s) > 120) return '';
  return filter_var($s, FILTER_VALIDATE_EMAIL) ? strtolower($s) : '';
}

// The address our mail is sent from: no-reply@<this site's domain>
function mail_from() {
  $host = preg_replace('/^www\.|:\d+$/', '', strtolower($_SERVER['HTTP_HOST'] ?? '')) ?: (string) parse_url(SITE['url'], PHP_URL_HOST);
  if (!preg_match('/^[a-z0-9.\-]+$/', $host)) $host = (string) parse_url(SITE['url'], PHP_URL_HOST);
  return 'no-reply@' . $host;
}

/* Send a plain-text email. $opt: reply_to, cc, bcc (single addresses). Returns true when handed to the mail server. */
function site_mail($to, $subject, $body, $opt = []) {
  $to = mail_address($to);
  if ($to === '') return false;
  $subject = mb_encode_mimeheader(mail_line($subject, 180), 'UTF-8', 'B', "\r\n");
  $h = ['From: ' . mb_encode_mimeheader(SITE['name'], 'UTF-8') . ' <' . mail_from() . '>',
        'MIME-Version: 1.0', 'Content-Type: text/plain; charset=UTF-8', 'Content-Transfer-Encoding: 8bit', 'Auto-Submitted: auto-generated'];
  foreach (['reply_to' => 'Reply-To', 'cc' => 'Cc', 'bcc' => 'Bcc'] as $k => $name)
    if (!empty($opt[$k]) && ($a = mail_address($opt[$k])) && $a !== $to) $h[] = "$name: $a";
  $body = str_replace(["\r\n", "\r"], "\n", (string) $body);
  $from = defined('ENQUIRY') && ENQUIRY['envelope_from'] ? mail_address(ENQUIRY['envelope_from']) : '';
  return $from ? @mail($to, $subject, $body, implode("\r\n", $h), '-f' . $from) : @mail($to, $subject, $body, implode("\r\n", $h));
}
