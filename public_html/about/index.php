<?php
/* ABOUT — who writes Enteriors and how the guides are made (trust / E-E-A-T).
   TODO: replace the text below with your own story. Keep every statement true and checkable:
   only claim years, project counts, awards or policies that you can show. */
$page = [
  'type'        => 'page',
  'title'       => 'About Enteriors',
  'crumb'       => 'About',
  'description' => 'Who writes Enteriors, how our interior guides and price ranges are put together, how often they are updated and how to reach us in Bangalore and Hosur.',
  'updated'     => '2026-10-14',
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
    <h2>What you will find here</h2>
    <ul>
      <li><strong>Costs:</strong> what interiors cost by home size, room and grade, in the <a href="/cost/">interior design cost guide</a>.</li>
      <li><strong>Materials and comparisons:</strong> plywood grades, boards, finishes and stone in the <a href="/materials/">materials guide</a>, with side-by-side <a href="/compare/">comparisons</a> and a <a href="/glossary/">glossary</a> of trade terms.</li>
      <li><strong>Rooms:</strong> the <a href="/modular-kitchen/">modular kitchen</a> and <a href="/wardrobe/">wardrobe</a> guides, and <a href="/rooms/">room-by-room ideas</a>.</li>
      <li><strong>Style and tradition:</strong> <a href="/styles/">interior styles</a> and <a href="/vastu/">vastu for the home</a>.</li>
      <li><strong>Planning:</strong> checklists, timelines and the mistakes to avoid, in the <a href="/planning/">planning guide</a>.</li>
      <li><strong>Finding a designer:</strong> <a href="/interior-designer-near-me/">interior designers by city</a>, with addresses and the work each firm takes on.</li>
    </ul>
    <h2>How firms are listed</h2>
    <p>Our city pages name interior firms that have a studio or office with a published address, and their own website showing finished work.</p>
    <ul>
      <li>Firms are listed in alphabetical order. The order is not a ranking.</li>
      <li>No firm pays to appear, and links to firms are marked nofollow.</li>
      <li>We do not quote prices for the firms we name. Ask each one for an itemised quotation instead.</li>
      <li>Details come from each firm's own published information, so confirm the address and scope with the firm before you visit or sign.</li>
    </ul>
    <h2>Your details</h2>
    <p>When you send an enquiry, we first confirm your email address, then our team contacts you. If you ask for quotations, we share your enquiry with up to three designers, and only for that purpose. We do not sell personal details. The full policy is on the <a href="/privacy/">privacy page</a>.</p>
    <h2>Spotted a mistake?</h2>
    <p>Prices, rules and products change. If something on a page is out of date or wrong, email <a href="mailto:<?= e(NAP['email']) ?>"><?= e(NAP['email']) ?></a> with the page address, and we will check it.</p>
    <h2>How we can help</h2>
    <p>If you would like help with your own home, we offer consultations in Bengaluru and Hosur. <?= e(LEADS['promise']) ?></p>
    <?= component('cta', ['variant' => 'buttons']) ?>
    <?= component('partner') ?>
  </div>
  <div class="container container--text mt-8"><?= component('nap') ?></div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
