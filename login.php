<?php
	session_start();
    $conn=new mysqli("localhost","root","","on_exams");
	if(mysqli_connect_error())
	{
		die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	}
	$_SESSION['status']=null;

	if(isset($_POST['submitadmin']))
	{
		$myusername = mysqli_real_escape_string($conn,$_POST['user']);
		$mypassword = mysqli_real_escape_string($conn,$_POST['pass']); 
		
		$sql = "SELECT memberid,name,photo FROM admin WHERE memberid = '$myusername' and password = '$mypassword'";
		$result=$conn->query($sql);
		$count = mysqli_num_rows($result);
		$row=$result->fetch_assoc();
		if($count == 1) 
		{
			$_SESSION['login'] = $row['memberid'];
			$_SESSION['admin_id'] =$row['memberid'];
			$_SESSION['login_pic'] = $row['photo'];
			$_SESSION['login_name'] = $row['name'];
			$_SESSION['user'] = "Member";
			$_SESSION['status']=null;
			header("location: admin.php?p=0");
		
		}
		else
		{
			$_SESSION['status']="User Id or Password Incorrect";
		}
	} 

	if(isset($_POST['submitstudent']))
	{
		$myusername = mysqli_real_escape_string($conn,$_POST['user']);
		$mypassword = mysqli_real_escape_string($conn,$_POST['pass']); 
		
		$sql = "SELECT studentid,name,photo,course,dept_id,sem FROM students WHERE studentid = '$myusername' and password = '$mypassword'";
		$result=$conn->query($sql);
		$count = mysqli_num_rows($result);
		$row=$result->fetch_assoc();
		if($count == 1) 
		{ 
			$_SESSION['login'] = $row['studentid'];
			$_SESSION['login_pic'] = $row['photo'];
			$_SESSION['login_name'] = $row['name'];
            $_SESSION['stdid'] = $row['studentid'];
			$_SESSION['stcourse'] = $row['course'];
			$_SESSION['stdept'] = $row['dept_id'];
			$_SESSION['stsem'] = $row['sem'];
			$_SESSION['status']=null;
			$_SESSION['user'] = "Student";
			header("location: student.php?p=0");
		}
		else
		{
			echo "<div class='alert alert-danger'><b>Error : </b> User Name and Password Incorrect.</div>";
		}
	} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body style="color:white;background:url('./img/loginback.jpg');background-repeat: no-repeat;background-size: cover;">
    <div class="login">
    <?php if($_SESSION['status']!="")
                {?>
            <div class="col-md-12">
            <div class="alert alert-danger" >
            <strong>Status :</strong> 
            <?php echo htmlentities($_SESSION['status']);?>
            <?php echo htmlentities($_SESSION['status']="");?>
            </div>
            </div>
    <?php } ?>
    <div class="selec">
    <h3 class="nonactive" onclick="change()" id="log"> Admin Login </h3>
    <h3 class="active" onclick="changes()" id="sign">Student Login</h3>
    </div>

    <form action="login.php" method="post" id="adminlog" style="display: none;">
        <input type="text" class="text" name="user"  id="user">
        <span>MemberID</span>
        <br>
        <br>
        <input type="password" class="text" id="pass" name="pass">
        <span>password</span>
        <br>
        <button class="signin" name="submitadmin" type="submit">
        Sign In
        </button>

        <hr>
    </form>

    <form action="login.php" method="post" id="studentlog">
        <input type="text" class="text" name="user"  id="user">
        <span>StudentID</span>
        <br>
        <br>
        <input type="password" class="text" id="pass" name="pass">
        <span>password</span>
        <br>
        <button class="signin" name="submitstudent" type="submit">
        Sign In
        </button>
        
        <hr>
    </form>
    </div>

</body>
</html>

<script type="text/javascript"> 
	function change() 
	{ 
			document.getElementById('log').className = "active"; 
			document.getElementById('sign').className = "nonactive";
			document.getElementById('studentlog').style.display="none";
			document.getElementById('adminlog').style.display="block";
	}
	function changes()
	{
		document.getElementById('log').className = "nonactive"; 
		document.getElementById('sign').className = "active"; 
		document.getElementById('studentlog').style.display="block";
		document.getElementById('adminlog').style.display="none";
	}
</script> 
