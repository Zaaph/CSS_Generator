<?php

function get_backg_size_d($arr, $name) {
	$ret = array();
	$w = 0;
	$h = 0;
	foreach ($arr as $value) {
		if ($value !== $name && $value !== "sprite.png") {
			$w += getimagesize($value)[0];
			$h += getimagesize($value)[1];
		}
	}
	$ret[0] = $w;
	$ret[1] = $h;
	return $ret;
}

function image_merge_d($arr, $name = "sprite.png", $padding = 0) {
	$i = 0;
	$j = 0;
	if (is_file($name))
		unlink($name);
	$backg_w = get_backg_size_d($arr, $name)[0] + ($padding*2);
	$backg_w += $padding * (count($arr) - 2);
	$backg_h = get_backg_size_d($arr, $name)[1] + ($padding*2);
	$backg_h += $padding * (count($arr) - 2);
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
			imagecopymerge($img, $src, $i+$padding, $j+$padding,
				     0, 0, $src_w, $src_h, 100);
			$i += $src_w + $padding;
			$j += $src_h + $padding;
		}
	}
	imagepng($img, $name);
}

?>