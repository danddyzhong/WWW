<?php
@session_id($_COOKIE['PHPSESSID']);
@session_start();
//载入ucpass类
error_reporting(0);
require_once('lib/Xigu.class.php');
require_once('serverSid.php');
require_once('./../includes/common/common.php');
include_once(str_replace("\\", '/', dirname(__FILE__) ).'/../includes/db/db_connet.php');
ob_end_clean();
$templateid = "127";    //可在后台短信产品→选择接入的应用→短信模板-模板ID，查看该模板ID
//$param = $_POST['yzm']; //多个参数使用英文逗号隔开（如：param=“a,b,c”），如为参数则留空
if(empty($yzmtel)) $yzmtel='';
$mobile = $yzmtel;
$dbobj =new DbConnet();
$select ="select * from msn_member where phone_number =:phone_number";
$param = array(':phone_number'=>$yzmtel);
$row =$dbobj->getRow($select,$param);
if(!empty($row['phone_number'])){
	$data['exist'] ='y';
	echo json_encode($data);
	exit;
}
$_SESSION['time']=time();
function makeCode(){
	$code='';
	for($i=0;$i<4;$i++){
		$code .=rand(0,9);
	}
	return $code;
}
$code=makeCode();
$_SESSION['code']=$code;
$param=$code.',5';
//70字内（含70字）计一条，超过70字，按67字/条计费，超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
echo $xigu->SendSms($templateid,$param,$mobile);
