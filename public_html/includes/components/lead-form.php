<?php
/* =====================================================================
   LEAD FORMS — five forms, one file. Options and wording: config.php → LEADS.
   Every form posts to LEADS['endpoint'] (api/lead.php) with the hidden security
   fields from includes/leads.php; site.js sends it without reloading the page.

     component('lead-form', ['variant' => 'full'])      1. dark section: pitch + ticks + long form   (home, contact, pillars, tools)
     component('lead-form', ['variant' => 'compact'])   2. card: name, mobile, city, home type        (blog posts, sidebars, pop-up)
     component('lead-form', ['variant' => 'inline'])    3. one-row strip: name + mobile               (under a hero, between sections)
     component('lead-form', ['variant' => 'callback'])  4. "call me back": name, mobile, time slot    (contact, cost pages)
     component('lead-form', ['variant' => 'quote'])     5. "get 3 quotes": budget and timeline too    (services, city pages)

   Options: id (unique on the page), title, text, button, eyebrow, heading (full only)
   ===================================================================== */
$variant = $p['variant'] ?? 'compact';
$id      = $p['id'] ?? ('lead-' . $variant);
$opts    = fn($list, $sel = '') => implode('', array_map(fn($o) => '<option' . ($o === $sel ? ' selected' : '') . '>' . e($o) . '</option>', $list));
$field   = fn($name, $label, $html) => '<div class="field"><label for="' . $id . '-' . $name . '">' . $label . '</label>' . $html . '</div>';

// Field building blocks (shared by all five forms)
$F = [
  'name'    => $field('name', 'Your name', '<input class="input" id="' . $id . '-name" name="name" required minlength="2" maxlength="60" autocomplete="name">'),
  'phone'   => $field('phone', 'Mobile number', '<input class="input" id="' . $id . '-phone" name="phone" type="tel" inputmode="tel" required maxlength="16" pattern="(\+?91|0)?[\s\-]?[6-9]([\s\-]?[0-9]){9}" title="10-digit Indian mobile number" placeholder="98765 43210" autocomplete="tel">'),
  'email'   => $field('email', 'Email <small>(optional)</small>', '<input class="input" id="' . $id . '-email" name="email" type="email" maxlength="120" autocomplete="email">'),
  'city'    => $field('city', 'City', '<select class="input" id="' . $id . '-city" name="city">' . $opts(LEADS['cities']) . '</select>'),
  'home'    => $field('home', 'Home type', '<select class="input" id="' . $id . '-home" name="home">' . $opts(LEADS['home_types'], '2 BHK') . '</select>'),
  'service' => $field('service', 'What are you looking to do?', '<select class="input" id="' . $id . '-service" name="service">' . $opts(LEADS['services']) . '</select>'),
  'budget'  => $field('budget', 'Budget', '<select class="input" id="' . $id . '-budget" name="budget">' . $opts(LEADS['budgets'], '₹5–10 lakh') . '</select>'),
  'when'    => $field('when', 'When do you want to start?', '<select class="input" id="' . $id . '-when" name="timeline">' . $opts(LEADS['timelines'], 'In 1–3 months') . '</select>'),
  'slot'    => $field('slot', 'Best time to call', '<select class="input" id="' . $id . '-slot" name="call_slot">' . $opts(LEADS['call_slots']) . '</select>'),
  'notes'   => $field('notes', 'Anything specific? <small>(optional)</small>', '<textarea class="input" id="' . $id . '-notes" name="notes" maxlength="1000" placeholder="E.g. modular kitchen, wardrobe with study, open plan living…"></textarea>'),
];
$row = fn(...$keys) => '<div class="form__row">' . implode('', array_map(fn($k) => $F[$k], $keys)) . '</div>';

$layouts = [   // variant => [default title, default button, fields]
  'full'     => ['Book your free consultation', 'Book free consultation →', $row('name', 'phone') . $F['email'] . $row('city', 'home') . $F['service'] . $F['notes']],
  'compact'  => ['Get a free call back',        'Request call back →',      $F['name'] . $F['phone'] . $row('city', 'home')],
  'inline'   => ['Talk to an interior expert',  'Call me back →',           $F['name'] . $F['phone']],
  'callback' => ['Request a call back',         'Call me back →',           $F['name'] . $F['phone'] . $F['slot']],
  'quote'    => ['Get 3 quotes from verified designers', 'Get my 3 quotes →', $row('name', 'phone') . $row('city', 'home') . $row('budget', 'when') . $F['notes']],
];
[$defTitle, $defButton, $fields] = $layouts[$variant] ?? $layouts['compact'];
$title = $p['title'] ?? $defTitle;
$note  = '<p class="form__note">' . e(LEADS['promise']) . ' By submitting you agree we may contact you and share your request with up to 3 designers. <a href="/privacy/">Privacy</a></p>';

$form = '<form class="form lead-form lead-form--' . e($variant) . '" id="' . e($id) . '-form" method="post" action="' . e(LEADS['endpoint']) . '" data-lead-form>'
      . ($variant === 'inline' ? '' : '<p class="form__title">' . e($title) . '</p>')
      . (!empty($p['text']) && !in_array($variant, ['full', 'inline']) ? '<p class="form__text">' . e($p['text']) . '</p>' : '')
      . ($variant === 'inline' ? '<div class="lead-form__fields">' . $fields . '<button class="btn btn--primary" type="submit">' . e($p['button'] ?? $defButton) . '</button></div>'
                               : $fields . '<button class="btn btn--primary btn--block" type="submit">' . e($p['button'] ?? $defButton) . '</button>')
      . lead_hidden_fields($variant)
      . $note
      . '</form>';

if ($variant === 'full'): ?>
<section class="section section--dark" id="<?= e($id) ?>">
  <div class="container lead">
    <div>
      <span class="eyebrow"><?= e($p['eyebrow'] ?? 'Free consultation') ?></span>
      <h2 class="section-title mt-4"><?= $p['heading'] ?? "Let's plan your<br>dream home <em>together.</em>" ?></h2>
      <p class="subheading mt-4"><?= e($p['text'] ?? 'Talk to a verified interior designer. Get material recommendations and a detailed cost estimate — no obligation.') ?></p>
      <ul class="ticks mt-6"><?php foreach (LEADS['trust'] as $t0) echo '<li>' . e($t0) . '</li>'; ?></ul>
<?php if (NAP['phone'] || NAP['email']): ?>
      <div class="mt-6"><?= component('nap', ['compact' => true]) ?></div>
<?php endif; ?>
    </div>
    <div class="lead__form"><?= $form ?></div>
  </div>
</section>
<?php elseif ($variant === 'inline'): ?>
<div class="lead-strip" id="<?= e($id) ?>">
  <div class="lead-strip__text"><strong><?= e($title) ?></strong><?php if (!empty($p['text'])): ?><span><?= e($p['text']) ?></span><?php endif; ?></div>
  <?= $form ?>
</div>
<?php else: ?>
<div class="lead-card lead-card--<?= e($variant) ?> mt-8" id="<?= e($id) ?>"><?= $form ?></div>
<?php endif;
