<?php
/* =====================================================================
   BLOG POSTS — the list of every post. One entry per post.

   To add a post:
     1. Add an entry below. The key is the slug = the file name = the URL:
          'sliding-wardrobe-designs'  →  /blogs/sliding-wardrobe-designs.php  →  enteriors.in/blogs/sliding-wardrobe-designs/
     2. Copy _templates/blog-post.php to /blogs/<slug>.php and write the article.
     3. Put the images in /assets/blogs/<folder>/  (hero.jpg|png|webp = main image).

   Required   title, description, category, folder, hero_alt, date
   Optional   location   place the post is about (shown beside the category, used in schema)
              pillar     key of the parent pillar in nav.php, e.g. 'modular-kitchen' — adds the "part of" link
              seo_title  shorter Google title          updated    last edit, YYYY-MM-DD
              author     key from AUTHORS in config    draft      true = visible on staging only
              canonical  '/main/page/' when the post repeats a main guide: Google then counts the main
                         page only (no two pages competing for one search), and the post stays out of
                         the sitemap and llms.txt. The migrated older versions use this.
   Extras such as the quick answer, FAQ and related links are set at the top of the post file itself.
   ===================================================================== */
$POSTS = [

  /* MIGRATED-START — written by tools/migrate.php on 2026-10-04 */
  'kitchen-renovation-cost' => [
    'title'       => 'Kitchen Renovation Cost in India — What You Actually Pay',
    'seo_title'   => 'Kitchen Renovation Cost Guide 2026',
    'description' => 'Renovating a kitchen is the single highest-return investment in any Indian home — and the most misunderstood. Homeowners routinely start with one budget…',
    'category'    => 'Cost',
    'pillar'      => 'cost',
    'folder'      => 'kitchen-renovation-cost',
    'hero_alt'    => 'Kitchen Renovation Cost in India — What You Actually Pay',
    'date'        => '2026-06-11',
    'updated'     => '2026-10-04',
  ],
  'wallpaper-cost-per-sq-ft' => [
    'title'       => 'Wallpaper Cost Per Square Foot in India — The Only Guide You Need',
    'seo_title'   => 'Wallpaper Cost Per Square Foot in India (2026): Complete…',
    'description' => 'Complete guide to wallpaper cost per sq ft in India 2026. Types, brands, installation, maintenance, room-wise selection and comparison with paint.',
    'category'    => 'Cost',
    'pillar'      => 'cost',
    'folder'      => 'wallpaper-cost-per-sq-ft',
    'hero_alt'    => 'Wallpaper Cost Per Square Foot in India — The Only Guide You Need',
    'date'        => '2026-06-11',
    'updated'     => '2026-10-04',
  ],
  'hidden-costs-home-interiors' => [
    'title'       => 'Hidden Costs in Home Interiors: What Most Homeowners Discover Too Late',
    'seo_title'   => 'Hidden Costs in Home Interiors',
    'description' => 'Why Projects Exceed Budget What Are Hidden Costs? Major Hidden Cost Categories Reading Quotations Correctly Real-World Budget Examples Contingency Budget…',
    'category'    => 'Cost',
    'pillar'      => 'cost',
    'folder'      => 'hidden-costs-home-interiors',
    'hero_alt'    => 'Hidden Costs in Home Interiors: What Most Homeowners Discover Too Late',
    'date'        => '2026-06-19',
    'updated'     => '2026-10-04',
  ],
  '2-bhk-interior-cost-breakdown' => [
    'title'       => '2BHK Interior Design Cost: 800 to 1500 Sq Ft The Definitive Guide',
    'seo_title'   => '2BHK Interior Design Cost Guide 2026 | 800',
    'description' => 'Complete 2BHK interior design cost guide for 800–1500 sq ft homes. Covers materials, ply types, modular kitchen costs, wardrobe, flooring, labour…',
    'category'    => 'Cost',
    'pillar'      => 'cost',
    'folder'      => '2-bhk-interior-cost-breakdown',
    'hero_alt'    => '2BHK Interior Design Cost: 800 to 1500 Sq Ft The Definitive Guide',
    'date'        => '2026-06-10',
    'updated'     => '2026-10-04',
    'canonical'   => '/cost/2-bhk-interior-cost/',
  ],
  '3-bhk-interior-budget-planning' => [
    'title'       => '3 BHK Interior Cost Calculator & Budget Planning Guide',
    'seo_title'   => '3 BHK Interior Cost Calculator 2026',
    'description' => 'Plan your 3 BHK interior budget with our free cost calculator. Get room-wise breakdowns, material cost comparisons, and expert tips to save money on interiors.',
    'category'    => 'Cost',
    'pillar'      => 'cost',
    'folder'      => '3-bhk-interior-budget-planning',
    'hero_alt'    => '3 BHK Interior Cost Calculator & Budget Planning Guide',
    'date'        => '2026-06-14',
    'updated'     => '2026-10-04',
    'canonical'   => '/cost/3-bhk-interior-cost/',
  ],
  'acrylic-vs-laminate-complete-comparison' => [
    'title'       => 'Acrylic',
    'seo_title'   => 'Acrylic vs Laminate',
    'description' => 'Acrylic vs Laminate — the definitive guide comparing durability, scratch resistance, cost, maintenance, moisture resistance, UV stability, lifespan, and…',
    'category'    => 'Materials',
    'pillar'      => 'materials',
    'folder'      => 'acrylic-vs-laminate-complete-comparison',
    'hero_alt'    => 'Acrylic',
    'date'        => '2024-01-01',
    'updated'     => '2026-10-04',
    'canonical'   => '/compare/acrylic-vs-laminate/',
  ],
  'interior-material-brands-india' => [
    'title'       => 'Every Brand That Goes Into a Well-Built Home',
    'seo_title'   => 'Best Interior Material Brands in India 2026 | Complete Guide',
    'description' => 'A complete guide to the best interior material brands in India — plywood, laminates, hardware, handles, channels, acrylic, wall panelling, glass and more.…',
    'category'    => 'Materials',
    'pillar'      => 'materials',
    'folder'      => 'interior-material-brands-india',
    'hero_alt'    => 'Every Brand That Goes Into a Well-Built Home',
    'date'        => '2025-06-11',
    'updated'     => '2026-10-04',
  ],
  'acrylic-finish-benefits-costs' => [
    'title'       => 'Acrylic Finish for Home Interiors: Benefits, Costs & Real Solutions',
    'seo_title'   => 'Acrylic Finish for Home Interiors 2026',
    'description' => 'Complete guide to acrylic finish for home interiors — types, brands, costs, kitchen & wardrobe applications, acrylic vs laminate vs PU vs membrane vs glass…',
    'category'    => 'Materials',
    'pillar'      => 'materials',
    'folder'      => 'acrylic-finish-benefits-costs',
    'hero_alt'    => 'Acrylic Finish for Home Interiors: Benefits, Costs & Real Solutions',
    'date'        => '2026-06-18',
    'updated'     => '2026-10-04',
    'canonical'   => '/materials/acrylic-finish/',
  ],
  'veneer-finish-luxury-wood-guide' => [
    'title'       => 'Veneer Finish for Home Interiors: The Ultimate Luxury Wood Guide (2026)',
    'seo_title'   => 'Veneer Finish for Home Interiors',
    'description' => 'The definitive 2026 luxury handbook to veneer interiors — wood species, cutting patterns, matching techniques, grades, cost, durability, and how to choose…',
    'category'    => 'Materials',
    'pillar'      => 'materials',
    'folder'      => 'veneer-finish-luxury-wood-guide',
    'hero_alt'    => 'Veneer Finish for Home Interiors: The Ultimate Luxury Wood Guide (2026)',
    'date'        => '2026-06-25',
    'updated'     => '2026-10-04',
    'canonical'   => '/materials/wood-veneer/',
  ],
  'hdhmr-board-carpenter-guide' => [
    'title'       => 'HDHMR board for interiors: a carpenter\'s honest guide (and when NOT to use it).',
    'seo_title'   => 'HDHMR Board for Interiors: A Carpenter\'s Honest Guide (and…',
    'description' => 'The most honest HDHMR board guide for Indian homes — manufacturing, real 2026 prices, brand-by-brand comparison, counterfeit detection, installation…',
    'category'    => 'Materials',
    'pillar'      => 'materials',
    'folder'      => 'hdhmr-board-carpenter-guide',
    'hero_alt'    => 'HDHMR board for interiors: a carpenter\'s honest guide (and when NOT to use it).',
    'date'        => '2026-06-26',
    'updated'     => '2026-10-04',
    'canonical'   => '/materials/hdhmr-board/',
  ],
  'interior-materials-a-to-z' => [
    'title'       => 'Interior Materials A–Z: The Complete Designer\'s Glossary',
    'seo_title'   => 'Interior Materials A–Z: The Complete Glossary',
    'description' => 'The definitive A–Z glossary of interior design materials. From Acoustical panels to Zellige tiles — explore 100+ materials with detailed descriptions, uses…',
    'category'    => 'Materials',
    'pillar'      => 'materials',
    'folder'      => 'interior-materials-a-to-z',
    'hero_alt'    => 'Interior Materials A–Z: The Complete Designer\'s Glossary',
    'date'        => '2026-06-11',
    'updated'     => '2026-10-04',
    'canonical'   => '/glossary/',
  ],
  'l-shape-modular-kitchen-designs' => [
    'title'       => 'L-Shape Modular Kitchen Designs: Colors, Layouts & Smart Space Ideas',
    'seo_title'   => 'L-Shape Modular Kitchen Designs 2026',
    'description' => 'Complete guide to L-shape modular kitchen designs: 12 color themes, space-saving layouts, functional zone planning, material options, and cost estimates.…',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'l-shape-modular-kitchen-designs',
    'hero_alt'    => 'L-Shape Modular Kitchen Designs: Colors, Layouts & Smart Space Ideas',
    'date'        => '2026-06-30',
    'updated'     => '2026-10-04',
  ],
  'u-shape-kitchen-designs' => [
    'title'       => 'U-Shape Kitchen Designs: The Three-Wall Workflow Machine',
    'seo_title'   => 'U-Shape Kitchen Designs 2026',
    'description' => 'U-shape kitchen design guide focused on workflow, storage capacity & ergonomics. Real dimensions, who it suits, U vs L vs island comparison, ventilation…',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'u-shape-kitchen-designs',
    'hero_alt'    => 'U-Shape Kitchen Designs: The Three-Wall Workflow Machine',
    'date'        => '2026-06-30',
    'updated'     => '2026-10-04',
  ],
  'modular-kitchen-planning-guide' => [
    'title'       => 'The Complete Modular Kitchen Planning Guide',
    'seo_title'   => 'The Complete Modular Kitchen Guide 2026',
    'description' => 'The definitive modular kitchen guide — layouts, materials, platforms, lighting, ventilation, storage, hardware, and every mistake to avoid. Your complete…',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'modular-kitchen-planning-guide',
    'hero_alt'    => 'The Complete Modular Kitchen Planning Guide',
    'date'        => '2026-06-10',
    'updated'     => '2026-10-04',
    'canonical'   => '/modular-kitchen/',
  ],
  'kitchen-storage-solutions-guide' => [
    'title'       => 'Kitchen Storage Solutions: The Definitive Guide for Every Home & Budget',
    'seo_title'   => 'Kitchen Storage Solutions',
    'description' => 'Transform your kitchen with expert storage solutions. Discover cabinet types, drawer systems, marble vs tile comparisons, and need-based recommendations…',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'kitchen-storage-solutions-guide',
    'hero_alt'    => 'Kitchen Storage Solutions: The Definitive Guide for Every Home & Budget',
    'date'        => '2026-06-16',
    'updated'     => '2026-10-04',
    'canonical'   => '/modular-kitchen/storage-solutions/',
  ],
  'modular-kitchen-storage-units-explained' => [
    'title'       => 'Modular Kitchen Storage: Every Unit, Accessory & Organizer — Explained with Real Costs',
    'seo_title'   => 'Modular Kitchen Storage: The Complete 2026 Guide',
    'description' => 'The most detailed guide to modular kitchen storage in India. 18 storage types explained with real 2026 prices, Hettich vs Hafele vs Blum comparison…',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'modular-kitchen-storage-units-explained',
    'hero_alt'    => 'Modular Kitchen Storage: Every Unit, Accessory & Organizer — Explained with Real Costs',
    'date'        => '2026-06-27',
    'updated'     => '2026-10-04',
    'canonical'   => '/modular-kitchen/storage-solutions/',
  ],
  'modular-kitchen-colour-pairings' => [
    'title'       => 'Modular Kitchen Colour Combinations: Best Pairings & 2026 Trends',
    'seo_title'   => 'Modular Kitchen Colour Combinations',
    'description' => 'Colour decides how a kitchen feels before anything else — how open or compact it looks, how clean it appears through the day, and how well it hides daily…',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'modular-kitchen-colour-pairings',
    'hero_alt'    => 'Modular Kitchen Colour Combinations: Best Pairings & 2026 Trends',
    'date'        => '2026-06-20',
    'updated'     => '2026-10-04',
    'canonical'   => '/blogs/kitchen-colour-combinations/',
  ],
  'two-colour-kitchen-laminates' => [
    'title'       => 'Two color combinations for kitchen laminates that actually work in Indian homes.',
    'seo_title'   => 'Two Color Combinations for Kitchen Laminates',
    'description' => 'A decision-first guide to two color combinations for kitchen laminates. See 10 expert-picked palettes with swatches, pros, cons and a match matrix for…',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'two-colour-kitchen-laminates',
    'hero_alt'    => 'Two color combinations for kitchen laminates that actually work in Indian homes.',
    'date'        => '2026-06-25',
    'updated'     => '2026-10-04',
    'canonical'   => '/blogs/kitchen-colour-combinations/',
  ],
  'japandi-wabi-sabi-meets-scandinavian' => [
    'title'       => 'Japandi Interior Design: Where Japanese Wabi-Sabi Meets Scandinavian Hygge',
    'seo_title'   => 'Japandi Interior Design',
    'description' => 'Master Japandi interior design — the refined fusion of Japanese wabi-sabi and Scandinavian hygge. Colours, furniture, materials, principles, and sourcing…',
    'category'    => 'Styles',
    'pillar'      => 'styles',
    'folder'      => 'japandi-wabi-sabi-meets-scandinavian',
    'hero_alt'    => 'Japandi Interior Design: Where Japanese Wabi-Sabi Meets Scandinavian Hygge',
    'date'        => '2026-06-20',
    'updated'     => '2026-10-04',
    'canonical'   => '/styles/japandi/',
  ],
  'minimalist-home-design-ideas' => [
    'title'       => 'Minimalist Home Design: The Complete Guide',
    'seo_title'   => 'Minimalist Home Design: The Complete Guide (2026)',
    'description' => 'A complete, expert guide to Minimalist home design — philosophy, colors, materials, room-by-room breakdowns, real Bangalore costs, maintenance, and honest…',
    'category'    => 'Styles',
    'location'    => 'Bangalore',
    'pillar'      => 'styles',
    'folder'      => 'minimalist-home-design-ideas',
    'hero_alt'    => 'Minimalist Home Design: The Complete Guide',
    'date'        => '2026-07-03',
    'updated'     => '2026-10-04',
    'canonical'   => '/styles/minimalist/',
  ],
  'contemporary-living-india' => [
    'title'       => 'The Art of Contemporary Living — Designed for India',
    'seo_title'   => 'Contemporary Interior Design for Indian Homes',
    'description' => 'Complete guide to contemporary interior design for Indian homes in 2026. Learn colour palettes, room-by-room tips, materials, Indian fusion elements, and…',
    'category'    => 'Styles',
    'pillar'      => 'styles',
    'folder'      => 'contemporary-living-india',
    'hero_alt'    => 'The Art of Contemporary Living — Designed for India',
    'date'        => '2026-06-13',
    'updated'     => '2026-10-04',
    'canonical'   => '/styles/contemporary/',
  ],
  'choosing-an-interior-designer-checklist' => [
    'title'       => 'How to Choose an Interior Designer: The Complete Homeowner\'s Guide (2026)',
    'seo_title'   => 'How to Choose an Interior Designer',
    'description' => 'The designer you choose shapes how comfortably you cook, work, store your belongings, and relax — every single day for years to come.',
    'category'    => 'Planning',
    'pillar'      => 'planning',
    'folder'      => 'choosing-an-interior-designer-checklist',
    'hero_alt'    => 'How to Choose an Interior Designer: The Complete Homeowner\'s Guide (2026)',
    'date'        => '2026-06-19',
    'updated'     => '2026-10-04',
    'canonical'   => '/planning/how-to-choose-interior-designer/',
  ],
  'vastu-for-home-interiors-room-by-room' => [
    'title'       => 'Ultimate Vastu Guide for Home Interiors: Room-by-Room Planning',
    'seo_title'   => 'Ultimate Vastu Guide for Home Interiors',
    'description' => 'Complete Vastu Shastra guide for home interiors — room-by-room planning for positive energy, modern solutions, and practical Vastu remedies without demolition.',
    'category'    => 'Vastu',
    'pillar'      => 'vastu',
    'folder'      => 'vastu-for-home-interiors-room-by-room',
    'hero_alt'    => 'Ultimate Vastu Guide for Home Interiors: Room-by-Room Planning',
    'date'        => '2026-08-29',
    'updated'     => '2026-10-04',
    'canonical'   => '/vastu/',
  ],
  /* MIGRATED-END */

  'kitchen-colour-combinations' => [
    'title'       => 'Two-Colour Kitchen Combinations That Work in Indian Homes',
    'seo_title'   => 'Kitchen Colour Combinations: 10 Two-Tone Ideas',
    'description' => 'Ten two-colour kitchen laminate combinations with swatches and hex codes, a decision table by kitchen size and light, finish advice and the mistakes to avoid.',
    'category'    => 'Kitchen',
    'location'    => 'Bangalore',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'kitchen-colour-combinations',
    'hero_alt'    => 'Two-colour modular kitchen with warm white wall units and walnut base units',
    'date'        => '2026-10-03',
  ],

  /* Examples — copy one, change the slug and details, then create the matching file in /blogs/
  'l-shape-modular-kitchen-designs' => [
    'title'       => 'L-Shape Modular Kitchen Designs',
    'description' => '...',
    'category'    => 'Kitchen',
    'location'    => 'Bangalore',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'l-shape-modular-kitchen-designs',
    'hero_alt'    => 'L-shape modular kitchen design in Bangalore',
    'date'        => '2026-10-03',
  ],
  'sliding-wardrobe-designs' => [
    'title'       => 'Sliding Wardrobe Designs for Bedrooms',
    'description' => '...',
    'category'    => 'Wardrobes',
    'pillar'      => 'wardrobe',
    'folder'      => 'sliding-wardrobe-designs',
    'hero_alt'    => 'Modern sliding wardrobe design for bedroom',
    'date'        => '2026-10-03',
  ],
  'pooja-room-designs' => [
    'title'       => 'Pooja Room Designs for Indian Homes',
    'description' => '...',
    'category'    => 'Pooja Room',
    'pillar'      => 'rooms',
    'folder'      => 'pooja-room-designs',
    'hero_alt'    => 'Wooden pooja room design with jaali doors',
    'date'        => '2026-10-03',
  ],
  */
];

/* ---------- helpers (no need to edit) ---------- */
const BLOG_BASE = '/blogs';
function post_url($slug) { return BLOG_BASE . '/' . $slug . '/'; }

// Posts that have a file and are not drafts (drafts show on staging), newest first.
// Optional filters: category name, pillar key, how many.
function posts($category = null, $pillar = null, $limit = null) {
  global $POSTS;
  $out = [];
  foreach ($POSTS as $slug => $p) {
    if (!is_file(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . BLOG_BASE . '/' . $slug . '.php')) continue;
    if (!empty($p['draft']) && !is_staging()) continue;
    if ($category && strcasecmp($p['category'], $category) !== 0) continue;
    if ($pillar && ($p['pillar'] ?? '') !== $pillar) continue;
    $out[$slug] = $p + ['slug' => $slug, 'url' => post_url($slug)];
  }
  uasort($out, fn($a, $b) => strcmp($b['date'], $a['date']));
  return $limit ? array_slice($out, 0, $limit, true) : $out;
}
