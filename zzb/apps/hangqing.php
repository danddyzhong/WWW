<!doctype html>
<html>
<head>
<meta charset="gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
<meta name="format-detection"content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<title>行情表格</title>
<meta name="keywords" content="行情表格">
<meta name="description" content="行情表格">
<script src="js/jquery-1.5.1.min.js"></script>

<script src="js/socket.io.js"></script>

<style>
@charset "gb2312";
/* 全局样式 */
*{
	/* [disabled]margin:0px; */
	padding: 0px;
	margin:0px;
}
i,b,span{font-weight:normal; font-style:normal;}
body{font-size:100%; font-family:Microsoft yahei,Helvetica,STHeiti,Droid Sans Fallback;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-webkit-tap-highlight-color:rgba(0,0,0,0)}
body,.global{background:#FFF;}
li{list-style-type:none;}
img{border:none;}
a{text-decoration:none;}
a:hover{text-decoration:none;}
.clear{clear:both;}
*:focus { outline: none; }

.container{width:190px;  margin:0 auto;}
.tab_box1{width:100%; font-size:12px;}
.data_tab{width:100%;}
.data_tab .red td{color:#FE0000;}
.data_tab td span{ color:#333; width:85%; margin:0 auto; padding:0.2em 3px; display:block; border-radius:3px;}
.data_tab td span i{color:#fff;}
.data_tab td span.red{background-color:#FF3B2F;}
.data_tab .green td{color:#00B259;}
.data_tab td span.green{background-color:#00B259; }
.data_tab td span.gray{background-color:#BFBFBF;}
.data_tab td{text-align:center; padding:3px 5px; border-bottom:1px solid #ccc; font-size:1em; background-color:#ECECEC; white-space:nowrap;}
.data_tab td.td1{width:41%; text-align:left; padding-left:3px; overflow:hidden;}
.data_tab td.td2{width:28%; text-align:right; padding-right:0px; padding-left:0px;font-size:1em; overflow:hidden;}
.data_tab td.td3{width:31%; text-align:right; margin-left:0px; padding-left:0px;overflow:hidden;}

.data_tab td.tl{text-align:left;}
.data2{display:none;}
.blue_word{color:#004391;}

.data_tab td.td3 span{float:right; text-align:center; font-size:1em;}
.more{background-color:#ECECEC;width:190px;height:29px;padding-top:1px;}
.more a{display:block;width:102px;height:27px;margin-left:43px;color:#f11;font-size:12px;text-align:center;background-color:#fa1;padding:5px;background:url(./img/btn.gif) no-repeat;}

</style>
<script>
var timer = {};

var Arr = ["http://121.40.214.64:8080", "http://121.40.214.64:8081", "http://121.40.214.64:8082", "http://121.40.214.64:8083", "http://121.40.214.64:8084", "http://121.40.214.64:8085", "http://120.26.82.121:8080", "http://120.26.82.121:8081", "http://120.26.82.121:8082", "http://120.26.82.121:8083", "http://120.26.82.121:8084", "http://120.26.82.121:8085", "http://121.40.216.113:8080", "http://121.40.216.113:8081", "http://121.40.216.113:8082", "http://121.40.216.113:8083", "http://121.40.216.113:8084", "http://121.40.216.113:8085", "http://120.26.82.135:8080", "http://120.26.82.135:8081", "http://120.26.82.135:8082", "http://120.26.82.135:8083", "http://120.26.82.135:8084", "http://120.26.82.135:8085", "http://120.26.82.202:8080", "http://120.26.82.202:8081", "http://120.26.82.202:8082", "http://120.26.82.202:8083", "http://120.26.82.202:8084", "http://120.26.82.202:8085", "http://121.40.216.110:8080", "http://121.40.216.110:8081", "http://121.40.216.110:8082", "http://121.40.216.110:8083", "http://121.40.216.110:8084", "http://121.40.216.110:8085", "http://120.26.82.182:8080", "http://120.26.82.182:8081", "http://120.26.82.182:8082", "http://120.26.82.182:8083", "http://120.26.82.182:8084", "http://120.26.82.182:8085", "http://121.40.216.116:8080", "http://121.40.216.116:8081", "http://121.40.216.116:8082", "http://121.40.216.116:8083", "http://121.40.216.116:8084", "http://121.40.216.116:8085"];
var n = Math.floor(Math.random() * Arr.length + 1) - 1
var server = Arr[n];
var socket = io.connect(server);
var pvalue;
var hcolor;
socket.on('price list',function(msg) {
    oldvalue = msg.v.lp;
    var pcolor;
    var ycolor;
    if (Number(oldvalue) > Number(pvalue)) {//下跌
        ycolor = "#55c45f";
		$('#' + msg.name + "_P").css("background-color", "#55c45f");
    } else if (Number(oldvalue) < Number(pvalue)) {//上涨
        ycolor = "#ff6b6b";
		$('#' + msg.name + "_P").css("background-color", "#ff6b6b");
    } else if (Number(oldvalue) == Number(pvalue)) {//盘整
        ycolor = "#4eb7cd";
		$('#' + msg.name + "_P").css("background-color", "#4eb7cd");
    }
    if (msg.v.ch != null) {
        var per = msg.v.chp;
        
        $('#' + msg.name + "_P").text(per.toFixed(2) + "%");
    }
    var id = timer[msg.name];
    if (id != null && id != 0) {
        clearTimeout(id);
    };
    $('#' + msg.name + "_B").text(msg.v.lp);
    var mm = setTimeout(function() {
        timer[msg.name] = 0;
    },
    600);
    timer[msg.name] = mm;
    hcolor = ycolor;
    pvalue = msg.v.lp;
});


</script>
<style>

</style>
</head>
<body>
<div class="container">
    <div class="tab_box1">
        <table class="data_tab" style="display:table" cellpadding="0" cellspacing="0"><tbody><tr class= "XAU"><td class="td1">现货黄金</td><td class="td2">----</td><td class="td3"><span><i class="data1">----</i><i class="data2">----</i></span></td></tr><tr class= "XAG"><td class="td1">现货白银</td><td class="td2">----</td><td class="td3"><span><i class="data1">----</i><i class="data2">----</i></span></td></tr><tr class= "EURUSD"><td class="td1">欧元美元</td><td class="td2">----</td><td class="td3"><span><i class="data1">----</i><i class="data2">----</i></span></td></tr><tr class= "DINIW"><td class="td1">美元指数</td><td class="td2">----</td><td class="td3"><span><i class="data1">----</i><i class="data2">----</i></span></td></tr></tbody></table>    </div>
	<div class="more"><a href="http://www.k1600.com/quotes/" target="_blank"></a></div>
</div>
</body>
</html>
