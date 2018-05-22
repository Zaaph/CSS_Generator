function image_merge($arr, $name = "sprite.png", $padding = 0) {
	$i = 0;
	$j = 0;
	if (is_file('sprite.png'))
		unlink('sprite.png');
	$arr = init_search();
	var_dump($arr);
	$backg = imagecreatetruecolor(600, 600);
	$bg = imagecolorallocate($backg, 255, 255, 255);
	imagefilledrectangle($backg, 0, 0, 600, 600, $bg);
	$img = $backg;
	foreach ($arr as $value) {
		$src = imagecreatefromjpeg($value);
		$src_w = getimagesize($value)[0];
		$src_h = getimagesize($value)[1];
		imagecopyresampled($backg, $src, 0, 0, 0, 600, 600, 0, $src_w, $src_h);
		imagecopymerge($img, $backg, 0, $i, 0, 0, 600, 600, 100);
		$i += $src_w;
		/*if ($i >= getimagesize($value)[0]) {
			$j += $src_h;
			$i = 0;
		}*/
	}
	echo "$i\n";
	imagepng($img, $name);
}

