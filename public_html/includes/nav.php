<?php
/* =====================================================================
   NAVIGATION + SITE MAP — the single source for:
     • the header menu and mobile menu     • breadcrumb names
     • the footer link columns             • the "In this guide" cards on each pillar page
     • the home page pillar cards and search suggestions
   Built from the cluster map (pillars + the designer directory, tools, services, blog).
   Add a link here ONCE and it appears in all of those places.
   Links to pages not uploaded yet are hidden automatically (is_live).

   Each pillar:
     key      folder name / id            tier   1 revenue · 2 volume · 3 trust
     label    short name (menus)          keyword  main search phrase the pillar targets
     href     pillar URL                  menu   true = own entry in the header (max 5 + "Guides")
     groups   titled lists of cluster pages  [label, url]
     tracking (optional) IDs for every page in this pillar, e.g. 'tracking' => ['meta_pixel' => '123…'] (see includes/tracking.php)
   ===================================================================== */
function lnk($label, $href) { return ['label' => $label, 'href' => $href]; }   // one menu link

$HUBS = [
  /* ---------------- TIER 1 — REVENUE PILLARS ---------------- */
  [
    'key' => 'modular-kitchen', 'label' => 'Modular Kitchen', 'href' => '/modular-kitchen/', 'icon' => '🍳', 'tier' => 1, 'menu' => true,
    'keyword' => 'modular kitchen design',
    'blurb' => 'Layouts, materials, storage and what a kitchen really costs.',
    'groups' => [
      ['title' => 'Layouts & planning', 'links' => [
        lnk('L-Shape vs U-Shape', '/modular-kitchen/l-shape-vs-u-shape/'),
        lnk('Island Kitchens', '/modular-kitchen/island-kitchen/'),
        lnk('Open Kitchen Ideas', '/modular-kitchen/open-kitchen-ideas/'),
        lnk('Kitchen Storage', '/modular-kitchen/storage-solutions/'),
      ]],
      ['title' => 'Materials & fittings', 'links' => [
        lnk('Countertop Guide', '/modular-kitchen/countertop-guide/'),
        lnk('Kitchen Hardware', '/modular-kitchen/hardware-guide/'),
        lnk('Acrylic Finish', '/materials/acrylic-finish/'),
        lnk('Kitchen Tiles & Backsplash', '/materials/kitchen-tiles/'),
      ]],
      ['title' => 'Cost & decisions', 'gold' => true, 'links' => [
        lnk('Modular Kitchen Cost', '/cost/modular-kitchen-cost/'),
        lnk('Kitchen Calculator', '/calculators/modular-kitchen/'),
        lnk('Modular vs Carpenter', '/compare/modular-vs-carpenter-kitchen/'),
        lnk('Kitchen Vastu', '/vastu/kitchen-vastu/'),
        lnk('Hidden Kitchens', '/trends/hidden-kitchens/'),
      ]],
    ],
    'feature' => ['label' => 'Free tool', 'title' => 'Modular Kitchen Calculator', 'text' => 'Price your kitchen by running foot, finish and hardware.', 'href' => '/calculators/modular-kitchen/', 'cta' => 'Calculate now'],
  ],
  [
    'key' => 'wardrobe', 'label' => 'Wardrobes', 'href' => '/wardrobe/', 'icon' => '🚪', 'tier' => 1, 'menu' => true,
    'keyword' => 'wardrobe designs for bedroom',
    'blurb' => 'Hinged, sliding and walk-in wardrobes: sizes, internals, finishes and cost.',
    'groups' => [
      ['title' => 'Types', 'links' => [
        lnk('Sliding Wardrobes', '/wardrobe/sliding-wardrobe/'),
        lnk('Walk-in Closet', '/wardrobe/walk-in-closet/'),
        lnk('Wardrobe Internal Design', '/wardrobe/wardrobe-internal-design/'),
        lnk('Sliding vs Hinged Wardrobe', '/compare/sliding-vs-hinged-wardrobe/'),
        lnk('Vanity & Dressing', '/rooms/vanity-dressing/'),
      ]],
      ['title' => 'Cost & tools', 'gold' => true, 'links' => [
        lnk('Wardrobe Cost', '/cost/wardrobe-cost/'),
        lnk('Wardrobe Calculator', '/calculators/wardrobe-cost/'),
        lnk('Bedroom Interior Cost', '/cost/bedroom-interior-cost/'),
      ]],
      ['title' => 'Related', 'links' => [
        lnk('Master Bedroom Design', '/rooms/master-bedroom/'),
        lnk('Bedroom Vastu', '/vastu/bedroom-vastu/'),
        lnk('Laminate Guide', '/materials/laminate-guide/'),
      ]],
    ],
  ],
  [
    'key' => 'cost', 'label' => 'Cost', 'href' => '/cost/', 'icon' => '₹', 'tier' => 1, 'menu' => true,
    'keyword' => 'interior design cost',
    'blurb' => 'BHK-wise and room-wise budgets, with calculators.',
    'groups' => [
      ['title' => 'Full home', 'links' => [
        lnk('1 BHK Interior Cost', '/cost/1-bhk-interior-cost/'),
        lnk('2 BHK Interior Cost', '/cost/2-bhk-interior-cost/'),
        lnk('3 BHK Interior Cost', '/cost/3-bhk-interior-cost/'),
        lnk('4 BHK & Villa Cost', '/cost/4-bhk-villa-cost/'),
        lnk('Home Renovation Cost', '/cost/home-renovation-cost/'),
        lnk('Essential vs Luxury Budget', '/cost/essential-vs-luxury-budget/'),
      ]],
      ['title' => 'Room-wise', 'links' => [
        lnk('Modular Kitchen Cost', '/cost/modular-kitchen-cost/'),
        lnk('Wardrobe Cost', '/cost/wardrobe-cost/'),
        lnk('False Ceiling Cost', '/cost/false-ceiling-cost/'),
        lnk('Flooring Cost per Sq Ft', '/cost/flooring-cost-per-sqft/'),
        lnk('Bathroom Renovation Cost', '/cost/bathroom-renovation-cost/'),
        lnk('Bedroom Interior Cost', '/cost/bedroom-interior-cost/'),
        lnk('Pooja Room Cost', '/cost/pooja-room-cost/'),
        lnk('TV Unit Cost', '/cost/tv-unit-cost/'),
      ]],
      ['title' => 'Calculators', 'gold' => true, 'links' => [
        lnk('Room-by-Room Quote Builder', '/calculators/home-interior-quote/'),
        lnk('Interior Cost Calculator', '/calculators/interior-cost/'),
        lnk('Modular Kitchen Calculator', '/calculators/modular-kitchen/'),
        lnk('Wardrobe Calculator', '/calculators/wardrobe-cost/'),
      ]],
    ],
    'feature' => ['label' => 'Free tool', 'title' => 'Interior Cost Calculator', 'text' => 'Room-by-room estimate in 2 minutes. No signup.', 'href' => '/calculators/interior-cost/', 'cta' => 'Calculate now'],
  ],
  [
    'key' => 'false-ceiling', 'label' => 'False Ceiling', 'href' => '/false-ceiling/', 'icon' => '💡', 'tier' => 1,
    'keyword' => 'false ceiling design',
    'blurb' => 'Gypsum, POP, PVC and wood ceilings, with lighting and cost.',
    'groups' => [
      ['title' => 'Plan it', 'links' => [
        lnk('False Ceiling Cost', '/cost/false-ceiling-cost/'),
        lnk('Lighting Design', '/planning/lighting-design/'),
        lnk('Electrical Points', '/planning/electrical-points/'),
        lnk('Living Room Guide', '/rooms/living-room/'),
        lnk('Master Bedroom Design', '/rooms/master-bedroom/'),
      ]],
    ],
  ],
  [
    'key' => 'flooring', 'label' => 'Flooring', 'href' => '/flooring/', 'icon' => '▦', 'tier' => 1,
    'keyword' => 'flooring types in India',
    'blurb' => 'Tiles, marble, granite, wood and vinyl compared for Indian homes.',
    'groups' => [
      ['title' => 'Materials', 'links' => [
        lnk('Marble Guide', '/materials/marble-guide/'),
        lnk('Granite Guide', '/materials/granite-guide/'),
        lnk('Kitchen Tiles & Backsplash', '/materials/kitchen-tiles/'),
        lnk('Dado Tile Guide', '/materials/dado-tiles/'),
      ]],
      ['title' => 'Cost & rooms', 'links' => [
        lnk('Flooring Cost per Sq Ft', '/cost/flooring-cost-per-sqft/'),
        lnk('Living Room Flooring', '/rooms/living-room-flooring/'),
        lnk('Terracotta Tiles', '/trends/terracotta-tiles/'),
      ]],
    ],
  ],

  /* ---------------- TIER 2 — VOLUME PILLARS ---------------- */
  [
    'key' => 'materials', 'label' => 'Materials', 'href' => '/materials/', 'icon' => '🪵', 'tier' => 2,
    'keyword' => 'interior design materials',
    'blurb' => 'Boards, finishes and stone — specs, grades and prices.',
    'groups' => [
      ['title' => 'Boards & panels', 'links' => [
        lnk('Plywood Guide', '/materials/plywood-guide/'),
        lnk('Marine Plywood (BWP)', '/materials/marine-plywood/'),
        lnk('MR Plywood', '/materials/mr-plywood/'),
        lnk('BWR Plywood', '/materials/bwr-plywood/'),
        lnk('Gurjan Plywood', '/materials/gurjan-plywood/'),
        lnk('HDHMR Board', '/materials/hdhmr-board/'),
        lnk('MDF Board', '/materials/mdf-board/'),
        lnk('Particle Board', '/materials/particle-board/'),
        lnk('Block Board', '/materials/block-board/'),
        lnk('WPC Board', '/materials/wpc-board/'),
      ]],
      ['title' => 'Finishes', 'links' => [
        lnk('Laminate Guide', '/materials/laminate-guide/'),
        lnk('Acrylic Finish', '/materials/acrylic-finish/'),
        lnk('Wood Veneer', '/materials/wood-veneer/'),
        lnk('PU Finish', '/materials/pu-finish/'),
        lnk('Membrane Finish', '/materials/membrane-finish/'),
        lnk('Glass Finish', '/materials/glass-finish/'),
        lnk('Lacquered Glass', '/materials/lacquered-glass/'),
        lnk('Duco Paint', '/materials/duco-paint/'),
      ]],
      ['title' => 'Surfaces & stone', 'links' => [
        lnk('Quartz Countertop', '/materials/quartz-countertop/'),
        lnk('Granite Guide', '/materials/granite-guide/'),
        lnk('Marble Guide', '/materials/marble-guide/'),
        lnk('Kitchen Tiles & Backsplash', '/materials/kitchen-tiles/'),
        lnk('Dado Tile Guide', '/materials/dado-tiles/'),
      ]],
      ['title' => '✦ Compare', 'gold' => true, 'links' => [
        lnk('MDF vs Plywood', '/compare/mdf-vs-plywood/'),
        lnk('Acrylic vs Laminate', '/compare/acrylic-vs-laminate/'),
        lnk('Quartz vs Granite', '/compare/quartz-vs-granite/'),
        lnk('Veneer vs Laminate', '/compare/veneer-vs-laminate/'),
        lnk('HDHMR vs Plywood', '/compare/hdhmr-vs-plywood/'),
        lnk('BWP vs BWR vs MR Plywood', '/compare/bwp-vs-bwr-vs-mr-plywood/'),
        lnk('Calibrated vs Normal Plywood', '/compare/calibrated-vs-normal-plywood/'),
        lnk('Engineered Wood vs Plywood', '/compare/engineered-wood-vs-plywood/'),
        lnk('Matte vs Glossy Finish', '/compare/matte-vs-glossy-finish/'),
        lnk('Modular vs Carpenter', '/compare/modular-vs-carpenter-kitchen/'),
        lnk('All Comparisons', '/compare/'),
        lnk('Materials Glossary A–Z', '/glossary/'),
      ]],
    ],
  ],
  [
    'key' => 'styles', 'label' => 'Styles', 'href' => '/styles/', 'icon' => '✦', 'tier' => 2, 'menu' => true,
    'keyword' => 'interior design styles',
    'blurb' => 'Design styles that work in Indian homes, and how to get each look.',
    'groups' => [
      ['title' => 'Contemporary', 'links' => [
        lnk('Modern', '/styles/modern/'),
        lnk('Contemporary', '/styles/contemporary/'),
        lnk('Minimalist', '/styles/minimalist/'),
        lnk('Monochrome', '/styles/monochrome/'),
        lnk('Transitional', '/styles/transitional/'),
      ]],
      ['title' => 'Global', 'links' => [
        lnk('Scandinavian', '/styles/scandinavian/'),
        lnk('Japandi', '/styles/japandi/'),
        lnk('Industrial', '/styles/industrial/'),
        lnk('Mid-Century Modern', '/styles/mid-century-modern/'),
        lnk('Mediterranean & Coastal', '/styles/mediterranean/'),
      ]],
      ['title' => 'Indian & traditional', 'links' => [
        lnk('Traditional Indian', '/styles/traditional-indian/'),
        lnk('Indo-Colonial', '/styles/indo-colonial/'),
        lnk('Ethnic Handcraft Accents', '/styles/ethnic-handcraft/'),
        lnk('Kerala & Rajasthan Styles', '/styles/regional-kerala-rajasthan/'),
      ]],
      ['title' => 'Luxury & premium', 'links' => [
        lnk('Luxury Interiors', '/styles/luxury-interior/'),
        lnk('Art Deco Revival', '/styles/art-deco/'),
        lnk('Bespoke Furniture', '/styles/bespoke-furniture/'),
        lnk('Premium Material Pairings', '/styles/premium-material-pairings/'),
      ]],
    ],
  ],
  [
    'key' => 'rooms', 'label' => 'Room Guides', 'href' => '/rooms/', 'icon' => '🛋️', 'tier' => 2,
    'keyword' => 'room by room interior design',
    'blurb' => 'Layouts, storage, materials and costs, room by room.',
    'groups' => [
      ['title' => 'Living spaces', 'links' => [
        lnk('Living Room Guide', '/rooms/living-room/'),
        lnk('TV Unit Designs', '/furniture/tv-unit-design/'),
        lnk('Sofa Buying Guide', '/furniture/sofa-buying-guide/'),
        lnk('Living Room Materials', '/rooms/living-room-materials/'),
        lnk('Living Room Flooring', '/rooms/living-room-flooring/'),
        lnk('Dining Room Guide', '/rooms/dining-room/'),
      ]],
      ['title' => 'Bedrooms & private', 'links' => [
        lnk('Master Bedroom Design', '/rooms/master-bedroom/'),
        lnk('Kids Room Ideas', '/rooms/kids-room/'),
        lnk('Study & Home Office', '/rooms/study-home-office/'),
        lnk('Vanity & Dressing', '/rooms/vanity-dressing/'),
        lnk('Bathroom Interior Guide', '/rooms/bathroom/'),
      ]],
      ['title' => 'Speciality spaces', 'links' => [
        lnk('Pooja Room Designs', '/rooms/pooja-room/'),
        lnk('Crockery Unit Designs', '/rooms/crockery-unit/'),
        lnk('Foyer & Entrance', '/rooms/foyer-entrance/'),
        lnk('Balcony Ideas', '/rooms/balcony/'),
        lnk('Utility Area Design', '/rooms/utility-area/'),
        lnk('Home Bar Ideas', '/rooms/home-bar/'),
      ]],
    ],
  ],
  [
    'key' => 'planning', 'label' => 'Home Planning', 'href' => '/planning/', 'icon' => '📐', 'tier' => 2,
    'keyword' => 'home interior planning',
    'blurb' => 'Where to start: checklists, electricals, lighting, storage and budget.',
    'groups' => [
      ['title' => 'Plan', 'links' => [
        lnk('Planning Checklist', '/planning/home-planning-checklist/'),
        lnk('Electrical Points', '/planning/electrical-points/'),
        lnk('Lighting Design', '/planning/lighting-design/'),
        lnk('Storage, Room by Room', '/planning/storage-room-by-room/'),
        lnk('Furniture Layout', '/planning/furniture-layout/'),
        lnk('Budget Planning & Control', '/planning/budget-control/'),
        lnk('Interior Project Timeline', '/planning/interior-timeline/'),
        lnk('Standard Interior Dimensions', '/planning/standard-interior-dimensions/'),
      ]],
      ['title' => 'Decide', 'links' => [
        lnk('How to Choose a Designer', '/planning/how-to-choose-interior-designer/'),
        lnk('Interior Design Mistakes', '/planning/interior-design-mistakes/'),
        lnk('New Home Handover Checklist', '/planning/new-home-handover-checklist/'),
        lnk('Small Home Hacks', '/lifestyle/small-home-hacks/'),
        lnk('Materials Glossary A–Z', '/glossary/'),
        lnk('Hardware Terms', '/glossary/hardware-terms/'),
      ]],
    ],
  ],

  /* ---------------- TIER 3 — TRUST & FRESHNESS ---------------- */
  [
    'key' => 'vastu', 'label' => 'Vastu', 'href' => '/vastu/', 'icon' => '🪔', 'tier' => 3,
    'keyword' => 'home vastu tips',
    'blurb' => 'Practical vastu for kitchens, bedrooms, pooja rooms and entrances.',
    'groups' => [
      ['title' => 'Room by room', 'links' => [
        lnk('Kitchen Vastu', '/vastu/kitchen-vastu/'),
        lnk('Bedroom Vastu', '/vastu/bedroom-vastu/'),
        lnk('Pooja Room Vastu', '/vastu/pooja-room-vastu/'),
        lnk('Main Door Vastu', '/vastu/main-door-vastu/'),
      ]],
    ],
  ],
  [
    'key' => 'trends', 'label' => 'Trends 2026', 'href' => '/trends/', 'icon' => '📈', 'tier' => 3,
    'keyword' => 'interior design trends 2026',
    'blurb' => 'What is new this year, and which trends will last.',
    'groups' => [
      ['title' => 'Trending now', 'links' => [
        lnk('Fluted Panels', '/trends/fluted-panels/'),
        lnk('Curved & Arched Furniture', '/trends/curved-arched-furniture/'),
        lnk('Warm Neutrals', '/trends/warm-neutrals/'),
        lnk('Biophilic Design', '/trends/biophilic-design/'),
        lnk('Hidden Kitchens', '/trends/hidden-kitchens/'),
        lnk('Smart Storage', '/trends/smart-storage/'),
        lnk('Limewash Textures', '/trends/limewash-textures/'),
      ]],
      ['title' => 'Material trends', 'links' => [
        lnk('Japandi Palette', '/trends/japandi-palette/'),
        lnk('Terracotta Tiles', '/trends/terracotta-tiles/'),
        lnk('Stone-Look Laminates', '/trends/stone-look-laminates/'),
        lnk('Bouclé & Textured Fabrics', '/trends/boucle-fabrics/'),
        lnk('Rattan & Cane Accents', '/trends/rattan-cane/'),
        lnk('Matte Black Hardware', '/trends/matte-black-hardware/'),
      ]],
    ],
  ],

  /* ---------------- PHASE 2 (Oct 2026) — DESIGN & MATERIAL HUB PILLARS ---------------- */
  [
    'key' => 'wall-design', 'label' => 'Wall Design', 'href' => '/wall-design/', 'icon' => '🧱', 'tier' => 2,
    'keyword' => 'wall design for living room',
    'blurb' => 'Panelling, texture paint, cladding and wallpaper: materials, specs and cost.',
    'groups' => [
      ['title' => 'Wall finishes', 'links' => [
        lnk('Wall Panelling Design', '/wall-design/wall-panelling/'),
        lnk('PVC vs WPC Wall Panels', '/wall-design/pvc-vs-wpc-wall-panels/'),
        lnk('Texture Paint Designs', '/wall-design/texture-paint/'),
        lnk('Stone Wall Cladding', '/wall-design/stone-wall-cladding/'),
        lnk('Wallpaper Guide', '/wall-design/wallpaper-guide/'),
      ]],
      ['title' => 'Related', 'links' => [
        lnk('Fluted Panels', '/trends/fluted-panels/'),
        lnk('Limewash Textures', '/trends/limewash-textures/'),
        lnk('Wallpaper Cost per Sq Ft', '/blogs/wallpaper-cost-per-sq-ft/'),
      ]],
    ],
  ],
  [
    'key' => 'colour', 'label' => 'Colour Guide', 'href' => '/colour/', 'icon' => '🎨', 'tier' => 2,
    'keyword' => 'wall colour combination',
    'blurb' => 'Colour combinations by room, paint finishes and how colour behaves in Indian light.',
    'groups' => [
      ['title' => 'Combinations', 'links' => [
        lnk('Bedroom Colour Combinations', '/colour/bedroom-colour-combination/'),
        lnk('Living Room Colour Combinations', '/colour/living-room-colour-combination/'),
        lnk('Exterior House Colours', '/colour/exterior-house-colour/'),
        lnk('Kitchen Colour Combinations', '/blogs/kitchen-colour-combinations/'),
      ]],
      ['title' => 'Paint science', 'links' => [
        lnk('Types of Paint Finish', '/colour/paint-finishes/'),
        lnk('Colour Psychology at Home', '/colour/colour-psychology/'),
      ]],
    ],
  ],
  [
    'key' => 'doors', 'label' => 'Doors & Partitions', 'href' => '/doors/', 'icon' => '🚪', 'tier' => 2,
    'keyword' => 'door design for home',
    'blurb' => 'Main, room, sliding and pooja doors, glass partitions: materials, sizes and cost.',
    'groups' => [
      ['title' => 'Doors', 'links' => [
        lnk('Main Door Design', '/doors/main-door-design/'),
        lnk('Flush Door vs Solid Wood Door', '/doors/flush-vs-solid-wood-door/'),
        lnk('Sliding Door Design', '/doors/sliding-door-design/'),
        lnk('Pooja Room Door Design', '/doors/pooja-room-door-design/'),
      ]],
      ['title' => 'Partitions', 'links' => [
        lnk('Glass Partition Design', '/doors/glass-partition-design/'),
        lnk('Main Door Vastu', '/vastu/main-door-vastu/'),
      ]],
    ],
  ],
  [
    'key' => 'furniture', 'label' => 'Furniture Design', 'href' => '/furniture/', 'icon' => '🛋️', 'tier' => 2,
    'keyword' => 'furniture design for home',
    'blurb' => 'Built-in and loose furniture: sizes, materials, construction and cost.',
    'groups' => [
      ['title' => 'Living & dining', 'links' => [
        lnk('TV Unit Design', '/furniture/tv-unit-design/'),
        lnk('Sofa Buying Guide', '/furniture/sofa-buying-guide/'),
        lnk('Shoe Rack Design', '/furniture/shoe-rack-design/'),
        lnk('Crockery Unit Design', '/rooms/crockery-unit/'),
      ]],
      ['title' => 'Bedroom & study', 'links' => [
        lnk('Bed Design with Storage', '/furniture/bed-design/'),
        lnk('Dressing Table Design', '/furniture/dressing-table-design/'),
        lnk('Study Table Design', '/furniture/study-table-design/'),
      ]],
    ],
  ],

  /* ---------------- FIND A DESIGNER — the "interior designers near me" pillar and its city pages ----------------
     Firms, cities and price bands for these pages: includes/data/designers.php */
  [
    'key' => 'interior-designers', 'label' => 'Interior Designers', 'href' => '/interior-designer-near-me/', 'icon' => '📍', 'tier' => 1,
    'keyword' => 'interior designers near me',
    'blurb' => 'Interior designers by city and locality, with addresses, segments and how to compare them.',
    'groups' => [
      ['title' => 'Metro cities', 'links' => [
        lnk('Bangalore', '/interior-designers/bangalore/'),
        lnk('Mumbai', '/interior-designers/mumbai/'),
        lnk('Hyderabad', '/interior-designers/hyderabad/'),
        lnk('Chennai', '/interior-designers/chennai/'),
        lnk('Pune', '/interior-designers/pune/'),
        lnk('Gurgaon', '/interior-designers/gurgaon/'),
        lnk('Delhi', '/interior-designers/delhi/'),
        lnk('Kolkata', '/interior-designers/kolkata/'),
      ]],
      ['title' => 'Bangalore', 'links' => [
        lnk('Luxury designers', '/interior-designers/bangalore/luxury/'),
        lnk('Budget designers', '/interior-designers/bangalore/budget/'),
        lnk('Kitchen designers', '/interior-designers/bangalore/kitchen/'),
        lnk('Indiranagar', '/interior-designers/bangalore/indiranagar/'),
      ]],
      ['title' => 'Mumbai', 'links' => [
        lnk('Luxury designers', '/interior-designers/mumbai/luxury/'),
        lnk('Andheri', '/interior-designers/mumbai/andheri/'),
        lnk('Bandra', '/interior-designers/mumbai/bandra/'),
        lnk('Malad', '/interior-designers/mumbai/malad/'),
        lnk('Mulund', '/interior-designers/mumbai/mulund/'),
      ]],
      ['title' => 'Hyderabad', 'links' => [lnk('Kukatpally', '/interior-designers/hyderabad/kukatpally/')]],
      ['title' => 'Chennai', 'links' => [
        lnk('Low-budget designers', '/interior-designers/chennai/low-budget/'),
        lnk('Architects and designers', '/interior-designers/chennai/architects/'),
      ]],
      ['title' => 'Pune', 'links' => [lnk('Kharadi', '/interior-designers/pune/kharadi/')]],
      ['title' => 'Offices, Delhi NCR', 'links' => [
        lnk('Office designers in Gurgaon', '/interior-designers/gurgaon/office/'),
        lnk('Office designers in Delhi', '/interior-designers/delhi/office/'),
      ]],
      ['title' => 'More cities', 'links' => [
        lnk('Coimbatore', '/interior-designers/coimbatore/'),
        lnk('Vizag', '/interior-designers/vizag/'),
        lnk('Madurai', '/interior-designers/madurai/'),
        lnk('Mysore', '/interior-designers/mysore/'),
        lnk('Vijayawada', '/interior-designers/vijayawada/'),
        lnk('Belgaum', '/interior-designers/belgaum/'),
        lnk('Trichy', '/interior-designers/trichy/'),
        lnk('Warangal', '/interior-designers/warangal/'),
        lnk('Erode', '/interior-designers/erode/'),
        lnk('Nellore', '/interior-designers/nellore/'),
        lnk('Tirunelveli', '/interior-designers/tirunelveli/'),
        lnk('Vellore', '/interior-designers/vellore/'),
      ]],
      ['title' => 'India and states', 'gold' => true, 'links' => [
        lnk('Best Interior Designers in India', '/interior-designers/india/'),
        lnk('Maharashtra', '/interior-designers/maharashtra/'),
        lnk('Famous Interior Designers of India', '/interior-designers/famous-interior-designers-india/'),
        lnk('How to Choose a Designer', '/planning/how-to-choose-interior-designer/'),
        lnk('Find a Designer Near You', '/services/find-designer/'),
      ]],
    ],
  ],

  /* ---------------- TRENDING DESIGNS — project gallery with filters (includes/data/trends.php) ---------------- */
  [
    'key' => 'trending-designs', 'label' => 'Designs', 'href' => '/trending-designs/', 'icon' => '🖼️', 'tier' => 0, 'menu' => true,
    'keyword' => 'trending interior designs',
    'blurb' => 'Homes and rooms from every state, with the firm, designer, style and approximate budget.',
    'groups' => [
      ['title' => 'Rooms', 'links' => [
        lnk('Modular Kitchens', '/trending-designs/?type=modular-kitchen'), lnk('Living Rooms', '/trending-designs/?type=living-room'),
        lnk('Master Bedrooms', '/trending-designs/?type=master-bedroom'), lnk('Kids Rooms', '/trending-designs/?type=kids-room'),
        lnk('Wardrobes', '/trending-designs/?type=wardrobe'), lnk('Pooja Rooms', '/trending-designs/?type=pooja-room'),
      ]],
      ['title' => 'Homes and spaces', 'links' => [
        lnk('Full Home Interiors', '/trending-designs/?type=full-home'), lnk('Villas and Houses', '/trending-designs/?type=villa'),
        lnk('Renovations', '/trending-designs/?type=renovation'), lnk('False Ceilings', '/trending-designs/?type=false-ceiling'),
        lnk('Offices', '/trending-designs/?type=office'), lnk('Cafés and Shops', '/trending-designs/?type=cafe-retail'),
      ]],
      ['title' => 'By budget', 'gold' => true, 'links' => [
        lnk('Under ₹3 lakh', '/trending-designs/?budget=under-3'), lnk('₹3–6 lakh', '/trending-designs/?budget=3-6'),
        lnk('₹6–10 lakh', '/trending-designs/?budget=6-10'), lnk('₹10–20 lakh', '/trending-designs/?budget=10-20'),
        lnk('All Trending Designs', '/trending-designs/'),
      ]],
    ],
    'feature' => ['label' => 'Directory', 'title' => 'Find a Designer', 'text' => 'Designers, freelancers, contractors and carpenters by area, pincode and reviews.', 'href' => '/services/find-designer/', 'cta' => 'Search near you'],
  ],

  /* ---------------- TOOLS, SERVICES, BLOG ---------------- */
  [
    'key' => 'calculators', 'label' => 'Calculators', 'href' => '/calculators/', 'icon' => '🧮', 'tier' => 0,
    'blurb' => 'Free calculators and planners. No signup.',
    'groups' => [
      ['title' => 'Free tools', 'gold' => true, 'links' => [
        lnk('Room-by-Room Quote Builder', '/calculators/home-interior-quote/'),
        lnk('Interior Cost Calculator', '/calculators/interior-cost/'),
        lnk('Modular Kitchen Calculator', '/calculators/modular-kitchen/'),
        lnk('Wardrobe Calculator', '/calculators/wardrobe-cost/'),
        lnk('Budget Planner', '/calculators/budget-planner/'),
        lnk('Material Selector', '/calculators/material-selector/'),
      ]],
    ],
  ],
  [
    'key' => 'services', 'label' => 'Services', 'href' => '/services/', 'icon' => '🤝', 'tier' => 0,
    'blurb' => 'Find a verified designer and compare quotes.',
    'groups' => [
      ['title' => 'Get help', 'links' => [
        lnk('Find a Designer', '/services/find-designer/'),
        lnk('Trending Designs', '/trending-designs/'),
        lnk('Get 3 Quotes', '/services/get-3-quotes/'),
        lnk('3D Visualisation', '/services/3d-visualisation/'),
        lnk('Turnkey Execution', '/services/turnkey-execution/'),
      ]],
      ['title' => 'Locations', 'links' => [
        lnk('Interior Designers Near Me', '/interior-designer-near-me/'),
        lnk('Interior Designers in Bangalore', '/interior-designers/bangalore/'),
        lnk('Interior Designers in Hosur', '/interior-designers/hosur/'),
      ]],
    ],
  ],
  [
    'key' => 'blog', 'label' => 'Blog', 'href' => '/blogs/', 'icon' => '✍️', 'tier' => 0, 'menu' => true,
    'blurb' => 'Design ideas, galleries and how-to articles.',
    'groups' => [],
  ],
];

/* Header: the pillar entries with 'menu' => true (keep it to six) plus one "Guides" menu
   that lists every other pillar. */
$GUIDES_MENU = [
  'key' => 'guides', 'label' => 'Guides', 'href' => '', 'groups' => [
    ['title' => 'Pillar guides', 'links' => [
      lnk('Materials', '/materials/'), lnk('Room Guides', '/rooms/'), lnk('False Ceiling', '/false-ceiling/'), lnk('Flooring', '/flooring/'),
    ]],
    ['title' => 'Design hub', 'links' => [
      lnk('Wall Design', '/wall-design/'), lnk('Colour Guide', '/colour/'), lnk('Doors & Partitions', '/doors/'), lnk('Furniture Design', '/furniture/'),
    ]],
    ['title' => 'Plan & decide', 'links' => [
      lnk('Home Planning', '/planning/'), lnk('Vastu', '/vastu/'), lnk('Trends 2026', '/trends/'), lnk('How to Choose a Designer', '/planning/how-to-choose-interior-designer/'),
    ]],
    ['title' => 'Reference & tools', 'gold' => true, 'links' => [
      lnk('Quote Builder', '/calculators/home-interior-quote/'), lnk('Calculators', '/calculators/'), lnk('Comparisons', '/compare/'), lnk('Materials Glossary A–Z', '/glossary/'), lnk('Find Interior Designers', '/interior-designer-near-me/'),
    ]],
  ],
];

$LEGAL_LINKS = [
  ['label' => 'About',   'href' => '/about/'],
  ['label' => 'Contact', 'href' => '/contact/'],
  ['label' => 'Blog',    'href' => '/blogs/'],
  ['label' => 'Privacy', 'href' => '/privacy/'],
  ['label' => 'Terms',   'href' => '/terms/'],
];

// A pillar by its key
function hub($key) {
  global $HUBS;
  foreach ($HUBS as $h) if ($h['key'] === $key) return $h;
  return null;
}
// The pillar a URL belongs to: the pillar whose folder the URL sits in, else the first pillar that lists it
function hub_for($url) {
  global $HUBS;
  foreach ($HUBS as $h) if ($h['href'] !== '' && $url !== $h['href'] && str_starts_with($url, $h['href'])) return $h;
  foreach ($HUBS as $h) foreach ($h['groups'] as $g) foreach ($g['links'] as $l) if ($l['href'] === $url) return $h;
  return null;
}
// Short menu label for a URL (used by breadcrumbs), or null
function nav_label($url) {
  global $HUBS, $GUIDES_MENU;
  $extra = ['/compare/' => 'Comparisons', '/glossary/' => 'Glossary', '/trending-designs/' => 'Trending Designs', '/services/find-designer/' => 'Find a Designer'];
  if (isset($extra[$url])) return $extra[$url];
  foreach ($HUBS as $h) {
    if ($h['href'] === $url) return $h['label'];
    foreach ($h['groups'] as $g) foreach ($g['links'] as $l) if ($l['href'] === $url) return $l['label'];
  }
  return null;
}

/* Footer columns: every pillar, then company and location links (only live pages show). */
$FOOTER = [
  'Kitchen & Wardrobes' => [
    lnk('Modular Kitchen Guide', '/modular-kitchen/'), lnk('Modular Kitchen Cost', '/cost/modular-kitchen-cost/'), lnk('Kitchen Calculator', '/calculators/modular-kitchen/'),
    lnk('Wardrobe Guide', '/wardrobe/'), lnk('Sliding Wardrobes', '/wardrobe/sliding-wardrobe/'), lnk('Wardrobe Cost', '/cost/wardrobe-cost/'),
  ],
  'Cost Guides' => [
    lnk('Interior Cost Guide', '/cost/'), lnk('1 BHK Interior Cost', '/cost/1-bhk-interior-cost/'), lnk('2 BHK Interior Cost', '/cost/2-bhk-interior-cost/'),
    lnk('3 BHK Interior Cost', '/cost/3-bhk-interior-cost/'), lnk('False Ceiling Cost', '/cost/false-ceiling-cost/'), lnk('Interior Cost Calculator', '/calculators/interior-cost/'),
    lnk('Room-by-Room Quote Builder', '/calculators/home-interior-quote/'),
  ],
  'Design' => [
    lnk('Interior Design Styles', '/styles/'), lnk('Room Guides', '/rooms/'), lnk('False Ceiling Guide', '/false-ceiling/'),
    lnk('Flooring Guide', '/flooring/'), lnk('Wall Design', '/wall-design/'), lnk('Colour Guide', '/colour/'),
    lnk('Doors & Partitions', '/doors/'), lnk('Furniture Design', '/furniture/'), lnk('Trends 2026', '/trends/'),
    lnk('Trending Designs', '/trending-designs/'),
  ],
  'Learn' => [
    lnk('Materials Guide', '/materials/'), lnk('Home Planning', '/planning/'), lnk('Home Vastu Guide', '/vastu/'),
    lnk('Comparisons', '/compare/'), lnk('Materials Glossary A–Z', '/glossary/'), lnk('Blog', '/blogs/'),
  ],
  'Company' => [
    lnk('About', '/about/'), lnk('Contact', '/contact/'), lnk('Portfolio', '/portfolio/'),
    lnk('Find a Designer', '/services/find-designer/'),
  ],
  'Find Interior Designers' => [
    lnk('Find a Designer (directory)', '/services/find-designer/'),
    lnk('Interior Designers Near Me', '/interior-designer-near-me/'), lnk('Best in India', '/interior-designers/india/'),
    lnk('Bangalore', '/interior-designers/bangalore/'), lnk('Mumbai', '/interior-designers/mumbai/'), lnk('Hyderabad', '/interior-designers/hyderabad/'),
    lnk('Chennai', '/interior-designers/chennai/'), lnk('Pune', '/interior-designers/pune/'), lnk('Gurgaon', '/interior-designers/gurgaon/'),
    lnk('Delhi', '/interior-designers/delhi/'), lnk('Kolkata', '/interior-designers/kolkata/'),
  ],
];
