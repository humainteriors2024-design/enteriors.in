<?php
/* CONTACT — NAP, hours and the lead form, all from includes/config.php. Schema: ContactPage + Organization. */
$page = [
  'type'        => 'page',
  'title'       => 'Contact Enteriors',
  'crumb'       => 'Contact',
  'description' => 'Talk to Enteriors about your home interiors in Bangalore and Hosur. Book a free consultation, call, WhatsApp or email us, and get up to three designer quotes.',
  'updated'     => '2026-10-14',
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

<section class="section section--tight">
  <div class="container container--text prose">
    <h2>What happens after you send the form</h2>
    <ol class="steps">
      <li><strong>Confirm your email</strong>We email you a 6-digit code and a one-click link. Use either one; it takes a few seconds and keeps fake enquiries out.</li>
      <li><strong>We get in touch</strong><?= e(LEADS['promise']) ?> We call you on the number you give.</li>
      <li><strong>A free consultation</strong>We talk through your rooms, budget, style and move-in date, and what is realistic for that budget.</li>
      <li><strong>Quotes, if you want them</strong>With your agreement, up to three verified designers quote the same scope, so you can compare them line by line.</li>
    </ol>

    <h2>Useful to have ready</h2>
    <ul>
      <li>The floor plan, or the builder's brochure with room sizes</li>
      <li>A few photos or a short video of each room</li>
      <li>A rough budget and the date you want to move in</li>
      <li>Your must-haves, such as a pooja unit, a study corner or extra storage</li>
    </ul>
    <p>Want a number first? Try the <a href="/calculators/interior-cost/">interior cost per sq ft calculator</a> or build an itemised list in the <a href="/calculators/home-interior-quote/">room-by-room quote builder</a>. How we use your details is explained in our <a href="/privacy/">privacy policy</a>.</p>
  </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
