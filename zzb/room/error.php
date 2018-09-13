<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>提 示</title>
</head>

<body>
<style>
*{font-family:'Microsoft YaHei UI', 'Microsoft YaHei', SimSun, 'Segoe UI', Tahoma, Helvetica, Sans-Serif;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div style="color:#F00; font-size:35px; margin-top:150px; margin-bottom:20px; text-align:center">提 示</div>
<div style="text-align:center; line-height:20px;">
<span  style="display:block; font-size:20px; color:#666;  padding:20px; margin:10px auto; width:600px; border:1px solid #CCC; white-space:200px; line-height:40px"><?=strip_tags($_GET['msg']);?></span>
<br><a href="/room/minilogin.php?act=logout" style="display:inline-block; width:60px; margin:10px; padding:5px; background:#09F; color:#FFF">返回</a>
</div>
</body>
</html>
