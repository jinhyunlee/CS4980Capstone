<?php

	require "NetBadge.php";
	require "Sessions.php";

	require "CheckInstructor.php";

	// If its not the teacher
	if (!$isTeacher) {
		// Find the quiz
		$cursor = $db->quizzes->find(array(
			"quizID" => $quizID
			));

		if ($cursor->count() > 0) {
			// Find the class ID
			foreach ($cursor as $document) {
				$classID = $document["classID"];
				continue;
			}
		}
		else {
			$object["success"] = false;
			$object["message"][] = "Quiz not found";
			echo json_encode($object);
			exit;
		}

		// Find the student
		$cursor = $db->roster->find(array(
			"studentID" => $id,
			"classID" => $classID
			));

		if ($cursor->count() > 0) {
			foreach ($cursor as $document) {
				$Myta = $document["ta"];
				$MystudentID = $document["studentID"];
				$MystudentName = $document["studentName"];
				$MysectionNumber = $document["sectionNumber"];
				$MyextraTime = $document["extraTime"];
				$Myemail = $document["email"];
			}
		}
		else {
			$object["success"] = false;
			$object["message"][] = "id not found";
			echo json_encode($object);
			exit;
		}

		$cursor = $db->allowed->find(array(
			"studentID" => $MystudentID,
			"quizID" => $quizID));

		if ($cursor->count() > 0) {
			foreach ($cursor as $document) {
				$MyretakeAllowed = $document["retakeAllowed"];
			}
		}
		else {
			$MyretakeAllowed = false;
		}
	}
?>