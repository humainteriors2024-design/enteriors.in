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
  /* MIGRATED-END */

  'planning-home-interiors-hosur-road' => [
    'title'       => 'Home Interiors on Hosur Road: Planning Guide for the Corridor',
    'seo_title'   => 'Home Interiors on Hosur Road, Bengaluru: Planning Guide',
    'description' => 'A guest post by Huma Interiors on planning home interiors along Hosur Road, from Electronic City and Bommasandra to Chandapura: apartments, rentals, houses, dust, heat and society rules.',
    'updated'     => '2026-10-14',
    'category'    => 'Planning',
    'location'    => 'Bangalore',
    'pillar'      => 'interior-designers',
    'folder'      => 'planning-home-interiors-hosur-road',
    'hero_alt'    => 'Apartment living room with a TV wall and closed storage in south Bengaluru',
    'date'        => '2026-10-14',
    'author'      => 'huma-interiors',
  ],

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
    'updated'     => '2026-10-14',
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
