<?php

	require "Note.php";

	checkNotePostData();
	insertNote();
	
	echo json_encode($object);

?>