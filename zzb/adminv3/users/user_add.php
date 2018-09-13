<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'users_admin')===false)exit("没有权限！");
if($act=="user_add"){
    if($db->num_rows($db->query("select uid from {$tablepre}members where username='$username'"))<1) {
        $db->query("insert into {$tablepre}members(username,realname,phone,password,fuser,tuser,rid,state,gid,regip,sex,regdate)
                values('$username','$realname','$phone','".md5($password)."','','','$rid','1','$gid','$onlineip','2',".time().") ");
//         var_dump("insert into {$tablepre}members(username,realname,phone,password,fuser,tuser,rid,state,gid,regip,sex,regdate)
//                 values('$username','$realname','$phone','".md5($password)."','','','$rid','1','$gid','$onlineip','2',".time().") ");
//         exit;
        $uid = $db->insert_id();
        $db->query("insert into {$tablepre}memberfields(uid,sn,nickname,kfmsg,uface)values('$uid','$sn','$nickname','$kfmsg','/face/rebot/".rand(10,40).".gif')");

        $db->query("insert into {$tablepre}cs(rid,uid,fid) values('{$rid}','{$uid}','{$kf}')");
        
        exit("<script>alert('添加成功！');parent.location.reload();</script>");
    }else{
        exit("<script>alert('用户名已存在！');location.href='?'</script>");
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
<?php
$query=$db->query("select * from {$tablepre}auth_group order by id desc");
while($row=$db->fetch_row($query)){
	$group.='<option value="'.$row[id].'">GID:'.$row[id].'-'.$row[title].'</option>';
}
if(stripos(auth_group($_SESSION['login_gid']),'users_group')===false){
	$group='';
}

//当前房间客服信息

$query=$db->query("select m.uid,ms.nickname from {$tablepre}members as m,{$tablepre}memberfields as ms  where m.gid in (4,5) and m.uid=ms.uid");
while($row=$db->fetch_row($query)){
	$kfs.="<option value='{$row['uid']}'>{$row['nickname']}</option>";
}
$csInfo.="";
?>
<form action="?" method="post" enctype="application/x-www-form-urlencoded">
  <ul class="breadcrumb">
  <div style="border-bottom:1px dashed #CCCCCC; padding:5px; margin-bottom:5px;"><strong>添加用户</strong></div>
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="80" class="tableleft" style="width:70px;">用户名：</td>
        <td><input name="username" type="text" id="username" style="width:350px;" value=""/></td>
    </tr>
    <tr>
        <td width="80" class="tableleft" style="width:70px;">昵称：</td>
        <td><input name="nickname" type="text" id="nickname" style="width:350px;" value=""/></td>
    </tr>
		  <tr>
            <td width="80" class="tableleft">所属房间：</td>
            <td><?=selectRooms('rid','1')?> &nbsp;</td>
          </tr>

          <tr>
            <td width="80" class="tableleft" style="width:70px;">QQ号码：</td>
            <td><input name="realname" type="text" id="realname" style="width:350px;" value=""/></td>
          </tr>
          <tr>
            <td width="80" class="tableleft">用户密码：</td>
            <td><input name="password" type="text" id="password" /> </td>
          </tr>
          <tr>
            <td width="80" class="tableleft">手机号码：</td>
            <td><input name="phone" type="text" id="phone" style="width:350px;" value=""/></td>
          </tr>
          <tr>
            <td width="80" class="tableleft">用 户 组：</td>
            <td><select name="gid" id="gid" >
              <?=$group?>
            </select>&nbsp;</td>
          </tr>
		  <tr>
            <td width="80" class="tableleft">客服：</td>
            <td>
			<select name="kf" id="kf" >
              <?=$kfs?>
            </select>
			</td>
          </tr>
          <tr>
            <td width="80" class="tableleft">自我介绍：</td>
            <td><textarea name="kfmsg" id="kfmsg" style="width:350px;"></textarea></td>
          </tr>
        </table>

  </ul>
  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="user_add">
</div>
  </form>

</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script> 
<script>

</script>
</body>
</html>
