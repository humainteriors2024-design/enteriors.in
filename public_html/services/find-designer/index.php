<?php
/* =====================================================================
   FIND A DESIGNER — /services/find-designer/
   Directory of interior designers, freelancers, contractors and carpenters. Find them by
   location (state, city, area), pincode (nearest first), "near me" (browser location, used only
   on the visitor's device), apartment or society, reviews and rating, budget level and what
   they offer (designer, carpenter, warranty, own factory, end-to-end, civil, plumbing,
   electrical, free consultation, 3D design). One profile per professional at
   /services/find-designer/<key>/ (includes/pages/pro.php, routed by .htaccess).
     Professionals ... includes/data/pros.php     Places ... includes/data/places.php
     Engine .......... includes/finder.php        Settings . config.php → FINDER, ENQUIRY
   ===================================================================== */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
if ($route = finder_route(current_path())) { require $_SERVER['DOCUMENT_ROOT'] . '/includes/pages/pro.php'; return; }

$D    = pros_db();
$T    = trends_db();
$base = FINDER['pros_url'];
$F    = pros_query();
[$hits, $counts] = pros_search($F);
$total = count($hits);
$per   = FINDER['per_page'];
$F['page'] = min($F['page'], max(1, (int) ceil($total / $per)));
$show  = array_slice($hits, ($F['page'] - 1) * $per, $per, true);
$filtered = finder_has_filters($F);
$widened  = !empty($F['_pin_min']);
$blank    = array_map(fn($v) => is_array($v) ? [] : '', $F);
unset($blank['_pin_min']);
$segs = ['budget' => 'Budget', 'mid' => 'Mid-range', 'premium' => 'Premium', 'luxury' => 'Luxury'];

/* active filters as removable chips */
$chips = [];
$drop = fn($k, $v) => finder_url($base, $F, [$k => array_values(array_diff($F[$k], [$v])), 'page' => 1, '_pin_min' => null]);
$off  = fn($over) => finder_url($base, $F, $over + ['page' => 1, '_pin_min' => null]);
if ($F['near'] !== '') $chips[] = ['“' . $F['near'] . '”', $off(['near' => ''])];
foreach ($F['type'] as $v) $chips[] = [$D['types'][$v]['plural'], $drop('type', $v)];
if ($F['state']) $chips[] = [state_name($F['state']), $off(['state' => '', 'city' => '', 'area' => ''])];
if ($F['city'])  $chips[] = [city_name($F['city']), $off(['city' => '', 'area' => ''])];
if ($F['area'])  $chips[] = [$F['area'], $off(['area' => ''])];
if ($F['pin'])   $chips[] = ['Pincode ' . $F['pin'], $off(['pin' => ''])];
if ($F['apt'] !== '') $chips[] = ['Apartment: ' . $F['apt'], $off(['apt' => ''])];
if ($F['rating'])  $chips[] = [$F['rating'] . '★ and above', $off(['rating' => ''])];
if ($F['reviews']) $chips[] = [$F['reviews'] . '+ reviews', $off(['reviews' => ''])];
foreach ($F['seg'] as $v) $chips[] = [$segs[$v], $drop('seg', $v)];
foreach ($F['req'] as $v) $chips[] = [$D['reqs'][$v], $drop('req', $v)];
if ($F['does']) $chips[] = ['Does: ' . $T['types'][$F['does']]['label'], $off(['does' => ''])];

$where = $F['area'] ? ' in ' . $F['area'] . ', ' . city_name($F['city']) : ($F['city'] ? ' in ' . city_name($F['city']) : ($F['state'] ? ' in ' . state_name($F['state']) : ''));
$what  = count($F['type']) === 1 ? strtolower($D['types'][$F['type'][0]]['plural']) : 'professionals';
ob_start(); ?>
<?= finder_sample_note('pros') ?>
<div class="fresults__bar">
  <button class="btn btn--outline btn--sm finder-toggle" type="button" data-filter-toggle aria-controls="filters" aria-expanded="false">Filters<?= $chips ? ' (' . count($chips) . ')' : '' ?></button>
  <p class="fresults__count" role="status"><strong><?= $total ?></strong> <?= e($total === 1 ? rtrim($what, 's') : $what) ?><?= e($where) ?><?= $F['pin'] ? ' near ' . e($F['pin']) : '' ?></p>
  <label class="fsort"><span>Sort</span>
    <select class="input" name="sort">
<?php foreach (['best' => $F['pin'] || $F['area'] ? 'Nearest first' : 'Best match', 'rating' => 'Highest rated', 'reviews' => 'Most reviewed', 'experience' => 'Most experienced', 'az' => 'A to Z'] as $v => $l): ?>
      <option value="<?= $v ?>"<?= $F['sort'] === $v ? ' selected' : '' ?>><?= $l ?></option>
<?php endforeach; ?>
    </select>
  </label>
</div>
<?= finder_chips($chips, $base) ?>
<?php if ($widened): ?>
<p class="callout callout--warn">Nobody is listed in or right next to pincode <?= e($F['pin']) ?> yet, so these work in the same postal region. Many work across a whole city: check the areas on each profile.</p>
<?php endif; ?>
<?php if ($show): ?>
<div class="pgrid">
<?php foreach ($show as $k => $p) echo pro_card($k, $p, $F); ?>
</div>
<?= finder_pager($base, $F, $total, $per) ?>
<?php else: ?>
<div class="fempty">
  <p class="fempty__title">No professionals match all of these filters.</p>
  <p>Remove a requirement or two, widen the location to the city, or try a nearby pincode.</p>
  <p><a class="btn btn--outline btn--sm" href="<?= e($base) ?>" rel="nofollow">Show everyone</a></p>
</div>
<?php endif;
$resultsHtml = ob_get_clean();

if (($_SERVER['HTTP_X_FINDER'] ?? '') === '1') {   // the page script asked for the results only
  header('Content-Type: application/json; charset=utf-8'); header('Cache-Control: no-store'); header('Vary: X-Finder'); header('X-Robots-Tag: noindex');
  $flat = [];
  foreach ($counts as $facet => $vals) foreach ($vals as $v => $n) $flat["$facet:$v"] = $n;
  $areas = $F['city'] ? array_keys(places_db()['cities'][$F['city']]['areas']) : [];
  echo json_encode(['html' => $resultsHtml, 'counts' => $flat, 'total' => $total, 'areas' => $areas, 'area' => $F['area']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  exit;
}

$page = [
  'type'        => 'page',
  'css'         => ['finder'],
  'js'          => ['finder', 'enquiry'],
  'title'       => 'Find an Interior Designer Near You',
  'seo_title'   => 'Find an Interior Designer or Contractor Near You',
  'description' => 'Find interior designers, freelancers, contractors and carpenters by area, pincode, apartment and reviews, and filter by budget, warranty and services.',
  'crumb'       => 'Find a Designer',
  'updated'     => $D['checked'],
  'schema_type' => 'CollectionPage',
  'noindex'     => finder_noindex('pros') || $filtered,
  'canonical'   => $F['page'] > 1 && !$filtered ? $base . '?page=' . $F['page'] : $base,
  'faq' => [
    'How do I find an interior designer near me?' => 'Type your area, apartment or 6-digit pincode in the search box, or select "Use my location". Results show who works closest first, with how near they are, the areas they cover, reviews, warranty and what they offer.',
    'Should I hire an interior designer, a freelancer or a contractor?' => 'A design firm designs and builds the whole interior under one contract. A freelance designer designs one-to-one and you hire the carpenter or contractor. A contractor or carpenter builds to drawings you already have. For a full home, a firm or a freelancer with a trusted team is usually easiest.',
    'What do the requirement filters mean?' => '"Designer" means they design, "Carpenter" that they have their own carpentry team, "Own factory" that kitchens and wardrobes are made in their own unit, "End-to-end" that they handle everything from design to handover, and "Civil", "Plumbing" and "Electrical" that they do that work themselves. "Free consultation" means the first meeting is free.',
    'How do I contact a professional?' => 'Select Contact for a call back or Mail to send a message. We email you a 6-digit code to confirm your address, then send your enquiry. Your details go only to the professional you chose.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';

// cities with someone listed, and their coordinates, for "use my location" (worked out in the browser only)
$C = places_db()['cities'];
$served = array_unique(array_merge(...array_map(fn($p) => $p['serves'], array_values($D['pros']))));
$geo = [];
foreach ($served as $c) $geo[$c] = [$C[$c]['lat'], $C[$c]['lng'], $C[$c]['name'], $C[$c]['state']];
$apts = array_unique(array_merge(...array_map(fn($p) => $p['apartments'], array_values($D['pros']))));
sort($apts);
$tabs = ['' => 'All', 'designer' => 'Interior designers', 'freelancer' => 'Freelancers', 'contractor' => 'Contractors', 'carpenter' => 'Carpenters'];
$tabType = count($F['type']) === 1 ? $F['type'][0] : '';
?>
<form class="finder" method="get" action="<?= e($base) ?>" data-finder>
<header class="page-header finder-head section--dark">
  <div class="container">
    <?= component('breadcrumbs', ['crumbs' => $crumbs]) ?>
    <span class="eyebrow mt-6">Find a designer · <?= count($D['pros']) ?> professionals</span>
    <h1>Find the right interior designer</h1>
    <p class="subheading">Designers, freelancers, contractors and carpenters near you. Search by area, pincode or apartment, then narrow down by budget, reviews and what you need done.</p>
    <nav class="finder-tabs" aria-label="Type of professional">
<?php foreach ($tabs as $v => $l) echo '<a href="' . e(finder_url($base, $F, ['type' => $v === '' ? [] : [$v], 'page' => 1, '_pin_min' => null])) . '"' . ($tabType === $v && (count($F['type']) <= 1) ? ' aria-current="page"' : '') . '>' . e($l) . '</a>'; ?>
    </nav>
    <div class="finder-search" role="search">
      <label for="fnear" class="visually-hidden">City, area, pincode or apartment</label>
      <input class="finder-search__input" id="fnear" name="near" type="search" value="<?= e($F['near']) ?>" maxlength="<?= (int) FINDER['search_chars'] ?>" placeholder="Area, pincode or apartment" autocomplete="off" data-word-limit="<?= (int) FINDER['search_words'] ?>" aria-describedby="fnear-hint">
      <button class="btn btn--outline finder-near" type="button" data-near-me data-cities="<?= e(json_encode($geo, JSON_UNESCAPED_UNICODE)) ?>">◎ Use my location</button>
      <button class="btn btn--primary" type="submit">Search</button>
    </div>
    <p class="finder-search__hint" id="fnear-hint" data-word-hint>Up to <?= (int) FINDER['search_words'] ?> words. Your location is used only on your device, to pick the nearest city.</p>
    <div class="finder-popular"><span>Find by:</span>
      <a class="tag tag--pill" href="#f-city" data-focus="f-state">Location</a>
      <a class="tag tag--pill" href="#f-pin" data-focus="f-pin">Pincode</a>
      <a class="tag tag--pill" href="#f-area" data-focus="f-area">Area</a>
      <a class="tag tag--pill" href="#f-apt" data-focus="f-apt">Apartment</a>
      <a class="tag tag--pill" href="<?= e(finder_url($base, $F, ['sort' => 'rating', 'rating' => '4', 'page' => 1, '_pin_min' => null])) ?>" rel="nofollow">Reviews</a>
      <a class="tag tag--pill" href="<?= e(finder_url($base, $F, ['req' => array_values(array_unique(array_merge($F['req'], ['free-consultation']))), 'page' => 1, '_pin_min' => null])) ?>" rel="nofollow">Free consultation</a>
    </div>
  </div>
</header>

<div class="container finder-layout section">
  <aside class="finder-filters" id="filters" aria-label="Filters">
    <div class="finder-filters__head"><p class="finder-filters__title">Filters</p><a href="<?= e($base) ?>" rel="nofollow">Clear all</a><button class="finder-filters__close" type="button" data-filter-close aria-label="Close filters">×</button></div>
<?php
$h = ''; foreach ($D['types'] as $k => $t) $h .= f_check('type', $k, $t['plural'], in_array($k, $F['type'], true), $counts['type'][$k] ?? 0);
echo f_group('Who are you looking for?', $h);

$areaSel = '<label class="fsel" for="f-area"><span>Area or locality</span><select class="input" name="area" id="f-area" data-area-select' . ($F['city'] ? '' : ' disabled') . '><option value="">' . ($F['city'] ? 'All areas' : 'Choose a city first') . '</option>';
if ($F['city']) foreach (array_keys($C[$F['city']]['areas']) as $a) $areaSel .= '<option' . ($a === $F['area'] ? ' selected' : '') . '>' . e($a) . '</option>';
$areaSel .= '</select></label>';
$pin = '<label class="fsel" for="f-pin"><span>Pincode <small>(nearest first)</small></span><input class="input" id="f-pin" name="pin" inputmode="numeric" pattern="[1-9][0-9]{5}" maxlength="6" value="' . e($F['pin']) . '" placeholder="e.g. 560102" autocomplete="postal-code"></label>';
echo f_group('Location', f_state_select($F['state'], $counts['state'], 'f-state') . f_city_select($F['city'], $counts['city'], 'f-city') . $areaSel . $pin, true, 'f-city-group');

$apt = '<label class="fsel" for="f-apt"><span>Apartment or society</span><input class="input" id="f-apt" name="apt" list="f-apt-list" maxlength="60" value="' . e($F['apt']) . '" placeholder="e.g. Juniper Heights" autocomplete="off"></label><datalist id="f-apt-list">';
foreach ($apts as $a) $apt .= '<option value="' . e($a) . '">';
echo f_group('Apartment', $apt . '</datalist><p class="fgroup__sub">Professionals who have worked in your building or society.</p>');

$h = f_check('rating', '', 'Any rating', $F['rating'] === '', null, 'radio');
foreach (['4.5' => '4.5★ and above', '4' => '4★ and above', '3.5' => '3.5★ and above'] as $v => $l) $h .= f_check('rating', $v, $l, $F['rating'] === $v, null, 'radio');
$h .= '<p class="fgroup__sub">Number of reviews</p>' . f_check('reviews', '', 'Any', $F['reviews'] === '', null, 'radio');
foreach (['10' => '10 or more', '50' => '50 or more', '100' => '100 or more'] as $v => $l) $h .= f_check('reviews', $v, $l, $F['reviews'] === $v, null, 'radio');
echo f_group('Reviews', $h);

$h = ''; foreach ($segs as $k => $l) $h .= f_check('seg', $k, $l, in_array($k, $F['seg'], true), $counts['seg'][$k] ?? 0);
echo f_group('Budget level', $h);
$h = ''; foreach ($D['reqs'] as $k => $l) $h .= f_check('req', $k, $l, in_array($k, $F['req'], true), $counts['req'][$k] ?? 0);
echo f_group('Your requirements', $h . '<p class="fgroup__sub">Shows only those who offer every ticked item.</p>');
echo f_group('Works on', f_select('does', 'Type of work', array_map(fn($t) => $t['label'], $T['types']), $F['does'], 'Any work', null, 'f-does'), (bool) $F['does']);
?>
    <button class="btn btn--primary btn--block finder-apply" type="submit">Show results</button>
  </aside>

  <div class="finder-results" data-results aria-live="polite">
<?= $resultsHtml ?>
  </div>
</div>
</form>

<section class="section section--grey">
  <div class="container">
    <?= section_head('Before you', 'hire', 'Five checks that save money') ?>
    <ol class="steps finder-steps">
      <li><strong>See finished work</strong>Visit one completed home, ideally in a building like yours.</li>
      <li><strong>Compare like for like</strong>Ask two or three for an itemised quote on the same scope, with board, laminate and hardware brands named.</li>
      <li><strong>Check the workshop</strong>Own factory or local carpenter: see where your furniture will be made.</li>
      <li><strong>Get the warranty in writing</strong>What it covers (boxes, shutters, hardware), for how long, and who to call.</li>
      <li><strong>Link payments to progress</strong>Pay in stages tied to delivery and installation, never most of it up front.</li>
    </ol>
    <div class="grid grid--lg mt-8">
      <?= card('/planning/how-to-choose-interior-designer/', 'How to choose an interior designer', 'The full checklist, questions to ask and red flags.', 'Guide', variant: 'boxed') ?>
      <?= card('/interior-designer-near-me/', 'Established firms by city', 'Researched lists of interior firms in 20 cities, with addresses and segments.', 'City guides', variant: 'boxed') ?>
      <?= card(FINDER['designs_url'], 'Trending designs', 'See homes and rooms from every state, with the firm and approximate budget.', 'Ideas', variant: 'boxed') ?>
    </div>
  </div>
</section>
<section class="section">
  <div class="container container--text"><?= component('faq') ?></div>
</section>
<?= enquiry_dialog() ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
