<?php

	// Erase 
	$_POST["quizID"] = "ABCD0";

	require "Note.php";

	ini_set('auto_detect_line_endings', true);
	$csv = "Note.csv";
	// Check if csv is given
	if (!isset($_POST["csv"])) {
		$object["success"] = false;
		$object["message"][] = "csv not given";
	}
	else {
		$csv =  $_POST["csv"];
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
	}
	fclose($file);

	insertNote();

	echo json_encode($object);

?>