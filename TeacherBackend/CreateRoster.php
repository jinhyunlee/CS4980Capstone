<?php

	require "Roster.php";
	checkRosterPostData();
	insertRoster();
	echo json_encode($object);
?>