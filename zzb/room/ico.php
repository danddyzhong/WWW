<?php
require_once '../include/common.inc.php';
$cfg['config']=$db->fetch_row($db->query("select * from {$tablepre}config where id='{$rid}'"));
$str='
[DEFAULT]
BASEURL=http://'.$_SERVER['HTTP_HOST'].'/?rid='.$rid.'
[{000214A0-0000-0000-C000-000000000046}]
Prop3=19,2
[InternetShortcut]
IDList=
URL=http://'.$_SERVER['HTTP_HOST'].'/?rid='.$rid.'
IconFile=http://'.$_SERVER['HTTP_HOST'].$cfg['config']['ico'].'
IconIndex=1
';
header("Content-type:application/octet-stream");
header("Content-Disposition:attachment;filename=".urlencode($cfg['config']['title']).".url");
echo $str;
?>
