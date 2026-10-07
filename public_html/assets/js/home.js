/* ENTERIORS — HOME PAGE ONLY: the search box. It filters the list of live pages printed
   by index.php (built from includes/nav.php and the blog posts), so it needs no server.
   The cost estimator on the home page is /assets/js/calc.js (worked out on the server). */
(function () {
  var search = document.querySelector('[data-search]');
  if (!search) return;
  var input = search.querySelector('input'), items = search.querySelectorAll('.search__list li');
  var filter = function () {
    var words = input.value.trim().toLowerCase().split(/\s+/).filter(Boolean), shown = 0;
    items.forEach(function (li) {
      var text = li.textContent.toLowerCase();
      var ok = words.every(function (w) { return text.indexOf(w) > -1; });
      li.hidden = !ok || (!words.length && shown >= 8);
      if (!li.hidden) shown++;
    });
    search.classList.toggle('is-empty', shown === 0);
  };
  input.addEventListener('focus', function () { search.classList.add('is-open'); filter(); });
  input.addEventListener('input', filter);
  input.addEventListener('blur', function () { setTimeout(function () { search.classList.remove('is-open'); }, 200); });
  search.addEventListener('submit', function () { var first = search.querySelector('.search__list li:not([hidden]) a'); if (first) location.href = first.href; });
})();
