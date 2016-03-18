<?php

	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	require "../Login/CheckLogin.php";

	$cursor = $db->quizzes->find(array(
		"quizID" => $quizID
		));

	$numSubmission = array();
	$beginDate = array();
	$beginTime = array();
	$endDate = array();
	$endTime = array();
	$sectionNumber = array();
	$lateDate = array();
	$lateTime = array();
	$question = array();


	if ($cursor->count() > 0) {
		foreach ($cursor as $document) {
			$numSubmission = $document["numSubmission"];
			$question = $document["question"];
			$quizName = $document["quizName"];
			$timeAllowed = $document["timeAllowed"];
			$retake = $document["retake"];
			$beginTime = $document["beginTime"];
			$beginDate = $document["beginDate"];
			$lateTime = $document["lateTime"];
			$lateDate = $document["lateDate"];
			$endTime = $document["endTime"];
			$endDate = $document["endDate"];
			$sectionNumber = $document["sectionNumber"];
			$language = $document["language"];
		}

		$size = count($question);


		$currDate = date("Y-m-d");
		$currTime = date("h:i");

		// Get the begin and end date 
		if (is_array($sectionNumber)) {
			$index = array_search($MysectionNumber, $sectionNumber);

			$MybeginDate = $beginDate[$index];
			$MybeginTime = $beginTime[$index];
			$MyendDate = $endDate[$index];
			$MyendTime = $endTime[$index];
		}
		else {
			$MybeginDate = $beginDate;
			$MybeginTime = $beginTime;
			$MyendDate = $endDate;
			$MyendTime = $endTime;
		}

		$allowed = false;
		if ($MybeginDate < $currDate && $currDate < $MyendDate){
			$allowed = true;
		}
		else if ($MybeginDate == $currDate) {
			if ($MybeginTime <= $currTime) {
				$allowed = true;
			}
			else {
				$output["message"][] = "Can't take the quiz yet";	
			}
		}
		else if ($currDate == $MyendDate) {
			if ($MyendTime > $currTime) {
				$allowed = true;
			}
			else {
				$output["message"][] = "Too late to take the quiz";	
			}
		}
		else {
			if ($MybeginDate > $currDate) {
				$output["message"][] = "Can't take the quiz yet";	
			}
			else {
				$output["message"][] = "Too late to take the quiz";
			}	
		}


		if ($allowed) {

			$cursor = $db->quizSubmission->find(array(
				"studentID" => $MystudentID,
				"quizID" => $quizID
				));

			// How many have they taken?
			$taken = $cursor->count();




			// If taken more than once
			if ($taken > 0) {
				$cursor = $db->quizSubmission->find(array(
					"studentID" => $MystudentID,
					"quizID" => $quizID,
					"try" => $taken));

				foreach ($cursor as $document) {
					$finished = $document["finished"];
					$MystartTime = $document["startTime"];
					$MystartDate = $document["startDate"];
				}

				// LOAD OLD - didn't finish yet
				if (!$finished) {
					$code = array();
					$feedback = array();

					for ($i = 1; $i <= $size; $i++) {
						$cursor = $db->submission->find(array(
							"studentID" => $MystudentID,
							"quizID" => $quizID,
							"questionNumber" => $i
							));

						// Sort backwards
						$cursor->sort(array(
							"_id" => -1));

						$tempCode = "";
						$tempResult = "";

						// If code is found for the particular question
						if ($cursor->count() > 0) {
							foreach($cursor as $document) {
								if ($document["save"]) {
									$tempCode = $document["code"];
								}
								else {
									$tempCode = $document["code"];
									$tempResult = $document["result"];
								}
								continue;
							}
						}
						$code[] = $tempCode;
						$feedback[] = $tempResult;
					}

					$output["success"] = true;
					$output["message"][] = "Success";
					$output["continue"] = true;

					$output["numSubmission"] = $numSubmission; // list
					$output["question"] = $question; // list
					$output["quizName"] = $quizName;
					$output["timeAllowed"] = $timeAllowed * $MyextraTime;
					$output["retake"] = $retake; // number of retakes allowed
					if ($MyretakeAllowed) { // number of retakes left
						$output["retakeLeft"] = "unlimited";	
					}
					else {
						$output["retakeLeft"] = $retake - $taken;
					}
					$output["language"] = $language;
					$output["try"] = $taken; // how many times have they taken
					$output["currTime"] = $currTime; // current time of server
					$output["currDate"] = $currDate;
					$output["startTime"] = $MystartTime;
					$output["startDate"] = $MystartDate;


					// Additional Outputs
					$output["code"] = $code;
					$output["feedback"] = $feedback;

					$secondsAllowed = ($timeAllowed * $MyextraTime)*60;
					$dayDiff = 60 * 60 * 24 * (strtotime($currDate) - strtotime($MystartDate));
					$timeDiff = strtotime($currTime) - strtotime($MystartTime);

					$output["timeLeft"] = $secondsAllowed - ($dayDiff + $timeDiff);

					$cursor = $db->quizSubmission->find(array(
						"studentID" => $MystudentID,
						"quizID" => $quizID,
						"finished" => false
						));
					foreach ($cursor as $document) {
						$exitTime = $document["exitTime"];
					}
					$exitTime[] = $currTime;

					$newdata = array('$set' => array(
						"exitTime" => $exitTime
						));
					$db->quizSubmission->update(array(
						"studentID" => $MystudentID,
						"quizID" => $quizID,
						"finished" => false),
						$newdata);

					echo json_encode($output);
					exit;
				}
			}

			// Allowed to take new quiz
			// taken 0 -> 1
			// taken 1 < 2 -> 2 < 2
			if ($taken < $retake || $MyretakeAllowed) {

				$db->quizSubmission->insert(array(
					"studentID" => $MystudentID,
					"IPAddress" => $IPAddress,
					"quizID" => $quizID,
					"startDate" => $currDate,
					"startTime" => $currTime,
					"try" => $taken + 1,
					"finished" => false,
					"finishDate" => NULL,
					"finishTime" => NULL,
					"exitTime" => NULL
					));

				$output["success"] = true;
				$output["continue"] = false;
				$output["message"][] = "Success";


				$output["numSubmission"] = $numSubmission; // list
				$output["question"] = $question; // list
				$output["quizName"] = $quizName;

				$output["timeAllowed"] = $timeAllowed * $MyextraTime;

				$output["retake"] = $retake; // number of retakes allowed
				
				if ($MyretakeAllowed) { // number of retakes left
					$output["retakeLeft"] = "unlimited";	
				}
				else {
					$output["retakeLeft"] = $retake - $taken - 1;
				}

				$output["language"] = $language;
				$output["try"] = $taken + 1; // how many times have they taken

				// If needed
				$output["currTime"] = $currTime;
				$output["currDate"] = $currDate;
				$output["startTime"] = $currTime;
				$output["startDate"] = $currDate;
			}
			else {
				$output["success"] = false;
				$output["message"][] = "Exceeded number of quizzes you can take";
			}
		}
	}
	else {
		$output["success"] = false;
		$output["message"][] = "Did not find the quiz item";
	}


	echo json_encode($output);
	

?>