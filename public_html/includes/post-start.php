<?php
/* =====================================================================
   TOP OF EVERY BLOG POST — makes all posts uniform.
   A post file (/blogs/<slug>.php) is only:

     <?php
     $post = [ 'quick_answer' => '…', 'faq' => [...], 'related' => [...] ];   // optional extras
     require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-start.php';
     ?>
       …the article: <h2>, <p>, tables, <?= img('file-name') ?> …
     <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-end.php'; ?>

   Title, description, category, date, image folder and hero alt come from
   includes/posts-data.php. Every post then gets, in the same order:
   breadcrumbs → category → title → author, date, reading time → hero image →
   quick answer → contents → article (with one CTA strip mid-way) → link to its
   pillar → FAQ → calculator CTA → call-back form → related → author → share.
   ===================================================================== */
require_once __DIR__ . '/site.php';

$slug = basename(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file'] ?? $_SERVER['SCRIPT_FILENAME'], '.php');
$meta = $POSTS[$slug] ?? null;
if (!$meta || (!empty($meta['draft']) && !is_staging())) {   // not in posts-data.php (or a draft on the live site)
  http_response_code(404);
  require $_SERVER['DOCUMENT_ROOT'] . '/404.php';
  exit;
}
$page = array_merge([
  'type'      => 'post',
  'crumb'     => $meta['title'],
  'eyebrow'   => $meta['category'] . (!empty($meta['location']) ? ' · ' . $meta['location'] : ''),
  'lede'      => $meta['description'],
  'published' => $meta['date'],
  'updated'   => $meta['updated'] ?? $meta['date'],
], $meta, $post ?? []);
require __DIR__ . '/head.php';
