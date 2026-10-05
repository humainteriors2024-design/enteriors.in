<?php
/* LIVING STYLE GUIDE — every colour, font, spacing step and shared block on one page (not indexed).
   Open /style-guide/ to see what exists before building a page; copy the snippet shown under each block.
   If something is not here, add it to the right CSS file and component first, then use it. */
$page = ['type' => 'page', 'title' => 'Style Guide', 'noindex' => true, 'css' => ['article', 'tool'],
  'description' => 'Enteriors design system reference: colours, fonts, spacing, cards, article blocks, calls to action, the five lead forms and the image helpers used across the site.'];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
$colours = ['--red' => 'Links, buttons, accents', '--red-dark' => 'Hover', '--red-tint' => 'Light red fills', '--gold' => 'Accents on dark only',
  '--ink' => 'Header, footer, dark sections', '--ink-2' => 'Panels on dark', '--text' => 'Body text', '--muted' => 'Secondary text',
  '--line' => 'Borders', '--surface' => 'Grey sections', '--green' => 'Tips', '--amber' => 'Cautions'];
$fonts = ['body' => ['Inter', 'Everything you read: paragraphs, menus, forms, tables. Weight 400.'],
          'serif' => ['Fraunces', 'Headings H1–H4, card titles, quotes. Light weights 400–500.'],
          'display' => ['Bebas Neue', 'Logo, buttons, big section titles and numbers only.']];
$scale  = ['--fs-xs' => '12px labels', '--fs-sm' => '14px captions, tables', '--fs-md' => '16px interface', '--fs-body' => '17–18px article text',
           '--fs-lg' => '20px lede, h4', '--fs-xl' => '24px h3', '--fs-2xl' => '28–36px h2', '--fs-3xl' => '36–56px h1'];
$spaces = ['--sp-1' => '4', '--sp-2' => '8', '--sp-3' => '12', '--sp-4' => '16', '--sp-5' => '24', '--sp-6' => '32', '--sp-7' => '48', '--sp-8' => '64', '--sp-9' => '96'];
$code   = fn($s) => '<p class="sg-code"><code>' . e($s) . '</code></p>';
?>
<header class="page-header section--dark">
  <div class="container">
    <span class="eyebrow">Design system</span>
    <h1>Enteriors style guide</h1>
    <p class="subheading">One set of colours, fonts and spacing (tokens.css), one card, six calls to action, five lead forms, two headers and two footers. Everything below is live from the shared files.</p>
  </div>
</header>

<section class="section container">
  <?= section_head('Colours', '', '1 · tokens.css') ?>
  <div class="grid grid--sm">
<?php foreach ($colours as $t => $use): ?>
    <div class="card card--boxed"><span class="swatch" style="--swatch: var(<?= $t ?>)"></span><p class="card__title"><?= $t ?></p><p class="card__text"><?= $use ?></p></div>
<?php endforeach; ?>
  </div>

  <?= section_head('Fonts', '', '1 · tokens.css + fonts.css') ?>
  <div class="grid">
<?php foreach ($fonts as $k => [$name, $use]): ?>
    <div class="card card--boxed"><span class="card__label">--font-<?= $k ?></span><p class="font-sample font-sample--<?= $k ?>"><?= $name ?></p><p class="card__text"><?= $use ?></p></div>
<?php endforeach; ?>
  </div>

  <?= section_head('Type scale', '& spacing', '1 · tokens.css') ?>
  <div class="grid grid--lg">
    <div class="card card--boxed">
      <span class="card__label">Type scale</span>
<?php foreach ($scale as $t => $use): ?>
      <p style="font-size: var(<?= $t ?>); line-height: 1.25; margin-top: var(--sp-2)"><?= $t ?> <small class="muted" style="font-size: var(--fs-xs)"><?= $use ?></small></p>
<?php endforeach; ?>
    </div>
    <div class="card card--boxed">
      <span class="card__label">Spacing steps (px)</span>
<?php foreach ($spaces as $t => $px): ?>
      <p style="display: flex; align-items: center; gap: var(--sp-3); margin-top: var(--sp-2); font-size: var(--fs-sm)"><span style="display: inline-block; height: 12px; width: var(<?= $t ?>); background: var(--red)"></span><?= $t ?> · <?= $px ?></p>
<?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--grey">
  <div class="container stack" style="--stack: var(--sp-5)">
    <?= section_head('Headings', '& text', '2 · base.css') ?>
    <p style="font-family: var(--font-serif); font-weight: var(--weight-heading); font-size: var(--fs-3xl); line-height: 1.18; letter-spacing: -.01em">H1 — Modular Kitchen Design: Layouts and Cost</p>
    <p class="subheading">Sub-heading (.subheading) — one or two sentences under a heading.</p>
    <h2>H2 — Choosing a layout</h2>
    <h3>H3 — The work triangle</h3>
    <h4>H4 — Small heading</h4>
    <p style="font-size: var(--fs-body); line-height: var(--leading-body); max-width: var(--max-text)">Body text — Use boiling-water-proof plywood anywhere near water. <a href="#">This is a link</a>, and this is <strong>bold</strong>. Prices use the rupee sign: ₹4,500–6,000 per running foot.</p>
    <div class="cluster"><span class="eyebrow">Eyebrow</span><span class="tag">Tag</span><span class="tag tag--red">Red tag</span><span class="tag tag--pill">Pill</span><span class="badge">Badge</span><span class="badge badge--soon">Soon</span><a class="link-arrow" href="#">Link arrow</a></div>
    <div class="cluster" style="--gap: var(--sp-3)">
      <a class="btn btn--primary" href="#">Primary</a>
      <a class="btn btn--outline" href="#">Outline</a>
      <a class="btn btn--dark" href="#">Dark</a>
      <a class="btn btn--whatsapp" href="#">WhatsApp</a>
      <a class="btn btn--primary btn--sm" href="#">Small</a>
    </div>
  </div>
</section>

<section class="section container">
  <?= section_head('The', 'one card', '4 · components.css') ?>
  <?= $code("<?= card('/url/', 'Title', 'Text', label: 'Label', icon: '🪵', variant: 'boxed', tags: ['A', 'B'], meta: 'Read →') ?>") ?>
  <div class="grid grid--lined grid--sm mb-6">
    <?= card('', 'Materials', 'Default — pillar tiles on the home page', '', '🪵') ?>
    <?= card('', 'Cost Guides', 'A linked card shows a red bar on hover', '', '₹') ?>
    <?= card('', 'Room Guides', 'A lined grid shares its borders', '', '🛋️', tags: ['Living', 'Bedroom']) ?>
  </div>
  <div class="grid mb-6">
    <?= card('', 'Related page', 'Used for "Keep reading".', 'Boxed', '', 'boxed') ?>
    <?= card('', 'Plywood', 'With a price and tags', variant: 'serif', price: '₹75–120<small> /sq ft</small>', tags: ['MR', 'BWR']) ?>
    <?= card('', 'Trend or highlight', 'Accent variant.', 'Accent', '', 'accent') ?>
  </div>
  <div class="grid grid--sm mb-6">
    <?= tile('/', 'Tile with icon', 'Until a photo is uploaded', '🎋', 'linear-gradient(135deg,#2a1f14,#3d2b1a)') ?>
    <?= tile('/', 'Tile with photo', 'tile_art() finds the file', tile_art('🍳', 'hero', '/assets/blogs/kitchen-colour-combinations'), 'linear-gradient(135deg,#1a1a2e,#16213e)') ?>
  </div>
<?php if ($sample = posts(limit: 1)): ?>
  <h3 class="mb-6">Blog post card</h3>
  <?= $code("<?= component('post-card', ['post' => \$post]) ?>   // \$post from posts()") ?>
  <div class="grid grid--lg"><?php foreach ($sample as $po) echo component('post-card', ['post' => $po]); ?></div>
<?php endif; ?>
</section>

<section class="section section--dark">
  <div class="container">
    <?= section_head('On a', 'dark section', 'section--dark') ?>
    <div class="grid grid--lined">
      <?= card('', 'Acrylic vs Laminate', 'Cards adapt inside dark sections.', 'Compare') ?>
      <?= card('', 'Quartz vs Granite', 'No extra classes needed.', 'Compare') ?>
      <?= card('', 'HDHMR vs Plywood', 'Labels turn gold for contrast.', 'Compare') ?>
    </div>
  </div>
</section>

<section class="section container container--text">
  <?= section_head('Article', 'blocks', '4 · components.css + article.css') ?>
  <div class="prose">
    <div class="callout"><span class="callout__title">Key rule</span>Red callout: the one thing to remember.</div>
    <div class="callout callout--tip"><span class="callout__title">Tip</span>Green callout: a helpful shortcut.</div>
    <div class="callout callout--warn"><span class="callout__title">Ask in writing</span>Amber callout: a caution.</div>
    <div class="table-wrap">
    <table><thead><tr><th>Board</th><th>Best for</th><th class="num">18 mm, per sq ft</th></tr></thead>
      <tbody><tr><td>BWP plywood</td><td>Sink unit, vanity</td><td class="num">₹110–180</td></tr><tr><td>MR plywood</td><td>Wardrobes</td><td class="num">₹75–120</td></tr><tr class="is-total"><td>Total row</td><td></td><td class="num">₹0</td></tr></tbody>
    </table>
    </div>
    <p class="table-note">Table note: where the numbers come from and whether GST is included.</p>
    <div class="pros-cons">
      <div><span class="pros-cons__title">Left</span><ul><li>Point one</li><li>Point two</li></ul></div>
      <div><span class="pros-cons__title">Right</span><ul><li>Point one</li><li>Point two</li></ul></div>
    </div>
    <ol class="steps"><li><strong>Step one</strong>What happens first.</li><li><strong>Step two</strong>What happens next.</li></ol>
    <dl class="spec"><dt>Kitchen size</dt><dd>Small to medium</dd><dt>Daylight</dt><dd>Medium</dd></dl>
  </div>
  <h3 class="mt-8 mb-6">Verdict (comparison pages)</h3>
  <div class="verdict">
    <div class="verdict__option"><h3>Choose laminate if…</h3><ul><li>You cook every day</li><li>Budget matters</li></ul></div>
    <div class="verdict__option"><h3>Choose acrylic if…</h3><ul><li>You want deep gloss</li><li>The kitchen is open</li></ul></div>
  </div>
  <h3 class="mt-8 mb-6">FAQ</h3>
  <details class="faq"><summary>Is HDHMR better than plywood?</summary><div class="faq__body"><p>It is denser and smoother, but holds screws less well when a hole is reused.</p></div></details>
</section>

<section class="section section--grey">
  <div class="container container--text">
    <?= section_head('Images', '', '5 · includes/images.php') ?>
    <?= $code("<?= img('ivory-and-sage-green-two-colour-kitchen') ?>   // format found automatically; alt text = file name") ?>
    <?= img('ivory-and-sage-green-two-colour-kitchen', caption: true, dir: '/assets/blogs/kitchen-colour-combinations') ?>
    <?= $code("<?= img('a-photo-you-have-not-uploaded') ?>   // staging shows this box; the live site shows nothing") ?>
    <?= img('a-photo-you-have-not-uploaded', dir: '/assets/blogs/kitchen-colour-combinations') ?>
    <?= $code("<?= gallery('chalk') ?>   // every image whose name starts with \"chalk\"; gallery() = all images in the folder") ?>
    <?= gallery('chalk', dir: '/assets/blogs/kitchen-colour-combinations') ?>
  </div>
</section>

<section class="section container container--text">
  <?= section_head('Calls to', 'action', '6 · components/cta.php') ?>
  <?= $code("<?= component('cta', ['variant' => 'strip']) ?>") ?>
  <?= component('cta', ['variant' => 'strip']) ?>
  <?= $code("<?= component('cta', ['variant' => 'pillar', 'hub' => hub('modular-kitchen')]) ?>") ?>
  <?= component('cta', ['variant' => 'pillar', 'hub' => hub('modular-kitchen')]) ?>
  <?= $code("<?= component('cta', ['variant' => 'service']) ?>") ?>
  <?= component('cta', ['variant' => 'service']) ?>
  <?= $code("<?= component('cta-band') ?>   // calculator box; picks the calculator for the page's pillar") ?>
  <?= component('cta-band', ['href' => '/calculators/interior-cost/']) ?>
  <?= $code("<?= component('cta', ['variant' => 'buttons']) ?>   // WhatsApp and Call appear once the numbers are set in config.php") ?>
  <div class="mt-4"><?= component('cta', ['variant' => 'buttons']) ?></div>
</section>

<section class="section section--grey">
  <div class="container container--text">
    <?= section_head('Five', 'lead forms', '7 · components/lead-form.php') ?>
    <p class="muted mb-6">All five post to the same handler with the same spam checks. Options and wording: config.php → LEADS. On this staging copy, anything you send is saved as a test lead.</p>
    <?= $code("<?= component('lead-form', ['variant' => 'compact']) ?>   // 2 · blog posts, sidebars, the pop-up") ?>
    <?= component('lead-form', ['variant' => 'compact', 'id' => 'sg-compact']) ?>
    <?= $code("<?= component('lead-form', ['variant' => 'inline']) ?>   // 3 · one-row strip") ?>
    <div class="mt-4"><?= component('lead-form', ['variant' => 'inline', 'id' => 'sg-inline', 'text' => 'Leave your number and we will call you back.']) ?></div>
    <?= $code("<?= component('lead-form', ['variant' => 'callback']) ?>   // 4 · call me back, with a time slot") ?>
    <?= component('lead-form', ['variant' => 'callback', 'id' => 'sg-callback']) ?>
    <?= $code("<?= component('lead-form', ['variant' => 'quote']) ?>   // 5 · get 3 quotes, with budget and timeline") ?>
    <?= component('lead-form', ['variant' => 'quote', 'id' => 'sg-quote']) ?>
    <?= $code("<a class=\"btn btn--primary\" href=\"/contact/\" data-open-lead>…</a>   // any link with data-open-lead opens the pop-up form") ?>
    <div class="mt-4"><a class="btn btn--primary" href="/contact/" data-open-lead>Open the pop-up form</a></div>
  </div>
</section>

<section class="section container">
  <?= section_head('More', 'components', '8 · components.css') ?>
  <div class="tabs" role="tablist"><button class="tabs__btn" role="tab" aria-selected="true" aria-controls="sg-t1">Boards</button><button class="tabs__btn" role="tab" aria-selected="false" aria-controls="sg-t2">Finishes</button></div>
  <div role="tabpanel" id="sg-t1"><p>Tab panel one.</p></div><div role="tabpanel" id="sg-t2" hidden><p>Tab panel two.</p></div>
  <div class="cluster mt-6"><a class="chip" href="#">Chip</a><a class="chip is-active" href="#">Active chip</a><a class="chip" href="#">Hosur <small>City guide</small></a></div>
  <ul class="ticks mt-6"><li>Tick list for trust points</li><li>Used beside the consultation form</li></ul>
  <h3 class="mt-8 mb-6">Contact block (config.php → NAP)</h3>
  <?= component('nap') ?>
  <h3 class="mt-8 mb-6">Headers and footers</h3>
  <p class="muted">Every page gets the full header and footer. A landing page can ask for the short ones in its settings: <code>'header' =&gt; 'minimal', 'footer' =&gt; 'minimal'</code> (see <a href="/thank-you/">the thank-you page</a>).</p>
</section>

<?= $code("<?= component('lead-form', ['variant' => 'full']) ?>   // 1 · the dark section below: home, contact, pillar and calculator pages") ?>
<?= component('lead-form', ['variant' => 'full', 'id' => 'sg-lead']) ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
