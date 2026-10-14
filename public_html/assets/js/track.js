/* =====================================================================
   ENTERIORS — click, scroll and form-view tracking (every page, loaded by foot.php)
   Every event goes through window.entTrack (includes/tracking.php), which adds page_type and drops
   anything that looks like a name, email or phone number. Nothing here reads form fields.
   Events (full list with parameters: docs/ga4-setup.md):
     click_call · click_whatsapp · click_email · social_click · partner_click · outbound_click ·
     file_download · cta_click · scroll_depth (25/50/75/90) · form_view
   The form funnel (form_start … generate_lead) is in site.js; calculator_use in calc.js; filter_use in finder.js.
   ===================================================================== */
(function () {
  'use strict';
  if (!window.entTrack || !document.addEventListener) return;
  var track = window.entTrack;
  var C = window.ENT_TRACK || {}, host = (C.host || location.hostname).replace(/^www\./, ''), here = location.hostname.replace(/^www\./, '');
  var ours = function (h) { return h === host || h === here || h.slice(-host.length - 1) === '.' + host; };   // this site (live or staging address)
  var partners = C.partners || [];
  var DOWNLOAD = /\.(pdf|zip|docx?|xlsx?|csv|pptx?|dwg|rar|7z)$/i;

  // where on the page a click happened (no personal data, just the area)
  var where = function (el) {
    if (el.closest('dialog')) return 'popup';
    if (el.closest('.site-header, .mobile-nav')) return 'header';
    if (el.closest('.sticky-cta')) return 'sticky_bar';
    if (el.closest('.site-footer')) return 'footer';
    var z = el.closest('[data-cta-zone]');
    if (z) return z.getAttribute('data-cta-zone');
    if (el.closest('.hero, .page-header')) return 'hero';
    if (el.closest('.toc')) return 'contents';
    if (el.closest('.lead, [data-vform]')) return 'form';
    if (el.closest('[data-calc]')) return 'calculator';
    if (el.closest('aside')) return 'sidebar';
    return 'content';
  };
  var text = function (el) { return (el.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 60); };

  // the main calls to action, by what they do
  var ctaName = function (el, href) {
    if (el.hasAttribute('data-cta')) return el.getAttribute('data-cta');
    if (el.hasAttribute('data-enquiry')) return 'listing_' + (el.getAttribute('data-mode') === 'mail' ? 'mail' : 'contact');
    if (el.hasAttribute('data-open-lead')) return 'free_consultation';
    if (el.hasAttribute('data-quote')) return 'get_quote';
    if (!el.matches('a.btn')) return '';
    if (/\/calculators\//.test(href)) return 'cost_calculator';
    if (/\/contact\/|#get-quote|#lead-/.test(href) || /consult/i.test(text(el))) return 'free_consultation';
    if (/\/interior-designer-near-me\/|\/interior-designers\//.test(href)) return 'find_designer';
    return 'other_button';
  };

  /* ---------- Clicks (capture phase: runs before handlers that stop the click) ---------- */
  document.addEventListener('click', function (ev) {
    var el = ev.target && ev.target.closest ? ev.target.closest('a, button') : null;
    if (!el) return;
    var a = el.tagName === 'A' ? el : null, href = a ? (a.getAttribute('href') || '') : '', loc = where(el), dt = el.getAttribute('data-track') || '';

    // 1. contact taps: these are key events (the address or number itself is never sent)
    if (/^tel:/i.test(href) || dt === 'call') { track('click_call', { link_location: loc }); return; }
    if (/^(https?:\/\/(wa\.me|api\.whatsapp\.com|chat\.whatsapp\.com|web\.whatsapp\.com)\/|whatsapp:)/i.test(href) || dt === 'whatsapp') { track('click_whatsapp', { link_location: loc }); return; }
    if (/^mailto:/i.test(href)) { track('click_email', { link_location: loc, email_type: /^mailto:\?/i.test(href) ? 'share' : 'contact' }); return; }

    // 2. calls to action (consultation, calculator, quotes, listing contact)
    var cta = ctaName(el, href);
    if (cta && !(el.matches('button[type="submit"]'))) track('cta_click', { cta_name: cta, cta_location: loc, cta_text: text(el) });

    if (!a || !a.href || !/^https?:$/.test(a.protocol)) return;
    var h = a.hostname.replace(/^www\./, '').toLowerCase(), path = a.pathname || '';

    // 3. file downloads (our own files or others')
    var m = DOWNLOAD.exec(path);
    if (m || a.hasAttribute('download')) {
      track('file_download', { file_name: path.split('/').pop().slice(0, 80), file_extension: m ? m[1].toLowerCase() : '', link_domain: h, link_location: loc });
      if (ours(h)) return;
    }
    if (!h || ours(h)) return;   // our own pages

    // 4. other websites: social, partner or outbound
    var name, p = { link_domain: h, link_url: a.href.split('#')[0].split('?')[0].slice(0, 100), link_location: loc };
    if (/(^|\.)instagram\.com$/.test(h)) { name = 'social_click'; p.social_network = 'instagram'; p.social_action = 'profile'; }
    else if (/(^|\.)(facebook\.com|fb\.com|fb\.me)$/.test(h)) { name = 'social_click'; p.social_network = 'facebook'; p.social_action = /sharer/.test(path) ? 'share' : 'profile'; }
    else if (dt === 'partner' || partners.some(function (d) { return h === d || h.slice(-d.length - 1) === '.' + d; })) { name = 'partner_click'; p.partner_name = h; }
    else name = 'outbound_click';

    // same-tab navigation: hold the click until the hit is sent (at most 0.7 s), then go
    var newTab = a.target === '_blank' || ev.ctrlKey || ev.metaKey || ev.shiftKey || ev.altKey || ev.button !== 0;
    if (!newTab && !ev.defaultPrevented) {
      ev.preventDefault();
      var gone = false, go = function () { if (!gone) { gone = true; location.href = a.href; } };
      p.beacon_callback = go;
      setTimeout(go, 700);
    }
    track(name, p);
  }, true);

  /* ---------- Scroll depth: 25 / 50 / 75 / 90 % of the page seen, once each per page view ---------- */
  var marks = [25, 50, 75, 90], sent = {}, ticking = false;
  var measure = function () {
    ticking = false;
    var de = document.documentElement, full = Math.max(de.scrollHeight, document.body ? document.body.scrollHeight : 0);
    if (full <= window.innerHeight * 1.15) return;   // pages that fit one screen have nothing to scroll
    var seen = ((window.pageYOffset || de.scrollTop) + window.innerHeight) / full * 100;
    marks.forEach(function (m) { if (!sent[m] && seen >= m) { sent[m] = 1; track('scroll_depth', { percent_scrolled: m }); } });
    if (sent[90]) window.removeEventListener('scroll', onScroll);
  };
  var onScroll = function () { if (!ticking) { ticking = true; (window.requestAnimationFrame || setTimeout)(measure); } };
  window.addEventListener('scroll', onScroll, { passive: true });

  /* ---------- form_view: a form box half on screen (pop-ups count when they open), once per form per page ---------- */
  var info = function (box) { return { form_name: box.getAttribute('data-form-name') || 'form', form_location: box.getAttribute('data-form-location') || 'in_page' }; };
  window.entFormInfo = info;
  var boxes = document.querySelectorAll('[data-vform]');
  if (boxes.length && 'IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (list) {
      list.forEach(function (en) {
        if (en.isIntersecting && en.intersectionRatio >= 0.5 && !en.target.hasAttribute('data-viewed')) {
          en.target.setAttribute('data-viewed', '');
          track('form_view', info(en.target));
          io.unobserve(en.target);
        }
      });
    }, { threshold: [0, 0.5] });
    boxes.forEach(function (b) { io.observe(b); });
  }
})();
