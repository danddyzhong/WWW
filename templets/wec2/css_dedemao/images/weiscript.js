$(document).ready(function(){
	slideMenu.build('new-hotArticles',160,10,10,1);
	$("#weixin").click(function(){toggleWeixinCode()});
});

function toggleWeixinCode(){
	$("#weixin2DC").animate({
   height: 'toggle', opacity: 'toggle'
 }, "fast");
}

var cc = 0;
var slideMenu=function(){
	var sp,st,t,m,sa,l,w,sw,ot;
	return{
		build:function(sm,sw,mt,s,sl,h){
			sp=s; st=sw; t=mt;
			m=document.getElementById(sm);
			if(m != null){
			    sa=m.getElementsByTagName('div');
			    ha = m.getElementsByTagName('h2');
			    toggle = document.getElementById("new-toggleButton");
			    l=sa.length; w=m.offsetWidth-43; sw=w/l;
			    ot=Math.floor((w-st)/(l-1)); var i=0;
			    for(i;i<l;i++){s=sa[i]; h=ha[i]; s.style.width=sw+'px'; this.timer(s,h,i)}
			    if(sl!=null){m.timer=setInterval(function(){slideMenu.slide(sa[sl-1])},t)}
			
			    toggle.onclick = function(){
				    if(cc==0){
					    clearInterval(m.timer);
					    m.timer=setInterval(function(){slideMenu.slide(sa[1])},t);
					    cc=1;
					    toggle.className = "new-close";
					    sa[1].className = "current";
					    sa[0].className = "";
				    }
				    else{
					    clearInterval(m.timer);
					    m.timer=setInterval(function(){slideMenu.slide(sa[0])},t)
					    cc=0;
					    toggle.className = "new-open";
					    sa[0].className = "current";
					    sa[1].className = "";
				    }
			    }
			}
		},
		timer:function(s,h,ic){
			h.onclick=function(){
				clearInterval(m.timer);
				m.timer=setInterval(function(){slideMenu.slide(s)},t)
				if(ic == 0){
					cc=0;
					toggle.className = "new-open";
					sa[0].className = "current";
					sa[1].className = "";
				}
				else{
					cc=1;
					toggle.className = "new-close";
					sa[1].className = "current";
					sa[0].className = "";
				}
			}
		},
		slide:function(s){
			var cw=parseInt(s.style.width,'10');
			if(cw<st){
				var owt=0; var i=0;
				for(i;i<l;i++){
					if(sa[i]!=s){
						var o,ow; var oi=0; o=sa[i]; ow=parseInt(o.style.width,'10');
						if(ow>ot){oi=Math.floor((ow-ot)/sp); oi=(oi>0)?oi:1; o.style.width=(ow-oi)+'px'}
						owt=owt+(ow-oi)}}
				s.style.width=(w-owt)+'px';
			}else{clearInterval(m.timer)}
		}
	};
}();



