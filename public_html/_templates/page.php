<?php
/* PLAIN PAGE TEMPLATE — about, contact-style pages, policies.
   Header, footer, CSS, SEO tags, schema and breadcrumbs are added for you. */
$page = [
  'type'        => 'page',
  'title'       => 'Page title',
  'description' => '140–160 characters describing the page for Google.',
  'updated'     => '2026-10-01',
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">Eyebrow</span>
    <h1>Main heading</h1>
    <p class="subheading">Sub-heading: one or two sentences.</p>
  </div>
</header>

<section class="section">
  <div class="container container--text prose">
    <h2>Section heading</h2>
    <p>Text…</p>
  </div>
</section>

<?php // Optional shared blocks — pick any: ?>
<?= component('lead-form', ['variant' => 'full']) ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
