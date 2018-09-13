<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sysmsg')===false)exit("没有权限！");
function sysmsg_list($num,$ntype,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}sysmsg";
	if($ntype!="")$sql.=" where type ='$ntype'  ";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}
switch($act){
	case "sysmsg_del":
		$db->query("delete from  {$tablepre}sysmsg where id ='$id'");
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
var t=new Array();
t[0]='系统消息';
t[1]='置顶公告';
t[2]='管理提示';
</script>
</head>
<body>
<div class="container" >
<form  class="form-horizontal" action="" method="get"> 
  <ul class="breadcrumb">
    <li class="active" >
    <select name="type" id="type">
      <option value="<?=$type?>"><?=$type?></option>
      <option value="">-所有</option>
      <option value="0">0系统消息</option>
      <option value="1">1置顶公告</option>
      <option value="2">2管理提示</option>
    </select>
      &nbsp;&nbsp;
      <button type="submit"  class="button ">查询</button>

      <button type="button"  class="button button-success" id="add_ban_bt" onClick="opennotice(0,'add')">添加</button>
      &nbsp;&nbsp;
    </li>
  </ul>
  </form>
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="40" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="40" align="center" bgcolor="#FFFFFF">房间</td>
        <td width="80" align="center" bgcolor="#FFFFFF">类型</td>
        <td align="center" bgcolor="#FFFFFF">内容</td>
        <td width="120" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
    </thead>
    <?php
	echo sysmsg_list(20,$type,'
    <tr>
      <td bgcolor="#FFFFFF" align="center">{id}</td>
	  <td bgcolor="#FFFFFF" align="center">{rid}</td>
	  <td bgcolor="#FFFFFF" align="center"><script>document.write(t[{type}])</script></td>
      <td align="center" bgcolor="#FFFFFF">{txt}</td>
      <td align="center" bgcolor="#FFFFFF">
	  <button class="button button-mini button-success" onClick="opennotice(\'{id}\',\'edit\')"><i class="x-icon x-icon-small icon-trash icon-white"></i>修改</button>
      <button id="del{id}" class="button button-mini button-danger" onclick="if(confirm(\'确定删除？\'))location.href=\'?act=sysmsg_del&id={id}\'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
    </tr>
');
	?>


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
            title:'广播',
            width:700,
            height:600,
            buttons:[],
            bodyContent:''
          });
});
function opennotice(id,type){
	dialog.set('bodyContent','<iframe src="sysmsg_edit.php?id='+id+'&type='+type+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}
      </script>
</body>
</html>
