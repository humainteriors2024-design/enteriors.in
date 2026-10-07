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
  'quote' => [
    'grades' => [   // multiplier, warranty, what it is
      'basic'         => ['Basic', 0.75, '1 yr workmanship', 'MR ply carcass with suede or duco-style painted finish: the most economical start.'],
      'essential'     => ['Essential', 0.85, '1 yr workmanship', 'MR ply carcass and shutters with standard laminate.'],
      'essential_bwp' => ['Essential + BWP in wet areas', 0.92, '2 yr workmanship', 'MR ply, with BWP (boiling-water-proof) ply in kitchen and bathroom, standard laminate.'],
      'standard'      => ['Standard', 1.00, '3 yr warranty', 'IS-grade MR and BWP ply with branded laminates: best value for most homes.'],
      'standard_gloss' => ['Standard, high gloss', 1.10, '3 yr warranty', 'MR and BWP ply with high-gloss laminate for a reflective look.'],
      'premium'       => ['Premium acrylic', 1.22, '5 yr warranty', 'MR and BWP ply with acrylic: mirror-gloss shutters, seamless edges.'],
      'premium_brand' => ['Premium, branded', 1.32, '5 yr branded', 'Branded laminate or acrylic with a manufacturer-backed 5-year warranty.'],
      'premium_plus'  => ['Premium, 10-year acrylic', 1.45, '10 yr branded', 'Ten-year branded acrylic: top-tier surface durability and colour fastness.'],
      'luxury'        => ['Luxury', 1.65, '15 yr warranty', 'Natural veneer or PU-coated finish on premium systems: flagship craftsmanship.'],
    ],
    'hardware' => [   // fitting ranges by price level (brand-neutral names; mention brands in the text only if you work with them)
      'basic'    => ['Basic', 0.90, 'Standard hinges and channels: functional, budget-friendly.'],
      'standard' => ['Standard branded', 1.00, 'Reliable Indian brand ranges with soft-close options (base pricing).'],
      'better'   => ['Mid-premium', 1.10, 'German-engineered ranges with smoother soft-close motion.'],
      'premium'  => ['Premium', 1.18, 'Premium German fittings and organiser systems.'],
      'topend'   => ['Top-end', 1.32, 'Austrian flagship ranges: lifetime-grade motion hardware.'],
    ],
    /* "Choose my own materials": the grade multiplier is worked out from the board, finish and shutter
       core you pick (₹ per sq ft, from the workbook), relative to the Standard reference set. */
    'materials' => [
      'carcass' => ['commercial_mr' => ['Commercial MR ply', 669.06], 'calibrated_mr' => ['Calibrated MR ply', 744.66], 'century_mr' => ['Branded MR ply', 771.45], 'green_mr' => ['Branded MR ply, premium', 775.95], 'bwp' => ['BWP ply', 916.10]],
      'finish'  => ['basic' => ['Basic laminate', 270.45], 'matt' => ['Matt laminate', 303.16], 'glossy' => ['Glossy laminate', 316.02], 'textured' => ['Textured laminate', 321.02], 'high_gloss' => ['High-gloss laminate', 367.45], 'acrylic' => ['Acrylic', 388.87], 'pu' => ['PU finish', 406.73], 'veneer' => ['Veneer', 416.45]],
      'shutter' => ['commercial' => ['Commercial ply 16 mm', 127.63], 'calibrated' => ['Calibrated ply 16 mm', 168.84], 'hdhmr' => ['HDHMR 16 mm', 244.60], 'century' => ['Branded ply 16 mm', 248.10], 'green' => ['Branded ply 16 mm, premium', 277.70], 'bwp' => ['BWP ply 16 mm', 305.30]],
      'reference' => ['century_mr', 'matt', 'century'],   // = Standard grade (multiplier 1.00)
    ],
    'design_fee' => [0, 15, 0],   // % of woodwork: min, max, default
    'areas' => [   // area => items: id => [name, description, unit sqft|each, L ft, H ft, qty, base rate ₹, grade weight, hardware weight, on by default, add-on]
      'living' => ['name' => 'Living Room', 'icon' => '🛋️', 'items' => [
        'lv_tvpanel' => ['TV Unit Panel', 'MR ply + laminate backdrop panel for TV wall', 'sqft', 7, 4, 1, 900, 1, 0, 0, 0],
        'lv_tvbelow' => ['TV Below Unit', 'Storage unit below TV with soft-close shutters', 'sqft', 7, 1.5, 1, 1750, 1, 0.35, 0, 0],
        'lv_wallunit' => ['Display / Wall Unit', 'Open + closed display wall unit', 'sqft', 4, 7, 1, 1750, 1, 0.35, 0, 0],
        'lv_foyer' => ['Foyer Unit', 'Entrance shoe/storage unit with shutters', 'sqft', 5, 1.5, 1, 1750, 1, 0.35, 0, 0],
        'lv_falseceiling' => ['Living Room False Ceiling', 'Gypsum board peripheral/full false ceiling (excl. paint & electricals)', 'sqft', 1, 1, 280, 100, 0, 0, 0, 0],
        'lv_fluted' => ['Fluted / WPC Panel', 'Decorative fluted wall panel', 'sqft', 1, 8, 8, 1050, 1, 0, 0, 1],
        'lv_sofa_highlight' => ['Sofa Wall Highlight', 'Feature wall behind sofa', 'each', 1, 1, 1, 25000, 0, 0, 0, 1],
        'lv_wallpaper' => ['Wallpaper + Installation', 'Premium wallpaper for accent wall', 'each', 1, 1, 1, 9700, 0, 0, 0, 1],
        'lv_lighting' => ['Profile / Strip Lighting Package', 'Cove + strip lights with driver', 'each', 1, 1, 1, 8500, 0, 0, 0, 1],
        'lv_curtain' => ['Curtain Rods (Motorised optional)', 'Full living room curtain track', 'each', 1, 1, 1, 6000, 0, 0, 0, 1],
        'lv_shoe_pullout' => ['Foyer Shoe Rack Pull-Out', 'Angled SS shoe pull-out inside foyer unit', 'each', 1, 1, 1, 4500, 0, 1, 0, 1],
      ]],
      'dining' => ['name' => 'Dining Area', 'icon' => '🍽️', 'items' => [
        'dn_base' => ['Dining Base Unit', 'Crockery base storage unit', 'sqft', 4, 2.5, 1, 1750, 1, 0.35, 0, 0],
        'dn_wall' => ['Dining Wall Unit', 'Overhead wall-mounted unit', 'sqft', 4, 2, 1, 1750, 1, 0.35, 0, 0],
        'dn_tall' => ['Crockery Tall Unit', 'Full-height crockery storage with glass shutters', 'sqft', 1.5, 7, 1, 1750, 1, 0.35, 0, 0],
        'dn_table' => ['Dining Table with 6 Chairs', 'Custom dining set as per design', 'each', 1, 1, 1, 68000, 1, 0.35, 0, 1],
        'dn_lighting' => ['Pendant / Crockery Lighting', 'Light points + decorative fixtures', 'each', 1, 1, 1, 2500, 0, 0, 0, 1],
        'dn_cutlery_drawer' => ['Crockery Unit Soft-Close Drawers', 'Internal soft-close drawer set (2 nos)', 'each', 1, 1, 1, 5200, 0, 1, 0, 1],
      ]],
      'kitchen' => ['name' => 'Kitchen', 'icon' => '🍳', 'items' => [
        'kt_base' => ['Kitchen Base Unit', 'BWP 710 grade ply carcass & shutter, laminate finish', 'sqft', 13, 2.5, 1, 1950, 1, 0.35, 1, 0],
        'kt_wall' => ['Kitchen Wall Unit', 'MR ply carcass & shutter, laminate finish', 'sqft', 10, 2, 1, 1750, 1, 0.35, 0, 0],
        'kt_tall' => ['Kitchen Tall Unit', 'BWP ply tall storage unit', 'sqft', 2, 7, 1, 1950, 1, 0.35, 0, 0],
        'kt_loft' => ['Kitchen Loft', 'Frame + shutter loft above wall units', 'sqft', 15, 2.5, 1, 1170, 1, 0.35, 0, 0],
        'kt_granite' => ['Granite / Quartz Countertop', 'Counter top with installation & nosing', 'sqft', 1, 1, 35, 670, 0, 0, 0, 0],
        'kt_tandem' => ['Tandem Pull-Out (Pot & Pan)', 'Full-extension soft-close basket (brand as selected)', 'each', 1, 1, 2, 5900, 0, 1, 0, 1],
        'kt_cutlery' => ['PVC Cutlery Tray', 'Modular organiser tray for top drawer', 'each', 1, 1, 1, 1300, 0, 1, 0, 1],
        'kt_bottle' => ['Bottle Pull-Out Unit', '2-tier bottle pull-out organiser', 'each', 1, 1, 1, 5800, 0, 1, 0, 1],
        'kt_corner' => ['Corner Unit (Magic Corner)', 'LeMans / corner pull-out unit', 'each', 1, 1, 1, 11500, 0, 1, 0, 1],
        'kt_wicker' => ['Wicker Basket', 'Wooden runner wicker basket', 'each', 1, 1, 1, 10500, 0, 1, 0, 1],
        'kt_plate' => ['Plate & Thali Basket (SS)', 'Stainless steel plate + thali basket, soft-close', 'each', 1, 1, 1, 4200, 0, 1, 0, 1],
        'kt_wastebin' => ['Pull-Out Waste Bin', 'Under-counter detachable waste bin on channels', 'each', 1, 1, 1, 3600, 0, 1, 0, 1],
        'kt_detergent' => ['Under-Sink Detergent Holder', 'Detergent + brush holder pull-out under sink', 'each', 1, 1, 1, 2800, 0, 1, 0, 1],
        'kt_rolling' => ['Rolling Shutter Unit', 'Aluminium tambour appliance garage on counter', 'each', 1, 1, 1, 14500, 0, 1, 0, 1],
        'kt_handleless' => ['Handle-less Profile', 'Aluminium profile handles, base + wall unit', 'each', 1, 1, 1, 13000, 0, 1, 0, 1],
        'kt_chimney' => ['Chimney + Hob (with fitting)', 'Approx. depending on brand & model selected', 'each', 1, 1, 1, 33850, 0, 0, 0, 1],
        'kt_sink' => ['Sink + Tap + Fitting', 'Granite cutting, waste pipe, angle cock, tap connection', 'each', 1, 1, 1, 4200, 0, 0, 0, 1],
      ]],
      'mbr' => ['name' => 'Master Bedroom (Bedroom 1)', 'icon' => '🛏️', 'items' => [
        'mb_wardrobe' => ['Hinged Wardrobe', 'MR ply carcass, HDHMR shutter, laminate finish', 'sqft', 7, 7, 1, 1800, 1, 0.35, 1, 0],
        'mb_cot' => ['Cot (King Size) with Storage', 'Hydraulic storage cot with side table', 'sqft', 6, 6.5, 1, 1500, 1, 0.35, 1, 0],
        'mb_loft' => ['Wardrobe Loft', 'Frame + shutter loft above wardrobe', 'sqft', 7, 2.5, 1, 1170, 1, 0.35, 0, 0],
        'mb_dresser' => ['Dressing Unit + Mirror', 'Dresser with drawers and mirror', 'sqft', 2.75, 7, 1, 1550, 1, 0.35, 0, 0],
        'mb_panel' => ['Bed Back Panel', 'Decorative paneling behind headboard', 'sqft', 6, 8, 1, 1175, 1, 0, 0, 0],
        'mb_study' => ['Study / Work Table', 'Wall-mounted work table unit', 'sqft', 3.5, 2.5, 1, 1175, 1, 0.35, 0, 0],
        'mb_headboard' => ['Cushioned Headboard', 'Fabric/rexine cushioned headboard, 1" with back ply', 'sqft', 6, 2, 12, 1105, 0, 0, 0, 1],
        'mb_mirror' => ['Long Dressing Mirror', 'Bronze / plain mirror, fixed', 'each', 1, 1, 1, 3850, 0, 0, 0, 1],
        'mb_lighting' => ['Dressing + Bed Light Points', 'Light points, 5amp plugs, slim profile light', 'each', 1, 1, 1, 3450, 0, 0, 0, 1],
        'mb_trouser' => ['Trouser Pull-Out', 'Soft-close trouser rack inside wardrobe', 'each', 1, 1, 1, 4800, 0, 1, 0, 1],
        'mb_pulldown' => ['Pull-Down Hanger Rod', 'Lift-assisted hanger for loft-height access', 'each', 1, 1, 1, 8500, 0, 1, 0, 1],
        'mb_tie' => ['Tie, Belt & Scarf Organiser', 'Pull-out multi-hook organiser rail', 'each', 1, 1, 1, 2400, 0, 1, 0, 1],
        'mb_jewel' => ['Jewellery Drawer with Lock', 'Velvet-lined organiser drawer with cam lock', 'each', 1, 1, 1, 6500, 0, 1, 0, 1],
        'mb_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'each', 1, 1, 1, 5200, 0, 1, 0, 1],
        'mb_pullmirror' => ['Pull-Out Dressing Mirror', 'Swivel pull-out mirror inside wardrobe', 'each', 1, 1, 1, 5500, 0, 1, 0, 1],
        'mb_locker' => ['Locker / Safe Provision', 'Reinforced locker cavity with ply box + lock', 'each', 1, 1, 1, 4500, 0, 1, 0, 1],
        'mb_sensorled' => ['Wardrobe Sensor LED Strip', 'Auto on/off profile light inside wardrobe', 'each', 1, 1, 1, 3200, 0, 0, 0, 1],
      ]],
      'bed2' => ['name' => 'Bedroom 2', 'icon' => '🛌', 'items' => [
        'b2_wardrobe' => ['Hinged Wardrobe', 'MR ply carcass, laminate finish', 'sqft', 6, 7, 1, 1800, 1, 0.35, 1, 0],
        'b2_cot' => ['Cot (Queen Size) with Storage', 'Box storage cot with headboard', 'sqft', 5, 6.5, 1, 1450, 1, 0.35, 0, 0],
        'b2_loft' => ['Wardrobe Loft', 'Frame + shutter loft', 'sqft', 6, 2.5, 1, 1170, 1, 0.35, 0, 0],
        'b2_study' => ['Study Table', 'Foldable / fixed wall-mounted study table', 'sqft', 3, 2.5, 1, 1175, 1, 0.35, 0, 0],
        'b2_mirror' => ['Mirror Panel', '5mm plain mirror with MDF back', 'sqft', 2.5, 5, 1, 520, 0, 0, 0, 0],
        'b2_bookshelf' => ['Book Shelf', 'Open shelving unit', 'sqft', 3.5, 2, 1, 1175, 1, 0, 0, 1],
        'b2_trouser' => ['Trouser Pull-Out', 'Soft-close trouser rack inside wardrobe', 'each', 1, 1, 1, 4800, 0, 1, 0, 1],
        'b2_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'each', 1, 1, 1, 5200, 0, 1, 0, 1],
        'b2_tie' => ['Tie & Belt Organiser', 'Pull-out multi-hook organiser rail', 'each', 1, 1, 1, 2400, 0, 1, 0, 1],
        'b2_sensorled' => ['Wardrobe Sensor LED Strip', 'Auto on/off profile light inside wardrobe', 'each', 1, 1, 1, 3200, 0, 0, 0, 1],
        'b2_headboard' => ['Cushioned Headboard', 'Fabric cushioned headboard with back ply', 'sqft', 5, 2, 10, 1105, 0, 0, 0, 1],
      ]],
      'bed3' => ['name' => 'Bedroom 3 / Guest Room', 'icon' => '🛏️', 'items' => [
        'b3_wardrobe' => ['Hinged Wardrobe', 'MR ply carcass, laminate finish', 'sqft', 6, 7, 1, 1800, 1, 0.35, 0, 0],
        'b3_loft' => ['Wardrobe Loft', 'Frame + shutter loft', 'sqft', 6, 2.5, 1, 1170, 1, 0.35, 0, 0],
        'b3_mirror' => ['Mirror Panel', '5mm plain mirror with MDF back', 'sqft', 2.5, 5, 1, 520, 0, 0, 0, 0],
        'b3_dresser' => ['Dressing Cabinet', 'Dressing unit with mirror & drawers', 'sqft', 2.75, 7, 1, 1550, 1, 0.35, 0, 1],
        'b3_trouser' => ['Trouser Pull-Out', 'Soft-close trouser rack inside wardrobe', 'each', 1, 1, 1, 4800, 0, 1, 0, 1],
        'b3_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'each', 1, 1, 1, 5200, 0, 1, 0, 1],
        'b3_sensorled' => ['Wardrobe Sensor LED Strip', 'Auto on/off profile light inside wardrobe', 'each', 1, 1, 1, 3200, 0, 0, 0, 1],
      ]],
      'kids' => ['name' => 'Kids Bedroom', 'icon' => '🧸', 'items' => [
        'kd_wardrobe' => ['Hinged Wardrobe', 'MR ply carcass, laminate finish, kid-friendly rounded edges', 'sqft', 6, 7, 1, 1800, 1, 0.35, 0, 0],
        'kd_loft' => ['Wardrobe Loft', 'Frame + shutter loft', 'sqft', 6, 2.5, 1, 1170, 1, 0.35, 0, 0],
        'kd_study' => ['Study Table + Wall Unit', 'Combined study & storage unit', 'sqft', 3, 2, 1, 1175, 1, 0.35, 0, 0],
        'kd_mirror' => ['Mirror Panel', '5mm plain mirror with MDF back', 'sqft', 2.5, 5, 1, 520, 0, 0, 0, 1],
        'kd_toy' => ['Open Toy Storage Unit', 'Low-height open cubby shelving, rounded edges', 'sqft', 3, 2.5, 1, 1175, 1, 0, 0, 1],
        'kd_pinboard' => ['Pin-Up / Soft Board', 'Fabric-wrapped soft board above study', 'each', 1, 1, 1, 1800, 0, 0, 0, 1],
        'kd_drawers' => ['Internal Soft-Close Drawers (2 nos)', 'Wardrobe internal drawer set on channels', 'each', 1, 1, 1, 5200, 0, 1, 0, 1],
      ]],
      'vanity' => ['name' => 'Bathroom / Vanity', 'icon' => '🚿', 'items' => [
        'va_vanity' => ['Vanity Under-Sink Unit', 'BWP 710 grade waterproof ply, laminate finish', 'sqft', 2.5, 2, 1, 1950, 1, 0.35, 0, 0],
        'va_hanging' => ['Hanging Cabinet', 'Wall-mounted waterproof storage cabinet', 'sqft', 2, 2.5, 1, 1950, 1, 0.35, 0, 0],
        'va_wallunit' => ['Wall Unit', 'BWP ply wall storage unit', 'sqft', 2, 2, 1, 1800, 1, 0.35, 0, 0],
        'va_mirror' => ['Mirror (Saint Gobain)', 'Plain mirror with edge polish', 'sqft', 2, 2, 1, 520, 0, 0, 0, 1],
        'va_glassshelf' => ['Glass Shelf (Arc)', 'Tempered glass shelf with fittings', 'each', 1, 1, 2, 1350, 0, 0, 0, 1],
        'va_towelrod' => ['Foldable Towel Rod', 'Wall-mounted foldable towel rod', 'each', 1, 1, 1, 2500, 0, 1, 0, 1],
      ]],
      'pooja' => ['name' => 'Pooja Unit', 'icon' => '🪔', 'items' => [
        'pj_unit' => ['Pooja Unit (Box + Door)', 'Laminate finish box unit; temple door supplied by client', 'sqft', 5, 1, 1, 1500, 1, 0.35, 0, 0],
        'pj_lighting' => ['Pooja Unit Lighting', 'Light point + 5amp plug + surface LED', 'each', 1, 1, 1, 2875, 0, 0, 0, 1],
        'pj_bell_drawer' => ['Pooja Drawer (Soft-Close)', 'Samagri storage drawer under unit', 'each', 1, 1, 1, 2600, 0, 1, 0, 1],
      ]],
      'other' => ['name' => 'Other / Services & Accessories', 'icon' => '🧰', 'items' => [
        'ot_sclose' => ['Soft-Close Hinges & Channels (Full House)', 'Approx. 5.5% of total woodwork value', 'each', 1, 1, 1, 18000, 0, 1, 0, 0],
        'ot_falseceiling_other' => ['Common Area False Ceiling', 'Gypsum board false ceiling (corridor / foyer)', 'sqft', 1, 1, 100, 100, 0, 0, 0, 0],
        'ot_debris' => ['Debris Removal', 'Post-installation debris clearance', 'each', 1, 1, 1, 8000, 0, 0, 0, 1],
        'ot_cleaning' => ['Deep Cleaning Service', 'Full house deep cleaning post-installation', 'each', 1, 1, 1, 12000, 0, 0, 0, 1],
        'ot_tarpaulin' => ['Floor Covering (Tarpaulin)', 'Protective floor covering during work', 'each', 1, 1, 1, 8000, 0, 0, 0, 1],
        'ot_unloading' => ['Unloading / Lift Charges', 'Where service lift unavailable', 'each', 1, 1, 1, 5000, 0, 0, 0, 1],
      ]],
    ],
  ],
];
