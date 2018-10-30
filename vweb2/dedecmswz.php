<html>
<head>
<!-- 说明：获取织梦、discuz、帝国程序最新文章。  2017.6.23     skype：666  -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<ol> 
<?php
if(file_exists(dirname(__FILE__).'/data/common.inc.php'))
{

	require_once (dirname(__FILE__) . "/include/common.inc.php");
    //最新文章
	$dsql->SetQuery("Select title,senddate From `#@__archives` where  arcrank = 0 order by id desc limit 0,3");
	$dsql->Execute();
	while($row=$dsql->GetArray())
	{ ?>
   <li> <?php echo $row['title'];echo "&nbsp;&nbsp;&nbsp;";echo date("Y-m-d",$row['senddate']);?></li><br>
   <?php 
    } 
   $dsql->Close(); 
// exit();
}
elseif(file_exists(dirname(__FILE__).'/e/config/config.php'))	
  {
   require_once(dirname(__FILE__).'/e/class/connect.php');
   require_once(dirname(__FILE__).'/e/class/db_sql.php');
   $link=db_connect();
   $empire=new mysqlquery();
    //最新文章
   $st=$empire->query("select title,truetime from `{$dbtbpre}ecms_news` where havehtml=1 order by id desc limit 0,3 ");
   while($st_r=$empire->fetch($st))
	{ ?>
   <li> <?php echo $st_r['title'];echo "&nbsp;&nbsp;&nbsp;";echo date("Y-m-d",$st_r['truetime']);?></li><br>
   <?php 
    } 
   db_close(); 
   $empire =null; 
// exit();
  }
elseif(file_exists(dirname(__FILE__).'/config/config_global.php'))
  {
   require_once('/source/class/class_core.php');
   $discuz = C::app();
   $discuz->init();
    //最新文章
   $rs = DB::query("select subject,dateline from ".DB::table("forum_thread")." order by tid desc limit 0,3 ");
   while($rw = DB::fetch($rs))
	{ ?>
   <li> <?php echo $rw['subject'];echo "&nbsp;&nbsp;&nbsp;";echo date("Y-m-d",$rw['dateline']);?></li><br>
   <?php 
    } 
//exit();
   }
else{
	 echo "获取程序失败";
     exit();
     }
?>
</ol>
</body>
</html>