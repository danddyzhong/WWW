console.log('jjjjjjjjj');
$(function(){
	var arrLink = document.links;
var thunderLen = arrLink.length;
var thunderSufix = ".asf;.avi;.iso;.mp3;.mpeg;.mpg;.mpga;.ra;.rar;.rm;.rmvb;.tar;.wma;.wmp;.wmv;.zip;.swf;.rmvb;.mp4;.3gp;.pdf;.mov;.wav;.scm;.mkv;.exe;.7z;.sub;.idx;.srt;.bin;.aac;"
var arrSufix = thunderSufix.split(";");
var isIE = (navigator.userAgent.indexOf('MSIE')>0);
if(typeof thunderHrefAttr == 'undefined') thunderHrefAttr = 'thunderHref';
for(var i=0;i<thunderLen;i++)
{	
	var temp =arrLink[i].href;
	var post = temp.lastIndexOf(".");
	var p = temp.substring(post,temp.length).toLowerCase();
	var k = arrSufix.length;
	var flag =false;
	var thunder_url = arrLink[i].href;
	var protocol=arrLink[i].protocol;
	//dz����
	var pathname=arrLink[i].pathname;
	var path=pathname.substring(pathname.lastIndexOf("/"),pathname.length);
	var thunderPath='';
	if(thunderPath == null)
	{
	   thunderPath="";
	}
	if(path == thunderPath && thunderPath != "")
	{
		flag=true;
	}
	//
	for(var k=0;k<arrSufix.length;k++)
	{
		if(p==arrSufix[k])
		{
			flag=true;
			break;
		}
	}
	if(protocol!="http:"&protocol!="ftp:"&protocol!="mms:"&protocol!="rtsp:")
	{
		flag=false;
	}	
	if(flag)
        {
            if(isIE)
            {
                try{
                    var s = document.createElement("anchor");
                    s.innerHTML+="<a target='_self' href='#' "+thunderHrefAttr+"='"+ThunderEncode(thunder_url)+"' thunderPid='"+thunderPid+"' thunderType='' thunderResTitle='"+arrLink[i].innerHTML+"' onClick='return OnDownloadClick_Simple(this,2)' oncontextmenu='ThunderNetwork_SetHref(this)'>"+arrLink[i].innerHTML+"</a>";
                    arrLink[i].replaceNode(s);
                }
                catch(e){
                    arrLink[i].setAttribute('target', '_self');
                    arrLink[i].setAttribute('href', '#');
                    //arrLink[i].setAttribute('thunderPid', thunderPid);
                    arrLink[i].setAttribute('thunderType', '');
                    arrLink[i].setAttribute('thunderResTitle', arrLink[i].innerHTML);
                    arrLink[i].setAttribute('onclick', 'return OnDownloadClick_Simple(this,2);');
                    arrLink[i].setAttribute('oncontextmenu', 'ThunderNetwork_SetHref(this)');
                    arrLink[i].setAttribute(thunderHrefAttr, ThunderEncode(thunder_url));
                }
            }
            else
            {
                arrLink[i].setAttribute('target', '_self');
                arrLink[i].setAttribute('href', '#');
                //arrLink[i].setAttribute('thunderPid', thunderPid);
                arrLink[i].setAttribute('thunderType', '');
                arrLink[i].setAttribute('thunderResTitle', arrLink[i].innerHTML);
                arrLink[i].setAttribute('onclick', 'return OnDownloadClick_Simple(this,2);');
                arrLink[i].setAttribute('oncontextmenu', 'ThunderNetwork_SetHref(this)');
                arrLink[i].setAttribute(thunderHrefAttr, ThunderEncode(thunder_url));
            }
        }
}
})
