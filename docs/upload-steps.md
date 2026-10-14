# Uploading the site

## What to download

On GitHub, open the repository, stay on the **main** branch, then **Code → Download ZIP**. The zip
contains one folder, `enteriors.in-main/`, with:

| Folder | What it is | Upload? |
|---|---|---|
| `public_html/` | The whole website | **Yes**: this is what goes on the server |
| `_removed-company/` (and `_removed-company.zip`) | The retired firm sign-in, kept for reference | No |
| `docs/` | Notes: SEO changes, keyword map, GA4 setup, UTM links, these steps | No |

Your private `leads/` folder sits next to `public_html/` on the server, not inside it. Uploading
never touches your leads, or the form secret the server keeps there (`leads/secret.key`, created
automatically on first use).

## Upload

1. In MilesWeb File Manager, rename the current `public_html` to `public_html_old` (your backup).
2. Upload the GitHub zip to your **home folder** (the folder that contains `public_html_old`, not
   inside it) and extract it there. This creates `enteriors.in-main/`.
3. Move `enteriors.in-main/public_html` up one level, so it sits next to `public_html_old`.
4. Delete `enteriors.in-main/` and the zip from the server. They hold only the notes and the retired
   files, which do not belong on the server.
5. Check a few pages, `/robots.txt` and one form (see "After upload").
6. When you are happy, delete `public_html_old`.

Never extract the GitHub zip *inside* `public_html`: the notes and the retired files would then be
reachable from the web.

If you copy the new `public_html` over the old one instead of replacing it, it is still safe. Retired pages are redirected
(`.htaccess` section 3d) or answer "410 Gone" (`/company/`, `/admin/companies.php`). Starting clean
is still the better choice.

## Settings in `public_html/includes/config.php`

| What | Where | Status |
|---|---|---|
| Form inboxes | `LEADS['notify_emails']` | Set: Enteriors.com@gmail.com and contact@enteriors.in. Server-side only, never shown on the site |
| Public email | `NAP['email']` | Set: contact@enteriors.in |
| GA4 Measurement ID | `TRACKING['ga4']` (section 4) | **Paste yours** (`G-…`). GA4 stays off until then |
| Search Console code | `TRACKING['gsc_verification']` | **Paste yours** (only the `content="…"` value) |
| Meta Pixel | `TRACKING['meta_pixel']` | Set: 2229913661272596 |
| Tracking switch | `TRACKING_ON` | `true`: tracking runs now, separate from the launch switch |
| Cloudflare Turnstile keys | `TURNSTILE` (section 5b) | Optional. Until set, forms use the built-in picture captcha. Get them at dash.cloudflare.com → Turnstile → Add widget (hostnames `enteriors.in` plus your staging address, "Managed" mode) |
| Admin password | `ADMIN` | Open `/admin/` on staging once; it gives you the line to paste |
| Street, postal code, phone | `NAP` | Only if customers can visit that address and it matches your Google Business Profile |
| Sender address for emails | `VERIFY['envelope_from']` | Only if code emails do not arrive: set `'no-reply@enteriors.in'` |

## After upload: quick test

- Send one real form with your own email. You get a 6-digit code and a link. After confirming, the
  enquiry arrives at **both** inboxes, with a "WHERE THIS ENQUIRY CAME FROM" block.
- Follow the live test checklist in [`ga4-setup.md`](ga4-setup.md), section 8 (DebugView,
  Realtime, Meta Pixel Helper).

## Launch day

- `config.php` → `const LAUNCHED = true;` turns on indexing, the sitemap and llms.txt. Then check
  `/robots.txt`, `/sitemap.xml` and the page source (`<meta name="robots">` should say `index, follow`).
- **Submit the sitemap only after this.** Before launch, `/sitemap.xml` answers "not found" on purpose.
  Then Search Console → Sitemaps → `https://enteriors.in/sitemap.xml`.
- `config.php` → `const PHASE2 = true;` only if the "Find a designer" directory and the other
  phase-2 pages should go live at the same time.
