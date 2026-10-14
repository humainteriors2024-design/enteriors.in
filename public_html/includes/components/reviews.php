<?php
/* REVIEWS — real, consented reviews only (REVIEWS in config.php). Hidden while the list is empty.
   Use: component('reviews') */
if (!REVIEWS) return;
?>
<section class="section section--grey">
  <div class="container">
    <?= section_head('Trusted by', 'homeowners', 'Client reviews') ?>
    <div class="grid">
<?php foreach (REVIEWS as $r): $initials = implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(explode(' ', $r['name']), 0, 2))); ?>
      <figure class="review">
        <span class="review__stars" aria-label="<?= (int)$r['stars'] ?> out of 5"><?= str_repeat('★', (int)$r['stars']) ?></span>
        <blockquote class="review__text"><?= e($r['text']) ?></blockquote>
        <figcaption class="review__who"><span class="author__avatar"><?= e($initials) ?></span><span><?= e($r['name']) ?><small><?= e($r['detail']) ?></small></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
  </div>
</section>
