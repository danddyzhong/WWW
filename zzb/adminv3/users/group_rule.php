<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'users_group')===false)exit("没有权限！");
if($act=="group_rules_edit"){
	group_rules_edit($id,implode(',',$rule));
}
$rules="";
$query=$db->query("select * from {$tablepre}auth_group where id='$id'");
while($row=$db->fetch_row($query)){
	$rules=$row['rules'];
}
$rules=explode(',',$rules);
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
<form action="?id=<?=$id?>" method="post" enctype="application/x-www-form-urlencoded">
  <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"><strong>后台权限</strong></div>
<?php
// var_dump($rules);
$query=$db->query("select * from {$tablepre}auth_rule where type=0 order by rulename desc");
while($row=$db->fetch_row($query)){
	if(in_array($row[rulename],$rules))$checked=" checked='CHECKED'";
	else $checked="";
?>  
    <li class="active liw">
      <label><input type="checkbox" name="rule[]" value="<?=$row[rulename]?>" <?=$checked?>><?=$row[title]?></label>
    </li>
<?php }?>
  </ul>
  
    <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"><strong>前台权限</strong></div>
<?php
$query=$db->query("select * from {$tablepre}auth_rule where type=1 order by rulename desc");
while($row=$db->fetch_row($query)){
	if(in_array($row[rulename],$rules))$checked=" checked='CHECKED'";
	else $checked="";
?>  
    <li class="active liw">
      <label><input type="checkbox" name="rule[]" value="<?=$row[rulename]?>" <?=$checked?>><?=$row[title]?></label>
    </li>
<?php }?>
  </ul>
  
  
  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="group_rules_edit">
  </div>
  </form>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script> 
<script>

</script>
</body>
</html>
