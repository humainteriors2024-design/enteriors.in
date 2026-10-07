<?php
/* =====================================================================
   WARDROBE COST CALCULATOR — component('wardrobe-calc')  (full: /calculators/wardrobe-cost/)
   component('wardrobe-calc', ['compact' => true])   one-row version inside articles (BHK and bedroom pages)
   Worked out on the server (calc_wardrobe). Prices: includes/calc/rates.php → 'wardrobe'.
   ===================================================================== */
require_once dirname(__DIR__) . '/calc/engine.php';
$W = calc_rates()['wardrobe'];
$compact = !empty($p['compact']);
$R = calc_wardrobe(['width' => $p['width'] ?? 8, 'height' => $p['height'] ?? 7]);
$o = $R['out'];
$GLOBALS['page']['js'][] = 'calc';
$sel = fn($name, $set, $def) => '<select class="input" id="wd-' . $name . '" name="' . $name . '">' . implode('', array_map(fn($k, $v) => '<option value="' . $k . '"' . ($k === $def ? ' selected' : '') . '>' . e($v[0]) . '</option>', array_keys($set), $set)) . '</select>';
?>
<div class="estimator<?= $compact ? ' estimator--stack' : '' ?>" data-calc="wardrobe">
  <form action="/calculators/wardrobe-cost/" method="get">
    <fieldset class="est-step">
      <legend class="est-step__title"><span>1</span>Size and doors</legend>
      <p class="est-step__hint">Wardrobes are priced by the area of the front: width × height. Measure the wall you want to fill.</p>
      <div class="fields mt-4">
        <div class="field"><label for="wd-width">Width (ft)</label><input class="input" id="wd-width" name="width" type="number" min="2" max="24" step="0.5" value="<?= +$R['in']['width'] ?>"></div>
        <div class="field"><label for="wd-height">Height (ft)</label><input class="input" id="wd-height" name="height" type="number" min="5" max="11" step="0.5" value="<?= +$R['in']['height'] ?>"></div>
        <div class="field"><label for="wd-loft">Loft above (ft)</label><input class="input" id="wd-loft" name="loft" type="number" min="0" max="4" step="0.5" value="0"></div>
        <div class="field"><label for="wd-door">Doors</label><?= $sel('door', $W['door'], 'hinged') ?></div>
        <div class="field"><label for="wd-finish">Finish</label><?= $sel('finish', $W['finish'], 'laminate') ?></div>
        <div class="field"><label for="wd-city">City</label><select class="input" id="wd-city" name="city"><?php foreach (calc_rates()['cities'] as $c => $f) echo '<option>' . e($c) . '</option>'; ?></select></div>
      </div>
    </fieldset>
    <fieldset class="est-step">
      <legend class="est-step__title"><span>2</span>Internal fittings</legend>
      <div class="options">
<?php foreach ($W['acc'] as $k => [$label, $price]): ?>
        <label class="option"><input type="checkbox" name="acc[]" value="<?= $k ?>"><span><?= e($label) ?><small>+<?= inr($price) ?></small></span></label>
<?php endforeach; ?>
      </div>
    </fieldset>
  </form>
  <aside class="summary" aria-live="polite">
    <div class="summary__head"><strong>Wardrobe estimate</strong><span data-out="meta"><?= $o['meta'] ?></span></div>
    <div class="summary__total"><div class="summary__amount" data-out="total"><?= $o['total'] ?></div><div class="summary__range" data-out="range"><?= $o['range'] ?></div></div>
    <ul class="summary__lines">
      <li>Front area <b data-out="area"><?= $o['area'] ?></b></li>
      <li>Rate <b data-out="rate"><?= $o['rate'] ?></b></li>
      <li>Wardrobe <b data-out="base"><?= $o['base'] ?></b></li>
      <li>Loft <b data-out="loft"><?= $o['loft'] ?></b></li>
      <li>Fittings <b data-out="fittings"><?= $o['fittings'] ?></b></li>
      <li>GST (<?= round(calc_rates()['gst'] * 100) ?>%) <b data-out="gst"><?= $o['gst'] ?></b></li>
    </ul>
    <div class="summary__foot">
      <a class="btn btn--primary btn--block" href="<?= e(SITE['cta2']['href']) ?>" data-open-lead>Get quotes for this wardrobe →</a>
      <p class="summary__note">Indicative for <?= e(calc_rates()['as_of']) ?>. Final price depends on internal layout and exact measurements.</p>
    </div>
  </aside>
</div>
