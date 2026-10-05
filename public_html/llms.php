<?php
/* /llms.txt — a plain-text map of the site for AI assistants and answer engines (llmstxt.org format).
   Built automatically from includes/nav.php (pillars and their live pages), the calculators and
   includes/posts-data.php. Nothing to edit; it grows as you upload pages. Served via .htaccess. */
require __DIR__ . '/includes/site.php';
require_once __DIR__ . '/includes/calc/engine.php';
header('Content-Type: text/plain; charset=utf-8');
header('X-Robots-Tag: noindex');
$u = SITE['url'];
// a page's description, read from its own $page block
$desc = function ($href) {
  $f = rtrim($_SERVER['DOCUMENT_ROOT'] ?: __DIR__, '/') . $href . 'index.php';
  return is_file($f) && preg_match("#'description'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'#", file_get_contents($f), $m) ? stripslashes($m[1]) : '';
};
$R = calc_rates();

echo '# ' . SITE['name'] . "\n\n> " . SITE['description'] . " Independent guides for Indian homes, with prices for Bengaluru (" . $R['as_of'] . ") and free calculators.\n\n";
echo "Key facts:\n";
echo "- Prices are indicative ranges for Bengaluru, including 18% GST unless stated; other cities use a factor (" . implode(', ', array_map(fn($c, $f) => "$c " . number_format($f, 2), array_keys($R['cities']), $R['cities'])) . ").\n";
echo "- Whole-home interiors, full scope, per sq ft of carpet area: " . implode(', ', array_map(fn($k, $v) => $R['home']['grades'][$k][0] . ' ₹' . number_format($v), array_keys($R['home']['per_sqft']), $R['home']['per_sqft'])) . ".\n";
echo "- Modular kitchens are priced per running foot of base unit (₹" . number_format(min(array_column($R['kitchen']['carcass'], 1))) . '–' . number_format(max(array_column($R['kitchen']['carcass'], 1))) . " by board, laminate finish, before GST); wardrobes per sq ft of front (₹" . number_format($R['wardrobe']['door']['hinged'][1]) . " hinged, ₹" . number_format($R['wardrobe']['door']['sliding'][1]) . " sliding, laminate, before GST).\n";
echo "- Service area: " . implode(', ', NAP['area_served']) . ". Contact: " . NAP['email'] . "\n\n";

global $HUBS;
foreach ($HUBS as $h) {
  if (!$h['href'] || $h['key'] === 'blog' || !is_live($h['href'])) continue;
  echo '## ' . $h['label'] . "\n\n";
  echo '- [' . $h['label'] . ' guide](' . $u . $h['href'] . '): ' . ($desc($h['href']) ?: $h['blurb']) . "\n";
  $seen = [$h['href'] => 1];
  foreach ($h['groups'] as $g) foreach ($g['links'] as $l) {
    if (isset($seen[$l['href']]) || !is_live($l['href'])) continue;
    $seen[$l['href']] = 1;
    echo '- [' . $l['label'] . '](' . $u . $l['href'] . ')' . (($d = $desc($l['href'])) ? ": $d" : '') . "\n";
  }
  echo "\n";
}
echo "## Blog\n\n";
foreach (posts() as $p) if (empty($p['canonical'])) echo '- [' . $p['title'] . '](' . $u . $p['url'] . '): ' . $p['description'] . "\n";
// Execution partner (config.php → PARTNER)
echo "\n## Execution partner\n\n";
echo '- [' . PARTNER['name'] . '](' . PARTNER['url'] . '): ' . ucfirst(PARTNER['summary']) . '. Based in ' . PARTNER['base'] . ' since ' . PARTNER['since'] . '; serves ' . implode(', ', PARTNER['areas']) . ".\n";
if (is_live(PARTNER['page'])) echo '- [How Enteriors works with ' . PARTNER['name'] . "]($u" . PARTNER['page'] . "): what the partner does, areas served and how referrals work.\n";
foreach (LOCALITY_PAGES as $name => $href) if (is_live($href)) echo "- [Home interiors in $name]($u$href): " . ($desc($href) ?: "Area guide for $name") . "\n";
echo "\n## Optional\n\n";
foreach (['/glossary/' => 'Materials glossary A–Z', '/compare/' => 'All comparisons', '/about/' => 'About Enteriors', '/contact/' => 'Contact'] as $href => $label)
  if (is_live($href)) echo "- [$label]($u$href)\n";
