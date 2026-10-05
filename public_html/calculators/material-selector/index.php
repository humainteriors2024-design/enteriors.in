<?php
/* MATERIAL SELECTOR — /calculators/material-selector/
   Pick a room and a priority; the page recommends board, shutter finish, hardware and surface.
   Works without JavaScript (a GET form); the full matrix below is the same data for every room.
   Edit recommendations in $ROOMS. Prices match includes/data/home.php (materials) and rates.php. */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
$PRIORITIES = ['budget' => 'Lowest cost that will last', 'balanced' => 'Best value', 'premium' => 'Best look and feel'];
$ROOMS = [   // key => [label, water exposure, [priority => [carcass, shutter finish, hardware, surface/other]], guide url]
  'kitchen-base' => ['Kitchen base units (sink and hob)', 'High', [
    'budget'   => ['BWP plywood under the sink, BWR elsewhere', 'Laminate (1 mm, matte or suede)', 'Basic soft-close hinges, ball-bearing channels', 'Black granite, sealed'],
    'balanced' => ['BWP plywood under the sink and dishwasher, BWR elsewhere', 'Laminate on base, acrylic on wall units', 'Branded soft-close hinges, tandem boxes for drawers', 'Quartz or dark granite'],
    'premium'  => ['BWP plywood throughout', 'Acrylic, PU or veneer (laminate inside)', 'Premium full-extension drawer systems, lift-ups', 'Quartz or sintered stone'],
  ], '/modular-kitchen/'],
  'kitchen-wall' => ['Kitchen wall units and lofts', 'Medium (steam)', [
    'budget'   => ['BWR plywood or HDHMR', 'Laminate', 'Basic soft-close hinges', 'Ceramic tile backsplash'],
    'balanced' => ['BWR plywood', 'Acrylic or high-gloss laminate', 'Branded soft-close; lift-up on one unit', 'Large-format tile or quartz backsplash'],
    'premium'  => ['BWR or BWP plywood', 'Fluted glass, PU or acrylic', 'Lift-up fittings, profile LED lights', 'Quartz or lacquered-glass backsplash'],
  ], '/modular-kitchen/'],
  'wardrobe' => ['Bedroom wardrobe', 'Low', [
    'budget'   => ['MR plywood or HDHMR', 'Laminate', 'Basic soft-close hinges', 'Loft to the ceiling'],
    'balanced' => ['Branded MR plywood; BWR on a bathroom wall', 'Laminate with one acrylic or mirror shutter', 'Branded hinges, full-extension channels', 'Internal drawers, sensor light'],
    'premium'  => ['Branded MR or BWR plywood', 'Veneer, PU or lacquered glass', 'Premium hinges or soft-close sliding system', 'Organisers, lights, pull-down hanger'],
  ], '/wardrobe/'],
  'tv-unit' => ['TV unit and living room', 'Low', [
    'budget'   => ['MR plywood or HDHMR', 'Laminate', 'Basic channels', 'Laminate back panel'],
    'balanced' => ['MR plywood', 'Textured laminate or veneer-look', 'Branded soft-close drawers', 'Fluted MDF or WPC feature panel'],
    'premium'  => ['MR plywood', 'Veneer or PU', 'Push-to-open drawers', 'Stone-look slab or veneer wall with cove light'],
  ], '/furniture/tv-unit-design/'],
  'vanity' => ['Bathroom vanity', 'Very high', [
    'budget'   => ['BWP plywood or WPC board', 'Laminate (inside and out)', 'Stainless steel hinges', 'Granite top'],
    'balanced' => ['BWP plywood', 'Laminate or acrylic', 'Stainless steel soft-close hinges', 'Quartz top, wall-hung'],
    'premium'  => ['BWP plywood', 'Acrylic or PU', 'Premium stainless fittings', 'Quartz or sintered stone with an under-mount basin'],
  ], '/rooms/bathroom/'],
  'utility' => ['Utility and balcony cabinets', 'Very high', [
    'budget'   => ['WPC board', 'Painted or laminated WPC', 'Stainless steel hinges', 'Anti-skid tile floor'],
    'balanced' => ['WPC or BWP plywood', 'Laminate', 'Stainless steel soft-close', 'Washer platform in granite'],
    'premium'  => ['BWP plywood', 'Acrylic', 'Premium stainless fittings', 'Quartz platform, tall broom unit'],
  ], '/rooms/utility-area/'],
  'kids' => ['Kids room', 'Low', [
    'budget'   => ['MR plywood', 'Laminate in light colours', 'Basic soft-close', 'Pin-board, open shelves'],
    'balanced' => ['MR plywood', 'Laminate with rounded edges', 'Soft-close everywhere (no pinched fingers)', 'Adjustable shelves and rods'],
    'premium'  => ['MR plywood', 'PU paint in custom colours', 'Premium soft-close, child locks', 'Built-in study with task light'],
  ], '/rooms/kids-room/'],
  'pooja' => ['Pooja unit', 'Low (lamps, oil)', [
    'budget'   => ['MR plywood', 'Laminate', 'Basic hinges', 'Granite base for lamps'],
    'balanced' => ['MR or BWR plywood', 'Veneer-look laminate; CNC jaali doors', 'Soft-close drawer for samagri', 'Corian or quartz back panel'],
    'premium'  => ['BWR plywood', 'Veneer or teak; carved doors', 'Brass fittings', 'Back-lit Corian or marble'],
  ], '/rooms/pooja-room/'],
];
$room = isset($_GET['room'], $ROOMS[$_GET['room']]) ? $_GET['room'] : null;
$prio = isset($_GET['priority'], $PRIORITIES[$_GET['priority']]) ? $_GET['priority'] : 'balanced';
$page = [
  'type'        => 'tool',
  'pillar'      => 'materials',
  'title'       => 'Material Selector: Boards and Finishes, Room by Room',
  'seo_title'   => 'Interior Material Selector (Free Tool)',
  'crumb'       => 'Material Selector',
  'description' => 'Free material selector: the right board, finish, hardware and surface for kitchens, wardrobes, TV units, vanities, utility and pooja units, by budget.',
  'eyebrow'     => 'Free tool',
  'lede'        => 'Pick a room and what matters most. We show the board, finish, hardware and surface that suit its exposure to water and your budget.',
  'published'   => '2026-10-05',
  'updated'     => '2026-10-05',
  'rates_as_of' => 'Oct 2026',
  'noindex'     => isset($_GET['room']),   // result URLs (?room=…) repeat this page: keep only the main URL in search; canonical is the clean URL
  'faq' => [
    'Which board is best for kitchen cabinets?' => 'BWP (boiling-water-proof, IS 710) plywood under the sink and around the dishwasher, and BWR plywood or HDHMR for other kitchen cabinets. Keep MR plywood, MDF and particle board for dry rooms.',
    'Which board is best for wardrobes?' => 'MR plywood or HDHMR in dry bedrooms; BWR plywood if the wardrobe stands against a bathroom wall.',
    'Which material is best for a bathroom vanity?' => 'BWP plywood or WPC board, laminated inside and out, with stainless steel hinges and a stone top.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section">
  <div class="container">
    <form class="form card card--boxed" method="get" action="/calculators/material-selector/#result">
      <div class="form__row">
        <div class="field"><label for="ms-room">Room or unit</label>
          <select class="input" id="ms-room" name="room"><?php foreach ($ROOMS as $k => $r) echo '<option value="' . e($k) . '"' . ($k === $room ? ' selected' : '') . '>' . e($r[0]) . '</option>'; ?></select></div>
        <div class="field"><label for="ms-priority">What matters most?</label>
          <select class="input" id="ms-priority" name="priority"><?php foreach ($PRIORITIES as $k => $l) echo '<option value="' . e($k) . '"' . ($k === $prio ? ' selected' : '') . '>' . e($l) . '</option>'; ?></select></div>
      </div>
      <button class="btn btn--primary" type="submit">Show my materials →</button>
    </form>

<?php if ($room): [$label, $water, $recs, $guide] = $ROOMS[$room]; [$carcass, $finish, $hw, $surface] = $recs[$prio]; ?>
    <div class="card card--boxed mt-6" id="result">
      <span class="card__label"><?= e($PRIORITIES[$prio]) ?> · Water exposure: <?= e($water) ?></span>
      <h2 class="card__title"><?= e($label) ?></h2>
      <div class="table-wrap">
      <table>
        <tbody>
          <tr><th>Carcass board</th><td><?= e($carcass) ?></td></tr>
          <tr><th>Shutter finish</th><td><?= e($finish) ?></td></tr>
          <tr><th>Hardware</th><td><?= e($hw) ?></td></tr>
          <tr><th>Surface and extras</th><td><?= e($surface) ?></td></tr>
        </tbody>
      </table>
      </div>
      <p class="card__text">Read more: <a href="<?= e($guide) ?>"><?= e(nav_label($guide) ?? 'the guide') ?></a> · <a href="/calculators/home-interior-quote/">price it in the quote builder</a></p>
    </div>
<?php endif; ?>
  </div>
</section>

<section class="section section--grey">
  <div class="container container--text prose">
    <h2>The full matrix: best value</h2>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Room or unit</th><th>Water</th><th>Board</th><th>Finish</th><th>Hardware</th></tr></thead>
      <tbody>
<?php foreach ($ROOMS as $k => [$label, $water, $recs, $guide]): [$c, $f, $h] = $recs['balanced']; ?>
        <tr><td><a href="<?= e($guide) ?>"><?= e($label) ?></a></td><td><?= e($water) ?></td><td><?= e($c) ?></td><td><?= e($f) ?></td><td><?= e($h) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <h2>Board prices at a glance</h2>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Board, 18 mm</th><th class="num">Per sq ft</th><th>Use</th></tr></thead>
      <tbody>
        <tr><td><a href="/materials/marine-plywood/">BWP plywood</a></td><td class="num">₹110–180</td><td>Sinks, vanities, utility</td></tr>
        <tr><td><a href="/materials/bwr-plywood/">BWR plywood</a></td><td class="num">₹90–140</td><td>Kitchens, humid rooms</td></tr>
        <tr><td><a href="/materials/mr-plywood/">MR plywood</a></td><td class="num">₹75–120</td><td>Wardrobes, TV and study units</td></tr>
        <tr><td><a href="/materials/hdhmr-board/">HDHMR</a></td><td class="num">₹70–110</td><td>Shutters, dry carcasses</td></tr>
        <tr><td><a href="/materials/wpc-board/">WPC board</a></td><td class="num">₹110–180</td><td>Wet areas</td></tr>
        <tr><td><a href="/materials/mdf-board/">MDF</a></td><td class="num">₹45–75</td><td>Painted shutters, dry rooms only</td></tr>
      </tbody>
    </table>
    </div>
    <p class="table-note">Indicative Bengaluru prices, October 2026, before GST.</p>
    <p>Every material is explained in the <a href="/materials/">materials guide</a> and the <a href="/glossary/">materials glossary</a>; grades are compared in <a href="/compare/bwp-vs-bwr-vs-mr-plywood/">BWP vs BWR vs MR plywood</a>.</p>
    <?= component('faq') ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
