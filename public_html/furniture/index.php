<?php
/* PILLAR PAGE — Furniture Design (/furniture/)   ·   Phase 2, Oct 2026
   Target keyword: "furniture design for home" (+ "home furniture design", "custom furniture design")
   Cluster links come from includes/nav.php → 'furniture'.  Images: /assets/pages/furniture/ */
$DIMS = [   // piece => [key dimensions]
  'Sofa'            => 'Seat height 400–450 mm, seat depth 500–600 mm, arm height 550–650 mm',
  'Dining table'    => 'Height 750 mm; 600 mm of edge per person; 900–1000 mm wide',
  'Bed (queen / king)' => 'Mattress about 1520 × 1980 mm (60 × 78 in) / 1830 × 1980 mm (72 × 78 in); 450–550 mm to the mattress top',
  'Study table'     => 'Height 730–760 mm, depth 600 mm, width 1000–1200 mm',
  'Dressing table'  => 'Seated height 700–750 mm; standing 900 mm; depth 400–450 mm',
  'TV unit'         => 'Low unit 400–450 mm high, 400–450 mm deep; TV centre about 1000–1100 mm from floor',
  'Shoe rack'       => 'Depth 300–350 mm (flat shelves) or 180–250 mm (tilt-out)',
  'Wardrobe'        => 'Depth 600 mm, hanging rod clearance 1700 mm (long) or 1000 mm (short)',
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'furniture',
  'title'        => 'Furniture Design for Home: Dimensions, Materials and Construction',
  'seo_title'    => 'Furniture Design for Home: Sizes & Materials',
  'crumb'        => 'Furniture Design',
  'description'  => 'Furniture design for Indian homes: built-in vs loose furniture, standard dimensions, boards, hardwoods and joinery, finishes and indicative cost.',
  'eyebrow'      => 'Design hub · pillar guide',
  'lede'         => 'How furniture is sized, built and finished, so you can judge a design or a quotation on more than its photo.',
  'hero_alt'     => 'Living room with a floating TV unit, a linen sofa and a solid wood coffee table',
  'published'    => '2026-10-04',
  'updated'      => '2026-10-04',
  'quick_answer' => 'Good furniture starts from human dimensions and the room plan, then chooses construction for the job: built-in units (TV units, wardrobes, beds with storage, study desks) in BWR or BWP plywood or HDHMR with laminate or veneer; loose furniture (sofas, chairs, tables) in kiln-dried hardwood or engineered wood with proper joinery. Check the core material, joint method, hardware and finish in every quote. Standard heights: seats 400–450 mm, tables 730–760 mm, kitchen counters 850–900 mm.',
  'takeaways' => [
    'Design from the body and the room plan first: seats 400–450 mm, tables 730–760 mm, counters 850–900 mm.',
    'Built-in storage in BWR/BWP plywood or HDHMR; loose seating in kiln-dried hardwood or good engineered wood.',
    'Joinery and hardware decide lifespan more than the face finish.',
    'Kiln-dried timber (around 8–12% moisture for indoor use in India) resists warping and open joints.',
    'In every quote, ask for the core material, grade, joint method, hardware brand and finish in writing.',
  ],
  'sources' => [
    ['Bureau of Indian Standards (BIS)', 'https://www.bis.gov.in/', 'IS 303 and IS 710 (plywood), IS 12406 (MDF), IS 1141 (timber seasoning)'],
    ['ISO 9241-5: Ergonomics of human-system interaction, workstation layout', 'https://www.iso.org/', 'desk and seating ergonomics'],
    ['Enteriors: standard interior dimensions', '/planning/standard-interior-dimensions/', 'room-by-room sizes'],
  ],
  'faq' => [
    'What furniture is essential when moving into a new flat?' => 'Beds and mattresses, wardrobes or clothes storage, a kitchen with basic storage, a few chairs or a sofa, and a shoe cabinet at the entrance. TV units, crockery units and study desks can follow once you know how you use the space.',
    'How much space should be left between furniture and walls?' => 'Built-in units sit against walls; leave 25–50 mm behind free-standing furniture on external walls so air can move and damp does not build up, especially in the monsoon.',
    'How long should home furniture last?' => 'Well-made built-in units in plywood or HDHMR with good hardware commonly last 15–20 years; quality solid wood furniture can last generations. Sofas typically need re-upholstery or new foam after 8–12 years.',
    'Is custom furniture better than ready-made?' => 'Custom built-in furniture fits the space exactly and uses it fully, which matters in compact apartments. Ready-made loose furniture is quicker, can be seen and tried before buying, and moves with you. Most homes combine both.',
    'What is the most durable finish for furniture?' => 'High-pressure laminate is the most scratch- and stain-resistant everyday surface. PU lacquer on veneer or wood is durable and repairable. Acrylic and high gloss look premium but show scratches and fingerprints sooner.',
    'Is built-in or loose furniture better?' => 'Built-in furniture makes the most of the space and hides clutter, and suits wardrobes, TV units, study desks and storage beds. Loose furniture moves with you, can be replaced and suits sofas, dining sets and chairs. Most homes do best with built-in storage and loose seating.',
    'Which wood is best for furniture in India?' => 'For solid furniture, teak, sheesham (Indian rosewood) and mango wood are common: teak is the most stable and durable, sheesham is dense and handsome, mango wood is affordable but needs good seasoning. For built-in units, plywood or HDHMR boards with laminate or veneer are more stable than solid wood.',
    'What is kiln-dried wood?' => 'Timber dried in a controlled kiln to a target moisture content (often around 8–12% for indoor furniture in India) before making furniture. It is far less likely to warp, crack or open at the joints than air-dried or fresh wood.',
    'How do I check furniture quality?' => 'Ask what the core material and its grade are, how joints are made (dowels, mortise and tenon, or only screws), which hardware brand and rating is used, and what finish is applied. Open drawers fully, sit on seats, and look at the back and underside, where cheap shortcuts usually hide.',
    'Is engineered wood furniture good?' => 'It depends on the board. Plywood and HDHMR in built-in units are strong and stable. Low-density particle board in flat-pack furniture is cheap but sags and swells with water, and holds screws poorly. Read the board type, not just "engineered wood".',
  ],
  'related' => [
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
    ['/rooms/', 'Room-by-room design guides', 'Layouts and storage', 'Pillar guide'],
    ['/wall-design/', 'Wall design guide', 'Panelling and finishes', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Furniture is where interior design meets the human body: the height of a seat, the depth of a desk and the reach to a shelf decide whether a home is comfortable every day. It is also where quotations hide the most variation, because two pieces that look identical can be built from very different boards, timbers and fittings. Enteriors' furniture guides start from dimensions and materials, then cover each piece in detail.</p>

<h2>Built-in or loose</h2>
<div class="table-wrap">
<table>
  <thead><tr><th></th><th>Built-in (carpentry or modular)</th><th>Loose (free-standing)</th></tr></thead>
  <tbody>
    <tr><td>Examples</td><td>Wardrobes, TV units, storage beds, study desks, shoe units, crockery units</td><td>Sofas, armchairs, dining sets, coffee tables, side tables</td></tr>
    <tr><td>Strength</td><td>Uses every centimetre; fits odd corners</td><td>Moves with you; easy to replace</td></tr>
    <tr><td>Materials</td><td>Plywood, HDHMR, MDF with laminate, veneer, acrylic or PU</td><td>Solid hardwood, engineered wood, metal, upholstery</td></tr>
    <tr><td>Watch for</td><td>Board grade near water; hardware quality</td><td>Wood seasoning, joinery, foam density</td></tr>
  </tbody>
</table>
</div>

<h2>Standard dimensions</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Piece</th><th>Key dimensions</th></tr></thead>
  <tbody>
<?php foreach ($DIMS as $piece => $d): ?>
    <tr><td><?= e($piece) ?></td><td><?= e($d) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Typical comfortable ranges for adults; adjust for the people who use the furniture. Full room dimensions are in <a href="/planning/standard-interior-dimensions/">standard interior dimensions</a>.</p>

<h2>Materials and construction</h2>
<h3>Boards for built-in furniture</h3>
<p>BWR or BWP plywood and HDHMR are the reliable cores; MDF suits dry, painted or routed parts; particle board belongs only in dry, low-load uses. Compare them in <a href="/compare/hdhmr-vs-plywood/">HDHMR vs plywood</a> and <a href="/compare/mdf-vs-plywood/">MDF vs plywood</a>.</p>
<h3>Solid wood for loose furniture</h3>
<ul>
  <li><strong>Teak:</strong> stable, durable, naturally oily; the premium standard.</li>
  <li><strong>Sheesham (Indian rosewood):</strong> dense, strong, attractive grain; heavy.</li>
  <li><strong>Mango wood:</strong> affordable and sustainable; must be well seasoned and treated against borers.</li>
  <li><strong>Rubberwood:</strong> used in many ready-made pieces; stable when properly treated.</li>
</ul>
<h3>Joinery</h3>
<p>Mortise and tenon, dowel and dovetail joints, glued and clamped, outlast pieces held only with screws or nails. In built-in units, look for proper cam-lock or dowel joinery and edge-banding on every exposed edge.</p>
<?= img('furniture-joinery-and-board-samples') ?>

<h2>Finishes</h2>
<p>Laminate is toughest for everyday surfaces; veneer brings real grain; PU and duco paints give seamless colour; melamine and PU polishes protect solid wood. Each is explained in the <a href="/materials/">materials guide</a>, including <a href="/materials/laminate-guide/">laminates</a>, <a href="/materials/pu-finish/">PU finish</a> and <a href="/materials/duco-paint/">duco paint</a>.</p>

<h2>Furniture guides by piece</h2>
<ul>
  <li><a href="/furniture/tv-unit-design/">TV unit design</a>: heights, viewing distance, wiring and storage</li>
  <li><a href="/furniture/sofa-buying-guide/">Sofa buying guide</a>: frames, springs, foam density and fabric rub counts</li>
  <li><a href="/furniture/bed-design/">Bed design with storage</a>: sizes, hydraulic vs box storage, headboards</li>
  <li><a href="/furniture/dressing-table-design/">Dressing table design</a>: sizes, mirror lighting and storage</li>
  <li><a href="/furniture/study-table-design/">Study table design</a>: ergonomics for adults and children</li>
  <li><a href="/furniture/shoe-rack-design/">Shoe rack design</a>: capacity, ventilation and foyer fit</li>
  <li><a href="/rooms/crockery-unit/">Crockery unit design</a>: shelves, glass and lighting</li>
</ul>
<p>Price built-in pieces with the <a href="/calculators/home-interior-quote/">room-by-room quote builder</a>.</p>
<h2>Clearances: the space around furniture</h2>
<p>Furniture that fits on paper can still fail if there is no room to use it. These clearances are typical comfortable minimums.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Situation</th><th>Clearance</th></tr></thead>
  <tbody>
    <tr><td>Main walkway through a room</td><td>900 mm</td></tr>
    <tr><td>Sofa to coffee table</td><td>400–450 mm</td></tr>
    <tr><td>Around a dining table (to wall or furniture)</td><td>900 mm; 750 mm minimum where nobody passes behind</td></tr>
    <tr><td>Beside a bed</td><td>600 mm minimum, 750 mm comfortable</td></tr>
    <tr><td>In front of a wardrobe with hinged doors</td><td>900 mm or more</td></tr>
    <tr><td>In front of drawers</td><td>About 600 mm to open and kneel</td></tr>
    <tr><td>Behind a desk chair</td><td>900 mm</td></tr>
    <tr><td>Between kitchen counters (parallel layout)</td><td>1000–1200 mm</td></tr>
  </tbody>
</table>
</div>
<?= img('living-room-furniture-plan-with-clearances', caption: 'A living room plan with walkway, sofa-to-table and TV viewing clearances marked') ?>

<h2>Worked example: furnishing a 2 BHK</h2>
<p>A typical furniture list for a 950 sq ft 2 BHK in Bengaluru, split into built-in and loose, at a standard grade:</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Item</th><th>Type</th><th class="num">Indicative cost</th></tr></thead>
  <tbody>
    <tr><td>Two wardrobes with lofts</td><td>Built-in, laminate</td><td class="num">₹1.6–2.6 lakh</td></tr>
    <tr><td>TV unit with back panel</td><td>Built-in</td><td class="num">₹45,000–90,000</td></tr>
    <tr><td>Two storage beds</td><td>Built-in, hydraulic</td><td class="num">₹80,000–1.4 lakh</td></tr>
    <tr><td>Study table with shelf</td><td>Built-in</td><td class="num">₹15,000–35,000</td></tr>
    <tr><td>Shoe cabinet with bench</td><td>Built-in</td><td class="num">₹20,000–45,000</td></tr>
    <tr><td>Crockery unit</td><td>Built-in</td><td class="num">₹35,000–75,000</td></tr>
    <tr><td>3-seater sofa + 2 chairs</td><td>Loose</td><td class="num">₹60,000–1.8 lakh</td></tr>
    <tr><td>4–6 seater dining set</td><td>Loose</td><td class="num">₹35,000–1.2 lakh</td></tr>
    <tr><td>Coffee and side tables</td><td>Loose</td><td class="num">₹10,000–40,000</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026, before GST. The kitchen is separate; price it with the <a href="/calculators/modular-kitchen/">kitchen calculator</a>.</p>

<h2>Furniture for Indian homes: what is different</h2>
<ul>
  <li><strong>Storage first:</strong> Indian households keep more at home (festival items, quilts, utensils, documents, suitcases), so built-in storage beds, lofts and wall units matter more than in many Western homes.</li>
  <li><strong>Floor seating and family gatherings:</strong> extra floor cushions, diwan beds and benches flex for guests.</li>
  <li><strong>Humidity and monsoon:</strong> choose moisture-resistant boards, finish all faces, and keep furniture 25–50 mm off external walls.</li>
  <li><strong>Termites:</strong> treated boards and anti-termite treatment for built-ins on ground floors.</li>
  <li><strong>Cleaning habits:</strong> daily mopping means furniture bases should be raised on legs or plinths with water-resistant edges.</li>
</ul>
<?= img('raised-furniture-legs-for-floor-mopping', caption: 'Furniture raised on slim legs: easier daily mopping and no water at the board edges') ?>

<h2>Quality checklist for any piece</h2>
<ol>
  <li><strong>Core material and grade</strong> in writing (e.g. BWR plywood IS 303, HDHMR).</li>
  <li><strong>Edges:</strong> edge-banded on all exposed sides, including the back and bottom near the floor.</li>
  <li><strong>Joinery:</strong> dowels, cam locks or mortise and tenon; not only nails and staples.</li>
  <li><strong>Hardware:</strong> hinge and channel brand, soft-close, load ratings.</li>
  <li><strong>Finish:</strong> laminate thickness (0.8–1 mm), veneer type, PU coats.</li>
  <li><strong>Warranty:</strong> separately for boards, hardware and finish.</li>
</ol>
<?= img('edge-banding-and-hinge-quality-check', caption: 'Checking edge-banding and branded soft-close hinges inside a built-in unit') ?>

<h2>Sustainable furniture choices</h2>
<ul>
  <li>Choose FSC or similarly certified timber where available, or plantation woods such as rubberwood and mango.</li>
  <li>Prefer low-emission boards (E1 or better) and water-based finishes indoors.</li>
  <li>Buy for repairability: replaceable cushions, removable covers, screwed rather than glued construction.</li>
  <li>Reuse and refinish: old solid-wood pieces can be re-polished and re-upholstered.</li>
</ul>

<h2>How to brief a carpenter or designer</h2>
<ol>
  <li><strong>A measured plan</strong> with doors, windows, switches and pillars marked.</li>
  <li><strong>A list of what each unit must hold:</strong> number of hanging clothes, shoes, books, devices.</li>
  <li><strong>The specification:</strong> board, finish, hardware brand, edge-banding.</li>
  <li><strong>Elevation drawings</strong> for every built-in unit, signed off before cutting starts.</li>
  <li><strong>A sample</strong> of the laminate or veneer and a hardware sample, kept on site.</li>
</ol>
<p>Our <a href="/planning/how-to-choose-interior-designer/">guide to choosing an interior designer</a> lists the questions to ask, and the <a href="/calculators/home-interior-quote/">quote builder</a> gives you an itemised list to compare quotes against.</p>
<?= img('carpenter-reviewing-wardrobe-elevation-drawing', caption: 'A wardrobe elevation drawing with internal layout, reviewed on site before cutting starts') ?>

<h2>Terms explained</h2>
<dl class="terms">
  <dt>Carcass</dt><dd>The box structure of a cabinet or wardrobe, behind the shutters.</dd>
  <dt>Shutter</dt><dd>The door or front panel of a cabinet.</dd>
  <dt>Edge-banding</dt><dd>A strip of laminate, PVC or veneer glued to board edges to seal and finish them.</dd>
  <dt>Kiln-dried</dt><dd>Timber dried in a controlled kiln to a target moisture content before use.</dd>
  <dt>E1 emission class</dt><dd>A low formaldehyde-emission class for wood-based boards.</dd>
  <dt>Loft</dt><dd>A storage cabinet above a wardrobe or door, reaching up to the ceiling.</dd>
</dl>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
