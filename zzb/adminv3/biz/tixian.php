<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_tixian')===false)exit("没有权限！");
function tixian_list($num,$name,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}member_tixian where 1=1";
	
	if($name!="")$sql.=" and `ulogin`='$name' or wname like '%$name%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	
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
.hide1{display:none}
.hide2{display:none}
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
function ftime2(time){
	if(time>(60*60*24)) return parseInt(time/(60*60*24))+"天";
	else if(time>(60*60))return parseInt(time/(60*60))+"小时";
	else if(time>60)return parseInt(time/60)+"分钟";
	else return parseInt(time)+"秒";
}
var s=new Array();
s[2]="<font style='color:#000'>驳回</font>";
s[1]="<font style='color:#090'>同意</font>";
s[0]="<font style='color:red'>未处理</font>";
</script>
</head>
<body>
<div class="container"  >
<form  class="form-horizontal" action="" method="get"> 
  <ul class="breadcrumb">
    <li class="active">
    签到人：<input type="text" name="nick" id="nick"class="abc input-default" placeholder="签到人昵称"> 
	房间ID：<input type="text" name="rid" id="rid"class="abc input-default" placeholder="房间ID" value='1'>
	  
      &nbsp;&nbsp;
      <button type="submit"  class="button ">查询</button>
      </li>
   
  </ul>
  </form>
  <form action="" method="POST" enctype="application/x-www-form-urlencoded"  class="form-horizontal" id="log_list"><input type="hidden" name="act" value="log_del"> 
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="40" align="center" bgcolor="#FFFFFF">ID</td>
        <td bgcolor="#FFFFFF">登录名</td>
		<td bgcolor="#FFFFFF">提现类型</td>
        <td bgcolor="#FFFFFF">提现户名</td>
		<td bgcolor="#FFFFFF">帐号</td>
		<td bgcolor="#FFFFFF">提现金额</td>
		<td bgcolor="#FFFFFF">申请时间</td>
		<td bgcolor="#FFFFFF">处理状态</td><td bgcolor="#FFFFFF">处理人</td><td bgcolor="#FFFFFF">处理说明</td>
        <td width="100" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
    </thead>
    
<?php
echo tixian_list(20,$nick,'
    <tr>
	  <td align="center" bgcolor="#FFFFFF">{id}</td>
      <td align="center" bgcolor="#FFFFFF">{ulogin}</td>
      <td align="center" bgcolor="#FFFFFF">{wtype}</td>
	  <td align="center" bgcolor="#FFFFFF">{wname}</td>
	  <td align="center" bgcolor="#FFFFFF">{wcode}</td>
	  <td align="center" bgcolor="#FFFFFF">{wmoney}</td>
	  <td align="center" bgcolor="#FFFFFF">{wtime}</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(s[{status}]); </script></td><td align="center" bgcolor="#FFFFFF">{clr}</td><td align="center" bgcolor="#FFFFFF">{ordercode}</td>
      <td align="center" bgcolor="#FFFFFF">
      <button type="button" class="button button-mini button-info hide{status}" onClick="openTx({id},{uid})" ><i class="x-icon x-icon-small icon-user  icon-white"></i>处理提现</button></td>
    </tr>
')?>


  </table>
  </form> 
    <ul class="breadcrumb">
    <li class="active"><?=$pagenav?>
    </li>
  </ul>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script>
BUI.use('bui/overlay',function(Overlay){
            dialog = new Overlay.Dialog({
            title:'处理提现',
            width:430,
            height:350,
            buttons:[],
            bodyContent:''
          });
});
function openTx(id,uid){
	dialog.set('bodyContent','<iframe src="tixian_edit.php?id='+id+'&uid='+uid+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}

  </script>

</body>
</html>
    
