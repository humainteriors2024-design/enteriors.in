<?php
/* ROOM-BY-ROOM QUOTE BUILDER — /calculators/home-interior-quote/
   The itemised calculator: 10 rooms, 91 items, material grade, fittings, city and design fee.
   Items and rates: includes/calc/rates.php → 'quote'. Worked out on the server: calc_quote().
   Every number on the page is printed by PHP first, then kept up to date by assets/js/calc.js. */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/calc/engine.php';
$Q = calc_rates()['quote'];
$R = calc_quote([]);
$o = $R['out'];
$opt = fn($set, $def, $withMult = false) => implode('', array_map(fn($k, $v) => '<option value="' . $k . '"' . ($k === $def ? ' selected' : '') . '>' . e($v[0]) . ($withMult ? ' · ' . number_format($v[1], 2) . '×' : '') . '</option>', array_keys($set), $set));
$matOpt = fn($set, $def) => implode('', array_map(fn($k, $v) => '<option value="' . $k . '"' . ($k === $def ? ' selected' : '') . '>' . e($v[0]) . ' · ₹' . round($v[1]) . '/sq ft</option>', array_keys($set), $set));
[$refC, $refF, $refS] = $Q['materials']['reference'];

$page = [
  'type'        => 'tool',
  'pillar'      => 'cost',
  'js'          => ['calc'],
  'title'       => 'Home Interior Quote Builder: Room by Room',
  'seo_title'   => 'Home Interior Cost Calculator, Item by Item (2026)',
  'crumb'       => 'Room-by-Room Quote',
  'description' => 'Build an itemised interior quote: pick rooms, modules and accessories, enter sizes, choose material grade and fittings, and see every line priced with GST.',
  'eyebrow'     => 'Free tool · itemised',
  'lede'        => 'Tick the modules you need in each room, adjust the sizes to your walls, and get a line-by-line estimate in the same format a designer’s quote uses.',
  'rates_as_of' => calc_rates()['as_of'],
  'published'   => '2026-10-04',
  'updated'     => '2026-10-04',
  'faq' => [
    'How is the price of each item worked out?' => 'Woodwork is priced per square foot of the unit’s front (length × height), cabinets and lofts at their own base rate. The material grade changes the woodwork rate, the fitting range changes hardware-heavy items most, and the city factor applies to everything. Accessories and services are priced per piece.',
    'What does "choose my own materials" do?' => 'Instead of a ready-made grade, you pick the carcass board, the finish and the shutter core. The calculator compares their combined rate per square foot with our Standard reference (branded MR ply, matt laminate, branded 16 mm ply shutters) and scales the woodwork accordingly.',
    'Does the estimate include GST?' => 'Yes. The design fee, if you add one, is added to the woodwork first, and 18% GST is applied to the total.',
    'How close will a real quote be?' => 'For the same items, sizes and materials, within about 10–15%. Site conditions, exact module sizes after measurement and the specific brands chosen account for most of the difference.',
    'Can I save or share my estimate?' => 'Use "Print or save as PDF" to keep a copy with every selected item. If you request a quote from this page, the estimate is attached to your enquiry automatically, so the designer starts from the same list.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section">
  <div class="container">
    <div class="estimator" data-calc="quote">
      <form action="/calculators/home-interior-quote/" method="get">
        <fieldset class="est-step q-settings">
          <legend class="est-step__title"><span>1</span>Grade, fittings and city</legend>
          <div class="fields mt-4">
            <div class="field"><label for="q-grade">Material grade</label>
              <select class="input" id="q-grade" name="grade"><?= $opt($Q['grades'], 'standard', true) ?><option value="custom">Choose my own materials…</option></select></div>
            <div class="field"><label for="q-hardware">Fittings range</label><select class="input" id="q-hardware" name="hardware"><?= $opt($Q['hardware'], 'standard', true) ?></select></div>
            <div class="field"><label for="q-city">City</label><select class="input" id="q-city" name="city"><?php foreach (calc_rates()['cities'] as $c => $f) echo '<option>' . e($c) . '</option>'; ?></select></div>
            <div class="field"><label for="q-fee">Design fee <output data-out="fee-pct"><?= $o['fee-pct'] ?></output></label><input class="range" id="q-fee" name="fee" type="range" min="<?= $Q['design_fee'][0] ?>" max="<?= $Q['design_fee'][1] ?>" step="1" value="<?= $Q['design_fee'][2] ?>"></div>
          </div>
          <div class="q-materials fields">
            <div class="field"><label for="q-carcass">Carcass board</label><select class="input" id="q-carcass" name="carcass"><?= $matOpt($Q['materials']['carcass'], $refC) ?></select></div>
            <div class="field"><label for="q-finish">Finish</label><select class="input" id="q-finish" name="finish"><?= $matOpt($Q['materials']['finish'], $refF) ?></select></div>
            <div class="field"><label for="q-shutter">Shutter core</label><select class="input" id="q-shutter" name="shutter"><?= $matOpt($Q['materials']['shutter'], $refS) ?></select></div>
          </div>
          <p class="q-note"><strong>Grade:</strong> <span data-out="grade-note"><?= $o['grade-note'] ?></span><br><strong>Fittings:</strong> <span data-out="hw-note"><?= $o['hw-note'] ?></span></p>
        </fieldset>

        <a class="q-bar" href="#q-summary"><span>Total incl. GST</span> <b data-out="total2"><?= $o['total2'] ?></b> <small data-out="count"><?= $o['count'] ?></small></a>
        <div class="q-tools">
          <button class="btn btn--outline btn--sm" type="button" data-expand="open">Open all rooms</button>
          <button class="btn btn--outline btn--sm" type="button" data-expand="close">Close all</button>
          <button class="btn btn--outline btn--sm" type="button" data-print>Print or save as PDF</button>
        </div>

<?php $first = true; foreach ($Q['areas'] as $aid => $area): ?>
        <details class="q-area"<?= $first ? ' open' : '' ?>>
          <summary>
            <span class="q-area__icon" aria-hidden="true"><?= $area['icon'] ?></span>
            <span class="q-area__name"><?= e($area['name']) ?><small data-out="cnt-<?= $aid ?>"><?= $o["cnt-$aid"] ?></small></span>
            <span class="q-area__total" data-out="area-<?= $aid ?>"><?= $o["area-$aid"] ?></span>
          </summary>
          <table class="q-table">
            <thead><tr><th><span class="visually-hidden">Include</span></th><th>Module or item</th><th class="num">L (ft)</th><th class="num">H (ft)</th><th class="num">Qty</th><th class="num">Size</th><th class="num">Rate</th><th class="num">Amount</th></tr></thead>
            <tbody>
<?php $group = null; foreach ($area['items'] as $id => [$name, $desc, $unit, $L, $H, $qty, $rate, $gw, $hw, $on, $addon]):
        if ($group !== $addon) { $group = $addon; echo '              <tr class="q-group"><td colspan="8">' . ($addon ? 'Add-ons and accessories' : 'Main modules') . "</td></tr>\n"; }
        $kind = $unit === 'sqft' ? 'SQ FT' : 'EACH';
        $tag = ($gw == 0 && $hw == 1) ? 'Fitting' : (($gw == 0 && $hw == 0) ? 'Service' : 'Woodwork'); ?>
              <tr class="q-row">
                <td><input type="checkbox" name="on[<?= $id ?>]" value="1" id="q-<?= $id ?>" aria-label="Include <?= e($name) ?>"<?= $on ? ' checked' : '' ?>></td>
                <td><label for="q-<?= $id ?>" class="q-item__name"><?= e($name) ?></label><span class="q-tag"><?= $tag ?> · <?= $kind ?></span><span class="q-item__desc"><?= e($desc) ?></span></td>
<?php if ($unit === 'sqft'): ?>
                <td class="num" data-label="L (ft)"><input class="input" type="number" name="L[<?= $id ?>]" value="<?= +$L ?>" min="0" max="40" step="0.25" aria-label="<?= e($name) ?> length in feet"></td>
                <td class="num" data-label="H (ft)"><input class="input" type="number" name="H[<?= $id ?>]" value="<?= +$H ?>" min="0" max="40" step="0.25" aria-label="<?= e($name) ?> height in feet"></td>
<?php else: ?>
                <td class="num q-dash" data-label="L (ft)">—</td><td class="num q-dash" data-label="H (ft)">—</td>
<?php endif; ?>
                <td class="num" data-label="Qty"><input class="input" type="number" name="qty[<?= $id ?>]" value="<?= +$qty ?>" min="0" max="2000" step="1" aria-label="<?= e($name) ?> quantity"></td>
                <td class="num" data-label="Size" data-out="sz-<?= $id ?>"><?= $o["sz-$id"] ?></td>
                <td class="num" data-label="Rate" data-out="rate-<?= $id ?>"><?= $o["rate-$id"] ?></td>
                <td class="num q-amt" data-label="Amount" data-out="amt-<?= $id ?>"><?= $o["amt-$id"] ?></td>
              </tr>
<?php endforeach; ?>
            </tbody>
          </table>
        </details>
<?php $first = false; endforeach; ?>
      </form>

      <aside class="summary" id="q-summary" aria-live="polite">
        <div class="summary__head"><strong>Your itemised quote</strong><span data-out="meta"><?= $o['meta'] ?></span></div>
        <div class="summary__total"><div class="summary__amount" data-out="total2"><?= $o['total2'] ?></div><div class="summary__range" data-out="count"><?= $o['count'] ?></div></div>
        <ul class="summary__lines">
          <li>Woodwork and items <b data-out="subtotal"><?= $o['subtotal'] ?></b></li>
          <li>Design fee (<span data-out="fee-pct"><?= $o['fee-pct'] ?></span>) <b data-out="fee"><?= $o['fee'] ?></b></li>
          <li>Taxable value <b data-out="taxable"><?= $o['taxable'] ?></b></li>
          <li>GST (<?= round(calc_rates()['gst'] * 100) ?>%) <b data-out="gst"><?= $o['gst'] ?></b></li>
          <li class="is-total">Grand total <b data-out="total"><?= $o['total'] ?></b></li>
          <li>Woodwork area <b data-out="sqft"><?= $o['sqft'] ?></b></li>
        </ul>
        <div class="summary__foot">
          <a class="btn btn--primary btn--block" href="#get-quote" data-quote>Get designer quotes for this list →</a>
          <a class="btn btn--outline btn--block" href="/calculators/interior-cost/">Quick estimate by sq ft instead</a>
          <p class="summary__note">Rates as of <?= e(calc_rates()['as_of']) ?>, Bengaluru base. Excludes civil work, flooring, painting, electrical rewiring, appliances and loose furniture unless listed. Real quotes can differ by 10–15% after measurement.</p>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section section--grey">
  <div class="container container--text prose">
    <h2>How this quote builder works</h2>
    <p>Each module is priced the way Indian interior firms price it: <strong>by the square foot of its front</strong> (length × height), at a base rate for a Standard grade with branded fittings in Bengaluru. Three settings then adjust every line:</p>
    <ul>
      <li><strong>Material grade</strong> scales the woodwork, from Basic (<?= number_format($Q['grades']['basic'][1], 2) ?>×) to Luxury (<?= number_format($Q['grades']['luxury'][1], 2) ?>×). It does not change fittings or services.</li>
      <li><strong>Fittings range</strong> applies fully to hardware accessories (pull-outs, baskets, drawers) and about a third to woodwork, where hinges and channels are part of the price.</li>
      <li><strong>City</strong> adjusts everything for local labour and logistics.</li>
    </ul>
    <p>All the arithmetic runs on our server from one rate sheet. The same sheet prints the tables on our cost guides, so the site never gives two different answers, and the estimate attached to your enquiry is exactly the one you saw.</p>

    <h2>Grades at a glance</h2>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Grade</th><th class="num">× woodwork</th><th>Warranty</th><th>What you get</th></tr></thead>
      <tbody>
<?php foreach ($Q['grades'] as [$label, $mult, $war, $note]): ?>
        <tr><td><?= e($label) ?></td><td class="num"><?= number_format($mult, 2) ?></td><td><?= e($war) ?></td><td><?= e($note) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>

    <h2>Material rates used for "choose my own materials"</h2>
    <p>From our workbook of current trade rates, per square foot of finished unit. The reference set for Standard grade is <?= e($Q['materials']['carcass'][$refC][0]) ?>, <?= e(strtolower($Q['materials']['finish'][$refF][0])) ?> and <?= e($Q['materials']['shutter'][$refS][0]) ?> shutters.</p>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Part</th><th>Option</th><th class="num">₹ per sq ft</th></tr></thead>
      <tbody>
<?php foreach (['carcass' => 'Carcass', 'finish' => 'Finish', 'shutter' => 'Shutter core'] as $part => $label) foreach ($Q['materials'][$part] as [$name, $rate]): ?>
        <tr><td><?= $label ?></td><td><?= e($name) ?></td><td class="num">₹<?= number_format($rate, 2) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>

    <h2>Before you take this to a designer</h2>
    <p>Bring the printed list and ask each firm to quote the same items, sizes, board, finish and fitting brand. Then compare line by line. Our guides to <a href="/materials/plywood-guide/">plywood grades</a>, <a href="/compare/acrylic-vs-laminate/">acrylic vs laminate</a>, <a href="/modular-kitchen/hardware-guide/">kitchen hardware</a> and <a href="/planning/how-to-choose-interior-designer/">choosing an interior designer</a> explain what each choice changes. For a single room, the <a href="/calculators/modular-kitchen/">kitchen calculator</a> and <a href="/calculators/wardrobe-cost/">wardrobe calculator</a> go into more detail.</p>
    <?= component('faq') ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
