<?php 
session_start();
$_SESSION["userid"] = '';
$_SESSION["name"] = '';
session_destroy();
// session_unset();
header("Location:login.php");
?>