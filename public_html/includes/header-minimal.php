<?php
/* ENTERIORS — MINIMAL HEADER: logo + phone + one button, no menu.
   For landing pages, thank-you pages and ad campaigns. Use: 'header' => 'minimal' in $page. */
?>
<header class="site-header site-header--minimal">
  <div class="container site-header__bar">
    <a href="/" class="logo" aria-label="<?= e(SITE['name']) ?> home">Enter<span>iors</span><sup>IN</sup></a>
    <div class="site-header__actions">
<?php if (NAP['phone']): ?>
      <a class="site-header__phone" href="<?= e(nap_phone_href()) ?>" data-track="call"><?= e(NAP['phone']) ?></a>
<?php endif; ?>
      <a href="<?= e(SITE['cta2']['href']) ?>" class="btn btn--primary btn--sm" data-open-lead><?= e(SITE['cta2']['label']) ?></a>
    </div>
  </div>
</header>
