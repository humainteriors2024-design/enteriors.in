<?php
/* =====================================================================
   ONE TRENDING DESIGN — /trending-designs/<key>/  (shown by trending-designs/index.php)
   Gallery (7–10 pictures), the project details, Contact / Mail (OTP-verified), the write-up,
   links to the matching guides and calculators, and more designs by firm, style and city.
   Data: includes/data/trends.php. Real photos: /assets/trending/<key>/ (replace the samples).
   ===================================================================== */
[, $key, $exists] = $route;
if (!$exists) { require $_SERVER['DOCUMENT_ROOT'] . '/404.php'; return; }
if (!str_ends_with(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '', '/')) { header('Location: ' . design_url($key), true, 301); exit; }

$T   = trends_db();
$d   = design($key);
$pro = pro($d['company']);
$st  = $T['styles'][$d['style']];
$ty  = $T['types'][$d['type']];
$imgs = design_images($key, $d);
$city = places_db()['cities'][$d['city']];
$all  = $T['designs'];
$desc = mb_strlen($d['summary']) > 158 ? rtrim(mb_substr($d['summary'], 0, 155), " ,.;:") . '…' : $d['summary'];
$real = empty($d['sample']);

$page = [
  'type'          => 'page',
  'css'           => ['finder'],
  'js'            => ['finder', 'enquiry'],
  'title'         => $d['title'],
  'seo_title'     => mb_strlen($d['title']) > 58 ? preg_replace('/ (in|on) [^,]+, ([^,]+)$/u', ' in $2', $d['title']) : $d['title'],
  'description'   => $desc,
  'crumb'         => $ty['label'] . ' in ' . city_name($d['city']),
  'updated'       => $d['added'],
  'noindex'       => !$real && !FINDER['index_samples'],
  'no_media_note' => true,
  'media_dir'     => '/assets/trending/' . $key,
  'image'         => !$imgs[0]['sample'] ? $imgs[0]['src'] : null,
  'schema_type'   => 'ItemPage',
  'schema_extra'  => $real ? [array_filter([
    '@type' => 'CreativeWork', 'name' => $d['title'], 'description' => $d['summary'], 'url' => SITE['url'] . design_url($key),
    'image' => array_map(fn($i) => SITE['url'] . $i['src'], array_slice($imgs, 0, 10)), 'dateCreated' => $d['added'],
    'genre' => $st['label'] . ' interior design', 'about' => $ty['label'],
    'creator' => $pro ? ['@type' => 'Organization', 'name' => $pro['name'], 'url' => SITE['url'] . pro_url($d['company'])] : null,
    'locationCreated' => ['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => $city['name'], 'addressRegion' => state_name($city['state']), 'postalCode' => $d['pincode'], 'addressCountry' => 'IN']],
  ])] : [],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';

// neighbours in date order, for previous / next links
$order = array_keys($all);
usort($order, fn($a, $b) => strcmp($all[$b]['added'], $all[$a]['added']) ?: strcmp($a, $b));
$pos  = array_search($key, $order, true);
$prev = $order[$pos - 1] ?? null; $next = $order[$pos + 1] ?? null;
// related: same firm, same style, same city (no repeats)
$used = [$key => 1];
$pick = function ($fn, $n) use ($all, &$used) {
  $out = [];
  foreach ($all as $k => $x) if (!isset($used[$k]) && $fn($x)) { $out[$k] = $x; $used[$k] = 1; if (count($out) === $n) break; }
  return $out;
};
$byFirm  = $pick(fn($x) => $x['company'] === $d['company'], 4);
$byStyle = $pick(fn($x) => $x['style'] === $d['style'], 4);
$byCity  = $pick(fn($x) => city_state($x['city']) === $city['state'], 4);
$blank   = array_map(fn($v) => is_array($v) ? [] : '', designs_query());
$fact = fn($label, $value) => $value === '' ? '' : '<div><dt>' . e($label) . '</dt><dd>' . $value . '</dd></div>';
$guide = fn($href, $text) => $href && is_live($href) ? '<a href="' . e($href) . '">' . e($text) . '</a>' : e($text);
?>
<div class="container section design">
  <?= component('breadcrumbs', ['crumbs' => $crumbs]) ?>
  <header class="design__head">
    <p class="eyebrow"><?= e($ty['label']) ?> · <?= e($st['label']) ?></p>
    <h1><?= e($d['title']) ?></h1>
    <p class="design__place"><?= e(design_place($d)) ?> <?= sample_badge($d) ?></p>
  </header>

  <div class="design__grid">
    <div class="gallery-box" data-gallery>
      <figure class="gallery-box__main">
        <?= finder_img($imgs[0], false, '(max-width: 1024px) 100vw, 860px', ' data-gallery-main') ?>
        <figcaption data-gallery-caption><?= e($imgs[0]['alt']) ?></figcaption>
<?php if (count($imgs) > 1): ?>
        <button class="gallery-box__nav gallery-box__nav--prev" type="button" data-gallery-step="-1" aria-label="Previous picture">‹</button>
        <button class="gallery-box__nav gallery-box__nav--next" type="button" data-gallery-step="1" aria-label="Next picture">›</button>
        <span class="gallery-box__count" data-gallery-count>1 / <?= count($imgs) ?></span>
<?php endif; ?>
      </figure>
      <div class="gallery-box__thumbs">
<?php foreach ($imgs as $i => $im): ?>
        <button type="button" data-gallery-thumb="<?= $i ?>" data-src="<?= e($im['src']) ?>" data-alt="<?= e($im['alt']) ?>" aria-label="Show picture <?= $i + 1 ?>"<?= $i === 0 ? ' aria-current="true"' : '' ?>><?= finder_img($im, true, '120px') ?></button>
<?php endforeach; ?>
      </div>
    </div>

    <aside class="design__panel">
      <dl class="design__facts">
        <?= $fact('Project / apartment', e($d['project'])) ?>
        <?= $fact('Location', e(design_place($d)) . ' ' . e($d['pincode'])) ?>
        <?= $fact('Company', $pro ? '<a href="' . e(pro_url($d['company'])) . '">' . e($pro['name']) . '</a>' : '') ?>
        <?= $fact('Designer', e($d['designer'])) ?>
        <?= $fact('Property type', e(design_home($d))) ?>
        <?= $fact('Design style', $guide($st['guide'], $st['label'])) ?>
        <?= $fact('Design type', $guide($ty['guide'], $ty['label'])) ?>
        <?= $fact('Approx. budget', '<strong>' . e(money_short($d['budget'])) . '</strong> <small>incl. GST</small>') ?>
        <?= $fact('Size', e(number_format($d['size'])) . ' sq ft') ?>
        <?= $fact('Time on site', 'About ' . (int) $d['weeks'] . ' weeks') ?>
      </dl>
      <div class="design__cta"><?= enquiry_buttons('design', $key, $pro['name'] ?? 'the designer', $d['title']) ?></div>
      <p class="form__note">Contact asks for a call back; Mail sends your message. We verify your email with a one-time code, then send your details to <?= e($pro['name'] ?? 'the firm') ?> only.</p>
<?php if ($pro): ?>
      <p class="mt-4"><a class="link-arrow" href="<?= e(pro_url($d['company'])) ?>">Profile: <?= e($pro['name']) ?></a></p>
<?php endif; ?>
    </aside>
  </div>

  <?= finder_sample_note('designs') ?>

  <div class="design__body">
    <div class="prose">
      <h2>About this design</h2>
<?php foreach ($d['text'] as $para) echo '      <p>' . e($para) . "</p>\n"; ?>
      <h2>Highlights</h2>
      <ul class="ticks"><?php foreach ($d['highlights'] as $x) echo '<li>' . e($x) . '</li>'; ?></ul>
      <h2>Materials</h2>
      <div class="card__tags"><?php foreach ($d['materials'] as $x) echo '<span class="tag">' . e(ucfirst($x)) . '</span>'; ?></div>
    </div>
    <aside class="design__plan">
      <p class="design__plan-title">Plan something similar</p>
      <ul>
<?php
$plan = array_filter([
  [$ty['cost'], 'What a ' . strtolower($ty['label']) . ' costs'], [$ty['guide'], $ty['label'] . ' guide'], [$st['guide'], $st['label'] . ' style guide'],
  ['/calculators/interior-cost/', 'Interior cost calculator'], [$city['guide'], 'Interior designers in ' . $city['name']],
  [finder_url(FINDER['pros_url'], ['city' => $d['city'], 'state' => $city['state']]), 'Find a designer in ' . $city['name']],
  [finder_url(FINDER['designs_url'], $blank, ['city' => $d['city'], 'state' => $city['state']]), 'All designs in ' . $city['name']],
], fn($x) => $x[0] && is_live($x[0]));
foreach ($plan as [$href, $label]) echo '        <li><a href="' . e($href) . '">' . e($label) . '</a></li>' . "\n";
?>
      </ul>
    </aside>
  </div>

  <nav class="design__pager" aria-label="More designs">
    <?= $prev ? '<a href="' . e(design_url($prev)) . '" rel="prev">‹ ' . e($all[$prev]['title']) . '</a>' : '<span></span>' ?>
    <a href="<?= e(FINDER['designs_url']) ?>">All trending designs</a>
    <?= $next ? '<a href="' . e(design_url($next)) . '" rel="next">' . e($all[$next]['title']) . ' ›</a>' : '<span></span>' ?>
  </nav>

<?php foreach ([['More by ' . ($pro['name'] ?? 'this firm'), $byFirm, finder_url(FINDER['designs_url'], $blank, ['company' => $d['company']])],
                ['More ' . $st['label'] . ' designs', $byStyle, finder_url(FINDER['designs_url'], $blank, ['style' => [$d['style']]])],
                ['More designs in ' . state_name($city['state']), $byCity, finder_url(FINDER['designs_url'], $blank, ['state' => $city['state']])]] as [$title, $list, $more]):
        if (!$list) continue; ?>
  <section class="mt-8">
    <div class="section-head"><h2 class="design__more-title"><?= e($title) ?></h2><a class="link-arrow" href="<?= e($more) ?>">See all</a></div>
    <div class="dgrid dgrid--compact"><?php foreach ($list as $k => $x) echo design_card($k, $x, true, true); ?></div>
  </section>
<?php endforeach; ?>
</div>
<?= enquiry_dialog() ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
