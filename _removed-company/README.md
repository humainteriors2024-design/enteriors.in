# Removed: company login (/company/) — 14 Oct 2026

The firm sign-in feature was taken off the website. Everything that existed **only** for it is in
this folder, at the same paths it had inside `public_html/`, so it can be restored or deleted.

| Moved here | What it was |
|---|---|
| `public_html/company/index.php` | sign-in page (email → 6-digit code) and the profile editor |
| `public_html/company/approve.php` | one-click approve / reject links emailed to the admin |
| `public_html/includes/company.php` | engine: fields, validation, storage, sessions, codes |
| `public_html/includes/config-COMPANY-block.php` | the `COMPANY` settings block cut from `config.php` (section 14) |
| `public_html/assets/css/company.css` | styles for the sign-in page and the profile extras |
| `public_html/assets/pages/company/` | the page's image-folder note |
| `public_html/admin/companies.php` | admin approvals list |

## Shared files that were edited (not moved)

Originals of the two files with larger edits are in `originals-of-edited-files/`; every original is also in the git history (the baseline commit on this branch).

- `includes/site.php` — no longer loads `company.php`.
- `includes/config.php` — `COMPANY` block removed; "PARTNER STUDIO" renumbered 15 → 14.
- `includes/nav.php` — "Company login" removed from the footer legal links.
- `includes/finder.php` — `pros_db()` no longer merges approved company profiles;
  the segment list moved from `company_segments()` to a new `pro_segments()`.
- `index.php`, `services/find-designer/index.php` — call `pro_segments()` instead of `company_segments()`.
- `includes/pages/pro.php` — the profile sections filled in by firms (offer, USPs, materials,
  social links, factory / GST facts) were removed; the directory profile itself still works.

Nothing else included the module: the designer directory, trending designs and the enquiry API
(`api/enquiry.php`) only read `includes/data/pros.php`, which is unchanged.

## Data on the server

If any firm already signed in on the live server, their saved profiles are in
`leads/companies/*.json` (one level **above** `public_html`). Download them before deleting.

## To restore later

Copy the files back to the same paths, paste `config-COMPANY-block.php` back into `config.php`,
restore the `require_once __DIR__ . '/company.php';` line in `includes/site.php`, and swap the
edited shared files for the originals (re-applying any newer changes made to them since).
