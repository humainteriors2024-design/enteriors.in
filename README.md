# enteriors.in

`public_html/` is the website source (PHP, runs on the MilesWeb/LiteSpeed host). `public_html.zip` is the same folder packed for upload; rebuild it after any change:

```sh
rm -f public_html.zip && zip -qr -X public_html.zip public_html
```

## Interior designer directory (Oct 2026)

39 pages that cover the 68 "interior designers in …" keywords. `docs/interior-designers-keyword-map.csv` shows which page owns each keyword.

| Page type | URL | Count |
|---|---|---|
| Pillar ("interior designers near me") | `/interior-designer-near-me/` | 1 |
| India, Maharashtra, famous designers | `/interior-designers/india/`, `/interior-designers/maharashtra/`, `/interior-designers/famous-interior-designers-india/` | 3 |
| City pages | `/interior-designers/<city>/` | 20 |
| Locality and segment pages | `/interior-designers/<city>/<area or segment>/` | 15 |

**One place to edit firms:** `public_html/includes/data/designers.php` holds every firm (name, website, segment, offices and addresses, work categories), the cities and the price segments. Change a firm there and every page that lists it updates. A page only names its firms and gives a one-line reason for each, in the `'designers'` part of its `$page` block.

- **Images:** one optional image per firm in `public_html/assets/designers/<firm-key>.jpg` (or upload at `/admin/images.php?dir=/assets/designers`). Cards show it once the file exists.
- **Links:** every link to a firm is `rel="nofollow noopener"`.
- **Rules:** no firm appears on more than 3 pages; no ratings, phone numbers or staff names. Check before every upload:

```sh
php tools/check-designers.php
```

- **Helpers and styles:** `public_html/includes/designers.php` (tables, cards, method note, city price bands, ItemList schema) and `public_html/assets/css/designers.css`.
- **Redirects:** the old `/interior-designers-bangalore/` page and the three old "best/top designers" blog posts (Bangalore, Hyderabad, Pune) now 301 to the matching city pages (`.htaccess`, section 3b).
- **Re-check** addresses and websites every quarter and update `'checked'` in the data file. Titles carrying "(2026)" need updating each January.

## Trending designs and Find a designer (Oct 2026)

| Page | URL | Data |
|---|---|---|
| Trending designs (listing, filters on the left, 4-word search) | `/trending-designs/` | `includes/data/trends.php` |
| One design (7–10 pictures, details, Contact / Mail) | `/trending-designs/<key>/` | same |
| Find a designer (designers, freelancers, contractors, carpenters) | `/services/find-designer/` | `includes/data/pros.php` |
| One professional's profile | `/services/find-designer/<key>/` | same |

States, cities, localities and pincodes for both: `includes/data/places.php`. Engine: `includes/finder.php`. Settings: `config.php` → `FINDER` and `ENQUIRY`. Both pages are linked from the home page (two new sections and the hero links), the header ("Designs" menu and the "Find a Designer" button), the footer, the services menu and the interior-designer city pages.

**Everything in `trends.php` and `pros.php` is a fictional sample** (`'sample' => true`): names, people, ratings, reviews, projects, prices, and the drawn pictures marked SAMPLE. While samples are shown the pages carry a notice, are `noindex`, and stay out of the sitemap and llms.txt. Replace them with real entries and set `'sample' => false`.

- **Filters:** location (state → city), design type, property type and home size, budget, style; directory adds type, area, pincode (nearest first), apartment, rating, reviews, budget level, requirements (designer, carpenter, warranty, own factory, end-to-end, civil, plumbing, electrical, free consultation, 3D) and "use my location" (worked out in the visitor's browser; nothing is sent). Filtering works without JavaScript; with it, results update in place and the address stays shareable. Filtered addresses are `noindex` with the canonical on the main page.
- **Photos:** upload 7–10 photos per design to `/assets/trending/<key>/` (or `/admin/images.php` → "Trending design: …"); they replace the samples automatically. Logos: `/assets/pros/<key>.jpg`.
- **Contact / Mail with OTP** (`api/enquiry.php`): the visitor enters name, mobile, email, location (and a message for Mail); a 6-digit code is emailed; the enquiry is sent only after the code is entered. The firm gets it with Reply-To set to the visitor, you get a copy, the visitor gets a confirmation. A firm's email (`'email'` in `pros.php`) is never shown on the site and is used only when `'verified' => true`; until then enquiries come to `LEADS['notify_email']` marked "For: <firm>". Every enquiry is saved to `leads/enquiries.csv` and `leads/leads.csv` (one folder above `public_html`).
- **Protection:** same-site check, hidden honeypot, signed and timed form key, limits per connection, email, mobile and site-wide per day, throw-away email domains blocked, codes stored only as a keyed hash, 10-minute expiry, 5 tries, single use, no links or HTML in messages, header-injection-safe mail, no repeat sends to the same firm within 24 hours. On staging the code is also written to `leads/otp-test.log` so you can test without email. Optional SMS: `ENQUIRY['sms_webhook']`.
- **Check before every upload:**

```sh
php tools/check-directory.php
```
