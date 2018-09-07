<?php
include(str_replace("\\", '/', dirname(__FILE__) ).'./../includes/common/common.php');
include(str_replace("\\", '/', dirname(__FILE__) ).'./../includes/userlogin.class.php');
try{
	error_reporting(0);
// 	ini_set("display_errors",true);
$admindirs = explode('/',str_replace("\\",'/',dirname(__FILE__)));
$admindir = $admindirs[count($admindirs)-1];
if($dopost =='login'){

	$validate = empty($validate) ? '' : strtolower(trim($validate));
	$svali = strtolower(GetCkVdValue());
	
	if(($validate=='' || $validate != $svali)){
		ResetVdValue();
		ShowMsg('验证码不正确!','login.php',0,1000);
		exit;
	}else{
		$cuserLogin = new userLogin($admindir);
		$res = $cuserLogin->checkUser($userid,$pwd);
	 //success
            if($res==1)
            {   
                $cuserLogin->keepUser();
                if(!empty($gotopage))
                {
                    ShowMsg('成功登录，正在转向管理管理主页！',$gotopage);
                    exit();
                }
                else
                {
                    ShowMsg('成功登录，正在转向管理管理主页！',"index.php");
                    exit();
                }
            }

            //error
            else if($res==-1)
            {
                ResetVdValue();
				ShowMsg('你的用户名不存在!','login.php',0,1000);
				exit;
            }
            else
            {
                ResetVdValue();
                ShowMsg('你的密码错误!','login.php',0,1000);
				exit;
            }
	}
}
}catch(Exception $e){
	echo $e->getMessage();
	exit;
}
include("./templates/login.html");