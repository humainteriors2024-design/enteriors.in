<?php
/* PILLAR PAGE — Vastu (/vastu/)
   Cluster links ("In this guide") come from includes/nav.php → 'vastu'.
   Images: /assets/pages/vastu/   (hero.jpg = main image)
   Framing: vastu is presented as traditional guidance that families may choose to follow —
   never as science, a guarantee or a building rule. Keep that wording when editing.
   The room-by-room summary is in $QUICK so it is edited in one place. */
$QUICK = [   // room or item => [traditionally preferred direction, practical alternative]
  'Main entrance'  => ['North, east or north-east', 'Fixed in a flat; keep it well lit and uncluttered'],
  'Living room'    => ['North, east or north-east', 'Any position, with heavy furniture on south and west walls'],
  'Kitchen'        => ['South-east', 'North-west'],
  'Hob'            => ['South-east of the kitchen, cook facing east', 'Where the gas line and chimney duct safely allow'],
  'Sink and water' => ['North or north-east of the kitchen', 'Anywhere with counter between sink and hob'],
  'Master bedroom' => ['South-west', 'Any bedroom, head towards the south or east'],
  'Wardrobes'      => ['South and west walls', 'The longest wall that does not block a window'],
  'Pooja room'     => ['North-east', 'A compact unit on an east or north wall'],
  'Study desk'     => ['Facing east or north', 'Where daylight falls from the side'],
  'Toilets'        => ['Avoided in the north-east', 'Fixed in a flat; keep clean and ventilated'],
];
$page = [
  'type'         => 'pillar',
  'pillar'       => 'vastu',
  'title'        => 'Home Vastu Tips: A Practical Room-by-Room Guide',
  'seo_title'    => 'Home Vastu Tips: Room-by-Room Guide',
  'crumb'        => 'Vastu',
  'description'  => 'Home vastu tips explained room by room: traditional directions for the main door, kitchen, bedroom and pooja room, and what an apartment can adopt.',
  'eyebrow'      => 'Pillar guide',
  'lede'         => 'The traditional vastu preference for each room, stated plainly, with what a flat owner can realistically apply and what the builder has already fixed.',
  'hero_alt'     => 'Bright apartment living room with a compact wooden pooja unit and a brass lamp in one corner',
  'published'    => '2026-10-03',
  'updated'      => '2026-10-03',
  'quick_answer' => 'Vastu shastra is a traditional Indian system of guidance on how a home is oriented and arranged. The most widely followed preferences are a main door in the north, east or north-east, the kitchen in the south-east, the master bedroom in the south-west and the pooja room in the north-east. These are customs rather than building rules, and most apartments can follow only some of them.',
  'faq' => [
    'What are the most widely followed home vastu tips?' => 'Four placements are repeated most often: the main entrance in the north, east or north-east, the kitchen in the south-east, the master bedroom in the south-west and the pooja room in the north-east. Tradition also keeps the north-east light and uncluttered and puts heavier storage on the south and west walls. Families choose which of these to follow.',
    'Which direction should the main door face as per vastu?' => 'Vastu tradition prefers a main door in the north, east or north-east. The facing is read by standing inside the door and looking out. In an apartment the door cannot be moved, so the usual approach is to keep the entrance well lit, clean and free of clutter.',
    'What if my kitchen is not in the south-east?' => 'The north-west is the usual traditional alternative. In a flat the kitchen cannot be relocated, so many families simply position the hob so that the cook faces east, where the gas line and chimney duct allow it. There is no need to rebuild a kitchen for this.',
    'Which direction should the head point while sleeping?' => 'Vastu tradition prefers sleeping with the head towards the south or the east, and avoids the head pointing north. This is a custom, not a medical recommendation. If the room allows only one sensible bed position, comfort and clear walking space decide.',
    'Where should the pooja room be in a flat?' => 'The north-east is the traditional place. Where there is no separate room there, a compact pooja unit in the north-east part of the living or dining room is the common answer, with an east or north wall as the second choice. Keep the space light, clean and uncluttered.',
    'Is vastu compulsory or scientifically proven?' => 'No. Vastu shastra is a traditional body of design guidance that families follow as a matter of custom and belief; it is not part of any building code. This guide does not present it as science or promise any result from following it.',
  ],
  'related' => [   // sibling pillar guides
    ['/rooms/', 'Room-by-room interior guides', 'Layouts, storage and materials for each room', 'Pillar guide'],
    ['/modular-kitchen/', 'Modular kitchen design guide', 'Layouts, materials, hardware and cost', 'Pillar guide'],
    ['/planning/', 'Home interior planning', 'Checklists, electricals, lighting and budget', 'Pillar guide'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Many Indian families like their home to follow vastu, yet most live in apartments whose plan was fixed before they saw it. This guide sets out the most widely followed home vastu tips room by room, says plainly which ones a flat owner can apply, and links to a detailed page for each room.</p>

<h2>What vastu is and how to use this guide</h2>
<p>Vastu shastra is a traditional Indian system of guidance on how a building is oriented and how its rooms are arranged. It relates each part of a home to a compass direction and to one of five elements. Families follow it to different degrees: some look only at the main door and the pooja room, others like every room checked.</p>
<div class="callout"><span class="callout__title">Tradition, not a building rule</span>Vastu guidelines are traditional preferences, not building-code requirements, and they are not offered here as science or as a promise of any result. Safety, ventilation, daylight and a practical layout come first. Most apartments cannot satisfy every guideline, and a home that follows only a few of them is still a perfectly good home.</div>
<p>Use this page as a list of preferences, not a test to be passed. Find the directions of your home, then note what already matches, what furniture can adjust and what is fixed.</p>

<h2>The five elements and eight directions</h2>
<p>Vastu tradition describes five elements: earth (prithvi), water (jal), fire (agni), air (vayu) and space (akasha). Four are linked to the corners of a home and the fifth to its centre. Together with the four main directions, the corners give eight zones.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Direction</th><th>Traditional association</th><th>Rooms traditionally placed there</th></tr></thead>
  <tbody>
    <tr><td>North</td><td>A lighter, more open side</td><td>Living room, main entrance, study</td></tr>
    <tr><td>North-east (Ishanya)</td><td>Water; kept light and uncluttered</td><td>Pooja room, main entrance, living room</td></tr>
    <tr><td>East</td><td>The sunrise side; lighter and more open</td><td>Main entrance, living room, study</td></tr>
    <tr><td>South-east (Agneya)</td><td>Fire</td><td>Kitchen</td></tr>
    <tr><td>South</td><td>A heavier, more enclosed side</td><td>Bedrooms, wardrobes, heavy storage</td></tr>
    <tr><td>South-west (Nairutya)</td><td>Earth</td><td>Master bedroom, heavy furniture</td></tr>
    <tr><td>West</td><td>A heavier, more enclosed side</td><td>Wardrobes and storage, other bedrooms</td></tr>
    <tr><td>North-west (Vayavya)</td><td>Air</td><td>Guest bedroom; the usual alternative for the kitchen</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">The centre of the home is linked with space and is traditionally kept open. Associations vary between regions and practitioners; only the most widely repeated are listed.</p>
<p>In short, the north and east sides are traditionally kept lighter and more open, the south and west carry the heavier rooms and storage, and toilets are traditionally avoided in the north-east.</p>

<h2>How to find the directions of your flat</h2>
<p>Every vastu tip for a house or flat depends on knowing where north is, so measure it instead of guessing from the morning sun.</p>
<ol class="steps">
  <li><strong>Start with the floor plan</strong>Builder plans usually carry a north arrow. Confirm it on site, because brochure plans are sometimes mirrored.</li>
  <li><strong>Stand at the centre of the home</strong>Open a compass app and hold the phone flat, away from the refrigerator and other large metal objects that can disturb the reading.</li>
  <li><strong>Check it twice</strong>Repeat the reading a few steps away. If the two differ noticeably, recalibrate and try again.</li>
  <li><strong>Mark north on the plan</strong>Draw the arrow on a printed plan and divide the plan into a three-by-three grid, so that each room reads as north-east, south-west and so on.</li>
</ol>
<p>By convention, a home faces the direction you look towards when you stand inside the main door looking out. Give the marked plan to your designer at the first meeting.</p>

<h2>Main door and entrance</h2>
<p>Vastu tradition prefers a main entrance in the north, east or north-east. In an apartment the door is where the corridor puts it, so attention shifts to how the entrance is kept: well lit, with a door that opens fully, footwear in a closed cabinet to one side, and a clean, uncluttered landing.</p>
<p>None of this needs building work. Door facing is covered in <a href="/vastu/main-door-vastu/">main door vastu</a>, and storage ideas in the <a href="/rooms/foyer-entrance/">foyer and entrance guide</a>.</p>

<h2>Living room</h2>
<p>The living room is traditionally placed in the north, east or north-east, the same lighter side as the entrance. Where it sits elsewhere, the usual approach is to arrange it in the same spirit:</p>
<ul>
  <li>Place the sofa, TV unit and bookcases towards the south and west walls.</li>
  <li>Keep the north and east sides more open, with lighter furniture and uncovered windows where privacy allows.</li>
  <li>Leave the north-east corner of the room free of tall or heavy pieces.</li>
</ul>
<p>Then check everyday use: the TV should not sit opposite a window that throws glare on the screen, and walkways should stay about 3 ft wide. See the <a href="/rooms/living-room/">living room guide</a> and <a href="/planning/furniture-layout/">furniture layout planning</a>.</p>

<h2>Kitchen: hob and sink placement</h2>
<p>The south-east corner, Agneya, is associated with fire, so vastu tradition places the kitchen there. The north-west is the usual alternative. Inside the kitchen, three preferences are repeated most often:</p>
<ul>
  <li><strong>Hob:</strong> towards the south-east part of the kitchen, so that the cook faces east.</li>
  <li><strong>Sink and water:</strong> the sink and stored water towards the north or north-east, kept apart from the hob. A stretch of counter between the two is sound kitchen planning in any case.</li>
  <li><strong>Heavy storage:</strong> tall units and grain storage towards the south and west walls.</li>
</ul>
<div class="callout callout--warn"><span class="callout__title">Services decide first</span>The gas line, the chimney duct, the window and the drain fix where a hob and sink can safely go. Do not give up a short chimney duct or a safe gas connection to gain a direction.</div>
<p>An apartment kitchen cannot be moved, but a hob can often be shifted along the counter at the design stage. See <a href="/vastu/kitchen-vastu/">kitchen vastu</a> for the detail, and the <a href="/modular-kitchen/">modular kitchen design guide</a> for layouts.</p>

<h2>Bedrooms and the study</h2>
<p>The master bedroom is traditionally placed in the south-west, the zone associated with earth. Other bedrooms commonly fall on the south and west sides, with the north-west often used for a guest room.</p>
<h3>Bed and wardrobe placement</h3>
<p>The preference families follow most is the sleeping direction: head towards the south or the east, and not towards the north. This depends on the bed, not the room, so it can be applied in any bedroom with two usable bed walls.</p>
<p>Wardrobes and other heavy storage are traditionally placed on the south or west walls. Decide the bed wall first, then give the wardrobe the longest remaining south or west wall that does not block a window. The <a href="/wardrobe/">wardrobe design guide</a> covers sizes and internals; room-wise detail is in <a href="/vastu/bedroom-vastu/">bedroom vastu</a> and the <a href="/rooms/master-bedroom/">master bedroom design guide</a>.</p>
<h3>Study and work desk</h3>
<p>A study desk is traditionally arranged so that the person faces east or north. Balance this with daylight, which is most comfortable from the side of the desk. See the <a href="/rooms/study-home-office/">study and home office guide</a>.</p>

<h2>Pooja room</h2>
<p>The north-east, Ishanya, is the traditional place for the pooja room, and it is kept light, clean and uncluttered. The space is usually arranged so that the person praying faces east or north.</p>
<p>Few apartments have a separate room in that corner. A compact unit in the north-east part of the living or dining room is the common answer, with an east or north wall elsewhere as the second choice. Plan it safely: a stone or tile surface under the lamp, clearance above the flame and no curtains nearby.</p>
<p>Placement is covered in <a href="/vastu/pooja-room-vastu/">pooja room vastu</a>, and materials, doors and lighting in <a href="/rooms/pooja-room/">pooja room designs</a>.</p>

<h2>Colours and materials by direction</h2>
<p>Colour is the least settled part of vastu for home interiors. Charts differ between practitioners, so read the table as commonly repeated suggestions, not rules.</p>
<div class="table-wrap">
<table>
  <thead><tr><th>Zone</th><th>Colours often suggested</th><th>A sensible way to use them</th></tr></thead>
  <tbody>
    <tr><td>North and east</td><td>Whites, creams, light greens and blues</td><td>Wall colours that keep rooms bright</td></tr>
    <tr><td>North-east</td><td>White, cream, pale yellow</td><td>A plain backdrop for the pooja unit</td></tr>
    <tr><td>South-east</td><td>Warm tones such as orange or peach</td><td>Kitchen accents, not whole walls</td></tr>
    <tr><td>South-west</td><td>Earthy beige, sand and brown</td><td>Bedroom walls, wood-tone wardrobes</td></tr>
  </tbody>
</table>
</div>
<p>On materials, the common thread is lighter finishes on the north and east sides and heavier, more solid furniture on the south and west. Choose every finish for durability first, then the shade. Light often changes a room more than paint; see <a href="/planning/lighting-design/">lighting design</a>.</p>

<h2>Vastu in apartments: what you can and cannot change</h2>
<p>A flat owner inherits most of the plan, so interior vastu is largely a matter of placement.</p>
<div class="pros-cons">
  <div><span class="pros-cons__title">Usually fixed</span><ul>
    <li>Direction of the main door</li>
    <li>Kitchen position, with its gas, drain and chimney points</li>
    <li>Toilets and other wet areas</li>
    <li>Structural walls, columns, beams and windows</li>
  </ul></div>
  <div><span class="pros-cons__title">Yours to choose</span><ul>
    <li>Furniture placement and bed orientation</li>
    <li>Position of the pooja unit</li>
    <li>Which walls carry wardrobes and storage</li>
    <li>Colours and lighting</li>
    <li>Keeping the north-east open and uncluttered</li>
  </ul></div>
</div>
<p>Do not try to relocate a kitchen or a toilet in a flat. Wet areas are stacked above those of the home below, so moving them risks leaks and needs approval from the society and a structural engineer. For what is fixed, tradition itself suggests simple adjustments: placement, colour, and keeping the area clean and uncluttered.</p>
<p>If your choices add a pooja unit or extra storage, the <a href="/calculators/interior-cost/">interior cost calculator</a> gives an indicative budget, and <a href="/planning/storage-room-by-room/">storage, room by room</a> helps decide which walls to use.</p>
<h3>When vastu and practicality conflict</h3>
<ol class="steps">
  <li><strong>Safety first</strong>Gas, electrical and fire safety, structure and escape routes are never traded for a direction.</li>
  <li><strong>Function next</strong>Daylight, ventilation, walking space and a workable kitchen come before orientation.</li>
  <li><strong>Tradition where it costs nothing</strong>Bed direction, pooja position, storage walls and colours can usually follow tradition with no penalty.</li>
  <li><strong>Decide the rest together</strong>Where a preference would cost space, money or comfort, weigh it as a family and record the decision in the design brief.</li>
</ol>

<h2>Quick-reference table: room by room</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Room or item</th><th>Traditionally preferred direction</th><th>Practical alternative</th></tr></thead>
  <tbody>
<?php foreach ($QUICK as $room => [$preferred, $alternative]): ?>
    <tr><td><?= e($room) ?></td><td><?= e($preferred) ?></td><td><?= e($alternative) ?></td></tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
<p class="table-note">Traditional preferences only; none is a building requirement.</p>
<p>Take this table and your marked floor plan to the first design meeting, along with the <a href="/planning/home-planning-checklist/">home planning checklist</a>.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
