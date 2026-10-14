<?php
/* =====================================================================
   COMPANY ACCOUNTS — /admin/companies.php   (password: config.php → ADMIN)
   Every firm that registered or claimed a listing at /company/: approve, reject or put back to pending,
   and see what they filled in. Approved profiles appear in the directory at once.
   Files: leads/companies/<key>.json (one level above public_html).
   ===================================================================== */
require __DIR__ . '/../includes/admin-auth.php';
$all = company_all();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && admin_token_ok($_POST['t'] ?? '') && isset($all[$_POST['k'] ?? ''])) {
  $k = $_POST['k']; $to = ['approve' => 'approved', 'reject' => 'rejected', 'pending' => 'pending'][$_POST['a'] ?? ''] ?? null;
  if ($to) {
    $r = $all[$k]; $was = $r['status'] ?? ''; $r['status'] = $to;
    $r['log'] = array_slice(array_merge($r['log'] ?? [], [[date('c'), "$to (admin)", $_SERVER['REMOTE_ADDR'] ?? '']]), -20);
    company_save($k, $r);
    if ($to === 'approved' && $was !== 'approved') site_mail($r['email'], 'Your company profile on ' . SITE['name'] . ' is approved',
      "Your company account for " . ($r['data']['name'] ?? '') . " is approved.\n\nSign in any time at " . SITE['url'] . COMPANY['url'] . " to update your details.\n\n— " . SITE['name'] . "\n");
  }
  header('Location: /admin/companies.php', true, 303); exit;
}
uasort($all, fn($a, $b) => [($a['status'] ?? '') !== 'pending', $b['updated'] ?? ''] <=> [($b['status'] ?? '') !== 'pending', $a['updated'] ?? '']);
$F = company_fields();
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Company accounts</title>
<style>body{font:15px/1.5 system-ui,sans-serif;max-width:1100px;margin:2rem auto;padding:0 1rem;color:#111}h1{margin:0 0 1rem}details{border:1px solid #ddd;border-radius:8px;margin:.6rem 0;padding:.6rem 1rem}summary{cursor:pointer;font-weight:600}.st{display:inline-block;padding:1px 8px;border-radius:99px;font-size:12px;margin-left:.5rem}.approved{background:#E5F4E7}.pending{background:#FFF4D6}.rejected{background:#FDEDEE}dl{display:grid;grid-template-columns:14rem 1fr;gap:.2rem 1rem;font-size:14px}dt{color:#666}dd{margin:0;white-space:pre-wrap}form{display:inline}button{font:inherit;padding:.35rem .8rem;margin-right:.3rem;border-radius:4px;border:1px solid #999;background:#fff;cursor:pointer}</style></head><body>
<p><a href="/admin/">← Reports</a></p>
<h1>Company accounts (<?= count($all) ?>)</h1>
<?php if (!$all): ?><p>No firm has registered yet. The sign-in page is <a href="<?= e(COMPANY['url']) ?>"><?= e(COMPANY['url']) ?></a>.</p><?php endif; ?>
<?php foreach ($all as $k => $r): $d = $r['data'] ?? []; $st = $r['status'] ?? 'pending'; ?>
<details<?= $st === 'pending' ? ' open' : '' ?>>
  <summary><?= e($d['name'] ?? $k) ?> <span class="st <?= e($st) ?>"><?= e($st) ?></span> <small style="font-weight:400;color:#666">· <?= e($r['email'] ?? '') ?> · <?= $r['claim'] ? 'claims ' . e($r['claim']) : 'new' ?> · updated <?= e(substr($r['updated'] ?? '', 0, 16)) ?></small></summary>
  <p>
<?php foreach (['approve' => 'Approve', 'reject' => 'Reject', 'pending' => 'Back to pending'] as $a => $l) if (!($a === 'approve' && $st === 'approved') && !($a === 'reject' && $st === 'rejected') && !($a === 'pending' && $st === 'pending')): ?>
    <form method="post"><input type="hidden" name="t" value="<?= e(admin_token()) ?>"><input type="hidden" name="k" value="<?= e($k) ?>"><input type="hidden" name="a" value="<?= $a ?>"><button><?= $l ?></button></form>
<?php endif; ?>
    <?php if ($st === 'approved'): ?><a href="<?= e(pro_url($r['claim'] ?: $k)) ?>" target="_blank">Company page</a><?php endif; ?>
  </p>
  <dl>
<?php foreach ($F as $f => [$label, $type, , $x]) { $v = $d[$f] ?? ''; if ($v === '' || $v === []) continue;
        if ($type === 'multi') $v = implode(', ', array_map(fn($o) => $x['options'][$o] ?? $o, (array) $v));
        elseif (in_array($type, ['select', 'radio'], true)) $v = $x['options'][$v] ?? $v;
        echo '<dt>' . e($label) . '</dt><dd>' . e($v) . '</dd>'; } ?>
  </dl>
</details>
<?php endforeach; ?>
</body></html>
