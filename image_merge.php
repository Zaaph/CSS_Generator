<?php

function image_merge($src_img, $dst_img) {
	$src = imagecreatefrompng($src_img);
	$dst = imagecreatefrompng($dst_img);
	$src_width = getimagesize($src_img)[0];
	$dst_width = getimagesize($dst_img)[0];
	$src_height = getimagesize($src_img)[1];
	$dst_height = getimagesize($dst_img)[1];
	imagecopy($dst, $src, $src_width, 0, 0, 0, $src_width, $src_height);
}

?>