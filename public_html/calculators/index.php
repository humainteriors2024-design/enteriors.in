<?php
/* CALCULATORS HUB — /calculators/
   The list comes from includes/nav.php → 'calculators'. A calculator appears here as soon as its page is uploaded. */
$TOOLS = [   // url => [title, what it does, icon, what you need to hand]
  '/calculators/home-interior-quote/' => ['Room-by-Room Quote Builder', 'Tick modules room by room, set sizes, grade and fittings, and get an itemised quote with GST. Print or save it as PDF.', '📋', 'Rough wall sizes'],
  '/calculators/interior-cost/'     => ['Interior Cost Calculator', 'A whole-home estimate from your carpet area, material grade, scope and city, with a room-wise split.', '₹', 'Carpet area'],
  '/calculators/modular-kitchen/'   => ['Modular Kitchen Calculator', 'Price a kitchen by running foot: layout, board, finish, hardware, countertop and accessories.', '🍳', 'Wall lengths'],
  '/calculators/wardrobe-cost/'     => ['Wardrobe Cost Calculator', 'Width, height, door type and finish give the price of one wardrobe, with accessories.', '🚪', 'Wall width and height'],
  '/calculators/material-selector/' => ['Material Selector', 'Pick boards and finishes room by room, by water exposure, budget and look.', '🪵', 'Room list'],
];
$page = [
  'type'        => 'page',
  'schema_type' => 'CollectionPage',
  'title'       => 'Interior Calculators',
  'seo_title'   => 'Free Interior Design Calculators',
  'crumb'       => 'Calculators',
  'description' => 'Free interior calculators for Indian homes: itemised room-by-room quote, whole-home cost, modular kitchen and wardrobe pricing, with GST. No signup.',
  'updated'     => '2026-10-04',
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">Free tools</span>
    <h1>Interior calculators</h1>
    <p class="subheading">Work out a realistic number before you speak to a designer. No signup, and nothing is sent anywhere until you ask for a quote.</p>
  </div>
</header>

<section class="section section--tight">
  <div class="container">
    <div class="grid grid--lg">
<?php foreach ($TOOLS as $url => [$title, $text, $icon, $need]) echo card($url, $title, $text, icon: $icon, variant: 'boxed', meta: 'You need: ' . $need, always: is_staging()); ?>
    </div>
  </div>
</section>

<section class="section section--grey section--tight">
  <div class="container container--text prose">
    <h2>How to use the estimates</h2>
    <p>Each calculator uses indicative Bengaluru rates and adjusts them for your city. Every estimate is worked out on our server from one rate sheet, so all the calculators and cost guides agree with each other. Treat the result as a planning figure: it tells you whether a budget is realistic and which choices move it most. A quotation after site measurement can differ by 10–15% either way.</p>
    <ul>
      <li><strong>Start with the whole home</strong> to set the total, then price the kitchen and wardrobes in detail.</li>
      <li><strong>Change one thing at a time</strong>, such as the finish or the hardware, to see what it costs.</li>
      <li><strong>Take the summary to your designer.</strong> If you request a quote from a calculator page, your estimate is attached to the enquiry.</li>
    </ul>
    <p>The rates behind the tools are explained in the <a href="/cost/">interior design cost guide</a>.</p>
  </div>
</section>

<?= component('lead-form', ['variant' => 'full', 'id' => 'get-quote', 'eyebrow' => 'Exact quote', 'heading' => 'Want a quote for <em>your home?</em>']) ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
