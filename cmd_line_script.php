<?php

function put_code_in_bin() {
	$code = file_get_contents('css_generator.php');
	if (is_file('/bin/css_generator'))
		unlink('/bin/css_generator');
	if (!(is_file('/bin/css_generator'))) {
		file_put_contents('/bin/css_generator', $code);
		shell_exec('chmod +x /bin/css_generator');
	}
	if (is_file('/bin/css_generator'))
		echo "css_generator correctly installed\n";
}

put_code_in_bin();

?>