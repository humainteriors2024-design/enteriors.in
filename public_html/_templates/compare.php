<?php
/* =====================================================================
   COMPARISON PAGE TEMPLATE — "X vs Y" (lives in /compare/x-vs-y/).
   Same as a cluster page, plus a verdict box built from 'verdict'.
   Add the page to the list in /compare/index.php so it shows on the comparisons page.
   A finished example: /compare/acrylic-vs-laminate/index.php
   ===================================================================== */
$page = [
  'type'         => 'compare',
  'title'        => 'X vs Y: Which Is Better for …? (up to 65 characters)',
  'seo_title'    => 'X vs Y — up to 48 characters',
  'crumb'        => 'X vs Y',
  'description'  => 'Meta description: 140–158 characters. Say what is compared, on which points, and that the page ends with a clear verdict.',
  'eyebrow'      => 'Boards compared',
  'lede'         => 'One sentence on the choice this page settles.',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'The short verdict in two or three sentences.',
  'verdict' => [                           // printed as "Choose x if…" / "Choose y if…"
    'x' => ['Reason one', 'Reason two', 'Reason three', 'Reason four'],
    'y' => ['Reason one', 'Reason two', 'Reason three', 'Reason four'],
  ],
  'faq' => [
    'Question people ask?' => 'Short, direct answer.',
  ],
  'related' => [                           // the pillar first, then two sibling pages
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
    ['/materials/plywood-guide/', 'Plywood guide', 'MR, BWR and BWP grades', 'Boards'],
    ['/materials/hdhmr-board/', 'HDHMR board', 'Where it works and where it does not', 'Boards'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Intro: who faces this choice and why it matters. Link up to the pillar guide.</p>

<h2>X vs Y at a glance</h2>
<div class="table-wrap">
<table>
  <thead><tr><th></th><th>X</th><th>Y</th></tr></thead>
  <tbody>
    <tr><td>Water resistance</td><td>…</td><td>…</td></tr>
    <tr><td>Cost</td><td>…</td><td>…</td></tr>
  </tbody>
</table>
</div>

<h2>Where X is the better choice</h2>
<p>Text.</p>

<h2>Where Y is the better choice</h2>
<div class="pros-cons">
  <div><span class="pros-cons__title">X</span><ul><li>Point</li><li>Point</li></ul></div>
  <div><span class="pros-cons__title">Y</span><ul><li>Point</li><li>Point</li></ul></div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
