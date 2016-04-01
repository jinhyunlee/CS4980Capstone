//save the current code and feedback
var startQuiz = 0;
var saveIntervalID;
var timerTime = 0;
var myInterval;

function saveText() {
	currentCode[qIndex] = editor.getValue();
	currentFeedback[qIndex] = document.getElementById("result").innerHTML;
}

//if coming back to test, retrieve code previously saved and display
function loadText() {
	if (currentCode[qIndex] != null) {
		editor.setValue(currentCode[qIndex], 1);
	} else {
		editor.setValue("", 1);
	}

	if (currentFeedback[qIndex] != null) {
		document.getElementById("result").innerHTML = currentFeedback[qIndex];
	} else {
		document.getElementById("result").innerHTML = "";
	}
}

//save code to server (done automatically)
function saveToServer(){
	/*$.ajax({
		type: "POST",
        url: "Save.php",
        data: {
        	code : currentCode, 
        },
        success: function(data){
     		console.log("Code Saved");
        }
	});*/
}

//when test is finished
function finishTest(element) {
	finished = 1;

	document.getElementById("bottom").style.display = "none";
	document.getElementById("problemNum").style.display = "none";
	document.getElementById("next").style.display = "none";
	document.getElementById("previous").style.display = "none";
	document.getElementById("description").innerHTML = "You are now finished. You may close the window."
	document.getElementById('countdown').style.display = "none";

	document.removeEventListener('webkitfullscreenchange', exitTest, false);
    document.removeEventListener('mozfullscreenchange', exitTest, false);
    document.removeEventListener('fullscreenchange', exitTest, false);
    document.removeEventListener('MSFullscreenChange', exitTest, false);

	document.webkitExitFullscreen();
	document.mozCancelFullscreen();
	document.exitFullscreen();
}

//exit test if quiz submitted
function exitTest() {
	saveText();
	if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
		pauseTest();

		$.ajax({
			type: "POST",
	        url: "SubmitQuiz.php",
	        data: {
	        	quizID : quizID, 
	        },
	        success: function(data){
	     		console.log("Code saved");
	        }
		});

		copied = 0;
	}
}

//pause test if alt-tabbed or exited fullscreen
function pauseTest() {
	document.getElementById("test").style.display = "none";
	document.getElementById("resumeTesting").style.display = "block";
	clearInterval(myInterval);
	clearInterval(saveIntervalID);
}

//resume test if returning
function resumeTest() {
	document.getElementById("test").style.display = "block";
	document.getElementById("resumeTesting").style.display = "none";
	loadText();
	saveIntervalID = setInterval(function() {
	    saveToServer();
	}, 10000);
}

//for the timer
function myTimer() {
	//TIMER FUNCTIONS
	var counterDate = new Date().getTime()
	var countdown = document.getElementById('countdown');
	var secondsLeft = timerTime - Math.round(counterDate/1000);

	var minutes = Math.floor(secondsLeft/60);
	var seconds = ((secondsLeft%60)).toFixed(0);
	
	if (seconds > 9) {	
		countdown.innerHTML = '' + minutes + ':' + seconds;
	} else {
		countdown.innerHTML = '' + minutes + ':0' + seconds;
	}
}

//for loading the buttons when question changes
function loadButtons() {
	//next and previous buttons
	if(qIndex <= 0){
		document.getElementById('previous').style.display = 'none';
	} else {
		document.getElementById('previous').style.display = 'inline-block';
	}
	//hide next button on last question
	if(qIndex == questions.length-1 || qIndex == -1){
		document.getElementById('next').style.display = 'none';
	} else {
		document.getElementById('next').style.display = 'inline-block';
	}
}

//retrieve the questions from the server
function getQuestions() {
	$.ajax({
        type: "POST",
        url: "GetQuestions.php",
        async: false,
        data: {quizID: quizID},
        dataType: "JSON",
        success: function(data){
        	//retrieve quiz from database in JSON format
        	//document.getElementById("quizName").innerHTML = data.quizName;
        	if (data.success) {
        		console.log(data);
        		document.getElementById("description").innerHTML = data.question[0];
	        	var i;
	        	for (i = 0; i < data.question.length; i++) {
	        		questions[i] = {description: data.question[i], numSubmissions: data.numSubmission[i], number: i+1};
	        		if (data.continue) {
	        			currentCode[i] = data.code[i];
	        			currentFeedback[i] = data.feedback[i];
	        		}
	        	}
	       		var date = new Date().getTime();
	        
	        	if (data.timeLeft != null) {
		        	timerTime =  Math.round(date/1000) + data.timeLeft;
			    } else {
			       	timerTime =  Math.round(date/1000) + data.timeAllowed;
			    }
	        	
	        	clearInterval(myInterval);
		       	myInterval = setInterval(myTimer, 1000);

		        var quizName = data.quizName;
		        	
	        	startQuiz = 1;
	        } else {
	        	console.log(data.message)
	        }
        }
	});
}

//force full screen
function requestFullScreen(element) {
	quizID = document.getElementById("quizIDInput").value;
	getQuestions();
	if (startQuiz == 1) {
	//if (getQuestions() == 1) {
		document.getElementById("problemNum").innerHTML = "Problem #" + questions[qIndex].number;
		document.getElementById("description").innerHTML = questions[qIndex].description;
	
		resumeTest();
		loadButtons();
		var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;
		if (requestMethod) {
			requestMethod.call(element);
			document.getElementById("fullscreen").style.display = "none";
			document.getElementById("quizIDDiv").style.display = "none";
			document.getElementById("countdown").style.display = "block";
			document.getElementById("bottom").style.display = "block";
			document.getElementById("problem").style.display = "block";

		} else if (typeof window.ActiveXObject !== "undefined") {
			var wscript  = new ActiveXObject("WScript.Shell");
			if (wscript != null) {
				wscript.SendKeys("{F11}");
			}
		}
		saveIntervalID = setInterval(function() {
		    saveToServer();
		}, 10000);
	}
	else {
		alert("Entered the wrong quiz ID ("+startQuiz+").");
	}
}