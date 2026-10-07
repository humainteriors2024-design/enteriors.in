<?php
/* =====================================================================
   ONE PROFESSIONAL — /services/find-designer/<key>/  (shown by services/find-designer/index.php)
   About, key facts, what they offer, areas and apartments, their trending designs, reviews,
   Contact / Mail (OTP-verified) and others nearby. Data: includes/data/pros.php.
   Optional logo: /assets/pros/<key>.jpg (or .png/.webp), square.
   ===================================================================== */
[, $key, $exists] = $route;
if (!$exists) { require $_SERVER['DOCUMENT_ROOT'] . '/404.php'; return; }
if (!str_ends_with(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '', '/')) { header('Location: ' . pro_url($key), true, 301); exit; }

$D = pros_db(); $T = trends_db(); $P = places_db();
$p = pro($key);
$c = $P['cities'][$p['city']];
$real = empty($p['sample']);
$type = $D['types'][$p['type']];
$designs = array_filter($T['designs'], fn($d) => $d['company'] === $key);
uasort($designs, fn($a, $b) => strcmp($b['added'], $a['added']));
$desc = $p['name'] . ': ' . strtolower($type['label']) . ' in ' . $p['area'] . ', ' . $c['name'] . '. ' . segment_label($p['segment']) . ' budgets, ' . (int) $p['projects'] . ' projects since ' . (int) $p['since'] . '. See their work and contact them.';

$page = [
  'type'          => 'page',
  'css'           => ['finder'],
  'js'            => ['finder', 'enquiry'],
  'title'         => $p['name'] . ', ' . $type['label'] . ' in ' . $c['name'],
  'seo_title'     => $p['name'] . ' · ' . $type['label'] . ' in ' . $p['area'] . ', ' . $c['name'],
  'description'   => mb_strlen($desc) > 158 ? rtrim(mb_substr($desc, 0, 155), ' ,.') . '…' : $desc,
  'crumb'         => $p['name'],
  'updated'       => $D['checked'],
  'noindex'       => !$real && !FINDER['index_samples'],
  'no_media_note' => true,
  'schema_type'   => 'ProfilePage',
  'schema_extra'  => $real ? [array_filter([
    '@type' => 'HomeAndConstructionBusiness', 'name' => $p['name'], 'url' => SITE['url'] . pro_url($key), 'description' => $p['about'],
    'address' => ['@type' => 'PostalAddress', 'addressLocality' => $p['area'] . ', ' . $c['name'], 'addressRegion' => state_name($c['state']), 'postalCode' => $p['pincode'], 'addressCountry' => 'IN'],
    'areaServed' => array_map(fn($x) => ['@type' => 'City', 'name' => city_name($x)], $p['serves']), 'foundingDate' => (string) $p['since'],
    'knowsLanguage' => $p['languages'],
  ])] : [],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';

$near = array_filter($D['pros'], fn($x, $k) => $k !== $key && in_array($p['city'], $x['serves'], true), ARRAY_FILTER_USE_BOTH);
uasort($near, fn($a, $b) => [(int) ($b['area'] === $p['area']), $b['rating']] <=> [(int) ($a['area'] === $p['area']), $a['rating']]);
$near = array_slice($near, 0, 3, true);
$blankD = array_map(fn($v) => is_array($v) ? [] : '', designs_query());
$fact = fn($label, $value) => $value === '' ? '' : '<div><dt>' . e($label) . '</dt><dd>' . $value . '</dd></div>';
?>
<div class="container section prof">
  <?= component('breadcrumbs', ['crumbs' => $crumbs]) ?>
  <header class="prof__head">
    <?= pro_avatar($key, $p) ?>
    <div>
      <p class="eyebrow"><?= e($type['label']) ?> · <?= e(segment_label($p['segment'])) ?></p>
      <h1><?= e($p['name']) ?> <?= sample_badge($p) ?></h1>
      <p class="prof__place"><?= e($p['area'] . ', ' . $c['name'] . ', ' . state_name($c['state']) . ' ' . $p['pincode']) ?></p>
      <p class="prof__rating"><?= pro_stars($p) ?></p>
    </div>
    <div class="prof__cta"><?= enquiry_buttons('pro', $key, $p['name']) ?><p class="form__note"><?= e($p['reply']) ?></p></div>
  </header>

  <?= finder_sample_note('pros') ?>

  <div class="prof__grid">
    <div>
      <section><h2>About</h2><p><?= e($p['about']) ?></p></section>

      <section><h2>What they offer</h2>
        <ul class="offer">
<?php foreach ($D['reqs'] as $k => $label): $has = in_array($k, $p['reqs'], true); ?>
          <li class="<?= $has ? 'is-yes' : 'is-no' ?>"><span aria-hidden="true"><?= $has ? '✓' : '–' ?></span> <?= e($label) ?><?= $k === 'warranty' && $p['warranty'] ? ' (' . (int) $p['warranty'] . ' years)' : '' ?><span class="visually-hidden"><?= $has ? ': yes' : ': no' ?></span></li>
<?php endforeach; ?>
        </ul>
        <p class="fgroup__sub">Types of work:
<?php echo implode(', ', array_map(fn($s) => '<a href="' . e(finder_url(FINDER['pros_url'], ['does' => $s, 'city' => $p['city'], 'state' => $c['state']])) . '" rel="nofollow">' . e($T['types'][$s]['label']) . '</a>', $p['services'])); ?></p>
      </section>

      <section><h2>Where they work</h2>
        <p><strong>Areas in <?= e($c['name']) ?>:</strong> <?php
          echo implode(', ', array_map(fn($a) => '<a href="' . e(finder_url(FINDER['pros_url'], ['city' => $p['city'], 'state' => $c['state'], 'area' => $a])) . '">' . e($a) . '</a>', $p['areas'])); ?></p>
<?php if (count($p['serves']) > 1): ?>
        <p><strong>Also in:</strong> <?= implode(', ', array_map(fn($x) => '<a href="' . e(finder_url(FINDER['pros_url'], ['city' => $x, 'state' => city_state($x)])) . '">' . e(city_name($x)) . '</a>', array_slice($p['serves'], 1))) ?></p>
<?php endif; ?>
        <p><strong>Apartments and societies:</strong> <?= e(implode(', ', $p['apartments'])) ?></p>
      </section>

<?php if ($designs): ?>
      <section><div class="section-head"><h2>Their trending designs</h2><a class="link-arrow" href="<?= e(finder_url(FINDER['designs_url'], $blankD, ['company' => $key])) ?>">See all</a></div>
        <div class="dgrid dgrid--compact"><?php foreach (array_slice($designs, 0, 6, true) as $k => $d) echo design_card($k, $d, true, true); ?></div>
      </section>
<?php endif; ?>

      <section><h2>Reviews</h2>
        <p class="prof__rating"><?= pro_stars($p) ?></p>
<?php foreach ($p['sample_reviews'] ?? [] as [$who, $when, $stars, $text]): ?>
        <blockquote class="review"><p><?= e($text) ?></p><footer><span class="stars" aria-label="<?= (int) $stars ?> out of 5"><span class="stars__fill" style="--r:<?= (int) $stars ?>">★★★★★</span></span> <?= e($who) ?>, <?= e($when) ?><?= $real ? '' : ' <span class="badge badge--sample">Sample review</span>' ?></footer></blockquote>
<?php endforeach; ?>
      </section>
    </div>

    <aside class="prof__side">
      <dl class="design__facts">
        <?= $fact('Type', e($type['label'])) ?>
        <?= $fact('Budget level', e(segment_label($p['segment']))) ?>
        <?= $fact('Pricing', e($p['price'])) ?>
        <?= $fact('Working since', (int) $p['since'] . ' (' . (2026 - (int) $p['since']) . ' years)') ?>
        <?= $fact('Projects', number_format($p['projects'])) ?>
        <?= $fact('Team', $p['team'] > 1 ? (int) $p['team'] . ' people' : 'Works solo') ?>
        <?= $fact('Warranty', $p['warranty'] ? (int) $p['warranty'] . ' years' : 'Ask them') ?>
        <?= $fact('Languages', e(implode(', ', $p['languages']))) ?>
        <?= $fact('Office', e($p['area'] . ', ' . $c['name'] . ' ' . $p['pincode'])) ?>
      </dl>
      <div class="design__cta"><?= enquiry_buttons('pro', $key, $p['name']) ?></div>
      <p class="form__note">We verify your email with a one-time code, then send your details to <?= e($p['name']) ?> only. Their own email address is never shown or shared.</p>
<?php if ($c['guide'] && is_live($c['guide'])): ?>
      <p class="mt-4"><a class="link-arrow" href="<?= e($c['guide']) ?>">Established interior firms in <?= e($c['name']) ?></a></p>
<?php endif; ?>
    </aside>
  </div>

<?php if ($near): ?>
  <section class="mt-8">
    <div class="section-head"><h2 class="design__more-title">Others in <?= e($c['name']) ?></h2><a class="link-arrow" href="<?= e(finder_url(FINDER['pros_url'], ['city' => $p['city'], 'state' => $c['state']])) ?>">See all</a></div>
    <div class="pgrid"><?php foreach ($near as $k => $x) echo pro_card($k, $x); ?></div>
  </section>
<?php endif; ?>
</div>
<?= enquiry_dialog() ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
