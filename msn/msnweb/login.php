<?php 
error_reporting(0);
require_once('./../includes/common/common.php');
require_once("./../includes/db/db_connet.php");
@session_id($_COOKIE['PHPSESSID']);
@session_start();
$dbobj =new DbConnet();
$where=' phone_number ='.$phonenum;
$select="select * from msn_member where phone_number =:phone_number ";
$param =array(':phone_number'=>$phonenum);
$row =$dbobj->getRow($select,$param);
if($row['phone_pwd'] ==''){
	ShowMsg('该用户不存在,请注册！','index.php',0,1000);
	exit;
}else{
	$pwd =substr(md5($pwd),3,9);
	if($pwd != $row['phone_pwd']){
		ShowMsg('密码不正确！','index.php',0,1000);
		exit;
	}
	$_SESSION['phone_login']=$phonenum;
}
header('Location:./member_center.php');
exit();
