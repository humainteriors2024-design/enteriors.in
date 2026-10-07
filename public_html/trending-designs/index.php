<?php
/* =====================================================================
   TRENDING DESIGNS — /trending-designs/
   Listing with filters on the left (location, design type, property type, budget, style),
   a search box (max FINDER['search_words'] words), sorting and pages. One design per page at
   /trending-designs/<key>/ (that page: includes/pages/design.php, routed by .htaccess).
     Designs ......... includes/data/trends.php   (company = a key in includes/data/pros.php)
     Engine .......... includes/finder.php        Settings: config.php → FINDER, ENQUIRY
     Look / scripts .. assets/css/finder.css · assets/js/finder.js (filters) · assets/js/enquiry.js (Contact / Mail)
   Filtering works without JavaScript (the form submits); with it, results update in place.
   ===================================================================== */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
if ($route = finder_route(current_path())) { require $_SERVER['DOCUMENT_ROOT'] . '/includes/pages/design.php'; return; }

$T    = trends_db();
$base = FINDER['designs_url'];
$F    = designs_query();
[$hits, $counts] = designs_search($F);
$total = count($hits);
$per   = FINDER['per_page'];
$F['page'] = min($F['page'], max(1, (int) ceil($total / $per)));
$show  = array_slice($hits, ($F['page'] - 1) * $per, $per, true);
$filtered = finder_has_filters($F);

/* active filters as removable chips */
$chips = [];
$drop = fn($k, $v) => finder_url($base, $F, [$k => array_values(array_diff($F[$k], [$v])), 'page' => 1]);
if ($F['q'] !== '')  $chips[] = ['“' . $F['q'] . '”', finder_url($base, $F, ['q' => '', 'page' => 1])];
if ($F['state'])     $chips[] = [state_name($F['state']), finder_url($base, $F, ['state' => '', 'city' => '', 'page' => 1])];
if ($F['city'])      $chips[] = [city_name($F['city']), finder_url($base, $F, ['city' => '', 'page' => 1])];
foreach ($F['type'] as $v)     $chips[] = [$T['types'][$v]['label'], $drop('type', $v)];
foreach ($F['property'] as $v) $chips[] = [$T['properties'][$v], $drop('property', $v)];
foreach ($F['bhk'] as $v)      $chips[] = [$v === '4' ? '4+ BHK' : "$v BHK", $drop('bhk', $v)];
if ($F['budget'])    $chips[] = [$T['budgets'][$F['budget']][0], finder_url($base, $F, ['budget' => '', 'page' => 1])];
foreach ($F['style'] as $v)    $chips[] = [$T['styles'][$v]['label'], $drop('style', $v)];
if ($F['company'] && ($co = pro($F['company']))) $chips[] = ['By ' . $co['name'], finder_url($base, $F, ['company' => '', 'page' => 1])];

/* the results block (also sent on its own to the page script when filters change) */
$where = $F['city'] ? ' in ' . city_name($F['city']) : ($F['state'] ? ' in ' . state_name($F['state']) : '');
ob_start(); ?>
<?= finder_sample_note('designs') ?>
<div class="fresults__bar">
  <button class="btn btn--outline btn--sm finder-toggle" type="button" data-filter-toggle aria-controls="filters" aria-expanded="false">Filters<?= $chips ? ' (' . count($chips) . ')' : '' ?></button>
  <p class="fresults__count" role="status"><strong><?= $total ?></strong> design<?= $total === 1 ? '' : 's' ?><?= e($where) ?><?= $total > $per ? ' · showing ' . (($F['page'] - 1) * $per + 1) . '–' . min($total, $F['page'] * $per) : '' ?></p>
  <label class="fsort"><span>Sort</span>
    <select class="input" name="sort">
<?php foreach (['new' => 'Newest first', 'budget-low' => 'Budget: low to high', 'budget-high' => 'Budget: high to low', 'az' => 'A to Z'] as $v => $l): ?>
      <option value="<?= $v ?>"<?= $F['sort'] === $v ? ' selected' : '' ?>><?= $l ?></option>
<?php endforeach; ?>
    </select>
  </label>
</div>
<?= finder_chips($chips, $base) ?>
<?php if ($show): ?>
<div class="dgrid">
<?php $i = 0; foreach ($show as $k => $d) echo design_card($k, $d, $i++ > 2); ?>
</div>
<?= finder_pager($base, $F, $total, $per) ?>
<?php else: ?>
<div class="fempty">
  <p class="fempty__title">No designs match all of these filters.</p>
  <p>Remove a filter above, or try a wider search: a city, a room or a style is usually enough.</p>
  <p><a class="btn btn--outline btn--sm" href="<?= e($base) ?>" rel="nofollow">Show all designs</a></p>
</div>
<?php endif;
$resultsHtml = ob_get_clean();

if (($_SERVER['HTTP_X_FINDER'] ?? '') === '1') {   // the page script asked for the results only
  header('Content-Type: application/json; charset=utf-8'); header('Cache-Control: no-store'); header('Vary: X-Finder'); header('X-Robots-Tag: noindex');
  $flat = [];
  foreach ($counts as $facet => $vals) foreach ($vals as $v => $n) $flat["$facet:$v"] = $n;
  echo json_encode(['html' => $resultsHtml, 'counts' => $flat, 'total' => $total], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  exit;
}

/* schema: the designs on this page (real ones only) */
$items = [];
foreach ($show as $k => $d) if (empty($d['sample'])) $items[] = ['@type' => 'ListItem', 'position' => count($items) + 1, 'url' => SITE['url'] . design_url($k), 'name' => $d['title']];

$page = [
  'type'        => 'page',
  'css'         => ['finder'],
  'js'          => ['finder', 'enquiry'],
  'title'       => 'Trending Interior Designs: Ideas from Every State',
  'seo_title'   => 'Trending Interior Designs: Ideas by City, Style and Budget',
  'description' => 'Trending home interior designs from across India: filter by city, room, property and budget, and see the firm, designer and approximate cost of each.',
  'crumb'       => 'Trending Designs',
  'updated'     => $T['checked'],
  'schema_type' => 'CollectionPage',
  'noindex'     => finder_noindex('designs') || $filtered,
  'canonical'   => $F['page'] > 1 && !$filtered ? $base . '?page=' . $F['page'] : $base,
  'schema_extra'=> $items ? [['@type' => 'ItemList', 'name' => 'Trending interior designs', 'itemListElement' => $items]] : [],
  'faq' => [
    'What are trending interior designs?' => 'They are recent home and room projects that show the styles, materials and layouts people are choosing now, from Japandi kitchens and pooja units with jaali doors to full 3 BHK apartments. Each one lists the city, the firm and designer, the property, the style and the approximate budget.',
    'How accurate are the budgets?' => 'Each budget is the approximate cost of that project including GST. Your cost depends on size, materials, brands and city, so use the figure as a reference and get an itemised quote. Our interior cost calculator gives an estimate for your own home.',
    'How do I contact the designer of a design?' => 'Select Contact (to get a call back) or Mail (to send a message) on the design. Enter your name, mobile, email and location; we email you a 6-digit code to confirm the address is yours, and your enquiry is sent once you enter it.',
    'Will my details be shared with anyone else?' => 'Only with the firm you contact, for that enquiry. Your email is verified with a one-time code so firms receive genuine enquiries, and repeated or automated messages are blocked.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
$popular = [['Modular kitchen', ['type' => ['modular-kitchen']]], ['Living room', ['type' => ['living-room']]], ['Pooja room', ['type' => ['pooja-room']]],
            ['2 BHK homes', ['bhk' => ['2']]], ['Under ₹6 lakh', ['budget' => '3-6']], ['Japandi', ['style' => ['japandi']]], ['Bengaluru', ['city' => 'bangalore', 'state' => 'karnataka']]];
$blank = array_map(fn($v) => is_array($v) ? [] : '', $F);
?>
<form class="finder" method="get" action="<?= e($base) ?>" data-finder>
<header class="page-header finder-head section--dark">
  <div class="container">
    <?= component('breadcrumbs', ['crumbs' => $crumbs]) ?>
    <span class="eyebrow mt-6">Trending designs · <?= count($T['designs']) ?> projects</span>
    <h1>Trending interior designs</h1>
    <p class="subheading">Homes and rooms from every state, with the firm, designer, property, style and approximate budget. Filter by location, room, property and budget, or search in up to <?= (int) FINDER['search_words'] ?> words.</p>
    <div class="finder-search" role="search">
      <label for="fq" class="visually-hidden">Search designs</label>
      <input class="finder-search__input" id="fq" name="q" type="search" value="<?= e($F['q']) ?>" maxlength="<?= (int) FINDER['search_chars'] ?>" placeholder="Try: Japandi kitchen Pune" autocomplete="off" data-word-limit="<?= (int) FINDER['search_words'] ?>" aria-describedby="fq-hint">
      <button class="btn btn--primary" type="submit">Search</button>
    </div>
    <p class="finder-search__hint" id="fq-hint" data-word-hint>Up to <?= (int) FINDER['search_words'] ?> words: a city, room, style or budget.</p>
    <div class="finder-popular"><span>Popular:</span>
<?php foreach ($popular as [$label, $over]) echo '<a class="tag tag--pill" href="' . e(finder_url($base, $blank, $over)) . '">' . e($label) . '</a>'; ?>
    </div>
  </div>
</header>

<div class="container finder-layout section">
  <aside class="finder-filters" id="filters" aria-label="Filters">
    <div class="finder-filters__head"><p class="finder-filters__title">Filters</p><a href="<?= e($base) ?>" rel="nofollow">Clear all</a><button class="finder-filters__close" type="button" data-filter-close aria-label="Close filters">×</button></div>
<?php
echo f_group('Location', f_state_select($F['state'], $counts['state'], 'f-state') . f_city_select($F['city'], $counts['city'], 'f-city'));
$h = ''; foreach ($T['types'] as $k => $t) $h .= f_check('type', $k, $t['label'], in_array($k, $F['type'], true), $counts['type'][$k] ?? 0);
echo f_group('Design type', $h);
$h = ''; foreach ($T['properties'] as $k => $l) $h .= f_check('property', $k, $l, in_array($k, $F['property'], true), $counts['property'][$k] ?? 0);
$h .= '<p class="fgroup__sub">Home size</p><div class="fopt-row">';
foreach (['1' => '1 BHK', '2' => '2 BHK', '3' => '3 BHK', '4' => '4+ BHK'] as $k => $l) $h .= f_check('bhk', (string) $k, $l, in_array((string) $k, $F['bhk'], true), $counts['bhk'][$k] ?? 0);
echo f_group('Property type', $h . '</div>');
$h = f_check('budget', '', 'Any budget', $F['budget'] === '', null, 'radio');
foreach ($T['budgets'] as $k => [$l]) $h .= f_check('budget', $k, $l, $F['budget'] === $k, $counts['budget'][$k] ?? 0, 'radio');
echo f_group('Budget', $h);
$h = ''; foreach ($T['styles'] as $k => $s) $h .= f_check('style', $k, $s['label'], in_array($k, $F['style'], true), $counts['style'][$k] ?? 0);
echo f_group('Design style', $h, (bool) $F['style']);
if ($F['company']) echo '<input type="hidden" name="company" value="' . e($F['company']) . '">';
?>
    <button class="btn btn--primary btn--block finder-apply" type="submit">Show designs</button>
  </aside>

  <div class="finder-results" data-results aria-live="polite">
<?= $resultsHtml ?>
  </div>
</div>
</form>

<section class="section section--grey">
  <div class="container">
    <?= section_head('Browse', 'designs', 'By room, city and style') ?>
    <div class="browse">
      <div><p class="browse__title">By design type</p><ul>
<?php foreach ($T['types'] as $k => $t) echo '<li><a href="' . e(finder_url($base, $blank, ['type' => [$k]])) . '">' . e($t['label']) . '</a></li>'; ?>
      </ul></div>
      <div><p class="browse__title">By city</p><ul>
<?php $byCity = array_count_values(array_column($T['designs'], 'city')); arsort($byCity);
      foreach (array_slice($byCity, 0, 16, true) as $c => $n) echo '<li><a href="' . e(finder_url($base, $blank, ['city' => $c, 'state' => city_state($c)])) . '">' . e(city_name($c)) . '</a> <small>' . $n . '</small></li>'; ?>
      </ul></div>
      <div><p class="browse__title">By style</p><ul>
<?php foreach ($T['styles'] as $k => $s) echo '<li><a href="' . e(finder_url($base, $blank, ['style' => [$k]])) . '">' . e($s['label']) . '</a>' . ($s['guide'] && is_live($s['guide']) ? ' · <a class="muted" href="' . e($s['guide']) . '">guide</a>' : '') . '</li>'; ?>
      </ul></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container finder-next">
    <div class="card card--boxed">
      <span class="card__label">Next step</span>
      <h2 class="card__title">Find a designer near you</h2>
      <p class="card__text">Search interior designers, freelancers, contractors and carpenters by city, area, pincode, apartment, reviews and what they offer.</p>
      <p><a class="btn btn--primary btn--sm" href="<?= e(FINDER['pros_url']) ?>">Find a designer →</a></p>
    </div>
    <?= card('/calculators/interior-cost/', 'What would this cost in my home?', 'Estimate your own home by size, finish and city, including GST.', 'Free calculator', variant: 'boxed') ?>
    <?= card('/styles/', 'Not sure which style?', 'Design styles explained, with the materials and colours that suit Indian homes.', 'Style guide', variant: 'boxed') ?>
  </div>
  <div class="container container--text"><?= component('faq') ?></div>
</section>
<?= enquiry_dialog() ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
