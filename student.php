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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/student.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  
</head>

<body>
    <div class="nav">
    <header>
            <h1>
                <label for="">
                    <span class="las la-bars"></span>
                </label>
            </h1>
        </header>
            <div class="sidebar">
        <div class="profile">
            <img src="<?php echo $_SESSION['login_pic']; ?>" alt="profile_picture">
            <h3><?php echo $_SESSION['login_name']; ?></h3>
            <p>Student</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="student.php?p=0" <?php if ($_GET['p'] == 0) echo 'class="active"'; ?>><span class="las la-igloo"></span>
                        <span>Dashboard</span></a>
                </li>

                <li>
                    <a href="student.php?p=2" <?php if ($_GET['p'] == 2) echo 'class="active"'; ?>><span class="las la-clipboard-list"></span>
                        <span>Results</span></a>
                </li>
                <li>
                    <a href="student.php?p=3" <?php if ($_GET['p'] == 3) echo 'class="active"'; ?>><span class="las la-user-circle"></span>
                        <span>Profile</span></a>
                </li>
                <li>
                    <a href="logout.php" <?php if ($_GET['p'] == 4) echo 'class="active"'; ?>><span class="las la-sign-in-alt"></span>
                        <span>Log Out</span></a>
                </li>
            </ul>
        </div>
    </div>
    </div>


    <div class="main-content">
        <?php if ($_GET['p'] == 0) include "st_dashboard.php" ?>
        <?php if ($_GET['p'] == 1) include "st_history.php" ?>
        <?php if ($_GET['p'] == 2) include "st_result.php" ?>
        <?php if ($_GET['p'] == 3) include "st_profile.php" ?>
    </div>

</body>
<script>
        window.onload = display_ct();

    function display_c() {
      var refresh = 1000;
      mytime = setTimeout('display_ct()', refresh)
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
      display_c();
    }
</script>
</html>

<?php
}
?>