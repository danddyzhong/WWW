<?php
require_once '../include/common.inc.php';
if($_SESSION['login_gid']<1){exit('<script>alert("你还没有登录！");top.location.href="/room/minilogin.php"</script>');}
$uid=$_SESSION['login_uid'];
$userinfo=$db->fetch_row($db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.uid='{$uid}'"));

if(isset($duihuan)&&floatval($dh_money)>0){
	$dmoney=floatval($dh_money);
	$dgold=$dmoney*100;
	$db->query("update {$tablepre}members set money=money-$dmoney,gold=gold+$dgold where uid='$uid' and money>=$dmoney");
}
$userinfo=$db->fetch_row($db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.uid='{$uid}'"));

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>用户充值</title>
  <link rel="stylesheet" href="../layui/css/layui.css">
</head>
<body>
<ul class="layui-nav">
  <li class="layui-nav-item"><img src="/face/img.php?t=p1&u=<?=$_SESSION['login_uid']?>" width="40" class="layui-circle" style="margin-right:20px;"></li>
  <li class="layui-nav-item layui-this"><a href="#">金币</a></li>
  <li class="layui-nav-item"><a href="/user/withdraw.php">提现</a></li>
    <li class="layui-nav-item "><a href="withdraw_log.php">提现记录</a></li>
</ul>

<div style="margin:5px;">
<!--
<blockquote class="layui-elem-quote">
  在线充值
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin: 10px 0px;">
  <legend>接口关闭，请联系客服充值</legend>
</fieldset>

<form class="layui-form" action="pay.php" method="post" >
<ul	style=" margin-left:40px;">
	<?php
	$query=$db->query("select * from {$tablepre}payitem order by id ");
	while($row=$db->fetch_row($query)){		
		echo "<li><input type='radio' name='gid' value='{$row[id]}' title='充值￥<b style=\"color:#F60\">{$row[rmb]}</b> 获 {$row[sn]}' checked=''> </li>";
	}
	?>
</ul>
<fieldset class="layui-elem-field layui-field-title" style="margin: 10px 0px;">
  <legend>选择支付方式</legend>
</fieldset>
<ul	style=" margin-left:40px;">
	<li><input type="radio" name="paytype" value="alipay" title="支付宝扫码支付" checked=""> </li>
    <li><input type="radio" name="paytype" value="weixin" title="微信扫码支付"> </li>
</ul>
<hr>
<ul	style=" margin-left:40px;">
	<li><button class="layui-btn layui-btn-danger">立即充值</button></li>
</ul>

</form>-->
<blockquote class="layui-elem-quote">
  兑换金币 可用余额 <font style="color:#F60">￥<?=$userinfo['money']?></font>,金币 <font style="color:#F60"><?=$userinfo['gold']?></font> 1元兑换100金币
</blockquote>
<form class="layui-form" action="?duihuan" method="post" >

<ul	style=" margin-left:10px;margin-top:50px;">
<div class="layui-form-item">
    <div class="layui-inline">
      <div class="layui-input-inline" style="width: 100px;">
        <input type="number" name="dh_money" placeholder="余额" autocomplete="off" class="layui-input" onkeyup="$('#showjb').val(this.value*100)">
      </div>
      <div class="layui-form-mid">兑换</div>
      <div class="layui-input-inline" style="width: 100px;">
        <input type="number" name="price_max" placeholder="金币" autocomplete="off" class="layui-input" readonly id="showjb">
      </div>
	  <div class="layui-input-inline" style="width: 100px;">
<button class="layui-btn layui-btn-danger">立即兑换</button>
      </div>
    </div>
  </div>
</ul>

</form>
</div>
<script src="/room/script/jquery.min.js"></script>
<script src="../layui/layui.js"></script>
<script>
layui.use(['layer', 'form'], function(){
  var layer = layui.layer
  ,form = layui.form();
  
});
</script> 

</body>
</html>