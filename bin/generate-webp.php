<?php
// Usage: php bin/generate-webp.php
ini_set('memory_limit', '1G');
// ponytail: one-shot sidecar generator, run again after adding or replacing images (no build step in this project)
$before = $after = 0;
$files = array_merge(
	glob('public/images/*.{jpg,jpeg,png,JPG,PNG}', GLOB_BRACE),
	glob('public/images/*/*.{jpg,jpeg,png,JPG,PNG}', GLOB_BRACE)
);
foreach ($files as $f) {
	$ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
	$img = $ext === 'png' ? @imagecreatefrompng($f) : @imagecreatefromjpeg($f);
	if (!$img) { echo "skip $f\n"; continue; }
	imagepalettetotruecolor($img);
	imagealphablending($img, false);
	imagesavealpha($img, true);
	imagewebp($img, "$f.webp", 82);
	unset($img);
	if (filesize("$f.webp") >= filesize($f)) {
		echo "dropped (not smaller): $f\n";
		unlink("$f.webp");
		continue;
	}
	$before += filesize($f);
	$after += filesize("$f.webp");
}
printf("converted: %d kB -> %d kB\n", $before / 1024, $after / 1024);
