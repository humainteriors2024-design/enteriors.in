/* ENTERIORS — Contact / Mail pop-up on trending designs and designer profiles.
   Any [data-enquiry] link opens it (data-kind = design | pro, data-target, data-name, data-about, data-mode = contact | mail).
   The form itself (checks, captcha, email verification by code or link, sending) is handled by the
   shared form script in site.js, like every other form. Without JavaScript the links open the contact page.
   Markup: enquiry_dialog() in includes/finder.php. */
(function () {
  var dlg = document.getElementById('enquiry-dialog');
  if (!dlg || !dlg.showModal || !window.fetch || !window.FormData) return;
  var box = dlg.querySelector('[data-vform]'), f1 = box.querySelector('[data-step="details"]');
  var opener = null;
  var track = function (n, d) { if (window.entTrack) window.entTrack(n, d || {}); };
  var setMode = function (mode) {
    var mail = mode === 'mail';
    f1.querySelectorAll('input[name="mode"]').forEach(function (r) { r.checked = r.value === mode; });
    dlg.querySelector('[data-enq-verb]').textContent = mail ? 'Mail' : 'Contact';
    dlg.querySelector('[data-enq-msg-hint]').textContent = mail ? '(required)' : '(optional)';
    f1.elements.message.required = mail;
  };
  document.addEventListener('click', function (e) {
    var a = e.target.closest('[data-enquiry]');
    if (!a) return;
    e.preventDefault();
    opener = a;
    var kind = a.getAttribute('data-kind'), target = a.getAttribute('data-target'), name = a.getAttribute('data-name'), about = a.getAttribute('data-about');
    if (target !== f1.elements.target.value) { f1.elements.consent.checked = false; if (box.vformReset) box.vformReset(); }   // a different listing: start fresh, keep what they typed
    else if (box.vformReset) box.vformReset();
    f1.elements.kind.value = kind; f1.elements.target.value = target;
    dlg.querySelectorAll('[data-enq-name]').forEach(function (s) { s.textContent = name; });
    var ab = dlg.querySelector('[data-enq-about]'); ab.textContent = about ? 'About: ' + about : ''; ab.hidden = !about;
    setMode(a.getAttribute('data-mode') === 'mail' ? 'mail' : 'contact');
    dlg.showModal();
    track('enquiry_open', { kind: kind, mode: a.getAttribute('data-mode') });
  });
  f1.addEventListener('change', function (e) { if (e.target.name === 'mode') setMode(e.target.value); });
  var close = function () { dlg.close(); if (opener) opener.focus(); };
  dlg.addEventListener('click', function (e) { if (e.target.closest('[data-enq-close]') || e.target === dlg) close(); });
})();
