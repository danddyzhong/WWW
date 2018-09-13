<?php
require_once '../include/common.inc.php';
if($_SESSION['login_gid']<1){exit('<script>alert("你还没有登录！");top.location.href="/room/minilogin.php"</script>');}
$uid=$_SESSION['login_uid'];
$userinfo=$db->fetch_row($db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.uid='{$uid}'"));
$txlog=$db->fetch_row($db->query("select sum(wmoney) as money_1 from  {$tablepre}member_tixian  where uid='{$uid}' and status=0"));
$userinfo['money_1']=intval($userinfo[money])-intval($txlog["money_1"]);
$msg="";
if(isset($save)){
	$wmoney=intval($wmoney);

	if($wmoney>intval($userinfo['money_1'])){$msg="余额不足!";}
	else if($wmoney&&$wtype){
		$wtime=date("Y-m-d H:i:s",time());
		$db->query("insert into  {$tablepre}member_tixian(uid,ulogin,wtype,wname,wcode,wmoney,wtime,ip,status)
		values('$uid','$userinfo[username]','$wtype','$wname','$wcode','$wmoney','$wtime','$onlineip',0)
		");
        $userinfo['money_1']=$userinfo['money_1']-$wmoney;
		$msg="申请已经提交，提现成功后从余额扣除！";

	}
	else{
		$msg="提现信息不全！";
	}
	$msg='<blockquote class="layui-elem-quote" style="    border-left: 5px solid red; color:coral">'.$msg.'</blockquote>';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>申请提现</title>
  <link rel="stylesheet" href="../layui/css/layui.css">
</head>
<body>
<ul class="layui-nav">
  <li class="layui-nav-item"><img src="/face/img.php?t=p1&u=<?=$_SESSION['login_uid']?>" width="40" class="layui-circle" style="margin-right:20px;"></li>
  <li class="layui-nav-item "><a href="/user/recharge.php">金币</a></li>
  <li class="layui-nav-item  layui-this"><a href="/user/withdraw.php">提现</a></li>
  <li class="layui-nav-item "><a href="withdraw_log.php">提现记录</a></li>
</ul>

<div style="margin:5px;">
<blockquote class="layui-elem-quote">
  申请提现 余额 <font style="color:#F60">￥<?=$userinfo['money']?></font>可提现：<font style="color:#F60">￥<?=$userinfo['money_1']?></font>
</blockquote>

<?=$msg?>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>提现信息</legend>
</fieldset>
<form class="layui-form  layui-form-pane" action="?save" method="post" style="margin-left:5px;">
  <div class="layui-form-item">
    <label class="layui-form-label">提现金额</label>
    <div class="layui-input-inline">
      <input type="number" name="wmoney" lay-verify="wmoney" placeholder="最少100元,整数" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
<label class="layui-form-label">提现方式</label>
    <div class="layui-input-inline">
      <select name="wtype">
        <option value="平台兑换">平台兑换</option>
      </select>
    </div>
	</div>
  <div class="layui-form-item">
    <label class="layui-form-label" style="font-size: 13px;">平台会员账号</label>
    <div class="layui-input-inline">
      <input type="text" name="wname" lay-verify="wname" placeholder="请输入" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item" style="display:none">
    <label class="layui-form-label">帐号信息</label>
    <div class="layui-input-inline">
      <input type="text" name="wcode" lay-verify="wcode" placeholder="请输入" autocomplete="off" class="layui-input">
    </div>
  </div>
<button class="layui-btn layui-btn-danger" lay-submit="" >提交</button></a>
</form>
<br>
<blockquote class="layui-elem-quote">
   兑换请联系红包管理员<!--QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=2308777636&site=qq&menu=yes" target="_blank">2308777636-->
</blockquote>
</div>
<script src="../layui/layui.js"></script>
 <script>
 
//一般直接写在一个js文件中
layui.use(['form', 'layedit', 'laydate'], function(){
  var layer = layui.layer
  ,form = layui.form();

  //自定义验证规则
  form.verify({
      wmoney: function(value){
      if(parseInt(value) < 100){
        return '提现金额至少100元';
      }
	  if(parseInt(value)><?=$userinfo['money_1']?>){
		  return '可提现余额不足';
	  }
    },  
    wname: function(value){
      if(value.length < 2){
        return '请输入正确的帐号名称';
      }
    },
	wcode: function(value){return;
      if(value.length < 5){
        return '请输入正确的帐号信息';
      }
    }
  });
});
</script> 
</body>
</html>