<?php
/* BLOG POST — /blogs/monsoon-proof-kitchen-wardrobe/
   Title, description, category, date and image folder: includes/posts-data.php
   Images: /assets/blogs/monsoon-proof-kitchen-wardrobe/   (hero.jpg = main image) */
$post = [
  'quick_answer' => 'To protect kitchens and wardrobes from monsoon humidity: use BWP plywood (or WPC) near water and BWR elsewhere in the kitchen, seal every edge with machine-pressed edge banding, treat damp walls before fixing units, leave a ventilation gap behind wardrobes on outside walls, use stainless steel hinges near sinks, and air wardrobes and dry the sink unit regularly from June to October.',
  'takeaways' => [
    'Board grade by exposure: BWP at sinks, BWR in kitchens, MR in dry bedrooms.',
    'Sealed edges on all four sides of every panel.',
    'Treat damp walls first; no board survives a wet wall.',
    'Ventilate wardrobes; silica gel or charcoal in closed bays.',
  ],
  'faq' => [
    'Why do kitchen cabinets swell in the monsoon?' => 'Moisture enters through unsealed cut edges and leaks under the sink. MR plywood, MDF and particle board swell first. BWP plywood with sealed edges resists it.',
    'How do I stop mould in wardrobes during the monsoon?' => 'Keep the wardrobe off damp walls, leave a small ventilation gap at the back on outside walls, air it on dry days, use silica gel or charcoal pouches, and avoid storing damp clothes.',
    'Should I avoid interior work during the monsoon?' => 'No, but the firm should store boards indoors and off the floor, seal edges promptly, and allow longer drying time for paint and putty.',
  ],
  'related' => [
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
    ['/compare/bwp-vs-bwr-vs-mr-plywood/', 'BWP vs BWR vs MR plywood', 'Which grade goes where', 'Compare'],
    ['/materials/wpc-board/', 'WPC board', 'Waterproof board for wet areas', 'Materials'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-start.php';
?>
<p>From June to October, humidity in Bangalore stays high and rain finds every weak joint in a building. That is when kitchen cabinets swell, laminate lifts and wardrobes start to smell. Most of it is preventable at the design stage. This post covers what to specify and how to care for units through the season. It is part of our <a href="/materials/">interior materials guide</a>.</p>

<h2>Board by exposure</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Where</th><th>Board</th></tr></thead>
  <tbody>
    <tr><td>Sink unit, dishwasher, vanity, utility</td><td>BWP plywood (IS 710) or WPC</td></tr>
    <tr><td>Other kitchen units</td><td>BWR plywood, or HDHMR with sealed edges</td></tr>
    <tr><td>Wardrobe on a bathroom or outside wall</td><td>BWR plywood</td></tr>
    <tr><td>Wardrobes and units in dry rooms</td><td>MR plywood or HDHMR</td></tr>
  </tbody>
</table>
</div>
<p>Grades are compared in <a href="/compare/bwp-vs-bwr-vs-mr-plywood/">BWP vs BWR vs MR plywood</a>.</p>
<?= img('sealed-plywood-edge-on-sink-cabinet', caption: 'Machine-pressed edge banding on all four edges of a BWP sink-unit panel') ?>

<h2>Five details that matter</h2>
<ol>
  <li><strong>Edge banding on all four edges</strong> of every panel, machine-pressed. See <a href="/blogs/factory-made-vs-site-made-interiors/">factory-made vs site-made</a>.</li>
  <li><strong>Laminate on both faces</strong> of shutters and carcass panels, to balance moisture.</li>
  <li><strong>Aluminium or PVC plinths</strong> under kitchen base units, which do not soak up mopping water.</li>
  <li><strong>Stainless steel hinges</strong> in the sink unit.</li>
  <li><strong>Silicone sealant</strong> around the sink and along the backsplash.</li>
</ol>

<h2>Walls first</h2>
<p>No board survives a wet wall. Before units are fixed, check for seepage on outside walls and walls shared with bathrooms, and treat it. On outside walls, leave a small air gap behind wardrobes or fix them on battens.</p>

<h2>Monsoon care routine</h2>
<ul>
  <li>Wipe and dry the sink unit floor weekly; check the trap for drips.</li>
  <li>Air wardrobes on dry days; keep silica gel or charcoal pouches inside.</li>
  <li>Do not store damp clothes or shoes in closed units.</li>
  <li>Run the AC or a dehumidifier in closed rooms.</li>
  <li>Tighten hinges and clean drawer channels at the end of the season.</li>
</ul>

<h2>During interior work</h2>
<p>If your interiors are being done in the monsoon, ask the firm how boards are stored (indoors, flat, off the floor), how soon edges are sealed after cutting, and how long paint and putty are left to dry. A firm with its own factory controls most of this. Our execution partner works from <?= huma('about', 'its own factory in Chandapura') ?>, where boards are stored indoors and every panel is edge-banded by machine. Local advice for South-East Bengaluru homes is in our <a href="/modular-kitchen/electronic-city-chandapura/">kitchen guide for Electronic City and Chandapura</a>.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-end.php'; ?>
