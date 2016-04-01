<?php


	require "Quiz.php";

	// Check if quiz id is given
	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}

    // View the quiz
	$cursor = $db->quizzes->find(array(
		"quizID" => $quizID
		));

	if ($cursor->count() > 0) {
		$object["success"] = true;
		$object["message"][] = "found the quiz";

		foreach ($cursor as $document) {

			$classID = $document["classID"];
			$quizName = $document["quizName"];
			$timeAllowed = $document["timeAllowed"];
			$retake = $document["retake"];
			//$problem = $document["problem"];
			//$date = $document["date"];

			$language = $document["language"];
			$question = $document["question"];
			$numSubmission = $document["numSubmission"];
			$answer = $document["answer"];

			$sectionNumber = $document["sectionNumber"];
			$beginTime = $document["beginTime"];
			$beginDate = $document["beginDate"];
			$lateDate = $document["lateDate"];
			$lateTime = $document["lateTime"];
			$endDate = $document["endDate"];
			$endTime = $document["endTime"];
		}

		$object["classID"] = $classID;
		$object["quizName"] = $quizName;
		$object["timeAllowed"] = $timeAllowed;
		$object["retake"] = $retake;

		$object["language"] = $language;
		$object["question"] = $question;
		$object["numSubmission"] = $numSubmission;
		$object["answer"] = $answer;

		$object["sectionNumber"] = $sectionNumber;
		$object["beginTime"] = $beginTime;
		$object["beginDate"] = $beginDate;
		$object["lateDate"] = $lateDate;
		$object["lateTime"] = $lateTime;
		$object["endDate"] = $endDate;
		$object["endTime"] = $endTime;
	}
	else {
		$object["success"] = false;
		$object["message"][] = "Did not find the quiz";
	}

	echo json_encode($object);

?>