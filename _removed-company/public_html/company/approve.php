<?php
/* ONE-CLICK APPROVAL — /company/approve.php?k=<key>&a=approve|reject&ts=…&s=…
   The links are emailed to LEADS['notify_email'] when a firm registers, claims a listing or edits a
   pending profile. Each link is signed with LEADS['secret'] and works for 30 days. The page asks
   for one confirming click (so link scanners in mail apps cannot approve anything by opening it). */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/site.php';
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
$g = fn($k) => is_scalar($_REQUEST[$k] ?? null) ? (string) $_REQUEST[$k] : '';
[$key, $act, $ts, $sig] = [$g('k'), $g('a'), $g('ts'), $g('s')];
$rec = company_load($key);
$ok = $rec && company_approve_ok($key, $act, $ts, $sig);
$done = '';
if ($ok && $_SERVER['REQUEST_METHOD'] === 'POST' && same_site_request()) {
  $rec['status'] = $act === 'approve' ? 'approved' : 'rejected';
  $rec['log'] = array_slice(array_merge($rec['log'] ?? [], [[date('c'), $rec['status'] . ' (email link)', $_SERVER['REMOTE_ADDR'] ?? '']]), -20);
  company_save($key, $rec);
  if ($rec['status'] === 'approved') site_mail($rec['email'], 'Your company profile on ' . SITE['name'] . ' is approved',
    "Good news: your company account for " . ($rec['data']['name'] ?? '') . " is approved.\n\nSign in any time at " . SITE['url'] . COMPANY['url'] . " to update your details.\n\n— " . SITE['name'] . "\n");
  $done = $rec['status'];
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Company approval</title>
<style>body{font:16px/1.5 system-ui,sans-serif;max-width:640px;margin:3rem auto;padding:0 1rem;color:#111}dl{display:grid;grid-template-columns:11rem 1fr;gap:.3rem 1rem}dt{color:#666}button{font:inherit;padding:.6rem 1.2rem;border-radius:4px;border:0;background:#C8102E;color:#fff;cursor:pointer}.reject{background:#444}</style></head><body>
<?php if (!$ok): ?>
<h1>Link not valid</h1><p>This approval link is wrong or older than 30 days. Use <a href="/admin/companies.php">/admin/companies.php</a> instead.</p>
<?php elseif ($done): ?>
<h1><?= $done === 'approved' ? 'Approved' : 'Rejected' ?></h1><p><?= e($rec['data']['name'] ?? $key) ?> is now <strong><?= e($done) ?></strong>.</p>
<?php else: ?>
<h1><?= $act === 'approve' ? 'Approve' : 'Reject' ?> this company?</h1>
<dl><dt>Company</dt><dd><?= e($rec['data']['name'] ?? '') ?></dd><dt>Email (verified)</dt><dd><?= e($rec['email']) ?></dd>
<dt>Type</dt><dd><?= $rec['claim'] ? 'Claim of listing ' . e($rec['claim']) : 'New registration' ?></dd>
<?php foreach (['office_city' => 'City', 'office_area' => 'Area', 'office_pincode' => 'Pincode', 'gst' => 'GSTIN', 'website' => 'Website'] as $f => $l) if (!empty($rec['data'][$f])) echo '<dt>' . $l . '</dt><dd>' . e($f === 'office_city' ? city_name($rec['data'][$f]) : $rec['data'][$f]) . '</dd>'; ?>
<dt>Current status</dt><dd><?= e($rec['status']) ?></dd></dl>
<p>Check the GSTIN on the GST portal and the website before approving.</p>
<form method="post"><input type="hidden" name="k" value="<?= e($key) ?>"><input type="hidden" name="a" value="<?= e($act) ?>"><input type="hidden" name="ts" value="<?= e($ts) ?>"><input type="hidden" name="s" value="<?= e($sig) ?>">
<button class="<?= $act === 'reject' ? 'reject' : '' ?>" type="submit"><?= $act === 'approve' ? 'Yes, approve' : 'Yes, reject' ?></button></form>
<?php endif; ?>
</body></html>
