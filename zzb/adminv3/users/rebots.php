<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'users_rebots')===false)exit("没有权限！");

if($act=='rebots_add'){
    $query=$db->query("select * from {$tablepre}rebots where id='1'");
    $row=$db->fetch_row($query);
    $rebots_arr=explode("\r\n",$row['rebots']);
    shuffle($rebots_arr);
    $i=rand(1,count($rebots_arr));
    $uname=$rebots_arr[$i];
	$db->query("insert into {$tablepre}apps_rebots(img,name,gid,fuser,weeks,hl,ol)values('/face/rebot/".rand(1,43).".gif','{$uname}','3','".$_SESSION['login_user']."','0,1,2,3,4,5,6','08:00:00','02:00:00')");
	$db->query("delete from {$tablepre}rebots where id!='1'");
    header("location:?");
}
else if($act=="rebots_del"){
	$db->query("delete from {$tablepre}apps_rebots where  id='$id'");
	header("location:?");
}
function app_rebots_list($num,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select *  from {$tablepre}apps_rebots r  where 1=1";
	if($_SESSION['login_gid']=='3'){
		$sql.=" and r.fuser='".$_SESSION['login_user']."'";
	}
	
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
	return new Date(time*1000).Format("yyyy-MM-dd hh:mm"); ; 
}
function ftime2(time){
	if(time>(60*60*24)) return parseInt(time/(60*60*24))+"天";
	else if(time>(60*60))return parseInt(time/(60*60))+"小时";
	else if(time>60)return parseInt(time/60)+"分钟";
	else return parseInt(time)+"秒";
}
function sgid(id){
	var arr=new Array();
	if(isNaN(id)) return '';
	<?php
	$query=$db->query("select * from {$tablepre}auth_group order by id desc");
while($row=$db->fetch_row($query)){
	echo "arr['{$row[id]}']='$row[title]';";
	}
	?>
	return arr[id];
}
</script>
</head>
<body>
<div class="container">
  <ul class="breadcrumb">
    <li class="active">
      &nbsp;&nbsp;
      <button type="button" class="button button-success" id="add_rebots_bt" onClick="location.href='?act=rebots_add'"><i class="icon icon-plus icon-white"></i> 添加</button>
      <button type="button" class="button " id="add_rebots_bt" onClick="location.href='?'"> 刷新</button>
      </li>
   
  </ul>
    <form action="" method="POST" enctype="application/x-www-form-urlencoded"  class="form-horizontal" id="rebots_list">
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="40" align="center" bgcolor="#FFFFFF">编号</td>
        <td align="center" bgcolor="#FFFFFF">昵称</td>
        <td width="80" align="center" bgcolor="#FFFFFF">头像</td>
        <td width="180" align="center" bgcolor="#FFFFFF">分组</td>
		<td width="180" align="center" bgcolor="#FFFFFF">所属</td>
        <td width="60" align="center" bgcolor="#FFFFFF">上线时间</td>
        <td width="60" align="center" bgcolor="#FFFFFF">下线时间</td>
        <td width="120" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
    </thead>
<?php

echo app_rebots_list(20,'
    <tr>
      <td bgcolor="#FFFFFF" align="center">{id}</td>
      <td align="center" bgcolor="#FFFFFF">{name}</td>
	  <td align="center" bgcolor="#FFFFFF"><img src="{img}" width="20" height="20">&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(sgid({gid})); </script>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">{fuser}&nbsp;</td>
	  <td align="center" bgcolor="#FFFFFF">{hl}&nbsp;</td>
	  <td align="center" bgcolor="#FFFFFF">{ol}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">
      <button type="button" class="button button-mini button-info" onClick="openUser({id},0)" ><i class="x-icon x-icon-small icon-wrench icon-white"></i>修改</button>
      <button type="button" class="button button-mini button-danger" onclick="if(confirm(\'确定删除机器人？\'))location.href=\'?act=rebots_del&id={id}&gid='.$gid.'\'" '.$display_delbutton.'><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
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
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script> 
<script>
BUI.use('bui/overlay',function(Overlay){
            dialog = new Overlay.Dialog({
            title:'修改人添加',
            width:630,
            height:600,
            buttons:[],
            bodyContent:''
          });
});
function openUser(id,type){
	dialog.set('bodyContent','<iframe src="rebots_edit.php?id='+id+'&type='+type+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}

  </script>
</body>
</html>
