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
  'css'           => ['finder', 'company'],
  'js'            => ['finder', 'enquiry'],
  'title'         => $p['name'] . ', ' . $type['label'] . ' in ' . $c['name'],
  'seo_title'     => $p['name'] . ' · ' . $type['label'] . ' in ' . $p['area'] . ', ' . $c['name'],
  'description'   => mb_strlen($desc) > 158 ? rtrim(mb_substr($desc, 0, 155), ' ,.') . '…' : $desc,
  'crumb'         => $p['name'],
  'updated'       => $D['checked'],
  'noindex'       => finder_noindex('pros') || (!$real && !FINDER['index_samples']),
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
$co = $p['company'] ?? [];   // details the firm filled in at /company/ (empty for listings that have not signed in)
$coOpt = fn($k, $v) => company_fields()[$k][3]['options'][$v] ?? '';
$offerLive = !empty($co['offer']) && (empty($co['offer_till']) || $co['offer_till'] >= date('Y-m-d'));
$usps = array_values(array_filter([$co['usp1'] ?? '', $co['usp2'] ?? '', $co['usp3'] ?? '']));
$social = array_filter(['Instagram' => $co['instagram'] ?? '', 'Facebook' => $co['facebook'] ?? '', 'Google reviews' => $co['google'] ?? '']);
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

  <?= $real ? '' : finder_sample_note('pros') ?>

  <div class="prof__grid">
    <div>
<?php if ($offerLive): ?>
      <div class="prof-offer" role="note"><strong>Ongoing offer: <?= e($co['offer']) ?></strong><?= !empty($co['offer_till']) ? '<span class="muted">Valid till ' . e(nice_date($co['offer_till'])) . '. Terms from the firm.</span>' : '<span class="muted">Terms from the firm.</span>' ?></div>
<?php endif; ?>
<?php if (trim((string) $p['about']) !== ''): ?>
      <section><h2>About</h2><p><?= e($p['about']) ?></p></section>
<?php endif; ?>
<?php if ($usps): ?>
      <section><h2>Why choose <?= e($p['name']) ?></h2><ul class="prof-usps"><?php foreach ($usps as $u) echo '<li>' . e($u) . '</li>'; ?></ul></section>
<?php endif; ?>
<?php $mats = array_filter(['Boards' => $co['mat_board'] ?? '', 'Finishes' => $co['mat_finish'] ?? '', 'Hardware' => $co['mat_hardware'] ?? '', 'Warranty' => $co['warranty_text'] ?? '', 'Prices' => trim(implode(' · ', array_filter([!empty($co['price_sqft']) ? 'From ₹' . number_format((int) $co['price_sqft']) . ' per sq ft' : '', !empty($co['price_2bhk']) ? '2 BHK from ' . money_short($co['price_2bhk']) : ''])) . (!empty($co['price_note']) ? ' — ' . $co['price_note'] : ''))]);
      if ($mats): ?>
      <section><h2>Materials, warranty and prices</h2><dl class="prof-mats"><?php foreach ($mats as $l => $v) echo '<div><dt>' . e($l) . '</dt><dd>' . e($v) . '</dd></div>'; ?></dl>
        <p class="form__note">As stated by <?= e($p['name']) ?>. Ask for these names in your itemised quotation, and compare it with your own estimate from our <a href="/calculators/home-interior-quote/">interior cost calculator</a>.</p></section>
<?php endif; ?>

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

<?php if ($social): ?>
      <section><h2>Instagram, Facebook and Google reviews</h2>
        <div class="prof-social"><?php foreach ($social as $l => $u) echo '<a class="btn btn--outline btn--sm" href="' . e($u) . '" target="_blank" rel="nofollow noopener">' . e($l) . ' ↗</a>'; ?></div>
<?php if (!empty($co['google_rating'])): ?>
        <p class="mt-4">Google rating: <strong><?= e(number_format((float) $co['google_rating'], 1)) ?></strong><?= !empty($co['google_count']) ? ' from ' . (int) $co['google_count'] . ' reviews' : '' ?>, as stated by the firm. <?= !empty($co['google']) ? 'Check it on Google with the link above.' : '' ?></p>
<?php endif; ?>
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
        <?= $fact('Segment', e(segment_label($p['segment']))) ?>
        <?= $fact('Pricing', e($p['price'])) ?>
        <?= $fact('Working since', (int) $p['since'] . ' (' . (2026 - (int) $p['since']) . ' years)') ?>
        <?= $fact('Projects', number_format($p['projects'])) ?>
        <?= $co ? '' : $fact('Team', $p['team'] > 1 ? (int) $p['team'] . ' people' : 'Works solo') ?>
        <?= $fact('Warranty', $p['warranty'] ? (int) $p['warranty'] . ' years' : 'Ask them') ?>
        <?= $fact('Languages', e(implode(', ', $p['languages']))) ?>
        <?= $fact('Office', e(($co['office_address'] ?? '') !== '' ? $co['office_address'] . ', ' . $p['area'] . ', ' . $c['name'] . ' ' . $p['pincode'] : $p['area'] . ', ' . $c['name'] . ' ' . $p['pincode']) . (!empty($co['office_map']) ? ' <a href="' . e($co['office_map']) . '" target="_blank" rel="nofollow noopener">Map</a>' : '')) ?>
<?php if ($co): ?>
        <?= $fact('Factory', e(trim($coOpt('factory', $co['factory'] ?? '') . (!empty($co['factory_location']) ? ': ' . $co['factory_location'] : '')))) ?>
        <?= $fact('Design team', !empty($co['team']) ? (int) $co['team'] . ' designers' : '') ?>
        <?= $fact('How they work', e(implode(', ', array_map(fn($m) => $coOpt('models', $m), (array) ($co['models'] ?? []))))) ?>
        <?= $fact('End-to-end interiors', ($co['end_to_end'] ?? '') === 'yes' ? 'Yes' : (($co['end_to_end'] ?? '') === 'no' ? 'No, woodwork and design' : '')) ?>
        <?= $fact('GSTIN', e($co['gst'] ?? '')) ?>
<?php endif; ?>
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
