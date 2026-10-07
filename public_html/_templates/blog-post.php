<?php
/* =====================================================================
   BLOG POST TEMPLATE — every post has exactly this shape, so all posts look the same.

   1. Add the post to /includes/posts-data.php (title, description, category, folder, hero_alt, date).
      The key you use there is the slug:  'sliding-wardrobe-designs'
   2. Copy this file to /blogs/<slug>.php            →  /blogs/sliding-wardrobe-designs.php
   3. Put the images in /assets/blogs/<slug>/        →  hero.jpg is the main image
   4. Write the article between the two "require" lines and upload the three things.
   The post is then live at  /blogs/<slug>/  and appears on the blog page, the home page
   and its pillar page automatically.

   Added for you, in the same order on every post: breadcrumbs, category, title, author and date,
   reading time, hero image, quick answer, contents list, one call-to-action in the middle,
   link to the pillar guide, FAQ, calculator box, call-back form, related links, author box, share buttons.
   ===================================================================== */
$post = [
  'quick_answer' => 'Two or three sentences that answer the main question directly.',
  'faq' => [
    'A question people ask?' => 'A short, direct answer.',
    'Another question?'      => 'Another short answer.',
  ],
  'related' => [   // exactly three: the pillar guide + two guide pages. Posts never link to other posts.
    ['/wardrobe/', 'Wardrobe design guide', 'Types, sizes and cost', 'Pillar guide'],
    ['/wardrobe/sliding-wardrobe/', 'Sliding wardrobes', 'Tracks, door widths and finishes', 'Wardrobes'],
    ['/cost/wardrobe-cost/', 'Wardrobe cost', 'Price per square foot of front', 'Cost'],
  ],
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-start.php';
?>
<p>Opening paragraph. Say what the reader will get, and link once to the pillar guide, for example our <a href="/wardrobe/">wardrobe design guide</a>.</p>

<h2>First section (each h2 becomes a line in the contents list)</h2>
<p>Text.</p>
<?= img('sliding-wardrobe-with-mirror-shutters', caption: 'Optional caption under the image') ?>

<h2>Second section</h2>
<ul>
  <li><strong>Point.</strong> Explanation.</li>
</ul>

<h2>Third section</h2>
<div class="table-wrap">
<table>
  <thead><tr><th>Option</th><th>Good for</th><th class="num">Cost</th></tr></thead>
  <tbody><tr><td>Name</td><td>Where it works</td><td class="num">₹0–0</td></tr></tbody>
</table>
</div>

<h2>Gallery (optional)</h2>
<?= gallery() ?>   <?php /* every image in the folder except hero; captions come from the file names */ ?>

<h2>Last section</h2>
<p>Close with what to do next and a second link to the <a href="/wardrobe/">pillar guide</a> or a calculator.</p>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/post-end.php'; ?>
