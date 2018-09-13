<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'apps_wt')===false)exit("没有权限！");
switch($act){
	case "wt_del":
		wt_del(implode(',',$id));
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
  <ul class="breadcrumb"><button type="button" class="button button-success" id="add_group_bt" style="float: right" onClick="openAppWt(0,'add')">添加</button>
    <li class="active">
    
    关键字：
      <input type="text" name="key" id="key"class="abc input-default" placeholder=""> 
      &nbsp;&nbsp;
      <button type="submit"  class="button ">查询</button>
      <button type="button"  class="button  button-danger"  onClick="if(confirm('确定删除？'))$('#hd_list').submit()">删除所选</button>
    &nbsp;&nbsp;</li>
   
  </ul>
  </form>
  <form action="" method="POST" enctype="application/x-www-form-urlencoded"  class="form-horizontal" id="hd_list"><input type="hidden" name="act" value="wt_del"> 
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="30" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="19" align="center" bgcolor="#FFFFFF"><input type="checkbox" onClick="$('.ids').attr('checked',this.checked); "></td>
        <td  align="center" bgcolor="#FFFFFF">问题</td>
        <td  align="center" bgcolor="#FFFFFF">答案</td>
        <td  align="center" bgcolor="#FFFFFF">提问人</td>
        <td  align="center" bgcolor="#FFFFFF">回答人</td>
        <td align="center" bgcolor="#FFFFFF">提问时间</td>
        <td align="center" bgcolor="#FFFFFF">状态</td>
        <td width="120" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
      
    </thead>
    
<?php
echo app_wt_list(20,$key,'
    <tr>
      <td align="center" bgcolor="#FFFFFF">{id}</td>
      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" class="ids" name="id[]" value="{id}"></td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({ktime})); </script>{q}</td>
      <td align="center" bgcolor="#FFFFFF">{a}</td>
      <td align="center" bgcolor="#FFFFFF">{quser}</td>
      <td align="center" bgcolor="#FFFFFF">{auser}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({qtime})); </script></td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(zt["{zt}"]); </script>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">
        <button  type="button" class="button button-mini button-success" onClick="openAppWt(\'{id}\',\'edit\')"><i class="x-icon x-icon-small icon-trash icon-white"></i>修改</button>
        
        <button type="button" class="button button-mini button-danger" onclick="if(confirm(\'确定删除？\'))location.href=\'?act=wt_del&id[]={id}\'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
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
            title:'问题修改',
            width:750,
            height:430,
            buttons:[],
            bodyContent:''
          });
		  
});
function openAppWt(id,type){
	dialog.set('bodyContent','<iframe src="app_wt_edit.php?id='+id+'&type='+type+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
	dialog.updateContent();
	dialog.show();
}
      </script>

</body>
</html>
