<?php
/* INTERIOR COST CALCULATOR — /calculators/interior-cost/
   The calculator itself is the shared estimator (includes/components/estimator.php).
   Rates, city factors and add-on prices: includes/calc/rates.php → 'home' (edit once; worked out on the server). */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/calc/engine.php';
$H = calc_rates()['home'];
$page = [
  'type'        => 'tool',
  'pillar'      => 'cost',
  'js'          => ['calc'],
  'title'       => 'Interior Cost Calculator',
  'seo_title'   => 'Interior Cost Calculator: Free Home Estimate',
  'description' => 'Free interior cost calculator: choose home size, material grade, scope and city for an instant estimate with a room-wise split, GST included. No signup.',
  'lede'        => 'Pick your home, grade and scope. The estimate, the room-wise split and the likely range update as you go.',
  'eyebrow'     => 'Free tool',
  'rates_as_of' => 'Oct 2026',
  'published'   => '2026-10-03',
  'updated'     => '2026-10-03',
  'faq' => [
    'How accurate is this interior cost calculator?' => 'It gives a planning figure, not a quotation. The estimate is built from indicative per-square-foot rates for Bengaluru and adjusted by a city factor. A quote after site measurement can differ by 10–15% either way, and more if your design is unusual.',
    'Does the estimate include GST?' => 'Yes. The rates include 18% GST. Loose furniture, appliances and, unless you choose that scope, flooring and bathroom work are not included.',
    'Which area should I enter?' => 'Carpet area: the usable floor inside your walls. It is usually 70–78% of the super built-up area on the sale agreement.',
    'What is the difference between the grades?' => 'Essential uses laminate finishes and basic soft-close fittings. Standard mixes better laminates with some acrylic and branded fittings. Premium uses acrylic, PU or veneer on visible surfaces with premium hardware. Luxury is made to order.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section">
  <div class="container">
    <?= component('estimator') ?>
  </div>
</section>

<section class="section section--grey section--tight">
  <div class="container container--text prose">
    <h2>How the estimate is worked out</h2>
    <p>The calculator multiplies your carpet area by a rate per square foot for the grade you choose, then adjusts it for scope and city. Extras are added as fixed amounts, and the contingency buffer is a percentage of everything above it.</p>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Grade</th><th class="num">Range per sq ft</th><th class="num">Rate used here</th></tr></thead>
      <tbody>
        <tr><td>Essential</td><td class="num">₹450–700</td><td class="num"><?= inr($H['per_sqft']['essential']) ?></td></tr>
        <tr><td>Standard</td><td class="num">₹700–1,100</td><td class="num"><?= inr($H['per_sqft']['standard']) ?></td></tr>
        <tr><td>Premium</td><td class="num">₹1,100–1,700</td><td class="num"><?= inr($H['per_sqft']['premium']) ?></td></tr>
        <tr><td>Luxury</td><td class="num">₹1,700 and above</td><td class="num"><?= inr($H['per_sqft']['luxury']) ?></td></tr>
      </tbody>
    </table>
    </div>
    <p class="table-note">Bengaluru, including GST, for a full scope: kitchen, wardrobes, TV unit, false ceiling, painting, lighting and curtains.</p>
    <ul>
      <li><strong>Kitchen and wardrobes only</strong> is taken as half of the full-scope figure.</li>
      <li><strong>Full interiors, flooring and bathrooms</strong> adds about 30% for new flooring and bathroom work.</li>
      <li><strong>City</strong> changes labour and overheads: Hosur and Mysuru run a little below Bengaluru, Mumbai and Delhi NCR above it.</li>
      <li><strong>The likely range</strong> is the estimate plus or minus <?= round($H['spread'] * 100) ?>%.</li>
    </ul>
    <p>Want every cabinet and accessory priced separately? The <a href="/calculators/home-interior-quote/">room-by-room quote builder</a> lists 91 modules across 10 rooms with sizes you can change.</p>

    <h2>What the estimate does not include</h2>
    <ul>
      <li>Loose furniture such as sofas, beds, dining tables and mattresses</li>
      <li>Kitchen and home appliances</li>
      <li>Civil changes, waterproofing and society or builder charges</li>
      <li>Anything found only at site measurement, such as damp walls or old wiring</li>
    </ul>
    <p>The ranges behind these rates, room-wise prices and a guide to comparing quotations are in our <a href="/cost/">interior design cost guide</a>.</p>
  </div>
</section>

<section class="section section--tight">
  <div class="container container--text">
    <?= component('faq') ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
