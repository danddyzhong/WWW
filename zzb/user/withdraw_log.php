<?php
require_once '../include/common.inc.php';
if($_SESSION['login_gid']<1){exit('<script>alert("你还没有登录！");top.location.href="/room/minilogin.php"</script>');}
$uid=$_SESSION['login_uid'];
function tixian_list($num,$name,$tpl){
    global $db,$tablepre,$firstcount,$displaypg;
    $uid=$_SESSION['login_uid'];
    $sql="select * from {$tablepre}member_tixian where uid='$uid'";


    $count=$db->num_rows($db->query($sql));
    pageft($count,$num,"");
    $sql.=" order by id desc";
    $sql.=" limit $firstcount,$displaypg";
    $query=$db->query($sql);
    return for_each($query,$tpl);
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
  <li class="layui-nav-item  "><a href="/user/withdraw.php">提现</a></li>
  <li class="layui-nav-item layui-this"><a href="/user/withdraw_log.php">提现记录</a></li>
</ul>

<div style="margin:5px;">
<blockquote class="layui-elem-quote">
  提现记录 最近10条
</blockquote>

<script>
    var s=new Array();
    s[2]="<font style='color:red'>驳回</font>";
    s[1]="<font style='color:#090'>到账</font>";
    s[0]="<font style='color:#090'>待处理</font>";
</script>

    <table class="layui-table" lay-size="sm">
        <colgroup>
            <col width="90">
            <col>
            <col>
            <col>
        </colgroup>
        <tbody>
        <?php
        echo tixian_list(10,'','
        <tr>
            <td>申请时间</td><td>{wtime}</td></tr><tr>
            <td>金额</td><td>{wmoney}</td></tr><tr>
            <td>状态</td><td><script>document.write(s[{status}]); </script></td></tr><tr>
            <td>说明</td><td>{ordercode}</td></tr>
            <tr><td colspan="2">&nbsp;</td></tr>
        ')?>


        </tbody>
    </table>
</div>

</body>
</html>