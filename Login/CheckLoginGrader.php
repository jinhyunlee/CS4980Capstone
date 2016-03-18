<?php

	require "NetBadge.php";
	require "Sessions.php";

	require "CheckInstructor.php";

	if (!$isTeacher) {
		if (!isset($classID)) {
			// Check if the quiz id Exists
			$cursor = $db->quizzes->find(array(
				"quizID" => $quizID
				));

			if ($cursor->count() > 0) {
				// Get the class ID from the quiz ID
				foreach ($cursor as $document) {
					$classID = $document["classID"];
					continue;
				}
			}
			else {
				$object["success"] = false;
				$object["message"][] = "Quiz ID not found";
				echo json_encode($object);
				exit;
			}
		}

		// After finding the QUIZ id -> class ID, find the student in that Class
		$cursor = $db->roster->find(array(
			"studentID" => $id,
			"classID" => $classID
			));

		if ($cursor->count() > 0) {
			$object["message"][] = "id found in roster";
			
			// See if the student is in class
			foreach ($cursor as $document) {
				$Myta = $document["ta"];
				continue;
			}

			if (!$Myta) {
				$object["success"] = false;
				$object["message"][] = "id is not TA";
				echo json_encode($object);
				exit;
			}
			else {
				$object["success"] = true;
				$object["message"][] = "this is TA";
			}
		}
		else {
			$object["success"] = false;
			$object["message"][] = "id not found in roster";
			echo json_encode($object);
			exit;
		}
	}



?>