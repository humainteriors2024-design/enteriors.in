/* ENTERIORS — Contact / Mail pop-up with email verification.
   Any [data-enquiry] link opens it (data-kind = design | pro, data-target, data-name, data-about, data-mode = contact | mail).
   1 details → api/enquiry.php action=start (emails a 6-digit code)  2 code → action=verify (sends the enquiry)  3 done.
   Without JavaScript the links simply open the contact page. Markup: enquiry_dialog() in includes/finder.php. */
(function () {
  var dlg = document.getElementById('enquiry-dialog');
  if (!dlg || !dlg.showModal || !window.fetch || !window.FormData) return;
  var f1 = dlg.querySelector('[data-enq-step="details"]'), f2 = dlg.querySelector('[data-enq-step="verify"]'), done = dlg.querySelector('[data-enq-step="done"]');
  var resendBtn = f2.querySelector('[data-enq-resend]');
  var MIN_WAIT = 3500;                  // matches LEADS['min_seconds'] (+ a margin): faster than this looks like a bot
  var loaded = performance.now(), keyAt = Date.now(), token = '', timer = null, retried = false, opener = null, current = {};
  var track = function (n, d) { if (window.entTrack) window.entTrack(n, d || {}); };
  var session = function (k) { try { return sessionStorage.getItem(k) || ''; } catch (e) { return ''; } };

  var show = function (step) {
    [f1, f2, done].forEach(function (el) { el.hidden = el !== step; });
    var first = step === f1 ? f1.querySelector('input:not([type=hidden]):not([type=radio]):not([type=checkbox])') : step === f2 ? f2.elements.code : done;
    setTimeout(function () { (step === f1 ? (Array.prototype.find.call(f1.querySelectorAll('.input'), function (i) { return !i.value; }) || first) : first).focus(); }, 30);
  };
  var clearErrors = function (form) {
    form.querySelectorAll('.has-error').forEach(function (f) { f.classList.remove('has-error'); });
    form.querySelectorAll('[data-err]').forEach(function (p) { p.hidden = true; p.textContent = ''; p.style.color = ''; });
    var n = form.querySelector('.form__error'); if (n) n.remove();
  };
  var fieldError = function (form, name, msg) {
    var p = form.querySelector('[data-err="' + name + '"]');
    if (p) { p.textContent = msg; p.hidden = false; }
    var el = form.elements[name];
    if (el && el.closest && el.closest('.field')) el.closest('.field').classList.add('has-error');
  };
  var note = function (form, msg) {
    var n = form.querySelector('.form__error') || form.appendChild(document.createElement('p'));
    n.className = 'form__error form__note'; n.setAttribute('role', 'alert'); n.style.color = 'var(--red)';
    n.textContent = msg || 'Something went wrong. Please try again, or use the contact page.';
  };
  var post = function (data) {
    return fetch(f1.getAttribute('action'), { method: 'POST', body: data, headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
      .then(function (r) { return r.json().catch(function () { return { ok: false }; }); });
  };
  var refreshKey = function () {
    return fetch('/api/form-key.php?form=enquiry', { headers: { 'Accept': 'application/json' } }).then(function (r) { return r.json(); })
      .then(function (res) { if (res.ok) { f1.elements.fk.value = res.fk; loaded = performance.now(); keyAt = Date.now(); } });
  };
  var countdown = function (secs) {
    clearInterval(timer);
    var left = secs;
    resendBtn.disabled = true;
    var tick = function () {
      if (left <= 0) { clearInterval(timer); resendBtn.disabled = false; resendBtn.textContent = 'Resend code'; return; }
      resendBtn.textContent = 'Resend code in ' + left + 's'; left--;
    };
    tick(); timer = setInterval(tick, 1000);
  };
  var setMode = function (mode) {
    var mail = mode === 'mail';
    f1.querySelectorAll('input[name="mode"]').forEach(function (r) { r.checked = r.value === mode; });
    dlg.querySelector('[data-enq-verb]').textContent = mail ? 'Mail' : 'Contact';
    dlg.querySelector('[data-enq-msg-hint]').textContent = mail ? '(required)' : '(optional)';
    f1.elements.message.required = mail;
  };

  /* open */
  document.addEventListener('click', function (e) {
    var a = e.target.closest('[data-enquiry]');
    if (!a) return;
    e.preventDefault();
    opener = a;
    current = { kind: a.getAttribute('data-kind'), target: a.getAttribute('data-target'), name: a.getAttribute('data-name'), about: a.getAttribute('data-about') };
    if (current.target !== f1.elements.target.value || !done.hidden) {   // a different listing (or a finished one): start fresh, keep what they typed
      token = ''; show(f1); clearErrors(f1); clearErrors(f2); f1.elements.consent.checked = false;
    }
    f1.elements.kind.value = current.kind; f1.elements.target.value = current.target;
    dlg.querySelectorAll('[data-enq-name]').forEach(function (s) { s.textContent = current.name; });
    var about = dlg.querySelector('[data-enq-about]'); about.textContent = current.about ? 'About: ' + current.about : ''; about.hidden = !current.about;
    setMode(a.getAttribute('data-mode') === 'mail' ? 'mail' : 'contact');
    if (Date.now() - keyAt > 30 * 60 * 1000) refreshKey();
    dlg.showModal();
    show(token ? f2 : f1);
    track('enquiry_open', { kind: current.kind, mode: a.getAttribute('data-mode') });
  });
  f1.addEventListener('change', function (e) { if (e.target.name === 'mode') setMode(e.target.value); });
  var close = function () { dlg.close(); if (opener) opener.focus(); };
  dlg.addEventListener('click', function (e) { if (e.target.closest('[data-enq-close]') || e.target === dlg) close(); });

  /* 1. details → send the code */
  var sendDetails = function (btn, label) {
    var data = new FormData(f1);
    var utm = session('ent_utm'); if (utm) data.append('utm', utm);
    data.append('landing', session('ent_landing') || location.pathname); data.append('referrer', document.referrer.slice(0, 200));
    setTimeout(function () {
      post(data).then(function (res) {
        btn.disabled = false; btn.textContent = label;
        if (res.ok) {
          token = res.token || '';
          dlg.querySelector('[data-enq-email]').textContent = res.email || f1.elements.email.value;
          f2.elements.code.value = ''; clearErrors(f2);
          show(f2); countdown(res.resend_in || 45);
          track('otp_sent', { kind: current.kind });
          return;
        }
        if (res.code === 'key' && !retried) { retried = true; btn.disabled = true; return refreshKey().then(function () { sendDetails(btn, label); }); }
        Object.keys(res.fields || {}).forEach(function (k) { fieldError(f1, k, res.fields[k]); });
        note(f1, res.message);
      }).catch(function () { btn.disabled = false; btn.textContent = label; note(f1); });
    }, Math.max(0, MIN_WAIT - (performance.now() - loaded)));
  };
  f1.addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors(f1);
    var el = f1.elements, bad = false;
    var check = function (name, ok, msg) { if (!ok) { fieldError(f1, name, msg); bad = true; } };
    check('name', /^[^\d<>{}@#$%^*_=+~`|\\]{2,60}$/.test(el.name.value.trim()), 'Please enter your name.');
    check('phone', /^(\+?91|0)?[\s\-]?[6-9]([\s\-]?\d){9}$/.test(el.phone.value.trim()), 'Please enter a 10-digit Indian mobile number.');
    check('email', /^[^\s@,;<>"]+@[^\s@,;<>"]+\.[a-z]{2,}$/i.test(el.email.value.trim()), 'Please enter a valid email address.');
    check('location', el.location.value.trim().length >= 2, 'Please enter your city or area.');
    if (el.message.required) check('message', el.message.value.trim().length >= 10, 'Please write a short message (at least 10 characters).');
    check('consent', el.consent.checked, 'Please tick the box to share your details with this firm.');
    if (bad) { var first = f1.querySelector('.has-error .input'); if (first) first.focus(); return; }
    var btn = f1.querySelector('[type="submit"]'), label = btn.textContent;
    btn.disabled = true; btn.textContent = 'Sending code…';
    retried = false;
    sendDetails(btn, label);
  });

  /* 2. code → send the enquiry */
  f2.elements.code.addEventListener('input', function () {
    var v = this.value.replace(/\D/g, '').slice(0, 6);
    if (v !== this.value) this.value = v;
    if (v.length === 6 && !f2.dataset.busy) f2.requestSubmit ? f2.requestSubmit() : f2.dispatchEvent(new Event('submit', { cancelable: true }));
  });
  f2.addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors(f2);
    var code = f2.elements.code.value;
    if (!/^\d{6}$/.test(code)) { fieldError(f2, 'code', 'Enter the 6 digits from the email.'); return; }
    var btn = f2.querySelector('[type="submit"]'), label = btn.textContent;
    btn.disabled = true; btn.textContent = 'Checking…'; f2.dataset.busy = '1';
    var data = new FormData(); data.append('action', 'verify'); data.append('token', token); data.append('code', code);
    post(data).then(function (res) {
      btn.disabled = false; btn.textContent = label; delete f2.dataset.busy;
      if (res.ok) {
        token = ''; clearInterval(timer);
        dlg.querySelector('[data-enq-done-text]').textContent = res.message;
        show(done);
        f1.elements.message.value = '';
        track('lead', { form: res.form || 'enquiry', lead_id: res.ref, kind: current.kind });
        return;
      }
      if (res.code === 'gone') { token = ''; show(f1); note(f1, res.message); return; }
      if (res.code === 'expired') { resendBtn.disabled = false; resendBtn.textContent = 'Resend code'; clearInterval(timer); }
      fieldError(f2, 'code', res.message || 'That code did not work.');
      f2.elements.code.select();
    }).catch(function () { btn.disabled = false; btn.textContent = label; delete f2.dataset.busy; note(f2); });
  });
  resendBtn.addEventListener('click', function () {
    if (!token) return;
    resendBtn.disabled = true;
    var data = new FormData(); data.append('action', 'resend'); data.append('token', token);
    post(data).then(function (res) {
      clearErrors(f2);
      if (res.ok) { countdown(res.resend_in || 45); fieldError(f2, 'code', res.message); f2.querySelector('[data-err="code"]').style.color = 'var(--green)'; f2.elements.code.value = ''; f2.elements.code.focus(); return; }
      if (res.code === 'gone') { token = ''; show(f1); note(f1, res.message); return; }
      if (res.resend_in) countdown(res.resend_in); else resendBtn.disabled = res.code === 'max';
      note(f2, res.message);
    }).catch(function () { resendBtn.disabled = false; note(f2); });
  });
  f2.querySelector('[data-enq-back]').addEventListener('click', function () { token = ''; clearInterval(timer); show(f1); });
})();
