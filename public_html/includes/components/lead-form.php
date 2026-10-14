<?php
/* =====================================================================
   LEAD FORMS — five forms, one file. Options and wording: config.php → LEADS.
   Every form asks for the same four details (name, mobile, email, city / area), has a captcha and
   verifies the visitor's email (a 6-digit code or a one-click link) before anything is sent to
   LEADS['notify_emails']. Engine: includes/verify.php · handler: api/lead.php · script: site.js.
   Built to fit one phone screen: short labels, two columns, no long text boxes.

     component('lead-form', ['variant' => 'full'])      1. dark section: pitch + ticks + form   (home, contact, pillars, tools)
     component('lead-form', ['variant' => 'compact'])   2. card: + home type                    (blog posts, the pop-up)
     component('lead-form', ['variant' => 'inline'])    3. one-row strip                        (under a hero, between sections)
     component('lead-form', ['variant' => 'callback'])  4. "call me back": + time slot          (contact, cost pages)
     component('lead-form', ['variant' => 'quote'])     5. "get 3 quotes": + home type, budget  (services, city pages)

   Options: id (unique on the page), title, text, button, eyebrow, heading (full only), flush (no top margin)
   Daily limits per person: config.php → FORM_LIMITS (consultation forms 5, get 3 quotes 3).
   ===================================================================== */
$variant = $p['variant'] ?? 'compact';
$id      = $p['id'] ?? ('lead-' . $variant);
$opts    = fn($list, $ph) => '<option value="">' . e($ph) . '</option>' . implode('', array_map(fn($o) => '<option>' . e($o) . '</option>', $list));
$sel     = fn($name, $label, $list, $ph) => vfield($id, $name, $label, '<select class="input" id="' . $id . '-' . $name . '" name="' . $name . '">' . $opts($list, $ph) . '</select>');

$extra = [   // each form's own (optional) fields
  'full'     => $sel('home', 'Home', LEADS['home_types'], 'Home type') . $sel('service', 'Need', LEADS['services'], 'What do you need?'),
  'compact'  => $sel('home', 'Home', LEADS['home_types'], 'Home type'),
  'inline'   => '',
  'callback' => $sel('call_slot', 'Call me', LEADS['call_slots'], 'Best time'),
  'quote'    => $sel('home', 'Home', LEADS['home_types'], 'Home type') . $sel('budget', 'Budget', LEADS['budgets'], 'Budget'),
];
$defaults = [   // variant => [title, button]
  'full'     => ['Book your free consultation', 'Send →'],
  'compact'  => ['Get a free call back', 'Request call back →'],
  'inline'   => ['Talk to an interior expert', 'Call me back →'],
  'callback' => ['Request a call back', 'Call me back →'],
  'quote'    => ['Get 3 quotes from verified designers', 'Get my 3 quotes →'],
];
[$defTitle, $defButton] = $defaults[$variant] ?? $defaults['compact'];
$title = $p['title'] ?? $defTitle;
$note  = '<p class="form__note">We email you a code to confirm it is you. By sending, you agree we may contact you about this request' . ($variant === 'quote' ? ' and share it with up to 3 designers' : '') . '. <a href="/privacy/">Privacy</a></p>';

$form = '<div class="vform vform--' . e($variant) . '" data-vform' . track_form_attrs($id, $variant) . '>'
      . '<form class="form lead-form lead-form--' . e($variant) . '" id="' . e($id) . '-form" data-step="details" method="post" action="' . e(LEADS['endpoint']) . '" data-lead-form>'
      . ($variant === 'inline' ? '' : '<p class="form__title">' . e($title) . '</p>')
      . (!empty($p['text']) && !in_array($variant, ['full', 'inline']) ? '<p class="form__text">' . e($p['text']) . '</p>' : '')
      . '<div class="form__grid">' . vfields_core($id) . $extra[$variant] . '</div>'
      . '<div class="form__send">' . captcha_field($id) . '<button class="btn btn--primary btn--block" type="submit">' . e($p['button'] ?? $defButton) . '</button></div>'
      . lead_hidden_fields($variant)
      . $note
      . '</form>'
      . verify_steps($id)
      . '</div>';

if ($variant === 'full'): ?>
<section class="section section--dark" id="<?= e($id) ?>">
  <div class="container lead">
    <div class="lead__pitch">
      <span class="eyebrow"><?= e($p['eyebrow'] ?? 'Free consultation') ?></span>
      <h2 class="section-title mt-4"><?= $p['heading'] ?? "Let's plan your<br>dream home <em>together.</em>" ?></h2>
      <p class="subheading mt-4"><?= e($p['text'] ?? 'Talk to a verified interior designer. Get material recommendations and a detailed cost estimate — no obligation.') ?></p>
    </div>
    <div class="lead__form"><?= $form ?></div>
    <div class="lead__trust">
      <ul class="ticks"><?php foreach (LEADS['trust'] as $t0) echo '<li>' . e($t0) . '</li>'; ?></ul>
<?php if (NAP['phone'] || NAP['email']): ?>
      <div class="mt-6"><?= component('nap', ['compact' => true]) ?></div>
<?php endif; ?>
    </div>
  </div>
</section>
<?php elseif ($variant === 'inline'): ?>
<div class="lead-strip" id="<?= e($id) ?>">
  <div class="lead-strip__text"><strong><?= e($title) ?></strong><?php if (!empty($p['text'])): ?><span><?= e($p['text']) ?></span><?php endif; ?></div>
  <?= $form ?>
</div>
<?php else: ?>
<div class="lead-card lead-card--<?= e($variant) ?><?= empty($p['flush']) ? ' mt-8' : '' ?>" id="<?= e($id) ?>"><?= $form ?></div>
<?php endif;
