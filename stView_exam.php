<?php
	session_start();
	date_default_timezone_set('Asia/Calcutta');

	$exam_id = $_GET['eid'];
	$stid = $_SESSION['stdid'];
	$conn = new mysqli("localhost", "root", "", "on_exams");
	if (mysqli_connect_error()) {
		die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
	}

	function attendencecheck(){
		global $conn,$exam_id,$stid;
		$myDate = date("Y-m-d",strtotime("now"));
		$query = "Select * from `st_attendence` where exam_id = '$exam_id' and 
		Studentid='$stid' and attendence_date='$myDate'";
		$resultset = mysqli_query($conn, $query);
		if(mysqli_num_rows($resultset) == 0){
			attendencemark();
		}
		else{
			attendenceupdate();
		}
	}
	function attendencemark(){
		global $conn,$exam_id,$stid;
		echo "aten mark";
		$myDate = date("Y-m-d",strtotime("now"));
		$myTime = date("H:i:s",strtotime("now"));
		$query = "Insert into st_attendence(exam_id,Studentid,attendence,
		attendence_date,attendence_time)
		values('$exam_id','$stid','Present','$myDate','$myTime');";
		$result1 = mysqli_query($conn, $query);
		if ($result1) {
		} else {
			header("Location: student.php?p=0");
		}
	}

	function attendenceupdate(){

		global $conn,$exam_id,$stid;
		$myDate = date("Y-m-d",strtotime("now"));
		$myTime = date("H:i:s",strtotime("now"));
		$query = "Update `st_attendence` Set `attendence`= 'Present',attendence_date='$myDate',
		attendence_time='$myTime' where exam_id='$exam_id' and Studentid='$stid';";
		$result1 = mysqli_query($conn, $query);
		if ($result1) {
		} else {
			header("Location: student.php?p=0");
		}
	}

	attendencecheck();

	$result = $conn->query("SELECT exam_duration,exam_datetime,total_question,marks_right_answer,marks_wrong_answer FROM exams WHERE exam_id = '$exam_id'");
	$totalquestion=0;
	while ($row = mysqli_fetch_array($result)) {
		$correctmarks = $row['marks_right_answer'];
		$wrongmarks = $row['marks_wrong_answer'];
		$exam_duration = $row['exam_duration'];
		$exam_datetime =  $row['exam_datetime'];
		$totalquestion = $row['total_question'] ;
	}

	$quiztest = array();
	$result1 = mysqli_query($conn, "SELECT questionno,question,option1,option2,option3,option4 FROM exam_questions WHERE exam_id = '$exam_id'");
	while ($row = mysqli_fetch_assoc($result1)) {
		$quiztest[] = $row;
	}

	$date = date("H:i:s",strtotime("$exam_datetime"));
	$datetime = new DateTime($date);
	$temptime = date("Y-m-d H:i:s",strtotime("{$date}+{$exam_duration} minute"));
	$temptime1 = new DateTime($temptime);
	$current = new DateTime("now");
	$re = $current->diff($temptime1);
	$h = $re->h;
	$m = $re->i;
	$s = $re->s;

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/viewexam.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script>


</head>

<body>
	<div class="home-box custom-box ">
		<h3>Instructions :</h3>
		<p>Total number of questions : <span class="total-question"></span></p>
		<button type="button" class="btn" onclick="startQuiz()">Start</button>
	</div>

	<div class="quiz-box custom-box hide">
		<div class="boxhead">
			<span class="timer-sec" id="timer"></span>
			<input type="hidden" name="hours">
			<input type="hidden" name="minute">
			<input type="hidden" name="second">
			<p id="demo"></p>
			<div class="question-number"></div>
		</div>
		<div class="question-text">
		</div>
		<div class="option-container">

		</div>
		<div class="ques-nav">
			<div class="prev-question-btn ">
				<button type="button" class="prevbtn btn" onclick="previous()">Previous</button>
			</div>
			<div class="next-question-btn">
				<button type="button" class="subbtn btn" onclick="submit()">Submit</button>
				<button type="button" class="nxtbtn btn" onclick="next()">Next</button>
			</div>
		</div>

		<div class="answers-indicator">
		</div>
	</div>
	<div class="result-box custom-box hide">
		<h1>Quiz Result</h1>
		<table>
			<tr>
				<td>Total Question</td>
				<td><span class="total-question"></span></td>
			</tr>
			<tr>
				<td>Attempt</td>
				<td><span class="total-attempt"></span></td>
			</tr>
			<tr>
				<td>Correct</td>
				<td><span class="total-correct"></span></td>
			</tr>
			<tr>
				<td>Wrong</td>
				<td><span class="total-wrong"></span></td>
			</tr>
			<tr>
				<td>Percentage</td>
				<td><span class="percentage"></span></td>
			</tr>
			<tr>
				<td>Your Total Score</td>
				<td><span class="total-score"></span></td>
			</tr>
		</table>
	</div>

	<!-- <script src="js/question.js"></script> -->
	<script src="js/app.js"></script>
	<script src="js/timer.js"></script>

	<script >
		
		var hrs = <?php echo $h ; ?>;
		var min = <?php echo $m ; ?>;
		var sec = <?php echo $s ; ?>;
		examTimer();

		var quiz = <?php echo json_encode($quiztest); ?>;
		var eid = <?php echo $exam_id; ?>;
		var stid = 	<?php echo $stid; ?>;
		var totalq = <?php echo $totalquestion; ?>;

		var d = new Date("<?php echo $exam_datetime ?>");
		var examtime = d.getFullYear()+"-0"+(d.getMonth()+1)+"-"+d.getDate()+ " " +d.getHours() + ":" + d.getMinutes()+":"+"00";
		
		function insertSelect(eid,stid,total){
			$.ajax({
				url: "viewExamServer.php",
				method: "POST",
				data: {
					'eid': eid,
					'stid':stid,
					'total':total,
					action: 'insertSelect'
				},
				success: function(data) {
					console.log(data);
				}
			})
		}

		function insertData(eid,stid,total,quesno,select){
			console.log(eid,stid,total,quesno,"  s  ",select);
			$.ajax({
				url: "viewExamServer.php",
				method: "POST",
				data: {
					'eid': eid,
					'stid':stid,
					'total':total,
					'quesno':quesno,
					'select':select,
					action: 'insertdata'
				},
				success: function(data) {
					console.log('adas',data);
				}
			})
		}
	</script>
</body>

</html>
