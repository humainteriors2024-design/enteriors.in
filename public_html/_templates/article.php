<?php
/* =====================================================================
   CLUSTER PAGE TEMPLATE — a detailed page under a pillar (e.g. /materials/laminate-guide/).
   1. Make the folder at the page's URL exactly as it is written in includes/nav.php
   2. Copy this file into it as index.php, fill in $page, write the content, upload.
   3. Images go in /assets/pages/<same path>/  (hero.jpg = main image).
   The menu, breadcrumbs, "part of our guide to …" link, contents list, FAQ, calculator box,
   related links, author box and share buttons are added for you. Every link to this page
   elsewhere on the site switches on by itself once the page is uploaded.
   A finished example: /materials/plywood-guide/index.php
   ===================================================================== */
$page = [
  'type'         => 'article',
  'title'        => 'Page H1 — up to 65 characters',
  'seo_title'    => 'Google title — up to 48 characters',     // " | Enteriors" is added
  'crumb'        => 'Short breadcrumb name',
  'description'  => 'Meta description: 140–158 characters that answer the search and earn the click. It shows under the title in Google results.',
  'eyebrow'      => 'Boards',              // small red label above the H1
  'lede'         => 'One sentence under the H1 saying what this page gives the reader.',
  'hero_alt'     => 'What the main photo shows',
  'published'    => '2026-10-03',          // YYYY-MM-DD, never change after launch
  'updated'      => '2026-10-03',          // change every time you edit the page
  'quick_answer' => 'Two or three sentences that answer the main question directly.',
  'faq' => [
    'Question people ask?' => 'Short, direct answer.',
  ],
  'related' => [                           // exactly three: the pillar first, then two sibling pages
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
    ['/materials/plywood-guide/', 'Plywood guide', 'MR, BWR and BWP grades', 'Boards'],
    ['/compare/acrylic-vs-laminate/', 'Acrylic vs laminate', 'Which finish to choose', 'Compare'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Intro. Link up to the pillar in the first paragraph, e.g. part of choosing <a href="/materials/">interior design materials</a>.</p>

<h2>First section (becomes a contents link automatically)</h2>
<p>Start with the answer, then the detail.</p>
<?= img('descriptive-file-name') ?>

<h2>Second section</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Column</th><th class="num">Price</th></tr></thead>
  <tbody><tr><td>Value</td><td class="num">₹0–0</td></tr></tbody>
</table>
</div>

<div class="callout callout--tip"><span class="callout__title">Tip</span>Optional tip box.</div>

<h2>Third section</h2>
<p>Link sideways to two or three sibling pages and once to the matching calculator.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
