<?php
/* STICKY CTA — floating Call / WhatsApp / Consultation buttons after the visitor scrolls (site.js).
   Switch off with STICKY_CTA = false in config.php. */
if (!STICKY_CTA) return;
?>
<div class="sticky-cta" data-sticky-cta>
<?php if (NAP['phone']): ?>  <a class="btn btn--dark btn--sm" href="<?= e(nap_phone_href()) ?>" data-track="call">Call now</a>
<?php endif; ?>
<?php if ($wa = whatsapp_href()): ?>  <a class="btn btn--dark btn--sm" href="<?= e($wa) ?>" target="_blank" rel="noopener" data-track="whatsapp">WhatsApp</a>
<?php endif; ?>
  <a class="btn btn--primary btn--sm" href="<?= e(SITE['cta2']['href']) ?>" data-open-lead><?= e(SITE['cta2']['label']) ?> ↗</a>
</div>
