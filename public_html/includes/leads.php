<?php
/* =====================================================================
   ENTERIORS — LEAD FORM SECURITY AND VALIDATION
   Shared by the forms (includes/components/lead-form.php) and the
   handler (api/lead.php). Settings: config.php → LEADS.

   Every form carries three hidden fields:
     form     which form and where it sits, e.g. "compact"
     fk       the form key: "<time>.<signature>" signed with LEADS['secret']
     website  an empty "honeypot" field that only bots fill in
   The handler then checks, in order: POST → same-site origin → honeypot →
   form key (genuine, not too fast, not too old) → IP rate limit →
   name → Indian mobile number → links/spam → duplicate lead.
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
