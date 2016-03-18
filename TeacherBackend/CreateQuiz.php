<?php

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

	$quizID =  "";
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
		"classID" => $classID
		));
	
	// Create Quiz ID - MAY NOT DELETE ANY QUIZZES
	$quizID = $classID . $cursor->count();

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
	// Create grading file
	for ($i = 1; $i <= $size; $i++) {
		$gradeFile = $path . $quizID . $i . ".c";
		if (!file_exists($gradeFile)) {
			$myFile = fopen($gradeFile, "w");
			fwrite($myFile, $answer[$i-1]);
			fclose($myFile);
		}
	}

	$object["success"] = true;
	$object["message"][] = "created";
	$object["quizID"] = $quizID;
	echo json_encode($object);

?>