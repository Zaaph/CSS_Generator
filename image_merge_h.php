<?php

include('recurse_search.php');

function get_backg_size_h($arr) {
	$ret = array();
	$w = 0;
	$h = array();
	foreach ($arr as $value) {
		$w += getimagesize($value)[0];
		$h[] = getimagesize($value)[1];
	}
	$ret[0] = $w;
	$ret[1] = max($h);
	return $ret;
}

function image_merge_h($arr, $name = "sprite.png", $padding = 20) {
	$i = 0;
	$j = 0;
	if (is_file($name))
		unlink($name);
	$arr = init_search();
	$backg_w = get_backg_size_h($arr)[0] + ($padding*2);
	$backg_w += $padding * (count($arr) - 1);
	$backg_h = get_backg_size_h($arr)[1] + ($padding*2);
	$backg = imagecreatetruecolor($backg_w, $backg_h);
	$bg = imagecolorallocatealpha($backg, 0, 0, 0, 127);
	imagefill($backg, 0, 0, $bg);
	imagesavealpha($backg, true);
	$img = $backg;
	foreach ($arr as $value) {
		$src = img_type_check($value);
		$src_w = getimagesize($value)[0];
		$src_h = getimagesize($value)[1];
		imagecopymerge($img, $src, $i+$padding, $j+$padding,
				     0, 0, $src_w, $src_h, 100);
		$i += $src_w + $padding;
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

$arr = init_search();
image_merge_h($arr);

?>