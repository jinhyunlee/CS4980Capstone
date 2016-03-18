<?php

	require "../Login/CheckLoginInstructor.php";

	$studentName = array();
	$studentID = array();
	$sectionNumber = array();
	$extraTime = array();
	$email = array();
	$ta = array();

	$classID = $_POST["classID"];
	$studentName = $_POST["studentName"];
	$studentID = $_POST["studentID"];	
	$sectionNumber = $_POST["sectionNumber"];
	$extraTime = $_POST["extraTime"];
	$email = $_POST["email"];
	$ta = $_POST["ta"];

	$cursor = $db->roster->find(array(
		"classID" => $classID
		));

	if ($cursor->count() > 0) {
		$db->roster->remove(array(
			"classID" => $classID
			));

		for ($i = 0; $i < count($studentID); $i++) {
			$db->roster->insert(array(
				"classID" => $classID,
				"studentID" => $studentID[$i],
				"studentName" => $studentName[$i],
				"sectionNumber" => $sectionNumber[$i],
				"extraTime" => $extraTime[$i],
				"email" => $email[$i],
				"ta" => $ta[$i]
				));
		}

		$object["success"] = true;
		$object["message"][] = "created";
	}
	else {
		$object["success"] = false;
		$object["message"][] = "roster doest not exist for that class";
	}

	echo json_encode($object);
?>