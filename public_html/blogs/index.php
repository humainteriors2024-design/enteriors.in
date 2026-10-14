<?php
/* BLOG HUB — /blogs/
   Lists every post in includes/posts-data.php that has a file in /blogs/, newest first.
   Nothing to edit here when you add a post. Filter by category with /blogs/?category=Kitchen */
$page = [
  'type'        => 'page',
  'schema_type' => 'CollectionPage',
  'title'       => 'Enteriors Blog',
  'seo_title'   => 'Interior Design Blog: Ideas and How-To Guides',
  'crumb'       => 'Blog',
  'description' => 'Interior design ideas, colour combinations and how-to articles for Indian homes, each linked to a detailed guide on kitchens, wardrobes, rooms and costs.',
  'updated'     => '2026-10-03',
];
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
$all   = posts();
$cats  = array_values(array_unique(array_column($all, 'category')));
$cat   = in_array($_GET['category'] ?? '', $cats, true) ? $_GET['category'] : '';
$shown = $cat ? posts($cat) : $all;
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">Blog</span>
    <h1>Ideas and how-to articles</h1>
    <p class="subheading">Design ideas, colour combinations and practical how-tos. Every article points to the full guide it belongs to.</p>
<?php if (count($cats) > 1): ?>
    <div class="cluster mt-6">
      <a class="chip<?= $cat ? '' : ' is-active' ?>" href="/blogs/">All</a>
<?php foreach ($cats as $c): ?>
      <a class="chip<?= $c === $cat ? ' is-active' : '' ?>" href="/blogs/?category=<?= e(rawurlencode($c)) ?>"><?= e($c) ?></a>
<?php endforeach; ?>
    </div>
<?php endif; ?>
  </div>
</header>

<section class="section section--tight">
  <div class="container">
<?php if ($shown): ?>
    <div class="grid grid--lg">
<?php foreach ($shown as $po) echo component('post-card', ['post' => $po]); ?>
    </div>
<?php else: ?>
    <p class="muted">Articles are on the way. Meanwhile, start with one of the guides below.</p>
<?php endif; ?>
  </div>
</section>

<section class="section section--grey section--tight">
  <div class="container">
    <?= section_head('Start with a', 'guide', 'Pillar guides') ?>
    <div class="grid grid--lined grid--sm">
<?php foreach ($HUBS as $h0) if (!empty($h0['tier'])) echo card($h0['href'], $h0['label'], $h0['blurb'], icon: $h0['icon']); ?>
    </div>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
