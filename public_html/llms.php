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
// the trending designs and directory pages are listed further down, and only once they hold real (non-sample) listings
$finderHidden = fn($href) => (str_starts_with($href, FINDER['designs_url']) && finder_noindex('designs')) || (str_starts_with($href, FINDER['pros_url']) && finder_noindex('pros'));
foreach ($HUBS as $h) {
  if (!$h['href'] || in_array($h['key'], ['blog', 'trending-designs'], true) || !is_live($h['href'])) continue;
  echo '## ' . $h['label'] . "\n\n";
  echo '- [' . $h['label'] . ' guide](' . $u . $h['href'] . '): ' . ($desc($h['href']) ?: $h['blurb']) . "\n";
  $seen = [$h['href'] => 1];
  foreach ($h['groups'] as $g) foreach ($g['links'] as $l) {
    if (isset($seen[$l['href']]) || !is_live($l['href']) || $finderHidden($l['href']) || str_contains($l['href'], '?')) continue;
    $seen[$l['href']] = 1;
    echo '- [' . $l['label'] . '](' . $u . $l['href'] . ')' . (($d = $desc($l['href'])) ? ": $d" : '') . "\n";
  }
  echo "\n";
}
if (!finder_noindex('designs') || !finder_noindex('pros')) {
  echo "## Design ideas and designer directory\n\n";
  if (!finder_noindex('designs')) echo '- [Trending interior designs](' . $u . FINDER['designs_url'] . '): homes and rooms from every state with the firm, designer, property, style and approximate budget; filter by city, design type, property and budget.' . "\n";
  if (!finder_noindex('pros')) echo '- [Find an interior designer](' . $u . FINDER['pros_url'] . '): designers, freelancers, contractors and carpenters by city, area, pincode, apartment and reviews, with budget level, warranty, factory and services.' . "\n";
  echo "\n";
}
echo "## Blog\n\n";
foreach (posts() as $p) if (empty($p['canonical'])) echo '- [' . $p['title'] . '](' . $u . $p['url'] . '): ' . $p['description'] . "\n";
echo "\n## Optional\n\n";
foreach (['/glossary/' => 'Materials glossary A–Z', '/compare/' => 'All comparisons', '/about/' => 'About Enteriors', '/contact/' => 'Contact'] as $href => $label)
  if (is_live($href)) echo "- [$label]($u$href)\n";
