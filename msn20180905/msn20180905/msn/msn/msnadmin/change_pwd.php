<?php 
error_reporting(0);
include_once("./../includes/common/common.php");
include_once(str_replace("\\", '/', dirname(__FILE__) ).'/../includes/db/db_connet.php');
session_start();
if(empty($changepwd)) $changepwd ='';
if($changepwd =='changepwd'){
	$dbobj =new DbConnet();
	$pwd = substr(md5($pwd),3,9);
// 	$updatesql = "update msn_admin set login_pwd ='{$pwd}' where login_name='{$_SESSION['msn_admin_name']}'";
	$updatesql = "update msn_admin set login_pwd =? where login_name=?";
	$param=array($pwd,$_SESSION['msn_admin_name']);

	if($dbobj->query($updatesql,$param)){
		showMsg("更新成功！","change_pwd.php",0,1000);
		exit();
	}else{
		showMsg("更新失败！请联系管理员","change_pwd.php",0,1000);
		exit();
	}
}
include("./templates/change_pwd.html");
exit();

