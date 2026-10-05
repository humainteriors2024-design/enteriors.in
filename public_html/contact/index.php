<?php
/* CONTACT — NAP, hours and the lead form, all from includes/config.php. Schema: ContactPage + Organization. */
$page = [
  'type'        => 'page',
  'title'       => 'Contact Enteriors',
  'crumb'       => 'Contact',
  'description' => 'Talk to Enteriors about your home interiors in Bangalore and Hosur. Book a free consultation, call, WhatsApp or email us, and get up to three designer quotes.',
  'updated'     => '2026-09-29',
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">Contact</span>
    <h1>Talk to us about your home</h1>
    <p class="subheading">Free consultation, honest material advice and up to three quotes from verified designers.</p>
  </div>
</header>

<section class="section section--tight">
  <div class="container grid">
    <div class="card card--boxed">
      <span class="card__label">Reach us</span>
      <?= component('nap') ?>
    </div>
    <div class="card card--boxed">
      <span class="card__label">Areas we cover</span>
      <p class="card__text"><?= e(implode(' · ', NAP['area_served'])) ?></p>
      <p class="card__text"><?= e(LEADS['promise']) ?></p>
    </div>
  </div>
</section>

<?= component('lead-form', ['variant' => 'full', 'heading' => 'Book your <em>free consultation</em>']) ?>

<?php /* INTERLINK: local guides + execution partner (scratchpad edits.py) */ ?>
<section class="section section--tight">
  <div class="container container--text prose">
    <p>Live near Electronic City, Chandapura or Bommasandra? Site visits, design and installation in South-East Bengaluru are handled by <a href="<?= e(PARTNER['page']) ?>">Huma Interiors, our execution partner</a>. You can also reach them directly at <?= huma('home', 'humainteriors.com', follow: false) ?>.</p>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
