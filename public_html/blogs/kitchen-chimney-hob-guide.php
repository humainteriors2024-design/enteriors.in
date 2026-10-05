<?php
/* BLOG POST — /blogs/kitchen-chimney-hob-guide/
   Title, description, category, date and image folder: includes/posts-data.php
   Images: /assets/blogs/kitchen-chimney-hob-guide/   (hero.jpg = main image)
   Prices match includes/calc/rates.php → kitchen 'chimney' and 'hob'. */
$post = [
  'quick_answer' => 'For Indian cooking, choose a ducted chimney with suction of 1,000–1,400 m³/h, baffle or filterless design and auto-clean, mounted 26–30 inches above the hob, with a short duct (under about 12 ft, two bends at most) to the outside. Choose the hob by how you cook: a glass-top hob (about ₹9,000) for most homes, a built-in hob (about ₹18,000) for a flush look. Basic chimneys cost about ₹12,000, auto-clean about ₹22,000 and premium about ₹40,000.',
  'takeaways' => [
    'Suction 1,000–1,400 m³/h for daily tadka and frying.',
    'Ducted, not recirculating; short duct, few bends.',
    'Chimney width at least the hob width; 26–30 inches above it.',
    'Plan the chimney socket and duct hole before tiling.',
  ],
  'faq' => [
    'What suction power do I need for an Indian kitchen?' => 'About 1,000–1,400 m³/h for a typical 80–120 sq ft kitchen with daily Indian cooking. Larger or open kitchens need more.',
    'Baffle filter or filterless chimney?' => 'Both work. Baffle filters are steel and washable; filterless (thermal auto-clean) chimneys collect oil in a removable cup and need less cleaning. Avoid mesh filters for heavy cooking.',
    'Glass-top or steel hob?' => 'Toughened glass hobs look clean and wipe easily; steel tops are tougher against heavy vessels. Built-in hobs sit flush with the counter and need a precise cut-out.',
    'How high should a chimney be above the hob?' => 'About 26–30 inches (65–75 cm), or the height the maker specifies. Lower is more effective but uncomfortable; higher loses suction.',
  ],
  'related' => [
    ['/modular-kitchen/', 'Modular kitchen design guide', 'Layouts, materials, storage and cost', 'Pillar guide'],
    ['/modular-kitchen/hardware-guide/', 'Kitchen hardware guide', 'Hinges, channels and lifts', 'Kitchen'],
    ['/planning/electrical-points/', 'Electrical points', 'Sockets for every appliance', 'Planning'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-start.php';
?>
<p>Indian cooking produces more smoke, oil and heat than most kitchens abroad are designed for. The chimney and hob decide whether that stays in the kitchen or settles on your shutters and living room curtains. This guide covers what to choose and where to place it. It is part of our <a href="/modular-kitchen/">modular kitchen design guide</a>.</p>

<h2>Chimney: what to look for</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Feature</th><th>Choose</th><th>Why</th></tr></thead>
  <tbody>
    <tr><td>Type</td><td>Ducted (vented outside)</td><td>Recirculating chimneys only filter; they do not remove heat and steam</td></tr>
    <tr><td>Suction</td><td>1,000–1,400 m³/h</td><td>Enough for daily tadka and frying in an average kitchen</td></tr>
    <tr><td>Filter</td><td>Baffle or filterless</td><td>Handle heavy oil; washable or auto-clean</td></tr>
    <tr><td>Width</td><td>60 cm for 2–3 burners; 90 cm for 4–5</td><td>At least as wide as the hob</td></tr>
    <tr><td>Height above hob</td><td>26–30 inches</td><td>Effective and comfortable</td></tr>
    <tr><td>Noise</td><td>Check dB at the setting you will use</td><td>A loud chimney gets switched off</td></tr>
  </tbody>
</table>
</div>
<?= img('kitchen-chimney-above-glass-hob', caption: 'A 90 cm wall-mounted chimney 28 inches above a four-burner glass hob, ducted outside') ?>

<h2>Ducting</h2>
<ul>
  <li>Keep the duct short: under about 12 ft, with two bends at most.</li>
  <li>Use a rigid or semi-rigid duct of the size the maker specifies, usually 6 inches.</li>
  <li>Cut the wall opening and fix the outside cowl before tiling.</li>
  <li>Box the duct into the loft for a clean look.</li>
</ul>

<h2>Hob: glass, steel or built-in</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Type</th><th>Good for</th><th class="num">Indicative price</th></tr></thead>
  <tbody>
    <tr><td>Glass-top hob (on the counter)</td><td>Most homes; easy to clean</td><td class="num">about ₹9,000</td></tr>
    <tr><td>Steel cooktop</td><td>Heavy vessels; budget kitchens</td><td class="num">₹4,000–8,000</td></tr>
    <tr><td>Built-in hob (flush)</td><td>Clean modular look</td><td class="num">about ₹18,000</td></tr>
    <tr><td>Induction</td><td>Flats on induction-friendly circuits; safety</td><td class="num">₹4,000–40,000</td></tr>
  </tbody>
</table>
</div>
<p>Look for brass burners, flame-failure safety devices and a mix of burner sizes: one big for kadai and pressure cooker, one small for simmering.</p>

<h2>Chimney prices</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Range</th><th class="num">Indicative price</th></tr></thead>
  <tbody>
    <tr><td>Basic (baffle, manual clean)</td><td class="num">about ₹12,000</td></tr>
    <tr><td>Auto-clean</td><td class="num">about ₹22,000</td></tr>
    <tr><td>Premium (high suction, quiet, sensors)</td><td class="num">about ₹40,000</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026. Installation and ducting extra.</p>

<h2>Plan before the kitchen is built</h2>
<ol>
  <li>Fix the hob position; it decides the gas or power point and the duct route.</li>
  <li>Add a dedicated socket for the chimney, high and hidden in the loft.</li>
  <li>Keep the hob away from windows where wind blows out flames.</li>
  <li>Allow 2 ft of counter on each side of the hob.</li>
</ol>
<p>Other kitchen sockets are listed in <a href="/planning/electrical-points/">electrical points</a>, and appliance costs in <a href="/cost/modular-kitchen-cost/">modular kitchen cost</a>.</p>
<?php /* INTERLINK: local guides + execution partner (scratchpad edits2.py) */ ?>
<p>Planning the chimney duct in a new flat? The <a href="/modular-kitchen/electronic-city-chandapura/">modular kitchen guide for Electronic City and Chandapura</a> covers where the duct usually runs in local apartment kitchens, and <a href="/blogs/modular-kitchen-cost-electronic-city/">modular kitchen cost in Electronic City</a> shows what appliances add to the bill.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-end.php'; ?>
