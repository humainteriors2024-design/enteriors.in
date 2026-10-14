# SEO changes — October 2026

This file explains the SEO decisions made on the `claude/website-refactor-forms-x5ihon` branch.
The full per-URL table is in [`keyword-map.csv`](keyword-map.csv).

## 1. Keyword map (task 6)

**Rule:** every indexable URL has exactly one primary keyword and one search intent, and no two
URLs share a primary keyword. The CSV has one row per URL (335 rows):

| Column | Meaning |
|---|---|
| `url` | The page address |
| `pillar` | The pillar (hub) it belongs to, from `includes/nav.php` |
| `primary_keyword` | The one search phrase the page is written to rank for |
| `search_intent` | Informational, Commercial investigation, Transactional, Local (commercial) or Navigational |
| `secondary_keywords` | Close variants the same page should also satisfy (they are not targeted by any other page) |
| `status` | Indexable at launch, noindex, or 301 |
| `decision_and_notes` | What was done and why |

How it was built: every page was crawled locally (317 pages after the changes), and its title, H1,
meta description, word count and the "Owns:" note in the source were compared. Pages were grouped
by topic, and any two pages aiming at the same or a near-identical phrase were treated as a
cannibalisation case. A script checks that no primary keyword appears twice.

Not given a keyword: the 100 trending-design pages and 45 directory profiles (fictional sample
listings, noindex until real ones replace them), and utility pages (`/thank-you/`, `/verify/`,
`/style-guide/`).

## 2. Cannibalisation found and how each case was fixed

### Merged + 301 (19 URLs)

Seventeen older blog posts repeated a main guide almost section for section. They were already
marked `canonical` to that guide, which hides the duplicate but still leaves two live pages, two
sets of internal links and two crawl paths. Each one is now **merged and redirected (301)**:
the guide keeps the URL, the few genuinely missing sections were rewritten into it, and the old
URL redirects in one hop (`.htaccess`, section 3d; `/blog/…` and `.php` variants included).

| Old URL | Now redirects to | What was carried over |
|---|---|---|
| /blogs/2-bhk-interior-cost-breakdown/ | /cost/2-bhk-interior-cost/ | Warranties to get in writing; designer vs contractor vs platform |
| /blogs/3-bhk-interior-budget-planning/ | /cost/3-bhk-interior-cost/ | Already covered (calculator, room-wise costs, phases) |
| /blogs/acrylic-finish-benefits-costs/ | /materials/acrylic-finish/ | Already covered |
| /blogs/acrylic-vs-laminate-complete-comparison/ | /compare/acrylic-vs-laminate/ | Already covered |
| /blogs/choosing-an-interior-designer-checklist/ | /planning/how-to-choose-interior-designer/ | Already covered (same structure) |
| /blogs/contemporary-living-india/ | /styles/contemporary/ | Already covered; it even had the same title |
| /blogs/hdhmr-board-carpenter-guide/ | /materials/hdhmr-board/ | Already covered |
| /blogs/interior-materials-a-to-z/ | /glossary/ | Glossary kept India-focused |
| /blogs/japandi-wabi-sabi-meets-scandinavian/ | /styles/japandi/ | Already covered |
| /blogs/kitchen-storage-solutions-guide/ | /modular-kitchen/storage-solutions/ | Already covered |
| /blogs/modular-kitchen-storage-units-explained/ | /modular-kitchen/storage-solutions/ | Already covered |
| /blogs/minimalist-home-design-ideas/ | /styles/minimalist/ | Already covered |
| /blogs/modular-kitchen-colour-pairings/ | /blogs/kitchen-colour-combinations/ | Colours by kitchen size and light; vastu note |
| /blogs/two-colour-kitchen-laminates/ | /blogs/kitchen-colour-combinations/ | Already covered (same structure) |
| /blogs/modular-kitchen-planning-guide/ | /modular-kitchen/ | Chimney and ventilation, appliance planning, lighting layers, one FAQ |
| /blogs/vastu-for-home-interiors-room-by-room/ | /vastu/ | Dining, bathrooms, balcony and staircase, mirrors and plants, adjustments without demolition, two FAQs |
| /blogs/veneer-finish-luxury-wood-guide/ | /materials/wood-veneer/ | Already covered |
| /rooms/vanity-dressing/ | /furniture/dressing-table-design/ | Both targeted "dressing unit / dressing table". Peninsula dresser row and seating clearances added |
| /rooms/utility-area/ | /rooms/balcony/ | Not a duplicate: the page was a balcony guide sitting on the wrong URL. Moved so URL, menu label and keyword match |

The blog now has 8 posts, each with its own keyword. Partner links that sat on retired pages were
removed (the targets already carry partner links).

### Re-targeted (title, H1, description and lede rewritten)

| URL | Was competing with | New primary keyword |
|---|---|---|
| /calculators/interior-cost/ | /calculators/home-interior-quote/ (both titled "Interior Cost Calculator") | interior cost per sq ft calculator |
| /materials/plywood-guide/ | /compare/bwp-vs-bwr-vs-mr-plywood/ (both "MR vs BWR vs BWP") | types of plywood |
| /services/find-designer/ | /interior-designer-near-me/ (both "…near you") | interior designer directory |
| /blogs/planning-home-interiors-hosur-road/ | the Electronic City and Chandapura pages (title named both) | home interiors on hosur road |
| /rooms/kids-room/ | /furniture/study-table-design/ (title was "Study Room Guide for Kids") | kids room design (sleep and safety sections added) |
| /rooms/bathroom/ | the dressing pages ("The Vanity & Bathroom", no keyword) | bathroom interior design |
| /planning/home-planning-checklist/ | /planning/new-home-handover-checklist/ (both "…to handover") | home interior checklist |
| /planning/new-home-handover-checklist/ | as above | flat handover checklist |

### Kept apart on purpose (similar topics, different keyword and intent)

- **Cost vs design:** `/false-ceiling/` (false ceiling design) and `/cost/false-ceiling-cost/` (false ceiling cost per sq ft); `/wall-design/wallpaper-guide/` (wallpaper for walls) and `/blogs/wallpaper-cost-per-sq-ft/`.
- **Whole home vs one room:** `/cost/home-renovation-cost/` and `/blogs/kitchen-renovation-cost/`.
- **Companies vs people:** `/interior-designers/india/` (best interior designers in India) and `/interior-designers/famous-interior-designers-india/` (famous designers, the people).
- **Style vs local service:** `/styles/luxury-interior/` and `/interior-designers/bangalore/luxury/`, `/interior-designers/mumbai/luxury/`.
- **Modern vs contemporary:** different searches with different meanings; each page defines its own style and links to the other.
- **City vs locality vs segment:** one page per city, and locality or budget pages under it (`/interior-designers/bangalore/electronic-city/`, `/…/budget/`) each with its own modifier.

## 3. What happens to redirected pages in Google

While the pre-launch lock is on, nothing new is indexed. The 301s make sure old links, bookmarks
and any URL Google crawled earlier land on the right page in one hop. Keep the 301 lines in
`.htaccess` permanently.

## 4. Pillar → cluster → sub-page structure (task 7)

The structure lives in one file, `includes/nav.php` (each pillar and its cluster pages). Every
page was crawled and its links in the main content (header, footer and menus excluded) were
checked against that structure. Result after the fixes:

| Check | Result |
|---|---|
| Every pillar links to every live cluster page in its group | Yes ("In this guide" cards on each pillar) |
| Every cluster page links up to its own pillar | Yes (the "Part of our guide to …" line under the H1, the breadcrumb and the "Keep reading" cards) |
| Every cluster page links to at least one sibling in the same pillar | Yes |
| Every blog post links to its pillar | Yes ("Part of a bigger guide" box) |
| `/interior-designer-near-me/` → every city page → every locality / segment page under that city | Yes |
| Locality and segment pages link to their city page and to each other | **Added**: a "More in <City>" line on every `/interior-designers/<city>/<page>/` (built automatically in `includes/foot.php`, so new locality pages get it too) |
| Orphan pages (no internal link in) | None, apart from utility pages that are meant to be unlinked and are noindex: `/verify/`, `/thank-you/`, `/style-guide/` |
| Broken internal links | None |

### Links fixed

- 15 links used old addresses for pages that exist under another URL, so they showed as plain text
  instead of links (for example `/blogs/interior-design-timeline/` → `/planning/interior-timeline/`,
  `/blogs/bwp-plywood-guide/` → `/materials/marine-plywood/`, `/rooms/tv-unit-designs/` →
  `/furniture/tv-unit-design/`). They now point to the right page.
- Links to the merged and moved pages (section 2) now point straight to their new URLs; no page
  links to a redirect.
- "Vanity & Dressing" in the Wardrobe and Room Guides menus became "Dressing Table Design";
  "Balcony Ideas" became "Balcony Design Ideas" and now opens the moved page.

### Links to pages not written yet

53 links point to pages that are planned but not yet uploaded (for example
`/wardrobe/sliding-wardrobe/`, `/cost/modular-kitchen-cost/`, the vastu room pages, the trends
pages). The site already handles these: on the live site the words show as plain text (no broken
link), on staging they get a dotted underline, and the link switches on by itself the day the
page is uploaded. They were left in place on purpose. A further 62 such links point to directory
profiles that stay hidden until `PHASE2` is switched on.

## 5. SEO tagging on every page (task 8)

Every page gets its tags from one template (`includes/head.php` and `includes/schema.php`), so the
audit was run on the rendered HTML of all 317 crawled pages.

| Tag | Rule | Before | After |
|---|---|---|---|
| `<title>` | Unique, keyword first, ≤ 65 characters with " \| Enteriors" | 18 too long, several cut mid-word with "…" | All unique and ≤ 65 |
| Meta description | Unique, 110–160 characters, a real sentence | 51 were the first paragraph cut off with "…"; 15 over 160 | All rewritten or trimmed; none cut off |
| Subheading (lede) under the H1 | A real sentence | The same cut-off text as the description showed on the page | Rewritten on every affected page |
| H1 | Exactly one, containing the page's primary keyword | One per page, but several had no keyword or were cut off ("The Complete Decision Guide", "Stop Lighting Your Home by Guesswork.", "FALSE CEILING COST GUIDE") | Keyword-first H1s |
| Canonical | Self-referencing (or the main page for paginated lists) | Present | Unchanged |
| Open Graph | og:title, og:description, og:url, og:image (+ size and alt when a hero photo exists) | Present | og:image:alt now uses descriptive hero alt text |
| Breadcrumb schema | `BreadcrumbList` on every page except the home page | Present | Unchanged |
| Article schema | `Article` on guides, `BlogPosting` on posts, with author, dates, citations | Present | Unchanged |
| FAQ schema | `FAQPage` wherever FAQs are shown | Missing on the home page | Added (148 pages) |
| LocalBusiness | Only where true | Firms on city pages were plain `Organization` | Firms with a published studio address are now `HomeAndConstructionBusiness` (a LocalBusiness type). Enteriors itself switches automatically once you add a street, postal code and phone in `config.php` → `NAP` (`schema_type` is now `'auto'`) |
| Image alt text | Every `<img>` has alt; decorative ones are empty | No image without alt | Descriptive hero alt added to 18 guides; the rest fall back to the page title |

Design and directory detail pages now build short titles (style + room + area + city) and cut
descriptions at a sentence or word, never mid-word, so real listings added later are tagged well
automatically.

Utility pages (`/thank-you/`, `/verify/`, `/style-guide/`) are noindex and kept short on purpose.

## 6. Content: easier reading and deeper thin pages (task 9)

### Easier to read

Many guides were migrated from an older page builder, and the move had left clutter in the text.
That clutter was removed across about 60 pages without changing what the pages say:

| Problem | Fix | Count |
|---|---|---|
| Section numbers fused into headings ("01 — FoundationWhat BWR plywood really is") | Plain headings (this also cleans the "On this page" list and anchor ids) | 155 headings |
| Paragraphs over 75 words | Split at sentence boundaries; run-on "Label: text. Label: text." paragraphs became bullet lists | 150+ paragraphs |
| Decorative leftovers shown as text: "Section 02", lone emoji, "01"/"02" step numbers, eyebrow labels above headings | Removed; step numbers moved into the heading or bold lead they belonged to | about 1,000 lines on 45 pages |
| Broken callout boxes (boxes inside boxes, stray tags, empty gaps) | Rebuilt: myth/fact pairs side by side (stacked on phones), tip cards in a grid, card headings as box titles | 15 pages |
| Unclosed paragraphs | Closed | 85 |
| Summaries that only made sense in the old layout | Rebuilt as tables or two-box comparisons (quartz vs granite, pooja room budgets, matte vs glossy) | 3 pages |

Result on the 169 guide and hub pages: no paragraph is longer than 80 words, the average paragraph is
29 words and the average sentence 17 words, and no page has stray or unclosed tags in its content.

**No keyword stuffing.** Six material pages repeated their keyword in almost every subheading
("Advantages of Gurjan Plywood", "Disadvantages of Gurjan Plywood", "Where Gurjan Plywood Works
Well", and 23 such headings on the membrane finish page). The keyword now stays in the H1 and a few
key headings; the other 69 subheadings were shortened ("Advantages", "How it is made").

**Facts checked and corrected:** the BWR plywood page wrongly described IS 303 (MR, BWR and BWP
are all grades under IS 303); one long duco paint sentence was split.

### Thin pages made useful

| Page | Added |
|---|---|
| 11 smaller city pages (Belgaum, Erode, Madurai, Mysore, Nellore, Tirunelveli, Trichy, Vellore, Vijayawada, Vizag, Warangal) | A table of areas, the homes found there and what to plan for; which months suit the work (monsoon and peak heat); one local section each: managing the work from another city (Tirunelveli), building and interiors with one firm (Nellore), Telangana GI crafts (Warangal), local textiles (Erode), designing for the heat (Vellore), renovating older Madras-terrace houses (Trichy), damp-proofing (Belgaum), flood-prone streets (Vijayawada), Mysuru crafts (Mysore), Chettinad details (Madurai), coastal hardware table (Vizag). No firm prices, as before. |
| /compare/ | Three comparison pages that were missing from the hub (calibrated vs normal plywood, engineered wood vs plywood, sliding vs hinged wardrobe); a quick-verdict table taken from each page's own conclusion; a "which comparison do you need" guide |
| /calculators/ | A "which calculator should I use" table and what to measure first |
| /calculators/interior-cost/ | Worked examples for 1–4 BHK at three grades, and how to read the room-wise split. Figures are calculated from the same rate sheet as the calculator (`includes/calc/rates.php`), so they update when the rates do |
| /calculators/wardrobe-cost/ | Five worked examples (also from the rate sheet) and how to measure the wall |
| /about/ | What is on the site, how firms are chosen for city pages, what happens to enquiry details, how to report a mistake |
| /contact/ | What happens after you send the form (email check, call, consultation, quotes) and what to have ready |

Pages that are short on purpose and stay short: `/thank-you/`, `/verify/`, `/privacy/`, and the
listing pages (`/blogs/`, `/trending-designs/`, `/services/find-designer/`), whose content is the list.
