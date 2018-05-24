<?php

include('image_merge_h.php');

function arg_check($argv = NULL) {
	$i = 1;
	/*$arr = init_search();*/
	/*while ($i < count($argv)) {
		if ($argv[$i] === "-r" || $argv[$i] === "-recursive") {
			$arr = init_search(1, $argv[count($argv)]);
		}
		if ($argv[$i] === "-i") {
			
		}
	}*/
	$options = "r:";
	$options .= "recursive:";
	$options .= "i:";
	$options .= "output-image:";
	$opt = getopt("i:");
	var_dump($opt);
}

arg_check();

?>