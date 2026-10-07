<?php
/* =====================================================================
   IMAGE UPLOADER — /admin/images.php   (same login as /admin/)
   Lists every page and blog post with the image slots its text asks for (hero + every img('…')),
   shows which are filled, and lets you upload a photo into any slot from the browser:
     • any JPG, PNG or WebP up to 15 MB, straight from a phone or camera
     • it is rotated upright, resized (max 2000 px wide, hero 2400 px), stripped of camera/GPS data,
       saved under the slot's file name as .jpg AND .webp (browsers get the smaller WebP)
     • the page shows it immediately: alt text and caption come from the page itself
   Nothing to configure. Without GD on the server, files are saved as uploaded (no resize/WebP).
   ===================================================================== */
require __DIR__ . '/../includes/admin-auth.php';
$root = rtrim($_SERVER['DOCUMENT_ROOT'] ?: dirname(__DIR__), '/');

/* ---------- every page and its slots ---------- */
function admin_pages($root) {
  global $POSTS;
  $out = [];
  $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
  foreach ($it as $f) {
    if ($f->getFilename() !== 'index.php') continue;
    $rel = str_replace('\\', '/', substr($f->getPath(), strlen($root)));
    if (preg_match('#^/(includes|assets|api|admin|_templates|style-guide|thank-you)(/|$)#', $rel)) continue;
    $src = file_get_contents($f->getPathname());
    $title = preg_match("#'title'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'#", $src, $m) ? stripslashes($m[1]) : ($rel ?: 'Home');
    $alt = preg_match("#'hero_alt'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'#", $src, $m) ? stripslashes($m[1]) : null;
    $url = ($rel ?: '') . '/';
    $out[$url] = ['url' => $url, 'title' => $title, 'dir' => MEDIA['page_dir'] . '/' . (trim($rel, '/') ?: 'home'), 'slots' => media_slots($src, ['title' => $title, 'hero_alt' => $alt])];
  }
  foreach ($POSTS as $slug => $p) {
    $file = "$root/blogs/$slug.php";
    if (!is_file($file)) continue;
    $out["/blogs/$slug/"] = ['url' => "/blogs/$slug/", 'title' => $p['title'], 'dir' => MEDIA['blog_dir'] . '/' . ($p['folder'] ?? $slug),
                             'slots' => media_slots(file_get_contents($file), $p)];
  }
  // Interior designer directory: one optional image per firm, shown on every page that lists the firm
  $db = designers_db(); $slots = [];
  foreach ($db['firms'] as $k => $f) $slots[$f['image'] ?? $k] = $f['name'] . ' (firm card image)';
  $out['/interior-designers/'] = ['url' => '/interior-designer-near-me/', 'title' => 'Interior designer directory: firm images', 'dir' => $db['img_dir'], 'slots' => $slots];
  ksort($out);
  return $out;
}
$pages = admin_pages($root);
$dirs = array_column($pages, null, 'dir');

/* ---------- upload ---------- */
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dir = (string) ($_POST['dir'] ?? ''); $slot = (string) ($_POST['slot'] ?? '');
  $f = $_FILES['photo'] ?? null;
  $back = '?dir=' . rawurlencode($dir);
  try {
    if (!admin_token_ok($_POST['token'] ?? '')) throw new Exception('Form expired, please reload the page.');
    if (!isset($dirs[$dir]) || !preg_match('/^[a-z0-9\-]{2,80}$/', $slot) || !isset($dirs[$dir]['slots'][$slot])) throw new Exception('Unknown page or image slot.');
    if (!$f || $f['error'] !== UPLOAD_ERR_OK) throw new Exception('Upload failed (error ' . ($f['error'] ?? '?') . '). The file may be larger than the server allows.');
    if ($f['size'] > 15 * 1024 * 1024) throw new Exception('Please use an image under 15 MB.');
    $info = @getimagesize($f['tmp_name']);
    $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
    if (!$info || !isset($types[$info[2]])) throw new Exception('That is not a JPG, PNG or WebP image.');
    $abs = $root . $dir;
    if (!is_dir($abs) && !@mkdir($abs, 0755, true)) throw new Exception('Could not create the folder ' . $dir);
    foreach (glob($abs . '/*') as $old) if (media_key(pathinfo($old, PATHINFO_FILENAME)) === $slot && in_array(strtolower(pathinfo($old, PATHINFO_EXTENSION)), MEDIA['images'])) @unlink($old);
    $saved = admin_save_image($f['tmp_name'], $info, $types[$info[2]], "$abs/$slot", $slot === MEDIA['hero_name'] ? 2400 : 2000);
    $msg = 'ok:Saved ' . implode(' + ', $saved) . ' in ' . $dir;
  } catch (Exception $ex) { $msg = 'err:' . $ex->getMessage(); }
  header('Location: images.php' . $back . '&msg=' . rawurlencode($msg) . '#slot-' . $slot, true, 303); exit;
}

// Re-encode (strips camera and GPS data), turn upright, resize, write .jpg/.png + .webp. Returns the file names written.
function admin_save_image($tmp, $info, $ext, $base, $maxW) {
  if (!function_exists('imagecreatetruecolor')) { move_uploaded_file($tmp, "$base.$ext"); return [basename("$base.$ext")]; }
  $img = match ($info[2]) { IMAGETYPE_JPEG => imagecreatefromjpeg($tmp), IMAGETYPE_PNG => imagecreatefrompng($tmp), IMAGETYPE_WEBP => imagecreatefromwebp($tmp) };
  if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data') && ($o = @exif_read_data($tmp)['Orientation'] ?? 1) > 1)
    $img = match ((int) $o) { 3 => imagerotate($img, 180, 0), 6 => imagerotate($img, -90, 0), 8 => imagerotate($img, 90, 0), default => $img };
  $w = imagesx($img); $h = imagesy($img);
  if ($w > $maxW) { $img = imagescale($img, $maxW, (int) round($h * $maxW / $w), IMG_BICUBIC); }
  $alpha = $info[2] === IMAGETYPE_PNG && (imagecolortransparent($img) >= 0 || (imagecolorat($img, 0, 0) >> 24) > 0);
  $files = [];
  if ($alpha) { imagesavealpha($img, true); imagepng($img, "$base.png", 8); $files[] = basename("$base.png"); }
  else { imageinterlace($img, true); imagejpeg($img, "$base.jpg", 82); $files[] = basename("$base.jpg"); }
  if (function_exists('imagewebp')) { if ($alpha) imagesavealpha($img, true); imagewebp($img, "$base.webp", 80); $files[] = basename("$base.webp"); }
  imagedestroy($img);
  return $files;
}

/* ---------- view ---------- */
$only = (string) ($_GET['dir'] ?? '');
$q = trim((string) ($_GET['q'] ?? ''));
$missingOnly = !empty($_GET['missing']);
$total = 0; $filled = 0;
foreach ($pages as $p) foreach ($p['slots'] as $s => $_) { $total++; if (media_find($s, $p['dir'])) $filled++; }
[$type, $text] = array_pad(explode(':', (string) ($_GET['msg'] ?? ''), 2), 2, '');
$token = admin_token();
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
<title>Images | <?= e(SITE['name']) ?></title>
<style>
  :root { --red: #C8102E; --ink: #111; --line: #e5e5e5; --muted: #666; --ok: #1E7B4F; --warn: #9A6300; }
  body { font: 15px/1.5 system-ui, -apple-system, 'Segoe UI', sans-serif; color: var(--ink); margin: 0; background: #f6f5f3; }
  header { background: var(--ink); color: #fff; padding: 1rem 1.25rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between; }
  header a { color: #fff; } h1 { font-size: 1.15rem; margin: 0; }
  main { max-width: 1100px; margin: 0 auto; padding: 1.25rem; }
  form.filter { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1rem; } form.filter input[type=search] { flex: 1; min-width: 200px; padding: .5rem; font-size: 1rem; }
  .bar { height: 8px; background: var(--line); border-radius: 4px; overflow: hidden; margin: .25rem 0 1rem; } .bar span { display: block; height: 100%; background: var(--ok); }
  .msg { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; } .msg.ok { background: #EDF7F1; color: var(--ok); } .msg.err { background: #FDF0F2; color: var(--red); }
  .page { background: #fff; border: 1px solid var(--line); border-radius: 10px; margin-bottom: 1rem; }
  .page > summary { padding: .9rem 1.1rem; cursor: pointer; display: flex; gap: .75rem; align-items: baseline; flex-wrap: wrap; }
  .page > summary b { flex: 1; } .count { font-size: 13px; color: var(--muted); } .count.done { color: var(--ok); font-weight: 600; }
  .slots { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: .75rem; padding: 0 1.1rem 1.1rem; }
  .slot { border: 1px solid var(--line); border-radius: 8px; padding: .75rem; display: grid; gap: .5rem; align-content: start; }
  .slot.missing { border-style: dashed; border-color: var(--warn); background: #FFFBF3; }
  .slot img { width: 100%; aspect-ratio: 16/10; object-fit: cover; border-radius: 4px; background: #eee; }
  .slot code { font-size: 12px; word-break: break-all; } .slot p { margin: 0; font-size: 13px; color: var(--muted); }
  .slot button { background: var(--red); color: #fff; border: 0; border-radius: 4px; padding: .45rem .8rem; font-weight: 600; cursor: pointer; }
  .slot input[type=file] { font-size: 13px; max-width: 100%; }
</style></head>
<body>
<header>
  <h1><?= e(SITE['name']) ?> · Images<?= is_staging() ? ' · STAGING' : '' ?></h1>
  <nav><a href="/admin/">Reports</a></nav>
</header>
<main>
<?php if ($text): ?><div class="msg <?= $type === 'ok' ? 'ok' : 'err' ?>"><?= e($text) ?></div><?php endif; ?>
  <p><b><?= $filled ?> of <?= $total ?></b> image slots filled across <?= count($pages) ?> pages. Choose a photo for any empty slot and press Upload; it is resized, converted to WebP and named for you.</p>
  <div class="bar"><span style="width:<?= $total ? round($filled * 100 / $total) : 0 ?>%"></span></div>
  <form class="filter" method="get">
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Find a page, e.g. wardrobe or /colour/">
    <label><input type="checkbox" name="missing" value="1"<?= $missingOnly ? ' checked' : '' ?>> Only pages with missing images</label>
    <button>Show</button> <?php if ($only || $q || $missingOnly): ?><a href="images.php">Show all</a><?php endif; ?>
  </form>
<?php foreach ($pages as $p):
  if ($only && $p['dir'] !== $only) continue;
  if ($q !== '' && stripos($p['title'] . ' ' . $p['url'], $q) === false) continue;
  $have = 0; foreach ($p['slots'] as $s => $_) if (media_find($s, $p['dir'])) $have++;
  if ($missingOnly && $have === count($p['slots'])) continue; ?>
  <details class="page"<?= $only ? ' open' : '' ?>>
    <summary><b><?= e($p['title']) ?></b> <a href="<?= e($p['url']) ?>" target="_blank"><?= e($p['url']) ?></a> <span class="count<?= $have === count($p['slots']) ? ' done' : '' ?>"><?= $have ?> / <?= count($p['slots']) ?> images</span></summary>
    <div class="slots">
<?php foreach ($p['slots'] as $slot => $what): $m = media_find($slot, $p['dir']); ?>
      <form class="slot<?= $m ? '' : ' missing' ?>" id="slot-<?= e($slot) ?>" method="post" enctype="multipart/form-data">
        <?php if ($m): ?><img src="<?= e($m['webp'] ?? $m['url']) ?>?t=<?= time() ?>" alt="" loading="lazy"><?php endif; ?>
        <code><?= e($slot) ?></code>
        <p><?= e($what) ?></p>
        <?php if ($m): ?><p><?= (int) $m['w'] ?> × <?= (int) $m['h'] ?> px · <?= e($m['file']) ?></p><?php endif; ?>
        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" required>
        <input type="hidden" name="dir" value="<?= e($p['dir']) ?>"><input type="hidden" name="slot" value="<?= e($slot) ?>"><input type="hidden" name="token" value="<?= e($token) ?>">
        <button><?= $m ? 'Replace' : 'Upload' ?></button>
      </form>
<?php endforeach; ?>
    </div>
  </details>
<?php endforeach; ?>
</main>
</body></html>
