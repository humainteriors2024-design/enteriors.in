<?php
/* CLUSTER ARTICLE — Plywood guide (/materials/plywood-guide/)
   Parent pillar: /materials/ (worked out from the URL).
   Images: /assets/pages/materials/plywood-guide/   (hero.jpg = main image)
   Prices sit in $GRADES and $BOARDS so they are edited in one place.
   They match the board table on the materials pillar and in cost/2-bhk-interior-cost/. */
$GRADES = [   // grade => [full name, glue, standard, where it is used, ₹ per sq ft for 18 mm]
  'MR'  => ['Moisture resistant', 'Urea-formaldehyde resin', 'IS 303', 'Interior grade for dry rooms: bedroom wardrobes, TV and study units', '₹75–120'],
  'BWR' => ['Boiling water resistant', 'Phenol-formaldehyde resin', 'IS 303', 'General-purpose exterior grade: kitchen cabinets away from the sink, furniture in humid rooms', '₹90–140'],
  'BWP' => ['Boiling water proof', 'Phenol-formaldehyde resin', 'IS 710', 'Marine grade: sink unit, kitchen base units, bathroom vanity, utility', '₹110–180'],
];
$BOARDS = [   // board => [link or '', water tolerance, screw holding, surface, ₹ per sq ft for 18 mm]
  'Plywood'        => ['', 'Set by the grade, from MR to BWP', 'Very good, even when a fitting is refitted', 'Slight grain; a sound base for laminate and veneer', '₹75–180'],
  'HDHMR board'    => ['/materials/hdhmr-board/', 'Good while the edges stay sealed', 'Good; weaker if a hole is reused', 'Very smooth; suits acrylic and PU', '₹70–110'],
  'MDF board'      => ['/materials/mdf-board/', 'Low', 'Fair; weak on edges', 'Very smooth; suits paint and routed designs', '₹45–75'],
  'Particle board' => ['/materials/particle-board/', 'Poor', 'Low', 'Usually sold pre-laminated', '₹35–55'],
];
$page = [
  'type'         => 'article',
  'title'        => 'Plywood Guide for Interiors: MR, BWR and BWP Grades and Price',
  'seo_title'    => 'Plywood Guide: MR vs BWR vs BWP Grades and Price',
  'crumb'        => 'Plywood Guide',
  'description'  => 'Plywood guide for Indian interiors: MR, BWR and BWP grades, IS 303 and IS 710, which grade goes where, thickness, 18 mm prices and how to check a sheet.',
  'eyebrow'      => 'Boards',
  'lede'         => 'The three plywood grades, the right thickness for each part, what an 18 mm sheet costs, and how to check you received what you paid for.',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'Plywood for interiors comes in three grades: MR for dry rooms, BWR for kitchen cabinets and humid rooms, and BWP (marine) for the sink unit, the vanity and other wet zones. Use 18–19 mm sheets for carcass sides, shelves and shutters, and 6–9 mm for back panels. Indicative 18 mm prices in Bengaluru are ₹75–120 per sq ft for MR, ₹90–140 for BWR and ₹110–180 for BWP, including GST.',
  'faq' => [
    'Which plywood is best for kitchen cabinets?' => 'BWP (marine) plywood for the sink unit and any cabinet beside plumbing. BWP or BWR plywood suits the other base units, and BWR is enough for wall units, which stay drier. MR plywood should be kept out of the kitchen.',
    'What is the difference between MR, BWR and BWP plywood?' => 'The difference is in the glue line. MR plywood uses urea-formaldehyde resin and is meant for dry interiors. BWR and BWP plywood use phenol-formaldehyde resin, and BWP is made to the stricter marine standard, IS 710.',
    'What thickness of plywood is used for wardrobes and kitchens?' => 'Usually 18 or 19 mm for carcass sides, shelves and shutters, and 6–9 mm for back panels and drawer bottoms. Some drawer sides and partitions are made in 12 mm, and heavy tops or long spans in 25 mm.',
    'Is BWP plywood fully waterproof?' => 'Its glue line is made to hold when wet, which is why it is used near sinks. The wood itself still takes in water through cut edges, so every edge and pipe cut-out must be sealed. No plywood should sit in standing water.',
    'How do I check that the plywood is genuine?' => 'Look for the brand, the grade and the IS number stamped on each sheet: IS 303 on MR and BWR plywood, IS 710 on BWP. Measure the thickness at several points, look along the edge for even plies, and keep a bill that names the brand and grade.',
    'What does 18 mm plywood cost in Bangalore?' => 'As an indication for branded sheets in October 2026, including GST: MR ₹75–120, BWR ₹90–140 and BWP ₹110–180 per sq ft. A standard 8 × 4 ft sheet is 32 sq ft, so multiply the rate by 32 for a sheet price.',
  ],
  'related' => [   // the first three that are uploaded are shown: pillar first, then sibling pages
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone compared', 'Pillar guide'],
    ['/compare/bwp-vs-bwr-vs-mr-plywood/', 'BWP vs BWR vs MR plywood', 'Grade-by-grade verdict', 'Compare'],
    ['/materials/hdhmr-board/', 'HDHMR board guide', 'The dense board used for shutters', 'Boards'],
    ['/materials/acrylic-finish/', 'Acrylic finish guide', 'A finish to put on the board', 'Finishes'],
    ['/materials/wood-veneer/', 'Wood veneer guide', 'Real wood grain on plywood', 'Finishes'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Plywood is the board inside most kitchens, wardrobes and TV units in Indian homes. Of all the <a href="/materials/">interior design materials</a> it is the one to settle first, because the board cannot be changed later without rebuilding the furniture. This plywood guide explains the three grades (MR, BWR and BWP), the thickness used for each part, indicative Bengaluru prices for October 2026 and how to check a sheet before it is cut.</p>

<h2>What plywood is and why it stays flat</h2>
<p>Plywood is made from thin sheets of wood called veneers. They are coated with resin, stacked so that the grain of each layer runs at right angles to the layer below, and bonded in a press under heat and pressure. Each layer is a ply. A sheet has an odd number of plies, so the two outer faces have their grain running the same way and the sheet is balanced about its middle layer.</p>
<p>Wood swells and shrinks mostly across its grain. In plywood every ply is held by neighbours running the other way, so that movement is restrained in both directions. This is why a plywood panel resists warping better than a solid plank of the same size, is strong along both its length and its width, and grips a screw well. The standard sheet is 8 × 4 ft, which is 32 sq ft.</p>

<h2>MR, BWR and BWP: the three plywood grades</h2>
<p>The grade describes how well the glue between the plies stands up to water. It says little about the wood itself.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Grade</th><th>Stands for</th><th>Glue</th><th>Standard</th><th>Where it is used</th><th class="num">18 mm, per sq ft</th></tr></thead>
  <tbody>
<?php foreach ($GRADES as $grade => [$name, $glue, $standard, $use, $price]): ?>
    <tr><td><?= e($grade) ?></td><td><?= e($name) ?></td><td><?= e($glue) ?></td><td><?= e($standard) ?></td><td><?= e($use) ?></td><td class="num"><?= e($price) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices for branded sheets, including GST, October 2026. Hosur is usually 5–10% lower.</p>
<p>IS 303 is the Indian Standard for general-purpose plywood, and it covers the MR and BWR grades. IS 710 is the separate standard for marine plywood, and BWP plywood is made to it. BWR and BWP both use phenolic resin, but the marine standard sets tougher tests for the bond, which is part of why <a href="/materials/marine-plywood/">marine plywood</a> costs more.</p>
<p>"Moisture resistant" does not mean waterproof. <a href="/materials/mr-plywood/">MR plywood</a> copes with humid air, not with wetting. For a decision table on the three grades, see <a href="/compare/bwp-vs-bwr-vs-mr-plywood/">BWP vs BWR vs MR plywood</a>.</p>

<h2>Which grade goes where</h2>
<p>No home needs one grade throughout. Match the grade to how much water each zone sees.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Zone</th><th>Grade</th><th>Why</th></tr></thead>
  <tbody>
    <tr><td>Kitchen sink unit</td><td>BWP</td><td>Closest to leaks and plumbing; seal every pipe cut-out</td></tr>
    <tr><td>Other kitchen cabinets</td><td>BWP or BWR</td><td>Base units meet spills and mopping water; wall units stay drier, so BWR is enough</td></tr>
    <tr><td>Bathroom vanity</td><td>BWP</td><td>Keep it wall-hung, clear of the wet floor</td></tr>
    <tr><td>Wardrobes</td><td>MR; BWR on a wall shared with a bathroom</td><td>A dry room; BWP is rarely worth its price here</td></tr>
    <tr><td>TV and study units</td><td>MR</td><td>A dry zone, so put the saving into the finish or the hardware</td></tr>
    <tr><td>Lofts</td><td>MR in bedrooms; BWR above the kitchen</td><td>Lightly used, but check the wall behind for damp first</td></tr>
  </tbody>
</table>
</div>
<p>The <a href="/calculators/material-selector/">material selector</a> works through the same choices room by room.</p>

<h2>Plywood thickness guide</h2>
<p>Thickness is chosen by the job each panel does. The figures below are common practice, not fixed rules.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Thickness</th><th>Commonly used for</th></tr></thead>
  <tbody>
    <tr><td>18–19 mm</td><td>Carcass sides, shelves and shutters</td></tr>
    <tr><td>12 mm</td><td>Some partitions and drawer sides</td></tr>
    <tr><td>6–9 mm</td><td>Back panels and drawer bottoms</td></tr>
    <tr><td>25 mm</td><td>Heavy tops and long spans</td></tr>
  </tbody>
</table>
</div>
<p>A long shelf that carries books or vessels needs a thicker board or a support in the middle. <a href="/materials/block-board/">Block board</a> is another option for long shelves and doors. Whatever thickness is quoted, it should be written into the quotation for each part, including the back panel.</p>

<h2>Core, species and calibrated plywood</h2>
<p>The grade tells you about the glue; the core tells you about the wood. Plywood made from hardwood veneers such as gurjan is denser and heavier, and it holds screws more firmly. Sheets with a softer core such as poplar are lighter and cheaper, and are acceptable for lightly loaded parts in dry rooms. Two sheets of the same grade can therefore differ a good deal in weight and price, so ask what the core is.</p>
<p>Calibrated plywood has been sanded to a uniform thickness across the whole sheet. This matters for modular, machine-made furniture, where the cutting, drilling and edge-banding machines are set to one thickness and an uneven sheet leaves stepped joints. It matters less for furniture built by hand on site, though an even sheet is still easier to work.</p>

<h2>How to check a plywood sheet at site</h2>
<ol class="steps">
  <li><strong>Read the stamp</strong>Each sheet should show the brand, the grade and the IS number: IS 303 on MR and BWR plywood, IS 710 on BWP.</li>
  <li><strong>Measure the thickness</strong>Use a calliper or a tape at several points along the edges. A sheet sold as 18 mm should not measure nearer 16 mm.</li>
  <li><strong>Look at the edge</strong>The plies should be even and straight, with no gaps and no overlaps between them.</li>
  <li><strong>Check that it lies flat</strong>Lay the sheet on a level floor. A bow or a twist will not come out once the sheet is cut.</li>
  <li><strong>Judge the weight</strong>Lift one corner and compare with another sheet of the same size and thickness. A much lighter sheet points to a softer core or to gaps inside.</li>
  <li><strong>Tap the surface</strong>Knock across the face with your knuckles. A hollow sound suggests a gap or a weak bond below.</li>
  <li><strong>Keep the bill</strong>It should name the brand, the grade, the thickness and the number of sheets.</li>
</ol>
<p>Factory-made modules arrive already cut and finished, so ask for photographs of the stamped sheets or the supplier invoice before production starts.</p>

<h2>Plywood versus HDHMR, MDF and particle board</h2>
<p>Plywood is not the only board in a quotation. The others are made from wood fibres or chips pressed with resin, and each has a place.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Board</th><th>Water tolerance</th><th>Screw holding</th><th>Surface</th><th class="num">18 mm, per sq ft</th></tr></thead>
  <tbody>
<?php foreach ($BOARDS as $board => [$href, $water, $screws, $surface, $price]): ?>
    <tr><td><?php if ($href): ?><a href="<?= e($href) ?>"><?= e($board) ?></a><?php else: ?><?= e($board) ?><?php endif; ?></td><td><?= e($water) ?></td><td><?= e($screws) ?></td><td><?= e($surface) ?></td><td class="num"><?= e($price) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices for branded sheets, including GST, October 2026.</p>
<p>A common and sensible combination is a plywood carcass with HDHMR shutters: the plywood carries the load and the hinge screws, and the fibreboard gives a flatter face for the finish. The trade-offs are set out in <a href="/compare/hdhmr-vs-plywood/">HDHMR vs plywood</a> and <a href="/compare/mdf-vs-plywood/">MDF vs plywood</a>.</p>

<h2>Termite treatment, storage and handling on site</h2>
<p>Many branded sheets are treated in the factory against termites and borers. If it matters to you, ask for the treatment and any warranty to be stated in writing rather than taken on trust. Treatment protects the board, not the wall behind it, so repair any damp before the woodwork goes up and keep the wood off damp walls.</p>
<ul>
  <li><strong>Stack sheets flat.</strong> Keep them off the floor on level supports, away from wet walls and rain. Sheets left leaning against a wall can bow.</li>
  <li><strong>Seal every cut.</strong> Cut edges, sink cut-outs and pipe holes expose the plies and should be sealed before the cabinet is fixed.</li>
  <li><strong>Band the edges.</strong> Edge banding on all exposed edges, including those at the back and bottom, keeps water out of the core.</li>
</ul>

<h2>Common mistakes when buying plywood</h2>
<ul>
  <li><strong>Paying for BWP everywhere.</strong> Only the wet zones need it. Bedroom wardrobes and TV units do well in MR or BWR.</li>
  <li><strong>Accepting "commercial ply".</strong> It is a loose trade term, most often used for MR-grade sheets, and not a specification. Ask for MR, BWR or BWP, the brand and the IS number.</li>
  <li><strong>Trusting an unbranded "waterproof" claim.</strong> Waterproof is a sales word. Without a stamp and a bill there is nothing to check it against.</li>
  <li><strong>Mixing grades without marking them.</strong> If a home uses two or three grades, the drawings and the quotation should state which cabinet gets which.</li>
</ul>
<div class="callout callout--tip"><span class="callout__title">Put it in writing</span>For each group of cabinets, the quotation should state the plywood brand, grade, thickness and IS number, with a clause that any substitution needs your approval.</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
