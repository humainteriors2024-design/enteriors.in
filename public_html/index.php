<?php
/* =====================================================================
   HOME PAGE — layout only.
     Words, prices and section lists .... includes/data/home.php
     Pillars, calculators, search list ... includes/nav.php (read automatically)
     Phone, facts, areas, forms .......... includes/config.php
     Photos ............................... /assets/pages/home/  (see the note in data/home.php)
   Styles: home.css + tool.css (estimator). Scripts: home.js (search), calc.js (estimator, worked out on the server).
   ===================================================================== */
$page = [
  'type'        => 'home',
  'title'       => 'Enteriors: Home Interior Guides, Costs and Calculators',
  'description' => 'Plan home interiors with confidence: guides to modular kitchens, wardrobes, materials and costs for Indian homes, free calculators and a free consultation.',
  'updated'     => '2026-10-03',
  'css'         => ['tool'],
  'js'          => ['home', 'calc'],
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
        <p class="card__text"><?= implode(' · ', array_map('locality_link', $localities)) ?></p>
      </div>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 17b. EXECUTION PARTNER (config.php → PARTNER; links built in includes/partner.php) ============ -->
<section class="section section--dark section--tight" id="execution-partner">
  <div class="container partner-panel">
    <div>
      <span class="eyebrow">Execution partner · South-East Bengaluru</span>
      <h2 class="section-title">Read here. <em>Build with Huma.</em></h2>
      <p class="subheading">Enteriors explains the decisions; our execution partner builds them. <?= huma('chandapura', 'Huma Interiors, interior designers in Chandapura') ?>, has designed, manufactured and installed modular kitchens, wardrobes and full home interiors from its own Chandapura factory since <?= e(PARTNER['since']) ?>, for homes across Electronic City, Bommasandra, Hebbagodi, Attibele and Hosur Road.</p>
      <div class="cluster mt-6" style="--gap: var(--sp-3)">
        <?= huma('home', 'Visit humainteriors.com →', follow: false, class: 'btn btn--primary') ?>
<?php if (is_live(PARTNER['page'])): ?>
        <a class="btn btn--outline" href="<?= e(PARTNER['page']) ?>">How the partnership works</a>
<?php endif; ?>
      </div>
    </div>
    <div>
      <ul class="ticks">
<?php foreach (PARTNER['promises'] as $pr): ?>
        <li><?= e(ucfirst($pr)) ?></li>
<?php endforeach; ?>
        <li>Own <?= e(PARTNER['factory']) ?> factory in Chandapura: kitchens, wardrobes and TV units built in-house</li>
      </ul>
      <p class="partner-panel__note mt-4">Local guides: <?= implode(' · ', array_map('locality_link', array_keys(LOCALITY_PAGES))) ?><?= is_live('/modular-kitchen/electronic-city-chandapura/') ? ' · <a href="/modular-kitchen/electronic-city-chandapura/">modular kitchens near Electronic City</a>' : '' ?>. <?= e(PARTNER['disclosure']) ?></p>
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
