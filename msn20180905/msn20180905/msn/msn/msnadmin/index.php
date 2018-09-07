<?php 
error_reporting(0);
require_once(str_replace("\\", '/', dirname(__FILE__) )."/../configs/global.config.php");
include(str_replace("\\", '/', dirname(__FILE__) ).'./../includes/userlogin.class.php');

$cuserLogin = new userLogin();
if($cuserLogin->getUserID()==-1)
{
	header("location:login.php");
	exit();
}
include("./templates/indexx.html");
exit();