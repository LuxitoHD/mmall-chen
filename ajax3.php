<?php
	$contents = file_get_contents($_GET['url']);
	header("Content-type:text/xml;charset=UTF-8");
	echo $contents;
?>