<?php
/* =====================================================================
   AUTOMATIC SITEMAP — served at /sitemap.xml (see .htaccess).
   Lists every folder that has an index.php plus every blog post in
   includes/posts-data.php, with the page's 'updated' date. Pages with
   'noindex' => true, drafts and private folders are skipped.
   Nothing to edit when you add pages. On staging the sitemap is empty.
   ===================================================================== */
require __DIR__ . '/includes/site.php';
$root = rtrim($_SERVER['DOCUMENT_ROOT'] ?: __DIR__, '/');
$skip = '#^/(includes|assets|api|admin|_templates|style-guide|thank-you|blogs/[^/]+)(/|$)#';
$urls = [];
if (!is_staging()) {
  $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
  foreach ($it as $file) {
    if ($file->getFilename() !== 'index.php') continue;
    $dir = str_replace($root, '', $file->getPath());
    $url = ($dir === '' ? '' : $dir) . '/';
    if (preg_match($skip, $url) || str_contains($url, '/.') || str_contains($url, '/_')) continue;
    $src = file_get_contents($file->getPathname());
    if (preg_match("#'noindex'\s*=>\s*true|'canonical'\s*=>\s*'/#", $src)) continue;   // hidden, or points Google at another page
    $date = preg_match("#'updated'\s*=>\s*'(\d{4}-\d{2}-\d{2})'#", $src, $m) ? $m[1] : date('Y-m-d', $file->getMTime());
    $urls[$url] = $date;
  }
  foreach (posts() as $slug => $p) if (empty($p['canonical'])) $urls[$p['url']] = $p['updated'] ?? $p['date'];
  if (!posts()) unset($urls[BLOG_BASE . '/']);   // no empty blog hub in the sitemap
  ksort($urls);
}
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u => $d) echo '  <url><loc>' . e(SITE['url'] . $u) . "</loc><lastmod>$d</lastmod></url>\n";
echo '</urlset>';
