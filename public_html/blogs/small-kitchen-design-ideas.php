<?php
/* BLOG POST — /blogs/small-kitchen-design-ideas/
   Title, description, category, date and image folder: includes/posts-data.php
   Images: /assets/blogs/small-kitchen-design-ideas/   (hero.jpg = main image) */
$post = [
  'quick_answer' => 'In a small kitchen of 6×8 ft or less, use a straight or compact L-shape layout, take storage to the ceiling with lofts, use drawers rather than shelves, choose compact or built-in appliances, keep colours light on the upper half, and light the counter with under-cabinet LEDs. A compact kitchen costs about ₹0.9–1.8 lakh including GST.',
  'takeaways' => [
    'Layout: straight or compact L; skip U-shapes and islands.',
    'Go vertical: lofts and a slim tall unit.',
    'Drawers, a corner solution and wall rails beat deep shelves.',
    'Light uppers, mid-tone lowers, under-cabinet lights.',
  ],
  'faq' => [
    'What is the best layout for a small kitchen?' => 'A straight (one-wall) layout for kitchens under about 6 ft wide, and a compact L-shape for squarish kitchens of about 6×7 ft and more.',
    'How can I get more storage in a small kitchen?' => 'Take wall units and lofts to the ceiling, use drawers under the counter, add a slim tall pull-out, use the inside of shutters for racks, and hang rails for ladles and spices.',
    'Which colours make a small kitchen look bigger?' => 'Light, warm colours on the wall units (warm white, pearl greige, light maple) with a mid-tone on the base units, a light backsplash and matte or satin finishes.',
  ],
  'related' => [
    ['/modular-kitchen/', 'Modular kitchen design guide', 'Layouts, materials, storage and cost', 'Pillar guide'],
    ['/modular-kitchen/storage-solutions/', 'Kitchen storage solutions', 'Units and accessories', 'Kitchen'],
    ['/cost/1-bhk-interior-cost/', '1 BHK interior cost', 'Budget for a compact home', 'Cost'],
  ],
  'partner'      => ['follow' => false],   // in-text partner links are followed; keep the box nofollow
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-start.php';
?>
<p>A small kitchen is not a problem to be solved with fewer things; it is a puzzle to be solved with better placement. These ideas come from the kitchens in 1 and 2 BHK flats, rental floors and studio apartments. For the full design process, see the <a href="/modular-kitchen/">modular kitchen design guide</a>.</p>

<h2>Layout</h2>
<ul>
  <li><strong>Straight (one wall):</strong> for kitchens under about 6 ft wide or open to the living room.</li>
  <li><strong>Compact L:</strong> for squarish kitchens from about 6×7 ft; one corner only.</li>
  <li><strong>Parallel:</strong> only if the kitchen is at least 7.5 ft wide. See <a href="/blogs/parallel-kitchen-designs/">parallel kitchens</a>.</li>
</ul>
<?= img('compact-straight-kitchen-with-lofts', caption: 'A compact straight kitchen: lofts to the ceiling, a slim tall unit and under-cabinet lights') ?>

<h2>Storage ideas</h2>
<ol>
  <li>Wall units and lofts to the ceiling.</li>
  <li>Drawers under the hob instead of shelves.</li>
  <li>A slim (6–9 inch) tall pull-out for oil bottles and spices.</li>
  <li>A corner carousel in an L-shape.</li>
  <li>Rails under the wall units for ladles, cups and a paper-towel roll.</li>
  <li>Racks on the inside of shutters for foil, wraps and lids.</li>
  <li>A toe-kick drawer for trays and chopping boards.</li>
</ol>

<h2>Appliances</h2>
<ul>
  <li>A two- or three-burner hob instead of four, if you cook simply.</li>
  <li>A slim (60 cm) chimney with ducting.</li>
  <li>A built-in microwave in the tall unit to free counter space.</li>
  <li>A single-bowl sink with a drainboard cover that doubles as counter.</li>
</ul>
<p>Choosing a chimney and hob is covered in the <a href="/blogs/kitchen-chimney-hob-guide/">chimney and hob guide</a>.</p>

<h2>Colour, light and finish</h2>
<ul>
  <li>Light, warm uppers and a mid-tone below.</li>
  <li>Matte or satin finishes; gloss only on a few uppers.</li>
  <li>Under-cabinet LEDs along the whole counter.</li>
  <li>A light backsplash in large tiles or one slab.</li>
</ul>

<h2>Cost</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Kitchen</th><th class="num">Essential</th><th class="num">Standard</th></tr></thead>
  <tbody>
    <tr><td>Straight, 8 ft base</td><td class="num">₹0.9–1.2 lakh</td><td class="num">₹1.3–1.8 lakh</td></tr>
    <tr><td>Compact L, 10 ft base</td><td class="num">₹1.1–1.5 lakh</td><td class="num">₹1.6–2.2 lakh</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026, including GST and a granite top; appliances extra.</p>
<p>See small kitchens built for flats around Electronic City and Chandapura at <?= huma('home', 'humainteriors.com') ?>, or price yours in the <a href="/calculators/modular-kitchen/">kitchen calculator</a>.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-end.php'; ?>
