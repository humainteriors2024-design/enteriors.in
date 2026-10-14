<?php
/* =====================================================================
   PILLAR PAGE TEMPLATE — the main guide for a topic (one per pillar in includes/nav.php).
   1. The folder is the pillar's URL, e.g. /modular-kitchen/  →  copy this file there as index.php
   2. 'pillar' must be the pillar's key in nav.php. The "In this guide" block lists that pillar's
      cluster pages automatically (only pages that are uploaded).
   3. Images go in /assets/pages/<folder>/  (hero.jpg = main image).
   Added for you: page header, facts strip, "In this guide", contents list, quick answer, FAQ,
   closing call to action, related guides, blog posts of this pillar, author box, consultation form.
   A finished example: /modular-kitchen/index.php
   ===================================================================== */
$page = [
  'type'         => 'pillar',
  'pillar'       => 'modular-kitchen',     // key in includes/nav.php
  'title'        => 'Page H1 — up to 65 characters, with the main keyword',
  'seo_title'    => 'Google title — up to 48 characters',     // " | Enteriors" is added
  'crumb'        => 'Short breadcrumb name',
  'description'  => 'Meta description: 140–158 characters that answer the search and earn the click. It shows under the title in Google results.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'One sentence under the H1 saying what this guide covers.',
  'hero_alt'     => 'What the main photo shows',
  'published'    => '2026-10-03',          // YYYY-MM-DD, never change after launch
  'updated'      => '2026-10-03',          // change every time you edit the page
  'quick_answer' => 'Two or three sentences that answer the main question, with numbers where they help.',
  'faq' => [
    'Question people ask?' => 'Short, direct answer.',
  ],
  'related' => [                           // two or three sibling pillar guides that are truly related
    ['/wardrobe/', 'Wardrobe design guide', 'Types, sizes and cost', 'Pillar guide'],
    ['/cost/', 'Interior design cost guide', 'Home and room-wise budgets', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Intro paragraph: what the reader will be able to decide after reading.</p>

<h2>First decision</h2>
<p>Explain it, then link to the detailed page: <a href="/modular-kitchen/l-shape-vs-u-shape/">L-shape vs U-shape kitchens</a>.
   A link to a page that is not uploaded yet shows as plain text until it is — write every link once and forget it.</p>

<h2>Second decision</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Option</th><th>Works best in</th><th class="num">Cost</th></tr></thead>
  <tbody><tr><td>Name</td><td>Where</td><td class="num">₹0–0</td></tr></tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, month and year. Say whether GST is included.</p>

<div class="callout callout--warn"><span class="callout__title">Ask in writing</span>A caution worth a box.</div>

<h2>How it is done</h2>
<ol class="steps">
  <li><strong>Step name</strong>What happens in this step.</li>
  <li><strong>Step name</strong>What happens in this step.</li>
</ol>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
