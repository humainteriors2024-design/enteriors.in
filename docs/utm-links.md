# Ready-made UTM links

Use these links wherever you post a link to the site. GA4 reads the tags, and every lead email shows
them under "WHERE THIS ENQUIRY CAME FROM" (see [`ga4-setup.md`](ga4-setup.md), section 7). The
first visit is the one that counts, for 90 days.

**Rules:** lower-case only, underscores instead of spaces, the same spelling every time. Never add
UTM tags to links between pages of enteriors.in, because that would overwrite the real source.

## Instagram

| Where | Link |
|---|---|
| Bio link | `https://enteriors.in/?utm_source=instagram&utm_medium=social&utm_campaign=bio` |
| Story link sticker | `https://enteriors.in/?utm_source=instagram&utm_medium=social&utm_campaign=story&utm_content=TOPIC` |
| Post or reel (link in caption or comment) | `https://enteriors.in/?utm_source=instagram&utm_medium=social&utm_campaign=post&utm_content=TOPIC` |
| DM reply with the calculator | `https://enteriors.in/calculators/interior-cost/?utm_source=instagram&utm_medium=social&utm_campaign=dm` |

Replace `TOPIC` with a short word for the post, e.g. `modular_kitchen`, `2bhk_cost`, `wardrobe`.
If a link tool (Linktree and similar) sits in the bio, put the bio link above on each of its buttons,
changing only `utm_content` (e.g. `utm_content=consultation`).

## Facebook page

| Where | Link |
|---|---|
| Page "Website" field and action button | `https://enteriors.in/?utm_source=facebook&utm_medium=social&utm_campaign=page` |
| Post | `https://enteriors.in/?utm_source=facebook&utm_medium=social&utm_campaign=post&utm_content=TOPIC` |
| Free consultation post | `https://enteriors.in/contact/?utm_source=facebook&utm_medium=social&utm_campaign=post&utm_content=consultation` |

## WhatsApp

| Where | Link |
|---|---|
| WhatsApp Business profile (website) | `https://enteriors.in/?utm_source=whatsapp&utm_medium=social&utm_campaign=business_profile` |
| Sharing a guide in a chat or group | `https://enteriors.in/PAGE/?utm_source=whatsapp&utm_medium=social&utm_campaign=share` |
| Status | `https://enteriors.in/?utm_source=whatsapp&utm_medium=social&utm_campaign=status&utm_content=TOPIC` |
| Broadcast list | `https://enteriors.in/?utm_source=whatsapp&utm_medium=social&utm_campaign=broadcast&utm_content=MONTH` |
| Sending the calculator to an enquiry | `https://enteriors.in/calculators/home-interior-quote/?utm_source=whatsapp&utm_medium=social&utm_campaign=share` |

Replace `PAGE` with the page address, e.g. `cost/2-bhk-interior-cost`. WhatsApp sends no referrer,
so without these tags such visits look like "Direct".

## Google Ads

1. In Google Ads → Admin → Account settings, turn **Auto-tagging ON**. Each click then carries a
   `gclid`, which GA4 (once linked) turns into campaign, ad group and keyword reports. The lead
   email says "Google Ads".
2. Also set this **Final URL suffix** (Account settings, or per campaign), so the lead email shows
   the campaign and keyword too:

   ```
   utm_source=google&utm_medium=cpc&utm_campaign={campaignid}&utm_content={adgroupid}&utm_term={keyword}
   ```

3. Final URLs to use in ads: `https://enteriors.in/` (brand), `https://enteriors.in/contact/`
   (consultation ads), `https://enteriors.in/calculators/interior-cost/` (cost ads), and the
   matching guide for topic ads (e.g. `https://enteriors.in/modular-kitchen/`).
4. Link Google Ads to GA4: GA4 → Admin → Product links → Google Ads links.

## Meta ads (for later)

In Ads Manager → ad → Destination → **URL parameters**, paste:

```
utm_source={{site_source_name}}&utm_medium=paid_social&utm_campaign={{campaign.name}}&utm_content={{ad.name}}
```

Meta fills in `fb`, `ig` or `msg` and the names. The lead email then says "Meta ads (ig)" or
"Meta ads (fb)". Name campaigns in lower case with underscores.

## Other places

| Where | Link |
|---|---|
| Google Business Profile, website button | `https://enteriors.in/?utm_source=google&utm_medium=organic&utm_campaign=gbp` |
| Email signature | `https://enteriors.in/?utm_source=email&utm_medium=signature&utm_campaign=team` |
| Printed brochure or site board (QR code) | `https://enteriors.in/?utm_source=print&utm_medium=qr&utm_campaign=brochure` |
| Partner studio site linking to you | `https://enteriors.in/?utm_source=humainteriors&utm_medium=referral&utm_campaign=partner` |

## Checking a link

Open the link in a private window, then GA4 → Reports → Realtime → "First user source / medium"
should show it within a minute. For a full check, send one form from that window: the lead email
shows the tags under "WHERE THIS ENQUIRY CAME FROM".
