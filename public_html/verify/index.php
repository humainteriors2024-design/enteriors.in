<?php
/* =====================================================================
   EMAIL VERIFICATION — /verify/   (never indexed, never in the sitemap)
     /verify/?t=<request>&k=<link key>   the one-click link from the verification email:
                                         confirms the request at once (a button without JavaScript)
     /verify/?t=<request>                no JavaScript on the form: type the 6-digit code here
   Both post to api/lead.php, which sends the submission to LEADS['notify_emails'].
   ===================================================================== */
$t = preg_match('/^[a-f0-9]{32}$/', (string) ($_GET['t'] ?? '')) ? $_GET['t'] : '';
$k = preg_match('/^[a-f0-9]{32}$/', (string) ($_GET['k'] ?? '')) ? $_GET['k'] : '';
$page = ['type' => 'page', 'title' => 'Confirm your email', 'noindex' => true, 'header' => 'minimal', 'footer' => 'minimal', 'no_media_note' => true,
  'description' => 'Confirm your email address to send your request to Enteriors.'];
header('Referrer-Policy: no-referrer');   // the link key never leaves this page
require $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<section class="section container container--text verify-page">
<?php if (!$t): ?>
  <span class="eyebrow">Email verification</span>
  <h1 class="mt-4">This link is incomplete</h1>
  <p class="lede mt-4">Please open the link exactly as it is in the email, or type the 6-digit code in the form you filled in.</p>
<?php elseif ($k): ?>
  <div data-verify-link data-token="<?= e($t) ?>" data-key="<?= e($k) ?>">
    <span class="eyebrow">Email verification</span>
    <h1 class="mt-4" data-verify-title>Confirming your email…</h1>
    <p class="lede mt-4" data-verify-text>One moment while we send your request.</p>
    <form method="post" action="<?= e(LEADS['endpoint']) ?>" class="mt-6" data-verify-fallback>
      <input type="hidden" name="action" value="confirm"><input type="hidden" name="token" value="<?= e($t) ?>"><input type="hidden" name="key" value="<?= e($k) ?>">
      <button class="btn btn--primary" type="submit">Confirm and send my request →</button>
    </form>
  </div>
  <script>
  (function () {
    var box = document.querySelector('[data-verify-link]'); if (!box || !window.fetch) return;
    var fb = box.querySelector('[data-verify-fallback]'); fb.hidden = true;
    var data = new FormData(); data.append('action', 'confirm'); data.append('token', box.dataset.token); data.append('key', box.dataset.key);
    fetch(fb.getAttribute('action'), { method: 'POST', body: data, headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        box.querySelector('[data-verify-title]').textContent = res.ok ? '✓ Email verified — request sent' : 'We could not confirm this link';
        box.querySelector('[data-verify-text]').textContent = res.message || '';
        // analytics: counted once (res.track) and generate_lead only when the server sent it (res.sent); nothing personal is sent
        var T = window.entTrack; if (!T) return;
        var names = (window.ENT_TRACK && window.ENT_TRACK.forms) || {};
        var p = { form_name: names[res.form] || res.form || 'form', form_location: res.form_location || 'email_link', verify_method: 'link' };
        if (res.ok && res.state === 'done' && res.track) {
          T('otp_verified', p);
          if (res.sent) T('generate_lead', Object.assign({ lead_type: res.form === 'enquiry' ? 'listing_enquiry' : 'consultation', lead_ref: res.ref }, p));
          else T('form_error', Object.assign({ reason: 'server', error_detail: 'mail_failed', form_step: 'link', error_source: 'server' }, p));
        } else if (!res.ok) {
          T('form_error', Object.assign({ reason: res.code === 'limit' ? 'daily_limit' : (res.code === 'link' || res.code === 'gone' || !res.code) ? 'validation' : 'server', error_detail: res.code || 'link', form_step: 'link', error_source: 'server' }, p));
        }
      })
      .catch(function () { fb.hidden = false; box.querySelector('[data-verify-title]').textContent = 'Confirm your email'; box.querySelector('[data-verify-text]').textContent = 'Tap the button to send your request.'; });
  })();
  </script>
<?php else: ?>
  <span class="eyebrow">Email verification</span>
  <h1 class="mt-4">Check your email</h1>
  <p class="lede mt-4">We sent you a 6-digit code and a link. Type the code below, or just open the link in the email.</p>
  <form class="form lead-card mt-6" method="post" action="<?= e(LEADS['endpoint']) ?>">
    <input type="hidden" name="action" value="verify"><input type="hidden" name="token" value="<?= e($t) ?>">
    <div class="field"><label for="v-code">6-digit code</label><input class="input vcode" id="v-code" name="code" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" required></div>
    <button class="btn btn--primary btn--block" type="submit">Verify and send →</button>
  </form>
<?php endif; ?>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/foot.php'; ?>
