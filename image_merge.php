<?php

include('recurse_search.php');
$arr = init_search();

function image_merge($arr, $name = "sprite.png", $padding = 0) {
	$i = 0;
	$j = 0;
	$x = 600;
	$y = 600;
	if (is_file('sprite.png'))
		unlink('sprite.png');
	$arr = init_search();
	var_dump($arr);
	$backg = imagecreatetruecolor(600, 600);
	$bg = imagecolorallocate($backg, 255, 255, 255);
	imagefilledrectangle($backg, 0, 0, 600, 600, $bg);
	$img = $backg;
	foreach ($arr as $value) {
		$src = img_type_check($value);
		$src_w = getimagesize($value)[0];
		$src_h = getimagesize($value)[1];
		imagecopyresampled($backg, $img, 0, 0, 0, 100, 100, 0, $src_w, $src_h);
		imagecopymerge($img, $src, $i, $j, 0, 0, 600, 600, 100);
		$i += $src_w;
		if ($i > getimagesize($value)[0]) {
			$j += $src_h;
			$i = 0;
		}
	}
	echo "$i\n";
	imagepng($img, $name);
}

function img_type_check($value) {
	if (exif_imagetype($value) === 1)
		return imagecreatefromgif($value);
	if (exif_imagetype($value) === 2)
		return imagecreatefromjpeg($value);
	if (exif_imagetype($value) === 3)
		return imagecreatefrompng($value);
}

image_merge('test3.jpeg');

?>
