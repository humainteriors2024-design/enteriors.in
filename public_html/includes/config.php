<?php
/* =====================================================================
   ENTERIORS — SITE CONFIG  (the ONE file you edit for site-wide facts)

   Everything here is read by the shared site engine (includes/site.php):
   header, footer, forms, tracking, lead handling, structured data,
   every page and every blog post. Leave a value as '' and it is hidden
   everywhere — nothing breaks.

   Sections
     0  Live / staging switch        6  Site facts (ratings, warranty …)
     1  Website name and URL         7  Services, areas served, cost links
     2  Contact details (NAP)        8  Authors, reviews, home stats
     3  Social links                 9  Image folders and formats
     4  Tracking IDs                10  CSS files and feature switches
     5  Lead forms                  11  Private reports (/admin/)
   Calculator prices are NOT here: includes/calc/rates.php
   ===================================================================== */

/* ---------- 0. LIVE / STAGING SWITCH ----------
   'auto'    = live only when the site is opened on the SITE url below; any
               other address (test sub-domain, localhost, IP) is staging.
   'live'    = force live.      'staging' = force staging.
   Staging: pages are noindex, tracking tags are off, a ribbon shows at the
   top, missing images show as labelled boxes, leads are saved as TEST. */
const ENV = 'auto';

/* ---------- 1. WEBSITE NAME AND URL ---------- */
const SITE = [
  'name'        => 'Enteriors',
  'url'         => 'https://enteriors.in',   // TODO: final domain, no trailing slash (also in .htaccess)
  'tagline'     => "India's honest guide to home interiors — materials, costs & design.",
  'description' => "India's interior knowledge platform — specs, costs and guidance for every material, room and budget.",
  'logo'        => '/assets/img/logo.png',        // 512×512 PNG, used in schema
  'image'       => '/assets/img/og-default.jpg',  // 1200×630 share image
  'locale'      => 'en_IN',
  'language'    => 'en-IN',
  'cta'         => ['label' => 'Interior Cost Calculator →', 'href' => '/calculators/interior-cost/'],
  'cta2'        => ['label' => 'Free Consultation',          'href' => '/contact/'],
];

/* ---------- 2. CONTACT DETAILS — Name, Address, Phone (keep IDENTICAL to Google Business Profile) ---------- */
const NAP = [
  'legal_name'  => 'Enteriors',          // TODO: registered business name
  'phone'       => '',                   // TODO: '+91 98xxxxxxxx' — shows Call buttons when set
  'whatsapp'    => '',                   // TODO: digits only with country code, e.g. '9198xxxxxxxx'
  'whatsapp_text' => 'Hi Enteriors, I would like help with my home interiors.',   // pre-filled WhatsApp message
  'email'       => 'hello@enteriors.in',
  'street'      => '',                   // TODO: e.g. '12, 3rd Cross, HSR Layout Sector 2'
  'locality'    => 'Bengaluru',
  'region'      => 'Karnataka',
  'postal_code' => '',                   // TODO: e.g. '560102'
  'country'     => 'IN',
  'hours'       => 'Mo-Sa 10:00-19:00',  // schema format; shown as text below
  'hours_text'  => 'Mon–Sat, 10 am – 7 pm',
  'area_served' => ['Bengaluru', 'Hosur'],
  'map_url'     => '',                   // TODO: Google Maps share link
  'map_embed'   => '',                   // optional: the src="" of a Google Maps embed (contact page)
  'geo'         => ['lat' => '', 'lng' => ''],
  // 'Organization' for a content site. Switch to 'HomeAndConstructionBusiness' ONLY if you
  // have a real address customers can visit and a Google Business Profile.
  'schema_type' => 'Organization',
];

/* ---------- 3. SOCIAL LINKS (footer icons + sameAs in schema) — '' hides one ---------- */
const SOCIAL = [
  'instagram' => 'https://www.instagram.com/enteriors.in',
  'facebook'  => 'https://www.facebook.com/enteriors.in',
  'youtube'   => 'https://www.youtube.com/@enteriors',
  'linkedin'  => 'https://www.linkedin.com/company/enteriors',
  'pinterest' => '',
];

/* ---------- 4. TRACKING IDs — only loaded on the LIVE site.
   Override for one PILLAR (all its pages and posts): includes/nav.php → that pillar's 'tracking'.
   Override for one PAGE: 'tracking' => ['meta_pixel' => 'OTHER-ID'] in its $page block; false = off.
   Every page reports its pillar, page type and content group with each event (see includes/tracking.php). ---------- */
const TRACKING = [
  'gsc_verification'  => '',   // Google Search Console: the content="…" value of the HTML tag
  'bing_verification' => '',   // Bing Webmaster Tools: the content="…" value
  'ga4'               => '',   // Google Analytics 4: 'G-XXXXXXXXXX'
  'ga4_api_secret'    => '',   // GA4 → Admin → Data streams → Measurement Protocol API secrets: also sends each lead from the server
  'gtm'               => '',   // Google Tag Manager: 'GTM-XXXXXXX' (if you manage GA4 inside GTM, leave ga4 blank)
  'google_ads'        => '',   // Google Ads: 'AW-XXXXXXXXXX'
  'google_ads_lead'   => '',   // Ads conversion label fired when a lead is sent: 'AbCdEfGhIjK'
  'meta_pixel'        => '',   // Meta (Facebook) Pixel ID: digits only
  'meta_capi_token'   => '',   // Meta Events Manager → Settings → Conversions API → access token: also sends each lead from the server
  'meta_test_code'    => '',   // Meta "Test events" code while you check the Conversions API; clear it afterwards
  'meta_api_version'  => 'v24.0',   // Graph API version for the Conversions API (use a current one from developers.facebook.com/docs/graph-api/changelog)
  'meta_domain_verification' => '',   // Meta Business → Brand safety → Domains: the content="…" value
  'clarity'           => '',   // Microsoft Clarity project ID (optional heatmaps and recordings)
];

/* ---------- 5. LEAD FORMS ---------- */
const LEADS = [
  'endpoint'      => '/api/lead.php',                 // where every form posts
  'notify_email'  => 'humainteriors2024@gmail.com',   // new leads are emailed here
  'notify_cc'     => '',                              // optional second address
  'webhook'       => '',                              // optional: URL that also receives each lead as JSON (CRM, Google Sheet script)
  'promise'       => 'We respond within 2 business hours.',
  'thank_you'     => '/thank-you/',

  // Spam protection (see includes/leads.php)
  'secret'          => 'DQP4Q-hYoga7a7JohvtXzPb8claA5r0FukMr-tAC1Abw21XZ',  // signs the hidden form key — change it to any long random text
  'min_seconds'     => 3,        // a form sent faster than this after loading is a bot
  'max_key_age'     => 21600,    // form key valid for 6 hours (it refreshes itself when the visitor starts typing)
  'rate_limit'      => 5,        // submissions allowed per IP address per hour
  'duplicate_hours' => 24,       // same mobile number again within this time is not emailed twice
  'max_links'       => 0,        // links allowed in a message (0 = any link is treated as spam)

  // Options shown in the forms
  'cities'     => ['Bengaluru', 'Hosur', 'Mumbai', 'Delhi NCR', 'Hyderabad', 'Chennai', 'Pune', 'Other'],
  'home_types' => ['1 BHK', '2 BHK', '3 BHK', '4 BHK+', 'Villa / Duplex'],
  'services'   => ['Full Home Interiors', 'Modular Kitchen', 'Wardrobes', 'Renovation', 'Not sure — need guidance'],
  'budgets'    => ['Under ₹5 lakh', '₹5–10 lakh', '₹10–20 lakh', '₹20 lakh+', 'Not decided'],
  'timelines'  => ['Immediately', 'In 1–3 months', 'In 3–6 months', 'Just exploring'],
  'call_slots' => ['Any time', 'Morning (10–1)', 'Afternoon (1–4)', 'Evening (4–7)'],
  'trust'      => [
    'Free 60-minute consultation — no obligation',
    'Matched with a designer in your city',
    'Get 3 competitive quotes from verified professionals',
    'Your details are shared only with the designers you agree to',
  ],
];

/* ---------- 6. SITE FACTS — ONLY numbers that are true today and that you can prove.
   Blank = not shown. Used by the facts strip (home page, pillar pages).
   Ratings are shown as text only — they are not added to structured data, because Google does not
   allow a site to mark up review scores collected on another platform. ---------- */
const FACTS = [
  'rating'         => '',   // e.g. '4.8'  (average on the source below)
  'review_count'   => '',   // e.g. '212'
  'review_source'  => 'Google',
  'review_url'     => '',   // link to the public reviews page
  'homes_done'     => '',   // e.g. '350+'
  'years'          => '',   // e.g. '9'  (years in business)
  'factory_sqft'   => '',   // e.g. '25,000'
  'warranty_years' => '',   // e.g. '10'
  'delivery_days'  => '',   // e.g. '45'  (delivery commitment)
];

/* ---------- 7. SERVICES, AREAS SERVED, COST LINKS ---------- */
const SERVICES = [   // label => page (links appear only when the page is live)
  'Full Home Interiors' => '/services/turnkey-execution/',
  'Modular Kitchens'    => '/modular-kitchen/',
  'Wardrobes'           => '/wardrobe/',
  'False Ceilings'      => '/false-ceiling/',
  'Find a Designer'     => '/services/find-designer/',
  'Get 3 Quotes'        => '/services/get-3-quotes/',
];
const AREAS = [      // city => [page, [localities]]
  'Bengaluru' => ['/interior-designers-bangalore/', ['Electronic City', 'Chandapura', 'Bommasandra', 'Hebbagodi', 'Attibele', 'Jigani', 'Begur', 'Hosa Road', 'HSR Layout', 'Sarjapur Road', 'Koramangala', 'Bannerghatta Road', 'JP Nagar', 'Whitefield', 'Marathahalli', 'Hebbal']],
  'Hosur'     => ['/interior-designers-hosur/',     ['Bagalur Road', 'Mathigiri', 'SIPCOT', 'Zuzuvadi', 'Mookandapalli']],
];
const LOCALITY_PAGES = [   // locality => its area guide; the name becomes a link wherever localities are listed (footer, home)
  'Electronic City' => '/interior-designers-bangalore/electronic-city/',
  'Chandapura'      => '/interior-designers-bangalore/chandapura/',
  'Bommasandra'     => '/interior-designers-bangalore/bommasandra/',
];
const COST_LINKS = [ // quick links used in footers, CTAs and forms
  '1 BHK interior cost' => '/cost/1-bhk-interior-cost/',
  '2 BHK interior cost' => '/cost/2-bhk-interior-cost/',
  '3 BHK interior cost' => '/cost/3-bhk-interior-cost/',
  'Modular kitchen cost' => '/cost/modular-kitchen-cost/',
  'Wardrobe cost'       => '/cost/wardrobe-cost/',
  'False ceiling cost'  => '/cost/false-ceiling-cost/',
];

/* ---------- 8. AUTHORS, REVIEWS, HOME STATS ---------- */
const AUTHORS = [    // who the byline names. 'type' => 'Organization' = the brand writes; 'Person' = a named expert
  'enteriors' => [
    'type' => 'Organization',
    'name' => 'Enteriors',
    'role' => 'Interior knowledge, research, materials and design hub',
    'bio'  => 'Enteriors researches interior materials, finishes, layouts and costs for Indian homes: specifications, grades, test results, trade rates and design principles, checked against manufacturers\' data and current market prices, and explained in plain language.',
    'url'  => '/about/',
    'same_as' => [],                                // brand profiles are taken from SOCIAL automatically
  ],
];
const DEFAULT_AUTHOR = 'enteriors';
/* ONLY real reviews from real clients, with their permission. The reviews section stays
   hidden while this list is empty. Never invent reviews: fake testimonials break
   consumer-protection rules and Google's review policies.
   Example: ['name' => 'Priya S.', 'detail' => '3 BHK · HSR Layout', 'text' => '…', 'stars' => 5], */
const REVIEWS = [];
const STATS = [      // home hero — only numbers that are true today
  ['num' => '11', 'suffix' => '',  'label' => 'Pillar guides'],
  ['num' => '8',  'suffix' => '',  'label' => 'Cities in the calculators'],
  ['num' => '70', 'suffix' => '+', 'label' => 'Terms in the glossary'],
];

/* ---------- 9. IMAGES AND VIDEOS ----------
   Each page has its own media folder. Drop files in, name them in plain words
   (l-shape-kitchen-with-breakfast-counter.jpg) and the file name becomes the alt text.
     Blog post  /blogs/<slug>/           →  /assets/blogs/<slug>/
     Other page /modular-kitchen/        →  /assets/pages/modular-kitchen/
     Home page                           →  /assets/pages/home/                       */
const MEDIA = [
  'blog_dir'  => '/assets/blogs',
  'page_dir'  => '/assets/pages',
  'images'    => ['webp', 'jpg', 'jpeg', 'png'],   // accepted image formats (first found wins; webp + jpg/png together = <picture>)
  'videos'    => ['mp4', 'webm'],
  'hero_name' => 'hero',                           // hero.jpg / hero.png / hero.webp is the page's main image
];

/* ---------- 10. CSS FILES (in load order) AND SWITCHES ---------- */
const CSS_FILES = ['tokens', 'fonts', 'base', 'layout', 'components', 'forms', 'header', 'footer'];
const CSS_BY_TYPE = [                  // extra file per page type
  'home' => ['home'], 'pillar' => ['article'], 'article' => ['article'], 'compare' => ['article'], 'post' => ['article'], 'tool' => ['tool'],
];
const CSS_LAST = ['utilities'];

const SHOW_ALL_LINKS = false;   // true = show menu links to pages not uploaded yet (preview only)
const FAQ_SCHEMA     = true;    // FAQPage markup: no longer a Google rich result, but AI answer engines (Bing Copilot,
                                // ChatGPT search, Perplexity, Google AI Overviews) read question-and-answer markup. Harmless to keep on.

/* ---------- 11. PRIVATE REPORTS (/admin/) — leads and calculator use, by pillar ----------
   Set a password: open /admin/ once on staging, it shows the line to paste here. Blank = /admin/ is off. */
const ADMIN = [
  'user'          => 'enteriors',
  'password_hash' => '',
];
const STICKY_CTA     = true;    // floating Call / Consultation buttons after scrolling
const LEAD_DIALOG    = true;    // "Free consultation" buttons open a pop-up form instead of leaving the page

/* ---------- 12. PARTNER — HUMA INTERIORS (execution partner for South-East Bengaluru) ----------
   Enteriors is the research and planning site; Huma Interiors designs, manufactures and installs.
   EVERY link from this site to humainteriors.com is built from this block (includes/partner.php),
   so if a page on humainteriors.com moves, change its URL here once and every link updates.
   Check that each URL still opens: /admin/partner-links.php (needs the /admin/ password).

   Link policy (applied automatically — see includes/partner.php):
     • follow    contextual links inside the text of pages on kitchens, wardrobes, living areas,
                 cost and the local area guides, with varied wording (brand, place, service)
     • nofollow  buttons, the footer line, the partner box on unrelated topics (styles, vastu,
                 trends …) and one in three boxes on related topics, so the profile stays natural
   A page can override: 'partner' => false (no box) or 'partner' => ['follow' => true, 'topic' => 'kitchen'].
   Facts below are as published on humainteriors.com; keep them in step with that site. ---------- */
const PARTNER = [
  'name'     => 'Huma Interiors',
  'url'      => 'https://humainteriors.com/',
  'base'     => 'Chandapura, Bengaluru',
  'address'  => 'No. 1145, Upkar Springfields, behind Sainagar, Neralur Gate, Chandapura, Bengaluru 562107',
  'since'    => '2019',
  'factory'  => '17,400 sq ft',
  'summary'  => 'a women-led interior studio with its own factory in Chandapura that designs, builds and installs modular kitchens, wardrobes and full home interiors',
  'promises' => ['3D design before you pay', 'itemised quotation with named brands', 'delivery date written into the contract', 'warranty of up to 10 years'],
  'areas'    => ['Chandapura', 'Electronic City', 'Bommasandra', 'Hebbagodi', 'Attibele', 'Anekal', 'Jigani', 'Begur', 'Hosa Road', 'HSR Layout', 'Sarjapur Road', 'Hosur'],
  // Pages on humainteriors.com. If a dedicated page exists for a topic (e.g. a modular kitchen page),
  // put its address here; until then the topic points at the most relevant page that exists.
  'pages' => [
    'home'            => 'https://humainteriors.com/',
    'about'           => 'https://humainteriors.com/about-us.php',
    'blog'            => 'https://humainteriors.com/blogs.php',
    'kitchen'         => 'https://humainteriors.com/',     // TODO: modular kitchen page, if Huma adds one
    'wardrobe'        => 'https://humainteriors.com/',     // TODO: wardrobe page, if Huma adds one
    'living'          => 'https://humainteriors.com/blogs/living-room-interior-design-bangalore/',
    'cost_2bhk'       => 'https://humainteriors.com/blogs/2bhk-interior-design-cost-in-bangalore/',
    'cost_3bhk'       => 'https://humainteriors.com/blogs/3bhk-interior-design-cost-in-bangalore/',
    'chandapura'      => 'https://humainteriors.com/',     // home page targets "interior designers in Chandapura"
    'electronic_city' => 'https://humainteriors.com/',     // TODO: Electronic City page, if Huma adds one
    'bommasandra'     => 'https://humainteriors.com/',     // TODO: Bommasandra page, if Huma adds one
  ],
  // Pillars (nav.php keys) whose pages are close enough in topic for a followed link in the partner box
  'follow_pillars' => ['modular-kitchen', 'wardrobe', 'cost', 'rooms', 'furniture', 'false-ceiling', 'services', 'locations'],
  'disclosure' => 'Enteriors refers home-owners in South-East Bengaluru to Huma Interiors, our execution partner. Our guides and prices stay independent and apply to any firm you choose.',
  'page'     => '/partners/huma-interiors/',   // our page about the partnership
];
