<?php

	require "Note.php";

	ini_set('auto_detect_line_endings', true);
	// Check if csv is given
	if (!isset($_POST["csv"])) {
		$object["success"] = false;
		$object["message"][] = "csv not given";
	}
	else {
		$csv =  $_POST["csv"] . ".csv";
	}

	$file = fopen($csv, "r");

	$line = fgetcsv($file, 1024);
	while(!feof($file)) {
		$line = fgetcsv($file, 1024);
		$studentID[] = $line[0];
		$notes[] = $line[1];
		$lateAllowed[] = $line[2];
		$exitAllowed[] = $line[3];
		$moreAllowed[] = $line[4];
		$lateDateAllowed[] = $line[5];
		$retakeAllowed[] = $line[6];
		$earlyAccessAllowed[] = $line[7];
		$lateAccessAllowed[] = $line[8];
	}
	fclose($file);

	insertNote();

	echo json_encode($object);

?>