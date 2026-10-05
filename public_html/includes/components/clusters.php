<?php
/* "IN THIS GUIDE" — the cluster pages of a pillar, grouped as in nav.php (hub → spoke links).
   Live pages are links. Pages not uploaded yet are hidden on the live site and shown as
   "planned" on staging, so you can see what is still to write.
   Use: component('clusters', ['hub' => hub('modular-kitchen')])  — added automatically on pillar pages.
   A pillar can instead list its own cards in $page['cards'] = [[url, title, text, label], …]. */
$h0 = $p['hub'] ?? null;
$manual = $p['cards'] ?? [];
$html = '';
if ($manual) {
  $html = '<div class="grid grid--lined">' . implode('', array_map(fn($c) => card($c[0], $c[1], $c[2] ?? '', $c[3] ?? ''), $manual)) . '</div>';
  if (!trim(strip_tags($html))) $html = '';
} elseif ($h0) {
  foreach ($h0['groups'] as $g) {
    $items = '';
    foreach ($g['links'] as $l) {
      if ($l['href'] === current_path()) continue;
      if (is_live($l['href'])) $items .= '<li><a href="' . e($l['href']) . '">' . e($l['label']) . '</a></li>';
      elseif (is_staging())    $items .= '<li class="is-planned">' . e($l['label']) . ' <span class="tag">planned</span></li>';
    }
    if ($items) $html .= '<div class="cluster-group"><p class="cluster-group__title">' . e(ltrim($g['title'], '✦ ')) . '</p><ul>' . $items . '</ul></div>';
  }
  if ($html) $html = '<div class="cluster-groups">' . $html . '</div>';
}
if (!$html) return;
?>
<section class="section section--grey section--tight">
  <div class="container">
    <?= section_head('In this', 'guide', $h0['label'] ?? 'Start here') ?>
    <?= $html ?>
  </div>
</section>
