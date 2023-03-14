<?php
session_start();
$conn = new mysqli("localhost", "root", "", "on_exams");
if (mysqli_connect_error()) {
    die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
}
date_default_timezone_set('Asia/Calcutta');
if(strlen($_SESSION['login'])==0)
{
  header("location: login.php");
}
else
{

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/sidenav.css">
</head>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


<link rel='stylesheet' href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css'>
<script src='https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js' type='text/javascript'></script>




<body style="background-color: #f3eeee;">
<div class="nav">
    <header>
            <h1>
                <label for="">
                    <span class="las la-bars"></span>
                </label>
            </h1>
        </header>
        <div class="sidenavmenu">
        <div class="sidebar" style="overflow-y: scroll;">
        <div class="profile">

        <input type="hidden" name="datenow" id="datenow" value="<?php echo date("Y-m-d");?>">
            <img src="<?php echo $_SESSION['login_pic']; ?>" alt="profile_picture">
            <h3><?php echo $_SESSION['login_name']; ?></h3>
            <p>Admin</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="admin.php?p=0" <?php if ($_GET['p'] == 0)  echo 'class="active"';  ?>><span class="las la-igloo"></span>
                        <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="admin.php?p=1" <?php if ($_GET['p'] == 1) echo 'class="active"'; ?>><span class="las la-history"></span>
                        <span>Add course</span></a>
                </li>
                <li>
                    <a href="admin.php?p=6" <?php if ($_GET['p'] == 6) echo 'class="active"'; ?>><span class="las la-history"></span>
                        <span>Add Subject</span></a>
                </li>
                <li>
                    <a href="admin.php?p=2" <?php if ($_GET['p'] == 2) echo 'class="active"'; ?>><span class="las la-history"></span>
                        <span>Exams</span></a>
                </li>
                <li>
                    <a href="admin.php?p=3" <?php if ($_GET['p'] == 3) echo 'class="active"'; ?>><span class="las la-clipboard-list"></span>
                        <span>Results</span></a>
                </li>
                <li>
                    <a href="admin.php?p=4" <?php if ($_GET['p'] == 4) echo 'class="active"'; ?>><span class="las la-user-circle"></span>
                        <span>Students</span></a>
                </li>
                <li>
                    <a href="admin.php?p=5" <?php if ($_GET['p'] == 5) echo 'class="active"'; ?>><span class="las la-user-circle"></span>
                        <span>Members</span></a>
                </li>
                <li>
                    <a href="logout.php"><span class="las la-sign-in-alt"></span>
                        <span>Log Out</span></a>
                </li>
            </ul>
        </div>
    </div>
        </div>
    </div>

    <div class="main-content">
        <?php if ($_GET['p'] == 0) include "admin_dashboard.php" ?>
        <?php if ($_GET['p'] == 1) include "add_course.php" ?>
        <?php if ($_GET['p'] == 2) include "admin_exam.php" ?>
        <?php 
        if ($_GET['p'] == 3){
            if(isset($_GET['rid'])){
                include "admin_viewresult.php" ;
            }
            else{
                include "admin_result.php" ;
            }
            
        }
        ?>
        <?php if ($_GET['p'] == 4) include "admin_user.php" ?>
        <?php if ($_GET['p'] == 5) include "admin_admin.php" ?>
        <?php if ($_GET['p'] == 6) include "admin_subject.php" ?>
       
    </div>

</body>
<script>
    window.onload = display_ct();

    function display_c() {
      var refresh = 1000;
      mytime = setTimeout('display_ct()', refresh);
    }

    function display_ct() {
      var x = new Date();
      var hours = x.getHours();
      var minutes = x.getMinutes();
      var seconds = x.getSeconds();

      var ampm = hours >= 12 ? 'pm' : 'am';
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = minutes < 10 ? '0'+minutes : minutes;
  
      let time = hours + ":" + minutes + ":" + seconds;
      document.getElementById('ct').innerHTML = "Time : " + time +" "+ampm;
    exam_status(time);
      display_c();
    }

    function exam_status(time){

        var now = $("#datenow").val();
        $.ajax({
				type: "POST",
				url: "backend.php",
				data:{
					'action': 'exam_status',
					'date':now,
                    'time':time
				},
				success: function (response) {
                    // console.log(response);
				}
			});
    }
</script>
</html>

<?php
}
?>