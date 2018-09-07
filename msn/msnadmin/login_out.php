<?php 
include(str_replace("\\", '/', dirname(__FILE__) ).'./../includes/userlogin.class.php');
$cuserLogin = new userLogin();
$cuserLogin->exitUser();
header("Location:./index.php");
exit;