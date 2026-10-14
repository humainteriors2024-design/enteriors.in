<?php
/* =====================================================================
   ENTERIORS — TRACKING: the ONE include for analytics (GA4 + Meta Pixel) and site verification.
   head.php prints tracking_head() in <head> and tracking_body() right after <body> on EVERY page
   (404, thank-you and verify included). /admin/ has its own pages and is never tracked.
   Settings: config.php → TRACKING_ON (the switch) and TRACKING (IDs). Full list of events and the
   GA4 settings to change: docs/ga4-setup.md.

   WHAT RUNS WHERE
     Always (even with tracking off):
       • site-verification meta tags (Search Console, Bing, Meta domain)
       • the first-visit cookie "ent_src" (utm_*, gclid, fbclid, referrer, landing page) that the server
         reads into every lead email — see first_touch() in leads.php (not set on /verify/: the email link
         is never anyone's first visit)
       • private values (?t= ?k= on the verify page, ?ref= on thank-you) are removed from the address
         bar before any tag can read them
       • window.entTrack(name, params): every event goes through it; it drops anything that looks like
         a name, email or phone number, and keeps a copy in window.entEvents (for testing in the console)
     Only when tracking_tags_on() (TRACKING_ON, live address or 'on_staging', not /admin/):
       • GA4 (gtag.js): ONE config call = ONE page_view, with page_type, content_group and site_section
         (on /verify/ with ignore_referrer, so a lead confirmed from Gmail keeps its real source)
       • Meta Pixel: PageView; Lead on a verified enquiry; Contact on call / WhatsApp taps
     /assets/js/track.js (every page): clicks, scroll depth and form views. site.js: the form funnel.
     calc.js / finder.js: calculator_use and filter_use.

   NEVER SENT to GA4 or Meta: name, email, phone, message, city typed in a form, or any value
   containing "@" or a phone-like number (entTrack filters them out as a safety net).
   ===================================================================== */

// Tags load only on the live site with TRACKING_ON (or on staging when TRACKING['on_staging']), never in /admin/
function tracking_tags_on() {
  if (!TRACKING_ON) return false;
  if (str_starts_with(current_path(), '/admin/')) return false;
  return !is_staging() || !empty(TRACKING['on_staging']);
}

/* The page_type sent with every page view and event (also used as GA4's built-in content_group):
   home | pillar | cluster | city | blog | tool | design | directory | form | other | not_found */
function tracking_page_type($page, $hub = null) {
  $path = current_path();
  $type = $page['type'] ?? 'page';
  if (http_response_code() === 404) return 'not_found';
  if ($path === '/') return 'home';
  if (in_array($path, ['/contact/', '/verify/', '/thank-you/'], true)) return 'form';
  if (str_starts_with($path, '/trending-designs/')) return 'design';
  if (str_starts_with($path, '/services/find-designer/')) return 'directory';
  if ($type === 'pillar') return 'pillar';
  if (str_starts_with($path, '/interior-designers/')) return 'city';
  if ($type === 'post' || str_starts_with($path, '/blogs/')) return 'blog';
  if ($type === 'tool' || str_starts_with($path, '/calculators/')) return 'tool';
  if (in_array($type, ['article', 'compare'], true)) return 'cluster';
  return 'other';
}

/* form_name and form_location for the form funnel. One map, used by the form markup (lead-form.php,
   finder.php) and by the verify page, so a lead confirmed from the email link carries the same names. */
const TRACK_FORM_NAMES = ['full' => 'free_consultation', 'compact' => 'call_back', 'inline' => 'call_back_strip',
                          'callback' => 'call_back_time_slot', 'quote' => 'get_3_quotes', 'enquiry' => 'listing_enquiry'];
function track_form_name($form) { return TRACK_FORM_NAMES[$form] ?? (preg_replace('/[^a-z0-9_]+/', '_', strtolower((string) $form)) ?: 'form'); }
function track_form_location($id, $variant) {
  $byId = ['popup' => 'popup', 'post-lead' => 'blog_post_end', 'get-quote' => 'page_bottom', 'home-callback' => 'home_strip', 'enquiry' => 'listing_popup'];
  if (isset($byId[$id])) return $byId[$id];
  if (str_starts_with((string) $id, 'sg-')) return 'style_guide';
  if (current_path() === '/contact/') return 'contact_page';
  return $variant === 'full' ? 'page_bottom' : 'in_page';
}
// data attributes printed on every form box: data-form-name, data-form-location (no personal data)
function track_form_attrs($id, $variant) {
  return ' data-form-name="' . e(track_form_name($variant)) . '" data-form-location="' . e(track_form_location($id, $variant)) . '"';
}

// Websites whose links count as partner_click (config.php → PARTNER and includes/data/partners.php)
function tracking_partner_hosts() {
  $urls = defined('PARTNER') && !empty(PARTNER['on']) ? [PARTNER['url']] : [];
  foreach (partner_links() as $list) if (is_array($list)) foreach ($list as $row) if (is_array($row) && isset($row[2])) $urls[] = $row[2];
  $hosts = array_map(fn($u) => preg_replace('/^www\./', '', strtolower((string) parse_url($u, PHP_URL_HOST))), $urls);
  return array_values(array_unique(array_filter($hosts)));
}

// What every page view and event carries
function tracking_meta($page, $hub = null) {
  $pt = tracking_page_type($page, $hub);
  return ['page_type' => $pt, 'content_group' => $pt, 'site_section' => $hub['key'] ?? 'none'];
}

function tracking_head($page = [], $hub = null) {
  $t = TRACKING;
  $j = fn($v) => json_encode($v, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
  $h = '';
  if ($t['gsc_verification'])         $h .= '  <meta name="google-site-verification" content="' . e($t['gsc_verification']) . "\">\n";
  if ($t['bing_verification'])        $h .= '  <meta name="msvalidate.01" content="' . e($t['bing_verification']) . "\">\n";
  if ($t['meta_domain_verification']) $h .= '  <meta name="facebook-domain-verification" content="' . e($t['meta_domain_verification']) . "\">\n";

  $on  = tracking_tags_on();
  $ga4 = $on && preg_match('/^G-[A-Z0-9]{4,20}$/', $t['ga4']) ? $t['ga4'] : '';
  $px  = $on && preg_match('/^\d{6,20}$/', $t['meta_pixel']) ? $t['meta_pixel'] : '';
  $ads = $on && preg_match('/^AW-\d+$/', $t['google_ads']) ? $t['google_ads'] : '';
  $cfg = [
    'ga4' => $ga4, 'pixel' => $px, 'ads' => $ads && $t['google_ads_lead'] ? $ads . '/' . $t['google_ads_lead'] : '',
    'host' => preg_replace('/^www\./', '', (string) parse_url(SITE['url'], PHP_URL_HOST)),
    'partners' => tracking_partner_hosts(),
    'forms' => TRACK_FORM_NAMES,
  ];

  // 1. bootstrap: first-visit cookie, clean address, debug / internal flags, the event helper (always)
  $h .= '  <script>' . "\n" . '(function(w,d){' . "\n"
    . 'var P=w.ENT_PAGE=' . $j(tracking_meta($page, $hub)) . ',C=w.ENT_TRACK=' . $j($cfg) . ',L=location,ss=w.sessionStorage,ls=w.localStorage;' . "\n"
    . 'w.entEvents=w.entEvents||[];' . "\n"
    . 'var get=function(s,k){try{return s.getItem(k)}catch(e){return null}},put=function(s,k,v){try{v===null?s.removeItem(k):s.setItem(k,v)}catch(e){}};' . "\n"
    . 'var q;try{q=new URLSearchParams(L.search)}catch(e){q={get:function(){return null},has:function(){return false}}}' . "\n"
    // first visit: kept 90 days in a first-party cookie, never overwritten (first touch)
    . 'try{if(!/(?:^|; )ent_src=/.test(d.cookie)&&L.pathname!=="/verify/"){var o=new URLSearchParams(),r=d.referrer||"";'
    . '["utm_source","utm_medium","utm_campaign","utm_term","utm_content","gclid","gbraid","wbraid","fbclid"].forEach(function(k){var v=q.get(k);if(v)o.set(k,v.slice(0,200))});'
    . 'try{if(r&&new URL(r).hostname.replace(/^www\./,"")===L.hostname.replace(/^www\./,""))r=""}catch(e){r=""}'
    . 'if(r)o.set("ref",r.split("?")[0].slice(0,200));o.set("lp",L.pathname.slice(0,200));o.set("ts",Math.floor(Date.now()/1e3));'
    . 'd.cookie="ent_src="+encodeURIComponent(o.toString())+"; Max-Age=7776000; Path=/; SameSite=Lax"+(L.protocol==="https:"?"; Secure":"")}}catch(e){}' . "\n"
    // ?debug_mode=1 → GA4 DebugView for this browser tab session; ?internal=1 → this browser is marked internal (1 year)
    . 'if(q.has("debug_mode"))put(ss,"ent_debug",q.get("debug_mode")==="1"?"1":null);' . "\n"
    . 'if(q.has("internal"))d.cookie="ent_internal="+(q.get("internal")==="1"?"1; Max-Age=31536000":"; Max-Age=0")+"; Path=/; SameSite=Lax";' . "\n"
    . 'P.debug=get(ss,"ent_debug")==="1";P.internal=/(?:^|; )ent_internal=1/.test(d.cookie);P.lead=get(ls,"ent_lead")==="1";' . "\n"
    // private values out of the address bar before any tag reads the URL (verify link key, thank-you ref) + our own switches
    . 'try{var u=new URL(L.href),x=0;["t","k","token","key","code","ref","email","phone","name","debug_mode","internal"].forEach(function(p){if(u.searchParams.has(p)){u.searchParams.delete(p);x=1}});'
    . 'if(x)history.replaceState(history.state,"",u.pathname+u.search+u.hash)}catch(e){}' . "\n"
    // the event helper: everything goes through here, nothing personal gets out
    . 'var BAD=/^(name|first_name|last_name|full_name|email|e_?mail|phone|mobile|tel|telephone|whatsapp_number|address|city_typed|message|notes|code|token|key|otp)$/i;' . "\n"
    . 'w.entTrack=function(n,p){p=p||{};var e={},k,v;for(k in p){if(!Object.prototype.hasOwnProperty.call(p,k)||BAD.test(k))continue;v=p[k];if(v===null||v===undefined||v==="")continue;'
    . 'if(typeof v==="string"){if(/@|\d[\d\s().-]{8,}\d/.test(v))continue;v=v.slice(0,100)}e[k]=v}'
    . 'if(!e.page_type)e.page_type=P.page_type;var ref=e.lead_ref;delete e.lead_ref;'
    . 'w.entEvents.push({event:n,params:e});' . "\n"
    . 'if(w.gtag&&C.ga4){if(e.beacon_callback){var cb=e.beacon_callback;delete e.beacon_callback;e.event_callback=cb;e.event_timeout=600}gtag("event",n,e)}else if(e.beacon_callback){e.beacon_callback()}' . "\n"
    . 'if(n==="generate_lead"){put(ls,"ent_lead","1");if(w.gtag&&C.ga4)gtag("set","user_properties",{lead_status:"lead"});if(w.gtag&&C.ads)gtag("event","conversion",{send_to:C.ads,transaction_id:ref})}' . "\n"
    . 'if(w.fbq&&C.pixel){if(n==="generate_lead")fbq("track","Lead",{content_name:e.form_name,content_category:e.page_type},ref?{eventID:ref}:undefined);'
    . 'else if(n==="click_call"||n==="click_whatsapp")fbq("track","Contact",{content_category:e.page_type,contact_method:n==="click_call"?"call":"whatsapp"})}};' . "\n"
    . '})(window,document);' . "\n" . "  </script>\n";

  if (!$on) return $h . '  <!-- tracking tags off (' . (TRACKING_ON ? (is_staging() ? 'staging address' : 'admin') : 'config.php → TRACKING_ON is false') . "); entTrack still logs events to window.entEvents -->\n";

  // 2. GA4 (+ optional Google Ads through the same tag): one config call = one page_view
  if ($ga4 || $ads) {
    $h .= '  <script async src="https://www.googletagmanager.com/gtag/js?id=' . e($ga4 ?: $ads) . "\"></script>\n"
        . '  <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());' . "\n"
        . '  (function(P){var c={page_type:P.page_type,content_group:P.content_group,site_section:P.site_section};'
        . 'if(P.debug)c.debug_mode=true;if(P.internal)c.traffic_type="internal";if(location.pathname==="/verify/")c.ignore_referrer=true;if(P.lead)gtag("set","user_properties",{lead_status:"lead"});'
        . ($ga4 ? 'gtag("config",' . $j($ga4) . ',c);' : '') . ($ads ? 'gtag("config",' . $j($ads) . ');' : '') . '})(window.ENT_PAGE);</script>' . "\n";
  }
  // 3. Meta Pixel: the standard base code. autoConfig off = no automatic button-click / page-metadata events.
  if ($px) {
    $h .= "  <script>\n  !function(f,b,e,v,n,t,s)\n  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?\n  n.callMethod.apply(n,arguments):n.queue.push(arguments)};\n"
        . "  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';\n  n.queue=[];t=b.createElement(e);t.async=!0;\n  t.src=v;s=b.getElementsByTagName(e)[0];\n"
        . "  s.parentNode.insertBefore(t,s)}(window, document,'script',\n  'https://connect.facebook.net/en_US/fbevents.js');\n"
        . "  fbq('set', 'autoConfig', false, '$px');\n  fbq('init', '$px');\n  fbq('track', 'PageView');\n  </script>\n";   // $px is digits only (checked above)
  }
  return $h;
}

// Right after <body>: the Meta Pixel noscript image (only when the pixel is on)
function tracking_body($page = []) {
  if (!tracking_tags_on() || !preg_match('/^\d{6,20}$/', TRACKING['meta_pixel'])) return '';
  return '<noscript><img height="1" width="1" style="display:none" alt="" src="https://www.facebook.com/tr?id=' . e(TRACKING['meta_pixel']) . '&amp;ev=PageView&amp;noscript=1"></noscript>' . "\n";
}
