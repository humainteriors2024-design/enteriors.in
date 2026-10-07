# enteriors.in: SEO, content and outbound-link update (7 October 2026)

`public_html.zip` in this branch is the updated site. The same files are in `public_html/` so every change can be read file by file. No new pages were created and no URL was changed.

## How to put it live

1. Back up the current `public_html` on the server.
2. Upload and extract `public_html.zip` so that its contents replace the existing files (the zip has one top-level `public_html` folder).
3. In the file manager, delete the inner copies of folders that sit inside themselves (`cost/cost`, `styles/styles`, `about/about` and so on). The new `.htaccess` redirects those addresses either way, but the copies should go.
4. Open `https://enteriors.in/sitemap.xml`. It should list 127 URLs and none with a repeated folder.
5. Resubmit the sitemap in Google Search Console.

## What was wrong on the live site

- **Every page existed twice.** Folders had been uploaded inside themselves, so `/cost/cost/2-bhk-interior-cost/` loaded the same page as `/cost/2-bhk-interior-cost/`, with its own canonical, and the sitemap listed both.
- **Visible leftovers from the migration.** Photo placeholders ("File: ….webp · Alt: …"), "Section 04" labels, "Appendix B · AI Image Prompts", fragments of a build script, quizzes and calculators that did nothing ("₹0"), call-out boxes nested inside each other, labels run into values ("Best forVillas").
- **Statements the site cannot back.** Many guides said Enteriors has a factory, delivered projects, a "Senior Production Head" and named designers. The About page says Enteriors is a knowledge site. The two contradicted each other.
- **Titles and descriptions** cut off with "…", in capitals, or not matching the page (the balcony-workspace guide was titled "Utility Area Design").
- **Headings out of order** on about 60 pages (h2 straight to h4).
- **No Google tag.**

## What changed

### Technical
- `.htaccess`: 301 from any repeated-folder address to the real one. `includes/head.php` does the same if the rule is missing. `sitemap.php` never lists such an address.
- A mistyped address no longer creates an image folder on the server.
- 17 older blog posts that cover a topic a main guide owns are now `noindex, follow` instead of carrying a canonical to a different article. One switch in `config.php` (`DUPLICATE_TOPIC`) reverses this.
- Headings are put in order when the page is built (`includes/foot.php`), so pages do not have to be rewritten by hand.
- Contents-list entries no longer show `&amp;`.

### Tracking
- Google tag `G-W1N4YLVNJX` set in `includes/config.php`. It loads only on the live domain.
- Every page view and event now carries `visit_source` (ai-assistant, organic-search, social, referral, campaign, direct) and `visit_referrer`, kept for the whole visit. Register both as custom dimensions in GA4 to report AI-assistant traffic separately. Form starts, leads, call, WhatsApp, button and outbound clicks were already tracked.

### Content
- Migration leftovers removed from 81 pages; flattened cards turned back into lists or tables; dead quizzes and calculators replaced with links to the real calculators.
- First-person factory and project claims rewritten in a neutral voice; invented statistics and unattributed expert quotes removed.
- 64 titles, H1s and descriptions rewritten; truncated sub-headings replaced.
- About 5,400 em dashes replaced with ordinary punctuation; stock phrases removed.
- The "Top 20" Bangalore post is now an unranked list that says where its details come from.
- Illustrations already in the repository added for 16 existing pages; alt text added for image slots.

### Links to humainteriors.com
- 29 links on 26 pages, to 27 pages. All are inside the text of a page on the same subject, open in a new tab and are ordinary followed links.
- Addresses live in one place: `includes/config.php` → `OUTSIDE`. Pages call `outlink('huma.key', 'words')`.
- Not linked because they do not load: `/blogs/home-interior-design-price.php` (404), `/blogs/kitchen-interior-designers-in-bangalore.php` (404), `/blogs/services/` (410). `/blogs/interior-designers-in-chandapura/` shows the home page, so the home page is linked instead.

## Needs you

- **Rotate two secrets.** This repository is public and `includes/config.php` holds the form-signing secret and the admin password hash. Change both, or make the repository private.
- **Business details.** Phone, WhatsApp, street address and the facts block in `config.php` are empty, so no call button shows and the organisation schema has no address.
- **Social links.** Confirm the Instagram, Facebook, YouTube and LinkedIn addresses in `config.php` are really yours.
- **Photographs.** 107 of 127 indexable pages still have no image. `/admin/images.php` lists what each page is waiting for.
- **Facts about other firms.** The Bangalore, Pune and Hyderabad designer lists describe third-party firms and have not been checked.
- **If Enteriors does have a factory and delivered projects,** say so on the About page and fill the facts block; the neutral wording can then be changed back.
