<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sys_rooms')===false)exit("没有权限！");
switch($act){
	case "rooms_del":
		$db->query("delete from {$tablepre}config where id='$id' and id!='1'");
	break;
	case "rooms_add":
		$db->query("insert into {$tablepre}config(title, `keys`, dc, logo, ico, bg, kcb, regban, msgban, state, pwd, regaudit, msgblock, msgaudit, msglog, logintip, loginguest, loginqq, tongji, copyright, tserver, vserver, livetype, online, defvideo, phonefp, livefp, rebots, defkf, defvideonick,acl,ggzl) select title, `keys`, dc, logo, ico, bg, kcb, regban, msgban, state, pwd, regaudit, msgblock, msgaudit, msglog, logintip, loginguest, loginqq, tongji, copyright, tserver, vserver, livetype, online, defvideo, phonefp, livefp, rebots, defkf, defvideonick,acl,ggzl from {$tablepre}config where id='1' ");
		//header("location:?");
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
	return new Date(time*1000).Format("yyyy-MM-dd hh:mm"); ; 
}

</script>
</head>
<body>
<div class="container"  style=" min-width:1300px;">
<form  class="form-horizontal" action="" method="post"> 
  <ul class="breadcrumb">
    <li class="active" >
    <input type="hidden" name="act" value="rooms_add">
      <button type="submit"  class="button button-success" id="add_ban_bt" >添加房间</button> (复制默认设置)
      &nbsp;&nbsp;
    </li>
  </ul>
  </form>
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="40" align="center" bgcolor="#FFFFFF">编号</td>
        <td align="center" bgcolor="#FFFFFF">标题</td>
        <td width="120" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
    </thead>
    <?php
	$query=$db->query("select * from {$tablepre}config where id!='1' order by id  desc");
	echo for_each($query,'
    <tr>
      <td bgcolor="#FFFFFF" align="center">{id}</td>
      <td align="center" bgcolor="#FFFFFF"><a href="?rid={id}" target="_blank">{title}</a></td>
      <td align="center" bgcolor="#FFFFFF">
      <button class="button button-mini button-success" onClick="location.href=\'rooms_edit.php?id={id}\'"><i class="x-icon x-icon-small icon-trash icon-white"></i>修改</button>
      <button id="del{id}" class="button button-mini button-danger" onclick="if(confirm(\'确定删除？\'))location.href=\'?act=rooms_del&id={id}\'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
    </tr>
');?>


  </table>
    <ul class="breadcrumb">
    <li class="active"><?=$pagenav?>
    </li>
  </ul>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script type="text/javascript">
BUI.use('bui/overlay',function(Overlay){
            dialog = new Overlay.Dialog({
            title:'公告板',
            width:700,
            height:600,
            buttons:[],
            bodyContent:''
          });
});
      </script>
</body>
</html>
