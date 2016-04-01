<?php

	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	require "../Login/Login.php";
	checkRoster($quizID);

	$questionNumber = (int)$_POST["questionNumber"];
	$submission = $_POST["submission"];
	$grade = filter_var($_POST["grade"], FILTER_VALIDATE_BOOLEAN);
	
	$cursor = $db->quizzes->find(array(
		"quizID" => $quizID
		));

	foreach ($cursor as $document) {
		$language = $document["language"];
		$numSubmission = $document["numSubmission"];
	}

	$path = "../Codes/";
	chdir($path);

	if ($language == "C") {
		$studentFile = $quizID . $MystudentID . $questionNumber . ".c";
		$gradeFile = $quizID . $questionNumber . ".c";
	}
	else {
		$studentFile = $quizID . $MystudentID . $questionNumber . ".c";
		$gradeFile = $quizID . $questionNumber . ".c";
	}

	$currDate = date("Y-m-d");
	$currTime = date("h:i:s");


	$myFile = fopen($studentFile, "w");
	fwrite($myFile, $submission);
	fclose($myFile);

	chmod($studentFile, 0777);

	if ($grade) {
	$str = "python os-system-calls.py " . $studentFile . " " . $gradeFile . " " . $language;
	}
	else {
		//$str = "python os-system-calls.py " . $studentFile . " C";
		$str = "python os-system-calls.py " . $studentFile . " " . $gradeFile . " " . $language;
	}
	$execs = exec($str, $op);

	$object["message"][] = getcwd();

	//$outputFile = $quizID . $MystudentID . $questionNumber . ".txt";
	$outputFile = $studentFile . ".txt";
	$object["message"][] = "OUT: " . $outputFile;
	if (file_exists($outputFile)) {
		$object["success"] = true;
		$object["message"][] = "results are found";
		$object["result"] = file_get_contents($outputFile);
	}
	else {
		$object["success"] = false;
		$object["message"][] = "results file are not found";
		$object["result"] = "";
		echo json_encode($object);
		exit;
	}




	/* 	===============================================================
		Save Students file into database
		=============================================================== */

	$cursor = $db->quizSubmission->find(array(
		"studentID" => $MystudentID,
		"quizID" => $quizID,
		"finished" => false
		));

	if ($cursor->count() == 0) {
		$object["success"] = false;
		$object["message"][] = "No quiz is going on";
	}
	else {
		foreach ($cursor as $document) {
			$taken = $document["try"];
			continue;
		}

		if ($grade) {
			$cursor = $db->submission->insert(array(
				"studentID" => $MystudentID,
				"quizID" => $quizID, 
				"questionNumber" => $questionNumber, 
				"graded" => true,
				"code" => $submission,
				"result" => $object["result"], 
				"submitTime" => $currTime,
				"submitDate" => $currDate,
				"save" => false,
				"try" => $taken
				));
		}
		else {

			$cursor = $db->submission->find(array(
				"studentID" => $MystudentID,
				"quizID" => $quizID,
				"questionNumber" => $questionNumber,
				"graded" => false
				));
			if ($cursor->count() > 0) {
				$db->submission->remove(array(
					"studentID" => $MystudentID,
					"quizID" => $quizID,
					"questionNumber" => $questionNumber,
					"graded" => false
					));
			}
			$db->submission->insert(array(
				"studentID" => $MystudentID,
				"quizID" => $quizID, 
				"questionNumber" => $questionNumber, 
				"code" => $submission,
				"submitTime" => $currTime,
				"submitDate" => $currDate,
				"result" => $object["result"],
				"graded" => false,
				"save" => false,
				"try" => $taken
				));
		}
	}


	echo json_encode($object);

?>