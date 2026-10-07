<?php
/* PILLAR PAGE — Colour Guide (/colour/)   ·   Phase 2, Oct 2026
   Target keyword: "wall colour combination" (+ "colour combination for house", "room colour ideas")
   Cluster links come from includes/nav.php → 'colour'.  Images: /assets/pages/colour/ */
$PAIRS = [   // [name, hex A, hex B, where it suits, why it works]
  ['Warm white + walnut brown', '#F3EEE5', '#5B3A24', 'Living, bedroom', 'Neutral base with a grounding wood tone; forgiving in any light'],
  ['Greige + sage green', '#D9D2C7', '#9DAF90', 'Bedroom, study', 'Low contrast, calm; sage reads natural under warm light'],
  ['Soft white + ink navy', '#F7F7F4', '#1F2B45', 'Living, dining', 'Classic contrast; navy behind a TV reduces screen glare'],
  ['Sand + terracotta', '#EFE4D2', '#A9573A', 'Living, dining', 'Earthy, warm; pairs with brass and cane'],
  ['Pale grey + dusty rose', '#E3E3E1', '#C99A9A', 'Bedroom', 'Soft and muted; grey stops the pink from turning sweet'],
  ['Ivory + olive', '#F2ECE0', '#6E7046', 'Living, foyer', 'Muted, sophisticated; olive hides marks'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'colour',
  'title'        => 'Wall Colour Combinations: How to Choose Colours for Every Room',
  'seo_title'    => 'Wall Colour Combinations for Indian Homes (2026)',
  'crumb'        => 'Colour Guide',
  'description'  => 'Wall colour combinations for Indian homes, with the science behind them: light direction, LRV, undertones, the 60-30-10 rule and finishes.',
  'eyebrow'      => 'Design hub · pillar guide',
  'lede'         => 'A method for choosing wall colours that look right in your light, with tested combinations and the paint science behind them.',
  'hero_alt'     => 'Paint swatches in warm neutrals and muted greens laid on a floor plan',
  'published'    => '2026-10-04',
  'updated'      => '2026-10-04',
  'quick_answer' => 'Pick wall colours in four steps: note which way the room faces (north light is cool, south and west light warm), choose a base colour with the right undertone and a light reflectance value (LRV) of about 60–85 for most walls, add one deeper accent in roughly a 60-30-10 split with furniture and décor, then test large samples on the wall in daylight and at night. Warm whites, greige, sage, muted blues and earthy terracotta are the most reliable bases in Indian homes.',
  'takeaways' => [
    'Read the light first: north light is cool and even, west light hot and golden in the evening.',
    'Main walls usually sit at LRV 60–85; keep colours below about LRV 30 for accents in bright rooms.',
    'Match undertones across walls, floor and furniture; most colour "mistakes" are undertone clashes.',
    'Use about 60% dominant, 30% secondary, 10% accent as a starting proportion.',
    'Test 2 × 2 ft samples on the wall in daylight and under your own bulbs before buying.',
  ],
  'sources' => [
    ['BS 8493: Light reflectance value (LRV) of a surface', 'https://knowledge.bsigroup.com/', 'the test method behind LRV figures on shade cards'],
    ['CIE (International Commission on Illumination)', 'https://cie.co.at/', 'colour rendering index and colour temperature definitions'],
    ['Valdez, P. & Mehrabian, A. (1994). Effects of color on emotions. Journal of Experimental Psychology: General, 123(4)', 'https://doi.org/10.1037/0096-3445.123.4.394', 'brightness and saturation predict emotional response more than hue'],
    ['Elliot, A. J. & Maier, M. A. (2014). Color psychology. Annual Review of Psychology, 65', 'https://doi.org/10.1146/annurev-psych-010213-115035', 'review of what colour research does and does not show'],
  ],
  'faq' => [
    'How many colours should a room have?' => 'Usually three: one dominant wall colour, one secondary colour (an accent wall, or furniture and curtains) and one small accent in cushions, art or metal. More is possible, but each extra colour needs a reason.',
    'Should all rooms in a house be the same colour?' => 'Not the same, but related. Use one family of neutrals for main walls throughout, especially in connected living, dining and passage areas, and give bedrooms their own accents. The home then feels calm and continuous.',
    'Do light colours really make rooms look bigger?' => 'Yes. Light, high-LRV colours reflect more light, soften the corners and make walls appear to recede. A low-contrast scheme, with walls, ceiling and large furniture close in tone, adds to the effect.',
    'Which colour combination is best for a house?' => 'A warm or neutral white as the main wall colour, one deeper accent for a feature wall, and wood or textile tones to link them. Warm white with walnut, greige with sage green and soft white with navy are three combinations that work in most Indian rooms and lights.',
    'What is LRV in paint?' => 'Light Reflectance Value: the percentage of visible light a colour reflects, from 0 (black) to 100 (perfect white). Most wall colours that keep a room bright sit between 60 and 85. Colours below about 30 absorb most light and suit accent walls in well-lit rooms.',
    'How do I choose a wall colour for a dark room?' => 'Choose a colour with a high LRV (70 or more) and a warm undertone, and use a matt or eggshell finish so it does not show every flaw. Add warm 2700–3000 K lighting. Avoid cool greys in dark north-facing rooms; they turn flat and gloomy.',
    'What is the 60-30-10 rule?' => 'A proportion guide: about 60% of what you see in a room in the dominant colour (usually walls), 30% in a secondary colour (furniture, curtains, one wall) and 10% in an accent (cushions, art, metal). It is a starting point, not a law.',
    'Should the ceiling be white?' => 'Usually, in a white with the same undertone as the walls, in a flat matt finish. A ceiling one or two shades lighter than the walls looks more finished than stark white. Dark ceilings suit only tall rooms.',
  ],
  'related' => [
    ['/wall-design/', 'Wall design guide', 'Panelling, texture, stone and wallpaper', 'Pillar guide'],
    ['/styles/', 'Interior design styles', 'Looks that work in Indian homes', 'Pillar guide'],
    ['/planning/lighting-design/', 'Lighting design', 'Colour temperature and layering', 'Planning'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Most colour mistakes are not taste mistakes. A shade that looked perfect on a small card turns grey, green or yellow on the wall because of the light in the room, the undertone of the paint or the sheen of the finish. Enteriors approaches colour as a material: something with measurable properties that behave predictably once you know them. This pillar explains those properties and links to detailed combination guides for each room.</p>

<h2>Step 1: read the light in the room</h2>
<p>Daylight changes colour through the day and with the direction a window faces. In India, the sun tracks across the southern sky for most of the year, so:</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Window faces</th><th>Light</th><th>Colours that work</th><th>Colours to test carefully</th></tr></thead>
  <tbody>
    <tr><td>North</td><td>Even, cool, indirect</td><td>Warm whites, cream, warm greige, terracotta, warm green</td><td>Cool greys and blues (look cold and flat)</td></tr>
    <tr><td>South</td><td>Strong, warm, changing</td><td>Most colours; cool and muted tones balance the warmth</td><td>Strong yellows and oranges (glare)</td></tr>
    <tr><td>East</td><td>Bright warm mornings, cooler afternoons</td><td>Soft neutrals, light greens, blues</td><td>Very dark colours in small rooms</td></tr>
    <tr><td>West</td><td>Dim mornings, hot golden evenings</td><td>Cool-leaning neutrals, sage, muted blue</td><td>Warm oranges and pinks (intense at sunset)</td></tr>
  </tbody>
</table>
</div>
<p>Artificial light matters as much at night. Warm white bulbs (2700–3000 K) make colours look warmer; cool white (5000–6500 K) makes them look bluer and harsher. Choose bulbs with a colour rendering index (CRI) of 90 or more, or colours will look duller than the sample. See <a href="/planning/lighting-design/">lighting design</a>.</p>

<h2>Step 2: understand undertone and LRV</h2>
<ul>
  <li><strong>Undertone</strong> is the hidden colour inside a neutral. Whites and greys lean yellow, pink, green or blue. Hold a sample against pure white paper to see it. Match undertones between walls, floor and furniture.</li>
  <li><strong>LRV (light reflectance value)</strong> is printed on many shade cards: 0 is black, 100 is perfect white. Main walls usually sit at 60–85; accent walls can go lower in bright rooms. LRV also affects heat on exterior walls, covered in <a href="/colour/exterior-house-colour/">exterior house colours</a>.</li>
</ul>

<h2>Step 3: build a combination</h2>
<p>Use the 60-30-10 proportion as a starting point: about 60% dominant colour (most walls), 30% secondary (furniture, curtains, one wall) and 10% accent (cushions, art, metal). Six combinations that work in most Indian rooms:</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Combination</th><th>Swatches</th><th>Suits</th><th>Why it works</th></tr></thead>
  <tbody>
<?php foreach ($PAIRS as [$name, $a, $b, $where, $why]): ?>
    <tr><td><?= e($name) ?></td><td><span style="display:inline-block;width:1.4rem;height:1.4rem;border-radius:3px;border:1px solid #ccc;background:<?= $a ?>"></span> <span style="display:inline-block;width:1.4rem;height:1.4rem;border-radius:3px;border:1px solid #ccc;background:<?= $b ?>"></span></td><td><?= e($where) ?></td><td><?= e($why) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Swatches are on-screen approximations. Always choose from a physical sample of the actual paint.</p>
<p>Room-by-room picks are in <a href="/colour/bedroom-colour-combination/">bedroom colour combinations</a>, <a href="/colour/living-room-colour-combination/">living room colour combinations</a> and <a href="/blogs/kitchen-colour-combinations/">kitchen colour combinations</a>.</p>

<h2>Step 4: choose the finish</h2>
<p>The same colour looks darker and richer in matt, lighter and more reflective in satin or gloss. Sheen also changes washability: matt hides wall flaws, eggshell and satin wipe clean, gloss is for doors, trims and grilles. The <a href="/colour/paint-finishes/">paint finishes guide</a> compares emulsion, enamel, distemper and specialist coatings.</p>
<?= img('large-paint-sample-boards-on-wall') ?>

<h2>Step 5: test properly</h2>
<ol>
  <li>Buy sample pots of two or three finalists.</li>
  <li>Paint samples at least 2 × 2 ft, two coats, on the actual wall, away from the old colour's edge.</li>
  <li>Look at them in morning light, at midday and at night under your bulbs, for two days.</li>
  <li>Check them beside the floor, the sofa fabric and the curtains.</li>
</ol>

<h2>What colour research does and does not show</h2>
<p>Colour affects how a room <em>feels</em>, but research on colour and mood is less certain than popular articles suggest: responses vary with culture, age, light and saturation more than with hue alone. Practical effects are better established: light, high-LRV colours make rooms feel larger and brighter; low-saturation colours are easier to live with for years; strong contrast draws the eye. The evidence is summarised in <a href="/colour/colour-psychology/">colour psychology at home</a>, with traditional directional colour guidance covered in the <a href="/vastu/">vastu guide</a>.</p>
<h2>Colour by room: a quick reference</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Room</th><th>Main walls</th><th>Accent options</th><th>Finish</th><th>Light</th></tr></thead>
  <tbody>
    <tr><td>Living room</td><td>Warm white, ivory, sand, greige</td><td>Terracotta, navy, olive, deep teal, charcoal</td><td>Washable matt or eggshell</td><td>2700–3000 K layered</td></tr>
    <tr><td>Master bedroom</td><td>Warm white, greige, cream</td><td>Sage, dusty blue, olive, walnut</td><td>Matt or eggshell</td><td>2700 K dimmable</td></tr>
    <tr><td>Kids' room</td><td>Soft white, pale greige</td><td>Colour in furniture and textiles</td><td>Washable / satin</td><td>3000–4000 K</td></tr>
    <tr><td>Kitchen</td><td>Light neutrals</td><td>Colour on cabinets, not walls</td><td>Satin</td><td>4000 K task light</td></tr>
    <tr><td>Study</td><td>Muted green, grey-blue, warm neutral</td><td>Wood, books</td><td>Matt</td><td>4000 K task + warm ambient</td></tr>
    <tr><td>Pooja room</td><td>Warm white, cream</td><td>Soft saffron, gold leaf, wood</td><td>Matt</td><td>2700 K</td></tr>
    <tr><td>Bathroom</td><td>Light neutrals (tile does the work)</td><td>One tile accent</td><td>Satin, anti-fungal</td><td>4000 K at mirror</td></tr>
    <tr><td>Passages</td><td>Same as living-room main colour</td><td>Art, not paint</td><td>Eggshell (scuffs)</td><td>Sensor or soft wall lights</td></tr>
  </tbody>
</table>
</div>
<?= img('paint-palette-for-whole-apartment-plan', caption: 'A whole-home palette laid over a 2 BHK floor plan: one neutral family throughout, accents room by room') ?>

<h2>Indian light, Indian floors</h2>
<p>Two things make colour behave differently in Indian homes compared with the photographs on most design sites.</p>
<ul>
  <li><strong>Strong, high sun.</strong> Much of India sits between about 8° and 30° north, so daylight is intense and warm for much of the year. Very saturated colours that look balanced in grey northern light can feel loud here. Slightly greyed-down (muted) versions usually look better.</li>
  <li><strong>Large, light floors.</strong> Most apartments have glossy vitrified tiles or marble in cream, beige or white. A floor covers as much area as a wall and bounces its colour upward. Beige tiles push walls warm; white or grey marble-look tiles push them cool.</li>
</ul>
<p>Bengaluru adds another twist: many apartments face east–west to catch breezes, so living rooms often get hot, golden western light in the evening. Cooler, muted accents (sage, dusty blue, olive) balance it better than strong oranges.</p>

<h2>Whole-home colour planning</h2>
<ol>
  <li><strong>Pick one neutral family</strong> (warm whites, or greiges) for all main walls and ceilings. Connected spaces then flow.</li>
  <li><strong>Assign one accent per room</strong>, drawn from a shared palette of three or four colours.</li>
  <li><strong>Repeat accents</strong> in small doses elsewhere: a living-room terracotta in dining chairs, or a bedroom sage in a bathroom towel.</li>
  <li><strong>Decide wood and metal tones</strong> early: walnut and brass, oak and black, teak and bronze. They behave like colours.</li>
  <li><strong>Write it down</strong>: shade names, codes, finish and room, so touch-ups and repaints match.</li>
</ol>
<?= img('colour-schedule-shade-codes-by-room', caption: 'A simple colour schedule: shade name, code, finish and room, kept for touch-ups and repaints') ?>

<h2>Colour trends for 2026, and which will last</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Trend</th><th>Examples</th><th>Staying power</th></tr></thead>
  <tbody>
    <tr><td>Warm neutrals</td><td>Greige, oatmeal, mushroom, warm white</td><td>High: a long-term base, not a fad</td></tr>
    <tr><td>Earth tones</td><td>Terracotta, clay, ochre, rust</td><td>High in India; suits local materials</td></tr>
    <tr><td>Muted greens</td><td>Sage, olive, eucalyptus</td><td>Medium-high; pairs with plants and wood</td></tr>
    <tr><td>Deep jewel accents</td><td>Teal, ink navy, aubergine</td><td>Medium; best on one wall or in fabric</td></tr>
    <tr><td>Cool greys and all-white</td><td>Pure white, blue-grey</td><td>Declining; feel cold in warm interiors</td></tr>
  </tbody>
</table>
</div>
<p>More in <a href="/trends/warm-neutrals/">warm neutrals</a> and <a href="/trends/">interior trends 2026</a>.</p>
<?= img('earth-tone-living-room-terracotta-and-clay', caption: 'Terracotta and clay with warm white: an earth-tone scheme that suits Indian light and materials') ?>

<h2>Common colour mistakes</h2>
<ul>
  <li>Choosing from a tiny chip under shop lights.</li>
  <li>Ignoring the floor's undertone.</li>
  <li>Using cool whites and greys in north-facing rooms.</li>
  <li>Too many accent colours, one per wall.</li>
  <li>Buying cool white (6500 K) bulbs that turn every colour harsh at night.</li>
  <li>Dark colours in high-gloss finishes on uneven walls.</li>
</ul>

<h2>Where to go next</h2>
<p>Start with the room you are painting: <a href="/colour/bedroom-colour-combination/">bedroom combinations</a>, <a href="/colour/living-room-colour-combination/">living room combinations</a> or <a href="/colour/exterior-house-colour/">exterior colours</a>. For finish and quantity, read <a href="/colour/paint-finishes/">types of paint finish</a>; for the science, <a href="/colour/colour-psychology/">colour psychology at home</a>. Textured and panelled alternatives to flat colour are in the <a href="/wall-design/">wall design guide</a>.</p>

<h2>Terms explained</h2>
<dl class="terms">
  <dt>Hue</dt><dd>The colour family: red, yellow, green, blue and so on.</dd>
  <dt>Value (lightness)</dt><dd>How light or dark a colour is; measured on shade cards as LRV.</dd>
  <dt>Saturation (chroma)</dt><dd>How intense or greyed-down a colour is. Muted colours have low saturation.</dd>
  <dt>Undertone</dt><dd>The subtle colour inside a neutral, such as the yellow in a cream or the green in a grey.</dd>
  <dt>LRV</dt><dd>Light reflectance value: the share of light a colour reflects, from 0 (black) to 100 (white).</dd>
  <dt>Colour temperature</dt><dd>How warm or cool a light source looks, in kelvin (K): 2700 K is warm, 4000 K neutral, 6500 K cool.</dd>
  <dt>CRI</dt><dd>Colour rendering index: how faithfully a light shows colours compared with daylight; 90 or more is good for homes.</dd>
</dl>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
