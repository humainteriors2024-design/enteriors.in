<?php
/* =====================================================================
   ENTERIORS — TRENDING DESIGNS + DESIGNER DIRECTORY (shared engine)
   Pages   /trending-designs/            listing, filters on the left, search (max 4 words)
           /trending-designs/<key>/      one design: gallery, details, Contact / Mail
           /services/find-designer/      directory of designers, freelancers, contractors, carpenters
           /services/find-designer/<key>/ one professional's profile
   Data    includes/data/trends.php · includes/data/pros.php · includes/data/places.php
   Mail    api/enquiry.php (one-time code to the visitor's email, then the enquiry goes out)
   Settings config.php → FINDER and ENQUIRY.

   Every filter value from the address bar is checked against the lists in the data files,
   so only known values are ever used; text search is cut to FINDER['search_words'] words.
   ===================================================================== */

/* ---------- data ---------- */
function places_db() { static $d; return $d ??= require __DIR__ . '/data/places.php'; }
function trends_db() { static $d; return $d ??= require __DIR__ . '/data/trends.php'; }
function pros_db()   { static $d; return $d ??= require __DIR__ . '/data/pros.php'; }
function design($key) { return trends_db()['designs'][$key] ?? null; }
function pro($key)    { return pros_db()['pros'][$key] ?? null; }
function city_name($k)  { return places_db()['cities'][$k]['name'] ?? ''; }
function city_state($k) { return places_db()['cities'][$k]['state'] ?? ''; }
function state_name($k) { return places_db()['states'][$k]['name'] ?? ''; }
function design_url($key) { return FINDER['designs_url'] . $key . '/'; }
function pro_url($key)    { return FINDER['pros_url'] . $key . '/'; }

/* Detail-page routes: ['designs'|'pros', key, exists] for /trending-designs/<key>/ or /services/find-designer/<key>/, else null.
   Used by is_live() so links to these pages are never stripped, and by the two page files. */
function finder_route($path) {
  foreach (['designs' => FINDER['designs_url'], 'pros' => FINDER['pros_url']] as $sec => $base)
    if (preg_match('#^' . preg_quote($base, '#') . '([a-z0-9\-]{1,100})/?$#', (string) $path, $m))
      return [$sec, $m[1], $sec === 'designs' ? (bool) design($m[1]) : (bool) pro($m[1])];
  return null;
}

/* Sample listings: while any are shown, the pages say so and are noindex (config FINDER['index_samples']) */
function finder_has_samples($sec) {
  static $c = [];
  return $c[$sec] ??= (bool) array_filter($sec === 'designs' ? trends_db()['designs'] : pros_db()['pros'], fn($x) => !empty($x['sample']));
}
function finder_noindex($sec) { return !FINDER['index_samples'] && finder_has_samples($sec); }
function finder_sample_note($sec) {
  if (!finder_has_samples($sec)) return '';
  $what = $sec === 'designs' ? 'These designs are sample listings: the projects, people and prices are fictional and the pictures are drawn illustrations.'
                             : 'These professionals are sample listings: the names, ratings, reviews and projects are fictional.';
  return '<p class="sample-note" role="note"><strong>Sample listings.</strong> ' . $what . ' Real, checked listings will replace them. Enquiries you send now reach the Enteriors team, who will reply to you.</p>';
}
function sample_badge($x) { return !empty($x['sample']) ? '<span class="badge badge--sample">Sample</span>' : ''; }

/* ---------- money, labels ---------- */
function money_short($n) {
  $n = (int) $n;
  if ($n >= 10000000) return '₹' . rtrim(rtrim(number_format($n / 10000000, 2), '0'), '.') . ' crore';
  if ($n >= 100000)   return '₹' . rtrim(rtrim(number_format($n / 100000, 1), '0'), '.') . ' lakh';
  return '₹' . number_format($n);
}
function design_band($d) {
  foreach (trends_db()['budgets'] as $k => [$label, $from, $to]) if ($d['budget'] >= $from && $d['budget'] < $to) return $k;
  return '';
}
function design_home($d) {   // "3 BHK apartment", "Studio apartment", "Office space"
  $prop = trends_db()['properties'][$d['property']] ?? '';
  return $d['bhk'] ? $d['bhk'] . ' BHK ' . strtolower($prop) : $prop;
}
function design_place($d, $state = true) {
  return $d['area'] . ', ' . city_name($d['city']) . ($state ? ', ' . state_name(city_state($d['city'])) : '');
}
function segment_label($k) { return ['budget' => 'Budget', 'mid' => 'Mid-range', 'premium' => 'Premium', 'luxury' => 'Luxury'][$k] ?? ''; }

/* ---------- pictures: real photos in /assets/trending/<key>/ win; otherwise the sample illustrations ---------- */
function design_images($key, $d) {
  $dir = '/assets/trending/' . $key;
  $out = [];
  foreach (media_files($dir) as $name => $set) {
    if (!array_intersect(array_keys($set), MEDIA['images']) || !($m = media_find($name, $dir))) continue;
    $alt = alt_from_name($m['file']);
    $out[] = ['src' => $m['url'], 'webp' => $m['webp'], 'w' => $m['w'] ?: 1200, 'h' => $m['h'] ?: 800,
              'alt' => preg_match('/\pL{3}/u', $alt) ? $alt : $d['title'] . ', photo ' . (count($out) + 1), 'sample' => false];
    if (count($out) === 12) break;
  }
  if ($out) return $out;
  $T = trends_db();
  foreach ($d['images'] as $v)
    $out[] = ['src' => '/assets/trending/samples/' . $v . '-' . (int) $d['palette'] . '.svg', 'webp' => null, 'w' => 1200, 'h' => 800,
              'alt' => $T['styles'][$d['style']]['label'] . ' ' . ($T['views'][$v] ?? str_replace('-', ' ', $v)) . ' (sample illustration)', 'sample' => true];
  return $out;
}
function finder_img($im, $lazy = true, $sizes = '', $attr = '') {
  $tag = '<img src="' . e($im['src']) . '" alt="' . e($im['alt']) . '" width="' . (int) $im['w'] . '" height="' . (int) $im['h'] . '"'
       . ($lazy ? ' loading="lazy" decoding="async"' : ' fetchpriority="high"') . ($sizes ? ' sizes="' . e($sizes) . '"' : '') . $attr . '>';
  return $im['webp'] ? '<picture><source srcset="' . e($im['webp']) . '" type="image/webp">' . $tag . '</picture>' : $tag;
}

/* ---------- search text: letters, digits and a few marks; at most N words ---------- */
function finder_text($raw) {
  $s = is_scalar($raw) ? (string) $raw : '';
  $s = preg_replace('/[^\p{L}\p{N}\s&\-.,\'()\/]/u', ' ', mb_substr($s, 0, 200));
  $words = preg_split('/\s+/u', trim($s), -1, PREG_SPLIT_NO_EMPTY);
  return mb_substr(implode(' ', array_slice($words, 0, FINDER['search_words'])), 0, FINDER['search_chars']);
}
function finder_norm($s) {   // lower case, city aliases, "2 bhk" → "2bhk"
  $s = mb_strtolower((string) $s);
  $s = preg_replace('/(\d)\s*-?\s*bhk\b/u', '$1bhk', $s);
  static $alias = ['bangalore' => 'bengaluru', 'blr' => 'bengaluru', 'bombay' => 'mumbai', 'gurgaon' => 'gurugram', 'mysore' => 'mysuru',
    'vizag' => 'visakhapatnam', 'trichy' => 'tiruchirappalli', 'belgaum' => 'belagavi', 'pondicherry' => 'puducherry', 'pondy' => 'puducherry',
    'calcutta' => 'kolkata', 'madras' => 'chennai', 'trivandrum' => 'thiruvananthapuram', 'cochin' => 'kochi', 'ernakulam' => 'kochi',
    'calicut' => 'kozhikode', 'mangalore' => 'mangaluru', 'baroda' => 'vadodara', 'puja' => 'pooja', 'mandir' => 'pooja', 'temple' => 'pooja',
    'almirah' => 'wardrobe', 'cupboard' => 'wardrobe', 'closet' => 'wardrobe', 'toilet' => 'bathroom', 'washroom' => 'bathroom',
    'scandi' => 'scandinavian', 'boho' => 'bohemian', 'midcentury' => 'mid-century', 'japanese' => 'japandi', 'ceilings' => 'ceiling', 'cafe' => 'café'];
  return preg_replace_callback('/\p{L}+/u', fn($m) => $alias[$m[0]] ?? $m[0], $s);
}
function finder_tokens($q) {
  static $stop = ['in', 'at', 'for', 'the', 'a', 'an', 'and', 'with', 'near', 'me', 'of', 'on', 'to', 'design', 'designs', 'interior', 'interiors',
                  'idea', 'ideas', 'best', 'latest', 'trending', 'new', 'top', 'my', 'home', 'homes', 'house'];
  $out = [];
  foreach (preg_split('/[\s,\/()]+/u', finder_norm($q), -1, PREG_SPLIT_NO_EMPTY) as $w) {
    $w = trim($w, ".-'&");
    if ($w === '' || in_array($w, $stop, true)) continue;
    if (mb_strlen($w) > 4 && str_ends_with($w, 's') && !str_ends_with($w, 'ss')) $w = mb_substr($w, 0, -1);   // kitchens → kitchen
    $out[] = $w;
  }
  return array_values(array_unique($out));
}
function finder_text_match($hay, $tokens) {
  foreach ($tokens as $t) if (!str_contains($hay, $t)) return false;
  return true;
}

/* ---------- reading the address bar ---------- */
function finder_list($key, $allowed, $max = 20) {   // ?type=a,b or ?type[]=a&type[]=b → only allowed values
  $v = $_GET[$key] ?? [];
  $v = is_array($v) ? $v : explode(',', (string) $v);
  $v = array_slice(array_filter(array_map(fn($x) => is_scalar($x) ? strtolower(trim((string) $x)) : '', $v)), 0, $max);
  return array_values(array_unique(array_filter($v, fn($x) => in_array($x, $allowed, true))));
}
function finder_one($key, $allowed) {
  $v = $_GET[$key] ?? '';
  $v = is_scalar($v) ? strtolower(trim((string) $v)) : '';
  return in_array($v, $allowed, true) ? $v : '';
}
function finder_page_no() { $p = $_GET['page'] ?? 1; return is_scalar($p) && ctype_digit((string) $p) ? max(1, min(500, (int) $p)) : 1; }

/* Address for a filter set: only non-empty values, lists joined with commas. $over replaces values. */
function finder_url($base, $F, $over = []) {
  $F = array_merge($F, $over);
  $q = [];
  foreach ($F as $k => $v) {
    if ($k[0] === '_' || ($k === 'page' && (int) $v <= 1)) continue;
    if (in_array($k, ['sort'], true) && in_array($v, ['new', 'best'], true)) continue;
    if (is_array($v)) { if ($v) $q[] = $k . '=' . implode(',', array_map('rawurlencode', $v)); }
    elseif ((string) $v !== '') $q[] = $k . '=' . rawurlencode((string) $v);
  }
  return $base . ($q ? '?' . implode('&', $q) : '');
}
function finder_has_filters($F) {
  foreach ($F as $k => $v) if ($k[0] !== '_' && !in_array($k, ['sort', 'page'], true) && $v !== '' && $v !== []) return true;
  return false;
}

/* ---------- facet helper: counts for one filter given every other filter ---------- */
function finder_counts($items, $F, $facet, $matchFn, $valueFn) {
  $c = [];
  foreach ($items as $k => $x) if ($matchFn($x, $F, $facet, $k)) foreach ((array) $valueFn($x) as $v) $c[$v] = ($c[$v] ?? 0) + 1;
  return $c;
}

/* =====================================================================
   TRENDING DESIGNS
   ===================================================================== */
function designs_query() {
  $T = trends_db(); $P = places_db();
  $F = [
    'q'        => finder_text($_GET['q'] ?? ''),
    'state'    => finder_one('state', array_keys($P['states'])),
    'city'     => finder_one('city', array_keys($P['cities'])),
    'type'     => finder_list('type', array_keys($T['types'])),
    'property' => finder_list('property', array_keys($T['properties'])),
    'bhk'      => finder_list('bhk', ['1', '2', '3', '4']),   // 4 = 4 BHK and larger
    'budget'   => finder_one('budget', array_keys($T['budgets'])),
    'style'    => finder_list('style', array_keys($T['styles'])),
    'company'  => finder_one('company', array_keys(pros_db()['pros'])),
    'sort'     => finder_one('sort', ['new', 'budget-low', 'budget-high', 'az']) ?: 'new',
    'page'     => finder_page_no(),
  ];
  if ($F['city'] && !$F['state']) $F['state'] = city_state($F['city']);
  if ($F['city'] && city_state($F['city']) !== $F['state']) $F['city'] = '';
  return $F;
}
function design_haystack($d) {
  static $cache = [];
  $T = trends_db(); $pro = pro($d['company']);
  return $cache[$d['title']] ??= finder_norm(implode(' ', [
    $d['title'], $d['project'], $d['area'], $d['pincode'], city_name($d['city']), $d['city'], state_name(city_state($d['city'])),
    $pro['name'] ?? '', $d['designer'], $T['properties'][$d['property']] ?? '', $d['bhk'] ? $d['bhk'] . 'bhk' : 'studio',
    $T['styles'][$d['style']]['label'] ?? '', $T['types'][$d['type']]['label'] ?? '', segment_label($d['segment']),
    implode(' ', $d['materials']), implode(' ', $d['highlights']),
  ]));
}
function design_matches($d, $F, $skip = '', $key = '') {
  if ($skip !== 'state' && $skip !== 'city' && $F['state'] && city_state($d['city']) !== $F['state']) return false;
  if ($skip !== 'city' && $F['city'] && $d['city'] !== $F['city']) return false;
  if ($skip !== 'type' && $F['type'] && !in_array($d['type'], $F['type'], true)) return false;
  if ($skip !== 'property' && $F['property'] && !in_array($d['property'], $F['property'], true)) return false;
  if ($skip !== 'bhk' && $F['bhk'] && !in_array((string) min(4, (int) $d['bhk']), $F['bhk'], true)) return false;
  if ($skip !== 'budget' && $F['budget'] && design_band($d) !== $F['budget']) return false;
  if ($skip !== 'style' && $F['style'] && !in_array($d['style'], $F['style'], true)) return false;
  if ($skip !== 'company' && $F['company'] && $d['company'] !== $F['company']) return false;
  if ($skip !== 'q' && $F['q'] !== '' && !finder_text_match(design_haystack($d), finder_tokens($F['q']))) return false;
  return true;
}
function designs_search($F) {
  $all = trends_db()['designs'];
  $hits = array_filter($all, fn($d) => design_matches($d, $F));
  uksort($hits, function ($a, $b) use ($hits, $F) {
    $x = $hits[$a]; $y = $hits[$b];
    return match ($F['sort']) {
      'budget-low'  => $x['budget'] <=> $y['budget'],
      'budget-high' => $y['budget'] <=> $x['budget'],
      'az'          => strcmp($x['title'], $y['title']),
      default       => [$y['added'], (int) !empty($y['trending'])] <=> [$x['added'], (int) !empty($x['trending'])],
    };
  });
  $m = 'design_matches';
  $counts = [
    'state'    => finder_counts($all, $F, 'state', $m, fn($d) => city_state($d['city'])),
    'city'     => finder_counts($all, $F, 'city', $m, fn($d) => $d['city']),
    'type'     => finder_counts($all, $F, 'type', $m, fn($d) => $d['type']),
    'property' => finder_counts($all, $F, 'property', $m, fn($d) => $d['property']),
    'bhk'      => finder_counts($all, $F, 'bhk', $m, fn($d) => $d['bhk'] ? (string) min(4, (int) $d['bhk']) : []),
    'budget'   => finder_counts($all, $F, 'budget', $m, fn($d) => design_band($d)),
    'style'    => finder_counts($all, $F, 'style', $m, fn($d) => $d['style']),
  ];
  return [$hits, $counts];
}

/* One design card: picture (browse all photos on the card), details, View / Contact / Mail */
function design_card($key, $d, $lazy = true, $compact = false) {
  $T = trends_db(); $pro = pro($d['company']); $imgs = design_images($key, $d); $url = design_url($key);
  $list = json_encode(array_map(fn($i) => [$i['src'], $i['alt']], $imgs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  $h = '<article class="dcard' . ($compact ? ' dcard--compact' : '') . '">'
     . '<div class="dcard__media" data-card-gallery="' . e($list) . '">'
     . '<a href="' . e($url) . '" tabindex="-1" aria-hidden="true">' . finder_img($imgs[0], $lazy, '(max-width: 640px) 100vw, 400px') . '</a>'
     . (count($imgs) > 1 ? '<button class="dcard__nav dcard__nav--prev" type="button" aria-label="Previous photo" data-card-step="-1">‹</button><button class="dcard__nav dcard__nav--next" type="button" aria-label="Next photo" data-card-step="1">›</button>' : '')
     . '<span class="dcard__count" data-card-count>1 / ' . count($imgs) . '</span>' . sample_badge($d) . '</div>'
     . '<div class="dcard__body">'
     . '<p class="dcard__kicker">' . e($T['types'][$d['type']]['label']) . ' · ' . e($T['styles'][$d['style']]['label']) . '</p>'
     . '<h3 class="dcard__title"><a href="' . e($url) . '">' . e($d['title']) . '</a></h3>';
  if (!$compact) {
    $h .= '<dl class="dcard__facts">'
        . '<div><dt>Project</dt><dd>' . e($d['project']) . '</dd></div>'
        . '<div><dt>Location</dt><dd>' . e(design_place($d)) . '</dd></div>'
        . '<div><dt>Company</dt><dd>' . ($pro ? '<a href="' . e(pro_url($d['company'])) . '">' . e($pro['name']) . '</a>' : '') . '</dd></div>'
        . '<div><dt>Designer</dt><dd>' . e($d['designer']) . '</dd></div>'
        . '<div><dt>Property</dt><dd>' . e(design_home($d)) . '</dd></div>'
        . '<div><dt>Budget</dt><dd><strong>≈ ' . e(money_short($d['budget'])) . '</strong></dd></div>'
        . '</dl>'
        . '<div class="dcard__actions"><a class="btn btn--sm btn--outline" href="' . e($url) . '">View design</a>'
        . enquiry_buttons('design', $key, $pro['name'] ?? 'the designer', $d['title'], true) . '</div>';
  } else {
    $h .= '<p class="dcard__place">' . e(design_place($d, false)) . ' · ≈ ' . e(money_short($d['budget'])) . '</p>';
  }
  return $h . '</div></article>';
}

/* =====================================================================
   DIRECTORY OF PROFESSIONALS
   ===================================================================== */
function pros_query() {
  $D = pros_db(); $P = places_db(); $T = trends_db();
  $F = [
    'near'    => finder_text($_GET['near'] ?? ''),
    'type'    => finder_list('type', array_keys($D['types'])),
    'state'   => finder_one('state', array_keys($P['states'])),
    'city'    => finder_one('city', array_keys($P['cities'])),
    'area'    => '',
    'pin'     => preg_match('/^[1-9]\d{5}$/', $p = trim((string) (is_scalar($_GET['pin'] ?? '') ? $_GET['pin'] ?? '' : ''))) ? $p : '',
    'apt'     => finder_text($_GET['apt'] ?? ''),
    'rating'  => finder_one('rating', ['4.5', '4', '3.5']),
    'reviews' => finder_one('reviews', ['10', '50', '100']),
    'seg'     => finder_list('seg', ['budget', 'mid', 'premium', 'luxury']),
    'req'     => finder_list('req', array_keys($D['reqs'])),
    'does'    => finder_one('does', array_keys($T['types'])),
    'sort'    => finder_one('sort', ['best', 'rating', 'reviews', 'experience', 'az']) ?: 'best',
    'page'    => finder_page_no(),
  ];
  if (preg_match('/^[1-9]\d{5}$/', $F['near'])) { $F['pin'] = $F['near']; $F['near'] = ''; }   // a pincode typed in the main box
  if ($F['city'] && !$F['state']) $F['state'] = city_state($F['city']);
  if ($F['city'] && city_state($F['city']) !== $F['state']) $F['city'] = '';
  if ($F['city']) $F['area'] = finder_area($F['city'], $_GET['area'] ?? '');
  return $F;
}
function finder_area($city, $raw) {   // an area must be one of the city's localities
  $raw = is_scalar($raw) ? trim((string) $raw) : '';
  foreach (array_keys(places_db()['cities'][$city]['areas'] ?? []) as $a) if (strcasecmp($a, $raw) === 0) return $a;
  return '';
}
function pro_pins($p) {   // pincodes of the localities a professional covers
  $areas = places_db()['cities'][$p['city']]['areas'] ?? [];
  return array_values(array_unique(array_filter(array_merge([$p['pincode']], array_map(fn($a) => $areas[$a] ?? '', $p['areas'])))));
}
function pin_closeness($p, $pin) {   // shared leading digits with the nearest pincode they cover (6 = same pincode)
  $best = 0;
  foreach (pro_pins($p) as $x) { $n = 0; while ($n < 6 && $x[$n] === $pin[$n]) $n++; $best = max($best, $n); }
  return $best;
}
function pin_label($n) { return [6 => 'Same pincode', 5 => 'Very close', 4 => 'Nearby', 3 => 'Same district', 2 => 'Same region'][$n] ?? ''; }
function pro_haystack($k, $p) {
  static $cache = [];
  $D = pros_db(); $T = trends_db(); $P = places_db();
  return $cache[$k] ??= finder_norm(implode(' ', array_merge(
    [$p['name'], $D['types'][$p['type']]['label'], $D['types'][$p['type']]['plural'], segment_label($p['segment']), $p['pincode']],
    $p['areas'], $p['apartments'], $p['languages'],
    array_map(fn($c) => $P['cities'][$c]['name'] . ' ' . $c . ' ' . state_name($P['cities'][$c]['state']), $p['serves']),
    array_map(fn($s) => $T['types'][$s]['label'] ?? '', $p['services']),
    array_map(fn($r) => $D['reqs'][$r], $p['reqs']),
  )));
}
function pro_matches($p, $F, $skip = '', $key = '') {
  $P = places_db();
  if ($skip !== 'type' && $F['type'] && !in_array($p['type'], $F['type'], true)) return false;
  if ($skip !== 'state' && $skip !== 'city' && $F['state'] && !array_filter($p['serves'], fn($c) => ($P['cities'][$c]['state'] ?? '') === $F['state'])) return false;
  if ($skip !== 'city' && $F['city'] && !in_array($F['city'], $p['serves'], true)) return false;
  if ($F['area'] && !($p['city'] === $F['city'] && in_array($F['area'], $p['areas'], true))) return false;
  if ($F['pin'] && pin_closeness($p, $F['pin']) < ($F['_pin_min'] ?? 3)) return false;
  if ($F['apt'] !== '' && !array_filter($p['apartments'], fn($a) => finder_text_match(finder_norm($a), finder_tokens($F['apt'])))) return false;
  if ($F['rating'] && $p['rating'] < (float) $F['rating']) return false;
  if ($F['reviews'] && $p['reviews'] < (int) $F['reviews']) return false;
  if ($skip !== 'seg' && $F['seg'] && !in_array($p['segment'], $F['seg'], true)) return false;
  if ($skip !== 'req' && $F['req'] && array_diff($F['req'], $p['reqs'])) return false;
  if ($F['does'] && !in_array($F['does'], $p['services'], true)) return false;
  if ($F['near'] !== '' && !finder_text_match(pro_haystack($key, $p), finder_tokens($F['near']))) return false;
  return true;
}
function pros_search(&$F) {
  $all = pros_db()['pros'];
  $hits = array_filter($all, fn($p, $k) => pro_matches($p, $F, '', $k), ARRAY_FILTER_USE_BOTH);
  if ($F['pin'] && !$hits) {   // nobody in or near that pincode: widen to the same postal region and say so
    $F['_pin_min'] = 2;
    $hits = array_filter($all, fn($p, $k) => pro_matches($p, $F, '', $k), ARRAY_FILTER_USE_BOTH);
  }
  $score = fn($p) => $p['rating'] * 20 + log(1 + $p['reviews']) * 4 + (empty($p['sample']) ? 30 : 0) + (!empty($p['verified']) ? 20 : 0);
  uksort($hits, function ($a, $b) use ($hits, $F, $score) {
    $x = $hits[$a]; $y = $hits[$b];
    $near = fn($p) => ($F['pin'] ? pin_closeness($p, $F['pin']) * 10 : 0) + ($F['city'] && $p['city'] === $F['city'] ? 5 : 0) + ($F['area'] && $p['area'] === $F['area'] ? 5 : 0);
    return match ($F['sort']) {
      'rating'     => [$y['rating'], $y['reviews']] <=> [$x['rating'], $x['reviews']],
      'reviews'    => [$y['reviews'], $y['rating']] <=> [$x['reviews'], $x['rating']],
      'experience' => $x['since'] <=> $y['since'],
      'az'         => strcasecmp($x['name'], $y['name']),
      default      => [$near($y), $score($y)] <=> [$near($x), $score($x)],
    };
  });
  $m = 'pro_matches';
  $counts = [
    'type'  => finder_counts($all, $F, 'type', $m, fn($p) => $p['type']),
    'state' => finder_counts($all, $F, 'state', $m, fn($p) => array_values(array_unique(array_map('city_state', $p['serves'])))),
    'city'  => finder_counts($all, $F, 'city', $m, fn($p) => $p['serves']),
    'seg'   => finder_counts($all, $F, 'seg', $m, fn($p) => $p['segment']),
    'req'   => finder_counts($all, $F, 'req', $m, fn($p) => $p['reqs']),
  ];
  return [$hits, $counts];
}
function pro_initials($name) {
  $w = preg_split('/[\s&]+/u', preg_replace('/\b(Interiors?|Studio|Design|Co\.|Works|Contractors|Builders|Carpentry|Workshop|Homes|Spaces|Living)\b/u', '', $name), -1, PREG_SPLIT_NO_EMPTY);
  return mb_strtoupper(mb_substr($w[0] ?? $name, 0, 1) . mb_substr($w[1] ?? '', 0, 1));
}
function pro_avatar($key, $p) {
  $img = media_find($key, '/assets/pros');
  if ($img) return '<span class="pavatar">' . finder_img(['src' => $img['url'], 'webp' => $img['webp'], 'w' => $img['w'] ?: 160, 'h' => $img['h'] ?: 160, 'alt' => $p['name'] . ' logo']) . '</span>';
  $hue = hexdec(substr(md5($key), 0, 2)) * 360 / 255;
  return '<span class="pavatar" style="--hue:' . (int) $hue . '" aria-hidden="true">' . e(pro_initials($p['name'])) . '</span>';
}
function pro_stars($p, $long = false) {
  $note = !empty($p['sample']) ? ' <small>(sample)</small>' : '';
  return '<span class="stars" aria-label="Rated ' . e($p['rating']) . ' out of 5"><span class="stars__fill" style="--r:' . e($p['rating']) . '">★★★★★</span></span> <strong>' . e(number_format($p['rating'], 1)) . '</strong>'
       . ' <span class="muted">(' . (int) $p['reviews'] . ' review' . ($p['reviews'] == 1 ? '' : 's') . ')' . '</span>' . $note;
}
function pro_card($key, $p, $F = []) {
  $D = pros_db(); $url = pro_url($key);
  $near = !empty($F['pin']) ? pin_label(pin_closeness($p, $F['pin'])) : (!empty($F['area']) && $p['area'] === $F['area'] ? 'In ' . $F['area'] : '');
  $reqs = array_slice($p['reqs'], 0, 6);
  $h = '<article class="pcard">'
     . '<div class="pcard__head">' . pro_avatar($key, $p)
     . '<div><p class="pcard__type">' . e($D['types'][$p['type']]['label']) . ' · ' . e(segment_label($p['segment'])) . '</p>'
     . '<h3 class="pcard__title"><a href="' . e($url) . '">' . e($p['name']) . '</a></h3>'
     . '<p class="pcard__place">' . e($p['area'] . ', ' . city_name($p['city']) . ' ' . $p['pincode']) . '</p></div>'
     . ($near ? '<span class="pcard__near">' . e($near) . '</span>' : '') . sample_badge($p) . '</div>'
     . '<p class="pcard__rating">' . pro_stars($p) . '</p>'
     . '<p class="pcard__meta">Since ' . (int) $p['since'] . ' · ' . (int) $p['projects'] . ' projects · ' . ($p['team'] > 1 ? (int) $p['team'] . ' people' : 'Works solo') . ($p['warranty'] ? ' · ' . (int) $p['warranty'] . '-year warranty' : '') . '</p>'
     . '<p class="pcard__price">' . e($p['price']) . '</p>'
     . '<ul class="pcard__reqs">' . implode('', array_map(fn($r) => '<li>' . e($D['reqs'][$r]) . '</li>', $reqs)) . (count($p['reqs']) > 6 ? '<li class="more">+' . (count($p['reqs']) - 6) . '</li>' : '') . '</ul>'
     . '<p class="pcard__serves"><span>Works in</span> ' . e(implode(', ', array_map('city_name', $p['serves']))) . '</p>'
     . '<p class="pcard__serves"><span>Apartments</span> ' . e(implode(', ', array_slice($p['apartments'], 0, 2))) . '</p>'
     . '<div class="pcard__actions"><a class="btn btn--sm btn--outline" href="' . e($url) . '">View profile</a>'
     . enquiry_buttons('pro', $key, $p['name'], '', true) . '</div>'
     . '</article>';
  return $h;
}

/* =====================================================================
   SHARED PIECES: filter widgets, chips, pager, enquiry buttons and dialog
   ===================================================================== */
function f_check($name, $value, $label, $checked, $count = null, $type = 'checkbox') {
  return '<label class="fopt"><input type="' . $type . '" name="' . e($name) . ($type === 'checkbox' ? '[]' : '') . '" value="' . e($value) . '"' . ($checked ? ' checked' : '') . '>'
       . '<span>' . e($label) . '</span>' . ($count !== null ? '<small class="fcount" data-fc="' . e($name . ':' . $value) . '">' . (int) $count . '</small>' : '') . '</label>';
}
function f_group($title, $body, $open = true, $id = '') {
  return '<details class="fgroup"' . ($open ? ' open' : '') . ($id ? ' id="' . e($id) . '"' : '') . '><summary>' . e($title) . '</summary><div class="fgroup__body">' . $body . '</div></details>';
}
function f_select($name, $label, $options, $sel, $any = 'Any', $counts = null, $id = '') {   // $options: value => label
  $h = '<label class="fsel"' . ($id ? ' for="' . e($id) . '"' : '') . '><span>' . e($label) . '</span><select class="input" name="' . e($name) . '"' . ($id ? ' id="' . e($id) . '"' : '') . '><option value="">' . e($any) . '</option>';
  foreach ($options as $v => $l) {
    $n = $counts !== null ? (int) ($counts[$v] ?? 0) : null;
    $h .= '<option value="' . e($v) . '"' . ((string) $v === (string) $sel ? ' selected' : '') . ($n !== null ? ' data-count="' . $n . '"' : '') . '>' . e($l) . ($n !== null ? ' (' . $n . ')' : '') . '</option>';
  }
  return $h . '</select></label>';
}
// state <select> grouped into states and union territories
function f_state_select($sel, $counts, $id) {
  $S = places_db()['states'];
  $h = '<label class="fsel" for="' . $id . '"><span>State or UT</span><select class="input" name="state" id="' . $id . '" data-state-select><option value="">All of India</option>';
  foreach ([false => 'States', true => 'Union territories'] as $ut => $title) {
    $h .= '<optgroup label="' . $title . '">';
    foreach ($S as $k => $s) if ($s['ut'] === (bool) $ut) { $n = (int) ($counts[$k] ?? 0); $h .= '<option value="' . e($k) . '"' . ($k === $sel ? ' selected' : '') . '>' . e($s['name']) . ' (' . $n . ')</option>'; }
    $h .= '</optgroup>';
  }
  return $h . '</select></label>';
}
// city <select>: every city, tagged with its state so the page script can narrow the list
function f_city_select($sel, $counts, $id, $onlyWithItems = true) {
  $C = places_db()['cities'];
  uasort($C, fn($a, $b) => strcmp($a['name'], $b['name']));
  $h = '<label class="fsel" for="' . $id . '"><span>City</span><select class="input" name="city" id="' . $id . '" data-city-select><option value="">All cities</option>';
  foreach ($C as $k => $c) {
    $n = (int) ($counts[$k] ?? 0);
    if ($onlyWithItems && !$n && $k !== $sel) continue;
    $h .= '<option value="' . e($k) . '" data-state="' . e($c['state']) . '"' . ($k === $sel ? ' selected' : '') . '>' . e($c['name']) . ' (' . $n . ')</option>';
  }
  return $h . '</select></label>';
}
// removable chips for the active filters: [label, url without it]
function finder_chips($chips, $clearUrl) {
  if (!$chips) return '';
  $h = '<div class="fchips" aria-label="Active filters">';
  foreach ($chips as [$label, $url]) $h .= '<a class="fchip" href="' . e($url) . '" rel="nofollow">' . e($label) . ' <span aria-hidden="true">×</span><span class="visually-hidden"> (remove)</span></a>';
  return $h . '<a class="fchip fchip--clear" href="' . e($clearUrl) . '" rel="nofollow">Clear all</a></div>';
}
function finder_pager($base, $F, $total, $per) {
  $pages = (int) ceil($total / $per);
  if ($pages < 2) return '';
  $cur = min($F['page'], $pages);
  $h = '<nav class="pager" aria-label="Pages">';
  if ($cur > 1) $h .= '<a href="' . e(finder_url($base, $F, ['page' => $cur - 1])) . '" rel="prev">‹ Previous</a>';
  for ($i = 1; $i <= $pages; $i++) {
    if ($pages > 7 && $i !== 1 && $i !== $pages && abs($i - $cur) > 1) { if (abs($i - $cur) === 2) $h .= '<span>…</span>'; continue; }
    $h .= $i === $cur ? '<span aria-current="page">' . $i . '</span>' : '<a href="' . e(finder_url($base, $F, ['page' => $i])) . '">' . $i . '</a>';
  }
  if ($cur < $pages) $h .= '<a href="' . e(finder_url($base, $F, ['page' => $cur + 1])) . '" rel="next">Next ›</a>';
  return $h . '</nav>';
}

/* Contact and Mail buttons. Without JavaScript they go to the contact page. */
function enquiry_buttons($kind, $key, $name, $about = '', $small = false) {
  $sz = $small ? ' btn--sm' : '';
  $data = ' data-enquiry data-kind="' . e($kind) . '" data-target="' . e($key) . '" data-name="' . e($name) . '" data-about="' . e($about) . '"';
  return '<a class="btn btn--primary' . $sz . '" href="/contact/" rel="nofollow"' . $data . ' data-mode="contact">Contact</a>'
       . '<a class="btn btn--outline' . $sz . '" href="/contact/" rel="nofollow"' . $data . ' data-mode="mail">Mail</a>';
}

/* The enquiry pop-up (printed once per page): details → 6-digit code → sent */
function enquiry_dialog() {
  static $done = false;
  if ($done) return '';
  $done = true;
  $cities = array_map(fn($c) => $c['name'], places_db()['cities']);
  sort($cities);
  $f = fn($n, $label, $input) => '<div class="field"><label for="enq-' . $n . '">' . $label . '</label>' . $input . '<p class="field__error" data-err="' . $n . '" hidden></p></div>';
  ob_start(); ?>
<dialog class="lead-dialog enq" id="enquiry-dialog" aria-labelledby="enq-title">
  <button class="lead-dialog__close" type="button" aria-label="Close" data-enq-close>×</button>
  <div class="lead-card">
    <form class="form enq__step" data-enq-step="details" method="post" action="<?= e(ENQUIRY['endpoint']) ?>" novalidate>
      <p class="form__title" id="enq-title"><span data-enq-verb>Contact</span> <span data-enq-name>the designer</span></p>
      <p class="form__text" data-enq-about hidden></p>
      <div class="enq__modes" role="radiogroup" aria-label="How should they reach you?">
        <label><input type="radio" name="mode" value="contact" checked> Call me back</label>
        <label><input type="radio" name="mode" value="mail"> Send a message</label>
      </div>
      <div class="form__row">
        <?= $f('name', 'Your name', '<input class="input" id="enq-name" name="name" required minlength="2" maxlength="60" autocomplete="name">') ?>
        <?= $f('phone', 'Mobile number', '<input class="input" id="enq-phone" name="phone" type="tel" inputmode="tel" required maxlength="16" placeholder="98765 43210" autocomplete="tel">') ?>
      </div>
      <?= $f('email', 'Email <small>(we send a code to verify it)</small>', '<input class="input" id="enq-email" name="email" type="email" required maxlength="120" autocomplete="email" spellcheck="false">') ?>
      <?= $f('location', 'Your location <small>(city and area)</small>', '<input class="input" id="enq-location" name="location" required minlength="2" maxlength="60" list="enq-cities" autocomplete="address-level2" placeholder="e.g. HSR Layout, Bengaluru">') ?>
      <datalist id="enq-cities"><?php foreach ($cities as $c) echo '<option value="' . e($c) . '">'; ?></datalist>
      <?= $f('message', 'Message <small data-enq-msg-hint>(optional)</small>', '<textarea class="input" id="enq-message" name="message" maxlength="1000" rows="3" placeholder="Your home, rooms, budget and when you want to start"></textarea>') ?>
      <label class="enq__consent"><input type="checkbox" name="consent" value="1" required> <span>Share my details with <span data-enq-name>this firm</span> for this enquiry only. <a href="/privacy/" target="_blank">Privacy</a></span></label>
      <p class="field__error" data-err="consent" hidden></p>
      <input type="hidden" name="action" value="start"><input type="hidden" name="kind" value=""><input type="hidden" name="target" value="">
      <?= lead_hidden_fields('enquiry') ?>
      <button class="btn btn--primary btn--block" type="submit">Send verification code →</button>
      <p class="form__note">We email you a 6-digit code to confirm the address is yours. Nothing is sent to the firm until you enter it.</p>
    </form>
    <form class="form enq__step" data-enq-step="verify" method="post" action="<?= e(ENQUIRY['endpoint']) ?>" hidden novalidate>
      <p class="form__title">Check your email</p>
      <p class="form__text">Enter the 6-digit code we sent to <strong data-enq-email></strong>. It works for <?= (int) ENQUIRY['otp_minutes'] ?> minutes. Check your spam folder if it has not arrived.</p>
      <div class="field"><label for="enq-code">Verification code</label><input class="input enq__code" id="enq-code" name="code" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" required><p class="field__error" data-err="code" hidden></p></div>
      <button class="btn btn--primary btn--block" type="submit">Verify and send →</button>
      <p class="enq__links"><button type="button" class="link-btn" data-enq-resend disabled>Resend code</button> · <button type="button" class="link-btn" data-enq-back>Change details</button></p>
    </form>
    <div class="enq__step enq__done" data-enq-step="done" hidden role="status" tabindex="-1">
      <p class="form__title">✓ Sent</p>
      <p data-enq-done-text></p>
      <button class="btn btn--outline btn--block" type="button" data-enq-close>Close</button>
    </div>
  </div>
</dialog>
<?php
  return ob_get_clean();
}
