<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'users_rebots')===false)exit("没有权限！");
if($act=="rebots_edit"){
	$db->query("update {$tablepre}apps_rebots set name='$name',img='$img',gid='$gid',weeks='$weeks',hl='$hl',ol='$ol',fuser='$fuser' where id='$id' ");
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
	<?php
	$query=$db->query("select * from {$tablepre}auth_group where id in(17,16,15,14,13,12,11,1,0) order by id desc");
	while($row=$db->fetch_row($query)){
		$group.='<option value="'.$row[id].'">GID:'.$row[id].'-'.$row[title].'</option>';
	}
	/*
  if(stripos(auth_group($_SESSION['login_gid']),'users_group')===false){
      $group='';
  }
  */
	$query=$db->query("select * from {$tablepre}apps_rebots where  id='$id'");
	echo for_each($query,'
<form action="?id={id}" method="post" enctype="application/x-www-form-urlencoded">
  <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"> </div>
<table class="table table-bordered table-hover definewidth m10">
		  <tr>
            <td width="80" class="tableleft" style="width:70px;">昵称：</td>
            <td><input name="name" type="text" id="name" style="width:350px;" value="{name}"/></td>
          </tr>
          <tr>
            <td width="80" class="tableleft" style="width:70px;">头像：</td>
            <td><input name="img" type="text" id="img" style="width:350px;" value="{img}"/>
			
			<br><select onchange="$(\'#img\').val(this.value);">
				<option value="/face/rebot/10.gif">选择头像</option>
				<option value="/face/rebot/10.gif">/face/rebot/10.gif</option>
				<option value="/face/rebot/11.gif">/face/rebot/11.gif</option>
				<option value="/face/rebot/12.gif">/face/rebot/12.gif</option>
				<option value="/face/rebot/13.gif">/face/rebot/13.gif</option>
				<option value="/face/rebot/14.gif">/face/rebot/14.gif</option>
				<option value="/face/rebot/15.gif">/face/rebot/15.gif</option>
				<option value="/face/rebot/16.gif">/face/rebot/16.gif</option>
				<option value="/face/rebot/17.gif">/face/rebot/17.gif</option>
				<option value="/face/rebot/18.gif">/face/rebot/18.gif</option>
				<option value="/face/rebot/19.gif">/face/rebot/19.gif</option>
				<option value="/face/rebot/20.gif">/face/rebot/20.gif</option>
			</select>
			<button  type="button" class="button button-mini button-success"><span id="logo_up_bnt"></span></button>
			
			</td>
          </tr>
          <tr>
            <td width="80" class="tableleft">用 户 组：</td>
            <td><select name="gid" id="gid" >
			<option value="{gid}">GID:{gid}</option>
              '.$group.'
            </select>&nbsp;</td>
          </tr>
          <tr>
            <td width="80" class="tableleft">所属用户：</td>
            <td><input name="fuser" type="text" id="fuser" style="width:350px;" value="{fuser}"/></td>
          </tr>
          <tr>
            <td width="80" class="tableleft">上线时间：</td>
            <td><input name="weeks" type="text" id="weeks" style="width:350px;" value="{weeks}"/>
              <br>
            星期（0,1,2,3,4）<br></td>
          </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td>上线时间<input name="hl" type="text" id="hl" class="calendar calendar-time" value="{hl}"/></td>
          </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td>离线时间<input name="ol" type="text" id="ol" class="calendar calendar-time"  value="{ol}"/></td>
          </tr>
        </table>

  </ul>
  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="rebots_edit">
	<input type="hidden" name="id" value="{id}">
</div>
  </form>
')?>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bui.js"></script>
<script type="text/javascript" src="../assets/js/config.js"></script>
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script>
<script>
	BUI.use('bui/calendar',function(Calendar){
		var datepicker = new Calendar.DatePicker({
			trigger:'.calendar',
			dateMask : 'HH:MM:ss',
			autoRender : true,
			showTime : true
		});
	});
	BUI.use('common/page');

	function swfupload_ok(fileObj,server_data){

		var data=eval("("+server_data+")") ;
		$("#"+data.msg.info).val(data.msg.url);
	}
	$(function(){


		var swfdef={
			// 按钮设置
			file_post_name:"filedata",
			button_width: 60,
			button_height: 18,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			button_text: '上传头像',
			button_text_style: ".upbnt{ color:#00F}",
			button_text_left_padding: 0,
			button_text_top_padding: 0,
			upload_success_handler : swfupload_ok,
			file_dialog_complete_handler:function(){this.startUpload();},
			file_queue_error_handler:function(){alert("选择文件错误");}
		}
		swfdef.flash_url="../../upload/swfupload/swfupload.swf";
		swfdef.button_placeholder_id="logo_up_bnt";
		swfdef.file_types="*.gif;*.jpg;*.png";
		swfdef.upload_url="../../upload/upload.php";
		swfdef.post_params={"info":"img"}

		swfu = new SWFUpload(swfdef);
	});

</script>
</body>
</html>
