<?php
/* =====================================================================
   ENTERIORS — BOTTOM OF EVERY PAGE — closes the layout opened in head.php and adds, in the
   same order on every page of a type: verdict → pillar link (posts) → FAQ → CTA →
   lead form (posts) → related → author → share, then the footer, pop-up form and scripts.
   It also builds the table of contents from the page's <h2> headings.
   ===================================================================== */
$t = $page['type'];

/* ---------- Close the reading layout (pillar, article, compare, post) ---------- */
if ($reading):
  echo "<!--/PROSE-->\n    </div>\n";   // .prose

  if ($page['verdict']): ?>
    <section class="mt-8">
      <h2 id="verdict" class="mb-6">The verdict</h2>
      <div class="verdict">
<?php foreach ($page['verdict'] as $name => $points): ?>
        <div class="verdict__option"><h3>Choose <?= e($name) ?> if…</h3><ul><?php foreach ($points as $p) echo '<li>' . e($p) . '</li>'; ?></ul></div>
<?php endforeach; ?>
      </div>
    </section>
<?php endif;

  if ($t === 'post') echo component('cta', ['variant' => 'pillar', 'hub' => $hub]);   // blog posts feed their pillar

  // Sources, standards and method: citations make a page more trustworthy to readers and to AI answer engines
  if ($page['sources']): ?>
    <section class="sources mt-8" id="sources">
      <h2 class="mb-4">Sources, standards and method</h2>
      <ul>
<?php foreach ($page['sources'] as $s): [$label, $url, $note] = array_pad((array) $s, 3, '');
        $internal = $url && $url[0] === '/';
        if ($internal && !is_live($url)) continue;   // our own page not uploaded yet: leave it out rather than show a dead link ?>
        <li><?= $url ? '<a href="' . e($url) . '"' . ($internal ? '' : ' rel="noopener" target="_blank"') . '>' . e($label) . '</a>' : e($label) ?><?= $note ? ' — ' . e($note) : '' ?></li>
<?php endforeach; ?>
      </ul>
      <p class="sources__method">Prices are indicative planning ranges for Bengaluru, reviewed <?= e(date('F Y', strtotime($page['updated'] ?: 'now'))) ?>, and exclude GST unless stated. Confirm them with current quotations; materials and rates change. Dimensions are typical good practice, not building-code requirements, unless a standard is named.</p>
    </section>
<?php endif;
  echo component('faq');
  echo $t === 'pillar' ? component('cta', ['variant' => 'service']) : component('cta-band');
  if ($t === 'post') echo component('lead-form', ['variant' => 'compact', 'id' => 'post-lead', 'title' => 'Planning your ' . strtolower($page['category'] ?? 'home') . '? Get a free call back']);

  // Related block: the first three listed pages that are uploaded (list the pillar first, then sibling pages).
  // A page that lists none gets its pillar + the nearest live pages from the same group in nav.php.
  if (!$page['related'] && $hub && $t !== 'pillar') {
    $page['related'][] = [$hub['href'], ucfirst($hub['keyword'] ?? $hub['label']) . ' guide', $hub['blurb'] ?? '', 'Pillar guide'];
    $groups = $hub['groups'];
    usort($groups, fn($a, $b) => (int) in_array($path, array_column($b['links'], 'href')) - (int) in_array($path, array_column($a['links'], 'href')));
    foreach ($groups as $g) foreach ($g['links'] as $l) $page['related'][] = [$l['href'], $l['label'], '', $g['title']];
  }
  $relatedLive = array_slice(array_filter($page['related'], fn($r) => is_live($r[0]) && $r[0] !== $path), 0, 3);
  $relatedHtml = implode('', array_map(fn($r) => card($r[0], $r[1], $r[2] ?? '', $r[3] ?? '', '', 'boxed'), $relatedLive));
  if ($relatedHtml): ?>
    <section class="mt-8"><h2 class="mb-6">Keep reading</h2><div class="grid"><?= $relatedHtml ?></div></section>
<?php endif;

  // Pillar pages list the blog posts that belong to them (posts link back up to the pillar)
  if ($t === 'pillar' && $hub && ($pillarPosts = posts(pillar: $hub['key'], limit: 3))): ?>
    <section class="mt-8"><h2 class="mb-6">From the blog</h2><div class="grid"><?php foreach ($pillarPosts as $po) echo component('post-card', ['post' => $po]); ?></div></section>
<?php endif;

  echo component('author');

  echo "  </article>\n  <aside class=\"page-grid__side\">";
  if ($t !== 'pillar') echo component('share');
  echo "</aside>\n</div>\n";
  if ($t === 'pillar') echo component('lead-form', ['variant' => 'full', 'id' => 'get-quote']);
endif;

/* ---------- Tool pages: lead form under the tool ---------- */
if ($t === 'tool') echo component('lead-form', ['variant' => 'full', 'id' => 'get-quote', 'eyebrow' => 'Exact quote', 'heading' => 'Want exact quotes for <em>this estimate?</em>']);
?>
</main>
<?php include __DIR__ . ($page['footer'] === 'minimal' ? '/footer-minimal.php' : '/footer.php'); ?>
<?= component('sticky-cta') ?>
<?= component('lead-dialog') ?>
<script src="/assets/js/site.js?v=<?= $ver('/assets/js/site.js') ?>" defer></script>
<?php foreach (array_unique($page['js']) as $js): $file = "/assets/js/$js.js"; ?>
<script src="<?= $file ?>?v=<?= $ver($file) ?>" defer></script>
<?php endforeach; ?>
</body>
</html>
<?php
/* ---------- Table of contents + heading anchors + reading time + mid-article CTA (server-side) ---------- */
$html = ob_get_clean();
if (preg_match('#<article>(.*)</article>#s', $html, $m)) {
  $article = $m[1]; $used = [];
  // 1. give every <h2> without an id one made from its text
  $article2 = preg_replace_callback('#<h2(?![^>]*\bid=)([^>]*)>(.*?)</h2>#s', function ($h) use (&$used) {
    $id = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower(trim(strip_tags($h[2])))), '-') ?: 'section';
    while (isset($used[$id])) $id .= '-2';
    $used[$id] = true;
    return "<h2 id=\"$id\"{$h[1]}>{$h[2]}</h2>";
  }, $article);
  // 2. blog posts: the same call-to-action strip before the middle <h2> of every post
  if ($t === 'post' && $page['mid_cta'] && preg_match('#<!--PROSE-->(.*?)<!--/PROSE-->#s', $article2, $pm)) {
    $parts = preg_split('#(?=<h2\b)#', $pm[1]);
    if (count($parts) > 4) {
      array_splice($parts, (int) ceil(count($parts) / 2), 0, [component('cta', ['variant' => 'strip'])]);
      $article2 = str_replace($pm[1], implode('', $parts), $article2);
    }
  }
  $html = str_replace($article, $article2, $html);
  // 3. contents list = the <h2>s in the main text, plus verdict and FAQ (only if 3+)
  preg_match('#<!--PROSE-->(.*?)<!--/PROSE-->#s', $article2, $pm);
  preg_match_all('#<h2[^>]*\bid="([^"]+)"[^>]*>(.*?)</h2>#s', $pm[1] ?? '', $hs, PREG_SET_ORDER);
  foreach (['verdict' => 'The verdict', 'sources' => 'Sources and method', 'faq' => 'Frequently asked questions'] as $id => $label)
    if (str_contains($article2, "id=\"$id\"")) $hs[] = [null, $id, $label];
  $tocHtml = '';
  if (count($hs) > 2) {
    $tocHtml = '<nav class="toc" aria-label="On this page"><details open><summary class="toc__title">On this page</summary><ol>';
    foreach ($hs as $h) $tocHtml .= '<li><a href="#' . e($h[1]) . '">' . e(trim(strip_tags($h[2]))) . '</a></li>';
    $tocHtml .= '</ol></details></nav>';
  }
  $html = str_replace('<!--TOC-->', $tocHtml, $html);
  // 4. reading time from the main text
  if (preg_match('#<!--PROSE-->(.*?)<!--/PROSE-->#s', $html, $p)) {
    $mins = max(1, (int) round(str_word_count(strip_tags($p[1])) / 200));
    $html = str_replace('<!--READTIME-->', $mins . ' min read', $html);
  }
}
$html = str_replace(['<!--TOC-->', '<span><!--READTIME--></span>', '<!--PROSE-->', '<!--/PROSE-->'], '', $html);

/* "Terms explained" lists (<dl class="terms">) also go out as DefinedTermSet structured data,
   so search and AI engines can read each definition as a definition. */
if (preg_match_all('#<dt>(.*?)</dt>\s*<dd>(.*?)</dd>#s', implode('', (preg_match_all('#<dl class="terms">(.*?)</dl>#s', $html, $dls) ? $dls[1] : [])), $terms, PREG_SET_ORDER)) {
  $set = ['@context' => 'https://schema.org', '@type' => 'DefinedTermSet', 'name' => 'Terms explained: ' . $page['title'], 'url' => $canonical,
          'hasDefinedTerm' => array_map(fn($x) => ['@type' => 'DefinedTerm', 'name' => trim(html_entity_decode(strip_tags($x[1]))), 'description' => trim(html_entity_decode(strip_tags($x[2])))], $terms)];
  $html = str_replace('</body>', '<script type="application/ld+json">' . json_encode($set, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n</body>", $html);
}

/* ---------- Links in the text to pages that are not uploaded yet ----------
   Write the link once, e.g. <a href="/cost/wardrobe-cost/">wardrobe cost</a>. While that page does not
   exist the words show as plain text (no broken link); the day you upload the page, the link switches on.
   On staging the words get a dotted underline so you can see which pages are still to write. */
if (!SHOW_ALL_LINKS) {
  $html = preg_replace_callback('#<a href="(/[a-z0-9/_\-]*/)(\#[^"]*)?">(.*?)</a>#s', function ($a) {
    if (is_live($a[1])) return $a[0];
    return is_staging() ? '<span class="link-planned" title="Planned page: ' . e($a[1]) . '">' . $a[3] . '</span>' : $a[3];
  }, $html);
}
echo $html;
