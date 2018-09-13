//var e=getEvent();
//var jq = jQuery.noConflict();
//window.onbeforeunload=function(){ws.send("Logout");}
/*网成科技财经直播系统v3.1 QQ 3350933991*/
function getId(id)
{
	return document.getElementById(id);
}
function Datetime(tag)
{
	return new Date().toTimeString().split(' ')[tag];	
}
function SetChatValue(Variables,value)
{
	ChatValue[Variables]=value;
}
function GetChatValue(Variables)
{
	return ChatValue[Variables];
}

var ChatValue =new Array(10);

function showLive(){
	if(RoomInfo.OtherVideoAutoPlayer=='0'){location.reload();}
	$('#OnLine_MV').html($('#OnLine_MV').html());
}
var ws;
var page_fire;
function OnSocket(){
	ws=new WebSocket("ws://"+RoomInfo.TServer+":"+RoomInfo.TSPort);  //127.0.0.1  7272
//	console.log('222'); h9w0.socket.1du1.com
//	ws=new WebSocket("ws://127.0.0.1:"+RoomInfo.TSPort);
//	ws=new WebSocket("ws://h9w0.socket.1du1.com:60592"); 
//	ws=new WebSocket("ws://127.0.0.1:7272");
	ws.onopen=onConnect;
	ws.onmessage=function(e){WriteMessage(e.data);};
	ws.onclose=function(){setTimeout('OnSocket()',1000);};
	ws.onerror=function(){};
}
function OnInit()
{	
	OnSocket();
	//auth
	if(check_auth("room_admin")){$('#manage_div').css('display','block');}
	if(check_auth("rebots_msg")){$('#chat_type').show();$('#chat_type_automsg').show();}
	if(check_auth("def_videosrc"))$('#bt_defvideosrc').show();
	window.moveTo(0,0);
	window.resizeTo(screen.availWidth,screen.availHeight);
	OnResize();	
	
	if($.browser.msie&&($.browser.version == "6.0")&&!$.support.style)
	{
		location.href='/room/error_browser.html?msg='+encodeURIComponent('您使用的是不安全IE6.0浏览器,请升级到最新版本或<br>下载安装<a href=http://chrome.360.cn/ target=_blank>360浏览器</a>或<a href=http://www.baidu.com/s?wd=chrome target=_blank>Google浏览器</a>!');
		return false;
	}
	$.ajaxSetup({ contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	
	
	interfaceInit();
	POPChat.Init();
	ToUser.set('ALL','大家');

	$('#UI_Left1').niceScroll({cursorcolor:"#000",cursorwidth:"1px",cursorborder:"0px;"});
	$('#MsgBox1').niceScroll({cursorcolor:"#ccc",cursorwidth:"3px",cursorborder:"0px;"});
	$('#OnLineUser_FindList').niceScroll({cursorcolor:"#FFF",cursorwidth:"3px",cursorborder:"0px;"});
	$('#OnLineUser_OhterList').niceScroll({cursorcolor:"#FFF",cursorwidth:"3px",cursorborder:"0px;"});
	$('#OnLineUser').niceScroll({cursorcolor:"#ccc",cursorwidth:"0px",cursorborder:"0px;"});
	$('#NoticeList').niceScroll({cursorcolor:"#ccc",cursorwidth:"3px",cursorborder:"0px;"});

	$("#Msg").keydown(function(e){if(e.keyCode==13){ToUser.set($("#ToUser").val(),$("#ToUser").find("option:selected").text());SysSend.msg();HideMenu();MsgCAlert();return false}});
	$("#Send_bt").on("click",function(){ToUser.set($("#ToUser").val(),$("#ToUser").find("option:selected").text());HideMenu();MsgCAlert();SysSend.msg();});
	
	$("body").click(function() { MsgCAlert();});
	
	
	
	//5分钟提示登录
//	if(RoomInfo.loginTip=='1'&&My.color=="2")  // modify by danddy
	if(RoomInfo.loginTip=='1'&&My.color=="2")
	setInterval("loginTip()",1000*60*5);
//	loginTip();	
	//游客主动私聊
//	if(RoomInfo.msgwin=='1'&&My.color=='2'){  // modify by danddy
	if(RoomInfo.msgwin=='1'&&My.color=='2'){
		$('.kfbase').click();
	}
	
	$('#Msg').html("连接中...");
	getsysmsg();
	
	if(RoomInfo.loginImg!=""){
		var img = new Image();img.src =RoomInfo.loginImg ;	
		img.onload=function(){openWin(1,false,'<a href="javascript://" target="_blank" onclick="window.open($(\'#kfbt2\').attr(\'href\'))"><img src="'+RoomInfo.loginImg+'"/></a>',img.width,img.height);}	
	}
	
	
	$("#adImg").responsiveSlides({
	  auto: true,             // Boolean: 设置是否自动播放, true or false
	  speed: 500,            // Integer: 动画持续时间，单位毫秒
	  timeout: 2500,          // Integer: 图片之间切换的时间，单位毫秒
	  pager: true,           // Boolean: 是否显示页码, true or false
	  nav: false,             // Boolean: 是否显示左右导航箭头（即上翻下翻）, true or false
	  random: false,          // Boolean: 随机幻灯片顺序, true or false
	  pause: true,           // Boolean: 鼠标悬停到幻灯上则暂停, true or false
	  pauseControls: true,    // Boolean: 悬停在控制板上则暂停, true or false
	  prevText: "<",   // String: 往前翻按钮的显示文本
	  nextText: ">",       // String: 往后翻按钮的显示文本
	  maxwidth: "",           // Integer: 幻灯的最大宽度
	  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
	  manualControls: "",     // Selector: 声明自定义分页导航
	  namespace: "rslides",   // String: 修改默认的容器名称
	  before: function(){},   // Function: 回调之前的参数
	  after: function(){}     // Function: 回调之后的参数
	});
	$("#comImg").responsiveSlides({
	  auto: true,             // Boolean: 设置是否自动播放, true or false
	  speed: 500,            // Integer: 动画持续时间，单位毫秒
	  timeout: 3000,          // Integer: 图片之间切换的时间，单位毫秒
	  pager: true,           // Boolean: 是否显示页码, true or false
	  nav: true,             // Boolean: 是否显示左右导航箭头（即上翻下翻）, true or false
	  random: false,          // Boolean: 随机幻灯片顺序, true or false
	  pause: true,           // Boolean: 鼠标悬停到幻灯上则暂停, true or false
	  pauseControls: true,    // Boolean: 悬停在控制板上则暂停, true or false
	  prevText: "<",   // String: 往前翻按钮的显示文本
	  nextText: ">",       // String: 往后翻按钮的显示文本
	  maxwidth: "",           // Integer: 幻灯的最大宽度
	  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
	  manualControls: "",     // Selector: 声明自定义分页导航
	  namespace: "rslides",   // String: 修改默认的容器名称
	  before: function(){},   // Function: 回调之前的参数
	  after: function(){}     // Function: 回调之后的参数
	});
	
	$('.NoticeList .tab a:first').addClass('active');
	$('#NoticeList .notice_div:first').css('display','');
	$('.NoticeList .tab a').on('click',function(){
		$('.NoticeList .tab a').removeClass('active');
		$(this).addClass('active');
		$('#NoticeList .notice_div').css('display','none').removeClass('in');
		$('#'+$(this)[0].id+'_div').css('display','').addClass('in');
	});
	$(".show-gifts").click(function(){$(".show-gifts").removeClass("active");$(this).addClass("active");$("#gift-id").val($(this).data("id"));});
	$(".show-gifts").mouseover(function(){
		var html='<div class="gift-tips"><div class="gift-tips-gif"><img src="{gif}"/></div><div class="gift-tips-info"><div class="gift-tips-info-title"><span class="gift-name">{name}</span><span class="gift-gold"></span><span class="gift-price">{price}</span></div><div style="clear:both"></div><div class="gift-tips-info-msg">{txt}</div></div></div>';
		var gift=$(this);
		html=html.replace("{gif}",gift.data("gif")).replace("{name}",gift.data("title")).replace("{price}",gift.data("price")).replace("{txt}",gift.data("txt"));
		layer.tips(html, "#gift"+gift.data("id"),{tips: [1, '#fff'],maxWidth:'400px',shift:-1,time:100000});
	});
	$(".show-gifts").mouseout(function(){$(".layui-layer-tips").hide()});
	
	$("#view-m").mouseover(function(){
		var html='<div style="    padding: 2px; text-align: center;"><img src="/apps/ewm.php?url=http://'+My.dm+'/room/m/?rid='+My.rid+'"><br>手机扫一扫<br>手机聊天更方便</div>';
		layer.tips(html, $("#view-m"),{tips: [1, '#eb6200'],maxWidth:'180px',shift:-1,time:100000});
	});
	$("#view-m").mouseout(function(){$(".layui-layer-tips").hide()});
	
	$("#gift-send").click(function(){sendgift()});
	bt_SwitchListTab('olUs');
	tipsMarquee();
}
function tipsMarquee(){
	$('#marquee1 .new').remove();
	$('#marquee2 .new').remove();
	$('#marquee1').kxbdSuperMarquee({isMarquee:true,direction:'left',isEqual:false,scrollDelay:20});
	$('#marquee2').kxbdSuperMarquee({isEqual:false,	distance:40,time:3,direction:'up'});
}
function bt_myrebots(){
	return;
	for(var i=0;i<20;i++){
		var rebot_id=$("#group_rebots li").eq(i).attr("id");
		var rebot_txt=$("#group_rebots li ").eq(i).find("strong").html();
		$("#chat_type").append("<option value='"+rebot_id+"'>"+rebot_txt+"</option>");
	}
	
}
function OnResize(){
	
	var cW=$(window).width();
	var cH=$(window).height()-8;
	$('#UI_MainBox').height(cH);
	
	/*
	if(cW<800){$('#UI_Left').hide();mw=320;}
	else if(cW<1024){$('#UI_Left').hide();mw=420;}
	else if(cW<1280){$('#UI_Left').show();mw=320;}
	else if(cW<1366){$('#UI_Left').show();mw=420;}
	else if(cW<1440){$('#UI_Left').show();mw=460;}
	else if(cW<1600){$('#UI_Left').show();mw=500;}
	else if(cW<1920){$('#UI_Left').show();mw=650;}
	else if(cW>=1920){$('#UI_Left').show();mw=cW-1260;}
	*/
	$('#UI_Left').show();mw=cW-720;
	$('#UI_Left').height(cH-$("#UI_Head").height()+8);
	$('#UI_Left .tab_div').height($('#UI_Left').height()-$('#Left_wrap').height()-10)
	$('#OnLineUser_FindList').height($('#UI_Left .tab_div').height()-$('#OnlineUser_Find').height());
	$('#OnLineUser').height($('#OnLineUser_FindList').height());
	$('#OnLineUser_OhterList').height($('#UI_Left .tab_div').height());
	
	$('#UI_Right').css("width",cW-mw-($('#UI_Left').is(":hidden")?0:$('#UI_Left').width())-12);	
	$('#UI_Central').css("margin-right",$('#UI_Right').outerWidth());
	
	/*
	if(cH<600){
		$('.NoticeList').hide();
		$('#OnLine_MV').css("height",cH-$('#UI_Head').height()-$('#LivePanel .title').height()-$('#ppchat-gift').height()-12);}
	else {
		$('.NoticeList').show();
		//广告保持比例10：2 20间距
		$('#OnLine_MV').css("height",cH-$('#UI_Head').height()-$('#LivePanel .title').height()-$('.NoticeList .tab').height()-$('#ppchat-gift').height()-23-$('.NoticeList').width()*0.35);
	}-$('#ppchat-gift').height()-14
	*/
	$('#OnLine_MV').css("height",cH-$('#UI_Head').height()-$('#LivePanel .title').height()-$('.NoticeList .tab').height()-13-$('.NoticeList').width()*0.35);

	$('#MsgBox1').height($('#MsgBox1').height()+cH-$('#UI_Central').height()-$('#UI_Head').height());
	
	
	
	$('#NoticeList').height($('.NoticeList').width()*0.35);
	$('#NoticeList .notice_div').height($('#NoticeList').height());
	$('#NoticeList .notice_div.txt').height($('#NoticeList').height()-20);
	
	//$("#gift-showbox").height($("#OnLine_MV").height());
	$("#gift-showbox").width(400);
	$("#gift-showbox").offset({"left":$("#OnLine_MV").offset().left,"top":$("#OnLine_MV").offset().top});

}
function OnUnload(){
	var str="Logout=M=";
	ws.send(str);
	
}
function tCam(tag)
{
	//My.cam=tag;
}
function tCamState(tag)
{
	My.camState=tag;
	//alert(tag);
}
function onConnect()
{
	My.age='null';
	if(device.iphone()||device.ios()||device.ipad())My.age='ios';
	else if(device.mobile())My.age='android';	
	setInterval("online(0)",1000*60*10);
	$('#Msg').html('');
	UserList.init();
	var str='Login=M='+My.roomid+'|'+My.chatid+'|'+My.nick+'|'+My.sex+'|'+My.age+'|'+My.qx+'|'+My.ip+'|'+My.vip+'|'+My.color+'|'+My.cam+'|'+My.state+'|'+My.mood;
	var str2='{"type":"Login","room_id":'+My.rid+',"chatid":'+My.chatid+',"nick":"'+My.nick+'","sex":'+My.sex+',"age":'+My.age+',"qx":'+My.qx+',"ip":"'+My.ip+'","vip":"'+My.vip+'","color":'+My.color+',"cam":"'+My.cam+'","state":'+My.state+',"mood":"'+My.mood+'"}';
	ws.send(str2);
	
	
}


function getXY(obj)
{ 
var a = new Array(); 
var t = obj.offsetTop; 
var l = obj.offsetLeft;
var w = obj.offsetWidth; 
var h = obj.offsetHeight;
while(obj=obj.offsetParent)
{ t+=obj.offsetTop; l+=obj.offsetLeft; } 
a[0] = t; a[1] = l; a[2] = w; a[3] = h; return a; 
}


function CloseColorPicker()
{
	getId('ColorTable').style.display='none'
}


function ck_Font(e,act)
{
	if(e!=null)
	{
	e.value=='true'?e.value='false':e.value='true';
	}
	switch(act)
	{
		case 'FontBold':
			if(e.value=='true')getId('Msg').style.fontWeight='bold';
			else getId('Msg').style.fontWeight='';
		break;
		case "FontItalic":
			if(e.value=='true')getId('Msg').style.fontStyle='italic';
			else getId('Msg').style.fontStyle='';
		break;
		case 'Fontunderline':
			if(e.value=='true')getId('Msg').style.textDecoration='underline';
			else getId('Msg').style.textDecoration='';
		break;
		case 'FontColor':
			getId('Msg').style.color=getId('ColorShow').style.backgroundColor;
		break;
		case 'ShowColorPicker':
			bt_ColorPicker();
		break;
	}
}
function ColorPicker()   
{		
  	  var baseColor=new Array(6);   
      baseColor[0]="00";     
      baseColor[1]="33";   
      baseColor[2]="66";   
      baseColor[3]="99";   
      baseColor[4]="CC";   
      baseColor[5]="FF";   
      var   myColor;   
      myColor="";   
      var   myHTML="";      
      myHTML=myHTML+"<div style='WIDTH:180px;HEIGHT:120px;' onclick='ck_Font(null,\"FontColor\");CloseColorPicker()'>";       
      for(i=0;i<6;i++)   
      {
              for(j=0;j<3;j++)   
                {     for(k=0;k<6;k++)   
                      {                     
                          myColor=baseColor[j]+baseColor[k]+baseColor[i];   
                          myHTML=myHTML+"<li data="+myColor+" onmousemove=\"document.getElementById('ColorShow').style.backgroundColor=this.style.backgroundColor\" style='background-color:#"+myColor+"'></li>";   
                      }   
                    }   
          
      }           
      for(i=0;i<6;i++)   
      { 
              for(j=3;j<6;j++)   
                {   for(k=0;k<6;k++)   
                      {                     
                          myColor=baseColor[j]+baseColor[k]+baseColor[i];//get   Color   
                          myHTML=myHTML+"<li data="+myColor+" onmousemove=\"document.getElementById('ColorShow').style.backgroundColor=this.style.backgroundColor\" style='background-color:#"+myColor+"'></li>";   
                      }   
                  }           
      }   
        
      myHTML=myHTML+"</div><div style='border:0px; width:180px; height:10px; background:#333333' id='ColorShow'></div>";      
      document.getElementById("ColorTable").innerHTML=myHTML;       
}
var ColorInit=false;
function bt_ColorPicker()
{
	var t=getXY(getId('FontColor'));
	getId('ColorTable').style.top=t[0]-145+'px';
	getId('ColorTable').style.left=t[1]+1+'px';
	if(!ColorInit)
	{
	ColorPicker();
	ColorInit=true;
	}
	getId('ColorTable').style.display='';
	getId('ColorTable').focus();
	return true;
	
}

function bt_Personal(e)
{
	if(e.value=='false')
	{
		e.value='true';
		e.src="images/Personal_true.gif";
		e.title='私聊中...[公聊/私聊]';
	}
	else
	{
		e.value='false';
		e.src="images/Personal_false.gif";
		e.title='公聊中...[公聊/私聊]';
	}
}
function bt_FontBar(e)
{
	if(!check_auth("msg_style")){layer.msg('没有权限！',{shift: 6});return false;}
	if(getId('FontBar').style.display=='none')
	{
		var t=getXY(getId('UI_Control'));
		getId('FontBar').style.display='';
		getId('FontBar').style.top=t[0]-29+'px';
		getId('FontBar').style.left=isIE?t[1]+1:t[1]+'px';
		getId('FontBar').style.width=t[2]-8+'px';
	}
	else
	{
		getId('FontBar').style.display='none';
	}
}
function bt_Send_key_option(e)
{
	var t=getXY(e);
	getId('Send_key_option').style.top=t[0]-50+'px';
	getId('Send_key_option').style.left=t[1]+2-165+'px';
	getId('Send_key_option').style.display='';
	getId('Send_key_option').focus();
}



function InsertImg(id,src){
	$(id).append('<img src=\"'+src+'\">');	
}
function bt_insertImg(id)
{
	$('#imgUptag').val(id);	
	$('#filedata').click();
}

function bt_MsgClear(){
	getId('MsgBox1').innerHTML = '';
}
function bt_SendEmote(obj){
	getId('Msg').innerHTML=obj.innerHTML;SysSend.msg();
	getId('Emote').style.display='none';
}
function bt_SwitchListTab(tag){
	$(".tab_nav a").removeClass('active');
	$(".tab_div").css('display','none');
	if(tag=="olUs"){
		$("#olUs").addClass("active");
		$("#tab_olUs").css("display","").addClass("in");
	}
	else if(tag=="myKh"){
		$("#myKh").addClass("active");
		$("#tab_myKh").css("display","").addClass("in");;
		UserList.getmylist(My.name);
	}
	else if(tag=="myKf"){



		$("#myKf").addClass("active");
		$("#tab_myKf").css("display","").addClass("in");
	}
	return false;
	
}
function bt_defvideosrc(){
	if(check_auth('def_videosrc')){
		SysSend.command('setVideoSrc',My.chatid+'_+_'+My.nick);
		$.ajax({type: 'get',url: 'ajax.php?act=setdefvideosrc&vid='+encodeURIComponent(My.chatid)+'&nick='+encodeURIComponent(My.nick)+'&rid='+My.rid});
	}
}
function bt_msgBlock(id){
		if(id!=""){
		SysSend.command('msgBlock',id);
		$.ajax({type: 'get',url: 'ajax.php?act=msgblock&s=1&msgid='+id});
		}
}
function bt_msgAudit(id,a){
		SysSend.command('msgAudit',id);
		$(a).hide();
		$.ajax({type: 'get',url: 'ajax.php?act=msgblock&s=0&msgid='+id});
}
function bt_FindUser(){
	var username=getId('finduser').value;
	getId("OnLineUser_FindList").style.display="none";
	getId("OnLineUser").style.display="";
	//alert(username);
	if(username==""){
		getId("OnLineUser_FindList").style.display="none";
		
		getId("OnLineUser").style.display="";
	}
	else{
		getId("OnLineUser_FindList").style.display="";		
		getId("OnLineUser_FindList").innerHTML="";
		getId("OnLineUser_FindList").style.height=getId("OnLineUser").offsetHeight +'px';
		getId("OnLineUser").style.display="none";
		
		var ulist=UserList.List();
		var li="";
		for(c in ulist){				
			if(ulist[c].nick.toLowerCase().indexOf(username.toLowerCase())>=0){
				//alert(ulist[c].nick);
				li=getId(ulist[c].chatid);
				var t_li=CreateElm(getId("OnLineUser_FindList"),'li',false,'fn'+ulist[c].chatid);
				t_li.innerHTML=li.innerHTML;
				t_li.oncontextmenu=li.oncontextmenu;
				t_li.onclick=li.onclick;
				t_li.ondblclick=li.ondblclick;
			}				
		}
	}
}

var audioNotify=true;
function bt_toggleAudio() {
   if(audioNotify == true) {
      audioNotify = false;
      getId('toggleaudio').src = 'images/Sc.gif';
   } else {
      audioNotify = true;
      getId('toggleaudio').src = 'images/So.gif';
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
	/*
	if($("#bt_gundong").attr("select")=="true"){
		$("#bt_gundong").attr("select","false");
		toggleScroll = false;
	}
	else {
		$("#bt_gundong").attr("select","true");
		toggleScroll = true;
	}
	*/
}
function bt_ToUserSet(chatid,nick){
	if(!check_auth("msg_ptp")){return;}ToUser.set(chatid,nick);
}
function bt_kick(chatid,nick){
	if(!check_auth("user_kick")){return;}
	var u={};
	u.nick=nick;
	u.chatid=chatid;
	UKick.ShowMb(u);
	return false;
}
function bt_ulistmore(num){
	UserList.showmore(num);
	$('#OnLineUser').animate({scrollTop:$('#OnLineUser')[0].scrollHeight}, 1000);
}
function callMyKf(u){
	POPChat.newtab(u);POPChat.showtab(u);
}
function openAd(img,url){
	if(url=="")
	openWin(1,false,'<img src="'+img+'" style="width:640px; height:245px;;border:0px;">',640,245);
	else
		window.open(url);
	//openWin(1,false,'<a href="'+url+'" target=_blank><img src="'+img+'" style="width:640px; height:245px;;border:0px;"></a>',640,245);
}

function toggleLeft(){
	if($('#UI_Left').is(":hidden")){
		$('#UI_Left').show().addClass("in");
		$('#UI_Central').css({'margin-left':'266px'});
		$(".js-main-meta-toggle").find("i").removeClass("fa-angle-double-right");
		
	}else{
		$('#UI_Central').css({'margin-left':'6px'});
		$('#UI_Left').hide();
		$(".js-main-meta-toggle").find("i").addClass("fa-angle-double-right");
	}
	/*
	if($('.NoticeList').is(":hidden")){
		$('.NoticeList').show().addClass("in");
		$('#OnLine_MV').height($('#OnLine_MV').height()-$('.NoticeList').outerHeight(true));
		
		
	}else{		
		$('#OnLine_MV').height($('#OnLine_MV').height()+$('.NoticeList').outerHeight(true));
		$('.NoticeList').hide();
		
	}
	*/
	
}
function join_favorite(e, t) {
    try {
        document.all ? window.external.addFavorite(e, t) : window.sidebar ? window.sidebar.addPanel(t, e, "") : layer.alert('请使用Ctrl+D快捷键进行添加操作!', {icon: 5, title:'加入收藏夹失败'});
    } catch (a) {
		layer.alert('请使用Ctrl+D快捷键进行添加操作!', {icon: 5, title:'加入收藏夹失败'});
    }
	return false;
}

function openImg(url){
	var img = new Image();img.src =url;
	img.onload=function(){openWin(1,false,'<img src="'+url+'" style="border:0px;">',img.width,img.height);}
}

function toggleSkin(){
	if($('.skin-list .li').length<=0){
		for(var i=1;i<=9;i++){
			$('.skin-list').append('<div class="li"><img src="/room/images/bgs/img-bg'+i+'.jpg"></div>');
		}
		$('.skin-list .li img').live('click',function(){
			$('body').attr('style','background-image:url('+this.src+')!important');
		});
	}
	openWin(1,'背景图片切换',$('#skin-div').html(),600,400);
}
function toggleRoom(){	
	openWin(1,'切换直播间',$('#rooms-div').html(),260,290);
}
function center(a, b) {
    b && 
    function(a) {
        var b = $(a)
          , 
        c = ($(window).width() - b.outerWidth()) / 2;
        b.css({
            left: c
        })
    }(a),
    function(a) {
        var e, f, b = $(a), 
        c = b.outerHeight(), 
        d = $(window).height();
        c > d ? (b.css("top", "0px"),
        e = 0) : (f = (d - c) / 2,
        b.css("top", f + "px"),
        e = f)
    }(a)
}
function ckSendMoney(){
	$("#money").html("￥0");$("#realmoneytip").html("");$("#realnumbertip").html("");
	var s=parseInt($("#realmoney").val());
	var b=parseInt($("#realnumber").val());
	$("#realmoney").val(s?s:0);
	$("#realnumber").val(b?b:0);
	if($("#realmoney").val()<5){$("#realmoneytip").html("金额最小5元");$("#realmoney").val(5);return false;}
	if($("#realnumber").val()<1){$("#realnumbertip").html("个数最小1，最大500");$("#realnumber").val(1);return false;}
	if($("#realnumber").val()>500){$("#realnumbertip").html("个数最小1，最大500");$("#realnumber").val(50);return false;}
	if($("#realmoney").val()>parseInt($("#MyMoney").val())){$("#realmoneytip").html("余额不足,最多￥"+$("#MyMoney").val());$("#realmoney").val($("#MyMoney").val());return false;}
	$("#money").html("￥"+$("#realmoney").val());

	return true;
}
function getMyMoney(){
	layer.load();
	$.getJSON("ajax.php?act=mymoney",function(re){
		layer.closeAll('loading');
		$("#mymoney1").html(re.money);
		$("#MyMoney").val(re.money);
		$("#realmoney").blur(function(){ckSendMoney()});
		$("#realnumber").blur(function(){ckSendMoney()});
		$("#btnenvelope").click(function(){
			if(!ckSendMoney()){return false;}
			else{
				$("#btnenvelope").hide();
				$("#btnenvelopeing").show();
				layer.load();
				$.getJSON("ajax.php?act=sendhongbao",{rid:My.rid,money:$("#realmoney").val(),number:$("#realnumber").val(),txt:$("#envelopetext").val(),togid:$("#togroup").val(),togtitle:$("#togroup").find("option:selected").text()},
					function(re){
						layer.closeAll('loading');
						if(re.code=="1"){
							SysSend.command('sendhongbao',"{uid:'"+My.chatid+"',hid:'"+re.hid+"',msg:'"+re.msg+"'}");
							var html='<div id="setEnvelopeOK" style="display:none"><p class="tipOK">红包发送成功!</p><div class="OK cursor" onclick="$(\'#setEnvelopeOK\').remove();">好的</div></div>';
							$("body").append(html),$("#setEnvelopeOK").show(),center("#setEnvelopeOK",true);
							PutMsg(My.rid,My.chatid,'ALL',My.nick,'hongbao','false','',re.msg,re.hid);
						}
						else if(re.code=="0"){
							layer.msg(re.msg,{shift: 6});
						}
						$("#setEnvelope").remove();
					});
			}
		});
	});
	$(".btnenvelope").click(function(){$("#btnenvelope").hide(),$("#btnenvelopeing").show()});
}
function sendHb(){
	var togroup="";
	for(var i in grouparr){
		togroup+='<option value="'+grouparr[i].id+'">'+grouparr[i].title+'</option>';
	}
	var html='<input id="MyMoney" type="hidden" value="0.00"><div id="setEnvelope" ><div class="redbagclose"></div><div class="envelopeBody"><div class=" pt10"><div class="registerNewconter" style="padding-right:60px;">金额：<input type="text" id="realmoney" name="realmoney" maxlength="4" value="" placeholder="请填写红包金额"> 元</div><p class="envelopetip" id="realmoneytip" style="margin-left:97px;"></p></div><div class=""><div class="registerNewconter" style="padding-right:60px;">个数：<input type="text" name="realnumber" id="realnumber" maxlength="4" value="" placeholder="请填写红包个数"> 个</div><p class="envelopetip" id="realnumbertip" style="margin-left:97px;"></p></div><div class="registerNewconter" style="padding-right:60px;">定向：<select id="togroup" name="togroup"><option value="0">所有</option>'+togroup+'</select>   组</div><div class=""><div class="registerNewconter" style="padding-right:79px;"><span>备注：</span><textarea name="envelopetext" id="envelopetext" maxlength="15" placeholder="恭喜发财,大吉大利！">恭喜发财,大吉大利！</textarea></div></div><div class="registerNewconter bagred" style="padding-right:0;"><p id="money" style="color: #fc4c4c;">￥0.00</p></div><div class="registerNewconter" style="padding-right:0;"><p style="font-size:14px;color:#a0a0a0;">余额￥<span id="mymoney1">0.00</span>元</p></div><div class="registerNewconter"><button class="btnEnvelope mt10" id="btnenvelope">发红包</button><button class="btnEnvelope mt10" id="btnenvelopeing">正在发..</button></div></div></div>';
	$("body").append(html),$("#setEnvelope").show(),center("#setEnvelope",true),getMyMoney(),
		$(".redbagclose").click(function(){$(this).parent().remove()});

}
$(function(){
	$(".hongbao").click(function(){
		
//		if(My.color=="0"){openWin(2,false,'/room/minilogin.php',370,340);return;} // modify by danddy 2018-09-11
		if(My.color=="2"){openWin(2,false,'/room/minilogin.php',370,340);return;}
		$("#hongBaoClick").remove();
		var html='<div id="hongBaoClick" style="display:none"><div class="bagbtn"><div class="sethongBao">发红包</div><div class="lookmainbag">我的红包</div></div><div class="redbagclose"></div></div>';
		$("body").append(html),$("#hongBaoClick").show(),center("#hongBaoClick",true),
			$(".redbagclose").click(function(){$(this).parent().remove()}),
			$(".lookmainbag").click(function(){$("#hongBaoClick").remove(),lookHbMoney();}),
			$(".sethongBao").click(function(){$("#hongBaoClick").remove(),sendHb();});
	});
	$(".qiandao").click(function(){
		//if(My.color=="0"){openWin(2,false,'/room/minilogin.php',370,340);return;}  // modify by danddy 2018-09-11
		if(My.color=="2"){openWin(2,false,'/room/minilogin.php',370,340);return;}
		qiandao=layer.open({
			type: 2,
			title: false,
			shadeClose: true,
			shift : 5,
			shade: 0.8,
			area: ['677px', '677px'],
			content: '/apps/qiandao.php?rid='+My.rid
		});
		layer.style(qiandao, {
			'box-shadow':'none',
			'background-color': 'transparent',
			'border': '0'
		});
	});
	$('.view-more-records').click(function(){ChatHistory('pc')});
});
var gHid="";
var vcode="";
function getHongBao(hid){
	//if(My.color=="0"){openWin(2,false,'/room/minilogin.php',370,340);return;} //modify by danddy 2018-09-11
	if(My.color=="2"){openWin(2,false,'/room/minilogin.php',370,340);return;}
	if(gHid!=hid){
		$('#hadredbag').remove();
		$('.hadredbag').remove();
		var html1='<div id="hadredbag" class="hadredbag" style="display:none"><div class="redbagclose" onclick="$(\'#hadredbag\').remove();"></div><p style="margin-top: 95px;color:#FFFF00">恭喜发财，大吉大利！</p><p class="memos mt10"><div style="    line-height: 30px;			font-size: 14px;			color: #B22222;">请输入验证码抢红包</div><div><img src="/include/image_firefox.inc.php?'+new Date().getTime()+'" onclick="this.src=this.src" style="vertical-align: middle;cursor: pointer;" title="点击刷新"><input type="text" style="border: 1px solid rgba(0,0,0,.2);width: 25px;background: none;vertical-align: middle;text-align: center;font-size: 16px;" id="vcode" value="">	</div><div class="img" style="line-height: 60px;			color: red;background: #ff0;margin-top: 65px;cursor: pointer;" id="nowgethb">马上抢</div></p><div class="minebag cursor lookthisbag" onclick="$(\'#hadredbag\').remove();$(\'#successredbag\').show();center(\'#successredbag\',true);"></div></div>';
		$("body").append(html1);
		$("#hadredbag").show(),center("#hadredbag",true);
		$("#nowgethb").click(function(){
			if($("#vcode").val()==""){
				alert('请输入验证码');
				return false;
			}
			vcode=$("#vcode").val();
			$('#hadredbag').remove();
			$('.hadredbag').remove();
			gHid=hid;
			getHongBao(hid);
		});
		return false;
	}

	layer.load();
	var isSendHBInfo=false;
	$.getJSON("ajax.php?act=gethongbao&hid="+hid+"&vcode="+vcode,function(re){
		layer.closeAll('loading');
		if(re.code==0){openWin(2,false,'/room/minilogin.php',370,340);return;}
		else {
			if(re.code==5){
				gHid="";layer.msg('计算结果验证码错误！', {icon: 5});return false;
			}
			if(re.code==6){
				gHid="";layer.alert(re.msg, {icon: 5});return false;
			}
			var html1='<div id="hadredbag" style="display:none"><div class="redbagclose" onclick="$(\'#hadredbag\').remove();"></div><div class="img"><img src="/face/img.php?t=p1&u='+re.hinfo.uid+'" width="60" height="60"></div><p style="margin-top: 15px;">'+re.hinfo.nick+'</p><p class="memos mt10">您已经抢过这个红包了!</p><div class="minebag cursor lookthisbag" onclick="$(\'#hadredbag\').remove();$(\'#successredbag\').show();center(\'#successredbag\',true);">看看大家的手气&gt;&gt;</div></div>';
			$("body").append(html1);
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
			$("body").append(html0);
			if(re.code==1&&!isSendHBInfo){
				isSendHBInfo=true;
				$("#myget_money").html('<span style="color:#333;font-size: 14px;">获</span>'+myget_money);
				$("#successredbag").show(),center("#successredbag",true);
				SysSend.command('gethongbao',"{uid:'"+My.chatid+"',nick:'"+re.hinfo.nick+"',money:'"+myget_money+"'}");
				PutMsg(My.rid,My.chatid,'ALL',My.nick,'gethongbao','false',re.hinfo.nick,'领取红包'+myget_money+'元',myget_money);
			}
			else if(re.code==2){
				$("#hadredbag").show(),center("#hadredbag",true);
			}
			else if(re.code==3){
				$("#hadredbag").show(),center("#hadredbag",true),$("#hadredbag .memos").text('手慢了，红包派完了！');
			}
			else if(re.code==4){
				$("#hadredbag").show(),center("#hadredbag",true),$("#hadredbag .memos").text('来晚了！24小时过期回收！');
			}

			$("#lookmymoney").click(function(){
				$("#successredbag").remove();
				$("#lookredbag").remove();

				lookHbMoney();
			});
		}

	});

}
function lookHbMoney(){
	layer.load();
	$.getJSON("ajax.php?act=lookhbmoney",function(re){
		layer.closeAll('loading');
		var html='<div id="lookredbag"><div class="redbagclose"  onclick="$(\'#lookredbag\').remove();"></div><div class="img"><img src="/face/img.php?t=p1&u='+My.chatid+'" width="65" height="65"></div><div class="money bagred"><span style="color:#333;font-size:14px;">余额</span><span id="mymoeny_ye">0.00</span><span style="color:#333;font-size:14px;">元</span></div><p style="margin-top:2px;font-size: 14px;color:#000">'+My.nick+'<br>共收到<span style="color:red;">'+re.gnum+'</span>个红包,最新20条记录</p>';
		html+='<div class="HBlist">';
		var item
		for(x in re.glist){
			var i=re.glist[x];
			item+='<div class="list-info"><div class="user-img"><img src="/face/img.php?t=p1&u='+i.uid+'" width="35" height="35"></div><div class="list-right"><div class="list-right-top"><div class="user-name fl f14">'+i.nick+'</div><div class="user-money fr f14">'+i.money+'元</div></div><div class="user-time">'+i.time+'</div> </div></div>';
		}
		html+=item+'</div></div>';
		$("body").append(html),center("#lookredbag",true);
		$.getJSON("ajax.php?act=mymoney",function(re){$("#mymoeny_ye").html(re.money);});
	});
}
var cc=0;
var msgindex=0;
var mm='';
var sp='';
var msgjiange='';
var msgmaxnum=0;
var msgautotime;
function click_automsg(){
	
     if(!check_auth("rebots_msg")){
        return;
    }
    if(typeof($('#automsg').val())!='undefined'){
		cc=0;msgindex=0;
        mm =$('#automsg').val();
		var n=parseInt($('#msgjiange').val())*1000/2;
		var m=(parseInt($('#msgjiange').val())+1)*1000;
		sp=parseInt(Math.random()*(m-n)+n);
		msgmaxnum=$('#msgmaxnum').val();
		clearTimeout(msgautotime);
		$.cookie('automsg', mm, { expires: 9999999, path: '/' });  
    }
   
	var msgstrs= new Array();  
    msgstrs=mm.split("\n"); 
    
    if(cc>=msgmaxnum){
        cc=0;
		
        return;
    }
	//var msgindex=parseInt(Math.random()*msgstrs.length);
	
	if(msgstrs[msgindex].length>0){
		SysSend.command('automsg',encodeURIComponent(msgstrs[msgindex]));
	}
	if(msgindex>=(msgstrs.length-1)){msgindex=0;}else {msgindex++};
	
    cc=cc+1;
    msgautotime=setTimeout("click_automsg()",sp);
  }
function  bt_automsg(){
	clearTimeout(msgautotime);
    if($.cookie("automsg")!=null){var info=unescape($.cookie("automsg"));}else {info='';}
  	var loadstr='<div style=" text-align:center;width:700px;height:400px;" onselectstart="return true;"><div>'
  				+'<textarea id="automsg" class="textarea" name="automsg"  style="width:660px;height:300px;margin:10px;">'+info+'</textarea>'
    			+'</div>'
				+'<div style="margin-top: -4px;"><font color="red" size="3">累计发送(条)：</font><input type="text" id="msgmaxnum" value="10000" name="msgmaxnum" maxlength="16" style="height: 26px;vertical-align: inherit;"> <font color="red" size="3">发言间隔(秒)：</font><input type="text"  value="30" id="msgjiange" name="msgjiange" maxlength="16" style="height: 26px;vertical-align: inherit;">'
       	 		+'<a href="javascript:void(0)" style="background-color: #f77a22;border-radius: 5px;padding: 6px 10px;font-size:15px;margin-left:10px;" onclick="click_automsg();layer.closeAll();">发     射</a></div></div>';
	layer.open({
		type: 1,
		title: '我的机器人自动发言&nbsp;&nbsp;(一行一条发言)',
		shadeClose: true,
		shade: false,
		area: ['700px', '400px'],
		content: loadstr //iframe的url
	});
    
}
/*网成科技财经直播系统v3.1 QQ3350933991*/