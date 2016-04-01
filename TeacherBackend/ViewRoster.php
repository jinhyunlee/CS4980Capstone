<?php

	require "Roster.php";

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