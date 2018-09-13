<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_order')===false)exit("没有权限！");
switch($act){
	case "payitem_add":
		payitem_add($sn,$gold,$vip_lv,$vip_expire,$rmb);
	break;
	case "payitem_del":
		payitem_del($id);
	break;
	case "payedit_edit":
		payitem_edit($id,$sn,$gold,$vip_lv,$vip_expire,$rmb);
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
        
        <td width="200" align="center" bgcolor="#FFFFFF">商品名称</td>
        
        <td width="70" align="center" bgcolor="#FFFFFF">售价（元）</td>
        <td align="center" bgcolor="#FFFFFF">金币</td>
        <td width="250" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
       </thead>
    <form method="post" enctype="application/x-www-form-urlencoded">
         <tr id="act_group" style="display:none">
        <td align="center" valign="middle" bgcolor="#FFFFFF"><span class="label label-info" id="actstate">Info</span></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="sn" type="text" id="sn" style="width:90%"/></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="rmb" type="text" id="rmb" style="width:80px;"/>
             </td>
        <td align="center" valign="middle" bgcolor="#FFFFFF">
		<!--
		VIP等级：
		<input name="vip_lv" type="text" id="vip_lv"/>
         &nbsp; VIP等级有天数：
          <input name="vip_expire" type="text" id="vip_expire"  />-->
		  <input name="vip_lv" type="hidden" id="vip_lv"/>
          <input name="vip_expire" type="hidden" id="vip_expire"  />
          &nbsp; 虚拟币：
          <input name="gold" type="text" id="gold"/></td>
        
        <td align="center" valign="middle" bgcolor="#FFFFFF"><input type="hidden" id="act" name="act">
             <input type="hidden" id="id" name="id"><button class="button   button-success" id="act_group_sub" type="submit"><i class="x-icon icon-ok icon-white"></i> 确定</button></td>
      </tr>
       </form>
<?php
$query=$db->query("select * from {$tablepre}payitem order by id desc");
while($row=$db->fetch_row($query)){
?>      
    <tr>
         <td bgcolor="#FFFFFF" align="center"><?=$row[id]?></td>
         <td bgcolor="#FFFFFF" align="center"><?=$row[sn]?>&nbsp; </td>
         <td align="center" bgcolor="#FFFFFF"><?=$row[rmb]?>&nbsp; </td>
         <td align="center" bgcolor="#FFFFFF">
         <?php $gold=explode('|',$row[v]); echo $gold[2];?>&nbsp;</td>
         
         <td bgcolor="#FFFFFF" align="center">
		<button  type="button" class="button button-mini button-success" onClick="openAppEwm('<?=$row[id]?>')"><i class="x-icon x-icon-small icon-wrench  icon-white"></i>收款二维码</button>

        <button class="button button-mini button-info"  onClick="payitem_edit_bt('<?=$row[id]?>','<?=$row[sn]?>','<?=$row[v]?>','<?=$row[rmb]?>')"><i class="x-icon x-icon-small icon-wrench icon-white"></i>修改</button>
        <button class="button button-mini button-danger" onclick="if(confirm('确定删除？'))location.href='?act=payitem_del&id=<?=$row[id]?>'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
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
    BUI.use('bui/calendar',function(Calendar){
          var datepicker = new Calendar.DatePicker({
            trigger:'.calendar',
			dateMask : 'yyyy-mm-dd',
            autoRender : true
          });
        });
BUI.use('bui/overlay',function(Overlay){
            dialog = new Overlay.Dialog({
            title:'',
            width:800,
            height:600,
            buttons:[],
            bodyContent:''
          });
});



  function payitem_edit_bt(id,sn,v,rmb){
  		$("#act").val("payedit_edit");
		$("#act_group").show();
		$("#sn").val(sn);
		$("#rmb").val(rmb);
		var arr=v.split('|');
		$("#vip_lv").val(arr[0]);
		$("#vip_expire").val(arr[1]);
		$("#gold").val(arr[2]);
				 
		$("#id").val(id);		 
		$("#actstate").html("修改");
  }
function openAppEwm(id){
	dialog.set('bodyContent','<iframe src="payitem_ewm.php?id='+id+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}

$(function(){

  $("#add_group_bt").on("click",function(){
		$("#act_group").toggle();
		$("#act").val("payitem_add");
		$("#sn").val("");
		$("#gold").val("");
		$("#vip_lv").val("0");
		$("#vip_expire").val("0");
		$("#rmb").val("");
		$("#actstate").html("添加");
  });


	  
});

  </script>
</body>
</html>
