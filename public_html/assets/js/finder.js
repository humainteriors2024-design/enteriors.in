/* ENTERIORS — trending designs + find a designer: filters, search word limit, "near me", galleries.
   Pages work without this file (the filter form submits normally); with it, results update in place
   and the address bar keeps a shareable link. The server sends only the results when asked with X-Finder: 1. */
(function () {
  document.documentElement.classList.add('js');

  /* ---------- picture switcher on cards: [data-card-gallery] holds [[src, alt], …] ---------- */
  document.addEventListener('click', function (e) {
    var b = e.target.closest('[data-card-step]');
    if (!b) return;
    var box = b.closest('[data-card-gallery]'), list;
    try { list = JSON.parse(box.getAttribute('data-card-gallery')); } catch (err) { return; }
    var i = ((+box.getAttribute('data-i') || 0) + (+b.getAttribute('data-card-step')) + list.length) % list.length;
    box.setAttribute('data-i', i);
    var img = box.querySelector('img');
    var pic = img.closest('picture');
    if (pic) pic.querySelectorAll('source').forEach(function (s) { s.remove(); });
    img.removeAttribute('srcset'); img.src = list[i][0]; img.alt = list[i][1];
    var c = box.querySelector('[data-card-count]'); if (c) c.textContent = (i + 1) + ' / ' + list.length;
  });

  /* ---------- gallery on a design page ---------- */
  var gal = document.querySelector('[data-gallery]');
  if (gal) {
    var thumbs = Array.prototype.slice.call(gal.querySelectorAll('[data-gallery-thumb]'));
    var main = gal.querySelector('[data-gallery-main]'), cap = gal.querySelector('[data-gallery-caption]'), cnt = gal.querySelector('[data-gallery-count]'), cur = 0;
    var go = function (i) {
      cur = (i + thumbs.length) % thumbs.length;
      var t = thumbs[cur], pic = main.closest('picture');
      if (pic) pic.querySelectorAll('source').forEach(function (s) { s.remove(); });
      main.removeAttribute('srcset'); main.src = t.getAttribute('data-src'); main.alt = t.getAttribute('data-alt');
      if (cap) cap.textContent = t.getAttribute('data-alt');
      if (cnt) cnt.textContent = (cur + 1) + ' / ' + thumbs.length;
      thumbs.forEach(function (x, k) { x.setAttribute('aria-current', String(k === cur)); });
      t.scrollIntoView({ block: 'nearest', inline: 'nearest' });
    };
    thumbs.forEach(function (t, i) { t.addEventListener('click', function () { go(i); }); });
    gal.querySelectorAll('[data-gallery-step]').forEach(function (b) { b.addEventListener('click', function () { go(cur + (+b.getAttribute('data-gallery-step'))); }); });
    gal.addEventListener('keydown', function (e) { if (e.key === 'ArrowRight') go(cur + 1); if (e.key === 'ArrowLeft') go(cur - 1); });
    var x0 = null;   // swipe on phones
    gal.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
    gal.addEventListener('touchend', function (e) { if (x0 === null) return; var dx = e.changedTouches[0].clientX - x0; if (Math.abs(dx) > 40) go(cur + (dx < 0 ? 1 : -1)); x0 = null; });
  }

  /* ---------- search boxes: at most N words ---------- */
  document.querySelectorAll('[data-word-limit]').forEach(function (inp) {
    var max = +inp.getAttribute('data-word-limit') || 4;
    var hint = inp.closest('form') && inp.closest('form').querySelector('[data-word-hint]');
    var base = hint ? hint.textContent : '';
    inp.addEventListener('input', function () {
      var words = inp.value.replace(/^\s+/, '').split(/\s+/);
      if (words.length > max && words[max] !== '') {
        inp.value = words.slice(0, max).join(' ');
        if (hint) { hint.textContent = 'Search accepts up to ' + max + ' words.'; hint.classList.add('is-over'); }
      } else if (hint && hint.classList.contains('is-over')) { hint.textContent = base; hint.classList.remove('is-over'); }
    });
  });

  /* ---------- filters ---------- */
  var form = document.querySelector('[data-finder]');
  if (!form || !window.fetch || !window.history.pushState) return;
  var results = form.querySelector('[data-results]');
  var aside = form.querySelector('.finder-filters');
  var stateSel = form.querySelector('[data-state-select]'), citySel = form.querySelector('[data-city-select]'), areaSel = form.querySelector('[data-area-select]');
  var track = function (n, d) { if (window.entTrack) window.entTrack(n, d || {}); };
  var busy = null;

  // keep option labels without their counts, so counts can be rewritten
  form.querySelectorAll('select option').forEach(function (o) { o.setAttribute('data-label', o.textContent.replace(/\s\(\d+\)$/, '')); });

  // the address for the current form: one value per name, lists joined with commas, empties left out
  var queryOf = function () {
    var map = {}, order = [];
    new FormData(form).forEach(function (v, k) {
      k = k.replace(/\[\]$/, ''); v = String(v).trim();
      if (v === '' || (k === 'sort' && (v === 'new' || v === 'best'))) return;
      if (!map[k]) { map[k] = []; order.push(k); }
      map[k].push(v);
    });
    return order.map(function (k) { return k + '=' + map[k].map(encodeURIComponent).join(','); }).join('&');
  };

  // put the values from an address back into the form (back button, chips, pages)
  var fill = function (search) {
    var p = {};
    search.replace(/^\?/, '').split('&').forEach(function (kv) {
      if (!kv) return;
      var i = kv.indexOf('='), k = decodeURIComponent(i < 0 ? kv : kv.slice(0, i)).replace(/\[\]$/, ''), v = i < 0 ? '' : decodeURIComponent(kv.slice(i + 1).replace(/\+/g, ' '));
      p[k] = (p[k] || []).concat(v.split(','));
    });
    Array.prototype.forEach.call(form.elements, function (el) {
      if (!el.name) return;
      var k = el.name.replace(/\[\]$/, ''), vals = p[k] || [];
      if (el.type === 'checkbox' || el.type === 'radio') el.checked = vals.length ? vals.indexOf(el.value) > -1 : el.value === '';
      else if (el.tagName === 'SELECT' || el.type === 'search' || el.type === 'text' || el.inputMode === 'numeric' || el.tagName === 'INPUT') { if (el.type !== 'hidden' || k === 'company') el.value = vals[0] || ''; }
    });
    narrowCities();
  };

  // show only the cities of the chosen state
  var narrowCities = function () {
    if (!stateSel || !citySel) return;
    var st = stateSel.value;
    Array.prototype.forEach.call(citySel.options, function (o) { if (o.value) o.hidden = !!st && o.getAttribute('data-state') !== st; });
    var sel = citySel.options[citySel.selectedIndex];
    if (sel && sel.value && sel.hidden) citySel.value = '';
  };
  narrowCities();

  var setAreas = function (list, chosen) {
    if (!areaSel) return;
    areaSel.innerHTML = '';
    var first = document.createElement('option'); first.value = ''; first.textContent = list.length ? 'All areas' : 'Choose a city first'; areaSel.appendChild(first);
    list.forEach(function (a) { var o = document.createElement('option'); o.value = a; o.textContent = a; if (a === chosen) o.selected = true; areaSel.appendChild(o); });
    areaSel.disabled = !list.length;
  };

  var load = function (url, push) {
    if (busy) busy.abort();
    busy = window.AbortController ? new AbortController() : null;
    results.classList.add('is-loading');
    fetch(url, { headers: { 'X-Finder': '1', 'Accept': 'application/json' }, signal: busy ? busy.signal : undefined, credentials: 'same-origin' })
      .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
      .then(function (res) {
        results.innerHTML = res.html;
        results.classList.remove('is-loading');
        form.querySelectorAll('[data-fc]').forEach(function (el) {
          var n = res.counts[el.getAttribute('data-fc')] || 0;
          el.textContent = n;
          if (n) el.removeAttribute('data-zero'); else el.setAttribute('data-zero', '');
        });
        form.querySelectorAll('select[name="state"], select[name="city"]').forEach(function (s) {
          Array.prototype.forEach.call(s.options, function (o) {
            if (!o.value) return;
            o.textContent = o.getAttribute('data-label') + ' (' + (res.counts[s.name + ':' + o.value] || 0) + ')';
          });
        });
        if (res.areas) setAreas(res.areas, res.area);
        if (push) history.pushState({ finder: 1 }, '', url);
        var top = results.getBoundingClientRect().top;
        if (top < 0 || top > window.innerHeight * 0.8) results.scrollIntoView({ behavior: 'smooth', block: 'start' });
        track('filter_results', { results: res.total, query: url.split('?')[1] || '' });
      })
      .catch(function (err) { if (err.name !== 'AbortError') location.href = url; });
  };
  var apply = function () { var q = queryOf(); load(form.getAttribute('action') + (q ? '?' + q : ''), true); };

  form.addEventListener('change', function (e) {
    var el = e.target;
    if (el === stateSel) { narrowCities(); if (citySel && citySel.value && citySel.options[citySel.selectedIndex].hidden) citySel.value = ''; if (areaSel) areaSel.value = ''; }
    if (el === citySel) {
      if (areaSel) areaSel.value = '';
      var o = citySel.options[citySel.selectedIndex];
      if (o && o.value && stateSel) stateSel.value = o.getAttribute('data-state');
    }
    if (el.matches('input[type="search"], input[type="text"], input[inputmode="numeric"], input[list]')) return;   // text boxes apply on Enter
    apply();
  });
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var pin = form.querySelector('[name="pin"]');
    if (pin && pin.value && !/^[1-9][0-9]{5}$/.test(pin.value)) { pin.focus(); pin.setCustomValidity('Enter a 6-digit pincode'); pin.reportValidity(); pin.setCustomValidity(''); return; }
    closeFilters(); apply();
  });
  // chips, pages and "clear all" inside the results update in place too
  form.addEventListener('click', function (e) {
    var a = e.target.closest('.fchips a, .pager a, .fempty a, .finder-filters__head a');
    if (!a || e.ctrlKey || e.metaKey || e.shiftKey) return;
    e.preventDefault();
    fill(a.search); load(a.href, true);
  });
  window.addEventListener('popstate', function () { fill(location.search); load(location.href, false); });

  /* filters drawer on phones and tablets */
  var openFilters = function () { aside.classList.add('is-open'); document.body.classList.add('filters-open'); var b = form.querySelector('[data-filter-toggle]'); if (b) b.setAttribute('aria-expanded', 'true'); };
  var closeFilters = function () { aside.classList.remove('is-open'); document.body.classList.remove('filters-open'); var b = form.querySelector('[data-filter-toggle]'); if (b) b.setAttribute('aria-expanded', 'false'); };
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-filter-toggle]')) { openFilters(); return; }
    if (e.target.closest('[data-filter-close]')) { closeFilters(); return; }
    if (document.body.classList.contains('filters-open') && !e.target.closest('.finder-filters')) closeFilters();
    var f = e.target.closest('[data-focus]');
    if (f) {   // "Find by" shortcuts: open the right filter and put the cursor in it
      var field = document.getElementById(f.getAttribute('data-focus'));
      if (!field) return;
      e.preventDefault();
      if (field.disabled && citySel) field = stateSel || citySel;
      var grp = field.closest('details'); if (grp) grp.open = true;
      if (window.matchMedia('(max-width: 1024px)').matches) openFilters();
      field.scrollIntoView({ block: 'center', behavior: 'smooth' });
      setTimeout(function () { field.focus(); }, 250);
    }
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeFilters(); });

  /* ---------- use my location: nearest listed city, worked out on this device only ---------- */
  var near = form.querySelector('[data-near-me]');
  if (near) {
    if (!navigator.geolocation) near.hidden = true;
    near.addEventListener('click', function () {
      var cities; try { cities = JSON.parse(near.getAttribute('data-cities')); } catch (err) { return; }
      var hint = form.querySelector('[data-word-hint]'), label = near.textContent;
      near.disabled = true; near.textContent = 'Finding you…';
      navigator.geolocation.getCurrentPosition(function (pos) {
        var la = pos.coords.latitude, lo = pos.coords.longitude, best = null, bestD = 1e9, rad = Math.PI / 180;
        Object.keys(cities).forEach(function (k) {
          var c = cities[k], dLa = (c[0] - la) * rad, dLo = (c[1] - lo) * rad;
          var h = Math.sin(dLa / 2) * Math.sin(dLa / 2) + Math.cos(la * rad) * Math.cos(c[0] * rad) * Math.sin(dLo / 2) * Math.sin(dLo / 2);
          var d = 12742 * Math.asin(Math.sqrt(h));
          if (d < bestD) { bestD = d; best = k; }
        });
        near.disabled = false; near.textContent = label;
        if (!best) return;
        if (stateSel) stateSel.value = cities[best][3];
        narrowCities();
        if (citySel) citySel.value = best;
        if (areaSel) areaSel.value = '';
        var nearBox = form.querySelector('[name="near"]'); if (nearBox) nearBox.value = '';
        if (hint) hint.textContent = 'Nearest city with listings: ' + cities[best][2] + (bestD > 60 ? ' (about ' + Math.round(bestD) + ' km away)' : '') + '.';
        track('near_me', { city: best, km: Math.round(bestD) });
        apply();
      }, function () {
        near.disabled = false; near.textContent = label;
        if (hint) hint.textContent = 'Location is off. Type your area, pincode or apartment instead.';
      }, { enableHighAccuracy: false, timeout: 10000, maximumAge: 600000 });
    });
  }
})();
