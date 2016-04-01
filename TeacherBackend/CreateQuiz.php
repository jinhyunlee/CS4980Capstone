<?php

	require "Quiz.php";
	checkQuizPostData();


	if (!isset($_POST["quizID"])) {
		$cursor = $db->quizzes->find(array(
			"classID" => $classID
			));
	
		// Create Quiz ID - MAY NOT DELETE ANY QUIZZES
		$quizID = $classID . $cursor->count();
	}

	insertQuiz();
	gradeFile();

	$object["quizID"] = $quizID;
	echo json_encode($object);

	

?>