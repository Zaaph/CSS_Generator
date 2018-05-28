#!/usr/bin/php

<?php
$time_start = microtime(true);

include('recurse_search.php');
include('image_merge_h.php');
include('css_generator_h.php');
include('image_merge_v.php');
include('css_generator_v.php');
include('image_merge_d.php');

function arg_check($argv = NULL) {
	$v = 0;
	$d = 0;
	if (is_dir($argv[count($argv) - 1]))
		$arr = init_search(0, $argv[count($argv) - 1]);
	else
		$arr = init_search();
	$short_opts = "ri:s:p:vd";
	$long_opts = array("recursive", "output-image:",
		 "output-style:", "padding:", "vertical", "diagonal");
	$options = getopt($short_opts, $long_opts);
	$output_img = "sprite.png";
	$output_css = "style.css";
	$padding = 0;
	foreach ($options as $key => $value) {
		if (($key === "r" || $key === "recursive") 
			&& is_dir($argv[count($argv) - 1]))
			$arr = init_search(1, $argv[count($argv) - 1]);
		elseif ($key === "r" || $key === "recursive")
			$arr = init_search(1);
		if ($key === "i" || $key === "output-image")
			$output_img = $value;
		if ($key === "s" || $key === "output-style")
			$output_css = $value;
		if (($key === "p" || $key === "padding") && $value !== FALSE)
			$padding = $value;
		if ($key === "v" || $key === "vertical")
			$v = 1;
		if ($key === "d" || $key === "diagonal")
			$d = 1;
	}
	if ($v === 0 && $d === 0) {
		image_merge_h($arr, $output_img, $padding);
		css_generator_h($arr, $output_css, $output_img, $padding);
	}
	elseif ($v === 1 && $d === 0) {
		image_merge_v($arr, $output_img, $padding);
		css_generator_v($arr, $output_css, $output_img, $padding);
	}
	elseif ($d === 1 && $v === 0) {
		image_merge_d($arr, $output_img, $padding);
	}
}

arg_check($argv);
?>