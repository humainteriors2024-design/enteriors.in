<?php
/* =====================================================================
   PARTNER LINKS — links from Enteriors to our partner studio, Huma Interiors (humainteriors.com).
   Printed by includes/components/partner.php at the end of the article on each page listed below,
   plus a few fixed places (home page areas, footer, interior cost calculator, locality guides, guest post).

   White-hat rules this file follows (Google's link spam and "qualify your outbound links" guidance):
     • Every placement is relevant to the page it sits on and useful to its reader.
     • The relationship is disclosed wherever the partner is promoted ("Partner studio" / "Sponsored").
     • rel is set per link:
         'follow'     editorial link inside helpful content      → rel="noopener"
         'nofollow'   footer, guest post, repeated or self-promotional links → rel="nofollow noopener"
         'sponsored'  promotional placements and anything paid or affiliated → rel="sponsored noopener"
     • Anchor text is mostly natural or branded, with exact-match local phrases used only on the
       pages that are really about that locality. At most two partner links per page.
   To add a link: copy a line. {a} is where the link goes inside the sentence.
   ===================================================================== */
/* Partner name, site and disclosure: config.php → PARTNER */

return [
  /* page path => list of [sentence with {a}, anchor text, partner URL, rel, box label] */
  '/rooms/pooja-room/' => [
    ['Short on space? These {a} show compact mandirs that fit a wall niche or a corner of the living room.', 'small pooja room designs for apartments', 'https://humainteriors.com/blogs/small-pooja-room-designs-in-apartments.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/doors/pooja-room-door-design/' => [
    ['For layouts that pair these doors with a compact unit, see {a} from Huma Interiors.', 'pooja room ideas for small flats', 'https://humainteriors.com/blogs/small-pooja-room-designs-in-apartments/', 'nofollow', 'More ideas'],
  ],
  '/rooms/kids-room/' => [
    ['Looking for finished examples? Browse these {a}, with study corners and storage that grow with the child.', 'kids bedroom designs', 'https://humainteriors.com/blogs/kids-bedroom-designs.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/furniture/study-table-design/' => [
    ['If you are planning a full study rather than a single desk, these {a} show layouts with shelving and lighting.', 'study room designs', 'https://humainteriors.com/blogs/study-room-designs-blog.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/furniture/dressing-table-design/' => [
    ['For more styles, see these {a}.', 'stylish dressing table designs', 'https://humainteriors.com/blogs/stylish-dressing-table-designs.php', 'follow', 'Ideas from our partner studio'],
    ['Combining the dresser with the wardrobe? Huma Interiors shows {a}.', 'wardrobe and dressing table layouts', 'https://humainteriors.com/blogs/wardrobe-with-dressing-table-designs-layouts-ideas-for-your-bedroom.php', 'nofollow', ''],
  ],
  '/doors/glass-partition-design/' => [
    ['For partitions between the entrance and the hall, see these {a}.', 'hall partition designs', 'https://humainteriors.com/blogs/hall-partition-design.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/doors/' => [
    ['Huma Interiors keeps a gallery of {a} in wood, glass, metal and jaali for Bengaluru apartments.', 'partition designs', 'https://humainteriors.com/partition-designs.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/rooms/living-room/' => [
    ['Dividing a long living room? These {a} keep light and air moving.', 'living room partition designs', 'https://humainteriors.com/blogs/living-room-partition-design.php', 'follow', 'Ideas from our partner studio'],
    ['For open plans, see {a}.', 'modern partitions between living and dining', 'https://humainteriors.com/blogs/modern-partition-living-dining.php', 'nofollow', ''],
  ],
  '/modular-kitchen/open-kitchen-ideas/' => [
    ['Want some separation without closing the kitchen? See these {a}.', 'kitchen partition design ideas', 'https://humainteriors.com/blogs/kitchen-partition-design.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/wall-design/' => [
    ['For bedrooms in particular, these {a} cover panelling, wallpaper and headboard walls.', 'bedroom wall design ideas', 'https://humainteriors.com/blogs/bedroom-wall-design-ideas.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/rooms/master-bedroom/' => [
    ['For the bed wall, Huma Interiors has {a}.', 'more bedroom wall designs', 'https://humainteriors.com/blogs/bedroom-wall-design-ideas.php', 'nofollow', 'More ideas'],
  ],
  '/blogs/kitchen-colour-combinations/' => [
    ['Choosing laminates? Huma Interiors lists {a}.', 'two-colour laminate combinations', 'https://humainteriors.com/blogs/two-colour-combination-for-kitchen-laminates.php', 'nofollow', 'More ideas'],
  ],
  '/furniture/tv-unit-design/' => [
    ['See these {a} for wall-mounted, panelled and floor-standing units.', 'modern TV unit designs for living rooms', 'https://humainteriors.com/blogs/modern-tv-unit-designs-for-living-rooms.php', 'follow', 'Ideas from our partner studio'],
  ],
  '/cost/2-bhk-interior-cost/' => [
    ['Want a second opinion from a working studio? Huma Interiors publishes its own {a}.', '2 BHK interior cost in Bangalore', 'https://humainteriors.com/2bhk-interior-cost.php', 'sponsored', 'Sponsored · partner studio'],
  ],
  '/cost/4-bhk-villa-cost/' => [
    ['For a Bengaluru studio\'s view of larger homes, see the {a} guide by Huma Interiors.', '4 BHK interior design cost in Bangalore', 'https://humainteriors.com/4bhk-interior-design-cost-in-bangalore.php', 'sponsored', 'Sponsored · partner studio'],
  ],
  '/cost/' => [
    ['Huma Interiors, our partner studio, explains {a} from the projects it builds.', 'interior design cost in Bangalore', 'https://humainteriors.com/interior-design-cost-in-bangalore.php', 'sponsored', 'Sponsored · partner studio'],
    ['Its {a} covers what changes the total.', 'home interior design price guide', 'https://humainteriors.com/blogs/home-interior-design-price.php', 'nofollow', ''],
  ],
  '/modular-kitchen/' => [
    ['Building in Bengaluru? Huma Interiors shares {a} for common layouts.', 'modular kitchen cost in Bangalore', 'https://humainteriors.com/modular-kitchen-cost-in-bangalore.php', 'sponsored', 'Sponsored · partner studio'],
  ],
  '/interior-designers/bangalore/kitchen/' => [
    ['Our partner studio Huma Interiors also designs kitchens in south Bengaluru: see its page on {a}.', 'kitchen interior designers in Bangalore', 'https://humainteriors.com/kitchen-interior-designers-in-bangalore.php', 'sponsored', 'Sponsored · partner studio'],
    ['It also writes about {a}.', 'choosing a kitchen designer', 'https://humainteriors.com/blogs/kitchen-interior-designers-in-bangalore.php', 'nofollow', ''],
  ],
  '/interior-designers/bangalore/' => [
    ['Our partner studio Huma Interiors works in south Bengaluru, from {a} to Hosur Road.', 'interiors in Chandapura', 'https://humainteriors.com/blogs/interior-designers-in-chandapura/', 'sponsored', 'Sponsored · partner studio'],
    ['It also publishes {a}.', 'its own guide to interior designers in Bangalore', 'https://humainteriors.com/best-interior-designers-in-bangalore.php', 'sponsored', ''],
  ],
  '/interior-designer-near-me/' => [
    ['In south Bengaluru, our partner studio Huma Interiors has {a} for Chandapura, Electronic City and Hosur Road.', 'a near-me guide', 'https://humainteriors.com/interior-designers-near-me.php', 'sponsored', 'Sponsored · partner studio'],
    ['It also works with homes {a}.', 'near Sarjapura Road', 'https://humainteriors.com/interior-designers-near-sarjapura-road.php', 'sponsored', ''],
  ],
  '/calculators/home-interior-quote/' => [
    ['Need a firm to quote this list? Our partner studio Huma Interiors, a {a}, quotes Bengaluru homes in the same itemised format.', 'home interior design studio in Chandapura', 'https://humainteriors.com/', 'sponsored', 'Sponsored · partner studio'],
  ],
  '/' => [
    ['{a}: our partner studio for design, factory-made modular work and installation across south Bengaluru and Hosur.', 'Interiors in Electronic City and Chandapura by Huma Interiors', 'https://humainteriors.com/home-interiors-in-electronic-city.php', 'sponsored', 'Sponsored · partner studio'],
  ],
  '/about/' => [
    ['Enteriors works with one partner studio for consultations in Bengaluru and Hosur: {a}. See its {b}.', 'Huma Interiors', 'https://humainteriors.com/', 'follow', 'Our partner studio', ['services', 'https://humainteriors.com/blogs/services/', 'nofollow']],
  ],
];
