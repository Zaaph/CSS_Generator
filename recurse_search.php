<?php

function init_search($recurse = 0, $dir = '.') {
    if (!is_dir($dir)) {
        return false;
    }
    $files = array();
    if ($recurse === 1) {
	   recurse_search($dir, $files);
	   $images = image_search($files);
	   return $images;
    }
    $folder = opendir($dir);
    while (($file = readdir($folder)) !== FALSE) {
        if ($file === '.' || $file === '..' || $file === "sprite.png") {
            continue;
        }
        $filepath = $dir == '.' ? $file : $dir . '/' . $file;
        if (is_file($filepath))
            $files[] = $filepath;
        else
            continue;
    }
    closedir($folder);
    $images = image_search($files);
    return $images;
}

function recurse_search($dir, &$files) {
    $folder = opendir($dir);
    while (($file = readdir($folder)) !== FALSE) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        $filepath = $dir == '.' ? $file : $dir . '/' . $file;
        if (is_file($filepath))
            $files[] = $filepath;
        elseif (is_dir($filepath))
            recurse_search($filepath, $files);
    }
    closedir($folder);
}

function image_search($files) {
    $images = array();
    foreach ($files as $file) {
        if (exif_imagetype($file) !== FALSE)
	    $images[] = $file;
    }
    return $images;
}
?>