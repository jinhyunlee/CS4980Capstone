<?php

	$MyteacherID = "";
	$MystudentID = "";
	$isTeacher = false;
	$isGrader = false;
	$isStudent = false;

	$object = array();
	$object["success"] = false;
	$object["message"] = array();

	$mongo = new MongoClient(); 
	$db = $mongo->selectDB("capstone");


	$Myta = false;
	$MystudentID = "";
	$MystudentName = "";
	$MysectionNumber = -1;
	$MyextraTime = 0;
	$Myemail = "";
	$MyretakeAllowed = false;


?>