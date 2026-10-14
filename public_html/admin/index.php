<?php
/* =====================================================================
   PRIVATE REPORTS — /admin/   (password: config.php → ADMIN)
   Reads the files the site already writes, one folder above public_html:
     leads/leads.csv       every enquiry (with page, pillar, landing page, source and calculator estimate)
     leads/calc-log.csv    every finished calculation (calculator, page, pillar, city, total)
   Shows, for the last 30 days and all time: leads and calculations by pillar, the pages and forms
   that bring leads, cities, traffic sources, and the latest enquiries. Download links for both files.
   Your Google Analytics reports by pillar use the same pillar names (content_group / pillar).
   ===================================================================== */
require __DIR__ . '/../includes/admin-auth.php';   // login (config.php → ADMIN)

/* ---------- data ---------- */
$dir = leads_dir();
$suffix = is_staging() ? '-test' : '';
$files = ['leads' => "$dir/leads$suffix.csv", 'calc' => "$dir/calc-log$suffix.csv"];
if (isset($_GET['download'], $files[$_GET['download']]) && is_file($files[$_GET['download']])) {
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename="' . basename($files[$_GET['download']]) . '"');
  readfile($files[$_GET['download']]); exit;
}
function read_csv($file) {
  if (!is_file($file) || !($fh = fopen($file, 'r'))) return [];
  $head = fgetcsv($fh); if (!$head) return [];
  $head[0] = preg_replace('/^\xEF\xBB\xBF/', '', $head[0]);
  $rows = [];
  while (($r = fgetcsv($fh)) !== false) if (count($r) === count($head)) $rows[] = array_combine($head, $r);
  fclose($fh);
  return $rows;
}
$leads = array_values(array_filter(read_csv($files['leads']), fn($l) => ($l['status'] ?? '') !== 'duplicate'));
$calcs = read_csv($files['calc']);
$days = (int) ($_GET['days'] ?? 30);
$since = $days ? date('Y-m-d', strtotime("-$days days")) : '0000';
$leadsP = array_filter($leads, fn($l) => $l['time'] >= $since);
$calcsP = array_filter($calcs, fn($c) => $c['time'] >= $since);

$label = function ($key) { $h = $key ? hub($key) : null; return $h ? $h['label'] : ($key ?: '(none)'); };
$count = function ($rows, $col) { $o = []; foreach ($rows as $r) { $k = $r[$col] ?? ''; $o[$k] = ($o[$k] ?? 0) + 1; } arsort($o); return $o; };
$source = function ($l) {
  if (preg_match('/utm_source=([^&]+)/', $l['utm'] ?? '', $m)) return 'utm: ' . urldecode($m[1]);
  if (str_contains($l['utm'] ?? '', 'gclid')) return 'Google Ads';
  if (str_contains($l['utm'] ?? '', 'fbclid')) return 'Meta ads / Facebook';
  $host = parse_url($l['referrer'] ?? '', PHP_URL_HOST);
  if (!$host) return 'Direct / unknown';
  if (preg_match('/google\./', $host)) return 'Google (organic)';
  if (preg_match('/bing\.|duckduckgo|yahoo/', $host)) return 'Other search';
  if (preg_match('/chatgpt|openai|perplexity|copilot|gemini|claude/', $host)) return 'AI assistants';
  if (preg_match('/facebook|instagram|fb\.|linkedin|pinterest|youtube|t\.co|twitter|x\.com/', $host)) return 'Social';
  return $host === parse_url(SITE['url'], PHP_URL_HOST) ? 'Internal' : $host;
};

// by pillar: leads, leads with an estimate, calculations, average estimate
$pillars = [];
foreach ($leadsP as $l) { $p = $l['pillar'] ?? ''; $pillars[$p]['leads'] = ($pillars[$p]['leads'] ?? 0) + 1; if (($l['estimate_total'] ?? '') !== '') { $pillars[$p]['est'] = ($pillars[$p]['est'] ?? 0) + 1; $pillars[$p]['sum'] = ($pillars[$p]['sum'] ?? 0) + (int) $l['estimate_total']; } }
foreach ($calcsP as $c) { $p = $c['pillar'] ?? ''; $pillars[$p]['calcs'] = ($pillars[$p]['calcs'] ?? 0) + 1; $pillars[$p]['csum'] = ($pillars[$p]['csum'] ?? 0) + (int) $c['total']; }
uasort($pillars, fn($a, $b) => ($b['leads'] ?? 0) <=> ($a['leads'] ?? 0) ?: ($b['calcs'] ?? 0) <=> ($a['calcs'] ?? 0));

$table = function ($title, $data, $head = 'Leads') {
  if (!$data) return '';
  $h = '<section><h2>' . e($title) . '</h2><table><thead><tr><th></th><th class="n">' . e($head) . '</th></tr></thead><tbody>';
  foreach (array_slice($data, 0, 15, true) as $k => $v) $h .= '<tr><td>' . e($k ?: '(none)') . '</td><td class="n">' . $v . '</td></tr>';
  return $h . '</tbody></table></section>';
};
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
<title>Reports | <?= e(SITE['name']) ?></title>
<style>
  :root { --red: #C8102E; --ink: #111; --line: #e5e5e5; --muted: #666; }
  body { font: 15px/1.5 system-ui, -apple-system, 'Segoe UI', sans-serif; color: var(--ink); margin: 0; background: #f6f5f3; }
  header { background: var(--ink); color: #fff; padding: 1rem 1.25rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between; }
  header a { color: #fff; margin-left: .75rem; } header a.on { font-weight: 700; color: #ffb3c0; }
  main { max-width: 1200px; margin: 0 auto; padding: 1.25rem; display: grid; gap: 1.25rem; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); }
  section { background: #fff; border: 1px solid var(--line); border-radius: 10px; padding: 1rem 1.25rem; overflow-x: auto; }
  section.wide { grid-column: 1 / -1; }
  h1 { font-size: 1.15rem; margin: 0; } h2 { font-size: 1rem; margin: 0 0 .75rem; }
  table { width: 100%; border-collapse: collapse; font-size: 14px; } th, td { text-align: left; padding: .4rem .5rem; border-bottom: 1px solid var(--line); vertical-align: top; }
  th { font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); } .n { text-align: right; font-variant-numeric: tabular-nums; white-space: nowrap; }
  .kpis { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: .75rem; } .kpi b { display: block; font-size: 1.8rem; color: var(--red); } .kpi span { color: var(--muted); font-size: 13px; }
  .muted { color: var(--muted); font-size: 13px; }
</style></head>
<body>
<header>
  <h1><?= e(SITE['name']) ?> reports<?= is_staging() ? ' · STAGING (test data)' : '' ?></h1>
  <nav>Period: <?php foreach ([7 => '7 days', 30 => '30 days', 90 => '90 days', 0 => 'All time'] as $d => $t) echo '<a href="?days=' . $d . '"' . ($d === $days ? ' class="on"' : '') . '>' . $t . '</a>'; ?>
    · <a href="/admin/images.php">Images</a> · <a href="?download=leads">Download leads CSV</a> <a href="?download=calc">Download calculator log</a></nav>
</header>
<main>
  <section class="wide">
    <div class="kpis">
      <div class="kpi"><b><?= count($leadsP) ?></b><span>Leads</span></div>
      <div class="kpi"><b><?= count(array_filter($leadsP, fn($l) => ($l['estimate_total'] ?? '') !== '')) ?></b><span>Leads with a calculator estimate</span></div>
      <div class="kpi"><b><?= count($calcsP) ?></b><span>Calculations finished</span></div>
      <div class="kpi"><b><?= $calcsP ? round(count($leadsP) * 100 / max(1, count($calcsP))) . '%' : '–' ?></b><span>Leads per calculation</span></div>
      <?php $ests = array_filter(array_map(fn($l) => (int) ($l['estimate_total'] ?? 0), $leadsP)); ?>
      <div class="kpi"><b><?= $ests ? lakh_fmt(array_sum($ests) / count($ests)) : '–' ?></b><span>Average estimate on leads</span></div>
    </div>
  </section>

  <section class="wide">
    <h2>By pillar</h2>
    <table><thead><tr><th>Pillar</th><th class="n">Leads</th><th class="n">With estimate</th><th class="n">Avg estimate</th><th class="n">Calculations</th><th class="n">Avg calculation</th></tr></thead><tbody>
<?php foreach ($pillars as $k => $p): ?>
      <tr><td><?= e($label($k)) ?></td><td class="n"><?= $p['leads'] ?? 0 ?></td><td class="n"><?= $p['est'] ?? 0 ?></td><td class="n"><?= !empty($p['est']) ? lakh_fmt($p['sum'] / $p['est']) : '–' ?></td><td class="n"><?= $p['calcs'] ?? 0 ?></td><td class="n"><?= !empty($p['calcs']) ? lakh_fmt($p['csum'] / $p['calcs']) : '–' ?></td></tr>
<?php endforeach; if (!$pillars): ?>
      <tr><td colspan="6" class="muted">No data for this period yet.</td></tr>
<?php endif; ?>
    </tbody></table>
    <p class="muted">Page views, reading depth and clicks by pillar are in Google Analytics: Reports → Engagement → Pages and screens → add "Content group" (or the custom dimension "pillar").</p>
  </section>

  <?= $table('Pages that bring leads', $count($leadsP, 'source')) ?>
  <?= $table('First page of the visit (landing)', $count($leadsP, 'landing')) ?>
  <?= $table('Traffic source', (function () use ($leadsP, $source) { $o = []; foreach ($leadsP as $l) { $s = $source($l); $o[$s] = ($o[$s] ?? 0) + 1; } arsort($o); return $o; })()) ?>
  <?= $table('Form used', $count($leadsP, 'form')) ?>
  <?= $table('City', $count($leadsP, 'city')) ?>
  <?= $table('Home type', $count($leadsP, 'home')) ?>
  <?= $table('Calculations by calculator', $count($calcsP, 'calculator'), 'Uses') ?>
  <?= $table('Calculations by page', $count($calcsP, 'page'), 'Uses') ?>

  <section class="wide">
    <h2>Latest enquiries</h2>
    <table><thead><tr><th>When</th><th>Name</th><th>Mobile</th><th>City · home</th><th>Pillar · page</th><th>Estimate</th><th>Notes</th></tr></thead><tbody>
<?php foreach (array_slice(array_reverse($leadsP), 0, 30) as $l): ?>
      <tr><td><?= e(substr($l['time'], 0, 16)) ?><br><span class="muted"><?= e($l['lead_id'] ?? '') ?></span></td><td><?= e($l['name']) ?></td><td><a href="tel:+91<?= e($l['phone']) ?>"><?= e($l['phone']) ?></a></td>
        <td><?= e(trim(($l['city'] ?? '') . ' · ' . ($l['home'] ?? ''), ' ·')) ?></td><td><?= e($label($l['pillar'] ?? '')) ?><br><span class="muted"><?= e($l['source'] ?? '') ?></span></td>
        <td><?= ($l['estimate_total'] ?? '') !== '' ? lakh_fmt((int) $l['estimate_total']) : '' ?></td><td class="muted"><?= e(mb_substr(trim(($l['notes'] ?? '') . ' ' . ($l['service'] ?? '')), 0, 140)) ?></td></tr>
<?php endforeach; ?>
    </tbody></table>
  </section>
</main>
</body></html>
<?php
function lakh_fmt($n) { return $n >= 1e5 ? '₹' . rtrim(rtrim(number_format($n / 1e5, 1), '0'), '.') . 'L' : '₹' . number_format($n); }
