/* ENTERIORS — site-wide JavaScript: menus, contents highlight, tabs, every form (with email verification), sticky CTA.
   Page-only scripts live in their own files (e.g. home.js) and are listed in $page['js']. */
(function () {
  // Mega menus: open on click (desktop hover is handled in CSS)
  var items = document.querySelectorAll('[data-nav-item]');
  function closeAll(except) {
    items.forEach(function (i) {
      if (i === except) return;
      i.classList.remove('is-open');
      var b = i.querySelector('[data-nav-toggle]'); if (b) b.setAttribute('aria-expanded', 'false');
    });
  }
  document.querySelectorAll('[data-nav-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('[data-nav-item]');
      closeAll(item);
      btn.setAttribute('aria-expanded', String(item.classList.toggle('is-open')));
    });
  });
  document.addEventListener('click', function (e) { if (!e.target.closest('[data-nav-item]')) closeAll(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeAll(); });

  // Mobile menu
  var burger = document.querySelector('[data-burger]');
  var mobile = document.querySelector('[data-mobile-nav]');
  if (burger && mobile) burger.addEventListener('click', function () {
    burger.setAttribute('aria-expanded', String(mobile.classList.toggle('is-open')));
  });

  // Table of contents: highlight the section being read; collapse on phones
  var links = Array.prototype.slice.call(document.querySelectorAll('.toc a'));
  if (links.length && 'IntersectionObserver' in window) {
    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        links.forEach(function (l) { l.setAttribute('aria-current', String(l.hash === '#' + en.target.id)); });
      });
    }, { rootMargin: '-20% 0px -70% 0px' });
    links.forEach(function (l) { var t = document.getElementById(l.hash.slice(1)); if (t) obs.observe(t); });
  }
  if (window.matchMedia('(max-width: 1024px)').matches) {
    var d = document.querySelector('.toc details'); if (d) d.removeAttribute('open');
  }

  // Tabs: <div role="tablist"> buttons with aria-controls → panels with role="tabpanel"
  document.querySelectorAll('[role="tablist"]').forEach(function (list) {
    var tabs = list.querySelectorAll('[role="tab"]');
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) {
          var on = t === tab;
          t.setAttribute('aria-selected', String(on));
          var panel = document.getElementById(t.getAttribute('aria-controls'));
          if (panel) panel.hidden = !on;
        });
      });
    });
  });

  /* ---------- Every form: details → email verification (code or link) → sent ----------
     One handler for the five lead forms, the pop-up and Contact / Mail on listings ([data-vform]).
     Checks the fields here first (the server checks again), keeps the hidden form key and the captcha
     fresh, records the campaign (utm) the visitor came from, then shows the code box. While the code
     box is open it asks the server every few seconds whether the link in the email was clicked, so a
     link opened on the phone also completes the form left open here. */
  var MIN_WAIT = 3500;                       // matches LEADS['min_seconds'] in config.php (+ a margin)
  var utm = (function () {
    var q = location.search.replace(/^\?/, '').split('&').filter(function (kv) { return /^(utm_|gclid|fbclid)/.test(kv); }).join('&');
    try { if (q) sessionStorage.setItem('ent_utm', q); return sessionStorage.getItem('ent_utm') || ''; } catch (e) { return q; }
  })();
  var track = function (name, data) { if (window.entTrack) window.entTrack(name, data || {}); };
  var landing = (function () {   // first page of the visit, sent with a lead
    try { var l = sessionStorage.getItem('ent_landing'); if (!l) { l = location.pathname; sessionStorage.setItem('ent_landing', l); } return l; } catch (e) { return location.pathname; }
  })();
  var RULES = {
    name: [/^[^\d<>{}@#$%^*_=+~`|\\]{2,60}$/, 'Please enter your name.'],
    phone: [{ test: function (v) { return /^(91|0)?[6-9]\d{9}$/.test(v.replace(/\D/g, '')); } }, 'Please enter a 10-digit Indian mobile number.'],
    email: [/^[^\s@,;<>"]+@[^\s@,;<>"]+\.[a-z]{2,}$/i, 'Please enter a valid email address.'],
    city: [/^.{2,60}$/, 'Please enter your city or area.'],
    location: [/^.{2,60}$/, 'Please enter your city or area.']
  };
  var TYPO = { 'gmial.com': 'gmail.com', 'gmai.com': 'gmail.com', 'gamil.com': 'gmail.com', 'gmail.co': 'gmail.com', 'gmail.con': 'gmail.com', 'gnail.com': 'gmail.com', 'gmail.in': 'gmail.com', 'yaho.com': 'yahoo.com', 'hotmial.com': 'hotmail.com', 'outlok.com': 'outlook.com', 'redifmail.com': 'rediffmail.com' };
  var post = function (url, data) {
    return fetch(url, { method: 'POST', body: data, headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
      .then(function (r) { return r.json().catch(function () { return { ok: false }; }); });
  };

  document.querySelectorAll('[data-vform]').forEach(function (box) {
    var f1 = box.querySelector('[data-step="details"]'), f2 = box.querySelector('[data-step="verify"]'), done = box.querySelector('[data-step="done"]');
    if (!f1 || !f2 || !done || !window.fetch || !window.FormData) return;
    f1.noValidate = true;                     // we show our own messages next to each field
    var formName = f1.elements.form.value, loaded = performance.now(), keyAt = Date.now(), begun = false;
    var token = '', timer = null, poller = null, finished = false;
    var resendBtn = f2.querySelector('[data-v-resend]');

    var show = function (step) {
      [f1, f2, done].forEach(function (el) { el.hidden = el !== step; });
      if (step === f2) setTimeout(function () { f2.elements.code.focus(); }, 30);
      if (step === done) done.focus();
      if (step !== f2) { clearInterval(poller); poller = null; }
    };
    var clearErrors = function (form) {
      form.querySelectorAll('.has-error').forEach(function (f) { f.classList.remove('has-error'); });
      form.querySelectorAll('[data-err]').forEach(function (p) { p.hidden = true; p.textContent = ''; p.classList.remove('is-ok'); });
      var n = form.querySelector('.form__error'); if (n) n.remove();
    };
    var fieldError = function (form, name, msg, ok) {
      var p = form.querySelector('[data-err="' + name + '"]');
      if (p) { p.textContent = msg; p.hidden = false; p.classList.toggle('is-ok', !!ok); }
      var el = form.elements[name];
      if (!ok && el && el.closest && el.closest('.field')) el.closest('.field').classList.add('has-error');
      return !!p;
    };
    var note = function (form, msg) {
      var n = form.querySelector('.form__error') || form.appendChild(document.createElement('p'));
      n.className = 'form__error form__note'; n.setAttribute('role', 'alert');
      n.textContent = msg || 'Something went wrong. Please try again, or email us.';
    };
    var refresh = function (withCaptcha) {   // a new form key (and built-in captcha); Turnstile resets itself
      if (window.turnstile) { var w = f1.querySelector('.cf-turnstile'); if (w) try { window.turnstile.reset(w); } catch (e) {} }
      var cap = withCaptcha && f1.querySelector('[data-captcha]');
      return fetch('/api/form-key.php?form=' + encodeURIComponent(formName) + (cap ? '&captcha=1' : ''), { headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (!res.ok) return;
          f1.elements.fk.value = res.fk; loaded = performance.now(); keyAt = Date.now();
          if (cap && res.captcha) { cap.querySelector('[data-captcha-img]').innerHTML = res.captcha.svg; f1.elements.captcha_token.value = res.captcha.token; f1.elements.captcha_answer.value = ''; }
        });
    };
    f1.addEventListener('focusin', function () {
      if (!begun) { begun = true; track('form_start', { form: formName }); }
      if (Date.now() - keyAt > 30 * 60 * 1000) refresh(true);   // open for 30+ minutes: fresh key and captcha
    });
    var newCap = f1.querySelector('[data-captcha-new]');
    if (newCap) newCap.addEventListener('click', function () { refresh(true); });

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
    var finish = function (res) {
      if (finished) return;
      finished = true; token = ''; clearInterval(timer);
      done.querySelector('[data-v-done]').textContent = res.message;
      show(done);
      track('lead', { form: res.form || formName, value: (window.ENT && ENT.calc) ? ENT.calc.total : undefined, currency: 'INR', calc: (window.ENT && ENT.calc) ? ENT.calc.type : undefined, lead_id: res.ref });
      box.dispatchEvent(new CustomEvent('vform:done', { bubbles: true }));
    };
    var startPolling = function () {
      clearInterval(poller);
      var started = Date.now();
      poller = setInterval(function () {
        if (!token || document.hidden) return;
        if (Date.now() - started > 40 * 60 * 1000) { clearInterval(poller); return; }
        var d = new FormData(); d.append('action', 'status'); d.append('token', token);
        post(f1.getAttribute('action'), d).then(function (res) {
          if (res.state === 'done') finish(res);
          else if (res.state === 'gone') { token = ''; show(f1); note(f1, res.message); }
        }).catch(function () {});
      }, 4000);
    };

    /* 1. details → email the code and the link */
    var sendDetails = function (btn, label, retried) {
      var data = new FormData(f1);
      if (utm) data.append('utm', utm);
      data.append('landing', landing); data.append('referrer', document.referrer.slice(0, 200));
      // calculator estimate, if the visitor used one on this page: the signed token lets the server
      // attach the estimate it worked out itself (the browser cannot change the figure)
      if (window.ENT && ENT.calc && formName !== 'enquiry') data.append('calc_token', ENT.calc.token);
      setTimeout(function () {
        post(f1.getAttribute('action'), data).then(function (res) {
          btn.disabled = false; btn.textContent = label;
          if (res.ok) {
            token = res.token || ''; finished = false;
            box.querySelector('[data-v-email]').textContent = res.email || f1.elements.email.value;
            f2.elements.code.value = ''; clearErrors(f2);
            show(f2); countdown(res.resend_in || 45); startPolling();
            track('otp_sent', { form: formName });
            return;
          }
          if (res.code === 'key' && !retried) { btn.disabled = true; return refresh(false).then(function () { sendDetails(btn, label, true); }); }
          Object.keys(res.fields || {}).forEach(function (k) { fieldError(f1, k, res.fields[k]); });
          if (res.code === 'captcha' || res.code === 'limit' || res.code === 'rate' || !res.fields) refresh(true);
          if (!res.fields || !Object.keys(res.fields).every(function (k) { return f1.querySelector('[data-err="' + k + '"]'); })) note(f1, res.message);
          var first = f1.querySelector('.has-error .input'); if (first) first.focus();
        }).catch(function () { btn.disabled = false; btn.textContent = label; note(f1); });
      }, Math.max(0, MIN_WAIT - (performance.now() - loaded)));
    };
    f1.addEventListener('submit', function (e) {
      e.preventDefault();
      clearErrors(f1);
      var el = f1.elements, bad = false;
      Object.keys(RULES).forEach(function (k) {
        if (el[k] && !RULES[k][0].test(el[k].value.trim())) { fieldError(f1, k, RULES[k][1]); bad = true; }
      });
      if (el.email && !bad) {
        var dom = el.email.value.trim().toLowerCase().split('@')[1];
        if (TYPO[dom]) { fieldError(f1, 'email', 'Did you mean …@' + TYPO[dom] + '?'); bad = true; }
      }
      if (el.message && el.message.required && el.message.value.trim().length < 10) { fieldError(f1, 'message', 'Please write a short message (at least 10 characters).'); bad = true; }
      if (el.consent && !el.consent.checked) { fieldError(f1, 'consent', 'Please tick the box to share your details with this firm.'); bad = true; }
      if (el.captcha_answer && !/^\d{1,2}$/.test(el.captcha_answer.value.trim())) { if (!fieldError(f1, 'captcha', 'Please add the two numbers.')) note(f1, 'Please add the two numbers in the picture.'); el.captcha_answer.closest('.captcha').classList.add('has-error'); bad = true; }
      if (bad) { var first = f1.querySelector('.has-error .input'); if (first) first.focus(); return; }
      var btn = f1.querySelector('[type="submit"]'), label = btn.textContent;
      btn.disabled = true; btn.textContent = 'Sending…';
      sendDetails(btn, label, false);
    });

    /* 2. code → send */
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
      post(f2.getAttribute('action'), data).then(function (res) {
        btn.disabled = false; btn.textContent = label; delete f2.dataset.busy;
        if (res.ok) return finish(res);
        if (res.code === 'gone' || res.code === 'limit') { token = ''; show(f1); refresh(true); note(f1, res.message); return; }
        if (res.code === 'expired') { resendBtn.disabled = false; resendBtn.textContent = 'Resend code'; clearInterval(timer); }
        fieldError(f2, 'code', res.message || 'That code did not work.');
        f2.elements.code.select();
      }).catch(function () { btn.disabled = false; btn.textContent = label; delete f2.dataset.busy; note(f2); });
    });
    resendBtn.addEventListener('click', function () {
      if (!token) return;
      resendBtn.disabled = true;
      var data = new FormData(); data.append('action', 'resend'); data.append('token', token);
      post(f2.getAttribute('action'), data).then(function (res) {
        clearErrors(f2);
        if (res.ok) { countdown(res.resend_in || 45); fieldError(f2, 'code', res.message, true); f2.elements.code.value = ''; f2.elements.code.focus(); return; }
        if (res.code === 'gone') { token = ''; show(f1); note(f1, res.message); return; }
        if (res.resend_in) countdown(res.resend_in); else resendBtn.disabled = res.code === 'max';
        note(f2, res.message);
      }).catch(function () { resendBtn.disabled = false; note(f2); });
    });
    f2.querySelector('[data-v-back]').addEventListener('click', function () { token = ''; clearInterval(timer); refresh(true); show(f1); });
    box.vformReset = function () { if (!finished && token) return show(f2); token = ''; finished = false; clearErrors(f1); clearErrors(f2); show(f1); };
  });

  /* ---------- Pop-up form: any [data-open-lead] opens it; without it the link works normally ---------- */
  var dialog = document.getElementById('lead-dialog');
  if (dialog && dialog.showModal) {
    document.addEventListener('click', function (e) {
      var opener = e.target.closest('[data-open-lead]');
      if (opener) {
        var onPage = document.querySelector('main [data-lead-form]');   // a form already on this page? scroll to it instead
        e.preventDefault();
        if (onPage && !dialog.contains(onPage) && opener.closest('.sticky-cta, .site-header, .mobile-nav') && onPage.offsetParent) { onPage.scrollIntoView({ behavior: 'smooth', block: 'center' }); return; }
        var vf = dialog.querySelector('[data-vform]'); if (vf && vf.vformReset) vf.vformReset();
        dialog.showModal();
      }
      if (e.target.closest('[data-close-lead]') || e.target === dialog) dialog.close();
    });
  }

  /* ---------- Click tracking ----------
     call / whatsapp (data-track), every button-style call to action (cta_click, with where it sits),
     contents-list jumps (toc_click), links to other websites (outbound_click).
     Every event also carries the page type and pillar (added in entTrack, see tracking.php). */
  document.addEventListener('click', function (e) {
    var t = e.target.closest('[data-track]');
    if (t) { track(t.getAttribute('data-track')); return; }
    var a = e.target.closest('a, button');
    if (!a) return;
    if (a.closest('.toc')) { track('toc_click', { section: (a.getAttribute('href') || '').slice(1) }); return; }
    if (a.matches('.btn, [data-open-lead], [data-quote]')) {
      var zone = a.closest('[data-cta-zone], .site-header, .sticky-cta, .cta-strip, .cta-band, .summary, .hero, .page-header, .site-footer, section, aside');
      track('cta_click', { cta_text: (a.textContent || '').trim().slice(0, 60), cta_zone: zone ? (zone.getAttribute('data-cta-zone') || zone.className.split(' ')[0] || zone.tagName.toLowerCase()) : 'page', link_url: a.getAttribute('href') || '' });
      return;
    }
    if (a.hostname && a.hostname !== location.hostname) track('outbound_click', { link_url: a.href.slice(0, 200) });
  });

  /* ---------- Reading depth on guides and posts: 25 / 50 / 75 / 100% of the article ---------- */
  var article = document.querySelector('.prose');
  if (article && document.body.matches('.page-pillar, .page-article, .page-compare, .page-post')) {
    var marks = [25, 50, 75, 100], sent = {}, t0 = Date.now();
    var onScroll = function () {
      var r = article.getBoundingClientRect(), seen = Math.min(1, Math.max(0, (window.innerHeight - r.top) / r.height));
      marks.forEach(function (m) {
        if (!sent[m] && seen * 100 >= m) { sent[m] = 1; track('scroll_depth', { percent_scrolled: m, seconds: Math.round((Date.now() - t0) / 1000) }); }
      });
      if (sent[100]) window.removeEventListener('scroll', onScroll);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    // an engaged read: 75% of the article and at least 60 seconds on the page
    var engaged = setInterval(function () { if (sent[75] && Date.now() - t0 > 60000) { track('article_read'); clearInterval(engaged); } }, 5000);
  }

  // Sticky Call / Consultation buttons after 500px of scrolling
  var sticky = document.querySelector('[data-sticky-cta]');
  if (sticky) window.addEventListener('scroll', function () {
    sticky.classList.toggle('is-visible', window.scrollY > 500);
  }, { passive: true });
})();
