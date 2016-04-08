<?php

	require "../Login/Login.php";

	// Check if quiz id is given
	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	$classID = getClassID($quizID);
	isGrader($classID);

	$studentID = array();
	$notes = array();
	$lateAllowed = array();
	$exitAllowed = array();
	$moreAllowed = array();
	$lateDateAllowed = array();
	$retakeAllowed = array();
	$earlyAccessAllowed = array();
	$lateAccessAllowed = array();

	function checkNotePostData() {

		// Check if the post data are sent
		if (!isset($_POST["studentID"]) || 
			!isset($_POST["notes"]) || 
			!isset($_POST["lateAllowed"]) ||
			!isset($_POST["exitAllowed"]) ||
			!isset($_POST["moreAllowed"]) ||
			!isset($_POST["lateDateAllowed"]) ||
			!isset($_POST["retakeAllowed"]) ||
			!isset($_POST["earlyAccessAllowed"]) ||
			!isset($_POST["lateAccessAllowed"])) {

			$GLOBALS['object']["success"] = false;
			$GLOBALS['object']["message"][] = "POST Data were not set";
			echo json_encode($object);
			exit;	
		}

		$GLOBALS['studentID'] = $_POST["studentID"];
		$GLOBALS['notes'] = $_POST["notes"];
		$GLOBALS['lateAllowed'] = $_POST["lateAllowed"];
		$GLOBALS['exitAllowed'] = $_POST["exitAllowed"];
		$GLOBALS['moreAllowed'] = $_POST["moreAllowed"];
		$GLOBALS['lateDateAllowed'] = $_POST["lateDateAllowed"];
		$GLOBALS['retakeAllowed'] = $_POST["retakeAllowed"];
		$GLOBALS['earlyAccessAllowed'] = $_POST["earlyAccessAllowed"];
		$GLOBALS['lateAccessAllowed'] = $_POST["lateAccessAllowed"];

		// TODO: Check for array length
	}

	function insertNote() {
		// See if the quiz exist for to have a note
		$cursor = $GLOBALS['db']->quizzes->find(array(
			"quizID" => $GLOBALS['quizID']
			));

		if ($cursor->count() > 0) {

			$cursor = $GLOBALS['db']->allowed->find(array(
					"quizID" => $GLOBALS['quizID']
					));

			if ($cursor->count() > 0) {
				$GLOBALS['db']->allowed->remove(array(
					"quizID" => $GLOBALS['quizID']
					));
				$GLOBALS['object']["message"][] = "removed First";
			}
			
			for ($i = 0; $i < count($GLOBALS['studentID']); $i++) {

				$GLOBALS['db']->allowed->insert(array(
					"quizID" => $GLOBALS['quizID'],
					"studentID" => $GLOBALS['studentID'][$i], 
					"notes" => $GLOBALS['notes'][$i],
					"lateAllowed" => filter_var($GLOBALS['lateAllowed'][$i], FILTER_VALIDATE_BOOLEAN),
					"exitAllowed" => filter_var($GLOBALS['exitAllowed'][$i], FILTER_VALIDATE_BOOLEAN),
					"moreAllowed" => filter_var($GLOBALS['moreAllowed'][$i], FILTER_VALIDATE_BOOLEAN),
					"lateDateAllowed" => filter_var($GLOBALS['lateDateAllowed'][$i], FILTER_VALIDATE_BOOLEAN),
					"retakeAllowed" => filter_var($GLOBALS['retakeAllowed'][$i], FILTER_VALIDATE_BOOLEAN),
					"earlyAccessAllowed" => filter_var($GLOBALS['earlyAccessAllowed'][$i], FILTER_VALIDATE_BOOLEAN),
					"lateAccessAllowed" => filter_var($GLOBALS['lateAccessAllowed'][$i], FILTER_VALIDATE_BOOLEAN)
					));
			}

			$GLOBALS['object']["success"] = true;
			$GLOBALS['object']["message"][] = "Sucessfully inserted";
		}
		else {
			$GLOBALS['object']["success"] = false;
			$GLOBALS['object']["message"][] = "Quiz id not found";
		}
	}

?>