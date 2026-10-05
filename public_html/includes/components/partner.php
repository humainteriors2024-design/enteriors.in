<?php
/* PARTNER BOX — "built by our execution partner" box linking to humainteriors.com (config.php → PARTNER).
   Added automatically by foot.php on guides, comparisons and blog posts. Wording and follow/nofollow
   come from includes/partner.php. Hide it on a page with 'partner' => false.
     component('partner')                              automatic topic and link policy
     component('partner', ['topic' => 'kitchen'])      force a topic
     component('partner', ['variant' => 'line'])       one-line version (footer) — always nofollow */
global $hub;
if (($page['partner'] ?? null) === false) return;
$variant = $p['variant'] ?? 'box';

if ($variant === 'line'): ?>
<p class="partner-line">Execution partner for South-East Bengaluru: <?= huma('home', PARTNER['name'] . ' (Chandapura)', follow: false) ?> — modular kitchens, wardrobes and home interiors for Electronic City, Chandapura and Bommasandra.</p>
<?php return; endif;

$hubKey = $p['hub'] ?? ($hub['key'] ?? null);
$topic  = $p['topic'] ?? partner_topic($page, $hubKey);
$follow = $p['follow'] ?? partner_follow($page, $hubKey, $topic);
$btnKey = ['kitchen' => 'kitchen', 'wardrobe' => 'wardrobe', 'living' => 'living', 'cost' => 'home', 'local' => 'home'][$topic] ?? 'home';
?>
<aside class="partner mt-8" aria-label="Execution partner">
  <span class="partner__label">Execution partner · South-East Bengaluru</span>
  <p class="partner__title"><?= e($p['title'] ?? partner_title($topic)) ?></p>
  <p class="partner__text"><?= $p['text'] ?? partner_sentence($topic, $follow) ?></p>
  <div class="partner__actions">
    <?= huma($btnKey, 'Visit ' . PARTNER['name'] . ' →', follow: false, class: 'btn btn--dark btn--sm') ?>
    <span class="partner__areas"><?= e(implode(' · ', array_slice(PARTNER['areas'], 0, 6))) ?></span>
  </div>
  <p class="partner__note">Partner link<?= is_live(PARTNER['page']) ? ' · <a href="' . e(PARTNER['page']) . '">How we work with ' . e(PARTNER['name']) . '</a>' : '' ?></p>
</aside>
