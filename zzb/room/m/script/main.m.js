var ws;
var page_fire
window.onbeforeunload=function(){ws.send("Logout");}
function OnSocket(){
	ws=new WebSocket("ws://"+RoomInfo.TServer+":"+RoomInfo.TSPort);
	ws.onopen=onConnect;
	ws.onmessage=function(e){WriteMessage(e.data)};
	ws.onclose=function(){setTimeout('location.reload()',3000);};
	ws.onerror=function(){setTimeout('location.reload()',3000);};
}
function Datetime(tag)
{
	return new Date().toTimeString().split(' ')[tag];
}
function MsgAutoScroll(){
	if(!toggleScroll)return;
	if($('#publicChat').find(".chat-item").length>100){$('#publicChat').find(".chat-item:eq(0)").remove();}

	$('#publicChat').scrollTop($('#publicChat')[0].scrollHeight);
}
UserList=(function(){
	var list=[];
	list['ALL']={sex:2,chatid:'ALL',nick:'大家'}
	return{
		List:function(){return list},
		init:function(){
			list['ALL']={sex:2,chatid:'ALL',nick:'大家'};
			var request_url='/ajax.php?act=getrlist&rid='+My.rid+'&r='+RoomInfo.r+'&'+Math.random() * 10000;
			$.ajax({type: 'get',dataType:'text',url: request_url,
				success:function(data){
					WriteMessage(data);
					$("#showOLNum").show();
				}});
		},
		get:function(id){return list[id];},
		add:function(id,u){
			//if($("#"+id).length >0)return;
			list[id]=u;
			$("#showOLNum").html(getOnlineNum());
		},
		del:function(id,u){
			if(id==My.chatid)return;
			delete(list[id]);
			$("#showOLNum").html(getOnlineNum());
		},
		showuser:function(u){
			if($("#"+u.chatid).length >0)return;
			if(grouparr[u.color]==undefined)return;
			var vip_ico="<img src='"+grouparr[u.color].ico+"'  align='top'>";


			var ref=getId("group_rebots");
			if(My.chatid==u.chatid){
				ref=getId("group_my");
			}
			else if(u.chatid.indexOf("x_r_i")>=0){
				ref=getId("group_"+u.color);
			}
			else
			{
				ref=getId("group_"+u.color);
			}


			//不分组
			//ref=getId("group_rebots");
			var uimg=u.mood;
			//if(u.color=="0")uimg='/face/p1/null.gif';
			var li=CreateElm1(ref,'li',false,u.chatid,null);

			var groupimg="<img src='"+grouparr[u.color].ico+"'  align='top'/ >";

			li.innerHTML='<a href="javascript:void(0)"  title="'+u.nick+'">'
				+'<span class="ugroup">'+groupimg+'</span>'
				+'<span class="uimg"><img src="'+uimg+'" onerror="this.src=\'/face/p1/null.gif\'" border="0" class="head" /></span>'
				+'<span class="unick">'+u.nick+'</span>'
				+'</a>';
			//li.oncontextmenu=function(){UserList.menu(u);return false;}
			li.onclick=function(){if(!check_auth("msg_ptp")){return;}ToUser.set(u.chatid,u.nick);$('#my-offcanvas').offCanvas('close')}
			//li.ondblclick=function(){if(!check_auth("msg_priv")){layer.msg('没有私聊权限！',{shift: 6});return;}if(u.chatid!=My.chatid&&u.chatid.indexOf('x_r')<0){POPChat.newtab(u);POPChat.showtab(u);}}

			if(u.color=="2"||u.color=="3"||u.color=="4"||u.color=="5"){
				ref=getId("group_manage");
				var li=CreateElm1(ref,'li',false,'mg'+u.chatid,null);
				li.innerHTML='<a href="javascript:void(0)"  title="'+u.nick+'">'
					+'<span class="ugroup">'+groupimg+'</span>'
					+'<span class="uimg"><img src="'+uimg+'" onerror="this.src=\'/face/p1/null.gif\'" border="0" class="head" /></span>'
					+'<span class="unick">'+u.nick+'</span>'
					+'</a>';
				li.onclick=function(){openPPChatPtpChatWin(u,true);}
			}

		}
	}
})();
function getId(id)
{
	return document.getElementById(id);
}
function CreateElm1(pObj,obj,className,id,ref){
	var elm = null;
	var elm=document.createElement(obj);
	if(!pObj)document.body.insertBefore(elm,ref);
	else pObj.insertBefore(elm,ref);
	if(id)elm.id = id;
	if(className)elm.className = className;
	return elm
}
function getOnlineNum(){
	var num=0;for(var v in UserList.List()){num++;};
	return num+parseInt(RoomInfo.r);
}
function MsgShow(str,type){
	//alert(str);
	if(str=="")return;
	if($('#MsgBox1').find(".chat-item").length>100){$('#MsgBox1').find(".chat-item:first").empty();$('#MsgBox1').find(".chat-item:first").remove();}

	$("#publicChat").append(str);
	$(".chat-msg img").unbind();
	$(".chat-msg img").on("click",function(){if($(this).width()>119||$(this).height()>119)openPopWin('查看图片',"<img src='"+$(this).attr('src')+"' width=100% onclick='layer.closeAll()'>")});
	MsgAutoScroll();
}
SysSend=(function(){
	return{
		msg:function(){
			MsgSend();
		},
		command:function(cmd,value){

			var Msg='';
			var IsPersonal='false';
			var Style="";
			var touser=ToUser.id;
			switch(cmd)
			{
				case 'send_Msgblock':
					Style="";
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='true';
					break;
				case 'msgBlock':
					Style="";
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='false';
					touser="ALL";
					break;
				case 'msgAudit':
					Style="";
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='false';
					touser="ALL";
					break;
				case 'kick':
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='true';
					break;
				default:
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='false';
					touser="ALL";
					break;

			}
			if(Msg!='')
			{
				if(ToUser.id.indexOf('x_r')>-1){
					touser='ALL';
				}
				var str='SendMsg=M='+touser+'|'+IsPersonal+'|'+Style+'|'+Msg;
				try{
					ws.send(str);
				}catch(e){ws.send(str);alert("[Send Error]["+str+"]"+e);}
				$("#messageEditor").html("");
			}
		}
	}
})();
ToUser=(function(){
	return{
		id:'ALL',
		name:'大家',
		add:function(id,name){

		},
		del:function(id){
		},
		set:function(id,name){
			if(id.indexOf('x_r')>-1){$("#messageEditor").html($("#messageEditor").html()+"@"+name+"&nbsp");return;}
			this.id=id;
			this.name=name;
			$("#messageEditor").html($("#messageEditor").html()+"@"+name+"&nbsp");
		}
	}
})();
function MsgSend(){
	if(!check_auth("msg_send")){layer.open({content: '没有发言权限！',skin: 'msg',time: 2 });return false;}
	if(RoomInfo.banall=='1'&&My.qx!='1'){
		layer.open({content: '全体禁言中！',skin: 'msg',time: 2 });
		RoomInfo.banall='1';return;
	}
	var msgid=randStr()+randStr();
	var str=$("#messageEditor").html();
	if(ToUser.id!='ALL')str=str.replace(/@[\u4e00-\u9fa5a-zA-Z0-9_-]{4,30}/ig,'');

	str=encodeURIComponent(str.str_replace());

	if(str=="")return;
	ws.send('SendMsg=M='+ToUser.id+'|false||'+msgid+'_+_'+str);

	PutMessage(My.rid,My.chatid,ToUser.id,My.nick,ToUser.name,'false','',str,msgid);
	ToUser.set('ALL','大家');
	$("#messageEditor").html("");
	//$("#messageEditor").focus();
}
function PtpMsgSend(){

	var msgid=randStr()+randStr();
	var str=$("#PPChatptpChat .messageEditor").html();

	str=encodeURIComponent(str.str_replace());

	if(str=="")return;
	ws.send('SendMsg=M='+$("#PPChatptpChat").data("chatid")+'|true||'+str);

	PutMessage(My.rid,My.chatid,$("#PPChatptpChat").data("chatid"),My.nick,$("#PPChatptpChat").data("nick"),'true','',str,msgid);

	$("#PPChatptpChat .messageEditor").html("");
	$("#PPChatptpChat .messageEditor").focus();
}
function showsyssmg(txt){
	//alert(txt);
	var date= Datetime(0);
	var s='<div class="chat-item notmine system"><div class="user-img"> <div class="uimg"><img src="/face/sys.gif"></div><div class="gimg"></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name">系统消息</span> <span class="chat-time">'+date+'</span></div><div class="chat-info-2"> <div class="chat-msg">'+txt+'</div></div></div></div>';
	//var s='<div class="msg_li"><div style="clear:both;"></div><div class="msg" id=""><div class="msg_head"><img src="/face/sys.gif"><span class="u">系统消息:</span></div> <div class="msg_content">'+txt+'</div></div></div>';


	MsgShow(s,0);
}
function getsysmsg(){
	$.getJSON("/ajax.php?act=getsysmsg","rid="+My.rid,
		function(data){
			if(data.sysmsg_state=='1'){
				data.sysmsg_id=0;
				timer_fun=function(){
					if(data.info.length<1)return;
					if(data.sysmsg_order=="1"){
						if(data.sysmsg_id>=data.info.length){data.sysmsg_id=0;}
					}else{
						data.sysmsg_id=Math.ceil(Math.random()*(data.info.length-1));;
						data.info.sort(function(){ return 0.5 - Math.random() });
					}
					showsyssmg(data.info[data.sysmsg_id++]);
				}
				timer_fun();
				setInterval('timer_fun()',data.sysmsg_timer*1000);
			}
		});
}

function randStr(){
	return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
}
function PutMessage(rid,uid,tid,uname,tname,privacy,style,str,msgid){
	if(RoomInfo.Msglog=='0')return;
	var request_url='../../ajax.php?act=putmsg';
	var postdata='msgid='+msgid+'&uname='+uname+'&tname='+tname+'&muid='+uid+'&rid='+rid+'&tid='+tid+'&privacy='+privacy+'&style='+style+'&msg='+str+'&'+Math.random() * 10000;

	$.ajax({type: 'POST',url:request_url,data:postdata});
}
function Mkick(adminid,rid,ktime,cause)
{
	$.ajax({type: 'get',dataType:'json',url: '../../ajax.php?act=kick&aid='+adminid+'&rid='+rid+'&ktime='+ktime+'&cause='+cause+'&u='+My.name+'&'+Math.random() * 10000,
		success:function(data){
			//alert(data);
			if(data.state=="yes"){
				location.href="../error.php?msg="+encodeURI('你被踢出！并禁止'+ktime+'分钟内登陆该房间！<br>原因是 '+cause+'');
			}
		}
	});
}
String.prototype.str_replace=function(t){
	var str=this;
	//var reg = new RegExp(msg_unallowable, "ig");
	//if(reg.test(str)&&!check_auth("room_admin"))return "含敏感关键字，内容被屏蔽";
	str= str.replace(/<\/?(?!br|img|font|p|span|\/font|\/p|\/span)[^>]*>/ig,'').replace(/\r?\n/ig,' ').replace(/(&nbsp;)+/ig," ").replace(/(=M=)+/ig,"").replace(/(|)+/ig,"").replace(/(SendMsg)/ig,'');
	//if(!check_auth("room_admin"))str=str.replace(reg,'**')
	return str;
};

function check_auth(auth){
	var auth_rules = grouparr[My.color].rules;
	if(auth_rules.indexOf(auth)>-1)return true;
	else false;
}
function FormatMsg(Msg)
{
	var User=UserList.get(Msg.ChatId);
	var toUser=UserList.get(Msg.ToChatId);
	var date= Datetime(0);
	var IsPersonal='';
	if(typeof(User)=='undefined'||typeof(toUser)=='undefined')return false;
	if(Msg.IsPersonal=='true' && toUser.chatid!='ALL') IsPersonal='[私]';
	var Txt=decodeURIComponent(Msg.Txt.str_replace());

	if(Txt.indexOf('C0MMAND')!=-1)
	{
		var command=Txt.split('_+_');
		switch(command[1])
		{
			case 'setVideoSrc':
				if(User.qx!="1")break;
				//$('#defvideosrc').html("当前讲师："+command[3]);
				RoomInfo.PVideo=User.chatid;
				RoomInfo.PVideoNick=command[3];
				var str='【'+command[3]+'】 开讲啦！欢迎提问交流！^_^';
				layer.open({
					content: str
					,btn: '我知道了'
				});

				return;

				break;
			case 'showTip':
				if(User.qx!="1")break;
				if(command[2]=="2"){
					//$("#marquee1 ul").prepend("<li>"+decodeURIComponent(command[3])+"</li>");tipsMarquee();
					layer.open({
						content: decodeURIComponent(command[3])
						,btn: '我知道了'
					});
				}
				else if(command[2]=="3"){
					//$("#marquee2 ul").prepend("<li>"+decodeURIComponent(command[3])+"</li>");tipsMarquee();
					layer.open({
						content: decodeURIComponent(command[3])
						,btn: '我知道了'
					});
				}
				else if(command[2]=="4"){
					//$('body').barrager({'img':'/face/img.php?t=p1&u='+User.chatid,'info':decodeURIComponent(command[3])});
					layer.open({
						content: decodeURIComponent(command[3])
						,btn: '我知道了'
					});
				}
				else if(command[2]=="5"){
					layer.open({
						content: decodeURIComponent(command[3])
						,btn: '我知道了'
					});
					//startFireWorks(300,decodeURIComponent(command[3]));
				}else if(command[2]=="6"){
					layer.open({content: '全体禁言中！',skin: 'msg',time: 2 });
					RoomInfo.banall='1';
				}
				else if(command[2]=="7"){
					layer.open({content: '解除全体禁言！',skin: 'msg',time: 2 });
					RoomInfo.banall='0';
				}

				break;
			case 'send_Msgblock':
				if(User.qx!="1")break;
				if(My.chatid==toUser.chatid){
					remove_auth('msg_send');
					layer.open({
						content: '你已被禁言！'
						,skin: 'msg'
						,time: 2 //2秒后自动关闭
					});
				}
				break;
			case 'msgAudit':
				if(User.qx!="1")break;
				$('#'+command[2]).show();
				$('#bt_audit_'+command[2]).hide();
				MsgAutoScroll();

				break;
			case 'msgBlock':
				if(User.qx!="1")break;
				$('#'+command[2]).remove();
				MsgAutoScroll();

				break;
			case 'rebotmsg':
				if(User.qx!="1")break;
				//var rebot=UserList.get(command[2]);
				var msg={};
				msg.ChatId=command[2];
				msg.nick=command[3];
				msg.ToChatId='ALL';
				msg.IsPersonal='false';
				msg.Txt=command[4];
				msg.ico=grouparr[command[5]].ico;
				msg.Style=Msg.Style;
				var s='<div class="chat-item notmine" ><div class="user-img"> <div class="uimg"><img src="/face/img.php?t=p1&u='+msg.ChatId+'"/></div><div class="gimg"><img src="'+msg.ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name"  onclick="ToUser.set(\''+msg.ChatId+'\',\''+msg.nick+'\')">'+msg.nick+'</span> <span class="chat-time">'+date+'</span></div><div class="chat-info-2"> <div class="chat-msg">'+msg.Txt+'</div></div></div></div>';
				MsgShow(s,0);
				break;

			case 'kick':
				if(User.qx!="1")break;
				if(My.chatid==toUser.chatid){
					Mkick(Msg.ChatId,My.roomid,command[2],command[3]);
				}
				break;
			case 'setstate':
				UserList.setstate(command[2],command[3],command[4]);
				break;
			case "sendgift":
				//SysSend.command('sendgift',"{uid:'"+My.chatid+"',nick:'"+nick+"',num:'"+num+"',gid:'"+gid+"'}");
				var ginfo=eval("("+command[2]+")");
				var gift=$("#gift"+ginfo.gid);
				var u=UserList.get(ginfo.uid);
				//ShowGifteffect(ginfo,gift);
				var msg="送给 <b>"+ginfo.nick+"</b> <b style='color:#F90'>"+ginfo.num+"</b> 份"+" <img src='"+gift.data("gif")+"' height='30' width='30'> "+gift.data("title")+" "+gift.data("txt");
				var str='<div class="chat-item notmine  system"><div class="user-img"> <div class="uimg"><img src="'+u.mood+'"/></div><div class="gimg"><img src="'+grouparr[u.color].ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name" onclick="ToUser.set(\''+u.chatid+'\',\''+u.nick+'\')" oncontextmenu="return bt_kick(\''+u.chatid+'\',\''+u.nick+'\')">'+u.nick+'</span> <span class="chat-time">'+date+'</span></div><div class="chat-info-2"> <div class="chat-msg">'+msg+'</div></div></div></div>';
				//alert(str);
				break;
			case "sendhongbao":
				var hinfo=eval("("+command[2]+")");
				var u=UserList.get(hinfo.uid);
				//ShowHbeffect(ginfo,gift);
				var msg='<div class="redbag-top" title="'+hinfo.msg+'" data-hid="'+hinfo.hid+'" onclick="getHongBao($(this).data(\'hid\'))"><div class="fl"><img src="/room/images/hongbao.png" style="margin-top: 3px;"></div><div class="fl ml10" style="color:#fff;"><p style="font-weight:bold;margin-bottom:4px;color:#f30;font-size:13px;">'+hinfo.msg+'</p>领取红包</div></div><div style="padding:3px 10px;background: #fff;color: #333;">直播室红包</div>';
				var str='<div class="chat-item notmine  hongbaomsg"><div class="user-img"> <div class="uimg"><img src="'+u.mood+'"  onclick="ToUser.set(\''+u.chatid+'\',\''+u.nick+'\')" /></div><div class="gimg"><img src="'+grouparr[u.color].ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name" onclick="ToUser.set(\''+u.chatid+'\',\''+u.nick+'\')" oncontextmenu="return bt_kick(\''+u.chatid+'\',\''+u.nick+'\')">'+u.nick+'</span> <span class="chat-time">'+date+'</span></div><div class="chat-info-2"> <div class="chat-msg">'+msg+'</div></div></div></div>';
				break;
			case "gethongbao":
				var hinfo=eval("("+command[2]+")");
				var u=UserList.get(hinfo.uid);
				var str='<div class="message-wrap"><div class="redbag-info1"><p style="color:#333;">'+u.nick+' 领取了 <span style="color:red;">'+hinfo.nick+'</span> 的红包 <span style="color:red;">'+hinfo.money+'元</span></p></div><div class="clear"></div></div>';
				break;
		}
	}
	else
	{
		var msgid="";
		if(Txt.indexOf('_+_')>-1){
			var t=Txt.split('_+_');
			msgid= t[0];
			Txt=t[1];
		}
		var msgBlockBt="";
		if(RoomInfo.msgBlock=="1"){
			if(check_auth('msg_block'))
				msgBlockBt=" <a href='javascript:void(0)' onclick='bt_msgBlock(\""+msgid+"\")'><img src='/room/images/11.png' style='border:0px;' title='屏蔽消息'></a>";
		}


		var msgAuditBt="";
		var msgAuditShow='';
		if(RoomInfo.msgAudit=="1"){
			msgAuditShow='style="display:none"';

			if(check_auth('msg_audit')){
				msgAuditBt=" <a href='javascript:void(0)' onclick='bt_msgAudit(\""+msgid+"\",this)'  id='bt_audit_"+msgid+"'><img src='/room/images/22.png' style='border:0px;' title='审核通过'></a>";
				msgAuditShow="";
			}

		}
		//敏感词语审核
		var reg = new RegExp(msg_unallowable, "ig");
		if(reg.test(Txt)){
			msgAuditShow='style="display:none"';

			if(check_auth('msg_audit')){
				msgAuditBt=" <a href='javascript:void(0)' onclick='bt_msgAudit(\""+msgid+"\",this)' id='bt_audit_"+msgid+"'><img src='/room/images/22.png' style='border:0px; ' title='审核通过'></a>";
				msgAuditShow="";
			}

		}
		//管理员不用审核
		if(User.color=='2'||User.color=='3'||User.color=='4'||User.color=='5'||User.chatid==My.chatid){
			msgAuditShow="";msgAuditBt="";
		}
		var who=" notmine ";
		if(User.color=='2'||User.color=='5'){
			who+=" manage";
		}
		else if(User.color=='3'||User.color=='4'){
			who+=" teacher";
		}
		if(User.chatid==My.chatid){
			who=" mine";
		}

		if(Msg.IsPersonal!='true' && toUser.chatid!='ALL'){
			Txt="@"+toUser.nick+" "+Txt;
		}

		if(Msg.IsPersonal=='true' && toUser.chatid!='ALL'){
			str='<div class="chat-item '+who+'" id="'+msgid+'" ><div class="user-img"> <div class="uimg"><img src="'+User.mood+'" onclick="ToUser.set(\''+User.chatid+'\',\''+User.nick+'\')" /></div><div class="gimg"><img src="'+grouparr[User.color].ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name" onclick="ToUser.set(\''+User.chatid+'\',\''+User.nick+'\')" oncontextmenu="return bt_kick(\''+User.chatid+'\',\''+User.nick+'\')">'+User.nick+'</span> <span class="chat-time">'+date+'</span><img src="/room/images/'+User.age+'.png"></div><div class="chat-info-2"> <div class="chat-msg">'+Txt+'</div></div></div></div>';

			return str;
		}

		str='<div class="chat-item '+who+'" id="'+msgid+'" '+msgAuditShow+'><div class="user-img"> <div class="uimg"><img src="'+User.mood+'" onclick="ToUser.set(\''+User.chatid+'\',\''+User.nick+'\')" /></div><div class="gimg"><img src="'+grouparr[User.color].ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name" onclick="ToUser.set(\''+User.chatid+'\',\''+User.nick+'\')" oncontextmenu="return bt_kick(\''+User.chatid+'\',\''+User.nick+'\')">'+User.nick+'</span> <span class="chat-time">'+date+'</span><img src="/room/images/'+User.age+'.png"></div><div class="chat-info-2"> <div class="chat-msg">'+Txt+msgBlockBt+msgAuditBt+'</div></div></div></div>';

	}
	return str;

}
function remove_auth(auth){
	grouparr[My.color].rules=grouparr[My.color].rules.replace(auth,"");
}
function OnInit(){
	OnSocket();
	Init();
	//showLive();
	$("#sendBtn").click(function(){MsgSend();});
	$("#publicChat").height($(window).outerHeight(true)-$("#header").outerHeight(true)-$("#head_1").outerHeight()-$("#footer").outerHeight(true));
	getsysmsg();
}
function onConnect()
{
	//setInterval("online('<?=$time?>')",10000);
	My.age='null';
	if(device.iphone()||device.ios()||device.ipad())My.age='ios';
	else if(device.mobile())My.age='android';

	var str='Login=M='+My.roomid+'|'+My.chatid+'|'+My.nick+'|'+My.sex+'|'+My.age+'|'+My.qx+'|'+My.ip+'|'+My.vip+'|'+My.color+'|'+My.cam+'|'+My.state+'|'+My.mood;
	ws.send(str);

	if(typeof(UserList)!='undefined'){
		UserList.init();
	}
	$("#touzhu_iframe").attr('src',touzhu_url);
	//bt_fenping();
}
function icon3() {
	$("#icon3").click(function() {
		var a = $("head  title").text();

		postToWb(a)
	})
}
function icon2() {
	$("#icon2").click(function() {
		var a = $("head  title").text();
		postToXinLang(a)
	})
}
function icon4() {
	$("#icon4").click(function() {
		var a = $("head  title").text();
		postToQzone(a)
	})
}
function postToXinLang(a) {
	window.open("http://v.t.sina.com.cn/share/share.php?title=" + encodeURIComponent(a) + "&url=" + encodeURIComponent(location.href) + "&rcontent=", "_blank", "scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes")
}
function postToQzone(a) {
	var b = encodeURI(a),
		c = encodeURI(a),
		d = encodeURI(document.location);
	return window.open("http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?title=" + b + "&url=" + d + "&summary=" + c),
		!1
}
function postToWb(a) {
	var b = encodeURI(a),
		c = encodeURI(document.location),
		d = encodeURI("appkey"),
		e = encodeURI(""),
		f = "",
		g = "http://v.t.qq.com/share/share.php?title=" + b + "&url=" + c + "&appkey=" + d + "&site=" + f + "&pic=" + e;
	window.open(g, "转播到腾讯微博", "width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no")
}
function showLive(){
	location.reload();
}
function Init(){
	$("#video-flash").click(function(){showLive()});
	$("body").click(function() { $(".setting-expression-layer").hide() });
	$(".footer .smile").click(function(a) {
		var input=$(this).parent().find(".messageEditor")[0];
		if (a.stopPropagation(), 0 == $("#expressions").find(".expr-tab").find("tr").length) {
			var b = '<tr><td><img src="/room/face/pic/m/kx.gif" alt="狂笑" title="狂笑" width="28" height="28" /></td>';
			b += ' <td><img src="/room/face/pic/m/jx.gif" alt="贱笑" title="贱笑" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/tx.gif" alt="偷笑" title="偷笑" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/qx.gif" alt="窃笑" title="窃笑" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/ka.gif" alt="可爱" title="可爱" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/kiss.gif" alt="kiss" title="kiss" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/up.gif" alt="up" title="up" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/bq.gif" alt="抱歉" title="抱歉" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/bx.gif" alt="鼻血" title="鼻血" width="28" height="28" /></td></tr>',
				b += '<tr><td><img src="/room/face/pic/m/bs.gif" alt="鄙视" title="鄙视" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/dy.gif" alt="得意" title="得意" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/fd.gif" alt="发呆" title="发呆" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/gd.gif" alt="感动" title="感动" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/glian.gif" alt="鬼脸" title="鬼脸" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/hx.gif" alt="害羞" title="害羞" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/jxia.gif" alt="惊吓" title="惊吓" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/zong.gif" alt="囧" title="囧" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/kl.gif" alt="可怜" title="可怜" width="28" height="28" /></td></tr>',
				b += '<tr><td><img src="/room/face/pic/m/kle.gif" alt="困了" title="困了" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/ld.gif" alt="来电" title="来电" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/lh.gif" alt="流汗" title="流汗" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/qf.gif" alt="气愤" title="气愤" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/qs.gif" alt="潜水" title="潜水" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/qiang.gif" alt="强" title="强" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/sx.gif" alt="伤心" title="伤心" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/suai.gif" alt="衰" title="衰" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/sj.gif" alt="睡觉" title="睡觉" width="28" height="28" /></td></tr>',
				b += '<tr><td><img src="/room/face/pic/m/tz.gif" alt="陶醉" title="陶醉" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/wbk.gif" alt="挖鼻孔" title="挖鼻孔" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/wq.gif" alt="委屈" title="委屈" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/xf.gif" alt="兴奋" title="兴奋" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/yw.gif" alt="疑问" title="疑问" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/yuan.gif" alt="晕" title="晕" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/zj.gif" alt="再见" title="再见" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/zan.gif" alt="赞" title="赞" width="28" height="28" /></td>',
				b += '<td><img src="/room/face/pic/m/zb.gif" alt="装逼" title="装逼" width="28" height="28" /></td></tr>',
				b += '<tr><td><img src="/room/face/pic/m/bd.gif" alt="被电" title="被电" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/gl.gif" alt="给力" title="给力" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/hjd.gif" alt="好激动" title="好激动" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/jyl.gif" alt="加油啦" title="加油啦" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/jjdx.gif" alt="贱贱地笑" title="贱贱地笑" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/lll.gif" alt="啦啦啦" title="啦啦啦" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/lm.gif" alt="来嘛" title="来嘛" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/lx.gif" alt="流血" title="流血" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/lgze.gif" alt="路过这儿" title="路过这儿" width="22" height="22" /></td></tr>',
				b += '<tr><td><img src="/room/face/pic/m/qkn.gif" alt="切克闹" title="切克闹" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/qgz.gif" alt="求关注" title="求关注" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/tzuang.gif" alt="推撞" title="推撞" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/ww.gif" alt="威武" title="威武" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/wg.gif" alt="围观" title="围观" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/xhh.gif" alt="笑哈哈" title="笑哈哈" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/zc.gif" alt="招财" title="招财" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/zf.gif" alt="转发" title="转发" width="22" height="22" /></td>',
				b += '<td><img src="/room/face/pic/m/zz.gif" alt="转转" title="转转" width="22" height="22" /></td></tr>',
				$("#expressions").find(".expr-tab").append(b),$(".setting-expression-layer").show(),
				$("#expressions").find(".expr-tab").find("img").click(function() {
					var a = $(this).attr("src");
					//$(input).focus(),
						//document.execCommand("insertImage", null, a),
                    $("#messageEditor").html($("#messageEditor").html()+'<img src="'+a+'" width="22" height="22" />');
						$(this).closest(".setting-expression-layer").hide()
				})
		} else $(".setting-expression-layer").toggle();

	});
	$("#sharedBtn").click(function() {
		var a = '<div class="header">';
		a += '<div class="sharedClose" style=""></div>',
			a += "</div>",
			a += '<h2 style="margin-bottom: 12px;color: #000;font-weight: 400;">分享到:</h2>',
			a += "<ul>",
			a += '<li onclick="icon3()" id="icon3"><img src="images/tx.png" width="44px" height="44px">腾讯微博</li>',
			a += '<li onclick="icon2()" id="icon2"><img src="images/sina.png" width="44px" height="44px">新浪微博</li>',
			a += '<li onclick="icon4()" id="icon4"><img src="images/qz.png" width="44px" height="44px">QQ空间</li>',
			a += "</ul>",
			$("#shared").empty().append(a),
			$("#sharedWrap").show(),
			$("#shared").show(),
			$("#shared .sharedClose").click(function() {
				$("#shared,#sharedWrap").hide()
			})
	});
	$(".am-tabs li").click(function() {
		if($(this).data("showtab")=="d2"){
          	$("#footer").hide();
			$("#noticeContent").hide();
			$(".div_plus").hide();
      		$(".tabsnav").hide();
			$(".tabsnav-"+$(this).data("showtab")).show();
          	$(".am-tabs li").removeClass("am-active");
          	$(this).addClass("am-active");
          	return ;
        }
		$(".am-tabs li").removeClass("am-active");
		$(this).addClass("am-active");
		$(".tabsnav-iframe iframe").prop("src",'');
		$(".tabsnav").hide();
		$(".tabsnav-"+$(this).data("showtab")).show();
		$("#noticeContent").hide();
		$(".div_plus").hide();
		if($(this).index()==0){
			$("#noticeContent").show();
			$(".div_plus").show();
			$("#footer").show();
			$("#publicChat").height($(window).outerHeight(true)-$("#header").outerHeight(true)-$("#head_1").outerHeight()-$("#footer").outerHeight(true)-10);
		}
		else{
			$("#footer").hide();
			$(".div_plus").hide();
			var tabsnav=$(this).data("showtab");
			$(".tabsnav-"+tabsnav).height($(window).outerHeight(true)-$("#header").outerHeight(true)-$("#head_1").outerHeight(true));
			var target=$(this).data("target");
			if(target=="blank"){
				window.open($(this).data("url"));
			}else if(target=="self"){
				location.href=$(this).data("url");
			}else if(target=="iframe"){
				$(".tabsnav-iframe").show();
				$(".tabsnav-iframe iframe").prop("src",$(this).data("url"));

			}
		}
	});
}
function PutMsg(rid,uid,tid,uname,tname,privacy,style,str,msgid){
	var request_url='/ajax.php?act=putmsg';
	var postdata='msgid='+msgid+'&uname='+encodeURIComponent(uname)+'&tname='+encodeURIComponent(tname)+'&muid='+uid+'&rid='+rid+'&tid='+tid+'&privacy='+privacy+'&style='+style+'&msg='+str+'&'+Math.random() * 10000;
	if(RoomInfo.Msglog=='0')return;
	$.ajax({type: 'POST',url:request_url,data:postdata});
}
var gHid="";
var vcode="";
function getHongBao(hid){
	if(My.color=="0"){layer.open({content: '请登录！',skin: 'msg',time: 2 });;return;}
	if(gHid!=hid){
		layer.open({
			title: [
				'恭喜发财，大吉大利！',
				'background-color: #FF4351; color:#fff;'
			]
			,content: '<div style="    line-height: 30px;			font-size: 14px;			color: #B22222;">请输入验证码抢红包</div><div><img src="/include/image_firefox.inc.php?'+new Date().getTime()+'" onclick="this.src=this.src" style="vertical-align: middle;cursor: pointer;" title="点击刷新"><input type="text" style="border: 1px solid rgba(0,0,0,.2);width: 25px;background: none;vertical-align: middle;text-align: center;font-size: 16px;" id="vcode" value="">	</div><div class="img" style="line-height: 30px;			color: red;background: #ff0;margin-top: 15px;cursor: pointer;" id="nowgethb" >马上抢</div>'
		});

		$("#nowgethb").click(function(){
			if($("#vcode").val()==""){
				alert('请输入验证码');
				return false;
			}
			vcode=$("#vcode").val();
			layer.closeAll();
			gHid=hid;
			getHongBao(hid);
		});
		return false;
	}
	$.getJSON("/ajax.php?act=gethongbao&hid="+hid+'&vcode='+vcode,function(re){
		if(re.code==0){layer.open({content: '请登录！',skin: 'msg',time: 2 });return;}
		else {
			//var html1='<div id="hadredbag" style="display:none"><div class="redbagclose" onclick="$(\'#hadredbag\').remove();"></div><div class="img"><img src="/face/img.php?t=p1&u='+re.hinfo.uid+'" width="60" height="60"></div><p style="margin-top: 15px;">'+re.hinfo.nick+'</p><p class="memos mt10">您已经抢过这个红包了!</p><div class="minebag cursor lookthisbag" onclick="$(\'#hadredbag\').remove();$(\'#successredbag\').show();center(\'#successredbag\',true);">看看大家的手气&gt;&gt;</div></div>';
			//$("body").append(html1);
			if(re.code==5){
				gHid="";
				layer.open({
					content: '计算结果验证码错误！'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				  });
				return false;
			}
			if(re.code==6){
				gHid="";
				layer.open({
					content: re.msg
					,btn: '朕知道了'
				  });
				return false;
			}

			var item="";
			var myget_money=0.00;
			for(x in re.glist){
				var i=re.glist[x];
				if(i.uid==My.chatid)myget_money=i.money;
				item+='<div class="list-info" ><div class="user-img"><img src="/face/img.php?t=p1&u='+i.uid+'" width="35" height="35"></div><div class="list-right"><div class="list-right-top"><div class="user-name fl f14">'+i.nick+'</div><div class="user-money fr f14">'+i.money+'元</div></div><div class="user-time">'+i.time+'</div></div></div>';
			}
			var html0='<div id="successredbag" style="display:none"><div class="redbagclose" onclick="$(\'#successredbag\').remove();"></div><div class="img"><img src="/face/img.php?t=p1&u='+re.hinfo.uid+'" width="65" height="65"></div><p style="margin-top:5px;font-size: 14px;color:#000;">'+re.hinfo.nick+'的红包</p><p class="p1" style="margin-top:5px; font-size: 12px;color: #CCC;">'+re.hinfo.msg+'</p><div class="money bagred"><span id="myget_money">'+re.hinfo.money+'</span><span style="color:#333;font-size: 14px;">元</span></div><p class="baginformation">已领取'+re.gnum+'/'+re.hinfo.number+'个，'+re.hinfo.money+'元红包已领'+re.gmoney+'元，</p>';
			html0+='<div class="HBlist">',
				html0+=item,
				html0+='</div>',
				html0+='<div class="minebag1 cursor lookthisbag" id="lookmymoney">查看我的钱包&gt;&gt;</div></div>';
			//$("body").append(html0);
			if(re.code==1){
				//$("#myget_money").html('<span style="color:#333;font-size: 14px;">获</span>'+myget_money);
				//$("#successredbag").show(),center("#successredbag",true);
				layer.open({
					title: [
						re.hinfo.nick+'的红包',
						'background-color: #FF4351; color:#fff;'
					]
					,content: '抢到红包'+myget_money+'元'
				});
				SysSend.command('gethongbao',"{uid:'"+My.chatid+"',nick:'"+re.hinfo.nick+"',money:'"+myget_money+"'}");
				PutMsg(My.rid,My.chatid,'ALL',My.nick,'gethongbao','false',re.hinfo.nick,'领取红包'+myget_money+'元',myget_money);
			}
			else if(re.code==2){
				//$("#hadredbag").show(),center("#hadredbag",true);
				layer.open({
					content: '您已经抢过这个红包了!'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				});
			}
			else if(re.code==3){
				//$("#hadredbag").show(),center("#hadredbag",true),$("#hadredbag .memos").text('手慢了，红包派完了！');
				layer.open({
					content: '手慢了，红包派完了！'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				});
			}
			else if(re.code==4){
				//$("#hadredbag").show(),center("#hadredbag",true),$("#hadredbag .memos").text('来晚了！24小时过期回收！');
				layer.open({
					content: '来晚了！24小时过期回收！'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				});
			}
			$("#lookmymoney").click(function(){
				$("#successredbag").remove();
				$("#lookredbag").remove();

				lookHbMoney();
			});
		}

	});

}
function WriteMessage(txt){
	//if(txt.indexOf('SendMsg')!=-1)
	//alert(txt);
	var Msg;
	try{
		Msg=eval("("+txt+")");
	}catch(e){return;}
	if(Msg.stat=='Fail'){
		layer.open({
			content: '发送错误，对方已经离线！'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		});
		return;
	}
	if(Msg.stat!='OK')
	{
		if(Msg.stat=="MaxOnline"){
			document.body.innerHTML='<div  style="font-size:12px; text-align:center; top:100px; position:absolute;width:100%">O.O 对不起，服务端并发数已满！请您联系管理员对系统扩容升级！<br><br></div>';
			return;
		}
		return ;
	}
	switch(Msg.type)
	{
		case "Ulogin":
			var U=Msg.Ulogin;
			var vip_msg="到来";
			var date= Datetime(0);
			var str='<span class="info">欢迎：<font class="u" >'+U.nick+'</font>  <font class="date">'+date+'</font></span>';
			if(My.chatid!=U.chatid){
				UserList.add(U.chatid,U);
			}
			var type=0;
			if(U.chatid==My.chatid) type=2;
			//MsgShow(str,type);

			break;
		case "UMsg":
			var str=FormatMsg(Msg.UMsg);
			if(Msg.UMsg.IsPersonal=='true'){
				var fcid=Msg.UMsg.ChatId;
				if(fcid==My.chatid)fcid=Msg.UMsg.ToChatId;
				var u=UserList.get(fcid);
				showPtpMsg(u,str);
			}
			else{
				MsgShow(str,1);
			}

			break;
		case "UonlineUser":

			var onlineNum=Msg.roomListUser.length;
			for(i=0;i<onlineNum;i++)
			{
				var U=Msg.roomListUser[i];

				UserList.add(U.chatid,U);
			}
			break;
		case "Ulogout":
			var U=Msg.Ulogout;
			var date= Datetime(0);
			var str='<span class="info">用户：'+U.nick+'   离开！ <font class="date">'+date+'</font></span>';
			//MsgShow(str,0);
			UserList.del(U.chatid,U);
			break;
		case "ping":
			ws.send('1');
			break;
		case "Sysmsg":
			alert(Msg.Sysmsg.txt);
			break;
	}

}
function bt_msgBlock(id){
	if(id!=""){
		SysSend.command('msgBlock',id);
		$.ajax({type: 'get',url: '/ajax.php?act=msgblock&s=1&msgid='+id});
	}
}
function bt_msgAudit(id,a){
	SysSend.command('msgAudit',id);
	$(a).hide();
	$.ajax({type: 'get',url: '/ajax.php?act=msgblock&s=0&msgid='+id});
}
function uploadAvatar(ElementId, editor) {
	//上传文件
	$.ajaxFileUpload({
		url:'/upload/upload_chat.php',//处理图片脚本
		secureuri :false,
		fileElementId : ElementId,//file控件id
		dataType : 'json',
		data: {type: ElementId },

		success : function (data, status){
			if(typeof(data.err) != 'undefined'){
				if(data.err != ''){
					alert(data.err);
				}else{
					var _img = '<img src="' + data.msg.url + '"class="chat-pic"/>';
					$(editor).append(_img);
					$(editor).parent().parent().find('.sendBtn').click();
				}
			}
		},
		error: function(data, status, e){
			alert(e);
		}
	});
}
function sendPlus(){

	layer.open({
		type: 1
		,content: $("#sendplus").html()
		,anim: 'up'
		,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 65px; padding:10px 0; border:none;'
	});
}
function qiandao(){
	if(My.color=="0"){layer.open({
		content: '请登录'
		,skin: 'msg'
		,time: 2 //2秒后自动关闭
	});
		return;}
	$.getJSON("/ajax.php?act=qiandao&rid="+My.rid,function(re){
		if(re.code==1){
			layer.open({
				content: '连续签到'+re.persist+"天，获"+re.credit + re.re+",继续保持获累加奖励^_^"
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
			$("#messageEditor").html("[<b>每日一签</b>] 连续签到 <font style='color:red'>" +re.persist + '</font> 天,'+"今日签到获得<font style='color:red'>"+re.credit + re.re+" </font>");
			$("#sendBtn").click();
		}else{
			layer.open({
				content: '今日已签过了，明日继续签到获累加奖励^_^'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
		}

	});
}
function openHbdiv(){
	layer.closeAll();
	layer.open({
		title: [
			'发红包',
			'background-color: #FF4351; color:#fff;'
		],
		type: 1
		,content: $("#sendHbdiv").html()
		,anim: 'up'
		,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 360px; padding:0 0 10px 0; border:none;border-radius:5px 5px 0px 0px'
	});
}
function openGiftdiv(){
	layer.closeAll();
	layer.open({
		type: 1
		,content: $("#giftdiv").html()
		,anim: 'up'
		,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 140px; padding:0 0 10px 0; border:none;'
	});
}
function sendGiftRe(e){
	$(".gift-re select").html('');
	var html='';
	var arr=UserList.List();
	for(var i in arr){
		if(arr[i].chatid.indexOf('x_r')<0&&arr[i].chatid!='ALL'){
			html+="<option value='"+arr[i].chatid+"'>"+arr[i].nick+"</option>";

			//$('#gift-reuser-uid').val(arr[i].chatid);
			//$('#gift-reuser-nick').val(arr[i].nick);
		}
	}
	$(".gift-re select").html(html);

	html=$("#giftsendDiv").html();
	var ginfo=$(e);
	html=html.replace('{title}',ginfo.data("title")).replace("{price}",ginfo.data("price")).replace("{gif}","<img src='"+ginfo.data("gif")+"'>").replace("{gid}",ginfo.data("id"));
	layer.closeAll();
	layer.open({
		type: 1
		,content: html
		,anim: 'up'
		,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 140px; padding:0 0 10px 0; border:none;'
	});
}
function sendGifts(e){
	$('#gift-reuser-uid').val($(e).parent().find(".gift-send-re").find('option:selected').val());
	$('#gift-reuser-nick').val($(this).find('option:selected').text());
	var sid=$(e).parent().find(".gift-send-re").find('option:selected').val()
	var nick=$(e).parent().find(".gift-send-re").find('option:selected').text()
	var num=$(e).parent().find('.gift-send-num').val();
	var gid=$(e).parent().find('.gift-send-gid').val();
	var gift=$("#gift"+gid);
	if(num<1){
		layer.open({
			content: '输入礼物数量！'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		});
		return;
	}
	if(sid&&nick&&num&&gid){
		layer.closeAll();
		$.get("/ajax.php?act=sendgift&sid="+sid+"&num="+num+"&gid="+gid,function(re){
			if(re=="0"){
				layer.open({
					content: '错误！没有该礼物数据！'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				});
			}
			else if(re=="-1"){layer.open({
				content: '金币不足，请充值！'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});}
			else if(re=="1"){
				SysSend.command('sendgift',"{uid:'"+My.chatid+"',nick:'"+nick+"',num:'"+num+"',gid:'"+gid+"'}");
				var msg="送给 <b>"+nick+"</b> <b style='color:#F90'>"+num+"</b> 份"+" <img src='"+gift.data("gif")+"' height='30' width='30'> "+gift.data("title")+" "+gift.data("txt");
				PutMsg(My.rid,My.chatid,'ALL',My.nick,'gift','false','',msg,'');
				layer.open({
					content: '礼物已经送出！'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				});
			}
		},'text');
	}
	else
	{
		layer.open({
			content: '系统错误！无法操作'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		});
		return;
	}
}
function sendHb(me,ne,txt,gid,gtitle){
	if(My.color=="0"){layer.open({
		content: '请登录'
		,skin: 'msg'
		,time: 2 //2秒后自动关闭
	});
		return;}
	if($(me).val()<5){
		layer.open({
			content: '金额最小5元'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		});
		return;
	}
	if($(ne).val()<1||$(ne).val()>500){
		layer.open({
			content: '个数最小1~500个'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		});
		return;
	}
	getMyMoney($(me).val(),$(ne).val(),$(txt).val(),$(gid).val(),$(gtitle).find("option:selected").text());
	layer.closeAll();

}

function getMyMoney(money,num,txt,togid,togtitle){
	if(My.color=="0"){layer.open({
		content: '请登录'
		,skin: 'msg'
		,time: 2 //2秒后自动关闭
	});
		return;
	}
	$.getJSON("/ajax.php?act=mymoney",function(re){
		if(money>parseInt(re.money)){
			layer.open({
				content: '余额不足，请充值'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});
			return;
		}else{
			$.getJSON("/ajax.php?act=sendhongbao",{rid:My.rid,money:money,number:num,txt:txt,togid:togid,togtitle:togtitle},
				function(re){
					if(re.code=="1"){
						SysSend.command('sendhongbao',"{uid:'"+My.chatid+"',hid:'"+re.hid+"',msg:'"+re.msg+"'}");
						layer.open({
							content: '红包已发送'
							,skin: 'msg'
							,time: 2 //2秒后自动关闭
						});
						PutMsg(My.rid,My.chatid,'ALL',My.nick,'hongbao','false','',re.msg,re.hid);
					}
					else if(re.code=="0"){
						layer.open({
							content: re.msg
							,skin: 'msg'
							,time: 2 //2秒后自动关闭
						});
					}
				});
		}

	});
}
function hideVideo(){
	$(".video-box").toggle();
	$(".am-tabs .am-active").click();
	if($(".video-box").is(":hidden"))$("#toggleVideo").removeClass("am-icon-eye").addClass("am-icon-eye-slash");
	else $("#toggleVideo").removeClass("am-icon-eye-slash").addClass("am-icon-eye");
}
function userInfo(){
	if(My.color=="0"){
		location.href='../minilogin.php?rid='+My.rid;
		//openPopIfrmae('未登录','../minilogin.php?rid='+My.rid);
	}
	else{
		location.href='profiles.m.php';
		//openPopIfrmae('用户中心','../profiles.php?uid='+My.chatid);
	}
}
function userPay(){
	openPopIfrmae('充值提现','/user/withdraw.php');
}
function openPopIfrmae(title,src){
	$(".video-box").hide();$(".am-tabs .am-active").click();
	if($(".video-box").is(":hidden"))$("#toggleVideo").removeClass("am-icon-eye").addClass("am-icon-eye-slash");
	else $("#toggleVideo").removeClass("am-icon-eye-slash").addClass("am-icon-eye");

	var html='  <header data-am-widget="header" class="am-header am-header-default iframe_header"><div class="am-header-left am-header-nav">  </div>';
	html+=' <h1 class="am-header-title">'+title+'</h1>';
	html+='<div class="am-header-right am-header-nav"><a href="javascript:;" class="" onclick="layer.closeAll()"><i class="am-header-icon am-icon-close" style="    margin: 8px 20px;"></i></a></div></header>';
	html+='<iframe frameborder=0 width=100% height=100% marginheight=0 marginwidth=0 scrolling=auto src="'+src+'"></iframe>';
	var pageii = layer.open({
		type: 1
		,content: html
		,anim: 'up'
		,style: 'position:fixed; left:0; top:0; width:100%; height:100%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s;'
	});
	$("#layui-m-layer"+pageii+" .layui-m-layercont").height($(window).height()-$("#layui-m-layer"+pageii+" .iframe_header").height());
	$("#layui-m-layer"+pageii+" .layui-m-layercont iframe").height($("#layui-m-layer"+pageii+" .layui-m-layercont").height());iosFrame();
}
function openPopWin(title,src){
	$(".video-box").hide();$(".am-tabs .am-active").click();
	if($(".video-box").is(":hidden"))$("#toggleVideo").removeClass("am-icon-eye").addClass("am-icon-eye-slash");
	else $("#toggleVideo").removeClass("am-icon-eye-slash").addClass("am-icon-eye");

	var html='  <header data-am-widget="header" class="am-header am-header-default iframe_header"><div class="am-header-left am-header-nav">  </div>';
	html+=' <h1 class="am-header-title">'+title+'</h1>';
	html+='<div class="am-header-right am-header-nav"><a href="javascript:;" class="" onclick="layer.closeAll()"><i class="am-header-icon am-icon-close" style="    margin: 8px 20px;"></i></a></div></header>';
	html+=src;
	var pageii = layer.open({
		type: 1
		,content: html
		,anim: 'up'
		,style: 'position:fixed; left:0; top:0; width:100%; height:100%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s;'
	});
	$("#layui-m-layer"+pageii+" .layui-m-layercont").height($(window).height()-$("#layui-m-layer"+pageii+" .iframe_header").height());
	$("#layui-m-layer"+pageii+" .layui-m-layercont iframe").height($("#layui-m-layer"+pageii+" .layui-m-layercont").height());iosFrame();
}


function iosFrame(){
	if(device.iphone()||device.ipad()||device.ios()){

		$("iframe").each(function(){
			$(this).parent().addClass("scroll-wrapper-ios");
		});
	}
}
var toggleScroll = true;
function bt_toggleScroll()
{
	if($("#bt_gundong").hasClass('noscroll')){
		$("#bt_gundong").removeClass('noscroll');
		toggleScroll = true;
	}
	else {
		$("#bt_gundong").addClass('noscroll');
		toggleScroll = false;
	}
}
function bt_MsgClear(){
	$('#publicChat .chat-item,.message-wrap,.info,.history-hr-wrap').remove();
}

function openApp(obj){
	if(obj.url.indexOf("javascript:")>-1){eval(obj.url.replace("javascript:",""));return;}
	layer.closeAll('iframe');
	if(obj.url.indexOf('?')>-1)obj.url+='&rid='+My.rid;
	else obj.url+='?rid='+My.rid;
	if(obj.target=="NewWin"){
		window.open(obj.url);
	}else{
		openPopIfrmae(obj.title,obj.url);
	}

}
function openUserList(){
	$("#header .msg-num-2").text('0').hide();
	$('#my-offcanvas .group').html('');
	var arr=UserList.List();
	for(var i in arr){
		UserList.showuser(arr[i]);
	}
	$('#my-offcanvas').offCanvas('open');
}
function showPtpMsg(u,str){
	openPPChatPtpChatWin(u,false);
	$('#ptpChatWin'+u.chatid).append(str);
	if($('#my-offcanvas').is(":hidden")&&$('#PPChatptpChat').is(":hidden")){
		$("#header .msg-num-2").text(parseInt($("#header .msg-num-2").text())+1).show();
	}


	if($('#PPChatptpChat').is(":hidden")||$('#PPChatptpChat').data('chatid')!=u.chatid){
		$('#ptpChatLi'+u.chatid+' .msg-num').text(parseInt($('#ptpChatLi'+u.chatid+' .msg-num').text())+1).show();
	}


	if($('#ptpChatWin'+u.chatid).find(".chat-item").length>100){$('#ptpChatWin'+u.chatid).find("div:eq(0)").remove();}
	$('#ptpChatCont').scrollTop($('#ptpChatCont')[0].scrollHeight);
	$('#ptpChatWin'+u.chatid+" img").unbind();
	$('#ptpChatWin'+u.chatid+" img").on("click",function(){if($(this).width()>119||$(this).height()>119)openPopWin('查看图片',"<img src='"+$(this).attr('src')+"' width=100% onclick='layer.closeAll()'>")});
}
function openPPChatPtpChatWin(u,active){
	if($("#ptpChatLi"+u.chatid).length<1){
		var groupimg="<img src='"+grouparr[u.color].ico+"'  align='top'/ >";
		var ref=getId("group_ptpchat");
		var li=CreateElm1(ref,'li',false,'ptpChatLi'+u.chatid,null);
		li.innerHTML='<a href="javascript:void(0)"  title="'+u.nick+'">'
			+'<span class="ugroup">'+groupimg+'</span>'
			+'<span class="uimg"><img src="'+u.mood+'" onerror="this.src=\'/face/p1/null.gif\'" border="0" class="head" /></span>'
			+'<span class="unick"><span class="am-badge am-badge-danger am-round msg-num" >0</span>'+u.nick+'</span>'
			+'</a>';
		li.onclick=function(){openPPChatPtpChatWin(u,true);}

	}

	if($('#ptpChatWin'+u.chatid).length<1){
		var html='<div class="publicChat" id="ptpChatWin'+u.chatid+'" style="display: none"></div>';
		$("#ptpChatCont").append(html);
	}
	if(active){
		$("#PPChatptpChat").data("chatid",u.chatid);
		$("#PPChatptpChat").data("nick",u.nick);
		$("#PPChatptpChat .am-header-title").html(u.nick);

		$("#PPChatptpChat").show();
		$("#PPChatptpChat .publicChat").hide();
		$('#ptpChatWin'+u.chatid).show();
		$('#ptpChatLi'+u.chatid+' .msg-num').text('0').hide();
	}
}
var oldmsgIndex=0;
function ChatHistory(t) {
	oldmsgIndex=oldmsgIndex+1;
	var PageSize = 20;
	$.ajax({
		url: "/ajax.php?act=oldmsg",
		data: {page:oldmsgIndex, type: t,rid:My.rid},
		type: "POST",
		dataType: "JSON",
		success: function (re) {
			if (re.code=="1") {
				$('.oldmsg').after(re.html);
			} else {
				$('.oldmsg .more-message').addClass('no-more');
				$('.oldmsg .more-message').html('没有更多消息');
			}
		}
	});
};
$(function(){
	$('.oldmsg').click(function(){ChatHistory('m')});
	$(".btn_plus_toggle").click(function(){
		if($(".div_plus").css("right")=="0px"){
			$(".div_plus").css("right","-61px");
			$(".div_plus i").removeClass("am-icon-chevron-right").addClass("am-icon-chevron-left");
		}else{
			$(".div_plus").css("right","0px");
			$(".div_plus i").removeClass("am-icon-chevron-left").addClass("am-icon-chevron-right");
		}
	});
	setTimeout("$('.btn_plus_toggle').click()",5000);
	setTimeout("$('#noticeContent').hide();",30000);
	$('.messageEditor').on('click', function () {
		var target = $(this).parent().parent().parent()[0];
		setTimeout(function(){
			target.scrollIntoView(false);
			//target.scrollIntoViewIfNeeded();
		},300);
	});
});