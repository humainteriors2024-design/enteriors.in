<?php
/* CALCULATORS HUB — /calculators/
   The list comes from includes/nav.php → 'calculators'. A calculator appears here as soon as its page is uploaded. */
$TOOLS = [   // url => [title, what it does, icon, what you need to hand]
  '/calculators/home-interior-quote/' => ['Room-by-Room Quote Builder', 'Tick modules room by room, set sizes, grade and fittings, and get an itemised quote with GST. Print or save it as PDF.', '📋', 'Rough wall sizes'],
  '/calculators/interior-cost/'     => ['Interior Cost Calculator', 'A whole-home estimate from your carpet area, material grade, scope and city, with a room-wise split.', '₹', 'Carpet area'],
  '/calculators/modular-kitchen/'   => ['Modular Kitchen Calculator', 'Price a kitchen by running foot: layout, board, finish, hardware, countertop and accessories.', '🍳', 'Wall lengths'],
  '/calculators/wardrobe-cost/'     => ['Wardrobe Cost Calculator', 'Width, height, door type and finish give the price of one wardrobe, with accessories.', '🚪', 'Wall width and height'],
  '/calculators/budget-planner/'    => ['Budget Planner', 'Split one budget across rooms and decide what to do now and what can wait.', '📋', 'Your total budget'],
  '/calculators/material-selector/' => ['Material Selector', 'Pick boards and finishes room by room, by water exposure, budget and look.', '🪵', 'Room list'],
];
$page = [
  'type'        => 'page',
  'schema_type' => 'CollectionPage',
  'title'       => 'Interior Calculators',
  'seo_title'   => 'Free Interior Design Calculators',
  'crumb'       => 'Calculators',
  'description' => 'Free interior calculators for Indian homes: itemised room-by-room quote, whole-home cost, modular kitchen and wardrobe pricing, with GST. No signup.',
  'updated'     => '2026-10-14',
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
    <h2>Which calculator should I use?</h2>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Your question</th><th>Use</th><th>You need</th></tr></thead>
      <tbody>
        <tr><td>Roughly what will my whole home cost?</td><td><a href="/calculators/interior-cost/">Interior cost per sq ft calculator</a></td><td>Carpet area</td></tr>
        <tr><td>What exactly should each room cost, item by item?</td><td><a href="/calculators/home-interior-quote/">Room-by-room quote builder</a></td><td>Rough wall sizes</td></tr>
        <tr><td>Is my kitchen quote fair?</td><td><a href="/calculators/modular-kitchen/">Modular kitchen calculator</a></td><td>Counter lengths in feet</td></tr>
        <tr><td>What should one wardrobe cost?</td><td><a href="/calculators/wardrobe-cost/">Wardrobe cost calculator</a></td><td>Wall width and height</td></tr>
      </tbody>
    </table>
    </div>

    <h2>Before you start</h2>
    <ul>
      <li><strong>Carpet area</strong> is the usable floor inside your walls. It is usually 70–78% of the super built-up area on the sale agreement.</li>
      <li><strong>Measure in feet.</strong> A tape measure and a phone photo of each wall are enough for a first estimate.</li>
      <li><strong>Pick your city.</strong> Rates are set for Bengaluru and adjusted for other cities, as labour and overheads differ.</li>
    </ul>

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
