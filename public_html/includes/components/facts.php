<?php
/* FACTS STRIP — true, provable numbers from config.php → FACTS (rating, homes, warranty …).
   Hidden while every fact is blank. Use: component('facts') */
$facts = site_facts();
if (!$facts) return;
?>
<div class="facts">
  <div class="container facts__row">
<?php foreach ($facts as [$num, $label]): ?>
    <div><span class="stat__num"><?= e($num) ?></span><span class="stat__label"><?= e($label) ?></span></div>
<?php endforeach; ?>
  </div>
</div>
