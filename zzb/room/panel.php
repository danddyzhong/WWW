<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body { margin-left: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; font-size:12px; text-align:center;}
-->
</style>
<?php
switch($_GET['type'])
{
	case "insertimg":
		echo '网络图片：<input type="text" id="uimg" name="uimg" />&nbsp;<button onclick="top.InsertIMG(document.getElementById(\'uimg\').value,\'1\')">插入</button>';
	break;
}
?>