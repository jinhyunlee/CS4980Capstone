<?php

	// Check Login
	require "../Login/CheckLoginGrader.php";

	// Array Set up
	$studentName = array();
	$studentID = array();
	$sectionNumber = array();
	$extraTime = array();
	$email = array();
	$ta = array();

	// Check the POST data
	if (!isset($_POST["classID"])) {
		$object["success"] = false;
		$object["message"][] = "classID not given";
		echo json_encode($object);
		exit;
	}
	$classID = $_POST["classID"];

	// Find the roster
	$cursor = $db->roster->find(array(
		"classID" => $classID
		));

	if ($cursor->count() > 0) {
		$object["success"] = true;
		$object["message"][] = "found the class";

		foreach ($cursor as $document) {
			$studentName[] = $document["studentName"];
			$studentID[] = $document["studentID"];	
			$sectionNumber[] = $document["sectionNumber"];
			$extraTime[] = $document["extraTime"];
			$email[] = $document["email"];
			$ta[] = $document["ta"];
		}

		$object["studentName"] = $studentName;
		$object["studentID"] = $studentID;
		$object["sectionNumber"] = $sectionNumber;
		$object["extraTime"] = $extraTime;
		$object["email"] = $email;
		$object["ta"] = $ta;

	}
	else {
		$object["success"] = false;
		$object["message"][] = "Did not find the roster";
	}
	echo json_encode($object);
?>