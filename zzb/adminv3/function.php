<?php
if(!isset($_SESSION['admincp']))exit("<script>top.location.href='http://".$_SERVER["HTTP_HOST"]."/adminv3/login.php'</script>");
function group_add($title,$sn,$ico,$ov){
	global $db,$tablepre;
	$db->query("insert into {$tablepre}auth_group(title,sn,ico,type,ov)values('$title','$sn','$ico',0,'$ov')");	
}
function group_del($id){
	global $db,$tablepre;
	$db->query("delete from {$tablepre}auth_group where id='$id' and id not in (1,2,3)");
}
function group_edit($id,$title,$sn,$ico,$ov){
	global $db,$tablepre;
	$db->query("update {$tablepre}auth_group set title='$title',sn='$sn',ico='$ico',ov='$ov' where id='$id'");
}
function group_rules_edit($id,$rules){
	global $db,$tablepre;
	$db->query("update {$tablepre}auth_group set rules='$rules'  where id='$id'");
}
function user_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}members where uid  in ($ids) and uid not in (0,1)");
	$db->query("delete from {$tablepre}memberfields where uid in ($ids) and uid not in (0,1)");
}
function user_edit($id,$realname,$password,$phone,$gid,$fuser,$tuser,$sn,$state,$nickname,$rid,$kfmsg){
	global $db,$tablepre;
	if($password!="")$pwd=" ,password='".md5($password)."',";
	else $pwd=',';
	if(stripos(auth_group($_SESSION['login_gid']),'users_group')!==false)
	{
		$db->query("update {$tablepre}members set gid='$gid'  where uid='$id'");
	}
	
	$db->query("update {$tablepre}members set realname='$realname' $pwd phone='$phone',fuser='$fuser',tuser='$tuser',rid='$rid',state='$state' where uid='$id'");
	$db->query("update {$tablepre}memberfields set sn='$sn',nickname='$nickname',kfmsg='$kfmsg' where uid='$id'");
}
function config_edit($arr,$id){
	global $db,$tablepre;
	foreach($arr as $key=>$v){
		$set[]="`$key`='$v'";
	}
	$sql="update {$tablepre}config set ".implode(",",$set)." where id='$id'";
	$db->query($sql);
}
function ban_del($id){
	global $db,$tablepre;
	$db->query("delete from {$tablepre}ban where id='$id'");
}
function ban_add($username,$ip,$sn,$losttime){
	global $db,$tablepre;
	$losttime=strtotime($losttime);
	$db->query("insert into {$tablepre}ban(username,ip,sn,losttime)values('$username','$ip','$sn','$losttime')");
}
function ban_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}ban";
	if($key!="")$sql.=" where username like '%$key%' or ip like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);
	

}
function notice_del($id){
	global $db,$tablepre;
	$db->query("delete from {$tablepre}notice where id='$id'");
}
function notice_add($title,$txt,$ov,$type,$rid){
	global $db,$tablepre;
	$losttime=strtotime($losttime);
	$db->query("insert into {$tablepre}notice(title,txt,ov,`type`,rid)values('$title','$txt','$ov','$type','$rid')");
}
function notice_edit($id,$title,$txt,$ov,$type,$rid){
	global $db,$tablepre;
	$db->query("update {$tablepre}notice set title='$title',txt='$txt',ov='$ov',`type`='$type',rid='$rid' where id='$id'");
}
function log_list($num,$type,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}msgs where 1=1";
	if($type!="")$sql.=" and `type`='$type'";
	if($key!="")$sql.=" and( uid like '%$key%' or ip like '%$key%' or uname like '%$key%' or msg like '%$key%')";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}
function log_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}msgs where id in ($ids)");
}
function hd_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}apps_hd where id in ($ids)");
}
function app_hd_add($ktime,$ptime,$sp,$kcj,$lx,$cw,$zsj,$zyj,$username,$pcj,$sn){
	global $db,$tablepre;
	$time=gdate();
	$ktime=strtotime($ktime);
	$ptime=strtotime($ptime);
	
	$db->query("insert into {$tablepre}apps_hd(ktime,ptime,sp,kcj,lx,cw,zsj,zyj,username,pcj,sn,ttime)values('$ktime','$ptime','$sp','$kcj','$lx','$cw','$zsj','$zyj','$username','$pcj','$sn','$time')");
}
function app_hd_edit($id,$ktime,$ptime,$sp,$kcj,$lx,$cw,$zsj,$zyj,$username,$pcj,$sn){
	global $db,$tablepre;
	$ktime=strtotime($ktime);
	$ptime=strtotime($ptime);
	$db->query("update {$tablepre}apps_hd set ktime='$ktime',ptime='$ptime',sp='$sp',kcj='$kcj',lx='$lx',cw='$cw',zsj='$zsj',zyj='$zyj',username='$username',pcj='$pcj',sn='$sn' where id='$id'");
}
function app_hd_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_hd";
	if($key!="")$sql.=" where uname like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
		while($row=$db->fetch_row($query)){
		$t=$tpl;
		
		if(strpos($row[lx],'买')&&$row['pcj']!=""){
			$t=str_replace('{yld}',round($row['pcj']-$row['kcj'],2),$t);
		}
		else if(strpos($row[lx],'卖')&&$row['pcj']!=""){
			$t=str_replace('{yld}',round($row['kcj']-$row['pcj'],2),$t);
		}else{
			$t=str_replace('{yld}','',$t);
		}
		foreach($row as $k=>$value){
			$t=str_replace('{'.$k.'}',$value,$t);	
		}
		$str.=$t;
		
	}
	return $str;

}

function app_wt_edit($id,$q,$a,$quser,$auser,$zt){
	global $db,$tablepre;
	$db->query("update {$tablepre}apps_wt set q='$q',a='$a',quser='$quser',auser='$auser',zt='$zt'  where id='$id'");
}
function app_wt_add($q,$a,$quser,$auser,$zt){
	global $db,$tablepre;
	$qtime=gdate();
	$db->query("insert into {$tablepre}apps_wt(q,a,quser,auser,qtime,zt)values('$q','$a','$quser','$auser','$qtime','$zt')");
}
function wt_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}apps_wt where id in ($ids)");
}
function app_wt_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_wt";
	if($key!="")$sql.=" where q like '%$key%' or a like '%$key%' or quser like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}


function app_jyts_edit($id,$title,$txt,$user){
	global $db,$tablepre;
	$db->query("update {$tablepre}apps_jyts set title='$title',txt='$txt',`user`='$user' where id='$id'");
}
function app_jyts_add($title,$txt,$auser){
	global $db,$tablepre;
	$atime=gdate();
	$db->query("insert into {$tablepre}apps_jyts(title,txt,`user`,atime)values('$title','$txt','$user','$atime')");
}
function jyts_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}apps_jyts where id in ($ids)");
}
function app_jyts_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_jyts";
	if($key!="")$sql.=" where title like '%$key%' or txt like '%$key%' or `user` like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}


function app_scpl_edit($id,$title,$txt,$user,$dj){
	global $db,$tablepre;
	$db->query("update {$tablepre}apps_scpl set title='$title',txt='$txt',`user`='$user',dj='$dj' where id='$id'");
}
function app_scpl_add($title,$txt,$user,$jd){
	global $db,$tablepre;
	$atime=gdate();
	$db->query("insert into {$tablepre}apps_scpl(title,txt,`user`,atime,dj)values('$title','$txt','$user','$atime','$dj')");
}
function scpl_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}apps_scpl where id in ($ids)");
}
function app_scpl_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_scpl";
	if($key!="")$sql.=" where title like '%$key%' or txt like '%$key%' or `user` like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}



function app_files_edit($id,$title,$url,$user){
	global $db,$tablepre;
	$db->query("update {$tablepre}apps_files set title='$title',url='$url',`user`='$user' where id='$id'");
}
function app_files_add($title,$url,$user){
	global $db,$tablepre;
	$atime=gdate();
	$db->query("insert into {$tablepre}apps_files(title,url,`user`,atime)values('$title','$url','$user','$atime')");
}
function files_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}apps_files where id in ($ids)");
}
function app_files_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_files";
	if($key!="")$sql.=" where title like '%$key%'   or `user` like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}




function app_manage_edit($id,$title,$url,$ico,$w,$h,$target,$s,$ov,$col,$bg,$jb,$rid,$p){
	global $db,$tablepre;
	$db->query("update {$tablepre}apps_manage set p='$p',rid='$rid',col='$col',bg='$bg',jb='$jb',title='$title',url='$url',ico='$ico',w='$w',h='$h',target='$target',s='$s',ov='$ov' where id='$id'");
}
function app_manage_add($title,$url,$ico,$w,$h,$target,$s,$ov,$col,$bg,$jb,$rid,$p){
	global $db,$tablepre;
	$atime=gdate();
	$db->query("insert into {$tablepre}apps_manage(col,bg,jb,title,url,ico,w,h,target,s,ov,rid,p)values('$col','$bg','$jb','$title','$url','$ico','$w','$h','$target','$s','$ov','$rid','$p')");
}
function manage_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}apps_manage where id in ($ids) and id not in(1,2,3,4,5,6)");
}
function app_manage_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_manage";
	if($key!="0" &&trim($key)!='' )$sql.=" where rid='$key'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by s,ov desc,id desc";
	$sql.=" limit $firstcount,$displaypg";
	
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}
function toupiao_del($ids){
	global $db,$tablepre;
	if($ids=="")return;
	$db->query("delete from {$tablepre}apps_toupiao where id in ($ids)");
	$db->query("delete from {$tablepre}apps_toupiao_xx where pid in ($ids)");
}
function app_toupiao_list($num,$key,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}apps_toupiao";
	if($key!="")$sql.=" where title like '%$key%'";
	
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc";
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);	

}
function selectRooms($tag,$def){
	global $db,$tablepre;
	$query=$db->query("select * from {$tablepre}config");
	while($row=$db->fetch_row($query)){
		$str.="<option value='$row[id]'>$row[id]-$row[title]</option>";
	}
	$str="<select name='{$tag}' id='{$tag}'><option value='{$def}'>{$def}-保持不变</option>{$str}</select>";
	return $str;
}
function selectRooms1($tag,$def){
	global $db,$tablepre;
	$query=$db->query("select * from {$tablepre}config");
	while($row=$db->fetch_row($query)){
		$str.="<option value='$row[id]'>$row[id]-$row[title]</option>";
	}
	$str="<select name='{$tag}' id='{$tag}'><option value='{$def}'>{$def}-保持不变</option><option value='0'>0-所有房间</option>{$str}</select>";
	return $str;
}
function gold_log($num,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}gold_log";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc limit $firstcount,$displaypg";
	$query=$db->query($sql);
	
	return for_each($query,$tpl);
}
function gift_add($name,$msg,$img,$price,$gif){
	global $db,$tablepre;
	$db->query("insert into {$tablepre}gift_goods(name,msg,img,price,gif)values('$name','$msg','$img','$price','$gif')");
}
function gift_edit($id,$name,$msg,$img,$price,$gif){
	global $db,$tablepre;
	$db->query("update {$tablepre}gift_goods set gif='$gif',name='$name',msg='$msg',img='$img',price='$price' where id='$id'");
}
function gift_del($id){
	global $db,$tablepre;
	$db->query("delete from {$tablepre}gift_goods where id='$id' ");
}
function payitem_add($sn,$gold,$vip_lv,$vip_expire,$rmb){
	global $db,$tablepre;
	$v=$vip_lv."|".$vip_expire."|".$gold;
	$db->query("insert into {$tablepre}payitem(sn,v,rmb)values('$sn','$v','$rmb')");
}
function payitem_edit($id,$sn,$gold,$vip_lv,$vip_expire,$rmb){
	global $db,$tablepre;
	$v=$vip_lv."|".$vip_expire."|".$gold;
	$db->query("update {$tablepre}payitem set sn='$sn',v='$v',rmb='$rmb' where id='$id'");
	
}
function user_edit_goldvip($uid,$vip_lv,$vip_expire,$addgold,$addmoney){
	global $db,$tablepre,$onlineip;
	$vip_lv=(int)$vip_lv;
	
	if($vip_lv>0){$vip_expire=$vip_lv.'-'.strtotime($vip_expire);}
	else $vip_expire=0;
	
	$addgold=(int)$addgold;
	$addmoney=floatval($addmoney);
	$db->query("update {$tablepre}members set gold=gold+$addgold,money=money+$addmoney,vip_expire='$vip_expire' where uid='$uid'");
	if($addgold>0){
		$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$uid','{$addgold}','$onlineip','".gdate()."','gold_add-{$uid}|{$addgold}|{$_SESSION[admincp]}充值')"); 
	}
	if($addmoney>0){
		$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$uid','{$addmoney}','$onlineip','".gdate()."','money_add-{$uid}|{$addmoney}|{$_SESSION[admincp]}充值')"); 
	}
}
function payitem_del($id){
	global $db,$tablepre;
	$db->query("delete from {$tablepre}payitem where id='$id' ");
}
function payorder($num,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}payorder";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc limit $firstcount,$displaypg";
	$query=$db->query($sql);
	
	return for_each($query,$tpl);
}
?>