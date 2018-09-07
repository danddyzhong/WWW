<?php 
error_reporting(0);
include_once("./../includes/common/common.php");
include_once(str_replace("\\", '/', dirname(__FILE__) ).'/../includes/db/db_connet.php');
$dbobj =new DbConnet();
// $row = $dbobj->getRow('msn_index_article');
$select ="select * from msn_index_article limit 1";
$row = $dbobj->getRow($select);
if(empty($dopost)) $dopost = '';
if($dopost =='save'){
	//$upquery = "update msn_index_article set body ='{$body}' where id ='{$row['id']}' ";
	$upquery = "update msn_index_article set body =? where id =? ";
	$param=array($body,intval($row['id']));
	if($dbobj->query($upquery,$param)){
		ShowMsg("更新成功！","web_index.php",0,1000);
		exit();
	}else{
		ShowMsg("更新出错，请检查原因！","web_index.php",0,2000);
		exit();
	}
}
include("./templates/web_index.html");
exit;