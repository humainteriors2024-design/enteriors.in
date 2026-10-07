<?php
/* AUTHOR BOX — from AUTHORS in config.php; added automatically on articles. */
$a = AUTHORS[$p['id'] ?? $page['author']] ?? null;
if (!$a) return;
?>
<div class="author mt-8">
  <span class="author__avatar" aria-hidden="true"><?= e(mb_substr($a['name'], 0, 1)) ?></span>
  <div>
    <p class="author__name">Researched and written by <a href="<?= e($a['url']) ?>"><?= e($a['name']) ?></a></p>
    <p class="author__role"><?= e($a['role']) ?><?= $page['updated'] ? ' · Last updated ' . nice_date($page['updated']) : '' ?></p>
    <p class="author__bio"><?= e($a['bio']) ?></p>
  </div>
</div>
