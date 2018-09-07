$(function(){
		$(".list_menue .nav_titl").click(function(){
			$(this).addClass('active').siblings().removeClass('active').parent().next().children().eq($(this).index()).show().siblings().hide();
		})
		
})
function hidde(e){
	$("#innerTips").attr("style", "display:none;");
	if(e!=''){
		$(e).val('');
	}
}
function hidde2(e){
	$("#innerTips2").attr("style", "display:none;");
	if(e!=''){
		$(e).val('');
	}
}
 var countdown = 60;
function sendemail() {
    var _this = this;
    var phon = $("#phonenum").val();
    var yzm =$("#yzm").val();
    
    if($("#phonenum").val()==''){
		alert('电话号码不能为空！');
		return false;
	}
    var pattern =/^1[34578]\d{9}$/;
	if (!pattern.test($("#phonenum").val()) ){
		alert('电话号码格式不对！');
		return false;
	}
	if($("#pwd").val()==''){
		alert('密码不能为空！');
		return false;
	}
	var len=$("#pwd").val().length
	if(len < 6 || len > 20){
		alert('密码格式不对！');
		return false;
	}
	$.ajax({
		type:"POST",
		dataType:'JSON',
		url:'smsyzm.php',
		data:{yzmtel:phon},
		success:function(data){
			 if (data.code == 200) {
		            $("#innerTips").attr("style", "display:block;color:green;");
		            $("#innerTips").html('发送成功');
		            window.setTimeout('hidde($(".donothing"))', 3000);
			}else if(data.exist =='y'){
				$(".reg_t").removeClass('active').next().addClass('active').parent().next().children().eq($(".reg_t").index()).hide().next().show();
				$("#innerTips2").attr("style", "display:block;color:green;");
	            $("#innerTips2").html('账号已存在，请直接登录！');
	            window.setTimeout('hidde2($(".donothing"))', 3000);
				 
	        }else {
	            $("#innerTips").attr("style", "display:block;color:red;");
	            $("#innerTips").html('发送失败');
	            window.setTimeout('hidde($(".donothing"))', 3000);
	        }
		},
	
	})
    var obj = $("#btn");
    settime(obj);
}
function settime(obj) {
    if (countdown == 0) {
        obj.attr('disabled', false);
        //obj.removeattr("disabled"); 
        obj.val("获取验证码");
        countdown = 60;
        return;
    } else {
        obj.attr('disabled', true);
        obj.val("重新发送(" + countdown + ")");
        countdown--;
    }
    setTimeout(function () {
        settime(obj)
    }
    , 1000)
}

function isPhoneNo(){
	var phonenum = $("#phonenum").val();
	var pattern =/^1[34578]\d{9}$/;
	 if (!pattern.test(phonenum) && phonenum !='' ) {
                $("#innerTips").attr("style", "display:block;color:red;");
                $("#innerTips").html('请输入正确的手机号');
                window.setTimeout('hidde($("#phonenum"))', 3000);
                return false;
            } else {
            return true;
    }
}
function isPhoneNo2(){
	
	var phonenum = $("#phonenum2").val();
	var pattern =/^1[34578]\d{9}$/;
	 if (!pattern.test(phonenum) && phonenum !='' ) {
                $("#innerTips2").attr("style", "display:block;color:red;");
                $("#innerTips2").html('请输入正确的手机号');
                window.setTimeout('hidde2($("#phonenum2"))', 3000);
                return false;
            } else {
            return true;
    }
}
function checkpwd(){
	var len=$("#pwd").val().length;
	if(len < 6 || len > 20 ){
                $("#innerTips").attr("style", "display:block;color:red;");
                $("#innerTips").html('请您输入6~20位的密码');
                window.setTimeout('hidde($("#pwd"))', 3000);
                return false;
            } else {
            return true;
    	}
}
function checkpwd2(){
	var len=$("#pwd2").val().length;
	if(len < 6 || len > 20 ){
                $("#innerTips2").attr("style", "display:block;color:red;");
                $("#innerTips2").html('请您输入6~20位的密码');
                window.setTimeout('hidde2($("#pwd2"))', 3000);
                return false;
            } else {
            return true;
    	}
}
function verifyInput(){
	if($("#phonenum").val()==''){
		alert('电话号码不能为空！');
		return false;
	}
	var pattern =/^1[34578]\d{9}$/;
	if (!pattern.test($("#phonenum").val()) ){
		alert('电话号码格式不对！');
		return false;
	}
	if($("#pwd").val()==''){
		alert('密码不能为空！');
		return false;
	}
	var len=$("#pwd").val().length
	if(len < 6 || len > 20){
		alert('密码格式不对！');
		return false;
	}
	if($('.scform_srchtxt').val()==''){
		alert('验证码不能为空！');
		return false;
	}
	 document.getElementById("myForm").submit();
}
function verifyInput2(){
	if($("#phonenum2").val()==''){
		alert('电话号码不能为空！');
		return false;
	}
	var pattern =/^1[34578]\d{9}$/;
	if (!pattern.test($("#phonenum2").val()) ){
		alert('电话号码格式不对！');
		return false;
	}
	if($("#pwd2").val()==''){
		alert('密码不能为空！');
		return false;
	}
	var len=$("#pwd2").val().length
	if(len < 6 || len > 20){
		alert('密码格式不对！');
		return false;
	}
	
	 document.getElementById("loginForm").submit();
}
$(function(){
	$("#phonenum").blur(function(){
	isPhoneNo();
	return false;
	})
	$("#pwd").blur(function(){
	checkpwd();
	return false;
	})
	$("#phonenum2").blur(function(){
	isPhoneNo2();
	return false;
	})
	$("#pwd2").blur(function(){
	checkpwd2();
	return false;
	})
})