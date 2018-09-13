/*网成科技财经直播系统v3.1 QQ 3350933991*/
function thisMovie(movieName) 
{
	if (navigator.appName.indexOf("Microsoft") != -1)
		return window[movieName];
	else 
		return document[movieName];
}
var t=0;
function Auto()
{
	ws.send('ping:');
}
function XHConn() {
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) { 
  	    try {
  		    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	    } catch (e) {
  		    try {
  			    xmlhttp = new XMLHttpRequest();
  		    } catch (e) {
  			    xmlhttp = false;
  		    }
  	    }
    }
  
    return xmlhttp;
}

function interfaceInit()
{
//setInterval('Auto()',30000);
POPChat=(function(){
	var list=[];
	var user=null;
	var win=null;
	return{
		Init:function(){
			var html = '<div class="layim_chatbox" id="layim_chatbox">'
            +'<h6>'
            +'<span class="layim_move"></span>'
            +'    <a href="javascript:void(0)" class="layim_face" target="_blank"><img src="" ></a>'
            +'    <a href="javascript:void(0)" class="layim_names" target="_blank">聊天窗口</a>'
            +'    <a href="javascript:void(0)" class="layim_qq" target="_blank"></a>'
            +'    <span class="layim_rightbtn">'
            +'        <!--<i class="layer_setmin"></i>-->'
            +'        <i class="layim_close"></i>'
            +'    </span>'
            +'</h6>'
            +'<div class="layim_chatmore" id="layim_chatmore">'
            +'    <ul class="layim_chatlist"></ul>'
            +'</div>'
            +'<div class="layim_groups" id="layim_groups"></div>'
            +'<div class="layim_chat">'
            +'    <div class="layim_chatarea" id="layim_chatarea">'
            +'        <ul class="layim_chatview layim_chatthis"  id="layim_area"></ul>'
            +'    </div>'
            +'    <div class="layim_tool">'
            +'        <i class="layim_addface fa fa-smile-o" title="发送表情" onclick="showFacePanel(this,\'#layim_write\');"onclick="showFacePanel(this,\'#layim_write\');"></i>'
            +'        <a href="javascript:;"><i class="layim_addimage fa fa-photo" title="发送图片" onclick="bt_insertImg(\'#layim_write\')" ></i></a>'
            +'        <!--<a href="javascript:;"><i class="layim_addfile " title="上传附件"></i></a>-->'
            +'        <!--<a href="" target="_blank" class="layim_seechatlog"><i></i>聊天记录</a>-->'
            +'    </div>'
            +'    <div class="layim_write" id="layim_write" contentEditable="true" ></div>'
            +'    <div class="layim_send">'
            +'        <div class="layim_sendbtn" id="layim_sendbtn">发送<!--<span class="layim_enter" id="layim_enter"><em class="layim_zero"></em></span>--></div>'
            +'        <div class="layim_sendtype" id="layim_sendtype">'
            +'            <span><i>√</i>按Enter键发送</span>'
            +'            <span><i></i>按Ctrl+Enter键发送</span>'
            +'        </div>'
            +'    </div>'
            +'</div>'
            +'</div>';
		layer.open({
    	type: 1, 
        moveType: 1,
		shade: false,
		area: ['900px', '493px'],
        move: '.layim_chatbox .layim_move',
        title: false,
		closeBtn: false,
    	content: html,
		success: function(layero){
				
				win=layero;
				
                $('.layim_close').on('click', function(){
					  	layero.hide();
        		});
				$('#openPOPChat').on('click', function(){
					  	layero.show();
        		});
				win.find('#layim_chatmore').on('click', 'li em', function(){
						user=null;
						
						var find_li=win.find('.layim_chatlist li');
						
						if(find_li.length>1){
								$("#layim_user"+$(this).attr('data-id')).remove();
								$("#layim_area"+$(this).attr('data-id')).remove();
								var li=find_li.first();
								POPChat.showtab({chatid:li.attr('data-id'),nick:li.attr('data-nick')});
						}
						else{
							layero.hide();
						}
						return false;
						
        		});
				win.find('#layim_chatmore').on('click', 'li', function(){
            			var othis = $(this);
           				POPChat.showtab({chatid:othis.attr('data-id'),nick:othis.attr('data-nick')});
        		});
				
								
				
				win.find("#layim_sendbtn").on('click', POPChat.send);
				win.find("#layim_write").keyup(function(e){
					if(e.keyCode === 13){
						POPChat.send();
						return false;
					}
				});
				layero.hide();
            }
		
		});
		
		},
		send:function(){
			$("#manage_div input").attr('checked',false);
			if(user==null)return;
			var toUserInfo=UserList.get(user.chatid);
			var msg=encodeURIComponent($("#layim_write").html().str_replace().replace("<br>",""));
			if($.trim(msg)=="")return;
			PutMessage(My.rid,My.chatid,user.chatid,My.nick,user.nick,'true','',msg,'');
			
			if(typeof(toUserInfo)=="undefined"||user.chatid.indexOf('x_r')>-1){
				POPChat.showmsg(My,user,decodeURIComponent(msg));
				win.find("#layim_write").html("");
				MsgCAlert();
				layer.msg('用户离线,消息转存到历史纪录！', {  shift: 2,icon: 5,time:3000});
				return;
			}
			var str2='{"type":"SendMsg","tochatid":"'+user.chatid+'","personal":"true","msg":"'+msg+'","style":"color:#000","room_id":'+My.rid+',"chatid":'+My.chatid+'}';
			var str='SendMsg=M='+user.chatid+'|true|color:#000|'+msg;
			ws.send(str2);
			
			
			win.find("#layim_write").html("");
			win.find("#layim_write").focus();
			MsgCAlert();
		},
		newtab:function(u){
			var layim_chatmore = win.find('#layim_chatmore');
        	var layim_chatarea = win.find('#layim_chatarea');
			var layim_groups=win.find('#layim_groups');
			if(win.find('#layim_user'+u.chatid).length<1){
				//layim_chatmore.find('ul>li').removeClass('layim_chatnow');
       			layim_chatmore.find('ul').append('<li data-qq="" data-id="'+ u.chatid +'" data-nick="'+u.nick+'" id="layim_user' +u.chatid +'"><img src="/face/img.php?t=p1&u='+u.chatid+'"><span><b class="layim_msgnum">0</b>'+ u.nick +'</span><em  data-id="'+ u.chatid +'">x</em></li>');
				//layim_chatarea.find('.layim_chatview').removeClass('layim_chatthis');
        		layim_chatarea.append('<ul class="layim_chatview " id="layim_area'+ u.chatid +'"></ul>');
				$(".layim_group_"+u.chatid).remove();
				layim_groups.append("<ul class=' layim_group' id='layim_group"+u.chatid+"'><div class='uimg'><img src='/face/img.php?t=p1&u="+u.chatid+"'></div><div class='unick'>"+u.nick+"</div><div class='uqq'></div><div class='umsg'></div></ul>");
				$.ajax({type:'GET',dataType:'JSON',url:'/ajax.php?act=mymsgold&tuid='+u.chatid,async: true,
				success:function(data){
					
					$("#layim_group"+ data.tuid+" .umsg").html(data.kfmsg);
					$("#layim_area"+ data.tuid).prepend(data.msg);
					
					
					$("#layim_user"+data.tuid).attr('data-qq',data.realname);
					/*
					win.find('.layim_qq').html("<span><a href='http://wpa.qq.com/msgrd?v=3&uin="+data.realname+"&site=qq&menu=yes' target='_blank'>QQ:"+data.realname+"</a></span>");
					if(data.realname!=""&&data.realname!='0'){
						win.find('.layim_names').css("line-height",'20px');
						win.find('.layim_qq').show();
						$("#layim_group"+ data.tuid+" .uqq").html("<a href='http://wpa.qq.com/msgrd?v=3&uin="+data.realname+"&site=qq&menu=yes' target='_blank'>QQ:"+data.realname+"</a>");
					}else{
						win.find('.layim_names').css("line-height",'40px');
						win.find('.layim_qq').hide();
					}
					*/
					if($.trim(data.kfmsg)!=""){
						var str='<li class="layim_chatehe"><div class="layim_chatuser"><img src="/face/img.php?t=p1&u='+u.chatid+'"><span class="layim_chatname">'+u.nick+'</span><span class="layim_chattime">'+Datetime(0)+'</span></div><div class="layim_chatsay"><font>'+data.kfmsg+'</font><em class="layim_zero"></em></div></li>';
						$("#layim_area"+ u.chatid).append(str);
					}
					win.find('#layim_area'+ data.tuid).scrollTop(win.find('#layim_area'+ data.tuid)[0].scrollHeight);
				}});
				
				
			}
			
			
			win.show();
			if(layim_chatmore.find('li').length<2){
				
				POPChat.showtab(u);
			}
		},
		showtab:function(u){
			user=u;
                       
			var layim_chatmore = win.find('#layim_chatmore');
        	var layim_chatarea = win.find('#layim_chatarea');
			var layim_groups=win.find('#layim_groups');
			layim_groups.find('ul').removeClass('layim_groupthis');
			layim_chatmore.find('ul>li').removeClass('layim_chatnow');
			layim_chatarea.find('.layim_chatview').removeClass('layim_chatthis');
			
			win.find('#layim_group'+u.chatid).addClass('layim_groupthis');
			win.find('#layim_user'+u.chatid).addClass('layim_chatnow');
			win.find('#layim_area'+u.chatid).addClass('layim_chatthis');
			
			
			win.find('.layim_chatnow .layim_msgnum').text("0");
			win.find('.layim_chatnow .layim_msgnum').hide();
			
			win.find('.layim_face>img').attr('src', '/face/img.php?t=p1&u='+u.chatid);
    		win.find('.layim_names').text(u.nick);
	
			win.show();
			win.find('#layim_area'+ u.chatid).scrollTop(win.find('#layim_area'+ u.chatid)[0].scrollHeight);
			
			win.find('.layim_qq').html("<span><a href='http://wpa.qq.com/msgrd?v=3&uin="+$("#layim_user"+u.chatid).attr('data-qq')+"&site=qq&menu=yes'  target='_blank'>QQ:"+$("#layim_user"+u.chatid).attr('data-qq')+"</a>");
			
			if($("#layim_user"+u.chatid).attr('data-qq')!=""&&$("#layim_user"+u.chatid).attr('data-qq')!='0'){
						win.find('.layim_names').css("line-height",'20px');
						win.find('.layim_qq').show();
					}else{
						win.find('.layim_names').css("line-height",'40px');
						win.find('.layim_qq').hide();
			}
		},
		showmsg:function(u,u1,str){
			if(user.chatid!=u.chatid&&u.chatid!=My.chatid){
				win.find('#layim_user'+u.chatid+' .layim_msgnum').show();
				win.find('#layim_user'+u.chatid+' .layim_msgnum').text(Number(win.find('#layim_user'+u.chatid+' .layim_msgnum').text())+1+"");	
			}
			var log = {};
			if(u.chatid==My.chatid)
				log.imarea = win.find('#layim_area'+ u1.chatid);
			else
				log.imarea = win.find('#layim_area'+ u.chatid);
			log.html = function(param, type){
                return '<li class="'+ (type === 'me' ? 'layim_chateme' : ' layim_chatehe') +'">'
                    +'<div class="layim_chatuser">'
                        + function(){
                            if(type === 'me'){
                                return '<span class="layim_chattime">'+ param.time +'</span>'
                                       +'<span class="layim_chatname">'+ param.name +'</span>'
                                       +'<img src="'+ param.face +'" >';
                            } else {
                                return '<img src="'+ param.face +'" >'
                                       +'<span class="layim_chatname">'+ param.name +'</span>'
                                       +'<span class="layim_chattime">'+ param.time +'</span>';      
                            }
                        }()
                    +'</div>'
                    +'<div class="layim_chatsay">'+ param.content +'<em class="layim_zero"></em></div>'
                +'</li>';
            };
			log.imarea.append(log.html({
                time: Datetime(0),
                name: u.nick,
                face: '/face/img.php?t=p1&u='+u.chatid,
                content: str
            },u.chatid==My.chatid?'me':""));
			log.imarea.scrollTop(log.imarea[0].scrollHeight);
			//if(win.find('.layim_chatnow').attr('data-id'))
		}
	}
})();


UserList=(function(){
	var list=[];
	var OnLineUser=getId('OnLineUser');
	var OnlineUserNum=getId('OnlineUserNum');
	var OnlineOtherNum=getId('OnlineOtherNum');
	var PInfo=CreateElm(false,'div','','PInfo');
	var hold = 0;
	var show = 0;
	var onlinuser=0;
	var onlinmyuser=0;
	var def_list=$('#OnLineUser').html();
	list['ALL']={sex:2,chatid:'ALL',nick:'大家'}
	return{
		List:function(){return list},
		init:function(){
			list=[];
			$('.group').html('');
			//OnLineUser.innerHTML='';
			OnlineUserNum.innerHTML='0';
			OnlineOtherNum.innerHTML='0';
			onlinuser=RoomInfo.r;
			onlinmyuser=0;
			list['ALL']={sex:2,chatid:'ALL',nick:'大家'}
			UserList.add(My.chatid,My);
			//获取rebots在线列表
			var request_url='ajax.php?act=getrlist&rid='+My.rid+'&r='+RoomInfo.r;
			var xmlhttp=XHConn();
				try{
				xmlhttp.open("GET",request_url,true);
				xmlhttp.send(null);
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							//alert(xmlhttp.responseText);
							WriteMessage(xmlhttp.responseText);
						}
					}
				}
				catch(e){return null;}
			},
		get:function(id){return list[id];},
		delmyuser:function(id){
			var u=UserList.get(id);
			if(u==undefined)return;
			//if(My.color=='3'&&u.cam==My.name){//modify by danddy 2018-09-11
			if(My.color=='4'&&u.cam==My.name){
				$("#group_myuser").find("#myuser"+id).remove();
				onlinmyuser--;
				OnlineOtherNum.innerHTML=$("#group_myuser li").length;
			}
		},
		addmyuser:function(u){
					if(u.chatid==My.chatid)return;
					var ref=getId("group_myuser");
					if($("#group_myuser").find("#myuser"+u.chatid).length>0)
					{
						$("#group_myuser").find("#myuser"+u.chatid).remove();
						onlinmyuser--;
					}					
					var li=CreateElm1(ref,'li',false,'myuser'+u.chatid,null);
					if(grouparr[u.color]==undefined)return;
					var groupimg="<img src='"+grouparr[u.color].ico+"'  align='top' title='"+grouparr[u.color].title+'-'+grouparr[u.color].sn+"'>";
						
					li.innerHTML='<a href="javascript:void(0)"  title="'+u.nick+'">'
					+'<span class="ugroup">'+groupimg+'</span>'
					+'<span class="uimg"><img src="'+u.mood+'" border="0" class="head" /></span>'
					+'<span class="unick">'+u.nick+'</span>'
					+'</a>';
					
					li.oncontextmenu=function(){UserList.menu(u);return false;}
					li.onclick=function(){ToUser.set(u.chatid,u.nick);}
					li.ondblclick=function(){if(u.chatid!=My.chatid||u.chatid.indexOf('x_r')<0){POPChat.newtab(u);POPChat.showtab(u);}}				
					
					onlinmyuser++;
					OnlineOtherNum.innerHTML=$("#group_myuser li").length;
					//layer.open({title:'衣食父母',content:'客户【'+u.nick+'】上线！',icon: 6,btn:['私聊','关闭'],yes:function(index){layer.close(index);POPChat.newtab(u);POPChat.showtab(u);}});
		},
		getmylist:function(user){
			for(var k in list){
					if(typeof(list[k].cam)!="undefined"){
						if(My.name==list[k].cam){
						UserList.addmyuser(list[k]);
						}
					}
			}
		},
		showuser:function(u){
			if($("#"+u.chatid).length >0)return;
			if(grouparr[u.color]==undefined)return;
			var vip_ico="<img src='"+grouparr[u.color].ico+"'  align='top' title='"+grouparr[u.color].title+'-'+grouparr[u.color].sn+"'>"; 
			
			
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
			
			var groupimg="<img src='"+grouparr[u.color].ico+"'  align='top'/ title='"+grouparr[u.color].title+'-'+grouparr[u.color].sn+"'>"; 
						
					li.innerHTML='<a href="javascript:void(0)"  title="'+u.nick+'">'
					+'<span class="ugroup">'+groupimg+'</span>'
					+'<span class="uimg"><img src="'+uimg+'" onerror="this.src=\'/face/p1/null.gif\'" border="0" class="head" /></span>'
					+'<span class="unick">'+u.nick+'</span>'
					+'</a>';
			li.oncontextmenu=function(){UserList.menu(u);return false;}
			li.onclick=function(){if(!check_auth("msg_ptp")){return;}ToUser.set(u.chatid,u.nick);}
			li.ondblclick=function(){if(!check_auth("msg_priv")){layer.msg('没有私聊权限！',{shift: 6});return;}if(u.chatid!=My.chatid&&u.chatid.indexOf('x_r')<0){POPChat.newtab(u);POPChat.showtab(u);}}



				//if ((u.color == "2" || u.color == "3" || u.color == "4" || u.color == "5")&&$("#mg"+u.chatid).length <1) {// modify by danddy 2018-09-11
					if ((u.color == "1" || u.color == "4" || u.color == "5" || u.color == "6")&&$("#mg"+u.chatid).length <1) {

					ref = getId("group_manage");
					var li = CreateElm1(ref, 'li', false, 'mg' + u.chatid, null);
					li.innerHTML = '<a href="javascript:void(0)"  title="' + u.nick + '">'
						+ '<span class="ugroup">' + groupimg + '</span>'
						+ '<span class="uimg"><img src="' + uimg + '" onerror="this.src=\'/face/p1/null.gif\'" border="0" class="head" /></span>'
						+ '<span class="unick">' + u.nick + '</span>'
						+ '</a>';
					li.onclick=function(){POPChat.newtab(u);POPChat.showtab(u);}
					li.ondblclick=function(){POPChat.newtab(u);POPChat.showtab(u);}
				}

		},
		showmore:function(num){
			var i=0;
			for(var k in list){		
				
				if(list[k]=="undefined"||k=="ALL")continue;
				var u=list[k];
				if($("#"+u.chatid).length >0)continue;
				this.showuser(u);
				if(++i>=num)break;
			}			
		},
		add:function(id,u){
//			console.log(list);
			list[id]=u;
//			console.log(list);
			//我的用户上线
			//if(My.color=='4'&&u.cam==My.name){//modify by danddy  2018-09-11
			if(My.color=='6'&&u.cam==My.name){
					this.addmyuser(u);					
			}
			
			onlinuser++;
			this.showuser(u);
				
			OnlineUserNum.innerHTML=onlinuser;		
		},
		setstate:function(id,state,automsg){
			list[id].state=state;
			//getId(id).title=automsg;
			//getId('state'+id).src="images/state"+state+".png";
		},
		del:function(id,u){
			UserList.delmyuser(id);
			if(id==My.chatid)return;
			var tmp_u=list[id];
			onlinuser--;
			OnlineUserNum.innerHTML=onlinuser;
			
			$("#"+id).empty();
			$("#"+id).remove();
			$("#mg"+id).remove();
			ToUser.del(id);
			
			delete(list[id]);
			
		},
		info:function(id){
			show = setTimeout(function(){UserList.showInfo(id)},0);
		},
		showInfo:function(id){
			if(hold)clearTimeout(hold);
			var u=this.get(id);
			
			var t=getXY(getId(id));
			PInfo.style.top=t[0]-142+'px';
			PInfo.style.left=t[1]+248+'px';
			//PInfo.innerHTML='Login:'+u.roomid+'|'+u.chatid+'|'+u.nick+'|'+u.sex+'|'+u.age+'|'+u.guest+'|'+u.ip+'|'+u.vip+'|'+u.color+'|'+u.cam+'|'+u.headface+'|'+u.state+'|<br><br><br>'+u.automsg;
			var request_url='ajax.php?act=userinfo&type=json&id='+id+'&'+Math.random() * 10000;
			var xmlhttp=XHConn();
			try{
				xmlhttp.open("GET",request_url,true);
				xmlhttp.send(null);
				xmlhttp.onreadystatechange=function()
				{
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
					{
					var UInfo=eval("("+xmlhttp.responseText+")");
					if(My.vip>0)uip=" [ <a href='http://www.ip138.com/ips8.asp?ip="+u.ip+"&action=1' target='_blank' title='点击查询地理位置'>"+u.ip+"</a> ]";
					else uip="";
					PInfo.innerHTML='<div style="width:280px; height:150px; padding:6px;" class="info_m">'
					+'<div style="width:100px; height:150px; float:left; margin-right:6px; margin-bottom:6px" class="info_m_l"><img src="/face/img.php?t=p2&u='+id+'" style="width:100px; height:150px;"></div>'
					+'<div style="float:left; width:174px; height:150px; overflow:hidden" class="info_m_r">'
					+'<div><a href="/room/profile.php?uid='+id+'" target="userinfo"  style="cursor:pointer;color:#06C;">'+UInfo.nick+'</a></div><div style="color:#999" class="info_m_m">'+UInfo.sn+'</div><div class="info_m_">'+UInfo.rank+'</div><div><a href="/room/profile.php?uid='+id+'" target="userinfo"  style="cursor:pointer;">'+UInfo.yx+'</a></div>'
					+'</div></div><div style="width:292px; height:20px; color:#000" >&nbsp;&nbsp;所在地：'+UInfo.city+uip+'</div>';
					PInfo.style.display = '';
					PInfo.style.cursor='default';
					}
				}
				
			}catch(e){return null;}
			
		},
		infoOver : function(){
			if(hold)clearTimeout(hold);
		},
		infoHold:function(){
			hold = setTimeout(UserList.infoHidden,500);
			PInfo.onmouseover= UserList.infoOver;
			PInfo.onmouseout = UserList.infoHold;
			if(show)clearTimeout(show);
		},
		infoHidden : function(){
			PInfo.style.display = 'none';
		},
		infos:function(id){
			var u=this.get(id);
			alert(u.nick)
		},
		setVideo:function(u){
				SysSend.command('setVideo',My.rid+'_+_'+u.chatid+'_+_'+u.nick);
				$('#menu').hide();
				var xmlhttp=XHConn();
				var request_url="ajax.php?act=setvideo&vid="+u.chatid+"&rid="+My.rid
				try{
				xmlhttp.open('GET',request_url,true);
				xmlhttp.send(null);
				}
				catch(e) {return true;}
		},
		menu:function(u)
		{
			//if(My.color=='0')return;
			u=this.get(u.chatid);
			
			this.infoHidden();
			var UserMenu= Menu.init('120px');
			if(My.chatid==u.chatid)
			{
				UserMenu.add('street-view','我的资料',function(){$('#menu').hide();openWin(2,false,'/room/profiles.php?uid='+u.chatid,460,600);});
			}
			else
			{
			UserMenu.add('comments','私聊',function(){$('#menu').hide();if(!check_auth("msg_priv")&&u.cam!=My.name){layer.msg('没有私聊权限！',{shift: 6});return;}if(u.chatid!=My.chatid&&u.chatid.indexOf('x_r')<0){POPChat.newtab(u);POPChat.showtab(u);}} );
			//UserMenu.hr();
			UserMenu.add('user','查看资料',function(){$('#menu').hide();if(!check_auth("user_info")){layer.msg('没有用户资料查看权限！',{shift: 6});return;}openWin(2,false,'/room/profiles.php?uid='+u.chatid,460,600);});
			//UserMenu.hr();
			UserMenu.add('eye-slash','屏蔽消息',function(){BList.add(u.chatid,u);$('#menu').hide();layer.msg('已屏蔽！');});
			
			if(check_auth("room_admin"))
				{
					//UserMenu.hr();
					UserMenu.add('exclamation-triangle','禁言',function(){ToUser.set(u.chatid,u.nick);SysSend.command('send_Msgblock','');layer.msg('命令已发送！');});
					UserMenu.add('user-times','踢出、封IP',function(){$('#menu').hide();if(!check_auth("user_kick")){layer.msg('没有用户踢出权限！',{shift: 6});return;}UKick.ShowMb(u);});
				}
			}
			var e=getEvent();
			UserMenu.display(e.clientX,e.clientY);
		}
	}
})();
PublicVideo=(function(){
	
})();
UKick=(function(){
	return{
		ShowMb:function(u){
			var loadstr='<div  id="kickmp" onselectstart="return true;">';
			loadstr+='<select name="MCmd" id="MCmd" onchange="if(this.value==\'kick\')getId(\'ktime\').style.display=\'\'"><option value="kick">踢出+封IP</option></select>';
			loadstr+='&nbsp;<select id="ktime" name="ktime"><option value="5256000">禁闭10年</option><option value="1">禁闭01分钟</option></select>';
			loadstr+='<br><br><input type="text" name="cause" id="cause" value="原因" size="24" /><br><button class="bt1" onclick="UKick.SendCmd(\''+u.chatid+'\',\''+u.nick+'\')">执行</button>';
			loadstr+='</div>';
				openWin(1,'踢出 '+u.nick,loadstr,290,200);
		},
		SendCmd:function(chatid,nick){
			ToUser.set(chatid,nick);
			SysSend.command('kick',getId('ktime').value+'_+_'+getId('cause').value);
			layer.closeAll();
			alert('操作成功!');
		}
			
			
	}
})();
BList=(function(){
	var List=[];
	return{
		init:function(){List=[]},
		add:function(id,u){
			if(BList.isExist(id)){BList.del(id);return;}
			List[id]=u;
			UserList.setstate(id,'00','已经屏蔽消息');
			},
		isExist:function(id){
			var r=false;
			for(key in List){
				if(id==List[key].chatid){return true;}
				}
			return r;
			},
		del:function(id){
			UserList.setstate(id,'0','');
			delete List[id];
			}
		}
})();

ToUser=(function(){
	$('#ToUser').change(function () {
		ToUser.set($(this).val(),$(this).find("option:selected").text());
    });
	return{
		id:null,
		name:null,
		add:function(id,name){
			$('#ToUser option[value='+id+']').remove();
			$("#ToUser").append("<option value='"+id+"'>"+name+"</option>");
			$('#ToUser option[value='+id+']').attr('selected','selected');
			
		},
		del:function(id){
			$('#ToUser option[value='+id+']').remove();
		},
		set:function(id,name){
			if(id==My.chatid)return;
			this.id=id;
			this.name=name;
			this.add(id,name);	
			$('#toName').html(name);		
		}
	}
})();

var oldMsg;
var oldTime;
var msgTag=false;
SysSend=(function(){
	return{
		isUser:function()
		{
			if(ToUser.id.indexOf('x_r')>-1){ToUser.set('ALL','大家');}
			var toUserInfo=UserList.get(ToUser.id);
			if(typeof(toUserInfo)=="undefined"){alert('对方已经离线！');ToUser.del(ToUser.id);return false;}
//			if(ToUser.id=='ALL'){alert('先选择一个网友！');return false;}
			return true;
		},
		msg:function(){
			//var reg = new RegExp(msg_unallowable, "ig");
			//if(reg.test(getId('Msg').innerHTML)&&!check_auth("room_admin")){layer.msg('含敏感关键字，内容被屏蔽！',{shift: 6});return false;}
			//if(!check_auth("room_admin"))str=str.replace(reg,'**');
			if(!check_auth("msg_send")){layer.msg('没有发言权限！',{shift: 6});return false;}
			if(RoomInfo.banall=='1'&&My.qx!='1'){
				layer.msg('全体禁言中！',{shift: 6});
					RoomInfo.banall='1';return;
			}
			if($("#chat_type").val()!="me"){SysSend.command('rebotmsg',encodeURIComponent(getId('Msg').innerHTML));$("#Msg").html('');return true;}
//			console.log(this.isUser(),ToUser,this);
			if(ToUser.id!="ALL")
			if(!this.isUser())return false;
			var toUserInfo=UserList.get(ToUser.id);
			if(toUserInfo.state=='00')alert("注意:"+toUserInfo.nick+' 的消息你已经屏蔽,你将收不到来自ta的消息');
			if(typeof(toUserInfo)=="undefined"){alert('对方已经离线！');ToUser.del(ToUser.id);return false;}
			var Msg=getId('Msg').innerHTML; 
			var Style="font-weight:"+getId('Msg').style.fontWeight+";font-style:"+getId('Msg').style.fontStyle+"; text-decoration:"+getId('Msg').style.textDecoration+";color:"+getId('Msg').style.color+"; font-family:"+getId('Msg').style.fontFamily+"; font-size:"+getId('Msg').style.fontSize;
			var Msg=encodeURIComponent(Msg.str_replace());
			if(Msg==oldMsg && My.qx=='0'){layer.msg('请勿刷屏！',{shift: 6});getId('Msg').innerHTML='';return;}
			var newTime=new Date().getTime();
			if(newTime-oldTime<500){alert("说话速度过快~歇会儿！");return;}
			if(msgTag){if(newTime-oldTime>5000)msgTag=false;else {alert("说话速度过快~歇会儿！");return;}}
			
			if(Msg!='')
			{
			var msgid=randStr()+randStr();
			var str='SendMsg=M='+ToUser.id+'|'+getId('Personal').value+'|'+Style+'|'+msgid+'_+_'+Msg;
			var str2='{"type":"SendMsg","tochatid":"'+ToUser.id+'","personal":"'+getId('Personal').value+'","msg":"'+msgid+'_+_'+Msg+'","style":"'+Style+'","room_id":'+My.rid+',"chatid":'+My.chatid+'}';
			ws.send(str2);
			
			oldMsg=Msg;
			oldTime=new Date().getTime();
			getId('Msg').innerHTML='';
			getId('Msg').focus();
			
			PutMessage(My.rid,My.chatid,ToUser.id,My.nick,toUserInfo.nick,getId('Personal').value,Style,Msg,msgid);
			}
			return true;
		},
		command:function(cmd,value){
			var Msg='';
			var IsPersonal=getId('Personal').value;
			var Style="font-weight:"+getId('Msg').style.fontWeight+";font-style:"+getId('Msg').style.fontStyle+"; text-decoration:"+getId('Msg').style.textDecoration+";color:"+getId('Msg').style.color+"; font-family:"+getId('Msg').style.fontFamily+"; font-size:"+getId('Msg').style.fontSize;
			var touser=ToUser.id;
			switch(cmd)
			{
				case 'setVideoSrc':
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='false';
					touser="ALL";
				break;
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
				case 'magicflash':
					if(this.isUser())
					{
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal=getId('Personal').value;
					}
				break;
				case 'requestVideo':
					if(this.isUser())
					{
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='true';
					}
				break;
				case 'setstate':
					//ToUser.id='ALL';
					Msg+='C0MMAND_+_'+cmd+'_+_'+My.chatid+'_+_'+value;
					IsPersonal='false';
					touser="ALL";
				break;
				case 'rebotmsg':
					if(!check_auth("rebots_msg"))return false;
					//var rebot=UserList.get($("#chat_type").val());
					var rebot_name=$("#chat_type").find("option:selected").text();
					var rebot_id=$("#chat_type").val(); 
					var rebot_gid=$("#chat_type").find("option:selected").data('gid');
					Msg+='C0MMAND_+_'+cmd+'_+_'+rebot_id+'_+_'+rebot_name+'_+_'+value+'_+_'+rebot_gid;					
					IsPersonal='false';
					touser="ALL";
					
					PutMessage(My.rid,rebot_id,'ALL',rebot_name,'大家',getId('Personal').value,'',value,'rebotmsg');
				break;
				case "automsg":
					if(!check_auth("rebots_msg"))return false;
					var renum=$('#chat_type').find('option').length;
						if(renum<=1){
							alert('您还没有机器人马甲，不能自动发言！请到后台机器人再来！');
							return;
						}
					var treb=  parseInt(Math.random()*(renum-1)+1);
					var rebot_id=$('#chat_type').find('option').eq(treb).val();
					var rebot_name=$("#chat_type").find("option").eq(treb).text();
					//var rebot=UserList.get(rebot_id);					
					var rebot_gid=$('#chat_type').find('option').eq(treb).data('gid');
					Msg+='C0MMAND_+_rebotmsg_+_'+rebot_id+'_+_'+rebot_name+'_+_'+value+'_+_'+rebot_gid;					
					IsPersonal='false';
					touser="ALL";					
					PutMessage(My.rid,rebot_id,'ALL',rebot_name,'大家',getId('Personal').value,'',value,'rebotmsg');
				break;
				case "showTip":
					Msg+='C0MMAND_+_'+cmd+'_+_'+value;
					IsPersonal='false';
					touser="ALL";
				break
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
				var str2='{"type":"SendMsg","tochatid":"'+touser+'","personal":"'+IsPersonal+'","msg":"'+Msg+'","style":"'+Style+'","room_id":'+My.rid+',"chatid":'+My.chatid+'}';
				var str='SendMsg=M='+touser+'|'+IsPersonal+'|'+Style+'|'+Msg;
				try{
					ws.send(str2);
				}catch(e){ws.send(str);alert("[Send Error]["+str+"]"+e);}
				
				if(Msg.indexOf('C0MMAND_')<0)
				getId('Msg').innerHTML='';
				getId('Msg').focus();
			}
		}
	}
})();
Menu=(function(){
	var MObj;
	return{
	init:function(w){
		RemoveElm(false,getId('menu'))
		this.MObj=CreateElm(false,'div',false,'menu');
		this.MObj.tabIndex=1;
		this.MObj.style.width=w;
		this.MObj.style.display='none';
		this.MObj.style.zIndex=100;
		return this;
		},
	add:function(icon,txt,fun){
		var n=CreateElm(this.MObj,'div','li','n');
		n.innerHTML='<div id="icon" ><i class="fa fa-'+icon+'"></i></div><span id="txt">'+txt+'</span>';
		n.onclick=fun;
		},
	hr:function(){
		var n=CreateElm(this.MObj,'div','hr','n');
		n.style.height='1px';
		n.style.fontSize='1px';
		},
	display:function(x,y){
		this.MObj.style.display='';
		this.MObj.style.top=y-$(this.MObj).height()+'px';
		this.MObj.style.left=x+'px';
		
		this.MObj.focus();
		this.MObj.onblur=function(){BrdBlur('menu');}
		
		}
	}
})();
}
function WriteMessage(txt){
	if(txt.indexOf('SendMsg')!=-1)
	alert(txt);
	var Msg;
	try{
		Msg=eval("("+txt+")");
	}catch(e){return;}
	if(Msg.stat!='OK')
	{
		if(Msg.stat=="MaxOnline"){
			document.body.innerHTML='<div  style="font-size:12px; text-align:center; top:100px; position:absolute;width:100%">O.O 对不起，服务端并发数已满！请您联系管理员对系统扩容升级！<br><br></div>';
			return;
		}
		if(Msg.stat=="OtherLogin"){
			location.href="/room/error.php?msg="+encodeURI('其他地方登录！请注意同一帐号不能两处登录、同一电脑不能两处打开房间！')
		}
		return ;
	}
	switch(Msg.type)
	{
		case "Ulogin":
			var U=Msg.Ulogin;
			var vip_msg="到来";
			var date= Datetime(0);
			var str='<div style="height:22px; line-height:22px;">欢迎：<font class="u" onclick="ToUser.set(\''+U.chatid+'\',\''+U.nick+'\')">'+U.nick+'</font> <font class="date">'+date+'</font></div>';
			str='<div class="fsl-come2"><span>' + U.nick + ' </span>进入直播间</div>';
			MsgShow(str,3);
			if(My.chatid!=U.chatid){
			UserList.add(U.chatid,U);
			}
			
		break;
		case "UMsg":
			var str=FormatMsg(Msg.UMsg);
			var type=0;
			if(!str)return;
			if(BList.isExist(Msg.UMsg.ChatId))return;
			if(Msg.UMsg.ToChatId==My.chatid) {type=2;MsgAlert(0);if(audioNotify==true)playSound('msg.mp3');}
			
			if(Msg.UMsg.ChatId==My.chatid) type=2;
			if(Msg.UMsg.ToChatId=='ALL'){if(Msg.UMsg.ChatId==My.chatid)type=2;else type=0;} 
			if(Msg.UMsg.IsPersonal!='true'){
				MsgShow(str,type);
			}
			else
			{
				if(Msg.UMsg.ChatId==My.chatid){
					POPChat.newtab(UserList.get(Msg.UMsg.ToChatId));
				}
				else{
					POPChat.newtab(UserList.get(Msg.UMsg.ChatId));
				}
				POPChat.showmsg(UserList.get(Msg.UMsg.ChatId),UserList.get(Msg.UMsg.ToChatId),"<font style='"+Msg.UMsg.Style+"'>"+decodeURIComponent(Msg.UMsg.Txt.str_replace())+"</font>");
			
			}	
		break;
		case "UonlineUser":
			var onlineNum=Msg.roomListUser.length;
			for(i=0;i<onlineNum;i++)
			{
			var U=Msg.roomListUser[i];
			UserList.add(U.chatid,U);
			}
			//UserList.showmore(15);
		break;
		case "Ulogout":
			var U=Msg.Ulogout;
			var date= Datetime(0);
			var str='<div style="height:22px; line-height:22px;">用户：<font class="u" onclick="ToUser.set(\''+U.chatid+'\',\''+U.nick+'\')">'+U.nick+'</font>   离开！ <font class="date">'+date+'</font></div>';
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

function CommObjectCheck(obj, inObj)
{
	if (obj == inObj)
	{
		return true;
	}
	if(obj.parentNode) {
		return CommObjectCheck(obj.parentNode, inObj);
	}
	return false;
}
function CreateElm(pObj,obj,className,id){
	var elm = null;
	var elm=document.createElement(obj);
	if(!pObj)document.body.insertBefore(elm,null);
	else pObj.insertBefore(elm,null);
	if(id)elm.id = id;
	if(className)elm.className = className;
	return elm
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
 

function RemoveElm(pObj,id)
{
	$(id).html("");
	$(id).remove()
}


String.prototype.str_replace=function(t){
	var str=this;
	
		
	str= str.replace(/<\/?(?!br|img|font|p|span|\/font|\/p|\/span)[^>]*>/ig,'').replace(/\r?\n/ig,' ').replace(/(&nbsp;)+/ig," ").replace(/(=M=)+/ig,"").replace(/(|)+/ig,"").replace(/(SendMsg)/ig,'');
	
	return str;
	};
function LinkMaker( str ) {
	return str.replace( /(https?:\/\/[\w.]+[^ \f\n\r\t\v\"\\\<\>\[\]\u2100-\uFFFF]*)|([a-zA-Z_0-9.-]+@[a-zA-Z_0-9.-]+\.\w+)/ig, function( s, v1, v2 ) {
		if ( v2 )
			return [ '<a href="mailto:', v2, '">', v2, '</a>' ].join( "" );
		else
			return [ '<a href="', s, '">', s, '</a>' ].join( "" );
	} );
}
function SwapLink()
{
	if(!isIE)
	getId('Msg').innerHTML=LinkMaker(getId('Msg').innerHTML);
	
	var as=getId('Msg').getElementsByTagName('a');
	for ( var i = as.length - 1; i >= 0; i-- ) {
		as[i].target='_blank';
		as[i].className='MsgUrlStyle';
	}
}
function PutMsg(rid,uid,tid,uname,tname,privacy,style,str,msgid){
	var request_url='ajax.php?act=putmsg';
	var postdata='msgid='+msgid+'&uname='+encodeURIComponent(uname)+'&tname='+encodeURIComponent(tname)+'&muid='+uid+'&rid='+rid+'&tid='+tid+'&privacy='+privacy+'&style='+style+'&msg='+str+'&'+Math.random() * 10000;
	if(RoomInfo.Msglog=='0')return;	
	$.ajax({type: 'POST',url:request_url,data:postdata});
}
function PutMessage(rid,uid,tid,uname,tname,privacy,style,str,msgid){
	var msgtip="";
	var request_url='ajax.php?act=putmsg';
	var postdata='msgid='+msgid+'&uname='+encodeURIComponent(uname)+'&tname='+encodeURIComponent(tname)+'&muid='+uid+'&rid='+rid+'&tid='+tid+'&privacy='+privacy+'&style='+style+'&msg='+str+'&'+Math.random() * 10000;
	if($("#msg_tip").attr("checked")){
		msgtip="msgtip=2&";
		$("#msg_tip").attr("checked",false);
		SysSend.command('showTip','2_+_'+str);
		$.ajax({type: 'POST',url:request_url,data:msgtip+postdata});
	}
	if($("#msg_tip_admin").attr("checked")){
		msgtip="msgtip=3&";
		$("#msg_tip_admin").attr("checked",false);
		SysSend.command('showTip','3_+_'+str);
		$.ajax({type: 'POST',url:request_url,data:msgtip+postdata});
	}
	if($("#msg_tip_feiping").attr("checked")){
		$("#msg_tip_feiping").attr("checked",false);
		SysSend.command('showTip','4_+_'+str);
	}
	if($("#msg_tip_qinghe").attr("checked")){
		$("#msg_tip_qinghe").attr("checked",false);
		SysSend.command('showTip','5_+_'+str);
	}
	if($("#msg_tip_banall").attr("checked")){
		$("#msg_tip_banall").attr("checked",false);
		if(RoomInfo.banall=="0")
		{SysSend.command('showTip','6_+_'+str);RoomInfo.banall="1";}
		else
		{SysSend.command('showTip','7_+_'+str);RoomInfo.banall="0";}
		$.get('/ajax.php?act=banall&val='+RoomInfo.banall+'&rid='+My.rid);
		return;
	}
	
	if(RoomInfo.Msglog=='0')return;	
	$.ajax({type: 'POST',url:request_url,data:msgtip+postdata});
}
function Mkick(adminid,rid,ktime,cause)
{
	$.ajax({type: 'get',dataType:'json',url: 'ajax.php?act=kick&aid='+adminid+'&rid='+rid+'&ktime='+ktime+'&cause='+encodeURIComponent(cause)+'&u='+encodeURIComponent(My.name)+'&'+Math.random() * 10000,
			success:function(data){
				//alert(data);
				if(data.state=="yes"){
				location.href="/room/error.php?msg="+encodeURI('你被踢出！并禁止'+ktime+'分钟内登陆该房间！<br>原因是 '+cause+'');
				}
			}
	});
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
				$('#defvideosrc').html("当前讲师："+command[3]);
				RoomInfo.PVideo=User.chatid;
				RoomInfo.PVideoNick=command[3];
				var str='【'+command[3]+'】 开讲啦！欢迎提问交流！^_^';
				$('body').barrager({'img':User.mood,'info':str});
				return;
				
			break;
			case 'showTip':
				if(User.qx!="1")break;
				if(command[2]=="2"){
					$("#marquee1 ul").prepend("<li>"+command[3]+"</li>");tipsMarquee();
				}
				else if(command[2]=="3"){
					$("#marquee2 ul").prepend("<li>"+command[3]+"</li>");tipsMarquee();
				}
				else if(command[2]=="4"){
					$('body').barrager({'img':User.mood,'info':command[3]});
				}
				else if(command[2]=="5"){
					startFireWorks(300,command[3]);
				}
				else if(command[2]=="6"){
					layer.msg('全体禁言中！',{shift: 6});
					RoomInfo.banall='1';
				}
				else if(command[2]=="7"){
					layer.msg('解除全体禁言！');
					RoomInfo.banall='0';
				}
			break;
			case 'send_Msgblock':
				if(User.qx!="1")break;
				if(My.chatid==toUser.chatid){
					remove_auth('msg_send');
					layer.msg('你已被禁言！',{shift: 6});
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
				ShowGifteffect(ginfo,gift);
				var msg="送给 <b>"+ginfo.nick+"</b> <b style='color:#F90'>"+ginfo.num+"</b> 份"+" <img src='"+gift.data("gif")+"' height='30' width='30'> "+gift.data("title")+" "+gift.data("txt");
				var str='<div class="chat-item notmine  system"><div class="user-img"> <div class="uimg"><img src="'+u.mood+'"/></div><div class="gimg"><img src="'+grouparr[u.color].ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name" onclick="ToUser.set(\''+u.chatid+'\',\''+u.nick+'\')" oncontextmenu="return bt_kick(\''+u.chatid+'\',\''+u.nick+'\')">'+u.nick+'</span> <span class="chat-time">'+date+'</span></div><div class="chat-info-2"> <div class="chat-msg">'+msg+'</div></div></div></div>';
				var tx_msg="<img src='"+gift.data("gif")+"' height='180'><div style='font-size:16px'><br>送给 <b>"+ginfo.nick+"</b> <b style='color:#F90'>"+ginfo.num+"</b> 份"+"<br>"+gift.data("title")+"<br>"+gift.data("txt")+"</div>";
				startFireWorks(300,decodeURIComponent(tx_msg));
			break;
			case "sendhongbao":
				var hinfo=eval("("+command[2]+")");
				var u=UserList.get(hinfo.uid);
				ShowHbeffect(ginfo,gift);
				var msg='<div class="redbag-top" title="'+hinfo.msg+'" data-hid="'+hinfo.hid+'" onclick="getHongBao($(this).data(\'hid\'))"><div class="fl"><img src="/room/images/hongbao.png" style="margin-top: 3px;"></div><div class="fl ml10" style="color:#fff;"><p style="font-weight:bold;margin-bottom:4px;color:#f30;font-size:14px;">'+hinfo.msg+'</p>领取红包</div></div><div style="padding:3px 10px;background: #fff;color: #333;">直播室红包</div>';
				var str='<div class="chat-item notmine  hongbaomsg"><div class="user-img"> <div class="uimg"><img src="'+u.mood+'"/></div><div class="gimg"><img src="'+grouparr[u.color].ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name" onclick="ToUser.set(\''+u.chatid+'\',\''+u.nick+'\')" oncontextmenu="return bt_kick(\''+u.chatid+'\',\''+u.nick+'\')">'+u.nick+'</span> <span class="chat-time">'+date+'</span></div><div class="chat-info-2"> <div class="chat-msg">'+msg+'</div></div></div></div>';
			break;
			case "gethongbao":
				var hinfo=eval("("+command[2]+")");
				var u=UserList.get(hinfo.uid);				
				var str='<div class="message-wrap"><div class="redbag-info1"><p style="color:#333;">'+u.nick+' 领取了 <span style="color:red;">'+hinfo.nick+'</span> 的红包获得 <span style="color:red;">'+hinfo.money+'元</span></p></div><div class="clear"></div></div>';
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
			msgAuditBt=" <a href='javascript:void(0)' onclick='bt_msgAudit(\""+msgid+"\",this)' id='bt_audit_"+msgid+"'><img src='/room/images/22.png' style='border:0px;' title='审核通过'></a>";
			msgAuditShow="";
		}
		
	}
	//管理员不用审核
	//if(User.color=='2'||User.color=='3'||User.color=='4'||User.color=='5'||User.chatid==My.chatid){//modify by danddy  2018-09-11
	if(User.color=='1'||User.color=='4'||User.color=='5'||User.color=='6'||User.chatid==My.chatid){
		msgAuditShow="";msgAuditBt="";
	}
	var who=" notmine ";	
//	if(User.color=='2'||User.color=='5'){  //modify by danddy  2018-09-11
	if(User.color=='1'||User.color=='5'){ 
		who+=" manage";
	}
//	else if(User.color=='3'||User.color=='4'){   //modify by danddy  2018-09-11
	else if(User.color=='4'||User.color=='6'){
		who+=" teacher";
	}
	if(User.chatid==My.chatid){
		//who=" notmine";
	}
	
	if(toUser.chatid!="ALL"){
		Txt="@"+toUser.nick+" "+Txt;
	}
	var uimg=User.mood;
	str='<div class="chat-item '+who+'" id="'+msgid+'" '+msgAuditShow+'><div class="user-img"> <div class="uimg"><img src="'+uimg+'" onerror="this.src=\'/face/p1/null.gif\'"/></div><div class="gimg"><img src="'+grouparr[User.color].ico+'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name" onclick="ToUser.set(\''+User.chatid+'\',\''+User.nick+'\')" oncontextmenu="return bt_kick(\''+User.chatid+'\',\''+User.nick+'\')">'+User.nick+'</span> <span class="chat-time">'+date+'</span><img src="/room/images/'+User.age+'.png"></div><div class="chat-info-2"> <div class="chat-msg">'+Txt+msgBlockBt+msgAuditBt+'</div></div></div></div>';

	}
	return str;
	
}
function fNumberAnimate(i, e, t, a, o, n) {
    i = "" + i;
    var  f = '<i class="symbol"></i>'
      , r = i.length
      , l = t.find(".gifts-num")
      , c = 230;
    l.data("max", i);
    for (var u = 0; r > u; u++)
        f += '<span class="nums num-0 num-ul" data-num="0" style="height: ' + c + 'px" data-index="' + u + '"></span>',
        c = 10 * c;
    l.html(f),
    o ? fNumScrollUniformSpeed(l.find(".num-ul").last(), l, e, !0, 0, a) : (n = Math.max(1, n),
    n = Math.min(n, e),
    fNumScrollUniformSpeed(l.find(".num-ul").last(), l, n, !1, 0, a))
}
function fNumScrollUniformSpeed(i, e, t, a, o, n) {
    var f = 23
      , r = +i.data("num") + 1
      , l = r * f
      , c = i.data("index")
      , u = c - 1
      , g = t
      , d = +e.data("max");
    if (!a) {
        var p = [300, 200, 100, 90, 80];
        c == e.find(".num-ul").length - 1 && (g = d / 2 > o ? p[o] || g : p[d - o - 1] || g)
    }
    0 == r % 10 && u >= 0 && fNumScrollUniformSpeed(e.find(".num-ul").eq(u), e, g),
    i.animate({
        marginTop: "-" + l + "px"
    }, g, function() {
        i.data("num", r),
        c == e.find(".num-ul").length - 1 && (o++,
        o == d ? n(): fNumScrollUniformSpeed(i, e, t, a, o, n))
    })
}
//你又开始无耻了 脸红啊
function ShowGifteffect(ginfo,gift){
	if(ginfo.num<10)return;
	var id=ginfo.uid+ginfo.num+randStr();
	var n=ginfo.num>=1414?1314:(ginfo.num>=999?999:(ginfo.num>=520?520:(ginfo.num>=99?99:1)));
	var html='<div class="send-gifts-ibox gifts-ibox-{n} js-slide-gift-show" id="ppchat_{id}">  <div class="send-gifts-inner">    <p class="names">{nick}</p>    <div class="send-bottom">      <p class="gifts-name dv">送出<span class="js-num-max-count">{num}</span>份 {title}</p>    </div>    <div class="gifts-num clearfix"><i class="symbol"></i>    </div>    <img src="{gif}" alt="" class="gifts-icon"> </div></div>'
	html=html.replace("{id}",id).replace("{n}",n).replace("{nick}",ginfo.nick).replace("{num}",ginfo.num).replace("{gif}",gift.data("gif")).replace("{title}",gift.data("title"));
	$("#gift-showbox").show();
	$("#gift-showbox").prepend(html);
	$("#ppchat_"+id).animate({
                marginLeft: '0px'
            },300,function(){
					fNumberAnimate(ginfo.num.toString(),100,$("#ppchat_"+id),function(){$("#ppchat_"+id).fadeOut(1000, function (){$(this).remove();if($("#gift-showbox").children().length<1)$("#gift-showbox").hide();});},0,0);}
	);
}
var msgBlock='';
function MsgShow(str,type){
	if(type==3){
		if ($('#whocomein div').length >= 4) {
				$('#whocomein div:last').animateCss("bounceOutLeft", function() {
                    $(this).remove()
                });
		}
			var $_div = $(''+str);
			$('#whocomein').prepend($_div);
			$_div.animateCss("bounceInLeft");
			setTimeout(function() {
                $_div.animateCss("bounceOutLeft", function() {
                    $_div.remove()
                });
        	}, 3e3);
	}
	else{
		$('#MsgBox1').append(str);
	}
	
	if($('#MsgBox1').find(".chat-item").length>100){$('#MsgBox1').find(".chat-item:first").empty();$('#MsgBox1').find(".chat-item:first").remove();}
	$(".chat-msg img").unbind();
	$(".chat-msg img").on("click",function(){if($(this).width()>300||$(this).height()>300)open_img($(this).attr('src'),1300,800)});
	$(".chat-msg img").on("mouseover",function(){if($(this).width()>300||$(this).height()>300){$(this).attr("title","点击看大图");$(this).addClass("chat-pic");}});
	MsgAutoScroll();
}
function MsgAutoScroll(){
	if(toggleScroll)
	$('#MsgBox1').scrollTop($('#MsgBox1')[0].scrollHeight);
	//$('#MsgBox1').animate({scrollTop:$('#MsgBox1')[0].scrollHeight}, 500);
}
var blinkerTimer;
function MsgAlert(tag)
{
	MsgCAlert();
	
	if(tag==0){document.title='您有新消息！祝你聊得愉快！';blinkerTimer=setTimeout('MsgAlert(1)',1000);}
	if(tag==1){document.title=RoomInfo.defaultTitle;blinkerTimer=setTimeout('MsgAlert(0)',1000);}
}
function MsgCAlert()
{
	if(blinkerTimer)clearTimeout(blinkerTimer);document.title=RoomInfo.defaultTitle;
}


function saveCode(obj,filename){
  var winname = window.open("", "", "top=10000,left=10000");
  winname.document.open("text/html", "replace");
  winname.document.writeln(obj);
  winname.document.execCommand("saveas", "", filename + ".html");
  winname.close();
}



//魔法表情
function online(rst)
{
	
	var xmlhttp=XHConn();
	var request_url="ajax.php?act=online&rst="+rst+"&num="+getId('OnlineUserNum').innerHTML+"&"+Math.random() * 10000;
	try{
		xmlhttp.open('GET',request_url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				var re = eval("("+xmlhttp.responseText+")");
				if(re.state=="logout")
				{layer.msg('你还没有登陆！',{shift: 6});}
				else if(re.state=='ologin')
				{
					var str='<div><img src="images/true.png" width="16" height="16"  style="vertical-align:text-bottom" /> '+Datetime(0)+' <br /> &nbsp;&nbsp;&nbsp;帐号其他地方登录或网络异常！统一帐号不能两个地方（浏览器登录）！ <a href="javascript:location.reload()" style="color:#0033FF;cursor:pointer">点击重新连接</a> </div>';
					//MsgShow(str,1);
				}
			}
			return true;
		}
	}
	catch(e) {return true;}
}
function ColorNick(id,i){return;
	if(i>=9)i=0;
	var col = ["white","coral","orange","red","greenyellow","lime","turquoise","coral","blueviolet","violet"];
	document.getElementById(id).style.color=col[i++];
	setTimeout("ColorNick('"+id+"',"+i+")",100);
}
function playSound(file){
	getId('MsgSound').innerHTML='<audio  src="sounds/' + file + '" loop="0" autostart="true" hidden="true"></audio>';
}
function openWin(type,title,content,w,h){
	layer.closeAll('iframe'); 
		layer.open({
		type: type,
		title: title,
		shadeClose: true,
		shade: 0.5,
		shift: 2,
		area: [w+'px', h+'px'],
		content: content //iframe的url
		});
	
}
function openApp(obj){
	layer.closeAll('iframe');
	if(obj.url.indexOf('?')>-1)obj.url+='&rid='+My.rid;
	else obj.url+='?rid='+My.rid;
	if(obj.target=="NewWin"){
		window.open(obj.url);
	}
	else if(obj.target=="POPWin"){
		layer.open({
		type: 2,
		title: obj.title,
		shadeClose: true,
		shade: 0.5,
		shift: 2,
		area: [obj.w+'px', obj.h+'px'],
		content: obj.url //iframe的url
		});
	}
	else if(obj.target=="QPWin"){
		layer.open({
    	type: 2,
		shadeClose: true,
		shade: 0.5,
		shift: 2,
		title: false, //不显示标题
		content: [obj.url,'no'], //捕获的元素
		area: [obj.w+'px', obj.h+'px']
	});
	}
	
}
var tbox;
function loginTip(){	
	//$('#OnLine_MV').html('直播体验结束，请登录！');
	//openWin(2,false,'/room/minilogin.php',390,310);
	layer.close(tbox);
        var boxstr='<div class="tbox malert"><div class="tinner"><div class="tcontent"><p id="alertmsg">您已在直播室收听5分钟，赶紧领取会员或VIP马甲，点击下方注册会员或联系上方QQ在线客服，即刻享受更多优质服务。</p><div class="bts"><a id="reg" href="javascript:openWin(2,false,\'room/minilogin.php?a=0\',370,525);">注册</a> <a id="login" href="javascript:openWin(2,false,\'room/minilogin.php\',370,340);">登录</a></div></div><div class="closeMessBtn" onclick="layer.close(tbox);"></div></div></div>';
        tbox= layer.open({
		type: 1,
		title: false,
		shadeClose: true,
		shade: false,
               closeBtn: false,
                 bgcolor: '',
		area: ['600px', '468px'],
		content: boxstr 
		});
                
                layer.style(tbox, {
		'box-shadow':'none',
		'background-color': 'transparent'
    
	}); 
}
function app_sendmsg(msg){
	var msgid=randStr()+randStr();
	var str='SendMsg=M=ALL|false|color:#000|'+msgid+'_+_'+encodeURIComponent(msg.str_replace());
			
	ws.send(str);
	PutMessage(My.rid,My.chatid,'ALL',My.nick,'ALL','false','',msg.str_replace(),msgid)
}
function check_auth(auth){
	var auth_rules = grouparr[My.color].rules;
	if(auth_rules.indexOf(auth)>-1)return true;
	else false;
}
function remove_auth(auth){
	grouparr[My.color].rules=grouparr[My.color].rules.replace(auth,"");
}
function BrdBlur(id) {
	
		var e=getEvent();
		var act=document.activeElement?document.activeElement:e.explicitOriginalTarget
		var src=e.srcElement ? e.srcElement : e.target
		if (!CommObjectCheck(act, src)) {
			getId(id).style.display='none';
		}
}

function HideMenu()
{
    var elementTable=["ColorTable","Send_key_option","FontBar"];
    for(var i=0;i<elementTable.length;i++)
      getId(elementTable[i]).style.display='none'
} 
//全局事件绑定
//window.onblur =function(){
//    if(!isIE){
//        HideMenu();
//    }
//}; 
function getEvent() //同时兼容ie和ff event
{  
        if(document.all)   return window.event;    
        func=getEvent.caller;        
        while(func!=null){  
            var arg0=func.arguments[0];
            if(arg0)
            {
              if((arg0.constructor==Event || arg0.constructor ==MouseEvent) || (typeof(arg0)=="object" && arg0.preventDefault && arg0.stopPropagation))
              {  
              return arg0;
              }
            }
            func=func.caller;
        }
        return null;
}
function MsgKeyDown()
{

}
function showsyssmg(txt){
	//alert(txt);
	var date= Datetime(0);
	var s='<div class="chat-item notmine system"><div class="user-img"> <div class="uimg"><img src="/face/sys.gif"/></div><div class="gimg"></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name">系统消息</span> <span class="chat-time">'+date+'</span></div><div class="chat-info-2"> <div class="chat-msg">'+txt+'</div></div></div></div>';
	
	MsgShow(s,0);
}
function getsysmsg(){
	$.getJSON("ajax.php?act=getsysmsg","rid="+My.rid,
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
function sendCaitiao(tag){
	var ct=[];
	ct['dyg']='<img src="/room/face/colorbar/dyg.gif">';
	ct['zyg']='<img src="/room/face/colorbar/zyg.gif">';
	ct['gl']='<img src="/room/face/pic/s1.gif"><img src="/room/face/pic/s1.gif"><img src="/room/face/pic/s6.gif"><img src="/room/face/pic/s6.gif"><img src="/room/face/pic/geili_thumb.gif"><img src="/room/face/pic/geili_thumb.gif"><img src="/room/face/pic/s0.gif"><img src="/room/face/pic/s0.gif">';
	ct['zs']='<img src="/room/face/colorbar/zs.gif">';
	ct['xh']='<img src="/room/face/colorbar/xh.gif">';
	//app_sendmsg(ct[tag]);
	$("#Msg").html(ct[tag]);
	$("#Send_bt").click();
}
var initFace=false;
function showFacePanel(e,toinput){
if(!initFace){initFaceColobar();initCt();initFace=true;}
	var offset = $(e).offset();

	var t = offset.top;
	var l = offset.left;
	$('#face').css( {"top" : t-$('#face').outerHeight(), "left":l});
	$('#face').show();
	$('#face').attr("toinput" , toinput);
}
function showCt(){
if(!initFace){initFaceColobar();initCt();initFace=true;}
	var offset = $('#bt_caitiao').offset();
			var t = offset.top;
			var l = offset.left;
			$('#caitiao').css( {"top" : t-$('#caitiao').outerHeight(), "left":l});
	
			$('#caitiao').show();
	
}
function  initFaceColobar(){
	
	$.get("/room/face/pic/face.html",function(data){
		$('#face').html(data);
		$('#facenav li').on('click',function(){
			var rel = $(this).attr('rel');
			$('#face dl').hide();
			$('#f_'+rel).show();
			$(this).siblings().removeClass('f_cur');
			$(this).addClass('f_cur');

		});	
	}).success(function(){
		$(document).bind('mouseup',function(e){
		if($(e.target).attr('isface')!='1' && $(e.target).attr('isface')!='2')
		{
			$('#face').hide();
			//$(document).unbind('mouseup');
		}
		else if($(e.target).attr('isface')=='1')
		{
			var toinput =$('#face').attr("toinput");
			$(toinput).append('<img src="'+$(e.target).attr('src')+'" onresizestart="return false" contenteditable="false">');
		}
	});


	});
}
function initCt(){
		$.get("/room/face/colorbar/colorbar.html",function(data){
		$('#caitiao').html(data);
		
		$('#caitiaonav li').on('click',function(){

			var rel = $(this).attr('rel');
			$('#caitiao dl').hide();
			$('#c_'+rel).show();
			$(this).siblings().removeClass('f_cur');
			$(this).addClass('f_cur');
		});	
		$(document).bind('mouseup',function(e){
				if($(e.target).attr('isnav')!='1')
				{
					$('#caitiao').hide();
				}
			});
	});
}
function sendgift(){
//	if(My.color=="2"){openWin(2,false,'/room/minilogin.php',370,340);}//modify by danddy 2018-09-11
	if(My.color=="1"){openWin(2,false,'/room/minilogin.php',370,340);}
	else if($("#gift-id").val()==0){layer.msg('请选择礼物');}
	else {
		var gift=$(".gifts-content").find(".active");
		if(gift.length<1){layer.msg('系统错误，不能获取礼物信息！');return;}
		$("#gift-reuser select").html('');
		var html='';
		var arr=UserList.List();
		for(var i in arr){
			if(arr[i].chatid.indexOf('x_r')<0&&arr[i].chatid!='ALL'){
				html+="<option value='"+arr[i].chatid+"'>"+arr[i].nick+"</option>";
		
				$('#gift-reuser-uid').val(arr[i].chatid);
				$('#gift-reuser-nick').val(arr[i].nick);
			}
		}
		$("#gift-reuser select").html(html);
		html=$("#gift-reuser").html();
		//html=html.replace("{uid}",RoomInfo.PVideo).replace("{nickname}",RoomInfo.PVideoNick);
		
		var lw=layer.open({
		  title: '选择送给谁',
		  content: html,
		  shadeClose: true,
		  btn:["送出"],
		  btn1: function(index, layero){
			  var sid=$('#gift-reuser-uid').val();
			  var nick=$('#gift-reuser-nick').val();
			  var num=$('#gift-num').val();
			  var gid=$('#gift-id').val();
			  if(sid==0||num==0||gid==0){layer.msg('送礼数据错误！'+sid+num+gid);return;}
			  
			  $.get("ajax.php?act=sendgift&sid="+sid+"&num="+num+"&gid="+gid,function(re){
			  if(re=="0"){layer.msg('错误！没有该礼物数据！',{shift: 6});}
			  else if(re=="-1"){layer.msg('金币不足，请充值！',{shift: 6});}
			  else if(re=="1"){
				  SysSend.command('sendgift',"{uid:'"+My.chatid+"',nick:'"+nick+"',num:'"+num+"',gid:'"+gid+"'}");
				  var msg="送给 <b>"+nick+"</b> <b style='color:#F90'>"+num+"</b> 份"+" <img src='"+gift.data("gif")+"' height='30' width='30'> "+gift.data("title")+" "+gift.data("txt");
				  PutMsg(My.rid,My.chatid,'ALL',My.nick,'gift','false','',msg,'');
			  }
			  },'text');
		  }
		});
	}
	//openWin(2,'送礼物','../sendgift.php?froom=froom&gid='+g+'&sid='+s,300,200);
}
function open_img(src,width,height){

timg =layer.open({
    type: 1,
     moveType: 1,
       title: false,
       shadeClose: true,
        move: '.layui-layer-content',
       moveOut: true,
      skin: 'layui-layer-rim',
      area: [width,+'px', height+'px'],
    content:'<div class="tcontent"><img src="'+src+'" style="max-width:'+($(window).width()-40)+'px;max-height:'+($(window).height()-40)+'px"/></div>'
});

}

function openWinTx(){
	
	//if(My.color=="0"){ //modify by danddy 2018-09-11
	if(My.color=="2"){ 
		openWin(2,false,'/room/minilogin.php',370,340);
	}
	else{
		openWin(2,false,'/user/withdraw.php',460,600);
	}
}
$.fn.extend({
    animateCss: function(e, t) {
        var i = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
        return this.addClass("animated " + e).one(i, function() {
            $(this).removeClass("animated " + e),
            "function" == typeof t && t()
        }),
        this
    }
})
//历史消息
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
				$('.view-more-records').after(re.html);
			} else {
				$('.view-more-records .more-message').addClass('no-more');
				$('.view-more-records .more-message').html('没有更多消息');
			}
		}
	});
};
/*网成科技财经直播系统v3.1 QQ33509339917*/