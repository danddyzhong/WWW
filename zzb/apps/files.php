<?php
require_once '../include/common.inc.php';
function app_files_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_files";
	if($key!="")$sql.=" where title like '%$key%'   or `user` like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}

switch($act){
	case "files_add":
		$user=$_SESSION['login_user'];
		$db->query("insert into {$tablepre}apps_files(title,url,`user`,atime)values('$title','$url','$user','".gdate()."')");
		$str="<font style='border-bottom:1px solid #999; color:red;font-size:14px;'>[添加共享资料]</font><br> {$title} …… [<font style='color:red;  cursor:pointer' onClick='$(\\\"#app_5\\\").trigger(\\\"click\\\")'>详细</font>]";
		exit('<script>top.app_sendmsg("'.$str.'");location.href="?"</script>');
	break;
}
$sql="select * from {$tablepre}apps_files";
if($id!="")$sql.=" where id='$id'";
else $sql.=" limit 1";
$row=$db->fetch_row($db->query($sql));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>共享文档</title>
</head>


<style type="text/css">
/* CSS Document */
body {
 font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 color: #4f6b72;
}
a {
 color: #c75f3e;
}
table {
 width: 100%;
 padding: 0;
 margin: 0;
}
caption {
 padding: 0 0 5px 0;
 width: 700px; 
 font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 text-align: right;
}
th {
 font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 color: #4f6b72;
 border-right: 1px solid #C1DAD7;
 border-bottom: 1px solid #C1DAD7;
 border-top: 1px solid #C1DAD7;
 letter-spacing: 2px;
 text-transform: uppercase;
 text-align:center;
 padding: 6px 6px 6px 12px;
 background: #CAE8EA ;
}
th.nobg {
 border-top: 0;
 border-left: 0;
 border-right: 1px solid #C1DAD7;
 background: none;
}
td {
 border-right: 1px solid #C1DAD7;
 border-bottom: 1px solid #C1DAD7;
 font-size:11px;
 padding: 6px 6px 6px 12px;
 color: #4f6b72;
}

td.alt {
 background: #F5FAFA;
 color: #797268;
}
th.spec {
 border-left: 1px solid #C1DAD7;
 border-top: 0;
 background: #fff ;
 font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
}
th.specalt {
 border-left: 1px solid #C1DAD7;
 border-top: 0;
 background: #f5fafa ;
 font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 color: #797268;
}
tr{ background: #fff }
tr:hover{background: #f5fafa}
tr:hover td {background:none;}
</style>
<body>
<script>
Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
function ftime(time){
	return new Date(time*1000).Format("yyyy-MM-dd hh:mm");
}
</script>

<?php

if(check_auth('files_add')){
?>
<form action="?act=files_add" method="post" enctype="application/x-www-form-urlencoded">
<table width="100%" cellspacing="0" id="files_add"  style="border-left: 1px solid #C1DAD7;border-top: 1px solid #C1DAD7; margin-bottom:5px; display:none ">
          <tr>
            <td class="tableleft" style="width:80px;">标题：</td>
            <td><input name="title" type="text" id="title"  style="width:98%" value=""></td>
          </tr>
          <tr>
            <td width="30" class="tableleft" style="width:80px;">附件：</td>
            <td><input name="url" type="text" id="url"  /> *当前服务器允许上传最大<?=ini_get('upload_max_filesize');?><br><br>
            <button  type="button" class="button button-mini button-success" ><span id="url_bt"></span></button></td>
      </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="发布"></td>
          </tr>
    </table>
</form>
<div style="margin:5px 0px;"><button onClick="document.getElementById('files_add').style.display=''">发布共享文档</button></div>
<?php
}
if(check_auth('files_view')){
?>
    
<table width="100%" cellspacing="0" id="mytable">

      <tr  >
        <th width="30" align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">编号</th>
        <th  align="left" bgcolor="#FFFFFF">共享名称</th>
        <th width="100"  align="left" bgcolor="#FFFFFF">发布人</th>
  </tr>
      

<?php
echo app_files_list(20,$key,'
    <tr>
    <td align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">{id}</td>
      <td align="left" bgcolor="#FFFFFF">{title}<a href="{url}" target="_blank">下载</a></td>
      <td>{user}</td>
    </tr>
')?>



</table>
<div style="height:30px; line-height:30px;"><?=$pagenav?></div>
<?php
}else{
	echo "<script>top.layer.msg('没有权限查看共享文档！请联系客服！');</script>";
}
?>
<script type="text/javascript" src="../xheditor/jquery/jquery-1.4.4.min.js"></script> 
<script type="text/javascript" src="../upload/swfupload/swfupload.js"></script> 
<script>
  function swfupload_ok(fileObj,server_data){
	 
	 var data=eval("("+server_data+")") ;
	 $("#"+data.msg.info).val(data.msg.url);
  }
  $(function(){


  var swfdef={
	  // 按钮设置
	    file_post_name:"filedata",
		button_width: 30,
		button_height: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		button_text: '上传',
		button_text_style: ".upbnt{ }",
		button_text_left_padding: 0,
		button_text_top_padding: 0,
		upload_success_handler : swfupload_ok,
		file_dialog_complete_handler:function(){this.startUpload();},
		file_queue_error_handler:function(){alert("选择文件错误");}
		}
  swfdef.flash_url="../upload/swfupload/swfupload.swf";
  swfdef.button_placeholder_id="url_bt";
  swfdef.file_types="*.zip;*.rar";
  swfdef.upload_url="../upload/upload.php";
  swfdef.post_params={"info":"url"}
  
  swfu = new SWFUpload(swfdef);
  
  var swfico=swfdef;
  swfico.button_placeholder_id="ico_up_bnt";
  swfico.file_types="*.ico";
  swfico.post_params={"info":"ico"}
  swfuico = new SWFUpload(swfico);
  
  var swfbg=swfdef;
  swfbg.button_placeholder_id="bg_up_bnt";
  swfbg.file_types="*.gif;*.jpg;*.png";
  swfbg.post_params={"info":"bg"}
  swfubg = new SWFUpload(swfbg);
  


	  
});


</script>
</body>
</html>

