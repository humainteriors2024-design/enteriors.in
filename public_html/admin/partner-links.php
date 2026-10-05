<?php
/* =====================================================================
   PARTNER LINK CHECK — /admin/partner-links.php   (same login as /admin/)
   1. Opens every humainteriors.com address in config.php → PARTNER['pages'] from the server
      and shows whether it answers (200) or is broken / redirected.
   2. Counts the links to humainteriors.com on this site, followed and nofollow, page by page,
      by reading the page files (blog posts, guides and the automatic partner box).
   Fix a broken address in config.php → PARTNER['pages'] and every link on the site follows.
   ===================================================================== */
require __DIR__ . '/../includes/admin-auth.php';

function check_url($url) {
  if (!function_exists('curl_init')) return ['?', 'curl not available on this server', ''];
  $ch = curl_init($url);
  curl_setopt_array($ch, [CURLOPT_NOBODY => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => false, CURLOPT_TIMEOUT => 12,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; EnteriorsLinkCheck/1.0; +' . SITE['url'] . ')']);
  curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
  $loc  = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
  $err  = curl_error($ch);
  curl_close($ch);
  return [$code ?: '—', $err, $loc];
}

$rows = [];
foreach (array_unique(PARTNER['pages']) as $url) $rows[$url] = check_url($url);

// Hand-written links in page files: huma('key', 'words') and huma('key', 'words', follow: false)
$root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
$uses = [];
foreach ($it as $f) {
  if ($f->getExtension() !== 'php' || preg_match('#/(includes|admin|_templates|api)/#', $f->getPathname())) continue;
  $src = file_get_contents($f->getPathname());
  if (!preg_match_all("#huma\('([a-z0-9_]+)',\s*'((?:[^'\\\\]|\\\\.)*)'([^)]*)\)#", $src, $m, PREG_SET_ORDER)) continue;
  foreach ($m as $x) $uses[] = [str_replace($root, '', $f->getPathname()), $x[1], stripslashes($x[2]), str_contains($x[3], 'false') ? 'nofollow' : 'follow'];
}
$follow = count(array_filter($uses, fn($u) => $u[3] === 'follow'));
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
<title>Partner links | <?= e(SITE['name']) ?></title>
<style>
  body { font: 15px/1.5 system-ui, -apple-system, 'Segoe UI', sans-serif; color: #111; margin: 0; background: #f6f5f3; }
  header { background: #111; color: #fff; padding: 1rem 1.25rem; } header a { color: #fff; }
  main { max-width: 1100px; margin: 0 auto; padding: 1.25rem; display: grid; gap: 1.25rem; }
  section { background: #fff; border: 1px solid #e5e5e5; border-radius: 10px; padding: 1rem 1.25rem; overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 14px; } th, td { text-align: left; padding: .4rem .5rem; border-bottom: 1px solid #e5e5e5; vertical-align: top; }
  .ok { color: #1E7B4F; font-weight: 700; } .bad { color: #C8102E; font-weight: 700; } .muted { color: #666; }
</style></head>
<body>
<header><strong><?= e(SITE['name']) ?> · Partner links (<?= e(PARTNER['name']) ?>)</strong> · <a href="/admin/">Reports</a> · <a href="/admin/images.php">Images</a></header>
<main>
  <section>
    <h2>Addresses on <?= e(parse_url(PARTNER['url'], PHP_URL_HOST)) ?></h2>
    <p class="muted">Edit them in <code>includes/config.php → PARTNER['pages']</code>. 200 = fine. 301/302 = the page moved: put the new address in config. 404 = broken.</p>
    <table><thead><tr><th>Used for</th><th>Address</th><th>Status</th></tr></thead><tbody>
<?php foreach (PARTNER['pages'] as $key => $url): [$code, $err, $loc] = $rows[$url]; ?>
      <tr><td><?= e($key) ?></td><td><a href="<?= e($url) ?>" target="_blank" rel="noopener"><?= e($url) ?></a></td>
        <td class="<?= $code == 200 ? 'ok' : 'bad' ?>"><?= e($code) ?><?= $loc ? ' → ' . e($loc) : '' ?><?= $err ? ' · ' . e($err) : '' ?></td></tr>
<?php endforeach; ?>
    </tbody></table>
  </section>
  <section>
    <h2>Links written into pages: <?= count($uses) ?> (<?= $follow ?> followed, <?= count($uses) - $follow ?> nofollow)</h2>
    <p class="muted">Plus the automatic partner box on every guide and post (followed on kitchen, wardrobe, living, cost and local pages except one in three; nofollow elsewhere), the home page section and the footer line (nofollow).</p>
    <table><thead><tr><th>Page file</th><th>Points to</th><th>Linked words</th><th>Type</th></tr></thead><tbody>
<?php foreach ($uses as [$file, $key, $words, $type]): ?>
      <tr><td><?= e($file) ?></td><td><?= e($key) ?></td><td><?= e($words) ?></td><td><?= e($type) ?></td></tr>
<?php endforeach; ?>
    </tbody></table>
  </section>
</main>
</body></html>
