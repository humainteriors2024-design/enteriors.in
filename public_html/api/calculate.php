<?php
/* =====================================================================
   ENTERIORS — CALCULATOR API. Every calculator on the site posts its choices here
   (assets/js/calc.js) and shows what comes back. Prices: includes/calc/rates.php.

   POST  calc = home | kitchen | wardrobe | quote,  plus the calculator's fields
         page = the page path (for the log)        log = 1 once the visitor has settled on a result
   Reply {ok, total, out: {key: html}, summary, token}
     token = signed copy of the estimate; a lead sent from the page carries it, so the
             estimate in your lead email is the one the server worked out.
   ===================================================================== */
require __DIR__ . '/../includes/site.php';
require_once __DIR__ . '/../includes/calc/engine.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');

$fail = function ($code, $msg) { http_response_code($code); echo json_encode(['ok' => false, 'message' => $msg]); exit; };
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $fail(405, 'POST only');
if (!same_site_request()) $fail(403, 'Use the calculator on our website.');

// Generous limit per IP address (each keystroke is a request): 900 per 10 minutes
$rateFile = leads_dir() . '/calc_rate_' . md5($_SERVER['REMOTE_ADDR'] ?? '') . '.txt';
$hits = array_filter(explode("\n", (string) @file_get_contents($rateFile)), fn($t) => (int) $t > time() - 600);
if (count($hits) >= 900) $fail(429, 'Too many requests. Please wait a minute.');
$hits[] = time();
@file_put_contents($rateFile, implode("\n", $hits), LOCK_EX);

$type = (string) ($_POST['calc'] ?? '');
$res = calc_run($type, $_POST);
if (!$res) $fail(400, 'Unknown calculator.');

$page = preg_match('#^/[a-z0-9/\-]*$#', $_POST['page'] ?? '') ? $_POST['page'] : '/';
if (!empty($_POST['log'])) calc_log($type, $res, rtrim($page, '/') . '/', $_POST['pillar'] ?? '');

echo json_encode(['ok' => true, 'total' => $res['total'], 'out' => $res['out'], 'summary' => $res['summary'], 'token' => calc_token($type, $res)], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
