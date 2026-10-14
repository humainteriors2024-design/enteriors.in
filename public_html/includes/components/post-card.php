<?php
/* POST CARD — one blog post in a list (blog hub, home page, pillar pages).
   Use: component('post-card', ['post' => $post])   where $post comes from posts() */
$po = $p['post'];
$thumb = media_find(MEDIA['hero_name'], MEDIA['blog_dir'] . '/' . $po['folder']);
?>
<a class="post-card" href="<?= e($po['url']) ?>">
<?php if ($thumb): ?>
  <picture><?php if ($thumb['webp']): ?><source srcset="<?= e($thumb['webp']) ?>" type="image/webp"><?php endif; ?><img class="post-card__img" src="<?= e($thumb['url']) ?>" alt="<?= e($po['hero_alt']) ?>" width="<?= $thumb['w'] ?>" height="<?= $thumb['h'] ?>" loading="lazy" decoding="async"></picture>
<?php endif; ?>
  <span class="post-card__body">
    <span class="card__label"><?= e($po['category']) ?></span>
    <span class="post-card__title"><?= e($po['title']) ?></span>
    <span class="card__text"><?= e($po['description']) ?></span>
    <span class="post-card__meta"><?= nice_date($po['updated'] ?? $po['date']) ?></span>
  </span>
</a>
