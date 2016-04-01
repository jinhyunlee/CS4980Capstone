<?php

	// Erase 
	$_POST["classID"] = "ABCD";

	require "Roster.php";

	$csv = "Roster.csv";


	ini_set('auto_detect_line_endings', true);
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
		$studentName[] = $line[1];
		$email[] = $line[2];
		$sectionNumber[] = $line[3];
		$extraTime[] = $line[4];
		$ta[] = $line[5];
	}
	fclose($file);

	$object["message"][] = $line[0];

	insertRoster();

	echo json_encode($object);



?>