<?php
require_once '../include/common.inc.php';
$query=$db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.gid=3 ");
while($row=$db->fetch_row($query)){
	$list.='
	    <div class="kefu clearfix">
		<div class="avatar nocustomer">
		<img src="../face/img.php?t=p1&u='.$row[uid].'"></div>
		<a class="button btn-qq nocustomer" href="http://wpa.qq.com/msgrd?v=3&amp;uin='.$row[realname].'&amp;site=qq&amp;menu=yes" target="_blank">
		<!--mqqwpa://im/chat?chat_type=wpa&uin={$row[realname]}&version=1&src_type=web&web_src=oicqzone.com-->
		<i class="icon icon-qq"></i>QQ交谈</a>
		<div class="name ellipsis nocustomer online">'.$row[nickname].' '.$row[phone].'</div>
		</div>
	';
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>客服列表</title>
<style type="text/css">
/* CSS Document */

.kefuContent .kefuContent-container {margin-top: 10px;}
.kefuContent .kefu {padding: 10px 15px; background-color: #fff; border-bottom: 1px solid #dadada;}
.kefuContent .kefu .button {float: right; text-align: center; padding: 0 5px; height: 25px; line-height: 25px; margin-top: 3px; border-radius: 3px;}
.kefuContent .kefu .button.btn-qq { background-color: #fdc965; color: #fff; margin-left: 10px;}
.kefuContent .kefu .avatar { float: left;}

.kefuContent .kefu .avatar img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    max-width: 100%;
}

.kefuContent .kefu .button .icon {
    width: 14px;
    height: 14px;
    margin-right: 3px;
    background: url(img/icon_qq.png) no-repeat center;
    background-size: 14px;
    vertical-align: -2px;
    display: inline-block;
}

.kefuContent .kefu .name {
    padding-right: 30px;
    line-height: 32px;
    color: #7e7e7f;
    margin-left: 35px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
body { font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif; color: #4f6b72;background-color: #fff;  }
a { color: #FFF; text-decoration: none;}

</style>
</head>

<body style="overflow:auto">

<div id="kefuContent" class="kefuContent">
<div class="kefuContent-container">

<?php
	  $arr = explode("\n",$cfg[config][ggzl]);
		foreach($arr as $k=>$v){
			$li=explode('|',$v);
				echo '
	    <div class="kefu clearfix">
		<div class="avatar nocustomer">
		<img src="/face/rebot/01.png"></div>
		<a class="button btn-qq nocustomer" href="mqqwpa://im/chat?chat_type=wpa&uin='.$li[4].'&version=1&src_type=web&web_src=oicqzone.com" target="_blank">
		<!--mqqwpa://im/chat?chat_type=wpa&uin='.$li[4].'&version=1&src_type=web&web_src=oicqzone.com-->
		<i class="icon icon-qq"></i>QQ交谈</a>
		<div class="name ellipsis nocustomer online">'.$li[3].' </div>
		</div>
	';
		}
	  ?>		
</div></div>
<iframe src="" frameborder="0" scrolling-y="auto" width="1" style=" display:none" name='oqq'></iframe>
</body>
</html>