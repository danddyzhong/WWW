var LSS_SITE = 'http://cdn.aodianyun.com';
//var LSS_SITE = 'http://192.168.1.27/demo';
var lssHandle,lssFunName,lssFunInterval,lssConf;
function aodianPlayer(conf){
	var conf = conf;
	if (!conf.container || conf.container == "" || !conf.player.name || conf.player.name == "") {
        console.log("缺少必要的参数：container、player.name");
        return;
    }
	var players = new Array('lssplayer','jwplayer','ckplayer');
	var playersCheck = false;
	for(var i in players){
    	if(players[i] == conf.player.name){
            playersCheck = true;
			break;
        }
    }
	if(!playersCheck){
		console.log("播放器类型错误");
		return;
	}
	
	//判断手机还是pc
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android","iPhone","SymbianOS","Windows Phone","iPad","iPod"];
    var isPc = true;
    for(var v = 0; v < Agents.length; v++){
        if(userAgentInfo.indexOf(Agents[v]) > 0){
            isPc = false;
            break;
        }
    }
	conf.isPc = isPc;
	
	var playerScript = LSS_SITE + '/lss/' + conf.player.name + '/player.js';
	
	if(conf.player.name == 'lssplayer'){
		if(conf.rtmpUrl && conf.rtmpUrl != ''){
			//var mode = /^rtmp\:\/\/(\d{1,8})\.lssplay\.aodianyun\.com\/([a-z\_\-A-Z\-0-9]*)(\?k\=([a-z0-9]*)\&t\=\d{10,11})?\/([a-z\_\-A-Z\-0-9]*)(\?k\=([a-z0-9]*)\&t\=\d{10,11})?$/;
			var mode = /^rtmp\:\/\/(.*)\/([a-z\_\-A-Z\-0-9]*)(\?k\=([a-z0-9]*)\&t\=\d{10,11})?\/([a-z\_\-A-Z\-0-9]*)(\?k\=([a-z0-9]*)\&t\=\d{10,11})?$/;
			if(!mode.test(conf.rtmpUrl)){
				console.log("rtmp地址格式错误");
				return;
			}
			var arr = conf.rtmpUrl.match(mode);
			
			//conf.uin = arr[1];
			conf.cname = arr[1];
			conf.app = arr[2];
			conf.key = '';
			conf.ck = arr[3] ? arr[3] : '';
			conf.pk = arr[6] ? arr[6] : '';
			conf.stream = arr[5] + conf.pk;;
			//conf.addr = 'rtmp://'+ conf.uin +'.lssplay.aodianyun.com/' + conf.app + conf.ck;
			conf.addr = 'rtmp://'+ conf.cname +'/' + conf.app + conf.ck;
			
			if(conf.hlsUrl && conf.hlsUrl != ''){
				var mode = /^http\:\/\/(.*)(\:8080)?\/([a-z\_\-A-Z\-0-9]*)\/([a-z\_\-A-Z\-0-9]*)\.m3u8$/;
				if(!mode.test(conf.hlsUrl)){
					console.log("hls地址格式错误");
					return;
				}
				if(conf.isPc == false){
					playerScript = LSS_SITE + '/lss/videojs/video.js';
				}
			}
		}
		else{
			if(!conf.url || conf.url == ""){
				console.log("缺少必要的参数：url");
        		return;
			}
			var mode = /^rtmp\:\/\/(.*)\/([a-z\_\-A-Z\-0-9]*)(\?k\=([a-z0-9]*)\&t\=\d{10,11})?\/([a-z\_\-A-Z\-0-9]*)(\?k\=([a-z0-9]*)\&t\=\d{10,11})?$/;
			if(!mode.test(conf.url)){
				console.log("发布地址格式错误");
				return;
			}
			var arr = conf.url.match(mode);
			
			//conf.uin = arr[1];
			conf.cname = arr[1];
			conf.app = arr[2];
			conf.key = '';
			conf.ck = arr[3] ? arr[3] : '';
			conf.pk = arr[6] ? arr[6] : '';
			conf.stream = arr[5] + conf.pk;;
			//conf.addr = 'rtmp://'+ conf.uin +'.lssplay.aodianyun.com/' + conf.app + conf.ck;
			conf.addr = 'rtmp://'+ conf.cname +'/' + conf.app + conf.ck;
		}
	}
	
	lssConf = conf;
	
	var layoutScript = document.createElement('script');
	layoutScript.type = 'text/javascript';
	layoutScript.src = playerScript;
	document.getElementsByTagName("body")[0].appendChild(layoutScript);
	lssFunName = conf.player.name + 'Run';
	lssFunInterval = setInterval("lssFunLoad()",100);

}
function lssFunLoad(){
	if(lssFunName && lssFunName in window){
		clearInterval(lssFunInterval);
		lssHandle = eval("new "+lssFunName+"(lssConf);");
	}
}