<?php
/* CLUSTER PAGE — /colour/paint-finishes/   ·   Phase 2, Oct 2026
   Target keyword: "types of wall paint finishes" (+ "emulsion vs distemper", "matt vs satin paint")
   Images: /assets/pages/colour/paint-finishes/ */
$page = [
  'type'         => 'article',
  'title'        => 'Types of Paint Finish: Sheen, Emulsion, Enamel and Distemper',
  'seo_title'    => 'Types of Wall Paint Finishes Explained',
  'crumb'        => 'Paint Finishes',
  'description'  => 'Wall paint finishes explained: matt, eggshell, satin and gloss sheen; emulsion, distemper and enamel; coverage, VOC and where each belongs.',
  'eyebrow'      => 'Paint science',
  'lede'         => 'What sheen does, how paint types differ, how much paint a room needs and which finish belongs on which surface.',
  'hero_alt'     => 'Painted boards showing matt, eggshell, satin and gloss sheen under the same light',
  'published'    => '2026-10-04',
  'updated'      => '2026-10-04',
  'quick_answer' => 'Sheen is how much light a dried paint reflects. Matt hides wall flaws but marks more easily; eggshell and satin wipe clean; semi-gloss and gloss are hardest-wearing and belong on doors, trims and grilles. For walls, a water-based acrylic emulsion is the standard in Indian homes; distemper is a cheaper, less washable option; enamel is for wood and metal. Most emulsions cover roughly 100–140 sq ft per litre per coat, and two coats over primer is normal.',
  'takeaways' => [
    'Sheen = how much light dried paint reflects: matt hides flaws, satin wipes clean, gloss is for wood and metal.',
    'Water-based acrylic emulsion is the standard wall paint; distemper is cheaper but not washable.',
    'Coverage is typically 100–140 sq ft per litre per coat; plan two coats over primer.',
    'Paint fails from the bottom up: alkali-resistant primer on new plaster is not optional.',
    'Choose low-VOC paints for bedrooms and air rooms well while paint cures.',
  ],
  'sources' => [
    ['Bureau of Indian Standards: IS 15489 (acrylic emulsion paint) and IS 2395 (painting plaster surfaces)', 'https://www.bis.gov.in/', 'Indian Standards for emulsion paints and their application'],
    ['US EPA: VOCs and indoor air quality', 'https://www.epa.gov/indoor-air-quality-iaq/volatile-organic-compounds-impact-indoor-air-quality', 'why low-VOC paint and ventilation matter'],
    ['ASTM D523: Specular gloss', 'https://www.astm.org/', 'how sheen is measured in gloss units'],
  ],
  'faq' => [
    'Which sheen is best for a ceiling?' => 'Flat matt. It hides the joints of gypsum boards and slight unevenness, and it does not reflect light fittings. Use a ceiling-specific emulsion in a white that matches the walls\' undertone.',
    'Does a higher price mean better paint?' => 'Usually more binder and better pigment, which means better coverage, washability and colour retention. Compare data sheets: coverage per litre, washability and VOC content tell you more than the brand tier.',
    'Can I paint over an old distemper wall with emulsion?' => 'Not directly. Distemper is chalky and stops emulsion bonding. Scrape and wash it off, sand, apply a primer, and then emulsion. Painting over it causes flaking within months.',
    'How long should paint dry between coats?' => 'Usually 2–4 hours for water-based emulsions in normal weather, longer in humid monsoon conditions. Check the data sheet, and allow putty and primer to dry fully first.',
    'Which paint finish is easiest to clean?' => 'Satin and semi-gloss clean most easily. Among wall finishes, a washable matt or eggshell is a good balance: it looks soft but tolerates wiping.',
    'Which paint finish is best for interior walls?' => 'A washable matt or eggshell emulsion for living rooms and bedrooms. It looks soft, hides small flaws and can be wiped. Use satin in kitchens, kids\' rooms and passages that need more scrubbing, and keep gloss for woodwork and metal.',
    'What is the difference between emulsion and distemper?' => 'Emulsion is an acrylic, water-based paint that forms a tough, washable film and lasts years. Distemper is a cheaper paint based on chalk and a weaker binder; it looks flat, rubs off when cleaned and needs repainting sooner. Emulsion is worth the extra cost in most homes.',
    'Is enamel paint good for walls?' => 'Not for main walls. Enamel (oil- or alkyd-based) dries hard and glossy, yellows over time and has strong solvent fumes. It is meant for doors, windows, grilles and metal. Water-based enamels exist for lower-odour work on wood and metal.',
    'How much paint do I need for a room?' => 'Work out the wall area (perimeter × height, minus doors and large windows), multiply by the number of coats, and divide by the coverage on the tin, typically 100–140 sq ft per litre for emulsion. A 12 × 12 ft room with a 10 ft ceiling has about 480 sq ft of walls, so two coats need roughly 7–10 litres.',
    'What are low-VOC paints?' => 'Paints that release fewer volatile organic compounds as they dry, so there is less smell and better indoor air. Most premium water-based emulsions are now low-VOC; ask for the VOC figure (in grams per litre) on the data sheet and air rooms well for a few days after painting.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Two walls painted in exactly the same colour can look completely different if one is matt and the other satin. The finish changes how colour reads, how flaws show and how well the wall survives cleaning. This is the technical side of the <a href="/colour/">colour guide</a>: what paint is made of, what the labels mean and what to specify for each surface.</p>

<h2>What paint is made of</h2>
<ul>
  <li><strong>Pigment</strong> gives colour and hiding power (titanium dioxide for white and opacity).</li>
  <li><strong>Binder</strong> (usually acrylic resin in emulsions) holds the pigment to the wall; more and better binder means a tougher, more washable film.</li>
  <li><strong>Extenders</strong> (fillers) add body and reduce cost; too much makes paint chalky and weak.</li>
  <li><strong>Solvent or water</strong> carries everything and evaporates. Water-based paints have less odour and lower VOCs.</li>
  <li><strong>Additives</strong> add mould resistance, flow, washability or dirt resistance.</li>
</ul>

<h2>Sheen levels compared</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Sheen</th><th>Look</th><th>Hides wall flaws</th><th>Washability</th><th>Best for</th></tr></thead>
  <tbody>
    <tr><td>Flat / matt</td><td>No shine; colour looks deepest</td><td>Best</td><td>Low to moderate (washable matt is better)</td><td>Ceilings, bedrooms, living-room walls</td></tr>
    <tr><td>Eggshell / low sheen</td><td>Faint soft glow</td><td>Good</td><td>Good</td><td>Living rooms, bedrooms with children</td></tr>
    <tr><td>Satin / soft sheen</td><td>Pearl-like</td><td>Moderate</td><td>Very good</td><td>Kitchens, passages, kids' rooms, bathrooms</td></tr>
    <tr><td>Semi-gloss</td><td>Clearly shiny</td><td>Poor</td><td>Excellent</td><td>Doors, frames, skirting</td></tr>
    <tr><td>Gloss / high gloss</td><td>Mirror-like</td><td>Very poor</td><td>Excellent</td><td>Grilles, railings, furniture details</td></tr>
  </tbody>
</table>
</div>
<?= img('paint-sheen-comparison-boards') ?>

<h2>Paint types used in Indian homes</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Type</th><th>Base</th><th>Where</th><th>Notes</th></tr></thead>
  <tbody>
    <tr><td>Interior acrylic emulsion</td><td>Water</td><td>All interior walls and ceilings</td><td>Standard choice; premium ranges are washable and low-VOC</td></tr>
    <tr><td>Distemper (dry or oil-bound)</td><td>Water / chalk</td><td>Low-budget walls, rentals</td><td>Flat, not washable, shorter life</td></tr>
    <tr><td>Enamel (alkyd or water-based)</td><td>Solvent or water</td><td>Doors, windows, grilles, metal</td><td>Hard and glossy; solvent enamels yellow and smell</td></tr>
    <tr><td>Exterior emulsion / elastomeric</td><td>Water</td><td>Outer walls</td><td>UV, rain and algae resistance; see <a href="/colour/exterior-house-colour/">exterior colours</a></td></tr>
    <tr><td>Texture and specialty finishes</td><td>Water / mineral</td><td>Feature walls</td><td>See <a href="/wall-design/texture-paint/">texture paint</a></td></tr>
    <tr><td>Wood finishes (PU, melamine, lacquer)</td><td>Solvent or water</td><td>Furniture, doors, veneer</td><td>See <a href="/materials/pu-finish/">PU finish</a></td></tr>
  </tbody>
</table>
</div>

<h2>Working out quantities</h2>
<ol>
  <li>Wall area = (sum of wall widths) × height. Subtract doors (about 20 sq ft each) and large windows.</li>
  <li>Multiply by the number of coats (two for a repaint, sometimes three for a big colour change).</li>
  <li>Divide by the coverage printed on the tin, usually 100–140 sq ft per litre per coat for emulsion on a smooth, primed wall. Rough or porous walls take more.</li>
  <li>Add 10% and keep the leftover, labelled with the shade code, for touch-ups.</li>
</ol>
<div class="callout"><span class="callout__title">Example</span>A 12 × 14 ft room with a 10 ft ceiling: walls = (12 + 14 + 12 + 14) × 10 = 520 sq ft, minus one door (20) = 500 sq ft. Two coats = 1,000 sq ft. At 120 sq ft per litre, about 8.5 litres; buy 10.</div>

<h2>The system matters more than the top coat</h2>
<p>Paint fails from the bottom up. On new plaster, let it cure, then apply an alkali-resistant primer; fill and sand with wall putty; prime again; then two finish coats. On repaints, wash, scrape loose paint and spot-prime. Skipping primer on fresh plaster is the commonest cause of patchy colour and peeling within a year.</p>

<h2>Health and indoor air</h2>
<p>Choose water-based, low-VOC emulsions for living spaces and keep solvent enamels for small areas with good ventilation. Paint bedrooms a few days before you move back in, and keep windows open while the paint cures. Colour choices for each room are in <a href="/colour/bedroom-colour-combination/">bedroom</a> and <a href="/colour/living-room-colour-combination/">living room colour combinations</a>.</p>
<h2>Which finish for which surface</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Surface</th><th>Paint</th><th>Sheen</th><th>Why</th></tr></thead>
  <tbody>
    <tr><td>Living and bedroom walls</td><td>Premium acrylic emulsion</td><td>Washable matt / eggshell</td><td>Soft look, hides flaws, can be wiped</td></tr>
    <tr><td>Ceilings</td><td>Ceiling emulsion</td><td>Flat matt</td><td>No glare, hides board joints</td></tr>
    <tr><td>Kitchen walls (outside the splash zone)</td><td>Washable emulsion</td><td>Satin</td><td>Grease and steam clean off</td></tr>
    <tr><td>Bathrooms (above tiles)</td><td>Anti-fungal emulsion</td><td>Satin</td><td>Moisture and mould resistance</td></tr>
    <tr><td>Kids' rooms, passages</td><td>Scrubbable emulsion</td><td>Eggshell / satin</td><td>Survives scrubbing of marks</td></tr>
    <tr><td>Wooden doors and frames</td><td>PU, melamine or water-based enamel</td><td>Satin / semi-gloss</td><td>Hard-wearing, wipeable</td></tr>
    <tr><td>Metal grilles and railings</td><td>Anti-corrosive primer + enamel</td><td>Gloss</td><td>Sheds water, resists rust</td></tr>
    <tr><td>Exterior walls</td><td>Exterior emulsion / elastomeric</td><td>Low sheen</td><td>UV, rain, algae resistance</td></tr>
  </tbody>
</table>
</div>
<?= img('satin-paint-kitchen-wall-wiped-clean', caption: 'A satin-finish kitchen wall being wiped clean: higher sheen means easier cleaning') ?>

<h2>Worked example: repainting a 2 BHK</h2>
<p>A 2 BHK of about 950 sq ft carpet area typically has 3,000–3,500 sq ft of wall and ceiling area to paint.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Item</th><th>Quantity</th><th class="num">Indicative cost</th></tr></thead>
  <tbody>
    <tr><td>Interior emulsion, two coats</td><td>About 50–65 litres</td><td class="num">Material included in rate</td></tr>
    <tr><td>Repaint with premium emulsion (touch-up putty, primer where needed)</td><td>3,000–3,500 sq ft</td><td class="num">₹55,000–1 lakh</td></tr>
    <tr><td>Fresh painting with two coats of putty</td><td>3,000–3,500 sq ft</td><td class="num">₹80,000–1.4 lakh</td></tr>
    <tr><td>Doors and grilles in enamel</td><td>Per house</td><td class="num">₹8,000–20,000</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru rates, October 2026, including labour and material, before GST. Roughly ₹18–30 per sq ft for a repaint and ₹25–40 for fresh work with putty.</p>

<h2>Wall putty, primer and the painting system</h2>
<ol>
  <li><strong>Cure</strong> new plaster for several weeks; test it is dry.</li>
  <li><strong>Alkali-resistant primer</strong> on fresh plaster; it stops the cement's alkalis attacking the paint.</li>
  <li><strong>Wall putty,</strong> one or two thin coats, sanded smooth; acrylic putty for interiors, cement-based on damp-prone walls.</li>
  <li><strong>Interior primer</strong> over the putty, so the finish coat absorbs evenly.</li>
  <li><strong>Two finish coats</strong> of emulsion, each allowed to dry.</li>
</ol>
<p>On a repaint of sound paint, wash, sand lightly, fill cracks, spot-prime, and apply two coats.</p>
<?= img('wall-putty-sanding-before-primer', caption: 'Sanding wall putty smooth before primer: the stage that decides how flat the final wall looks') ?>

<h2>Paint problems and their causes</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Problem</th><th>Usual cause</th><th>Fix</th></tr></thead>
  <tbody>
    <tr><td>Patchy colour (flashing)</td><td>No primer on fresh or patched plaster</td><td>Spot-prime, then repaint the whole wall</td></tr>
    <tr><td>Peeling and blistering</td><td>Damp in the wall, or painting over distemper</td><td>Fix damp; strip; prime; repaint</td></tr>
    <tr><td>Efflorescence (white salts)</td><td>Water moving through masonry</td><td>Fix water source; brush off; alkali-resistant primer</td></tr>
    <tr><td>Mould spots</td><td>Humidity and poor ventilation</td><td>Fungicidal wash; anti-fungal paint; ventilation</td></tr>
    <tr><td>Cracks</td><td>Plaster movement or structural cracks</td><td>Crack filler or mesh; structural cracks need an engineer</td></tr>
    <tr><td>Yellowing of enamel</td><td>Solvent alkyd enamel ageing, little light</td><td>Use water-based or PU finishes</td></tr>
  </tbody>
</table>
</div>
<?= img('paint-blistering-from-damp-wall', caption: 'Blistering paint on a wall shared with a bathroom: the cause is damp, not the paint') ?>

<h2>Before you decide</h2>
<ul>
  <li>What does the wall need to survive: hands, steam, scrubbing, sun?</li>
  <li>How flat is the wall? Higher sheens show every ripple.</li>
  <li>Is the plaster new (needs curing and alkali-resistant primer) or previously painted?</li>
  <li>Is the paint water-based and low-VOC for bedrooms?</li>
  <li>Does the quote name the full system: putty, primer, finish, number of coats?</li>
</ul>
<p>Write the finish into your colour schedule with the shade code: "Warm white, washable matt, living and bedrooms; satin, kitchen and bathrooms; semi-gloss, doors". Painters then cannot substitute a cheaper finish without it being obvious.</p>
<?= img('paint-system-cans-putty-primer-emulsion', caption: 'A complete painting system: wall putty, primer and finish emulsion from one range') ?>

<h2>Terms explained</h2>
<dl class="terms">
  <dt>Sheen</dt><dd>The gloss level of dried paint, measured in gloss units at a set angle.</dd>
  <dt>Binder</dt><dd>The resin that holds pigment together and to the wall; it decides washability and durability.</dd>
  <dt>Emulsion</dt><dd>A water-based paint in which binder particles are dispersed in water; dries to a flexible film.</dd>
  <dt>Distemper</dt><dd>A low-cost paint based on chalk and a weak binder; not washable.</dd>
  <dt>Enamel</dt><dd>A hard, glossy paint for wood and metal, solvent- or water-based.</dd>
  <dt>Wall putty</dt><dd>A fine filler applied in thin coats to make plaster smooth before painting.</dd>
  <dt>VOC</dt><dd>Volatile organic compounds that evaporate as paint dries; lower is better for indoor air.</dd>
</dl>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
