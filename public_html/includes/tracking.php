<?php
/* =====================================================================
   ENTERIORS — TRACKING (GA4, Google Tag Manager, Google Ads, Meta Pixel, Microsoft Clarity)
   IDs come from config.php → TRACKING. Nothing loads on staging.

   WHICH ID A PAGE USES — most specific wins:
     1. config.php → TRACKING                          the whole site
     2. includes/nav.php → a pillar's 'tracking'        every page in that pillar (pillar page,
                                                        its cluster pages and its blog posts)
     3. the page's own $page['tracking']                one page
   e.g. 'tracking' => ['meta_pixel' => '1234567890', 'ga4' => false]   (false = off for this page)

   WHAT EVERY PAGE SENDS (so reports can be cut by pillar):
     page_type      home | pillar | article | compare | post | tool | page
     pillar         pillar key, e.g. "modular-kitchen" (or "none")
     content_group  pillar name, e.g. "Modular Kitchen" — GA4's built-in Content group report
     page_role      pillar-page | cluster-page | blog-post | calculator | other
     author, published
   GA4: sent with the page view (content_group is automatic; register page_type, pillar and
        page_role as custom dimensions in GA4 → Admin → Custom definitions to see them).
   GTM: pushed to the dataLayer as event "page_meta" before GTM loads.
   Meta: PageView, plus ViewContent with content_category = pillar on guides, posts and calculators.

   EVENTS (site.js and calc.js call entTrack(name, data); pillar and page_type are added to all):
     generate_lead (+ Ads conversion, Meta Lead)   form_start        cta_click      toc_click
     scroll_depth (25/50/75/100)   article_read    calc_start        calc_result    calc_quote_click
     calc_print    click_call      click_whatsapp  outbound_click
   Leads are ALSO sent from the server (track_server_lead) when the API secret / token is set,
   so conversions are not lost to ad-blockers. Browser and server events share one event id,
   so Google and Meta count each lead once.
   ===================================================================== */

// IDs in force for this page (site → pillar → page)
function tracking_ids($page = []) {
  $ids = array_merge(TRACKING, $page['hub_tracking'] ?? [], $page['tracking'] ?? []);
  return array_map(fn($v) => $v === false ? '' : trim((string) $v), $ids);
}

// What we know about the page, in the shape every analytics tool receives
function tracking_meta($page, $hub = null) {
  $t = $page['type'] ?? 'page';
  $role = ['pillar' => 'pillar-page', 'article' => 'cluster-page', 'compare' => 'cluster-page', 'post' => 'blog-post', 'tool' => 'calculator', 'home' => 'home'][$t] ?? 'other';
  $a = AUTHORS[$page['author'] ?? ''] ?? null;
  return array_filter([
    'page_type' => $t, 'page_role' => $role,
    'pillar' => $hub['key'] ?? 'none', 'content_group' => $hub['label'] ?? ucfirst($role === 'other' ? 'Company' : $role),
    'post_category' => $page['category'] ?? null, 'author' => $a['name'] ?? null, 'published' => $page['published'] ?? null,
  ], fn($v) => $v !== null && $v !== '');
}

function tracking_head($page = [], $hub = null) {
  $t = tracking_ids($page);
  $meta = tracking_meta($page, $hub);
  $h = '';
  // Site verification tags are harmless on staging too
  if ($t['gsc_verification'])  $h .= '  <meta name="google-site-verification" content="' . e($t['gsc_verification']) . "\">\n";
  if ($t['bing_verification']) $h .= '  <meta name="msvalidate.01" content="' . e($t['bing_verification']) . "\">\n";
  if ($t['meta_domain_verification'] ?? '') $h .= '  <meta name="facebook-domain-verification" content="' . e($t['meta_domain_verification']) . "\">\n";
  $j = fn($v) => json_encode($v, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

  // The page facts and the event helper exist on staging too (so they can be tested); the tags do not
  $ads = ($t['google_ads'] && $t['google_ads_lead']) ? $j($t['google_ads'] . '/' . $t['google_ads_lead']) : 'null';
  $h .= '  <script>window.dataLayer=window.dataLayer||[];window.ENT_PAGE=' . $j($meta) . ';dataLayer.push(Object.assign({event:"page_meta"},ENT_PAGE));'
      . 'window.entTrack=function(n,d){d=Object.assign({},ENT_PAGE,d||{});var g={lead:"generate_lead",call:"click_call",whatsapp:"click_whatsapp"}[n]||n;'
      . 'dataLayer.push(Object.assign({event:g},d));'
      . 'if(window.gtag)gtag("event",g,d);'
      . 'if(!window.fbq)return;var o={eventID:d.lead_id||undefined};'
      . 'if(n==="lead"){var a=' . $ads . ';if(a&&window.gtag)gtag("event","conversion",{send_to:a,value:d.value,currency:"INR",transaction_id:d.lead_id});fbq("track","Lead",{content_category:d.pillar,content_name:d.form,value:d.value,currency:"INR"},o);}'
      . 'else if(n==="calc_result")fbq("trackCustom","CalculatorResult",{content_category:d.pillar,calc:d.calc,value:d.value,currency:"INR"});'
      . 'else if(/^(click_call|click_whatsapp)$/.test(g))fbq("track","Contact",{content_category:d.pillar,method:g});'
      . 'else if(g==="article_read")fbq("trackCustom","ArticleRead",{content_category:d.pillar});};'
      . "</script>\n";
  if (is_staging()) return $h . "  <!-- staging: tracking tags are off (dataLayer and entTrack still run, so events can be checked in the browser console) -->\n";

  if ($t['gtm']) $h .= "  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer'," . $j($t['gtm']) . ");</script>\n";

  $gtag = array_values(array_filter([$t['ga4'], $t['google_ads']]));
  if ($gtag) {
    $cfg = $meta; unset($cfg['published']);
    $h .= '  <script async src="https://www.googletagmanager.com/gtag/js?id=' . e($gtag[0]) . "\"></script>\n";
    $h .= '  <script>function gtag(){dataLayer.push(arguments);}gtag("js",new Date());'
        . ($t['ga4'] ? 'gtag("config",' . $j($t['ga4']) . ',' . $j($cfg) . ');' : '')
        . ($t['google_ads'] ? 'gtag("config",' . $j($t['google_ads']) . ');' : '') . "</script>\n";
  }
  if ($t['meta_pixel']) {
    $vc = in_array($meta['page_role'], ['pillar-page', 'cluster-page', 'blog-post', 'calculator'])
        ? "fbq('track','ViewContent'," . $j(['content_category' => $meta['pillar'], 'content_name' => $page['title'] ?? '', 'content_type' => $meta['page_role']]) . ");" : '';
    $h .= "  <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init'," . $j($t['meta_pixel']) . ");fbq('track','PageView');$vc</script>\n";
  }
  if ($t['clarity']) $h .= '  <script>(function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);})(window,document,"clarity","script",' . $j($t['clarity']) . ');clarity("set","pillar",' . $j($meta['pillar']) . ');clarity("set","page_type",' . $j($meta['page_type']) . ");</script>\n";
  return $h;
}

function tracking_body($page = []) {
  $t = tracking_ids($page);
  if (is_staging() || !$t['gtm']) return '';
  return '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . e($t['gtm']) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n";
}

/* Server-side lead event — GA4 Measurement Protocol and Meta Conversions API.
   Runs only on the live site, only when the secret/token is set, never slows the visitor (2 s timeout). */
function track_server_lead($lead, $eventId) {
  if (is_staging()) return;
  $hub = ($lead['pillar'] ?? '') ? hub($lead['pillar']) : hub_for(rtrim($lead['source'] ?: '/', '/') . '/');
  $t = tracking_ids(['hub_tracking' => $hub['tracking'] ?? []]);
  $post = function ($url, $body) {
    @file_get_contents($url, false, stream_context_create(['http' => ['method' => 'POST', 'header' => "Content-Type: application/json\r\n", 'content' => json_encode($body), 'timeout' => 2, 'ignore_errors' => true]]));
  };
  $value = (int) ($lead['estimate_total'] ?? 0);
  if ($t['ga4'] && ($t['ga4_api_secret'] ?? '')) {
    $cid = preg_match('/^GA\d\.\d\.(\d+\.\d+)$/', $_COOKIE['_ga'] ?? '', $m) ? $m[1] : (random_int(1e9, 9e9) . '.' . time());
    $post('https://www.google-analytics.com/mp/collect?measurement_id=' . rawurlencode($t['ga4']) . '&api_secret=' . rawurlencode($t['ga4_api_secret']), [
      'client_id' => $cid, 'events' => [['name' => 'generate_lead_server', 'params' => array_filter([
        'form' => $lead['form'], 'pillar' => $hub['key'] ?? 'none', 'page_location' => SITE['url'] . $lead['source'], 'lead_id' => $eventId,
        'value' => $value ?: null, 'currency' => $value ? 'INR' : null, 'city' => $lead['city'],
      ])]],
    ]);
  }
  if ($t['meta_pixel'] && ($t['meta_capi_token'] ?? '')) {
    $user = array_filter([
      'ph' => [hash('sha256', '91' . $lead['phone'])], 'em' => $lead['email'] ? [hash('sha256', strtolower(trim($lead['email'])))] : null,
      'ct' => $lead['city'] ? [hash('sha256', strtolower(preg_replace('/[^a-z]/i', '', $lead['city'])))] : null, 'country' => [hash('sha256', 'in')],
      'client_ip_address' => $_SERVER['REMOTE_ADDR'] ?? null, 'client_user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
      'fbp' => $_COOKIE['_fbp'] ?? null, 'fbc' => $_COOKIE['_fbc'] ?? null,
    ]);
    $body = ['data' => [['event_name' => 'Lead', 'event_time' => time(), 'event_id' => $eventId, 'action_source' => 'website',
      'event_source_url' => SITE['url'] . $lead['source'], 'user_data' => $user,
      'custom_data' => array_filter(['content_category' => $hub['key'] ?? 'none', 'content_name' => $lead['form'], 'value' => $value ?: null, 'currency' => $value ? 'INR' : null])]]];
    if ($t['meta_test_code'] ?? '') $body['test_event_code'] = $t['meta_test_code'];
    $post('https://graph.facebook.com/' . rawurlencode($t['meta_api_version'] ?: 'v24.0') . '/' . rawurlencode($t['meta_pixel']) . '/events?access_token=' . rawurlencode($t['meta_capi_token']), $body);
  }
}
