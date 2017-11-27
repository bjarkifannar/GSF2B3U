<?php
	$s_info_post = split("\n", $_POST['as_info']);
	$school_info = array();

	foreach ($s_info_post as $line) {
		$tmp = split(':', $line);
		$school_info[strtolower(str_replace(' ', '_', $tmp[0]))] = trim($tmp[1]);
	}

	$json_school_info = json_encode($school_info, JSON_UNESCAPED_UNICODE);
?>