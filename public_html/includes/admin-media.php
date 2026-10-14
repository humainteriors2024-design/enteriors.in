<?php
/* ADMIN — saving uploaded photos (shared by /admin/images.php and /admin/designs.php). */

// Re-encode (strips camera and GPS data), turn upright, resize, write .jpg/.png + .webp. Returns the file names written.
function admin_save_image($tmp, $info, $ext, $base, $maxW) {
  if (!function_exists('imagecreatetruecolor')) { move_uploaded_file($tmp, "$base.$ext"); return [basename("$base.$ext")]; }
  $img = match ($info[2]) { IMAGETYPE_JPEG => imagecreatefromjpeg($tmp), IMAGETYPE_PNG => imagecreatefrompng($tmp), IMAGETYPE_WEBP => imagecreatefromwebp($tmp) };
  if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data') && ($o = @exif_read_data($tmp)['Orientation'] ?? 1) > 1)
    $img = match ((int) $o) { 3 => imagerotate($img, 180, 0), 6 => imagerotate($img, -90, 0), 8 => imagerotate($img, 90, 0), default => $img };
  $w = imagesx($img); $h = imagesy($img);
  if ($w > $maxW) { $img = imagescale($img, $maxW, (int) round($h * $maxW / $w), IMG_BICUBIC); }
  $alpha = $info[2] === IMAGETYPE_PNG && (imagecolortransparent($img) >= 0 || (imagecolorat($img, 0, 0) >> 24) > 0);
  $files = [];
  if ($alpha) { imagesavealpha($img, true); imagepng($img, "$base.png", 8); $files[] = basename("$base.png"); }
  else { imageinterlace($img, true); imagejpeg($img, "$base.jpg", 82); $files[] = basename("$base.jpg"); }
  if (function_exists('imagewebp')) { if ($alpha) imagesavealpha($img, true); imagewebp($img, "$base.webp", 80); $files[] = basename("$base.webp"); }
  imagedestroy($img);
  return $files;
}
