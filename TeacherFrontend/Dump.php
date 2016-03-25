<?php

	// Check Login
	require "../Login/NetBadge.php";
	require "../Login/Sessions.php";

	require "../Login/CheckInstructor.php";
	
	
    echo '<p>roster:</p>';
    $cursor = $db->roster->find();
    foreach($cursor as $document) {
        echo '<pre>'; var_dump($document); echo '</pre>';
    }

    echo '<p>allowed:</p>';
    $cursor = $db->allowed->find();
    foreach($cursor as $document) {
        echo '<pre>'; var_dump($document); echo '</pre>';
    }

    echo '<p>quizzes:</p>';
    $cursor = $db->quizzes->find();
    foreach($cursor as $document) {
        echo '<pre>'; var_dump($document); echo '</pre>';
    }
?>