<?php
/* =====================================================================
   AUTOMATIC SITEMAP — served at /sitemap.xml (see .htaccess).
   Lists every folder that has an index.php plus every blog post in
   includes/posts-data.php, with the page's 'updated' date. Pages with
   'noindex' => true, drafts and private folders are skipped.
   Nothing to edit when you add pages.
   Pre-launch lock (config.php → LAUNCHED = false) and staging: answers "not found", so no sitemap is exposed.
   ===================================================================== */
require __DIR__ . '/includes/site.php';
if (site_locked()) { http_response_code(404); header('Content-Type: text/plain; charset=utf-8'); echo "Not found.\n"; exit; }
$urls = sitemap_urls();   // includes/functions.php (the IndexNow tool in /admin/ uses the same list)
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u => $d) echo '  <url><loc>' . e(SITE['url'] . $u) . "</loc><lastmod>$d</lastmod></url>\n";
echo '</urlset>';
