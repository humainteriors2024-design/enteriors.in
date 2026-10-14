<?php
/* COMPARISONS HUB — /compare/
   Add a comparison to $COMPARE when its page is uploaded (pages not uploaded yet are hidden on the live site). */
$COMPARE = [   // url => [title, the question it settles, group, one-line verdict (from the page's own conclusion)]
  '/compare/acrylic-vs-laminate/'          => ['Acrylic vs Laminate', 'Gloss and depth against toughness and price, for kitchen and wardrobe shutters.', 'Finishes', 'Laminate where doors take daily wear; acrylic where a deep solid colour is seen more than touched.'],
  '/compare/veneer-vs-laminate/'           => ['Veneer vs Laminate', 'Real wood grain or a printed one, and what each needs in care.', 'Finishes', 'Laminate for kitchens, kids\' rooms and rentals; veneer for display units where real wood grain matters.'],
  '/compare/matte-vs-glossy-finish/'       => ['Matte vs Glossy Finish', 'Which hides fingerprints, which opens up a small kitchen.', 'Finishes', 'Matte for bedrooms, living rooms and ceilings; gloss where wipe-clean surfaces and light matter, as in kitchens.'],
  '/compare/mdf-vs-plywood/'               => ['MDF vs Plywood', 'Smooth and stable against strong and water-tolerant.', 'Boards', 'Plywood for the box and anything near water or carrying weight; MDF for painted shutters in dry rooms.'],
  '/compare/hdhmr-vs-plywood/'             => ['HDHMR vs Plywood', 'Where the engineered board can replace plywood, and where it cannot.', 'Boards', 'HDHMR for shutters and damp-prone fronts; plywood for carcasses, long shelves and heavy loads.'],
  '/compare/engineered-wood-vs-plywood/'   => ['Engineered Wood vs Plywood', 'MDF, HDHMR and particle board against plywood, room by room.', 'Boards', 'Mix them: a plywood box with MDF or HDHMR shutters, and no particle board near water.'],
  '/compare/bwp-vs-bwr-vs-mr-plywood/'     => ['BWP vs BWR vs MR Plywood', 'Three grades, and which cabinet needs which.', 'Boards', 'Match the grade to the room: BWP where water is a daily reality, BWR for general kitchen use, MR only in dry rooms.'],
  '/compare/calibrated-vs-normal-plywood/' => ['Calibrated vs Normal Plywood', 'Why exact thickness matters for factory-made furniture.', 'Boards', 'Calibrated for modular kitchens, sliding wardrobes and CNC-cut furniture; normal plywood suits simple site-made carpentry.'],
  '/compare/quartz-vs-granite/'            => ['Quartz vs Granite', 'Countertops compared for heat, stains, upkeep and price.', 'Surfaces', 'Quartz for low upkeep and an even look; granite for heavy heat and sunlit or outdoor counters.'],
  '/compare/modular-vs-carpenter-kitchen/' => ['Modular vs Carpenter-Made Kitchen', 'Factory finish against on-site flexibility.', 'Kitchens', 'Modular for a home you will live in for years; carpenter-made for very simple or oddly shaped kitchens and rentals, if you can check the work daily.'],
  '/compare/sliding-vs-hinged-wardrobe/'   => ['Sliding vs Hinged Wardrobe', 'The space each door needs, what it costs and how it ages.', 'Wardrobes', 'Sliding where there is no room for doors to swing; hinged for full access, kids\' rooms and a lower price.'],
];
$page = [
  'type'        => 'page',
  'schema_type' => 'CollectionPage',
  'title'       => 'Interior Material Comparisons',
  'seo_title'   => 'Interior Material Comparisons: Which to Choose',
  'crumb'       => 'Comparisons',
  'description' => 'Side-by-side comparisons of interior boards, finishes and countertops for Indian homes: durability, upkeep, look and price, each with a clear verdict.',
  'updated'     => '2026-10-14',
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
<?php foreach ($COMPARE as $url => [$title, $text, $group, $verdict]) echo card($url, $title, $text, label: $group, variant: 'boxed', always: is_staging()); ?>
    </div>
  </div>
</section>

<section class="section section--tight">
  <div class="container container--text prose">
    <h2>Quick verdicts</h2>
    <p>The short answer from each comparison. Open the full page for the reasons, the prices and the exceptions.</p>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Comparison</th><th>Short answer</th></tr></thead>
      <tbody>
<?php foreach ($COMPARE as $url => [$title, $text, $group, $verdict]) if (is_live($url) || is_staging()) echo '        <tr><td><a href="' . e($url) . '">' . e($title) . '</a></td><td>' . e($verdict) . "</td></tr>\n"; ?>
      </tbody>
    </table>
    </div>

    <h2>Which comparison do you need?</h2>
    <ul>
      <li><strong>Planning a kitchen:</strong> start with <a href="/compare/bwp-vs-bwr-vs-mr-plywood/">plywood grades</a>, then the <a href="/compare/acrylic-vs-laminate/">shutter finish</a> and the <a href="/compare/quartz-vs-granite/">countertop</a>. Still deciding who builds it? See <a href="/compare/modular-vs-carpenter-kitchen/">modular vs carpenter-made</a>.</li>
      <li><strong>Planning wardrobes:</strong> choose the <a href="/compare/sliding-vs-hinged-wardrobe/">door type</a> first, then the board (<a href="/compare/mdf-vs-plywood/">MDF vs plywood</a>) and the finish (<a href="/compare/veneer-vs-laminate/">veneer vs laminate</a>).</li>
      <li><strong>Reading a quotation:</strong> check which board is named for each unit with <a href="/compare/engineered-wood-vs-plywood/">engineered wood vs plywood</a> and <a href="/compare/hdhmr-vs-plywood/">HDHMR vs plywood</a>, and whether factory-made units use <a href="/compare/calibrated-vs-normal-plywood/">calibrated plywood</a>.</li>
      <li><strong>Choosing colours and sheen:</strong> <a href="/compare/matte-vs-glossy-finish/">matte vs glossy</a> covers walls, laminates and shutters.</li>
    </ul>
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
