<?php
require_once '../include/common.inc.php';
function app_wt_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_wt where zt=0";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}

switch($act){
	case "wt_re": 	
		$db->query("update {$tablepre}apps_wt set a='$a', auser='$auser' where id='$id'");
		$str="<font style='border-bottom:1px solid #999; color:red;font-size:14px;'>[回答问题]</font><br>问题编号【{$id}】有了答案！请查看 …… [<font style='color:red;  cursor:pointer' onClick='$(\\\"#app_2\\\").trigger(\\\"click\\\")'>详细</font>]";
		exit('<script>top.app_sendmsg("'.$str.'");location.href="?"</script>');
	break;	
	case "wt_add":
		$quser=$_SESSION['login_user'];
		$db->query("insert into {$tablepre}apps_wt(q,quser,zt,qtime)values('$q','$quser',0,'".gdate()."')");
		$str="<font style='border-bottom:1px solid #999; color:#09F;font-size:14px;'>[提出问题]</font><br>问题【{$q}】期待答案！ …… [<font style='color:red;  cursor:pointer' onClick='$(\\\"#app_2\\\").trigger(\\\"click\\\")'>详细</font>]";
		exit('<script>top.app_sendmsg("'.$str.'");location.href="?"</script>');
	break;
}

$row=$db->fetch_row($db->query("select * from {$tablepre}apps_wt where id='$id'"));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>在线答疑</title>
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
if(check_auth('wt_re')&&$act=="wt_view"){
?>
<form action="?act=wt_re&id=<?=$row[id]?>" method="post" enctype="application/x-www-form-urlencoded">
<table width="100%" cellspacing="0" id="mytable"  style="border-left: 1px solid #C1DAD7;border-top: 1px solid #C1DAD7; margin-bottom:5px;">
          <tr>
            <td width="30" class="tableleft" style="width:80px;">问题：</td>
            <td colspan="3"><?=$row[q]?><br><script>document.write(ftime(<?=$row[q]?>)); </script></td>
      </tr>
          <tr>
            <td class="tableleft">答案：</td>
            <td colspan="3"><textarea name="a" rows="3" id="a" style="width:98%"><?=$row[a]?></textarea></td>
          </tr>
          <tr>
            <td class="tableleft">提问：</td>
            <td>
            <?=$row[quser]?></td>
            <td width="60"><span class="tableleft">回答</span>：</td>
            <td width="100"><input name="auser" type="hidden" id="auser" value="<?=$_SESSION['login_user']?>"><?=$_SESSION['login_user']?></td>
          </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td colspan="3"><input type="submit" name="button" id="button" value="回答问题"></td>
          </tr>
    </table>
</form>
<?php
}
if(check_auth('wt_add')){
?>
<form action="?act=wt_add" method="post" enctype="application/x-www-form-urlencoded">
<table width="100%" cellspacing="0" id="wt_add"  style="border-left: 1px solid #C1DAD7;border-top: 1px solid #C1DAD7; margin-bottom:5px; display:none">
          <tr>
            <td width="30" class="tableleft" style="width:80px;">问题：</td>
            <td><textarea name="q" rows="3" id="q" style="width:98%"></textarea></td>
      </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="发布问题"></td>
          </tr>
    </table>
</form>
<div style="margin:5px 0px;"><button onClick="document.getElementById('wt_add').style.display=''">提出问题</button></div>
<?php
}
else {
	echo '<div style="margin:5px 0px;"><font style="color:red">没有提问权限</font></div>';
}
if(check_auth('wt_view')){
?>
<table width="100%" cellspacing="0" id="mytable">

      <tr  >
        <th width="30" align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">编号</th>
        <th  align="left" bgcolor="#FFFFFF">问题/答案</th>
  </tr>
      

<?php
echo app_wt_list(10,$key,'
    <tr>
    <td align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">{id}</td>
      <td align="left" bgcolor="#FFFFFF">问题：{q} ( {quser} <script>document.write(ftime({qtime})); </script> )<br>
      答案：{a} ( {auser} ) 【<a href="?id={id}&act=wt_view">回答</a>】
      </td>
      
    </tr>
')?>



</table>
<div style="height:30px; line-height:30px;"><?=$pagenav?></div>
<?php
}else{
	echo "<script>top.layer.msg('没有权限查看在线答疑！请联系客服！');</script>";
}
?>
</body>
</html>

