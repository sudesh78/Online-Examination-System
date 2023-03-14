<?php
    session_start();
	date_default_timezone_set('Asia/Calcutta');

    $conn = new mysqli("localhost", "root", "", "on_exams");
    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    }
	
    $course_id=!empty($_POST['course_id'])?$_POST['course_id']:'';
	$deptid=!empty($_POST['deptid'])?$_POST['deptid']:'';
    if(!empty($course_id))
    {
    $result=$conn->query("SELECT dept_id, dept_name from department WHERE course_id='$course_id'");
            
    if($result->num_rows>0)
    {
        echo "<option value=''>Select Department</option>";
        while($arr= $result->fetch_assoc())
        {
			if($deptid == $arr['dept_id']){
				echo "<option value='".$arr['dept_id']."' selected='yes'>".$arr['dept_name']."</option><br>";
			}
			else{
				echo "<option value='".$arr['dept_id']."' >".$arr['dept_name']."</option><br>";
			}
        }
    }  
    } 

    $dept_id=!empty($_POST['dept_id'])?$_POST['dept_id']:'';
    if(!empty($dept_id))
    {
    $result1=$conn->query("SELECT * from subjects WHERE dept_id='$dept_id'");
            
    if($result1->num_rows>0)
    {
        echo "<option value=''>Select Code</option>";
        while($arr= $result1->fetch_assoc())
        {
            echo "<option value='".$arr['sub_id']."'>".$arr['sub_code']."</option><br>";
            
        }
    }  
    }

    $subcode=!empty($_POST['subcode'])?$_POST['subcode']:'';
    if(!empty($subcode))
    {
    $result=$conn->query("SELECT * from subjects WHERE sub_id='$subcode'");
            
    if($result->num_rows>0)
    {
        while($arr= $result->fetch_assoc())
        {
            echo $arr['sub_name'];
            
        }
    }  
    }

    if(isset($_POST['save']))
    {
        $coursename = $_POST['coursename'];
        $deptname = $_POST['dept_name'];
        $semno = $_POST['sem_no'];
        $subcode= $_POST['sub_code'];
        $subname= $_POST['sub_name'];
        $examdatetime = $_POST['exam_datetime'];
        $duration = $_POST['exam_duration'];
        $tquestion = $_POST['total_question'];
        $right = $_POST['marks_right_answer'];
        $wrong = $_POST['marks_wrong_answer'];

        $datetime = $examdatetime;


        $query = "Insert into exams(exam_title,exam_code,course,sem,dept,exam_datetime,exam_duration,total_question,marks_right_answer,marks_wrong_answer,status) 
        values('$subname','$subcode','$coursename','$semno',
        '$deptname','$datetime', $duration,'$tquestion','$right','$wrong','Created')";
        $query_run = mysqli_query($conn,$query);
        if($query_run)
        {	
            $_SESSION['status'] = "Updated Successfully";
			header("Location: admin.php?p=2");
        
        }
        else{
            $_SESSION['status'] = "Error in Backend";
			header("Location: admin.php?p=4");
        }


	}
	if(isset($_POST['delete_exam'])){
		$del_id = $_POST['del_id'];
        $query = "Delete from exams where exam_id='$del_id' and status='Created'";
        $query_run = mysqli_query($conn,$query);
        if($query_run)
        {	
			if(mysqli_affected_rows($conn) == 0){
				$_SESSION['status'] = "Unable to Delete Started/Completed Exam";
				header("Location: admin.php?p=2");
			}else{
				$_SESSION['status'] = "Deleted Successfully";
				header("Location: admin.php?p=2");
			}
            
        }
        else{
            $_SESSION['status'] = "Unable to Delete Exam";
            header("Location: admin.php?p=2");
        }
	}

	function attendencefill($eid){
		global $conn;
		$result = $conn->query("Select exams.course,exams.sem,exams.dept,students.studentid,exams.exam_id from exams,students where
		exams.course = students.course and exams.sem = students.sem and exams.dept = students.dept_id 
		and exams.exam_id=$eid");
		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){
				$stdid = $row['studentid'];
				$myDate = date("Y-m-d",strtotime("now"));
				$myTime = date("H:i:s",strtotime("now"));
				$result1 = $conn->query("Insert into st_attendence(exam_id,Studentid,attendence,
				attendence_date,attendence_time)
				values('$eid','$stdid','Absent','$myDate','$myTime');");
				if($result1){
					echo "Insert Success";
				}
				else{
					echo "Insert Attendence Fail";
				}
			}
		}
		else{
			echo "No Record";
		}
	}


	function resultfill($eid){
		global $conn;
		$query = "Select * from students,exams where 
		students.course = exams.course and students.sem = exams.sem 
		and students.dept_id = exams.dept and exams.exam_id ='$eid'";

		$result1 = mysqli_query($conn,$query);
		if($result1){
			while($row = mysqli_fetch_assoc($result1)){
				$stid = $row['studentid'];
				$examdate = $row['exam_datetime'];
				$result ="INSERT INTO `result`(
					`Studentid`, `exam_id`, `exam_datetime`, `status`) 
					VALUES ('$stid','$eid',
					'$examdate','Not Declared')";
					$query_run = mysqli_query($conn,$result);
				if ($query_run) {
					echo "success";
				}
				else{
					echo "Fail";
				}

			}
			
		}
	}

	function resultCalc($eid){
		global $conn;
		$query4 = "select marks_right_answer,marks_wrong_answer from exams where exam_id='$eid'";
		$result5 = mysqli_query($conn,$query4);
		if($row3 = mysqli_fetch_assoc($result5)){
            $correctmark = $row3['marks_right_answer'];
            $wrongmark = $row3['marks_wrong_answer'];;
            $query = "Select exam_id,questionno,correct from exam_questions where exam_id='$eid'";
            $result = $conn->query($query);
            $ques_ans = array();
            if(mysqli_num_rows($result)>0){
                $total = mysqli_num_rows($result);
                while($row = mysqli_fetch_assoc($result)){
                    $ques_ans[$row['questionno']] = $row['correct'];
                }
            }
            else{
                echo "select From exams_question Wrong";
            }
            $query1 = "Select * from st_attendence where exam_id = '$eid' and attendence='Present'";
            $st_result = array();
            $result1 = mysqli_query($conn,$query1);
            if($result1){
                while($row1 = mysqli_fetch_assoc($result1)){
                    $stid = $row1['Studentid'];
                    $total = $total*$correctmark;
                    $correct = 0;
                    $incorrect = 0;
                    $notattemp = 0;
                    if($row1['attendence']=='Present'){
                        $query2 = "Select * from st_answers where exam_id ='$eid' and studentid='$stid'";
                        $result2 = mysqli_query($conn,$query2);
                        if($result2){
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $quesno = $row2['questionno'];
                                $select = $row2['selected'];
                                if($select == 0){
                                    $notattemp ++;
                                }
                                else
                                {
                                    if($ques_ans[$quesno] == $select){
                                        $correct++;
                                    }
                                    else{
                                        $incorrect++;
                                    }
                                }
                            }
                            $temp = $correct*$correctmark-$incorrect*$wrongmark;
                            $totalmark = $total*$correctmark;
                            $totalobtain = ($temp/$totalmark)*100;
                            $st_result[$stid] = $correct;
                            $query3 = "Update result set percentage='$totalobtain', 
                            total_marks ='$totalmark', marks='$temp' where 
                            exam_id='$eid' and Studentid='$stid'";
                            $result4 = mysqli_query($conn,$query3);
                            if($result4){
                                echo "Success";
                            }
                            else{
                                echo "Fail";
                            }
                        }else{
                            echo "select From stanswer Wrong";
                        }
                    }
                    else{
                        $query3 = "Update result set percentage='0', 
                            total_marks ='$total', marks='0' where 
                            exam_id='$eid' and Studentid='$stid'";
                            $result4 = mysqli_query($conn,$query3);
                            if($result4){
                                echo "Success";
                            }
                            else{
                                echo "Fail";
                            }
                    }

                }
            }
            else{
                echo "select From attendence Wrong";
            }
        }
        else{
            echo "select From exams Wrong";
        }
	}

	
    if(isset($_POST['quessave']))
    {
        $eid = $_POST['exam_id'];
        $qno = $_POST['que_no'];
        $tque = $_POST['total_que'];
        $ques = $_POST['question_title'];
        $op1 = $_POST['option_title_1'];
        $op2 = $_POST['option_title_2'];
        $op3 = $_POST['option_title_3'];
        $op4 = $_POST['option_title_4'];
        $ans = $_POST['answer_option'];
        $query = "INSERT INTO exam_questions
        (exam_id,questionno, question, option1, option2, 
        option3, option4, correct) 
        VALUES ('$eid','$qno','$ques','$op1','$op2','$op3',
        '$op4','$ans')";
        $query_run = mysqli_query($conn,$query);
        
        if($query_run)
        {
            header("Location: questions.php?p=2&eid=$eid&q=$tque");
        }
        else{
            print " Unable TO Issue";
        }
    }

    if(isset($_POST['delete_ques']))
    {
        $del_qid = $_POST['del_qid'];
        $del_eid = $_POST['del_eid'];
        $tot_q = $_POST['del_tq'];
        $query = "Delete from exam_questions
        where id='$del_qid' and exam_id='$del_eid'";
        $query_run = mysqli_query($conn,$query);

        if($query_run)
        {
			$_SESSION['status'] = "Deleted Successfully";
            header("Location: questions.php?p=2&eid=$del_eid&q=$tot_q");
        }
        else{
			$_SESSION['status'] = "Unable TO Issue";
            header("Location: questions.php?p=2&eid=$del_eid&q=$tot_q");
        }
    }
    

if(isset($_POST["edit_quessave"]))
{
    $tq = $_POST['edit_total_que'];
	$eid = $_POST['edit_exam_id'];
    $qid = $_POST['edit_que_id'];
    $ques = $_POST['edit_question_title'];
    $op1 = $_POST['edit_option_title_1'];
    $op2 = $_POST['edit_option_title_2'];
    $op3 = $_POST['edit_option_title_3'];
    $op4 = $_POST['edit_option_title_4'];
    $ans = $_POST['edit_answer_option'];

	$query = "UPDATE exam_questions Set question='$ques',option1='$op1',
    option2='$op2',option3='$op3',option4='$op4',correct='$ans' WHERE exam_id=$eid and id=$qid ;";
	$query_run = mysqli_query($conn,$query);
	if($query_run)
	{
		$_SESSION['status'] = "Added Successfully";
		header("Location: questions.php?p=2&eid=$eid&q=$tq");
	}
	else
	{
		$_SESSION['status'] = "Unable to Add";
		header("Location: questions.php?p=2&eid=$eid&q=$tq");
	}
}

if(isset($_POST["newusersubmit"]))
	{
		$sid = $_POST['newsid'];
        $cour = $_POST['newcoursename'];
        $dept = $_POST['newdeptname'];
        $sem = $_POST['newsemno'];
		$name = $_POST['newusername'];
		$email = $_POST['newemail'];
		$mobile = $_POST['newmobile'];
		$password = $_POST['newpassword'];
		$new_image = $_FILES['profileImage']['name'];
		rename("$new_image", 'new_location/image1.jpg');

		$update_filename = $conn->real_escape_string('photos/student'.$_FILES['profileImage']['name']);

		$query = "Insert into students(studentid,name,course,dept_id,sem,emailid,mobileno,password,photo,status) 
				values($sid,'$name','$cour','$dept','$sem','$email','$mobile','$password','$update_filename',1);";
		$result = mysqli_query($conn,$query);

		if($result){
			if($_FILES["profileImage"]['name']!='')
			{
				move_uploaded_file($_FILES["profileImage"]["tmp_name"],"photos/student".$_FILES["profileImage"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: admin.php?p=4");
		}
		else{
			$_SESSION['status']="Update Unsucessful";
			header("Location: admin.php?p=4");

		}	
	}


    if(isset($_POST["editusersubmit"]))
	{
		$sid = $_POST['editsid'];
		$name = $_POST['editname'];
        $sem = $_POST['editsemno'];
		$email = $_POST['editemail'];
		$mobile = $_POST['editmobile'];
		$password = $_POST['editpassword'];
		$new_image = $_FILES['profileImg']['name'];
		$old_image = $_POST['fakepic'];
    
        if($new_image != '')
        {
            $update_filename = $conn->real_escape_string('photos/student/'.$_FILES['profileImg']['name']);
        }
        else{
            $update_filename = $conn->real_escape_string($_POST['fakepic']);
        }

		$query = "Update students set
				  name='$name',sem='$sem',emailid='$email',password='$password',
				  mobileno='$mobile',photo='$update_filename' where studentid=$sid;";
		$result = mysqli_query($conn,$query);

		if($result){
			if($_FILES["profileImg"]['name']!='')
			{
				move_uploaded_file($_FILES["profileImg"]["tmp_name"],"photos/student/".$_FILES["profileImg"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: admin.php?p=4");

		}
		else{
			echo "Update Unsuccessful";
            header("Location: admin.php?p=4");		}	
	}

	if(isset($_POST["delete_user"]))
	{
		$sid = $_POST['del_id'];
		$query = "Select photo from students where studentid=$sid";
		$query1 = "Delete from students where studentid=$sid";
		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result) > 0)
		{
			foreach($result as $row)
			{
				$photo = $row['photo'];
			}
			$result1 = mysqli_query($conn,$query1);
			if($result1)
			{
				$_SESSION['status'] = "Update Successfull";
				unlink($photo);
                header("Location: admin.php?p=4");				}
			else
			{
				$_SESSION['status'] = "Update UnSuccessful";
                header("Location: admin.php?p=4");				}
		}
		else{
			$_SESSION['status'] = "Update UnSuccessful ";
            header("Location: admin.php?p=4");			}

	}

    if(isset($_POST["new_cour_submit"]))
	{
		$in_no = $_POST['store'];
        $coursename = $_POST['newcourse'];
        $courid = $_POST['newcoursename'];
        $branchname = $_POST['newbranchname'];
        
        $query = "Insert into course(course_name) values('$coursename')";
		$query1 = "Insert into department(course_id,dept_name) values('$courid','$branchname')";
        if($in_no == 0)
        {
            $query_run = mysqli_query($conn,$query);
            if($query_run)
            {	
                $_SESSION['status'] = "Added Successfully";
                header("Location: admin.php?p=1");
            }
            else{
                $_SESSION['status'] = "Adding UnSuccessful";
                header("Location: admin.php?p=1");
            }
        }
        else
        if($in_no == 1)
        {
            $query_run1 = mysqli_query($conn,$query1);
            if($query_run1)
            {	
                $_SESSION['status'] = "Added Successfully";
                header("Location: admin.php?p=1");
            }
            else{
                $_SESSION['status'] = "Adding UnSuccessful";
                header("Location: admin.php?p=1");
            }
        }
        else{
            $_SESSION['status'] = "Error in Backend Processing";
                header("Location: admin.php?p=1");
        }
	}
	if(isset($_POST["new_subject_submit"]))
	{
        $coursename = $_POST['coursename'];
        $branchname = $_POST['dept_name'];
		$subname = $_POST['newsubname'];
		$subcode = $_POST['newsubcode'];
        $type = $_POST['formtype'];
		$query = "Insert into subjects(sub_name,sub_code,course_id,dept_id) 
		values('$subname','$subcode','$coursename','$branchname')";
		$query_run = mysqli_query($conn,$query);
		if($query_run)
        {

			$_SESSION['status'] = "Added Successfully";
			if($type == "1"){
				header("Location: admin.php?p=6&cid=$coursename&did=$branchname");
			}else{
				header("Location: admin.php?p=1");
			}
			
        }
        else{
            $_SESSION['status'] = "Error in Backend Processing";
                header("Location: admin.php?p=1");
        }
	}
    if(isset($_POST["delete_branch"]))
	{
		$del_id = $_POST['del_deptid'];
        $query = "Delete from department where dept_id='$del_id'";
        $query_run = mysqli_query($conn,$query);
        if($query_run)
        {	
            $_SESSION['status'] = "Deleted Successfully";
            header("Location: admin.php?p=1");
        }
        else{
            $_SESSION['status'] = "Error in Backend Processing";
            header("Location: admin.php?p=1");
        }
 
	}
	if(isset($_POST["delete_subject"]))
	{
		$sub_id = $_POST['del_subid'];
		$dept_id = $_POST['del_did'];
		$courseid = $_POST['del_cid'];
        $query = "Delete from subjects where sub_id='$sub_id'";
        $query_run = mysqli_query($conn,$query);
        if($query_run)
        {	
            $_SESSION['status'] = "Deleted Successfully";
            header("Location: admin.php?p=6&cid=$courseid&did=$dept_id");
        }
        else{
            $_SESSION['status'] = "Error in Backend Processing";
            header("Location: admin.php?p=6&cid=$courseid&did=$dept_id");
        }
 
	}


	
    if(isset($_POST["newmembersubmit"]))
  {
	  $mid = $_POST['newmid'];
	  $name = $_POST['newmembername'];
	  $email = $_POST['newemail'];
	  $mobile = $_POST['newmobile'];
	  $password = $_POST['newpassword'];
	  $new_image = $_FILES['profileImage']['name'];

	  $update_filename = $conn->real_escape_string('photos/admin/'.$_FILES['profileImage']['name']);

	  $query = "Insert into admin(memberid,name,emailid,mobileno,password,photo) 
			  values($mid,'$name','$email','$mobile','$password','$update_filename');";
	  $result = mysqli_query($conn,$query);
	  if($result){
		  if($_FILES["profileImage"]['name']!='')
		  {
			  move_uploaded_file($_FILES["profileImage"]["tmp_name"],"photos/admin/".$_FILES["profileImage"]["name"]);
			  unlink($old_image);
		  }
		  $_SESSION['status'] = "Updated Successfully";
          header("Location: admin.php?p=5");
	  }
	  else{
			$_SESSION['status']="Update Unsuccessful";
            header("Location: admin.php?p=5");
	  }	
  }



  if(isset($_POST["editmembersubmit"]))
	{
		$mid = $_POST['editmid'];
		$name = $_POST['editname'];
		$email = $_POST['editemail'];
		$mobile = $_POST['editmobile'];
		$password = $_POST['editpassword'];
		$new_image = $_FILES['profileImg']['name'];
		$old_image = $_POST['fakepic'];
    
        if($new_image != '')
        {
            $update_filename = $conn->real_escape_string('photos/admin/'.$_FILES['profileImg']['name']);
        }
        else{
            $update_filename = $conn->real_escape_string($_POST['fakepic']);
        }

		$query = "Update admin set
				  name='$name',emailid='$email',password='$password',
				  mobileno='$mobile',photo='$update_filename' where memberid=$mid;";
		$result = mysqli_query($conn,$query);

		if($result){
			if($_FILES["profileImg"]['name']!='')
			{
				move_uploaded_file($_FILES["profileImg"]["tmp_name"],"photos/admin/".$_FILES["profileImg"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: admin.php?p=5");
		}
		else{
			$_SESSION['status']="Update Unsuccessful";
			header("Location: admin.php?p=5");
		}	
	}

  if(isset($_POST["delete_member"]))
  {
		$mid = $_POST['del_mid'];
		$query = "Select photo from admin where memberid=$mid";
		$query1 = "Delete from admin where memberid=$mid;";
		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result) > 0)
		{
			foreach($result as $row)
			{
				$photo = $row['photo'];
			}
			$result1 = mysqli_query($conn,$query1);
			if($result1)
			{
				$_SESSION['status'] = "Update Successfull";
				unlink($photo);
				header("Location: admin.php?p=5");
			}
			else
			{
				$_SESSION['status'] = "Update UnSuccessful";
				header("Location: admin.php?p=5");
			}
		}
		else{
			$_SESSION['status'] = "Update UnSuccessful ";
			header("Location: admin.php?p=5");
		}

  }

  if(isset($_POST['action'])){
	if($_POST['action'] == "exam_status"){
		$date = $_POST['date'];
		$time = $_POST['time'];
		$datetime= date('Y-m-d H:i', strtotime("$date $time"));
		$query = "Select exam_datetime,exam_id,exam_duration,status from exams where (status='Created' or status='Started') and exam_datetime like'$date%'";
		$result = $conn->query($query);
		if($result->num_rows>0){
			while($row= $result->fetch_assoc())
			{
				$eid= $row['exam_id'];
				$examdatetime = date("Y-m-d h:i",strtotime("{$row['exam_datetime']}"));
				if($examdatetime==$datetime and $row['status'] =='Created'){
					attendencefill($eid);
					$result1= $conn->query("update exams set status='Started' where exam_id = '$eid'");
					echo "success Update";
				}
				elseif($row['status'] =='Started'){
					$min = $row['exam_duration'];
					$examtime = date('Y-m-d h:i', strtotime("+$min minutes", strtotime("{$row['exam_datetime']}")));
					if($datetime>$examtime){
						$result2= $conn->query("update exams set status='Completed' where exam_id = '$eid'");
						if($result2){
							resultfill($eid);
							resultCalc($eid);
							echo "Success Completed";
						}
						else{
							echo "Error Updating Exam";
						}
					}
					else{
						echo "Completed Condition not Matched";
					}
				}
				else{
					echo "Condition not match";
				}
			}
			}
			else{
				echo "No Data Available";
			}
		}
	
	  if($_POST["action"]=='checking_quesedit')
	  {
		  $result_array = [];
		  $eid = $_POST['eid'];
		  $qid = $_POST['qid'];
	  
		  $query = "SELECT * from exam_questions WHERE exam_id=$eid and id=$qid ;";
		  $query_run = mysqli_query($conn,$query);
		  if(mysqli_num_rows($query_run) > 0)
		  {
			  foreach($query_run as $row)
			  {
				  array_push($result_array,$row);
				  header('Content-type: application/json');
				  echo json_encode($result_array);
			  }
		  }
		  else
		  {
			  echo $return = "not";
		  }
	  }
	
	  if($_POST["action"] == "checking_memberedit")
	  {
			$result_array = [];
			$mid = $_POST['m_id'];
			$query = "SELECT * FROM admin where memberid=$mid ";
			$query_run = mysqli_query($conn,$query);
	
			if(mysqli_num_rows($query_run) > 0)
			{
				foreach($query_run as $row)
				{
					array_push($result_array,$row);
					header('Content-type: application/json');
					echo json_encode($result_array);
				}
			}
			else
			{
				$_SESSION['status'] = "No Record Found";
				header("Location: admin.php?p=5");
			}
	  }
	
	  if($_POST["action"] == 'checking_editbtn')
	  {
		  $result_array = [];
		  $sid = $_POST['sid'];
		  $query = "select studentid,name,sem,photo,
		  emailid,password,mobileno,course_name,dept_name 
		  from students a, course c, department d where 
		  a.course = c.course_id and a.dept_id =d.dept_id and studentid='$sid';";
		  $query_run = mysqli_query($conn,$query);
		  if(mysqli_num_rows($query_run) > 0)
		  {
			  foreach($query_run as $row)
			  {
				  array_push($result_array,$row);
				  header('Content-type: application/json');
				  echo json_encode($result_array);
			  }
		  }
		  else
		  {
			  $_SESSION['status'] = "No Record Found";
			  header("Location: admin.php?p=4");
	
		  }
	  }
	
	  if($_POST['action']=='resulttable'){
		$result_array = [];
		$rid = $_POST['r_id'];
		$query = "SELECT resultid,exams.exam_id,exams.exam_datetime,total_marks,Marks,
		cgpa,exam_declared_date,course_name,
		dept_name,exam_title,exam_code FROM result,exams,course,department
		where course.course_id=exams.course 
		and department.dept_id=exams.dept and exams.exam_id = result.exam_id ";
		
		$query_run = mysqli_query($conn,$query);
	
		if(mysqli_num_rows($query_run) > 0)
		{
			foreach($query_run as $row)
			{
				array_push($result_array,$row);
				header('Content-type: application/json');
				echo json_encode($result_array);
			}
		}
		else
		{
			echo $return = "<h5>No Record Found</h5>";
		}
	  }

	  if($_POST['action'] == 'subtablefetch'){
		$result_array1 = [];
		$cid = $_POST['cid'];
		$did = $_POST['did'];
		$query = "SELECT * from subjects where course_id='$cid' and dept_id='$did';";
		$query_run = mysqli_query($conn,$query);
		if(mysqli_num_rows($query_run) > 0)
		{
			$i=0;
			while($row = mysqli_fetch_array($query_run))
			{
				$data[$i] = array("sub_id"=>$row["sub_id"],"sub_name" =>$row["sub_name"],"sub_code"=>$row["sub_code"]);
				$i=$i+1;
			}
			header('Content-type: application/json');
			echo json_encode($data);
		}
		else
		{
			echo $return = "not";
		}

	  }

	  if($_POST['action'] == 'declare_result'){
		$rid = $_POST['r_id'];
		$date = date('Y-m-d',strtotime("now"));
		$query = "Update result set status='Declared',exam_declared_date='$date' where resultid='$rid'";
        $query_run = mysqli_query($conn,$query);
        if($query_run)
        {	
            $_SESSION['status'] = "Declared";
            header("Location: admin.php?p=3");
        }
        else{
            $_SESSION['status'] = "Error in Backend Processing";
            header("Location: admin.php?p=3");
        }
	  }

  }



?>