<?php

function get_backg_size_h($arr, $name) {
	$ret = array();
	$w = 0;
	$h = array();
	foreach ($arr as $value) {
		if ($value !== $name && $value !== "sprite.png") {
			$w += getimagesize($value)[0];
			$h[] = getimagesize($value)[1];
		}
	}
	$ret[0] = $w;
	$ret[1] = max($h);
	return $ret;
}

function image_merge_h($arr, $name = "sprite.png", $padding = 0) {
	$i = 0;
	if (is_file($name))
		unlink($name);
	$backg_w = get_backg_size_h($arr, $name)[0] + ($padding*2);
	$backg_w += $padding * (count($arr) - 1);
	$backg_h = get_backg_size_h($arr, $name)[1] + ($padding*2);
	$backg = imagecreatetruecolor($backg_w, $backg_h);
	$bg = imagecolorallocatealpha($backg, 0, 0, 0, 127);
	imagefill($backg, 0, 0, $bg);
	imagesavealpha($backg, true);
	$img = $backg;
	foreach ($arr as $value) {
		if ($value !== "$name" && $value !== "sprite.png") {
			$src = img_type_check($value);
			$src_w = getimagesize($value)[0];
			$src_h = getimagesize($value)[1];
			imagecopy($img, $src, $i+$padding, $padding,
				     0, 0, $src_w, $src_h);
			$i += $src_w + $padding;
		}
	}
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
?>