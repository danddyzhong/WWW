<?php
$u=$_GET['t'].'/'.$_GET['id'].".gif";
$n=$_GET['t'].'/null.gif';
if(file_exists($u))header("Location: $u");
else 
header("Location: $n");
?>