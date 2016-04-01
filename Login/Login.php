<?php


	// Required for Log in
	require "NetBadge.php";
	require "Sessions.php";

	// Checks if this is the instructor and sets the session variable
	function checkTeacher() {

		// Checks the instructor file
		$tempstr = dirname(__FILE__);
		if (file_exists($tempstr . "/Instructors.txt")) {
			$instructors = file($tempstr . "/Instructors.txt");
			$instr = array();

			// Check if the id is instructor from instructors file
			foreach ($instructors as $instructor) {
			 	if ($GLOBALS['id'] == $instructor) {
			 		$GLOBALS['MyteacherID'] = $instructor;
			 		$GLOBALS['isGrader'] = true;
			 		$GLOBALS['isTeacher'] = true;
			 		$GLOBALS['isStudent'] = true;
			 		$GLOBALS['Myta'] = true;
			 		$GLOBALS['MystudentID'] = $instructor;
			 		$GLOBALS['MystudentName'] = $instructor; // TODO: Change
			 		$GLOBALS['MysectionNumber'] = 0; // 0 bypasses
			 		$GLOBALS['MyextraTime'] = 1;
			 		$GLOBALS['Myemail'] = $instructor;  // TODO: Change
			 		$GLOBALS['MyretakeAllowed'] = true;
			 		$GLOBALS['object']["success"] = true;
					$GLOBALS['object']["message"][] = "Instructor file found.";
			 	}
			}
		}
		else {
			$GLOBALS['object']["success"] = false;
			$GLOBALS['object']["message"][] = "Instructors file not found.";
			echo json_encode($GLOBALS['object']);
			exit;
		}
	}

	// Error message that it is not the instructor
	function isTeacher() {
		checkTeacher();

		if ($GLOBALS['isTeacher']) {
			$GLOBALS['object']["success"] = true;
			$GLOBALS['object']["message"][] = "This is the teacher.";
			return true;
		}
		else {
			$GLOBALS['object']["success"] = false;
			$GLOBALS['object']["message"][] = "id not an instructor.";

			echo json_encode($GLOBALS['object']);
			exit;
		}
	}

	// Checks if the roster
	function checkRoster($classID) {
		checkTeacher();

		if (!$GLOBALS['isTeacher']) {
			$cursor = $GLOBALS['db']->roster->find(array(
				"studentID" => $GLOBALS['id'],
				"classID" => $GLOBALS['classID']
				));

			if ($cursor->count() > 0) {
				$GLOBALS['object']["success"] = true;
				$GLOBALS['object']["message"][] = "id found in roster";

				// Get the TA value
				foreach ($cursor as $document) {
					$GLOBALS['Myta'] = $document["ta"];
					$GLOBALS['MystudentID'] = $document["studentID"];
					$GLOBALS['MystudentName'] = $document["studentName"];
					$GLOBALS['MysectionNumber'] = $document["sectionNumber"];
					$GLOBALS['MyextraTime'] = $document["extraTime"];
					$GLOBALS['Myemail'] = $document["email"];
					$GLOBALS['isStudent'] = true;
					continue;
				}
				if ($GLOBALS['Myta']) {
					$GLOBALS['isGrader'] = true;
					$GLOBALS['MysectionNumber'] = 0; // Bypasses
				}
			}
			else {
				$GLOBALS['object']["success"] = false;
				$GLOBALS['object']["message"][] = "id not found in roster";
				echo json_encode($GLOBALS['object']);
				exit;
			}
		}
	}

	function getClassID($quizID) {
		$cursor = $GLOBALS['db']->quizzes->find(array(
			"quizID" => $quizID
			));

		if ($cursor->count() > 0) {
			$GLOBALS['object']["message"][] = "Quiz ID found";
			// Find the class ID
			foreach ($cursor as $document) {
				$GLOBALS['object']["success"] = true;
				$GLOBALS['object']["message"][] = "Class ID found";
				$GLOBALS['classID'] = $document["classID"];
				return $GLOBALS['classID'];
			}
		}
		else {
			$GLOBALS['object']["success"] = false;
			$GLOBALS['object']["message"][] = "Quiz not found";
			echo json_encode($GLOBALS['object']);
			exit;
		}
	}
	// Error messsage if it is not grader
	function isGrader($classID) {

		checkRoster($classID);

		if ($GLOBALS['Myta']) {
			$GLOBALS['object']["success"] = true;
			$GLOBALS['object']["message"][] = "this is Grader";
			return true;
		}
		else {
			$GLOBALS['object']["success"] = false;
			$GLOBALS['object']["message"][] = "id is not Grader";
			echo json_encode($GLOBALS['object']);
			exit;
		}
	}

	// To test into the message
	function printLoginInfo() {

		// Logged in successfully
		if ($GLOBALS['isStudent']) {
			$GLOBALS['object']["message"][] = "Instructor: " . $isTeacher;
			$GLOBALS['object']["message"][] = "Grader: " . $isGrader;
			$GLOBALS['object']["message"][] = "ID: " . $MystudentID;
			$GLOBALS['object']["message"][] = "Name: " . $MystudentName;
			$GLOBALS['object']["message"][] = "Number: " . $MysectionNumber;
			$GLOBALS['object']["message"][] = "Email: " . $Myemail;
			$GLOBALS['object']["message"][] = "Extratime: " . $MyextraTime;
		}

	}

?>