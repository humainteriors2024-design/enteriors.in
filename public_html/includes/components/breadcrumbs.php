<?php
/* BREADCRUMBS — built from the URL; labels from nav.php. Schema is added by schema.php.
   Use: component('breadcrumbs', ['crumbs' => crumbs($page)]) */
$c = $p['crumbs'] ?? crumbs($page);
if (count($c) < 2) return;
?>
<nav class="breadcrumbs" aria-label="Breadcrumb">
  <ol>
<?php foreach ($c as $i => $x): ?>
    <li><?= $i < count($c) - 1 ? '<a href="' . e($x['url']) . '">' . e($x['name']) . '</a>' : '<span aria-current="page">' . e($x['name']) . '</span>' ?></li>
<?php endforeach; ?>
  </ol>
</nav>
