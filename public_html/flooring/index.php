<?php
/* PILLAR PAGE — Flooring (/flooring/)
   Cluster links ("In this guide") come from includes/nav.php → 'flooring'.
   Images: /assets/pages/flooring/   (hero.jpg = main image)
   Rates used on this page are in $FLOORS so they are edited in one place. */
$FLOORS = [   // type => [durability, behaviour with water, maintenance, indicative ₹ per sq ft laid]
  'Vitrified tile'             => ['High; resists scratches and stains', 'Very low absorption; suits every room', 'Low: daily mopping, grout cleaning now and then', '₹90–220'],
  'Ceramic tile'               => ['Moderate; the glaze can chip', 'Glazed face sheds water, the body absorbs more', 'Low', '₹60–120'],
  'Indian marble'              => ['Long-lived, but scratches and etches', 'Porous; stains unless sealed', 'Sealing, and re-polishing every few years', '₹150–400'],
  'Italian or imported marble' => ['Softer than most Indian marble', 'Porous; marks easily with acids', 'Highest: sealing and gentle cleaners only', '₹450–1,200+'],
  'Granite'                    => ['Very high', 'Dense, with low porosity', 'Low; reseal every year or two', '₹150–350'],
  'Kota and similar stone'     => ['Very high', 'Handles water; unpolished finish grips well', 'Low', '₹90–180'],
  'Engineered wood'            => ['Moderate; can dent and scratch', 'Copes with humidity, not with standing water', 'Dry or lightly damp mop', '₹350–900'],
  'Laminate wood flooring'     => ['Moderate; cannot be re-polished', 'Swells if water enters the joints', 'Dry or lightly damp mop', '₹120–250'],
  'SPC or vinyl plank'         => ['Good; heavy sharp loads can dent it', 'Waterproof plank', 'Low', '₹110–260'],
  'Terracotta'                 => ['Moderate; edges can chip', 'Very porous; must be sealed', 'Re-sealing from time to time', '₹100–250'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'flooring',
  'title'        => 'Flooring Types in India: Materials, Cost and Where to Use',
  'seo_title'    => 'Flooring Types in India: Materials & Cost',
  'crumb'        => 'Flooring',
  'description'  => 'Flooring types in India compared: vitrified and ceramic tiles, marble, granite, Kota, wood and SPC, with cost per sq ft and the best floor for each room.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'Ten floor materials compared for Indian homes: how each handles water, wear and climate, what it costs per square foot and which room it suits.',
  'hero_alt'     => 'Living room with large matt vitrified floor tiles and a wood-look bedroom floor beyond',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'The main flooring types in Indian homes are vitrified and ceramic tiles, marble, granite, Kota stone, engineered wood, laminate and SPC vinyl planks. Vitrified tile suits most rooms and costs about ₹90–220 per sq ft laid in Bengaluru; Indian marble is about ₹150–400 and engineered wood ₹350–900 (indicative, October 2026, including GST). Choose by water exposure first, then traffic, upkeep and budget.',
  'faq' => [
    'Which is the best flooring for a home in India?' => 'For most homes, vitrified tile is the practical choice: it is dense, easy to mop and works in every room, at roughly ₹90–220 per sq ft laid in Bengaluru. Marble or engineered wood suit a living room or bedroom when the budget and the upkeep are acceptable. Wet areas need a matt, slip-resistant tile whatever is used elsewhere.',
    'What is the marble flooring price per sq ft?' => 'Indicative Bengaluru rates for October 2026, with laying and polishing, are about ₹150–400 per sq ft for Indian marble and ₹450–1,200 or more for Italian and other imported marble. The spread comes from the variety, the slab size and how uniform the lot is. Budget separately for sealing and for re-polishing every few years.',
    'Is wooden flooring suitable for Indian homes?' => 'Yes, in dry rooms. Engineered wood and laminate work well in bedrooms and living rooms but should stay out of bathrooms, kitchens and open balconies. SPC planks give a wood look and are waterproof, so they suit homes where spills or humidity are a worry.',
    'Are vitrified tiles better than marble?' => 'They are easier to live with: vitrified tiles need no sealing or polishing and do not react to lemon juice or vinegar. Marble has natural veining that no print fully matches and can be re-polished to look new, but it stains and scratches more easily and costs more to lay. The choice is mainly between low upkeep and a natural material.',
    'Can new tiles be laid over old tiles?' => 'Yes, if the old tiles are firmly bonded, level and dry. The new tiles are fixed with tile adhesive, which raises the floor by about 12–15 mm, so doors and thresholds must be checked first. Hollow, cracked or damp floors should be removed instead.',
    'How much does flooring cost for a 1,000 sq ft flat?' => 'In a mid-range vitrified tile at about ₹130–170 per sq ft, 1,000 sq ft of floor comes to roughly ₹1.3–1.7 lakh including GST in Bengaluru, as of October 2026. The same area is about ₹1.5–4 lakh in Indian marble and ₹3.5–9 lakh in engineered wood. Removing an old floor is extra.',
  ],
  'related' => [   // sibling pillar guides
    ['/cost/', 'Interior design cost guide', 'Home and room-wise budgets', 'Pillar guide'],
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
    ['/rooms/', 'Room-by-room guides', 'Layouts, storage and materials', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>The floor is the hardest finish to change once wardrobes, the kitchen and furniture are in place. It is walked on, mopped daily and, in many Indian homes, sat on. This guide compares the flooring types sold in India by how they behave with water, wear and weather, with indicative Bengaluru costs for October 2026.</p>

<h2>How to choose a floor</h2>
<p>Six questions narrow the choice:</p>
<ul>
  <li><strong>Traffic.</strong> Living rooms, passages and kitchens take the most wear and need a hard surface.</li>
  <li><strong>Water.</strong> Bathrooms, balconies, utility areas and kitchens rule out wood-based floors and polished finishes.</li>
  <li><strong>Climate.</strong> Humid and coastal cities are hard on wood. Stone and tile stay cool in hot regions.</li>
  <li><strong>Maintenance.</strong> Some floors only need mopping; others also need sealing and polishing.</li>
  <li><strong>Budget.</strong> Compare the laid cost per square foot, not the price of the material alone.</li>
  <li><strong>New or replacement.</strong> In an occupied home, the condition of the old floor decides whether you can lay over it.</li>
</ul>
<div class="callout"><span class="callout__title">Start with water</span>List the rooms that get wet and choose those floors first. The dry rooms can then follow taste and budget.</div>

<h2>Flooring types compared</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Type</th><th>Durability</th><th>With water</th><th>Maintenance</th><th class="num">Cost per sq ft</th></tr></thead>
  <tbody>
<?php foreach ($FLOORS as $type => [$wear, $water, $care, $cost]): ?>
    <tr><td><?= e($type) ?></td><td><?= e($wear) ?></td><td><?= e($water) ?></td><td><?= e($care) ?></td><td class="num"><?= e($cost) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru rates, October 2026, for material plus laying, including GST. Marble rates include polishing. The terracotta range is a rough guide. Hosur usually comes in 5–10% lower.</p>

<h2>Tiles in more detail</h2>
<h3>Ceramic and vitrified</h3>
<p>A ceramic tile is a fired clay body with a glaze on top. It is lighter and more absorbent, so it is used mainly on walls, with floor-rated versions for bathrooms. A vitrified tile is fired until the body is dense and almost non-absorbent, which makes it the standard floor tile. Wall choices are covered in the <a href="/materials/dado-tiles/">dado tile guide</a> and in <a href="/materials/kitchen-tiles/">kitchen tiles and backsplash</a>.</p>
<h3>Three kinds of vitrified tile</h3>
<ul>
  <li><strong>Glazed (GVT and PGVT)</strong> has a printed glaze layer, so it offers the widest range of marble, stone and wood looks. PGVT is the polished, glossy version.</li>
  <li><strong>Double-charge</strong> has a thick pigmented top layer pressed onto the body. Patterns are simpler, but they do not wear off, which suits busy floors.</li>
  <li><strong>Full-body</strong> carries one colour through the whole thickness, so a chip shows less. It is used on stairs and other heavy-use areas.</li>
</ul>
<p>Large-format and slab tiles give fewer joints, at about ₹200–450 per sq ft laid, and need a very flat base.</p>
<h3>Slip resistance, sizes and joints</h3>
<p>Wet areas need a matt or textured finish. Many makers print an R rating on the box: R10 or higher is the usual advice for bathroom floors, and R11 for open balconies and outdoor steps. Common floor sizes are 600 × 600 mm and 600 × 1200 mm; bathrooms use smaller tiles so the floor can follow the slope to the drain. Leave a 2–3 mm grout joint even with straight-edged tiles, and use epoxy grout in kitchens and bathrooms, where it resists stains.</p>

<h2>Natural stone: marble, granite and Kota</h2>
<p><strong>Marble</strong> is laid as slabs on a mortar bed, then ground and polished on site. It is porous and fairly soft, so it needs sealing after laying and a fresh polish every few years. Indian varieties such as Makrana are harder-wearing than many imported marbles, which are chosen for their white ground and veining. The <a href="/materials/marble-guide/">marble guide</a> compares varieties and finishes.</p>
<div class="callout callout--warn"><span class="callout__title">Keep acids off marble</span>Lemon juice, vinegar, tamarind and acid-based bathroom cleaners eat into the polish and leave dull marks. Wipe spills at once and use a neutral cleaner.</div>
<p><strong>Granite</strong> is harder and far less porous. It resists scratches and stains, which makes it the usual stone for staircases, thresholds and counters. Polished granite is slippery when wet, so ask for a flamed or leathered finish on steps and outdoors. See the <a href="/materials/granite-guide/">granite guide</a>.</p>
<p><strong>Kota</strong>, a limestone from Rajasthan, is durable and economical. Left unpolished it grips well, so it suits balconies, utility areas and paths; indoors it can be polished to a soft sheen. <strong>Terracotta</strong> gives a warm, earthy look but must be sealed, as described in <a href="/trends/terracotta-tiles/">terracotta tiles</a>.</p>

<h2>Wood and wood-look floors</h2>
<ul>
  <li><strong>Engineered wood</strong> has a real hardwood top layer on a plywood or HDF base. It moves less than solid wood when humidity changes, but standing water will damage it.</li>
  <li><strong>Laminate wood flooring</strong> is an HDF plank with a printed wood pattern under a hard wear layer. It is the least tolerant of water at the joints.</li>
  <li><strong>SPC or vinyl plank</strong> has a rigid mineral-and-vinyl core and is waterproof. It clicks together and is thin enough to go over an existing floor.</li>
</ul>
<p>All three are usually laid as floating floors on an underlay. They need an expansion gap of about 8–10 mm at the walls, hidden by the skirting, and a profile at each doorway. Keep engineered wood and laminate out of bathrooms, kitchens and open balconies. SPC is the only one of the three that can go into a wet room, and tiles remain the safer choice for a shower area.</p>

<h2>Which floor for which room</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Room</th><th>Good choices</th><th>Avoid</th></tr></thead>
  <tbody>
    <tr><td>Living room</td><td>Large vitrified tiles, marble, engineered wood</td><td>Laminate near a balcony door that lets in rain</td></tr>
    <tr><td>Bedrooms</td><td>Vitrified tile, laminate, SPC, engineered wood</td><td>High gloss where older family members walk</td></tr>
    <tr><td>Kitchen</td><td>Matt vitrified tile</td><td>Laminate, engineered wood, polished marble</td></tr>
    <tr><td>Bathrooms</td><td>Anti-skid ceramic or matt vitrified tile</td><td>Polished tiles, marble, any wood-based floor</td></tr>
    <tr><td>Balcony</td><td>Anti-skid outdoor tile, Kota, flamed granite, sealed terracotta</td><td>Polished surfaces, laminate, engineered wood</td></tr>
    <tr><td>Pooja room</td><td>White marble or a marble-look tile</td><td>Unsealed marble, which stains with oil and kumkum</td></tr>
    <tr><td>Staircase</td><td>Granite or full-body tile with grooved or rough nosing</td><td>Polished treads without anti-slip grooves</td></tr>
  </tbody>
</table>
</div>
<p>For the room that sets the tone of the home, the options are compared in <a href="/rooms/living-room-flooring/">living room flooring</a>. Wet-room detailing is covered in the <a href="/rooms/bathroom/">bathroom interior guide</a>.</p>

<h2>Flooring for India's climates</h2>
<ul>
  <li><strong>Humid coasts and heavy-monsoon cities</strong> such as Mumbai, Chennai, Kochi and Mangaluru favour tile and stone. Polished floors can turn damp and slippery in very humid weather, so matt finishes are safer. For a wood look, choose SPC.</li>
  <li><strong>Hot, dry regions</strong> suit stone and tile, which stay cool underfoot. Large tiled areas need movement joints because of wide temperature swings.</li>
  <li><strong>Bengaluru and Hosur</strong> have a mild climate in which almost every material performs well. Ground floors still need a moisture barrier under wood-based planks.</li>
</ul>
<p>Comfort matters too. Stone and tile feel cool underfoot, which is welcome in summer and less so on a winter morning. Wood, laminate and SPC feel warmer.</p>

<h2>What flooring costs</h2>
<p>A complete per-square-foot rate should cover the material, laying labour, adhesive or mortar bedding, grout, skirting and wastage of about 5–10% for cuts and breakage. Ask each contractor which of these the quoted figure includes. Removal of an old floor, levelling and waterproofing are normally separate lines.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Worked example: 1,000 sq ft flat</th><th class="num">Indicative figure</th></tr></thead>
  <tbody>
    <tr><td>Floor area to cover</td><td class="num">1,000 sq ft</td></tr>
    <tr><td>Tiles to order, with about 8% wastage</td><td class="num">1,080 sq ft</td></tr>
    <tr><td>Mid-range vitrified tile, complete rate per sq ft of floor</td><td class="num">₹130–170</td></tr>
    <tr><td>Total</td><td class="num">₹1.3–1.7 lakh</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative for Bengaluru, October 2026, including GST. An economy tile brings the total nearer ₹90,000; a premium tile takes it to about ₹2.2 lakh.</p>
<p>Material-wise rates are broken down in <a href="/cost/flooring-cost-per-sqft/">flooring cost per sq ft</a>. Flooring is not part of the usual interiors scope, so add it to the figure from the <a href="/calculators/interior-cost/">interior cost calculator</a>.</p>

<h2>Laying over an existing floor or removing it</h2>
<div class="pros-cons">
  <div><span class="pros-cons__title">Lay over the old floor</span><ul>
    <li>Tile-on-tile with adhesive works when the old tiles are firmly bonded, level and dry.</li>
    <li>SPC planks go over any even floor; deep joints are filled first.</li>
    <li>Less dust, noise and debris.</li>
    <li>Tile-on-tile raises the floor by about 12–15 mm.</li>
  </ul></div>
  <div><span class="pros-cons__title">Remove and relay</span><ul>
    <li>Needed when tiles sound hollow, are cracked or the floor is damp.</li>
    <li>Needed for marble and other stone, which need depth for a mortar bed.</li>
    <li>Lets you correct levels and redo bathroom waterproofing.</li>
    <li>Adds breaking, debris removal and time.</li>
  </ul></div>
</div>
<div class="callout callout--tip"><span class="callout__title">Check door heights first</span>Before laying over a floor, measure the gap under every door and balcony slider, and the height of bathroom thresholds and kitchen plinths. Doors may need trimming.</div>

<h2>Installation steps and timeline</h2>
<ol class="steps">
  <li><strong>Check the base</strong>Levels are measured across rooms, hollows and cracks are repaired, and wet areas are waterproofed and tested with standing water.</li>
  <li><strong>Plan the layout</strong>Tiles are set out dry from the main door or the room centre, so thin cut pieces fall where they show least.</li>
  <li><strong>Lay</strong>Tiles go on adhesive or a mortar bed with spacers; stone on a mortar bed; planks on underlay with an expansion gap.</li>
  <li><strong>Cure and grout</strong>Tiled floors are kept free of foot traffic for about a day, then grouted.</li>
  <li><strong>Polish and finish</strong>Marble and Kota are ground and polished in stages. Skirting and door profiles are fixed.</li>
  <li><strong>Protect</strong>The floor is covered with sheets until carpentry and painting are over.</li>
</ol>
<p>As a rough guide for a 1,000 sq ft flat, tiling takes one to two weeks, marble three to four weeks with polishing, and click-fit planks two to four days. Tile and stone go in before woodwork; floating planks go in last.</p>

<h2>Mistakes to avoid</h2>
<ul>
  <li><strong>No spare box.</strong> Tile batches differ slightly in shade and size. Keep one unopened box from the same batch for repairs.</li>
  <li><strong>Polished tiles in wet areas.</strong> Gloss in a bathroom, balcony or utility is a slipping risk.</li>
  <li><strong>No slope to the drain.</strong> Wet floors need a steady fall towards the outlet, checked with water before grouting.</li>
  <li><strong>Skipping level checks.</strong> Uneven tile edges and steps between rooms are hard to correct later.</li>
  <li><strong>Tiles laid without joints.</strong> Tightly butted tiles have no room to move and can lift.</li>
  <li><strong>No expansion gap.</strong> Laminate and SPC laid tight to the walls can buckle.</li>
</ul>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
