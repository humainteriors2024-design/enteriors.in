<?php
/* =====================================================================
   INTERIOR DESIGNER LISTINGS — helpers for /interior-designer-near-me/ and
   every /interior-designers/... page. No need to edit: the firms, cities and
   price bands are in includes/data/designers.php.

   A listing page sets, in its $page block:
     'designers'      => ['firm-key' => 'Why this firm fits this page', …]   the main list
     'designers_more' => ['firm-key' => '…', …]   optional "also worth a look" list
     'city'           => 'bangalore'   city key: picks the office shown for each firm
     'area'           => 'Indiranagar' optional: prefers the office in that area
     'hide_bands'     => true          optional: leave the home price band out of each card (office pages)
   and prints, wherever it wants them in the text:
     <?= designer_table() ?>      comparison table (firm, segment, location, work)
     <?= designer_profiles() ?>   one card per firm: address, map, work, website
     <?= designer_method() ?>     how the firms were chosen + disclosure
     <?= designer_costs('bangalore') ?>   price bands for the city (from the calculator rates)
     <?= designer_city_links() ?> cards linking to every city page
   The ItemList structured data for the list is added automatically (schema.php).
   Every link to a firm is rel="nofollow noopener" and opens in a new tab.
   Firm images: /assets/designers/<firm-key>.webp|jpg|png — shown only once uploaded.
   ===================================================================== */

function designers_db() { static $d = null; return $d ??= require __DIR__ . '/data/designers.php'; }
function designer($key) { return designers_db()['firms'][$key] ?? null; }
function designer_city($key) { return designers_db()['cities'][$key] ?? null; }
function designer_segment($seg) { return designers_db()['segments'][$seg] ?? null; }
function designers_checked() { return nice_date(designers_db()['checked']); }

// The office to show on this page: one in the page's area, else one in its city, else the first
function designer_office($f, $city = null, $area = null) {
  $offices = $f['offices'] ?? [];
  if ($area) foreach ($offices as $o) if ($o[0] === $city && stripos($o[1], $area) !== false) return $o;
  if ($city) foreach ($offices as $o) if ($o[0] === $city) return $o;
  return $offices[0] ?? null;
}
// "Indiranagar, Bengaluru" — area plus the official city name (once)
function designer_place($o, $withCity = true) {
  if (!$o) return '';
  $city = designer_city($o[0])['official'] ?? '';
  if (!$withCity || $city === '' || stripos($o[1], $city) !== false) return $o[1];
  return $o[1] . ', ' . $city;
}
function designer_link($f, $text = null, $class = '') {
  return '<a href="' . e($f['url']) . '" rel="nofollow noopener" target="_blank"' . ($class ? ' class="' . e($class) . '"' : '') . '>' . e($text ?? $f['name']) . '</a>';
}
function designer_badge($seg) {
  $s = designer_segment($seg);
  return $s ? '<span class="seg seg--' . e($seg) . '">' . e($s['label']) . '</span>' : '';
}
// "Villas, apartments, hospitality" — work categories as one readable phrase ($n = how many)
function designer_works($f, $n = null) {
  $w = $n ? array_slice($f['works'], 0, $n) : $f['works'];
  foreach ($w as $i => $x) if ($i && !preg_match('/^([0-9]|[A-Z]{2}|[A-Z][a-z]*[A-Z])/', $x)) $w[$i] = lcfirst($x);
  return implode(', ', $w);
}
function designer_map_url($f, $o) {
  $q = $f['name'] . ', ' . ($o[2] ?: designer_place($o));
  return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($q);
}

/* Rows for a list: [key, firm, note, office], sorted by segment (luxury → budget), then by name,
   so the order on the page is never a ranking. Unknown keys are skipped (a warning on staging). */
function designer_rows($list = null, $pg = null) {
  global $page;
  $pg = $pg ?? $page;
  $order = array_flip(array_keys(designers_db()['segments']));
  $rows = [];
  foreach ($list ?? ($pg['designers'] ?? []) as $key => $note) {
    if (is_int($key)) { $key = $note; $note = ''; }
    $f = designer($key);
    if (!$f) { if (is_staging()) trigger_error("Unknown designer key: $key", E_USER_WARNING); continue; }
    // national pages (no city) show a brand's head office rather than one of its many studios
    $o = (empty($pg['city']) && !empty($f['hq'])) ? null : designer_office($f, $pg['city'] ?? null, $pg['area'] ?? null);
    $rows[] = [$key, $f, $note, $o];
  }
  usort($rows, fn($a, $b) => [$order[$a[1]['segment']] ?? 9, $a[1]['name']] <=> [$order[$b[1]['segment']] ?? 9, $b[1]['name']]);
  return $rows;
}

/* Comparison table. Options: list (default the page's 'designers'), caption,
   place => 'area' (area only, default on city pages) | 'city' (area and city, for India/state pages) */
function designer_table($list = null, $caption = '', $place = null) {
  global $page;
  $rows = designer_rows($list);
  if (!$rows) return '';
  $place = $place ?? (empty($page['city']) ? 'city' : 'area');
  $h = '<div class="table-wrap designer-table"><table>' . ($caption ? '<caption>' . e($caption) . '</caption>' : '')
     . '<thead><tr><th class="num">#</th><th>Firm</th><th>Segment</th><th>Location</th><th>Work it takes on</th></tr></thead><tbody>';
  foreach ($rows as $i => [$key, $f, $note, $o]) {
    $loc = $o ? designer_place($o, $place === 'city') : ($f['hq'] ?? '');
    $h .= '<tr><td class="num">' . ($i + 1) . '</td><td><a href="#firm-' . e($key) . '">' . e($f['name']) . '</a></td><td>' . designer_badge($f['segment']) . '</td>'
        . '<td>' . e($loc) . '</td><td>' . e(designer_works($f, 3)) . '</td></tr>';
  }
  return $h . '</tbody></table></div>';
}

/* One card per firm. Options: list, heading level for the firm name (3 by default) */
function designer_profiles($list = null, $level = 3) {
  global $page;   // 'hide_bands' => true on office pages: home price bands do not apply
  $rows = designer_rows($list);
  $dir = designers_db()['img_dir'];
  $h = '<div class="designers">';
  foreach ($rows as [$key, $f, $note, $o]) {
    $seg = designer_segment($f['segment']);
    $pic = media_find($f['image'] ?? $key, $dir) ? img($f['image'] ?? $key, alt: $f['name'] . ' — interior work', dir: $dir, class: 'designer__img') : '';
    $meta = array_filter([$f['type'], !empty($f['since']) ? 'Since ' . (int) $f['since'] : '', !empty($f['hq']) && !$o ? 'Based in ' . $f['hq'] : '']);
    $h .= '<article class="designer' . ($pic ? ' designer--img' : '') . '" id="firm-' . e($key) . '">' . $pic . '<div class="designer__body">'
        . "<h$level class=\"designer__name\">" . designer_link($f) . ' ' . designer_badge($f['segment']) . "</h$level>"
        . '<p class="designer__meta">' . e(implode(' · ', $meta)) . '</p>'
        . ($note ? '<p class="designer__note">' . e($note) . '</p>' : '')
        . '<dl class="designer__facts">';
    if ($o) $h .= '<div><dt>' . ($o[2] ? 'Address' : 'Location') . '</dt><dd>' . e($o[2] ?: designer_place($o)) . ' <a class="designer__map" href="' . e(designer_map_url($f, $o)) . '" rel="nofollow noopener" target="_blank">Map</a></dd></div>';
    elseif (!empty($f['hq'])) $h .= '<div><dt>Head office</dt><dd>' . e($f['hq']) . '</dd></div>';
    $h .= '<div><dt>Work</dt><dd>' . e(designer_works($f)) . '</dd></div>'
        . ($seg ? '<div><dt>Segment</dt><dd>' . e($seg['label'] . (empty($page['hide_bands']) ? ' · typically ' . $seg['band'] : '')) . '</dd></div>' : '')
        . '</dl><p class="designer__link">' . designer_link($f, 'Visit ' . $f['name'] . ' website', 'link-arrow') . '</p></div></article>';
  }
  return $h . '</div>';
}

/* "How these firms were chosen" + disclosure. $place = where they are (e.g. 'Bangalore'). */
function designer_method($place = '', $extra = '') {
  $db = designers_db();
  $where = $place ? 'in or near ' . e($place) : 'in the city';
  return '<div class="callout callout--pillar designer-method" id="how-we-chose">'
       . '<span class="callout__title">How these firms were chosen</span>'
       . '<p>Each firm has a studio, office or showroom ' . $where . ' with a published address or locality, its own website showing completed work, and takes on the kind of project this page covers. We include a spread of budgets on purpose. Firms are grouped by segment, from luxury to budget, and listed alphabetically within each group. The segment is our reading of the firm\'s own positioning and published pricing, not a quality score.' . ($extra ? ' ' . e($extra) : '') . '</p>'
       . '<p>' . e($db['disclosure']) . ' Last checked ' . designers_checked() . '.</p></div>';
}

/* Price bands for a city, in the same grades as the cost guide and calculators.
   Uses the calculator's city factor when it has one; otherwise shows the Bengaluru base and says so. */
function designer_costs($cityKey, $note = '') {
  require_once __DIR__ . '/calc/engine.php';
  $c = designer_city($cityKey);
  $rates = calc_rates();
  $factor = ($c && $c['rate'] !== '' && isset($rates['cities'][$c['rate']])) ? $rates['cities'][$c['rate']] : null;
  $f = $factor ?? 1.0;
  $bands = ['budget' => [450, 700], 'mid' => [700, 1100], 'premium' => [1100, 1700], 'luxury' => [1700, null]];
  $round = fn($n) => (int) (round($n * $f / 25) * 25);
  $lakh = fn($n) => rtrim(rtrim(number_format($n / 100000, 1), '0'), '.');
  $h = '<div class="table-wrap"><table><thead><tr><th>Segment</th><th class="num">Per sq ft of carpet area</th><th class="num">2 BHK (about 950 sq ft)</th><th class="num">3 BHK (about 1,400 sq ft)</th></tr></thead><tbody>';
  foreach ($bands as $seg => [$lo, $hi]) {
    $lo2 = $round($lo); $hi2 = $hi ? $round($hi) : null;
    $h .= '<tr><td>' . e(designer_segment($seg)['label']) . '</td>'
        . '<td class="num">₹' . number_format($lo2) . ($hi2 ? '–' . number_format($hi2) : '+') . '</td>'
        . '<td class="num">' . ($hi2 ? '₹' . $lakh($lo2 * 950) . '–' . $lakh($hi2 * 950) . ' lakh' : '₹' . $lakh($lo2 * 950) . ' lakh+') . '</td>'
        . '<td class="num">' . ($hi2 ? '₹' . $lakh($lo2 * 1400) . '–' . $lakh($hi2 * 1400) . ' lakh' : '₹' . $lakh($lo2 * 1400) . ' lakh+') . '</td></tr>';
  }
  $h .= '</tbody></table></div>';
  $basis = $factor !== null && $factor != 1.0
    ? 'Bengaluru base rates multiplied by the ' . e($c['rate']) . ' factor (' . number_format($factor, 2) . ') used in our calculators'
    : ($factor !== null ? 'Our Bengaluru base rates' : 'Our Bengaluru base rates; the calculators do not yet carry a factor for ' . e($c['name'] ?? 'this city') . ', so compare these with two or three local quotations');
  return $h . '<p class="table-note">Full scope: kitchen, wardrobes, TV unit, false ceiling, painting, lighting and curtains, including 18% GST. Basis: ' . $basis . ', ' . e($rates['as_of']) . '. Indicative only.' . ($note ? ' ' . e($note) : '') . '</p>';
}

/* Cards for city pages. $keys = city keys to show (default: every city with a page), $exclude = keys to leave out */
function designer_city_links($keys = null, $exclude = []) {
  $cities = designers_db()['cities'];
  $h = '<div class="grid grid--sm city-grid">';
  foreach ($keys ?? array_keys($cities) as $k) {
    $c = $cities[$k] ?? null;
    if (!$c || !$c['url'] || in_array($k, (array) $exclude, true)) continue;
    $h .= card($c['url'], 'Interior designers in ' . $c['name'], $c['official'] !== $c['name'] ? $c['official'] . ', ' . $c['state'] : $c['state'], variant: 'boxed', always: is_staging());
  }
  return $h . '</div>';
}

/* ItemList structured data for the page's main list (called from schema.php) */
function designer_itemlist($pg, $canonical) {
  $rows = designer_rows(null, $pg);
  if (!$rows) return null;
  $items = [];
  foreach ($rows as $i => [$key, $f, $note, $o]) {
    $c = $o ? designer_city($o[0]) : null;
    $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'item' => array_filter([
      '@type' => 'Organization', 'name' => $f['name'], 'url' => $f['url'],
      'address' => $o ? array_filter(['@type' => 'PostalAddress', 'streetAddress' => $o[2] ?: null, 'addressLocality' => $c['official'] ?? null, 'addressRegion' => $c['state'] ?? null, 'addressCountry' => 'IN']) : null,
    ])];
  }
  return ['@type' => 'ItemList', '@id' => $canonical . '#designers', 'name' => $pg['list_name'] ?? ($pg['seo_title'] ?? $pg['title']),
          'numberOfItems' => count($items), 'itemListOrder' => 'https://schema.org/ItemListUnordered', 'itemListElement' => $items];
}
