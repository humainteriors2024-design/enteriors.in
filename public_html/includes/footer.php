<?php
/* =====================================================================
   ENTERIORS — SITE FOOTER (full) — included by foot.php on every page
   Brand + contact details, CTAs, link columns for every pillar ($FOOTER in nav.php),
   areas served, legal links, social icons. Styles: footer.css
   Use 'footer' => 'minimal' in $page for landing pages.
   =====================================================================*/
$icons = [
  'instagram' => 'M12 7a5 5 0 100 10 5 5 0 000-10zm0 8.2a3.2 3.2 0 110-6.4 3.2 3.2 0 010 6.4zM17.3 5.5a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4zM12 2c-2.7 0-3 0-4.1.1C4.3 2.3 2.3 4.3 2.1 7.9 2 9 2 9.3 2 12s0 3 .1 4.1c.2 3.6 2.2 5.6 5.8 5.8 1.1.1 1.4.1 4.1.1s3 0 4.1-.1c3.6-.2 5.6-2.2 5.8-5.8.1-1.1.1-1.4.1-4.1s0-3-.1-4.1c-.2-3.6-2.2-5.6-5.8-5.8C15 2 14.7 2 12 2z',
  'facebook'  => 'M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7A10 10 0 0022 12z',
  'email'     => 'M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z',
];
?>
<footer class="site-footer">
  <div class="container">
    <div class="site-footer__top">
      <div>
        <a href="/" class="logo">Enter<span>iors</span><sup>IN</sup></a>
        <p class="site-footer__tagline"><?= e(SITE['tagline']) ?></p>
        <?= component('nap') ?>
      </div>
      <div class="cluster" style="--gap: var(--sp-3)">
<?php if (is_live(SITE['cta']['href'])): ?>
        <a href="<?= e(SITE['cta']['href']) ?>" class="btn btn--primary"><?= e(SITE['cta']['label']) ?></a>
<?php endif; ?>
        <a href="<?= e(SITE['cta2']['href']) ?>" class="btn btn--outline" data-open-lead><?= e(SITE['cta2']['label']) ?></a>
<?php if ($wa = whatsapp_href()): ?>
        <a href="<?= e($wa) ?>" class="btn btn--outline" target="_blank" rel="noopener" data-track="whatsapp">WhatsApp us</a>
<?php endif; ?>
      </div>
    </div>
    <div class="site-footer__links">
<?php foreach ($FOOTER as $title => $links) { $links = live_links($links); if ($links) echo link_list($links, $title); } ?>
    </div>
    <div class="site-footer__areas">
<?php foreach (AREAS as $city => [$href, $places]): ?>
      <p><strong><?= is_live($href) ? '<a href="' . e($href) . '">' . e($city) . '</a>' : e($city) ?>:</strong> <?= e(implode(' · ', $places)) ?></p>
<?php endforeach; ?>
<?php if (defined('PARTNER') && !empty(PARTNER['on'])): ?>
      <p class="site-footer__partner"><strong>Partner studio:</strong> <?= partner_a(PARTNER['name'], PARTNER['url'], 'nofollow') ?>, <?= e(PARTNER['where']) ?>.</p>
<?php endif; ?>
    </div>
    <div class="site-footer__bottom">
      <p>© <?= date('Y') ?> <?= e(NAP['legal_name'] ?: SITE['name']) ?>. Prices are indicative for Bangalore &amp; Hosur; actual quotes vary by site and specification.</p>
      <div class="cluster" style="--gap: var(--sp-5)">
<?php foreach (live_links($LEGAL_LINKS) as $l) echo '<a href="' . e($l['href']) . '">' . e($l['label']) . '</a>'; ?>
<?php if (!site_locked()): ?>
        <a href="/sitemap.xml">Sitemap</a>
<?php endif; ?>
      </div>
      <div class="social">
<?php foreach (array_filter(SOCIAL) as $name => $url) echo '<a href="' . e($url) . '" target="_blank" rel="noopener" aria-label="' . e(SITE['name']) . ' on ' . ucfirst($name) . '"><svg viewBox="0 0 24 24"><path d="' . $icons[$name] . '"/></svg></a>'; ?>
<?php if (NAP['email']) echo '<a href="mailto:' . e(NAP['email']) . '" aria-label="Email ' . e(SITE['name']) . '"><svg viewBox="0 0 24 24"><path d="' . $icons['email'] . '"/></svg></a>'; ?>
      </div>
    </div>
  </div>
</footer>
