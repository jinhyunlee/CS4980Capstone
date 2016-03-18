<?php

	$tempstr = dirname(__FILE__);
	if (file_exists($tempstr . "/Instructors.txt")) {
		$instructors = file($tempstr . "/Instructors.txt");
		$instr = array();

		// Check if the id is instructor from instructors file
		foreach ($instructors as $instructor) {
		 	if ($id == $instructor) {
		 		$MyteacherID = $instructor;
		 		$MystudentID = $instructor;
		 		$isGrader = true;
		 		$isTeacher = true;
		 		$isStudent = true;
		 	}
		}
	}
	else {
		$object["success"] = false;
		$object["message"][] = "Instructors file not found";
		echo json_encode($object);
		exit;
	}
?>