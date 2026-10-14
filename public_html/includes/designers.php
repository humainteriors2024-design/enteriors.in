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
     <?= designer_table() ?>      comparison table (firm, location, work)
     <?= designer_profiles() ?>   one card per firm: address, map, work, website
     <?= designer_method() ?>     how the firms were chosen + disclosure
     <?= designer_costs('bangalore') ?>   a link to the itemised interior cost calculator (no price figures:
                                          pages that name other firms show no segments and no prices, Oct 2026)
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
// Segment labels are no longer shown for other firms (Oct 2026). Kept so older templates do not break.
function designer_badge($seg) { return ''; }
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

/* Rows for a list: [key, firm, note, office], sorted alphabetically by name,
   so the order on the page is never a ranking (no segment grouping, Oct 2026). Unknown keys are skipped (a warning on staging). */
function designer_rows($list = null, $pg = null) {
  global $page;
  $pg = $pg ?? $page;
  $rows = [];
  foreach ($list ?? ($pg['designers'] ?? []) as $key => $note) {
    if (is_int($key)) { $key = $note; $note = ''; }
    $f = designer($key);
    if (!$f) { if (is_staging()) trigger_error("Unknown designer key: $key", E_USER_WARNING); continue; }
    // national pages (no city) show a brand's head office rather than one of its many studios
    $o = (empty($pg['city']) && !empty($f['hq'])) ? null : designer_office($f, $pg['city'] ?? null, $pg['area'] ?? null);
    $rows[] = [$key, $f, $note, $o];
  }
  usort($rows, fn($a, $b) => strcasecmp($a[1]['name'], $b[1]['name']));
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
     . '<thead><tr><th class="num">#</th><th>Firm</th><th>Location</th><th>Work it takes on</th></tr></thead><tbody>';
  foreach ($rows as $i => [$key, $f, $note, $o]) {
    $loc = $o ? designer_place($o, $place === 'city') : ($f['hq'] ?? '');
    $h .= '<tr><td class="num">' . ($i + 1) . '</td><td><a href="#firm-' . e($key) . '">' . e($f['name']) . '</a></td>'
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
    $pic = media_find($f['image'] ?? $key, $dir) ? img($f['image'] ?? $key, alt: $f['name'] . ' — interior work', dir: $dir, class: 'designer__img') : '';
    $meta = array_filter([$f['type'], !empty($f['since']) ? 'Since ' . (int) $f['since'] : '', !empty($f['hq']) && !$o ? 'Based in ' . $f['hq'] : '']);
    $h .= '<article class="designer' . ($pic ? ' designer--img' : '') . '" id="firm-' . e($key) . '">' . $pic . '<div class="designer__body">'
        . "<h$level class=\"designer__name\">" . designer_link($f) . "</h$level>"
        . '<p class="designer__meta">' . e(implode(' · ', $meta)) . '</p>'
        . ($note ? '<p class="designer__note">' . e($note) . '</p>' : '')
        . '<dl class="designer__facts">';
    if ($o) $h .= '<div><dt>' . ($o[2] ? 'Address' : 'Location') . '</dt><dd>' . e($o[2] ?: designer_place($o)) . ' <a class="designer__map" href="' . e(designer_map_url($f, $o)) . '" rel="nofollow noopener" target="_blank">Map</a></dd></div>';
    elseif (!empty($f['hq'])) $h .= '<div><dt>Head office</dt><dd>' . e($f['hq']) . '</dd></div>';
    $h .= '<div><dt>Work</dt><dd>' . e(designer_works($f)) . '</dd></div>'
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
       . '<p>Each firm has a studio, office or showroom ' . $where . ' with a published address or locality, its own website showing completed work, and takes on the kind of project this page covers. Firms are listed alphabetically; the order is not a ranking. We do not quote prices for the firms named here: ask each one for an itemised quotation and compare it with your own estimate from our <a href="/calculators/home-interior-quote/">interior cost calculator</a>.' . ($extra ? ' ' . e($extra) : '') . '</p>'
       . '<p>' . e($db['disclosure']) . ' Last checked ' . designers_checked() . '.</p>' . designer_finder_links() . '</div>';
}

/* "Search the directory / see designs" line under the method note: filtered to the page's city when we have listings there */
function designer_finder_links() {
  global $page;
  if (!function_exists('finder_route') || !is_live(FINDER['pros_url'])) return '';
  $c = $page['city'] ?? '';
  $city = $c && city_name($c) ? ['city' => $c, 'state' => city_state($c)] : [];
  $pros = $city && array_filter(pros_db()['pros'], fn($p) => in_array($c, $p['serves'], true));
  $designs = $city && array_filter(trends_db()['designs'], fn($d) => $d['city'] === $c);
  $name = $city ? city_name($c) : '';
  return '<p>Want someone near your street? Search the <a href="' . e(finder_url(FINDER['pros_url'], $pros ? $city : [])) . '">designer directory</a>'
       . ($pros ? ' for ' . e($name) : '') . ' by area, pincode, apartment and reviews, or browse <a href="' . e(finder_url(FINDER['designs_url'], $designs ? $city : [])) . '">trending designs'
       . ($designs ? ' from ' . e($name) : '') . '</a> with their approximate budgets.</p>';
}

/* Cost section for city and locality pages. Pages that name other firms carry no price figures or segment
   bands (Oct 2026), so this prints a short pointer to the itemised calculator instead. $note is ignored. */
function designer_costs($cityKey = '', $note = '') {
  $c = designer_city($cityKey);
  $where = $c ? ' in ' . e($c['name']) : '';
  return '<div class="callout callout--pillar designer-quote">'
       . '<span class="callout__title">Price your own home first</span>'
       . '<p>Every home is different, so we do not publish price bands for the firms on this page. Use our <a href="/calculators/home-interior-quote/">interior cost calculator</a> to build an itemised estimate for your rooms' . $where . ', with the exact board, finish and fittings, then ask each firm to quote the same list. Comparing line by line shows where quotations really differ.</p>'
       . '<p><a class="btn btn--primary btn--sm" href="/calculators/home-interior-quote/">Build my itemised quote →</a></p></div>';
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
