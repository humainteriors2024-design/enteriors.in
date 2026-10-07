<?php
/* CTA BAND — dark box pointing to a calculator. By default it picks the calculator that
   matches the page's pillar (kitchen pages → kitchen calculator, wardrobe pages → wardrobe
   calculator, everything else → interior cost calculator).
   Use: component('cta-band')  or  component('cta-band', ['title' => '…', 'text' => '…', 'href' => '/x/', 'button' => 'Go →']) */
global $hub;
$byHub = [
  'modular-kitchen' => ['/calculators/modular-kitchen/', 'What will your kitchen cost?', 'Price your kitchen by running foot, board, finish and hardware. Free, no signup.', 'Modular Kitchen Calculator →'],
  'wardrobe'        => ['/calculators/wardrobe-cost/', 'What will your wardrobe cost?', 'Enter the size, door type and finish for an instant estimate. Free, no signup.', 'Wardrobe Calculator →'],
];
$pick = $byHub[$hub['key'] ?? ''] ?? null;
if ($pick && !is_live($pick[0])) $pick = null;
$href = $p['href'] ?? ($pick[0] ?? SITE['cta']['href']);
if (!is_live($href) || $href === current_path()) return;
?>
<aside class="cta-band mt-8">
  <span class="eyebrow"><?= e($p['eyebrow'] ?? 'Free tool') ?></span>
  <h2><?= e($p['title'] ?? ($pick[1] ?? 'What will your interiors cost?')) ?></h2>
  <p><?= e($p['text'] ?? ($pick[2] ?? 'Get a room-by-room estimate with your choice of material grade, hardware brand and city. Free, no signup.')) ?></p>
  <a class="btn btn--primary" href="<?= e($href) ?>"><?= e($p['button'] ?? ($pick[3] ?? SITE['cta']['label'])) ?></a>
</aside>
