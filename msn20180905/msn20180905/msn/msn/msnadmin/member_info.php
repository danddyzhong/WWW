<?php 
error_reporting(0);
include_once("./../includes/common/common.php");
include_once(str_replace("\\", '/', dirname(__FILE__) ).'/../includes/db/db_connet.php');
$dbobj =new DbConnet();
$select ="select phone_number,ip_address,create_time from msn_member order by id desc ";
$allRows =$dbobj->getAllRows($select);
if(!empty($allRows)){
	$memberStr='';
	$memberStr='<table class="mtb"><tr><td>序号</td><td>电话号码</td><td>ip地址</td><td>注册时间</td></tr>';
	$num =1;
		foreach( $allRows as $key =>$val ){
			$date =date("Y-m-d H:i",$val['create_time']);
			$memberStr .="<tr><td>".$num."</td><td>".$val['phone_number']."</td><td>".$val['ip_address']."</td><td>".$date."</td></tr>";
			$num++;
		}
	$memberStr .="</table>";
}
include("./templates/member_info.html");
exit;
