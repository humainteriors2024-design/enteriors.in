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
  'youtube'   => 'M23.5 6.2a3 3 0 00-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 00.5 6.2C0 8.1 0 12 0 12s0 3.9.5 5.8a3 3 0 002.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 002.1-2.1c.5-1.9.5-5.8.5-5.8s0-3.9-.5-5.8zM9.5 15.6V8.4l6.3 3.6-6.3 3.6z',
  'linkedin'  => 'M20.4 20.5h-3.6v-5.6c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9v5.7H9.4V9h3.4v1.6c.5-.9 1.6-1.8 3.4-1.8 3.6 0 4.3 2.4 4.3 5.5v6.2zM5.3 7.4a2.1 2.1 0 110-4.1 2.1 2.1 0 010 4.1zm1.8 13.1H3.6V9h3.6v11.5z',
  'pinterest' => 'M12 2a10 10 0 00-3.6 19.3c-.1-.8-.2-2 0-2.9l1.2-5s-.3-.6-.3-1.5c0-1.4.8-2.4 1.8-2.4.9 0 1.3.6 1.3 1.4 0 .9-.5 2.1-.8 3.3-.2 1 .5 1.8 1.5 1.8 1.8 0 3-2.3 3-5 0-2-1.4-3.6-3.9-3.6a4.5 4.5 0 00-4.7 4.5c0 .8.3 1.4.6 1.8.2.2.2.3.1.5l-.2.8c-.1.3-.3.3-.5.2-1.4-.6-2-2.1-2-3.8 0-2.8 2.4-6.2 7.1-6.2 3.8 0 6.3 2.8 6.3 5.7 0 3.9-2.2 6.9-5.4 6.9-1.1 0-2.1-.6-2.4-1.3l-.7 2.8c-.3 1-.8 2-1.3 2.8A10 10 0 1012 2z',
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
      <p><strong><?= is_live($href) ? '<a href="' . e($href) . '">' . e($city) . '</a>' : e($city) ?>:</strong> <?= implode(' · ', array_map('locality_link', $places)) ?></p>
<?php endforeach; ?>
      <?= component('partner', ['variant' => 'line']) ?>
    </div>
    <div class="site-footer__bottom">
      <p>© <?= date('Y') ?> <?= e(NAP['legal_name'] ?: SITE['name']) ?>. Prices are indicative for Bangalore &amp; Hosur; actual quotes vary by site and specification.</p>
      <div class="cluster" style="--gap: var(--sp-5)">
<?php foreach (live_links($LEGAL_LINKS) as $l) echo '<a href="' . e($l['href']) . '">' . e($l['label']) . '</a>'; ?>
        <a href="/sitemap.xml">Sitemap</a>
      </div>
      <div class="social">
<?php foreach (array_filter(SOCIAL) as $name => $url) echo '<a href="' . e($url) . '" target="_blank" rel="noopener" aria-label="' . e(SITE['name']) . ' on ' . $name . '"><svg viewBox="0 0 24 24"><path d="' . $icons[$name] . '"/></svg></a>'; ?>
      </div>
    </div>
  </div>
</footer>
