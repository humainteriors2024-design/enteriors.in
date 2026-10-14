# GA4, Meta Pixel and Search Console setup

Everything is loaded from one file, `public_html/includes/tracking.php`. The settings are in
`public_html/includes/config.php`, section 4.

| Setting | What it does | Now |
|---|---|---|
| `TRACKING_ON` | Turns GA4 and the Meta Pixel on or off on the live site. It is separate from `LAUNCHED`, so tracking runs while Google indexing stays off | `true` |
| `TRACKING['ga4']` | Your GA4 Measurement ID (`G-…`) | **blank: paste yours** |
| `TRACKING['meta_pixel']` | Meta Pixel ID | `2229913661272596` |
| `TRACKING['gsc_verification']` | Search Console HTML-tag code (only the `content="…"` value) | **blank: paste yours** |
| `TRACKING['on_staging']` | Also load the tags on a staging address (testing only) | `false` |
| `TRACKING['google_ads']`, `['google_ads_lead']` | Optional, for later: Google Ads conversion through the same Google tag | blank |

No GA4 ID was in the code before, so GA4 stays off until you paste the ID. The Meta Pixel is already on.

What is never tracked: `/admin/` pages, and anything personal. Names, emails, phone numbers and
anything typed into a form are never sent to Google or Meta. The event helper (`entTrack`) also
drops any value that contains `@` or looks like a phone number, as a safety net. The private keys in
the email-verification link are removed from the address bar before any tag loads.

---

## 1. Page views

There is one `page_view` per page, sent by the single GA4 `config` call. No page view is sent by hand,
so pages are never counted twice. Every page view and every event carries:

| Parameter | Values |
|---|---|
| `page_type` | `home`, `pillar`, `cluster`, `city`, `blog`, `tool`, `design`, `directory`, `form`, `other`, `not_found` |
| `content_group` | Same as `page_type`. GA4 has a built-in **Content group** report for it, so no registration is needed |
| `site_section` | The guide the page belongs to, e.g. `modular-kitchen`, `materials`, `interior-designers` (`none` for pages outside a guide) |

What each `page_type` means:

| page_type | Pages |
|---|---|
| `home` | `/` |
| `pillar` | Main guides: `/materials/`, `/modular-kitchen/`, `/interior-designer-near-me/` … |
| `cluster` | Articles and comparisons inside a guide |
| `city` | `/interior-designers/<city>/` and its locality and budget pages |
| `blog` | `/blogs/` and every post |
| `tool` | Calculators |
| `design` | Trending designs (list and each design) |
| `directory` | Designer directory (`/services/find-designer/`), hidden until `PHASE2` |
| `form` | `/contact/`, `/verify/` (email link), `/thank-you/` |
| `other` | About, privacy, the comparison hub and similar |
| `not_found` | The 404 page |

---

## 2. Events

All names are lower-case snake_case.

### Form funnel (every form, including the pop-up and the Contact / Mail pop-up on listings)

| Event | When it fires | Parameters |
|---|---|---|
| `form_view` | The form is at least half on screen (pop-ups: when they open). Once per form per page | `form_name`, `form_location`, `page_type` |
| `form_start` | First tap into any field | same |
| `form_submit` | The details pass the checks in the browser and are sent to the server | same |
| `otp_sent` | The server emailed the 6-digit code and link | same |
| `otp_verified` | The email is confirmed (code or link). Counted once | same + `verify_method` (`code` or `link`) |
| `generate_lead` | **Only after the server confirms the enquiry was emailed to the team.** Counted once, even if the visitor has the form open in two tabs or confirms on another device | same + `lead_type` (`consultation` or `listing_enquiry`) |
| `form_error` | Any failed step | same + `reason` (`validation`, `captcha`, `daily_limit`, `server`), `error_detail` (which check: a field name, `otp`, `rate`, `limit`, `mail_failed`, `network` …), `form_step` (`details`, `code`, `link`, `send`), `error_source` (`browser` or `server`) |

`form_name` values: `free_consultation`, `call_back`, `call_back_strip`, `call_back_time_slot`,
`get_3_quotes`, `listing_enquiry`.

`form_location` values: `popup`, `contact_page`, `page_bottom`, `home_strip`, `blog_post_end`,
`in_page`, `listing_popup`. When the lead is confirmed from the email link, `email_link` is used only
if the original location is unknown.

After `generate_lead`, the user property **`lead_status = lead`** is set. It is set again on every
later visit from that browser, so you can build a "Leads" audience and compare them with everyone else.

If someone confirms from the email link on their phone, `otp_verified` and `generate_lead` are
counted on the phone, once. The original tab only shows "done" and sends nothing.

### Clicks

| Event | When it fires | Parameters |
|---|---|---|
| `click_call` | Any `tel:` link or Call button | `link_location` (header, footer, sticky_bar, content, popup, hero, …) |
| `click_whatsapp` | Any WhatsApp link or button | `link_location` |
| `click_email` | Any `mailto:` link | `link_location`, `email_type` (`contact` or `share`) |
| `social_click` | Instagram or Facebook links (footer icons, Facebook share) | `social_network` (`instagram`, `facebook`), `social_action` (`profile`, `share`), `link_location` |
| `partner_click` | Links to the partner studio (humainteriors.com) | `partner_name`, `link_url`, `link_domain`, `link_location` |
| `outbound_click` | Any other website | `link_url` (without query string), `link_domain`, `link_location` |
| `file_download` | Links to pdf, zip, doc(x), xls(x), csv, ppt(x), dwg, or links with `download` | `file_name`, `file_extension`, `link_domain`, `link_location` |
| `cta_click` | Main calls to action | `cta_name` (`free_consultation`, `cost_calculator`, `get_quote`, `find_designer`, `listing_contact`, `listing_mail`, `other_button`), `cta_location`, `cta_text` |

For links that open in the same tab and leave the site, the click waits until the event is sent (at
most 0.7 seconds) and then continues. Nothing is lost when the next page loads.

### Tools, filters and engagement

| Event | When it fires | Parameters |
|---|---|---|
| `calculator_use` | A calculator is used: first change (`start`), first result after a pause (`result`), Print or save as PDF (`print_pdf`) | `calculator_name` (`interior_cost`, `modular_kitchen`, `wardrobe_cost`, `room_by_room_quote`), `calc_action` |
| `filter_use` | A filter is changed on trending designs or the directory, or "near me" is used | `filter_name`, `filter_value`, `results_count`, `listing` (`trending_designs`, `designer_directory`) |
| `scroll_depth` | 25, 50, 75 and 90% of the page seen, once each per page | `percent_scrolled` |
| (automatic) | GA4 measures engaged time on its own (`user_engagement`). Check it under Reports → Engagement → Pages and screens → **Average engagement time** | — |

### Meta Pixel events

| Pixel event | When |
|---|---|
| `PageView` | Every page (plus the `<noscript>` image when JavaScript is off) |
| `Lead` | Together with `generate_lead`, with `eventID` = the lead reference (so Meta can de-duplicate) |
| `Contact` | Together with `click_call` and `click_whatsapp` |

Automatic Pixel events (button clicks, page metadata) are switched off in the code
(`fbq('set', 'autoConfig', false, …)`).

---

## 3. Key events to mark in GA4

GA4 → Admin → Data display → **Events** (or **Key events**). Mark these three:

1. **`generate_lead`** (the main conversion)
2. **`click_call`**
3. **`click_whatsapp`**

An event shows in the list after it has fired once, which can take up to 24 hours. To mark it
before that, use **New key event** and type the exact name.

---

## 4. Custom definitions to register

GA4 → Admin → Data display → **Custom definitions** → **Create custom dimension**. Use the parameter
name as the dimension name, so reports read the same as this document.

**Event-scoped dimensions**

| Parameter | Parameter | Parameter |
|---|---|---|
| `page_type` | `site_section` | `form_name` |
| `form_location` | `reason` | `error_detail` |
| `form_step` | `error_source` | `verify_method` |
| `lead_type` | `cta_name` | `cta_location` |
| `link_location` | `social_network` | `social_action` |
| `partner_name` | `email_type` | `calculator_name` |
| `calc_action` | `filter_name` | `filter_value` |
| `listing` | `percent_scrolled` | |

**User-scoped dimension:** `lead_status`

**Custom metric (optional):** `results_count` (event-scoped, Standard).

Built-in dimensions that need no registration: Content group, Link URL, Link domain, File name,
File extension. If GA4 says a name already exists, skip it.

Custom dimensions only fill in from the day you create them. Register them before the live test.

---

## 5. GA4 admin settings to change

| Where | Change | Why |
|---|---|---|
| Admin → Data streams → (web stream) → **Enhanced measurement** (gear icon) | **Form interactions: OFF** | The site sends its own `form_start` / `form_submit`. Left on, GA4 would send a second, duplicate set |
| same | **Scrolls: OFF** | The site sends `scroll_depth` at 25/50/75/90 |
| same | **Outbound clicks: OFF** | The site sends `outbound_click`, `social_click` and `partner_click` |
| same | **File downloads: OFF** | The site sends `file_download` |
| same | Page views → Show advanced settings → **Page changes based on browser history events: OFF** | Filters on trending designs change the address without loading a new page. Left on, every filter change would count as an extra page view |
| same | Page views ON, Site search ON (harmless), Video engagement ON | — |
| Admin → Data streams → (web stream) → Configure tag settings → **List unwanted referrals** | Add `mail.google.com`, `outlook.live.com`, `outlook.office.com`, `mail.yahoo.com`, `mail.zoho.com`, `rediffmail.com`, `enteriors.in` | When a visitor confirms from the email link, the lead stays credited to where they really came from, not to their webmail. The verify page also sends `ignore_referrer` for the same reason |
| Admin → Data streams → (web stream) → Configure tag settings → **Define internal traffic** | Add a rule: name `office`, `traffic_type` = `internal`, IP address = your office or home IP | Your own visits are kept out of reports. On a phone or changing IP, open any page once with **`?internal=1`** instead. That browser is then marked internal for a year (`?internal=0` undoes it) |
| Admin → Data collection and modification → **Data filters** | Internal Traffic filter: leave in **Testing** during the live test, then set to **Active**. Developer Traffic filter: **Active** | Testing keeps your test visits visible. Active removes them from reports. DebugView still shows debug traffic |
| Admin → Data collection and modification → **Data retention** | Event data retention: **14 months**. Reset user data on new activity: **ON** | The default is only 2 months, which is too short for year-on-year Explorations |
| Admin → Data collection and modification → **Data collection** | **Google signals: ON** | Adds demographics and cross-device reporting. The privacy page already explains that Google Analytics is used |
| Admin → Reporting identity | **Blended** (the default) | — |
| Admin → Product links → **Search Console links** | Link your Search Console property (do section 6 first) | Search queries and landing pages appear in GA4 |
| Admin → Property details | Time zone: **India (GMT+05:30)**. Currency: **Indian Rupee** | Days line up with the daily form limits and the lead emails |

**Meta Events Manager** (Data sources → your Pixel → Settings):

- **Automatic advanced matching: OFF.** When on, Meta reads email and phone fields from forms.
- **Track events automatically without code: OFF.** The code already disables it.
- **Traffic permissions:** allow only `enteriors.in`.

---

## 6. Google Search Console and sitemaps

**Verify the site** with one of these methods (any one is enough):

- **Domain property (recommended):** in Search Console add `enteriors.in` as a *Domain* property and
  copy the `google-site-verification=…` TXT record into MilesWeb → cPanel → Zone Editor →
  `enteriors.in` → Add Record (TXT). This covers http, https and www in one property.
- **HTML tag:** add a *URL-prefix* property for `https://enteriors.in/`, choose **HTML tag**, copy
  only the code inside `content="…"` into `config.php` → `TRACKING['gsc_verification']` and upload
  `config.php`. The tag is printed on every page.
- **HTML file:** download the `google….html` file Search Console offers and upload it into
  `public_html/`. Nothing in the code needs to change.

**Submit the sitemap** after the site is out of the pre-launch lock (`config.php` →
`const LAUNCHED = true;`). Before that, `/sitemap.xml` answers "not found" on purpose and every page
is noindex.

1. Search Console → Sitemaps → enter `sitemap.xml` → Submit. It lists every indexable page (164 at
   the last check). Sample listings, utility pages and phase-2 pages are left out automatically. It
   is also named in `/robots.txt`, so Google finds it on its own as well.
2. **Bing and others (IndexNow):** open `/admin/indexnow.php` (needs the admin password) and press
   **Submit**. It sends every sitemap page to Bing, Yandex, Seznam and Naver at once, using the
   IndexNow key already in `public_html/c87fa4a9510f7c3ed112221462b2a5f0.txt`. Use it again after
   adding or updating several pages. Google does not use IndexNow, so the Search Console submit is
   still needed for Google. Also add the site to Bing Webmaster Tools; it can import everything from
   Search Console.
3. Link Search Console to GA4 (section 5).

## 7. Where each enquiry came from (lead emails)

On a visitor's first page view the site saves a first-party cookie, `ent_src`, for 90 days. It
holds the `utm_*` tags, `gclid` / `gbraid` / `wbraid`, `fbclid`, the referring website and the
landing page, and it is never overwritten (first touch). When a form is sent, the server reads it
and every lead email to both inboxes gets a block like this:

```
WHERE THIS ENQUIRY CAME FROM
Channel:        Instagram (social) — tagged link
First visit:    2026-10-14 10:27
Landing page:   https://enteriors.in/
utm_source:     instagram
utm_medium:     social
utm_campaign:   bio
Form sent from: https://enteriors.in/materials/
```

Channel names used: Google Ads, Meta ads, `<Source> (<medium>) — tagged link`, Facebook or Instagram
(link click), Google search (organic), Other search engine, Instagram, Facebook, WhatsApp, AI
assistant, Other website: `<domain>`, Direct. The same values go into `leads/leads.csv` (columns
`landing`, `referrer`, `utm`), so `/admin/` reports by source as before. Ready-made links:
[`utm-links.md`](utm-links.md).

---

## 8. Live test checklist (after uploading)

Paste the GA4 ID first and upload `config.php`. Then, on your phone or computer:

1. **Debug on:** open `https://enteriors.in/?debug_mode=1` and keep browsing in that tab. Debug
   stays on for the tab; `?debug_mode=0` turns it off.
2. **GA4 → Admin → DebugView:** your device appears within a minute. Check:
   - [ ] `page_view` once per page, with `page_type` and `content_group` (click the event to see parameters)
   - [ ] `scroll_depth` at 25 / 50 / 75 / 90 on a long guide
   - [ ] `cta_click` on "Free Consultation" and on a calculator button
   - [ ] `form_view` when the pop-up opens, `form_start` when you tap a field
   - [ ] Send the pop-up empty: `form_error` with `reason = validation`
   - [ ] Fill it in properly (your own email): `form_submit`, then `otp_sent`
   - [ ] Type a wrong code: `form_error` (`reason = validation`, `error_detail = otp`)
   - [ ] Type the right code: `otp_verified`, then **`generate_lead`**. Under User properties, `lead_status = lead`
   - [ ] The lead email arrives at **both** inboxes with the "WHERE THIS ENQUIRY CAME FROM" block
   - [ ] Footer Instagram / Facebook icons: `social_click`. Email icon: `click_email`. Partner link: `partner_click`
   - [ ] A calculator: `calculator_use` (`start`, then `result` after you stop typing)
   - [ ] A filter on trending designs: `filter_use`, and **no** extra `page_view`
3. **Realtime report** (GA4 → Reports → Realtime): users, page views and event counts appear within
   about a minute, without debug mode too.
4. **Source test:** in a private window open
   `https://enteriors.in/?utm_source=test&utm_medium=test&utm_campaign=launch_check`, browse a page,
   send a form and confirm. The lead email should say `Test (test) — tagged link`.
5. **Meta:** install the **Meta Pixel Helper** Chrome extension. Every page shows `PageView`. A
   verified form shows `Lead`. In Events Manager → **Test events**, enter `https://enteriors.in` and
   repeat the form test.
6. **No personal data:** in DebugView, open `generate_lead` and `form_error`. There should be no
   name, email, phone or city values. In Pixel Helper, the `Lead` event shows only `content_name`
   and `content_category`.
7. Mark the key events (section 3) once they have appeared.
8. When testing is done: set the Internal Traffic filter to **Active**, and open the site once with
   `?internal=1` on each device you use, so your own visits stay out of the reports.

### If something looks wrong

| Symptom | Check |
|---|---|
| No GA4 data at all | `TRACKING_ON = true` and `TRACKING['ga4']` filled in `config.php`. View the page source and search for `gtag/js?id=G-` |
| `form_start` / `form_submit` twice | Enhanced measurement → Form interactions is still on |
| Page views jump when filtering designs | Enhanced measurement → "Page changes based on browser history events" is still on |
| Leads credited to `mail.google.com` or `google / organic` | Unwanted referrals list (section 5) |
| Your own visits in reports | Internal Traffic filter not Active, or open the site with `?internal=1` on that device |
