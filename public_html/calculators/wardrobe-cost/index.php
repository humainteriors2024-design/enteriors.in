<?php
/* WARDROBE COST CALCULATOR — /calculators/wardrobe-cost/
   Calculator: includes/components/wardrobe-calc.php. Rates: includes/calc/rates.php → 'wardrobe'. */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/calc/engine.php';
$W = calc_rates()['wardrobe'];
$page = [
  'type'        => 'tool',
  'pillar'      => 'wardrobe',
  'js'          => ['calc'],
  'title'       => 'Wardrobe Cost Calculator',
  'seo_title'   => 'Wardrobe Cost Calculator: Hinged and Sliding (2026)',
  'crumb'       => 'Wardrobe Calculator',
  'description' => 'Work out a wardrobe price from its size: hinged or sliding doors, laminate to PU finish, loft and internal fittings, with GST, for Bangalore and other cities.',
  'eyebrow'     => 'Free tool',
  'lede'        => 'Enter the width and height of the wall you want to fill, pick doors and finish, add fittings, and see the price with GST.',
  'rates_as_of' => calc_rates()['as_of'],
  'published'   => '2026-10-04',
  'updated'     => '2026-10-14',
  'faq' => [
    'How is a wardrobe priced in India?' => 'By the square foot of its front: width × height. The rate depends on the door type and the finish; a loft above is priced the same way at a lower rate, and internal fittings such as trouser pull-outs are added per piece.',
    'Is a sliding wardrobe more expensive than a hinged one?' => 'Usually by about 15–20% for the same size and finish, because of the track system and heavier shutters. It saves the swing space of hinged doors, which matters in bedrooms narrower than about 10 feet.',
    'How deep should a wardrobe be?' => 'About 2 ft (600 mm) inside for hanging clothes on a rod. Sliding wardrobes need roughly 2 ft 3 in overall to fit the track.',
    'Which finish lasts longest?' => 'Laminate is the toughest for daily use and the easiest to maintain. Acrylic and PU look richer but show scratches and fingerprints sooner; veneer needs a good PU coat to stay smooth.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section">
  <div class="container">
    <?= component('wardrobe-calc') ?>
  </div>
</section>

<section class="section section--grey">
  <div class="container container--text prose">
    <h2>Rates behind the calculator</h2>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Door type</th><th class="num">₹ per sq ft of front</th></tr></thead>
      <tbody><?php foreach ($W['door'] as [$label, $rate]) echo '<tr><td>' . e($label) . '</td><td class="num">' . inr($rate) . '</td></tr>'; ?></tbody>
    </table>
    </div>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Finish</th><th class="num">× laminate price</th></tr></thead>
      <tbody><?php foreach ($W['finish'] as [$label, $m]) echo '<tr><td>' . e($label) . '</td><td class="num">' . number_format($m, 2) . '</td></tr>'; ?></tbody>
    </table>
    </div>
    <p class="table-note">Laminate finish, branded hinges and channels, before GST, Bengaluru. A loft is priced at <?= round($W['loft'] * 100) ?>% of the wardrobe rate per sq ft.</p>
    <h2>Worked examples</h2>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Wardrobe</th><th class="num">About, with GST</th></tr></thead>
      <tbody>
<?php foreach ([
  ['6 × 7 ft, hinged, laminate', ['width' => 6, 'height' => 7, 'door' => 'hinged', 'finish' => 'laminate']],
  ['8 × 7 ft, hinged, laminate, 2 ft loft', ['width' => 8, 'height' => 7, 'loft' => 2, 'door' => 'hinged', 'finish' => 'laminate']],
  ['8 × 7 ft, sliding, laminate', ['width' => 8, 'height' => 7, 'door' => 'sliding', 'finish' => 'laminate']],
  ['8 × 7 ft, sliding, acrylic, 2 ft loft', ['width' => 8, 'height' => 7, 'loft' => 2, 'door' => 'sliding', 'finish' => 'acrylic']],
  ['10 × 8 ft, hinged, PU paint', ['width' => 10, 'height' => 8, 'door' => 'hinged', 'finish' => 'pu']],
] as [$label, $in]) echo '        <tr><td>' . e($label) . '</td><td class="num">' . inr(round(calc_wardrobe($in + ['city' => 'Bangalore'])['total'], -3)) . "</td></tr>\n"; ?>
      </tbody>
    </table>
    </div>
    <p class="table-note">Bengaluru, branded hinges and channels, no internal fittings. Worked out with the same rates as the calculator.</p>

    <h2>How to measure your wall</h2>
    <ol class="steps">
      <li><strong>Width</strong>Measure wall to wall at three heights and use the smallest number. Leave room for a door frame or a switchboard at either end.</li>
      <li><strong>Height</strong>Measure floor to ceiling, and note any beam that drops below the ceiling. Most wardrobes are 7 ft with a loft above; a full-height wardrobe needs no loft.</li>
      <li><strong>Depth</strong>Allow about 2 ft for a hinged wardrobe and about 2 ft 3 in for a sliding one, plus room in front: hinged doors need about 2 ft to swing open.</li>
      <li><strong>Obstacles</strong>Mark windows, AC pipes, skirting and switches, and check the wall for damp before anything is fixed to it.</li>
    </ol>

    <h2>Plan the inside before the outside</h2>
    <p>The finish decides how a wardrobe looks; the internal layout decides whether it works. Our <a href="/wardrobe/wardrobe-internal-design/">wardrobe internal design guide</a> covers hanging heights, drawer counts and where fittings earn their cost, and <a href="/compare/sliding-vs-hinged-wardrobe/">sliding vs hinged wardrobes</a> helps with the door choice. For the full bedroom, see the <a href="/wardrobe/">wardrobe guide</a> or build a <a href="/calculators/home-interior-quote/">room-by-room quote</a>.</p>
    <?= component('faq') ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
