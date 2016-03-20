READ ME

TODO (Backend):
	1. Python - unique name and chmod, feedback filter (Michael)
	2. Klobbering (Both)
	3. Grading (Both)

Directory ===============================================================

	[Login]
		Checks login of students, TA, or instructor

		Files:
			1. CheckLogin.php
			2. CheckGrader.php
			3. CheckInstructor.php 
			4. Instructors.txt
			5. NetBadge.php
			6. Sessions.php

			Note: Instructors.txt has list of instructor IDs

	[Sample]
		Sample files to make it easier

		Files:
			1. Roster.txt 							*
			2. Quiz.txt 							*

	[TeacherBackend]
		Teacher's portal

		Files:
			1. CreateNote.php
			2. CreateQuiz.php
			3. CreateRoster.php
			4. EditNote.php
			5. EditQuiz.php
			6. EditRoster.php
			7. ViewNote.php
			8. ViewQuiz.php
			9. ViewRoster.php

	[TeacherFrontend]
		Teacher's page

		Files:
			1. Teacher.html


			Populate data
			Teacher.html is my own data

	[Student]
		Students' portal

		Files:
			1. Student.html
			2. GetQuestions.php
			3. Submit.php
			4. Save.php
			5. SubmitQuiz.php
			6. test.html
			7. test.js
			8. test.css
			9. [ace-builds]

			Student.html is my own tester.



<< BACK-BACKEND >>
NetBadge.php ==============================================================

	[Unknown]

	Provides identification

		id 				<string>
		IPAddress 		<string>


Sessions.php ==============================================================

	Provides global variables about sessions and sets up Mongo

		MyteacherID 		<string> 			*
		MystudentID 	<string>			*
		isTeacher 		<bool> 				//Instructor
		isStudent 		<bool> 				//Student
		isGrader 		<bool> 				//TA or Instructor

		db 				[MONGO]

	Also provides output for Front End for only Errors

		object

			success 	<bool>
			message 	<list-str>

	TODO?: Make sessions


CheckLoginGrader.php =========================================================

	Check if it is grader or a TA

	sets the session.php variables

	output for Front End for only errors

		object

			success 	<bool>
			message 	<list-str>


ViewQuiz.php =========================================================

	View Quiz information

	[Input]
		quizID 			<string> 

	[Output]
		success 		<bool>
		message 		<list-str>

		classID 		<string> 		// Class ID
		quizName 		<string> 		// Quiz Title
		timeAllowed 	<int> 			// Minutes allowed
		retake 			<int> 			// How many times can you retake

		language 		<string> 		// Programming Language of the quiz

		question 		<list-str>
		numSubmission 	<list-int> 		// Number of Submission allowed for Q
		answer 			<list-str> 		// Answer Code by Instructor to run

		sectionNumber 	<list-int> 		// Section Number
		beginTime 		<list-time>  	// When can you take the quiz
		beginDate 		<list-date> 	// " 			"
		lateTime 		<list-time> 	// When will it be considered late
		lateDate 		<list-date> 	// " 			"
		endTime 		<list-time> 	// When will it be closed permanantly
		endDate 		<list-date> 	// " 			"

	NOTE: Need to change style of database and language to list

ViewRoster.php =========================================================

	View Roster Information

	[Input]
		classID 		<string>

	[Output]
		success 		<bool>
		message 		<list-str>

		studentName 	<list-str>
		studentID 		<list-str>
		sectionNumber 	<list-int> 		
		extraTime 		<list-double> 	// Extra time multiplier
		email 			<list-str>
		ta 				<list-bool> 	// Is it a TA

ViewNote.php ==============================================================

	View Note Information

	[Input]
		quizID 			<string>

	[Output]
		success 		<bool>
		message 		<list-str>

		studentID 		<list-str>
		notes	 		<list-str> 		
		lateAllowed		<list-bool> 	// Alllowed to be overtime?
		exitAllowed		<list-bool> 	// Alllowed to exit?
		moreAllowed		<list-bool> 	// Alllowed to submit more?
		retakeAllowed	<list-bool> 	// Alllowed to be retake more?
		lateDateAllowed <list-bool> 	// Allowed to be late?

CreateQuiz.php ============================================================

	Create Quiz - Only Happy Case

	[Input]
		classID 		<string> 		// Class ID
		quizName 		<string> 		// Quiz Title
		timeAllowed 	<int> 			// Minutes allowed
		retake 			<int> 			// How many times can you retake

		language 		<string> 		// Programming Language of the quiz

		question 		<list-str>
		numSubmission 	<list-int> 		// Number of Submission allowed for Q
		answer 			<list-str> 		// Answer Code by Instructor to run

		sectionNumber 	<list-int> 		// Section Number
		beginTime 		<list-time>  	// When can you take the quiz
		beginDate 		<list-date> 	// " 			"
		lateTime 		<list-time> 	// When will it be considered late
		lateDate 		<list-date> 	// " 			"
		endTime 		<list-time> 	// When will it be closed permanantly
		endDate 		<list-date> 	// " 			"

	[Output]
		quizID 			<string> 
		success 		<bool>
		message 		<list-str>

CreateRoster.php ============================================================

	Create Roster - Happy Case

	[Input]
		classID 		<string>
		studentName 	<list-str>
		studentID 		<list-str>
		sectionNumber 	<list-int> 		
		extraTime 		<list-double> 	// Extra time multiplier
		email 			<list-str>
		ta 				<list-bool> 	// Is it a TA

	[Output]
		success 		<bool>
		message 		<list-str>

CreateNote.php ============================================================

	Create Note - Happy Case

	[Input]
		quizID 			<string>
		studentID 		<list-str>
		notes	 		<list-str> 		
		lateAllowed		<list-bool> 	// Alllowed to be overtime?
		exitAllowed		<list-bool> 	// Alllowed to exit?
		moreAllowed		<list-bool> 	// Alllowed to submit more?
		retakeAllowed	<list-bool> 	// Alllowed to be retake more?
		lateDateAllowed <list-bool> 	// Allowed to be late?

	[Output]
		success 		<bool>
		message 		<list-str>

		
EditQuiz.php ============================================================

	Edit Quiz - Only Happy Case

	[Input]
		quizID 			<string> 
		classID 		<string> 		// Class ID
		quizName 		<string> 		// Quiz Title
		timeAllowed 	<int> 			// Minutes allowed
		retake 			<int> 			// How many times can you retake

		language 		<string> 		// Programming Language of the quiz

		question 		<list-str>
		numSubmission 	<list-int> 		// Number of Submission allowed for Q
		answer 			<list-str> 		// Answer Code by Instructor to run

		sectionNumber 	<list-int> 		// Section Number
		beginTime 		<list-time>  	// When can you take the quiz
		beginDate 		<list-date> 	// " 			"
		lateTime 		<list-time> 	// When will it be considered late
		lateDate 		<list-date> 	// " 			"
		endTime 		<list-time> 	// When will it be closed permanantly
		endDate 		<list-date> 	// " 			"

	[Output]
		success 		<bool>
		message 		<list-str>


		NOTE: All edit must be ATOMIC

EditRoster.php ============================================================

	Edit Roster - Happy Case

	[Input]
		classID 		<string>
		studentName 	<list-str>
		studentID 		<list-str>
		sectionNumber 	<list-int> 		
		extraTime 		<list-double> 	// Extra time multiplier
		email 			<list-str>
		ta 				<list-bool> 	// Is it a TA

	[Output]
		success 		<bool>
		message 		<list-str>

EditNote.php ============================================================

	Edit Note - Happy Case

	[Input]
		quizID 			<string>
		studentID 		<list-str>
		notes	 		<list-str> 		
		lateAllowed		<list-bool> 	// Alllowed to be overtime?
		exitAllowed		<list-bool> 	// Alllowed to exit?
		moreAllowed		<list-bool> 	// Alllowed to submit more?
		retakeAllowed	<list-bool> 	// Alllowed to be retake more?
		lateDateAllowed <list-bool> 	// Allowed to be late?

	[Output]
		success 		<bool>
		message 		<list-str>


<< FRONT-BACKEND >>
GetQuestions.php =======================================================


<< DATABASE >>
Mongo DB ===================================================================

	use capstone
	db.collection_name.find({name: "whatever"})
	db.collection_name.remove({name: "whatever"})


	COLLECTIONS

	*note these are not organized in the most smartest way...*
	TODO Future: make it nested for list....

	[Information about the quiz]
	quizzes
		teacherID			<string>	teacher of the class
		quizID				<string>	quiz id, unique identifier autogen
		classID				<string>	class id, such as CS3330 (No space)
		quizName			<string> 	quiz title
		timeAllowed			<int>		time allowed (minutes) for whole quiz
		question 			<list-str>	list of questions (description)
		numSubmission		<list-int> 	number of submission allow for each q
		answer				<list-str> 	main.c file of the teachers
		language 			<string> 	language file (currently only C)
		retake 				<int> 		are they allowed for retake?
		beginTime	 		<list-time>	list/section when is the quiz allowed
		beginDate			<list-date>	"  "
		endTime			 	<list-time>	list/section when is the quiz over?
		endDate				<list-date>	"  "
		lateTime			<list-time>	list/section when will it be counted late
		lateDate 			<list-date>	"  "
		sectionNumber		<list-int>	list/section what section it is


	[Information about each submission / save]
	submission
		studentID			<string>	student such as jl4vw
		quizID				<string>	quiz id of a partiular quiz (selected)
		questionNumber 		<int>		which question the submission is for
		code 				<string>	the code
		graded				<bool>		is this for grade or for testing	
		result 				<str-json>	what the output was JSON
		submitDate 			<date>		when it was submitted
		submitTime 	 		<time>		"  "
		save 				<bool>		was this saved?
		


	[Information about each quiz submission]
	db.quizSubmission.find()
		IPAddress 		<string> 	ip address of the student 	[UNFINISHED]
		try					<int>		number of tries
		finished 			<bool>		is the student done?
		studentID 			<string>	student id
		quizID 				<string>	quiz id
		startDate 			<date>		when did the quiz begin
		startTime			<time>		"  "
		finishDate			<date>		when did the quiz end
		finishTime			<time>		"  "
		exitTime			<list-date>	list - did this person exit


	[Roster for class]
	roster
		teacherID			<string>	teacher of the class
		studentID 			<string>	a student
		classID				<string>	class id
		sectionNumber 		<int>		section number for that student
		extraTime			<double>	extra time multiplier
		email				<string>	email of the student
		studentName			<string>	student name
		ta 					<bool>		ta - is it the ta?			[FIX]


	[Additional Priv]
	allowed
		studentID			<string>	student ID
		note				<string>	any notes by TA / Prof
		lateAllowed 		<bool>		are they excused to be late by TA
		exitAllowed 		<bool> 		are they excused to exit by TA
		moreAllowed			<bool>		more submission allowed
		quizID				<string> 	quizID
		lateDateAllowed		<bool>		late date allowed
		retakeAllowed 		<bool>		additional take allowed








































































































































































Quizzes.php [UNFINISHED - Additional Feature] ================================================================

	SESSION:
		<string> 	MystudentID / TeacherID

	OUTPUT:
		[JSON OBJECT] 
			<list> 		quizName
			<list>		quizID
			<list> 		timeAllowed
			<list> 		beginTime
			<list> 		beginDate
			<list> 		endTime
			<list>		endDate
			<list>		retake	
			<bool> 		success; see if it is successful or not
    		<string> 	message; message about it's return to see what went wrong



GetQuestions.php ===========================================================

	SESSION:
		<string> 	studentID
		<int>		MysectionNumber
		<double>	extraTime
		<string>	MyIPAddress

	INPUT:
		<string> 	quizID

	OUTPUT:
		[JSON OBJECT] quiz
    		<list> 		question
			<list> 		numSubmission
			<int> 		timeAllowed
			<string> 	quizName
			<time> 		currTime
			<date>		currDate
			<string>	language
			<int>		try				// number of times they have taken

			<time> 		startTime
			<date> 		startDate
			<list> 		code
			<list> 		feedback
			<bool>		continue;		is this a continue or a new quiz?
			<int> 		timeLeft 			// seconds

    		<bool> 		success; see if it is successful or not
    		<string> 	message; message about it's return to see what went wrong

	SUMMARY:
		given quizID, returns the questions and details. 				
			Checks if student is logged in							
			Checks if student can take the quiz / again. 			
			Checks if student started it before 						
			Save into quizSubmission mongo 								



Submit.php ===============================================================

	SESSION:
		<string> 	MystudentID
		<string> 	MyclassID
		<int>		MysectionNumber
		<double>	MyextraTime
		<string>	MyIPAddress
	
	INPUT: 
		<string> 	quizID
		<int> 		questionNumber
		<string>	submission
		<bool>		grade 				// is this for grade or not

	OUTPUT:
		[JSON OBJECT] output
			<bool> 		success; see if it is successful or not
    		<string> 	message; message about it's return to see what went wrong
			<JSON>  result
			 	<string>  compilationMessages
			 	<string>  stdoutMessages
			 	<string>  stderrMessages
			 	<double>  grade

	SUMMARY:
		given quizID and the questionNumber and compile and run 	
		  	Save to database                                      	

SubmitQuiz.php ==========================================================

	SESSION:
		<string> 	MystudentID
		<string> 	MyclassID
		<int>		MysectionNumber
		<double>	MyextraTime
		<string>	MyIPAddress


	INPUT:
		<string> 	quizID


	OUTPUT:
		"success"

	SUMMARY:
		closing the quiz


SaveQuiz.php =============================================================

	SESSION:
		<string> 	MystudentID
		<string>	MyclassID

	INPUT:
		<string> 	quizID
		<list> 		code

	OUTPUT:
	[JSON OBJECT] output
		<bool> 		success
		<string>	message




CreateQuiz.php ==========================================================

	SESSION:
		<string> 	teacherID

	INPUT:
		<string> 	classID
		<string>	quizName
		<int>	 	timeAllowed
		<list>		numSubmission
		<list>		question
		<list>		answer
		<int>		retake
		<string>	language
		<list>		beginTime			- list of HTML5 time format
		<list>		beginDate			- list of HTML5 date format
		<list>		endTime
		<list>		endDate
		<list> 		lateTime
		<list>		lateDate
		<list>		sectionNumber		- list of section number (first item here corresponds to first item in time/date)

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message
		    <string> 	quizID

  	SUMMARY:
    	makes the quiz                                        


CreateRoster.php ==========================================================

	SESSION:
		<string> 	teacherID


	INPUT:
		<string> 	classID
		<list> 		sectionNumber
		<list>		studentID
		<list>		extraTime
		<list>		studentName
		<list>		email
		<list>		ta 					- boolean if the student is TA or not

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message

	SUMMARY:
		using txt file or whatever, add people to roster
		able to add manually


EditRoster.php ==========================================================

	SESSION:
		<string> 	teacherID


	INPUT:
		<string> 	classID
		<list> 		sectionNumber
		<list>		studentID
		<list>		extraTime
		<list>		studentName
		<list>		email
		<list>		ta

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message

	SUMMARY:
		using txt file or whatever, edit people to roster
		able to add manually


ViewRoster.php ==========================================================

	SESSION:
		<string> 	teacherID


	INPUT:
		<string> 	classID

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message
		    <list> 		sectionNumber
			<list>		studentID
			<list>		extraTime
			<list>		studentName
			<list>		email
			<list>		ta

	SUMMARY:
		View roster


ViewQuiz.php ==========================================================

	SESSION:
		<string> 	teacherID 		/ 	TA


	OUTPUT:
		<string> 	classID
		<string>	quizName
		<int>	 	timeAllowed
		<list>		numSubmission
		<list>		question
		<list>		answer
		<int>		retake
		<string>	language
		<list>		beginTime
		<list>		beginDate
		<list>		endTime
		<list>		endDate
		<list>		sectionNumber

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message

  	SUMMARY:
    	see the quiz without taking it

EditQuiz.php ==========================================================

	SESSION:
		<string> 	teacherID

	INPUT:
		<string> 	classID
		<string>	quizName
		<int>	 	timeAllowed
		<list>		numSubmission
		<list>		question
		<list>		answer
		<int>		retake
		<string>	language
		<list>		beginTime
		<list>		beginDate
		<list>		endTime
		<list>		endDate
		<list>		sectionNumber

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message

  	SUMMARY:
    	edit the quiz  

CreateNote.php ========================================================

	SESSION:
		<string> 	teacherID

	INPUT:
		<string>	quizID
		<list> 		studentID
		<list>		notes
		<list> 		lateAllowed 		
		<list> 		exitAllowed 
		<list>		moreAllowed

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message

EditNote.php ========================================================

	SESSION:
		<string> 	teacherID

	INPUT:
		<string>	quizID
		<list> 		studentID
		<list>		notes
		<list> 		lateAllowed 		
		<list> 		exitAllowed 
		<list>		moreAllowed

	OUTPUT:
		[JSON OBJECT] output
		    <bool> 		success
		    <string>	message

 ViewNote.php ============================================================

	SESSION:
		<string> 	teacherID

	INPUT:
		<string> 	quizID

	OUTPUT:
	[JSON OBJECT] output
		<bool> 		success
		<string>	message
		<list> 		studentID
		<list>		notes
		<list> 		lateAllowed 		
		<list> 		exitAllowed 
		<list>		moreAllowed	
		<list>		lateDateAllowed
		<list> 		retakeAllowed






PYTHON FILE ==========================================================

NOTE: My PHP file will create the student files and delete after python call.
		It will read the generated file and delete at end (make sure i have permission)
INPUT: 
	studentFile = file_of_the_student_uniquely_defined.c (it could be .cpp, or whatever)
	gradeFile = file_of_the_main.c 
	languge = such as "C"

EXEC: 
	$str = "python os-system-calls.py " . $studentFile . " " . $gradeFile . " " $language;

OUTPUT:
	outputFile = file_of_the_student_uniquely_defined.txt (same as input but diff extension)
		this will be JSON


