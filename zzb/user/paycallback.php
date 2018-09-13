<?php
require_once '../include/common.inc.php';

$k=$memo;
if($k!="vip_ppchat_org")die();//连接key
$rmb=$Money;
//$sn=iconv("GBK", "UTF-8", $title);;
$sn= $title;
if($Gateway=="alipay")$paytype="alipay";
else if($Gateway=="weixin")$paytype="weixin";

$otime=time()-5*60;
$ntime=time();
$query=$db->query("select * from {$tablepre}payorder where sn='$sn' and pay=0 and rmb='$rmb' and ptype='$paytype' and payordertime>=$otime");
while($row=$db->fetch_row($query)){
	$db->query("update {$tablepre}payitem_ewm set stime=0,state=0 where orderid='{$row[id]}'");
	$db->query("update {$tablepre}payorder set paytime=$ntime,pay=1 where id='$row[id]' ");
		
	$payitem=$db->fetch_row($db->query("select * from {$tablepre}payitem where id='$row[payid]'"));
	$gold=explode('|',$payitem[v]);
	$gold=$gold[2];
	$db->query("update {$tablepre}members set gold=gold+$gold where uid='$row[uid]'");
	$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$row[uid]','$gold','$onlineip','$ntime','gold_cz-$row[uid]|{$gold}|{$paytype}接口充值')");
	echo "Success";
}



?>