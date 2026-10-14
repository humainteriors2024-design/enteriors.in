<?php
/* =====================================================================
   INDEXNOW — /admin/indexnow.php   (same login as /admin/)
   Sends every URL in the sitemap to IndexNow in one request. IndexNow is shared by Bing, Yandex,
   Seznam and Naver, so new and updated pages are picked up within hours instead of waiting for a crawl.
   Google does not use IndexNow: for Google, submit /sitemap.xml once in Search Console (it is also
   listed in /robots.txt, so Google finds it on its own).
   Key: config.php → TRACKING['indexnow_key']; the key file /<key>.txt must be in public_html.
   Works only after launch (config.php → LAUNCHED = true): before that the sitemap is empty.
   ===================================================================== */
require __DIR__ . '/../includes/admin-auth.php';

$key  = TRACKING['indexnow_key'] ?? '';
$host = (string) parse_url(SITE['url'], PHP_URL_HOST);
$keyFile = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/' . $key . '.txt';
$keyOk = preg_match('/^[a-zA-Z0-9-]{8,128}$/', $key) && is_file($keyFile) && trim((string) file_get_contents($keyFile)) === $key;
$urls = array_map(fn($u) => SITE['url'] . $u, array_keys(sitemap_urls()));
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && admin_token_ok($_POST['t'] ?? '')) {
  if (!$keyOk || !$urls || is_staging()) {
    $result = [0, 'Nothing sent: ' . (!$keyOk ? 'the key file is missing or does not match.' : (is_staging() ? 'this is a staging address.' : 'the sitemap is empty (the site is still in the pre-launch lock).'))];
  } else {
    $body = json_encode(['host' => $host, 'key' => $key, 'keyLocation' => SITE['url'] . '/' . $key . '.txt', 'urlList' => array_slice($urls, 0, 10000)], JSON_UNESCAPED_SLASHES);
    $code = 0;
    if (function_exists('curl_init')) {
      $ch = curl_init('https://api.indexnow.org/indexnow');
      curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $body, CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf-8'],
                              CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20]);
      curl_exec($ch); $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
    } else {
      @file_get_contents('https://api.indexnow.org/indexnow', false, stream_context_create(['http' => ['method' => 'POST',
        'header' => "Content-Type: application/json; charset=utf-8\r\n", 'content' => $body, 'timeout' => 20, 'ignore_errors' => true]]));
      if (preg_match('#^HTTP/\S+ (\d{3})#', $http_response_header[0] ?? '', $m)) $code = (int) $m[1];
    }
    $meaning = [200 => 'Accepted: the URLs were submitted.', 202 => 'Received: the key is still being checked; the URLs will be processed.',
      400 => 'Bad request.', 403 => 'Key not valid: check that /' . $key . '.txt opens and shows the key.', 422 => 'The URLs do not belong to ' . $host . '.',
      429 => 'Too many requests: wait a day and try again.'][$code] ?? ($code ? 'Unexpected answer.' : 'No answer: the server could not reach api.indexnow.org.');
    $result = [$code, $meaning];
    @file_put_contents(leads_dir() . '/indexnow.log', date('c') . "\t" . count($urls) . " urls\t$code\n", FILE_APPEND | LOCK_EX);
  }
}
?><!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
<title>IndexNow · Enteriors admin</title>
<style>body{font:15px/1.6 system-ui,sans-serif;max-width:760px;margin:2rem auto;padding:0 1rem;color:#111}code{background:#f3f3f3;padding:0 .25rem}
.ok{color:#0a7a2f}.bad{color:#b00020}button{font:inherit;padding:.6rem 1.2rem;cursor:pointer}nav a{margin-right:.5rem}</style></head>
<body>
<nav><a href="/admin/">Reports</a> · <a href="/admin/images.php">Images</a> · <a href="/admin/designs.php">Add a design</a></nav>
<h1>Submit the sitemap to IndexNow</h1>
<p>Sends every page in <a href="/sitemap.xml" target="_blank">/sitemap.xml</a> to Bing, Yandex, Seznam and Naver in one go.
Use it after launch and after adding or updating several pages. For Google, submit the sitemap once in Search Console.</p>
<ul>
  <li>Key file: <code>/<?= e($key) ?>.txt</code> — <?= $keyOk ? '<span class="ok">found and matching</span>' : '<span class="bad">missing or not matching</span>' ?></li>
  <li>Pages in the sitemap: <strong><?= count($urls) ?></strong><?= $urls ? '' : ' <span class="bad">(the site is still in the pre-launch lock: config.php → LAUNCHED)</span>' ?></li>
</ul>
<?php if ($result): ?>
<p class="<?= in_array($result[0], [200, 202], true) ? 'ok' : 'bad' ?>"><strong><?= $result[0] ?: '—' ?></strong> <?= e($result[1]) ?></p>
<?php endif; ?>
<form method="post"><input type="hidden" name="t" value="<?= e(admin_token()) ?>">
<button<?= $keyOk && $urls && !is_staging() ? '' : ' disabled' ?>>Submit <?= count($urls) ?> pages</button></form>
</body></html>
