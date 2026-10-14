/* ENTERIORS — every calculator on the site (home estimator, kitchen, wardrobe, room-by-room quote).
   There are NO prices in this file. Each change is sent to /api/calculate.php, which works the
   estimate out on the server from includes/calc/rates.php and sends back the text for every
   [data-out="…"] box. The page already shows the first result (printed by PHP), so it works
   and reads correctly even before this script runs.

   Markup:  <div data-calc="home|kitchen|wardrobe|quote"> <form>…fields…</form> …[data-out] boxes… </div>
            data-fill='{"base":12,"wall":9}' on a radio or <option> fills other fields when chosen.
   Tracking: calc_start (first change), calc_result (after the visitor pauses), both with the pillar. */
(function () {
  var API = '/api/calculate.php';
  window.ENT = window.ENT || {};
  var track = function (n, d) { if (window.entTrack) window.entTrack(n, d || {}); };

  document.querySelectorAll('[data-calc]').forEach(function (box) {
    var type = box.getAttribute('data-calc'), form = box.querySelector('form');
    var calcName = { home: 'interior_cost', kitchen: 'modular_kitchen', wardrobe: 'wardrobe_cost', quote: 'room_by_room_quote' }[type] || type;
    var use = function (action) { track('calculator_use', { calculator_name: calcName, calc_action: action }); };
    if (!form) return;
    var seq = 0, timer = null, idle = null, started = false, logged = false, last = null;

    function show(out) {
      Object.keys(out).forEach(function (k) {
        box.querySelectorAll('[data-out="' + k + '"]').forEach(function (el) { if (el.innerHTML !== out[k]) el.innerHTML = out[k]; });
      });
    }
    function send(log) {
      var fd = new FormData(form), my = ++seq;
      fd.append('calc', type); fd.append('sent', '1'); fd.append('page', location.pathname);
      if (window.ENT_PAGE) fd.append('pillar', ENT_PAGE.pillar);
      if (log) fd.append('log', '1');
      box.classList.add('is-busy');
      return fetch(API, { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (my !== seq) return;                       // a newer request is on its way
          box.classList.remove('is-busy');
          if (!res.ok) return;
          show(res.out); last = res;
          // the latest estimate travels with any enquiry sent from this page (see site.js)
          if (started) ENT.calc = { type: type, total: res.total, summary: res.summary, token: res.token };
        })
        .catch(function () { box.classList.remove('is-busy'); });
    }
    function fill(el) {
      var src = el.tagName === 'SELECT' ? el.options[el.selectedIndex] : el;
      var data = src && src.getAttribute('data-fill');
      if (!data || (el.type === 'radio' && !el.checked)) return;
      try { data = JSON.parse(data); } catch (e) { return; }
      Object.keys(data).forEach(function (k) { if (form.elements[k]) form.elements[k].value = data[k]; });
    }
    function changed(e) {
      if (e && e.target) fill(e.target);
      if (!started) { started = true; use('start'); }
      clearTimeout(timer); timer = setTimeout(function () { send(false); }, 160);
      clearTimeout(idle);                              // once the visitor pauses, log the result (once per page view)
      idle = setTimeout(function () {
        send(!logged).then(function () { if (last && !logged) { logged = true; use('result'); } });
      }, 4000);
    }
    // Interior quote: a home type ticks the usual modules in its rooms and clears the others
    // (runs before the form's own change handler, so the server sees the new ticks)
    form.querySelectorAll('[data-preset]').forEach(function (r) {
      r.addEventListener('change', function () {
        if (!r.checked || r.value === 'custom') return;
        var areas = (r.getAttribute('data-preset') || '').split(',');
        box.querySelectorAll('details.q-area').forEach(function (d) {
          var inHome = areas.indexOf(d.getAttribute('data-area')) > -1;
          d.querySelectorAll('input[type="checkbox"][data-default]').forEach(function (c) { c.checked = inHome && c.getAttribute('data-default') === '1'; });
        });
      });
    });
    // Changing one material by hand means the package no longer applies as a whole
    form.querySelectorAll('select[data-spec]').forEach(function (s) {
      s.addEventListener('change', function () {   // a package fills the selects without firing change, so this is always the visitor
        form.querySelectorAll('input[name="package"]').forEach(function (p) { p.checked = false; });
      });
    });
    form.addEventListener('input', changed);
    form.addEventListener('change', changed);
    form.addEventListener('submit', function (e) { e.preventDefault(); changed(); });

    // Buttons that lead to a quote form are counted as cta_click by track.js (cta_location = calculator)
    // Room-by-room quote: collapse / expand all, print
    box.querySelectorAll('[data-expand]').forEach(function (b) {
      b.addEventListener('click', function () { var open = b.getAttribute('data-expand') === 'open'; box.querySelectorAll('details.q-area').forEach(function (d) { d.open = open; }); });
    });
    box.querySelectorAll('[data-print]').forEach(function (b) {
      b.addEventListener('click', function () { box.querySelectorAll('details.q-area').forEach(function (d) { d.open = true; }); use('print_pdf'); window.print(); });
    });
  });
})();
