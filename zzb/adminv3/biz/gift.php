<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_gift')===false)exit("没有权限！");
switch($act){
	case "gift_add":
		gift_add($name,$msg,$ico,$price,$gif);
	break;
	case "gift_del":
		gift_del($id);
	break;
	case "gift_edit":
		gift_edit($id,$name,$msg,$ico,$price,$gif);
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
        <td width="150" align="center" bgcolor="#FFFFFF">礼物名称</td>
        <td align="center" bgcolor="#FFFFFF">默认赠言</td>
        <td width="60" align="center" bgcolor="#FFFFFF">售价</td>
        <td width="60" align="center" bgcolor="#FFFFFF">售出</td>
        <td width="120" align="center" bgcolor="#FFFFFF">图标</td>
		<td width="120" align="center" bgcolor="#FFFFFF">动图</td>
        <td width="120" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
       </thead>
    <form method="post" enctype="application/x-www-form-urlencoded">
         <tr id="act_group" style="display:none">
        <td align="center" valign="middle" bgcolor="#FFFFFF"><span class="label label-info" id="actstate">Info</span></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="name" type="text" id="name"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="msg" type="text" id="msg" style="width:400px;" maxlength="100"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="price" type="text" id="price" style="width:40px;"/></td>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><button class="button button-mini button-danger"  id="group_up_bnt">上传</button>
             <input type="hidden" id="ico" name="ico">
             <input type="hidden" id="act" name="act">
             <input type="hidden" id="id" name="id">
             <img src="" style="border:0px; height:20px; float:left" id="ico_src"/></td>
		<td align="center" valign="middle" bgcolor="#FFFFFF"><button class="button button-mini button-danger"  id="group_up_bnt_gif">上传</button>
             <input type="hidden" id="gif" name="gif">
			 <img src="" style="border:0px; height:20px; float:left" id="gif_src"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><button class="button   button-success" id="act_group_sub" type="submit"><i class="x-icon icon-ok icon-white"></i> 确定</button></td>
      </tr>
       </form>
<?php
$query=$db->query("select * from {$tablepre}gift_goods order by id desc");
while($row=$db->fetch_row($query)){
?>      
    <tr>
         <td bgcolor="#FFFFFF" align="center"><?=$row[id]?></td>
         <td bgcolor="#FFFFFF" align="center"><?=$row[name]?>&nbsp; </td>
         <td align="center" bgcolor="#FFFFFF"><?=$row[msg]?>&nbsp; </td>
         <td align="center" bgcolor="#FFFFFF"><?=$row[price]?>&nbsp;</td>
         <td bgcolor="#FFFFFF" align="center"><?=$row[sale]?>&nbsp;</td>
         <td bgcolor="#FFFFFF" align="center"><img src="<?=$row[img]?>" style="border:0px; height:20px; float:left" id="ico_src"/></td>
		 <td bgcolor="#FFFFFF" align="center"><img src="<?=$row[gif]?>" style="border:0px; height:20px; float:left" id="ico_src_gif"/></td>
         <td bgcolor="#FFFFFF" align="center">
        <button class="button button-mini button-info"  onClick="gift_edit_bt('<?=$row[id]?>','<?=$row[name]?>','<?=$row[msg]?>','<?=$row[img]?>','<?=$row[price]?>')"><i class="x-icon x-icon-small icon-wrench icon-white"></i>修改</button>
        <button class="button button-mini button-danger" onclick="if(confirm('确定删除？'))location.href='?act=gift_del&id=<?=$row[id]?>'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
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



  function gift_edit_bt(id,name,msg,ico,price){
  		$("#act").val("gift_edit");
		$("#act_group").show();
		$("#msg").val(msg);
		$("#name").val(name);
		$("#ico").val(ico);
		$("#id").val(id);
		$("#price").val(price);
		$("#ico_src").attr("src",ico);
		$("#actstate").html("修改");
  }
  function swfupload_ok(fileObj,server_data){
	 var data=eval("("+server_data+")") ;
	 $('#'+data.msg.info).val(data.msg.url);
	 $("#"+data.msg.info+"_src").attr("src",data.msg.url);
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
  swfdef.post_params={"info":"ico"}  
  swfu = new SWFUpload(swfdef);
  
  var swfgif=swfdef;
  swfgif.button_placeholder_id="group_up_bnt_gif";
  swfgif.post_params={"info":"gif"}
  swfu_gif = new SWFUpload(swfgif);
  
  $("#add_group_bt").on("click",function(){
		$("#act_group").toggle();
		$("#act").val("gift_add");
		$("#msg").val("");
		$("#name").val("");
		$("#price").val("");
		$("#ico").val("");
		$("#ico_src").attr("src","");
		$("#actstate").html("添加");
  });


	  
});

  </script>
</body>
</html>
