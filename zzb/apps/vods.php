<?php
require_once '../include/common.inc.php';
function app_vod_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_vod";
	if($key!="")$sql.=" where title like '%$key%'  ";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by ov desc,id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="../room/script/jquery.min.js"></script>
<title>视频库</title>
<style type="text/css">
/* CSS Document */


body { font: normal 13px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif; color: #4f6b72;background-color: #fff; }
a { color: #FFF; text-decoration: none;}
.list { float: left; }
.li { float: left; margin: 5px 5px 0 0; width: 130px; padding: 5px;    height:110px; cursor:pointer}
.li_img img{ width: 125px; height: 75px; border: 1px #CCCCCC solid; padding: 1px; }
.li_qq { background: url(img/pop_btn1.png) no-repeat; display: block; margin: 0 auto; color: #fff; font-size: 14px; padding-left: 25px; margin-top: 3px; width: 80px; height: 26px; line-height: 26px; overflow:hidden }
.li_phone:hover{ color:#000; }
.li_phone { display: block; height: 20px; line-height: 20px; margin: 2px; overflow:hidden; color:#333; text-align:center}
</style>
</head>

<body>
<div class='list'>
<?php
echo app_vod_list(20,$key,"
  <div class='li' id='{id}' onClick='view(\"{url}\")'>
    <div class='li_img'><img src='{pic}'></div>
    <div class='li_phone'>{title}</div>
  </div>
")?>


</div>
<script>
function view(swf){
	$("#tag_logo",parent.document).hide();
	$("#OnLine_MV",parent.document).html('<embed id="videolive" src="'+swf+'" quality="high" width="100%" height="100%" align="middle" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" type="application/x-shockwave-flash" autostart="true">');
	top.layer.closeAll();
}
</script>
</body>
</html>
