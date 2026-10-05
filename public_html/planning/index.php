<?php
/* PILLAR PAGE — Home Planning (/planning/)
   Cluster links ("In this guide") come from includes/nav.php → 'planning'.
   Images: /assets/pages/planning/   (hero.jpg = main image)
   Budget bands and timelines used on this page are in $BANDS and $TIMELINE so they are edited in one place. */
$BANDS = [   // grade => [₹ per sq ft of carpet area incl. GST, 2 BHK (~950 sq ft), 3 BHK (~1,400 sq ft)]
  'Essential' => ['₹450–700', '₹4.2–6.5 lakh', '₹6–10 lakh'],
  'Standard'  => ['₹700–1,100', '₹6.5–10 lakh', '₹10–15 lakh'],
  'Premium'   => ['₹1,100–1,700', '₹10.5–16 lakh', '₹15–24 lakh'],
  'Luxury'    => ['₹1,700 and above', 'Quoted per project', 'Quoted per project'],
];
$TIMELINE = [   // scope => [typical duration, what happens]
  'Design stage'                    => ['2–3 weeks', 'Site measurement, layout, 3D views, samples and the itemised quotation'],
  'Kitchen and wardrobes only'      => ['45–60 days', 'Factory production, electrical changes, installation and countertop'],
  'Full home'                       => ['75–100 days', 'Adds false ceiling, painting, lighting, TV unit and curtains'],
  'Premium finishes or custom work' => ['Up to four months', 'Veneer, PU and made-to-order furniture need longer finishing time'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'planning',
  'title'        => 'Home Interior Planning: Where to Start and What to Decide',
  'seo_title'    => 'Home Interior Planning: Steps and Checklist',
  'crumb'        => 'Home Planning',
  'description'  => 'A home interior planning guide: when to start, a nine-step design process, budget bands, electrical points, lighting, storage, layout and timelines.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'The decisions to take, in the order to take them, from the first budget figure to the final snag list.',
  'hero_alt'     => 'Floor plan, laminate samples and a measuring tape laid out on a table',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'Start planning two to three months before possession or move-in. Fix the budget and scope first, then the furniture layout, then electrical and lighting, then materials, and only then compare itemised quotations. In Bengaluru, full-home interiors cost roughly ₹450–700 per sq ft of carpet area in essential grade, ₹700–1,100 in standard and ₹1,100–1,700 in premium, including GST (indicative, October 2026), and a full home takes about 75–100 days.',
  'faq' => [
    'When should I start planning my home interiors?' => 'Two to three months before possession of a new flat, or before the date you want to move in. The budget, the brief and the designer shortlist can all be done before handover; accurate measurement and production have to wait until you have the keys.',
    'What is the first step in home interior planning?' => 'Set the total budget and the scope it must cover. Every later choice, from the layout to the shutter finish, is easier and faster when the spending limit is already fixed.',
    'How much should I budget for home interiors in Bangalore?' => 'As an indicative range for October 2026, about ₹450–700 per sq ft of carpet area in essential grade, ₹700–1,100 in standard and ₹1,100–1,700 in premium, including GST. That covers kitchen, wardrobes, TV unit, false ceiling, painting, lighting and curtains, and excludes loose furniture, flooring and bathrooms. Keep a further 10–15% as contingency.',
    'How long do home interiors take from design to handover?' => 'Allow two to three weeks for design, about 45–60 days for a kitchen and wardrobes, and 75–100 days for a full home. Premium work with veneer, PU or custom furniture can run to four months.',
    'Should electrical work be done before the false ceiling?' => 'Yes. Conduits, sockets and light points are completed before the false ceiling is closed and before painting. Adding a point later means cutting into a finished wall or ceiling.',
    'Can home interiors be done in phases?' => 'Yes. Do the kitchen, wardrobes, electrical changes and painting before you move in, because they are dusty or need walls opened. The TV wall, crockery unit, curtains and décor can follow later, provided their wiring is run in the first phase.',
  ],
  'related' => [   // sibling pillar guides
    ['/cost/', 'Interior design cost guide', 'Home and room-wise budgets', 'Pillar guide'],
    ['/rooms/', 'Room-by-room guides', 'Layouts, storage and materials for each room', 'Pillar guide'],
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Home interior planning is mostly a matter of taking decisions in the right order. A furniture plan drawn after the electrician has finished, or a budget fixed after the design is approved, leads to rework that costs more than the item itself. This interior planning guide sets out the sequence, the figures to plan with in Bengaluru and Hosur, and the papers to hold before work starts, with a detailed page linked for each step.</p>

<h2>When to start planning</h2>
<p>Start two to three months before possession of a new flat, or before the date you want to move in. That leaves room for design, quotations and factory production without the home standing empty for longer than it needs to.</p>
<div class="pros-cons">
  <div><span class="pros-cons__title">Before handover</span><ul>
    <li>Set the budget and the scope</li>
    <li>Collect the builder's floor plan and electrical layout</li>
    <li>Write the room-by-room brief</li>
    <li>Shortlist designers and ask for concept layouts and rough estimates</li>
    <li>Ask whether the builder will add or shift electrical points before handing over</li>
  </ul></div>
  <div><span class="pros-cons__title">After handover</span><ul>
    <li>Accurate site measurement, including beams, columns and ceiling height</li>
    <li>A check of the builder's work: damp patches, hollow tiles, existing points</li>
    <li>Final drawings and the itemised quotation</li>
    <li>Apartment association rules on work hours and service-lift use</li>
    <li>Production and site work</li>
  </ul></div>
</div>
<p>Do not release anything for production on the builder's drawing alone. Built walls rarely match the plan to the last inch, and modules are cut to the measured size.</p>

<h2>The interior design process, step by step</h2>
<ol class="steps">
  <li><strong>Set the budget and scope</strong>Decide the total you can spend and the rooms and items it must cover.</li>
  <li><strong>Measure and note what exists</strong>Record wall lengths, ceiling height, beams, windows, switchboards and plumbing points, and photograph each wall.</li>
  <li><strong>Write a room-by-room brief</strong>Who uses the room, what must be stored, and which furniture and appliances you already own.</li>
  <li><strong>Fix the layout and furniture plan</strong>Place beds, sofa, dining table, wardrobes and kitchen runs to scale before anything else is decided.</li>
  <li><strong>Plan electrical and lighting</strong>Mark every socket, switch and light against the furniture plan.</li>
  <li><strong>Choose materials and finishes</strong>Boards, laminates, hardware and colours, approved from physical samples.</li>
  <li><strong>Get itemised quotations</strong>Give each firm the same drawings and specification so the totals can be compared.</li>
  <li><strong>Agree timeline and payment stages</strong>Dates and milestone-linked payments go into the agreement.</li>
  <li><strong>Execution and snag list</strong>Site work, installation, then a written list of fixes before the final payment.</li>
</ol>
<p>For step six, the <a href="/materials/">interior materials guide</a> compares boards and finishes, while the <a href="/glossary/">materials glossary</a> and the page on <a href="/glossary/hardware-terms/">hardware terms</a> explain the words you will meet in a specification.</p>

<h2>Budget first, design second</h2>
<p>Design to a budget; do not budget to a design. Full-home interiors are usually compared per square foot of carpet area, in four grades.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Grade</th><th class="num">Per sq ft of carpet area</th><th class="num">2 BHK, about 950 sq ft</th><th class="num">3 BHK, about 1,400 sq ft</th></tr></thead>
  <tbody>
<?php foreach ($BANDS as $grade => [$sqft, $two, $three]): ?>
    <tr><td><?= e($grade) ?></td><td class="num"><?= e($sqft) ?></td><td class="num"><?= e($two) ?></td><td class="num"><?= e($three) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru figures for October 2026, including 18% GST. Hosur usually comes in 5–10% lower.</p>
<p><strong>In scope:</strong> kitchen, wardrobes, TV unit, false ceiling, painting, lighting and curtains. <strong>Not in scope:</strong> loose furniture, flooring, bathroom work and kitchen appliances. List those separately so they do not eat into the interior budget. Home-wise and room-wise ranges are in the <a href="/cost/">interior design cost guide</a>, with worked examples for a <a href="/cost/2-bhk-interior-cost/">2 BHK</a> and a <a href="/cost/3-bhk-interior-cost/">3 BHK</a>.</p>
<div class="callout"><span class="callout__title">Keep 10–15% aside</span>Electrical rework, plumbing shifts, uneven walls and small changes all appear after work begins. On a ₹10 lakh plan, hold ₹1–1.5 lakh outside the quotation.</div>
<h3>What to do now and what can wait</h3>
<p>If money is short, phase the work instead of lowering the board or hardware grade. Do first whatever is dusty or opens walls: electrical conduits, plumbing shifts, kitchen, wardrobes and painting. The TV wall, crockery unit, wall panelling, curtains and décor can follow after you have lived in the home for a few months. If a false ceiling or TV wall is coming later, run its wiring now.</p>
<p>The <a href="/calculators/interior-cost/">interior cost calculator</a> gives a first estimate, the <a href="/calculators/home-interior-quote/">budget planner</a> helps you divide it between rooms, and <a href="/planning/budget-control/">budget planning and control</a> deals with holding the figure once work is under way.</p>

<h2>A home planning checklist by stage</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Stage</th><th>What to decide</th><th>Who does it</th></tr></thead>
  <tbody>
    <tr><td>Before possession</td><td>Budget ceiling, scope, must-haves, shortlist of firms</td><td>You</td></tr>
    <tr><td>At handover</td><td>Measurements, existing points, beams, builder defects to be fixed</td><td>You, with the designer</td></tr>
    <tr><td>Design</td><td>Furniture layout, electrical and lighting plan, elevations, 3D views</td><td>Designer; you sign off</td></tr>
    <tr><td>Specification</td><td>Board grade, finish, hardware, colours, approved samples</td><td>Designer proposes; you approve</td></tr>
    <tr><td>Agreement</td><td>Itemised quotation, dates, payment stages, warranty</td><td>You and the firm</td></tr>
    <tr><td>Site work</td><td>Order of electrical, plumbing, ceiling and painting</td><td>Project manager and site team</td></tr>
    <tr><td>Installation</td><td>Module fit, shutter alignment, countertop, light fittings</td><td>Installers; project manager checks</td></tr>
    <tr><td>Handover</td><td>Snag list, warranty papers, final payment</td><td>You, with the project manager</td></tr>
  </tbody>
</table>
</div>
<p>The longer <a href="/planning/home-planning-checklist/">home planning checklist</a> breaks each of these stages into individual items.</p>

<h2>Electrical points and lighting</h2>
<p>Electrical work is the first trade on site and the hardest to change later. Plan it from your furniture layout, not from the builder's default points.</p>
<ul>
  <li><strong>Count sockets room by room</strong> against the appliances you own, then add a few spare.</li>
  <li><strong>Separate 16 A points</strong> for the geyser, air conditioner, oven, microwave and washing machine. Lamps, chargers and the television run on 6 A points.</li>
  <li><strong>Two-way switches at the bedside</strong>, so the main light can be switched off from the bed as well as the door.</li>
  <li><strong>Data and TV points</strong> for the router, the TV wall and the study desk, fixed before walls are closed.</li>
</ul>
<div class="callout callout--warn"><span class="callout__title">Order of work</span>Conduits and points are completed before the false ceiling is closed and before painting. A point added afterwards means cutting into a finished surface.</div>
<p>The page on <a href="/planning/electrical-points/">planning electrical points</a> takes this further for each room.</p>
<h3>Lighting in three layers</h3>
<p>Good lighting comes from three layers on separate switches: <strong>ambient</strong> light for the whole room, <strong>task</strong> light where you cook, read or work, and <strong>accent</strong> light for a wall, a niche or a shelf. Use warm white, about 2700–3000 K, in living rooms and bedrooms, and neutral white, about 4000 K, in the kitchen and study. Lights and ceiling are drawn together, so read <a href="/planning/lighting-design/">lighting design</a> alongside the <a href="/false-ceiling/">false ceiling guide</a>.</p>

<h2>Storage, room by room</h2>
<p>List what you own before any cabinet is drawn. Storage sized to real belongings avoids both clutter and paying for shelves that stay empty.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Room</th><th>What needs storing</th><th>Typical solution</th></tr></thead>
  <tbody>
    <tr><td>Foyer</td><td>Footwear, keys, helmets, umbrellas</td><td>Shoe cabinet with a seat and one shallow drawer</td></tr>
    <tr><td>Living room</td><td>Media devices, books, display pieces</td><td>TV unit with closed base storage and a few open shelves</td></tr>
    <tr><td>Kitchen</td><td>Vessels, groceries, small appliances, dustbin</td><td>Drawers under the counter, a tall pantry unit, lofts</td></tr>
    <tr><td>Bedroom</td><td>Clothes, bedding, suitcases</td><td>Floor-to-ceiling wardrobe with loft; bed with storage</td></tr>
    <tr><td>Children's room</td><td>Toys, books, school bags</td><td>Low open shelves and a study unit with drawers</td></tr>
    <tr><td>Bathroom</td><td>Toiletries, towels, cleaning supplies</td><td>Vanity under the basin and a mirror cabinet</td></tr>
    <tr><td>Utility</td><td>Detergents, mops, buckets, drying stand</td><td>Tall cabinet in water-resistant board</td></tr>
  </tbody>
</table>
</div>
<p>Sizes and internal fittings are covered in <a href="/planning/storage-room-by-room/">storage, room by room</a>.</p>

<h2>Furniture layout and clearances</h2>
<p>The layout decides whether a room is comfortable to use, and no finish can rescue a poor one. Three clearances matter most:</p>
<ul>
  <li><strong>Walkways:</strong> about 3 ft clear on the main routes through a room.</li>
  <li><strong>Beside a bed:</strong> about 2 ft on each open side.</li>
  <li><strong>Door swings:</strong> room doors, wardrobe shutters and drawers must open fully without meeting furniture.</li>
</ul>
<p>Draw the room to scale on squared paper, or mark the furniture sizes on the floor with masking tape and walk around them. The <a href="/planning/furniture-layout/">furniture layout</a> page covers each room, and the <a href="/rooms/">room guides</a> go deeper into individual spaces.</p>
<h3>Small homes</h3>
<p>In a compact flat the same rules apply with less margin. Sliding shutters where a swing door would block a passage, full-height storage and furniture that does two jobs all help; more ideas are in <a href="/lifestyle/small-home-hacks/">small home hacks</a>.</p>

<h2>Choosing who will build it</h2>
<div class="table-wrap">
<table>
  <thead><tr><th></th><th>Designer-led firm</th><th>Modular brand</th><th>Carpenter with a separate designer</th></tr></thead>
  <tbody>
    <tr><td>Design</td><td>Drawn for your home by the firm's designer</td><td>Adapted from the brand's catalogue of modules</td><td>Freelance designer or architect, paid a fee</td></tr>
    <tr><td>Making</td><td>Own or partner factory</td><td>Brand's factory</td><td>On site or in a small workshop</td></tr>
    <tr><td>Flexibility</td><td>High</td><td>Within module sizes and listed finishes</td><td>Highest for odd shapes</td></tr>
    <tr><td>Coordination</td><td>One firm answers for design and execution</td><td>Brand handles its own scope; other trades may be yours</td><td>You or the designer coordinate every trade</td></tr>
    <tr><td>Paperwork</td><td>Itemised quotation and written warranty are usual</td><td>Standard quotation and warranty terms</td><td>Often informal unless you insist</td></tr>
  </tbody>
</table>
</div>
<p>None of the three is better in every home. Compare them on written specification, supervision and service terms, using the questions in <a href="/planning/how-to-choose-interior-designer/">how to choose an interior designer</a>.</p>

<h2>How long it takes</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Scope</th><th class="num">Typical duration</th><th>What it covers</th></tr></thead>
  <tbody>
<?php foreach ($TIMELINE as $scope => [$days, $what]): ?>
    <tr><td><?= e($scope) ?></td><td class="num"><?= e($days) ?></td><td><?= e($what) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Indicative durations. A compact 2 BHK can finish a little sooner; design changes after sign-off and late material choices are the usual causes of delay.</p>

<h2>What to have in writing</h2>
<ul>
  <li><strong>Itemised quotation:</strong> room by room, with size, rate and GST for each item.</li>
  <li><strong>Material specification:</strong> board grade and thickness, finish, and hardware brand and model.</li>
  <li><strong>Drawings:</strong> the signed layout, elevations and electrical plan that the site team will build from.</li>
  <li><strong>Payment stages:</strong> each payment tied to a completed milestone, not to a calendar date.</li>
  <li><strong>Warranty terms:</strong> what is covered, for how long, and how to raise a service request.</li>
  <li><strong>Handover checklist:</strong> a written snag list with a date against each fix.</li>
</ul>

<h2>Common planning mistakes</h2>
<ul>
  <li><strong>Designing before budgeting.</strong> The design then has to be cut back, and the cuts usually fall on boards and hardware.</li>
  <li><strong>Buying the sofa or bed first.</strong> Pieces bought before the layout is fixed often do not fit it.</li>
  <li><strong>Accepting the builder's electrical layout.</strong> It was drawn without your furniture in mind.</li>
  <li><strong>Comparing quotations on the total alone.</strong> Different specifications make the totals meaningless.</li>
  <li><strong>Changing the design after production starts.</strong> Every altered module is remade at your cost.</li>
  <li><strong>No contingency.</strong> The first surprise then comes out of the finish or the fittings.</li>
  <li><strong>Releasing the final payment before the snag list is closed.</strong></li>
</ul>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
