<?php

function css_generator_h($arr, $name = "style.css", $sprite_name, $padding = 0) {
	$i = 0;
	$str = "";
	foreach ($arr as $value) {
		if ($sprite_name !== $value) {
			$str .= ".";
			$str .= get_img_name($value);
			$i++;
			if ($i < count($arr))
				$str .= ", ";
		}
	}
	$i = 0;
	$str .= "\n{\ndisplay: inline-block;\nbackground: url('png.png') no-repeat;
overflow: hidden;\ntext-indent: -9999px;\ntext-align: center;\n}\n\n";
	foreach ($arr as $value) {
		if ($sprite_name !== $value) {
			$str .= "." . get_img_name($value) . "\n{\nbackground-position: ";
			$str .= ($i + $padding);
			$str .= "px -0px; width: " . getimagesize($value)[0] . "px; height: ";
			$str .= getimagesize($value)[1] . "px;\n}\n\n";
			$i += (getimagesize($value)[0] + $padding);
		}
	}
	file_put_contents($name, $str);
}

function get_img_name($value) {
	if (exif_imagetype($value) === 1)
		return basename($value, ".gif");
	if (exif_imagetype($value) === 2)
		return basename($value, ".jpeg");
	if (exif_imagetype($value) === 3)
		return basename($value, ".png");
}
?>