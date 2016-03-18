<?php

	if (!isset($_POST["quizID"])) {
		$object["success"] = false;
		$object["message"][] = "quizID not given";
		echo json_encode($object);
		exit;	
	}
	$quizID =  $_POST["quizID"];

	require "../Login/CheckLogin.php";

	$cursor = $db->quizSubmission->find(array(
			"studentID" => $MystudentID,
			"quizID" => $quizID,
			"finished" => false
			));

	if ($cursor->count() > 0) {

		$currDate = date("Y-m-d");
		$currTime = date("h:i");

		$newdata = array('$set' => array(
			"finished" => true,
			"finishDate" => $currDate,
			"finishTime" => $currTime
			));
		$db->quizSubmission->update(array(
				"studentID" => $MystudentID,
				"quizID" => $quizID,
				"finished" => false),
				$newdata);

		$object["success"] = true;
		$object["message"][] = "finished the quiz";

	}
	else {
		$object["success"] = false;
		$object["message"][] = "no test exists that is still active";
	}

	echo json_encode($object);

?>