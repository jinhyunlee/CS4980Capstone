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


	/* 	===============================================================
		Get quizID or redirect
		=============================================================== */
	
	$code = array();
	$code = $_POST["code"];


	/* 	===============================================================
		Save the quiz into submission collection
		=============================================================== */

	$currDate = date("Y-m-d");
	$currTime = date("h:i:s");

	for ($i = 0; $i < count($code); $i++) {

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
				"save" => true,
				"try" => $taken
				));

			$object["success"] = true;
			$object["message"][] = "saved the quiz";
		}
	}
	echo json_encode($object);

?>