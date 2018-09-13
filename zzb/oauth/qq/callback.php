<?php
include '../../include/common.inc.php';
require_once("API/qqConnectAPI.php");
$qc = new QC();

$acs = $qc->qq_callback();//callback主要是验证 code和state,返回token信息，并写入到文件中存储，方便get_openid从文件中度  
$oid = $qc->get_openid();//根据callback获取到的token信息得到openid,所以callback必须在openid前调用  
$qc = new QC($acs,$oid);  

$user_info=$qc->get_user_info();
$user_info[openid]=$oid;

 


if($user_info[ret] =="0") {
		$token=$user_info[openid];
		$username=$user_info[nickname];
		$password=$user_info[openid];
		$img=$user_info[figureurl_qq_1];
		$oauth=user_login_oauth($token);
		//@file_put_contents(PPCHAT_ROOT."/log.txt",json_encode($user_info));
		if($oauth){
			header("location:/?rid=".$_SESSION['rid']);
		}else{
			user_reg_oauth($token,$username,$img);
			header("location:/?rid=".$_SESSION['rid']);
		}		
	}
	else{
		header("location:/?rid=".$_SESSION['rid']);
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$cfg['config']['title']?> QQ登录</title>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="default">
</head>

<body>
<?=$msg?>
</body>
</html>
