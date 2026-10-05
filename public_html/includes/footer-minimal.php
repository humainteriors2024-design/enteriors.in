<?php
/* ENTERIORS — MINIMAL FOOTER: one line with contact details and legal links.
   For landing pages and thank-you pages. Use: 'footer' => 'minimal' in $page. */
?>
<footer class="site-footer site-footer--minimal">
  <div class="container site-footer__bottom">
    <p>© <?= date('Y') ?> <?= e(NAP['legal_name'] ?: SITE['name']) ?></p>
    <?= component('nap', ['compact' => true]) ?>
    <div class="cluster" style="--gap: var(--sp-5)">
<?php foreach (live_links($LEGAL_LINKS) as $l) echo '<a href="' . e($l['href']) . '">' . e($l['label']) . '</a>'; ?>
    </div>
  </div>
</footer>
