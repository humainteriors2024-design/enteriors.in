<?php
/* COMPARISONS HUB — /compare/
   Add a comparison to $COMPARE when its page is uploaded (pages not uploaded yet are hidden on the live site). */
$COMPARE = [   // url => [title, the question it settles, group]
  '/compare/acrylic-vs-laminate/'          => ['Acrylic vs Laminate', 'Gloss and depth against toughness and price, for kitchen and wardrobe shutters.', 'Finishes'],
  '/compare/veneer-vs-laminate/'           => ['Veneer vs Laminate', 'Real wood grain or a printed one, and what each needs in care.', 'Finishes'],
  '/compare/matte-vs-glossy-finish/'       => ['Matte vs Glossy Finish', 'Which hides fingerprints, which opens up a small kitchen.', 'Finishes'],
  '/compare/mdf-vs-plywood/'               => ['MDF vs Plywood', 'Smooth and stable against strong and water-tolerant.', 'Boards'],
  '/compare/hdhmr-vs-plywood/'             => ['HDHMR vs Plywood', 'Where the engineered board can replace plywood, and where it cannot.', 'Boards'],
  '/compare/bwp-vs-bwr-vs-mr-plywood/'     => ['BWP vs BWR vs MR Plywood', 'Three grades, and which cabinet needs which.', 'Boards'],
  '/compare/quartz-vs-granite/'            => ['Quartz vs Granite', 'Countertops compared for heat, stains, upkeep and price.', 'Surfaces'],
  '/compare/modular-vs-carpenter-kitchen/' => ['Modular vs Carpenter-Made Kitchen', 'Factory finish against on-site flexibility.', 'Kitchens'],
];
$page = [
  'type'        => 'page',
  'schema_type' => 'CollectionPage',
  'title'       => 'Interior Material Comparisons',
  'seo_title'   => 'Interior Material Comparisons: Which to Choose',
  'crumb'       => 'Comparisons',
  'description' => 'Side-by-side comparisons of interior boards, finishes and countertops for Indian homes: durability, upkeep, look and price, each with a clear verdict.',
  'updated'     => '2026-10-03',
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">Compare</span>
    <h1>Material comparisons</h1>
    <p class="subheading">The choices homeowners go back and forth on, set side by side with a plain verdict at the end of each.</p>
  </div>
</header>

<section class="section section--tight">
  <div class="container">
    <div class="grid grid--lg">
<?php foreach ($COMPARE as $url => [$title, $text, $group]) echo card($url, $title, $text, label: $group, variant: 'boxed', always: is_staging()); ?>
    </div>
  </div>
</section>

<section class="section section--grey section--tight">
  <div class="container container--text prose">
    <h2>How we compare</h2>
    <p>Every comparison looks at the same things: how each option stands up to water, heat and daily handling, what it needs in cleaning and repair, how it looks, and what it costs in Bengaluru. Each page ends with a verdict that says when to choose one and when the other.</p>
    <p>For the full picture of boards, finishes and stone, start with the <a href="/materials/">interior design materials guide</a>. Trade terms are explained in the <a href="/glossary/">materials glossary</a>.</p>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
