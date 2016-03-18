<?php

	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	require "../Login/CheckLoginInstructor.php";

	$question = array();
	$answer = array();
	$numSubmission = array();
	$beginTime = array();
	$beginDate = array();
	$endDate = array();
	$endTime = array();
	$lateDate = array();
	$lateTime = array();
	$sectionNumber = array();

	$classID = $_POST["classID"];
	$quizName = $_POST["quizName"];
	$timeAllowed = $_POST["timeAllowed"];	
	$question = $_POST["question"];
	$numSubmission = $_POST["numSubmission"];
	$answer = $_POST["answer"];
	$retake = $_POST["retake"];
	$beginTime = $_POST["beginTime"];
	$beginDate = $_POST["beginDate"];
	$endDate = $_POST["endDate"];
	$endTime = $_POST["endTime"];
	$lateDate = $_POST["lateDate"];
	$lateTime = $_POST["lateTime"];
	$sectionNumber = $_POST["sectionNumber"];
	$language = $_POST["language"];

	// Number of questions
	$size = count($question);

	$cursor = $db->quizzes->find(array(
		"quizID" => $quizID
		));

	if ($cursor->count() > 0) {
		$db->quizzes->remove(array(
			"quizID" => $quizID
			));
	}
	else {
		$object["success"] = false;
		$object["message"][] = "quiz ID not found to edit";
		echo json_encode($object);
		exit;
	}

	$db->quizzes->insert(array(
		"teacherID" => $MyteacherID,
		"quizID" => $quizID,
		"classID" => $classID,
		"quizName" => $quizName,
		"timeAllowed" => $timeAllowed,
		"question" => $question,
		"numSubmission" => $numSubmission,
		"answer" => $answer,
		"retake" => $retake,
		"beginTime" => $beginTime,
		"beginDate" => $beginDate,
		"endTime" => $endTime,
		"endDate" => $endDate,
		"lateTime" => $lateTime,
		"lateDate" => $lateDate,
		"sectionNumber" => $sectionNumber,
		"language" => $language
		));

	$path = "../Codes/";
	// MUST be less than 100 questions
	for ($i = 1; $i <= 100; $i++) {
		$gradeFile = $path . $quizID . $i . ".c";
		if (file_exists($gradeFile)) {
			unlink($gradeFile);
		}
	}
	for ($i = 1; $i <= $size; $i++) {
		$gradeFile = $path . $quizID . $i . ".c";
		$myFile = fopen($gradeFile, "w");
		fwrite($myFile, $answer[$i-1]);
		fclose($myFile);
	}

	$object["success"] = true;
	$object["message"][] = "created";
	echo json_encode($object);

?>