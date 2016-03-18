<?php

	// Check if quiz id is given
	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	// Check if this is for grader
	require "../Login/CheckLoginGrader.php";

	// Array set up
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


	// TO DO: THIS LATER 
	/*$object["problem"] = array();
	$object["date"] = array();
	for ($i = 0; $i < count($question); $i++) {
		$object["problem"][] = array(
			"question" => $question[$i],
			"answer" => $answer[$i],
			"numSubmission" => $numSubmission[$i]
			);
	}
	for ($i = 0; $i < count($sectionNumber); $i++) {
		$object["date"][] = array(
			"sectionNumber" => $sectionNumber[$i],
			"beginDate" => $beginDate[$i],
			"beginTime" => $beginTime[$i],
			"lateDate" => $lateDate[$i],
			"lateTime" => $lateTime[$i],
			"endDate" => $endDate[$i],
			"endTime" => $endTime[$i]
			);	
	}*/

    // View the quiz
	$cursor = $db->quizzes->find(array("quizID" => $quizID));

	if ($cursor->count() > 0) {
		$object["success"] = true;
		$object["message"][] = "found the quiz";

		foreach ($cursor as $document) {

			$classID = $document["classID"];
			$quizName = $document["quizName"];
			$timeAllowed = $document["timeAllowed"];
			$retake = $document["retake"];
			//$problem = $document["problem"];
			//$date = $document["date"];

			$language = $document["language"];
			$question = $document["question"];
			$numSubmission = $document["numSubmission"];
			$answer = $document["answer"];

			$sectionNumber = $document["sectionNumber"];
			$beginTime = $document["beginTime"];
			$beginDate = $document["beginDate"];
			$lateDate = $document["lateDate"];
			$lateTime = $document["lateTime"];
			$endDate = $document["endDate"];
			$endTime = $document["endTime"];
		}

		$object["classID"] = $classID;
		$object["quizName"] = $quizName;
		$object["timeAllowed"] = $timeAllowed;
		$object["retake"] = $retake;

		$object["language"] = $language;
		$object["question"] = $question;
		$object["numSubmission"] = $numSubmission;
		$object["answer"] = $answer;

		$object["sectionNumber"] = $sectionNumber;
		$object["beginTime"] = $beginTime;
		$object["beginDate"] = $beginDate;
		$object["lateDate"] = $lateDate;
		$object["lateTime"] = $lateTime;
		$object["endDate"] = $endDate;
		$object["endTime"] = $endTime;
	}
	else {
		$object["success"] = false;
		$object["message"][] = "Did not find the quiz";
	}

	echo json_encode($object);

?>