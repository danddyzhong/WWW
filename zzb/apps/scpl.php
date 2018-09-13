<?php
require_once '../include/common.inc.php';
function app_scpl_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_scpl";
	if($key!="")$sql.=" where title like '%$key%' or txt like '%$key%' or `user` like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}

switch($act){
	case "scpl_add":
		$user=$_SESSION['login_user'];
		$db->query("insert into {$tablepre}apps_scpl(title,txt,`user`,atime,dj)values('$title','$txt','$user','".gdate()."','$dj')");
		$str="<font style='border-bottom:1px solid #999; color:red;font-size:14px;'>[发布市场评论]</font><br>{$dj}星级 {$title} …… [<font style='color:red;  cursor:pointer' onClick='$(\\\"#app_4\\\").trigger(\\\"click\\\")'>详细</font>]";
		exit('<script>top.app_sendmsg("'.$str.'");location.href="?"</script>');
	break;
}
$sql="select * from {$tablepre}apps_scpl";
if($id!="")$sql.=" where id='$id'";
else $sql.=" limit 1";
$row=$db->fetch_row($db->query($sql));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>市场评论</title>
</head>


<style type="text/css">
/* CSS Document */
body {
 font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 color: #4f6b72;
}
a {
 color: #c75f3e;
}
table {
 width: 100%;
 padding: 0;
 margin: 0;
}
caption {
 padding: 0 0 5px 0;
 width: 700px; 
 font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 text-align: right;
}
th {
 font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 color: #4f6b72;
 border-right: 1px solid #C1DAD7;
 border-bottom: 1px solid #C1DAD7;
 border-top: 1px solid #C1DAD7;
 letter-spacing: 2px;
 text-transform: uppercase;
 text-align:center;
 padding: 6px 6px 6px 12px;
 background: #CAE8EA ;
}
th.nobg {
 border-top: 0;
 border-left: 0;
 border-right: 1px solid #C1DAD7;
 background: none;
}
td {
 border-right: 1px solid #C1DAD7;
 border-bottom: 1px solid #C1DAD7;
 font-size:11px;
 padding: 6px 6px 6px 12px;
 color: #4f6b72;
}

td.alt {
 background: #F5FAFA;
 color: #797268;
}
th.spec {
 border-left: 1px solid #C1DAD7;
 border-top: 0;
 background: #fff ;
 font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
}
th.specalt {
 border-left: 1px solid #C1DAD7;
 border-top: 0;
 background: #f5fafa ;
 font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
 color: #797268;
}
tr{ background: #fff }
tr:hover{background: #f5fafa}
tr:hover td {background:none;}
</style>
<body>
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
	return new Date(time*1000).Format("yyyy-MM-dd hh:mm");
}
</script>

<?php

if(check_auth('scpl_add')){
?>
<form action="?act=scpl_add" method="post" enctype="application/x-www-form-urlencoded">
<table width="100%" cellspacing="0" id="jyts_add"  style="border-left: 1px solid #C1DAD7;border-top: 1px solid #C1DAD7; margin-bottom:5px; display:none">
          <tr>
            <td class="tableleft" style="width:80px;">标题：</td>
            <td><input name="title" type="text" id="title"  style="width:98%" value=""></td>
          </tr>
          <tr>
            <td class="tableleft" style="width:80px;">等级：</td>
            <td><select name="dj" id="dj">
              <option value="1">1星</option>
              <option value="2">2星</option>
              <option value="3">3星</option>
              <option value="4">4星</option>
              <option value="5">5星</option>
            </select></td>
          </tr>
          <tr>
            <td width="30" class="tableleft" style="width:80px;">问题：</td>
            <td><textarea name="txt" id="txt" style="width:100%" class="xheditor {cleanPaste:0,height:'300',internalScript:true,inlineScript:true,linkTag:true,upLinkUrl:'../upload/upload.php',upImgUrl:'../upload/upload.php',upFlashUrl:'../upload/upload.php',upMediaUrl:'../upload/upload.php'}"></textarea></td>
      </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="发布"></td>
          </tr>
    </table>
</form>
<div style="margin:5px 0px;"><button onClick="document.getElementById('jyts_add').style.display=''">发布市场评论</button></div>
<?php
}
if(check_auth('scpl_view')){
?>
<div  style=" padding:20px; margin-bottom:10px;border:1px solid #CCC; <?php if($act!='scpl_view')echo 'display:none';?>">
          <div style="font-size:20px; line-height:25px; text-align:center"><strong><?=$row['title']?></strong></div>
		  <div style="text-align:center"><?=$row['dj']?>星 <?=date('Y-m-d H:i:s', $row['atime'])?> <?=$row['user']?></div>
          <div><?=tohtml($row['txt'])?></div>
</div>
    
<table width="100%" cellspacing="0" id="mytable">

      <tr  >
        <th width="30" align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">编号</th>
        <th width="40"  align="left" bgcolor="#FFFFFF">星级</th>
        <th  align="left" bgcolor="#FFFFFF">标题</th>
        <th width="100"  align="left" bgcolor="#FFFFFF">发布时间</th>
        <th width="100"  align="left" bgcolor="#FFFFFF">发布人</th>
  </tr>
      

<?php
echo app_scpl_list(20,$key,'
    <tr>
    <td align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">{id}</td>
	<td>{dj}星</td>
      <td align="left" bgcolor="#FFFFFF"><a href="?id={id}&act=scpl_view">{title}</a></td>
	  <td> <script>document.write(ftime({atime})); </script></td>
      <td>{user}</td>
    </tr>
')?>



</table>
<div style="height:30px; line-height:30px;"><?=$pagenav?></div>
<?php
}else{
	echo "<script>top.layer.msg('没有权限查看市场评论！请联系客服！');</script>";
}
?>
<script type="text/javascript" src="../xheditor/jquery/jquery-1.4.4.min.js"></script> 
<script type="text/javascript" src="../xheditor/xheditor.js"></script>
<script type="text/javascript" src="../xheditor/xheditor_lang/zh-cn.js"></script>
</body>
</html>

