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
