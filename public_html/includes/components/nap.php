<?php
/* NAP — Name, Address, Phone from config.php. Identical everywhere (footer, contact, lead section).
   Use: component('nap')  or  component('nap', ['compact' => true]) */
$compact = $p['compact'] ?? false;
$addr = nap_address_line();
?>
<address class="nap">
<?php if (!$compact): ?>  <span class="nap__name"><?= e(NAP['legal_name'] ?: SITE['name']) ?></span>
<?php endif; ?>
<?php if ($addr && !$compact): ?>  <span><?= e($addr) ?></span>
<?php endif; ?>
<?php if (NAP['phone']): ?>  <a href="<?= e(nap_phone_href()) ?>" data-track="call">📞 <?= e(NAP['phone']) ?></a>
<?php endif; ?>
<?php if (NAP['whatsapp']): ?>  <a href="<?= e(whatsapp_href()) ?>" target="_blank" rel="noopener" data-track="whatsapp">💬 WhatsApp</a>
<?php endif; ?>
<?php if (NAP['email']): ?>  <a href="mailto:<?= e(NAP['email']) ?>">✉ <?= e(NAP['email']) ?></a>
<?php endif; ?>
<?php if (NAP['hours_text'] && !$compact): ?>  <span>🕘 <?= e(NAP['hours_text']) ?></span>
<?php endif; ?>
<?php if (NAP['map_url'] && !$compact): ?>  <a href="<?= e(NAP['map_url']) ?>" target="_blank" rel="noopener">📍 View on map</a>
<?php endif; ?>
</address>
