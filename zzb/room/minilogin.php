<?php
require_once '../include/common.inc.php';
switch($act){
	case "login":
		
		$msg=user_login($username,$password);
		if($msg===true){
			if($remember=="1"){
				setcookie("ppchat_user", $username, time()+3600*24*15,'/');
				setcookie("ppchat_user_pwd", $password, time()+3600*24*15,'/');
			}
			exit("<script>top.location.href='/?rid={$rid}';</script>");
		}
		else{ $msg= "<script>alert('{$msg}');</script>";}
	break;
	case "reg":
		$guestexp = '^Guest|'.$cfg['config']['regban']."Guest";
		if(preg_match("/\s+|{$guestexp}/is", $u)||trim($u)=="")
		exit("<script>alert('用户名禁用！');</script>");
		
		$query=$db->query("select uid from {$tablepre}members where username='{$u}' limit 1");
		if($db->num_rows($query))exit("<script>alert('用户名已经被使用!换一个，如{$u}1985');location.href='?rid={$rid}'</script>");
		
		if($cfg[config][chkphone]=="1"){
			if($_SESSION['repwd_yzm_ok']!=1)exit("<script>alert('手机验证码错误!');location.href='?rid={$rid}'</script>");
			$query=$db->query("select uid from {$tablepre}members where phone='{$phone}' limit 1");
			if($db->num_rows($query))exit("<script>alert('手机号码已被注册!');location.href='?rid={$rid}'</script>");
		}
		
		$regtime=gdate();
		$p2 =$p;
		$p=md5($p);
		if(isset($_COOKIE['tg']));
		$tuser=userinfo($_COOKIE['tg'],'{username}');
		if($cfg['config']['regaudit']=='1')$state='0';
		else $state='1';
		$db->query("insert into {$tablepre}members(username,password,sex,email,regdate,regip,lastvisit,lastactivity,gold,realname,gid,phone,fuser,tuser,state)	
values('$u','$p','2','$email','$regtime','$onlineip','$regtime','$regtime','0','$qq','3','$phone','$tuser','$tuser','$state')");
// 		$str ="insert into {$tablepre}members(username,password,sex,email,regdate,regip,lastvisit,lastactivity,gold,realname,gid,phone,fuser,tuser,state)	
// values('$u','$p','2','$email','$regtime','$onlineip','$regtime','$regtime','0','$qq','1','$phone','$tuser','$tuser','$state')";
// 		var_dump($str);
		$uid=$db->insert_id();
		$db->query("replace into {$tablepre}memberfields (uid,nickname)	values('$uid','$u')	");
		$db->query("insert into  {$tablepre}msgs(rid,ugid,uid,uname,tuid,tname,mtime,ip,msg,type)
	values('{$cfg[config][id]}','1','{$uid}','{$u}','{$cfg[config][defvideo]}','{$cfg[config][defvideonick]}','".gdate()."','{$onlineip}','用户注册','2')
		");
		
		$msg=user_login($u,$p2);
		if($msg===true){exit("<script src='script/device.min.js'></script><script>if (!device.desktop()){top.window.location = '/room/m/?rid={$rid}';}else {top.location.href='/index.php?rid={$rid}';}</script>");}
		else{ $msg="<script src='script/device.min.js'></script><script>top.layer.msg('注册成功！$msg',{shift: 6});layer.msg('注册成功！$msg',{shift: 6});if (!device.desktop()){top.window.location = '/room/m/?rid={$rid}';}else {top.location.href='/index.php?rid={$rid}';}</script>";}
	break;
	case "logout":
		unset($_SESSION['login_uid']);
		unset($_SESSION['login_user']);
		setcookie("ppchat_user", "", 0,"/");
		setcookie("ppchat_user_pwd", "", 0,"/");
		session_destroy(); 
		header("location:/index.php?rid={$rid}");
	break;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$cfg['config']['title']?> 登录</title>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />  
<link href="css/minilogin.css" rel="stylesheet" type="text/css"  />
<script src="script/jquery.min.js"></script>
<script src="/room/script/layer.js"></script>
</head>

<body>
<div class="login">
    
    <div class="header">
        <div class="switch" id="switch"><a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);" tabindex="7">快速登录</a>
			<a class="switch_btn" id="switch_login" href="javascript:void(0);" tabindex="8">快速注册</a><div class="switch_bottom" id="switch_bottom" style="position: absolute; width: 66px; left: 0px;"></div>
        </div>
    </div>    
  
    
    <div class="web_qr_login" id="web_qr_login" style="display: block; ">    

            <!--登录-->
            <div class="web_login" id="web_login">
               
               
               <div class="login-box">
    
            
			<div class="login_form">
				<form action="?act=login&rid=<?=$rid?>" method="post" enctype="application/x-www-form-urlencoded"  name="loginform"  id="login_form" class="loginForm" >
                <div class="uinArea" id="uinArea">
                <label class="input-tips user" for="username"></label>
                <div class="inputOuter" id="uArea">
                    
                    <input type="text" id="username" name="username" class="inputstyle"  placeholder="请输入用户名"/>
                </div>
                </div>
                <div class="pwdArea" id="pwdArea">
               <label class="input-tips pwd" for="password"></label> 
               <div class="inputOuter" id="pArea">
                    
                    <input type="password" id="password" name="password" class="inputstyle"  placeholder="登录密码"/>
                </div>
				
                </div>
				<div class="control-password clearfix">
                                                    <label>
			      <input type="checkbox" name="remember" id="remember" value="1">15天内自动登录
			    </label>
				</div>
                                                    
                <div style="margin-top:20px;"><input type="submit" value="登 录" style="width:268px;" class="button_blue"/>
				</div>
				<div style="clear: both;"></div><!--
				<div style="margin-top:20px; height:30px; line-height:25px; ">
				<span style="float:left;    margin-right: 10px;">社区帐号登录</span>
				<a  style="float:left" class="bt_qq" href="javascript://" onclick="top.location.href='/oauth/qq/index.php'"></a>
				</div>-->
              </form>
           </div>
           
            	</div>
               
            </div>
            <!--登录end-->
  </div>

  <!--注册-->
    <div class="qlogin" id="qlogin" style="display:none" >
   
    <div class="web_login"> <form action="?act=reg&rid=<?=$rid?>" method="post" enctype="application/x-www-form-urlencoded" id="regUser">
        <ul class="reg_form" id="reg-ul" style=" margin:10px;">
        		<div id="userCue" class="cue">快速注册请注意格式</div>
				<div style="    margin-left: 49px;">
                <li>
                	
                    <label for="user"  class="input-tips2 user"></label>
                    <div class="inputOuter2">
                        <input type="text" id="u" name="u" maxlength="16" class="inputstyle2" placeholder="2-16位字符"/>
                    </div>
                    
                </li>
                
                <li>
                <label for="passwd" class="input-tips2 pwd"></label>
                    <div class="inputOuter2">
                        <input type="password" id="p"  name="p" maxlength="16" class="inputstyle2"  placeholder="登录密码"/>
                    </div>
                    
                </li>
                <li>
                <label for="passwd2" class="input-tips2 pwd"></label>
                    <div class="inputOuter2">
                        <input type="password" id="p2" name="p2" maxlength="16" class="inputstyle2"  placeholder="确认登录密码" />
                    </div>
                    
                </li>
                
                <li>
                 <label for="qq" class="input-tips2 qq"></label>
                    <div class="inputOuter2">
                       
                        <input type="text" id="qq" name="qq" maxlength="12" class="inputstyle2" style="	ime-mode:disabled;"  placeholder="请输入QQ"/>
                    </div>
                   
                </li>
				<!--
                <li>
                 <label for="email" class="input-tips2 mail"></label>
                    <div class="inputOuter2">
                       
                        <input type="text" id="email" name="email" maxlength="30" class="inputstyle2"/>
                    </div>
                   
                </li>
				-->
				<?php
				if($cfg[config][chkphone]=="1"){
				?>
				<li>
                 <label for="phone" class="input-tips2 yzm"></label>
                    <div class="inputOuter2">
                       
                        <input type="text" id="gvc_yz" name="gvc_yz" maxlength="4" class="inputstyle2"  placeholder="图形验证码" style="width:123px;ime-mode:disabled; "/>
						<img src="../gvc.php" style=" width:50px; height:20px;" title="点击刷新" alt="点击刷新" onclick="this.src=this.src">
						<span id="gvc_yzm_zt"></span>
                    </div>
                   
                </li>
                <li>
                 <label for="phone" class="input-tips2 phone"></label>
                    <div class="inputOuter2"  >
                       
                        <input type="text" id="phone" name="phone" maxlength="11" class="inputstyle2"  placeholder="输入手机号码" style="width:123px; font-size:14px;ime-mode:disabled;"/>
						<input type="button" id="bt_sendyzm" value="发送验证码" class="inputstyle2" style="width:80px;height:38px; font-size:14px; background: #2795dc; color:#fff"/>
						
					</div>
                   
                </li>
				
				<li>
                 <label for="phone" class="input-tips2 yzm"></label>
                    <div class="inputOuter2">
                       
                        <input type="text" id="phone_yz" name="phone_yz" maxlength="4" class="inputstyle2"  placeholder="手机验证码" style="width:123px;ime-mode:disabled; "/>
						<span id="yzm_zt"></span>
                    </div>
                   
                </li>
                <?php
				}else{
				?>
				<li  style="display:none">
                 <label for="phone" class="input-tips2 phone"></label>
                    <div class="inputOuter2"  >
                       
                        <input type="text" id="phone" name="phone" maxlength="11" class="inputstyle2"  placeholder="手机号码"/>
						
					</div>
                   
                </li>
				<?php }?>
                <li>
                    <div class="inputArea">
                        <input type="button" id="reg"  style="margin-top:10px;width:268px;" class="button_blue" value="注册"/></div>
                    
                </li>
				</div>
				<div class="cl"></div>
            </ul></form>
           
    
    </div>
   
    
    </div>
    <!--注册end-->
</div>
<script>
$(function(){
	
	$('#switch_qlogin').click(function(){
		$('#switch_login').removeClass("switch_btn_focus").addClass('switch_btn');
		$('#switch_qlogin').removeClass("switch_btn").addClass('switch_btn_focus');
		$('#switch_bottom').animate({left:'0px',width:'66px'});
		$('#qlogin').css('display','none');
		$('#web_qr_login').css('display','block');
		try{
		parent.layer.iframeAuto(parent.layer.getFrameIndex(window.name));
		}catch(e){}
		});
	$('#switch_login').click(function(){
		
		$('#switch_login').removeClass("switch_btn").addClass('switch_btn_focus');
		$('#switch_qlogin').removeClass("switch_btn_focus").addClass('switch_btn');
		$('#switch_bottom').animate({left:'152px',width:'66px'});
		
		$('#qlogin').css('display','block');
		$('#web_qr_login').css('display','none');
		try{
		parent.layer.iframeAuto(parent.layer.getFrameIndex(window.name));
		}catch(e){}
		});
		if(getParam("a")=='0')
		{
			$('#switch_login').trigger('click');
		}

	});
	
function logintab(){
	scrollTo(0);
	$('#switch_qlogin').removeClass("switch_btn_focus").addClass('switch_btn');
	$('#switch_login').removeClass("switch_btn").addClass('switch_btn_focus');
	$('#switch_bottom').animate({left:'152px',width:'66px'});
	$('#qlogin').css('display','none');
	$('#web_qr_login').css('display','block');
	
}


//根据参数名获得该参数 pname等于想要的参数名 
function getParam(pname) { 
    var params = location.search.substr(1); // 获取参数
    var ArrParam = params.split('&'); 
    if (ArrParam.length == 1) { 
        //只有一个参数的情况 
        return params.split('=')[1]; 
    } 
    else { 
         //多个参数参数的情况 
        for (var i = 0; i < ArrParam.length; i++) { 
            if (ArrParam[i].split('=')[0] == pname) { 
                return ArrParam[i].split('=')[1]; 
            } 
        } 
    } 
}  
function preg_match(re, str) {
	var matches = re.exec(str);
	return matches != null;
}

var reMethod = "GET",
	pwdmin = 6;

$(function() {
	$("#u").blur(function(){
		if ($('#u').val().length < 2 || $('#u').val().length > 16) {

			$('#u').focus().css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×用户名位2-16字符</b></font>");
			return false;

		}
		
		$.ajax({
			type: reMethod,
			url: '../ajax.php?act=regcheck',
			data: "username=" + $("#u").val() + '&temp=' + new Date(),
			dataType: 'html',
			success: function(result) {
				result=$.trim(result);
				if (result!='1') {
					$('#u').focus().css({
						border: "1px solid red",
						boxShadow: "0 0 2px red"
					});
					if(result=='-1')
					$("#userCue").html("<font color='red'><b>×用户名含关键字，不能使用！</b></font>");
					else if(result=='0')
					$("#userCue").html("<font color='red'><b>×用户名被占用！</b></font>");
					return false;
				} else {
					$("#userCue").html("");
					$('#u').css({
						border: "1px solid #082",
						boxShadow: "0 0 2px #082"
					});
				}

			}
		});
	});
	$("#phone_yz").change(function(){
		$.get("../ajax.php?act=sendyzm_yz&yzm="+$("#phone_yz").val(),function(data){
			if(data!='1'){
				$('#phone_yz').focus().css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
				});
				$('#userCue').html("<font color='red'><b>×短信验证码错误!</b></font>");
			}
			else{
				$('#phone_yz').css({
						border: "1px solid #082",
						boxShadow: "none"
				});
				
				$('#yzm_zt').html("正确");
				$('#userCue').html("");
			}
		});
	});
	$("#bt_sendyzm").click(function(){
		if($("#bt_sendyzm").val()=="已发送")return;
		if(!preg_match(/^1[0-9]{10}$/, $.trim($('#phone').val()))) {
			$('#phone').css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×手机号码不正确!</b></font>");
			return false;
		}
		
		if($("#gvc_yz").val()==""){
			$('#gvc_yz').css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×请填写图形验证码!</b></font>");
			return false;
		}
		$("#bt_sendyzm").val("已发送");
		
		$.ajax({type:'GET',url:"../ajax.php?act=sendyzm&phone="+$("#phone").val()+'&gvc='+$("#gvc_yz").val(),
			success:function(data){
			if(data=='1'){
				alert("验证码已经发送到手机"+$("#phone").val());
				$("#bt_sendyzm").attr('disabled',false);
				$("#bt_sendyzm").val("已发送");
			}
			else{
				alert(data);
				$("#bt_sendyzm").val("发送验证码");
				return false;
			}
		}});
	});
	
	$('#reg').click(function() {
		
		if ($('#u').val() == "") {
			$('#u').focus().css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×用户名不能为空</b></font>");
			return false;
		}


		if ($('#p').val().length < pwdmin) {
			$('#p').focus();
			$('#userCue').html("<font color='red'><b>×密码不能小于" + pwdmin + "位</b></font>");
			return false;
		}
		if ($('#p2').val() != $('#p').val()) {
			$('#p2').focus();
			$('#userCue').html("<font color='red'><b>×两次密码不一致！</b></font>");
			return false;
		}
		
		var sqq = /^[1-9]{1}[0-9]{4,9}$/;
		if (!sqq.test($('#qq').val()) || $('#qq').val().length < 5 || $('#qq').val().length > 12) {
			$('#qq').focus().css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×QQ号码格式不正确</b></font>");
			return false;
		} else {
			$('#qq').css({
				border: "1px solid #D7D7D7",
				boxShadow: "none"
			});
			
		}

		$('#regUser').submit();
	});
	

});

</script>
<?=$msg?>
</body>
</html>
