#!/usr/bin/php

<?php

include('recurse_search.php');
include('image_merge_h.php');
include('css_generator_h.php');

function arg_check($argv = NULL) {
	if (is_dir($argv[count($argv) - 1]))
		$arr = init_search(0, $argv[count($argv) - 1]);
	else
		$arr = init_search();
	$short_opts = "ri:s:p:";
	$long_opts = array("recursive", "output-image:", "output-style:", "padding:");
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
		if ($key === "p" || $key === "padding")
			$padding = $value;
	}
	image_merge_h($arr, $output_img, $padding);
	css_generator_h($arr, $output_css, $output_img, $padding);
}

arg_check($argv);

?>