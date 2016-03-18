<?php

	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	require "../Login/CheckLogin.php";


	/* 	===============================================================
		Get quizID or redirect
		=============================================================== */
	
	$code = array();
	$code = $_POST["code"];


	/* 	===============================================================
		Save the quiz into submission collection
		=============================================================== */

	$currDate = date("Y-m-d");
	$currTime = date("h:i");

	for ($i = 0; $i < count($code); $i++) {

		$cursor = $db->submission->find(array(
			"studentID" => $MystudentID,
			"quizID" => $quizID,
			"questionNumber" => $i+1,
			"graded" => false
			));

		if ($cursor->count() > 0) {
			$db->submission->remove(array(
				"studentID" => $MystudentID,
				"quizID" => $quizID,
				"questionNumber" => $i+1,
				"graded" => false
				));
		}
		$db->submission->insert(array(
			"studentID" => $MystudentID,
			"quizID" => $quizID, 
			"questionNumber" => $i+1, 
			"code" => $code[$i],
			"submitTime" => $currTime,
			"submitDate" => $currDate,
			"result" => "",
			"graded" => false,
			"save" => true
			));

		$object["success"] = true;
		$object["message"][] = "saved the quiz";
	}
	echo json_encode($object);

?>