<?php
/* FAQ — questions from $page['faq'] (question => answer). Added automatically on articles.
   Use elsewhere: component('faq', ['items' => ['Q?' => 'A.']]) */
$items = $p['items'] ?? $page['faq'] ?? [];
if (!$items) return;
?>
<section class="mt-8" aria-labelledby="faq">
  <h2 id="faq" class="mb-6"><?= e($p['title'] ?? 'Frequently asked questions') ?></h2>
<?php foreach ($items as $q => $a): ?>
  <details class="faq"><summary><?= e($q) ?></summary><div class="faq__body"><p><?= e($a) ?></p></div></details>
<?php endforeach; ?>
</section>
