<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'tongji_reg')===false)exit("没有权限！");

?>
<!DOCTYPE HTML>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/bui-min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/page-min.css" rel="stylesheet" type="text/css" />
<!-- 下面的样式，仅是为了显示代码，而不应该在项目中使用-->
<link href="../assets/css/prettify.css" rel="stylesheet" type="text/css" />
<style type="text/css">
code { padding: 0px 4px; color: #d14; background-color: #f7f7f9; border: 1px solid #e1e1e8; }
</style>
<script>
Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
function ftime(time){
	return new Date(time*1000).Format("yyyy-MM-dd hh:mm"); ; 
}
</script>
</head>
<body>
<div class="container"  style=" min-width:1300px;">

  <table  class="table table-bordered table-hover definewidth m10">
	<tr><td>
	
	<div class="row">
        <div class="span24" id="canvas"></div>
      </div>
	</td></tr>



  </table>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
<script src="http://g.tbcdn.cn/bui/acharts/1.0.32/acharts-min.js"></script>
<!-- https://g.alicdn.com/bui/acharts/1.0.29/acharts-min.js -->
 
 
  <script type="text/javascript">
      var chart = new AChart({ 
          theme : AChart.Theme.Base,
          id : 'canvas',
          width : 960,
          height : 500,
          plotCfg : {
            margin : [50,50,50]
          },
          xAxis : {
            type : 'time',
            labels : {
              label : {
                'font-size': '10'
              }
            },
            formatter : function(value){
              var date = new Date(value);
              return date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
            },
            tickOffset : 10
          },
		  seriesOptions : { //设置多个序列共同的属性
            lineCfg : { //不同类型的图对应不同的共用属性，lineCfg,areaCfg,columnCfg等，type + Cfg 标示
              markers : {
                single : true //仅使用一个marker
              },
              smooth : true
            }
          },
          yAxis : {
            min : 0
          },  
          tooltip : {
            valueSuffix : '人',
			crosshairs : true //是否出现基准线
          },
          legend : {
            align : 'right',
            layout : 'vertical',
            dy : -150,
            dx : -60
          },
          xTickCounts : [1,8],//设置x轴tick最小数目和最大数目 
          series : [ {
              name: '在线人数',
              smooth : true,
              animate: false 
          }]
        });
 
        chart.render();
 
          var series = chart.getSeries()[0]; 
 
 
 
          function add(y){
            var x = Math.floor((new Date()).getTime()/1000) * 1000; // current time         
                  //y = Math.random() + 0.25;  
              
            series.addPoint([x, y],false,true); 
          }
		  
		  
var ws;
function OnSocket(){
	ws=new WebSocket("ws://<?=$cfg['config']['tserver']?>");
	ws.onopen=function(){ws.send("UserListCount=M=<?=$_SERVER['HTTP_HOST']?>/<?=$cfg['config']['id']?>");setInterval('ws.send("UserListCount=M=<?=$_SERVER['HTTP_HOST']?>/<?=$cfg['config']['id']?>")',2000);}
	ws.onmessage=function(e){var msg=eval("("+e.data+")");add(msg.OnlineNum)}
	ws.onclose=function(){setTimeout('OnSocket()',1000);}
	ws.onerror=function(){}
}
OnSocket();
      </script>

</body>
</html>
