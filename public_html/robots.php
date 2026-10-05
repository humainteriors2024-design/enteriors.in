<?php
/* robots.txt — generated so it always matches the live/staging switch in config.php.
   Live: everyone may read the guides — search engines AND AI answer engines (being quoted by
   ChatGPT, Perplexity, Gemini and Copilot is now a traffic source). Private folders stay closed.
   Staging: block everything. */
require __DIR__ . '/includes/site.php';
header('Content-Type: text/plain; charset=utf-8');
if (is_staging()) { echo "User-agent: *\nDisallow: /\n"; exit; }
$private = "Disallow: /api/\nDisallow: /admin/\nDisallow: /includes/\nDisallow: /_templates/\nDisallow: /style-guide/\nDisallow: /thank-you/\n";
echo "User-agent: *\n$private\n";
// AI search and answer engines, named so the intent is explicit
foreach (['GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-SearchBot', 'PerplexityBot', 'Google-Extended', 'Applebot-Extended', 'Bingbot', 'CCBot'] as $bot) echo "User-agent: $bot\n";
echo "Allow: /\n$private\n";
echo "Sitemap: " . SITE['url'] . "/sitemap.xml\n";
echo "# Site guide for AI assistants: " . SITE['url'] . "/llms.txt\n";
