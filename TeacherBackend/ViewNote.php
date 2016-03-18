<?php

	
	// Check if quiz id is given
	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	require "../Login/CheckLoginGrader.php";

	// Array set up
	$studentID = array();
	$notes = array();
	$lateAllowed = array();
	$exitAllowed = array();
	$moreAllowed = array();
	$lateDateAllowed = array();
	$retakeAllowed = array();

	// Find quiz
	$cursor = $db->quizzes->find(array("quizID" => $quizID));
	if ($cursor->count() > 0) {

		$cursor = $db->allowed->find(array("quizID" => $quizID));

		foreach ($cursor as $document) {
			$studentID[] = $document["studentID"];
			$notes[] = $document["notes"];
			$lateAllowed[] = $document["lateAllowed"];
			$exitAllowed[] = $document["exitAllowed"];
			$moreAllowed[] = $document["moreAllowed"];
			$lateDateAllowed[] = $document["lateDateAllowed"];
			$retakeAllowed[] = $document["retakeAllowed"];
		}
	
		$object["success"] = true;
		$object["message"][] = "Did find the roster";

		$object["studentID"] = $studentID;
		$object["notes"] = $notes;
		$object["lateAllowed"] = $lateAllowed;
		$object["exitAllowed"] = $exitAllowed;
		$object["moreAllowed"] = $moreAllowed;
		$object["lateDateAllowed"] = $lateDateAllowed;
		$object["retakeAllowed"] = $retakeAllowed;
	}
	else {
		$object["success"] = false;
		$object["message"][] = "Did not find the quiz";
	}

	echo json_encode($object);

?>