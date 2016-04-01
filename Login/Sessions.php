<?php


	// Session variables that will be used throught the log in.

	// Type of user
	$MyteacherID = "";
	$MystudentID = "";
	$isTeacher = false;
	$isGrader = false;
	$isStudent = false;

	// What will be returned to Front End
	$object = array();
	$object["success"] = false;
	$object["message"] = array();


	// Mongo Client is initialized here.
	$mongo = new MongoClient(); 
	$db = $mongo->selectDB("capstone");


	// Privileges - all off currently
	$Myta = false;
	$MystudentID = "";
	$MystudentName = "";
	$MysectionNumber = -1;
	$MyextraTime = 0;
	$Myemail = "";
	$MyretakeAllowed = false;


?>