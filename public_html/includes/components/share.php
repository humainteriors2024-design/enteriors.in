<?php
/* SHARE BUTTONS — real page URL written in by PHP (no JavaScript). Facebook and Email only (Oct 2026: the site links to no other networks). */
$u = rawurlencode(SITE['url'] . current_path()); $t = rawurlencode($page['title']);
$links = [
  'Facebook'  => ["https://www.facebook.com/sharer/sharer.php?u=$u", 'M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7A10 10 0 0022 12z'],
  'Email'     => ["mailto:?subject=$t&body=$u", 'M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'],
];
?>
<div class="share" aria-label="Share this page">
<?php foreach ($links as $name => [$href, $d]): ?>
  <a href="<?= e($href) ?>" target="_blank" rel="noopener" aria-label="Share on <?= $name ?>"><svg viewBox="0 0 24 24"><path d="<?= $d ?>"/></svg></a>
<?php endforeach; ?>
</div>
