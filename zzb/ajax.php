<?php
header("Expires: Thu, 01 Jan 1970 00:00:01 GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");

require_once './include/common.inc.php';
require_once PPCHAT_ROOT.'./include/json.php';
$json=new JSON_obj;
$uid=(int)$uid;
$id=(int)$id;
switch($act)
{
		case "oldmsg":
			$uid=$_SESSION['login_uid'];
			$page=$page*20;
			//用户组
			$re = $db->query("select * from {$tablepre}auth_group order by ov desc");
			while($row=$db->fetch_row($re)){
				$groupli.="<div id='group_{$row[id]}' class='group'></div>";
				$grouparr.="grouparr['{$row[id]}']=".json_encode($row).";\n";
				$group["m".$row[id]]=$row;
			}
			$re = $db->query("select * from {$tablepre}msgs where rid='$rid' and p='false' and state!='1' and `type`='0'    order by id desc limit $page, 20 ");
			if($type=='pc')
			while($row=$db->fetch_row($re)){
				$row['msg']=tohtml($row['msg']);
				$who=" notmine";
				if($row[ugid]=='2'||$row[ugid]=='5'){$who.=' manage';}
				else if($row[ugid]=='3'||$row[ugid]=='4'){$who.=' teacher';}
				//if($row[uid]==$uid)$who=" notmine ";



				if($row[tuid]!="ALL")$row[msg]="@$row[tname] ".$row[msg];
				if($row[tname]=="hongbao"){$who.=' hongbaomsg';$row[msg]='<div class="redbag-top" title="'.$row[msg].'" data-hid="'.$row[msgid].'" onclick="getHongBao($(this).data(\'hid\'))"><div class="fl"><img src="/room/images/hongbao.png" style="margin-top: 3px;"></div><div class="fl ml10" style="color:#fff;"><p style="font-weight:bold;margin-bottom:4px;color:#f30;font-size:14px;">'.$row[msg].'</p>领取红包</div></div><div style="padding:3px 10px;background: #fff;color: #333;">直播室红包</div>';}
				if($row[tname]=="gift"){$who.=' system';}
				if($row[tname]=="gethongbao"){
					$omsg='<div class="message-wrap"><div class="redbag-info1"><p style="color:#333;">'.$row['uname'].' 领取了 <span style="color:red;">'.$row['style'].'</span> 的红包 <span style="color:red;">'.$row['msgid'].'元</span></p></div><div class="clear"></div></div>'.$omsg;
					continue;
				}
				$omsg='<div class="chat-item '.$who.'"><div class="user-img"> <div class="uimg"><img src="/face/img.php?t=p1&u='.$row[uid].'"/></div><div class="gimg"><img src="'.$group["m".$row[ugid]][ico].'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name"  onclick="ToUser.set(\''.$row[uid].'\',\''.$row[uname].'\')">'.$row[uname].'</span> <span class="chat-time">'.date('H:i:s',$row[mtime]).'</span></div><div class="chat-info-2"> <div class="chat-msg">'.$row[msg].'</div></div></div></div>'.$omsg;
			}
			if($type=='m')
			while($row=$db->fetch_row($re)){
				$row['msg']=tohtml($row['msg']);
				$who=" notmine";
				if($row[ugid]=='2'||$row[ugid]=='5'){$who.=' manage';}
				else if($row[ugid]=='3'||$row[ugid]=='4'){$who.=' teacher';}
				if($row[uid]==$uid)$who=" mine ";



				if($row[tuid]!="ALL")$row[msg]="@$row[tname] ".$row[msg];
				if($row[tname]=="hongbao"){$who.=' hongbaomsg';$row[msg]='<div class="redbag-top" title="'.$row[msg].'" data-hid="'.$row[msgid].'" onclick="getHongBao($(this).data(\'hid\'))"><div class="fl"><img src="/room/images/hongbao.png" style="margin-top: 3px;"></div><div class="fl ml10" style="color:#fff;"><p style="font-weight:bold;margin-bottom:4px;color:#f30;font-size:13px;">'.$row[msg].'</p>领取红包</div></div><div style="padding:3px 10px;background: #fff;color: #333;">直播室红包</div>';}
				if($row[tname]=="gift"){$who.=' system';}
				if($row[tname]=="gethongbao"){
					$omsg='<div class="message-wrap"><div class="redbag-info1"><p style="color:#333;">'.$row['uname'].' 领取了 <span style="color:red;">'.$row['style'].'</span> 的红包 <span style="color:red;">'.$row['msgid'].'元</span></p></div><div class="clear"></div></div>'.$omsg;
					continue;
				}
				$omsg='<div class="chat-item '.$who.'"><div class="user-img"> <div class="uimg"><img src="/face/img.php?t=p1&u='.$row[uid].'"/></div><div class="gimg"><img src="'.$group["m".$row[ugid]][ico].'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name"  onclick="ToUser.set(\''.$row[uid].'\',\''.$row[uname].'\')">'.$row[uname].'</span> <span class="chat-time">'.date('H:i:s',$row[mtime]).'</span></div><div class="chat-info-2"> <div class="chat-msg">'.$row[msg].'</div></div></div></div>'.$omsg;
			}
			$json=array();
			if($omsg!=""){
				$json["code"]="1";
				$json["html"]=$omsg;

			}else{
				$json["code"]="0";
				$json["html"]=$omsg;
			}
			exit(json_encode($json));
		break;
		case "banall":
			if(stripos(auth_group($_SESSION['login_gid']),'room_admin')!==false){
				$db->query("update {$tablepre}config set banall='$val' where id='$rid'");
				echo "ok";exit();
			}
		break;
		case "isqiandao":
			$uid=$_SESSION['login_uid'];
			$gid=$_SESSION['login_gid'];
			$myinfo=getUserInfo($uid); 
			$now=date('Ymd',time());
			$q=$db->query("select * from {$tablepre}apps_qiandao where uid='$uid' and rid='$rid' and FROM_UNIXTIME(ltime,'%Y%m%d')='$now'");
			if($db->num_rows($q)>0){
				exit('{"code":1}');
			}else exit('{"code":0}');
		break;
		case "qiandao":
			$uid=$_SESSION['login_uid'];
			$gid=$_SESSION['login_gid'];
			$myinfo=getUserInfo($uid); 
			$now=date('Ymd',time());
			$ltime=time();
			if($gid>0&&$rid>0){
				$q=$db->query("select * from {$tablepre}apps_qiandao where uid='$uid' and rid='$rid'");
				if($db->num_rows($q)>0){
					$q=$db->query("select * from {$tablepre}apps_qiandao where uid='$uid'  and rid='$rid' and FROM_UNIXTIME(ltime,'%Y%m%d')='$now'");
					if($db->num_rows($q)<1){
						//今天未签
						$tag=1;
						//上一天没签到更新累计
						$oday=date('Ymd',$ltime-24*3600);
						$q=$db->query("select * from {$tablepre}apps_qiandao where uid='$uid'  and rid='$rid' and FROM_UNIXTIME(ltime,'%Y%m%d')='$oday'");
						if($db->num_rows($q)<1){
							$db->query("update {$tablepre}apps_qiandao set ltime='$ltime',c=0 where uid='$uid' and rid='$rid'");
						}
					}else{
						$tag=0;
					}
				}else{
					//从没签到
					$db->query("insert into {$tablepre}apps_qiandao(uid,ltime,c,rid)values('$uid','$ltime',0,'$rid')");
					$tag=1;
				}
				
				$json=array();
				
				if($tag){						
					$db->query("update {$tablepre}apps_qiandao set ltime='$ltime',c=c+1,nick='$myinfo[nickname]' where uid='$uid' and rid='$rid'");
					$qiandao=$db->fetch_row($db->query("select * from {$tablepre}apps_qiandao where uid='$uid' and rid='$rid'"));
					$qdnum=$qiandao['c']*$cfg['config']['qiandao_num'];
					$qdre=$cfg['config']['qiandao_re'];
					if($qdre=="gold"){							
						$db->query("update {$tablepre}members set gold=gold+$qdnum where uid='$uid'");
						$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$uid','{$qdnum}','$onlineip','".gdate()."','gold_qiandao-{$uid}|{$qdnum}|签到获金币')"); 		
						$json['re']="金币";
					}else if($qdre=="money"){
						$db->query("update {$tablepre}members set money=money+$qdnum where uid='$uid'");
						$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$uid','{$qdnum}','$onlineip','".gdate()."','money_qiandao-{$uid}|{$qdnum}|签到获红包零钱')");
						$json['re']="元红包";
					}
					$db->query("insert into {$tablepre}apps_qiandao_log(uid,atime,rid,qiandao_re,qiandao_num,qiandao_c)values('$uid','$ltime','$rid','$qdre','$qdnum','$qiandao[c]')");
					$db->query("update {$tablepre}apps_qiandao set c=1 where uid='$uid' and c>=31");
				}
				
				$json["code"]=$tag;
				$json["credit"]=$qdnum;
				$json["persist"]=$qiandao['c'];
				exit(json_encode($json));
			}
		break;
		case "lookhbmoney":
			$uid=$_SESSION['login_uid'];
			$gid=$_SESSION['login_gid'];
			$myinfo=getUserInfo($uid); 
			if($gid>0){
				$query=$db->query("select h.uid,h.nick,g.money,g.gtime from {$tablepre}apps_hongbao as h,{$tablepre}apps_hongbao_get as g where h.id=g.hid and g.uid='$uid' order by g.gtime desc limit 20");
				$list=array();
				while($row=$db->fetch_row($query)){
					$row['time']=date('Y-m-d H:i:s',$row['gtime']);
					$list[]=$row;
				}
				$json=array();
				$json['code']=1;
				$json['glist']=$list;
				$json['msg']='';
				$json['gnum']=$db->num_rows($db->query("select id from {$tablepre}apps_hongbao_get where uid='$uid'"));
				exit(json_encode($json));
			}else{
				exit('{"code":0,"msg":"未登录"}');
			}
		break;
		case "gethongbao":
			$uid=$_SESSION[login_uid];
			$gid=$_SESSION['login_gid'];
			$myinfo=getUserInfo($uid); 
			if($gid>0){
				$query=$db->query("select * from {$tablepre}apps_hongbao where id='$hid' ");
				while($hongbao=$db->fetch_row($query)){
					if($hongbao['togid']!="0"&&$hongbao['togid']!=$gid)exit('{"code":6,"msg":"本次红包【'.$hongbao['togtitle'].'】才能参与!请联系在线客服或管理加入会员组"}');
				}

				if($_SESSION['backValidate']!=$vcode){
					exit('{"code":5,"msg":"验证码错误！'.$_SESSION['backValidate'].'-'.$vcode.'"}');
				}

				//code 0 未登录 1抢到 2已抢，3抢没了				
				$code=1;
				$lmoney=0.01;
				$omoney=0.00;
				$ntime=time();
				if($_SESSION["hb$hid"]!==true) {
					$fp = fopen("./tmp/hb$hid.lock", "w+");
					while (!flock($fp, LOCK_EX)) {
						usleep(1000 * 100);
					}
				}

				$query=$db->query("select * from {$tablepre}apps_hongbao where id='$hid' ");
				while($hongbao=$db->fetch_row($query)){
					$num=$db->fetch_row($db->query("select  ifnull(sum(money),0)as money,count(*)as num from {$tablepre}apps_hongbao_get where hid='$hid'"));
					
					$q=$db->query("select * from {$tablepre}apps_hongbao_get where hid='$hid' and uid='$uid'");
					if($db->num_rows($q)<1&&$_SESSION["hb$hid"]!==true){
						if($num['num']<$hongbao['number']){
							$otime=$hongbao['atime']+24*3600;
							if($otime<time()){
								//过期了
								$code=4;
								//过期处理
							}else{
								$code=1;
								//红包剩余rmb
								$omoney=$hongbao['money']-$num['money'];
								//随机红包
								if($hongbao['number']-$num['num']==1)$mmoney=$omoney;
								else {
									$max=$omoney/($hongbao['number']-$num['num']+1)*2;
									$mmoney=mt_rand($lmoney*100,$max*100)/100;
								}
								$db->query("update {$tablepre}members set money=money+$mmoney  where uid='$uid'");
								$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$uid','{$mmoney}','$onlineip','".gdate()."','money_gethongbao-{$uid}|{$mmoney}|抢红包')"); 
								$db->query("insert into {$tablepre}apps_hongbao_get(hid,uid,money,gtime,nick)value('$hid','$uid','$mmoney','$ntime','$myinfo[nickname]')");
								$num=$db->fetch_row($db->query("select  ifnull(sum(money),0)as money,count(*)as num from {$tablepre}apps_hongbao_get where hid='$hid'"));
								$_SESSION["hb$hid"]=true;
							}
						}else{
							//抢没了
							$code=3;
						}
					}else{
						//抢过了
						$code=2;
					}
					
					$q=$db->query("select * from {$tablepre}apps_hongbao_get where hid='$hid'");
					$list=array();
					while($item=$db->fetch_row($q)){
						$item['time']=date('Y-m-d H:i:s',$item['gtime']);
						$list[]=$item;
					}
					$json=array();
					$json["code"]=$code;
					$json["hinfo"]=$hongbao;
					$json["glist"]=$list;
					$json["gnum"]=$num['num'];
					$json["gmoney"]=$num['money'];
					$json["msg"]="";
					exit(json_encode($json));
				}
				flock($fp, LOCK_UN);
				fclose($fp);
			}
			else{
				exit('{"code":0,"msg":"未登录"}');
			}
		break;
		case "sendhongbao":
			$row=$db->fetch_row($db->query("select money,gold from {$tablepre}members where uid='{$_SESSION[login_uid]}'"));
			$money=floatval($money);
			$number=(int)$number;
			$msg=strip_tags($txt);
			$atime=time();
			$myinfo=getUserInfo($_SESSION[login_uid]); 
			if($row['money']>=$money){				
				$db->query("update {$tablepre}members set money=money-{$money} where uid='{$_SESSION[login_uid]}'");
				$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('{$_SESSION[login_uid]}','{$money}','$onlineip','".time()."','money_hongbao-{$_SESSION[login_uid]}|{$money}|发红包')"); 
				$db->query("insert into {$tablepre}apps_hongbao(money,number,msg,atime,rid,nick,uid,togid,togtitle)values('$money','$number','$msg','$atime','$rid','$myinfo[nickname]','$myinfo[uid]','$togid','$togtitle')");
				$hid=$db->insert_id();
				exit('{"code":1,"uid":"'.$_SESSION[login_uid].'","msg":"'.$msg.'","hid":"'.$hid.'"}');
			}
			else{
				exit('{"code":0,"msg":"余额不足"}');
			}
		break;
		case "mymoney":
			$uid=$_SESSION[login_uid];
			$gid=$_SESSION['login_gid'];
			$myinfo=getUserInfo($uid); 
			if($gid>0){
				//过期红包回收
				$otime=time()-24*3600;
				
				$q=$db->query("select * from {$tablepre}apps_hongbao where uid='$uid' and over=0 and atime<$otime");
				while($hongbao=$db->fetch_row($q)){
					$num=$db->fetch_row($db->query("select  ifnull(sum(money),0)as money,count(*)as num from {$tablepre}apps_hongbao_get where hid='$hongbao[id]'"));
					if($num['num']<$hongbao['number']){
						$omoney=$hongbao['money']-$num['money'];
						$db->query("update {$tablepre}members set money=money+{$omoney} where uid='$uid'");
						$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$uid','{$omoney}','$onlineip','".time()."','money_hongbao_over-{$uid}|{$omoney}|过期红包回收')"); 
						$db->query("update  {$tablepre}apps_hongbao set over=1 where id='$hongbao[id]' ");
					}
				}
				
					
				$row=$db->fetch_row($db->query("select money,gold from {$tablepre}members where uid='{$_SESSION[login_uid]}'"));
				exit($json->encode($row));
			}
			
			
		break;
		case "orderstate":
			$query=$db->query("select * from {$tablepre}payorder where id='$oid' and pay=1");
			if($db->num_rows($query)>0){exit('{"code":1}');}else{exit('{"code":0}');}
		break;
		case "sendgift":
			exit(sendgift($num,$gid,$sid,''));
		break;
		case "sendyzm":
			include_once './include/sendmsg.php';
			
			if($_SESSION['backValidate']!=$gvc){exit('图形验证码错误！');}
			$phone=trim($phone);
			$query=$db->query("select uid from {$tablepre}members where phone='{$phone}' limit 1");
			if($db->num_rows($query)){
				exit("{$phone} 已经注册,不能重复使用!验证码发送失败!");
			}else{
				$yzm=rand(1000,9999);
				$_SESSION['reg_yzm']=$yzm;
				$sendstr="您好！感谢您注册，您获取的手机验证码为：{$yzm}，有效期3分钟。如非本人操作，请忽略此短信。";
				$re=sms_send($phone,$sendstr);
				exit($re);
			}
		break;
		
		case "sendyzm_yz":
			if($_SESSION['reg_yzm']==$yzm)exit("1");
		break;
		case "sendyzm_repwd":
			include_once './include/sendmsg.php';
			if($_SESSION['backValidate']!=$gvc){exit('图形验证码错误！');}
			$phone=trim($phone);
			$query=$db->query("select uid from {$tablepre}members where phone='{$phone}' limit 1");
			if($db->num_rows($query)){
				$yzm=rand(1000,9999);
				$_SESSION['repwd_yzm']=$yzm;
				$_SESSION['repwd_phone']=$phone;
				$sendstr="您好！您正在重置密码，验证码为：{$yzm}，有效期3分钟。如非本人操作，请忽略此短信。";
				$re=sms_send($phone,$sendstr);
				exit($re);
				
			}else{
				exit("号码未注册!发送失败!");
			}
		break;
		case "sendyzm_repwd_yz":
			if($_SESSION['repwd_yzm']==$yzm){$_SESSION['repwd_yzm_ok']=1;exit("1");}
		break;
		case "repwd":
			if(isset($_SESSION['repwd_yzm_ok'])&&$_SESSION['repwd_yzm_ok']==1&&isset($_SESSION['repwd_phone'])){
				$phone=$_SESSION['repwd_phone'];
				$query=$db->query("update {$tablepre}members set password='".md5($newpwd)."' where phone='$phone'");
				
				exit("1");
			}
			else{
				exit("验证码错误！");
			}
		break;
		case "setdefvideosrc":
			if(stripos(auth_group($_SESSION['login_gid']),'def_videosrc')!==false)
			$db->query("update {$tablepre}config set defvideo='$vid',defvideonick='$nick' where id='$rid'");
		break;
		case "getsysmsg":
			$data["sysmsg_state"]=$cfg['config']['sysmsg_state'];
			if($cfg['config']['sysmsg_state']=="1"){
				$data["sysmsg_timer"]=$cfg['config']['sysmsg_timer'];
				$data["sysmsg_order"]=$cfg['config']['sysmsg_order'];
				$query=$db->query("select txt from {$tablepre}sysmsg where (rid='{$rid}' or rid='0') and `type`='0' order by id desc");
				$info= array();
				while($row=$db->fetch_row($query)){
					array_push($info,tohtml($row['txt']));
				}
				
				$data["info"]=$info;
			}
			exit($json->encode($data));
		break;
		//私聊聊天记录
		case "mymsgold":
			$uid=$_SESSION['login_uid'];
			$str1='
				<li class="layim_chate[me]"><div class="layim_chatuser"><span class="layim_chattime">[date]</span><span class="layim_chatname">[uname]</span><img src="../face/img.php?t=p1&u=[uid]"></div><div class="layim_chatsay"><font style="color:#000">[msg]</font><em class="layim_zero"></em></div></li>
				';
			$str2='
				<li class="layim_chate[me]"><div class="layim_chatuser"><img src="../face/img.php?t=p1&u=[uid]"><span class="layim_chatname">[uname]</span><span class="layim_chattime">[date]</span></div><div class="layim_chatsay"><font style="color:#000">[msg]</font><em class="layim_zero"></em></div></li>
				';
			$query=$db->query("select *  from {$tablepre}msgs where (uid='$uid' and tuid='$tuid')or(uid='$tuid' and tuid='$uid') and type='0' order by id desc limit 0,20");
			while($row=$db->fetch_row($query)){
				
				if($row['uid']==$uid)
					$str=str_replace("[me]","me",$str1);
				else 
					$str=str_replace("[me]","he",$str2);
				$str=str_replace("[uid]",$row['uid'],$str);
				$str=str_replace("[uname]",$row['uname'],$str);
				$str=str_replace("[msg]",tohtml($row['msg']),$str);
				$str=str_replace("[date]",date("Y-m-d H:i:s",$row['mtime']),$str);
				$msgold=$str.$msgold;
			}
			
			
			$data['realname']=userinfo($tuid,'{realname}');
			$data['kfmsg']=tohtml(userinfo($tuid,'{kfmsg}'));
			$data['tuid']=$tuid;
			$data['msg']=$msgold;
			
			exit($json->encode($data));
		break;
		//屏蔽消息
		case "msgblock":
			$db->query("update {$tablepre}msgs set state='$s' where msgid='$msgid' and state!='2' and state!='3'");
			exit();
		break;
		//我的客服
		case "remyfuser":
			$uid=$_SESSION['login_uid'];
			$tuser=userinfo($_COOKIE['tg'],'{username}');
			if(trim($tuser)!="")
			$db->query("update {$tablepre}members set fuser='$tuser',tuser='$tuser' where fuser='' and tuser='' and uid='$uid'");
		break;
		case "getmylist":
			//exit(print_r($_GET));
			$data['state']='false';
			$uid=$_SESSION['login_uid'];
			$time=gdate();
		
			$db->query("update {$tablepre}members set lastvisit='$time',regip='$onlineip' where uid='{$uid}'");
			
			$userinfo=$db->fetch_row($db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.uid='{$uid}'")); 
			$i=0;
			if($userinfo['gid']!='3'){
				if($userinfo['fuser']=="")$userinfo['fuser']=$cfg['config']['defkf'];
				if($userinfo['fuser']==""){$data['state']='false';}
				else{
					$query=$db->query("select m.*,ms.* from {$tablepre}members m left join {$tablepre}memberfields ms
								  on m.uid=ms.uid   where m.username ='$userinfo[fuser]'");
					while($row=$db->fetch_row($query)){
						$tmp['uid']=$row['uid'];
						$tmp['chatid']=$row['uid'];
						$tmp['nick']=$row['nickname'];
						$tmp['phone']=$row['phone'];
						$tmp['qq']=$row['realname'];
						$tmp['color']=$row['gid'];
						$tmp['mood']=$row['mood'];
						$data['row'][$i++]=$tmp;
						$data['state']='true';
					}
				}
			}else{
				$query=$db->query("select m.*,ms.* from {$tablepre}members m left join {$tablepre}memberfields ms
							  on m.uid=ms.uid   where m.fuser='{$user}' and m.username!='{$user}' order by m.lastvisit desc limit 100");
				while($row=$db->fetch_row($query)){
					$tmp['uid']=$row['uid'];
					$tmp['chatid']=$row['uid'];
					$tmp['nick']=$row['nickname'];
					$tmp['phone']=$row['phone'];
					$tmp['qq']=$row['realname'];
					$tmp['color']=$row['gid'];
					$data['row'][$i++]=$tmp;
					$data['state']='true';
				}
			}
			
			exit($json->encode($data));
		break;
		case "getrlist":
		
		//机器人列表
		$week=date("w");
		$nowday=date("Y-m-d ");
		$nowtime=time();
		$sql="select * from {$tablepre}apps_rebots where weeks like '%".date("w")."%'";
		
		
		$time=time();
		$query=$db->query("select * from {$tablepre}rebots where rid='$rid' and losttime>{$time}");
		if($db->num_rows($query)<=0){
			$roomListUserJsonStr=array("type"=>"UonlineUser","stat"=>"OK");
			$roomListUser=array();
			$roomUser=array("roomid"=>$_SERVER['HTTP_HOST'].".".$rid,"chatid"=>"","ip"=>"0.0.0.0","qx"=>"0","cam"=>"","vip"=>"0","age"=>"null","sex"=>"","mood"=>"","state"=>"0","nick"=>"","color"=>"1");		
			
			$i=0;
			//载入客服机器人
			$query=$db->query($sql);
			$nowtime=gdate();
			$i=0;
			while($row=$db->fetch_row($query)){
				if($i>=$r)break;
				$hl=@strtotime($row['hl']);
				$ol=@strtotime($row['ol']);
				
				if(($hl<$ol&&$nowtime>$hl&&$nowtime<$ol)||($hl>$ol&&($nowtime>$hl||$nowtime<$ol))){
					$roomUser_t=$roomUser;
					$roomUser_t['chatid']='x_r_i'.$row['id'];
					$roomUser_t['sex']=rand(0,2);
					$roomUser_t['cam']=rand(0,2);
					$roomUser_t['nick']=$row['name'];
					$roomUser_t['color']=$row['gid'];
                    $roomUser_t['mood']=$row['img'];
					$roomUser_t['fuser']=$row['fuser'];
					$roomListUser[$i++]=$roomUser_t;
					
				}
			}
			
			//载入系统机器人		
			$query=$db->query("select * from {$tablepre}rebots where id='1'");
			$row=$db->fetch_row($query);
			$rebots_arr=explode("\r\n",$row['rebots']);
			shuffle($rebots_arr);
			
			//$count=count($rebots_arr);		
			for(;$i<50;$i++){
				if($r<=0)break;
				if(trim($rebots_arr[$i])=="")continue;
				$roomUser_t=$roomUser;
				$roomUser_t['chatid']='x_r'.$i;
				$roomUser_t['sex']=rand(0,2);
				$roomUser_t['cam']=rand(0,2);
                $roomUser_t['mood']='/face/rebot/'.rand(1,43).".gif";
				$roomUser_t['nick']=$rebots_arr[$i];
				$roomListUser[$i]=$roomUser_t;
			
				if($i>=$r)break;
			}
			$roomListUserJsonStr['roomListUser']=$roomListUser;
			$data=base64_encode($json->encode($roomListUserJsonStr));
			
			$losttime=time()+60*60;
			$db->query("delete from {$tablepre}rebots where rid='$rid'");
			$db->query("insert into {$tablepre}rebots(rid,rebots,losttime)values('$rid','$data','$losttime')");
		}
		else{
			//获取有效列表
			$row=$db->fetch_row($query);
			$data=$row['rebots'];
		}
		
		exit(base64_decode($data));
	break;
	case "putmsg":
// 		error_reporting(11);
		$state="0";
		if($cfg['config']['msgaudit']=='1'){
			$state='1';
			$gid=$_SESSION['login_gid'];	
			if($gid=='2'||$gid=='3'||$gid=='4'||$gid=='5'){$state="0";}
		}
		
		
		if(stripos(auth_group($_SESSION['login_gid']),'sysmsg')!==false){
			if($msgtip=="2"){$db->query("insert into {$tablepre}sysmsg(txt,rid,`type`) values('$msg','$rid','1')");}
			if($msgtip=="3"){$db->query("insert into {$tablepre}sysmsg(txt,rid,`type`) values('$msg','$rid','2')");}
		}
		
		if(strstr($muid,'x_r_i')){
			$r=@$db->fetch_row($db->query("(select gid from {$tablepre}apps_rebots where id='".str_replace('x_r_i','',$muid)."')"));
			$ugid=$r[gid];
			$gid=$ugid;
			if($gid=='2'||$gid=='3'||$gid=='4'||$gid=='5'){$state="0";}
		}else if(strstr($muid,'x_r'))$ugid='0';
		else $ugid=$_SESSION[login_gid];
		$zz = $cfg['config']['msgban'];
		if(preg_match("/{$zz}/is", $msg)){
			$state='1';$gid=$_SESSION['login_gid'];if($gid=='2'||$gid=='3'||$gid=='4'||$gid=='5'){$state="0";}
		}
		$sql="insert into {$tablepre}msgs(rid,uid,tuid,uname,tname,p,style,msg,mtime,ugid,msgid,ip,state)
				  values('$rid','$muid','$tid','$uname','$tname','$privacy','$style','$msg',".gdate().",'$ugid','$msgid','$onlineip','$state')";
// 		echo $sql;var_dump($muid); die('dddd fs ');
	  	$db->query($sql);
	break;
	case "regcheck":
			$guestexp = '^Guest|'.$cfg['config']['regban']."Guest";
			if(preg_match("/\s+|{$guestexp}/is", $username))
			exit('-1');
			
			if($db->num_rows($db->query("select * from {$tablepre}members where username='$username' "))>0)exit('0');
			else exit('1');
	break;
	case "setvideo":
		$uid=$_SESSION['login_uid'];
		if(check_auth('room_admin')){
		$db->query("update {$tablepre}config set defvideo='{$vid}' where id='{$def_cfg}'");
		}
	break;
	case "userstate":
		if(isset($_SESSION['login_uid']))
		{
			$userstate['state']="login";
			$id=$_SESSION['login_uid'];
			$query=$db->query("select m.uid,m.sex,m.onlinetime,m.gold,ms.nickname,ms.mood,ms.city,ms.bday
						  from {$tablepre}members m,{$tablepre}memberfields ms
						  where m.uid=ms.uid and m.uid='{$id}'
						  ");
  			$row=$db->fetch_row($query);
			$userinfo['id']	 =$row['uid'];
			$userinfo['nick']=$row['nickname'];
			$userinfo['sn']=$row['mood'];
			$userinfo['rank']=showstars($row['onlinetime']);
			$userinfo['gold']=$goldname.':'.$row['gold'];
			$userstate['info']=$userinfo;
			
		}
		else
		{
			$userstate['state']="logout";
		}
		$data=$json->encode($userstate);
		exit($data);
	break;
	case "userinfo":
		$query=$db->query("select m.*,ms.*
						  from {$tablepre}members m,{$tablepre}memberfields ms
						  where m.uid=ms.uid and m.uid='{$id}'
						  ");
  		$row=$db->fetch_row($query);
		$row['password']='';
		$data=$json->encode($row);
		exit($data);
	break;
	case "delimpression":
		if(!isset($_SESSION['login_uid'])||$_SESSION['login_uid']==0)
		$state['state']='logout';
		else
		{
			$uid=$_SESSION['login_uid'];
			$db->query("delete from {$tablepre}membersapp1 where uid='$uid' and fuid='$fuid' and ftime='$ftime'");
			$state['state']='ok';
		}
		$data=$json->encode($state);
		exit($data);
	break;
	case "impression":
		if(!isset($_SESSION['login_uid'])||$_SESSION['login_uid']==0)
		$state['state']='logout';
		else
		{
			$color=rand_color();
			$time=gdate();
			$fuid=$_SESSION['login_uid'];
			$db->query("delete from {$tablepre}membersapp1 where uid='$uid' and fuid='$fuid'");
			$sql="insert into {$tablepre}membersapp1(uid,color,txt,fuid,ftime)
				  values('$uid','$color','$t','$fuid','$time')";
	  		$db->query($sql);
	  		$state['state']='ok';
		}
		$data=$json->encode($state);
		exit($data);
	break;
	case "memberfriends":
		if(!isset($_SESSION['login_uid']))
		$state['state']='logout';
		else
		{
		$ftime=gdate();
		$uid=$_SESSION['login_uid'];
		if(isset($a))$db->query("replace into {$tablepre}membersapp3(uid,fuid,ftime)values('$uid','$a','$ftime')");
		if(isset($d))$db->query("delete from {$tablepre}membersapp3 where uid='$uid' and fuid='$d'");
		$state['state']='ok';
		}
		$data=$json->encode($state);
		exit($data);
	break;
	case "message":
		if(!isset($_SESSION['login_uid'])||$_SESSION['login_uid']==0)
		$state['state']='logout';
		else
		{
			if(isset($d))
			{
			$db->query("delete from {$tablepre}membersapp4 where id='$d' and uid='$_SESSION[login_uid]'");
			$state['state']='ok';
			}
			else{
			if(trim($txt)!=''){
				$txt=$db->totxt($txt);
				$ftime=gdate()-2;
				$fuid=$_SESSION['login_uid'];
				$db->query("insert into {$tablepre}membersapp4(uid,fuid,ftime,tag,txt)values('$uid','$fuid','$ftime','$tag','$txt')");
				}
			$state['state']='ok';
			}
		}
		$data=$json->encode($state);
		exit($data);
		
	break;
	case "kick":
		if(check_user_auth($aid,'user_kick')){
			$losttime=$ktime*60+gdate();
			$db->query("insert into {$tablepre}ban(username,ip,losttime,sn)values('$u','$onlineip','$losttime','$cause')");
			$state['state']='yes';
			$data=$json->encode($state);
			exit($data);
		}
		
	break;
	case "online":
		if(!isset($_SESSION['login_uid']))
		$state['state']='logout';
		else
		{
			if($_SESSION['login_uid']==0){$state['state']='ok';$data=$json->encode($state);exit($data);}
			$rst=(int)$_SESSION['login_time'];
			if($rst>0){
				$time=gdate();
				$u_id=$_SESSION['login_uid'];
				$_time=(int)($time-$rst);
				$rid=$_SESSION['onlines_state']['rid'];
				
				$db->query("update {$tablepre}memberonlines set lastactivity='$time' where uid='$u_id'");
				$db->query("update {$tablepre}members set lastactivity='$time',onlinetime=onlinetime+$_time where uid='$u_id'");
				$state['state']='ok';
				
			}
			else
			{
				
				reonline();
				$state['state']='ok';
			}
			
		}
		$_SESSION['login_time']=gdate();
		$data=$json->encode($state);
		exit($data);
		
	break;
}

?>