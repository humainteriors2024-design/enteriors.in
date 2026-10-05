<?php
/* CLUSTER PAGE — Wardrobe cost (/cost/wardrobe-cost/)
   Rates match includes/calc/rates.php → 'wardrobe' (the wardrobe calculator), October 2026. */
$page = [
  'type'         => 'article',
  'title'        => 'Wardrobe Cost in 2026: Price per Sq Ft for Hinged and Sliding Wardrobes',
  'seo_title'    => 'Wardrobe Cost per Sq Ft (2026 Prices)',
  'crumb'        => 'Wardrobe Cost',
  'description'  => 'What a fitted wardrobe costs in 2026: price per sq ft of front for hinged and sliding doors, what finishes, lofts and accessories add, and worked examples by size.',
  'eyebrow'      => 'Cost',
  'lede'         => 'Wardrobes are priced by the area of their front. Here is the rate, what pushes it up, and how to check a quotation line by line.',
  'hero_alt'     => 'Floor-to-ceiling hinged wardrobe with loft and laminate shutters',
  'published'    => '2026-10-05',
  'updated'      => '2026-10-05',
  'quick_answer' => 'A fitted wardrobe costs about ₹1,100–1,800 per sq ft of front for hinged doors with laminate shutters, before GST, and about 15–20% more for sliding doors. A typical 7 ft wide, 8 ft high wardrobe with a loft costs about ₹70,000 in essential grade, ₹95,000 in standard and ₹1.5 lakh in premium, including GST.',
  'takeaways'    => [
    'Price = width × height of the front × rate per sq ft; check whether the loft is counted at the full rate or about half.',
    'Hinged laminate wardrobes run about ₹1,400 per sq ft before GST; sliding about ₹1,650.',
    'Acrylic adds about 30%, veneer about 50% and PU paint about 70% to the shutter cost.',
    'Each internal accessory (trouser pull-out, jewellery drawer, sensor light) adds ₹3,500–9,000.',
  ],
  'faq' => [
    'What is the cost of a wardrobe per square foot?' => 'About ₹1,100–1,400 per sq ft of front in essential grade, ₹1,400–1,800 in standard and ₹2,000–3,000 in premium, for hinged wardrobes, before GST. Sliding doors add about 15–20%.',
    'How much does a 6 ft wardrobe cost?' => 'A 6 ft wide, 7 ft high hinged wardrobe has a 42 sq ft front. At ₹1,400 per sq ft that is ₹58,800 before GST, or about ₹69,400 with GST. A 2 ft loft above it adds about ₹11,000–20,000 with GST, depending on whether the loft is charged at about half the rate or the full rate.',
    'Are sliding wardrobes more expensive than hinged?' => 'Yes, by about 15–20% for laminate, because of the track system, soft-close dampers and a slightly deeper carcass. Glass or mirror sliding doors cost more again.',
    'Is the loft included in the wardrobe price?' => 'It depends on the firm. Some measure the full height including the loft at one rate; others price the loft separately at about half the wardrobe rate. Ask which method is used, and compare totals rather than rates.',
    'Which finish gives the best value for wardrobes?' => 'Laminate. It is the toughest and the least expensive. Use acrylic, veneer or PU on one or two feature shutters if you want a richer look without paying for it across the whole wardrobe.',
  ],
  'related' => [
    ['/wardrobe/', 'Wardrobe design guide', 'Types, sizes, internals and cost', 'Pillar guide'],
    ['/calculators/wardrobe-cost/', 'Wardrobe cost calculator', 'Price your own wardrobe', 'Tool'],
    ['/compare/sliding-vs-hinged-wardrobe/', 'Sliding vs hinged wardrobe', 'Which suits your bedroom', 'Compare'],
  ],
  'sources' => [
    ['Enteriors wardrobe rate sheet, October 2026', '/calculators/wardrobe-cost/', 'the same rates the wardrobe calculator uses'],
    ['Bureau of Indian Standards: IS 303 plywood', 'https://www.bis.gov.in/', 'MR-grade plywood used for bedroom carcasses'],
  ],
  'partner'      => ['follow' => false],   // in-text partner links are followed; keep the box nofollow
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>A wardrobe quotation usually shows one number per square foot and one total. Both can mislead: the rate can look low because the loft is measured separately, and the total can hide a cheaper board. This page explains how fitted wardrobes are priced in 2026, using the same Bengaluru rates as our <a href="/calculators/wardrobe-cost/">wardrobe calculator</a>. For types, sizes and internal layouts, start with the <a href="/wardrobe/">wardrobe design guide</a>.</p>

<h2>How wardrobes are priced</h2>
<p>Fitted wardrobes are priced per <strong>square foot of front</strong>: the width of the wardrobe multiplied by its height.</p>
<ul>
  <li><strong>Body:</strong> width × height of the main wardrobe, usually about 7 ft high.</li>
  <li><strong>Loft:</strong> width × height of the section above, to the ceiling. Some firms charge it at the full rate as part of the height; others at about 55% of the rate.</li>
  <li><strong>Accessories:</strong> each internal fitting priced as an item.</li>
  <li><strong>GST:</strong> 18%, often added at the end.</li>
</ul>

<h2>Rates by grade</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Grade</th><th class="num">Per sq ft of front (hinged, before GST)</th><th class="num">7 × 8 ft with loft, incl. GST</th><th>What you get</th></tr></thead>
  <tbody>
    <tr><td>Essential</td><td class="num">₹1,100–1,400</td><td class="num">about ₹70,000</td><td>MR plywood or HDHMR, laminate, basic soft-close hinges, shelves, one rod, one or two drawers</td></tr>
    <tr><td>Standard</td><td class="num">₹1,400–1,800</td><td class="num">about ₹95,000</td><td>Branded plywood, better laminates or a few acrylic shutters, branded hinges and channels, more drawers</td></tr>
    <tr><td>Premium</td><td class="num">₹2,000–3,000</td><td class="num">about ₹1.5 lakh</td><td>Acrylic, veneer, PU or glass shutters, premium hardware, internal lights and organisers</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026. Hosur is about 8% lower.</p>

<h2>What doors and finishes add</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Choice</th><th class="num">Rate or multiplier</th><th>Notes</th></tr></thead>
  <tbody>
    <tr><td>Hinged doors, laminate</td><td class="num">₹1,400 per sq ft</td><td>The base rate</td></tr>
    <tr><td>Sliding doors, laminate</td><td class="num">₹1,650 per sq ft</td><td>Track system and a deeper carcass</td></tr>
    <tr><td>Acrylic shutters</td><td class="num">× 1.3</td><td>Gloss shows fingerprints; matte acrylic hides them</td></tr>
    <tr><td>Lacquered glass</td><td class="num">× 1.4</td><td>Usually in aluminium-framed sliding doors</td></tr>
    <tr><td>Wood veneer</td><td class="num">× 1.5</td><td>Real grain under a PU or melamine polish</td></tr>
    <tr><td>PU paint</td><td class="num">× 1.7</td><td>Any colour; suits grooved shutters</td></tr>
  </tbody>
</table>
</div>
<p>See <a href="/compare/acrylic-vs-laminate/">acrylic vs laminate</a> and <a href="/compare/veneer-vs-laminate/">veneer vs laminate</a> to choose, and <a href="/wardrobe/sliding-wardrobe/">sliding wardrobes</a> for track systems.</p>

<h2>Accessories</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Accessory</th><th class="num">Indicative price</th></tr></thead>
  <tbody>
    <tr><td>Sensor lighting</td><td class="num">₹3,500</td></tr>
    <tr><td>Trouser pull-out</td><td class="num">₹4,500</td></tr>
    <tr><td>Shoe rack insert</td><td class="num">₹5,000</td></tr>
    <tr><td>Jewellery drawer</td><td class="num">₹6,000</td></tr>
    <tr><td>Full-length pull-out mirror</td><td class="num">₹7,000</td></tr>
    <tr><td>Pull-down hanger (for high rods)</td><td class="num">₹9,000</td></tr>
  </tbody>
</table>
</div>
<p>How to plan the inside before choosing accessories is covered in <a href="/wardrobe/wardrobe-internal-design/">wardrobe internal design</a>.</p>

<h2>Worked examples</h2>
<h3>A 7 ft hinged wardrobe with loft</h3>
<div class="table-wrap">
<table>
  <thead><tr><th>Line</th><th>Working</th><th class="num">Amount</th></tr></thead>
  <tbody>
    <tr><td>Body</td><td>7 ft × 7 ft = 49 sq ft × ₹1,400</td><td class="num">₹68,600</td></tr>
    <tr><td>Loft</td><td>7 ft × 2 ft = 14 sq ft × ₹1,400 × 0.55</td><td class="num">₹10,780</td></tr>
    <tr><td>Accessories</td><td>Trouser pull-out, sensor light</td><td class="num">₹8,000</td></tr>
    <tr><td>GST</td><td>18%</td><td class="num">₹15,728</td></tr>
    <tr><td><strong>Total</strong></td><td></td><td class="num"><strong>about ₹1.03 lakh</strong></td></tr>
  </tbody>
</table>
</div>
<h3>The same wardrobe with sliding doors</h3>
<p>Body 49 sq ft × ₹1,650 = ₹80,850, loft 14 sq ft × ₹1,650 × 0.55 = ₹12,705, accessories ₹8,000, GST ₹18,280: about <strong>₹1.2 lakh</strong>.</p>

<h2>Typical totals by size</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Wardrobe</th><th class="num">Hinged, laminate</th><th class="num">Sliding, laminate</th><th class="num">Hinged, acrylic</th></tr></thead>
  <tbody>
    <tr><td>4 ft wide, 7 ft + 2 ft loft</td><td class="num">₹60,000–65,000</td><td class="num">₹70,000–75,000</td><td class="num">₹77,000–82,000</td></tr>
    <tr><td>6 ft wide, 7 ft + 2 ft loft</td><td class="num">₹85,000–92,000</td><td class="num">₹1–1.07 lakh</td><td class="num">₹1.1–1.17 lakh</td></tr>
    <tr><td>8 ft wide, 7 ft + 2 ft loft</td><td class="num">₹1.12–1.2 lakh</td><td class="num">₹1.32–1.4 lakh</td><td class="num">₹1.45–1.52 lakh</td></tr>
    <tr><td>10 ft wide, 7 ft + 2 ft loft</td><td class="num">₹1.4–1.47 lakh</td><td class="num">₹1.62–1.7 lakh</td><td class="num">₹1.8–1.87 lakh</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Base rates of ₹1,400 (hinged) and ₹1,650 (sliding) per sq ft, loft at 55% of the rate, two accessories (about ₹8,000) and 18% GST. Indicative Bengaluru prices, October 2026.</p>

<h2>Reading a wardrobe quotation</h2>
<ol>
  <li><strong>Check the measured area.</strong> Width × height for the body and the loft, written separately.</li>
  <li><strong>Check the board.</strong> Brand, grade (MR, BWR) and thickness: 18 mm for the carcass, 8–9 mm or more for the back.</li>
  <li><strong>Check the shutters.</strong> Finish name and series; the inside of the shutters should be laminated too.</li>
  <li><strong>Check the hardware.</strong> Hinge and channel brand and type (soft-close, full-extension).</li>
  <li><strong>Check what is extra.</strong> Handles, internal drawers, accessories, lights and GST.</li>
</ol>
<p>Pricing a whole bedroom? See <a href="/cost/bedroom-interior-cost/">bedroom interior cost</a>. For wardrobes built and installed in South-East Bengaluru, our execution partner Huma Interiors makes <?= huma('wardrobe', 'sliding, hinged and walk-in wardrobes in Chandapura') ?> and quotes each of the lines above separately.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
