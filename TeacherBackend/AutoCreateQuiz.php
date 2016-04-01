<?php

	// CREATE NEW QUIZ ONLY NO EDIT
	require "Quiz.php";

	ini_set('auto_detect_line_endings', true);
	$csv = "Quiz.csv";
	// Check if csv is given
	if (!isset($_POST["csv"])) {
		$object["message"][] = "csv not given";
	}
	else {
		$csv =  $_POST["csv"];
	}

	$file = fopen($csv, "r");
	$line = fgetcsv($file, 1024);
	$line = fgetcsv($file, 1024);
	$classID = $line[0];
	$quizName = $line[1];
	$timeAllowed = $line[2];	
	$language = $line[3];
	$retake = $line[4];
	fclose($file);

	$csv = "Quiz2.csv";
	// Check if csv is given
	if (!isset($_POST["csv2"])) {
		$object["message"][] = "csv not given";
	}
	else {
		$csv =  $_POST["csv2"];
	}

	$file = fopen($csv, "r");
	$line = fgetcsv($file, 1024);

	while(!feof($file)) {
		$line = fgetcsv($file, 1024);

		$question[] = $line[0];
		$numSubmission[] = $line[1];
		$answer[] = $line[2];
	}
	fclose($file);


	$csv = "Quiz3.csv";
	// Check if csv is given
	if (!isset($_POST["csv3"])) {
		$object["message"][] = "csv not given";
	}
	else {
		$csv =  $_POST["csv3"];
	}

	$file = fopen($csv, "r");
	$line = fgetcsv($file, 1024);

	while(!feof($file)) {
		$line = fgetcsv($file, 1024);
		$sectionNumber[] = $line[0];
		$beginDate[] = $line[1];
		$beginTime[] = $line[2];
		$lateDate[] = $line[3];
		$lateTime[] = $line[4];
		$endDate[] = $line[5];
		$endTime[] = $line[6];
	}
	fclose($file);


	if (!isset($_POST["quizID"])) {
		$cursor = $db->quizzes->find(array(
			"classID" => $classID
			));
	
		// Create Quiz ID - MAY NOT DELETE ANY QUIZZES
		$quizID = $classID . $cursor->count();
	}

	insertQuiz();
	gradeFile();

	$object["quizID"] = $quizID;
	echo json_encode($object);

?>



