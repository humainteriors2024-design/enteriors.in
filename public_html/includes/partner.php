<?php
/* =====================================================================
   ENTERIORS — PARTNER LINKS (Huma Interiors, humainteriors.com)
   Facts and URLs live in config.php → PARTNER. This file only builds the links.

     <?= huma('kitchen', 'modular kitchens in Chandapura') ?>            followed link to a page in PARTNER['pages']
     <?= huma('home', 'Huma Interiors', follow: false) ?>                 nofollow link
     <?= component('partner') ?>                                          the partner box (added automatically by foot.php)

   The automatic box picks its wording from the page topic (kitchen, wardrobe, living, cost,
   local, general) and varies the linked words from page to page, so the links read naturally
   and the anchor text is not the same everywhere. Follow / nofollow: see partner_follow().
   ===================================================================== */

// One link to humainteriors.com. $key = a key of PARTNER['pages'] or a full https:// URL.
function huma($key, $text, $follow = true, $class = '') {
  $url = PARTNER['pages'][$key] ?? (str_starts_with($key, 'http') ? $key : PARTNER['url']);
  return '<a href="' . e($url) . '" rel="' . ($follow ? 'noopener' : 'nofollow noopener') . '" target="_blank"'
       . ($class ? ' class="' . e($class) . '"' : '') . ' data-partner="' . e(is_string($key) && isset(PARTNER['pages'][$key]) ? $key : 'url') . '">' . e($text) . '</a>';
}

// The topic of a page, for choosing the box wording: kitchen | wardrobe | living | cost | local | general
function partner_topic($pg, $hubKey = null) {
  if (!empty($pg['partner']['topic'])) return $pg['partner']['topic'];
  $path = current_path();
  $cat  = strtolower($pg['category'] ?? '');
  if ($hubKey === 'locations' || str_starts_with($path, '/interior-designers-') || str_starts_with($path, '/partners/') || $cat === 'local guide') return 'local';
  if ($hubKey === 'modular-kitchen' || $cat === 'kitchen' || str_contains($path, 'kitchen') || str_contains($path, 'countertop')) return 'kitchen';
  if ($hubKey === 'wardrobe' || $cat === 'wardrobes' || str_contains($path, 'wardrobe') || str_contains($path, 'walk-in') || str_contains($path, 'bedroom')) return 'wardrobe';
  if ($hubKey === 'cost' || $cat === 'cost' || str_contains($path, '-cost')) return 'cost';
  if (in_array($hubKey, ['rooms', 'furniture', 'false-ceiling', 'wall-design'], true) || in_array($cat, ['living', 'living room', 'rooms'], true)
      || preg_match('#living|tv-unit|sofa|false-ceiling|dining|foyer|crockery|pooja#', $path)) return 'living';
  return 'general';
}

/* Followed or nofollow?
   - the page says so ('partner' => ['follow' => true|false])
   - pillar pages: followed when the pillar is in PARTNER['follow_pillars']
   - other pages on a related topic: followed, except one page in three (nofollow) for a natural mix
   - pages on unrelated topics (styles, vastu, trends, colour …): nofollow */
function partner_follow($pg, $hubKey = null, $topic = null) {
  if (isset($pg['partner']['follow'])) return (bool) $pg['partner']['follow'];
  $topic = $topic ?? partner_topic($pg, $hubKey);
  $related = in_array($hubKey, PARTNER['follow_pillars'], true) || in_array($topic, ['kitchen', 'wardrobe', 'living', 'cost', 'local'], true);
  if (($pg['type'] ?? '') === 'pillar') return $related;
  if (!$related) return false;
  return crc32(current_path()) % 3 !== 0;
}

/* Wording for the partner box, by topic: [page key, linked words, sentence with {link}].
   One line is chosen per page (stable for that URL), so different pages link with different words. */
function partner_lines($topic) {
  $L = [
    'kitchen' => [
      ['kitchen', 'modular kitchens in Chandapura', 'Huma Interiors, our execution partner, designs and builds {link} in its own factory, a short drive from Electronic City and Bommasandra.'],
      ['kitchen', 'factory-made modular kitchens for South-East Bengaluru', 'If you live around Electronic City, Chandapura or Bommasandra, Huma Interiors builds {link}, with a 3D design before you pay and an itemised quotation with named brands.'],
      ['electronic_city', 'modular kitchen in Electronic City', 'Planning a {link} or nearby? Huma Interiors cuts, edge-bands and installs every cabinet from its Chandapura factory.'],
      ['home', 'Huma Interiors', 'For a kitchen built to the standards in this guide, see {link}, a factory-backed studio in Chandapura that serves Electronic City, Bommasandra and Hosur Road.'],
      ['bommasandra', 'kitchen interiors in Bommasandra', 'Huma Interiors handles {link}, Chandapura and Electronic City from design to installation, with the delivery date written into the contract.'],
    ],
    'wardrobe' => [
      ['wardrobe', 'wardrobes made in its Chandapura factory', 'Huma Interiors, our execution partner, offers sliding, hinged and walk-in {link}, sized to what you own and installed across Electronic City and Bommasandra.'],
      ['home', 'Huma Interiors', 'Need wardrobes built to these specifications near Electronic City? {link} designs them in 3D and makes them in its own Chandapura factory.'],
      ['electronic_city', 'bedroom interiors in Electronic City', 'For {link}, Chandapura and Bommasandra, Huma Interiors plans the wardrobe wall, loft and dresser together and builds them in-house.'],
      ['chandapura', 'wardrobe designers in Chandapura', 'Huma Interiors, {link}, builds every shutter and internal drawer on its own floor and installs across South-East Bengaluru.'],
    ],
    'living' => [
      ['living', 'living room interior design in Bangalore', 'Huma Interiors, our execution partner in Chandapura, has a detailed guide to {link}, and builds TV units, panelling and false ceilings for homes around Electronic City.'],
      ['electronic_city', 'living room interiors in Electronic City', 'For {link}, Chandapura and Bommasandra, Huma Interiors designs the TV wall, ceiling and storage together and builds the units in its own factory.'],
      ['chandapura', 'home interiors in Chandapura', 'Huma Interiors does {link}, Electronic City and Bommasandra: TV units, crockery and pooja units, panelling and ceilings, designed in 3D first.'],
      ['home', 'humainteriors.com', 'See living rooms, TV units and pooja units built for apartments near Electronic City at {link}.'],
    ],
    'cost' => [
      ['cost_2bhk', '2 BHK interior design cost in Bangalore', 'For a builder\'s view of the same numbers, Huma Interiors publishes its own breakdown of {link}, from its factory in Chandapura.'],
      ['cost_3bhk', '3 BHK interior design cost in Bangalore', 'Huma Interiors, our execution partner, sets out {link} room by room, based on homes it has built around Electronic City.'],
      ['chandapura', 'interior designers in Chandapura', 'Want these figures turned into a written quote? Huma Interiors, a team of {link} with its own factory, gives an itemised quotation with named brands.'],
      ['electronic_city', 'home interiors in Electronic City', 'For {link}, Chandapura and Bommasandra, Huma Interiors quotes line by line and writes the delivery date into the contract.'],
    ],
    'local' => [
      ['chandapura', 'interior designers in Chandapura', 'Huma Interiors, our execution partner, is a team of {link} with a 17,400 sq ft factory on the same site, serving Electronic City, Bommasandra, Attibele and Hosur Road.'],
      ['electronic_city', 'interior designers in Electronic City', 'Looking for {link} who also manufacture? Huma Interiors designs in 3D first and builds every unit in Chandapura.'],
      ['bommasandra', 'interior designers near Bommasandra', 'Huma Interiors is a team of {link}, Jigani and Hebbagodi, with its own factory in Chandapura and a written delivery date.'],
    ],
    'general' => [
      ['about', 'Huma Interiors', 'Enteriors\' guides are put into practice by {link}, our execution partner: a factory-backed interior studio in Chandapura serving Electronic City and Bommasandra.'],
      ['home', 'humainteriors.com', 'Want to see these ideas in finished homes in South-East Bengaluru? Browse projects at {link}.'],
      ['electronic_city', 'home interiors in Electronic City', 'Huma Interiors, our execution partner, takes these ideas into {link}, Chandapura and Bommasandra, with every unit built in its own factory.'],
      ['bommasandra', 'interior designers in Bommasandra', 'Looking for {link} or Chandapura who can build what you read here? Huma Interiors designs in 3D first and manufactures in-house.'],
      ['blog', 'Huma Interiors blog', 'For project-based ideas and real costs from Bangalore homes, read the {link}.'],
    ],
  ];
  return $L[$topic] ?? $L['general'];
}

// Box heading by topic
function partner_title($topic) {
  return [
    'kitchen'  => 'Building a kitchen near Electronic City or Chandapura?',
    'wardrobe' => 'Wardrobes for a home near Electronic City or Chandapura?',
    'living'   => 'Doing up a living room in South-East Bengaluru?',
    'cost'     => 'Want a written quote for these numbers?',
    'local'    => 'Ready for a site visit in South-East Bengaluru?',
  ][$topic] ?? 'Doing up a home near Electronic City, Chandapura or Bommasandra?';
}

// One sentence with one partner link, for the box or for use inside a page
function partner_sentence($topic, $follow, $seed = null) {
  $lines = partner_lines($topic);
  [$key, $anchor, $text] = $lines[crc32($seed ?? current_path()) % count($lines)];
  return str_replace('{link}', huma($key, $anchor, $follow), e($text));
}
