<?php 
session_start();
unset($_SESSION['login_pic']);
unset($_SESSION['login_name']);
session_destroy();
echo "<script>window.open('login.php','_self')</script>";
?>