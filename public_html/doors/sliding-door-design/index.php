<?php
/* CLUSTER PAGE — /doors/sliding-door-design/   ·   Phase 2, Oct 2026
   Target keyword: "sliding door design" (+ "sliding door for bedroom", "sliding door for kitchen")
   Images: /assets/pages/doors/sliding-door-design/ */
$page = [
  'type'         => 'article',
  'title'        => 'Sliding Door Design: Systems, Tracks, Materials and Where They Suit',
  'seo_title'    => 'Sliding Door Design for Home: Types & Systems',
  'crumb'        => 'Sliding Door Design',
  'description'  => 'Sliding door design for homes: top-hung, bottom-rolling, pocket and barn systems, track weight ratings, glass and wood panels, sound and cost.',
  'eyebrow'      => 'Doors',
  'lede'         => 'Sliding doors save swing space, but only the right system slides smoothly for years. How the systems work, what they can carry and where each belongs.',
  'hero_alt'     => 'Fluted glass sliding door between a living room and a study',
  'published'    => '2026-10-04',
  'updated'      => '2026-10-04',
  'quick_answer' => 'A sliding door hangs from a top track (top-hung) or rolls on a bottom track (bottom-rolling). Top-hung systems leave a clean floor and suit internal doors, kitchens and room dividers; bottom-rolling systems carry heavier glass and suit balconies. Choose a track rated above the panel weight (common ratings 40, 60, 80 and 120 kg per panel), add soft-close dampers and a floor guide, and remember that sliding doors seal and insulate sound less well than hinged doors.',
  'takeaways' => [
    'Top-hung systems leave a clean floor; bottom-rolling systems carry heavy glass and suit balconies.',
    'Weigh the panel and choose a track rated above it (commonly 40, 60, 80 or 120 kg).',
    '10 mm toughened glass weighs about 25 kg per m²: a 900 × 2100 mm panel is about 47 kg.',
    'Overlap 50–75 mm beyond the opening and add seals for privacy and sound.',
    'Fix the track into concrete, a hardwood header or steel, never into gypsum alone.',
  ],
  'sources' => [
    ['Bureau of Indian Standards: IS 2553 (Part 1)', 'https://www.bis.gov.in/', 'safety glass for glazed sliding doors'],
    ['National Building Code of India 2016', 'https://www.bis.gov.in/', 'clear widths and safety glazing'],
    ['Enteriors: glass partition design', '/doors/glass-partition-design/', 'glass types and thickness'],
  ],
  'faq' => [
    'What is the best sliding door for a small bedroom?' => 'A top-hung solid panel with soft-close and edge seals, or a pocket door if the wall can be built for it. Both save the swing space a hinged door needs.',
    'Can sliding doors be used for a bathroom?' => 'Yes, especially pocket doors with seals, or top-hung doors that overlap the opening generously. Use a waterproof panel (WPC or laminated BWP core) and a privacy hook lock.',
    'How long do sliding door rollers last?' => 'Good branded ball-bearing rollers last many years with clean tracks. Cheap plastic rollers wear in a year or two. Rollers are replaceable, so choose a system whose parts are easy to buy.',
    'What is the minimum wall space needed for a sliding door?' => 'For a surface-mounted sliding door, a clear stretch of wall at least as wide as the door plus the overlap (about 50–75 mm each side) next to the opening, with no switches or sockets behind it.',
    'Are sliding doors noisy?' => 'Good systems with nylon or ball-bearing rollers and soft-close dampers are quiet. Cheap rollers, dusty bottom tracks and missing floor guides cause rattling and grinding.',
    'Can I convert a hinged door to a sliding door?' => 'Usually, with a surface-mounted top-hung kit, if there is enough clear wall beside the opening and a solid header above. The old frame may stay as a casing or be replaced with a flat trim.',
    'Are sliding doors good for bedrooms?' => 'Yes, where swing space is short or a hinged door would hit furniture. They let more sound through than a hinged door, because of the gaps around the panel. A pocket door or a sliding door with brush seals and a wall overlap reduces this.',
    'What is the difference between top-hung and bottom-rolling sliding doors?' => 'Top-hung doors hang from rollers in an overhead track, with only a small guide on the floor, so there is no floor track to trip on or clean. Bottom-rolling doors carry their weight on wheels in a floor track; they handle heavier panels but the track collects dust.',
    'How much does a sliding door cost?' => 'Indicatively, in Bengaluru (October 2026, before GST): a wooden or laminated internal sliding door with a branded top-hung kit costs about ₹18,000–45,000 per panel; a framed aluminium and glass partition door ₹600–1,200 per sq ft; uPVC balcony sliding doors ₹700–1,400 per sq ft.',
    'Can a sliding door be locked?' => 'Yes, with a hook lock or a flush sliding-door lock. Internal sliding doors typically use a privacy hook lock; balcony doors use multi-point locks in the frame.',
    'What is a pocket door?' => 'A sliding door that disappears into a cavity inside the wall when open. It looks the cleanest but needs the cavity planned before plastering, and the track must be accessible for maintenance.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<p>Sliding doors solve a real problem in compact Indian apartments: a 900 mm hinged door needs about 0.8 m² of clear floor to swing, which is often exactly where a bed, a wardrobe or a dining chair wants to be. Sliding doors also suit open-plan homes that want to close off the kitchen or study only sometimes. Their weak points are sealing, sound and cheap hardware. This guide is part of the <a href="/doors/">doors guide</a>.</p>

<h2>Sliding door systems</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>System</th><th>How it works</th><th>Best for</th><th>Limits</th></tr></thead>
  <tbody>
    <tr><td>Top-hung, surface mounted</td><td>Rollers in a track fixed above the opening; small floor guide</td><td>Bedrooms, kitchens, studies, dividers</td><td>Panel covers part of the wall when open</td></tr>
    <tr><td>Barn door</td><td>Exposed rail and rollers on the wall face</td><td>Feature doors, studies, utility</td><td>Visible hardware; larger gaps around the panel</td></tr>
    <tr><td>Pocket door</td><td>Panel slides into a cavity in the wall</td><td>Bathrooms, walk-in closets, tight passages</td><td>Must be planned in the wall build</td></tr>
    <tr><td>Bottom-rolling</td><td>Wheels in a floor track</td><td>Heavy glass, balconies, wardrobes</td><td>Floor track collects dust</td></tr>
    <tr><td>Multi-panel / telescopic</td><td>Several panels on parallel tracks, linked</td><td>Wide living–dining or living–balcony openings</td><td>More hardware; needs precise fitting</td></tr>
    <tr><td>Lift-and-slide</td><td>Panel lifts off its seal to slide, drops to seal</td><td>Large premium balcony doors</td><td>Expensive</td></tr>
  </tbody>
</table>
</div>
<?= img('fluted-glass-sliding-door-study') ?>

<h2>Weight, track and hardware</h2>
<ul>
  <li><strong>Weigh the panel.</strong> A 900 × 2100 mm solid-core wood panel weighs roughly 25–35 kg; 10 mm toughened glass of the same size about 47 kg (glass weighs about 25 kg per m² per 10 mm).</li>
  <li><strong>Choose a track rated above that weight,</strong> commonly 40, 60, 80 or 120 kg per panel.</li>
  <li><strong>Soft-close dampers</strong> at one or both ends stop the panel slamming and bouncing.</li>
  <li><strong>A floor guide</strong> stops the panel swinging; top-hung doors still need one.</li>
  <li><strong>Fix the track into solid structure:</strong> concrete lintel, a hardwood or ply header, or a steel section, not into gypsum ceiling boards.</li>
</ul>

<h2>Panel materials</h2>
<ul>
  <li><strong>Wood and laminated flush panels:</strong> privacy and warmth for bedrooms and studies.</li>
  <li><strong>Glass in aluminium frames:</strong> clear, frosted, fluted (reeded) or tinted; keeps light flowing between rooms. See <a href="/doors/glass-partition-design/">glass partition design</a>.</li>
  <li><strong>Louvred and slatted:</strong> airflow for utility areas and wardrobes.</li>
  <li><strong>Mirror panels:</strong> for wardrobes and dressing areas; see <a href="/compare/sliding-vs-hinged-wardrobe/">sliding vs hinged wardrobes</a>.</li>
</ul>

<h2>Sound, privacy and seals</h2>
<p>Sliding doors leave gaps at the edges and bottom, so they let through more sound and light than hinged doors. Overlap the panel 50–75 mm beyond the opening on each side, add brush or rubber seals at the edges, and use a solid panel where privacy matters. For bathrooms, a pocket door with seals is better than a surface-mounted barn door.</p>

<h2>Where sliding doors work best</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Location</th><th>Recommended</th></tr></thead>
  <tbody>
    <tr><td>Kitchen to living</td><td>Top-hung fluted or frosted glass, to keep light and contain smells while cooking</td></tr>
    <tr><td>Study or guest room off the living room</td><td>Top-hung wood or glass, or a multi-panel divider</td></tr>
    <tr><td>Bedroom with tight swing space</td><td>Top-hung solid panel with seals, or a pocket door</td></tr>
    <tr><td>Bathroom / walk-in closet</td><td>Pocket door with seals</td></tr>
    <tr><td>Balcony</td><td>uPVC or aluminium bottom-rolling with weather seals and mesh</td></tr>
  </tbody>
</table>
</div>
<p>Indicative costs are in the FAQ below. For wardrobe sliding shutters, see the <a href="/wardrobe/">wardrobe guide</a>.</p>
<h2>Indicative costs</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Door</th><th>Specification</th><th class="num">Indicative cost</th></tr></thead>
  <tbody>
    <tr><td>Internal wood sliding door</td><td>Laminated solid-core panel, branded top-hung kit, soft-close</td><td class="num">₹18,000–35,000 per panel</td></tr>
    <tr><td>Veneered sliding door</td><td>Veneer and PU, concealed track</td><td class="num">₹28,000–45,000 per panel</td></tr>
    <tr><td>Aluminium + glass sliding</td><td>Slim profile, 6–10 mm toughened, fluted or frosted</td><td class="num">₹600–1,200 per sq ft</td></tr>
    <tr><td>Barn door</td><td>Wood panel, exposed black rail</td><td class="num">₹20,000–40,000</td></tr>
    <tr><td>Pocket door</td><td>Panel + in-wall cassette frame</td><td class="num">₹30,000–60,000</td></tr>
    <tr><td>uPVC balcony sliding</td><td>2 or 3 tracks, mesh, toughened glass</td><td class="num">₹700–1,400 per sq ft</td></tr>
  </tbody>
</table>
</div>
<p class="table-note">Indicative Bengaluru prices, October 2026, before GST, including installation.</p>
<?= img('top-hung-sliding-track-soft-close-detail', caption: 'A top-hung track with ball-bearing rollers and a soft-close damper: the hardware that decides how a sliding door feels') ?>

<h2>Worked example: a kitchen sliding door</h2>
<p>An open kitchen in a Bengaluru 2 BHK with a 1500 mm wide opening to the dining area. The family wants to contain cooking smells but keep light:</p>
<ul>
  <li><strong>System:</strong> two top-hung panels, each about 800 mm wide (overlapping in the middle), on a track rated 60 kg per panel with soft-close at both ends.</li>
  <li><strong>Panels:</strong> black aluminium frames with 8 mm fluted toughened glass. Each panel weighs roughly 35 kg (0.8 × 2.1 m × 20 kg per m² for 8 mm glass, plus the frame).</li>
  <li><strong>Fixing:</strong> track bolted into the concrete lintel through a hardwood packing strip; floor guide in the centre.</li>
  <li><strong>Seals:</strong> brush seals on the meeting edges.</li>
  <li><strong>Indicative cost:</strong> about 34 sq ft × ₹700–1,000 = ₹24,000–34,000 before GST.</li>
</ul>
<?= img('fluted-glass-kitchen-sliding-doors-black-frame', caption: 'Twin fluted-glass sliding doors in black frames between a kitchen and dining area') ?>

<h2>Installation checks</h2>
<ol>
  <li>Check the header can carry the load; add a timber or steel header if needed.</li>
  <li>Check the floor is level across the opening; adjust the floor guide accordingly.</li>
  <li>Keep switches and sockets off the wall the panel slides over.</li>
  <li>Adjust the rollers so the panel hangs plumb with an even gap at the floor (5–10 mm).</li>
  <li>Test soft-close and the stoppers; panels should not bounce back.</li>
</ol>

<h2>Maintenance</h2>
<ul>
  <li>Vacuum bottom tracks monthly; grit wears rollers.</li>
  <li>Wipe top tracks and check rollers yearly; do not oil nylon rollers unless the maker says so.</li>
  <li>Re-adjust rollers if the panel drops or rubs.</li>
  <li>Replace brush seals when they flatten.</li>
</ul>
<?= img('pocket-door-into-walk-in-closet', caption: 'A pocket door sliding fully into the wall at a walk-in closet entrance') ?>

<h2>Sliding door ideas</h2>
<ul>
  <li><strong>Floor-to-ceiling slatted wood</strong> panels to close a TV room or study.</li>
  <li><strong>Mirror-faced sliding doors</strong> for a dressing area, doubling as a full-length mirror.</li>
  <li><strong>Jaali sliding panels</strong> for a pooja niche in the living room.</li>
  <li><strong>Telescopic glass panels</strong> that stack to one side to open living and dining completely.</li>
</ul>
<?= img('slatted-wood-sliding-panels-tv-room', caption: 'Floor-to-ceiling slatted oak sliding panels closing off a TV room from the living area') ?>

<h2>Hinged or sliding? A quick comparison</h2>
<div class="table-wrap">
<table>
  <thead><tr><th></th><th>Hinged door</th><th>Sliding door</th></tr></thead>
  <tbody>
    <tr><td>Floor space</td><td>Needs swing space</td><td>Needs wall space beside the opening</td></tr>
    <tr><td>Sound and privacy</td><td>Better seal</td><td>Gaps at edges; seals help</td></tr>
    <tr><td>Security</td><td>Easier to lock securely</td><td>Hook or flush locks; fine for internal use</td></tr>
    <tr><td>Accessibility</td><td>Needs a pull and push</td><td>Easier for wheelchairs if the handle is reachable</td></tr>
    <tr><td>Cost</td><td>Lower</td><td>Higher (track and hardware)</td></tr>
    <tr><td>Maintenance</td><td>Hinges only</td><td>Tracks and rollers need cleaning</td></tr>
  </tbody>
</table>
</div>

<h2>Before you decide</h2>
<ul>
  <li>Is there a clear wall beside the opening, with no switches?</li>
  <li>Is the header strong enough for the track?</li>
  <li>How heavy will the panel be, and is the track rated above it?</li>
  <li>How much privacy and sound control do you need?</li>
  <li>Who will use it daily, and is the handle comfortable for them?</li>
</ul>
<?= img('sliding-door-flush-handle-and-hook-lock', caption: 'A flush sliding-door handle with an integrated hook lock for privacy') ?>

<h2>Terms explained</h2>
<dl class="terms">
  <dt>Top-hung</dt><dd>A sliding door whose weight hangs from rollers in an overhead track.</dd>
  <dt>Bottom-rolling</dt><dd>A sliding door whose weight rests on wheels running in a floor track.</dd>
  <dt>Soft-close damper</dt><dd>A device that catches the panel near the end of travel and draws it gently closed.</dd>
  <dt>Floor guide</dt><dd>A small fitting on the floor that keeps a top-hung panel from swinging.</dd>
  <dt>Pocket door</dt><dd>A sliding door that slides into a cavity inside the wall.</dd>
  <dt>Telescopic door</dt><dd>Several linked panels on parallel tracks that stack together when opened.</dd>
</dl>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
