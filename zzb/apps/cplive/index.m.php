<?php
require_once '../../include/common.inc.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="default">
<meta name="browsermode" content="application">
<meta name="apple-touch-fullscreen" content="no">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<script src="../../room/script/jquery.min.js"></script>
<script src="../../room/script/jquery.nicescroll.min.js"></script>
<style>
html{
	font-size:12px;
}
</style>
</head>


<style type="text/css">
#Cp-live{ width:100%;}
#Cp-live .Cp-list{width: 100%;color:#fff; clear: both; }
#Cp-live .Cp-list-bjkl8{width: 100%;color:#fff;clear: both;}
#Cp-live .Cp-list .Cp-list-limg{width: 10%;height: 100%;float: left;text-align: center; margin-top:14px;}
#Cp-live .Cp-list .Cp-list-limg img{width: 35px;margin-top:5px;}
#Cp-live .Cp-list .Cp-list-center-up{float: left;height: 20px;width:90%; }
#Cp-live .Cp-list .Cp-list-center-up span{line-height: 20px; margin-left:5px;}
#Cp-live .Cp-list .Cp-list-center-down{height: 40px;width:90%;float: left}
#Cp-live .Cp-list .Cp-list-center-down-bjkl8{width:90%;float: left}
#Cp-live .Cp-list .Cp-list-center-down .kj-box{height: 35px;width: 95%;margin-left: 5px;border:1px solid #ddd;border-radius: 4px;}
#Cp-live .Cp-list .Cp-list-center-down .kj-box-bjkl8{height: 70px;width: 95%;margin-left: 5px;border:1px solid #ddd;border-radius: 4px;}

#Cp-live .Cp-list .Cp-list-center-down .kj-box img {margin-top: 4px;border-radius:16px;margin-left: 2px; width:25px;}
#Cp-live .Cp-list .Cp-list-center-down .kj-box-bjkl8 img {margin-top: 4px;border-radius:16px;margin-left: 2px; width:24px;}
#Cp-live .Cp-list .Cp-right{width: 27%;height: 100%;float: left;float: left;margin-top: -40px;}
#Cp-live .Cp-list .Cp-right span{margin-left:10px;text-align: center;display: block;float: left;}
#Cp-live .Cp-list .Cp-right .kj-left{display:block;margin-left:30px;margin-top: 12px;}
#Cp-live .Cp-list .Cp-right .is{margin-top:20px;float:left;width:50px;height:50px;display:block;border-radius:3px;background: url(./cpimg/time_bg.png);color:#fff;}
#Cp-live .Cp-list .Cp-right .is{margin-top:20px;float:left;width:50px;height:50px;display:block;border-radius:3px;background: url(./cpimg/time_bg.png);color:#fff;}
#Cp-live .Cp-list .Cp-right .im{overflow:hidden;text-align:center;margin-top:20px;float:left;width:50px;height:50px;display:block;border-radius:3px;background: url(./cpimg/time_bg.png);color:#fff;}
#Cp-live .Cp-list .Cp-right .hk6{text-align:center;margin-top:20px;float:left;width:110px;height:50px;display:block;border-radius:3px;background: url(./cpimg/time_bg.png);color:#fff;}
.none{ display:none}
.cplist{ width:100%; height:35px; border-bottom:1px solid #ccc;    padding-bottom: 5px;    margin-bottom: 5px; margin-top:5px;}
.cplist li{float:left;width:10%;     list-style: none;}
.cplist li img { width:35px;}
</style>
<body style="background:url(/upload/upfile/day_170718/201707182127258696.jpg);">
<div class="cplist">
	<li onclick="showcp('1')"><img src="./cpimg/1.png"></li>
	<li onclick="showcp('2')"><img src="./cpimg/2.png"></li>
	<li onclick="showcp('3')"><img src="./cpimg/3.png"></li>
	<li onclick="showcp('4')"><img src="./cpimg/4.png"></li>
	<li onclick="showcp('5')"><img src="./cpimg/5.png"></li>
	<li onclick="showcp('6')"><img src="./cpimg/6.png"></li>
	<li onclick="showcp('7')"><img src="./cpimg/7.png"></li>
	<li onclick="showcp('8')"><img src="./cpimg/8.png"></li>
	<li onclick="showcp('9')"><img src="./cpimg/9.png"></li>
	<li onclick="showcp('10')"><img src="./cpimg/10.png"></li>
</div>
<div id="Cp-live" >

				<div class="Cp-list none " id="cp1">
					<div class="Cp-list-limg"><img src="./cpimg/1.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>北京赛车(pk10)最新开奖<span id="bjpk10-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="bjpk10-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="bjpk10-number"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="Cp-list none" id="cp3">
					<div class="Cp-list-limg"><img src="./cpimg/3.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>重庆时时彩最新开奖<span id="cqssc-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="cqssc-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="cqssc-number"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="Cp-list none" id="cp2">
					<div class="Cp-list-limg"><img src="./cpimg/2.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>香江彩最新开奖<span id="hk6-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="hk6-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="hk6-number"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="Cp-list none" id="cp7">
					<div class="Cp-list-limg"><img src="./cpimg/7.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>江苏快三最新开奖<span id="jsk3-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="jsk3-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="jsk3-number"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="Cp-list none" id="cp8">
					<div class="Cp-list-limg"><img src="./cpimg/8.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>福彩3D最新开奖<span id="fc3d-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="fc3d-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="fc3d-number"></span>
							</div>
						</div>
					</div>
					<!-- <div class="Cp-right"><font class="kj-left">下期开奖:<font id="fc3d-next_time">00:00</font></font><span id="fc3d-next" class="hk6">00</span></div> -->
				</div>
				<div class="Cp-list none" id="cp5">
					<div class="Cp-list-limg"><img src="./cpimg/5.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>排列3最新开奖<span id="pl3-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="pl3-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="pl3-number"></span>
							</div>
						</div>
					</div>
					<!-- <div class="Cp-right"><font class="kj-left">下期开奖:<font id="pl3-next_time">00:00</font></font><span id="pl3-next" class="hk6">00</span></div> -->
				</div>
				<div class="Cp-list none" id="cp4">
					<div class="Cp-list-limg"><img src="./cpimg/4.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>广东快乐十分最新开奖<span id="gdklsf-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="gdklsf-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="gdklsf-number"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="Cp-list none" id="cp9">
					<div class="Cp-list-limg"><img src="./cpimg/9.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>重庆快乐十分(幸运农场)最新开奖<span id="cqklsf-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="cqklsf-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="cqklsf-number"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="Cp-list none" id="cp10">
					<div class="Cp-list-limg"><img src="./cpimg/10.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>新疆时时彩最新开奖<span id="xjssc-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="xjssc-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down">
							<div class="kj-box">
								<span id="xjssc-number"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="Cp-list Cp-list-bjkl8 " id="cp6">
					<div class="Cp-list-limg"><img src="./cpimg/6.png"></div>
					<div>
						<div class="Cp-list-center-up">
							<span>北京快乐8最新开奖<span id="bjkl8-expect">x</span>期</span> <span style="float:right;margin-right:10px;">开奖倒计时:<span id="bjkl8-next-m"></span></span>
						</div>
						<div class="Cp-list-center-down Cp-list-center-down-bjkl8">
							<div class="kj-box kj-box-bjkl8">
								<span id="bjkl8-number"></span>
							</div>
						</div>
					</div>
				</div>
				
			</div>


<script>
function formatnumber(strs) 
{
    strimg = '';
    strs = strs.split(',');
    for (i = 0; i < strs.length; i++) 
    {
        if (strs[i].indexOf("+") > 0) {
            strjs = strs[i].split('+');
            strimg = strimg + '<img src="./cpimg/n' + strjs[0] + '.png">';
            strimg = strimg + '<img src="./cpimg/plus.png">';
            strimg = strimg + '<img src="./cpimg/n' + strjs[1] + '.png">';
        } 
        else {
            strimg = strimg + '<img src="./cpimg/n' + strs[i] + '.png">';
        }
    }
    return strimg;
}
function formatnumberhk6(strs) 
{
    strimg = '';
    strs = strs.split(',');
    for (i = 0; i < strs.length; i++) 
    {
        if (strs[i].indexOf("+") > 0) {
            strjs = strs[i].split('+');
            strimg = strimg + '<img src="./cpimg/hk' + strjs[0] + '.png">';
            strimg = strimg + '<img src="./cpimg/plus.png">';
            strimg = strimg + '<img src="./cpimg/hk' + strjs[1] + '.png">';
        } 
        else {
            strimg = strimg + '<img src="./cpimg/hk' + strs[i] + '.png">';
        }
    }
    return strimg;
}
function execFun(fun){
	eval(fun);
}
function showcp(id){
	$(".Cp-list").addClass("none");
	$("#cp"+id).removeClass("none");
}
function indexUpdatapc() {
    $(document).ready(function() {
				
        $.ajax({
            url: 'ppchat_api.php?code=bjpk10&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#bjpk10-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#bjpk10-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+5*60;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('bjpk10-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=cqssc&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#cqssc-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#cqssc-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+10*60;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('cqssc-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=hk6&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#hk6-expect").text(data[0].expect);
                var strbjpk10 = formatnumberhk6(data[0].opencode);
                $("#hk6-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+2*24*3600;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('hk6-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=jsk3&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#jsk3-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#jsk3-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+10*60;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('jsk3-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=fc3d&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#fc3d-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#fc3d-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+24*3600;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('fc3d-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=pl3&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#pl3-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#pl3-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+24*3600;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('pl3-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=gdklsf&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#gdklsf-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#gdklsf-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+10*60;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('gdklsf-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=cqklsf&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#cqklsf-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#cqklsf-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+10*60;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('cqklsf-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=xjssc&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#xjssc-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#xjssc-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+10*60;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('xjssc-next-m',nextopentime-nowtime);
            }
        });
        $.ajax({
            url: 'ppchat_api.php?code=bjkl8&n=1',
            type: 'GET',
            dataType: 'json',
            timeout: 7000,
            cache: false,
            success: function(data) {
                $("#bjkl8-expect").text(data[0].expect);
                var strbjpk10 = formatnumber(data[0].opencode);
                $("#bjkl8-number").html(strbjpk10);
                var opentime=strtotime(data[0].opentime);
				var nextopentime=opentime+5*60;
				var nowtime=strtotime(data[0].nowtime);
				SetRemainTime('bjkl8-next-m',nextopentime-nowtime);
            }
        });
    });
}

indexUpdatapc();
setInterval(indexUpdatapc,30*1000);

function time(){
    return (new Date()).getTime() / 1000;
}
function strtotime(str){
    var _arr = str.split(' ');
    var _day = _arr[0].split('-');
    _arr[1] = (_arr[1] == null) ? '0:0:0' :_arr[1];
    var _time = _arr[1].split(':');
    for (var i = _day.length - 1; i >= 0; i--) {
        _day[i] = isNaN(parseInt(_day[i])) ? 0 :parseInt(_day[i]);
    };
    for (var i = _time.length - 1; i >= 0; i--) {
        _time[i] = isNaN(parseInt(_time[i])) ? 0 :parseInt(_time[i]);
    };
    var _temp = new Date(_day[0],_day[1]-1,_day[2],_time[0],_time[1],_time[2]);
    return _temp.getTime() / 1000;
}
//将时间减去1秒，计算天、时、分、秒 
function SetRemainTime(elm,SysSecond) {
	SysSecond = SysSecond - 1;	 
  if (SysSecond > 0) { 
   var second = Math.floor(SysSecond % 60);             // 计算秒     
   var minite = Math.floor((SysSecond / 60) % 60);      //计算分 
   var hour = Math.floor((SysSecond / 3600) % 24);      //计算小时 
   var day = Math.floor((SysSecond / 3600) / 24);        //计算天
   var str=day + "天" + hour + "小时" + minite + "分" + second + "秒";
   if(SysSecond>=24*3600)str=str;
   else if(SysSecond>=3600)str=hour + "小时" + minite + "分" + second + "秒";
   else if(SysSecond>=60)str= minite + "分" + second + "秒";
   else str= second + "秒";
   $("#"+elm).html(str); 
   window.clearInterval(times["time"+elm]);
   times["time"+elm]=window.setTimeout("SetRemainTime('"+elm+"',"+SysSecond+")", 1000);
  } else {
   $("#"+elm).html("等待开奖数据"); 
	window.clearInterval(times["time"+elm]);
  } 
 }
 var times=[];
</script>

</body>
</html>

