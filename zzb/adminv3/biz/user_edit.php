<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_goldvip')===false)exit("没有权限！");
if($act=="user_edit_goldvip"){
	user_edit_goldvip($id,$vip_lv,$vip_expire,$addgold,$addmoney);
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
$query=$db->query("select * from {$tablepre}auth_group order by id desc");
while($row=$db->fetch_row($query)){
	$group.='<option value="'.$row[id].'">GID:'.$row[id].'-'.$row[title].'</option>';
}
if(stripos(auth_group($_SESSION['login_gid']),'users_group')===false){
	$group='';
}

echo userinfo($id,'
<form action="?id={uid}" method="post" enctype="application/x-www-form-urlencoded">
  <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"><strong>[{username}] {nickname}</strong></div>
<table class="table table-bordered table-hover definewidth m10">
			<tr>
			  <td class="tableleft"  width="80">用户帐号：</td>
			  <td>{username}</td>
	    </tr>
			<tr>
			  <td class="tableleft">用户昵称：</td>
			  <td>{nickname}</td>
	    </tr>
			<tr style="display:none">
            <td width="100" class="tableleft">VIP等级：</td>
            <td><select name="vip_lv" id="vip_lv" >
			<option value="{vip_level}">VIP{vip_level}</option>
              <option value="0">VIP0</option>
			  <option value="1">VIP1</option>
              <option value="2">VIP2</option>
              <option value="3">VIP3</option>
              <option value="4">VIP4</option>
              <option value="5">VIP5</option>
              <option value="6">VIP6</option>
              <option value="7">VIP7</option>
            </select>&nbsp;</td>
          </tr>
		  <tr style="display:none">
            <td class="tableleft">到期时间：</td>
            <td><input name="vip_expire" type="text" id="vip_expire"  value="{vip_expire}"  class="calendar" /></td>
          </tr>
          <tr>
            <td class="tableleft">现有虚拟币：</td>
            <td>{gold}</td>
          </tr>
		  <tr>
            <td class="tableleft">现有人民币：</td>
            <td>{money}</td>
          </tr>
          <tr>
            <td class="tableleft">虚拟币：</td>
            <td>
			<input name="addgold" type="text" id="addgold"  value="0"/> 
			 
			</td>
          </tr>
		  <tr>
            <td  class="tableleft">人民币：</td>
            <td>
			<input name="addmoney" type="text" id="addmoney"  value="0"/>
			</td>
          </tr>
        </table>

  </ul>
  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="user_edit_goldvip">
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
			dateMask : 'yyyy-mm-dd',
            autoRender : true
          });
        });

</script>
</body>
</html>
