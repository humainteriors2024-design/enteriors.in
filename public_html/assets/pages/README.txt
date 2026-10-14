IMAGES FOR PAGES (everything except blog posts)
===============================================
One folder per page, with the same path as the page's URL:

  page  /modular-kitchen/                       ->  /assets/pages/modular-kitchen/
  page  /cost/2-bhk-interior-cost/              ->  /assets/pages/cost/2-bhk-interior-cost/
  home page                                     ->  /assets/pages/home/

For a new page, create the matching folder here and upload the images into it.

  hero.jpg / hero.png / hero.webp   the page's main image (shown under the title, used when the page is shared)
  any-other-name.jpg                shown where the page says  <?= img('any-other-name') ?>

Rules
  - JPG, JPEG, PNG and WebP are all accepted. If you upload BOTH name.webp and name.jpg,
    browsers get the smaller WebP and the JPG is the fallback.
  - Name files in plain words with hyphens: sliding-wardrobe-with-mirror.jpg
    The file name becomes the alt text: "Sliding wardrobe with mirror".
  - Keep photos under about 250 KB (1600 px wide is plenty).
  - <?= gallery() ?> in a page shows every image in its folder; <?= gallery('wardrobe') ?> only
    files whose names start with "wardrobe".
  - Videos: name.mp4 (and/or name.webm) with <?= video('name') ?>. An image of the same name is the poster.

Home page tiles: upload modular-kitchen.jpg, wardrobe.jpg, interior-cost.jpg, false-ceiling.jpg,
flooring.jpg (hero tiles) and modern.jpg, contemporary.jpg, scandinavian.jpg, japandi.jpg,
minimalist.jpg, industrial.jpg, traditional-indian.jpg, luxury.jpg (style tiles) to /assets/pages/home/.
A tile shows its photo as soon as the file exists; until then it shows an icon.
