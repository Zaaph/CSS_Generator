<?php

include('image_merge_h.php');
include('recurse_search.php');

function arg_check($argv) {
	$i = 1;
	$arr = init_search();
	while ($i < count($argv)) {
		if ($argv[$i] === "-r" || $argv[$i] === "-recursive") {
			$arr = init_search(1, $argv[count($argv)]);
		}
		if ($argv[$i] === ) {
			
		}
	}
}

?>