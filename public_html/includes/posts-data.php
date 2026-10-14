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
    'seo_title'   => 'Kitchen Renovation Cost in India (2026)',
    'description' => 'Kitchen renovation cost in India for 2026: budget tiers, full cost breakdown, labour, modular vs carpenter, styles, timeline and costly mistakes.',
    'category'    => 'Cost',
    'pillar'      => 'cost',
    'folder'      => 'kitchen-renovation-cost',
    'hero_alt'    => 'Kitchen during renovation with new cabinets being installed',
    'date'        => '2026-06-11',
    'updated'     => '2026-10-14',
  ],
  'wallpaper-cost-per-sq-ft' => [
    'title'       => 'Wallpaper Cost Per Square Foot in India — The Only Guide You Need',
    'seo_title'   => 'Wallpaper Cost per Sq Ft in India (2026)',
    'description' => 'Complete guide to wallpaper cost per sq ft in India 2026. Types, brands, installation, maintenance, room-wise selection and comparison with paint.',
    'category'    => 'Cost',
    'pillar'      => 'wall-design',
    'folder'      => 'wallpaper-cost-per-sq-ft',
    'hero_alt'    => 'Bedroom feature wall with a textured wallpaper',
    'date'        => '2026-06-11',
    'updated'     => '2026-10-14',
  ],
  'hidden-costs-home-interiors' => [
    'title'       => 'Hidden Costs in Home Interiors: What Most Homeowners Discover Too Late',
    'seo_title'   => 'Hidden Costs in Home Interiors',
    'description' => 'Hidden costs in home interiors: what quotations leave out on materials, hardware, kitchens, wardrobes, electricals and GST, and how to budget for them.',
    'category'    => 'Cost',
    'pillar'      => 'cost',
    'folder'      => 'hidden-costs-home-interiors',
    'hero_alt'    => 'Interior quotation with excluded items highlighted',
    'date'        => '2026-06-19',
    'updated'     => '2026-10-14',
  ],
  'interior-material-brands-india' => [
    'title'       => 'Interior Material Brands in India: Plywood, Laminates, Hardware and More',
    'seo_title'   => 'Interior Material Brands in India (2026)',
    'description' => 'Interior material brands in India: plywood, laminates, hardware, handles, channels, acrylic, wall panels, glass, tiles and paint, by category and budget.',
    'category'    => 'Materials',
    'pillar'      => 'materials',
    'folder'      => 'interior-material-brands-india',
    'hero_alt'    => 'Plywood, laminate and hardware samples from Indian brands',
    'date'        => '2025-06-11',
    'updated'     => '2026-10-14',
  ],
  'l-shape-modular-kitchen-designs' => [
    'title'       => 'L-Shape Modular Kitchen Designs: Colors, Layouts & Smart Space Ideas',
    'seo_title'   => 'L-Shape Modular Kitchen Designs 2026',
    'description' => 'L-shape modular kitchen designs: ideal sizes, 12 colour themes, 6 layouts, work triangle, storage, materials, small-kitchen plans and appliance placement.',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'l-shape-modular-kitchen-designs',
    'hero_alt'    => 'L-shape modular kitchen with a corner carousel and window above the sink',
    'date'        => '2026-06-30',
    'updated'     => '2026-10-14',
  ],
  'u-shape-kitchen-designs' => [
    'title'       => 'U-Shape Kitchen Designs: The Three-Wall Workflow Machine',
    'seo_title'   => 'U-Shape Kitchen Designs 2026',
    'description' => 'U-shape kitchen design: who it suits, space needed, workflow, corner solutions, variations, U vs L vs island, ventilation and storage capacity.',
    'category'    => 'Kitchen',
    'pillar'      => 'modular-kitchen',
    'folder'      => 'u-shape-kitchen-designs',
    'hero_alt'    => 'U-shape modular kitchen with counters on three walls',
    'date'        => '2026-06-30',
    'updated'     => '2026-10-14',
  ],
  /* MIGRATED-END */

  'planning-home-interiors-hosur-road' => [
    'title'       => 'Home Interiors on Hosur Road: Planning Guide for the Corridor',
    'seo_title'   => 'Home Interiors on Hosur Road: Planning Guide',
    'description' => 'Guest post by Huma Interiors: planning home interiors along Hosur Road, from Electronic City to Chandapura: flats, rentals, houses, dust and society rules.',
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
