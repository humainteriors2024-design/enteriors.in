<?php
/* =====================================================================
   ENTERIORS — IMAGES AND VIDEOS
   Every page has its own media folder (config.php → MEDIA):
     blog post  /blogs/<slug>/     →  /assets/blogs/<slug>/
     any page   /modular-kitchen/  →  /assets/pages/modular-kitchen/
     home page                     →  /assets/pages/home/

   Upload a JPG, JPEG, PNG or WebP and call it by name WITHOUT the extension:
     <?= img('l-shape-kitchen-with-breakfast-counter') ?>
   - the format is found automatically (WebP + JPG/PNG of the same name = <picture>)
   - the alt text is made from the file name: "L-shape kitchen with breakfast counter"
   - width/height are read from the file, and images below the first screen load lazily
   - hero.jpg / hero.png / hero.webp is the page's main image (shown under the title)

     <?= img('name', caption: 'Shown under the image') ?>
     <?= img('name', alt: 'Custom alt text') ?>
     <?= gallery() ?>                 every image in the folder, in name order
     <?= gallery('wardrobe') ?>       only files whose name starts with "wardrobe"
     <?= video('site-walkthrough') ?> MP4 or WebM, with poster image of the same name
   ===================================================================== */

// Web path of the current page's media folder
function media_dir($pg = null) {
  global $page;
  $pg = $pg ?? $page ?? [];
  if (!empty($pg['media_dir'])) return rtrim($pg['media_dir'], '/');
  if (!empty($pg['folder']))    return MEDIA['blog_dir'] . '/' . trim($pg['folder'], '/');
  $path = trim(current_path(), '/');
  return MEDIA['page_dir'] . '/' . ($path === '' ? 'home' : $path);
}

/* Make sure a page's media folder exists. The first time a page is opened (on staging or live) its
   folder is created with a short note listing the file names the page is waiting for, so you never
   have to create image folders by hand: write the page, open it once, then upload into the folder. */
function media_folder_ready($dir, $pg = []) {
  if (!empty($pg['no_media_note'])) return;   // pages that manage their own photo folders (trending designs)
  $abs = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $dir;
  $pageFile = current(array_filter(get_included_files(), fn($f) => !preg_match('#[/\\\\](includes[/\\\\]|preview-router\.php$)#', $f)));
  $note = $abs . '/_put-images-here.txt';
  // (re)write the note when the folder is new or the page has changed since the note was written
  if (is_dir($abs) && is_file($note) && (!$pageFile || filemtime($note) >= filemtime($pageFile))) return;
  if (!is_dir($abs) && !@mkdir($abs, 0755, true)) return;
  $want = [];
  foreach (media_slots($pageFile ? @file_get_contents($pageFile) : '', $pg) as $name => $what) $want[] = str_pad("$name.jpg", 46) . $what;
  @file_put_contents($note, "Images for " . ($pg['title'] ?? $dir) . "\n"
    . "Easiest: open /admin/images.php, find this page and upload each photo; it is resized, converted to WebP and named for you.\n"
    . "By hand: upload JPG, PNG or WebP with exactly these names (the description becomes the alt text and caption).\n\n"
    . "This page is waiting for:\n  " . implode("\n  ", $want) . "\n");
}

/* The image slots a page's source asks for: ['hero' => 'description', 'file-name' => 'caption or alt', …] */
function media_slots($src, $pg = []) {
  $slots = [MEDIA['hero_name'] => 'Main image: under the title, on cards and when shared (landscape, 1600 × 900 or larger). Shows: ' . ($pg['hero_alt'] ?? $pg['title'] ?? 'the page topic')];
  if ($src && preg_match_all("/img\('([a-z0-9\-]+)'(?:[^)]*?caption:\s*'((?:[^'\\\\]|\\\\.)*)')?/", $src, $m, PREG_SET_ORDER))
    foreach ($m as $x) if ($x[1] !== MEDIA['hero_name']) $slots[$x[1]] = isset($x[2]) && $x[2] !== '' ? stripslashes($x[2]) : alt_from_name($x[1]);
  return $slots;
}

// Files in a media folder, grouped by name: ['hero' => ['webp' => 'hero.webp', 'jpg' => 'Hero.JPG'], …]
function media_files($dir) {
  static $cache = [];
  if (isset($cache[$dir])) return $cache[$dir];
  $out = [];
  $abs = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $dir;
  foreach (is_dir($abs) ? scandir($abs) : [] as $f) {
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    if (!in_array($ext, array_merge(MEDIA['images'], MEDIA['videos']), true)) continue;
    $out[media_key(pathinfo($f, PATHINFO_FILENAME))][$ext] = $f;
  }
  ksort($out, SORT_NATURAL);
  return $cache[$dir] = $out;
}
function media_key($name) { return trim(preg_replace('/[\s_\-]+/', '-', strtolower($name)), '-'); }
function media_url($dir, $file) { return $dir . '/' . rawurlencode($file); }

// Alt text from a file name: "2-bhk_modular-kitchen-01.jpg" → "2 BHK modular kitchen"
function alt_from_name($file) {
  $s = pathinfo($file, PATHINFO_FILENAME);
  $s = preg_replace('/[_\-]+/', ' ', $s);
  $s = preg_replace('/\s*\(?\b\d{1,3}\)?$/', '', $s);                       // drop a trailing counter: "kitchen 01", "kitchen (2)"
  $s = trim(preg_replace('/\s+/', ' ', $s));
  $s = preg_replace_callback('/\b(bhk|tv|led|pu|mdf|hdhmr|pop|pvc|wpc|upvc|spc|bwp|bwr|cnc|ac|rft)\b/i', fn($m) => strtoupper($m[1]), $s);
  $s = preg_replace_callback('/\b([lug]) shape(d?)\b/i', fn($m) => strtoupper($m[1]) . '-shape' . $m[2], $s);
  return ucfirst($s);
}

// First existing image for a name: ['url', 'file', 'webp' => url|null, 'w', 'h'] or null
function media_find($name, $dir = null) {
  $dir = $dir ?? media_dir();
  $set = media_files($dir)[media_key($name)] ?? null;
  if (!$set) return null;
  $main = null;
  foreach (MEDIA['images'] as $ext) if ($ext !== 'webp' && isset($set[$ext])) { $main = $set[$ext]; break; }
  $webp = $set['webp'] ?? null;
  if (!$main && !$webp) return null;
  $file = $main ?? $webp;
  $size = @getimagesize(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $dir . '/' . $file) ?: [0, 0];
  return ['file' => $file, 'url' => media_url($dir, $file), 'webp' => ($main && $webp) ? media_url($dir, $webp) : null, 'w' => $size[0], 'h' => $size[1]];
}

/* One image. Named options: alt, caption, class, lazy (false for the first image on a page), dir, sizes */
function img($name, $alt = null, $caption = '', $class = '', $lazy = true, $dir = null, $sizes = '') {
  $dir = $dir ?? media_dir();
  $m = media_find($name, $dir);
  if (!$m) {   // not uploaded yet: a labelled box on staging (what to shoot + upload link), nothing on the live site
    if (!is_staging()) return '';
    $what = is_string($caption) && $caption !== '' ? $caption : alt_from_name($name);
    return '<div class="img-missing"><strong>Image needed: ' . e($what) . '</strong>File name: <code>' . e(media_key($name)) . '.jpg</code> in <code>' . e($dir) . '/</code>'
         . (is_file(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/admin/images.php') ? ' · <a href="/admin/images.php?dir=' . rawurlencode($dir) . '">Upload it →</a>' : '') . '</div>';
  }
  $alt  = $alt ?? alt_from_name($m['file']);
  $attr = ' alt="' . e($alt) . '"' . ($m['w'] ? ' width="' . $m['w'] . '" height="' . $m['h'] . '"' : '')
        . ($lazy ? ' loading="lazy" decoding="async"' : ' fetchpriority="high"') . ($sizes ? ' sizes="' . e($sizes) . '"' : '');
  $tag = '<img src="' . e($m['url']) . '"' . $attr . '>';
  if ($m['webp']) $tag = '<picture><source srcset="' . e($m['webp']) . '" type="image/webp">' . $tag . '</picture>';
  if ($caption === true) $caption = $alt;
  return '<figure class="figure' . ($class ? ' ' . e($class) : '') . '">' . $tag . ($caption ? '<figcaption>' . e($caption) . '</figcaption>' : '') . '</figure>';
}

/* Gallery of every image in the folder (or those whose name starts with $match).
   The hero image is left out. Captions come from the file names. */
function gallery($match = '', $dir = null, $captions = true, $class = '') {
  $dir = $dir ?? media_dir();
  $h = '';
  foreach (media_files($dir) as $key => $set) {
    if ($key === MEDIA['hero_name'] || str_starts_with($key, '-')) continue;
    if ($match !== '' && !str_starts_with($key, media_key($match))) continue;
    if (!array_intersect(array_keys($set), MEDIA['images'])) continue;
    $h .= img($key, caption: $captions, dir: $dir);
  }
  if ($h === '') return is_staging() ? '<div class="img-missing">Add images to <code>' . e($dir) . '/</code> — they appear here automatically.</div>' : '';
  return '<div class="gallery' . ($class ? ' ' . e($class) : '') . '">' . $h . '</div>';
}

/* Video from the page folder (MP4 and/or WebM). An image with the same name is used as the poster. */
function video($name, $caption = '', $dir = null) {
  $dir = $dir ?? media_dir();
  $set = media_files($dir)[media_key($name)] ?? [];
  $src = '';
  foreach (MEDIA['videos'] as $ext) if (isset($set[$ext])) $src .= '<source src="' . e(media_url($dir, $set[$ext])) . '" type="video/' . $ext . '">';
  if ($src === '') return is_staging() ? '<div class="img-missing">Add video: <code>' . e($dir . '/' . media_key($name)) . '.mp4</code></div>' : '';
  $poster = media_find($name, $dir);
  return '<figure class="figure"><video controls preload="none" playsinline' . ($poster ? ' poster="' . e($poster['url']) . '"' : '') . ' aria-label="' . e(alt_from_name($name)) . '">' . $src . '</video>'
       . ($caption ? '<figcaption>' . e($caption) . '</figcaption>' : '') . '</figure>';
}

// The page's hero image (hero.jpg|png|webp) — alt from $page['hero_alt'] or the page title
function page_hero($pg = null) {
  global $page;
  $pg = $pg ?? $page;
  $dir = media_dir($pg);
  if (!media_find(MEDIA['hero_name'], $dir)) return is_staging() && in_array($pg['type'] ?? '', ['post', 'pillar']) ? img(MEDIA['hero_name'], dir: $dir) : '';
  return img(MEDIA['hero_name'], alt: $pg['hero_alt'] ?? $pg['title'], class: 'figure--hero', lazy: false, dir: $dir);
}
