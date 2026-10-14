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
   4. ROOM-BY-ROOM INTERIOR QUOTE (rebuilt Oct 2026) — NO MULTIPLIERS
   Each line = size × its own rate, where a woodwork rate is the SUM of the chosen board, shutter core,
   finish and fittings rates plus the item's making rate (includes/calc/rates.php → 'quote').
   Fittings, accessories and services have their own fixed prices. GST is added at the end.
   Only final line rates and amounts leave the server; the components stay here.
   ===================================================================== */
function calc_quote_specs($in) {   // the chosen option key for every material choice
  $S = calc_rates()['quote']['specs'];
  $pick = [];
  foreach ($S as $k => $spec) {
    $opts = is_string($spec['options']) ? $S[$spec['options']]['options'] : $spec['options'];
    $pick[$k] = calc_pick($in[$k] ?? '', $opts, $spec['default']);
  }
  return $pick;
}
function calc_quote_opt($k, $key) {   // [name, rate, what it is, where it suits] for one choice
  $S = calc_rates()['quote']['specs'];
  $opts = is_string($S[$k]['options']) ? $S[$S[$k]['options']]['options'] : $S[$k]['options'];
  return $opts[$key];
}
// Final rate per unit for one item, and the spec line printed under it
function calc_quote_line($item, $pick) {
  [, , $kind, , , , $price, , , $wet] = $item;
  $Q = calc_rates()['quote'];
  $o = fn($k) => calc_quote_opt($k, $pick[$k]);
  $box = $wet ? $o('wet') : $o('carcass');
  $hwIdx = array_search($pick['hardware'], array_keys($Q['specs']['hardware']['options']), true);
  switch ($kind) {
    case 'cabinet': return [$box[1] + $o('shutter')[1] + $o('finish')[1] + $o('hardware')[1] + $price,
                            $box[0] . ' box · ' . $o('shutter')[0] . ' shutters · ' . $o('finish')[0] . ' · ' . $o('hardware')[0]];
    case 'open':    return [$box[1] + $o('finish')[1] + $price, $box[0] . ' · ' . $o('finish')[0] . ' · open shelves'];
    case 'panel':   return [$o('shutter')[1] + $o('finish')[1] + $price, $o('shutter')[0] . ' panel · ' . $o('finish')[0]];
    case 'fitting': return [(float) ($price[$hwIdx] ?? $price[1]), $o('hardware')[0]];
    case 'counter': return [(float) $o('counter')[1], $o('counter')[0]];
    case 'ceiling': return [(float) $o('ceiling')[1], $o('ceiling')[0] . ' · excludes paint and electricals'];
    case 'rate':    return [(float) $price, 'Fixed rate per sq ft'];
    default:        return [(float) $price, 'Fixed price per piece'];
  }
}
function calc_quote($in) {
  $Q = calc_rates()['quote']; $gst = calc_rates()['gst'];
  $pick = calc_quote_specs($in);
  $sent = !empty($in['sent']);   // a submitted form: unticked boxes are really off
  $home = calc_pick($in['home'] ?? '', $Q['homes'], $Q['default_home']);
  $homeAreas = $Q['homes'][$home][1];

  $out = []; $sub = 0; $wood = 0; $sqft = 0; $count = 0; $rooms = 0; $roomLines = []; $roomRows = [];
  foreach ($Q['areas'] as $aid => $area) {
    $aTotal = 0; $aCount = 0;
    foreach ($area['items'] as $id => $item) {
      [$name, $desc, $kind, $dL, $dH, $dQty, , $defOn] = $item;
      $on  = $sent ? !empty($in['on'][$id]) : ($defOn && in_array($aid, $homeAreas, true));
      $Lf  = calc_num($in['L'][$id] ?? null, 0, 40, $dL);
      $Hf  = calc_num($in['H'][$id] ?? null, 0, 40, $dH);
      $qty = calc_num($in['qty'][$id] ?? null, 0, 2000, $dQty);
      $perSqft = !in_array($kind, ['each', 'fitting'], true);
      $size = $perSqft ? $Lf * $Hf * $qty : $qty;
      [$rate, $spec] = calc_quote_line($item, $pick);
      $amt = round($size * $rate);
      $out["rate-$id"] = inr($rate) . ($perSqft ? '<small>/sq ft</small>' : '');
      $out["sz-$id"]   = rtrim(rtrim(number_format($size, 1), '0'), '.') . ($perSqft ? ' sq ft' : ' nos');
      $out["amt-$id"]  = $on ? inr($amt) : '<span class="muted">' . inr($amt) . '</span>';
      $out["spec-$id"] = e($spec);
      if ($on && $amt > 0) {
        $aTotal += $amt; $aCount++;
        if (in_array($kind, ['cabinet', 'open', 'panel'], true)) { $sqft += $size; $wood += $amt; }
      }
    }
    $out["area-$aid"] = $aTotal ? inr($aTotal) : '<span class="muted">₹0</span>';
    $out["cnt-$aid"]  = $aCount . ' of ' . count($area['items']) . ' selected';
    if ($aCount) { $rooms++; $roomLines[] = $area['name'] . ' ' . lakh($aTotal); $roomRows[] = '<li>' . e($area['name']) . ' <b>' . inr($aTotal) . '</b></li>'; }
    $sub += $aTotal; $count += $aCount;
  }
  $tax = round($sub * $gst);
  $total = $sub + $tax;

  // spec sheet: what every choice is, so quotes can be compared on the same list
  $sheet = '';
  foreach ($Q['specs'] as $k => $spec) {
    [$n, , $what, $suits] = calc_quote_opt($k, $pick[$k]);
    $sheet .= '<li><span>' . e($spec['label']) . '</span><b>' . e($n) . '</b><small>' . e($what) . ' ' . e($suits) . '</small></li>';
  }
  $war = $Q['warranty'][$pick['carcass']] ?? '';
  $meta = calc_quote_opt('carcass', $pick['carcass'])[0] . ' · ' . calc_quote_opt('finish', $pick['finish'])[0] . ' · ' . calc_quote_opt('hardware', $pick['hardware'])[0];
  $out += [
    'items' => (string) $count, 'rooms' => (string) $rooms, 'sqft' => number_format($sqft, 1) . ' sq ft',
    'subtotal' => inr($sub), 'wood' => inr($wood), 'other' => inr($sub - $wood), 'gst' => inr($tax),
    'total' => inr($total), 'total2' => lakh($total), 'meta' => e($meta), 'sheet' => $sheet,
    'room-lines' => $roomRows ? implode('', $roomRows) : '<li class="muted">Tick at least one item</li>',
    'avg' => $sqft > 0 ? inr($wood / $sqft) . '<small>/sq ft</small>' : '—', 'warranty' => e($war),
    'count' => $count . ' item' . ($count === 1 ? '' : 's') . ' in ' . $rooms . ' room' . ($rooms === 1 ? '' : 's'),
  ];
  return [
    'in' => ['city' => 'Bangalore', 'home' => $home, 'specs' => $pick, 'items' => $count],
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
  return $p . '.' . substr(hash_hmac('sha256', $p, lead_secret() . '|calc'), 0, 24);
}
function calc_token_read($tok) {   // ['t' => type, 'v' => total, 's' => summary] or null
  [$p, $sig] = array_pad(explode('.', (string) $tok, 2), 2, '');
  if ($p === '' || !hash_equals(substr(hash_hmac('sha256', $p, lead_secret() . '|calc'), 0, 24), $sig)) return null;
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
