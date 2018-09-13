<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sys_base')===false)exit("没有权限！");
function mobile_nav_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}mobile_tabs";
	if($key!="")$sql.=" where title like '%$key%'  ";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by status desc,ov desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}

switch($act){
	case "nav_del":
		$ids=@implode(',',$id);
		$db->query("delete from {$tablepre}mobile_tabs where id in ($ids)");
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
var zt=new Array();
zt['0']="通过";
zt['1']="不通过";
</script>
</head>
<body>
<div class="container">
<form  class="form-horizontal" action="" method="get"> 
  <ul class="breadcrumb"><button type="button" class="button button-success" id="add_group_bt" style="float: right" onClick="openAppFiles(0,'add')">添加</button>
    <li class="active">
    
    关键字：
      <input type="text" name="key" id="key"class="abc input-default" placeholder=""> 
      &nbsp;&nbsp;
      <button type="submit"  class="button ">查询</button>
      <button type="button"  class="button  button-danger"  onClick="if(confirm('确定删除？'))$('#hd_list').submit()">删除所选</button>
    &nbsp;&nbsp;</li>
   
  </ul>
  </form>
  <form action="" method="POST" enctype="application/x-www-form-urlencoded"  class="form-horizontal" id="hd_list"><input type="hidden" name="act" value="nav_del"> 
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="30" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="30" align="center" bgcolor="#FFFFFF">房间</td>
        <td  width="30" bgcolor="#FFFFFF">排序</td>
        <td width="19" align="center" bgcolor="#FFFFFF"><input type="checkbox" onClick="$('.ids').attr('checked',this.checked); "></td>
          <td width="30" align="center" bgcolor="#FFFFFF">启用</td>
          <td  align="center" bgcolor="#FFFFFF">标题</td>
        
        <td width="120" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
      
    </thead>
    
<?php
echo mobile_nav_list(20,$key,'
    <tr>
      <td align="center" bgcolor="#FFFFFF">{id}</td>
	  <td align="center" bgcolor="#FFFFFF">{rid}</td>
	  <td align="center" bgcolor="#FFFFFF">{ov}</td>
      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" class="ids" name="id[]" value="{id}"></td>
      <td align="center" bgcolor="#FFFFFF">{status}</td>
	  <td align="center" bgcolor="#FFFFFF">{title}</td>
	  
      <td align="center" bgcolor="#FFFFFF">
        <button  type="button" class="button button-mini button-success" onClick="openAppFiles(\'{id}\',\'edit\')"><i class="x-icon x-icon-small icon-trash icon-white"></i>修改</button>
        
        <button type="button" class="button button-mini button-danger" onclick="if(confirm(\'确定删除？\'))location.href=\'?act=nav_del&id[]={id}\'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
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
<script type="text/javascript">
BUI.use('bui/overlay',function(Overlay){
            dialog = new Overlay.Dialog({
            title:'修改',
            width:750,
            height:630,
            buttons:[],
            bodyContent:''
          });
		  
});
function openAppFiles(id,type){
	dialog.set('bodyContent','<iframe src="mobile_nav_edit.php?id='+id+'&type='+type+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}
      </script>

</body>
</html>
