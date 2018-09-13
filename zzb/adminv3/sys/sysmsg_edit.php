<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sysmsg')===false)exit("没有权限！");
if($act=="sysmsg_add"){
	$db->query("insert into {$tablepre}sysmsg(txt,`type`,rid) values('$txt','$ntype','$rid')");
	$id=$db->insert_id();
	$type='edit';
}else if($act=="sysmsg_edit"){
	$db->query("update {$tablepre}sysmsg set txt='$txt',`type`='$ntype',`rid`='$rid' where id='$id'");
}

$query=$db->query("select * from {$tablepre}sysmsg where id='$id'");
if($db->num_rows($query)>0)$row=$db->fetch_row($query);
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
<!-- <link href="../assets/css/prettify.css" rel="stylesheet" type="text/css" /> -->
<style type="text/css">
code { padding: 0px 4px; color: #d14; background-color: #f7f7f9; border: 1px solid #e1e1e8; }
input,select{vertical-align:middle;}
.liw { width:160px; height:25px; line-height:25px;}
</style>
</head>
<body>
<div class="container" style="margin-bottom:50px;">

<form action="?id=<?=$id?>&type=<?=$type?>" method="post" enctype="application/x-www-form-urlencoded">

  
<table class="table table-bordered table-hover definewidth m10">
          <tr>
            <td class="tableleft">类型：</td>
            <td><select name="ntype" id="ntype">
      <option value="<?=$row[type]?>"><?=$row[type]?>保持不变</option>
      <option value="0">0系统消息</option>
      <option value="1">1置顶公告</option>
      <option value="2">2管理提示</option>
    </select></td>
          </tr>
          <tr>
            <td class="tableleft">类型：</td>
            <td><?=selectRooms1('rid',$row[rid])?></td>
          </tr>
          <tr>
            <td width="50" class="tableleft">内容：</td>
            <td><textarea name="txt" id="txt" style="width:100%;"  class="xheditor {cleanPaste:0,height:'350',internalScript:true,inlineScript:true,linkTag:true,upLinkUrl:'../../upload/upload.php',upImgUrl:'../../upload/upload.php',upFlashUrl:'../../upload/upload.php',upMediaUrl:'../../upload/upload.php'}"><?=tohtml($row[txt])?></textarea></td>
      </tr>
    </table>

  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onClick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="sysmsg_<?=$type?>">
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="hidden" name="type" value="<?=$type?>">
</div>
  </form>

</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script type="text/javascript" src="../../xheditor/xheditor.js"></script>
<script type="text/javascript" src="../../xheditor/xheditor_lang/zh-cn.js"></script>
<script>

</script>
</body>
</html>
