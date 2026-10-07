<?php
/* =====================================================================
   HOME PAGE — layout only.
     Words, prices and section lists .... includes/data/home.php
     Pillars, calculators, search list ... includes/nav.php (read automatically)
     Phone, facts, areas, forms .......... includes/config.php
     Photos ............................... /assets/pages/home/  (see the note in data/home.php)
   Styles: home.css + tool.css (estimator) + finder.css (trending designs, find a designer).
   Scripts: home.js (search), calc.js (estimator, worked out on the server), finder.js (photo switcher on design cards).
   ===================================================================== */
$page = [
  'type'        => 'home',
  'title'       => 'Enteriors: Home Interior Guides, Costs and Calculators',
  'description' => 'Plan home interiors with confidence: guides to modular kitchens, wardrobes, materials and costs for Indian homes, free calculators and a free consultation.',
  'updated'     => '2026-10-03',
  'css'         => ['tool', 'finder'],
  'js'          => ['home', 'calc', 'finder'],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/data/home.php';
$hero    = $HOME['hero'];
$homeDir = MEDIA['page_dir'] . '/home';
$tier    = fn($n) => array_filter($HUBS, fn($h0) => ($h0['tier'] ?? 0) === $n);
$topics  = fn($h0) => array_slice(array_column($h0['groups'][0]['links'] ?? [], 'label'), 0, 3);   // three topic tags per pillar

// Search suggestions = every live page in the menu, plus blog posts
$suggest = [];
foreach ($HUBS as $h0) {
  if (is_live($h0['href'])) $suggest[$h0['href']] = [$h0['label'], 'Guide'];
  foreach ($h0['groups'] as $g) foreach (live_links($g['links']) as $l) $suggest[$l['href']] ??= [$l['label'], $h0['label']];
}
foreach (posts() as $po) $suggest[$po['url']] = [$po['title'], 'Blog'];
?>

<!-- ============ 1. HERO ============ -->
<section class="hero section--dark">
  <div class="container hero__grid">
    <div>
      <span class="hero__badge"><?= e($hero['badge']) ?></span>
      <h1 class="hero__title"><?= $hero['title'] ?></h1>
      <p class="subheading mb-6"><?= e($hero['text']) ?></p>

      <form class="search" role="search" action="/" onsubmit="return false" data-search>
        <div class="search__bar">
          <label for="q" class="visually-hidden">Search guides</label>
          <input class="search__input" id="q" type="search" placeholder="Search kitchen cost, plywood, wardrobe sizes…" autocomplete="off">
          <button class="search__btn" type="submit">Search</button>
        </div>
        <ul class="search__list">
<?php foreach ($suggest as $href => [$label, $group]): ?>
          <li><a href="<?= e($href) ?>"><?= e($label) ?> <small><?= e($group) ?></small></a></li>
<?php endforeach; ?>
        </ul>
      </form>

      <div class="hero__pills">
<?php foreach ($hero['pills'] as [$label, $href]) if (is_live($href)) echo '<a class="tag tag--pill" href="' . e($href) . '">' . e($label) . '</a>'; ?>
      </div>

      <div class="hero__cta">
        <a class="btn btn--primary" href="<?= e(SITE['cta']['href']) ?>"><?= e(SITE['cta']['label']) ?></a>
        <a class="btn btn--outline" href="<?= e(SITE['cta2']['href']) ?>" data-open-lead><?= e(SITE['cta2']['label']) ?></a>
      </div>

      <div class="hero__stats">
<?php foreach (STATS as $s): ?>
        <div><p class="stat__num"><?= e($s['num']) ?><span><?= e($s['suffix']) ?></span></p><p class="stat__label"><?= e($s['label']) ?></p></div>
<?php endforeach; ?>
      </div>
    </div>

    <div class="mosaic">
<?php foreach ($hero['mosaic'] as [$t, $sub, $icon, $href, $bg, $photo]) echo tile($href, $t, $sub, tile_art($icon, $photo, $homeDir), $bg); ?>
    </div>
  </div>
</section>

<!-- ============ 2. MARQUEE ============ -->
<div class="marquee" aria-hidden="true">
  <div class="marquee__track">
<?php foreach (array_merge($HOME['marquee'], $HOME['marquee']) as $m) echo '<span class="marquee__item">' . e($m) . '</span>'; ?>
  </div>
</div>

<!-- ============ 3. FACTS (config.php → FACTS; hidden while blank) ============ -->
<?= component('facts') ?>

<!-- ============ 4. THE FIVE BIG DECISIONS (tier-1 pillars) ============ -->
<section class="section">
  <div class="container">
    <?= section_head('Start with the', 'big decisions', 'Where most of the budget goes') ?>
    <div class="grid grid--lined" style="--min: 220px">
<?php foreach ($tier(1) as $h0) echo card($h0['href'], $h0['label'], $h0['blurb'], icon: $h0['icon'], tags: $topics($h0), meta: 'Read the guide →', always: true); ?>
    </div>
    <div class="mt-8"><?= component('lead-form', ['variant' => 'inline', 'id' => 'home-callback', 'title' => 'Prefer to talk it through?', 'text' => 'Leave your number and an interior expert will call you back.']) ?></div>
  </div>
</section>

<!-- ============ 4b. TRENDING DESIGNS (includes/data/trends.php; 'trending' => true first, then newest) ============ -->
<?php
$TD = trends_db();
$homeDesigns = $TD['designs'];
uasort($homeDesigns, fn($a, $b) => [(int) !empty($b['trending']), $b['added']] <=> [(int) !empty($a['trending']), $a['added']]);
$homeDesigns = array_slice($homeDesigns, 0, 8, true);
$designTypes = ['modular-kitchen', 'full-home', 'living-room', 'master-bedroom', 'kids-room', 'wardrobe', 'pooja-room', 'false-ceiling', 'bathroom', 'villa'];
?>
<section class="section section--grey" id="trending-designs">
  <div class="container">
    <?= section_head('Trending', 'designs', 'Homes and rooms from every state', FINDER['designs_url'], 'All ' . count($TD['designs']) . ' designs') ?>
    <div class="home-trend-types">
<?php foreach ($designTypes as $k) echo '<a class="tag tag--pill" href="' . e(finder_url(FINDER['designs_url'], ['type' => [$k]])) . '">' . e($TD['types'][$k]['label']) . '</a>'; ?>
    </div>
    <div class="dgrid dgrid--compact">
<?php foreach ($homeDesigns as $k => $d) echo design_card($k, $d, true, true); ?>
    </div>
    <p class="mt-6"><a class="btn btn--outline" href="<?= e(FINDER['designs_url']) ?>">Browse trending designs by city, style and budget →</a></p>
  </div>
</section>

<!-- ============ 4c. FIND AN INTERIOR DESIGNER (searches /services/find-designer/) ============ -->
<section class="section section--dark" id="find-designer" data-cta-zone="home-finder">
  <div class="container home-finder">
    <div>
      <span class="eyebrow">Find a designer</span>
      <h2 class="section-title mt-4">Find the right <em>interior designer</em></h2>
      <p class="subheading mt-4">Interior designers, freelancers, contractors and carpenters near you. Search by area, pincode or apartment, then compare reviews, budget level, warranty and what they do.</p>
      <ul class="ticks mt-6">
        <li>Nearest first when you search by pincode or area</li>
        <li>Filter by warranty, own factory, end-to-end, civil, plumbing and electrical work</li>
        <li>Contact them directly after a quick email check: your details go only to them</li>
      </ul>
      <div class="home-finder__links">
<?php foreach (['designer' => 'Interior designers', 'freelancer' => 'Freelancers', 'contractor' => 'Contractors', 'carpenter' => 'Carpenters'] as $k => $l) echo '<a href="' . e(finder_url(FINDER['pros_url'], ['type' => [$k]])) . '">' . e($l) . ' →</a>'; ?>
      </div>
    </div>
    <form class="home-finder__form" method="get" action="<?= e(FINDER['pros_url']) ?>">
      <div class="home-finder__row">
        <div class="field"><label for="hf-type">Looking for</label>
          <select class="input" id="hf-type" name="type"><option value="">Anyone</option><option value="designer">Interior designer</option><option value="freelancer">Freelance designer</option><option value="contractor">Contractor</option><option value="carpenter">Carpenter</option></select></div>
        <div class="field"><label for="hf-near">Where</label>
          <input class="input" id="hf-near" name="near" type="search" maxlength="<?= (int) FINDER['search_chars'] ?>" data-word-limit="<?= (int) FINDER['search_words'] ?>" placeholder="Area, pincode or apartment" autocomplete="off"></div>
      </div>
      <div class="field"><label>Your requirements <small>(optional)</small></label>
        <div class="home-finder__chips">
<?php foreach (['budget' => 'Budget', 'mid' => 'Mid-range', 'premium' => 'Premium', 'luxury' => 'Luxury'] as $k => $l) echo '<label><input type="checkbox" name="seg[]" value="' . $k . '"><span>' . e($l) . '</span></label>';
      foreach (pros_db()['reqs'] as $k => $l) if ($k !== '3d-design') echo '<label><input type="checkbox" name="req[]" value="' . e($k) . '"><span>' . e($l) . '</span></label>'; ?>
        </div>
      </div>
      <p class="finder-search__hint" data-word-hint>Up to <?= (int) FINDER['search_words'] ?> words, e.g. "Whitefield" or "560102".</p>
      <button class="btn btn--primary btn--block" type="submit">Find designers →</button>
    </form>
  </div>
</section>

<!-- ============ 5. COST ESTIMATOR ============ -->
<section class="section section--dark section--panel" id="calculator">
  <div class="container">
    <?= section_head('What will your home', 'cost?', 'Interior cost estimator', '/calculators/interior-cost/', 'Full calculator') ?>
    <?= component('estimator', ['compact' => true]) ?>
  </div>
</section>

<!-- ============ 6. PRICE SNAPSHOT ============ -->
<section class="section">
  <div class="container">
    <?= section_head('Interior cost in', 'Bangalore', 'Price snapshot · ' . date('M Y', strtotime($page['updated'])), '/cost/', 'Full cost guide') ?>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Home</th><th>Typical carpet area</th><th class="num">Essential</th><th class="num">Standard</th><th class="num">Premium</th></tr></thead>
      <tbody>
<?php foreach ($HOME['costs'] as $home => [$area, $ess, $std, $prem, $url]): ?>
        <tr><td><?= is_live($url) ? '<a href="' . e($url) . '">' . e($home) . ' interior cost</a>' : e($home) ?></td><td><?= e($area) ?></td><td class="num"><?= e($ess) ?></td><td class="num"><?= e($std) ?></td><td class="num"><?= e($prem) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <p class="table-note mt-4">Indicative, including GST, for kitchen, wardrobes, TV unit, false ceiling, painting, lighting and curtains. Loose furniture, flooring and bathrooms are extra. Hosur is usually 5–10% lower.</p>
  </div>
</section>

<!-- ============ 7. MORE GUIDES (tier-2 and tier-3 pillars) ============ -->
<section class="section section--grey">
  <div class="container">
    <?= section_head('Go', 'deeper', 'Materials, styles, rooms and planning') ?>
    <div class="grid grid--lined grid--sm">
<?php foreach (array_merge($tier(2), $tier(3)) as $h0) echo card($h0['href'], $h0['label'], $h0['blurb'], icon: $h0['icon'], always: true); ?>
    </div>
  </div>
</section>

<!-- ============ 8. MATERIALS LIBRARY (tabs) ============ -->
<section class="section section--dark">
  <div class="container">
    <?= section_head('Materials', 'library', 'Grades, uses and price bands', '/materials/', 'Materials guide') ?>
    <div class="tabs" role="tablist" aria-label="Material groups">
<?php $i = 0; foreach ($HOME['materials'] as $tab => $items): ?>
      <button class="tabs__btn" role="tab" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="mat-<?= $i ?>"><?= e($tab) ?></button>
<?php $i++; endforeach; ?>
    </div>
<?php $i = 0; foreach ($HOME['materials'] as $tab => $items): ?>
    <div class="grid grid--sm" role="tabpanel" id="mat-<?= $i ?>"<?= $i ? ' hidden' : '' ?>>
<?php foreach ($items as [$name, $use, $price, $unit, $tags, $href]) echo card($href, $name, $use, price: e($price) . '<small> ' . e($unit) . '</small>', tags: $tags, variant: 'serif', always: true); ?>
    </div>
<?php $i++; endforeach; ?>
    <p class="mt-6 muted">Indicative Bengaluru prices, <?= date('F Y', strtotime($page['updated'])) ?>. Brand, grade and site conditions change the installed cost.</p>
  </div>
</section>

<!-- ============ 9. HOW TO USE ENTERIORS ============ -->
<section class="section">
  <div class="container">
    <?= section_head('From first idea to', 'handover', 'How to use this site') ?>
    <div class="grid grid--lined">
<?php foreach ($HOME['steps'] as $n => [$t, $txt, $href, $link]) echo card(is_live($href) ? $href : '', $t, $txt, count: sprintf('%02d', $n + 1), meta: is_live($href) ? $link . ' →' : '', always: true); ?>
    </div>
  </div>
</section>

<!-- ============ 10. ROOM GUIDES ============ -->
<section class="section section--grey">
  <div class="container">
    <?= section_head('Room', 'guides', 'Room by room', '/rooms/', 'All rooms') ?>
    <div class="grid grid--lined" style="--min: 270px">
<?php foreach ($HOME['rooms'] as [$t, $txt, $icon, $href, $tags]) echo card($href, $t, $txt, icon: $icon, tags: $tags, always: true); ?>
    </div>
  </div>
</section>

<!-- ============ 11. DESIGN STYLES ============ -->
<section class="section section--dark">
  <div class="container">
    <?= section_head('Design', 'styles', 'Find your look', '/styles/', 'All styles') ?>
    <div class="grid" style="--min: 270px">
<?php foreach ($HOME['styles'] as [$t, $txt, $icon, $href, $bg, $photo]) echo tile($href, $t, $txt, tile_art($icon, $photo, $homeDir), $bg); ?>
    </div>
  </div>
</section>

<!-- ============ 12. COMPARISONS ============ -->
<section class="section">
  <div class="container">
    <?= section_head('Side by', 'side', 'Comparisons', '/compare/', 'All comparisons') ?>
    <div class="grid grid--lined grid--lg">
<?php foreach ($HOME['compare'] as [$t, $txt, $href]) echo card($href, $t, $txt, label: 'Compare', always: true); ?>
    </div>
  </div>
</section>

<!-- ============ 13. CALCULATORS (from nav.php) ============ -->
<section class="section section--grey">
  <div class="container">
    <?= section_head('Free', 'calculators', 'No signup', '/calculators/', 'All calculators') ?>
    <div class="grid grid--lined grid--sm">
<?php foreach (hub('calculators')['groups'][0]['links'] as $l) echo card($l['href'], $l['label'], $HOME['tools'][$l['href']] ?? '', icon: '🧮', meta: 'Free', always: true); ?>
    </div>
  </div>
</section>

<!-- ============ 14. TRENDS ============ -->
<section class="section">
  <div class="container">
    <?= section_head('Trends', '2026', 'What is new, and what will last', '/trends/', 'Trends guide') ?>
    <div class="grid grid--lg">
<?php foreach ($HOME['trends'] as [$label, $t, $txt, $href]) echo card($href, $t, $txt, label: $label, variant: 'accent', always: true); ?>
    </div>
  </div>
</section>

<!-- ============ 15. FROM THE BLOG (newest posts from posts-data.php) ============ -->
<?php if ($latest = posts(limit: 3)): ?>
<section class="section section--grey">
  <div class="container">
    <?= section_head('From the', 'blog', 'Ideas and how-tos', '/blogs/', 'All articles') ?>
    <div class="grid grid--lg">
<?php foreach ($latest as $po) echo component('post-card', ['post' => $po]); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 16. REVIEWS (hidden until real reviews are added in config.php) ============ -->
<?= component('reviews') ?>

<!-- ============ 17. AREAS SERVED (config.php → AREAS) ============ -->
<section class="section section--tight">
  <div class="container">
    <?= section_head('Consultations in', 'your area', 'Where we work') ?>
    <div class="grid grid--lg">
<?php foreach (AREAS as $city => [$url, $localities]): ?>
      <div class="card card--boxed">
        <h3 class="card__title"><?= is_live($url) ? '<a href="' . e($url) . '">Interior designers in ' . e($city) . '</a>' : 'Interior designers in ' . e($city) ?></h3>
        <p class="card__text"><?= e(implode(' · ', $localities)) ?></p>
      </div>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 18. QUESTIONS ============ -->
<section class="section section--grey section--tight">
  <div class="container container--text">
    <?= component('faq', ['items' => $HOME['faq'], 'title' => 'Common questions']) ?>
  </div>
</section>

<!-- ============ 19. LEAD FORM ============ -->
<?= component('lead-form', ['variant' => 'full', 'id' => 'get-quote']) ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
