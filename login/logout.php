<?php
//initialize the session
session_start();

//unset all of the session variables
// $_SESSION=array();
unset($_SESSION['name']);
unset($_SESSION['email']);

//destroy the session
session_destroy();

//redirect to login page
header("location: login.php");
exit;
?>