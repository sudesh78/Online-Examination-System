<?php
    $conn = new mysqli("localhost", "root", "", "on_exams");
    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    }
    date_default_timezone_set('Asia/Calcutta');

    if($_POST['action']=='insertSelect'){

        $total = $_POST['total'];
        $eid = $_POST['eid'];
        $stid = $_POST['stid'];
        
        $query1 = "Select * from st_answers where exam_id ='$eid' and studentid='$stid'";
        $result1=$conn->query($query1);
        if(mysqli_num_rows($result1) == 0){
            for($i = 1;$i<=$total;$i++){
                $query = "INSERT INTO `st_answers`(`exam_id`, `Studentid`, `questionno`, `selected`) 
                        VALUES ('$eid','$stid','$i',0)";
                $result1 = mysqli_query($conn, $query);
                if ($result1) {
                    echo "insert success";
                } else {
                    echo "insert fail";
                }
            }
            
        }else{
            echo "blank";
        }
    }
    




    if($_POST['action']=='insertdata')
    {
        $eid = $_POST['eid'];
        $stid = $_POST['stid'];
        $total = $_POST['total'];
        $quesno = $_POST['quesno'];
        $select = $_POST['select'];

        $query = "Update `st_answers`
        set selected = '$select' where `exam_id`='$eid' and `Studentid`='$stid' and `questionno`='$quesno' ";
        $result1 = mysqli_query($conn, $query);
        if ($result1) {
            echo "update success";
        } else 
        {
            echo "update Fail";
        }       
        
    }

        
    if($_POST['action']=='insertresult')
    {
        $eid = $_POST['eid'];
        $stid = $_POST['stid'];
        $examdate = date("Y-m-d h:i:s",strtotime($_POST['examdate']));
       
        $result =("INSERT INTO `result`(
         `Studentid`, `exam_id`, `exam_datetime`, `status`) 
         VALUES ('$stid','$eid',
         '$examdate','Not Declared')");
          $query_run = mysqli_query($conn,$result);
	    if ($query_run) {
            echo "success";
	    }
        else{
            echo "Fail";
        }
    
    }

    if($_POST['action'] == "selectdata"){
        $eid = $_POST['eid'];
        $stid = $_POST['stid'];

        $query =("SELECT * FROM st_answers WHERE exam_id = '$eid' and Studentid =
		'$stid'");
        $query1 =("SELECT questionno,selected FROM st_answers WHERE exam_id = '$eid' and Studentid =
		'$stid'");
	    if ($row = $conn->query($query)) {
            $exam_select = array();
            if (mysqli_num_rows($row) == 0) {
                    echo "blank";
            } else {
                $row1 = mysqli_query($conn, $query1);
                while ($result = mysqli_fetch_assoc($row1)) {
                    $exam_select[$result['questionno']] = $result['selected'];
                }
                echo json_encode($exam_select, JSON_FORCE_OBJECT);
            }
	    }
        else{
            echo"eerror";
        }

    }

    if($_POST['action'] == 'checkexam'){
        $eid = $_POST['eid'];
        $stid = $_POST['stid'];
        $time = date("Y-m-d h:i:s");
           
        $query = ("SELECT exam_datetime,exam_duration FROM exams WHERE exam_id = '$eid' and status = 'Started'");

	    if ($row = $conn->query($query)) {
            if (mysqli_num_rows($row) == 1){
                if($row1 = $row->fetch_assoc()){
                    $min = $row1['exam_duration'];
                    $re = date('Y-m-d h:i', strtotime("+$min minutes", strtotime("{$row1['exam_datetime']}")));

                    if($time < $re){
                        echo "Success";
                    }
                    else{
                        echo "You Are Late";
                    }
                }
            }
            else{
                echo "Exam Not Started";
            }
            
	    }
        else{
            echo "Error Processing Query";
        }
    }


////////////////////////////////////////////////////////////////////////////////////

    if($_POST['action'] == 'profilecheck')
    {
        $result_array = [];
        $sid = $_POST['stid'];
        $query = "SELECT * FROM students,course,department where students.course = course.course_id and 
        department.dept_id = students.dept_id and studentid=$sid ";
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

    
	if(isset($_POST["profileupdate"]))
	{
		$sid = $_POST['studentid'];
		$email = $_POST['email'];
		$mobile = $_POST['phone'];
		$password = $_POST['password'];
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
				  emailid='$email',password='$password',
				  mobileno='$mobile',photo='$update_filename' where studentid=$sid;";
		echo $new_image,"  ",$old_image;
        $result = mysqli_query($conn,$query);
		if($result){
			if($_FILES["profileImg"]['name']!='')
			{
				move_uploaded_file($_FILES["profileImg"]["tmp_name"],"photos/student/".$_FILES["profileImg"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: student.php?q=3");

		}
		else{
			echo "Update Unsuccessful";
			header("Location: student.php?q=3");
		}	
	}

    if(isset($_POST['action'])){
        if($_POST['action'] == "resulttable"){
            $result_array = [];
            $rid = $_POST['r_id'];
            $query = "SELECT resultid,students.Studentid,exams.exam_id,exams.exam_datetime,total_marks,marks,
            result.percentage,exam_declared_date,students.name,students.sem,course_name,
            dept_name,exam_title,exam_code FROM result,exams,course,department,students 
            where course.course_id=students.course and result.Studentid = students.studentid
            and department.dept_id=students.dept_id and exams.exam_id = result.exam_id and resultid='$rid'";
            
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
    
    }
    
?>

