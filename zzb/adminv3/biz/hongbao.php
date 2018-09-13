<?php
require_once '../../include/common.inc.php';

require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_hongbao')===false)exit("没有权限！");
function hongbao_list($num,$rid,$nick,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_hongbao where 1=1";
	
	if($rid!="")$sql.=" and `rid`='$rid'";
	if($nick!="")$sql.=" and nick like'%$nick%'";
	
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
	return new Date(time*1000).Format("yyyy-MM-dd hh:mm:ss"); ; 
}
var type=[];
type["0"]="聊天";
type["1"]="登陆";
type["2"]="注册";
type["3"]="入室";
</script>
</head>
<body>
<div class="container"  >
<form  class="form-horizontal" action="" method="get"> 
  <ul class="breadcrumb">
    <li class="active">
    发送人：<input type="text" name="nick" id="nick"class="abc input-default" placeholder="发送人昵称"> 
	房间ID：<input type="text" name="r_id" id="rid"class="abc input-default" placeholder="房间ID" value=''>
	  
      &nbsp;&nbsp;
      <button type="submit"  class="button ">查询</button>
      </li>
   
  </ul>
  </form>
  <form action="" method="POST" enctype="application/x-www-form-urlencoded"  class="form-horizontal" id="log_list"><input type="hidden" name="act" value="log_del"> 
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="40" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="40" align="center" bgcolor="#FFFFFF">房间</td>
        <td width="40" bgcolor="#FFFFFF">金额</td>
		<td width="40" bgcolor="#FFFFFF">个数</td>
        <td bgcolor="#FFFFFF">（UID）发送人</td>
		<td width="150" bgcolor="#FFFFFF">发送时间</td>
        <td bgcolor="#FFFFFF">红包留言</td>
        <td width="100" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
    </thead>
    
<?php
echo hongbao_list(20,$r_id,$nick,'
    <tr>
      <td align="center" bgcolor="#FFFFFF">{id}</td>
      <td align="center" bgcolor="#FFFFFF">{rid}</td>
      <td align="center" bgcolor="#FFFFFF">{money}</td>
      <td align="center" bgcolor="#FFFFFF">{number}</td>
      <td align="center" bgcolor="#FFFFFF">({uid}){nick}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({atime})); </script></td>
      <td align="center" bgcolor="#FFFFFF">{msg}</td>
      <td align="center" bgcolor="#FFFFFF">
      <button type="button" class="button button-mini button-info" onClick="openHg({id})" ><i class="x-icon x-icon-small icon-user  icon-white"></i>领取记录</button></td>
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
            title:'领取记录',
            width:630,
            height:650,
            buttons:[],
            bodyContent:''
          });
});
function openHg(hid){
	dialog.set('bodyContent','<iframe src="hongbao_get.php?hid='+hid+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}

  </script>

</body>
</html>
    
