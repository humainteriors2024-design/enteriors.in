<?php
/* PILLAR PAGE — Doors & Partitions (/doors/)   ·   Phase 2, Oct 2026
   Target keyword: "door design for home" (+ "door design", "types of doors for home")
   Cluster links come from includes/nav.php → 'doors'.  Images: /assets/pages/doors/ */
$SIZES = [   // door => [clear opening (width × height), common shutter thickness, notes]
  'Main entrance'      => ['1000–1200 × 2100–2400 mm (3′3″–4′ × 7′–8′)', '35–45 mm', 'Wider for double doors; solid or solid-core only'],
  'Bedroom'            => ['900 × 2100 mm (3′ × 7′)', '30–35 mm', 'Wider (1000 mm) if furniture must pass or for wheelchair use'],
  'Bathroom / toilet'  => ['750 × 2100 mm (2′6″ × 7′)', '30–32 mm', 'Waterproof shutter (WPC, FRP or BWP-core)'],
  'Kitchen / utility'  => ['800–900 × 2100 mm', '30–35 mm', 'Often left open or a sliding/glazed door'],
  'Pooja room'         => ['600–1200 mm wide, height to suit', '18–30 mm', 'Jaali, glass or bell-hung shutters; often double'],
  'Balcony'            => ['900–2400 mm (sliding)', 'System-specific', 'uPVC or aluminium sliding with weather seals'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'doors',
  'title'        => 'Door Design for Home: Types, Materials, Sizes and Cost',
  'seo_title'    => 'Door Design for Home: Types, Materials & Sizes',
  'crumb'        => 'Doors & Partitions',
  'description'  => 'Door design for Indian homes: main, bedroom, bathroom, sliding and pooja doors; solid wood, flush, WPC and uPVC compared; sizes, hardware and cost.',
  'eyebrow'      => 'Design hub · pillar guide',
  'lede'         => 'Every door in a home has a different job. Here is how the type, the material and the hardware should follow that job, with standard sizes and indicative costs.',
  'hero_alt'     => 'Teak main door with brass handle and a matching frame in a Bangalore apartment',
  'published'    => '2026-10-04',
  'updated'      => '2026-10-04',
  'quick_answer' => 'Match the door to its job: a solid or solid-core main door 35–45 mm thick with a multi-point or good mortise lock; 30–35 mm flush or panel doors for bedrooms; waterproof WPC, FRP or BWP-core doors for bathrooms; and sliding doors or glass partitions where swing space is short. Standard Indian openings are about 1000–1200 mm for the main door, 900 mm for bedrooms and 750 mm for bathrooms, 2100 mm high. Budget the frame and hardware as carefully as the shutter.',
  'takeaways' => [
    'Typical openings: main door 1000–1200 mm, bedroom 900 mm, bathroom 750 mm wide; 2100 mm high.',
    'Main door: 35–45 mm solid or solid-core shutter, anchored frame, four hinges, multi-point or mortise lock.',
    'Bedrooms: 30–35 mm solid-core flush or panel doors; bathrooms: WPC or FRP that cannot swell.',
    'A weak frame ruins a good shutter: seasoned hardwood or steel, fixed plumb before plastering.',
    'Sliding doors and glass partitions save swing space but seal and insulate sound less well.',
  ],
  'sources' => [
    ['Bureau of Indian Standards: IS 2202 (Part 1)', 'https://www.bis.gov.in/', 'wooden flush door shutters, solid core type'],
    ['Bureau of Indian Standards: IS 4021', 'https://www.bis.gov.in/', 'timber door, window and ventilator frames'],
    ['National Building Code of India 2016', 'https://www.bis.gov.in/', 'door widths, escape routes and accessibility'],
    ['Bureau of Indian Standards: IS 2553 (Part 1)', 'https://www.bis.gov.in/', 'safety glass used in doors and partitions'],
  ],
  'faq' => [
    'How wide should a bedroom door be?' => 'About 900 mm (3 ft) clear for most bedrooms, which lets furniture through. Where a wheelchair or walker may be used, plan 1000 mm clear and a level threshold.',
    'What is the difference between a door frame and a door shutter?' => 'The frame (chaukhat) is the fixed surround built into the wall that carries the hinges and lock strike. The shutter is the moving door leaf. They are often priced separately.',
    'Which door is best for a bathroom?' => 'A WPC or FRP door in a WPC, stainless steel or sealed hardwood frame. These do not swell or rot when splashed. Keep the frame bottom off the wet floor.',
    'Which material is best for doors in India?' => 'For the main door, solid hardwood (teak, sal) or an engineered solid-core door with veneer. For bedrooms, a good solid-core flush door with veneer or laminate is stable and affordable. For bathrooms, WPC or FRP doors, which do not swell with water.',
    'What is the standard size of a door in India?' => 'Common clear openings are about 1000–1200 mm wide for the main door, 900 mm for bedrooms and 750 mm for bathrooms, all typically 2100 mm (7 ft) high. Frames add about 50–75 mm on each side. Always measure the actual opening before ordering.',
    'What is a flush door?' => 'A door with flat faces made from a core (solid timber blocks, particle board or a hollow frame) covered with plywood or veneer on both sides. Solid-core flush doors are strong, stable and the most common internal doors in Indian homes.',
    'Are WPC doors good?' => 'Yes, for bathrooms, utility areas and anywhere water is likely: they are waterproof and termite-proof and need no polishing. They are heavier than hollow doors and have fewer finish options; choose a solid WPC door and a WPC or stainless steel frame for wet areas.',
    'How much does a door cost in India?' => 'Indicatively, in Bengaluru (October 2026, before GST): a laminated solid-core flush door shutter costs about ₹6,000–15,000, a veneered one ₹9,000–22,000, a WPC bathroom door ₹6,000–14,000, and a solid teak main door ₹40,000–1.5 lakh or more. The frame, hardware, polish and fixing are extra.',
  ],
  'related' => [
    ['/wall-design/', 'Wall design guide', 'Panelling, texture and stone', 'Pillar guide'],
    ['/furniture/', 'Furniture design', 'Built-in and loose furniture', 'Pillar guide'],
    ['/materials/', 'Interior materials guide', 'Boards, finishes and stone', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Doors are opened tens of thousands of times over their life, carry security for the whole home and take moisture, sun and slamming. Yet they are often chosen from a catalogue photo at the end of a project. Enteriors treats a door as a small piece of engineering: a shutter, a frame and hardware that have to work together. This pillar sets out the types, materials and sizes, and links to detailed guides.</p>

<h2>Standard door sizes in Indian homes</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Door</th><th>Typical clear opening</th><th>Shutter thickness</th><th>Notes</th></tr></thead>
  <tbody>
<?php foreach ($SIZES as $d => [$size, $t, $note]): ?>
    <tr><td><?= e($d) ?></td><td><?= e($size) ?></td><td><?= e($t) ?></td><td><?= e($note) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Typical sizes; your building's openings may differ. Frames usually add 50–75 mm each side. More dimensions are in <a href="/planning/standard-interior-dimensions/">standard interior dimensions</a>.</p>

<h2>Door types by how they open</h2>
<ul>
  <li><strong>Hinged (swing) doors:</strong> the default; best seal and security. Need clear swing space equal to the door width.</li>
  <li><strong><a href="/doors/sliding-door-design/">Sliding doors</a>:</strong> save swing space; good for wardrobes, kitchens, balconies and room dividers. Seal and sound insulation are weaker.</li>
  <li><strong>Pocket doors:</strong> slide into the wall; neat but need a planned cavity.</li>
  <li><strong>Folding and bi-fold doors:</strong> for wide openings to balconies or between living and dining.</li>
  <li><strong>Pivot doors:</strong> large, dramatic main or feature doors on a floor and top pivot.</li>
</ul>

<h2>Door materials compared</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Material</th><th>Strengths</th><th>Weaknesses</th><th>Best for</th></tr></thead>
  <tbody>
    <tr><td>Solid hardwood (teak, sal, sheesham)</td><td>Strong, repairable, ages well</td><td>Expensive; can warp if poorly seasoned</td><td>Main doors, pooja doors</td></tr>
    <tr><td>Solid-core flush (veneer or laminate)</td><td>Stable, flat, affordable, many finishes</td><td>Edges need protection from water</td><td>Bedrooms, main doors (35–40 mm)</td></tr>
    <tr><td>Hollow-core flush</td><td>Light and cheap</td><td>Weak, poor sound insulation</td><td>Store rooms only</td></tr>
    <tr><td>Panel doors (moulded HDF or timber)</td><td>Classic look</td><td>Moulded HDF dislikes water</td><td>Bedrooms in traditional or transitional homes</td></tr>
    <tr><td>WPC / FRP</td><td>Waterproof, termite-proof</td><td>Heavier; limited looks</td><td>Bathrooms, utility</td></tr>
    <tr><td>uPVC / aluminium with glass</td><td>Weather-sealed, low upkeep</td><td>Not for security doors</td><td>Balcony, kitchen, partitions</td></tr>
    <tr><td>Steel and steel-wood security doors</td><td>High security, fire resistance options</td><td>Industrial look unless clad</td><td>Main doors, villas</td></tr>
  </tbody>
</table>
</div>
<p>The detailed comparison is in <a href="/doors/flush-vs-solid-wood-door/">flush door vs solid wood door</a>.</p>
<?= img('door-material-samples-teak-flush-wpc') ?>

<h2>Frames: the part people forget</h2>
<p>A good shutter in a weak frame sags, sticks and lets the lock slip. Main and bedroom frames are usually seasoned hardwood (sal or teak) around 100 × 60 mm; bathroom frames should be WPC, stainless steel or hardwood with the bottom sealed, kept off the wet floor. Frames should be fixed with hold-fasts or anchor bolts, plumb and square, before plastering and flooring finish around them.</p>

<h2>Hardware that matters</h2>
<ul>
  <li><strong>Hinges:</strong> three stainless steel or brass ball-bearing hinges per door; four on heavy main doors.</li>
  <li><strong>Locks:</strong> a mortise lock or multi-point lock on the main door, or a digital lock with a mechanical override; tubular or privacy locks inside.</li>
  <li><strong>Door closers and stoppers:</strong> stop handles hitting walls and wardrobes.</li>
  <li><strong>Seals and drop seals:</strong> reduce dust, sound and AC loss under the door.</li>
</ul>

<h2>Partitions</h2>
<p>Where you want separation without a solid wall, <a href="/doors/glass-partition-design/">glass partitions</a>, slatted wood screens and jaali panels divide a space while keeping light and air moving. They are common between living and dining areas, in studies and at the entrance.</p>

<h2>Detailed guides</h2>
<ul>
  <li><a href="/doors/main-door-design/">Main door design</a>: materials, security, sizes and style</li>
  <li><a href="/doors/flush-vs-solid-wood-door/">Flush door vs solid wood door</a>: construction, grades and cost</li>
  <li><a href="/doors/sliding-door-design/">Sliding door design</a>: systems, tracks and where they suit</li>
  <li><a href="/doors/pooja-room-door-design/">Pooja room door design</a>: jaali, glass and bells</li>
  <li><a href="/doors/glass-partition-design/">Glass partition design</a>: glass types, frames and safety</li>
</ul>
<h2>Indicative costs, door by door</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Door</th><th>Typical specification</th><th class="num">Shutter</th><th class="num">Frame + hardware + fitting</th></tr></thead>
  <tbody>
    <tr><td>Main door (flat)</td><td>40 mm engineered solid-core, teak veneer, PU</td><td class="num">₹25,000–70,000</td><td class="num">₹15,000–45,000</td></tr>
    <tr><td>Main door (villa, solid teak)</td><td>45 mm teak, carved or grooved</td><td class="num">₹60,000–1.5L+</td><td class="num">₹25,000–80,000</td></tr>
    <tr><td>Bedroom door</td><td>32 mm solid-core flush, laminate</td><td class="num">₹6,000–15,000</td><td class="num">₹6,000–14,000</td></tr>
    <tr><td>Bedroom door (veneer)</td><td>32 mm solid-core flush, veneer, PU</td><td class="num">₹9,000–22,000</td><td class="num">₹7,000–16,000</td></tr>
    <tr><td>Bathroom door</td><td>WPC solid door, WPC frame</td><td class="num">₹6,000–14,000</td><td class="num">₹4,000–9,000</td></tr>
    <tr><td>Kitchen sliding door</td><td>Aluminium frame, fluted glass, top-hung</td><td class="num">₹18,000–40,000</td><td class="num">Included in system</td></tr>
    <tr><td>Balcony sliding door</td><td>uPVC or aluminium, 2 panels, mesh</td><td class="num">₹700–1,400 per sq ft</td><td class="num">Included</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026, before GST. Digital locks, safety grille doors and carving add more.</p>
<?= img('bedroom-flush-door-laminate-with-matt-black-handle', caption: 'A 32 mm solid-core flush bedroom door in oak laminate with a matt black lever handle') ?>

<h2>Doors for Indian conditions</h2>
<ul>
  <li><strong>Monsoon humidity:</strong> doors swell and stick. Seal all six faces, leave 2–3 mm gaps, and use BWP-grade cores near bathrooms and balconies.</li>
  <li><strong>Termites:</strong> ground-floor homes and wooden frames in contact with masonry are at risk. Use treated timber or WPC frames, and anti-termite treatment before flooring.</li>
  <li><strong>Sun on villa entrances:</strong> south- and west-facing doors fade and crack; use a canopy or recess and a UV-resistant finish.</li>
  <li><strong>Dust:</strong> drop seals and brush seals keep dust out in cities and construction zones.</li>
  <li><strong>Wet bathroom floors:</strong> keep wooden frames off the floor with a stone or WPC base.</li>
</ul>

<h2>Accessible and safe doors</h2>
<p>Doors are also safety and accessibility features, especially in homes with elderly family members or young children.</p>
<ul>
  <li><strong>Clear width:</strong> at least 900 mm for main and bedroom doors, and ideally the bathroom used by an elderly person, so a walker or wheelchair passes.</li>
  <li><strong>Lever handles</strong> instead of knobs: easier for arthritic hands.</li>
  <li><strong>Level thresholds</strong> or bevelled ones of no more than about 12 mm, to avoid trips.</li>
  <li><strong>Bathroom doors that open outward</strong> or slide, so a person who falls inside does not block the door.</li>
  <li><strong>Finger guards and door stoppers</strong> where children play.</li>
</ul>
<?= img('accessible-bathroom-sliding-door-lever-handle', caption: 'An outward-sliding bathroom door with a lever handle and level threshold: safer for elderly family members') ?>

<h2>Ordering doors: the right sequence</h2>
<ol>
  <li><strong>Fix frames early</strong>, before plastering and flooring, set to the finished floor level.</li>
  <li><strong>Protect frames</strong> during construction with tape or covers.</li>
  <li><strong>Measure shutters after flooring</strong>, frame by frame; old buildings are rarely square.</li>
  <li><strong>Finish shutters</strong> (polish or laminate) before hanging, on all faces.</li>
  <li><strong>Hang and fit hardware last</strong>, after painting, to avoid damage.</li>
</ol>

<h2>Door hardware at a glance</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Item</th><th>Main door</th><th>Bedroom</th><th>Bathroom</th></tr></thead>
  <tbody>
    <tr><td>Hinges</td><td>4 heavy ball-bearing</td><td>3 ball-bearing</td><td>3 stainless steel</td></tr>
    <tr><td>Lock</td><td>Mortise deadbolt, multi-point or digital</td><td>Mortise or tubular with privacy</td><td>Privacy lock with outside release</td></tr>
    <tr><td>Handle</td><td>Pull handle or lever</td><td>Lever</td><td>Lever</td></tr>
    <tr><td>Extras</td><td>Viewer or video bell, closer, chain</td><td>Stopper</td><td>Drop seal (optional)</td></tr>
  </tbody>
</table>
</div>
<?= img('door-hardware-hinges-mortise-lock-lever', caption: 'Door hardware laid out: ball-bearing hinges, a mortise lock body and a lever handle') ?>

<h2>Terms explained</h2>
<dl class="terms">
  <dt>Chaukhat (door frame)</dt><dd>The fixed frame built into the wall that carries the shutter, hinges and lock strike.</dd>
  <dt>Shutter</dt><dd>The moving leaf of the door.</dd>
  <dt>Solid core</dt><dd>A flush door core of solid timber blocks or battens rather than a hollow frame.</dd>
  <dt>Lipping</dt><dd>Solid wood strips on the edges of a flush door that hide and protect the core.</dd>
  <dt>Mortise lock</dt><dd>A lock fitted into a pocket (mortise) cut in the door edge; stronger than a surface or tubular lock.</dd>
  <dt>Drop seal</dt><dd>A seal in the bottom of a door that drops to the floor when the door closes, blocking dust, light and sound.</dd>
  <dt>Manifestation</dt><dd>Markings on clear glass that make it visible, so nobody walks into it.</dd>
</dl>
<?= img('pivot-main-door-villa-entrance', caption: 'An oversized pivot main door at a villa entrance, sheltered by a deep canopy against sun and rain') ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
