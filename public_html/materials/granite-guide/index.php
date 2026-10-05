<?php
/* CLUSTER PAGE — Granite guide (/materials/granite-guide/)
   Prices match /flooring/ and includes/calc/rates.php → kitchen 'counter'. */
$page = [
  'type'         => 'article',
  'title'        => 'Granite Guide: Colours, Finishes, Grades and Price for Floors and Counters',
  'seo_title'    => 'Granite Guide: Colours, Finishes and Price',
  'crumb'        => 'Granite Guide',
  'description'  => 'Granite for Indian homes: Black Galaxy, Absolute Black and Tan Brown, polished vs leathered finishes, sealing, and 2026 prices for counters and floors.',
  'eyebrow'      => 'Surfaces & stone',
  'lede'         => 'India is one of the world\'s largest granite producers, and granite remains the most practical stone for kitchens, stairs and busy floors. Here is how to choose it.',
  'hero_alt'     => 'Granite slabs in Black Galaxy, Tan Brown and Steel Grey at a stone yard',
  'published'    => '2026-10-05',
  'updated'      => '2026-10-05',
  'quick_answer' => 'Granite is a hard, heat-proof natural stone that suits kitchen counters, stairs and high-traffic floors. Dark colours such as Black Galaxy, Absolute Black and Tan Brown hide stains best. Polished granite needs sealing once a year; leathered and flamed finishes are less slippery. Fixed granite costs about ₹280 per sq ft for counters and ₹150–350 per sq ft laid for floors in Bengaluru in 2026.',
  'takeaways'    => [
    'Hard, heat-proof and inexpensive: the default kitchen counter in India.',
    'Dark, speckled granites hide oil and turmeric; light granites stain without sealing.',
    'Polished for counters; leathered, honed or flamed for floors, stairs and outdoors.',
    'Seal on installation and yearly; wipe acids (lemon, tamarind) promptly.',
  ],
  'faq' => [
    'Which granite colour is best for a kitchen?' => 'Dark, busy patterns such as Black Galaxy, Absolute Black, Jet Black, Tan Brown and Steel Grey hide oil, turmeric and hard-water marks best. Light granites look fresh but need diligent sealing.',
    'What is the price of granite per sq ft?' => 'For kitchen counters, about ₹280 per sq ft fixed for common Indian granites in Bengaluru in 2026, more for rare colours and special edges. For floors, about ₹150–350 per sq ft laid and polished.',
    'Does granite need sealing?' => 'Yes, most granite benefits from a penetrating sealer when installed and about once a year after, especially lighter colours and areas around the sink.',
    'Is granite good for flooring?' => 'Very good for stairs, entrances, balconies and high-traffic areas because it is hard and dense. Polished granite floors can be slippery when wet; choose leathered or honed finishes where water is likely.',
  ],
  'related' => [
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
    ['/compare/quartz-vs-granite/', 'Quartz vs granite', 'Which countertop suits daily Indian cooking?', 'Compare'],
    ['/modular-kitchen/countertop-guide/', 'Kitchen countertop guide', 'Every countertop material compared', 'Kitchen'],
  ],
  'sources' => [
    ['Bureau of Indian Standards: IS 14223 (polished building stones)', 'https://www.bis.gov.in/', 'granite slab properties and tests'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Granite is an igneous stone formed from slowly cooled magma, made mostly of quartz and feldspar. Its hardness and resistance to heat make it the most practical natural stone for Indian kitchens, and Karnataka, Andhra Pradesh, Telangana, Tamil Nadu and Rajasthan quarry much of what is used across the country. This guide covers colours, finishes and prices. It is part of our <a href="/materials/">interior materials guide</a>.</p>

<h2>Popular colours</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Granite</th><th>Look</th><th>Best for</th></tr></thead>
  <tbody>
    <tr><td>Black Galaxy</td><td>Black with golden flecks</td><td>Kitchen counters; hides everything</td></tr>
    <tr><td>Absolute Black / Jet Black</td><td>Uniform deep black</td><td>Modern kitchens; shows dust and smudges a little</td></tr>
    <tr><td>Tan Brown</td><td>Dark brown with black and red specks</td><td>Warm wood kitchens</td></tr>
    <tr><td>Steel Grey</td><td>Grey-black speckle</td><td>Counters and floors</td></tr>
    <tr><td>Telephone Black</td><td>Dark greenish black</td><td>Counters, stairs</td></tr>
    <tr><td>Sadarahalli / grey granites</td><td>Light grey speckle</td><td>Floors, stairs, outdoor paving</td></tr>
    <tr><td>Kashmir White, light granites</td><td>White-grey with dark specks</td><td>Light kitchens; must be sealed</td></tr>
  </tbody>
</table>
</div>
<?= img('granite-colour-samples-for-kitchen', caption: 'Popular kitchen granites: Black Galaxy, Absolute Black, Tan Brown and Steel Grey') ?>

<h2>Finishes</h2>
<ul>
  <li><strong>Polished:</strong> glossy and the easiest to wipe; best for counters.</li>
  <li><strong>Honed:</strong> matte, less slippery; shows stains more without sealing.</li>
  <li><strong>Leathered:</strong> soft texture that hides fingerprints and water marks; good for counters and floors.</li>
  <li><strong>Flamed:</strong> rough, anti-skid; for outdoor steps and balconies.</li>
</ul>

<h2>Thickness and edges</h2>
<p>Counters use 18–20 mm slabs with the front edge built up to about 40 mm; floors use 15–20 mm tiles or slabs. Common edge profiles are straight, bullnose and bevelled; a drip groove under the counter's front edge stops water running onto shutters.</p>

<h2>Prices</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Use</th><th class="num">Indicative price</th></tr></thead>
  <tbody>
    <tr><td>Kitchen counter, common Indian granite, fixed</td><td class="num">about ₹280 per sq ft</td></tr>
    <tr><td>Kitchen counter, premium colours</td><td class="num">₹350–600 per sq ft</td></tr>
    <tr><td>Flooring, laid and polished</td><td class="num">₹150–350 per sq ft</td></tr>
    <tr><td>Staircase, tread and riser</td><td class="num">₹1,200–2,500 per step</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026, before GST.</p>

<h2>Buying and care</h2>
<ol>
  <li>Choose the actual slab at the yard; colour varies from block to block.</li>
  <li>Check for cracks, resin-filled fissures and colour patches in daylight.</li>
  <li>Ask for the same lot for the whole kitchen.</li>
  <li>Seal on installation; reseal yearly with a penetrating sealer.</li>
  <li>Clean with mild soap; wipe lemon, tamarind and vinegar promptly.</li>
</ol>
<p>Granite or quartz? See <a href="/compare/quartz-vs-granite/">quartz vs granite</a>. For floors, see the <a href="/flooring/">flooring guide</a>.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
