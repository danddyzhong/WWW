<?php
require_once '../include/common.inc.php';
require_once PPCHAT_ROOT.'./include/json.php';
$json=new JSON_obj;
$vuid=$_SESSION['login_uid'];
$m=date('Ym',gdate());
if(!isset($om))$om=$m;
if($act=="add"){
	if($vuid<1){
		$data["status"]=0;
		$data["msg"]="未登录，不能投票";
		exit($json->encode($data));	
	}
	if($db->num_rows($db->query("select * from {$tablepre}apps_rank where vuid='$vuid' and uid='$teacher' and FROM_UNIXTIME(vtime,'%Y%m%d')='".date('Ymd',gdate())."'"))>0){
		$data["status"]=2;
		$data["msg"]="你今日已经投过他了！";
		exit($json->encode($data));	
	}
	$db->query("insert into {$tablepre}apps_rank(uid,vuid,vtime)values('$teacher','$vuid',".gdate().")");
	$data["status"]=1;
	$data["msg"]="";
	//$db->query_cache_clear('rank');
	exit($json->encode($data));	
}
//$db->query_cache_clear('rank');
$re=$db->query_cache('rank',60*2,"select m.*,ms.*,(select count(*) from  {$tablepre}apps_rank where uid=m.uid and FROM_UNIXTIME(vtime,'%Y%m')='".date("{$om}",gdate())."') as sum,(select count(*) from  {$tablepre}apps_rank where uid=m.uid and FROM_UNIXTIME(vtime,'%Y%m%d')='".date("Ymd",gdate())."') as dsum from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.gid=4 order by sum desc",60);

foreach($re as  $row){
	
	if($om!=date('Ym',gdate()))$vote_none=" style='display:none'";
	$list.="
		<li id='t{$row[uid]}'><a href='javascript:vote({$row[uid]})' {$vote_none}></a>
		<p class='v_name'><i class='percent'></i>{$row[nickname]}</p>
		<p class='percent_container'><span class='percent_line'></span></p>
		<p class='v_text' ><span>今日获赞：<i class='count'>{$row[dsum]}</i></span><span>月累计：<i class='amount'>{$row[sum]}</i></span></p></li>
	";
	$vote_none="";
	$sum=$sum+$row['sum'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
<meta name="keyword" content=""/>
<title><?=$om?>月份讲师榜单</title>
<script type="text/javascript" src="../room/script/jquery.min.js"></script>

<style>
*{margin:0;padding:0;}
html{height:100%; }
body{background:#fff;font-family:microsoft yahei,Helvetica,arial,sans-serif;font-size:14px;color:#888;}
.grap{width:800px;margin:0 auto;}
.grap h1{text-align:center;color:#ff0;font-size:36px;background:url(img/tbg.gif) center no-repeat;}
li i{font-style:normal;}
.grap h1 i{font-size:14px;font-style:normal;font-weight:normal;margin-left:10px;color:#E8C2C6;}
.vote{clear:both;padding:25px;border:2px solid #B20000;border-radius:15px;}
.vote li{height:115px; padding-top:15px;border-bottom:1px solid #ddd;list-style-type:none;}
.vote li a{float:right;width:100px; height:100px;display:block;background:url(img/vote.gif) no-repeat;font-size:0px;overflow:hidden;text-indent:-50px;}
.vote li a:hover{background:url(img/voon.gif) no-repeat;}
.vote li a.voted{background:url(img/voted.gif) no-repeat;}
.vote li p{float:left;width:620px;}
.v_name{height:35px;line-height:35px;font-size:18px;color:#333;}
.v_name i{float:right;padding-right:10px;font-style:normal;color:#B20000;}
.percent_container{height:28px;background:#eee;position:relative;margin-top:8px;}
.percent_line{position:absolute;left:0;top:0;height:28px;background:#B20000;display:block;}
.w33{width:33%;}
.w20{width:20%;}
.w10{width:10%;}
.v_text{margin-top:8px;height:27px;line-height:27px;}
.v_text span{margin-right:25px;}
.malertbox{border:#ccc 1px solid\9;}
</style>

</head>

<script>
var sum = <?=$sum?>;
var id = 6;
$(function(){

	calpercent();

	
});
function calpercent(){
		$('ul li').each(function(){
			var count = parseInt($(this).find('.count').text());
			var amount = parseInt($(this).find('.amount').text());
			
			var percent= sum ? Math.round(amount/sum*10000)/100: 1;
			percent = percent+'%';
			$(this).find('.percent').html(percent);
			$(this).find('.percent_line').css('width',percent);		
			
		});
}
function vote(t){
		$.post('?act=add',{'id':id,'teacher':t},function(data){
			if( data.status == 1){
				var num = $('#t'+t).find('.count').text();
				num = parseInt(num);
				$('#t'+t).find('.count').text( num+1);
				$('#t'+t).find('a').addClass('voted').attr('href','javascript:void(0)');

				num = $('#t'+t).find('.amount').text();
				num = parseInt(num);
				$('#t'+t).find('.amount').text( num+1);
				sum+=1;
				top.app_sendmsg('<img src="/room/face/colorbar/zyg.gif">');
				calpercent();
			}else if(data.status==2){
				top.layer.msg("你今日已为他点赞，明日再来！",{shift: 6});
			}else{
				alert( data.msg);
			}
		},'json');
}

</script>
<body>
<div class="grap">
<h1><?=date('Y年m',strtotime($om."28"))?>月讲师榜单</h1>
<span style="position:absolute;right:12px;top:12px;text-decoration:none;font-size:16px;color:#f00;" >
<select onChange="location.href='?om='+this.value">
<?="<option value='".date('Ym',gdate())."'>历史排行榜</option>"?>
<?="<option value='".date('Ym',gdate())."'>".date('Y年m月',gdate())."排行榜</option>"?>
<?="<option value='".date('Ym',strtotime('-1 month'))."'>".date('Y年m月',strtotime('-1 month'))."排行榜</option>"?>
<?="<option value='".date('Ym',strtotime('-2 month'))."'>".date('Y年m月',strtotime('-2 month'))."排行榜</option>"?>
<?="<option value='".date('Ym',strtotime('-2 month'))."'>".date('Y年m月',strtotime('-3 month'))."排行榜</option>"?>
</select></span>

<div class="vote">
<div style="font-size:20px;color:red;margin:20px;font-weight:bold;width:500px;margin:0 auto;text-align:center;">欢迎您参与我们月度之星评选！<br/>
感谢您对我们老师的支持！</div>
<ul id='vote'>


<?=$list?>

</ul>




</div>
</div>


</body>
</html>