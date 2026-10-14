<?php
/* POP-UP LEAD FORM — any link or button with data-open-lead opens this instead of leaving the page
   (site.js). Without JavaScript the link simply goes to its href (the contact page).
   Switch off with LEAD_DIALOG = false in config.php. */
if (!LEAD_DIALOG || ($page['header'] ?? '') === 'none') return;
?>
<dialog class="lead-dialog" id="lead-dialog" aria-label="Request a free consultation">
  <button class="lead-dialog__close" type="button" aria-label="Close" data-close-lead>×</button>
  <?= component('lead-form', ['variant' => 'compact', 'id' => 'popup', 'title' => 'Book a free consultation', 'text' => 'Tell us where to reach you and a designer will call to understand your home.']) ?>
</dialog>
