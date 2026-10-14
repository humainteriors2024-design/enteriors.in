<?php
/* PRIVACY POLICY — a working draft that matches what this website actually collects
   (see api/lead.php and includes/tracking.php).
   TODO: have it checked against the Digital Personal Data Protection Act before launch, fill in how long
   you keep enquiries, and update it whenever you add a tracking tool or change what the forms ask. */
$page = ['type' => 'page', 'title' => 'Privacy Policy', 'crumb' => 'Privacy', 'updated' => '2026-10-14',
  'description' => 'How Enteriors collects, uses, shares and deletes the personal details you submit through our enquiry forms and calculators, and how to contact us about them.'];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
$tools = array_filter(['Google Analytics' => TRACKING['ga4'] || TRACKING['gtm'], 'Google Ads' => TRACKING['google_ads'], 'Meta Pixel' => TRACKING['meta_pixel'], 'Microsoft Clarity' => TRACKING['clarity']]);
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">Privacy</span>
    <h1>Privacy policy</h1>
    <p class="subheading">What we collect when you use this website, why, and how to have it removed.</p>
  </div>
</header>
<section class="section section--tight">
  <div class="container container--text prose">
    <p>Last updated: <?= nice_date($page['updated']) ?>.</p>
    <h2>What we collect</h2>
    <ul>
      <li><strong>Details you type into a form:</strong> your name, mobile number, email address and city or area (every form asks for these four), and, where the form asks, your home type, the work you are planning, budget, preferred time for a call and any message.</li>
      <li><strong>Email verification:</strong> before a form is sent we email you a one-time code and a link to confirm the address is yours. We keep a record that it was verified, not the code.</li>
      <li><strong>Details sent with the form automatically:</strong> the page you sent it from, the advertisement or campaign link you arrived through (if any), your IP address, and the date and time.</li>
      <li><strong>Calculator estimates:</strong> the calculators run in your browser. An estimate reaches us only if you send an enquiry from that page, in which case a one-line summary is attached to it.</li>
    </ul>
    <h2>Why we collect it</h2>
    <p>To call or message you about your enquiry, to prepare advice or a quotation, and to protect the forms from spam and misuse. The IP address, email and mobile number are also counted (on our server, not in your browser) to limit how many requests one person can send per day.</p>
<?php if (captcha_mode() === 'turnstile'): ?>
    <p>The forms use Cloudflare Turnstile to tell people from bots. Cloudflare processes technical details of your browser for that check only, under its own privacy policy.</p>
<?php endif; ?>
    <h2>Who sees it</h2>
    <p>Our own team. If you contact a designer or firm listed on this site, we pass your enquiry to that firm. If you ask us to arrange quotations, we share your enquiry with up to three interior designers, and only for that purpose. We do not sell personal details.</p>
    <h2>Cookies and measurement</h2>
<?php if ($tools): ?>
    <p>We use <?= e(implode(', ', array_keys($tools))) ?> to understand which pages are useful and whether our advertising works. These tools set cookies or similar identifiers in your browser. You can block them in your browser settings without losing access to any page.</p>
<?php else: ?>
    <p>This website does not currently use analytics or advertising cookies. If that changes, this page will be updated first.</p>
<?php endif; ?>
    <h2>How long we keep it</h2>
    <p>Enquiries are kept for as long as we are in touch about your project and for a reasonable period afterwards, then deleted. <!-- TODO: state your period, e.g. "24 months" --></p>
    <h2>Your choices</h2>
    <p>You can ask to see, correct or delete the details we hold about you, or tell us to stop contacting you, at any time<?php if (NAP['email']): ?> by writing to <a href="mailto:<?= e(NAP['email']) ?>"><?= e(NAP['email']) ?></a><?php endif; ?>. We will act on the request and confirm when it is done.</p>
    <h2>Contact</h2>
    <?= component('nap') ?>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
