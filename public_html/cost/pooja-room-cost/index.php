<?php
/* CLUSTER PAGE — Pooja room cost (/cost/pooja-room-cost/)
   Figures match /cost/ (room-wise table) and includes/calc/rates.php → 'quote' pooja items. */
$page = [
  'type'         => 'article',
  'title'        => 'Pooja Room Cost in 2026: Wall Units, Floor Units and Full Pooja Rooms',
  'seo_title'    => 'Pooja Room and Pooja Unit Cost (2026)',
  'crumb'        => 'Pooja Room Cost',
  'description'  => 'Pooja unit and pooja room cost in 2026: wall and floor units, jaali and temple doors, Corian and marble backs, lighting and full rooms with flooring.',
  'eyebrow'      => 'Cost',
  'lede'         => 'From a compact wall unit in a flat to a full room in a house, here is what each kind of pooja space costs and what drives the price.',
  'hero_alt'     => 'Wooden pooja unit with jaali doors, a back-lit panel and brass bells',
  'published'    => '2026-10-05',
  'updated'      => '2026-10-05',
  'quick_answer' => 'A pooja unit costs about ₹20,000–40,000 in essential grade, ₹40,000–75,000 in standard and ₹80,000–2 lakh in premium, including GST. The box itself is about ₹1,500 per sq ft of front before GST; doors, back panels in marble or Corian, CNC jaali work, lighting and drawers make up the rest. A full pooja room with flooring, ceiling and door costs ₹1.5–4 lakh.',
  'takeaways'    => [
    'Wall-mounted units suit small flats; floor units with storage suit larger living or dining areas.',
    'CNC-cut jaali in MDF or veneer is the most popular door; solid wood carving costs the most.',
    'A back-lit Corian or marble panel adds ₹10,000–40,000 and transforms the unit.',
    'Plan a light point, a 5A socket and ventilation for lamps and incense.',
  ],
  'faq' => [
    'How much does a pooja unit cost?' => 'About ₹20,000–40,000 in essential grade, ₹40,000–75,000 in standard and ₹80,000–2 lakh in premium, including GST, depending on size, doors, back panel and lighting.',
    'What is the cost of a pooja room door?' => 'A pair of CNC jaali doors in MDF with PU paint costs about ₹15,000–35,000; veneer or teak-finish doors ₹25,000–60,000; a solid teak carved door ₹60,000–1.5 lakh or more.',
    'Is a wall-mounted pooja unit a good idea?' => 'In small flats, yes. It saves floor space and keeps the idols at eye level. Check that the wall can carry the load and fix the unit to a ply backing.',
    'Which material is best for a pooja unit?' => 'BWR or MR plywood with laminate or veneer for the box, a Corian, marble or quartz back panel that will not stain with oil or kumkum, and a stone or quartz base for lamps.',
  ],
  'related' => [
    ['/cost/', 'Interior design cost guide', 'Home and room-wise budgets', 'Pillar guide'],
    ['/rooms/pooja-room/', 'Pooja room designs', 'Units, doors, materials and lighting', 'Rooms'],
    ['/doors/pooja-room-door-design/', 'Pooja room door designs', 'Jaali, glass and carved doors', 'Doors'],
  ],
  'sources' => [
    ['Enteriors quote builder rate sheet, October 2026', '/calculators/home-interior-quote/', 'pooja unit, lighting and drawer rates'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Almost every Indian home has a place for prayer, from a shelf in a 1 BHK to a full room in an independent house. This page prices each kind, using the same Bengaluru rates as our <a href="/calculators/home-interior-quote/">quote builder</a>. For designs, sizes and materials, see the <a href="/rooms/pooja-room/">pooja room guide</a>.</p>

<h2>Three kinds of pooja space</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Type</th><th>Typical size</th><th class="num">Essential</th><th class="num">Standard</th><th class="num">Premium</th></tr></thead>
  <tbody>
    <tr><td>Wall-mounted unit</td><td>2.5–3 ft wide, 3 ft high</td><td class="num">₹20,000–30,000</td><td class="num">₹40,000–55,000</td><td class="num">₹80,000–1.2 lakh</td></tr>
    <tr><td>Floor unit with storage</td><td>3–4 ft wide, 6–7 ft high</td><td class="num">₹30,000–40,000</td><td class="num">₹55,000–75,000</td><td class="num">₹1.2–2 lakh</td></tr>
    <tr><td>Full pooja room</td><td>4×5 ft and up</td><td class="num">₹1.5–2 lakh</td><td class="num">₹2–3 lakh</td><td class="num">₹3–4 lakh+</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026, including GST. A full room includes the unit, door, flooring, ceiling and lighting.</p>
<?= img('pooja-unit-with-jaali-doors', caption: 'A floor-standing pooja unit with CNC jaali doors, a back-lit panel and a drawer for samagri') ?>

<h2>What makes up the price</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Part</th><th class="num">Indicative cost</th></tr></thead>
  <tbody>
    <tr><td>Box unit, laminate finish</td><td class="num">about ₹1,500 per sq ft of front, before GST</td></tr>
    <tr><td>CNC jaali doors in MDF with PU paint (pair)</td><td class="num">₹15,000–35,000</td></tr>
    <tr><td>Veneer or teak-finish doors (pair)</td><td class="num">₹25,000–60,000</td></tr>
    <tr><td>Solid teak carved door</td><td class="num">₹60,000–1.5 lakh+</td></tr>
    <tr><td>Back panel in Corian or quartz, back-lit</td><td class="num">₹15,000–40,000</td></tr>
    <tr><td>Marble or quartz base for lamps</td><td class="num">₹5,000–15,000</td></tr>
    <tr><td>Soft-close drawer for samagri</td><td class="num">about ₹2,600</td></tr>
    <tr><td>Light point, 5A plug and LED</td><td class="num">about ₹2,900</td></tr>
    <tr><td>Bells and brass fittings</td><td class="num">₹2,000–10,000</td></tr>
  </tbody>
</table>
</div>
<p>Door styles are compared in <a href="/doors/pooja-room-door-design/">pooja room door designs</a>.</p>

<h2>Materials that last</h2>
<ul>
  <li><strong>Box:</strong> BWR or MR plywood with laminate or veneer; avoid MDF near water used for abhishekam.</li>
  <li><strong>Back:</strong> Corian, quartz or marble, which do not absorb oil, ghee or kumkum.</li>
  <li><strong>Base for lamps:</strong> stone or quartz, never laminate; a diya can scorch it.</li>
  <li><strong>Ventilation:</strong> jaali doors or a gap at the top so smoke from lamps and incense escapes.</li>
</ul>

<h2>Placement</h2>
<p>Vastu tradition places the pooja space in the north-east, with the person praying facing east or north; see <a href="/vastu/pooja-room-vastu/">pooja room vastu</a>. In flats, a quiet corner of the living or dining area, away from the toilet walls and the TV, works well.</p>
<p>Our execution partner in South-East Bengaluru builds <?= huma('chandapura', 'pooja units in its Chandapura factory', follow: false) ?>, including CNC jaali doors and back-lit panels, as part of full home interiors.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
