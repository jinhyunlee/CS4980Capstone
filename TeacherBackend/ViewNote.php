<?php

	
	require "Note.php";

	// Find quiz
	$cursor = $db->quizzes->find(array(
		"quizID" => $quizID
		));

	if ($cursor->count() > 0) {

		$cursor = $db->allowed->find(array(
			"quizID" => $quizID
			));

		foreach ($cursor as $document) {
			$studentID[] = $document["studentID"];
			$notes[] = $document["notes"];
			$lateAllowed[] = $document["lateAllowed"];
			$exitAllowed[] = $document["exitAllowed"];
			$moreAllowed[] = $document["moreAllowed"];
			$lateDateAllowed[] = $document["lateDateAllowed"];
			$retakeAllowed[] = $document["retakeAllowed"];
			$earlyAccessAllowed[] = $document["earlyAccessAllowed"];
			$lateAccessAllowed[] = $document["lateAccessAllowed"];
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
		$object["earlyAccessAllowed"] = $earlyAccessAllowed;
		$object["lateAccessAllowed"] = $lateAccessAllowed;
	}
	else {
		$object["success"] = false;
		$object["message"][] = "Did not find the quiz";
	}

	echo json_encode($object);

?>