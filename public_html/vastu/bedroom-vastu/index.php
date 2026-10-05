<?php
/* CLUSTER PAGE — Bedroom vastu (/vastu/bedroom-vastu/)
   Vastu pages describe tradition, not building rules or science (see /about/). */
$page = [
  'type'         => 'article',
  'title'        => 'Bedroom Vastu: Bed Direction, Wardrobe Placement and Colours',
  'seo_title'    => 'Bedroom Vastu Tips: Bed and Wardrobe',
  'crumb'        => 'Bedroom Vastu',
  'description'  => 'Bedroom vastu made simple: master bedroom direction, sleeping direction, where the bed, wardrobe, mirror and TV go, colours, and easy fixes for flats.',
  'eyebrow'      => 'Vastu',
  'lede'         => 'The bedroom vastu preferences families ask about most, and how to apply them with furniture placement rather than building work.',
  'hero_alt'     => 'Bedroom plan with the bed head on the south wall and the wardrobe on the south-west',
  'published'    => '2026-10-05',
  'updated'      => '2026-10-05',
  'quick_answer' => 'Vastu tradition places the master bedroom in the south-west of the home, with the head of the bed towards the south (or east), the wardrobe and heavy storage on the south or west wall, and the north-east corner of the room kept light. Mirrors facing the bed are traditionally avoided. In flats, most of this is achieved by where the bed and wardrobe go.',
  'takeaways'    => [
    'Master bedroom: south-west traditionally; children\'s and guest rooms west or north-west.',
    'Sleep with the head towards the south or east; north is traditionally avoided.',
    'Wardrobes and heavy furniture on the south or west walls.',
    'No mirror facing the bed; cover or move a mirrored wardrobe shutter if needed.',
  ],
  'faq' => [
    'Which direction should the bed face as per vastu?' => 'Vastu tradition prefers the head of the bed towards the south, with east as the alternative, so that you sleep with your head to the south or east. Sleeping with the head to the north is traditionally avoided.',
    'Where should the wardrobe be placed in a bedroom?' => 'Along the south or west wall, or in the south-west corner, where vastu tradition places heavy furniture. Keep the north-east corner light.',
    'Is a mirror opposite the bed bad as per vastu?' => 'Vastu tradition avoids a mirror that reflects the bed. If a mirrored wardrobe shutter faces the bed, it can be moved to an inside door or covered at night.',
    'What colours are good for a bedroom as per vastu?' => 'Soft, warm and earthy colours such as beige, light pink, peach, light brown and soft green are traditionally preferred for bedrooms, with very dark or very bright colours avoided.',
  ],
  'related' => [
    ['/vastu/', 'Home vastu guide', 'Room-by-room vastu for flats and houses', 'Pillar guide'],
    ['/rooms/master-bedroom/', 'Master bedroom design', 'Layouts, wardrobes and lighting', 'Rooms'],
    ['/wardrobe/', 'Wardrobe design guide', 'Types, sizes and cost', 'Wardrobes'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>After the kitchen and the pooja room, the bedroom is where families most often ask about vastu, mainly about which way to sleep and where the wardrobe should go. This page sets out the most widely repeated preferences and how to apply them in a flat. It is part of our <a href="/vastu/">home vastu guide</a>.</p>
<div class="callout"><span class="callout__title">Tradition, not a building rule</span>Vastu guidance describes traditional preferences, not building-code requirements, and is not offered as science or a promise of any result. Comfort, ventilation and safe clearances come first.</div>

<h2>Which bedroom goes where</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Bedroom</th><th>Traditional zone</th></tr></thead>
  <tbody>
    <tr><td>Master bedroom</td><td>South-west</td></tr>
    <tr><td>Children's bedroom</td><td>West or north-west; east also accepted</td></tr>
    <tr><td>Guest bedroom</td><td>North-west</td></tr>
    <tr><td>Avoid</td><td>A bedroom in the north-east or south-east is traditionally less preferred</td></tr>
  </tbody>
</table>
</div>

<h2>Arranging the room</h2>
<?= img('bedroom-vastu-layout-plan', caption: 'Bedroom arranged to vastu preferences: bed head on the south wall, wardrobe on the west, north-east corner kept light') ?>
<div class="table-wrap">
<table>
  <thead><tr><th>Element</th><th>Traditional placement</th><th>Practical note</th></tr></thead>
  <tbody>
    <tr><td>Bed</td><td>Head towards the south (or east)</td><td>Keep 2–2.5 ft clear on each side</td></tr>
    <tr><td>Wardrobe</td><td>South or west wall; south-west corner</td><td>Needs about 3 ft clear in front for hinged doors</td></tr>
    <tr><td>Dresser and mirror</td><td>Not facing the bed</td><td>A pull-out mirror inside the wardrobe solves this</td></tr>
    <tr><td>TV</td><td>South-east, if at all</td><td>Many families keep it out of the bedroom</td></tr>
    <tr><td>Study table</td><td>Facing east or north</td><td>Window to the side for glare-free light</td></tr>
    <tr><td>North-east corner</td><td>Kept light and open</td><td>A plant or a low chair rather than storage</td></tr>
  </tbody>
</table>
</div>

<h2>Wardrobes and mirrors</h2>
<p>Vastu tradition places wardrobes against the south or west wall, which suits most bedrooms because those walls are often solid. If the only free wall is north or east, keep the wardrobe lighter in colour. A mirrored shutter facing the bed is traditionally avoided; put the mirror on an inside door or use a pull-out mirror. Wardrobe types are compared in the <a href="/wardrobe/">wardrobe design guide</a>.</p>

<h2>Colours and lighting</h2>
<p>Soft, warm colours are traditionally preferred: beige, peach, light pink, light brown and soft green. Warm white light (about 3,000 K) and dimmable bedside lights suit rest. Colour pairings are in <a href="/colour/bedroom-colour-combination/">bedroom colour combinations</a>.</p>

<h2>What you can do in a flat</h2>
<ol>
  <li>Turn the bed so the head is to the south or east, if the room allows a 2 ft clearance on both sides.</li>
  <li>Put the wardrobe on the south or west wall.</li>
  <li>Move or cover any mirror facing the bed.</li>
  <li>Keep the north-east corner free of heavy furniture.</li>
</ol>
<p>Room planning is covered in <a href="/rooms/master-bedroom/">master bedroom design</a> and <a href="/planning/furniture-layout/">furniture layout</a>.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
