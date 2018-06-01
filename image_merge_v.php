<?php

function get_backg_size_v($arr, $name) {
	$ret = array();
	$w = array();
	$h = 0;
	foreach ($arr as $value) {
		if ($value !== $name && $value !== "sprite.png") {
			$w[] = getimagesize($value)[0];
			$h += getimagesize($value)[1];
		}
	}
	$ret[0] = max($w);
	$ret[1] = $h;
	return $ret;
}

function image_merge_v($arr, $name = "sprite.png", $padding = 0) {
	$i = 0;
	$j = 0;
	if (is_file($name))
		unlink($name);
	$backg_w = get_backg_size_v($arr, $name)[0] + ($padding*2);
	$backg_h = get_backg_size_v($arr, $name)[1] + ($padding*2);
	$backg_h += $padding * (count($arr) - 1);
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
			imagecopy($img, $src, $padding, $i+$padding,
				     0, 0, $src_w, $src_h);
			$i += $src_h + $padding;
		}
	}
	imagepng($img, $name);
}