<?php
/* =====================================================================
   CALLS TO ACTION — one file, six looks. Wording defaults come from config.php.

     component('cta', ['variant' => 'strip'])      slim red-tint strip inside articles: text + button (opens the pop-up form)
     component('cta', ['variant' => 'service'])    dark closing box on pillar pages → find a designer / free consultation
     component('cta', ['variant' => 'pillar', 'hub' => $hub])   "this article is part of …" link from a blog post up to its pillar
     component('cta', ['variant' => 'whatsapp'])   WhatsApp button (hidden until the number is set in config.php)
     component('cta', ['variant' => 'call'])       click-to-call button (hidden until the phone is set)
     component('cta', ['variant' => 'buttons'])    row: consultation + WhatsApp + call
   Calculator box: component('cta-band')

   Options: title, text, button, href
   ===================================================================== */
$variant = $p['variant'] ?? 'strip';
$consult = SITE['cta2'];

if ($variant === 'strip'): ?>
<aside class="cta-strip">
  <p><strong><?= e($p['title'] ?? 'Want this planned for your home?') ?></strong> <?= e($p['text'] ?? 'Share your floor plan and get a free consultation with a verified designer.') ?></p>
  <a class="btn btn--primary btn--sm" href="<?= e($p['href'] ?? $consult['href']) ?>" data-open-lead><?= e($p['button'] ?? $consult['label'] . ' →') ?></a>
</aside>
<?php elseif ($variant === 'service'):
  $find = '/services/find-designer/'; $live = is_live($find); ?>
<aside class="cta-band mt-8">
  <span class="eyebrow"><?= e($p['eyebrow'] ?? 'Next step') ?></span>
  <h2><?= e($p['title'] ?? 'Ready to plan yours with a designer?') ?></h2>
  <p><?= e($p['text'] ?? 'Get matched with a verified interior designer in Bangalore or Hosur and compare up to three itemised quotes. Free, no obligation.') ?></p>
  <div class="cluster" style="--gap: var(--sp-3)">
    <a class="btn btn--primary" href="<?= e($live ? $find : $consult['href']) ?>"<?= $live ? '' : ' data-open-lead' ?>><?= e($p['button'] ?? ($live ? 'Find a designer near you →' : $consult['label'] . ' →')) ?></a>
<?php if (is_live(SITE['cta']['href'])): ?>
    <a class="btn btn--outline" href="<?= e(SITE['cta']['href']) ?>"><?= e(SITE['cta']['label']) ?></a>
<?php endif; ?>
  </div>
</aside>
<?php elseif ($variant === 'pillar'):
  $h0 = $p['hub'] ?? null;
  if (!$h0 || !is_live($h0['href'])) return; ?>
<aside class="callout callout--pillar mt-8">
  <span class="callout__title">Part of a bigger guide</span>
  This article supports our <a href="<?= e($h0['href']) ?>"><?= e(empty($h0['keyword']) ? $h0['label'] : $h0['keyword']) ?> guide</a>, which covers layouts, materials, costs and how to choose.
</aside>
<?php elseif ($variant === 'whatsapp'):
  if (!($wa = whatsapp_href($p['text'] ?? null))) return; ?>
<a class="btn btn--whatsapp" href="<?= e($wa) ?>" target="_blank" rel="noopener" data-track="whatsapp"><?= e($p['button'] ?? 'Chat on WhatsApp') ?></a>
<?php elseif ($variant === 'call'):
  if (!NAP['phone']) return; ?>
<a class="btn btn--outline" href="<?= e(nap_phone_href()) ?>" data-track="call"><?= e($p['button'] ?? 'Call ' . NAP['phone']) ?></a>
<?php elseif ($variant === 'buttons'): ?>
<div class="cluster" style="--gap: var(--sp-3)">
  <a class="btn btn--primary" href="<?= e($consult['href']) ?>" data-open-lead><?= e($p['button'] ?? $consult['label'] . ' →') ?></a>
  <?= component('cta', ['variant' => 'whatsapp']) ?>
  <?= component('cta', ['variant' => 'call']) ?>
</div>
<?php endif;
