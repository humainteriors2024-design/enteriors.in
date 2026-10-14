<?php
/* =====================================================================
   ENTERIORS — SITE CONFIG  (the ONE file you edit for site-wide facts)

   Everything here is read by the shared site engine (includes/site.php):
   header, footer, forms, tracking, lead handling, structured data,
   every page and every blog post. Leave a value as '' and it is hidden
   everywhere — nothing breaks.

   Sections
     0  LAUNCH SWITCH, live/staging  6  Site facts (ratings, warranty …)
     1  Website name and URL         7  Services, areas served, cost links
     2  Contact details (NAP)        8  Authors, reviews, home stats
     3  Social links                 9  Image folders and formats
     4  Analytics: TRACKING_ON,     10  CSS files and feature switches
        GA4, Meta Pixel, Search Console
     5  Lead forms (the one inbox)  11  Private reports (/admin/)
     5b Captcha: TURNSTILE KEYS     12  Trending designs, designer directory
     5c Email verification and      13  Launch phases
        daily limits                14  Partner studio
   Calculator prices are NOT here: includes/calc/rates.php
   ===================================================================== */

/* ---------- 0. LAUNCH SWITCH — the ONE line to change on launch day ----------
   false = PRE-LAUNCH LOCK (now): on every address, including enteriors.in —
             • every page says noindex, nofollow (meta robots AND the X-Robots-Tag header)
             • /sitemap.xml and /llms.txt answer "not found"; robots.txt lists no sitemap and keeps
               Google Images out (pages stay crawlable so search engines can SEE the noindex)
             • the footer has no Sitemap link
           Forms keep working normally and leads are real (not marked TEST).
   true  = LAUNCHED: the site can be indexed, sitemap and llms.txt are on.
   Analytics (GA4, Meta Pixel) has its OWN switch, TRACKING_ON in section 4, so it can run before launch.
   Check after flipping: open /robots.txt, /sitemap.xml and view the source of any page (meta name="robots"). */
const LAUNCHED = true;   // launched 14 Oct 2026 at the owner's request (false = back to the pre-launch lock)

/* ---------- 0b. LIVE / STAGING (by address) ----------
   'auto'    = live only when the site is opened on the SITE url below; any
               other address (test sub-domain, localhost, IP) is staging.
   'live'    = force live.      'staging' = force staging.
   Staging: pages are noindex, tracking tags are off, a ribbon shows at the
   top, missing images show as labelled boxes, leads are saved as TEST.
   (Staging is always locked, whatever LAUNCHED says.) */
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
  'cta'         => ['label' => 'Interior Cost Calculator →', 'href' => '/calculators/home-interior-quote/'],   // the detailed, itemised quote (Oct 2026)
  'cta2'        => ['label' => 'Free Consultation',          'href' => '/contact/'],
];

/* ---------- 2. CONTACT DETAILS — Name, Address, Phone (keep IDENTICAL to Google Business Profile) ---------- */
const NAP = [
  'legal_name'  => 'Enteriors',          // TODO: registered business name
  'phone'       => '',                   // TODO: '+91 98xxxxxxxx' — shows Call buttons when set
  'whatsapp'    => '',                   // TODO: digits only with country code, e.g. '9198xxxxxxxx'
  'whatsapp_text' => 'Hi Enteriors, I would like help with my home interiors.',   // pre-filled WhatsApp message
  'email'       => 'contact@enteriors.in',   // the ONE public address: footer, contact page, schema, social icons, visitor emails
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
  // 'auto' = Organization until street, postal code and phone above are filled in, then LocalBusiness
  // (HomeAndConstructionBusiness) with the address, hours and map. Fill them in ONLY if customers can
  // visit that address and it matches your Google Business Profile exactly.
  'schema_type' => 'auto',
];

/* ---------- 3. SOCIAL LINKS (footer icons + sameAs in schema) — '' hides one ----------
   Only these two networks are shown. The footer adds a third icon, Email (mailto: NAP['email'] above);
   email is not a profile, so it is not listed in schema sameAs. */
const SOCIAL = [
  'instagram' => 'https://www.instagram.com/enteriors.in',
  'facebook'  => 'https://www.facebook.com/enteriors.in',
];

/* ---------- 4. ANALYTICS AND SEARCH CONSOLE — one include: includes/tracking.php ----------
   TRACKING_ON is separate from LAUNCHED (section 0), so analytics can be tested on the live site
   while Google indexing stays off.
     true  = GA4 and the Meta Pixel load on every page of the live site (enteriors.in), including the
             404, thank-you and verify pages. /admin/ is never tracked.
     false = no tags anywhere. The first-visit source cookie still works, so lead emails keep their source.
   Staging addresses never load the tags unless 'on_staging' below is true.
   Test with ?debug_mode=1 on any page (GA4 → Admin → DebugView). docs/ga4-setup.md has every event. */
const TRACKING_ON = true;
const TRACKING = [
  'ga4'               => 'G-6GZMB484LL',       // GA4 Measurement ID (set 14 Oct 2026). To change it, replace only what is inside the quotes, e.g. 'G-AB12CD34EF' (GA4 → Admin → Data streams → Web). Blank = GA4 off
  'meta_pixel'        => '2229913661272596',   // Meta (Facebook) Pixel ID: PageView on every page, Lead on a verified enquiry, Contact on call / WhatsApp taps
  'gsc_verification'  => '0lH2ddfuw-r_04ZKCm2W1a2PcucEmKV5XH2CRTVdZgU',   // Google Search Console verification code (14 Oct 2026); the same code is the DNS TXT record
  'bing_verification' => '',                   // Bing Webmaster Tools: the content="…" value (optional)
  'meta_domain_verification' => '',            // Meta Business → Brand safety → Domains: the content="…" value (optional)
  'google_ads'        => '',                   // optional, later: Google Ads 'AW-XXXXXXXXXX' (loads through the same Google tag, no second tag)
  'google_ads_lead'   => '',                   // optional, later: the Ads conversion label sent with each generate_lead
  'on_staging'        => false,                // true = also load the tags on a staging address (for testing only)
  'indexnow_key'      => 'c87fa4a9510f7c3ed112221462b2a5f0',   // IndexNow (Bing, Yandex, Seznam, Naver): its key file /<key>.txt is in public_html. Submit from /admin/indexnow.php
];

/* ---------- 5. LEAD FORMS ----------
   EVERY form on the site (free consultation, call back, get 3 quotes, the pop-up, and Contact / Mail
   on trending designs and designer profiles) posts to the same handler and is emailed to the ONE
   inbox below, only after the visitor has verified their email address (section 5c). */
const LEADS = [
  'endpoint'      => '/api/lead.php',                 // where every form posts
  // THE inboxes: every verified form submission is emailed to each address here (one email each).
  // SERVER-SIDE ONLY: these are used to send mail and are never printed in a page, script, form field or API reply.
  'notify_emails' => ['Enteriors.com@gmail.com', 'contact@enteriors.in'],
  'webhook'       => '',                              // optional: URL that also receives each lead as JSON (CRM, Google Sheet script)
  'promise'       => 'We respond within 2 business hours.',
  'thank_you'     => '/thank-you/',

  // Spam protection (see includes/leads.php)
  'secret'          => '',   // signs form keys, codes, captchas and links. Leave '' : the server makes its own random secret
                               // the first time it is needed and keeps it in leads/secret.key (outside public_html, never in git).
  'min_seconds'     => 3,        // a form sent faster than this after loading is a bot
  'max_key_age'     => 21600,    // form key valid for 6 hours (it refreshes itself when the visitor starts typing)
  'max_links'       => 0,        // links allowed in a message (0 = any link is treated as spam)

  // Options shown in the forms
  'cities'     => ['Bengaluru', 'Hosur', 'Mumbai', 'Delhi NCR', 'Hyderabad', 'Chennai', 'Pune', 'Kolkata', 'Coimbatore', 'Mysuru'],   // suggestions in the City box (visitors can type any city or area)
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

/* ---------- 5b. CAPTCHA ON EVERY FORM — Cloudflare Turnstile ----------
   >>> PASTE YOUR TWO TURNSTILE KEYS HERE <<<
   Get them free: dash.cloudflare.com → Turnstile → Add widget → name "Enteriors", hostnames enteriors.in
   (and your staging address), widget mode "Managed" → copy the Site Key and the Secret Key.
   While either key is blank, every form shows a small built-in picture captcha instead, so forms keep working. */
const TURNSTILE = [
  'site_key'   => '',   // public key, e.g. '0x4AAAAAAA…' (printed in the page)
  'secret_key' => '',   // private key, e.g. '0x4AAAAAAA…' (only used on the server)
];

/* ---------- 5c. EMAIL VERIFICATION AND DAILY LIMITS — every form ----------
   Nothing reaches LEADS['notify_emails'] until the visitor proves the email address is theirs: we email
   them a 6-digit code AND a one-click link (either works). Limits are counted on the server against the
   visitor's IP address, verified email and mobile number, so a new browser or incognito does not reset them.
   A "day" is the calendar day in India (midnight to midnight IST). */
const FORM_LIMITS = [
  'consultation' => 5,   // free consultation, call back and the contact page form: per person per day
  'other'        => 3,   // every other form (get 3 quotes, Contact / Mail a designer or design): each, per person per day
];
const FORM_GROUPS = [    // form name => limit group ('consultation' or 'other')
  'full' => 'consultation', 'compact' => 'consultation', 'inline' => 'consultation', 'callback' => 'consultation',
  'quote' => 'other', 'enquiry' => 'other',
];
const VERIFY = [
  'code_minutes'   => 30,     // the code and the link work for this long
  'code_attempts'  => 5,      // wrong codes allowed before the request is cancelled
  'resends'        => 2,      // extra codes the visitor can ask for
  'resend_seconds' => 45,     // wait before another code can be sent
  'per_ip_hour'    => 10,     // verification emails started from one connection per hour
  'per_email_hour' => 4,      // verification emails to one address per hour …
  'per_email_day'  => 8,      // … and per day (stops anyone flooding someone else's inbox)
  'site_daily_cap' => 400,    // verification emails sent by the whole site per day
  'confirm_user'   => true,   // email the visitor a copy of what was sent
  'envelope_from'  => '',     // optional: 'no-reply@enteriors.in' if your host needs a fixed sender for mail() to deliver
  'sms_webhook'    => '',     // optional: URL that also sends the code by SMS (receives JSON: phone, code, minutes)
  'block_domains'  => ['mailinator.com', 'guerrillamail.com', 'sharklasers.com', '10minutemail.com', 'tempmail.com', 'temp-mail.org',
                       'yopmail.com', 'trashmail.com', 'getnada.com', 'dispostable.com', 'maildrop.cc', 'throwawaymail.com', 'fakeinbox.com'],
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
  'Bengaluru' => ['/interior-designers/bangalore/', ['Electronic City', 'Chandapura', 'Bommasandra', 'Whitefield', 'Sarjapur Road', 'HSR Layout', 'Koramangala', 'Bannerghatta Road', 'JP Nagar', 'Hebbal', 'Yelahanka', 'Marathahalli', 'KR Puram', 'Devanahalli']],
  'Hosur'     => ['/interior-designers/hosur/',     ['Bagalur Road', 'Mathigiri', 'SIPCOT', 'Zuzuvadi', 'Mookandapalli']],
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
  'huma-interiors' => [
    'type'  => 'Organization',
    'guest' => true,
    'name'  => 'Huma Interiors',
    'role'  => 'Guest author · interior design studio in Chandapura, Bengaluru',
    'bio'   => 'Huma Interiors designs and builds home interiors across Chandapura, Electronic City, Bommasandra and Hosur Road. It is a partner studio of Enteriors; this post was written by its team and edited by Enteriors.',
    'url'   => '/about/',
    'site'  => 'https://humainteriors.com/',
    'same_as' => [],
  ],
];
  // (guest authors: 'guest' => true prints "Guest post by" and a disclosure; their own site goes in 'site', linked nofollow)
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
  'password_hash' => '$2y$10$JXp7MJhTSyF6wGeOX5uEhuWVozeqEO.gMTtMvjOpRwVHemqTf2Fqi',   // set 14 Oct 2026; to change it, open /admin/ on staging with this line blanked, or ask
];
const STICKY_CTA     = true;    // floating Call / Consultation buttons after scrolling
const LEAD_DIALOG    = true;    // "Free consultation" buttons open a pop-up form instead of leaving the page

/* ---------- 12. TRENDING DESIGNS AND DESIGNER DIRECTORY ----------
   Pages: /trending-designs/ and /services/find-designer/ (engine: includes/finder.php).
   Data:  includes/data/trends.php · includes/data/pros.php · includes/data/places.php
   "Contact" and "Mail" buttons open a form; like every form on the site it is sent to
   LEADS['notify_emails'] (with the firm's name) once the visitor's email is verified. */
const FINDER = [
  'designs_url'   => '/trending-designs/',
  'pros_url'      => '/services/find-designer/',
  'per_page'      => 24,      // results per page
  'search_words'  => 4,       // search boxes accept at most this many words …
  'search_chars'  => 60,      // … and this many characters
  'index_samples' => false,   // false = while sample listings are shown, these pages are noindex and stay out of the sitemap
];
const ENQUIRY = [
  'endpoint'     => '/api/lead.php',   // same handler as every other form
  'repeat_hours' => 24,                // the same person contacting the same firm again within this time is not sent twice
];

/* ---------- 13. LAUNCH PHASES ----------
   Phase 2 features stay hidden until PHASE2 is true: no menu, footer, home-page or in-text links point to them,
   they are left out of the sitemap and llms.txt, and the pages themselves are noindex.
   Launch day: set PHASE2 to true. */
const PHASE2 = false;
const PHASE2_PATHS = [
  '/services/find-designer/',     // Find a designer (directory + company profile pages)
  '/services/find-contractor/',   // Find a contractor
  '/trending-materials/',         // Find the trending materials
  '/services/get-3-quotes/',
];

/* ---------- 14. PARTNER STUDIO — Huma Interiors (links: includes/data/partners.php, printed by components/partner.php) ---------- */
const PARTNER = [
  'name'  => 'Huma Interiors',
  'url'   => 'https://humainteriors.com/',
  'where' => 'Chandapura and Electronic City, Bengaluru',
  'note'  => 'Huma Interiors is a partner studio of Enteriors.',   // disclosure printed with every promotional placement
  'on'    => true,                                                // false = every partner link and box disappears
];
