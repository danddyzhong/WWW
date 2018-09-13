<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'apps_scpl')===false)exit("没有权限！");
if($act=="app_scpl_add"){
	
	app_scpl_add($title,$txt,$user,$dj);
	$id=$db->insert_id();
	$type='edit';
}else if($act=="app_scpl_edit"){
	app_scpl_edit($id,$title,$txt,$user,$dj);
}

$query=$db->query("select * from {$tablepre}apps_scpl where id='$id'");
if($db->num_rows($query)>0)$row=$db->fetch_row($query);
else {$row[user]=$_SESSION[admincp]; $row[dj]='1';}

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

<form action="?id=<?=$id?>&type=<?=$type?>" method="post" enctype="application/x-www-form-urlencoded">

  
<table class="table table-bordered table-hover definewidth m10">
          <tr>
            <td class="tableleft" style="width:80px;"> 等级：</td>
            <td><select name="dj" id="dj">
            <option value="<?=$row[dj]?>"><?=$row[dj]?>星</option>
              <option value="1">1星</option>
              <option value="2">2星</option>
              <option value="3">3星</option>
              <option value="4">4星</option>
              <option value="5">5星</option>
            </select></td>
          </tr>
          <tr>
            <td width="30" class="tableleft" style="width:80px;">标题：</td>
            <td><input name="title" type="text" id="title" value="<?=$row[title]?>"  /></td>
      </tr>
          <tr>
            <td class="tableleft">问题：</td>
            <td><textarea name="txt" id="txt" style="width:100%" class="xheditor {cleanPaste:0,height:'270',internalScript:true,inlineScript:true,linkTag:true,upLinkUrl:'../../upload/upload.php',upImgUrl:'../../upload/upload.php',upFlashUrl:'../../upload/upload.php',upMediaUrl:'../../upload/upload.php'}"><?=$row[txt]?></textarea></td>
          </tr>
          <tr>
            <td class="tableleft">发布人：</td>
            <td><input name="user" type="text" id="user" value="<?=$row[user]?>"  /></td>
          </tr>
    </table>

  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="app_scpl_<?=$type?>">
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

    <script type="text/javascript">
        BUI.use('bui/calendar',function(Calendar){
            var datepicker = new Calendar.DatePicker({
              trigger:'.calendar-time',
              showTime:true,
              autoRender : true
            });
        });
      </script>
</body>
</html>
