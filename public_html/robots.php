<?php
/* robots.txt — generated so it always matches the switches in config.php.
   Launched (LAUNCHED = true): everyone may read the guides — search engines AND AI answer engines (being quoted
   by ChatGPT, Perplexity, Gemini and Copilot is now a traffic source). Private folders stay closed.
   Pre-launch lock (LAUNCHED = false): pages stay crawlable ON PURPOSE, so search engines can read the noindex on
   every page and drop anything already indexed (a "Disallow: /" would hide that noindex from them). No sitemap is
   listed and Google Images is kept out.
   Staging address: block everything. */
require __DIR__ . '/includes/site.php';
header('Content-Type: text/plain; charset=utf-8');
if (is_staging()) { echo "User-agent: *\nDisallow: /\n"; exit; }
$private = "Disallow: /api/\nDisallow: /admin/\nDisallow: /includes/\nDisallow: /_templates/\nDisallow: /style-guide/\nDisallow: /thank-you/\nDisallow: /verify/\n";
if (site_locked()) {
  echo "# Pre-launch: every page is noindex (meta robots + X-Robots-Tag). Crawling is allowed so search engines can see that.\n";
  echo "# No sitemap until launch (includes/config.php → LAUNCHED).\n";
  echo "User-agent: *\n$private\nUser-agent: Googlebot-Image\nDisallow: /\n";
  exit;
}
echo "User-agent: *\n$private\n";
// AI search and answer engines, named so the intent is explicit
foreach (['GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-SearchBot', 'PerplexityBot', 'Google-Extended', 'Applebot-Extended', 'Bingbot', 'CCBot'] as $bot) echo "User-agent: $bot\n";
echo "Allow: /\n$private\n";
echo "Sitemap: " . SITE['url'] . "/sitemap.xml\n";
echo "# Site guide for AI assistants: " . SITE['url'] . "/llms.txt\n";
