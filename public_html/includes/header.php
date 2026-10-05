<?php
/* =====================================================================
   ENTERIORS — SITE HEADER (full) — included by head.php on every page
   Logo, pillar menu, CTA button, mobile menu. Links: nav.php. Styles: header.css
   The menu shows at most five pillar entries ('menu' => true in nav.php) plus one
   "Guides" menu for every other pillar. Use 'header' => 'minimal' in $page for
   landing pages that should show only the logo and one button.
   ===================================================================== */
$menu = array_values(array_filter($HUBS, fn($h) => !empty($h['menu']) && $h['key'] !== 'blog'));
$menu[] = $GUIDES_MENU;
$menu[] = hub('blog');
$hubsLive = [];
foreach ($menu as $hub0) {
  $groups = [];
  foreach ($hub0['groups'] as $g) { $l = live_links($g['links']); if ($l) $groups[] = $g + ['live' => $l]; }
  $pillarLive = $hub0['href'] !== '' && is_live($hub0['href']);
  if ($pillarLive || $groups) $hubsLive[] = $hub0 + ['live_groups' => $groups, 'pillar_live' => $pillarLive];
}
$here = current_path();
?>
<header class="site-header">
  <div class="container site-header__bar">
    <a href="/" class="logo" aria-label="<?= e(SITE['name']) ?> home">Enter<span>iors</span><sup>IN</sup></a>

    <nav class="nav" aria-label="Main">
<?php foreach ($hubsLive as $h): ?>
      <div class="nav__item" data-nav-item>
        <a class="nav__link"<?= $h['pillar_live'] ? ' href="' . e($h['href']) . '"' : ' tabindex="0"' ?><?= $h['href'] !== '' && str_starts_with($here, $h['href']) ? ' aria-current="page"' : '' ?>><?= e($h['label']) ?></a>
<?php if ($h['live_groups']): ?>
        <button class="nav__toggle" aria-expanded="false" aria-label="Show <?= e($h['label']) ?> menu" data-nav-toggle><svg viewBox="0 0 24 24"><polyline points="6,9 12,15 18,9"/></svg></button>
        <div class="mega">
          <div class="container mega__grid">
<?php foreach ($h['live_groups'] as $g) echo link_list($g['live'], $g['title'], !empty($g['gold'])); ?>
<?php if (!empty($h['feature']) && is_live($h['feature']['href'])) {
        $f = $h['feature'];
        echo card($f['href'], $f['title'], $f['text'], $f['label'], '', 'dark', $f['cta'] . ' →');
      } ?>
          </div>
        </div>
<?php endif; ?>
      </div>
<?php endforeach; ?>
    </nav>

    <div class="site-header__actions">
<?php if (NAP['phone']): ?>
      <a class="site-header__phone" href="<?= e(nap_phone_href()) ?>" data-track="call"><?= e(NAP['phone']) ?></a>
<?php endif; ?>
<?php if (is_live(SITE['cta']['href'])): ?>
      <a href="<?= e(SITE['cta']['href']) ?>" class="btn btn--primary btn--sm site-header__cta"><?= e(SITE['cta']['label']) ?></a>
<?php endif; ?>
    </div>
    <button class="burger" aria-label="Open menu" aria-expanded="false" data-burger><span></span><span></span><span></span></button>
  </div>

  <div class="mobile-nav" data-mobile-nav>
<?php foreach ($hubsLive as $h):
        $links = $h['pillar_live'] ? [['label' => $h['label'] . ' — full guide', 'href' => $h['href']]] : [];
        foreach ($h['live_groups'] as $g) $links = array_merge($links, $g['live']);
        if (count($links) === 1): ?>
    <a class="mobile-nav__link" href="<?= e($links[0]['href']) ?>"><?= e($h['label']) ?></a>
<?php   else: ?>
    <details><summary><?= e($h['label']) ?></summary><?= link_list($links) ?></details>
<?php   endif; endforeach; ?>
    <a href="<?= e(SITE['cta2']['href']) ?>" class="btn btn--primary" data-open-lead><?= e(SITE['cta2']['label']) ?></a>
<?php if (is_live(SITE['cta']['href'])): ?>
    <a href="<?= e(SITE['cta']['href']) ?>" class="btn btn--outline"><?= e(SITE['cta']['label']) ?></a>
<?php endif; ?>
  </div>
</header>
