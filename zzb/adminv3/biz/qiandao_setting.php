<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_qiandao')===false)exit("没有权限！");
if($act=="edit"){
	foreach($re as $k=>$v){
		$q_re=$v['re'];
		$q_num=$num[$k]['num'];
		$db->query("update  {$tablepre}config  set qiandao_re='$q_re',qiandao_num='$q_num' where id='$k'");
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/bui-min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/page-min.css" rel="stylesheet" type="text/css" />
<!-- 下面的样式，仅是为了显示代码，而不应该在项目中使用-->
<link href="../assets/css/prettify.css" rel="stylesheet" type="text/css" />
<style type="text/css">
code { padding: 0px 4px; color: #d14; background-color: #f7f7f9; border: 1px solid #e1e1e8; }
input,select{vertical-align:middle;}
.liw { width:160px; height:25px; line-height:25px;}
</style>
</head>
<body>
<div class="container" style="margin-bottom:50px;">
<form action="?act=edit" method="post" enctype="application/x-www-form-urlencoded">
  <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"><strong>房间签到设置</strong></div>
<table class="table table-bordered table-hover definewidth m10">
<?php
$q=$db->query("select id,qiandao_re,qiandao_num,title from {$tablepre}config  order by id ");
$qdre["gold"]="金币";
$qdre["money"]="红包";
while($row=$db->fetch_row($q)){
	echo "<tr><td class='tableleft'  width='250' ><div style='width:250px; height:20px;     overflow: hidden;'>房间ID{$row[id]}：{$row[title]}</div></td><td>
	奖励: <select name='re[{$row[id]}][re]' style='width:70px;'><option value='{$row[qiandao_re]}'>".$qdre[$row[qiandao_re]]."</option><option value='gold'>金币</option><option value='money'>红包</option></select>
	数额：<input name=\"num[{$row[id]}][num]\" type='text' value='{$row[qiandao_num]}'> * 续签递增
	</td></tr>";
}
?>

</table>
 <div>
    <button type="submit"  class="button button-success">提交设置</button>
</div>
  </ul>
 
</form>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script> 
<script>
    BUI.use('bui/calendar',function(Calendar){
          var datepicker = new Calendar.DatePicker({
            trigger:'.calendar',
			dateMask : 'yyyy-mm-dd',
            autoRender : true
          });
        });

</script>
</body>
</html>
