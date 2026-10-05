<?php
/* BLOG POST — /blogs/kitchen-colour-combinations/
   Title, description, category, date and image folder: includes/posts-data.php
   Images: /assets/blogs/kitchen-colour-combinations/   (hero.jpg = main image)
   Palettes: edit $COMBOS. Each: [name, hex, light?] x2, tag, text, works[], watch[], size, light, style.
   The picture for each palette is the file "<first>-and-<second>-two-colour-kitchen" in the image folder. */
$COMBOS = [
  [['Warm white', '#F4EFE6', 1], ['Walnut wood', '#5B3A24', 0], 'Timeless', 'Warm white uppers over walnut-grain lowers. It feels finished without trying, works with almost any countertop and resells easily.',
    ['Hides everyday marks on the lower run', 'Pairs with granite, quartz or wood-look tops', 'Unlikely to date'], ['A white with a yellow undertone can look tired', 'Wood-grain quality varies a lot; see it in person', 'Can feel safe if you want a statement'], 'Any', 'Low to medium', 'Classic, transitional'],
  [['Chalk white', '#FAFAF8', 1], ['Graphite grey', '#3B3C3F', 0], 'Clean modern', 'The default modern kitchen for a reason: bright uppers keep the room open, and dark grey lowers take the scuffs.',
    ['Works with stainless steel and white quartz', 'Looks sharp in photos', 'Easy to refresh with new handles'], ['Pure white shows turmeric quickly', 'Needs wood or brass to avoid feeling cold', 'Very common'], 'Medium to large', 'Any', 'Modern, minimal'],
  [['Ivory', '#F2ECE0', 1], ['Sage green', '#9DAF90', 1], 'Soft colour', 'For anyone tired of white and grey but not ready for strong colour. Calm, distinctive, and friendly with brass.',
    ['Restful, low-contrast palette', 'Lovely with brushed brass handles', 'Looks designed rather than standard'], ['Sage shifts a lot under different bulbs', 'Test the actual sheet in your kitchen', 'Narrows your later accent choices'], 'Small to medium', 'Medium to high', 'Contemporary, soft'],
  [['Soft white', '#F7F7F4', 1], ['Ink navy', '#1F2B45', 0], 'Confident classic', 'Navy lowers and soft white uppers, finished with brushed brass. Looks tailored and hides water marks well.',
    ['Dramatic but not loud', 'Handles scuffs and splashes', 'Pairs with warm wood floors'], ['Needs good daylight or warm lighting', 'Can feel cold in north-facing rooms', 'More trend-led than neutrals'], 'Medium to large', 'High', 'Bold modern'],
  [['Charcoal black', '#161616', 0], ['Natural oak', '#A07B55', 0], 'Editorial', 'Black tall units or uppers with oak-grain lower cabinets. The wood takes the edge off the black.',
    ['Reads premium and restaurant-like', 'Hides steam and splash marks', 'Ages slowly'], ['Needs a bright kitchen, without exception', 'Cheap black laminate looks plasticky', 'Small kitchens will feel closed in'], 'Large only', 'High', 'Editorial, hospitality'],
  [['Sand', '#EFE4D2', 1], ['Terracotta', '#A9573A', 0], 'Warm Indian', 'An earthy pair that sits naturally with brass, copper, cane and Indian textiles. Terracotta hides spice stains well.',
    ['Very forgiving of haldi and oil', 'Friendly with traditional dining rooms', 'Warm under evening light'], ['Too orange a shade looks dated', 'Choose a muted, brown-based terracotta', 'Narrower resale appeal than neutrals'], 'Medium', 'Medium', 'Warm modern, traditional'],
  [['Concrete grey', '#5A5A58', 0], ['Ochre', '#C7952E', 1], 'Personality', 'Use ochre in a small dose, such as one tall unit or the island, against a grey base. Warmth without the usual wood.',
    ['Memorable and photogenic', 'Ochre hides turmeric', 'Creative but grown-up'], ['Avoid bright lemon yellows', 'Limits other accent colours', 'Too much yellow looks like a café chain'], 'Medium to large', 'Medium to high', 'Contemporary, eclectic'],
  [['Linen beige', '#E7DFD1', 1], ['Forest green', '#35473A', 0], 'Earthy modern', 'A deeper, moodier relative of sage. Beautiful with terrazzo or warm-grey quartz and textured finishes.',
    ['Natural and calming', 'Hides moderate wear', 'Longer staying power than brighter greens'], ['Needs warm light, not cool white', 'Pick a yellow-beige, not a pink-beige', 'Looks flat in a smooth finish; choose texture'], 'Medium to large', 'Medium', 'Earthy, biophilic'],
  [['Pearl greige', '#ECE5DE', 1], ['Light maple', '#CDAE8C', 1], 'Compact friendly', 'Two light, warm tones that make a small 2 BHK kitchen feel bigger without the starkness of pure white.',
    ['Opens up small kitchens', 'Hides daily wear better than white', 'Broad resale appeal'], ['Needs good handles and lighting to come alive', 'Wood-grain quality matters here most', 'Can look plain if under-styled'], 'Small (best)', 'Low to medium', 'Modern, transitional'],
  [['Graphite', '#2A2A2B', 0], ['Signal red', '#B3122E', 0], 'Statement', 'For a keen cook who wants the kitchen to be the heart of the home. Red on one island or tall unit only, graphite everywhere else.',
    ['High impact from a small red area', 'Hides cooking marks', 'Strong character'], ['Needs a large, bright kitchen', 'Red laminates vary widely; sample several', 'Harder to resell; choose it for living, not flipping'], 'Large', 'High', 'Bold modern'],
];

$post = [
  'quick_answer' => 'Put the darker laminate on the base cabinets and the lighter one on the wall units, in roughly a 60:40 or 70:30 split. For small or dim kitchens, choose two light warm tones such as greige and light maple; keep black, navy or red combinations for large, bright kitchens.',
  'faq' => [
    'Which two-colour combination suits a small Indian kitchen?' => 'Light, warm pairs such as pearl greige with light maple, or warm white with walnut. They keep the room open and hide wear better than pure white. Avoid dark combinations unless the kitchen gets strong daylight.',
    'Should the dark colour go on top or bottom?' => 'Bottom, in most kitchens. Lower cabinets take more splashes and knocks, and a darker base grounds the room while lighter uppers bounce light. Reverse it only in large, bright kitchens where you want drama.',
    'Are dark laminates harder to maintain?' => 'Dark matte laminates hide oil and small scratches well. They do show hard-water spots and dust more than mid-tones, so wipe them with a dry microfibre cloth.',
    'Can I use three colours?' => 'You can, but it usually looks busy. Most good three-colour kitchens are really two colours plus a small accent, such as a wood tall unit, a coloured island or a patterned backsplash.',
    'How long does a laminate kitchen last?' => 'A good 1 mm laminate on the right board, properly edge-banded, looks good for 10–12 years or more of daily use. Edges and joints near the sink usually show wear first.',
    'Should laminates match the countertop?' => 'They do not need to match, but their undertones should agree: warm laminates with warm stone, cool laminates with cool stone.',
  ],
  'related' => [   // one pillar + two cluster pages (posts do not link to other posts)
    ['/modular-kitchen/', 'Modular kitchen design guide', 'Layouts, materials, storage and cost', 'Pillar guide'],
    ['/materials/acrylic-finish/', 'Acrylic finish guide', 'Gloss or matte shutters', 'Finishes'],
    ['/compare/acrylic-vs-laminate/', 'Acrylic vs laminate', 'Which finish for your kitchen', 'Compare'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-start.php';
?>
<p>A kitchen is looked at, touched and cleaned more than any other room, so the colour decision carries more weight than it seems in a showroom. Two-colour laminate schemes have become the norm in Indian modular kitchens because they solve a real problem: one colour looks flat under a single window and tube lights, while three or more start to look busy. Two, chosen well, give depth and balance.</p>

<h2>Why two colours work better than one</h2>
<p>Most apartment kitchens in India have one window and one overhead light. A single colour absorbs that light evenly, and the upper and lower cabinets merge into one block. Splitting the colours fixes this with almost no cost:</p>
<ul>
  <li>A <strong>darker base</strong> sits where grease, water and feet are, and hides wear.</li>
  <li>A <strong>lighter top</strong> reflects light onto the counter and makes the ceiling feel higher.</li>
</ul>
<div class="callout"><span class="callout__title">Default rule</span>Dark below, light above. Flip it only in a large, well-lit kitchen when you deliberately want a dramatic, hotel-style look.</div>

<h2>Getting the proportions right</h2>
<p>Designers often use a 60-30-10 split: about 60% of the visible surface in the main colour, 30% in the second colour, and 10% in an accent such as handles, backsplash or lights. In a kitchen that usually means:</p>
<ul>
  <li><strong>Main colour (about 60%):</strong> wall units, tall units and lofts. This is the colour people will describe your kitchen by.</li>
  <li><strong>Second colour (about 30%):</strong> base units and the island. This is the anchor.</li>
  <li><strong>Accent (about 10%):</strong> handles, backsplash, pendant lights or one feature door.</li>
</ul>
<p>An equal 50:50 split tends to look undecided. In very small kitchens (under about 80 sq ft), go 70:30 with the lighter colour leading. In an open kitchen, repeat the main colour, or something close to it, somewhere in the living room so the spaces feel connected.</p>

<h2>Four questions to answer before you look at swatches</h2>
<h3>1. How much daylight does the kitchen get?</h3>
<p>Stand in it at about 11 am with the lights off. If you can read a recipe comfortably, dark combinations are open to you. If you reach for the switch, stay with the lighter pairs.</p>
<h3>2. How big is it?</h3>
<p>Under 80 sq ft is small, 80–140 sq ft is medium, above 140 sq ft is large. Small kitchens carry one calm mood well; large kitchens can take contrast. Deep colours in a small kitchen rarely feel luxurious; they feel tight.</p>
<h3>3. What is the countertop?</h3>
<p>Stone is not neutral. A white quartz with grey veins pulls the scheme cool; black granite warms woods towards orange. Choose the countertop first, or choose laminates knowing exactly what it will be.</p>
<h3>4. How much do you cook?</h3>
<p>Gloss laminates show every fingerprint within days of daily tadka. If the kitchen works hard, favour matte and textured finishes, and expect colours to look slightly different in each finish.</p>

<h2>Ten combinations that work</h2>
<p>Each card shows the two colours, a simple illustration of how they sit on the cabinets, and approximate hex codes to take to a laminate dealer. Treat the size and light notes as a filter: if your kitchen does not match, move on to the next.</p>
<?php foreach ($COMBOS as $i => $c): [$a, $b, $tag, $text, $works, $watch, $size, $light, $style] = $c; ?>
<div class="combo">
  <div class="combo__chips">
    <span style="--c:<?= $a[1] ?><?= $a[2] ? ';--on:#1A1A1A' : '' ?>"><?= e($a[0]) ?> · <?= $a[1] ?></span>
    <span style="--c:<?= $b[1] ?><?= $b[2] ? ';--on:#1A1A1A' : '' ?>"><?= e($b[0]) ?> · <?= $b[1] ?></span>
  </div>
  <div class="combo__body">
    <?= img(strtolower(str_replace(' ', '-', $a[0] . ' and ' . $b[0])) . '-two-colour-kitchen') ?>
    <span class="eyebrow"><?= sprintf('%02d', $i + 1) ?> · <?= e($tag) ?></span>
    <h3 class="combo__title"><?= e($a[0]) ?> and <?= e(strtolower($b[0])) ?></h3>
    <p><?= e($text) ?></p>
    <div class="pros-cons">
      <div><span class="pros-cons__title">Works because</span><ul><?php foreach ($works as $w) echo '<li>' . e($w) . '</li>'; ?></ul></div>
      <div><span class="pros-cons__title">Watch out for</span><ul><?php foreach ($watch as $w) echo '<li>' . e($w) . '</li>'; ?></ul></div>
    </div>
    <dl class="spec"><dt>Kitchen size</dt><dd><?= e($size) ?></dd><dt>Daylight needed</dt><dd><?= e($light) ?></dd><dt>Style</dt><dd><?= e($style) ?></dd></dl>
  </div>
</div>
<?php endforeach; ?>

<h2>Quick decision table</h2>
<p>Find the row that describes your kitchen. The pairs listed are the ones we would start with; others are not wrong, just not the first choice.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Your kitchen</th><th>Start with</th></tr></thead>
  <tbody>
    <tr><td>Small and fairly dark</td><td>Pearl greige and light maple · Warm white and walnut</td></tr>
    <tr><td>Small but sunny</td><td>Ivory and sage · Chalk white and graphite</td></tr>
    <tr><td>Medium, average light</td><td>Warm white and walnut · Chalk white and graphite · Linen beige and forest green</td></tr>
    <tr><td>Medium, bright, want a statement</td><td>Soft white and ink navy · Sand and terracotta · Concrete grey and ochre</td></tr>
    <tr><td>Large with plenty of daylight</td><td>Charcoal black and oak · Soft white and ink navy · Graphite and signal red</td></tr>
    <tr><td>Open to the living room</td><td>Warm white and walnut · Ivory and sage · Linen beige and forest green</td></tr>
    <tr><td>Heavy Indian cooking every day</td><td>Sand and terracotta · Charcoal black and oak · Pearl greige and light maple</td></tr>
    <tr><td>Planning to sell within 7 years</td><td>Warm white and walnut · Pearl greige and light maple · Chalk white and graphite</td></tr>
    <tr><td>Want something unusual</td><td>Linen beige and forest green · Sand and terracotta · Graphite and signal red</td></tr>
  </tbody>
</table>
</div>

<h2>Matte, gloss or textured?</h2>
<p>The same colour in three finishes gives three different kitchens.</p>
<ul>
  <li><strong>Matte:</strong> the best all-rounder for cooking kitchens. Dark colours look richer in matte and forgive more.</li>
  <li><strong>Gloss:</strong> useful on light-coloured wall units in small kitchens, where reflection helps. Avoid it on base units, which take the most grease and knocks.</li>
  <li><strong>Textured (suede, woodgrain, fabric):</strong> makes wood looks and greens convincing. Slightly dearer, and worth it on the colour that leads your scheme.</li>
</ul>
<div class="callout callout--tip"><span class="callout__title">If you pick one finish for everything</span>Pick matte. It dates slowest, photographs consistently and copes best with daily cooking. For a glossier look on a few doors, see our <a href="/materials/acrylic-finish/">acrylic finish guide</a>.</div>

<h2>Six mistakes we see often</h2>
<ol>
  <li><strong>Choosing under showroom lights.</strong> Showroom LEDs flatter everything. Take three or four samples home and look at them on the wall at the times you cook.</li>
  <li><strong>Gloss everywhere.</strong> It looks wonderful for two weeks. Limit gloss to one element at most.</li>
  <li><strong>Matching cabinet wood to floor wood.</strong> Two similar woods fight. Go clearly lighter or clearly darker than the floor.</li>
  <li><strong>Ignoring the handles.</strong> Hardware is the accent that finishes the scheme: brushed brass warms, matte black sharpens, chrome cools.</li>
  <li><strong>Trusting the catalogue colour.</strong> Greens, navies and reds vary widely between brands and finishes. Always see the real sheet.</li>
  <li><strong>Matching laminate to wall paint.</strong> They reflect light differently and never match exactly. Aim for a related tone, not a copy.</li>
</ol>
<p>Once the colours are settled, price your layout in the <a href="/calculators/modular-kitchen/">modular kitchen calculator</a>.</p>
<?php /* INTERLINK: local guides + execution partner (scratchpad edits.py) */ ?>
<p>For colour schemes in real local kitchens, see <a href="/blogs/modular-kitchen-designs-chandapura/">12 kitchen designs for Chandapura homes</a> and <a href="/blogs/small-kitchen-design-ideas/">small kitchen design ideas</a>. Huma Interiors, our execution partner, can show you laminate and acrylic sheets in person at its <?= huma('home', 'Chandapura studio', follow: false) ?>.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-end.php'; ?>
