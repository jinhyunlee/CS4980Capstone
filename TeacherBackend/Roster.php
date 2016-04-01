<?php

	require "../Login/Login.php";

	// Check if quiz id is given
	if (!isset($_POST["classID"])) {
		$object["success"] = false;
		$object["message"][] = "classID not given";
		echo json_encode($object);
		exit;	
	}
	$classID =  $_POST["classID"];
	isTeacher();

	$studentName = array();
	$studentID = array();
	$sectionNumber = array();
	$extraTime = array();
	$email = array();
	$ta = array();

	function checkRosterPostData() {

		// Check if the post data are sent
		if (!isset($_POST["studentID"]) || 
			!isset($_POST["studentName"]) || 
			!isset($_POST["sectionNumber"]) ||
			!isset($_POST["extraTime"]) ||
			!isset($_POST["email"]) ||
			!isset($_POST["ta"])) {

			$GLOBALS['object']["success"] = false;
			$GLOBALS['object']["message"][] = "POST Data were not set";
			echo json_encode($object);
			exit;	
		}

		$GLOBALS['studentName'] = $_POST["studentName"];
		$GLOBALS['studentID'] = $_POST["studentID"];	
		$GLOBALS['sectionNumber'] = $_POST["sectionNumber"];
		$GLOBALS['extraTime'] = $_POST["extraTime"];
		$GLOBALS['email'] = $_POST["email"];
		$GLOBALS['ta'] = $_POST["ta"];

		// TODO: Check for array length
	}

	function insertRoster() {
		$cursor = $GLOBALS['db']->roster->find(array(
		"classID" => $GLOBALS['classID']
		));

		if ($cursor->count() > 0) {
			$GLOBALS['db']->roster->remove(array(
				"classID" => $GLOBALS['classID']
				));

			$GLOBALS['object']["message"][] = "removed First";
		}

		for ($i = 0; $i < count($GLOBALS['studentID']); $i++) {
			$GLOBALS['db']->roster->insert(array(
				"classID" => $GLOBALS['classID'],
				"studentID" => $GLOBALS['studentID'][$i],
				"studentName" => $GLOBALS['studentName'][$i],
				"sectionNumber" => $GLOBALS['sectionNumber'][$i],
				"extraTime" => $GLOBALS['extraTime'][$i],
				"email" => $GLOBALS['email'][$i],
				"ta" => filter_var($GLOBALS['ta'][$i], FILTER_VALIDATE_BOOLEAN)
				));
		}
		$GLOBALS['object']["success"] = true;
		$GLOBALS['object']["message"][] = "created";
	}

?>