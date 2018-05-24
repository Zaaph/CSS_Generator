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
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== FALSE) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        $filepath = $dir == '.' ? $file : $dir . '/' . $file;
        if (is_file($filepath))
            $files[] = $filepath;
        else
            continue;
    }
    closedir($handle);
    $images = image_search($files);
    return $images;
}

function recurse_search($dir, &$files) {
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== FALSE) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        $filepath = $dir == '.' ? $file : $dir . '/' . $file;
        if (is_link($filepath))
            continue;
        if (is_file($filepath))
            $files[] = $filepath;
        elseif (is_dir($filepath))
            recurse_search($filepath, $files);
    }
    closedir($handle);
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