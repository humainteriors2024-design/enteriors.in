<?php
/* =====================================================================
   ADD A DESIGN — /admin/designs.php   (same login as /admin/)
   Adds a company's design to /trending-designs/ (and its own page at /trending-designs/<key>/).
   Every field the filters use is REQUIRED, so each design you add can be found by every filter:
     company · city · location / area · pincode · design type · property type · design style · budget
   plus a title and at least one photo. Optional: project, designer, BHK, size, weeks, summary,
   highlights, materials, "show on the home page first".
   Saved in the private folder one level above public_html (leads/designs/<key>.json), so uploading a
   new copy of the website never removes them; photos go to /assets/trending/<key>/ (01, 02 …).
   The sample designs in includes/data/trends.php are checked against the same rules below.
   ===================================================================== */
require __DIR__ . '/../includes/admin-auth.php';
require __DIR__ . '/../includes/admin-media.php';

$T = trends_db_file(); $P = places_db(); $D = pros_db_raw();
$root = rtrim($_SERVER['DOCUMENT_ROOT'] ?: dirname(__DIR__), '/');
$added = [];
foreach (glob(designs_dir() . '/*.json') ?: [] as $f) { $x = json_decode((string) file_get_contents($f), true); if (is_array($x)) $added[basename($f, '.json')] = $x; }
$editKey = preg_match('/^[a-z0-9\-]{3,100}$/', (string) ($_GET['edit'] ?? '')) && isset($added[$_GET['edit']]) ? $_GET['edit'] : '';
$errors = []; $msg = (string) ($_GET['msg'] ?? '');
$v = $editKey ? $added[$editKey] : [];

function design_key_for($title, $city, $taken) {
  $s = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string) $title) ?: (string) $title), '-'));
  $s = substr($s ?: 'design', 0, 80);
  if ($city && !str_ends_with($s, $city)) $s .= '-' . $city;
  $base = $s; $i = 2;
  while (isset($taken[$s])) $s = $base . '-' . $i++;
  return $s;
}

/* ---------- save ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!admin_token_ok($_POST['token'] ?? '')) { header('Location: designs.php?msg=' . rawurlencode('err:Form expired, please try again.'), true, 303); exit; }
  $in = fn($k, $max = 200) => mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags(is_scalar($_POST[$k] ?? null) ? (string) $_POST[$k] : ''))), 0, $max);
  $key = preg_match('/^[a-z0-9\-]{3,100}$/', $in('key')) && isset($added[$in('key')]) ? $in('key') : '';

  if (($_POST['action'] ?? '') === 'hide' && $key) {   // take a design off the site (kept, can be shown again)
    $added[$key]['hidden'] = empty($added[$key]['hidden']);
    file_put_contents(designs_dir() . "/$key.json", json_encode($added[$key], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), LOCK_EX);
    header('Location: designs.php?msg=' . rawurlencode('ok:' . ($added[$key]['hidden'] ? 'Hidden from the site: ' : 'Shown again: ') . $added[$key]['title']), true, 303); exit;
  }

  $v = [
    'title' => $in('title', 120), 'company' => $in('company', 100), 'city' => $in('city', 60), 'area' => $in('area', 60),
    'pincode' => preg_replace('/\s/', '', $in('pincode', 10)), 'type' => $in('type', 40), 'property' => $in('property', 40), 'style' => $in('style', 40),
    'budget' => (int) preg_replace('/\D/', '', $in('budget', 12)),
    'project' => $in('project', 80), 'designer' => $in('designer', 60), 'bhk' => min(6, (int) $in('bhk', 2)), 'size' => (int) $in('size', 6), 'weeks' => min(52, (int) $in('weeks', 2)),
    'summary' => $in('summary', 400),
    'highlights' => array_values(array_filter(array_map(fn($l) => mb_substr(trim(strip_tags($l)), 0, 90), preg_split('/\R/', (string) ($_POST['highlights'] ?? ''))))),
    'materials' => array_values(array_filter(array_map(fn($l) => mb_substr(trim(strip_tags($l)), 0, 40), explode(',', (string) ($_POST['materials'] ?? ''))))),
    'trending' => !empty($_POST['trending']),
  ];
  foreach (design_missing($v) as $k => $label) $errors[$k] = $label . ' is required' . ($k === 'pincode' ? ' (6 digits)' : ($k === 'budget' ? ' (in rupees, e.g. 650000)' : '')) . '.';
  if (in_array($v['property'], ['office', 'commercial', 'studio'], true)) $v['bhk'] = 0;
  elseif (!$errors && $v['bhk'] < 1 && in_array($v['type'], ['full-home', 'villa', 'renovation'], true)) $errors['bhk'] = 'BHK is required for a full home.';

  // photos: at least one for a new design
  $files = [];
  if (!empty($_FILES['photos']['name']) && is_array($_FILES['photos']['name'])) {
    foreach ($_FILES['photos']['name'] as $i => $n) {
      if (($_FILES['photos']['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) continue;
      if ($_FILES['photos']['error'][$i] !== UPLOAD_ERR_OK || $_FILES['photos']['size'][$i] > 15 * 1024 * 1024) { $errors['photos'] = 'A photo could not be uploaded (max 15 MB each).'; continue; }
      $info = @getimagesize($_FILES['photos']['tmp_name'][$i]);
      $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
      if (!$info || !isset($types[$info[2]])) { $errors['photos'] = 'Photos must be JPG, PNG or WebP.'; continue; }
      $files[] = [$_FILES['photos']['tmp_name'][$i], $info, $types[$info[2]]];
    }
  }
  if (count($files) > 10) $errors['photos'] = 'Up to 10 photos per design.';
  if (!$key && !$files && empty($errors['photos'])) $errors['photos'] = 'Add at least one photo.';

  if (!$errors) {
    $taken = array_merge($T['designs'], $added);
    $key = $key ?: design_key_for($v['title'], $v['city'], $taken);
    $old = $added[$key] ?? [];
    $v['added'] = $old['added'] ?? date('Y-m-d');
    $v['by'] = $_SERVER['PHP_AUTH_USER'] ?? '';
    $v['updated'] = date('c');
    if (!empty($old['hidden'])) $v['hidden'] = true;
    if ($files) {
      $dir = $root . '/assets/trending/' . $key;
      if (!is_dir($dir)) @mkdir($dir, 0755, true);
      $n = count(array_filter(glob($dir . '/*') ?: [], fn($f) => preg_match('/\.(jpe?g|png)$/i', $f)));
      foreach ($files as [$tmp, $info, $ext]) admin_save_image($tmp, $info, $ext, sprintf('%s/%02d', $dir, ++$n), 2000);
    }
    file_put_contents(designs_dir() . "/$key.json", json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), LOCK_EX);
    @chmod(designs_dir() . "/$key.json", 0600);
    header('Location: designs.php?msg=' . rawurlencode('ok:Saved. It is on the site now: ' . design_url($key)), true, 303); exit;
  }
  $editKey = $key;
}

/* ---------- options ---------- */
$opt = fn($list, $sel) => '<option value="">Choose…</option>' . implode('', array_map(fn($k, $l) => '<option value="' . e($k) . '"' . ((string) $k === (string) $sel ? ' selected' : '') . '>' . e($l) . '</option>', array_keys($list), $list));
$pros = array_map(fn($p) => $p['name'] . ' (' . city_name($p['city']) . ')' . (!empty($p['sample']) ? ' — sample' : ''), $D['pros']); asort($pros);
$cities = []; foreach ($P['cities'] as $k => $c) $cities[$k] = $c['name'] . ', ' . state_name($c['state']); asort($cities);
$areas = []; foreach ($P['cities'] as $k => $c) $areas[$k] = array_keys($c['areas'] ?? []);
$bad = []; foreach ($T['designs'] as $k => $d) if ($m = design_missing($d)) $bad[$k] = $m;
[$mt, $mx] = array_pad(explode(':', $msg, 2), 2, '');
$token = admin_token();
$f = fn($k, $label, $input, $req = true, $hint = '', $wide = false) => '<div class="f' . ($wide ? ' wide' : '') . (isset($errors[$k]) ? ' bad' : '') . '"><label for="d-' . $k . '">' . e($label) . ($req ? ' <b>*</b>' : '') . '</label>' . $input
  . ($hint ? '<small>' . e($hint) . '</small>' : '') . (isset($errors[$k]) ? '<em>' . e($errors[$k]) . '</em>' : '') . '</div>';
$val = fn($k) => e(is_array($v[$k] ?? '') ? '' : (string) ($v[$k] ?? ''));
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
<title>Add a design | <?= e(SITE['name']) ?></title>
<style>
  :root { --red: #C8102E; --ink: #111; --line: #ddd; --muted: #666; --ok: #1E7B4F; }
  body { font: 15px/1.5 system-ui, -apple-system, 'Segoe UI', sans-serif; color: var(--ink); margin: 0; background: #f6f5f3; }
  header { background: var(--ink); color: #fff; padding: 1rem 1.25rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between; }
  header a { color: #fff; } h1 { font-size: 1.15rem; margin: 0; } h2 { font-size: 1.05rem; margin: 0 0 .75rem; }
  main { max-width: 1000px; margin: 0 auto; padding: 1.25rem; display: grid; gap: 1.25rem; }
  section { background: #fff; border: 1px solid var(--line); border-radius: 10px; padding: 1rem 1.25rem; }
  .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: .75rem 1rem; }
  .f { display: grid; gap: 3px; } .f.wide { grid-column: 1 / -1; }
  .f label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); } .f label b { color: var(--red); }
  .f input, .f select, .f textarea { font: inherit; padding: .5rem .6rem; border: 1px solid var(--line); border-radius: 4px; background: #fff; width: 100%; box-sizing: border-box; }
  .f small { color: var(--muted); font-size: 12px; } .f em { color: var(--red); font-size: 13px; font-style: normal; } .f.bad input, .f.bad select { border-color: var(--red); }
  .msg { padding: .75rem 1rem; border-radius: 6px; } .msg.ok { background: #EDF7F1; color: var(--ok); } .msg.err { background: #FDF0F2; color: var(--red); }
  button { background: var(--red); color: #fff; border: 0; border-radius: 4px; padding: .6rem 1.1rem; font-weight: 700; cursor: pointer; font-size: 15px; }
  button.link { background: none; color: var(--red); padding: 0; font-weight: 400; text-decoration: underline; }
  table { width: 100%; border-collapse: collapse; font-size: 14px; } td, th { text-align: left; padding: .4rem; border-bottom: 1px solid var(--line); vertical-align: top; }
  .muted { color: var(--muted); }
</style></head>
<body>
<header>
  <h1><?= e(SITE['name']) ?> · Add a design<?= is_staging() ? ' · STAGING' : '' ?></h1>
  <nav><a href="/admin/">Reports</a> · <a href="/admin/images.php">Images</a> · <a href="/admin/indexnow.php">IndexNow</a> · <a href="/trending-designs/" target="_blank">Trending designs ↗</a></nav>
</header>
<main>
<?php if ($mx): ?><div class="msg <?= $mt === 'ok' ? 'ok' : 'err' ?>"><?= e($mx) ?></div><?php endif; ?>
<?php if ($errors): ?><div class="msg err">Please fill in the fields marked below. Every design needs them so it shows up in every filter.</div><?php endif; ?>

  <section>
    <h2><?= $editKey ? 'Edit: ' . e($v['title'] ?? $editKey) : 'Add a company design' ?></h2>
    <p class="muted">Fields with <b style="color:var(--red)">*</b> are required: they are the filters on Trending designs (city, location, pincode, design type, property type, style and budget) and the company it belongs to.</p>
    <form method="post" enctype="multipart/form-data">
      <div class="grid">
        <?= $f('title', 'Title', '<input id="d-title" name="title" required maxlength="120" value="' . $val('title') . '" placeholder="e.g. Japandi 3 BHK in Whitefield, Bengaluru">', true, 'Style + room or home + area + city reads best.') ?>
        <?= $f('company', 'Company', '<select id="d-company" name="company" required>' . $opt($pros, $v['company'] ?? '') . '</select>', true, 'Add the firm to includes/data/pros.php first if it is not listed.') ?>
        <?= $f('city', 'City', '<select id="d-city" name="city" required>' . $opt($cities, $v['city'] ?? '') . '</select>') ?>
        <?= $f('area', 'Location / area', '<input id="d-area" name="area" required maxlength="60" list="d-areas" value="' . $val('area') . '" placeholder="e.g. Whitefield"><datalist id="d-areas"></datalist>') ?>
        <?= $f('pincode', 'Pincode', '<input id="d-pincode" name="pincode" required inputmode="numeric" pattern="[1-9][0-9]{5}" maxlength="6" value="' . $val('pincode') . '" placeholder="560066">') ?>
        <?= $f('type', 'Design type', '<select id="d-type" name="type" required>' . $opt(array_map(fn($t) => $t['label'], $T['types']), $v['type'] ?? '') . '</select>') ?>
        <?= $f('property', 'Property type', '<select id="d-property" name="property" required>' . $opt($T['properties'], $v['property'] ?? '') . '</select>') ?>
        <?= $f('style', 'Design style', '<select id="d-style" name="style" required>' . $opt(array_map(fn($t) => $t['label'], $T['styles']), $v['style'] ?? '') . '</select>') ?>
        <?= $f('budget', 'Approximate budget, ₹', '<input id="d-budget" name="budget" required inputmode="numeric" value="' . e(($v['budget'] ?? '') ?: '') . '" placeholder="650000">', true, 'Including GST. Sets the budget filter band.') ?>
        <?= $f('bhk', 'BHK', '<select id="d-bhk" name="bhk">' . $opt(['0' => 'Not a home / studio', '1' => '1 BHK', '2' => '2 BHK', '3' => '3 BHK', '4' => '4 BHK', '5' => '5 BHK', '6' => '6+ BHK'], (string) ($v['bhk'] ?? '')) . '</select>', false, 'Required for a full home.') ?>
        <?= $f('size', 'Size, sq ft', '<input id="d-size" name="size" inputmode="numeric" value="' . e(($v['size'] ?? '') ?: '') . '">', false) ?>
        <?= $f('weeks', 'Weeks on site', '<input id="d-weeks" name="weeks" inputmode="numeric" value="' . e(($v['weeks'] ?? '') ?: '') . '">', false) ?>
        <?= $f('project', 'Project / building', '<input id="d-project" name="project" maxlength="80" value="' . $val('project') . '">', false) ?>
        <?= $f('designer', 'Designer', '<input id="d-designer" name="designer" maxlength="60" value="' . $val('designer') . '" placeholder="e.g. Revathi V.">', false) ?>
        <?= $f('summary', 'Summary', '<textarea id="d-summary" name="summary" rows="2" maxlength="400">' . $val('summary') . '</textarea>', false, 'Two sentences: who it was for, the look and the key materials.', true) ?>
        <?= $f('highlights', 'Highlights (one per line)', '<textarea id="d-highlights" name="highlights" rows="3">' . e(implode("\n", $v['highlights'] ?? [])) . '</textarea>', false, '', true) ?>
        <?= $f('materials', 'Materials (comma separated)', '<input id="d-materials" name="materials" value="' . e(implode(', ', $v['materials'] ?? [])) . '" placeholder="teak veneer, quartz, matte laminate">', false) ?>
        <div class="f"><label><input type="checkbox" name="trending" value="1"<?= !empty($v['trending']) ? ' checked' : '' ?>> Show on the home page first</label></div>
        <?= $f('photos', $editKey ? 'Add more photos' : 'Photos (1 to 10)', '<input id="d-photos" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple' . ($editKey ? '' : ' required') . '>', !$editKey, 'The first photo is the main one (landscape). Resized and converted to WebP for you.', true) ?>
      </div>
      <input type="hidden" name="token" value="<?= e($token) ?>"><input type="hidden" name="key" value="<?= e($editKey) ?>">
      <p><button type="submit"><?= $editKey ? 'Save changes' : 'Add design' ?></button><?= $editKey ? ' <a href="designs.php">Cancel</a>' : '' ?></p>
    </form>
  </section>

  <section>
    <h2>Designs you have added (<?= count($added) ?>)</h2>
<?php if (!$added): ?><p class="muted">None yet.</p><?php else: ?>
    <table><thead><tr><th>Design</th><th>Company</th><th>City</th><th></th></tr></thead><tbody>
<?php foreach ($added as $k => $x): $miss = design_missing($x); ?>
      <tr><td><a href="<?= e(design_url($k)) ?>" target="_blank"><?= e($x['title'] ?? $k) ?></a><?= !empty($x['hidden']) ? ' <span class="muted">(hidden)</span>' : '' ?><?= $miss ? '<br><em style="color:var(--red)">Missing: ' . e(implode(', ', $miss)) . ' — not shown until fixed</em>' : '' ?></td>
        <td><?= e($D['pros'][$x['company'] ?? '']['name'] ?? '') ?></td><td><?= e(city_name($x['city'] ?? '')) ?></td>
        <td><a href="?edit=<?= e($k) ?>">Edit</a> · <form method="post" style="display:inline"><input type="hidden" name="token" value="<?= e($token) ?>"><input type="hidden" name="key" value="<?= e($k) ?>"><input type="hidden" name="action" value="hide"><button class="link"><?= !empty($x['hidden']) ? 'Show' : 'Hide' ?></button></form></td></tr>
<?php endforeach; ?>
    </tbody></table>
<?php endif; ?>
  </section>

  <section>
    <h2>Check: designs in includes/data/trends.php</h2>
    <p><?= count($T['designs']) ?> designs in the file<?= $bad ? ', <b style="color:var(--red)">' . count($bad) . ' missing a filter field</b>:' : ': every one has all the filter fields.' ?></p>
<?php if ($bad): ?><ul><?php foreach ($bad as $k => $m) echo '<li><code>' . e($k) . '</code>: ' . e(implode(', ', $m)) . '</li>'; ?></ul><?php endif; ?>
  </section>
</main>
<script>
  // suggest the localities of the chosen city
  (function () {
    var areas = <?= json_encode($areas, JSON_UNESCAPED_UNICODE) ?>, city = document.getElementById('d-city'), list = document.getElementById('d-areas');
    var fill = function () { list.innerHTML = ''; (areas[city.value] || []).forEach(function (a) { var o = document.createElement('option'); o.value = a; list.appendChild(o); }); };
    city.addEventListener('change', fill); fill();
  })();
</script>
</body></html>
