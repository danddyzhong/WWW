<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_order')===false)exit("没有权限！");


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
	if(time==0)return "";
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
<div class="container"  style=" min-width:1300px;">
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="40" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="80" align="center" bgcolor="#FFFFFF">用户ID</td>
        
        <td width="100" align="center" bgcolor="#FFFFFF">商品ID</td>
        
		<td width="100" align="center" bgcolor="#FFFFFF">下单IP</td>
        <td width="150" align="center" bgcolor="#FFFFFF">下单时间</td>
        <td width="150" align="center" bgcolor="#FFFFFF">支付时间</td>
        <td width="60" align="center" bgcolor="#FFFFFF">是否付款</td>
        <td  align="center" bgcolor="#FFFFFF">&nbsp; </td>
        </tr>
    </thead>

<?=payorder(20,'
          <tr>
            <td height="20" bgcolor="#FFFFFF">{id}</td>
            <td height="20" bgcolor="#FFFFFF">{uid}</td>
			
			<td height="20" bgcolor="#FFFFFF">{payid}</td>
            <td height="20" bgcolor="#FFFFFF">{payip}</td>
            <td height="20" bgcolor="#FFFFFF"><script>document.write(ftime({payordertime}));</script></td>
            <td height="20" bgcolor="#FFFFFF"><script>document.write(ftime({paytime}))</script></td>
            <td height="20" bgcolor="#FFFFFF">{pay}</td>
			<td height="20" bgcolor="#FFFFFF">&nbsp; </td>
          </tr>')?>

  </table>
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


  </script>
</body>
</html>
