<?php
/* PILLAR PAGE — Wardrobes (/wardrobe/)
   Cluster links ("In this guide") come from includes/nav.php → 'wardrobe'.
   Images: /assets/pages/wardrobe/   (hero.jpg = main image)
   Rates used on this page are in $RATES so they are edited in one place. */
$RATES = [   // grade => [₹ per sq ft of front (hinged, laminate, before GST), typical 7 × 8 ft total incl. GST, what you get]
  'Essential' => ['₹1,100–1,400', 'about ₹70,000', 'MR plywood or HDHMR carcass, laminate shutters, hinged doors, basic soft-close hinges, shelves, one hanging rod and one or two drawers'],
  'Standard'  => ['₹1,400–1,800', 'about ₹95,000', 'Branded plywood carcass, better laminates or a few acrylic shutters, branded hinges and drawer channels, more drawers'],
  'Premium'   => ['₹2,000–3,000', 'about ₹1.5 lakh', 'Acrylic, veneer, PU or glass shutters, premium hardware, internal lights and fitted organisers'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'wardrobe',
  'title'        => 'Wardrobe Designs for Bedrooms: Types, Sizes and Cost',
  'seo_title'    => 'Wardrobe Designs for Bedroom: Types & Cost',
  'crumb'        => 'Wardrobes',
  'description'  => 'Wardrobe designs for bedroom use: hinged, sliding and walk-in types, standard sizes, internal layouts, boards, finishes, hardware and cost per sq ft.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'What to decide before you order a wardrobe, in order: the type, the doors, the size, the layout inside, then boards, finish, hardware and budget.',
  'hero_alt'     => 'Floor-to-ceiling bedroom wardrobe with laminate shutters and a loft above',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'Most bedrooms suit a fitted wardrobe about 24 inches (60 cm) deep, built up to the ceiling with a loft. Choose hinged doors if there is about 2 ft of clear floor in front, and sliding doors if there is not. In Bangalore, a hinged laminate wardrobe costs roughly ₹1,100–1,400 per sq ft of front in essential grade, ₹1,400–1,800 in standard grade and ₹2,000–3,000 in premium grade before GST, so a 7 × 8 ft wardrobe comes to about ₹70,000, ₹95,000 or ₹1.5 lakh including GST.',
  'faq' => [
    'Which is better, a hinged or a sliding wardrobe?' => 'Hinged doors cost less, open the whole wardrobe at once and are simple to repair, but they need about 2 ft of clear floor to swing. Sliding doors need no swing space and suit wardrobes 6 ft or wider, at roughly 15–20% more. Let the gap between the wardrobe and the bed decide.',
    'What is the standard depth of a bedroom wardrobe?' => 'About 24 inches (60 cm) for a hinged wardrobe, which lets clothes hang without touching the doors. A sliding wardrobe is usually about 26 inches (65 cm) deep, because the door tracks take up the extra space.',
    'How is wardrobe cost calculated?' => 'Most firms quote per square foot of front, which is the width multiplied by the height, loft included. A 7 ft wide, 8 ft high wardrobe is 56 sq ft. Drawers, accessories and 18% GST are usually added to that figure, so ask for each as a separate line.',
    'Which board is best for a bedroom wardrobe?' => 'MR-grade plywood or HDHMR board, 18 mm thick, is enough for a dry bedroom. Move up to BWR plywood only if the wardrobe stands against a bathroom wall or the room is prone to damp. The hinges and drawer channels affect daily use more than a costlier board.',
    'How much space does a walk-in closet need?' => 'About 5 ft of clear width for storage along one side, and about 7 ft for storage on both sides. That allows 2 ft for the units and a 3 ft aisle to stand and dress in.',
    'How long does it take to make a wardrobe?' => 'About four to six weeks from a signed design: two to three weeks of factory production and one to two days of installation for each wardrobe. Ordered together with a modular kitchen, allow 45–60 days.',
  ],
  'related' => [   // sibling pillar guides
    ['/modular-kitchen/', 'Modular kitchen design guide', 'Layouts, materials and cost', 'Pillar guide'],
    ['/cost/', 'Interior design cost guide', 'Home and room-wise budgets', 'Pillar guide'],
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
  ],
  'partner'      => ['follow' => false],   // the in-text partner link is followed; keep the box nofollow
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>A wardrobe is usually the largest piece of furniture in a bedroom, and once it is fixed to the wall it stays there for many years, so the order of decisions matters. The room decides which type fits, the floor space decides the doors, your clothes decide the layout inside, and only then do boards, finishes and hardware come in. This guide to wardrobe designs for bedrooms follows that order, with common sizes and indicative Bengaluru prices, and links to a detailed page for each step.</p>

<h2>Wardrobe types at a glance</h2>
<p>Four types cover almost every bedroom. Measure the wall, the clear floor in front of it and the ceiling height first; those three figures usually make the choice for you.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Type</th><th>Works best in</th><th>Space it needs</th><th>Watch out for</th></tr></thead>
  <tbody>
    <tr><td>Hinged (openable doors)</td><td>Most bedrooms; the least expensive fitted option</td><td>About 2 ft of clear floor for the doors to swing</td><td>Doors clashing with the bed or the room door</td></tr>
    <tr><td>Sliding</td><td>Rooms where the bed sits close; walls of 6 ft or more</td><td>No swing space, but a slightly deeper carcass</td><td>Only part of the wardrobe is open at one time</td></tr>
    <tr><td>Walk-in closet</td><td>Master bedrooms with a spare alcove or passage</td><td>About 5 ft wide for one side of storage, 7 ft for two</td><td>Needs its own lighting and ventilation</td></tr>
    <tr><td>Open wardrobe (no shutters)</td><td>Inside a walk-in or dressing area</td><td>Same depth, no door clearance</td><td>Dust, and everything stays on show</td></tr>
  </tbody>
</table>
</div>
<p>Whichever type you pick, build it from floor to ceiling. The top section is normally a separate <strong>loft</strong> with its own shutters, for suitcases, bedding and out-of-season clothes. Two types have their own pages: <a href="/wardrobe/sliding-wardrobe/">sliding wardrobes</a> and <a href="/wardrobe/walk-in-closet/">walk-in closet design</a>. If the same wall has to hold a mirror and a dresser, see <a href="/rooms/vanity-dressing/">vanity and dressing units</a>.</p>

<h2>Hinged or sliding doors</h2>
<p>This choice is mainly a question of floor space, and then of budget.</p>
<div class="pros-cons">
  <div><span class="pros-cons__title">Hinged doors</span><ul><li>The whole wardrobe opens at once, so everything is visible</li><li>Simple hardware; a hinge is easy to adjust or replace</li><li>The back of a door can carry a mirror or hooks</li><li>Need about 2 ft of clear floor for the doors to swing</li></ul></div>
  <div><span class="pros-cons__title">Sliding doors</span><ul><li>No swing space, so the bed can sit closer</li><li>Wider doors, about 2.5–4 ft each, give a flat front that suits mirror or glass</li><li>The carcass is a little deeper to make room for the tracks</li><li>Only half or a third of the wardrobe is open at one time</li><li>Cost more, and work best on a wardrobe at least 6 ft wide</li></ul></div>
</div>
<div class="callout"><span class="callout__title">A quick test</span>Measure from the wardrobe front to the edge of the bed. With 3 ft or more, hinged doors are comfortable and cost less. With less than about 2.5 ft, choose sliding doors.</div>

<h2>Standard wardrobe sizes</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Dimension</th><th>Common size</th><th>Why it matters</th></tr></thead>
  <tbody>
    <tr><td>Depth, hinged</td><td>24 inches (60 cm)</td><td>Clothes on hangers clear the doors</td></tr>
    <tr><td>Depth, sliding</td><td>About 26 inches (65 cm)</td><td>The door tracks take up the extra depth</td></tr>
    <tr><td>Height</td><td>Body about 7 ft, loft above it to the ceiling</td><td>Daily storage stays within reach</td></tr>
    <tr><td>Short-hang section</td><td>About 40 inches (100 cm)</td><td>Shirts, kurtas, blouses and folded trousers; two can be stacked</td></tr>
    <tr><td>Long-hang section</td><td>60–66 inches (150–168 cm)</td><td>Sarees on hangers, gowns, long kurtas and coats</td></tr>
    <tr><td>Shelf spacing</td><td>12–15 inches (30–38 cm)</td><td>Folded piles stay low enough not to topple</td></tr>
    <tr><td>Shelf width</td><td>Up to about 3 ft (90 cm)</td><td>A wider 18 mm shelf tends to sag under weight</td></tr>
    <tr><td>Drawer height</td><td>6–8 inches (15–20 cm); about 4 inches for accessory trays</td><td>Shallow drawers keep small items in one layer</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Common trade sizes, not fixed rules. Check them against your own height.</p>
<p>How the bed, the wardrobe and the room door fit together is covered in <a href="/rooms/master-bedroom/">master bedroom design</a>.</p>

<h2>Planning the inside</h2>
<p>The inside matters more than the front. Before anything is drawn, count how many garments hang, how many are folded and how many need full-length hanging. Then plan each wardrobe for the person who will use it.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>User</th><th>Hanging</th><th>Shelves</th><th>Drawers</th></tr></thead>
  <tbody>
    <tr><td>Couple, master bedroom</td><td>About half the width: one long-hang bay, the rest stacked short-hang</td><td>Mid-height shelves for folded daily wear, one side each</td><td>Two or three at waist height, one lockable</td></tr>
    <tr><td>Children</td><td>One low rod they can reach, raised as they grow</td><td>Mostly shelves, on adjustable supports</td><td>Two low drawers for uniforms and socks</td></tr>
    <tr><td>Guest room</td><td>One short-hang bay</td><td>A few shelves; the rest for bedding and household storage</td><td>One is enough</td></tr>
  </tbody>
</table>
</div>
<p>Whoever uses it, arrange the wardrobe by reach. Daily clothes belong between knee and eye level, and drawers at waist height, where you can see into them. The lowest foot or so suits shoes and bags, and the loft takes things used a few times a year. See also <a href="/rooms/kids-room/">kids room design</a> and <a href="/planning/storage-room-by-room/">storage, room by room</a>.</p>

<h2>Boards and shutter finishes</h2>
<h3>Carcass board</h3>
<p>The carcass is the box behind the shutters, with its shelves and partitions. A bedroom is a dry room, so it does not need kitchen-grade board. MR-grade plywood or HDHMR board, 18 mm thick, is the usual choice, with a thinner back panel. Step up to BWR plywood where the wardrobe stands against a bathroom wall. Grades are explained in the <a href="/materials/plywood-guide/">plywood guide</a> and the engineered option in <a href="/materials/hdhmr-board/">HDHMR board</a>.</p>
<div class="callout callout--warn"><span class="callout__title">Check the wall first</span>No board grade makes up for a wet wall. If the wardrobe wall shows damp patches, have the seepage treated before the wardrobe is fixed.</div>
<h3>Shutter finishes</h3>
<ul>
  <li><strong>Laminate</strong> has the widest range of colours, stands up best to daily handling and costs the least. See the <a href="/materials/laminate-guide/">laminate guide</a>.</li>
  <li><strong>Acrylic</strong> gives a deep gloss or a soft matte surface at about 1.3–1.6 times the laminate price. Gloss shows fingerprints. See the <a href="/materials/acrylic-finish/">acrylic finish guide</a>.</li>
  <li><strong>Wood veneer</strong> is real wood grain under a clear polish, at about 1.5–2 times laminate. See <a href="/materials/wood-veneer/">wood veneer</a>.</li>
  <li><strong>PU paint</strong> comes in any colour and suits grooved or shaped shutters. It can chip, but it can be repaired. See <a href="/materials/pu-finish/">PU finish</a>.</li>
  <li><strong>Lacquered glass</strong> gives a flat, reflective colour, usually in aluminium-framed sliding doors. It is heavy on hardware. See <a href="/materials/lacquered-glass/">lacquered glass</a>.</li>
  <li><strong>Mirror</strong> shutters save a separate dressing mirror. Ask for a safety backing film, and keep mirror to one or two doors.</li>
</ul>
<p>A sensible mix is laminate on most shutters and a richer finish on one or two. Compare <a href="/compare/acrylic-vs-laminate/">acrylic vs laminate</a> and <a href="/compare/veneer-vs-laminate/">veneer vs laminate</a>.</p>

<h2>Hardware and accessories</h2>
<ul>
  <li><strong>Hinges.</strong> Soft-close concealed hinges on every shutter. A 7 ft shutter normally takes four; heavier mirror shutters may need more.</li>
  <li><strong>Sliding systems.</strong> Rollers carry each door on a bottom track or hang it from a top track, with soft-close dampers at both ends.</li>
  <li><strong>Drawer channels.</strong> Full-extension, soft-close channels let you reach the back of the drawer.</li>
  <li><strong>Trouser pull-outs.</strong> A sliding frame of rails that keeps trousers flat and visible in a narrow bay.</li>
  <li><strong>Tie, belt and jewellery trays.</strong> Shallow, divided drawers for small things.</li>
  <li><strong>Internal lights.</strong> LED strips on a door or motion sensor. They need a power point planned before installation.</li>
</ul>
<p>As an indicative Bengaluru figure, each fitted accessory adds roughly ₹3,500–9,000 before GST. Trade names are explained in <a href="/glossary/hardware-terms/">hardware terms</a>.</p>
<div class="callout callout--tip"><span class="callout__title">Drawers behind doors</span>An internal drawer has to clear the open door and its hinges, and in a sliding wardrobe it must not sit behind the overlap of two doors. Ask to see each drawer drawn fully open.</div>

<h2>What a wardrobe costs</h2>
<p>Fitted wardrobes are priced per square foot of front: the width of the wardrobe multiplied by its height, loft included. Ask whether drawers, handles and the loft are inside the rate. The table shows indicative Bengaluru rates for October 2026 for a hinged wardrobe with laminate shutters.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Grade</th><th class="num">Per sq ft of front</th><th class="num">Typical 7 × 8 ft wardrobe with loft</th><th>What you get</th></tr></thead>
  <tbody>
<?php foreach ($RATES as $grade => [$sqft, $total, $what]): ?>
    <tr><td><?= e($grade) ?></td><td class="num"><?= e($sqft) ?></td><td class="num"><?= e($total) ?></td><td><?= e($what) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Rates per sq ft are before GST. Typical totals include 18% GST and assume a simple inside, priced towards the lower end of each band. Hosur usually comes in 5–10% lower than Bengaluru.</p>
<h3>Worked example: a 7 × 8 ft wardrobe</h3>
<p>A wardrobe 7 ft wide and 8 ft high has a front of 7 × 8 = 56 sq ft. At a standard-grade rate of ₹1,400 per sq ft, that is 56 × 1,400 = ₹78,400. Adding 18% GST brings it to about ₹92,500, close to the typical figure in the table. At ₹1,800 per sq ft it is ₹1,00,800 before GST and about ₹1.19 lakh with it.</p>
<p>Sliding doors usually add 15–20% for the track system, and a little more when the shutters are heavy glass or mirror. Finish, drawers and hardware brand move the price next. A full breakdown is in <a href="/cost/wardrobe-cost/">wardrobe cost</a>, and you can price your own size in the <a href="/calculators/wardrobe-cost/">wardrobe cost calculator</a>. For the whole room, see <a href="/cost/bedroom-interior-cost/">bedroom interior cost</a>.</p>

<h2>Process and timeline</h2>
<ol class="steps">
  <li><strong>Site measurement</strong>Wall width, ceiling height, beams, skirting and switchboards are measured, and the wall is checked for damp.</li>
  <li><strong>Design and internal layout</strong>Agree the door type and the front, then the inside, bay by bay.</li>
  <li><strong>Itemised quotation</strong>Board, finish, hardware brand and each accessory listed line by line, with GST shown separately.</li>
  <li><strong>Electrical work</strong>Points for internal lights are added, and any switchboard the wardrobe would cover is moved.</li>
  <li><strong>Factory production</strong>Panels are cut, edge-banded and drilled. Allow two to three weeks.</li>
  <li><strong>Installation and snag check</strong>Each wardrobe takes one to two days to fix. Check door gaps, alignment and drawer movement before signing off.</li>
</ol>
<p>Wardrobes on their own usually take four to six weeks from a signed design. Ordered together with a modular kitchen, allow 45–60 days for both.</p>

<h2>Common wardrobe mistakes</h2>
<ul>
  <li><strong>Choosing the doors before measuring the floor.</strong> The gap to the bed decides between hinged and sliding, not the catalogue.</li>
  <li><strong>Stopping short of the ceiling.</strong> The gap gathers dust and loses a loft.</li>
  <li><strong>Covering a switchboard or crowding the air-conditioner.</strong> Mark both on the drawing before production starts.</li>
  <li><strong>Mirror or gloss on every shutter.</strong> Both show fingerprints. Use them on one or two doors.</li>
</ul>
<p>If your family follows vastu, traditional guidance usually places heavy wardrobes along the south or west wall and avoids a mirror that faces the bed. These are customs that many households observe, not technical requirements; see <a href="/vastu/bedroom-vastu/">bedroom vastu</a>.</p>
<?php /* INTERLINK: local guides + execution partner (scratchpad edits.py) */ ?>
<h2>Wardrobes for homes in Electronic City, Chandapura and Bommasandra</h2>
<p>Second bedrooms in many apartment projects off Hosur Road are compact, so the wardrobe wall decides how the whole room works. For ideas that fit those rooms, see <a href="/blogs/wardrobe-designs-small-bedrooms/">wardrobe designs for small bedrooms</a> and <a href="/blogs/wardrobe-with-dressing-unit-ideas/">wardrobes with a dressing unit</a>; for humidity, read <a href="/blogs/monsoon-proof-kitchen-wardrobe/">monsoon-proof kitchens and wardrobes</a>. Local costs and builders are covered in the <a href="/interior-designers-bangalore/chandapura/">Chandapura</a> and <a href="/interior-designers-bangalore/electronic-city/">Electronic City</a> area guides.</p>
<p>Huma Interiors, our execution partner, builds <?= huma('wardrobe', 'sliding and hinged wardrobes in Chandapura') ?> to the sizes and internals described above, for homes across South-East Bengaluru.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
