<?php
/* CLUSTER PAGE — /colour/exterior-house-colour/   ·   Phase 2, Oct 2026
   Target keyword: "exterior house colour combination" (+ "outside house colour", "exterior paint colours India")
   Images: /assets/pages/colour/exterior-house-colour/ */
$COMBOS = [   // [name, body hex, trim hex, character, notes]
  ['Warm white + teak brown', '#EFE9DF', '#6B4A2F', 'Timeless, cool in summer', 'High LRV body keeps walls cooler; brown hides dust on trims'],
  ['Light grey + charcoal', '#C9C8C4', '#3B3C3F', 'Contemporary', 'Grey body hides city dust and monsoon streaks'],
  ['Sand beige + terracotta', '#E3D3B8', '#A9573A', 'Warm, regional', 'Suits sloped roofs, brick and stone details'],
  ['Off-white + sage', '#EEEBE3', '#8E9F82', 'Soft, garden-friendly', 'Good for independent houses with greenery'],
  ['Cream + slate blue', '#EFE7D6', '#4F6070', 'Calm, coastal', 'Choose fade-resistant inorganic pigments for the blue'],
  ['Pale greige + black accents', '#DCD5CA', '#1E1E1E', 'Modern minimal', 'Black on metal and window frames only; it heats up'],
];
$page = [
  'type'         => 'article',
  'title'        => 'Exterior House Colour Combinations: Heat, Dust, Monsoon and Fading',
  'seo_title'    => 'Exterior House Colour Combinations (2026)',
  'crumb'        => 'Exterior Colours',
  'description'  => 'Exterior house colour combinations chosen for Indian heat, dust, rain and fading: six schemes, LRV and solar heat, paint types and repaint cycles.',
  'eyebrow'      => 'Colour combinations',
  'lede'         => 'Outside colours face sun, rain and dust every day. Six schemes that last, and the paint science that decides how long they look new.',
  'hero_alt'     => 'Independent house painted warm white with teak brown window frames',
  'published'    => '2026-10-04',
  'updated'      => '2026-10-04',
  'quick_answer' => 'For Indian exteriors, choose a light body colour with a high LRV (about 65–85) to reflect heat and hide dust, with a deeper trim colour for frames, bands and gates. Warm white with teak brown, light grey with charcoal and sand with terracotta are reliable combinations. Use a premium exterior emulsion or elastomeric paint with a dirt-pickup-resistant finish; bright reds, blues and yellows fade fastest, so use them only for small accents.',
  'takeaways' => [
    'Choose a light body colour (LRV about 65–85) to reflect heat and hide dust; deeper colours for trims.',
    'Earthy iron-oxide colours and neutrals hold their colour; bright reds, blues and greens fade fastest.',
    'Use premium exterior emulsion or elastomeric paint with dirt-pickup and algae resistance.',
    'Preparation decides life: repair cracks, clean algae, prime, then two coats in dry weather.',
    'Repaint every 5–8 years, sooner on coastal and very wet sites.',
  ],
  'sources' => [
    ['Bureau of Energy Efficiency: Eco-Niwas Samhita (residential energy code)', 'https://beeindia.gov.in/', 'cool roofs and building envelope guidance for Indian homes'],
    ['Bureau of Indian Standards: IS 2395', 'https://www.bis.gov.in/', 'code of practice for painting masonry and plaster surfaces'],
    ['Lawrence Berkeley National Laboratory: Heat Island Group', 'https://heatisland.lbl.gov/', 'solar reflectance and cool coatings research'],
  ],
  'faq' => [
    'Is white a good exterior colour in Indian cities?' => 'Pure bright white reflects the most heat but shows dust, rain streaks and algae quickly. A warm off-white or cream keeps most of the cooling benefit and looks clean for longer.',
    'How much does exterior painting cost per square foot?' => 'Indicatively, in Bengaluru (October 2026, before GST), about ₹33–60 per sq ft for preparation, primer and two coats of premium exterior emulsion, with scaffolding. Elastomeric and texture systems cost more.',
    'Which colour keeps a house cool?' => 'Light colours with a high solar reflectance: white, off-white, cream and pale greige on walls, and white or special cool coatings on roof slabs. They absorb less of the sun\'s heat, especially on west and south faces.',
    'What is the best exterior colour for a house near the sea?' => 'Light, salt-tolerant neutrals such as off-white, sand or light grey, with a premium exterior paint designed for coastal conditions. Avoid dark colours, which fade and show salt deposits, and repaint on a shorter cycle.',
    'Does an exterior colour need approval in an apartment?' => 'Usually yes. Apartment exteriors are common property, and the association or builder decides the colour scheme. Independent houses are free to choose, within any local layout rules.',
    'Which colour is best for the outside of a house in India?' => 'Light, warm neutrals: warm white, cream, sand, light greige or light grey. They reflect more of the sun\'s heat, show less fading and hide dust better than very white or very dark colours. Use darker shades for trims and accents.',
    'Does exterior colour affect indoor temperature?' => 'Yes. A wall with a high light reflectance absorbs less solar heat, which lowers the surface temperature and reduces heat passing indoors, especially on west-facing walls and roofs. Special heat-reflective (cool) coatings increase the effect.',
    'Which exterior colours fade fastest?' => 'Bright, saturated reds, blues, greens and yellows made with organic pigments fade fastest in strong sun. Earthy colours made from iron oxide pigments (terracotta, ochre, browns) and neutrals hold their colour longest.',
    'How often should the exterior of a house be painted?' => 'With a good primer and two coats of a premium exterior emulsion, every 5–8 years; premium elastomeric or long-life systems can last longer. Coastal and heavy-rain areas need repainting sooner. Repaint when you see chalking, cracks or algae, not only when the colour looks dull.',
    'What is elastomeric paint?' => 'A thick, rubbery exterior coating that stretches over hairline cracks and bridges them, keeping rain out. It suits plastered walls with fine cracks. It does not fix structural cracks, which need repair first.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>An exterior colour is judged from the street for years, so it has to look good on day one and still look good after five monsoons and five summers. In India that means choosing for heat, dust, algae and fading as much as for taste. This page sets out six combinations and the properties that make them last. For interior colours, see the <a href="/colour/">colour guide</a>.</p>

<h2>Six exterior colour combinations</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Body + trim</th><th>Swatches</th><th>Character</th><th>Why it lasts</th></tr></thead>
  <tbody>
<?php foreach ($COMBOS as [$name, $a, $b, $char, $note]): ?>
    <tr><td><?= e($name) ?></td><td><span style="display:inline-block;width:1.4rem;height:1.4rem;border-radius:3px;border:1px solid #ccc;background:<?= $a ?>"></span> <span style="display:inline-block;width:1.4rem;height:1.4rem;border-radius:3px;border:1px solid #ccc;background:<?= $b ?>"></span></td><td><?= e($char) ?></td><td><?= e($note) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">On-screen approximations. Exterior colours look lighter outdoors than on a card; choose one shade deeper than you think.</p>
<?= img('warm-white-house-teak-brown-trims') ?>

<h2>Heat: why light colours keep a house cooler</h2>
<p>Sunlight absorbed by a wall turns into heat. A colour's light reflectance value (LRV) is a good everyday guide to how much it reflects: a warm white around LRV 80 reflects far more than a mid-brown around LRV 20. The effect is strongest on west-facing walls and roof slabs, which take the hottest afternoon sun. Heat-reflective "cool" coatings for roofs and walls use special pigments that also reflect infrared, and can lower surface temperatures further. Dark colours are best kept for window frames, grilles and small bands.</p>

<h2>Dust, rain and algae</h2>
<ul>
  <li><strong>Very white walls</strong> show dust and rain streaks quickly in cities. A warm white or light greige stays cleaner-looking.</li>
  <li><strong>Very dark walls</strong> show a pale film of dust and fade unevenly.</li>
  <li><strong>Mid-light neutrals</strong> (sand, light grey, greige) are the most forgiving.</li>
  <li><strong>Algae and fungus</strong> grow on shaded, north-facing and wet walls. Use paints with anti-algal additives, and fix drips from sills and AC units.</li>
</ul>

<h2>Fading: which pigments last</h2>
<p>Colour fading in sun depends on the pigment. Iron oxide pigments (the earthy reds, browns, yellows and ochres) and titanium dioxide (white) are very stable. Bright reds, blues, violets and greens rely more on organic pigments, which fade faster under strong UV. That is why terracotta and teak brown look good for years, while a bright blue gate can look washed out in two summers. For saturated accents, ask for a colour from the brand's exterior fade-resistant range.</p>

<h2>Exterior paint types</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Type</th><th>What it does</th><th>Typical life</th></tr></thead>
  <tbody>
    <tr><td>Exterior acrylic emulsion</td><td>Standard weather-resistant paint</td><td>4–6 years</td></tr>
    <tr><td>Premium exterior emulsion</td><td>Better UV and dirt resistance, anti-algal</td><td>5–8 years</td></tr>
    <tr><td>Elastomeric coating</td><td>Stretches over hairline cracks, waterproofing</td><td>7–10 years</td></tr>
    <tr><td>Exterior texture</td><td>Thick textured film, hides surface flaws</td><td>7–10 years</td></tr>
    <tr><td>Heat-reflective / cool coating</td><td>Reflects solar heat (roofs, west walls)</td><td>Varies by product</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Lives assume correct surface preparation, primer and two finish coats, in typical Indian conditions; coastal and heavy-rain areas run shorter.</p>

<h2>Surface preparation decides the life</h2>
<ol>
  <li>Repair cracks and fix leaks; let damp walls dry.</li>
  <li>Wash off dust, algae and chalking; treat algae with a biocide.</li>
  <li>Apply an exterior primer (alkali-resistant on new plaster).</li>
  <li>Apply two finish coats; paint in dry weather, not just before rain.</li>
</ol>

<h2>Colour, materials and the street</h2>
<p>Look at the roof, stone, brick and window frames that will stay, and at the neighbouring houses: a colour that fights the street looks out of place. For texture and stone on façades, see <a href="/wall-design/texture-paint/">texture paint</a> and <a href="/wall-design/stone-wall-cladding/">stone wall cladding</a>; for the main door, see <a href="/doors/main-door-design/">main door design</a>.</p>
<h2>Exterior colour by climate zone</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Climate</th><th>Cities</th><th>Body colours</th><th>Paint priorities</th></tr></thead>
  <tbody>
    <tr><td>Warm and humid (coastal)</td><td>Mumbai, Chennai, Kochi, Visakhapatnam</td><td>Off-white, sand, light grey</td><td>Salt and algae resistance; shorter repaint cycle</td></tr>
    <tr><td>Hot and dry</td><td>Jaipur, Ahmedabad, Nagpur</td><td>White, cream, pale earth tones</td><td>High reflectance; flexible paint against thermal cracks</td></tr>
    <tr><td>Composite</td><td>Delhi NCR, Lucknow, Hyderabad</td><td>Warm white, greige, sand</td><td>UV resistance; dust resistance</td></tr>
    <tr><td>Temperate</td><td>Bengaluru, Pune</td><td>Most light and mid tones</td><td>Monsoon algae on shaded faces; dust resistance</td></tr>
    <tr><td>Very wet</td><td>Kerala, Konkan, North-East</td><td>Light neutrals, earthy trims</td><td>Elastomeric waterproof coats; anti-algal</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Climate zones follow the broad classification used in Indian building energy guidance.</p>
<?= img('coastal-house-off-white-and-slate-blue', caption: 'A coastal home in off-white with slate blue shutters: light body colour, fade-resistant accent') ?>

<h2>Worked example: repainting a G+1 independent house</h2>
<p>A two-storey house in Bengaluru with about 3,000 sq ft of exterior wall area:</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Step</th><th>Detail</th><th class="num">Indicative cost</th></tr></thead>
  <tbody>
    <tr><td>Preparation</td><td>Wash, algae treatment, crack filling</td><td class="num">₹15,000–30,000</td></tr>
    <tr><td>Primer</td><td>One coat exterior primer</td><td class="num">₹15,000–25,000</td></tr>
    <tr><td>Finish</td><td>Two coats premium exterior emulsion</td><td class="num">₹60,000–1 lakh</td></tr>
    <tr><td>Scaffolding</td><td>Two floors</td><td class="num">₹10,000–25,000</td></tr>
    <tr><td><strong>Total</strong></td><td>About ₹33–60 per sq ft, before GST</td><td class="num"><strong>₹1–1.8 lakh</strong></td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru rates, October 2026. Elastomeric systems and texture finishes cost more; waterproofing repairs are extra.</p>

<h2>Colour placement on a façade</h2>
<ul>
  <li><strong>Body:</strong> the light main colour on most of the wall.</li>
  <li><strong>Bands and projections:</strong> a mid tone on sunshades, floor bands and parapets to give depth.</li>
  <li><strong>Trims:</strong> a deeper colour on window frames, grilles and the gate.</li>
  <li><strong>Base:</strong> a darker plinth band, 450–900 mm high, hides rain splash and dust.</li>
  <li><strong>Feature:</strong> stone, texture or wood cladding on one element, such as the entrance.</li>
</ul>
<?= img('facade-colour-placement-body-band-trim-plinth', caption: 'A façade with a light body, mid-tone bands, deep trims and a darker plinth that hides rain splash') ?>

<h2>Maintenance between repaints</h2>
<ul>
  <li>Wash the façade gently once a year after the monsoon; low pressure only.</li>
  <li>Treat algae patches early with a biocidal wash.</li>
  <li>Fix leaking sills, AC drain pipes and overflowing gutters, the main causes of streaks.</li>
  <li>Touch up trims and grilles every two to three years; metal rusts faster than walls fade.</li>
  <li>Inspect for hairline cracks before each monsoon and seal them.</li>
</ul>

<h2>Roof slabs and terraces</h2>
<p>The roof of a single-storey or top-floor home gets the most sun of any surface. A white or light-coloured, heat-reflective coating on the roof slab can noticeably lower the temperature of the room below. India's residential energy code (Eco-Niwas Samhita) and cool-roof programmes in several cities encourage reflective roofs for this reason. Use a product designed for roofs, with waterproofing properties, applied over a clean, repaired surface.</p>
<?= img('white-cool-roof-coating-terrace', caption: 'A white heat-reflective coating on a terrace slab, reducing heat passing into the room below') ?>

<h2>Before you decide</h2>
<ul>
  <li>Look at large samples outdoors on two walls (one sunny, one shaded) at morning, noon and evening.</li>
  <li>Check the colour against fixed elements: roof tiles, stone, windows, the gate and the neighbours.</li>
  <li>Ask for the product's exterior performance claims in writing: dirt resistance, algae resistance and warranty years.</li>
  <li>For apartments, get the association's approval before changing balcony or façade colours.</li>
  <li>Plan the repaint cycle and keep the shade codes for touch-ups.</li>
</ul>
<?= img('exterior-colour-samples-on-sunny-and-shaded-walls', caption: 'Exterior colour samples painted on a sunny wall and a shaded wall, compared through the day') ?>

<h2>Terms explained</h2>
<dl class="terms">
  <dt>Solar reflectance</dt><dd>The share of the sun's energy, including infrared, that a surface reflects. Higher values mean a cooler surface.</dd>
  <dt>Chalking</dt><dd>A powdery surface on old paint caused by UV breaking down the binder; a sign the paint needs renewing.</dd>
  <dt>Dirt pick-up resistance</dt><dd>A paint's ability to stay clean by not holding on to dust; important in cities.</dd>
  <dt>Iron oxide pigments</dt><dd>Earth pigments (reds, browns, yellows) that are very light-fast and weather-resistant.</dd>
  <dt>Plinth band</dt><dd>A darker strip at the base of an exterior wall that hides rain splash and dirt.</dd>
</dl>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
