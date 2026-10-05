<?php
/* PILLAR PAGE — Room Guides (/rooms/)
   Cluster links ("In this guide") come from includes/nav.php → 'rooms'.
   Images: /assets/pages/rooms/   (hero.jpg = main image)
   The budget split in $SPLIT matches cost/3-bhk-interior-cost/ — change both together. */
$SPLIT = [   // budget head => [share of a standard full-home budget in %, what it pays for]
  'Modular kitchen'              => [22, 'Cabinets, hardware, countertop'],
  'Wardrobes'                    => [22, 'All bedrooms, with lofts'],
  'Living room and TV wall'      => [12, 'TV unit and wall panel'],
  'False ceiling'                => [8,  'Living room and master bedroom first'],
  'Electrical and lighting'      => [8,  'New points, downlights, cove lights'],
  'Painting'                     => [6,  'Whole home'],
  'Dining and crockery'          => [6,  'Crockery unit and dining wall'],
  'Design and supervision'       => [6,  'Drawings and site management'],
  'Foyer, utility and balcony'   => [5,  'Shoe unit, utility cabinets, balcony seating'],
  'Curtains and soft furnishing' => [5,  'Curtains and blinds'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'rooms',
  'title'        => 'Room-by-Room Interior Design Guide for Indian Homes',
  'seo_title'    => 'Room by Room Interior Design Guide: Indian Homes',
  'crumb'        => 'Room Guides',
  'description'  => 'Room by room interior design for Indian homes: what to decide first in the living room, bedrooms and kitchen, standard sizes, budget split and site order.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'What to decide first in every room, the sizes that keep it comfortable, how the budget divides and the order in which the work happens on site.',
  'hero_alt'     => 'Living and dining area of an Indian apartment with a TV unit, sofa and dining table',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'Plan every room in the same order: function and storage first, then layout, then materials, then lighting. Settle the kitchen and wardrobes before the decorative rooms, because they are built in and together take about 45% of a full-home budget. In Bengaluru, full interiors for a 3 BHK of about 1,400 sq ft carpet area cost roughly ₹10–15 lakh in standard grade, including GST (indicative, October 2026).',
  'faq' => [
    'Which room should I design first?' => 'Start with the kitchen and the wardrobes. They are fixed to the walls, depend on plumbing and electrical points, and need the longest factory time. Living room panels, wallpaper and décor can follow later without breaking anything.',
    'How much of the budget should each room get?' => 'In a standard full-home budget the kitchen takes about 22%, the wardrobes about 22% and the living room with the TV wall about 12%. The rest is shared between false ceilings, electrical work, painting, the dining area, the foyer and utility, curtains and design fees.',
    'What is the right height for a TV unit?' => 'A floor-standing TV unit is usually 18–24 inches high. Mount the screen so that its centre is near your eye level when seated, which is roughly 3.5 ft from the floor for a typical sofa.',
    'How much space should I leave around furniture?' => 'Keep about 3 ft for any path people walk through, about 2 ft on each side of a bed and 2.5–3 ft behind dining chairs so they can be pulled back. Mark the furniture on the floor with tape before you order it.',
    'Can I do the interiors one room at a time?' => 'Yes, as long as the dusty work is done for the whole home in one go: plumbing changes, electrical conduits, false ceilings and flooring. Furniture can then be added room by room, with the kitchen and wardrobes before you move in.',
    'How long do full-home interiors take?' => 'Allow 45–60 days for a kitchen and wardrobes only, and 75–100 days for a full home. Premium work with veneer, PU or custom furniture can take up to four months.',
  ],
  'related' => [   // sibling pillar guides
    ['/modular-kitchen/', 'Modular kitchen design guide', 'Layouts, materials and cost', 'Pillar guide'],
    ['/wardrobe/', 'Wardrobe design guide', 'Types, sizes, internals and cost', 'Pillar guide'],
    ['/styles/', 'Interior design styles', 'Pick one look for the whole home', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Room by room interior design treats a home as a set of small projects that share one budget, one palette and one work schedule. Each room has a different job: the kitchen is a workplace, a bedroom is mostly storage and rest, and the living room is where the family sits with its guests. This guide sets out what to decide first in each room, the sizes that keep it comfortable, how the money usually divides and the order of work on site.</p>

<h2>How to plan a home room by room</h2>
<p>Use the same four steps in every room. The order stops you from choosing a laminate colour before you know where the wardrobe will stand.</p>
<ol class="steps">
  <li><strong>Function and storage</strong>Write down who uses the room, what they do there and what has to be stored. Count the real things: hanging clothes, books, vessels, shoes. The <a href="/planning/storage-room-by-room/">room-by-room storage plan</a> gives a checklist.</li>
  <li><strong>Layout</strong>Place the largest pieces first (bed, sofa, dining table, kitchen counter), then check door swings, windows and walking paths. See <a href="/planning/furniture-layout/">furniture layout</a> for the method.</li>
  <li><strong>Materials</strong>Choose boards, finishes and flooring for the conditions in that room: water, sunlight, heat and daily wear.</li>
  <li><strong>Lighting and electricals</strong>Mark sockets, switches and light points only after the furniture positions are fixed. The guides to <a href="/planning/electrical-points/">electrical points</a> and <a href="/planning/lighting-design/">lighting design</a> go room by room.</li>
</ol>
<div class="callout"><span class="callout__title">Fix the rooms you cannot easily redo</span>The kitchen and the wardrobes are built in, tied to plumbing and electrical points, and costly to change. Finalise them before wall panels, wallpaper and décor, which can be added later.</div>

<h2>What to decide first in each room</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Room</th><th>First decision</th><th>Key fixed furniture</th><th>Where the budget usually goes</th></tr></thead>
  <tbody>
    <tr><td>Living room</td><td>TV wall and seating positions</td><td>TV unit, wall panel</td><td>TV wall, false ceiling, lighting</td></tr>
    <tr><td>Dining</td><td>Table size and shape</td><td>Crockery unit</td><td>Crockery unit, pendant light</td></tr>
    <tr><td>Kitchen</td><td>Layout: straight, L, parallel or U</td><td>Base, wall and tall units</td><td>Cabinets, hardware, countertop</td></tr>
    <tr><td>Master bedroom</td><td>Bed position and wardrobe wall</td><td>Wardrobe with loft, dresser</td><td>Wardrobe</td></tr>
    <tr><td>Kids room</td><td>What must change as the child grows</td><td>Wardrobe, study table</td><td>Wardrobe and study unit</td></tr>
    <tr><td>Study or home office</td><td>Desk position against window and sockets</td><td>Desk, bookshelves</td><td>Desk, storage, task light</td></tr>
    <tr><td>Bathroom</td><td>Wet and dry zones</td><td>Vanity, shower partition</td><td>Waterproofing, tiles, fittings</td></tr>
    <tr><td>Pooja</td><td>Wall unit or separate room</td><td>Mandir unit</td><td>Unit, doors, lighting</td></tr>
    <tr><td>Foyer</td><td>Number of shoes to store</td><td>Shoe unit, seat, mirror</td><td>Shoe unit</td></tr>
    <tr><td>Balcony</td><td>One main use: sitting, plants or drying</td><td>Seating, planters</td><td>Flooring, outdoor-grade furniture</td></tr>
    <tr><td>Utility</td><td>Washing machine and sink positions</td><td>Wall cabinets, washer platform</td><td>Water-resistant cabinets</td></tr>
  </tbody>
</table>
</div>

<h2>Living and dining spaces</h2>
<p>Living room design starts from two things, the TV wall and the seating, because the ceiling, lights and sockets all follow from them. The <a href="/rooms/living-room/">living room guide</a> works through layouts for common apartment shapes, and the <a href="/rooms/living-room-electronic-city/">living room guide for Electronic City apartments</a> applies them to the flats along Hosur Road.</p>
<h3>TV wall and seating</h3>
<p>Place the main sofa facing the TV wall and keep the centre of the screen near seated eye level. A floor-standing unit is usually 18–24 inches high. A common rule of thumb for viewing distance is about 1.5 to 2.5 times the screen diagonal, so measure the room before choosing the screen. Storage and wire management are covered in <a href="/furniture/tv-unit-design/">TV unit designs</a>.</p>
<p>A sofa is loose furniture, outside most interior quotations. Measure the wall, the lift and the main door before buying, and leave about 3 ft of passage around the seating. Frames and fabrics are explained in the <a href="/furniture/sofa-buying-guide/">sofa buying guide</a>.</p>
<h3>Materials and flooring</h3>
<p>The living room takes the most foot traffic and often the most sunlight, so choose finishes that tolerate both. Laminate and veneer are the usual choices for the TV unit and wall panels; see <a href="/rooms/living-room-materials/">living room materials</a>. Vitrified tile is the most common apartment floor; marble and wood-finish floors cost more. All are compared in <a href="/rooms/living-room-flooring/">living room flooring</a>.</p>
<h3>Dining area</h3>
<p>Choose the table for the number of people who eat together every day. Leave 2.5–3 ft behind each chair, and fix the pendant light point only after the table position is final. The <a href="/rooms/dining-room/">dining room guide</a> has table sizes for four, six and eight seats.</p>

<h2>Bedrooms and private rooms</h2>
<h3>Master bedroom</h3>
<p>Bedroom design begins with the bed. Put the headboard against a solid wall with about 2 ft clear on each side, then give the longest remaining wall to the wardrobe. A wardrobe is 24 inches deep, so check that hinged doors can open fully without touching the bed, or choose sliding doors. Layouts are shown in <a href="/rooms/master-bedroom/">master bedroom design</a>. A dresser works best near daylight with a light on each side of the mirror; see <a href="/rooms/vanity-dressing/">vanity and dressing units</a>.</p>
<h3>Kids room</h3>
<p>Plan a kids room to grow with the child. Build a full-height wardrobe with adjustable shelves and a hanging rail that can be raised, keep the bed as loose furniture that can be replaced, and leave open floor for play. Avoid themed built-in furniture that will be outgrown in a few years. More in <a href="/rooms/kids-room/">kids room ideas</a>.</p>
<h3>Study and home office</h3>
<p>A desk height of about 28–30 inches suits most adults, paired with a chair that adjusts. Set the desk side-on to the window to avoid glare on the screen, add a task light, and provide sockets at desk level. The <a href="/rooms/study-home-office/">study and home office guide</a> covers shelving and cable planning.</p>
<h3>Bathroom</h3>
<p>Separate the wet zone (shower) from the dry zone (basin and WC) with a glass partition or a small level difference. Use anti-skid tiles on the floor, slope the floor towards the drain, and complete waterproofing before any tile is laid. Vanity cabinets need BWP plywood or another water-resistant board. Bathrooms are priced outside the usual interior package; the <a href="/rooms/bathroom/">bathroom interior guide</a> lists what to include.</p>

<h2>Kitchen and wardrobes: the two built-in rooms</h2>
<p>Kitchen design involves more decisions than any other room: layout, cabinet boards, shutter finish, countertop and hardware. They are set out in order in the <a href="/modular-kitchen/">modular kitchen design guide</a>. Wardrobe types, internal fittings and sizes are in the <a href="/wardrobe/">wardrobe design guide</a>. Lock both designs before the electrician marks any points, because sockets, the chimney outlet and the light switches depend on them.</p>

<h2>Speciality spaces</h2>
<ul>
  <li><strong>Pooja room.</strong> A wall unit suits most apartments. Plan a drawer for lamps and incense, a stone or tile surface under the lamp, and ventilation. See <a href="/rooms/pooja-room/">pooja room designs</a>. Many families follow the traditional preference for the north-east, described in <a href="/vastu/pooja-room-vastu/">pooja room vastu</a>.</li>
  <li><strong>Crockery unit.</strong> Keep it beside the dining table, with glass shutters above for display and closed drawers below for cutlery and linen. See <a href="/rooms/crockery-unit/">crockery unit designs</a>.</li>
  <li><strong>Foyer.</strong> A shoe unit, a seat, a mirror and a place for keys cover most needs. See <a href="/rooms/foyer-entrance/">foyer and entrance design</a>.</li>
  <li><strong>Balcony.</strong> Choose one main use and buy outdoor-grade materials. Never block the drain or the floor slope. See <a href="/rooms/balcony/">balcony ideas</a>.</li>
  <li><strong>Utility.</strong> Fix the washing machine and sink positions first, then add water-resistant cabinets above. See <a href="/rooms/utility-area/">utility area design</a>.</li>
  <li><strong>Home bar.</strong> A counter or a cabinet inside the dining or living area is usually enough, with a top that wipes clean. See <a href="/rooms/home-bar/">home bar ideas</a>.</li>
</ul>

<h2>Useful dimensions for every room</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Dimension</th><th>Common size</th><th>Why it matters</th></tr></thead>
  <tbody>
    <tr><td>Passage clearance</td><td>About 3 ft (90 cm)</td><td>Comfortable for one person to walk through</td></tr>
    <tr><td>Space behind a dining chair</td><td>About 2.5–3 ft (75–90 cm)</td><td>Room to pull the chair back and sit down</td></tr>
    <tr><td>Clearance beside a bed</td><td>About 2 ft (60 cm)</td><td>Room to get in and to make the bed</td></tr>
    <tr><td>Wardrobe depth</td><td>24 inches (60 cm)</td><td>Fits clothes on hangers</td></tr>
    <tr><td>Kitchen counter height</td><td>32–34 inches (81–86 cm)</td><td>A lower counter strains the back</td></tr>
    <tr><td>Study desk height</td><td>28–30 inches (71–76 cm)</td><td>Forearms rest level while writing or typing</td></tr>
    <tr><td>TV unit height (floor unit)</td><td>About 18–24 inches (45–60 cm)</td><td>Brings the screen centre close to seated eye level</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">These are common starting sizes, not fixed rules. Adjust them for the people who use the room.</p>

<h2>How the budget splits across rooms</h2>
<p>Full-home interiors in Bengaluru cost roughly ₹450–700 per sq ft of carpet area in essential grade, ₹700–1,100 in standard grade and ₹1,100–1,700 in premium grade, including GST. These are indicative rates for October 2026. The scope is the kitchen, wardrobes, TV unit, false ceiling, painting, lighting and curtains; loose furniture, flooring and bathrooms are extra. A standard-grade budget usually divides like this:</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Budget head</th><th class="num">Share</th><th>What it pays for</th></tr></thead>
  <tbody>
<?php foreach ($SPLIT as $head => [$pct, $what]): ?>
    <tr><td><?= e($head) ?></td><td class="num"><?= $pct ?>%</td><td><?= e($what) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Shares are indicative and shift with the number of bedrooms and the finishes chosen. Hosur usually comes in 5–10% lower than Bengaluru.</p>
<p>The kitchen and wardrobes together take about 45% of the total. Keep a further 10–15% aside as contingency. Room-wise ranges are in the <a href="/cost/">interior design cost guide</a>, and the <a href="/calculators/interior-cost/">interior cost calculator</a> gives an estimate for your own home.</p>

<h2>The order of work on site</h2>
<p>Trades follow the same sequence in every room: wet and dusty work first, finished surfaces last.</p>
<ol class="steps">
  <li><strong>Civil and plumbing changes</strong>Wall alterations, new water and drain lines and bathroom waterproofing.</li>
  <li><strong>Electrical conduits</strong>Walls are chased and conduits laid for every point, including ones you will use later.</li>
  <li><strong>False ceiling</strong>Framing and boards go up once the ceiling wiring is in place. See the <a href="/false-ceiling/">false ceiling guide</a>.</li>
  <li><strong>Flooring and tiling</strong>Floor and wall tiles are laid, then the floor is covered for protection. Options are in the <a href="/flooring/">flooring guide</a>.</li>
  <li><strong>Carpentry or modular installation</strong>Kitchen, wardrobes, TV unit and other storage are built or fitted.</li>
  <li><strong>Painting, final coats</strong>Putty and primer are done earlier; the final coats come after carpentry so that scuffs are covered.</li>
  <li><strong>Lights and fittings</strong>Light fixtures, fans, switch plates, handles and bathroom fittings.</li>
  <li><strong>Soft furnishing and deep cleaning</strong>Curtains and blinds, then a full clean and a snag check before moving in.</li>
</ol>

<h2>Common room-planning mistakes</h2>
<ul>
  <li><strong>Choosing colours before storage.</strong> Finishes are easy to change on paper; a wardrobe that is a foot too short is not.</li>
  <li><strong>Marking electrical points too early.</strong> Sockets end up behind the bed or the wardrobe.</li>
  <li><strong>Ignoring door and drawer swing.</strong> Check that every shutter and drawer opens fully with the furniture in place.</li>
  <li><strong>One ceiling light per room.</strong> Add task light at the desk, the dresser mirror and the kitchen counter.</li>
  <li><strong>Dry-area boards in wet areas.</strong> Bathroom vanities and utility cabinets need water-resistant board.</li>
</ul>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
