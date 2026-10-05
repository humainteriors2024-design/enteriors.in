<?php
/* =====================================================================
   WHOLE-HOME COST ESTIMATOR — one calculator, used on several pages:
     home page                      component('estimator', ['compact' => true])
     /cost/ pillar                  component('estimator', ['compact' => true, 'stack' => true])
     /calculators/interior-cost/    component('estimator')                         (adds extras + contingency)
     BHK cost pages                 component('estimator', ['home' => '3 BHK', 'scope' => false, 'addons' => ['balcony', 'utility'], 'min' => 1000, 'max' => 2500, 'title' => 'Your 3 BHK estimate'])
   Worked out on the server (includes/calc/engine.php → calc_home). Prices: includes/calc/rates.php.
   The page lists 'calc' in $page['js'] (head.php adds it automatically when this component is used).
   ===================================================================== */
require_once dirname(__DIR__) . '/calc/engine.php';
$H       = calc_rates()['home'];
$compact = !empty($p['compact']);
$extras  = $p['extras'] ?? !$compact;
$showScope = $p['scope'] ?? true;
$defHome = $p['home'] ?? '2 BHK';
$defAddons = $p['addons'] ?? [];
$defBuffer = $extras ? ($p['buffer'] ?? 10) : 0;
$uid     = 'est' . substr(md5(json_encode($p)), 0, 4);
$R       = calc_home(['home' => $defHome, 'area' => $p['area'] ?? $H['sizes'][$defHome], 'addon' => $defAddons, 'buffer' => $defBuffer]);
$o       = $R['out'];
$GLOBALS['page']['js'][] = 'calc';   // make sure the script is on the page
?>
<div class="estimator<?= $compact ? ' estimator--compact' : '' ?><?= !empty($p['stack']) ? ' estimator--stack' : '' ?>" data-calc="home">
  <form action="<?= e(SITE['cta']['href']) ?>" method="get">
    <fieldset class="est-step">
      <legend class="est-step__title"><span>1</span>Your home</legend>
      <div class="fields mt-4">
        <div class="field"><label for="<?= $uid ?>-home">Home type</label>
          <select class="input" id="<?= $uid ?>-home" name="home"><?php foreach ($H['sizes'] as $label => $sqft) echo '<option data-fill=\'{"area":' . $sqft . '}\'' . ($label === $defHome ? ' selected' : '') . '>' . e($label) . '</option>'; ?></select></div>
        <div class="field"><label for="<?= $uid ?>-city">City</label>
          <select class="input" id="<?= $uid ?>-city" name="city"><?php foreach (calc_rates()['cities'] as $c => $f) echo '<option>' . e($c) . '</option>'; ?></select></div>
      </div>
      <div class="range-row mt-4"><label for="<?= $uid ?>-area">Carpet area</label><output data-out="area"><?= $o['area'] ?></output></div>
      <input class="range" id="<?= $uid ?>-area" name="area" type="range" min="<?= (int) ($p['min'] ?? 300) ?>" max="<?= (int) ($p['max'] ?? 4000) ?>" step="50" value="<?= (int) $R['in']['area'] ?>">
      <p class="est-step__hint">Carpet area is the floor inside your walls, usually 70–78% of the super built-up area on the sale deed.</p>
    </fieldset>
    <fieldset class="est-step">
      <legend class="est-step__title"><span>2</span><?= $showScope ? 'Grade and scope' : 'Package' ?></legend>
      <h4>Material grade</h4>
      <div class="options">
<?php foreach ($H['grades'] as $k => [$label, $hint]): ?>
        <label class="option"><input type="radio" name="pkg" value="<?= $k ?>"<?= $k === 'standard' ? ' checked' : '' ?>><span><?= e($label) ?><small><?= e($hint) ?> · ₹<?= number_format($H['per_sqft'][$k]) ?>/sq ft</small></span></label>
<?php endforeach; ?>
      </div>
<?php if ($showScope): ?>
      <h4>Scope of work</h4>
      <div class="options">
<?php foreach ($H['scope'] as $k => [$m, $label, $hint]): ?>
        <label class="option"><input type="radio" name="scope" value="<?= $k ?>"<?= $k === 'full' ? ' checked' : '' ?>><span><?= e($label) ?><small><?= e($hint) ?></small></span></label>
<?php endforeach; ?>
      </div>
<?php endif; ?>
    </fieldset>
<?php if ($extras): ?>
    <fieldset class="est-step">
      <legend class="est-step__title"><span>3</span>Extras and buffer</legend>
      <p class="est-step__hint">Rooms and systems that are not part of a standard scope.</p>
      <div class="options">
<?php foreach ($H['addons'] as $k => [$label, $hint, $price]): ?>
        <label class="option"><input type="checkbox" name="addon[]" value="<?= $k ?>"<?= in_array($k, $defAddons) ? ' checked' : '' ?>><span><?= e($label) ?><small><?= e($hint) ?> · +<?= lakh($price) ?></small></span></label>
<?php endforeach; ?>
      </div>
      <div class="range-row mt-4"><label for="<?= $uid ?>-buffer">Contingency buffer</label><output data-out="buffer"><?= $o['buffer'] ?></output></div>
      <input class="range" id="<?= $uid ?>-buffer" name="buffer" type="range" min="0" max="20" step="5" value="<?= $defBuffer ?>">
    </fieldset>
<?php endif; ?>
  </form>
  <aside class="summary" aria-live="polite">
    <div class="summary__head"><strong><?= e($p['title'] ?? 'Your estimate') ?></strong><span data-out="meta"><?= $o['meta'] ?></span></div>
    <div class="summary__total"><div class="summary__amount" data-out="total"><?= $o['total'] ?></div><div class="summary__range" data-out="range"><?= $o['range'] ?></div></div>
<?php if ($showScope): ?>
    <div class="breakdown" data-out="breakdown"><?= $o['breakdown'] ?></div>
<?php endif; ?>
    <ul class="summary__lines">
<?php if ($extras): ?>
      <li><span data-out="scope"><?= $o['scope'] ?></span> <b data-out="base"><?= $o['base'] ?></b></li>
      <li>Extras <b data-out="extras"><?= $o['extras'] ?></b></li>
      <li>Contingency <b data-out="contingency"><?= $o['contingency'] ?></b></li>
<?php endif; ?>
      <li class="is-total">Works out to <b data-out="persqft"><?= $o['persqft'] ?></b></li>
    </ul>
    <div class="summary__foot">
      <a class="btn btn--primary btn--block" href="<?= e(SITE['cta2']['href']) ?>" data-open-lead>Get exact quotes for this →</a>
<?php if ($compact && is_live('/calculators/home-interior-quote/')): ?>
      <a class="btn btn--outline btn--block" href="/calculators/home-interior-quote/">Build an itemised quote, room by room</a>
<?php endif; ?>
      <p class="summary__note">Indicative, including GST, rates as of <?= e(calc_rates()['as_of']) ?>. Excludes loose furniture and appliances. Quotes after a site measurement can differ by 10–15% either way.</p>
    </div>
  </aside>
</div>
