IMAGES FOR BLOG POSTS
=====================
One folder per post, named in the post's entry in /includes/posts-data.php ('folder' => '...').
Normally the folder name is the same as the post's slug:

  post  /blogs/kitchen-colour-combinations/   ->  /assets/blogs/kitchen-colour-combinations/

  hero.jpg / hero.png / hero.webp   main image: shown under the title, on blog cards and when shared
  any-other-name.jpg                shown where the post says  <?= img('any-other-name') ?>

JPG, JPEG, PNG and WebP are all accepted. The file name becomes the alt text, so name files
in plain words: two-tone-kitchen-with-walnut-base-units.jpg -> "Two tone kitchen with walnut base units".
The hero image's alt text comes from 'hero_alt' in posts-data.php.
