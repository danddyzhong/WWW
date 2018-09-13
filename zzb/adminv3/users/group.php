<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'users_group')===false)exit("没有权限！");
switch($act){
	case "group_add":
		group_add($title,$sn,$ico,$ov);
	break;
	case "group_del":
		group_del($id);
	break;
	case "group_edit":
		group_edit($id,$title,$sn,$ico,$ov);
	break;
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
</style>
   </head>
   <body>
<div class="container" style=" min-width:700px;">
     <ul class="breadcrumb">
    <li class="active">
         <button type="submit"  class="button button-success" id="add_group_bt"><i class="icon icon-plus icon-white"></i> 添加</button>
         &nbsp;&nbsp;</li>
  </ul>
     <table  class="table table-bordered table-hover definewidth m10" >
    <thead>
         <tr style="font-weight:bold" >
        <td width="50" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="150" align="center" bgcolor="#FFFFFF">分组名称</td>
        <td align="center" bgcolor="#FFFFFF">分组描述</td>
        <td width="60" align="center" bgcolor="#FFFFFF">列表排序</td>
        <td width="120" align="center" bgcolor="#FFFFFF">分组图标</td>
        <td width="230" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
       </thead>
    <form method="post" enctype="application/x-www-form-urlencoded">
         <tr id="act_group" style="display:none">
        <td align="center" valign="middle" bgcolor="#FFFFFF"><span class="label label-info" id="actstate">Info</span></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="title" type="text" id="title"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="sn" type="text" id="sn" style="width:400px;"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="ov" type="text" id="ov" style="width:40px;"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><button class="button button-mini button-danger"  id="group_up_bnt">上传</button>
             <input type="hidden" id="ico" name="ico">
             <input type="hidden" id="act" name="act">
             <input type="hidden" id="id" name="id">
             <img src="" style="border:0px; height:20px; float:left" id="ico_src"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><button class="button   button-success" id="act_group_sub" type="submit"><i class="x-icon icon-ok icon-white"></i> 确定</button></td>
      </tr>
       </form>
<?php
$query=$db->query("select * from {$tablepre}auth_group order by id desc");
while($row=$db->fetch_row($query)){
?>      
    <tr>
         <td bgcolor="#FFFFFF" align="center"><?=$row[id]?></td>
         <td bgcolor="#FFFFFF" align="center"><?=$row[title]?>&nbsp; </td>
         <td align="center" bgcolor="#FFFFFF"><?=$row[sn]?>&nbsp; </td>
         <td align="center" bgcolor="#FFFFFF"><?=$row[ov]?>&nbsp;</td>
         <td bgcolor="#FFFFFF" align="center"><img src="<?=$row[ico]?>" style="border:0px; height:20px; float:left" id="ico_src"/></td>
         <td bgcolor="#FFFFFF" align="center">
         <button class="button button-mini button-warning" <?php if($row[id]==1){echo "style='display:none;'"; } ?>onClick="openRule('<?=$row[id]?>','<?=$row[type]?>')"><i class="x-icon x-icon-small icon-check icon-white"></i>权限</button>
         <button class="button button-mini button-primary" onClick="openGroupUser('<?=$row[id]?>','<?=$row[title]?>')"><i class="x-icon x-icon-small icon-user icon-white"></i>成员</button>
        <button class="button button-mini button-info"  onClick="group_edit_bt('<?=$row[id]?>','<?=$row[title]?>','<?=$row[sn]?>','<?=$row[ico]?>','<?=$row[ov]?>')"><i class="x-icon x-icon-small icon-wrench icon-white"></i>修改</button>
        <button class="button button-mini button-danger" onclick="if(confirm('删除后所属用户转为普通用户，是否继续？'))location.href='?act=group_del&id=<?=$row[id]?>'" <?php if(in_array($row[id],array('0','1','2','3','4')))echo "style='display:none'"?>><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
    </tr>
<?php }?>       
  </table>
     <div class="row">
    
  </div>
   </div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script> 
<script>
BUI.use('bui/overlay',function(Overlay){
            dialog = new Overlay.Dialog({
            title:'用户组权限编辑',
            width:800,
            height:600,
            buttons:[],
            bodyContent:''
          });
});
function openRule(id,type){
	dialog.set('bodyContent','<iframe src="group_rule.php?id='+id+'&type='+type+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}
function openGroupUser(id,name){
	top.topManager.openPage({
		id : 'GroupUser'+id,
		href : 'users/users.php?gid='+id,
		title : name+' 成员'
	  });
	top.topManager.reloadPage();
}


  function group_edit_bt(id,title,sn,ico,ov){
  		$("#act").val("group_edit");
		$("#act_group").show();
		$("#sn").val(sn);
		$("#title").val(title);
		$("#ico").val(ico);
		$("#id").val(id);
		$("#ov").val(ov);
		$("#ico_src").attr("src",ico);
		$("#actstate").html("修改");
  }
  function swfupload_ok(fileObj,server_data){
	 var data=eval("("+server_data+")") ;
	 $('#ico').val(data.msg.url);
	 $('#ico_src').attr("src",data.msg.url);
	 //alert(data.msg.url);
  }
  $(function(){


  var swfdef={
	  // 按钮设置
	    file_post_name:"filedata",
		button_width: 35,
		button_height: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		button_text: '<span class="upbnt">上传</span>',
		button_text_style: ".upbnt{ color:#00F}",
		button_text_left_padding: 0,
		button_text_top_padding: 0,
		upload_success_handler : swfupload_ok,
		file_dialog_complete_handler:function(){this.startUpload();},
		file_queue_error_handler:function(){alert("选择文件错误");}
		}
  swfdef.flash_url="../../upload/swfupload/swfupload.swf";
  swfdef.button_placeholder_id="group_up_bnt";
  swfdef.file_types="*.gif;*.jpg;*.png";
  swfdef.upload_url="../../upload/upload.php";
  
  swfu = new SWFUpload(swfdef);
  $("#add_group_bt").on("click",function(){
		$("#act_group").toggle();
		$("#act").val("group_add");
		$("#sn").val("");
		$("#title").val("");
		$("#ico").val("");
		$("#ico_src").attr("src","");
		$("#actstate").html("添加");
  });


	  
});

  </script>
</body>
</html>
