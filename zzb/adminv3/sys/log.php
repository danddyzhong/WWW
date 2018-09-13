<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sys_log')===false)exit("没有权限！");
if($cmsg!=""){
	$ctime=time()-$cmsg*24*3600;
	if($ctype=="0") {
		$where="  `type`='0'";
	}else if($ctype=="123"){
		$where="  (`type`='1' or `type`='2' or `type`='3' )";
	}
	$db->query("delete from {$tablepre}msgs where mtime<$ctime and $where");
	$db->query("OPTIMIZE TABLE `chat_apps_ad`, `chat_apps_appad`, `chat_apps_files`, `chat_apps_hd`, `chat_apps_hongbao`, `chat_apps_hongbao_get`, `chat_apps_jyts`, `chat_apps_manage`, `chat_apps_qiandao`, `chat_apps_qiandao_log`, `chat_apps_rank`, `chat_apps_rebots`, `chat_apps_scpl`, `chat_apps_vote`, `chat_apps_wt`, `chat_auth_group`, `chat_auth_rule`, `chat_ban`, `chat_cache`, `chat_config`, `chat_cs`, `chat_gift_class`, `chat_gift_goods`, `chat_gift_list`, `chat_gold_log`, `chat_memberfields`, `chat_memberonlines`, `chat_members`, `chat_membersapp1`, `chat_membersapp2`, `chat_membersapp3`, `chat_membersapp4`, `chat_members_oauth`, `chat_member_tixian`, `chat_msgs`, `chat_msgs_20160126`, `chat_notice`, `chat_payitem`, `chat_payitem_ewm`, `chat_payorder`, `chat_rebots`, `chat_roomadmin`, `chat_roomclass`, `chat_roommusic`, `chat_roomvideo`, `chat_sysmsg`, `chat_votereport`");
}
switch($act){
	case "log_del":
		log_del(implode(',',$id));
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
<div class="container"  style=" min-width:1300px;">
<form  class="form-horizontal" action="" method="get"> 
  <ul class="breadcrumb">
    <li class="active" style="width:100%">
	<span style="float:right">
	  
		  <button style="float:right;margin: 0px 6px;" type="button"  class="button  button-inverse" onClick="if(confirm('确定清空？')){location.href='?ctype=123&cmsg='+$('#cmsg').val()}" title="注册、登录、入室">清空其他记录</button></span>
		  <button style="float:right;margin: 0px 6px;" type="button"  class="button  button-inverse" onClick="if(confirm('确定清空？')){location.href='?ctype=0&cmsg='+$('#cmsg').val()}">清空聊天记录</button>
		
		<select name="cmsg" id="cmsg" style="width:70px;float:right;margin: 0px 6px;">
            <option value="">时间段</option>
			<option value="0">所有</option>
            <option value="1">清空一天前</option>
            <option value="30">清空一月前</option>
			<option value="90">清空三月前</option>
          </select>
		</span>
		关键字：
      <input type="text" name="key" id="key"class="abc input-default" placeholder=""> 
      &nbsp;&nbsp;
      <button type="submit"  class="button ">查询</button>
      <button type="button"  class="button  button-danger" id="add_ban_bt" onClick="if(confirm('确定删除？'))$('#log_list').submit()">删除所选</button>
	  
    &nbsp;&nbsp;</li>
   
  </ul>
  </form>
  <form action="" method="POST" enctype="application/x-www-form-urlencoded"  class="form-horizontal" id="log_list"><input type="hidden" name="act" value="log_del"> 
  <table  class="table table-bordered table-hover definewidth m10">
    <thead>
      <tr style="font-weight:bold" >
        <td width="30" align="center" bgcolor="#FFFFFF">编号</td>
        <td width="19" align="center" bgcolor="#FFFFFF"><input type="checkbox" onClick="$('.ids').attr('checked',this.checked); "></td>
        <td width="74" align="center" bgcolor="#FFFFFF">UID</td>
        <td width="100" align="center" bgcolor="#FFFFFF">昵称</td>
        <td width="100" align="center" bgcolor="#FFFFFF">IP</td>
        <td width="120" align="center" bgcolor="#FFFFFF">时间</td>
        <td width="36" align="center" bgcolor="#FFFFFF">类型</td>
        <td align="center" bgcolor="#FFFFFF">描述</td>
        <td width="55" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
    </thead>
    
<?php
echo log_list(20,$type,$key,'
    <tr>
      <td align="center" bgcolor="#FFFFFF">{id}</td>
      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" class="ids" name="id[]" value="{id}"></td>
      <td align="center" bgcolor="#FFFFFF">{uid}</td>
      <td align="center" bgcolor="#FFFFFF">{uname}</td>
      <td align="center" bgcolor="#FFFFFF">{ip}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({mtime})); </script></td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(type[\'{type}\']); </script></td>
      <td align="center" bgcolor="#FFFFFF">{msg}</td>
      <td align="center" bgcolor="#FFFFFF">
      <button type="button" class="button button-mini button-danger" onclick="if(confirm(\'确定删除？\'))location.href=\'?type=<?=$type?>&act=log_del&id[]={id}\'" ><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
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

</body>
</html>
