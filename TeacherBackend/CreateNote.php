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

	$studentID = array();
	$notes = array();
	$lateAllowed = array();
	$exitAllowed = array();
	$moreAllowed = array();
	$lateDateAllowed = array();
	$retakeAllowed = array();
	$object = array();

	$studentID = $_POST["studentID"];
	$notes = $_POST["notes"];
	$lateAllowed = $_POST["lateAllowed"];
	$exitAllowed = $_POST["exitAllowed"];
	$moreAllowed = $_POST["moreAllowed"];
	$lateDateAllowed = $_POST["lateDateAllowed"];
	$retakeAllowed = $_POST["retakeAllowed"];

	$cursor = $db->quizzes->find(array(
		"quizID" => $quizID
		));

	if ($cursor->count() > 0) {
		for ($i = 0; $i < count($studentID); $i++) {

			$db->allowed->insert(array(
				"quizID" => $quizID,
				"studentID" => $studentID[$i], 
				"notes" => $notes[$i],
				"lateAllowed" => $lateAllowed[$i],
				"exitAllowed" => $exitAllowed[$i],
				"moreAllowed" => $moreAllowed[$i],
				"lateDateAllowed" => $lateDateAllowed[$i],
				"retakeAllowed" => $retakeAllowed[$i]
				));
		}

		$object["success"] = true;
		$object["message"][] = "Sucessfully inserted";
	}
	else {
		$object["success"] = false;
		$object["message"][] = "Quiz id not found";
	}

	echo json_encode($object);

?>