<?php
/* ABOUT — who writes Enteriors and how the guides are made (trust / E-E-A-T).
   TODO: replace the text below with your own story. Keep every statement true and checkable:
   only claim years, project counts, awards or policies that you can show. */
$page = [
  'type'        => 'page',
  'title'       => 'About Enteriors',
  'crumb'       => 'About',
  'description' => 'Who writes Enteriors, how our interior guides and price ranges are put together, how often they are updated and how to reach us in Bangalore and Hosur.',
  'updated'     => '2026-10-03',
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
$a = AUTHORS[DEFAULT_AUTHOR];
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">About</span>
    <h1>Plain guidance for home interiors</h1>
    <p class="subheading"><?= e(SITE['description']) ?></p>
  </div>
</header>
<section class="section section--tight">
  <div class="container container--text prose">
    <!-- TODO: replace with your own words -->
    <h2>What Enteriors is</h2>
    <p>Enteriors is a knowledge site for people doing up a home in India. It explains materials, layouts and costs in plain language so that you can brief a designer, read a quotation and check the work with confidence. The <a href="/calculators/">calculators</a> are free and need no signup.</p>
    <h2>Who writes it</h2>
    <p>Every guide is researched and written by the <?= e($a['name']) ?> team: <?= e(lcfirst($a['role'])) ?>. <?= e($a['bio']) ?></p>
    <h2>How the guides are made</h2>
    <ul>
      <li><strong>Prices are indicative ranges</strong> for Bengaluru, shown with the month they were last reviewed. They are meant for planning. A quotation after site measurement can differ by 10–15% either way.</li>
      <li><strong>Every page shows its last-updated date.</strong> When rates or advice change, the page and the date change with them.</li>
      <li><strong>No invented reviews or figures.</strong> Customer reviews and company facts appear only when they are real and can be checked.</li>
      <li><strong>Vastu pages describe tradition.</strong> They are written as customary guidance, not as technical or scientific advice.</li>
    </ul>
    <h2>How we can help</h2>
    <p>If you would like help with your own home, we offer consultations in Bengaluru and Hosur. <?= e(LEADS['promise']) ?></p>
    <?= component('cta', ['variant' => 'buttons']) ?>
  </div>
  <div class="container container--text mt-8"><?= component('nap') ?></div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
