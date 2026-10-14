<?php
/* SHARE BUTTONS — real page URL written in by PHP (no JavaScript). */
$u = rawurlencode(SITE['url'] . current_path()); $t = rawurlencode($page['title']);
$links = [
  'WhatsApp'  => ["https://api.whatsapp.com/send?text=$t%20$u", 'M12 2a10 10 0 00-8.6 15.1L2 22l4.9-1.3A10 10 0 1012 2zm4.6 12c-.2-.1-1.5-.7-1.7-.8-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1a6.7 6.7 0 01-3.3-2.9c-.2-.3.3-.4.7-1.3.1-.2 0-.4 0-.5l-.8-2c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 00-.7.3 3 3 0 00-.9 2.1c0 1.2.9 2.5 1 2.7a11.4 11.4 0 004.4 3.9c1.6.7 2.3.7 3.1.6.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.2-1.2l-.5-.3z'],
  'Facebook'  => ["https://www.facebook.com/sharer/sharer.php?u=$u", 'M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7A10 10 0 0022 12z'],
  'Pinterest' => ["https://pinterest.com/pin/create/button/?url=$u&description=$t", 'M12 2a10 10 0 00-3.6 19.3c-.1-.8-.2-2 0-2.9l1.2-5s-.3-.6-.3-1.5c0-1.4.8-2.4 1.8-2.4.9 0 1.3.6 1.3 1.4 0 .9-.5 2.1-.8 3.3-.2 1 .5 1.8 1.5 1.8 1.8 0 3-2.3 3-5 0-2-1.4-3.6-3.9-3.6a4.5 4.5 0 00-4.7 4.5c0 .8.3 1.4.6 1.8.2.2.2.3.1.5l-.2.8c-.1.3-.3.3-.5.2-1.4-.6-2-2.1-2-3.8 0-2.8 2.4-6.2 7.1-6.2 3.8 0 6.3 2.8 6.3 5.7 0 3.9-2.2 6.9-5.4 6.9-1.1 0-2.1-.6-2.4-1.3l-.7 2.8c-.3 1-.8 2-1.3 2.8A10 10 0 1012 2z'],
  'Email'     => ["mailto:?subject=$t&body=$u", 'M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'],
];
?>
<div class="share" aria-label="Share this page">
<?php foreach ($links as $name => [$href, $d]): ?>
  <a href="<?= e($href) ?>" target="_blank" rel="noopener" aria-label="Share on <?= $name ?>"><svg viewBox="0 0 24 24"><path d="<?= $d ?>"/></svg></a>
<?php endforeach; ?>
</div>
