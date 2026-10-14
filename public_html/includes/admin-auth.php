<?php
/* ADMIN LOGIN — shared by /admin/ (reports) and /admin/images.php (image uploader).
   Password: config.php → ADMIN. Until a password is set, staging shows a page that makes the
   line to paste into config.php; the live site answers 404. */
require_once __DIR__ . '/site.php';
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

if (ADMIN['password_hash'] === '') {
  if (!is_staging()) { http_response_code(404); require __DIR__ . '/../404.php'; exit; }
  $line = '';
  if (($_POST['pw'] ?? '') !== '' && strlen($_POST['pw']) >= 10) $line = "'password_hash' => '" . password_hash($_POST['pw'], PASSWORD_DEFAULT) . "',";
  echo '<!doctype html><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Set up admin</title><body style="font:16px system-ui;max-width:640px;margin:3rem auto;padding:0 1rem">'
     . '<h1>Set a password for /admin/</h1><p>Choose a password (10+ characters). Copy the line it gives you into <code>includes/config.php</code> → <code>ADMIN</code>, replacing the empty password_hash line, then upload config.php. The same login opens the reports and the image uploader.</p>'
     . '<form method="post"><input name="pw" type="password" minlength="10" required style="font-size:1rem;padding:.5rem;width:100%"><p><button style="font-size:1rem;padding:.5rem 1rem">Make the line</button></p></form>'
     . ($line ? '<p>Paste this:</p><pre style="background:#f4f4f4;padding:1rem;white-space:pre-wrap;word-break:break-all">' . e($line) . '</pre>' : '') . '</body>';
  exit;
}
if (!(($_SERVER['PHP_AUTH_USER'] ?? '') === ADMIN['user'] && password_verify($_SERVER['PHP_AUTH_PW'] ?? '', ADMIN['password_hash']))) {
  usleep(400000);
  header('WWW-Authenticate: Basic realm="Enteriors admin"');
  http_response_code(401);
  exit('Login required.');
}

// One-time token for forms on admin pages (stops other sites posting to them)
function admin_token() { return hash_hmac('sha256', 'admin|' . date('Y-m-d') . '|' . ($_SERVER['PHP_AUTH_USER'] ?? ''), LEADS['secret']); }
function admin_token_ok($t) { return is_string($t) && hash_equals(admin_token(), $t); }
