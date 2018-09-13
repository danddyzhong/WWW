<?php
echo file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=".$_GET['ip']);
?>