<?php
/* PILLAR PAGE — Materials (/materials/)
   Cluster links ("In this guide") come from includes/nav.php → 'materials'.
   Images: /assets/pages/materials/   (hero.jpg = main image)
   Full-home rates used on this page are in $GRADES so they are edited in one place.
   Board prices match the table in cost/2-bhk-interior-cost/. */
$GRADES = [   // grade => [boards, finishes and fittings, ₹ per sq ft of carpet area, typical 2 BHK total]
  'Essential' => ['BWR plywood or HDHMR in the kitchen, MR plywood in bedrooms', '1 mm laminate throughout, basic soft-close hardware, granite top', '₹450–700', '₹4.2–6.5 lakh'],
  'Standard'  => ['BWP plywood near the sink, BWR elsewhere, HDHMR shutters', 'Laminate with acrylic on key fronts, branded fittings, granite or quartz top', '₹700–1,100', '₹6.5–10 lakh'],
  'Premium'   => ['BWP plywood through the kitchen, BWR plywood and HDHMR in dry rooms', 'Acrylic, PU or veneer on visible surfaces, premium hardware, quartz top', '₹1,100–1,700', '₹10.5–16 lakh'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'materials',
  'title'        => 'Interior Design Materials: Boards, Finishes and Stone',
  'seo_title'    => 'Interior Design Materials: Boards & Finishes',
  'crumb'        => 'Materials',
  'description'  => 'Interior design materials for Indian homes: plywood grades, HDHMR and MDF, laminate, acrylic, veneer and PU finishes, stone tops, prices and site checks.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'The boards, finishes and stone behind every kitchen, wardrobe and TV unit: what each is for, what it costs and how to check it on site.',
  'hero_alt'     => 'Plywood, laminate, veneer and stone samples laid out on a table',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'Interior woodwork has three layers: a core board, a surface finish, and edge bands with hardware. For most Bengaluru homes, use BWP (marine) plywood near water, BWR or MR plywood or HDHMR in dry rooms, and 1 mm laminate as the default finish. Acrylic costs about 1.3–1.6 times a laminate finish, and veneer or PU paint about 1.5–2 times.',
  'faq' => [
    'Which material is best for kitchen cabinets?' => 'BWP (marine) plywood for the sink unit and any cabinet near plumbing, and BWR plywood or HDHMR for the rest. Laminate is the toughest everyday shutter finish. Keep MDF and particle board for dry rooms.',
    'Is HDHMR better than plywood?' => 'Neither is better everywhere. HDHMR is denser and smoother, so it suits shutters and acrylic or PU finishes, and it usually costs less than BWP plywood. Plywood holds screws better when fittings are removed and refitted, and BWP plywood copes better with a leak.',
    'Do I need marine plywood for the whole house?' => 'No. BWP plywood earns its price in the kitchen, the bathroom vanity and the utility area. Bedroom wardrobes, TV units and study units in dry rooms work well in MR or BWR plywood or HDHMR.',
    'Which finish lasts longest on shutters?' => 'Laminate resists scratches, heat and daily wiping better than the other common finishes, and it costs the least. Acrylic and PU look richer but mark more easily. PU and veneer can be refinished, while a damaged acrylic or membrane shutter is replaced.',
    'What thickness of board and laminate should a quotation show?' => 'Look for 18 mm board for carcass sides and shutters, 6–9 mm for back panels and 1 mm laminate on visible faces. A thinner liner laminate inside the cabinets is normal, but it should be written down.',
    'How much do materials change the cost of interiors?' => 'A great deal. In Bengaluru, a 2 BHK of about 950 sq ft carpet area runs from roughly ₹4.2–6.5 lakh in essential materials to ₹10.5–16 lakh in premium materials, including GST. Board grade, shutter finish and hardware brand are the main reasons, along with a wider scope of ceilings and lighting.',
  ],
  'related' => [   // sibling pillar guides
    ['/modular-kitchen/', 'Modular kitchen design guide', 'Layouts, boards, finishes and cost', 'Pillar guide'],
    ['/wardrobe/', 'Wardrobe design guide', 'Types, sizes, internals and cost', 'Pillar guide'],
    ['/flooring/', 'Flooring guide', 'Tiles, marble, granite, wood and vinyl', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Underneath the drawings, every interior quotation is a list of materials: a board, a finish, an edge band and some hardware, repeated for each cabinet. Knowing what those words mean is the surest way to compare two quotes and to check what arrives at site. This guide covers the interior design materials used in Indian homes in the order you should choose them, with indicative Bengaluru prices for October 2026 and a detailed page on each one. Unfamiliar terms are explained in the <a href="/glossary/">materials glossary</a>.</p>

<h2>How interior woodwork is built: three layers</h2>
<p>A kitchen cabinet, a wardrobe and a TV unit are all made the same way.</p>
<ol class="steps">
  <li><strong>Core board</strong>The structural panel, usually 18 mm thick, that forms the carcass (the box) and the shutters. It decides strength, screw-holding and how the piece copes with water.</li>
  <li><strong>Surface finish</strong>The sheet or coating bonded to the board: laminate, acrylic, veneer or paint. It decides the look, the feel and how easily the surface cleans.</li>
  <li><strong>Edge band and hardware</strong>The strip that seals each cut edge, plus the hinges, channels and handles. They decide how the furniture feels in use and how long it stays sealed.</li>
</ol>
<p>Choose in that order. The board cannot be changed later without rebuilding the piece, a shutter finish can be replaced at moderate cost, and hinges and channels can be swapped in an afternoon. Saving on the board to pay for a richer finish puts the money in the wrong layer. How the layers are put together matters as well; see <a href="/compare/modular-vs-carpenter-kitchen/">modular vs carpenter-made</a> work.</p>

<h2>Boards compared</h2>
<p>Plywood is graded MR, BWR or BWP by how well its glue line stands up to water. IS 303 is the standard for general-purpose plywood and IS 710 the standard for marine plywood. The <a href="/materials/plywood-guide/">plywood guide</a> and <a href="/compare/bwp-vs-bwr-vs-mr-plywood/">BWP vs BWR vs MR plywood</a> explain the grades in detail.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Board</th><th>Water tolerance</th><th>Screw-holding</th><th>Best use</th><th class="num">18 mm, per sq ft</th></tr></thead>
  <tbody>
    <tr><td><a href="/materials/marine-plywood/">BWP (marine) plywood</a></td><td>Highest of the plywoods</td><td>Very good</td><td>Sink unit, kitchen base units, vanity, utility</td><td class="num">₹110–180</td></tr>
    <tr><td>BWR plywood</td><td>Good</td><td>Very good</td><td>Kitchen wall units, wardrobes in humid rooms</td><td class="num">₹90–140</td></tr>
    <tr><td><a href="/materials/mr-plywood/">MR plywood</a></td><td>Dry areas only</td><td>Very good</td><td>Bedroom wardrobes, TV and study units</td><td class="num">₹75–120</td></tr>
    <tr><td><a href="/materials/hdhmr-board/">HDHMR board</a></td><td>Good while edges stay sealed</td><td>Good; weaker if a hole is reused</td><td>Shutters, wardrobes, back panels</td><td class="num">₹70–110</td></tr>
    <tr><td><a href="/materials/mdf-board/">MDF board</a></td><td>Low</td><td>Fair; weak on edges</td><td>Painted, PU or routed shutters in dry rooms</td><td class="num">₹45–75</td></tr>
    <tr><td><a href="/materials/particle-board/">Particle board</a></td><td>Poor</td><td>Low</td><td>Loose, dry shelving only</td><td class="num">₹35–55</td></tr>
    <tr><td><a href="/materials/block-board/">Block board</a></td><td>Depends on the grade bought</td><td>Good</td><td>Long shelves, doors, bed frames</td><td class="num">₹80–130</td></tr>
    <tr><td><a href="/materials/wpc-board/">WPC board</a></td><td>Waterproof</td><td>Lower than plywood</td><td>Bathroom vanities, outdoor units</td><td class="num">₹100–170</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices for branded sheets, including GST, October 2026. Block board is usually sold in 19 mm.</p>
<p>Plywood's cross-laid layers grip a screw well even after it is removed and refitted. Fibreboards rely on density and lose grip when a hole is reused. The trade-offs are set out in <a href="/compare/hdhmr-vs-plywood/">HDHMR vs plywood</a> and <a href="/compare/mdf-vs-plywood/">MDF vs plywood</a>.</p>

<h2>Which board where</h2>
<p>No home needs one board throughout. Match the board to the water and the load in each zone.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Zone</th><th>Recommended board</th><th>Note</th></tr></thead>
  <tbody>
    <tr><td>Kitchen sink unit</td><td>BWP (marine) plywood</td><td>Closest to leaks; seal every pipe cut-out</td></tr>
    <tr><td>Other kitchen cabinets</td><td>BWP or BWR plywood carcass; HDHMR or plywood shutters</td><td>HDHMR gives a flatter base than plywood for acrylic and PU</td></tr>
    <tr><td>Wardrobes</td><td>MR plywood, or BWR on a wall shared with a bathroom; HDHMR shutters</td><td>BWP is rarely worth its price in a dry bedroom</td></tr>
    <tr><td>TV unit</td><td>MR plywood or HDHMR; MDF for painted or grooved panels</td><td>A dry zone, so choose for a smooth surface</td></tr>
    <tr><td>Bathroom vanity</td><td>BWP plywood or WPC</td><td>Keep it wall-hung, clear of the wet floor</td></tr>
    <tr><td>Long shelves and doors</td><td>Block board</td><td>Resists sagging over long spans</td></tr>
  </tbody>
</table>
</div>
<p>You can also work through these choices room by room in the <a href="/calculators/material-selector/">material selector</a>.</p>

<h2>Finishes compared</h2>
<p>The finish changes the look far more than the board behind it. <a href="/materials/laminate-guide/">Laminate</a> is the reference point; the last column shows what a finished shutter costs against it.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Finish</th><th>Look</th><th>Durability</th><th>Repair</th><th class="num">Cost against laminate</th></tr></thead>
  <tbody>
    <tr><td>Laminate</td><td>Matte, gloss, wood, stone and textured prints</td><td>Toughest against scratches and heat</td><td>Limited</td><td class="num">Base</td></tr>
    <tr><td><a href="/materials/acrylic-finish/">Acrylic</a></td><td>Deep solid colour, gloss or matte</td><td>Softer surface; gloss shows prints and fine scratches</td><td>Replace the shutter</td><td class="num">1.3–1.6×</td></tr>
    <tr><td><a href="/materials/wood-veneer/">Wood veneer</a></td><td>Real wood grain</td><td>Depends on the polish; keep away from water</td><td>Can be re-polished</td><td class="num">1.5–2×</td></tr>
    <tr><td><a href="/materials/pu-finish/">PU paint</a></td><td>Any colour, matte to high gloss; suits grooved and curved doors</td><td>Can chip at edges</td><td>Touched up on site</td><td class="num">1.5–2×</td></tr>
    <tr><td><a href="/materials/membrane-finish/">Membrane (PVC foil)</a></td><td>Seamless wrap over profiled doors</td><td>Can lift near heat</td><td>Replace the shutter</td><td class="num">About 1.1×</td></tr>
    <tr><td><a href="/materials/lacquered-glass/">Lacquered glass</a></td><td>Flat, reflective colour</td><td>Easy to clean; heavy on hinges</td><td>Replace the panel</td><td class="num">1.5–2×</td></tr>
    <tr><td><a href="/materials/glass-finish/">Glass and mirror</a></td><td>Clear, tinted, fluted or mirrored panels, often in an aluminium frame</td><td>Wipes clean; ask for toughened glass</td><td>Replace the panel</td><td class="num">Varies with frame and glass</td></tr>
    <tr><td><a href="/materials/duco-paint/">Duco paint</a></td><td>Sprayed solid colour</td><td>Less tough than PU</td><td>Can be re-sprayed</td><td class="num">Usually below PU</td></tr>
  </tbody>
</table>
</div>
<p>Sheen is a separate decision. Gloss shows fingerprints and fine scratches more than matte in every finish; see <a href="/compare/matte-vs-glossy-finish/">matte vs glossy</a>. For the closest calls, read <a href="/compare/acrylic-vs-laminate/">acrylic vs laminate</a> and <a href="/compare/veneer-vs-laminate/">veneer vs laminate</a>, or browse <a href="/compare/">all comparisons</a>.</p>

<h2>Surfaces and stone</h2>
<p>Countertops, floors and wall tiles are bought separately from the woodwork but chosen alongside it.</p>
<ul>
  <li><strong><a href="/materials/granite-guide/">Granite</a></strong> is hard, takes hot vessels and is the least expensive stone for a kitchen counter. As flooring it costs about ₹150–350 per sq ft.</li>
  <li><strong><a href="/materials/quartz-countertop/">Quartz</a></strong> is an engineered slab: non-porous, uniform in colour and easy to wipe. It costs more and should be kept clear of very hot pans. See <a href="/compare/quartz-vs-granite/">quartz vs granite</a>.</li>
  <li><strong><a href="/materials/marble-guide/">Marble</a></strong> is softer and marks with lemon, vinegar and other acids, so it suits floors better than working counters. Indian marble runs about ₹150–400 per sq ft with polishing, Italian marble ₹450–1,200 or more.</li>
  <li><strong>Tiles</strong> divide by use: vitrified tiles for floors (about ₹90–220 per sq ft) and ceramic tiles mainly for walls. <a href="/materials/kitchen-tiles/">Kitchen backsplash tiles</a> should wipe clean and have few grout lines; bathroom and utility walls are covered in the <a href="/materials/dado-tiles/">dado tile guide</a>.</li>
</ul>
<p>Flooring figures are indicative for material and laying; ask whether a quote includes 18% GST.</p>

<h2>Edges, adhesives and what is hidden</h2>
<p>A board is only as water-resistant as its edges. Every cut exposes the core, so each edge is sealed with an edge band, a strip of PVC or ABS applied by machine.</p>
<ul>
  <li><strong>Thickness.</strong> A 0.8 mm band is usual on carcass panels and shelves. A 2 mm band on shutters and exposed edges takes knocks better and allows a slightly rounded corner.</li>
  <li><strong>Glue.</strong> Ordinary edge banding uses EVA hot-melt glue. PUR glue gives a thinner, more water-resistant joint and is worth asking for on kitchen shutters and on acrylic.</li>
  <li><strong>All four edges.</strong> Edges at the back and bottom are out of sight and easy to skip. Ask for every one to be banded.</li>
  <li><strong>Pressing.</strong> Laminate, acrylic and veneer pressed in a factory bond more evenly than sheets glued by hand on site.</li>
</ul>
<p>Hidden parts deserve a line in the quotation too: the back panel (usually 6–9 mm), the laminate inside the cabinet, the legs under kitchen base units, and the hinges and channels, whose names are decoded under <a href="/glossary/hardware-terms/">hardware terms</a>.</p>

<h2>How to read the material specification in a quotation</h2>
<p>For each group of cabinets, a complete quotation states:</p>
<ul>
  <li><strong>Board:</strong> brand, grade (MR, BWR or BWP), thickness and IS number.</li>
  <li><strong>Finish:</strong> type, brand and thickness. 1 mm laminate on visible faces is the norm, with a thinner liner laminate inside.</li>
  <li><strong>Edge band:</strong> thickness and glue type.</li>
  <li><strong>Hardware:</strong> brand and series for hinges, channels and drawer systems, not the brand alone.</li>
  <li><strong>Countertop:</strong> stone, thickness and edge detail.</li>
</ul>
<div class="callout"><span class="callout__title">Compare the specification before the price</span>"Waterproof ply", "branded laminate" and "imported fittings" are not specifications. Ask for brand, grade and thickness in writing, and for a clause that any substitution needs your approval.</div>

<h2>How materials change the budget</h2>
<p>Material grade moves the total more than flat size does. The table ties typical combinations to full-home rates per sq ft of carpet area, for a scope of kitchen, wardrobes, TV unit, false ceiling, painting, lighting and curtains.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Grade</th><th>Boards</th><th>Finishes and fittings</th><th class="num">Per sq ft</th><th class="num">2 BHK, about 950 sq ft</th></tr></thead>
  <tbody>
<?php foreach ($GRADES as $grade => [$boards, $finishes, $sqft, $total]): ?>
    <tr><td><?= e($grade) ?></td><td><?= e($boards) ?></td><td><?= e($finishes) ?></td><td class="num"><?= e($sqft) ?></td><td class="num"><?= e($total) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices including 18% GST, October 2026. Loose furniture, flooring and bathrooms are extra. Hosur is usually 5–10% lower.</p>
<p>The least costly route to a richer-looking home is one premium finish where it shows, such as acrylic kitchen fronts or a veneer TV wall, with good laminate elsewhere. Price your own rooms in the <a href="/calculators/interior-cost/">interior cost calculator</a>.</p>

<h2>Checks to make when materials reach the site</h2>
<ul>
  <li><strong>Read the stamp on the plywood.</strong> Each sheet should show the brand, the grade and the IS number: IS 303 on general-purpose plywood, IS 710 on marine plywood.</li>
  <li><strong>Measure the thickness.</strong> Use a calliper or a tape on a few sheets. A board sold as 18 mm that measures nearer 16 mm is a different product.</li>
  <li><strong>Match the laminate.</strong> Check the brand and catalogue code on the sheet or its label against the sample you approved.</li>
  <li><strong>Inspect the edge banding.</strong> It should sit flush, with no gaps, glue lines or lifting corners, and match the face colour.</li>
  <li><strong>Open the hardware boxes.</strong> Brand and series should be those named in the quotation.</li>
</ul>
<p>Factory-made modules arrive cut and finished, so ask for photographs of the stamped sheets or the supplier invoice before production starts.</p>

<h2>Common mistakes with materials</h2>
<ul>
  <li><strong>One board for the whole house.</strong> BWP everywhere wastes money; MR everywhere fails at the sink.</li>
  <li><strong>Trusting the word "waterproof".</strong> It is a sales term, not a grade. Ask for MR, BWR or BWP and the IS number.</li>
  <li><strong>MDF or particle board near water.</strong> Both swell once water gets in, and a swollen board cannot be repaired.</li>
  <li><strong>Gloss on every door.</strong> Keep it for surfaces that are seen more than touched.</li>
  <li><strong>Choosing from a small swatch.</strong> See a large sample in your own room's light before approving.</li>
  <li><strong>Losing the catalogue codes.</strong> Note every laminate and acrylic code so a damaged shutter can be matched later.</li>
</ul>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
