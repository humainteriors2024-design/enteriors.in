<?php
/* =====================================================================
   ENTERIORS — STRUCTURED DATA (JSON-LD), built for every page from
   config.php (brand, NAP, social, authors) and the page's $page block.
   Nothing to write per page. Test any URL at search.google.com/test/rich-results
   ===================================================================== */

function schema_json($page, $crumbs, $canonical) {
  $u = SITE['url'];
  $id = fn($frag) => $u . '/#' . $frag;

  // Organization (or LocalBusiness subtype) with NAP — the same on every page
  $address = array_filter([
    '@type' => 'PostalAddress', 'streetAddress' => NAP['street'], 'addressLocality' => NAP['locality'],
    'addressRegion' => NAP['region'], 'postalCode' => NAP['postal_code'], 'addressCountry' => NAP['country'],
  ]);
  $org = array_filter([
    '@type' => NAP['schema_type'], '@id' => $id('org'), 'name' => SITE['name'], 'legalName' => NAP['legal_name'],
    'url' => $u . '/', 'logo' => $u . SITE['logo'], 'image' => $u . SITE['image'], 'description' => SITE['description'],
    'email' => NAP['email'], 'telephone' => NAP['phone'], 'address' => count($address) > 2 ? $address : null,
    'areaServed' => array_map(fn($c) => ['@type' => 'City', 'name' => $c], NAP['area_served']),
    'sameAs' => array_values(array_filter(SOCIAL)),
    'contactPoint' => (NAP['phone'] || NAP['email']) ? array_filter(['@type' => 'ContactPoint', 'contactType' => 'customer service',
      'telephone' => NAP['phone'], 'email' => NAP['email'], 'areaServed' => 'IN', 'availableLanguage' => ['English', 'Hindi', 'Kannada']]) : null,
  ]);
  if (NAP['schema_type'] !== 'Organization') {           // LocalBusiness-only fields
    $org['openingHours'] = NAP['hours'];
    if (NAP['geo']['lat']) $org['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => NAP['geo']['lat'], 'longitude' => NAP['geo']['lng']];
    if (NAP['map_url']) $org['hasMap'] = NAP['map_url'];
  }

  $website = ['@type' => 'WebSite', '@id' => $id('website'), 'url' => $u . '/', 'name' => SITE['name'],
              'inLanguage' => SITE['language'], 'publisher' => ['@id' => $id('org')]];

  // Every page is a WebPage linked to the site and its breadcrumb
  $webpage = array_filter([
    '@type' => $page['schema_type'] ?? ($page['type'] === 'page' && str_contains($canonical, '/contact/') ? 'ContactPage' : ($page['type'] === 'page' && str_contains($canonical, '/about/') ? 'AboutPage' : 'WebPage')),   // hubs set 'schema_type' => 'CollectionPage'
    '@id' => $canonical . '#webpage', 'url' => $canonical, 'name' => $page['seo_title'] ?? $page['title'],
    'description' => $page['description'], 'isPartOf' => ['@id' => $id('website')], 'inLanguage' => SITE['language'],
    'breadcrumb' => count($crumbs) > 1 ? ['@id' => $canonical . '#breadcrumb'] : null,
    'dateModified' => $page['updated'] ?: null,
  ]);

  $graph = [$org, $website, $webpage];

  if (count($crumbs) > 1) {
    $graph[] = ['@type' => 'BreadcrumbList', '@id' => $canonical . '#breadcrumb',
      'itemListElement' => array_map(fn($c, $i) => ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $c['name'], 'item' => $u . $c['url']], $crumbs, array_keys($crumbs))];
  }

  if (in_array($page['type'], ['pillar', 'article', 'compare', 'post'])) {
    global $hub;
    $a = AUTHORS[$page['author']] ?? null;
    $isPost = $page['type'] === 'post';
    $inPillar = $hub && $page['type'] !== 'pillar' && is_live($hub['href']);
    // Pillar pages list their live cluster pages; cluster pages and posts point up to their pillar
    $parts = [];
    if ($page['type'] === 'pillar' && $hub) foreach ($hub['groups'] as $g) foreach ($g['links'] as $l)
      if (is_live($l['href']) && $l['href'] !== $hub['href']) $parts[$l['href']] = ['@type' => 'Article', 'url' => $u . $l['href'], 'name' => $l['label']];
    $graph[] = array_filter([
      '@type' => $isPost ? 'BlogPosting' : 'Article', '@id' => $canonical . '#article', 'headline' => $page['title'], 'description' => $page['description'],
      'mainEntityOfPage' => ['@id' => $canonical . '#webpage'], 'image' => $u . $page['image'],
      'datePublished' => $page['published'], 'dateModified' => $page['updated'] ?: $page['published'],
      'articleSection' => $isPost ? ($page['category'] ?? null) : null,
      'contentLocation' => ($isPost && !empty($page['location'])) ? ['@type' => 'Place', 'name' => $page['location']] : null,
      'author' => $a ? (($a['type'] ?? 'Person') === 'Organization' ? ['@id' => $id('org')]   // the brand itself (the Organization node above)
                         : array_filter(['@type' => 'Person', 'name' => $a['name'], 'url' => $u . $a['url'], 'jobTitle' => $a['role'], 'sameAs' => $a['same_as'] ?: null])) : null,
      'publisher' => ['@id' => $id('org')], 'inLanguage' => SITE['language'],
      'abstract' => $page['quick_answer'] ?: null,                                   // the answer-first summary AI engines quote
      'about' => $hub && !empty($hub['keyword']) ? ['@type' => 'Thing', 'name' => $hub['keyword']] : null,
      'isPartOf' => $inPillar ? ['@type' => 'WebPage', '@id' => $u . $hub['href'] . '#webpage', 'url' => $u . $hub['href'], 'name' => $hub['label'] . ' guide'] : null,
      'hasPart' => $parts ? array_values($parts) : null,
      // Citations and the parts written to be read aloud / quoted by assistants
      'citation' => $page['sources'] ? array_values(array_map(fn($s) => array_filter(['@type' => 'CreativeWork', 'name' => ((array) $s)[0], 'url' => ((array) $s)[1] ?? null]), $page['sources'])) : null,
      'speakable' => ($page['quick_answer'] || $page['takeaways']) ? ['@type' => 'SpeakableSpecification', 'cssSelector' => array_values(array_filter([$page['quick_answer'] ? '#quick-answer' : null, $page['takeaways'] ? '#key-takeaways' : null]))] : null,
      'keywords' => $page['keywords'] ?? null,
      'spatialCoverage' => ['@type' => 'Place', 'name' => 'India'],
    ]);
  }

  if ($page['type'] === 'tool') {
    $graph[] = ['@type' => 'WebApplication', 'name' => $page['title'], 'description' => $page['description'], 'url' => $canonical,
      'applicationCategory' => 'FinanceApplication', 'operatingSystem' => 'Any', 'isAccessibleForFree' => true, 'browserRequirements' => 'Any modern browser',
      'featureList' => 'Instant estimate with GST; city-adjusted rates; rates as of ' . ($page['rates_as_of'] ?? '') . '; estimate attached to quote requests',
      'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'INR'], 'publisher' => ['@id' => $id('org')]];
  }

  if (FAQ_SCHEMA && $page['faq']) {
    $graph[] = ['@type' => 'FAQPage', 'mainEntity' => array_map(fn($q, $a) => ['@type' => 'Question', 'name' => $q,
      'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a]], array_keys($page['faq']), $page['faq'])];
  }

  // Extra schema a page adds itself, e.g. an ItemList on a "Top 20" page
  foreach ($page['schema_extra'] ?? [] as $extra) $graph[] = $extra;

  return json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
