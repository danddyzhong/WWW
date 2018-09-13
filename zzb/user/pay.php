<?php
require_once '../include/common.inc.php';
if($_SESSION['login_gid']<1){exit('<script>alert("你还没有登录！");top.location.href="/room/minilogin.php"</script>');}
$query=$db->query("select * from {$tablepre}payitem where id='$gid'");
if($db->num_rows($query)<1){header("location:recharge.php");}
$payitem=$db->fetch_row($query);
//获取支付二维码 设置过期未支付 二维码
$otime=time()-5*60;
$ntime=time();
$db->query("update {$tablepre}payitem_ewm set stime=0,state=0 where pid='$gid' and stime<{$otime}");
$query=$db->query("select * from {$tablepre}payitem_ewm where  stime=0 and state=0 and etype='{$paytype}' limit 1");
if($db->num_rows($query)<1){exit('<script>alert("支付系统忙，请稍候或选择其他充值项目再试！");top.location.href="recharge.php"</script>');}
$ewm=$db->fetch_row($query);

//生成订单
$db->query("insert into {$tablepre}payorder(uid,payid,payordertime,payip,pay,paytime,sn,rmb,ptype)values('$u_id','$gid','$ntime','$onlineip',0,0,'$ewm[sn]','$payitem[rmb]','$paytype')");
$payorderid=$db->insert_id();

//设置占用
$db->query("update {$tablepre}payitem_ewm set stime={$ntime},state=1,orderid='$payorderid' where id='{$ewm[id]}'");
?>
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> 账户充值 - 扫描支付！</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="/room/script/jquery.min.js"></script>
    <link href="images/wechat.css" rel="stylesheet" media="screen">
    <style type="text/css">
        .time-item strong {
            background: #DC7C00;
            color: #fff;
            line-height: 49px;
            font-size: 22px;
            font-family: Arial;
            padding: 0 10px;
            margin-right: 10px;
            border-radius: 5px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
    </style>
    <script type="text/javascript">
        var intDiff = parseInt(300);/*倒计时总秒数量*/
        function timer(intDiff) {
            window.setInterval(function () {
                var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;/*时间默认值*/
                if (intDiff > 0) {
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                $('#day_show').html(day + "天");
                $('#hour_show').html('<s id="h"></s>' + hour + '时');
                $('#minute_show').html('<s></s>' + minute + '分');
                $('#second_show').html('<s></s>' + second + '秒');
                intDiff--;
                if (intDiff <= 0){
                    $('#qrcode_image').attr('src', '');
					$(".body").hide();
                    alert('二维码已经过期');
                    window.opener= null;
                    window.open('','_self');
                    window.close();
                }
            }, 1000);
        }
        $(function () {
            timer(intDiff);
        });
    </script>
</head>
<body><div id="qrcode"></div>

<div class="body">
<!--
    <h1 class="mod-title">
        <img src="images/<?=$paytype?>.jpg"  style="height:47px; margin-top:5px;">
    </h1>-->
    <div class="mod-ct">
        <div class="order">
        </div>
        <!--<div class="amount">￥</div>-->
        <div class="qr-image" style="">
            <span id="erweima">
                <img class="ft-center" id="qrcode_image" src="<?=$ewm['ewm']?>">
            </span>
            <br>
            <div class="time-item">
                <br>
                距离该订单过期还有<br>
                <strong id="minute_show"><s></s>00分</strong>
                <strong id="second_show"><s></s>00秒</strong>
            </div>
        </div>
        <!--detail-open 加上这个类是展示订单信息，不加不展示-->
        <!--
        <div class="detail detail-open" id="orderDetail" style="">
            <dl class="detail-ct">
                <dt>订单号</dt>
                <dd id="storeName">20170814164331496</dd>
            </dl>
            <a class="arrow"><i class="ico-arrow"></i></a>
        </div>
        -->
        <div class="tip">
            <span class="dec dec-left"></span>
            <span class="dec dec-right"></span>
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p>扫描二维码完成支付</p>
            </div>
        </div>
    </div>

    <div class="foot">
        <div class="inner">
            <p><?=$webcopyright?></p>
        </div>
    </div>

</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        _nCheckingVerifyCode = setInterval(function() {
                $.ajax({
                    type: 'POST',
                    url: "/ajax.php?act=orderstate",
                    dataType: "json",
                    data: {
                        'oid': '<?=$payorderid?>'
                    },
                    success: function(data) {
                        if (data.code == 1) {
                            clearInterval(_nCheckingVerifyCode);
                            $('#qrcode_image').attr('src', '');
                            //location.href = data.url;
							alert("已充值，请至用户中心查验");
							window.opener= null;
                            window.open('','_self');
                            window.close();
                        } else if (data.code == 0 && data.msg) {
                            clearInterval(_nCheckingVerifyCode);
                            $('#qrcode_image').attr('src', '');
                            alert(data.msg);
                            window.opener= null;
                            window.open('','_self');
                            window.close();
                            /*location.href = data.url;*/
                        }
                    }
                })
            },
            3000)
    });
</script>

</body></html>