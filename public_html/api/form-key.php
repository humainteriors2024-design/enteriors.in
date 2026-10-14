<?php
/* Fresh form key (and, with &captcha=1, a fresh built-in captcha) for a form that has been open a long
   time or whose captcha was used. Called by site.js. Keeps "maximum key age" from blocking a real person. */
require __DIR__ . '/../includes/site.php';
header('Content-Type: application/json');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');
$form = preg_replace('/[^a-z0-9\-]/', '', strtolower((string) ($_GET['form'] ?? '')));
if ($form === '' || !same_site_request()) { http_response_code(400); echo json_encode(['ok' => false]); exit; }
$out = ['ok' => true, 'fk' => lead_key($form)];
if (!empty($_GET['captcha']) && captcha_mode() === 'builtin') { [$t, $svg] = captcha_new(); $out['captcha'] = ['token' => $t, 'svg' => $svg]; }
echo json_encode($out, JSON_UNESCAPED_SLASHES);
