<?php
/* INTERIOR COST CALCULATOR — itemised home interior quote — /calculators/home-interior-quote/
   Rebuilt Oct 2026 for easy use and like-for-like quote comparison:
     1. pick the home type (ticks the usual modules in its rooms)   2. pick a material package or each material
     3. adjust items and sizes room by room                        → line-by-line quote with a material spec sheet
   NO multipliers anywhere: every line is size × its own rate, and a woodwork rate is the sum of the chosen
   board, shutter core, finish and fittings rates plus the item's making rate. All rates and the arithmetic stay
   on the server (includes/calc/rates.php → 'quote', includes/calc/engine.php → calc_quote()); the page and
   assets/js/calc.js only send choices and show the answer. */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/calc/engine.php';
$Q = calc_rates()['quote'];
$R = calc_quote([]);
$o = $R['out'];
$pick = $R['in']['specs'];
$homeAreas = $Q['homes'][$Q['default_home']][1];
$optsOf = fn($k) => is_string($Q['specs'][$k]['options']) ? $Q['specs'][$Q['specs'][$k]['options']]['options'] : $Q['specs'][$k]['options'];
$kindTag = ['cabinet' => 'Cabinet', 'open' => 'Open unit', 'panel' => 'Panel', 'fitting' => 'Fitting', 'counter' => 'Countertop', 'ceiling' => 'Ceiling', 'rate' => 'Per sq ft', 'each' => 'Each'];

$page = [
  'type'        => 'tool',
  'pillar'      => 'cost',
  'js'          => ['calc'],
  'title'       => 'Interior Cost Calculator: Itemised Home Interior Quote',
  'seo_title'   => 'Interior Cost Calculator: Itemised Home Quote',
  'crumb'       => 'Interior Cost Calculator',
  'description' => 'Free interior cost calculator: choose your home, the board, finish and fittings, adjust each room, and get a line-by-line quote with GST to compare.',
  'eyebrow'     => 'Free tool · itemised · no signup',
  'lede'        => 'Three steps: choose your home, choose your materials, then fine-tune the rooms. You get a line-by-line quote and a material spec sheet in the same format designers use, so you can compare their quotes like for like.',
  'rates_as_of' => calc_rates()['as_of'],
  'published'   => '2026-10-04',
  'updated'     => '2026-10-14',
  'faq' => [
    'How is each line priced?' => 'Cabinets and wardrobes are priced per square foot of their front (length × height). Their rate is the sum of the box board, the shutter core, the shutter finish and the fittings you choose, plus factory making and installation. Fittings, accessories and services have their own fixed prices, and the countertop and false ceiling are priced per square foot of the option you pick. Nothing is scaled by a hidden factor.',
    'Why does the board in wet areas have its own setting?' => 'Kitchen sink and hob units and bathroom vanities sit next to water every day. They should use BWP (boiling-water-proof, IS:710) plywood whatever you choose for the rest of the home, so the calculator prices those units with the wet-area board.',
    'Does the estimate include GST?' => 'Yes. 18% GST is added to the total of everything you have ticked.',
    'How close will a real quote be?' => 'For the same items, sizes and materials, usually within 10–15%. Site conditions, the exact module sizes after measurement and the specific brands chosen account for most of the difference.',
    'How do I use this to compare designer quotes?' => 'Print the quote with its spec sheet and give the same list to every firm. Ask them to quote each line with the board, shutter, finish and fitting brand named. Lines that differ a lot from your estimate are the ones to question.',
    'Which city are the rates for?' => 'Bengaluru trade rates, updated every quarter. Other large cities are usually within about 10% for the same specification; compare with local quotes.',
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section">
  <div class="container">
    <div class="estimator" data-calc="quote">
      <form action="/calculators/home-interior-quote/" method="get">
        <fieldset class="est-step">
          <legend class="est-step__title"><span>1</span>Your home</legend>
          <p class="est-step__hint">Pick the home type: its usual modules are ticked for you. You can change any item in step 3.</p>
          <div class="q-choices" role="radiogroup" aria-label="Home type">
<?php foreach ($Q['homes'] as $k => [$label, $areas]): ?>
            <label class="q-choice"><input type="radio" name="home" value="<?= e($k) ?>" data-preset="<?= e(implode(',', $areas)) ?>"<?= $k === $Q['default_home'] ? ' checked' : '' ?>><span><?= e($label) ?></span></label>
<?php endforeach; ?>
          </div>
        </fieldset>

        <fieldset class="est-step">
          <legend class="est-step__title"><span>2</span>Your materials</legend>
          <p class="est-step__hint">Start from a package, then change any material. The quote and the spec sheet update as you go.</p>
          <div class="q-choices q-choices--packages" role="radiogroup" aria-label="Material package">
<?php foreach ($Q['packages'] as $k => [$label, $text, $fill]): ?>
            <label class="q-choice q-choice--card"><input type="radio" name="package" value="<?= e($k) ?>" data-fill='<?= e(json_encode($fill)) ?>'<?= $k === $Q['default_package'] ? ' checked' : '' ?>><span><b><?= e($label) ?></b><small><?= e($text) ?></small></span></label>
<?php endforeach; ?>
          </div>
          <div class="fields q-specs mt-4">
<?php foreach ($Q['specs'] as $k => $spec): ?>
            <div class="field"><label for="q-<?= e($k) ?>"><?= e($spec['label']) ?></label>
              <select class="input" id="q-<?= e($k) ?>" name="<?= e($k) ?>" data-spec><?php foreach ($optsOf($k) as $ok => $opt) echo '<option value="' . e($ok) . '"' . ($ok === $pick[$k] ? ' selected' : '') . '>' . e($opt[0]) . '</option>'; ?></select></div>
<?php endforeach; ?>
          </div>
        </fieldset>

        <fieldset class="est-step q-rooms">
          <legend class="est-step__title"><span>3</span>Rooms and items</legend>
          <p class="est-step__hint">Open a room, tick what you need and set sizes in feet. Lines you untick stay visible in grey and are not counted.</p>
          <a class="q-bar" href="#q-summary"><span>Total incl. GST</span> <b data-out="total2"><?= $o['total2'] ?></b> <small data-out="count"><?= $o['count'] ?></small></a>
          <div class="q-tools">
            <button class="btn btn--outline btn--sm" type="button" data-expand="open">Open all rooms</button>
            <button class="btn btn--outline btn--sm" type="button" data-expand="close">Close all</button>
            <button class="btn btn--outline btn--sm" type="button" data-print>Print or save as PDF</button>
          </div>

<?php $first = true; foreach ($Q['areas'] as $aid => $area): $inHome = in_array($aid, $homeAreas, true); ?>
          <details class="q-area" data-area="<?= e($aid) ?>"<?= $first ? ' open' : '' ?>>
            <summary>
              <span class="q-area__icon" aria-hidden="true"><?= $area['icon'] ?></span>
              <span class="q-area__name"><?= e($area['name']) ?><small data-out="cnt-<?= $aid ?>"><?= $o["cnt-$aid"] ?></small></span>
              <span class="q-area__total" data-out="area-<?= $aid ?>"><?= $o["area-$aid"] ?></span>
            </summary>
            <table class="q-table">
              <thead><tr><th><span class="visually-hidden">Include</span></th><th>Module or item</th><th class="num">L (ft)</th><th class="num">H (ft)</th><th class="num">Qty</th><th class="num">Size</th><th class="num">Rate</th><th class="num">Amount</th></tr></thead>
              <tbody>
<?php $group = null; foreach ($area['items'] as $id => [$name, $desc, $kind, $L, $H, $qty, , $on, $addon]):
        if ($group !== $addon) { $group = $addon; echo '                <tr class="q-group"><td colspan="8">' . ($addon ? 'Add-ons and accessories' : 'Main modules') . "</td></tr>\n"; }
        $perSqft = !in_array($kind, ['each', 'fitting'], true); $twoD = in_array($kind, ['cabinet', 'open', 'panel', 'rate'], true); ?>
                <tr class="q-row">
                  <td><input type="checkbox" name="on[<?= $id ?>]" value="1" id="q-<?= $id ?>" data-default="<?= (int) $on ?>" aria-label="Include <?= e($name) ?>"<?= $on && $inHome ? ' checked' : '' ?>></td>
                  <td><label for="q-<?= $id ?>" class="q-item__name"><?= e($name) ?></label><span class="q-tag"><?= e($kindTag[$kind] ?? '') ?></span><span class="q-item__desc"><?= e($desc) ?></span><span class="q-spec" data-out="spec-<?= $id ?>"><?= $o["spec-$id"] ?></span></td>
<?php if ($twoD): ?>
                  <td class="num" data-label="L (ft)"><input class="input" type="number" name="L[<?= $id ?>]" value="<?= +$L ?>" min="0" max="40" step="0.25" inputmode="decimal" aria-label="<?= e($name) ?> length in feet"></td>
                  <td class="num" data-label="H (ft)"><input class="input" type="number" name="H[<?= $id ?>]" value="<?= +$H ?>" min="0" max="40" step="0.25" inputmode="decimal" aria-label="<?= e($name) ?> height in feet"></td>
<?php else: ?>
                  <td class="num q-dash" data-label="L (ft)">—</td><td class="num q-dash" data-label="H (ft)">—</td>
<?php endif; ?>
                  <td class="num" data-label="<?= $twoD || !$perSqft ? 'Qty' : 'Sq ft' ?>"><input class="input" type="number" name="qty[<?= $id ?>]" value="<?= +$qty ?>" min="0" max="2000" step="1" inputmode="numeric" aria-label="<?= e($name) ?> <?= $twoD || !$perSqft ? 'quantity' : 'area in sq ft' ?>"></td>
                  <td class="num" data-label="Size" data-out="sz-<?= $id ?>"><?= $o["sz-$id"] ?></td>
                  <td class="num" data-label="Rate" data-out="rate-<?= $id ?>"><?= $o["rate-$id"] ?></td>
                  <td class="num q-amt" data-label="Amount" data-out="amt-<?= $id ?>"><?= $o["amt-$id"] ?></td>
                </tr>
<?php endforeach; ?>
              </tbody>
            </table>
          </details>
<?php $first = false; endforeach; ?>
        </fieldset>
      </form>

      <aside class="summary" id="q-summary" aria-live="polite">
        <div class="summary__head"><strong>Your interior quote</strong><span data-out="meta"><?= $o['meta'] ?></span></div>
        <div class="summary__total"><div class="summary__amount" data-out="total2"><?= $o['total2'] ?></div><div class="summary__range" data-out="count"><?= $o['count'] ?></div></div>
        <ul class="summary__lines summary__rooms" data-out="room-lines"><?= $o['room-lines'] ?></ul>
        <ul class="summary__lines">
          <li>Woodwork <b data-out="wood"><?= $o['wood'] ?></b></li>
          <li>Fittings, countertop, ceiling and services <b data-out="other"><?= $o['other'] ?></b></li>
          <li>GST (<?= round(calc_rates()['gst'] * 100) ?>%) <b data-out="gst"><?= $o['gst'] ?></b></li>
          <li class="is-total">Grand total <b data-out="total"><?= $o['total'] ?></b></li>
          <li>Woodwork area <b data-out="sqft"><?= $o['sqft'] ?></b></li>
          <li>Average woodwork rate <b data-out="avg"><?= $o['avg'] ?></b></li>
        </ul>
        <div class="q-sheet">
          <p class="q-sheet__title">Spec sheet: ask every designer to quote this</p>
          <ul data-out="sheet"><?= $o['sheet'] ?></ul>
          <p class="q-sheet__war"><span>Board warranty:</span> <span data-out="warranty"><?= $o['warranty'] ?></span></p>
        </div>
        <div class="summary__foot">
          <a class="btn btn--primary btn--block" href="#get-quote" data-quote>Get designer quotes for this list →</a>
          <button class="btn btn--outline btn--block" type="button" data-print>Print or save as PDF</button>
          <a class="btn btn--outline btn--block" href="/calculators/interior-cost/">Quick estimate by sq ft instead</a>
          <p class="summary__note">Bengaluru rates, <?= e(calc_rates()['as_of']) ?>. Excludes civil work, flooring, painting, electrical rewiring, appliances and loose furniture unless listed. Real quotes can differ by 10–15% after measurement.</p>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section section--grey">
  <div class="container container--text prose">
    <h2>How this interior cost calculator works</h2>
    <p>It prices your home the way an itemised designer quotation does, one line at a time, and it never scales your total by a grade or city factor.</p>
    <ul>
      <li><strong>Cabinets and wardrobes</strong> are priced per square foot of their front (length × height). The rate adds up the box board, the shutter core, the finish and the fittings you picked, plus factory making, edge banding, transport and installation.</li>
      <li><strong>Wet areas</strong> such as the kitchen sink and hob units and bathroom vanities use the wet-area board you choose, normally BWP plywood.</li>
      <li><strong>Fittings</strong> such as tandem drawers, corner units and pull-outs have a price for each fittings range.</li>
      <li><strong>Countertops and false ceilings</strong> are priced per square foot of the option you pick; services such as deep cleaning are fixed prices.</li>
      <li><strong>GST at 18%</strong> is added to the total.</li>
    </ul>
    <p>All the arithmetic runs on our server from one rate sheet, so the estimate attached to your enquiry is exactly the one you saw.</p>

    <h2>Material guide: what each choice means</h2>
    <p>Use these names when you brief a designer. A quotation that does not name the board, shutter, finish and fitting brand cannot be compared with another one.</p>
<?php foreach (['carcass', 'shutter', 'finish', 'hardware', 'counter', 'ceiling'] as $k): ?>
    <h3><?= e($Q['specs'][$k]['label']) ?></h3>
    <div class="table-wrap">
    <table>
      <thead><tr><th>Option</th><th>What it is</th><th>Where it suits / what to check</th></tr></thead>
      <tbody>
<?php foreach ($optsOf($k) as [$name, , $what, $suits]): ?>
        <tr><td><?= e($name) ?></td><td><?= e($what) ?></td><td><?= e($suits) ?></td></tr>
<?php endforeach; ?>
      </tbody>
    </table>
    </div>
<?php endforeach; ?>

    <h2>How to compare designer quotes with this list</h2>
    <ol>
      <li><strong>Send the same list to every firm.</strong> Print this page (or save it as a PDF) and ask for a quote on the same items, sizes and spec sheet.</li>
      <li><strong>Check the names, not just the totals.</strong> Board grade and IS standard (IS:303 or IS:710), shutter core, laminate or acrylic thickness and brand, and the hinge and channel range.</li>
      <li><strong>Compare line by line.</strong> A total that looks cheap often leaves out lofts, countertops, fittings or the false ceiling.</li>
      <li><strong>Read the exclusions.</strong> Electrical work, painting, civil changes, transport and debris removal are often outside the price.</li>
      <li><strong>Get warranties in writing.</strong> The board maker's warranty and the firm's own workmanship warranty are different things.</li>
    </ol>
    <?= component('partner') ?>
    <p>Our guides to <a href="/materials/plywood-guide/">plywood grades</a>, <a href="/compare/acrylic-vs-laminate/">acrylic vs laminate</a>, <a href="/modular-kitchen/hardware-guide/">kitchen hardware</a> and <a href="/planning/how-to-choose-interior-designer/">choosing an interior designer</a> explain what each choice changes. For a single room, the <a href="/calculators/modular-kitchen/">kitchen calculator</a> and <a href="/calculators/wardrobe-cost/">wardrobe calculator</a> go into more detail.</p>
    <?= component('faq') ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
