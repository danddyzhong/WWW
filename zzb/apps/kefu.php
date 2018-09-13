<?php
require_once '../include/common.inc.php';
$query=$db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.gid=3 ");
while($row=$db->fetch_row($query)){
	$list.="

  <div class='li' id='$row[uid]'>
    <div class='li_img'><img src='../face/img.php?t=p2&u={$row[uid]}'></div>
    <div class='li_qq'><a href='http://wpa.qq.com/msgrd?v=3&uin={$row[realname]}&site=qq&menu=yes' title='点击这里联系 {$row[nickname]} QQ：{$row[realname]}' target='_blank'>
    {$row[nickname]}</a></div>
    <div class='li_phone'>{$row[phone]}</div>
  </div>
";
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="../room/script/jquery.min.js"></script>
<title>客服列表</title>
<style type="text/css">
/* CSS Document */


body { font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif; color: #4f6b72;background-color: #c2ddf3; }
a { color: #FFF; text-decoration: none;}
.list { float: left; }
.li { float: left; margin: 5px 5px 0 0; width: 112px; padding: 5px; border: 1px solid #aec5d8; background-color: #fff; height:208px;}
.li_img img{ width: 108px; height: 150px; border: 1px #CCCCCC solid; padding: 1px; }
.li_qq { background: url(img/pop_btn1.png) no-repeat; display: block; margin: 0 auto; color: #fff; font-size: 14px; padding-left: 25px; margin-top: 3px; width: 80px; height: 26px; line-height: 26px; overflow:hidden }
.li_qq:hover{opacity: 0.9;}
.li_phone { background: url(img/pop_btn2.png) no-repeat 1px 3px; display: block; height: 22px; line-height: 22px; padding-left: 12px; margin: 0 auto; overflow:hidden; color:#F00}
</style>
</head>

<body>
<div class='list'>


<?=$list?>
</div>
<script>
/*
$(function(){
	var list=$(".li");
	for(var i=0;i<list.length ;i++){
		var id=$(list[i]).attr('id');

		if($("#group_myuser",window.parent.document).find('#myuser'+id).length<1&&$("#group_myuser",window.parent.document)[0]!=undefined){
			if(id!='PubKF')
			$("#"+id).hide();
			
		}
	}
	
});
*/
</script>
<iframe src="" frameborder="0" scrolling-y="auto" width="1" style=" display:none" name='oqq'></iframe>
</body>
</html>