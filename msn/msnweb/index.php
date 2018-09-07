<?php 
error_reporting(0);
include_once("./../includes/common/common.php");
include_once(str_replace("\\", '/', dirname(__FILE__) ).'/../includes/db/db_connet.php');
session_start();
$dbobj =new DbConnet();
$select ="select * from msn_index_article limit 1";
$row = $dbobj->getRow($select);
include("./webhtml/index.html");