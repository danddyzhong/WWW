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
function $(id){
	return document.getElementById(id);	
}
function preg_match(re, str) {
	var matches = re.exec(str);
	return matches != null;
}
function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}
function ftime(t1,t2)
{
	t2=t2-2;
	var second = 1000; 
	var minutes = second*60; 
	var hours = minutes*60; 
	var days = hours*24; 
	var months = days*30; 
	var twomonths = days*365; 
	var myDate = new Date(t2*1000); 
	var nowtime = new Date(t1*1000); 
	var longtime =nowtime.getTime()- myDate.getTime(); 
	if( longtime > months*2 )  return myDate.toLocaleDateString();
	else if (longtime > months) return ("1个月前"); 
	else if (longtime > days*7) return ("1周前"); 
	else if (longtime > days) return(Math.floor(longtime/days)+"天前"); 
	else if ( longtime > hours)return(Math.floor(longtime/hours)+"小时前"); 
	else if (longtime > minutes) return(Math.floor(longtime/minutes)+"分钟前"); 
	else if (longtime > second) return(Math.floor(longtime/second)+"秒前"); 
	else return myDate.toLocaleString(); 
}
function mb_strlen(str) {
	charset='utf-8';
	var len = 0;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
	}
	return len;
}
function CreateElm(pObj,obj,className,id){
	var elm = null;
	var elm=document.createElement(obj);
	if(!pObj)document.body.appendChild(elm);
	else pObj.appendChild(elm);
	if(id)elm.id = id;
	if(className)elm.className = className;
	return elm
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
facediv=null;
function msgubbface(){
	
	if(facediv==null){
	var t=getXY($('face'));
	facediv=CreateElm(null,'div',null,'face_div');
	facediv.style.float='left';
	facediv.style.width='362px';
	facediv.style.border='1px #CCC solid';
	facediv.style.position='absolute';
	facediv.style.top=t[0]+'px';
	facediv.style.left=t[1]+'px';
	facediv.style.background='#FFF';
	facediv.onclick=function(){$('face_div').style.display='none';}
	facediv.innerHTML="Loading...";
	var p='';
	for(var i=0;i<105;i++){
		p+='<div style="float:left"><img src="room/face/pic/'+i+'.gif" onclick="$(\'txt\').value+=\':em'+i+':\';"/></div>';
		}
	facediv.innerHTML=p;
	}
	else $('face_div').style.display='';
}
editfacediv=null
function editface(tag){
	var t=getXY($('eface'));
	$('editface').style.display='';
	$('editface').style.top=t[0]+'px';
	$('editface').style.left=t[1]+300+'px';
	$('editface_src').src='editface.php?type='+tag;
}
function writeUbb(str){
	re=/:em(\d{1,3}):/gi;  
	str=str.replace(re,"<img   src='room/face/pic/$1.gif'   border='0'>");
	document.write(str);
}
function delimpression(fuid,ftime){
	var xmlhttp=XHConn();
	var request_url='ajax.php?act=delimpression&fuid='+fuid+'&ftime='+ftime+'&'+Math.random() * 10000;
	try{
		xmlhttp.open('GET',request_url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				var re = eval("("+xmlhttp.responseText+")");
				if(re.state=="logout")
				{alert('你还没有登陆！');location.href='index.php'}
				else
				location.reload();
			}
			return true;
		}
	}
	catch(e) {return true;}	
}
function impression(uid,txt)
{
	if(txt==''){alert('印象内容不能为空！');return;}
	var xmlhttp=XHConn();
	var request_url='ajax.php?act=impression&uid='+uid+'&t='+encodeURIComponent(txt)+'&'+Math.random() * 10000;
	try{
		xmlhttp.open('GET',request_url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				var re = eval("("+xmlhttp.responseText+")");
				if(re.state=="logout")
				{alert('你还没有登陆！');location.href='index.php'}
				else
				location.reload();
			}
			return true;
		}
	}
	catch(e) {return true;}
}
function memberfriends(uid,c)
{
	var xmlhttp=XHConn();
	var request_url='ajax.php?act=memberfriends&'+c+'='+uid+'&'+Math.random() * 10000;
	try{
		xmlhttp.open('GET',request_url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				var re = eval("("+xmlhttp.responseText+")");
				if(re.state=="logout")
				{alert('你还没有登陆！');location.href='index.php'}
				else
				location.reload();
			}
			return true;
		}
	}
	catch(e) {return true;}
}
function message(id,c)
{
	
	if($('tag').checked)$('tag').value=1;else $('tag').value=0;
	if($('txt').value.length>200)return alert('留言过长！最多输入200个字。');
	$('sb').disabled=true;
	var xmlhttp=XHConn();
	var request_url='ajax.php?act=message&'+c+'='+id+'&'+Math.random() * 10000;
	try{
		xmlhttp.open('POST',request_url,true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");   
		xmlhttp.send('uid='+id+'&tag='+encodeURIComponent($('tag').value)+'&txt='+encodeURIComponent($('txt').value));
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				var re = eval("("+xmlhttp.responseText+")");
				if(re.state=="logout")
				{alert('你还没有登陆！');location.href='index.php'}
				else
				location.reload();
			}
			return true;
		}
	}
	catch(e) {return true;}
}
function UserState()
{
	var xmlhttp=XHConn();
		var request_url='ajax.php?act=userstate&'+Math.random() * 10000;
		try{
			xmlhttp.open('GET',request_url,true);
			xmlhttp.send(null);
			xmlhttp.onreadystatechange=function()
			{
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
				{
					var re = eval("("+xmlhttp.responseText+")");
					if(re.state=="login")
					{
						//alert(xmlhttp.responseText);
						$('UserState').innerHTML='<a href="profile.php?uid='+re.info.id+'">'+re.info.nick+"[UID:"+re.info.id+"]</a> | <a href=\"gift.php\">"+re.info.gold+"</a> | <a href=\"pay.php\">充值</a> | <a href='useredit.php?#profile' target='useredit'>设置</a>|<a href='logging.php?act=logout'>退出</a>";
					}
					else
					{
						$('UserState').innerHTML="<登录 | 注册";
					}
				}
				return true;
			}
		}
		catch (e)
		{
			return true;
		}
}
function online(rst)
{
	var xmlhttp=XHConn();
	var request_url='ajax.php?act=online&'+Math.random() * 10000;
	try{
		xmlhttp.open('GET',request_url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				//var re = eval("("+xmlhttp.responseText+")");
				//if(re.state=="logout")
				//{alert('你还没有登陆！');location.href='index.php'}
			}
			return true;
		}
	}
	catch(e) {return true;}
}
function openWithIframe(tit,url,w,h,str,o){
$('massage_box').style.left = (document.documentElement.clientWidth - w) / 2+'px';
$('massage_box').style.top = (document.documentElement.clientHeight )/2 - h/2+'px';
$('massage_box').style.width = w+"px";
$('massage_box').style.height = h+"px";
$('pop_title').innerHTML=tit;
if(!o)
$('mask').style.display='';
$('massage_box').style.display=''
var popiframe='<iframe src="'+url+'" width="'+(w-7)+'px"  height="'+(h-37)+'px" frameborder=0 scrolling=no></iframe>';
if(url!=null)
$('pop_iframe').innerHTML=popiframe;
else 
$('pop_iframe').innerHTML=str;
}
function closeWithIframe(){
$('massage_box').style.display="none";
$('mask').style.display="none";
}
function dragWinx(o){
	//o.firstChild.onmousedown=function(){return false;};
	o.onmousedown=function(a){
		var d=document;if(!a)a=window.event;
		if((a.srcElement ? a.srcElement : a.target).className!='title'){return false;}
		var x=a.layerX?a.layerX:a.offsetX,y=a.layerY?a.layerY:a.offsetY;
		if(o.setCapture)
			o.setCapture();
		else if(window.captureEvents)
			window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);

		d.onmousemove=function(a){
			if(!a)a=window.event;
			if(!a.pageX)a.pageX=a.clientX;
			if(!a.pageY)a.pageY=a.clientY;
			var tx=a.pageX-x,ty=a.pageY-y;
			//o.style.left=tx+'px';
			//o.style.top=ty+'px';
			var cH=document.documentElement.clientHeight;
			var cW=document.documentElement.clientWidth;
			var oH=o.offsetHeight;
			var oW=o.offsetWidth;
			var r=[0,cW-oW,0,cH-oH];
			o.style.left=(tx<r[0]?r[0]:tx>r[1]?r[1]:tx)+'px';
			o.style.top=(ty<r[2]?r[2]:ty>r[3]?r[3]:ty)+'px';
		};

		d.onmouseup=function(){
			if(o.releaseCapture)
				o.releaseCapture();
			else if(window.captureEvents)
				window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
			d.onmousemove=null;
			d.onmouseup=null;
		};
	};
}
document.write('<div id="massage_box" style="position:absolute; FILTER: progid:DXImageTransform.Microsoft.DropShadow();z-index:100000;display:none;" >');
document.write('<div style="border-width:1 1 3 1 ; width:100%; height:100%; background:#fff; color:#004080; font-size:12px; line-height:150%">');
document.write('<span onClick="closeWithIframe()" style="float:right; cursor:pointer;padding:5px;" class="titlesss"><img src="room/images/close.gif"></span>');
document.write('<div style="cursor:move;padding:3px;" class="titles" id="pop_title">');

document.write('</div>');
document.write('<div style="padding:3px" id=pop_iframe></div>');
document.write('</div>');
document.write('</div>');
document.write('<div id="mask" style="position:absolute; top:0; left:0; width:100%; background:#666666; filter:ALPHA(opacity=30); opacity:0.9;z-index:1;height:100%;display:none;"></div>');

function sendgift(s,g){
	//var loadstr='<font color="red">服务器连接失败</font><br>';
	openWithIframe('赠送礼物','sendgift.php?gid='+g+'&sid='+s,300,200,null,false);	
	dragWinx($("massage_box"));
}

setInterval("online(null)",60000);