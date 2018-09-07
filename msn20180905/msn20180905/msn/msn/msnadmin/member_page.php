<?php 
error_reporting(0);
include_once("./../includes/common/common.php");
include_once(str_replace("\\", '/', dirname(__FILE__) ).'/../includes/db/db_connet.php');
$dbobj =new DbConnet();
$select="select * from msn_member_article limit 1";
$row = $dbobj->getRow($select);
if(empty($dopost)) $dopost = '';
$time =time();
if($dopost =='save'){
	if(!empty($row['id'])){
// 		$upquery = "update msn_member_article set body ='{$body}' where id ='{$row['id']}' ";
		$upquery = "update msn_member_article set body =? where id =? ";
		$param =array($body,intval($row['id']));
	}else{
// 		$upquery = "insert into msn_member_article (body,time) values ('{$body}','{$time}') ";
		$upquery = "insert into msn_member_article (body,time) values (':body',':time') ";
		$param=array(':body'=>$body,':time'=>$time);
	}
	//echo  $upquery;//exit;
	if($dbobj->query($upquery,$param)){
		
		ShowMsg("更新成功！","member_page.php",0,1000);
		exit();
	}else{
		ShowMsg("更新出错，请检查原因！","javascript:;",0,2000);
		exit();
	}
}
include("./templates/member_page.html");
exit;