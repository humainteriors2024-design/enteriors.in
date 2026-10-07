<?php
/* MODULAR KITCHEN CALCULATOR — /calculators/modular-kitchen/
   Rates: includes/calc/rates.php → 'kitchen' (the same numbers feed the calculator, the rate
   tables on this page and the estimate attached to leads). Worked out on the server: calc_kitchen(). */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/calc/engine.php';
$K = calc_rates()['kitchen'];
$R = calc_kitchen([]);
$o = $R['out'];

$radios = function ($group, $name, $checked) use ($K) {
  $h = '';
  foreach ($K[$group] as $k => $v) {
    $fill = $group === 'layout' ? ' data-fill=\'{"base":' . $v[2] . ',"wall":' . $v[3] . '}\'' : '';
    $h .= '<label class="option"><input type="radio" name="' . $name . '" value="' . $k . '"' . ($k === $checked ? ' checked' : '') . $fill . '><span>' . e($v[0]) . (isset($v[2]) && is_string($v[2]) ? '<small>' . e($v[2]) . '</small>' : '') . '</span></label>';
  }
  return '<div class="options">' . $h . '</div>';
};
$checks = function ($group, $on = []) use ($K) {
  $h = '';
  foreach ($K[$group] as $k => $v) $h .= '<label class="option"><input type="checkbox" name="' . $group . '[]" value="' . $k . '"' . (in_array($k, $on) ? ' checked' : '') . '><span>' . e($v[0]) . '<small>+' . inr($v[1]) . '</small></span></label>';
  return '<div class="options">' . $h . '</div>';
};
$select = fn($group, $name, $sel) => '<select class="input" id="kc-' . $name . '" name="' . $name . '">' . implode('', array_map(fn($k, $v) => '<option value="' . $k . '"' . ($k === $sel ? ' selected' : '') . '>' . e($v[0]) . ($v[1] ? ' · ' . inr($v[1]) : '') . '</option>', array_keys($K[$group]), $K[$group])) . '</select>';

$page = [
  'type'        => 'tool',
  'pillar'      => 'modular-kitchen',
  'js'          => ['calc'],
  'title'       => 'Modular Kitchen Cost Calculator',
  'seo_title'   => 'Modular Kitchen Cost Calculator (Free, 2026)',
  'crumb'       => 'Modular Kitchen Calculator',
  'description' => 'Price a modular kitchen by running foot: choose layout, board, finish, hardware, countertop and accessories. Itemised estimate with GST for Bangalore and more.',
  'eyebrow'     => 'Free tool',
  'lede'        => 'Enter your cabinet lengths, choose materials and fittings, and get an itemised kitchen estimate that you can take to any designer.',
  'rates_as_of' => calc_rates()['as_of'],
  'published'   => '2026-10-03',
  'updated'     => '2026-10-04',
  'faq' => [
    'How is a modular kitchen priced in India?' => 'By the running foot (rft) of cabinet length. The base-unit rate depends on the board, finish and hardware; wall units, lofts, tall units, countertop and accessories are added on top, then installation and 18% GST.',
    'What is a running foot?' => 'One foot of cabinet length measured along the wall, whatever the cabinet depth. An L-shaped kitchen with 7 ft on one wall and 5 ft on the other has 12 rft of base units.',
    'How accurate is this calculator?' => 'It gives a planning figure, usually within 10% of an itemised quote for the same specification. Site conditions, exact module sizes and brand choices move the final number.',
    'Is a quartz countertop worth the extra cost?' => 'Quartz is non-porous, easy to clean and more uniform than granite, but it dislikes very hot pans placed directly on it. Granite costs less and handles heat better. Both last for decades with normal care.',
    'Which board is best for a kitchen in Bangalore?' => 'BWP plywood for the base units, especially the sink unit. BWR plywood or HDHMR works for wall units. Avoid MDF and particle board anywhere water can reach.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section">
  <div class="container">
    <div class="estimator" data-calc="kitchen">
      <form action="/calculators/modular-kitchen/" method="get">
        <fieldset class="est-step">
          <legend class="est-step__title"><span>1</span>Layout and size</legend>
          <p class="est-step__hint">Choose a layout to fill typical lengths, then change them to match your kitchen. Measure base units along the wall, including the corner.</p>
          <?= $radios('layout', 'layout', 'l') ?>
          <div class="fields mt-4">
            <div class="field"><label for="kc-base">Base units (rft)</label><input class="input" id="kc-base" name="base" type="number" min="0" max="60" step="0.5" value="<?= +$R['in']['base'] ?>"></div>
            <div class="field"><label for="kc-wall">Wall units (rft)</label><input class="input" id="kc-wall" name="wall" type="number" min="0" max="60" step="0.5" value="<?= +$R['in']['wall'] ?>"></div>
            <div class="field"><label for="kc-tall">Tall units (nos)</label><input class="input" id="kc-tall" name="tall" type="number" min="0" max="8" step="1" value="<?= +$R['in']['tall'] ?>"></div>
            <div class="field"><label for="kc-loft">Loft (rft)</label><input class="input" id="kc-loft" name="loft" type="number" min="0" max="60" step="0.5" value="0"></div>
            <div class="field"><label for="kc-city">City</label><select class="input" id="kc-city" name="city"><?php foreach (calc_rates()['cities'] as $c => $f) echo '<option>' . e($c) . '</option>'; ?></select></div>
          </div>
        </fieldset>

        <fieldset class="est-step">
          <legend class="est-step__title"><span>2</span>Board (carcass)</legend>
          <p class="est-step__hint">The box behind the doors. It decides how the kitchen copes with water.</p>
          <?= $radios('carcass', 'carcass', 'bwp') ?>
        </fieldset>

        <fieldset class="est-step">
          <legend class="est-step__title"><span>3</span>Shutter finish</legend>
          <p class="est-step__hint">The biggest visual choice, and the second-biggest cost lever after size.</p>
          <?= $radios('finish', 'finish', 'laminate') ?>
        </fieldset>

        <fieldset class="est-step">
          <legend class="est-step__title"><span>4</span>Hinges and channels</legend>
          <?= $radios('hardware', 'hardware', 'branded') ?>
        </fieldset>

        <fieldset class="est-step">
          <legend class="est-step__title"><span>5</span>Countertop, backsplash and appliances</legend>
          <div class="fields mt-4">
            <div class="field"><label for="kc-counter">Countertop</label><?= $select('counter', 'counter', 'granite') ?></div>
            <div class="field"><label for="kc-splash">Backsplash</label><?= $select('splash', 'splash', 'tile') ?></div>
            <div class="field"><label for="kc-sink">Sink</label><?= $select('sink', 'sink', 'ss1') ?></div>
            <div class="field"><label for="kc-chimney">Chimney</label><?= $select('chimney', 'chimney', 'none') ?></div>
            <div class="field"><label for="kc-hob">Hob</label><?= $select('hob', 'hob', 'none') ?></div>
          </div>
        </fieldset>

        <fieldset class="est-step">
          <legend class="est-step__title"><span>6</span>Storage accessories</legend>
          <?= $checks('acc', ['cutlery', 'cups', 'wicker', 'bin']) ?>
        </fieldset>

        <fieldset class="est-step">
          <legend class="est-step__title"><span>7</span>Site work</legend>
          <p class="est-step__hint">Only needed for renovations or when services move.</p>
          <?= $checks('site') ?>
        </fieldset>
      </form>

      <aside class="summary" aria-live="polite">
        <div class="summary__head"><strong>Kitchen estimate</strong><span data-out="meta"><?= $o['meta'] ?></span></div>
        <div class="summary__total"><div class="summary__amount" data-out="total"><?= $o['total'] ?></div><div class="summary__range" data-out="range"><?= $o['range'] ?></div></div>
        <ul class="summary__lines">
<?php foreach (['base' => 'Base units', 'wall' => 'Wall units and loft', 'tall' => 'Tall units', 'tops' => 'Countertop and backsplash', 'acc' => 'Accessories', 'appl' => 'Sink, hob and chimney', 'site' => 'Site work', 'install' => 'Installation and transport', 'gst' => 'GST (' . round(calc_rates()['gst'] * 100) . '%)'] as $k => $label): ?>
          <li><?= e($label) ?> <b data-out="<?= $k ?>"><?= $o[$k] ?></b></li>
<?php endforeach; ?>
          <li class="is-total">Total <b data-out="total2"><?= $o['total2'] ?></b></li>
        </ul>
        <ul class="summary__lines">
          <li>Same kitchen in laminate <b data-out="cmp-laminate"><?= $o['cmp-laminate'] ?></b></li>
          <li>Same kitchen in acrylic <b data-out="cmp-acrylic"><?= $o['cmp-acrylic'] ?></b></li>
          <li>Same kitchen in PU <b data-out="cmp-pu"><?= $o['cmp-pu'] ?></b></li>
        </ul>
        <div class="summary__foot">
          <a class="btn btn--primary btn--block" href="#get-quote" data-quote>Get quotes for this kitchen →</a>
          <p class="summary__note">Bengaluru base rates, <?= e($page['rates_as_of']) ?>. Real quotes vary after site measurement.</p>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section section--grey">
  <div class="container container--text prose">
    <h2>How the estimate is worked out</h2>
    <p>Every figure starts from the <strong>base-unit rate per running foot</strong> for the board you pick, with a laminate finish and branded standard fittings. Wall units cost about <?= round($K['wall_factor'] * 100) ?>% of that rate, lofts about <?= round($K['loft_factor'] * 100) ?>%, and each tall unit about <?= $K['tall_factor'] ?> running feet of base unit. The finish and hardware choices then scale the cabinet cost, and the layout adds a little for corner fittings and fillers.</p>
    <p>Countertop area is the base run multiplied by a 2 ft depth; backsplash is the same length at 2 ft high. Installation and transport add <?= round($K['install'] * 100) ?>% of the woodwork, tops and accessories. GST at <?= round(calc_rates()['gst'] * 100) ?>% is applied to the whole estimate, city factors last. The calculation runs on our server from one rate sheet, so the number you see is the number that reaches us with your enquiry.</p>

    <h3>Base-unit rates by board</h3>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Board</th><th class="num">₹ per rft</th><th>Note</th></tr></thead>
      <tbody>
<?php foreach ($K['carcass'] as $v): ?>
        <tr><td><?= e($v[0]) ?></td><td class="num"><?= inr($v[1]) ?></td><td><?= e($v[2]) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <p class="table-note">Laminate shutters, branded standard fittings, before GST.</p>

    <h3>Finish and hardware multipliers</h3>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Choice</th><th class="num">× cabinet cost</th><th>Note</th></tr></thead>
      <tbody>
<?php foreach (array_merge($K['finish'], $K['hardware']) as $v): ?>
        <tr><td><?= e($v[0]) ?></td><td class="num"><?= number_format($v[1], 2) ?></td><td><?= e($v[2]) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>

    <h3>Countertop rates</h3>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Material</th><th class="num">₹ per sq ft, fixed</th></tr></thead>
      <tbody>
<?php foreach ($K['counter'] as $v): ?>
        <tr><td><?= e($v[0]) ?></td><td class="num"><?= inr($v[1]) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>

    <h2>What the estimate leaves out</h2>
    <ul>
      <li>Built-in oven, microwave, dishwasher and refrigerator</li>
      <li>Structural changes such as moving walls or windows</li>
      <li>Flooring for the whole kitchen, unless you tick tiling</li>
      <li>Extra costs found at measurement, such as out-of-level walls</li>
    </ul>

    <h2>Getting a quote you can compare</h2>
    <p>Ask each firm for the same four numbers: base-unit rate per rft, wall-unit rate per rft, countertop rate per sq ft, and a list of accessories with brand and model. With those, quotes can be compared line by line instead of by the bottom figure. Our guide to <a href="/planning/how-to-choose-interior-designer/">choosing an interior designer</a> has the full question list, and the <a href="/cost/2-bhk-interior-cost/">2 BHK</a> and <a href="/cost/3-bhk-interior-cost/">3 BHK</a> cost guides show how the kitchen fits into a whole-home budget. For the whole flat, item by item, use the <a href="/calculators/home-interior-quote/">room-by-room quote builder</a>.</p>
    <p>Not sure about colours? See <a href="/blogs/kitchen-colour-combinations/">two-colour laminate combinations</a>, the <a href="/materials/acrylic-finish/">acrylic finish guide</a> or <a href="/modular-kitchen/hardware-guide/">kitchen hardware explained</a>.</p>
    <?= component('faq') ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
