<?php

	require "Roster.php";

	ini_set('auto_detect_line_endings', true);
	// Check if csv is given
	if (!isset($_POST["csv"])) {
		$object["success"] = false;
		$object["message"][] = "csv not given";
		echo json_encode($object);
	}
	else {
		$csv =  $_POST["csv"] . ".csv";
	}

	// Read the csv file
	$file = fopen($csv, "r");

	$line = fgetcsv($file, 1024);
	while(!feof($file)) {
		$line = fgetcsv($file, 1024);
		$studentID[] = $line[0];
		$studentName[] = $line[1];
		$email[] = $line[2];
		$sectionNumber[] = $line[3];
		$extraTime[] = $line[4];
		$ta[] = $line[5];
	}
	fclose($file);

	// Insert roster information
	insertRoster();

	echo json_encode($object);



?>