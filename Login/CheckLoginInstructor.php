<?php

	//$id = "a"; // STUDENT
	//$id = "c"; // TA
	$id = "0"; // PROFESSOR

	if ($id == "0") {
		$teacherID = "0";
	}
	else {

		$object["success"] = false;
		$object["message"] = "id not an instructor";

		echo json_encode($object);
		exit;
	}



?>