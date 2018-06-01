#!/usr/bin/php

<?php

include('recurse_search.php');
include('image_merge_h.php');
include('css_writer_h.php');
include('image_merge_v.php');
include('css_writer_v.php');
include('image_merge_d.php');
include('css_writer_d.php');

function engine($argv = NULL) {
	$v = 0;
	$d = 0;
	$h = 0;
	if (is_dir($argv[count($argv) - 1]))
		$arr = init_search(0, $argv[count($argv) - 1]);
	else
		$arr = init_search();
	$short_opts = "ri:s:p:vdh";
	$long_opts = array("recursive", "output-image:",
		 "output-style:", "padding:", "vertical", "diagonal", "help");
	$options = getopt($short_opts, $long_opts);
	$output_img = "sprite.png";
	$output_css = "style.css";
	$padding = 0;
	opt_check($arr, $options, $output_img, $output_css, $v, $d, $h,
				$padding, $argv);
	opt_apply($arr, $options, $output_img, $output_css, $v, $d, $h, $padding);
}

function opt_check(&$arr, $options, &$output_img, &$output_css,
					 &$v, &$d, &$h, &$padding, $argv) {
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
		if ($key === "h" || $key === "help")
			$h = 1;
	}
}

function opt_apply($arr, $options, $output_img, $output_css,
					 $v, $d, $h, $padding) {
	if ($h === 1) {
		$man = file_get_contents('man.txt');
		echo $man;
		die();
	}
	if ($v === 0 && $d === 0) {
		image_merge_h($arr, $output_img, $padding);
		css_writer_h($arr, $output_css, $output_img, $padding);
	}
	elseif ($v === 1 && $d === 0) {
		image_merge_v($arr, $output_img, $padding);
		css_writer_v($arr, $output_css, $output_img, $padding);
	}
	elseif ($d === 1 && $v === 0) {
		image_merge_d($arr, $output_img, $padding);
		css_writer_d($arr, $output_css, $output_img, $padding);
	}
	elseif ($d === 1 && $v === 1) {
		echo "Please choose between diagonal or vertical concatenation,
		doing both is not possible (type -h or --help for more info)\n";
	}
}

engine($argv);
?>