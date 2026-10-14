# Uploading this version

The zip `enteriors_public_html_14oct_ready.zip` (repo root) holds the whole `public_html/` folder.
Your private `leads/` folder sits next to `public_html/` on the server, not inside it, so uploading
never touches your leads.

## Upload

1. In MilesWeb File Manager, rename the current `public_html` to `public_html_old` (your backup).
2. Upload the zip next to it and extract. It creates a fresh `public_html/`.
3. Open the site and check a few pages, `/robots.txt` and one form (see "After upload").
4. When you are happy, delete `public_html_old`.

If you extract over the old folder instead, it is still safe. The retired pages are redirected
(`.htaccess` section 3d) or answer "410 Gone" (`/company/`, `/admin/companies.php`), and the other
leftovers are placeholder text files and one unused stylesheet. Starting clean is still the better choice.

## Before or right after upload

| What | Where | Why |
|---|---|---|
| Paste the two Cloudflare Turnstile keys | `includes/config.php` → `TURNSTILE` (section 5b) | Until then, forms use the built-in picture captcha. Get the keys at dash.cloudflare.com → Turnstile → Add widget, with hostnames `enteriors.in` plus your staging address, in "Managed" mode |
| Set the admin password | Open `/admin/` on staging once. It gives you a line to paste into `config.php` → `ADMIN` | `/admin/` (reports, images, add a design) stays off until then |
| Street, postal code and phone | `config.php` → `NAP` | Only if customers can visit that address and it matches your Google Business Profile. The site's structured data then switches from Organization to LocalBusiness by itself |
| Sender address for emails | `config.php` → `VERIFY['envelope_from']` | Only if code emails do not arrive: set `'no-reply@enteriors.in'` |

## After upload: quick test

- Send one real form with your own email. You should get a 6-digit code and a link, and after
  confirming, the enquiry arrives at the inbox set in `LEADS['notify_email']`.
- If you added Turnstile keys, the form shows the Cloudflare check instead of the picture captcha.
  This could not be tested before upload, because Cloudflare was not reachable from the build machine.

## Launch day (later)

- `config.php` → `const LAUNCHED = true;` turns on indexing, the sitemap, llms.txt and tracking
  (once tracking IDs are set). Then check `/robots.txt`, `/sitemap.xml` and the page source
  (`<meta name="robots">` should say `index, follow`).
- `config.php` → `const PHASE2 = true;` only if the "Find a designer" directory and the other
  phase-2 pages listed under it should go live at the same time.
