<?php
/* PILLAR PAGE — Modular Kitchen (/modular-kitchen/)
   Cluster links ("In this guide") come from includes/nav.php → 'modular-kitchen'.
   Images: /assets/pages/modular-kitchen/   (hero.jpg = main image)
   Rates used on this page are in $RATES so they are edited in one place. */
$RATES = [   // grade => [base unit ₹ per running ft, typical L-shape total, what you get]
  'Essential' => ['₹3,500–4,500', '₹1.3–1.7 lakh', 'BWR plywood or HDHMR carcass, laminate shutters, basic soft-close fittings, granite top'],
  'Standard'  => ['₹4,500–6,000', '₹1.9–2.6 lakh', 'BWP plywood near the sink, laminate with some acrylic fronts, branded fittings, granite or quartz top'],
  'Premium'   => ['₹6,500–9,500', '₹3–4.5 lakh', 'BWP plywood throughout, acrylic, PU or veneer fronts, premium hardware, quartz top, tall unit and organisers'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'modular-kitchen',
  'title'        => 'Modular Kitchen Design: Layouts, Materials and Cost',
  'seo_title'    => 'Modular Kitchen Design Guide: Layouts & Cost',
  'crumb'        => 'Modular Kitchen',
  'description'  => 'Plan a modular kitchen for an Indian home: six layouts compared, cabinet boards and shutter finishes, countertops, hardware, per-running-foot cost and timeline.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'Everything to decide before you order a kitchen, in the order you will decide it: layout, boards, finish, countertop, hardware and budget.',
  'hero_alt'     => 'Modular kitchen with wall units, base units and a tall unit',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'A modular kitchen is built from factory-made cabinets fixed on site. In Bangalore, a typical L-shape kitchen (about 10 ft of base units and 8 ft of wall units) costs roughly ₹1.3–1.7 lakh in essential grade, ₹1.9–2.6 lakh in standard grade and ₹3–4.5 lakh in premium grade, including GST. Choose the layout first, then the cabinet board, then the shutter finish.',
  'faq' => [
    'Which layout is best for a small Indian kitchen?' => 'A straight or L-shape layout. Both keep the floor clear and need the fewest corner fittings. In a kitchen under 80 sq ft, avoid a U-shape unless the room is at least 8 ft wide, or the two runs will leave too little standing space.',
    'Which board is best for kitchen cabinets?' => 'Boiling-water-proof (BWP) plywood is the safest choice under the sink and near the dishwasher. BWR plywood or HDHMR works well for the remaining cabinets. Keep MDF and particle board for dry areas only.',
    'How is modular kitchen cost calculated?' => 'Most firms quote per running foot of base unit, then add wall units, lofts and tall units as a share of that rate. Countertop, backsplash, accessories, appliances and 18% GST are added on top. Ask for each of these as a separate line.',
    'How long does a modular kitchen take?' => 'About four to six weeks from a signed design: two to three weeks in the factory, three to five days to install, plus the countertop and any plumbing or electrical changes.',
    'Is a modular kitchen better than a carpenter-made kitchen?' => 'A factory-made kitchen has machine-cut panels and pressed edge banding, so the finish is more consistent and it can be dismantled. A carpenter-made kitchen fits odd walls more easily and may cost less. The quality of board, hardware and edge sealing matters more than the method.',
    'How long does a modular kitchen last?' => 'With a water-resistant carcass, sealed edges and branded hinges and channels, 12 to 15 years of daily cooking is realistic. Hinges and channels can be replaced; swollen boards cannot.',
  ],
  'related' => [   // sibling pillar guides
    ['/wardrobe/', 'Wardrobe design guide', 'Types, sizes, internals and cost', 'Pillar guide'],
    ['/cost/', 'Interior design cost guide', 'Home and room-wise budgets', 'Pillar guide'],
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>The kitchen is the most engineered room in a home. Water, heat, oil and weight all meet in a few square feet, and every cabinet is opened many times a day. That is why kitchen decisions are best taken in a fixed order: the layout decides how you move, the boards decide how long the cabinets last, the finish decides how it looks and cleans, and the hardware decides how it feels to use. This guide follows that order and links to a detailed page for each step.</p>

<h2>What makes a kitchen modular</h2>
<p>A modular kitchen is assembled from separate cabinets (modules) that are cut, edge-banded and drilled in a factory and then fixed together on site. Three kinds of module do most of the work:</p>
<ul>
  <li><strong>Base units</strong> stand on the floor and carry the countertop, hob and sink. They hold the heaviest items, so most of them should be drawers.</li>
  <li><strong>Wall units</strong> hang above the counter for everyday crockery and groceries. A loft above them uses the space up to the ceiling.</li>
  <li><strong>Tall units</strong> run from floor to loft height for a pantry, a built-in oven or a microwave.</li>
</ul>
<p>Because modules are standard widths, a damaged shutter or a tired hinge can be replaced without rebuilding the kitchen. If you are weighing this against site-built cabinets, the trade-offs are set out in <a href="/compare/modular-vs-carpenter-kitchen/">modular vs carpenter-made kitchens</a>.</p>

<h2>Choosing a layout</h2>
<p>The room usually chooses the layout for you. Measure the clear wall lengths, mark the window, the gas point and the water inlet, and match them to the table below.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Layout</th><th>Works best in</th><th>Strength</th><th>Watch out for</th></tr></thead>
  <tbody>
    <tr><td>Straight (one wall)</td><td>Studio and 1 BHK kitchens, open kitchens</td><td>Cheapest, no corner units</td><td>Little counter space beside the hob</td></tr>
    <tr><td>L-shape</td><td>Most 2 and 3 BHK apartments</td><td>Good work triangle, one corner only</td><td>The corner needs a carousel or it becomes dead storage</td></tr>
    <tr><td>Parallel (galley)</td><td>Long, narrow kitchens with a utility at the end</td><td>Most counter per square foot</td><td>Needs about 4 ft clear between the two runs</td></tr>
    <tr><td>U-shape</td><td>Square kitchens of 100 sq ft or more</td><td>Maximum storage and counter</td><td>Two corners to fit out; feels tight under 8 ft width</td></tr>
    <tr><td>Peninsula (G-shape)</td><td>Open kitchens that need a divider</td><td>Adds a breakfast counter without a free-standing island</td><td>Entry gap must stay at least 3 ft</td></tr>
    <tr><td>Island</td><td>Large open kitchens, villas</td><td>Sociable; extra prep surface</td><td>Needs 3.5–4 ft clearance on all sides and floor-level services</td></tr>
  </tbody>
</table>
</div>
<p>A closer comparison of the two most common choices is in <a href="/modular-kitchen/l-shape-vs-u-shape/">L-shape vs U-shape kitchens</a>. If you are planning to open the kitchen to the living room, read <a href="/modular-kitchen/open-kitchen-ideas/">open kitchen ideas</a> before removing a wall.</p>

<h3>The work triangle</h3>
<p>Whatever the layout, keep the sink, the hob and the refrigerator at the three points of a triangle, with no leg shorter than about 4 ft or longer than about 9 ft. The usual order along the counter is storage, then washing, then preparation, then cooking, so that food moves in one direction.</p>

<h2>Sizes that make a kitchen comfortable</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Dimension</th><th>Common size</th><th>Why it matters</th></tr></thead>
  <tbody>
    <tr><td>Counter height</td><td>32–34 inches (81–86 cm)</td><td>Roughly half your height plus 2 inches; a lower counter strains the back</td></tr>
    <tr><td>Counter depth</td><td>24 inches (60 cm)</td><td>Fits standard hobs, sinks and built-in appliances</td></tr>
    <tr><td>Gap between counter and wall units</td><td>24 inches (60 cm)</td><td>Room for a mixer and a clear view of the counter</td></tr>
    <tr><td>Wall unit depth</td><td>12–14 inches (30–35 cm)</td><td>Deep enough for dinner plates without hitting your head</td></tr>
    <tr><td>Hob to chimney</td><td>26–30 inches (65–75 cm)</td><td>Follow the chimney maker's figure for suction and safety</td></tr>
    <tr><td>Aisle width</td><td>3.5–4 ft</td><td>Lets two people pass and drawers open fully</td></tr>
  </tbody>
</table>
</div>

<h2>Cabinet boards: the part you do not see</h2>
<p>The carcass, meaning the box behind each shutter, decides the life of the kitchen. It sits closest to leaks and steam, so choose it for water resistance first.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Board</th><th>Water tolerance</th><th>Use it for</th></tr></thead>
  <tbody>
    <tr><td>BWP plywood (boiling-water-proof)</td><td>Highest</td><td>Sink unit, dishwasher surround, any cabinet near plumbing</td></tr>
    <tr><td>BWR plywood (boiling-water-resistant)</td><td>High</td><td>All other base and wall units</td></tr>
    <tr><td>HDHMR board</td><td>Good if edges stay sealed</td><td>Shutters and dry carcasses; very smooth for acrylic and PU</td></tr>
    <tr><td>MDF</td><td>Low</td><td>Shutters in dry zones only</td></tr>
    <tr><td>Particle board</td><td>Lowest</td><td>Short-term or rental kitchens away from water</td></tr>
  </tbody>
</table>
</div>
<div class="callout callout--warn"><span class="callout__title">Ask in writing</span>Have the quotation name the board grade, the thickness (18 mm for carcass sides is the norm) and the brand for each cabinet group. "Waterproof ply" on its own is not a specification.</div>
<p>Grades and price bands are explained in the <a href="/materials/plywood-guide/">plywood guide</a>, and the engineered option in <a href="/materials/hdhmr-board/">HDHMR board</a>.</p>

<h2>Shutter finishes</h2>
<p>Shutters are what you see and wipe every day. The finish changes the look far more than the price of the board behind it.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Finish</th><th>Look</th><th>Daily use</th><th class="num">Cost against laminate</th></tr></thead>
  <tbody>
    <tr><td>Laminate</td><td>Matte, gloss or textured; widest colour range</td><td>Toughest against scratches and heat</td><td class="num">Base</td></tr>
    <tr><td>Membrane (PVC foil)</td><td>Seamless, can wrap grooved doors</td><td>Keep away from the hob and oven</td><td class="num">A little more</td></tr>
    <tr><td>Acrylic</td><td>Deep gloss or soft matte</td><td>Shows fingerprints in gloss; wipe with microfibre</td><td class="num">About 1.3–1.4×</td></tr>
    <tr><td>Lacquered glass</td><td>Reflective, very flat</td><td>Easy to clean; heavy on hinges</td><td class="num">About 1.5×</td></tr>
    <tr><td>PU paint</td><td>Any colour, satin to gloss</td><td>Can chip; can be repaired on site</td><td class="num">About 1.6×</td></tr>
  </tbody>
</table>
</div>
<p>For a kitchen that is cooked in every day, laminate on the base units and a richer finish on the wall units gives the best balance. See the <a href="/materials/acrylic-finish/">acrylic finish guide</a> and <a href="/compare/acrylic-vs-laminate/">acrylic vs laminate</a> for the detail.</p>

<h2>Countertop and backsplash</h2>
<ul>
  <li><strong>Granite</strong> is the default for Indian cooking: hard, heat-proof and the least expensive stone. Black and dark shades hide stains best.</li>
  <li><strong>Quartz</strong> is non-porous and uniform in colour. It costs more and should be protected from very hot vessels.</li>
  <li><strong>Sintered stone and large porcelain slabs</strong> resist heat and stains and suit premium kitchens, at the highest price.</li>
</ul>
<p>Ask for a 20 mm top with a front edge built up to about 40 mm, a slight slope towards the sink, and a drip groove under the front edge. The backsplash can be the same slab, tiles or lacquered glass. Options are compared in the <a href="/modular-kitchen/countertop-guide/">countertop guide</a> and <a href="/compare/quartz-vs-granite/">quartz vs granite</a>.</p>

<h2>Hardware and storage</h2>
<p>Hinges and drawer channels are the moving parts, and they take the wear. Budget for them before you budget for a costlier finish.</p>
<ul>
  <li><strong>Soft-close hinges</strong> on every shutter, with stainless steel versions near the sink.</li>
  <li><strong>Full-extension drawer systems</strong> under the hob for vessels, cutlery and spices. Drawers hold more usable storage than shelves behind a door.</li>
  <li><strong>A corner solution</strong> in L and U layouts, such as a carousel or a pull-out corner unit.</li>
  <li><strong>A tall pantry unit</strong> if the wall allows it. It stores more than two wall units and keeps groceries in one place.</li>
  <li><strong>Lift-up or bi-fold shutters</strong> on wall units above eye level, so open doors stay out of the way.</li>
</ul>
<p>Brands, load ratings and what to check on delivery are covered in the <a href="/modular-kitchen/hardware-guide/">kitchen hardware guide</a>, and internal organisers in <a href="/modular-kitchen/storage-solutions/">kitchen storage solutions</a>.</p>

<h2>What a modular kitchen costs</h2>
<p>Kitchens are priced per running foot of base unit. Wall units usually cost about 65% of the base rate per running foot and lofts about 40%. The table shows indicative Bengaluru rates for October 2026; the typical total is for an L-shape with about 10 ft of base units and 8 ft of wall units, including GST.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Grade</th><th class="num">Base unit, per running ft</th><th class="num">Typical L-shape total</th><th>What you get</th></tr></thead>
  <tbody>
<?php foreach ($RATES as $grade => [$rft, $total, $what]): ?>
    <tr><td><?= e($grade) ?></td><td class="num"><?= e($rft) ?></td><td class="num"><?= e($total) ?></td><td><?= e($what) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Base-unit rates are before GST. Appliances (hob, chimney, sink, built-in oven) are extra. Hosur usually comes in 5–10% lower than Bengaluru.</p>
<p>Four things move the price most: the number of drawers, the shutter finish, the hardware brand and the countertop. A full breakdown is in <a href="/cost/modular-kitchen-cost/">modular kitchen cost</a>, and you can price your own layout in the <a href="/calculators/modular-kitchen/">modular kitchen calculator</a>.</p>

<h2>From first measurement to first meal</h2>
<ol class="steps">
  <li><strong>Site measurement</strong>Walls, windows, beams, plumbing and electrical points are measured after plastering and before flooring is finalised.</li>
  <li><strong>Layout and 3D design</strong>Agree the layout, appliance list and storage plan. Fix the hob, sink and chimney positions now, because services depend on them.</li>
  <li><strong>Itemised quotation</strong>Board, finish, hardware brand, countertop and accessories listed line by line, with GST shown separately.</li>
  <li><strong>Services on site</strong>Plumbing lines, drain, gas pipe, electrical points and wall tiling are completed before cabinets arrive.</li>
  <li><strong>Factory production</strong>Panels are cut, edge-banded and drilled. Allow two to three weeks.</li>
  <li><strong>Installation</strong>Cabinets, countertop, sink, appliances and handles are fitted in three to five days, followed by a snag check.</li>
</ol>

<h2>Mistakes that are expensive to fix later</h2>
<ul>
  <li><strong>Too few sockets.</strong> Plan separate points for the mixer, microwave, oven, kettle, water purifier, chimney and refrigerator.</li>
  <li><strong>Shelves where drawers should be.</strong> Deep shelves under the counter hide what is at the back.</li>
  <li><strong>Forgetting the dustbin and the gas cylinder.</strong> Both need a planned cabinet with ventilation for the cylinder.</li>
  <li><strong>Gloss on every surface.</strong> It looks its best on day one. Keep gloss for wall units.</li>
  <li><strong>Choosing by brochure colour.</strong> See the actual laminate or acrylic sheet in your own kitchen light.</li>
  <li><strong>No under-cabinet light.</strong> Wall units cast a shadow on the counter exactly where you chop.</li>
</ul>
<p>If vastu matters in your home, the placement of the hob and sink is discussed in <a href="/vastu/kitchen-vastu/">kitchen vastu</a>.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
