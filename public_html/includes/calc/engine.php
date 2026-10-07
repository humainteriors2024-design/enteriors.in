<?php
/* =====================================================================
   ENTERIORS — CALCULATOR ENGINE (server side). No need to edit: prices are in rates.php.

   One function per calculator. Each takes the visitor's choices (a form post),
   cleans them (unknown options fall back to defaults, numbers are clamped to
   sensible limits) and returns:
     'in'      the cleaned choices
     'total'   the grand total in ₹ (number)
     'out'     ready-to-show text for every [data-out="…"] box on the page
     'summary' one line used in lead notes, emails and the calculator log

   Used by: api/calculate.php (live updates while the visitor types) and by the
   calculator components, which print the first result into the HTML so the page
   shows real numbers before any JavaScript runs (fast, and visible to Google).
   ===================================================================== */

function calc_rates() { static $r = null; return $r ??= require __DIR__ . '/rates.php'; }

/* ---------- formatting ---------- */
function inr_digits($n) {   // 1234567 → 12,34,567 (Indian grouping)
  $n = (string) (int) round(abs($n));
  if (strlen($n) <= 3) return $n;
  $last = substr($n, -3); $rest = substr($n, 0, -3);
  return preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest) . ',' . $last;
}
function inr($n) { return ($n < 0 ? '−' : '') . '₹' . inr_digits($n); }
function lakh($n) {
  if ($n >= 1e7) return '₹' . rtrim(rtrim(number_format($n / 1e7, 2), '0'), '.') . ' Cr';
  if ($n >= 1e5) return '₹' . rtrim(rtrim(number_format($n / 1e5, $n >= 1e6 ? 1 : 2), '0'), '.') . 'L';
  return inr($n);
}

/* ---------- input cleaning ---------- */
function calc_num($v, $min, $max, $def) { return is_numeric($v) ? max($min, min($max, (float) $v)) : $def; }
function calc_pick($v, $set, $def) { return is_scalar($v) && array_key_exists((string) $v, $set) ? (string) $v : $def; }
function calc_many($v, $set) { return array_values(array_intersect(array_map('strval', (array) $v), array_keys($set))); }
function calc_city($v) { $c = calc_rates()['cities']; $k = calc_pick($v, $c, 'Bangalore'); return [$k, $c[$k]]; }

/* =====================================================================
   1. WHOLE-HOME ESTIMATE — ₹/sq ft × carpet area × scope × city, + extras + contingency
   ===================================================================== */
function calc_home($in) {
  $H = calc_rates()['home'];
  $home  = calc_pick($in['home'] ?? '', $H['sizes'], '2 BHK');
  $area  = calc_num($in['area'] ?? null, 250, 8000, $H['sizes'][$home]);
  $pkg   = calc_pick($in['pkg'] ?? '', $H['per_sqft'], 'standard');
  $scopeKey = calc_pick($in['scope'] ?? '', $H['scope'], 'full');
  [$city, $cf] = calc_city($in['city'] ?? '');
  $addons = calc_many($in['addon'] ?? [], $H['addons']);
  $buf   = calc_num($in['buffer'] ?? 0, 0, 25, 0) / 100;
  $scope = $H['scope'][$scopeKey];

  $full   = $area * $H['per_sqft'][$pkg] * $cf;
  $base   = $full * $scope[0];
  $extras = array_sum(array_map(fn($a) => $H['addons'][$a][2] * $cf, $addons));
  $cont   = ($base + $extras) * $buf;
  $total  = $base + $extras + $cont;

  $rows = [];
  foreach ($H['split'] as [$label, $pct, $core]) if ($scopeKey !== 'core' || $core) $rows[] = [$label, $full * $pct / 100];
  if ($scopeKey === 'plus') $rows[] = [$H['plus_label'], $full * ($scope[0] - 1)];
  $max = max(array_column($rows, 1)) ?: 1;
  $bars = implode('', array_map(fn($r) => '<div class="breakdown__row"><span>' . e($r[0]) . '</span><span class="bars__track"><span class="bars__fill" style="--w:' . round($r[1] / $max * 100) . '%"></span></span><b>' . lakh($r[1]) . '</b></div>', $rows));

  $meta = number_format($area) . ' sq ft · ' . $H['grades'][$pkg][0] . ' · ' . $city;
  return [
    'in' => compact('home', 'area', 'pkg', 'city', 'addons') + ['scope' => $scopeKey, 'buffer' => $buf * 100],
    'total' => round($total),
    'out' => [
      'area' => number_format($area) . ' sq ft', 'buffer' => round($buf * 100) . '%', 'meta' => e($meta), 'scope' => e($scope[1]),
      'base' => lakh($base), 'extras' => lakh($extras), 'contingency' => lakh($cont), 'total' => lakh($total), 'total2' => lakh($total),
      'persqft' => inr($total / $area) . ' per sq ft', 'range' => 'Likely range ' . lakh($total * (1 - $H['spread'])) . ' – ' . lakh($total * (1 + $H['spread'])),
      'breakdown' => $bars,
    ],
    'summary' => 'Home estimate ' . lakh($total) . " ($meta, " . strtolower($scope[1]) . ($addons ? ', + ' . implode(', ', array_map(fn($a) => strtolower($H['addons'][$a][0]), $addons)) : '') . ($buf ? ', ' . round($buf * 100) . '% buffer' : '') . ')',
  ];
}

/* =====================================================================
   2. MODULAR KITCHEN — running feet × board rate × finish × hardware × layout, + tops,
      accessories, appliances, site work, installation, GST, city
   ===================================================================== */
function calc_kitchen($in, $finishOverride = null) {
  $K = calc_rates()['kitchen']; $gst = calc_rates()['gst'];
  $layout  = calc_pick($in['layout'] ?? '', $K['layout'], 'l');
  $carcass = calc_pick($in['carcass'] ?? '', $K['carcass'], 'bwp');
  $finish  = $finishOverride ?? calc_pick($in['finish'] ?? '', $K['finish'], 'laminate');
  $hw      = calc_pick($in['hardware'] ?? '', $K['hardware'], 'branded');
  $counter = calc_pick($in['counter'] ?? '', $K['counter'], 'granite');
  $splash  = calc_pick($in['splash'] ?? '', $K['splash'], 'tile');
  $sink    = calc_pick($in['sink'] ?? '', $K['sink'], 'ss1');
  $chimney = calc_pick($in['chimney'] ?? '', $K['chimney'], 'none');
  $hob     = calc_pick($in['hob'] ?? '', $K['hob'], 'none');
  $acc     = calc_many($in['acc'] ?? ($in['sent'] ?? false ? [] : ['cutlery', 'cups', 'wicker', 'bin']), $K['acc']);
  $site    = calc_many($in['site'] ?? [], $K['site']);
  $baseRft = calc_num($in['base'] ?? null, 0, 60, $K['layout'][$layout][2]);
  $wallRft = calc_num($in['wall'] ?? null, 0, 60, $K['layout'][$layout][3]);
  $tallN   = calc_num($in['tall'] ?? null, 0, 8, 1);
  $loftRft = calc_num($in['loft'] ?? null, 0, 60, 0);
  [$city, $cf] = calc_city($in['city'] ?? '');

  $rate = $K['carcass'][$carcass][1];
  $mult = $K['finish'][$finish][1] * $K['hardware'][$hw][1] * $K['layout'][$layout][1];
  $L = [
    'base' => $baseRft * $rate * $mult,
    'wall' => ($wallRft * $K['wall_factor'] + $loftRft * $K['loft_factor']) * $rate * $mult,
    'tall' => $tallN * $K['tall_factor'] * $rate * $mult,
    'tops' => $baseRft * 2 * ($K['counter'][$counter][1] + $K['splash'][$splash][1]),
    'acc'  => array_sum(array_map(fn($a) => $K['acc'][$a][1], $acc)),
    'appl' => $K['sink'][$sink][1] + $K['chimney'][$chimney][1] + $K['hob'][$hob][1],
    'site' => array_sum(array_map(fn($a) => $K['site'][$a][1], $site)),
  ];
  $L['install'] = ($L['base'] + $L['wall'] + $L['tall'] + $L['tops'] + $L['acc']) * $K['install'];
  foreach ($L as $k => $v) $L[$k] = $v * $cf;
  $sub = array_sum($L);
  $L['gst'] = $sub * $gst;
  $total = $sub + $L['gst'];
  if ($finishOverride) return $total;

  $meta = $K['layout'][$layout][0] . ' · ' . (+$baseRft) . ' rft base · ' . $city;
  $out = array_map('inr', $L) + [
    'total' => lakh($total), 'total2' => inr($total), 'meta' => e($meta),
    'range' => 'Likely range ' . lakh($total * (1 - $K['spread'])) . ' – ' . lakh($total * (1 + $K['spread'])),
  ];
  foreach (['laminate', 'acrylic', 'pu'] as $f) $out["cmp-$f"] = lakh(calc_kitchen($in, $f));
  return [
    'in' => compact('layout', 'carcass', 'finish', 'counter', 'city') + ['hardware' => $hw, 'base' => $baseRft, 'wall' => $wallRft, 'tall' => $tallN, 'loft' => $loftRft],
    'total' => round($total), 'out' => $out,
    'summary' => 'Kitchen estimate ' . lakh($total) . ' (' . $K['layout'][$layout][0] . ", $baseRft rft base + $wallRft rft wall, " . $K['carcass'][$carcass][0] . ', ' . $K['finish'][$finish][0] . ', ' . $K['counter'][$counter][0] . " top, $city)",
  ];
}

/* =====================================================================
   3. WARDROBE — front area (width × height) × door rate × finish, + loft, fittings, GST, city
   ===================================================================== */
function calc_wardrobe($in) {
  $W = calc_rates()['wardrobe']; $gst = calc_rates()['gst'];
  $width  = calc_num($in['width'] ?? null, 2, 24, 8);
  $height = calc_num($in['height'] ?? null, 5, 11, 7);
  $loftH  = calc_num($in['loft'] ?? null, 0, 4, 0);
  $door   = calc_pick($in['door'] ?? '', $W['door'], 'hinged');
  $finish = calc_pick($in['finish'] ?? '', $W['finish'], 'laminate');
  $acc    = calc_many($in['acc'] ?? [], $W['acc']);
  [$city, $cf] = calc_city($in['city'] ?? '');

  $front = $width * $height;
  $rate  = $W['door'][$door][1] * $W['finish'][$finish][1];
  $base  = $front * $rate * $cf;
  $loft  = $width * $loftH * $rate * $W['loft'] * $cf;
  $fit   = array_sum(array_map(fn($a) => $W['acc'][$a][1], $acc)) * $cf;
  $tax   = ($base + $loft + $fit) * $gst;
  $total = $base + $loft + $fit + $tax;
  $meta  = "$width × $height ft · " . $W['door'][$door][0] . ' · ' . $W['finish'][$finish][0] . " · $city";
  return [
    'in' => compact('width', 'height', 'door', 'finish', 'city', 'acc') + ['loft' => $loftH],
    'total' => round($total),
    'out' => ['area' => round($front + $width * $loftH) . ' sq ft', 'base' => inr($base), 'loft' => inr($loft), 'fittings' => inr($fit), 'gst' => inr($tax),
              'total' => inr($total), 'total2' => lakh($total), 'meta' => e($meta), 'rate' => inr($rate * $cf) . ' per sq ft',
              'range' => 'Likely range ' . lakh($total * (1 - $W['spread'])) . ' – ' . lakh($total * (1 + $W['spread']))],
    'summary' => 'Wardrobe estimate ' . inr($total) . " ($meta" . ($loftH ? ", $loftH ft loft" : '') . ($acc ? ', ' . count($acc) . ' fittings' : '') . ')',
  ];
}

/* =====================================================================
   4. ROOM-BY-ROOM QUOTE — every item: size × base rate × grade/hardware/city effect
   ===================================================================== */
function calc_quote_grade($in) {   // [multiplier, label, note]
  $Q = calc_rates()['quote'];
  if (($in['grade'] ?? '') === 'custom') {
    $M = $Q['materials']; [$rc, $rf, $rs] = $M['reference'];
    $c = calc_pick($in['carcass'] ?? '', $M['carcass'], $rc);
    $f = calc_pick($in['finish'] ?? '', $M['finish'], $rf);
    $s = calc_pick($in['shutter'] ?? '', $M['shutter'], $rs);
    $ref = $M['carcass'][$rc][1] + $M['finish'][$rf][1] + $M['shutter'][$rs][1];
    $mult = ($M['carcass'][$c][1] + $M['finish'][$f][1] + $M['shutter'][$s][1]) / $ref;
    return [$mult, 'Own materials', $M['carcass'][$c][0] . ' carcass, ' . $M['finish'][$f][0] . ', ' . $M['shutter'][$s][0] . ' shutters (' . number_format($mult, 2) . '× Standard)', compact('c', 'f', 's')];
  }
  $g = calc_pick($in['grade'] ?? '', $Q['grades'], 'standard');
  return [$Q['grades'][$g][1], $Q['grades'][$g][0], $Q['grades'][$g][3] . ' ' . $Q['grades'][$g][2] . '.', $g];
}
function calc_quote($in) {
  $Q = calc_rates()['quote']; $gst = calc_rates()['gst'];
  [$g, $gradeLabel, $gradeNote, $gradeKey] = calc_quote_grade($in);
  $hwKey = calc_pick($in['hardware'] ?? '', $Q['hardware'], 'standard'); $h = $Q['hardware'][$hwKey][1];
  [$city, $cf] = calc_city($in['city'] ?? '');
  $fee = calc_num($in['fee'] ?? null, $Q['design_fee'][0], $Q['design_fee'][1], $Q['design_fee'][2]) / 100;
  $sent = !empty($in['sent']);   // a submitted form: unticked boxes are really off

  $out = []; $wood = 0; $sqft = 0; $count = 0; $rooms = 0; $roomLines = []; $chosen = [];
  foreach ($Q['areas'] as $aid => $area) {
    $aTotal = 0; $aCount = 0;
    foreach ($area['items'] as $id => [$name, $desc, $unit, $dL, $dH, $dQty, $rate, $gw, $hw, $defOn]) {
      $on  = $sent ? !empty($in['on'][$id]) : (bool) $defOn;
      $Lf  = calc_num($in['L'][$id] ?? null, 0, 40, $dL);
      $Hf  = calc_num($in['H'][$id] ?? null, 0, 40, $dH);
      $qty = calc_num($in['qty'][$id] ?? null, 0, 2000, $dQty);
      $size = $unit === 'sqft' ? $Lf * $Hf * $qty : $qty;
      $eff  = $rate * (1 + ($g - 1) * $gw) * (1 + ($h - 1) * $hw) * $cf;
      $amt  = $size * $eff;
      $out["rate-$id"] = inr($eff);
      $out["sz-$id"]   = rtrim(rtrim(number_format($size, 1), '0'), '.') . ($unit === 'sqft' ? ' sq ft' : ' nos');
      $out["amt-$id"]  = $on ? inr($amt) : '<span class="muted">' . inr($amt) . '</span>';
      if ($on && $amt > 0) {
        $aTotal += $amt; $aCount++;
        if ($unit === 'sqft') $sqft += $size;
        $chosen[] = $name;
      }
    }
    $out["area-$aid"] = $aTotal ? inr($aTotal) : '<span class="muted">₹0</span>';
    $out["cnt-$aid"]  = $aCount . ' of ' . count($area['items']) . ' selected';
    if ($aCount) { $rooms++; $roomLines[] = $area['name'] . ' ' . lakh($aTotal); }
    $wood += $aTotal; $count += $aCount;
  }
  $feeAmt = $wood * $fee;
  $taxable = $wood + $feeAmt;
  $tax = $taxable * $gst;
  $total = $taxable + $tax;
  $meta = "$gradeLabel · " . $Q['hardware'][$hwKey][0] . " fittings · $city";
  $out += [
    'items' => (string) $count, 'rooms' => (string) $rooms, 'sqft' => number_format($sqft, 1) . ' sq ft',
    'subtotal' => inr($wood), 'fee' => inr($feeAmt), 'fee-pct' => round($fee * 100) . '%', 'taxable' => inr($taxable), 'gst' => inr($tax),
    'total' => inr($total), 'total2' => lakh($total), 'meta' => e($meta), 'grade-note' => e($gradeNote), 'hw-note' => e($Q['hardware'][$hwKey][2]),
    'count' => $count . ' item' . ($count === 1 ? '' : 's') . ' in ' . $rooms . ' room' . ($rooms === 1 ? '' : 's'),
  ];
  return [
    'in' => ['grade' => $gradeKey, 'hardware' => $hwKey, 'city' => $city, 'fee' => $fee * 100, 'items' => $count],
    'total' => round($total), 'out' => $out,
    'summary' => 'Itemised quote ' . inr($total) . " incl. GST ($meta; $count items: " . implode(', ', $roomLines) . ')',
  ];
}

/* ---------- dispatcher ---------- */
const CALCS = ['home' => 'calc_home', 'kitchen' => 'calc_kitchen', 'wardrobe' => 'calc_wardrobe', 'quote' => 'calc_quote'];
function calc_run($type, $in = []) { return isset(CALCS[$type]) ? (CALCS[$type])((array) $in) : null; }

/* ---------- signed estimate token: lets api/lead.php trust the estimate sent with a lead ---------- */
function calc_token($type, $res) {
  $p = rtrim(strtr(base64_encode(json_encode(['t' => $type, 'v' => $res['total'], 's' => mb_substr($res['summary'], 0, 600), 'ts' => time()], JSON_UNESCAPED_UNICODE)), '+/', '-_'), '=');
  return $p . '.' . substr(hash_hmac('sha256', $p, LEADS['secret'] . '|calc'), 0, 24);
}
function calc_token_read($tok) {   // ['t' => type, 'v' => total, 's' => summary] or null
  [$p, $sig] = array_pad(explode('.', (string) $tok, 2), 2, '');
  if ($p === '' || !hash_equals(substr(hash_hmac('sha256', $p, LEADS['secret'] . '|calc'), 0, 24), $sig)) return null;
  $d = json_decode(base64_decode(strtr($p, '-_', '+/')), true);
  return ($d && time() - ($d['ts'] ?? 0) < 7 * 86400) ? $d : null;
}

/* ---------- usage log (one line per finished calculation; read by /admin/) ---------- */
function calc_log($type, $res, $page, $pillar = '') {
  csv_append(leads_dir() . (is_staging() ? '/calc-log-test.csv' : '/calc-log.csv'), [
    'time' => date('Y-m-d H:i:s'), 'calculator' => $type, 'page' => $page, 'pillar' => lead_pillar($pillar, $page),
    'city' => $res['in']['city'] ?? '', 'total' => $res['total'], 'summary' => $res['summary'],
  ]);
}
