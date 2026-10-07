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
