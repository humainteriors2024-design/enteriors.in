<?php
/* TERMS OF USE — /terms/  (linked from the footer, includes/nav.php → $LEGAL_LINKS)
   TODO: have this checked by your lawyer and add your registered business details. */
$page = [
  'type'        => 'page',
  'title'       => 'Terms of Use',
  'crumb'       => 'Terms',
  'description' => 'Terms of use for Enteriors: how our guides, prices and calculators may be used, how consultations and referrals work, and the limits of our responsibility.',
  'updated'     => '2026-10-05',
];
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<header class="page-header">
  <div class="container">
    <?= component('breadcrumbs') ?>
    <span class="eyebrow mt-6">Legal</span>
    <h1>Terms of use</h1>
    <p class="subheading">Last updated <?= e(nice_date($page['updated'])) ?>. By using <?= e(parse_url(SITE['url'], PHP_URL_HOST)) ?> you agree to these terms.</p>
  </div>
</header>

<section class="section section--tight">
  <div class="container container--text prose">
    <h2>1. What this site is</h2>
    <p><?= e(SITE['name']) ?> publishes guides, price ranges and calculators about home interiors in India, and offers free consultations and referrals to interior designers. We do not manufacture or install interiors ourselves.</p>

    <h2>2. Information, prices and calculators</h2>
    <ul>
      <li>Content is general information for planning, not professional, structural, electrical or legal advice for your specific home.</li>
      <li>Prices are indicative ranges for Bengaluru unless stated, reviewed on the date shown on each page. Actual quotations depend on site conditions, specification, brand and market rates, and can differ.</li>
      <li>Calculator results are estimates based on published rates and your inputs. They are not quotations or offers.</li>
      <li>Vastu content describes traditional preferences, not building rules or scientific claims.</li>
    </ul>

    <h2>3. Consultations and referrals</h2>
    <ul>
      <li>Consultations and referrals are free for homeowners and do not oblige you to hire anyone.</li>
      <li>With your consent, we share your enquiry with up to three designers, or with our execution partner, Huma Interiors, for homes in South-East Bengaluru. See our <a href="/privacy/">privacy policy</a> and <a href="/partners/huma-interiors/">how we work with Huma Interiors</a>.</li>
      <li>Any contract for design or execution is between you and the firm you choose. Its quotation, timeline, warranty and terms are that firm's responsibility.</li>
      <li>We may receive a fee from firms for referrals; it is never added to your quotation as a separate charge.</li>
    </ul>

    <h2>4. Links to other websites</h2>
    <p>We link to manufacturers, standards bodies, our execution partner and other sites for reference. We are not responsible for their content or practices.</p>

    <h2>5. Intellectual property</h2>
    <p>Text, tables, illustrations and calculators on this site are owned by <?= e(NAP['legal_name'] ?: SITE['name']) ?> unless stated. You may quote short extracts with a link to the source page. Do not copy pages or images wholesale.</p>

    <h2>6. Acceptable use</h2>
    <p>Do not misuse forms, submit false information, attempt to break the site's security, or scrape content in bulk.</p>

    <h2>7. Limitation of liability</h2>
    <p>To the extent allowed by law, we are not liable for losses arising from reliance on general information, estimates or third-party work. Nothing in these terms limits rights you have under consumer protection law.</p>

    <h2>8. Changes and contact</h2>
    <p>We may update these terms; the date above shows the latest version. Questions: <a href="mailto:<?= e(NAP['email']) ?>"><?= e(NAP['email']) ?></a>.</p>
  </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
