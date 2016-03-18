<?php

	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	require "../Login/CheckLogin.php";

	$questionNumber = $_POST["questionNumber"];
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
	if ($language == "C") {
		$studentFile = $path . $quizID . $MystudentID . $questionNumber . ".c";
		$gradeFile = $path . $quizID . $questionNumber . ".c";
	}
	else {
		$studentFile = $path . $quizID . $MystudentID . $questionNumber . ".c";
		$gradeFile = $path . $quizID . $questionNumber . ".c";
	}

	$currDate = date("Y-m-d");
	$currTime = date("h:i");


	$myFile = fopen($studentFile, "w");
	fwrite($myFile, $submission);
	fclose($myFile);

	$str = "../Grade/python os-system-calls.py " . $studentFile . " " . $gradeFile . " " . $language;
	//$str = "python os-system-calls.py " . $studentFile . " " . $gradeFile;
	exec($str, $op);

	$object = array();
	$outputFile = $quizID . $MystudentID . $questionNumber . ".txt";
	if (file_exists($outputFile)) {
		$object["success"] = true;
		$object["message"] = "results are found";
		$object["result"] = file_get_contents($outputFile);
	}
	else {
		$object["success"] = false;
		$object["message"] = "results file are not found";
		$object["result"] = "";
		echo json_encode($object);
		exit;
	}




	/* 	===============================================================
		Save Students file into database
		=============================================================== */
		
	$db = $mongo->selectDB("capstone");

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
			"save" => false));
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
			"save" => false
			));
	}


	echo json_encode($object);

?>