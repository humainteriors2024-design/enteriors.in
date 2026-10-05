<?php
/* BLOG POST — /blogs/factory-made-vs-site-made-interiors/
   Title, description, category, date and image folder: includes/posts-data.php
   Images: /assets/blogs/factory-made-vs-site-made-interiors/   (hero.jpg = main image) */
$post = [
  'quick_answer' => 'Factory-made (modular) interiors are cut, edge-banded and drilled by machines and assembled on site; site-made interiors are built by carpenters in your home. Factory-made units have more consistent finish, sealed edges and less dust, take less time on site and can be dismantled; site-made work fits odd walls easily and may cost 10–20% less on paper. Board, hardware and edge sealing matter more than the method.',
  'takeaways' => [
    'Factory: square, sealed, consistent panels; 2–3 weeks in the factory, days on site.',
    'Site-made: flexible for odd walls; weeks of dust and noise at home.',
    'Edge sealing is the biggest durability difference in humid cities.',
    'Visit the factory: panel saw, edge-bander, boring machine, boards stored off the floor.',
  ],
  'faq' => [
    'Is factory-made furniture better than carpenter-made?' => 'For kitchens and wardrobes, usually yes: machine-cut panels, pressed edge banding and precise hardware drilling give a better and longer-lasting finish. A skilled carpenter is still useful for odd shapes, loose furniture and repairs.',
    'Is modular furniture more expensive than carpenter work?' => 'On paper it can be 10–20% more, but carpenter quotes often exclude edge banding, polish, wastage and the cost of weeks of site work. Compare the same board, finish and hardware.',
    'What should I check when visiting a modular factory?' => 'A panel saw or beam saw, an edge-banding machine, a boring machine for hinge holes, branded boards stored flat and off the floor, and finished modules wrapped for transport.',
  ],
  'related' => [
    ['/planning/', 'Home planning guide', 'Checklists, electricals, lighting and budget', 'Pillar guide'],
    ['/compare/modular-vs-carpenter-kitchen/', 'Modular vs carpenter kitchen', 'The kitchen comparison in detail', 'Compare'],
    ['/services/turnkey-execution/', 'Turnkey execution', 'One team from design to handover', 'Services'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-start.php';
?>
<p>Twenty years ago almost every Indian kitchen and wardrobe was built by carpenters in the home. Today most are made in factories and assembled on site. The difference affects how your interiors look on day one, how they cope with the monsoon, how long the work takes and how much dust you live with. This post compares the two. It is part of our <a href="/planning/">home planning guide</a>.</p>

<h2>Side by side</h2>
<div class="table-wrap">
<table>
  <thead><tr><th></th><th>Factory-made (modular)</th><th>Site-made (carpenter)</th></tr></thead>
  <tbody>
    <tr><td>Cutting</td><td>Panel or beam saw: square, exact</td><td>Hand or table saw: varies with skill</td></tr>
    <tr><td>Edges</td><td>Machine-pressed edge banding, all edges</td><td>Glued tape or lipping, often front edges only</td></tr>
    <tr><td>Hardware holes</td><td>Machine-bored, consistent</td><td>Hand-drilled</td></tr>
    <tr><td>Time on site</td><td>Days</td><td>Weeks</td></tr>
    <tr><td>Dust and noise at home</td><td>Low</td><td>High</td></tr>
    <tr><td>Odd walls and shapes</td><td>Needs fillers and precise measurement</td><td>Easy to adapt</td></tr>
    <tr><td>Dismantle and move</td><td>Possible</td><td>Rarely</td></tr>
    <tr><td>Cost on paper</td><td>Baseline</td><td>Often 10–20% less</td></tr>
  </tbody>
</table>
</div>
<?= img('modular-factory-panel-saw-and-edge-bander', caption: 'Inside a modular factory: a panel saw cuts boards square and an edge-bander seals every edge') ?>

<h2>Why edge sealing matters in humid cities</h2>
<p>Boards absorb moisture through their cut edges. In Bangalore's June–October monsoon, an unsealed edge near a sink or a bathroom wall swells and lifts the laminate. Machine-pressed edge banding with PUR or EVA glue seals every edge evenly; hand-applied tape often leaves gaps. That single difference explains most of the durability gap. See <a href="/blogs/monsoon-proof-kitchen-wardrobe/">monsoon-proof kitchens and wardrobes</a>.</p>

<h2>When site-made still makes sense</h2>
<ul>
  <li>Very irregular walls or curved spaces.</li>
  <li>One-off pieces: a window seat, a pooja niche, a staircase cabinet.</li>
  <li>Small repairs and additions after handover.</li>
</ul>

<h2>What to check on a factory visit</h2>
<ol class="steps">
  <li><strong>Machines</strong>A panel or beam saw, an edge-bander and a boring machine.</li>
  <li><strong>Boards</strong>Branded, grade-stamped sheets stored flat and off the floor, indoors.</li>
  <li><strong>Edges</strong>Pick up an offcut: the banding should be flush, tight and on all edges.</li>
  <li><strong>Assembly</strong>Modules dry-assembled and checked before dispatch.</li>
  <li><strong>Packing</strong>Panels wrapped and corner-protected for transport.</li>
</ol>
<p>The kitchen-specific comparison is in <a href="/compare/modular-vs-carpenter-kitchen/">modular vs carpenter-made kitchens</a>.</p>

<h2>Factories close to home</h2>
<p>Being close to the factory makes a visit easy and after-sales service faster. In South-East Bengaluru, many factories sit in Bommasandra, Jigani and Chandapura. Our execution partner builds in <?= huma('about', 'its own factory in Chandapura') ?>, where homeowners can see their kitchens and wardrobes being made; see their <?= huma('home', 'home interiors in Electronic City', follow: false) ?> and nearby areas. Our <a href="/interior-designers-bangalore/chandapura/">Chandapura area guide</a> explains what to look for.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-end.php'; ?>
