<?php

	require "../Login/Login.php";

	isTeacher();

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
	$quizID = "";
	if (isset($_POST["quizID"])) {
		$quizID = $_POST["quizID"];
	}
	$quizName = "";
	$classID = "";
	$timeAllowed = "";	
	$retake = "";
	$language = "";

	function checkQuizPostData() {

		// TODO: CHECKS

		$GLOBALS['classID'] = $_POST["classID"];
		$GLOBALS['quizName'] = $_POST["quizName"];
		$GLOBALS['timeAllowed'] = $_POST["timeAllowed"];	
		$GLOBALS['question'] = $_POST["question"];
		$GLOBALS['numSubmission'] = $_POST["numSubmission"];
		$GLOBALS['answer'] = $_POST["answer"];
		$GLOBALS['retake'] = $_POST["retake"];
		$GLOBALS['beginTime'] = $_POST["beginTime"];
		$GLOBALS['beginDate'] = $_POST["beginDate"];
		$GLOBALS['endDate'] = $_POST["endDate"];
		$GLOBALS['endTime'] = $_POST["endTime"];
		$GLOBALS['lateDate'] = $_POST["lateDate"];
		$GLOBALS['lateTime'] = $_POST["lateTime"];
		$GLOBALS['sectionNumber'] = $_POST["sectionNumber"];
		$GLOBALS['language'] = $_POST["language"];

	}

	function insertQuiz() {

		$cursor = $GLOBALS['db']->quizzes->find(array(
			"quizID" => $GLOBALS['quizID']
			));

		if ($cursor->count() > 0) {
			$GLOBALS['db']->quizzes->remove(array(
				"quizID" => $GLOBALS['quizID']
				));
		}

		$GLOBALS['db']->quizzes->insert(array(
			"teacherID" => $GLOBALS['MyteacherID'],
			"quizID" => $GLOBALS['quizID'],
			"classID" => $GLOBALS['classID'],
			"quizName" => $GLOBALS['quizName'],
			"timeAllowed" => $GLOBALS['timeAllowed'],
			"question" => $GLOBALS['question'],
			"numSubmission" => $GLOBALS['numSubmission'],
			"answer" => $GLOBALS['answer'],
			"retake" => $GLOBALS['retake'],
			"beginTime" => $GLOBALS['beginTime'],
			"beginDate" => $GLOBALS['beginDate'],
			"endTime" => $GLOBALS['endTime'],
			"endDate" => $GLOBALS['endDate'],
			"lateTime" => $GLOBALS['lateTime'],
			"lateDate" => $GLOBALS['lateDate'],
			"sectionNumber" => $GLOBALS['sectionNumber'],
			"language" => $GLOBALS['language']
			));

		$GLOBALS['object']["success"] = true;
		$GLOBALS['object']["message"][] = "created";

	}

	function gradeFile() {

		// Number of questions
		$size = count($GLOBALS['question']);

		$path = "../Codes/";
		// MUST be less than 100 questions
		for ($i = 1; $i <= 100; $i++) {
			$gradeFile = $path . $GLOBALS['quizID'] . $i . ".c";
			if (file_exists($gradeFile)) {
				unlink($gradeFile);
			}
		}
		for ($i = 1; $i <= $size; $i++) {
			$gradeFile = $path . $GLOBALS['quizID'] . $i . ".c";
			$myFile = fopen($gradeFile, "w");
			fwrite($myFile, $GLOBALS['answer'][$i-1]);
			chmod($gradeFile, 0777);
			fclose($myFile);
		}

		$GLOBALS['object']["success"] = true;
		$GLOBALS['object']["message"][] = "Files created";
	}
?>