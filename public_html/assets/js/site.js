/* ENTERIORS — site-wide JavaScript: menus, contents highlight, tabs, lead forms, sticky CTA.
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

  /* ---------- Lead forms (all five variants + the pop-up) ----------
     Sends without leaving the page, shows field errors, keeps the hidden form key fresh,
     records the campaign (utm) the visitor came from and reports the lead to tracking. */
  var MIN_WAIT = 3500;                       // matches LEADS['min_seconds'] in config.php (+ a margin)
  var utm = (function () {
    var q = location.search.replace(/^\?/, '').split('&').filter(function (kv) { return /^(utm_|gclid|fbclid)/.test(kv); }).join('&');
    try { if (q) sessionStorage.setItem('ent_utm', q); return sessionStorage.getItem('ent_utm') || ''; } catch (e) { return q; }
  })();
  var track = function (name, data) { if (window.entTrack) window.entTrack(name, data || {}); };
  var landing = (function () {   // first page of the visit, sent with a lead
    try { var l = sessionStorage.getItem('ent_landing'); if (!l) { l = location.pathname; sessionStorage.setItem('ent_landing', l); } return l; } catch (e) { return location.pathname; }
  })();

  document.querySelectorAll('[data-lead-form]').forEach(function (form) {
    var loaded = performance.now(), keyAt = Date.now(), retried = false, begun = false;
    form.addEventListener('focusin', function () { if (!begun) { begun = true; track('form_start', { form: form.elements.form.value }); } });
    var refreshKey = function () {
      return fetch('/api/form-key.php?form=' + encodeURIComponent(form.elements.form.value), { headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (res) { if (res.ok) { form.elements.fk.value = res.fk; loaded = performance.now(); keyAt = Date.now(); } });
    };
    // a form left open for 30+ minutes gets a new key when the visitor starts typing
    form.addEventListener('focusin', function () { if (Date.now() - keyAt > 30 * 60 * 1000) refreshKey(); });

    var note = function (msg) {
      var n = form.querySelector('.form__error') || form.appendChild(document.createElement('p'));
      n.className = 'form__error form__note'; n.setAttribute('role', 'alert'); n.textContent = msg || 'Something went wrong. Please call or email us.';
    };
    var send = function (btn, label) {
      var data = new FormData(form);
      if (utm) data.append('utm', utm);
      data.append('landing', landing); data.append('referrer', document.referrer.slice(0, 200));
      // calculator estimate, if the visitor used one on this page: the signed token lets the server
      // attach the estimate it worked out itself (the browser cannot change the figure)
      if (window.ENT && ENT.calc) data.append('calc_token', ENT.calc.token);
      var wait = Math.max(0, MIN_WAIT - (performance.now() - loaded));
      setTimeout(function () {
        fetch(form.action, { method: 'POST', body: data, headers: { 'Accept': 'application/json' } })
          .then(function (r) { return r.json(); })
          .then(function (res) {
            if (res.ok) {
              track('lead', { form: res.form || form.elements.form.value, value: (window.ENT && ENT.calc) ? ENT.calc.total : undefined, currency: 'INR', calc: (window.ENT && ENT.calc) ? ENT.calc.type : undefined, lead_id: res.lead_id });
              form.innerHTML = '<p class="form__ok" role="status">✓ ' + res.message + '</p>';
              return;
            }
            if (res.code === 'key' && !retried) { retried = true; return refreshKey().then(function () { send(btn, label); }); }
            form.querySelectorAll('.field.has-error').forEach(function (f) { f.classList.remove('has-error'); });
            Object.keys(res.fields || {}).forEach(function (k) { var el = form.elements[k]; if (el && el.closest) el.closest('.field').classList.add('has-error'); });
            throw new Error(res.message);
          })
          .catch(function (err) { btn.disabled = false; btn.textContent = label; note(err.message); });
      }, wait);
    };
    form.addEventListener('submit', function (e) {
      if (!window.fetch) return;                    // very old browsers: normal form post
      e.preventDefault();
      if (!form.reportValidity()) return;
      var btn = form.querySelector('[type="submit"]'), label = btn.textContent;
      btn.disabled = true; btn.textContent = 'Sending…';
      send(btn, label);
    });
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
