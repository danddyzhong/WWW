<?php 
error_reporting(0);
require_once('./../includes/common/common.php');
require_once("./../includes/db/db_connet.php");
session_start();
$dbobj =new DbConnet();
if(isset($_SESSION['phone_login'])){
	$username =$_SESSION['phone_login'];
	$select="select * from msn_member_article where id =1";
	$row =$dbobj->getRow($select);
	
}else{
	header("Location:./index.php");
	exit;
}
include("./webhtml/member_page.html");
exit;