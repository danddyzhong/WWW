<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sys_base')===false)exit("没有权限！");
if($act=="mobile_nav_add"){
	
	$db->query("insert into {$tablepre}mobile_tabs(title,txt,url,ov,rid,target,status)values('$title','$txt','$url','$ov','$rid','$target','$status')");
	$id=$db->insert_id();
	$type='edit';
}else if($act=="mobile_nav_edit"){
	$db->query("update {$tablepre}mobile_tabs set title='$title',txt='$txt',url='$url',ov='$ov',rid='$rid',target='$target',status='$status' where id='$id'");
}

$query=$db->query("select * from {$tablepre}mobile_tabs where id='$id'");
if($db->num_rows($query)>0)$row=$db->fetch_row($query);
else {$row[user]=$_SESSION[admincp]; }

function selectTarget($tag,$def){
    global $db,$tablepre;
    $str="<select name='{$tag}' id='{$tag}'><option value='{$def}'>{$def}-保持不变</option>
            <option value='blank'>blank-新窗口</option><option value='self'>self-直接跳转</option>
            <option value='iframe'>iframe-框架嵌入</option><option value='html'>html-嵌入源码</option>{$str}</select>";
    return $str;
}
function selectstatus($tag,$def){
    global $db,$tablepre;
    $str="<select name='{$tag}' id='{$tag}'><option value='{$def}'>{$def}-保持不变</option>
            <option value='1'>1-是</option><option value='0'>0-否</option>{$str}</select>";
    return $str;
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

<form action="?id=<?=$id?>&type=<?=$type?>" method="post" enctype="application/x-www-form-urlencoded">

  
<table class="table table-bordered table-hover definewidth m10">

          <tr>
            <td width="30" class="tableleft" style="width:80px;">标题：</td>
            <td><input name="title" type="text" id="title" value="<?=$row[title]?>"   class="input-large"/></td>
      </tr>
          <tr>
            <td class="tableleft">房间</td>
            <td><?=selectRooms1('rid',$row[rid])?></td>
          </tr>
          <tr>
            <td class="tableleft">排序</td>
            <td><input name="ov" type="text" id="ov" value="<?=$row[ov]?>"  /></td>
          </tr>
        <tr>
        <td class="tableleft">打开方式</td>
        <td><?=selectTarget('target',$row[target])?></td>
        </tr>
    <tr>
        <td class="tableleft">是否启用</td>
        <td><?=selectStatus('status',$row[status])?></td>
    </tr>
          <tr>
            <td class="tableleft">连接地址：</td>
            <td><input name="url" type="text" id="url" value="<?=$row[url]?>"  class="input-large"/></td>
          </tr>
    <tr>
        <td width="30" class="tableleft">内容：</td>
        <td><textarea name="txt" id="txt" style="width:100%;"  class="xheditor {cleanPaste:0,height:'150',internalScript:true,inlineScript:true,linkTag:true,upLinkUrl:'../../upload/upload.php',upImgUrl:'../../upload/upload.php',upFlashUrl:'../../upload/upload.php',upMediaUrl:'../../upload/upload.php'}"><?=tohtml($row[txt])?></textarea></td>
    </tr>
    </table>

  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="mobile_nav_<?=$type?>">
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
</body>
</html>
