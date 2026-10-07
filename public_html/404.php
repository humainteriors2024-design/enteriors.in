<?php
http_response_code(404);
$page = ['type' => 'page', 'title' => 'Page not found', 'noindex' => true,
  'description' => "The page you were looking for has moved or doesn't exist. Start from one of the Enteriors knowledge hubs below."];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section container">
  <span class="eyebrow">Error 404</span>
  <h1 class="mt-4">This page doesn't exist</h1>
  <p class="lede mt-4 mb-6">It may have moved. Try one of the hubs:</p>
  <div class="grid grid--lined grid--sm">
    <?php foreach ($HUBS as $h0) echo card($h0['href'], $h0['label'], $h0['blurb'], '', $h0['icon']); ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
