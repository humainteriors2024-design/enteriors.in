<?php
/* =====================================================================
   ENTERIORS — HELPERS (no need to edit)
   Small functions that print shared HTML so it is never retyped.
   ===================================================================== */

// Escape text for HTML
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Live or staging? (config.php → ENV). Staging = noindex, no tracking, test leads.
function is_staging() {
  static $s = null;
  if ($s !== null) return $s;
  if (ENV === 'live') return $s = false;
  if (ENV === 'staging') return $s = true;
  $host = strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? ''));
  $live = strtolower((string) parse_url(SITE['url'], PHP_URL_HOST));
  return $s = !($host === $live || $host === 'www.' . $live);
}

// Current URL path, always ending in /
function current_path() {
  $p = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
  return rtrim($p, '/') . '/';
}

// Does a page exist on the server? Used to hide links to pages not uploaded yet.
// Works for folder pages (/materials/ → materials/index.php) and blog posts (/blogs/slug/ → blogs/slug.php).
function is_live($href) {
  if (SHOW_ALL_LINKS || $href === '/' || str_starts_with($href, '#') || preg_match('#^(https?:|tel:|mailto:)#', $href)) return true;
  $path = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . strtok($href, '#?');
  return is_file($path . 'index.php') || is_file($path . 'index.html') || is_file(rtrim($path, '/') . '.php');
}
function live_links($links) { return array_values(array_filter($links, fn($l) => is_live($l['href']))); }
function nice_date($ymd) { return $ymd ? date('j M Y', strtotime($ymd)) : ''; }

// Include a component from includes/components/, passing settings as $p
//   component('lead-form', ['variant' => 'full'])
function component($name, $p = []) {
  global $page, $HUBS;
  ob_start();
  include __DIR__ . "/components/$name.php";
  return ob_get_clean();
}

/* CARD — one card for every tile on the site.
   Named arguments keep it readable:
     card('/materials/plywood-guide/', 'Plywood', 'MR vs BWP', label: 'Boards', icon: '🪵')
   A card whose page isn't uploaded yet is hidden — or, with always: true,
   shown without a link (used on the home page so the design stays full). */
function card($href, $title, $text = '', $label = '', $icon = '', $variant = '', $meta = '',
              $tags = [], $count = '', $price = '', $bars = [], $always = false, $style = '') {
  $live = $href && is_live($href);
  if ($href && !$live && !$always) return '';
  $tag  = $live ? 'a' : 'div';
  $cls  = 'card' . ($variant ? ' ' . implode(' ', array_map(fn($v) => "card--$v", explode(' ', $variant))) : '');
  $h    = "<$tag class=\"$cls\"" . ($live ? ' href="' . e($href) . '"' : '') . ($style ? ' style="' . e($style) . '"' : '') . '>';
  if ($count) $h .= '<span class="card__count">' . e($count) . '</span>';
  if ($icon)  $h .= '<span class="card__icon" aria-hidden="true">' . e($icon) . '</span>';
  if ($label) $h .= '<span class="card__label">' . e($label) . '</span>';
  $h .= '<h3 class="card__title">' . e($title) . ($live || !$href ? '' : ' <span class="badge badge--soon">Soon</span>') . '</h3>';
  if ($text)  $h .= '<p class="card__text">' . e($text) . '</p>';
  if ($price) $h .= '<p class="card__price">' . $price . '</p>';            // may contain <small>
  if ($bars) {
    $h .= '<div class="bars">';
    foreach ($bars as $i => [$name, $pct]) $h .= '<div class="bars__row"><span>' . e($name) . '</span><span class="bars__track"><span class="bars__fill' . ($i ? ' bars__fill--alt' : '') . '" style="--w:' . (int)$pct . '%"></span></span></div>';
    $h .= '</div>';
  }
  if ($tags)  $h .= '<div class="card__tags">' . implode('', array_map(fn($t) => '<span class="tag">' . e($t) . '</span>', $tags)) . '</div>';
  if ($meta)  $h .= '<span class="card__meta">' . e($meta) . '</span>';
  return $h . "</$tag>";
}

// Image-style tile (design styles, room mosaic)
function tile($href, $title, $text = '', $art = '', $bg = '') {
  $live = is_live($href);
  $tag = $live ? 'a' : 'div';
  return "<$tag class=\"tile\"" . ($live ? ' href="' . e($href) . '"' : '') . ($bg ? ' style="--tile-bg:' . e($bg) . '"' : '') . '>'
    . '<span class="tile__art" aria-hidden="true">' . $art . '</span>'
    . '<span class="tile__body"><span class="tile__title">' . e($title) . ($live ? '' : ' <span class="badge badge--soon">Soon</span>') . '</span>' . ($text ? '<span class="tile__text">' . e($text) . '</span>' : '') . '</span>'
    . "</$tag>";
}

// Tile artwork: the photo "<name>.jpg|png|webp" from a media folder if it exists, otherwise the icon
function tile_art($icon, $photo = '', $dir = null) {
  $m = $photo ? media_find($photo, $dir ?? media_dir()) : null;
  return $m ? '<img src="' . e($m['url']) . '" alt="' . e(alt_from_name($m['file'])) . '"' . ($m['w'] ? ' width="' . $m['w'] . '" height="' . $m['h'] . '"' : '') . ' loading="lazy" decoding="async">' : e($icon);
}

// Section title row: eyebrow + big title with accent + "view all" link
function section_head($title, $accent = '', $eyebrow = '', $href = '', $linkText = 'View all') {
  $h = '<div class="section-head"><div>';
  if ($eyebrow) $h .= '<span class="eyebrow">' . e($eyebrow) . '</span>';
  $h .= '<h2 class="section-title">' . e($title) . ($accent ? ' <em>' . e($accent) . '</em>' : '') . '</h2></div>';
  if ($href && is_live($href)) $h .= '<a class="link-arrow" href="' . e($href) . '">' . e($linkText) . '</a>';
  return $h . '</div>';
}

// Titled list of links (menus and footer)
function link_list($links, $title = '', $gold = false, $allHref = '', $allLabel = 'View all') {
  $h = '<div class="link-list">';
  if ($title) $h .= '<p class="link-list__title' . ($gold ? ' link-list__title--gold' : '') . '">' . e($title) . '</p>';
  $h .= '<ul>';
  foreach ($links as $l) $h .= '<li><a href="' . e($l['href']) . '">' . e($l['label']) . (!empty($l['badge']) ? ' <span class="badge">' . e($l['badge']) . '</span>' : '') . '</a></li>';
  if ($allHref) $h .= '<li><a class="is-all" href="' . e($allHref) . '">' . e($allLabel) . ' →</a></li>';
  return $h . '</ul></div>';
}

// Shortcuts kept for older pages/templates
function lead_form($title = null) { return component('lead-form', ['variant' => 'compact', 'title' => $title]); }
function cta_band($title = null, $text = null) { return component('cta-band', array_filter(['title' => $title, 'text' => $text])); }

// NAP helpers
function nap_phone_href() { return NAP['phone'] ? 'tel:' . preg_replace('/[^0-9+]/', '', NAP['phone']) : ''; }
// WhatsApp chat link with a pre-filled message ('' when no number is set)
function whatsapp_href($text = null) {
  return NAP['whatsapp'] ? 'https://wa.me/' . preg_replace('/\D/', '', NAP['whatsapp']) . '?text=' . rawurlencode($text ?? NAP['whatsapp_text']) : '';
}
// Site facts that have a value (config.php → FACTS), as [label, value] pairs for the facts strip
function site_facts() {
  $f = FACTS; $out = [];
  if ($f['rating'])         $out[] = [$f['rating'] . '★', trim(($f['review_count'] ? $f['review_count'] . ' ' : '') . $f['review_source'] . ' reviews')];
  if ($f['homes_done'])     $out[] = [$f['homes_done'], 'Homes completed'];
  if ($f['years'])          $out[] = [$f['years'] . ' yrs', 'In business'];
  if ($f['factory_sqft'])   $out[] = [$f['factory_sqft'], 'Sq ft factory'];
  if ($f['warranty_years']) $out[] = [$f['warranty_years'] . ' yrs', 'Warranty'];
  if ($f['delivery_days'])  $out[] = [$f['delivery_days'] . ' days', 'Delivery commitment'];
  return $out;
}
function nap_address_line() {
  return implode(', ', array_filter([NAP['street'], NAP['locality'], NAP['region'] . (NAP['postal_code'] ? ' ' . NAP['postal_code'] : ''), NAP['country'] === 'IN' ? 'India' : NAP['country']]));
}

// Breadcrumb trail from the URL: Home › Materials › Plywood
function crumbs($page) {
  $parts = array_values(array_filter(explode('/', current_path())));
  $out = [['name' => 'Home', 'url' => '/']];
  foreach ($parts as $i => $seg) {
    $url = '/' . implode('/', array_slice($parts, 0, $i + 1)) . '/';
    $isLast = $i === count($parts) - 1;
    if (!$isLast && !is_live($url)) continue;   // skip hub folders not uploaded yet (no dead links)
    $name = nav_label($url) ?? ($isLast ? ($page['crumb'] ?? $page['title']) : ucwords(str_replace('-', ' ', $seg)));
    $out[] = ['name' => $name, 'url' => $url];
  }
  return $out;
}

// A locality name, linked to its area guide when there is one (config.php → LOCALITY_PAGES)
function locality_link($name) {
  $u = LOCALITY_PAGES[$name] ?? '';
  return $u && is_live($u) ? '<a href="' . e($u) . '">' . e($name) . '</a>' : e($name);
}
