<?php
/* =====================================================================
   CHECK THE INTERIOR DESIGNER PAGES  —  run from the repository root:
       php tools/check-designers.php
   Reads public_html/includes/data/designers.php and every page that lists firms, then reports:
     • firms used on more than 'max_pages' pages (the site-wide limit, default 3)
     • page keys that are not in the directory, firms with no website, bad city keys
     • firms listed on a city page that have no office in that city
     • how many pages use each firm, and firms not used anywhere
   Exit code 1 when there is an error, so it can run before every upload.
   ===================================================================== */
$root = dirname(__DIR__) . '/public_html';
$db = require $root . '/includes/data/designers.php';
$errors = 0;
$err = function ($m) use (&$errors) { $errors++; echo "ERROR  $m\n"; };
$warn = fn($m) => print("warn   $m\n");

// 1. Directory sanity
foreach ($db['firms'] as $k => $f) {
  if (empty($f['url']) || !preg_match('#^https?://#', $f['url'])) $err("$k: missing or invalid website");
  if (!isset($db['segments'][$f['segment'] ?? ''])) $err("$k: unknown segment '" . ($f['segment'] ?? '') . "'");
  foreach ($f['offices'] ?? [] as $o) if (!isset($db['cities'][$o[0]])) $err("$k: office city '{$o[0]}' is not in 'cities'");
}

// 2. Pages: read each $page block without rendering the page
$pages = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
foreach ($it as $file) {
  if ($file->getFilename() !== 'index.php') continue;
  $src = file_get_contents($file->getPathname());
  if (!str_contains($src, "'designers'") || !preg_match('#\$page = \[(.*?)\n\];\nrequire#s', $src, $m)) continue;
  $page = eval('return [' . $m[1] . "\n];");
  $url = str_replace($root, '', $file->getPath()) . '/';
  $pages[$url] = $page;
}
ksort($pages);

$use = [];
foreach ($pages as $url => $p) {
  $keys = array_merge(array_keys($p['designers'] ?? []), array_keys($p['designers_more'] ?? []));
  if (count($keys) !== count(array_unique($keys))) $err("$url: a firm is listed twice on the page");
  foreach (array_unique($keys) as $k) {
    if (!isset($db['firms'][$k])) { $err("$url: unknown firm key '$k'"); continue; }
    $use[$k][] = $url;
    $city = $p['city'] ?? null;
    if ($city && !in_array($city, array_column($db['firms'][$k]['offices'] ?? [], 0), true)) $warn("$url: '$k' has no office in '$city'");
  }
  printf("%-58s %2d firms\n", $url, count($keys));
}

// 3. The site-wide limit
echo "\n";
$max = $db['max_pages'];
arsort($use);
foreach ($use as $k => $urls) if (count($urls) > $max) $err("$k is on " . count($urls) . " pages (limit $max): " . implode(', ', $urls));
$unused = array_diff(array_keys($db['firms']), array_keys($use));
if ($unused) $warn('not used on any page: ' . implode(', ', $unused));

printf("\n%d pages, %d firms in the directory, %d used, most-used firm on %d pages (limit %d). %s\n",
  count($pages), count($db['firms']), count($use), $use ? max(array_map('count', $use)) : 0, $max, $errors ? "$errors error(s)." : 'No errors.');
exit($errors ? 1 : 0);
