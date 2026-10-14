<?php
/* =====================================================================
   INDEXNOW — /admin/indexnow.php   (same login as /admin/)
   Sends every URL in the sitemap to IndexNow in one request. IndexNow is shared by Bing, Yandex,
   Seznam and Naver, so new and updated pages are picked up within hours instead of waiting for a crawl.
   Google does not use IndexNow: for Google, submit /sitemap.xml once in Search Console (it is also
   listed in /robots.txt, so Google finds it on its own).
   Key: config.php → TRACKING['indexnow_key'], or a newer key made with the "Make a new key" button
   (kept in leads/indexnow.key; its public file /<key>.txt is written into public_html).
   Works only after launch (config.php → LAUNCHED = true): before that the sitemap is empty.
   ===================================================================== */
require __DIR__ . '/../includes/admin-auth.php';

$docroot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
$store = leads_dir() . '/indexnow.key';
$valid = fn($k) => is_string($k) && preg_match('/^[a-zA-Z0-9-]{8,128}$/', $k);
$fileOk = fn($k) => $valid($k) && is_file("$docroot/$k.txt") && trim((string) file_get_contents("$docroot/$k.txt")) === $k;
$host = (string) parse_url(SITE['url'], PHP_URL_HOST);
$result = null;

// a GET of the public key file, the way IndexNow fetches it (from this server, over https)
function indexnow_fetch($url) {
  if (!function_exists('curl_init')) return [0, '', 'curl is not available on this server'];
  $ch = curl_init($url);
  curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => false, CURLOPT_TIMEOUT => 10,
                          CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; IndexNow key check; +https://www.indexnow.org)']);
  $body = (string) curl_exec($ch); $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE); $err = curl_error($ch); curl_close($ch);
  return [$code, $body, $err];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && admin_token_ok($_POST['t'] ?? '') && ($_POST['do'] ?? '') === 'newkey') {
  $new = bin2hex(random_bytes(16));
  if (@file_put_contents("$docroot/$new.txt", $new) !== false && @file_put_contents($store, $new) !== false) $result = [200, 'A new key was made: /' . $new . '.txt. Now press Submit.'];
  else $result = [0, 'Could not write the new key file into public_html (folder permissions).'];
}
$key = is_file($store) && $fileOk(trim((string) file_get_contents($store))) ? trim((string) file_get_contents($store)) : (TRACKING['indexnow_key'] ?? '');
$keyOk = $fileOk($key);
$keyUrl = SITE['url'] . '/' . $key . '.txt';
$urls = array_map(fn($u) => SITE['url'] . $u, array_keys(sitemap_urls()));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && admin_token_ok($_POST['t'] ?? '') && ($_POST['do'] ?? '') === 'submit') {
  if (!$keyOk || !$urls || is_staging()) {
    $result = [0, 'Nothing sent: ' . (!$keyOk ? 'the key file is missing or does not match.' : (is_staging() ? 'this is a staging address.' : 'the sitemap is empty (the site is still in the pre-launch lock).'))];
  } else {
    $body = json_encode(['host' => $host, 'key' => $key, 'keyLocation' => $keyUrl, 'urlList' => array_slice($urls, 0, 10000)], JSON_UNESCAPED_SLASHES);
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
    $meaning = [200 => 'Accepted: the pages were submitted.', 202 => 'Received: the key is still being checked; the pages will be processed.',
      400 => 'Bad request.',
      403 => 'IndexNow could not confirm the key from the internet. See "If you get 403" below.',
      422 => 'The URLs do not belong to ' . $host . '.', 429 => 'Too many requests: wait a day and try again.'][$code] ?? ($code ? 'Unexpected answer.' : 'No answer: the server could not reach api.indexnow.org.');
    $result = [$code, $meaning];
    @file_put_contents(leads_dir() . '/indexnow.log', date('c') . "\t" . count($urls) . " urls\t$key\t$code\n", FILE_APPEND | LOCK_EX);
  }
}
[$fc, $fb, $fe] = $keyOk ? indexnow_fetch($keyUrl) : [0, '', ''];
$publicOk = $fc === 200 && trim($fb) === $key;
$odd = array_filter($urls, fn($u) => preg_match('#^https?://[^/]+/(public_html|enteriors\.in-main)#', $u));
?><!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
<title>IndexNow · Enteriors admin</title>
<style>body{font:15px/1.6 system-ui,sans-serif;max-width:760px;margin:2rem auto;padding:0 1rem;color:#111}code{background:#f3f3f3;padding:0 .25rem}
.ok{color:#0a7a2f}.bad{color:#b00020}button{font:inherit;padding:.6rem 1.2rem;cursor:pointer;margin:0 .5rem .5rem 0}nav a{margin-right:.5rem}li{margin:.25rem 0}</style></head>
<body>
<nav><a href="/admin/">Reports</a> · <a href="/admin/images.php">Images</a> · <a href="/admin/designs.php">Add a design</a></nav>
<h1>Submit the sitemap to IndexNow</h1>
<p>Sends every page in <a href="/sitemap.xml" target="_blank">/sitemap.xml</a> to Bing, Yandex, Seznam and Naver in one go.
Use it after launch and after adding or updating several pages. For Google, submit the sitemap once in Search Console.</p>
<ul>
  <li>Key file on the server: <code>/<?= e($key) ?>.txt</code> — <?= $keyOk ? '<span class="ok">found and matching</span>' : '<span class="bad">missing or not matching</span>' ?></li>
  <li>Key file from the internet (<a href="<?= e($keyUrl) ?>" target="_blank">open it</a>): <?= !$keyOk ? '—' : ($publicOk ? '<span class="ok">opens and shows the key</span>' : '<span class="bad">' . e($fc ? "answers $fc" . ($fc === 200 ? ' but shows something else' : '') : 'could not be checked' . ($fe ? " ($fe)" : '')) . '</span>') ?></li>
  <li>Pages in the sitemap: <strong><?= count($urls) ?></strong><?= $urls ? '' : ' <span class="bad">(the site is still in the pre-launch lock: config.php → LAUNCHED)</span>' ?></li>
<?php if ($odd): ?>
  <li class="bad">The sitemap lists <?= count($odd) ?> pages from a second copy of the site inside public_html (e.g. <?= e(substr(reset($odd), 0, 60)) ?>). Delete that folder in File Manager.</li>
<?php endif; ?>
</ul>
<?php if ($result): ?>
<p class="<?= in_array($result[0], [200, 202], true) ? 'ok' : 'bad' ?>"><strong><?= $result[0] ?: '—' ?></strong> <?= e($result[1]) ?></p>
<?php endif; ?>
<form method="post"><input type="hidden" name="t" value="<?= e(admin_token()) ?>">
<button name="do" value="submit"<?= $keyOk && $urls && !is_staging() ? '' : ' disabled' ?>>Submit <?= count($urls) ?> pages</button>
<button name="do" value="newkey">Make a new key</button></form>

<h2>If you get 403</h2>
<p>403 means IndexNow fetched <code>/<?= e($key) ?>.txt</code> from the internet and did not get the key back. Try in this order:</p>
<ol>
  <li>Open <a href="<?= e($keyUrl) ?>" target="_blank"><?= e($keyUrl) ?></a> in a private window. It must show only the key. If it shows an error, a login or a "checking your browser" page, the hosting firewall is in the way: ask MilesWeb support to allow bots to read this file (Imunify360 / ModSecurity whitelist for <code>/<?= e($key) ?>.txt</code>).</li>
  <li>Press <strong>Make a new key</strong>, then <strong>Submit</strong>. A key that failed once can stay marked as invalid for a while; a fresh key starts clean.</li>
  <li>Either way, Bing does not need IndexNow: in <a href="https://www.bing.com/webmasters" target="_blank" rel="noopener">Bing Webmaster Tools</a> choose <em>Import from Google Search Console</em>, which adds the site and its sitemap in one step.</li>
</ol>
</body></html>
