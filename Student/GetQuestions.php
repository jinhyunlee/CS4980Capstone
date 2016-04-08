<?php

	// Get the quiz ID
	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	// Check the login
	require "../Login/Login.php";
	checkRoster($quizID);


	// Set up the variables
	$numSubmission = array();
	$beginDate = array();
	$beginTime = array();
	$endDate = array();
	$endTime = array();
	$sectionNumber = array();
	$lateDate = array();
	$lateTime = array();
	$question = array();


	// Get the quiz information
	$cursor = $db->quizzes->find(array(
		"quizID" => $quizID
		));

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
			continue;
		}

		$size = count($question);

		// Current date
		$currDate = date("Y-m-d");
		$currTime = date("h:i:s");

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


		$cursor = $db->allowed->find(array(
			"quizID" => $quizID,
			"studentID" => $MystudentID
			));

		if ($cursor->count() > 0) {
			$MyearlyAccessAllowed = $document["earlyAccessAllowed"];
			$MylateAccessAllowed = $document["lateAccessAllowed"];
		}
		// Allowed to take?
		$allowed = false;
		if ($MybeginDate < $currDate && $currDate < $MyendDate){
			$allowed = true;
		}
		else if ($MybeginDate == $currDate) {
			if ($MybeginTime <= $currTime) {
				$allowed = true;
			}
			else {
				if ($MyearlyAccessAllowed) {
					$allowed = true;
				}	
				else {
					$object["message"][] = "Can't take the quiz yet";
				}
			}
		}
		else if ($currDate == $MyendDate) {
			if ($MyendTime > $currTime) {
				$allowed = true;
			}
			else {
				if ($MylateAccessAllowed) {
					$allowed = true;
				}	
				else {
					$object["message"][] = "Too late to take the quiz";	
				}
			}
		}
		else {
			if ($MybeginDate > $currDate) {
				if ($MyearlyAccessAllowed) {
					$allowed = true;
				}	
				else {
					$object["message"][] = "Can't take the quiz yet";
				}	
			}
			else {
				if ($MylateAccessAllowed) {
					$allowed = true;
				}	
				else {
					$object["message"][] = "Too late to take the quiz";	
				};
			}	
		}

		// If allowed to take
		if ($allowed) {
			$object["message"][] = "You may take the quiz";

			$cursor = $db->quizSubmission->find(array(
				"studentID" => $MystudentID,
				"quizID" => $quizID
				));

			// How many have they taken? 
			$taken = $cursor->count(); // if it is first time
			$object["message"][] = "Taken: " . $taken;

			// If taken more than once
			if ($taken > 0) {
				$object["message"][] = "You have taken it before";
				$cursor = $db->quizSubmission->find(array(
					"studentID" => $MystudentID,
					"quizID" => $quizID,
					"try" => $taken));

				foreach ($cursor as $document) {
					$finished = $document["finished"];
					$MystartTime = $document["startTime"];
					$MystartDate = $document["startDate"];
					continue;
				}

				// LOAD OLD - didn't finish yet
				if (!$finished) {
					$object["message"][] = "Have not finished the quiz";
					$code = array();
					$feedback = array();
					$numSubmitted = array();

					for ($i = 1; $i <= $size; $i++) {
						$numSubmitted[$i-1] = 0;
						$cursor = $db->submission->find(array(
							"studentID" => $MystudentID,
							"quizID" => $quizID,
							"questionNumber" => $i,
							"try" => $taken
							));

						$tempCode = "";
						$tempResult = "";

						// If code is found for the particular question
						if ($cursor->count() > 0) {
							$object["message"][] = "Count: " . $cursor->count();
							foreach($cursor as $document) {
								if ($document["save"]) {
									$tempCode = $document["code"];
								}
								else {
									$tempCode = $document["code"];
									$tempResult = $document["result"];
									$numSubmitted[$i-1] = $numSubmitted[$i-1] + 1;
								}
							}
						}
						$code[] = $tempCode;
						$feedback[] = $tempResult;
						$object["message"][] = "Temp code: " . $tempCode;
						$object["message"][] = "Temp feedback: " . $tempResult;

					}


					$object["success"] = true;
					$object["message"][] = "Success";
					$object["continue"] = true;

					$object["numSubmission"] = $numSubmission; // list
					$object["question"] = $question; // list
					$object["quizName"] = $quizName;
					$object["timeAllowed"] = $timeAllowed * $MyextraTime;
					$object["retake"] = $retake; // number of retakes allowed
					if ($MyretakeAllowed) { // number of retakes left
						$object["retakeLeft"] = "unlimited";	
					}
					else {
						$object["retakeLeft"] = $retake - $taken;
					}
					$object["language"] = $language;
					$object["try"] = $taken; // how many times have they taken
					$object["currTime"] = $currTime; // current time of server
					$object["currDate"] = $currDate;
					$object["startTime"] = $MystartTime;
					$object["startDate"] = $MystartDate;


					// Additional Outputs
					$object["code"] = $code;
					$object["feedback"] = $feedback;
					$object["numSubmitted"] = $numSubmitted;

					$secondsAllowed = ($timeAllowed * $MyextraTime);
					$dayDiff = 60 * 60 * 24 * (strtotime($currDate) - strtotime($MystartDate));
					$object["message"][] = "day diff: " . $dayDiff;
					$timeDiff = strtotime($currTime) - strtotime($MystartTime);
					$object["message"][] = "time diff: " . $timeDiff;
					$object["timeLeft"] = $secondsAllowed - ($dayDiff + $timeDiff);

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

					echo json_encode($object);
					exit;
				}
			}

			// Allowed to take new quiz
			// taken 0 -> 1
			// taken 1 < 2 -> 2 < 2
			if ($taken < $retake || $MyretakeAllowed) {
				$object["message"][] = "You may take the NEW quiz";

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

				$object["success"] = true;
				$object["continue"] = false;
				$object["message"][] = "Success";


				$object["numSubmission"] = $numSubmission; // list
				$object["question"] = $question; // list
				$object["quizName"] = $quizName;

				$object["timeAllowed"] = $timeAllowed * $MyextraTime;

				$object["retake"] = $retake; // number of retakes allowed
				
				if ($MyretakeAllowed) { // number of retakes left
					$object["retakeLeft"] = "unlimited";	
				}
				else {
					$object["retakeLeft"] = $retake - $taken - 1;
				}

				$object["language"] = $language;
				$object["try"] = $taken + 1; // how many times have they taken

				// If needed
				$object["currTime"] = $currTime;
				$object["currDate"] = $currDate;
				$object["startTime"] = $currTime;
				$object["startDate"] = $currDate;
			}
			else {
				$object["success"] = false;
				$object["message"][] = "Exceeded number of quizzes you can take";
			}
		}
	}
	else {
		$object["success"] = false;
		$object["message"][] = "Did not find the quiz item";
	}


	echo json_encode($object);
	

?>