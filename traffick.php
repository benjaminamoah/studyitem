<?php
	$file = "traffick.txt";
	$file2 = "j2me/traffick_learn.txt";
	$current = file_get_contents($file);
	$current2 = file_get_contents($file2);
	echo $current.". You know what this means...<br />";
	echo $current2.". You know what this means at learn...<br /><br />";

	$file3 = "j2me/traffick_dest.txt";
	$current3 = file_get_contents($file3);
	echo "Hi! These are the logs...";
	echo $current3;
?>