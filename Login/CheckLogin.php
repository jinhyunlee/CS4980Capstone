<?php

	$id = "a"; // STUDENT
	//$id = "c"; // TA
	//$id = "0"; // PROFESSOR

	if ($id == "0") {
		$teacherID = "0";
		$studentID = "0";
	}
	else {

		$mongo = new MongoClient(); 
		$db = $mongo->selectDB("capstone");
		$cursor = $db->quizzes->find(array("quizID" => $quizID));

		if ($cursor->count() > 0) {

			foreach ($cursor as $document) {
				$classID = $document["classID"];
			}
		}
		else {
			$object["success"] = false;
			$object["message"] = "Quiz not found";

			echo json_encode($object);
			exit;
		}

		$cursor = $db->roster->find(array(
			"studentID" => $id,
			"classID" => $classID));

		if ($cursor->count() > 0) {

			$extraTime = 1;
			foreach ($cursor as $document) {
				$ta = $document["ta"];
				$studentID = $document["studentID"];
				$studentName = $document["studentName"];
				$MysectionNumber = $document["sectionNumber"];
				$extraTime = intval($document["extraTime"]);
				$email = $document["email"];
				$ta = $document["ta"];

			}
		}
		else {
			$object["success"] = false;
			$object["message"] = "id not found";

			echo json_encode($object);
			exit;
		}

		$cursor = $db->allowed->find(array(
			"studentID" => $id,
			"quizID" => $quizID));

		if ($cursor->count() > 0) {

			foreach ($cursor as $document) {
				$retakeAllowed = $document["retakeAllowed"];
			}
		}
		else {
			$retakeAllowed = "false";
		}
		

	}



?>