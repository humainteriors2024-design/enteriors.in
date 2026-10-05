<?php
/* =====================================================================
   HOME PAGE CONTENT — edit words, links and prices here, not in index.php.
   • Pillar cards, search suggestions and calculators are NOT listed here: they are
     read from includes/nav.php, so they can never go out of step with the menu.
   • A card whose page is not uploaded yet shows as a plain card marked "Soon"
     (no dead links). It becomes a link the day the page is uploaded.
   • Prices: keep in step with /cost/ and includes/calc/rates.php (the calculators' rate sheet).
   • Photos: put them in /assets/pages/home/ named after the tile, e.g.
     modular-kitchen.jpg, wardrobe.jpg, living-room.jpg, modern.jpg — the tile
     then shows the photo instead of the icon, with alt text from the file name.
   ===================================================================== */

$HOME = [
  'hero' => [
    'badge' => "India's interior knowledge platform",
    'title' => 'Know Before<br>You Design.<br><em>Build Smart.</em>',
    'text'  => 'Clear guides to modular kitchens, wardrobes, materials and costs for Indian homes, with free calculators. Read first, then talk to a designer with the right questions.',
    'pills' => [   // quick links under the search box (only live pages show)
      ['Kitchen guide', '/modular-kitchen/'], ['Wardrobe guide', '/wardrobe/'], ['Interior cost', '/cost/'],
      ['2 BHK cost', '/cost/2-bhk-interior-cost/'], ['3 BHK cost', '/cost/3-bhk-interior-cost/'],
      ['Acrylic vs laminate', '/compare/acrylic-vs-laminate/'], ['Plywood grades', '/materials/plywood-guide/'], ['Glossary', '/glossary/'],
    ],
    'mosaic' => [   // [title, sub, icon, url, background, photo name in /assets/pages/home/]
      ['Modular Kitchen', 'Layouts · Materials · Cost', '🍳', '/modular-kitchen/', 'linear-gradient(135deg,#0d1a0d,#142814)', 'modular-kitchen'],
      ['Wardrobes', 'Hinged · Sliding · Walk-in', '🚪', '/wardrobe/', 'linear-gradient(135deg,#281408,#3d1f0a)', 'wardrobe'],
      ['Interior Cost', 'Per sq ft · BHK · Room-wise', '₹', '/cost/', 'linear-gradient(135deg,#14203a,#0d1527)', 'interior-cost'],
      ['False Ceiling', 'Gypsum · POP · Lighting', '💡', '/false-ceiling/', 'linear-gradient(135deg,#1a0d1a,#2d1428)', 'false-ceiling'],
      ['Flooring', 'Tiles · Marble · Wood', '▦', '/flooring/', 'linear-gradient(135deg,#0d1428,#141e28)', 'flooring'],
    ],
  ],

  'marquee' => ['Modular Kitchens', 'Wardrobes', 'Interior Cost', 'False Ceilings', 'Flooring', 'Materials', 'Design Styles', 'Room Guides', 'Home Planning', 'Vastu', 'Trends 2026', 'Free Calculators'],

  // Price snapshot — same figures as the table on /cost/
  'costs' => [   // home => [typical carpet area, essential, standard, premium, guide url]
    '1 BHK' => ['about 550 sq ft', '₹2.5–4 lakh', '₹4–6 lakh', '₹6–9.5 lakh', '/cost/1-bhk-interior-cost/'],
    '2 BHK' => ['about 950 sq ft', '₹4.2–6.5 lakh', '₹6.5–10 lakh', '₹10.5–16 lakh', '/cost/2-bhk-interior-cost/'],
    '3 BHK' => ['about 1,400 sq ft', '₹6–10 lakh', '₹10–15 lakh', '₹15–24 lakh', '/cost/3-bhk-interior-cost/'],
    '4 BHK or villa' => ['about 2,000 sq ft', '₹9–14 lakh', '₹14–22 lakh', '₹22–34 lakh', '/cost/4-bhk-villa-cost/'],
  ],

  'steps' => [   // how to use the site: [title, text, url, link text]
    ['Read the guide', 'Start with the pillar guide for the room you are doing. Each one sets out the decisions in the order you will make them.', '/modular-kitchen/', 'Kitchen guide'],
    ['Work out the budget', 'Use the calculators to get a realistic figure for your home size, grade and city before any meeting.', '/calculators/interior-cost/', 'Cost calculator'],
    ['Compare like with like', 'Ask each firm for the same specification: board, finish, hardware brand and sizes, line by line.', '/planning/how-to-choose-interior-designer/', 'How to choose a designer'],
    ['Build with a written plan', 'Agree drawings, payment stages tied to milestones, a timeline and warranty terms before work starts.', '/planning/', 'Planning guide'],
  ],

  // Materials library tabs: tab => list of [name, use, price, unit, tags, url]
  'materials' => [
    'Boards' => [
      ['BWP Plywood', 'Sink units, kitchen base units, vanities', '₹110–180', '/sq ft, 18 mm', ['Marine grade', 'IS 710'], '/materials/marine-plywood/'],
      ['BWR Plywood', 'Kitchen wall units, humid rooms', '₹90–140', '/sq ft, 18 mm', ['Water-resistant'], '/materials/plywood-guide/'],
      ['MR Plywood', 'Wardrobes, TV and study units', '₹75–120', '/sq ft, 18 mm', ['Dry areas'], '/materials/mr-plywood/'],
      ['HDHMR Board', 'Shutters, wardrobes, back panels', '₹70–110', '/sq ft, 18 mm', ['Dense', 'Smooth'], '/materials/hdhmr-board/'],
      ['MDF Board', 'Painted and routed shutters, dry rooms', '₹45–75', '/sq ft, 18 mm', ['Smooth', 'Dry only'], '/materials/mdf-board/'],
    ],
    'Finishes' => [
      ['Laminate', 'Toughest everyday finish for shutters', 'Base', 'price', ['Matte', 'Gloss', 'Textured'], '/materials/laminate-guide/'],
      ['Acrylic', 'Deep gloss or soft matte fronts', '1.3–1.6×', 'laminate', ['High gloss', 'Matte'], '/materials/acrylic-finish/'],
      ['Wood Veneer', 'Real wood grain under clear polish', '1.5–2×', 'laminate', ['Natural', 'Recon'], '/materials/wood-veneer/'],
      ['PU Paint', 'Any colour; repairable on site', 'About 1.6×', 'laminate', ['Any colour'], '/materials/pu-finish/'],
    ],
    'Flooring' => [
      ['Vitrified Tiles', 'Every room; low upkeep', '₹90–220', '/sq ft laid', ['GVT', 'Double charge'], '/flooring/'],
      ['Indian Marble', 'Living rooms; needs sealing', '₹150–400', '/sq ft laid', ['Polished'], '/materials/marble-guide/'],
      ['Granite', 'Floors, stairs, counters', '₹150–350', '/sq ft laid', ['Hard', 'Dense'], '/materials/granite-guide/'],
      ['SPC / Vinyl Plank', 'Wood look; waterproof plank', '₹110–260', '/sq ft laid', ['Click-fit'], '/flooring/'],
      ['Engineered Wood', 'Bedrooms and living rooms', '₹350–900', '/sq ft laid', ['Real wood top'], '/flooring/'],
    ],
    'Countertops' => [
      ['Granite', 'The default for Indian cooking', 'About ₹280', '/sq ft fixed', ['Heat-proof'], '/materials/granite-guide/'],
      ['Quartz', 'Uniform colour, non-porous', 'About ₹650', '/sq ft fixed', ['Low upkeep'], '/materials/quartz-countertop/'],
      ['Sintered Stone', 'Large slabs for premium kitchens', 'About ₹1,200', '/sq ft fixed', ['Heat and stain resistant'], '/modular-kitchen/countertop-guide/'],
    ],
  ],

  'tools' => [   // one line under each calculator (the list itself comes from nav.php)
    '/calculators/interior-cost/'     => 'Whole-home estimate by size, grade, scope and city.',
    '/calculators/modular-kitchen/'   => 'Price a kitchen by running foot, finish and hardware.',
    '/calculators/wardrobe-cost/'     => 'One wardrobe by size, door type and finish.',
    '/calculators/material-selector/' => 'Boards and finishes, room by room.',
  ],

  'rooms' => [   // [title, text, icon, url, tags]
    ['Living Room', 'Layout, TV wall, seating and lighting', '🛋️', '/rooms/living-room/', ['TV unit', 'Sofa', 'Flooring']],
    ['Master Bedroom', 'Bed wall, wardrobe wall and dresser', '🛏', '/rooms/master-bedroom/', ['Wardrobe', 'Lighting']],
    ['Kids Room', 'Storage and study that grow with the child', '🧸', '/rooms/kids-room/', ['Study', 'Storage']],
    ['Study & Home Office', 'Desk height, light and shelving', '📚', '/rooms/study-home-office/', ['Ergonomics']],
    ['Pooja Room', 'Units, doors, materials and lighting', '🪔', '/rooms/pooja-room/', ['Vastu', 'Materials']],
    ['Dining & Crockery', 'Table clearances and crockery units', '🍽️', '/rooms/dining-room/', ['Crockery unit']],
    ['Bathroom', 'Wet and dry zones, tiles and vanity', '🚿', '/rooms/bathroom/', ['Tiles', 'Vanity']],
    ['Balcony & Utility', 'Decking, seating and washer platforms', '🌿', '/rooms/balcony/', ['Utility']],
  ],

  'compare' => [   // [title, the question it settles, url]
    ['Acrylic vs Laminate', 'Gloss and depth, or toughness and price?', '/compare/acrylic-vs-laminate/'],
    ['MDF vs Plywood', 'Smooth and stable, or strong near water?', '/compare/mdf-vs-plywood/'],
    ['Quartz vs Granite', 'Which countertop suits daily Indian cooking?', '/compare/quartz-vs-granite/'],
    ['HDHMR vs Plywood', 'Can the engineered board replace plywood?', '/compare/hdhmr-vs-plywood/'],
    ['Modular vs Carpenter-Made', 'Factory finish or on-site flexibility?', '/compare/modular-vs-carpenter-kitchen/'],
    ['Veneer vs Laminate', 'Real wood grain or a printed one?', '/compare/veneer-vs-laminate/'],
  ],

  'styles' => [   // [title, text, icon, url, background, photo name in /assets/pages/home/]
    ['Modern', 'Flat planes · Wood, glass, steel', '🏙️', '/styles/modern/', 'linear-gradient(135deg,#1a1a2e,#16213e)', 'modern'],
    ['Contemporary', 'Warm neutrals · Current, relaxed', '🛋️', '/styles/contemporary/', 'linear-gradient(135deg,#2a1f14,#3d2b1a)', 'contemporary'],
    ['Scandinavian', 'Pale wood · White · Simple forms', '🌿', '/styles/scandinavian/', 'linear-gradient(135deg,#2d4a22,#1a3a10)', 'scandinavian'],
    ['Japandi', 'Low furniture · Natural textures', '🎋', '/styles/japandi/', 'linear-gradient(135deg,#251a0a,#3d2d14)', 'japandi'],
    ['Minimalist', 'Few pieces · Concealed storage', '◻️', '/styles/minimalist/', 'linear-gradient(135deg,#1a1218,#2d1a28)', 'minimalist'],
    ['Industrial', 'Cement texture · Black metal', '⚙️', '/styles/industrial/', 'linear-gradient(135deg,#1c1c1c,#2d2a25)', 'industrial'],
    ['Traditional Indian', 'Teak · Brass · Carved detail', '🪔', '/styles/traditional-indian/', 'linear-gradient(135deg,#1a0d0d,#2d1414)', 'traditional-indian'],
    ['Luxury', 'Stone · Veneer · Made to order', '💎', '/styles/luxury-interior/', 'linear-gradient(135deg,#0d1a2d,#141f2d)', 'luxury'],
  ],

  'trends' => [   // [label, title, text, url]
    ['Surfaces', 'Fluted Panels', 'Ribbed panels on feature walls, TV units and wardrobe fronts.', '/trends/fluted-panels/'],
    ['Furniture', 'Curved and Arched Furniture', 'Rounded sofas, arched niches and curved wardrobe ends.', '/trends/curved-arched-furniture/'],
    ['Colour', 'Warm Neutrals', 'Beige, greige and terracotta in place of cool grey.', '/trends/warm-neutrals/'],
    ['Nature', 'Biophilic Design', 'Plants, daylight and natural materials planned in from the start.', '/trends/biophilic-design/'],
    ['Kitchen', 'Hidden Kitchens', 'Handle-less shutters, appliance garages and pocket doors.', '/trends/hidden-kitchens/'],
    ['Storage', 'Smart Storage', 'Drawer-based base units, lofts and furniture that stores.', '/trends/smart-storage/'],
  ],

  'faq' => [
    'What is Enteriors?' => 'Enteriors is a knowledge site for home interiors in India. It explains materials, layouts and costs in plain language, offers free calculators, and can connect you with interior designers in Bangalore and Hosur when you are ready.',
    'How much do home interiors cost in Bangalore?' => 'For a full scope, budget roughly ₹450–700 per sq ft of carpet area in essential grade, ₹700–1,100 in standard grade and ₹1,100–1,700 in premium grade, including GST. A typical 2 BHK comes to about ₹6.5–10 lakh in standard grade.',
    'Are the calculators free?' => 'Yes. They need no signup and nothing is sent anywhere unless you choose to request a quote.',
    'Where do the prices on this site come from?' => 'They are indicative ranges for Bengaluru, shown with the month they were last updated. They are meant for planning; a quotation after site measurement can differ by 10–15% either way.',
    'Which should I decide first: design, materials or budget?' => 'Budget and scope first, then layout, then materials and finishes. The planning guide sets out the order and what to have in writing before work starts.',
    'Which areas do you cover?' => 'Consultations are available in Bengaluru and Hosur. The guides and calculators are written for homes across India, with city factors for eight cities.',
  ],
];
