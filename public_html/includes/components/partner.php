<?php
/* PARTNER BOX — printed by foot.php at the end of the article on pages listed in includes/data/partners.php.
   One short, relevant pointer to our partner studio, with the relationship disclosed when it promotes the studio.
   component('partner')                       the links for the current page
   component('partner', ['path' => '/x/'])    the links for another path (used by the locality guides) */
if (!defined('PARTNER') || empty(PARTNER['on'])) return;
$items = partner_links()[$p['path'] ?? current_path()] ?? [];
if (!$items) return;
$label = ''; $promo = false; $out = [];
foreach (array_slice($items, 0, 2) as $it) {
  [$text, $anchor, $url, $rel] = $it;
  $label = $label ?: ($it[4] ?? '');
  $promo = $promo || $rel === 'sponsored' || stripos($label, 'partner') !== false;
  $html = str_replace('{a}', partner_a($anchor, $url, $rel), e($text));
  if (!empty($it[5])) [$a2, $u2, $r2] = $it[5];
  if (!empty($it[5])) $html = str_replace('{b}', partner_a($a2, $u2, $r2), $html);
  $out[] = $html;
}
?>
<aside class="callout partner-box mt-8" aria-label="<?= e($label ?: 'From our partner studio') ?>">
  <span class="callout__title"><?= e($label ?: 'From our partner studio') ?></span>
  <p><?= implode(' ', $out) ?></p>
<?php if ($promo): ?>
  <p class="partner-box__note"><?= e(PARTNER['note']) ?></p>
<?php endif; ?>
</aside>
