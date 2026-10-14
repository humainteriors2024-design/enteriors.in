<?php
/* =====================================================================
   ENTERIORS — ALL CALCULATOR RATES (the ONE file to edit when prices change)

   Every calculator on the site is worked out on the SERVER from these numbers
   (includes/calc/engine.php, answered by api/calculate.php). The browser only
   sends the choices and shows the result, so:
     • a rate changed here changes every calculator, every page that prints a
       rate table, and the estimate attached to new leads — at the same moment
     • nobody can edit the prices in their browser and send you a fake estimate

   Prices are indicative for Bengaluru (city factor 1.00), in ₹.
   After a change: update 'as_of', then open each calculator once to check.
   ===================================================================== */
return [
  'as_of' => 'Oct 2026',
  'gst'   => 0.18,

  /* City factor relative to Bengaluru. Used by every calculator. */
  'cities' => ['Bangalore' => 1.00, 'Hosur' => 0.92, 'Mysuru' => 0.93, 'Chennai' => 0.95, 'Hyderabad' => 0.96, 'Pune' => 0.98, 'Mumbai' => 1.18, 'Delhi NCR' => 1.10],

  /* ---------- 1. WHOLE-HOME ESTIMATOR (home page, /cost/, /calculators/interior-cost/, BHK pages)
     ₹ per sq ft of CARPET area including GST. Full scope = kitchen, wardrobes, TV unit,
     false ceiling, painting, lighting, curtains. ---------- */
  'home' => [
    'per_sqft' => ['essential' => 575, 'standard' => 900, 'premium' => 1400, 'luxury' => 2000],
    'grades'   => [   // label, what it means
      'essential' => ['Essential', 'Laminate, basic fittings'],
      'standard'  => ['Standard', 'Mixed finishes, branded fittings'],
      'premium'   => ['Premium', 'Acrylic, PU or veneer'],
      'luxury'    => ['Luxury', 'Bespoke, top-end hardware'],
    ],
    'sizes'    => ['1 BHK' => 550, '2 BHK' => 950, '3 BHK' => 1400, '4 BHK' => 2000, 'Villa / Duplex' => 3000],   // typical carpet area
    'scope'    => [   // multiplier, label, hint
      'core' => [0.5, 'Kitchen and wardrobes', 'The two essentials'],
      'full' => [1.0, 'Full interiors', 'Woodwork, ceiling, paint, lights'],
      'plus' => [1.3, 'Full interiors, flooring and bathrooms', 'For renovations'],
    ],
    'split'    => [   // share of a full-interiors budget, % (adds to 100); 'core' = part of "kitchen and wardrobes"
      ['Modular kitchen', 22, true], ['Wardrobes', 22, true], ['Living room and TV wall', 12, false], ['False ceiling and lighting', 16, false],
      ['Painting', 6, false], ['Dining, foyer and curtains', 16, false], ['Design and supervision', 6, true],
    ],
    'plus_label' => 'Flooring and bathrooms',
    'addons'   => [   // label, hint, ₹
      'balcony'    => ['Balcony', 'Deck, seating, planters', 60000],
      'utility'    => ['Utility', 'Cabinets, washer platform', 40000],
      'study'      => ['Study room', 'Desk, shelving, storage', 75000],
      'pooja'      => ['Pooja unit', 'Wall or standalone', 45000],
      'theatre'    => ['Media room', 'Panels, seating, acoustics', 150000],
      'automation' => ['Home automation', 'Lights and curtains', 120000],
    ],
    'spread'   => 0.12,   // ± range shown under the total
  ],

  /* ---------- 2. MODULAR KITCHEN CALCULATOR (/calculators/modular-kitchen/) ---------- */
  'kitchen' => [
    'carcass'  => [   // ₹ per running foot of base unit, laminate finish, branded hardware, before GST
      'bwp'   => ['BWP plywood', 4800, 'Best near sinks and dishwashers'],
      'bwr'   => ['BWR plywood', 4400, 'Good all-round kitchen board'],
      'hdhmr' => ['HDHMR board', 4000, 'Dense and smooth; keep edges sealed'],
      'mdf'   => ['MDF', 3500, 'Dry areas only'],
      'pb'    => ['Pre-laminated particle board', 3300, 'Budget; avoid near water'],
    ],
    'finish'   => [   // multiplier on cabinet cost
      'laminate' => ['Laminate', 1.00, 'Toughest everyday finish'],
      'membrane' => ['Membrane (PVC foil)', 1.08, 'Can wrap profiled doors; keep away from heat'],
      'acrylic'  => ['Acrylic', 1.35, 'Deep gloss or soft matte'],
      'glass'    => ['Lacquered glass', 1.50, 'Heaviest; needs sturdy hinges'],
      'veneer'   => ['Wood veneer', 1.55, 'Real grain; needs PU protection'],
      'pu'       => ['PU paint', 1.60, 'Any colour, repairable on site'],
    ],
    'hardware' => [
      'basic'   => ['Basic soft-close', 0.90, 'Unbranded or entry ranges'],
      'branded' => ['Branded standard', 1.00, 'Entry lines of the big fitting brands'],
      'premium' => ['Branded premium', 1.12, 'Full-extension, higher load ratings'],
      'topend'  => ['Top-end', 1.25, 'Premium European ranges, servo or push systems'],
    ],
    'layout'   => [   // label, multiplier for corner fittings and fillers, default base rft, default wall rft
      'straight'  => ['Straight', 1.00, 8, 8],
      'l'         => ['L-shape', 1.04, 12, 9],
      'parallel'  => ['Parallel', 1.02, 14, 10],
      'u'         => ['U-shape', 1.08, 16, 10],
      'peninsula' => ['Peninsula', 1.06, 14, 8],
      'island'    => ['Island', 1.10, 14, 8],
    ],
    'wall_factor' => 0.65, 'loft_factor' => 0.40, 'tall_factor' => 7,   // wall/loft per rft and each tall unit, as a share of the base rate
    'counter'  => ['granite' => ['Granite', 280], 'nano' => ['Nano white', 450], 'quartz' => ['Quartz', 650], 'steel' => ['Stainless steel', 700], 'solid' => ['Solid surface', 800], 'sintered' => ['Sintered stone', 1200]],   // ₹ per sq ft fixed
    'splash'   => ['none' => ['No backsplash', 0], 'tile' => ['Ceramic tile', 180], 'subway' => ['Subway / designer tile', 280], 'glass' => ['Lacquered glass', 550], 'quartz' => ['Quartz slab', 650]],   // ₹ per sq ft, 2 ft high
    'acc'      => [
      'cutlery' => ['Cutlery tray', 1800], 'cups' => ['Cup & saucer pull-out', 3500], 'wicker' => ['Wicker basket', 3200], 'bottle' => ['Bottle pull-out', 4500],
      'bin' => ['Dustbin pull-out', 3500], 'corner' => ['Corner carousel', 12000], 'lift' => ['Lift-up wall shutter', 6500], 'pantry' => ['Tall pantry pull-out', 24000], 'led' => ['Profile LED under wall units', 5000],
    ],
    'sink'     => ['ss1' => ['Steel, single bowl', 6500], 'ss2' => ['Steel, double bowl', 9500], 'hand' => ['Handmade steel', 14000], 'quartz' => ['Quartz sink', 18000]],
    'chimney'  => ['none' => ['None', 0], 'basic' => ['Basic', 12000], 'auto' => ['Auto-clean', 22000], 'prem' => ['Premium', 40000]],
    'hob'      => ['none' => ['None', 0], 'glass' => ['Glass-top hob', 9000], 'built' => ['Built-in hob', 18000]],
    'site'     => ['demo' => ['Remove old kitchen', 12000], 'plumb' => ['Plumbing changes', 10000], 'elec' => ['New electrical points', 8000], 'tile' => ['Wall or floor tiling', 18000]],
    'install'  => 0.05,   // installation and transport, share of woodwork + tops + accessories
    'spread'   => 0.10,
  ],

  /* ---------- 3. WARDROBE CALCULATOR (/calculators/wardrobe-cost/, bedroom and BHK pages) ---------- */
  'wardrobe' => [
    'door'   => ['hinged' => ['Hinged', 1400], 'sliding' => ['Sliding', 1650]],   // ₹ per sq ft of front, laminate, before GST
    'finish' => ['laminate' => ['Laminate', 1.0], 'acrylic' => ['Acrylic', 1.3], 'glass' => ['Lacquered glass', 1.4], 'veneer' => ['Wood veneer', 1.5], 'pu' => ['PU paint', 1.7]],
    'loft'   => 0.55,   // loft rate as a share of the wardrobe rate
    'acc'    => ['trouser' => ['Trouser pull-out', 4500], 'jewellery' => ['Jewellery drawer', 6000], 'shoe' => ['Shoe rack insert', 5000], 'light' => ['Sensor lighting', 3500], 'mirror' => ['Full-length mirror', 7000], 'lift' => ['Pull-down hanger', 9000]],
    'spread' => 0.10,
  ],

  /* ---------- 4. ROOM-BY-ROOM QUOTE BUILDER (/calculators/home-interior-quote/)
     From the July 2026 itemised calculator (v3) and the "Home Interior Calculator" workbook.
     Effective rate of an item = base rate × grade effect × hardware effect × city factor, where
       grade effect    = 1 + (grade multiplier − 1) × item's grade weight
       hardware effect = 1 + (hardware multiplier − 1) × item's hardware weight
     Woodwork: grade weight 1, hardware weight 0.35 · hardware accessories: 0 / 1 · services: 0 / 0 ---------- */
  /* ---------- 4. ROOM-BY-ROOM INTERIOR QUOTE (/calculators/home-interior-quote/) — rebuilt Oct 2026 ----------
     NO MULTIPLIERS. Every rupee comes from a rate written here, added up line by line on the server:
       woodwork rate per sq ft of front = box board + shutter core + finish + fittings + making
         'cabinet'  box + shutter + finish + fittings + making      'open'  box + finish + making (no doors)
         'panel'    shutter core + finish + making (wall panels)
         making     the item's own number below: factory making, edge banding, back panels, transport,
                    installation and overheads, per sq ft of front
       'fitting'  five prices, one per fittings range below      'each'  one fixed price per piece
       'rate'     ₹ per sq ft, fixed                              'counter' / 'ceiling'  ₹ per sq ft of the countertop / ceiling picked
     Kitchen base and tall units and bathroom cabinets ('wet' = 1) use the wet-area board, not the box board.
     Bengaluru trade rates, before GST. The visitor only ever sees each line's final rate and amount. */
  'quote' => [
    'homes' => [   // quick start: rooms ticked for each home type (their usual modules come on)
      '1bhk'   => ['1 BHK', ['living', 'kitchen', 'mbr', 'vanity', 'other']],
      '2bhk'   => ['2 BHK', ['living', 'kitchen', 'mbr', 'bed2', 'vanity', 'pooja', 'other']],
      '3bhk'   => ['3 BHK', ['living', 'dining', 'kitchen', 'mbr', 'bed2', 'bed3', 'vanity', 'pooja', 'other']],
      '4bhk'   => ['4 BHK or villa', ['living', 'dining', 'kitchen', 'mbr', 'bed2', 'bed3', 'kids', 'vanity', 'pooja', 'other']],
      'custom' => ['Pick rooms myself', []],
    ],
    'default_home' => '2bhk',

    /* Material choices. Each option: [name, ₹ per sq ft of front, what it is (shown in the spec sheet), where it suits / what to check] */
    'specs' => [
      'carcass' => ['label' => 'Box (carcass) board', 'default' => 'branded_mr', 'options' => [
        'commercial_mr' => ['Commercial MR plywood, 18 mm', 380, 'Unbranded moisture-resistant plywood for cabinet sides, shelves and backs.', 'Dry rooms on a tight budget. Ask for the thickness and a sample sheet.'],
        'hdhmr'         => ['HDHMR board, 18 mm', 400, 'High-density, high-moisture-resistant fibre board: dense, flat and smooth.', 'Wardrobes and dry units. Edges must be sealed; not for sink cabinets.'],
        'calibrated_mr' => ['Calibrated MR plywood, 18 mm', 420, 'MR plywood sanded to an even thickness, so laminates sit flat and joints stay tight.', 'Good value for wardrobes, TV units and wall units.'],
        'branded_mr'    => ['Branded MR plywood, IS:303, 18 mm', 470, 'Moisture-resistant plywood from a national brand, made to IS:303 with a stamped grade.', 'The usual choice for dry areas. Check the IS:303 stamp on every sheet.'],
        'branded_bwr'   => ['Branded BWR plywood, 18 mm', 520, 'Boiling-water-resistant plywood: better glue line than MR for humid rooms.', 'Bedrooms on outer walls, coastal or very humid homes.'],
        'bwp'           => ['BWP marine plywood, IS:710, 18 mm', 590, 'Boiling-water-proof plywood made to IS:710 with phenolic glue.', 'Kitchen sink and hob units, bathroom vanities.'],
        'gurjan_bwp'    => ['Gurjan BWP plywood, IS:710, 18 mm', 680, 'BWP plywood with gurjan hardwood veneers throughout, heavier and stronger.', 'Top-end kitchens and vanities that should last 15 years or more.'],
      ]],
      'wet' => ['label' => 'Board in wet areas (sink, hob and vanity units)', 'default' => 'bwp', 'options' => 'carcass'],   // same list as the box board
      'shutter' => ['label' => 'Shutter (door) core', 'default' => 'branded_ply', 'options' => [
        'commercial'  => ['Commercial plywood, 18 mm', 110, 'Unbranded plywood core for the doors and drawer fronts.', 'Budget work; check for warping on tall doors.'],
        'hdhmr'       => ['HDHMR, 18 mm', 140, 'Dense fibre-board core that stays flat and takes routing and profiles well.', 'Tall wardrobe doors and handle-less profiles.'],
        'calibrated'  => ['Calibrated plywood, 18 mm', 150, 'Even-thickness plywood core, so doors line up and gaps stay equal.', 'A good middle choice for most rooms.'],
        'branded_ply' => ['Branded MR plywood, 18 mm', 170, 'National-brand IS:303 plywood core with good screw holding.', 'The usual choice; holds hinges well for years.'],
        'branded_bwp' => ['Branded BWP plywood, 18 mm', 210, 'IS:710 plywood core for doors near water.', 'Sink and dishwasher doors, bathroom vanities.'],
      ]],
      'finish' => ['label' => 'Shutter finish', 'default' => 'matt_lam', 'options' => [
        'basic_lam' => ['Laminate 0.8 mm, regional brand', 120, 'Decorative laminate on the outside, 0.8 mm liner inside.', 'Lowest cost; fewer colours and textures.'],
        'matt_lam'  => ['Laminate 1 mm, national brand, matt or suede', 170, '1 mm decorative laminate from a national brand, with a matching liner and edge band.', 'Toughest everyday finish; hides fingerprints.'],
        'gloss_lam' => ['High-gloss laminate 1 mm', 210, 'Glossy decorative laminate with matching edge band.', 'Reflective look at laminate prices; shows scratches more.'],
        'af_lam'    => ['Anti-fingerprint or textured laminate', 240, 'Super-matt, anti-fingerprint or wood-texture laminate.', 'Handle-less kitchens and dark colours.'],
        'acrylic'   => ['Acrylic 1.5 mm, edge-matched', 360, 'Acrylic sheet on the front with a matching acrylic edge band: mirror gloss or soft matt.', 'Kitchens and wardrobes that should look seamless.'],
        'pu'        => ['PU paint, matt or gloss', 450, 'Polyurethane paint sprayed in layers on MDF or ply, in any colour.', 'Any shade, curved profiles; can be touched up.'],
        'veneer'    => ['Natural wood veneer with PU polish', 480, 'Real wood veneer sealed with clear PU polish.', 'Warm, natural grain for living rooms and bedrooms.'],
      ]],
      'hardware' => ['label' => 'Fittings range (hinges, channels, pull-outs)', 'default' => 'standard', 'options' => [   // index 0–4 = the price used for every 'fitting' item
        'basic'    => ['Normal hinges and channels', 40, 'Standard hinges and telescopic channels without soft-close.', 'Rarely used doors only.'],
        'standard' => ['Soft-close, Indian branded', 90, 'Soft-close hinges and full-extension channels from an established Indian brand.', 'Best value for most homes; ask for the brand and range by name.'],
        'better'   => ['Soft-close, German-engineered range', 140, 'German-engineered hinges, channels and baskets with smoother, quieter motion.', 'Kitchens and wardrobes in daily use.'],
        'premium'  => ['Premium German fittings', 190, 'Premium German hinges, tandem boxes and organisers with longer warranties.', 'Heavy drawers and tall pull-outs.'],
        'topend'   => ['Top-end Austrian ranges', 260, 'Flagship Austrian hinge, lift-up and drawer systems.', 'Lifetime-grade motion; top-end kitchens.'],
      ]],
      'counter' => ['label' => 'Kitchen countertop', 'default' => 'granite', 'options' => [   // ₹ per sq ft fixed, with cutting and nosing
        'granite'         => ['Granite 18–20 mm, polished', 550, 'Indian granite such as Jet Black or Tan Brown, polished, with sink and hob cut-outs.', 'Hard-wearing and heat-proof; the default for Indian cooking.'],
        'granite_premium' => ['Premium granite 20 mm, polished', 700, 'Select granite with fewer veins and a uniform colour.', 'When the counter is a design feature.'],
        'quartz'          => ['Quartz 15 mm, national brand', 900, 'Engineered quartz: uniform colour, non-porous.', 'Low upkeep; keep hot pans off it.'],
        'sintered'        => ['Sintered stone 12 mm', 1400, 'Large-format sintered stone slabs.', 'Heat and stain resistant; premium kitchens and islands.'],
      ]],
      'ceiling' => ['label' => 'False ceiling', 'default' => 'gypsum', 'options' => [   // ₹ per sq ft fixed, excludes paint and electricals
        'pop'      => ['POP on GI frame', 90, 'Plaster of Paris on a galvanised iron frame.', 'Curves and mouldings; takes longer to dry.'],
        'gypsum'   => ['Gypsum board on GI frame', 100, 'Gypsum boards on a galvanised iron channel frame, joints taped and finished.', 'The usual choice for living rooms and bedrooms.'],
        'gypsum_mr'=> ['Moisture-resistant gypsum board', 125, 'Moisture-resistant (green) gypsum board on a GI frame.', 'Kitchens, balconies and humid rooms.'],
        'wood'     => ['Wooden rafters or veneer panels', 450, 'Wooden rafters or veneer-faced panels on a frame.', 'Feature ceilings in living and dining rooms.'],
      ]],
    ],
    'packages' => [   // quick picks that fill the material choices above (no price of their own)
      'essential' => ['Essential', 'Commercial ply, regional laminate, normal fittings', ['carcass' => 'commercial_mr', 'wet' => 'bwp', 'shutter' => 'commercial', 'finish' => 'basic_lam', 'hardware' => 'basic', 'counter' => 'granite', 'ceiling' => 'gypsum']],
      'standard'  => ['Standard', 'Branded ply, 1 mm laminate, soft-close', ['carcass' => 'branded_mr', 'wet' => 'bwp', 'shutter' => 'branded_ply', 'finish' => 'matt_lam', 'hardware' => 'standard', 'counter' => 'granite', 'ceiling' => 'gypsum']],
      'premium'   => ['Premium', 'BWR ply, acrylic, German fittings, quartz', ['carcass' => 'branded_bwr', 'wet' => 'bwp', 'shutter' => 'branded_ply', 'finish' => 'acrylic', 'hardware' => 'better', 'counter' => 'quartz', 'ceiling' => 'gypsum']],
      'luxury'    => ['Luxury', 'Gurjan BWP, veneer or PU, top-end fittings', ['carcass' => 'branded_bwr', 'wet' => 'gurjan_bwp', 'shutter' => 'branded_bwp', 'finish' => 'veneer', 'hardware' => 'topend', 'counter' => 'sintered', 'ceiling' => 'gypsum']],
    ],
    'default_package' => 'standard',
    'warranty' => [   // shown in the spec sheet, by box board (typical manufacturer cover; the firm's own workmanship warranty is separate)
      'commercial_mr' => 'Usually no board warranty', 'hdhmr' => 'Board maker\'s warranty varies', 'calibrated_mr' => 'Usually 1–5 years on the board',
      'branded_mr' => 'Typically 10–25 years on the board (IS:303 brands)', 'branded_bwr' => 'Typically 15–25 years on the board', 'bwp' => 'Typically 15–30 years on the board (IS:710 brands)', 'gurjan_bwp' => 'Typically 25 years to lifetime on the board',
    ],

    /* Rooms and items: id => [name, description, kind, L ft, H ft, qty, price, on by default, add-on, wet]
       price = making ₹/sq ft (cabinet, open, panel) · ₹ each · ₹/sq ft (rate) · [5 prices] (fitting) · 0 (counter, ceiling: priced by the choice above) */
    'areas' => [
      'living' => ['name' => 'Living Room', 'icon' => '🛋️', 'items' => [
        'lv_tvpanel' => ['TV Unit Panel', 'Backdrop panel for the TV wall', 'panel', 7, 4, 1, 560, 1, 0, 0],
        'lv_tvbelow' => ['TV Below Unit', 'Storage unit below TV with soft-close shutters', 'cabinet', 7, 1.5, 1, 850, 1, 0, 0],
        'lv_wallunit' => ['Display / Wall Unit', 'Open + closed display wall unit', 'cabinet', 4, 7, 1, 850, 0, 0, 0],
        'lv_foyer' => ['Foyer Unit', 'Entrance shoe/storage unit with shutters', 'cabinet', 5, 1.5, 1, 850, 1, 0, 0],
        'lv_falseceiling' => ['Living Room False Ceiling', 'Peripheral or full false ceiling (excludes paint and electrical points)', 'ceiling', 1, 1, 280, 0, 1, 0, 0],
        'lv_fluted' => ['Fluted / WPC Panel', 'Decorative fluted wall panel', 'panel', 1, 8, 8, 710, 0, 1, 0],
        'lv_sofa_highlight' => ['Sofa Wall Highlight', 'Feature wall behind sofa', 'each', 1, 1, 1, 25000, 0, 1, 0],
        'lv_wallpaper' => ['Wallpaper + Installation', 'Premium wallpaper for accent wall', 'each', 1, 1, 1, 9700, 0, 1, 0],
        'lv_lighting' => ['Profile / Strip Lighting Package', 'Cove + strip lights with driver', 'each', 1, 1, 1, 8500, 0, 1, 0],
        'lv_curtain' => ['Curtain Rods (Motorised optional)', 'Full living room curtain track', 'each', 1, 1, 1, 6000, 0, 1, 0],
        'lv_shoe_pullout' => ['Foyer Shoe Rack Pull-Out', 'Angled SS shoe pull-out inside foyer unit', 'fitting', 1, 1, 1, [3400, 4500, 5850, 7200, 9450], 0, 1, 0],
      ]],
      'dining' => ['name' => 'Dining Area', 'icon' => '🍽️', 'items' => [
        'dn_base' => ['Dining Base Unit', 'Crockery base storage unit', 'cabinet', 4, 2.5, 1, 850, 1, 0, 0],
        'dn_wall' => ['Dining Wall Unit', 'Overhead wall-mounted unit', 'cabinet', 4, 2, 1, 850, 1, 0, 0],
        'dn_tall' => ['Crockery Tall Unit', 'Full-height crockery storage with glass shutters', 'cabinet', 1.5, 7, 1, 850, 0, 0, 0],
        'dn_table' => ['Dining Table with 6 Chairs', 'Custom dining set as per design', 'each', 1, 1, 1, 68000, 0, 1, 0],
        'dn_lighting' => ['Pendant / Crockery Lighting', 'Light points + decorative fixtures', 'each', 1, 1, 1, 2500, 0, 1, 0],
        'dn_cutlery_drawer' => ['Crockery Unit Soft-Close Drawers', 'Internal soft-close drawer set (2 nos)', 'fitting', 1, 1, 1, [3900, 5200, 6750, 8300, 10900], 0, 1, 0],
      ]],
      'kitchen' => ['name' => 'Kitchen', 'icon' => '🍳', 'items' => [
        'kt_base' => ['Kitchen Base Unit', 'Base cabinets under the counter', 'cabinet', 13, 2.5, 1, 930, 1, 0, 1],
        'kt_wall' => ['Kitchen Wall Unit', 'Wall-hung cabinets above the counter', 'cabinet', 10, 2, 1, 850, 1, 0, 0],
        'kt_tall' => ['Kitchen Tall Unit', 'Full-height pantry or appliance unit', 'cabinet', 2, 7, 1, 930, 0, 0, 1],
        'kt_loft' => ['Kitchen Loft', 'Frame + shutter loft above wall units', 'cabinet', 15, 2.5, 1, 270, 1, 0, 0],
        'kt_granite' => ['Granite / Quartz Countertop', 'Countertop with cutting, installation and edge nosing', 'counter', 1, 1, 35, 0, 1, 0, 0],
        'kt_tandem' => ['Tandem Pull-Out (Pot & Pan)', 'Full-extension soft-close basket', 'fitting', 1, 1, 2, [4400, 5900, 7650, 9450, 12400], 1, 1, 0],
        'kt_cutlery' => ['PVC Cutlery Tray', 'Modular organiser tray for top drawer', 'fitting', 1, 1, 1, [1000, 1300, 1700, 2100, 2750], 1, 1, 0],
        'kt_bottle' => ['Bottle Pull-Out Unit', '2-tier bottle pull-out organiser', 'fitting', 1, 1, 1, [4350, 5800, 7550, 9300, 12200], 0, 1, 0],
        'kt_corner' => ['Corner Unit (Magic Corner)', 'LeMans / corner pull-out unit', 'fitting', 1, 1, 1, [8600, 11500, 14950, 18400, 24150], 0, 1, 0],
        'kt_wicker' => ['Wicker Basket', 'Wooden runner wicker basket', 'fitting', 1, 1, 1, [7900, 10500, 13650, 16800, 22050], 0, 1, 0],
        'kt_plate' => ['Plate & Thali Basket (SS)', 'Stainless steel plate + thali basket, soft-close', 'fitting', 1, 1, 1, [3150, 4200, 5450, 6700, 8800], 0, 1, 0],
        'kt_wastebin' => ['Pull-Out Waste Bin', 'Under-counter detachable waste bin on channels', 'fitting', 1, 1, 1, [2700, 3600, 4700, 5750, 7550], 0, 1, 0],
        'kt_detergent' => ['Under-Sink Detergent Holder', 'Detergent + brush holder pull-out under sink', 'fitting', 1, 1, 1, [2100, 2800, 3650, 4500, 5900], 0, 1, 0],
        'kt_rolling' => ['Rolling Shutter Unit', 'Aluminium tambour appliance garage on counter', 'fitting', 1, 1, 1, [10900, 14500, 18850, 23200, 30450], 0, 1, 0],
        'kt_handleless' => ['Handle-less Profile', 'Aluminium profile handles, base + wall unit', 'fitting', 1, 1, 1, [9750, 13000, 16900, 20800, 27300], 0, 1, 0],
        'kt_chimney' => ['Chimney + Hob (with fitting)', 'Approx. depending on brand & model selected', 'each', 1, 1, 1, 33850, 0, 1, 0],
        'kt_sink' => ['Sink + Tap + Fitting', 'Granite cutting, waste pipe, angle cock, tap connection', 'each', 1, 1, 1, 4200, 1, 1, 0],
      ]],
      'mbr' => ['name' => 'Master Bedroom (Bedroom 1)', 'icon' => '🛏️', 'items' => [
        'mb_wardrobe' => ['Hinged Wardrobe', 'Full-height hinged wardrobe', 'cabinet', 7, 7, 1, 900, 1, 0, 0],
        'mb_cot' => ['Cot (King Size) with Storage', 'Hydraulic storage cot with side table', 'cabinet', 6, 6.5, 1, 600, 1, 0, 0],
        'mb_loft' => ['Wardrobe Loft', 'Frame + shutter loft above wardrobe', 'cabinet', 7, 2.5, 1, 270, 1, 0, 0],
        'mb_dresser' => ['Dressing Unit + Mirror', 'Dresser with drawers and mirror', 'cabinet', 2.75, 7, 1, 650, 1, 0, 0],
        'mb_panel' => ['Bed Back Panel', 'Decorative paneling behind headboard', 'panel', 6, 8, 1, 835, 0, 0, 0],
        'mb_study' => ['Study / Work Table', 'Wall-mounted work table unit', 'cabinet', 3.5, 2.5, 1, 275, 0, 0, 0],
        'mb_headboard' => ['Cushioned Headboard', 'Fabric/rexine cushioned headboard, 1" with back ply', 'rate', 6, 2, 12, 1105, 0, 1, 0],
        'mb_mirror' => ['Long Dressing Mirror', 'Bronze / plain mirror, fixed', 'each', 1, 1, 1, 3850, 0, 1, 0],
        'mb_lighting' => ['Dressing + Bed Light Points', 'Light points, 5amp plugs, slim profile light', 'each', 1, 1, 1, 3450, 0, 1, 0],
        'mb_trouser' => ['Trouser Pull-Out', 'Soft-close trouser rack inside wardrobe', 'fitting', 1, 1, 1, [3600, 4800, 6250, 7700, 10100], 0, 1, 0],
        'mb_pulldown' => ['Pull-Down Hanger Rod', 'Lift-assisted hanger for loft-height access', 'fitting', 1, 1, 1, [6400, 8500, 11050, 13600, 17850], 0, 1, 0],
        'mb_tie' => ['Tie, Belt & Scarf Organiser', 'Pull-out multi-hook organiser rail', 'fitting', 1, 1, 1, [1800, 2400, 3100, 3850, 5050], 0, 1, 0],
        'mb_jewel' => ['Jewellery Drawer with Lock', 'Velvet-lined organiser drawer with cam lock', 'fitting', 1, 1, 1, [4900, 6500, 8450, 10400, 13650], 0, 1, 0],
        'mb_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'fitting', 1, 1, 1, [3900, 5200, 6750, 8300, 10900], 0, 1, 0],
        'mb_pullmirror' => ['Pull-Out Dressing Mirror', 'Swivel pull-out mirror inside wardrobe', 'fitting', 1, 1, 1, [4100, 5500, 7150, 8800, 11550], 0, 1, 0],
        'mb_locker' => ['Locker / Safe Provision', 'Reinforced locker cavity with ply box + lock', 'fitting', 1, 1, 1, [3400, 4500, 5850, 7200, 9450], 0, 1, 0],
        'mb_sensorled' => ['Wardrobe Sensor LED Strip', 'Auto on/off profile light inside wardrobe', 'each', 1, 1, 1, 3200, 0, 1, 0],
      ]],
      'bed2' => ['name' => 'Bedroom 2', 'icon' => '🛌', 'items' => [
        'b2_wardrobe' => ['Hinged Wardrobe', 'Full-height hinged wardrobe', 'cabinet', 6, 7, 1, 900, 1, 0, 0],
        'b2_cot' => ['Cot (Queen Size) with Storage', 'Box storage cot with headboard', 'cabinet', 5, 6.5, 1, 550, 1, 0, 0],
        'b2_loft' => ['Wardrobe Loft', 'Frame + shutter loft', 'cabinet', 6, 2.5, 1, 270, 1, 0, 0],
        'b2_study' => ['Study Table', 'Foldable / fixed wall-mounted study table', 'cabinet', 3, 2.5, 1, 275, 0, 0, 0],
        'b2_mirror' => ['Mirror Panel', '5mm plain mirror with MDF back', 'rate', 2.5, 5, 1, 520, 0, 0, 0],
        'b2_bookshelf' => ['Book Shelf', 'Open shelving unit', 'open', 3.5, 2, 1, 535, 0, 1, 0],
        'b2_trouser' => ['Trouser Pull-Out', 'Soft-close trouser rack inside wardrobe', 'fitting', 1, 1, 1, [3600, 4800, 6250, 7700, 10100], 0, 1, 0],
        'b2_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'fitting', 1, 1, 1, [3900, 5200, 6750, 8300, 10900], 0, 1, 0],
        'b2_tie' => ['Tie & Belt Organiser', 'Pull-out multi-hook organiser rail', 'fitting', 1, 1, 1, [1800, 2400, 3100, 3850, 5050], 0, 1, 0],
        'b2_sensorled' => ['Wardrobe Sensor LED Strip', 'Auto on/off profile light inside wardrobe', 'each', 1, 1, 1, 3200, 0, 1, 0],
        'b2_headboard' => ['Cushioned Headboard', 'Fabric cushioned headboard with back ply', 'rate', 5, 2, 10, 1105, 0, 1, 0],
      ]],
      'bed3' => ['name' => 'Bedroom 3 / Guest Room', 'icon' => '🛏️', 'items' => [
        'b3_wardrobe' => ['Hinged Wardrobe', 'Full-height hinged wardrobe', 'cabinet', 6, 7, 1, 900, 1, 0, 0],
        'b3_loft' => ['Wardrobe Loft', 'Frame + shutter loft', 'cabinet', 6, 2.5, 1, 270, 1, 0, 0],
        'b3_mirror' => ['Mirror Panel', '5mm plain mirror with MDF back', 'rate', 2.5, 5, 1, 520, 0, 0, 0],
        'b3_dresser' => ['Dressing Cabinet', 'Dressing unit with mirror & drawers', 'cabinet', 2.75, 7, 1, 650, 0, 1, 0],
        'b3_trouser' => ['Trouser Pull-Out', 'Soft-close trouser rack inside wardrobe', 'fitting', 1, 1, 1, [3600, 4800, 6250, 7700, 10100], 0, 1, 0],
        'b3_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'fitting', 1, 1, 1, [3900, 5200, 6750, 8300, 10900], 0, 1, 0],
        'b3_sensorled' => ['Wardrobe Sensor LED Strip', 'Auto on/off profile light inside wardrobe', 'each', 1, 1, 1, 3200, 0, 1, 0],
      ]],
      'kids' => ['name' => 'Kids Bedroom', 'icon' => '🧸', 'items' => [
        'kd_wardrobe' => ['Hinged Wardrobe', 'Hinged wardrobe with rounded edges', 'cabinet', 6, 7, 1, 900, 1, 0, 0],
        'kd_loft' => ['Wardrobe Loft', 'Frame + shutter loft', 'cabinet', 6, 2.5, 1, 270, 0, 0, 0],
        'kd_study' => ['Study Table + Wall Unit', 'Combined study & storage unit', 'cabinet', 3, 2, 1, 275, 1, 0, 0],
        'kd_mirror' => ['Mirror Panel', '5mm plain mirror with MDF back', 'rate', 2.5, 5, 1, 520, 0, 1, 0],
        'kd_toy' => ['Open Toy Storage Unit', 'Low-height open cubby shelving, rounded edges', 'open', 3, 2.5, 1, 535, 0, 1, 0],
        'kd_pinboard' => ['Pin-Up / Soft Board', 'Fabric-wrapped soft board above study', 'each', 1, 1, 1, 1800, 0, 1, 0],
        'kd_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'fitting', 1, 1, 1, [3900, 5200, 6750, 8300, 10900], 0, 1, 0],
      ]],
      'vanity' => ['name' => 'Bathroom / Vanity', 'icon' => '🚿', 'items' => [
        'va_vanity' => ['Vanity Under-Sink Unit', 'Cabinet under the wash basin', 'cabinet', 2.5, 2, 1, 930, 1, 0, 1],
        'va_hanging' => ['Hanging Cabinet', 'Wall-mounted cabinet', 'cabinet', 2, 2.5, 1, 930, 0, 0, 1],
        'va_wallunit' => ['Wall Unit', 'Wall storage unit', 'cabinet', 2, 2, 1, 780, 0, 0, 1],
        'va_mirror' => ['Mirror (Saint Gobain)', 'Plain mirror with edge polish', 'rate', 2, 2, 1, 520, 1, 1, 0],
        'va_glassshelf' => ['Glass Shelf (Arc)', 'Tempered glass shelf with fittings', 'each', 1, 1, 2, 1350, 0, 1, 0],
        'va_towelrod' => ['Foldable Towel Rod', 'Wall-mounted foldable towel rod', 'fitting', 1, 1, 1, [1900, 2500, 3250, 4000, 5250], 0, 1, 0],
      ]],
      'pooja' => ['name' => 'Pooja Unit', 'icon' => '🪔', 'items' => [
        'pj_unit' => ['Pooja Unit (Box + Door)', 'Box unit; temple door supplied by you', 'cabinet', 5, 1, 1, 600, 1, 0, 0],
        'pj_lighting' => ['Pooja Unit Lighting', 'Light point + 5amp plug + surface LED', 'each', 1, 1, 1, 2875, 0, 1, 0],
        'pj_bell_drawer' => ['Pooja Drawer (Soft-Close)', 'Samagri storage drawer under unit', 'fitting', 1, 1, 1, [1950, 2600, 3400, 4150, 5450], 0, 1, 0],
      ]],
      'other' => ['name' => 'Other / Services & Accessories', 'icon' => '🧰', 'items' => [
        'ot_falseceiling_other' => ['Common Area False Ceiling', 'False ceiling in the corridor or foyer', 'ceiling', 1, 1, 100, 0, 0, 0, 0],
        'ot_debris' => ['Debris Removal', 'Post-installation debris clearance', 'each', 1, 1, 1, 8000, 1, 1, 0],
        'ot_cleaning' => ['Deep Cleaning Service', 'Full house deep cleaning post-installation', 'each', 1, 1, 1, 12000, 1, 1, 0],
        'ot_tarpaulin' => ['Floor Covering (Tarpaulin)', 'Protective floor covering during work', 'each', 1, 1, 1, 8000, 0, 1, 0],
        'ot_unloading' => ['Unloading / Lift Charges', 'Where service lift unavailable', 'each', 1, 1, 1, 5000, 0, 1, 0],
      ]],
    ],
  ],
];
