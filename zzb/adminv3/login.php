<?php
require_once '../include/common.inc.php';
error_reporting(0);
if($act=="user_login"){
	$query=$db->query("select * from {$tablepre}members where username='$username' and password='".md5($password)."'");
	while($row=$db->fetch_row($query)){

		if(stripos(auth_group($row[gid]),'adminlogin')){
			
			$_SESSION['admincp']=$row['username'];
			$_SESSION['login_uid']=$row['uid'];
			$_SESSION['login_gid']=$row['gid'];
			$_SESSION['login_user']=$row['username'];
			header("location:index.php");
		}else{
			exit("<script>alert('access not enought!!!!');top.location.href='login.php';</script>");
		}
	}
	exit("<script>alert('用户名或密码错误！');top.location.href='login.php';</script>");
}
else if($act=="user_logout"){
	$_SESSION['admincp']="";
	unset($_SESSION['admincp']);
	session_destroy(); 
	header("location:?");
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?=$cfg['config']['title']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/bui-min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/page-min.css" rel="stylesheet" type="text/css" />
<!-- 下面的样式，仅是为了显示代码，而不应该在项目中使用-->
<!-- <link href="../assets/css/prettify.css" rel="stylesheet" type="text/css" /> -->
<style type="text/css">
code { padding: 0px 4px; color: #d14; background-color: #f7f7f9; border: 1px solid #e1e1e8; }

</style>

</head>
<body>
<form method="post" enctype="application/x-www-form-urlencoded">
<div style="height:350px; background:#27467e;position:relative;">
	<div style="position:relative; bottom:-300px; text-align:center"><span style=" color:#FFF; font-size:40px;font-family: Microsoft YaHei;text-shadow:5px 2px 6px #000;"><?=$cfg['config']['title']?>管理登录</span></div>
</div>

<div style="text-align:center; margin-top:20px; font-size:13px;">
用户：<input name="username" type="text" id="username">
&nbsp;&nbsp;
密码：<input name="password" type="password" id="password">
<button class="button button-small button-success" type="submit">登录</button>
<input type="hidden" name="act" value="user_login">
 </div>
<div style="position:fixed; bottom:5px; text-align:center; color:#999 ; width:100%"><?=$webcopyright?></div>
</form>
</body>
</html>
