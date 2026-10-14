<?php
$page = ['type' => 'page', 'title' => 'Thank you', 'noindex' => true,
  'header' => 'minimal', 'footer' => 'minimal',
  'description' => 'Thanks for your request. We will call you to understand your home and share up to three matching designer quotes.'];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section container container--text text-center">
  <span class="eyebrow">Request received</span>
  <h1 class="mt-4">Thank you — your request is with us</h1>
  <p class="lede mt-4 mb-6"><?= e(LEADS['promise']) ?> Meanwhile, get a rough budget with the calculator.</p>
  <?php if (is_live(SITE['cta']['href'])): ?><a class="btn btn--primary" href="<?= e(SITE['cta']['href']) ?>"><?= e(SITE['cta']['label']) ?></a><?php endif; ?>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
