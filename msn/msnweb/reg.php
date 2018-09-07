<?php 
error_reporting(0);
require_once('./../includes/common/common.php');
require_once("./../includes/db/db_connet.php");
@session_id($_COOKIE['PHPSESSID']);
@session_start();
$dbobj =new DbConnet();
$where=' phone_number ='.$yzmtel;
$select ="select * from msn_member where phone_number =:phone_number";
$param = array(':phone_number'=>$yzmtel);
$row =$dbobj->getRow($select,$param);
if($row['phone_number'] !=''){
	ShowMsg('用户已存在，请直接登录！','index.php',0,1000);
	exit;
}else{
	if( (time() - $_SESSION['time']) > 5*60 ){
		ShowMsg('验证码时间失效！请您重新发送验证码','index.php',0,1000);
		exit;
	}
	if($code != $_SESSION['code'] ){
		ShowMsg('验证码不正确！','index.php',0,1000);
		exit;
	}
	$pwd =substr(md5($pwd),3,9);
	$time=time();
	$ip =GetIP();
	
	//$insertsql ="insert into msn_member (phone_number,phone_pwd,create_time,ip_address) values ('{$yzmtel}','{$pwd}','{$time}','{$ip}')";
	$insertsql ="insert into msn_member (phone_number,phone_pwd,create_time,ip_address) values (:phone_number,:phone_pwd,:time,:ip)";
	$param =array(':phone_number'=>$yzmtel,':phone_pwd'=>$pwd,':time'=>$time,':ip'=>$ip);
	if($dbobj->query($insertsql,$param)){
		$_SESSION['phone_login']=$yzmtel;
		ShowMsg('注册成功！','member_center.php',0,1000);
		exit;
	}else{
		ShowMsg('注册失败','index.php',0,1000);
		exit;
	}
	
}
exit;