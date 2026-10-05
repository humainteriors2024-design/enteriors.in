<?php
/* =====================================================================
   ENTERIORS — TOP OF EVERY PAGE
   <head> (SEO tags, CSS, tracking, schema) → header → page header →
   opening of the layout for this page type. Pages set $page, then:
     require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
   (Blog posts use includes/post-start.php, which fills $page from posts-data.php.)

   $page['type'] picks the layout:
     home     header only; the page builds its own sections
     pillar   dark page header + "In this guide" cards + contents | text
     article  page header + contents | text | share        (cluster pages; 'compare' adds a verdict)
     post     blog post: same as article + category, hero image, pillar link, lead form
     tool     dark page header; the page builds its sections
     page     plain page (about, contact, privacy, 404 …)

   Useful $page keys: title, seo_title, description, eyebrow, lede, published, updated,
   quick_answer, faq, related, verdict, crumb, pillar (key in nav.php), hero_alt,
   noindex, canonical, header|footer => 'minimal', tracking => [...], css => [...], js => [...]
   ===================================================================== */
require_once __DIR__ . '/site.php';

$page = array_merge([
  'type' => 'page', 'title' => '', 'seo_title' => null, 'description' => '', 'eyebrow' => '', 'lede' => '',
  'author' => DEFAULT_AUTHOR, 'published' => '', 'updated' => '', 'quick_answer' => '', 'takeaways' => [], 'sources' => [], 'cards' => [], 'faq' => [],
  'verdict' => null, 'related' => [], 'noindex' => false, 'image' => null, 'css' => [], 'js' => [],
  'pillar' => null, 'header' => 'full', 'footer' => 'full', 'tracking' => [], 'mid_cta' => true,
], $page ?? []);

$path      = current_path();
$canonical = SITE['url'] . ($page['canonical'] ?? $path);   // 'canonical' => '/main/page/' when this page repeats a main page
$fullTitle = ($page['seo_title'] ?? $page['title']) . ($page['type'] === 'home' ? '' : ' | ' . SITE['name']);
$crumbs    = crumbs($page);
$author    = AUTHORS[$page['author']] ?? null;
$reading   = in_array($page['type'], ['pillar', 'article', 'compare', 'post']);          // long-form layouts
$hub       = $page['pillar'] ? hub($page['pillar']) : ($reading ? hub_for($path) : null);  // the pillar this page belongs to
$page['hub_tracking'] = $hub['tracking'] ?? [];                                           // pillar-level tracking IDs (nav.php)
media_folder_ready(media_dir($page), $page);                                              // every page gets its image folder automatically
$heroImg   = media_find(MEDIA['hero_name'], media_dir($page));
$page['image'] = $page['image'] ?? ($heroImg['url'] ?? SITE['image']);                    // share image: the page's hero, else the site default
$noindex   = $page['noindex'] || is_staging();
$cssList   = array_unique(array_merge(CSS_FILES, CSS_BY_TYPE[$page['type']] ?? [], $page['css'], CSS_LAST));
$ver       = fn($f) => @filemtime($_SERVER['DOCUMENT_ROOT'] . $f) ?: 1;   // cache-buster: changes when the file changes
if (is_staging() && !headers_sent()) header('X-Robots-Tag: noindex, nofollow');

ob_start();   // lets foot.php add the contents list and heading anchors
?>
<!doctype html>
<html lang="<?= e(SITE['language']) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($fullTitle) ?></title>
  <meta name="description" content="<?= e($page['description']) ?>">
  <link rel="canonical" href="<?= e($canonical) ?>">
  <meta name="robots" content="<?= $noindex ? 'noindex, ' . (is_staging() ? 'nofollow' : 'follow') : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' ?>">
  <meta property="og:site_name" content="<?= e(SITE['name']) ?>">
  <meta property="og:type" content="<?= $reading ? 'article' : 'website' ?>">
  <meta property="og:title" content="<?= e($page['seo_title'] ?? $page['title']) ?>">
  <meta property="og:description" content="<?= e($page['description']) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:image" content="<?= e(SITE['url'] . $page['image']) ?>">
<?php if (!empty($heroImg['w'])): ?>
  <meta property="og:image:width" content="<?= (int) $heroImg['w'] ?>">
  <meta property="og:image:height" content="<?= (int) $heroImg['h'] ?>">
  <meta property="og:image:alt" content="<?= e($page['hero_alt'] ?? $page['title']) ?>">
<?php endif; ?>
  <meta property="og:locale" content="<?= e(SITE['locale']) ?>">
<?php if ($reading && $hub): ?>
  <meta property="article:section" content="<?= e($hub['label']) ?>">
<?php endif; if ($page['published']): ?>
  <meta property="article:published_time" content="<?= e($page['published']) ?>">
<?php endif; if ($page['updated']): ?>
  <meta property="article:modified_time" content="<?= e($page['updated']) ?>">
<?php endif; ?>
  <meta name="twitter:card" content="summary_large_image">
  <meta name="theme-color" content="#080808">
  <link rel="icon" href="/favicon.svg" type="image/svg+xml">
  <link rel="preload" href="/assets/fonts/inter.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="/assets/fonts/<?= $page['type'] === 'home' ? 'bebas-neue' : 'fraunces' ?>.woff2" as="font" type="font/woff2" crossorigin>
<?php foreach ($cssList as $f): $file = "/assets/css/$f.css"; ?>
  <link rel="stylesheet" href="<?= $file ?>?v=<?= $ver($file) ?>">
<?php endforeach; ?>
<?= tracking_head($page, $hub) ?>
  <script type="application/ld+json"><?= schema_json($page, $crumbs, $canonical) ?></script>
</head>
<body class="page-<?= e($page['type']) ?>">
<?= tracking_body($page) ?>
<?php if (is_staging()): ?>
<div class="staging-ribbon">Staging preview — not indexed, tracking off, leads saved as tests</div>
<?php endif; ?>
<a href="#main" class="visually-hidden">Skip to content</a>
<?php include __DIR__ . ($page['header'] === 'minimal' ? '/header-minimal.php' : '/header.php'); ?>
<main id="main">
<?php
/* ---------- Page header (all types except home and plain page) ---------- */
if ($reading || $page['type'] === 'tool'):
  $dark = in_array($page['type'], ['pillar', 'tool']);
  $meta = [];
  if (in_array($page['type'], ['article', 'compare', 'post'])) {
    if ($author) $meta[] = 'By ' . e($author['name']);
    if ($page['type'] === 'post' && $page['published']) $meta[] = '<time datetime="' . e($page['published']) . '">' . nice_date($page['published']) . '</time>';
    if ($page['updated'] && ($page['type'] !== 'post' || $page['updated'] !== $page['published'])) $meta[] = 'Updated <time datetime="' . e($page['updated']) . '">' . nice_date($page['updated']) . '</time>';
    $meta[] = '<!--READTIME-->';
  }
  if ($page['type'] === 'pillar' && $page['updated']) $meta[] = 'Updated ' . date('M Y', strtotime($page['updated']));
  if ($page['type'] === 'tool') {
    if (!empty($page['rates_as_of'])) $meta[] = 'Rates as of ' . e($page['rates_as_of']);
    $meta[] = 'Bengaluru base pricing';
    $meta[] = 'No signup';
  }
  // Cluster pages and posts link up to their pillar near the top of the page
  $upLink = ($hub && $page['type'] !== 'pillar' && is_live($hub['href']) && $hub['href'] !== $path)
          ? (empty($hub['keyword']) ? 'More in <a href="' . e($hub['href']) . '">' . e($hub['label']) . '</a>'
                                    : 'Part of our guide to <a href="' . e($hub['href']) . '">' . e($hub['keyword']) . '</a>') : '';
?>
<header class="page-header<?= $dark ? ' section--dark' : '' ?>">
  <div class="container">
    <?= component('breadcrumbs', ['crumbs' => $crumbs]) ?>
<?php if ($page['eyebrow']): ?>    <span class="eyebrow mt-6"><?= e($page['eyebrow']) ?></span>
<?php endif; ?>
    <h1><?= e($page['title']) ?></h1>
<?php if ($page['lede']): ?>    <p class="subheading"><?= e($page['lede']) ?></p>
<?php endif; ?>
<?php if ($meta || $upLink): ?>    <div class="page-header__meta"><?php foreach ($meta as $m) echo '<span>' . $m . '</span>'; if ($upLink) echo '<span class="page-header__up">' . $upLink . '</span>'; ?></div>
<?php endif; ?>
  </div>
</header>
<?php endif; ?>
<?php
/* ---------- Pillar: facts strip + "In this guide" cards for the pages in this cluster ---------- */
if ($page['type'] === 'pillar'):
  echo component('facts');
  echo component('clusters', ['hub' => $hub, 'cards' => $page['cards']]);
endif;

/* ---------- Open the reading layout: contents | article ---------- */
if ($reading): ?>
<div class="container page-grid section">
  <aside class="page-grid__side"><!--TOC--></aside>
  <article>
<?= page_hero($page) ?>
<?php if ($page['quick_answer']): ?>
    <div class="callout mb-6" id="quick-answer"><span class="callout__title">Quick answer</span><?= e($page['quick_answer']) ?></div>
<?php endif; if ($page['takeaways']): /* answer-first bullets: the part AI assistants quote most */ ?>
    <div class="takeaways mb-6" id="key-takeaways"><span class="takeaways__title">Key takeaways</span><ul><?php foreach ($page['takeaways'] as $t0) echo '<li>' . e($t0) . '</li>'; ?></ul></div>
<?php endif; ?>
    <div class="prose"><!--PROSE-->
<?php endif; ?>
