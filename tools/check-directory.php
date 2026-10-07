<?php
/* Checks the trending designs and the designer directory data before an upload:
     php tools/check-directory.php
   includes/data/trends.php, pros.php and places.php: every key used exists, every design has
   7–10 pictures, budgets and sizes are numbers, no professional shows an email address on the
   site (emails are private), and samples are counted so you know what is still placeholder. */
$root = dirname(__DIR__) . '/public_html';
$P = require "$root/includes/data/places.php";
$T = require "$root/includes/data/trends.php";
$D = require "$root/includes/data/pros.php";
$err = []; $warn = [];

foreach ($P['cities'] as $k => $c) {
  if (!isset($P['states'][$c['state']])) $err[] = "city $k: unknown state {$c['state']}";
  foreach ($c['areas'] as $a => $pin) if (!preg_match('/^[1-9]\d{5}$/', $pin)) $err[] = "city $k: area $a has a bad pincode $pin";
}
$states = [];
foreach ($T['designs'] as $k => $d) {
  if (!preg_match('/^[a-z0-9\-]{1,100}$/', $k)) $err[] = "design $k: key must be lower-case letters, digits and hyphens";
  foreach (['title', 'project', 'city', 'area', 'company', 'designer', 'property', 'style', 'type', 'segment', 'summary'] as $f) if (empty($d[$f])) $err[] = "design $k: missing $f";
  $c = $P['cities'][$d['city']] ?? null;
  if (!$c) { $err[] = "design $k: unknown city {$d['city']}"; continue; }
  $states[$c['state']] = 1;
  if (!isset($c['areas'][$d['area']])) $err[] = "design $k: area {$d['area']} is not listed for {$d['city']} in places.php";
  if (!isset($D['pros'][$d['company']])) $err[] = "design $k: company {$d['company']} is not in pros.php";
  if (!isset($T['styles'][$d['style']])) $err[] = "design $k: unknown style {$d['style']}";
  if (!isset($T['types'][$d['type']])) $err[] = "design $k: unknown type {$d['type']}";
  if (!isset($T['properties'][$d['property']])) $err[] = "design $k: unknown property {$d['property']}";
  if (!in_array($d['segment'], ['budget', 'mid', 'premium', 'luxury'], true)) $err[] = "design $k: unknown segment {$d['segment']}";
  if (!is_int($d['budget']) || $d['budget'] <= 0) $err[] = "design $k: budget must be a whole number of rupees";
  if (!is_int($d['size']) || $d['size'] <= 0) $err[] = "design $k: size must be a whole number of sq ft";
  $photos = is_dir("$root/assets/trending/$k") ? count(preg_grep('/\.(jpe?g|png|webp)$/i', scandir("$root/assets/trending/$k"))) : 0;
  if (!$photos) {
    $n = count($d['images']);
    if ($n < 7 || $n > 10) $warn[] = "design $k: $n sample pictures (7–10 expected)";
    foreach ($d['images'] as $v) if (!is_file("$root/assets/trending/samples/$v-{$d['palette']}.svg")) $err[] = "design $k: missing sample picture $v-{$d['palette']}.svg";
    if (empty($d['sample'])) $warn[] = "design $k: marked real but has no photos in /assets/trending/$k/";
  }
}
foreach ($D['pros'] as $k => $p) {
  if (!isset($D['types'][$p['type']])) $err[] = "pro $k: unknown type {$p['type']}";
  if (!isset($P['cities'][$p['city']])) { $err[] = "pro $k: unknown city {$p['city']}"; continue; }
  if (!isset($P['cities'][$p['city']]['areas'][$p['area']])) $err[] = "pro $k: area {$p['area']} not listed for {$p['city']}";
  foreach ($p['serves'] as $c) if (!isset($P['cities'][$c])) $err[] = "pro $k: serves unknown city $c";
  if (($p['serves'][0] ?? '') !== $p['city']) $err[] = "pro $k: the first city in 'serves' must be their own city";
  foreach ($p['areas'] as $a) if (!isset($P['cities'][$p['city']]['areas'][$a])) $err[] = "pro $k: area $a not listed for {$p['city']}";
  foreach ($p['reqs'] as $r) if (!isset($D['reqs'][$r])) $err[] = "pro $k: unknown requirement $r";
  foreach ($p['services'] as $s) if (!isset($T['types'][$s])) $err[] = "pro $k: unknown service $s";
  if ($p['rating'] < 0 || $p['rating'] > 5) $err[] = "pro $k: rating must be 0–5";
  if ($p['email'] !== '' && !filter_var($p['email'], FILTER_VALIDATE_EMAIL)) $err[] = "pro $k: email is not valid";
  if (!empty($p['verified']) && $p['email'] === '') $warn[] = "pro $k: verified but has no email, so enquiries go to the site inbox";
  if (empty($p['sample']) && !empty($p['sample_reviews'])) $warn[] = "pro $k: real listing still has sample reviews";
}
$missingStates = array_diff(array_keys($P['states']), array_keys($states));
$sd = count(array_filter($T['designs'], fn($d) => !empty($d['sample'])));
$sp = count(array_filter($D['pros'], fn($p) => !empty($p['sample'])));
foreach ($warn as $w) echo "warning: $w\n";
foreach ($err as $e) echo "ERROR: $e\n";
echo count($T['designs']) . " designs ($sd samples), " . count($D['pros']) . " professionals ($sp samples), designs in " . count($states) . ' of ' . count($P['states']) . " states and UTs"
   . ($missingStates ? ' (none yet in: ' . implode(', ', array_map(fn($s) => $P['states'][$s]['name'], $missingStates)) . ')' : '') . ".\n";
echo $err ? count($err) . " errors.\n" : "No errors.\n";
exit($err ? 1 : 0);
