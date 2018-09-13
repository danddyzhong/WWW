<?php
require_once '../include/common.inc.php';
function app_hd_add($ktime,$ptime,$sp,$kcj,$lx,$cw,$zsj,$zyj,$username,$pcj,$sn,$rid){
	global $db,$tablepre;
	$time=gdate();
	$ktime=strtotime($ktime);
	$ptime=strtotime($ptime);
	$username=$_SESSION['login_user'];
	$db->query("insert into {$tablepre}apps_hd(ktime,sp,kcj,lx,cw,zsj,zyj,username,sn,ttime,rid)values('$ktime','$sp','$kcj','$lx','$cw','$zsj','$zyj','$username','$sn','$time','$rid')");
}
function app_hd_userinfo($username,$tpl){
	global $db,$tablepre;
	if($username=="")return "";
	$query=$db->query("select m.*,ms.*
						  from {$tablepre}members m,{$tablepre}memberfields ms
						  where m.uid=ms.uid and m.username='{$username}'
						  ");
	
	return for_each($query,$tpl);
}
function app_hd_list($num,$rid,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_hd where rid='$rid'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	while($row=$db->fetch_row($query)){
		$t=$tpl;
		if($row['username']==$_SESSION['login_user']&&$row['pcj']==""){
			$t=str_replace('{pcj}',"<a href=\"javascript:bt_hd_pc('{$row[id]}','{$row[lx]}','{$row[sp]}')\">平仓</a>",$t);
		}
		if($row['username']==$_SESSION['login_user']){
			$sn=urlencode($row[sn]);
			$t=str_replace('{username}',"{username} <!--<a href=\"javascript:bt_hd_del('{$row[id]}','{$row[lx]}','{$row[sp]}')\">删</a>--> <a href=\"javascript:bt_hd_edit('{$row[id]}','{$row[kcj]}','{$row[pcj]}','{$row[zsj]}','{$row[zyj]}','{$sn}')\">改</a>",$t);
		}
		if(strpos($row[lx],'买')!==false&&$row['pcj']!=""){
			$t=str_replace('{yld}',round($row['pcj']-$row['kcj'],2),$t);
		}
		else if(strpos($row[lx],'卖')!==false&&$row['pcj']!=""){
			$t=str_replace('{yld}',round($row['kcj']-$row['pcj'],2),$t);
		}else{
			$t=str_replace('{yld}','',$t);
		}
		$t=str_replace('{username}',app_hd_userinfo($row['username'],'{nickname}'),$t);
		foreach($row as $k=>$value){
			$t=str_replace('{'.$k.'}',$value,$t);	
		}
		$str.=$t;
		
	}
	return $str;	
}
switch($act){
	case "z":
		if($_SESSION['z'.$id]==""&&$_COOKIE['z'.$id]==""){
			$db->query("update {$tablepre}apps_hd set z=z+1 where id='$id' ");
			$_SESSION['z'.$id]=1;
			setcookie('z'.$id, '1', gdate()+315360000);
		}
	break;
	case "hd_del":
		//$db->query("delete from {$tablepre}apps_hd where username='$_SESSION[login_user]' and id='$id'");
	break;
	case "app_hd_pc":
		if(check_auth('hd_add')){
		$db->query("update {$tablepre}apps_hd set pcj='{$pc_pcj}',ptime='".gdate()."' where id='{$pc_id}'");
		$str="<font style='font-weight:bold;font-size:14px;' class='flash1'>[ 交易提醒 ]</font><br>单号：$pc_id,$pc_lx,$pc_sp 平仓 [ <font style='font-size:12px;cursor:pointer' onClick='$(\\\"#app_1\\\").trigger(\\\"click\\\")'>详细</font> ]";
		exit('<script>top.app_sendmsg("'.$str.'");location.href="?rid='.$rid.'"</script>');
		}
	break;
	case "app_hd_edit":
		if(check_auth('hd_add')){
		//zsj='{$edit_zsj}',zyj='{$edit_zyj}',
		$db->query("update {$tablepre}apps_hd set sn='{$edit_sn}' where id='{$edit_id}'");
		$str="<font style='font-weight:bold;font-size:14px;'  class='flash1'>[ 交易提醒 ]</font><br>单号：$edit_id,开仓价：$edit_kcj 修改 [<font style='font-size:12px;cursor:pointer' onClick='$(\\\"#app_1\\\").trigger(\\\"click\\\")'>详细</font>]";
		exit('<script>top.app_sendmsg("'.$str.'");location.href="?rid='.$rid.'"</script>');
		}
	break;
	case "app_hd_add": 	
		if(check_auth('hd_add')){
		app_hd_add($ktime,$ptime,$sp,$kcj,$lx,$cw,$zsj,$zyj,$username,$pcj,$sn,$rid);
		$id=$db->insert_id();
		$str="<font style='font-weight:bold;font-size:14px;'  class='flash1'>[ 交易提醒 ]</font><br>单号：$id,$lx,$sp …… [<font style='font-size:12px; cursor:pointer' onClick='$(\\\"#app_1\\\").trigger(\\\"click\\\")'>详细</font>]";
		exit('<script>top.app_sendmsg("'.$str.'");location.href="?rid='.$rid.'"</script>');
		}
	break;	
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>交易提醒</title>
</head>


<style type="text/css">
/* CSS Document */
*{font-family: "微软雅黑", "宋体", Arial, sans-serif;}
body {
 font: normal 12px auto  Microsoft Yahei, Verdana, Geneva, sans-serif; 
 color: #000;
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
 text-align: right;
}
th {
 color: #000;
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
 font-size:12px;
 padding: 6px 6px 6px 12px;
 color: #000;
}

td.alt {
 background: #F5FAFA;
 color: #797268;
}
th.spec {
 border-left: 1px solid #C1DAD7;
 border-top: 0;
 background: #fff ;
 font: bold 10px ;
}
th.specalt {
 border-left: 1px solid #C1DAD7;
 border-top: 0;
 background: #f5fafa ;
 font: bold 10px;
 color: #797268;
}
tr{ background: #fff }
tr:hover{background: #f5fafa}
tr:hover td {background:none;}
</style>
<script src="../room/script/jquery.min.js"></script>



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
	if(!time)return "";
	return new Date(time*1000).Format("yyyy-MM-dd hh:mm"); ; 
}
function bt_hd_pc(id,lx,sp){
	//$("#act_pc_from").find('input[type=text]').val("");
	$("#pc_lx").val(lx);
	$("#pc_sp").val(sp);
	$("#pc_id").val(id);
	$("#pc_no_id").text(id);
	$("#pc_pcj").focus();
	$("#act_add_from").hide();
	$("#act_pc_from").show();
	$("#act_edit_from").hide();
}
function bt_hd_del(id){
	if(confirm('确定删除？')){location.href="?act=hd_del&id="+id;}
}
function bt_hd_add(){
	//$("#act_add_from").find('input[type=text]').val(""); 
	$("#cw").focus();
	$("#act_add_from").show();
	$("#act_pc_from").hide();
	$("#act_edit_from").hide();
}
function bt_hd_edit(id,kcj,pcj,zsj,zyj,sn){
	$("#act_add_from").hide();
	$("#act_pc_from").hide();
	$("#act_edit_from").show();
	
	$('#edit_no_id').html(id);
	$('#edit_id').val(id);
	$('#edit_kcj').val(kcj);
	$('#edit_zsj').val(zsj);
	$('#edit_zyj').val(zyj);
	$('#edit_sn').val(decodeURIComponent(sn));
	$('#edit_kcj').attr('readonly',true);
	$('#edit_zsj').attr('readonly',true);
	$('#edit_zyj').attr('readonly',true);
	if(pcj!=""){
		$('#edit_kcj').attr('readonly',true);
		$('#edit_zsj').attr('readonly',true);
		$('#edit_zyj').attr('readonly',true);
	}
}
</script>
<?php
if(check_auth('hd_add')){
?>
<form action="" method="post" enctype="application/x-www-form-urlencoded">
<table width="100%" cellspacing="0" id="act_edit_from"  style="border-left: 1px solid #C1DAD7;border-top: 1px solid #C1DAD7; margin-bottom:5px; display:none ">
          <tr>
            <td width="80" align="center" class="tableleft" >单号：<span id="edit_no_id"></span></td>
            <td width="50" align="right" class="tableleft" >开仓价：</td>
            <td><input type="text" name="edit_kcj" id="edit_kcj" readonly></td>
            <td width="50" align="right">止损价：</td>
            <td><input type="text" name="edit_zsj" id="edit_zsj" ></td>
            <td width="50" align="right">止盈价：</td>
            <td><input type="text" name="edit_zyj" id="edit_zyj" >&nbsp;</td>
            <td> </td>
      </tr>
      <tr>
            <td width="80" align="center" class="tableleft" >备注：<span id="edit_no_id"></span></td>
            <td colspan="6" align="right" class="tableleft" ><input name="edit_sn" type="text" id="edit_sn"  style="width:98%">&nbsp;</td>
            <td>
            <input name="act"  type="hidden" id="act" value="app_hd_edit"/> 
            <input name="edit_id"  type="hidden" id="edit_id" />
            <input name="rid"  type="hidden" value="<?=$rid?>" />
            <input type="submit" name="button2" id="button2" value="修改">
            <input type="button" name="button2" id="button2" value="取消" onClick="$('#act_edit_from').hide()"></td>
      </tr>
    </table>
</form>
<form action="" method="post" enctype="application/x-www-form-urlencoded">
<table width="100%" cellspacing="0" id="act_pc_from"  style="border-left: 1px solid #C1DAD7;border-top: 1px solid #C1DAD7; margin-bottom:5px; display:none ">
          <tr>
            <td width="80" align="center" class="tableleft" >单号：<span id="pc_no_id"></span></td>
            <td width="50" align="right" class="tableleft" >类型：</td>
            <td><input type="text" name="pc_lx" id="pc_lx" readonly></td>
            <td width="80" align="right">商品：</td>
            <td><input type="text" name="pc_sp" id="pc_sp" readonly></td>
            <td align="right">平仓价：</td>
            <td><input type="text" name="pc_pcj" id="pc_pcj">&nbsp;</td>
            <td>
            <input name="act"  type="hidden" id="act" value="app_hd_pc"/> 
            <input name="pc_id"  type="hidden" id="pc_id" />
            <input name="rid"  type="hidden" value="<?=$rid?>" />
            <input type="submit" name="button2" id="button2" value="平仓"></td>
      </tr>
    </table>
</form>
<form action="" method="post" enctype="application/x-www-form-urlencoded">
<table width="100%" cellspacing="0" id="act_add_from"  style="border-left: 1px solid #C1DAD7;border-top: 1px solid #C1DAD7; margin-bottom:5px; display:none ">
          <tr>
            <td width="30" align="right" class="tableleft" style="width:80px;">类型：</td>
            <td><select name="lx" id="lx">
              <option value="现价买入">现价买入</option>
              <option value="现价卖出">现价卖出</option>
              <option value="到价买入">到价买入</option>
              <option value="到价卖出">到价卖出</option>
              <option value="限价买入">限价买入</option>
              <option value="限价卖出">限价卖出</option>
            </select></td>
            <td width="80" align="right">仓位：</td>
            <td><input name="cw" type="text" id="cw" style="ime-mode:disabled" value="20">
            %</td>
            <td align="right"><span class="tableleft">商品：</span></td>
            <td>
			<input name="sp" type="text" id="sp" value="燃油" >
			<select onChange="$('#sp').val(this.value)">
              <option value="燃油">燃油</option>
              <option value="甬油">甬油</option>
              <option value="甬银">甬银</option>
            </select></td>
            <td>
            <input name="act"  type="hidden" id="act" value="app_hd_add"/> 
            <input name="ktime"  type="hidden" id="ktime" value="<?=date('Y-m-d H:i:s',gdate())?>"  class="calendar calendar-time"  style="ime-mode:disabled"/></td>
      </tr>
          <tr>
            <td align="right" class="tableleft">开仓价：</td>
            <td><input name="kcj" type="text" id="kcj"  style="ime-mode:disabled"></td>
            <td align="right"><span class="tableleft">止损价：</span></td>
            <td><input name="zsj" type="text" id="zsj"  style="ime-mode:disabled"></td>
            <td align="right">止盈价：</td>
            <td><input name="zyj" type="text" id="zyj"  style="ime-mode:disabled"></td>
            <td></td>
          </tr>
          <tr>
            <td align="right" class="tableleft">备注：</td>
            <td colspan="5"><input name="sn" type="text" id="sn"  style="width:98%"></td>
            <td><input type="submit" name="button" id="button" value="提交"><input name="rid"  type="hidden" value="<?=$rid?>" /></td>
          </tr>
    </table>
</form>
<div style="margin:5px 0px;"><button onClick="bt_hd_add()">发布交易</button></div>
<?php
}
if(check_auth('hd_view')){
?>
<table width="100%" cellspacing="0" id="mytable">

      <tr  >
        <th width="30" align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">单号</th>
        <th  align="center" bgcolor="#FFFFFF">开仓时间</th>
        <th  align="center" bgcolor="#FFFFFF">类型</th>
        <th  align="center" bgcolor="#FFFFFF">仓位</th>
        <th  align="center" bgcolor="#FFFFFF">商品</th>
        <th align="center" bgcolor="#FFFFFF">开仓价</th>
        <th align="center" bgcolor="#FFFFFF">止损价</th>
        <th align="center" bgcolor="#FFFFFF">止盈价</th>
        <th align="center" bgcolor="#FFFFFF">平仓时间</th>
        <th align="center" bgcolor="#FFFFFF">平仓价</th>
		<th align="center" bgcolor="#FFFFFF">盈利点数</th>
        <th align="center" bgcolor="#FFFFFF">点赞</th>
        <th align="center" bgcolor="#FFFFFF">分析师</th>
		<th align="center" bgcolor="#FFFFFF">备注</th>
  </tr>
      
<?php
echo app_hd_list(20,$rid,'

    <tr>
    <td align="center" bgcolor="#FFFFFF"  style="border-left: 1px solid #C1DAD7;">{id}</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({ktime})); </script></td>
      <td align="center" bgcolor="#FFFFFF">{lx}</td>
      <td align="center" bgcolor="#FFFFFF">{cw}%&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">{sp}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">{kcj}</td>
      <td align="center" bgcolor="#FFFFFF">{zsj}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">{zyj}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({ptime})); </script></td>
      <td align="center" bgcolor="#FFFFFF">{pcj}&nbsp;</td>
	  <td align="center" bgcolor="#FFFFFF">{yld}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">{z} <a href="?id={id}&act=z">赞</a></td>
      <td align="center" bgcolor="#FFFFFF">{username}</td>
      <td align="center" bgcolor="#FFFFFF">{sn}</td>
    </tr>
 ')?>   


</table>
<div style="height:30px; line-height:30px;"><?=$pagenav?></div>
<?php
}else{
	echo "<script>top.layer.msg('没有权限查看交易数据！请联系客服！');</script>";
}
?>
</body>
</html>

