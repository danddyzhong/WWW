<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'users_admin')===false)exit("没有权限！");
if($act=="user_edit"){
	user_edit($id,$realname,$password,$phone,$gid,$fuser,$tuser,$sn,$state,$nickname,$rid,$kfmsg);
	$db->query("delete from {$tablepre}cs where uid='{$id}' and rid='{$rid}'");
	$db->query("insert into {$tablepre}cs(rid,uid,fid) values('{$rid}','{$id}','{$kf}')");
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
		$query=$db->query("select * from {$tablepre}auth_group where id>=10 and id<=17 order by id desc");
		$group="";
		while($row=$db->fetch_row($query)){
			$group.='<option value="'.$row[id].'">GID:'.$row[id].'-'.$row[title].'</option>';
		}
	}
	$kfs="";
	$user=getUserInfo($id);
	//客服信息
	$query=$db->query("select * from {$tablepre}cs where uid='{$id}' and rid in (select id from {$tablepre}config)");
	while($row=$db->fetch_row($query)){
		$fu=getUserInfo($row[fid]);
		$csInfo.="<li>房间(ID):{$row[rid]}-->客服:{$fu[nickname]}(UID:{$fu[uid]}) &nbsp;&nbsp;&nbsp;</li>";

		if($row['rid']==$user['rid']){$kfs.="<option value='{$fu[uid]}' checked>{$fu[nickname]}</option>";}
	}
	//当前房间客服信息

	//echo "select m.uid,ms.nickname from {$tablepre}members as m,{$tablepre}memberfields as ms  where m.gid in (2,3,4,5) and m.rid='{$user['gid']}' and m.uid=ms.uid";
	$query=$db->query("select m.uid,ms.nickname from {$tablepre}members as m,{$tablepre}memberfields as ms  where m.gid in (4,5) and m.rid='{$user['rid']}' and m.uid=ms.uid");
	while($row=$db->fetch_row($query)){
		$kfs.="<option value='{$row['uid']}'>{$row['nickname']}</option>";
	}
	$csInfo.="";
	echo userinfo($id,'
<form action="?id={uid}" method="post" enctype="application/x-www-form-urlencoded">
  <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"><strong>[{username}] {nickname}</strong></div>
<table class="table table-bordered table-hover definewidth m10">
			<tr>
            <td width="80" class="tableleft">审核状态：</td>
            <td><select name="state" id="state" >
			<option value="{state}">S:{state}不变</option>
              <option value="1">S:1已审核</option>
			  <option value="0">S:0未审核</option>
            </select>&nbsp;</td>
          </tr>
		  <tr>
            <td width="80" class="tableleft">所属房间：</td>
            <td>'.selectRooms('rid','{rid}').' 按房间id分配对应rid客服 &nbsp;</td>
          </tr>
		  <tr>
            <td width="80" class="tableleft" style="width:70px;">昵称：</td>
            <td><input name="nickname" type="text" id="nickname" style="width:350px;" value="{nickname}"/></td>
          </tr>
          <tr>
            <td width="80" class="tableleft" style="width:70px;">QQ号码：</td>
            <td><input name="realname" type="text" id="realname" style="width:350px;" value="{realname}"/></td>
          </tr>
          <tr>
            <td width="80" class="tableleft">用户密码：</td>
            <td><input name="password" type="text" id="password" /> 为空不修改密码</td>
          </tr>
          <tr>
            <td width="80" class="tableleft">手机号码：</td>
            <td><input name="phone" type="text" id="phone" style="width:350px;" value="{phone}"/></td>
          </tr>
          <tr>
            <td width="80" class="tableleft">用 户 组：</td>
            <td><select name="gid" id="gid" >
			<option value="{gid}">GID:{gid}</option>
              '.$group.'
            </select>&nbsp;</td>
          </tr>
		  <tr>
            <td width="80" class="tableleft">客服信息：</td>
            <td>'.$csInfo.'&nbsp;<br>
			当前房间客服：<select name="kf" id="kf" >
              '.$kfs.'
            </select>
			</td>
          </tr>
          <tr>
            <td width="80" class="tableleft">自我介绍：</td>
            <td><textarea name="kfmsg" id="kfmsg" style="width:350px;">{kfmsg}</textarea></td>
          </tr>
        </table>

  </ul>
  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="user_edit">
</div>
  </form>
')?>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bui.js"></script>
<script type="text/javascript" src="../assets/js/config.js"></script>
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script>
<script>

</script>
</body>
</html>
