<?php
/* Fresh form key for a form that has been open a long time (called by site.js when the
   visitor starts typing). Keeps "maximum key age" from ever blocking a real person. */
require __DIR__ . '/../includes/site.php';
header('Content-Type: application/json');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');
$form = preg_replace('/[^a-z0-9\-]/', '', strtolower((string) ($_GET['form'] ?? '')));
if ($form === '' || !same_site_request()) { http_response_code(400); echo json_encode(['ok' => false]); exit; }
echo json_encode(['ok' => true, 'fk' => lead_key($form)]);
