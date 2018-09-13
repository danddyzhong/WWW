<?php
require_once '../include/common.inc.php';
?>
<style>
*{ margin:0px;}
.gd{ color:#FFF; height:36px; line-height:36px; background:#000; position:absolute; bottom:0px; left:0px; z-index:100px; width:140px; font-size:12px;}
.logo{height:50px; line-height:36px; background:#000; position:absolute; top:10px; left:20px; z-index:100px; width:200px; font-size:12px;
BACKGROUND: url(<?=$cfg['config']['logo']?>) no-repeat
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
switch($type){
	case "pc":
		exit(tohtml($cfg['config']['livefp']).'<div class="gd"><marquee scrollamount="3">投资有风险， 入市需谨慎</marquee></div><div class="logo"></div>');
	break;	
	case "m":
		exit(tohtml($cfg['config']['phonefp']));
	break;
}
?>
