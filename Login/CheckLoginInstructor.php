<?php

	require "NetBadge.php";
	require "Sessions.php";

	require "CheckInstructor.php";

	if ($isTeacher) {
		$object["success"] = true;
		$object["message"][] = "This is the teacher";
	}
	else {
		$object["success"] = false;
		$object["message"][] = "id not an instructor";

		echo json_encode($object);
		exit;
	}

?>