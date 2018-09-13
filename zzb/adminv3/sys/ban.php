<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sys_ban')===false)exit("没有权限！");
switch($act){
	case "ban_del":
		ban_del($id);
	break;
	case "ban_add":
		ban_add($username,$ip,$sn,$losttime);
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
<div class="container">
<form  class="form-horizontal" action="" method="get"> 
  <ul class="breadcrumb">
    <li class="active">
    关键字：
      <input type="text" name="key" id="key"class="abc input-default" placeholder=""> 
      &nbsp;&nbsp;
      <button type="submit"  class="button ">查询</button>
    &nbsp;&nbsp; 用户名、IP为查询字段</li>
    <li class="active" style="float:right">
      <button type="button"  class="button button-success" id="add_ban_bt" onClick="$('#act_ban').toggle()">添加</button>
      &nbsp;&nbsp;
    </li>
  </ul>
  </form>
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="40" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="150" align="center" bgcolor="#FFFFFF">用户名</td>
        <td width="300" align="center" bgcolor="#FFFFFF">IP</td>
        <td align="center" bgcolor="#FFFFFF">备注</td>
        <td width="150" align="center" bgcolor="#FFFFFF">过期时间</td>
        <td width="55" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
    </thead>
    <form method="post" enctype="application/x-www-form-urlencoded" action="?">
    <tr  id="act_ban" style="display:none">
      <td bgcolor="#FFFFFF" align="center"><span class="label label-info" >屏蔽</span></td>
      <td align="center" bgcolor="#FFFFFF"><input name="username" type="text" class="abc input-default" id="username"  maxlength="20"></td>
      <td align="center" bgcolor="#FFFFFF"><input name="ip" type="text" class="abc input-default" id="ip" maxlength="18"></td>
      <td align="center" bgcolor="#FFFFFF"><input name="sn" type="text" class="abc input-large control-text" id="sn"  maxlength="18"></td>
      <td align="center" bgcolor="#FFFFFF"><input name="losttime" type="text" class="abc input-default calendar calendar-time" id="losttime" ></td>
      <td align="center" bgcolor="#FFFFFF">
      <button class="button button-small button-success" >提交</button>
      <input type="hidden" name="act" value="ban_add">
       </td>
    </tr>
    </form>
<?php
echo ban_list(20,$key,'
    <tr>
      <td bgcolor="#FFFFFF" align="center">{id}</td>
      <td align="center" bgcolor="#FFFFFF">{username}</td>
      <td align="center" bgcolor="#FFFFFF" class="ip">{ip}</td>
      <td align="center" bgcolor="#FFFFFF">{sn}</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({losttime}));</script></td>
      <td align="center" bgcolor="#FFFFFF">
      <button class="button button-mini button-danger" onclick="if(confirm(\'确定删除用户？\'))location.href=\'?act=ban_del&id={id}\'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
    </tr>
')?>


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
            var Calendar = BUI.Calendar
            var datepicker = new Calendar.DatePicker({
              trigger:'.calendar-time',
              showTime:true,
              autoRender : true
            });

$(function(){
	$(".ip").each(function(){
		var ip=$(this).html();
		var e=this;
		$.getJSON("../ip.php?ip="+ip,function(re){
			var str=re.country+re.province+re.city;
			
			$(e).html(ip+" "+str);
		});
	});	
});
</script>
</body>
</html>
