<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_tixian')===false)exit("没有权限！");
$txinfo=$db->fetch_row($db->query("select * from {$tablepre}member_tixian  where id='$id'"));
$uinfo=$db->fetch_row($db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.uid='{$txinfo[uid]}'"));
if($txinfo['status']=="1")exit("<script>alert('已经处理');parent.location.reload();</script>");
if($act=="tixian_edit"){
	$wmoney=intval($txinfo[wmoney]);
	if($wmoney>intval($uinfo['money'])&&$status=='1'){
		echo "<script>alert('错误，提现金额大于用户余额！');</script>";
	}else{
		$db->query("update {$tablepre}member_tixian set status='$status',ordercode='$ordercode',clr='$_SESSION[login_user]'  where id='$id'");
		if($status=='1'){
			$db->query("update {$tablepre}members set  money=money-$wmoney where uid='$txinfo[uid]'");
			$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$txinfo[uid]','$txinfo[wmoney]','$onlineip','".gdate()."','money_tixian-{$txinfo[uid]}|{$txinfo[wmoney]}|{$txinfo[ulogin]}提现')");

		}
		exit("<script>parent.location.reload();</script>");
	}

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

<form action="?id=<?=$id?>" method="post" enctype="application/x-www-form-urlencoded">
  <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"><strong><?=$uinfo['username']?> <?=$uinfo['nickname']?> <?=$txinfo['ip']?></strong></div>
<table class="table table-bordered table-hover definewidth m10">
		
		<tr>
			  <td class="tableleft"  width="80">用户余额：</td>
			  <td><?=$uinfo['money']?></td>
	    </tr>
		
			<tr>
			  <td class="tableleft">提现金额：</td>
			  <td><?=$txinfo['wmoney']?></td>
	    </tr>
	<tr>
		<td class="tableleft">处理方式：</td>
		<td><select name="status">
				<option value="1">同意</option>
				<option value="2">驳回</option>
			</select></td>
	</tr>
          <tr>
            <td class="tableleft">处理说明：</td>
            <td>
			<input name="ordercode" type="text" id="ordercode"  value="0" maxlength="90"/>
			 
			</td>
          </tr>
        </table>

  </ul>
  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="tixian_edit">
</div>
  </form>

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
