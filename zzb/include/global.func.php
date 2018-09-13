<?php 
if(!defined('IN_PPCHAT')) {
	exit('Access Denied');
}

function getrobot() {
	if(!defined('IS_ROBOT')) {
		$kw_spiders = 'Bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla';
		$kw_browsers = 'MSIE|Netscape|Opera|Konqueror|Mozilla';
		if(preg_match("/($kw_browsers)/i", $_SERVER['HTTP_USER_AGENT'])) {
			define('IS_ROBOT', FALSE);
		} elseif(preg_match("/($kw_spiders)/i", $_SERVER['HTTP_USER_AGENT'])) {
			define('IS_ROBOT', TRUE);
		} else {
			define('IS_ROBOT', FALSE);
		}
	}
	return IS_ROBOT;
}
function daddslashes($string, $force = 0) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(1) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
            if(!MAGIC_QUOTES_GPC || $force) {
                $string = addslashes($strip ? stripslashes($string) : $string);
            }
            if(strpos($_SERVER['PHP_SELF'],'adminv3')===false)$string=filterVar($string);
		}
	}

	return $string;
}
function filterVar($str){
    $str=strip_tags(tohtml($str),'<img><br><p><font><span>');
    $str= preg_replace("/(exec)|(FROM)|(select)|(create)|(update)|(delete)|(insert)|(load_file)|(outfile)|(char)|(union)|(script)|(on([a-z]+)\s*=)|(eval)|(frame)|(data:text)/i","·$0·",$str);
    return $str;
}
function keyED($txt,$encrypt_key) { 
$encrypt_key = md5($encrypt_key); 
$ctr=0; 
$tmp = ""; 
for ($i=0;$i<strlen($txt);$i++){ 
if ($ctr==strlen($encrypt_key)) $ctr=0; 
$tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1); 
$ctr++; 
} 
return $tmp; 
} 

function encrypt($txt,$key){ 
srand((double)microtime()*1000000); 
$encrypt_key = md5(rand(0,32000)); 
$ctr=0; 
$tmp = ""; 
for ($i=0;$i<strlen($txt);$i++){ 
if ($ctr==strlen($encrypt_key)) $ctr=0; 
$bbb=substr($encrypt_key,$ctr,1) . 
(substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1)); 
$tmp.= $bbb; 
$ctr++; 
} 
return base64_encode(keyED($tmp,$key)); 
} 

function decrypt($txt,$key){ 
$txt=base64_decode($txt); 
$txt = keyED($txt,$key); 
$tmp = ""; 
for ($i=0;$i<strlen($txt);$i++){ 
$md5 = substr($txt,$i,1); 
$i++; 
$tmp.= (substr($txt,$i,1) ^ $md5); 
} 
return $tmp; 
}
function connectkey(){
	global $tserver_key;
	return encrypt($_SERVER['HTTP_HOST'],$tserver_key);
}
function dhtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
		//$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
		str_replace(array('&',"'",'"', '<', '>'), array('&amp;','&apos;','&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}
function tohtml($str){
	return str_replace(array('&amp;','&apos;','&quot;', '&lt;', '&gt;'), array('&',"'", '"', '<', '>'),$str);
}
function showstars($totalol) {
	global $upgrade;
	$starthreshold=4;
	$onlinetime_total=round($totalol / 60/60, 2);
	$num=@ceil(($onlinetime_total + 1) / $upgrade);
	
	//$num--;
	if($onlinetime_total>24)
	{
		$d=floor($onlinetime_total/24);
		$onlinetime_total=$onlinetime_total-$d*24;
		$d.="天 ";
	}
	$alt = 'title="等级: '.$num.' (在线:'.round($totalol / 60/60, 2).'小时)"';
	$str='';
	if(empty($starthreshold)) {
		for($i = 0; $i < $num; $i++) {
			$str.="<img src=\"./images/star_level1.gif\" {$alt}/>";
		}
	} else {
		for($i = 3; $i > 0; $i--) {
			$numlevel = intval($num / pow($starthreshold, ($i - 1)));
			$num = ($num % pow($starthreshold, ($i - 1)));
			for($j = 0; $j < $numlevel; $j++) {
			$str.="<img src=\"./images/star_level{$i}.gif\" {$alt}/>";
			}
		}
	}
	
	return $str;
}
function gdate(){
	global $timeoffset;
	return time()+$timeoffset;
}
function isemail($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}
#分页函数
#Editor:xianlin E-Mial:xianlin85@163.com
#$totle总条数,$displaypg limit条数,$url可以为空
#使用:
/**********************************************************
$count=$db->sqlnum($db->query($sql));
pageft($count,15,"");
$re=$db->query($sql." limit $firstcount,$displaypg");
#想必不用多说了!

#echo $pagenav //为"共0页 首页 上一页 下一页 尾页共0条,0页"
***********************************************************/
if(!function_exists(pageft)){ 
function pageft($totle,$displaypg=20,$url){
	global $firstcount,$_GET,$db,$pagenav,$_SERVER;
	$GLOBALS["displaypg"]=$displaypg;
	$page=1;
	if(isset($_GET['page']))
	{
	$page=$db->fhtml($_GET['page']);
	if($page<=1){$up=1;$firstcount=0;$down=2;}
	else {$down=$page+1;$firstcount=($page-1)*$displaypg;$up=$page-1;}
	
	}
	else {$up=1;$down=2;$firstcount=0;}
	$count=ceil($totle/$displaypg);
	if($down>$count)$down=$count;
	
	if($url==''){ $url=$_SERVER["REQUEST_URI"];}
	$parse_url=parse_url($url);
	$url=$parse_url["path"]."?".ereg_replace("(^|&)page=[0-9]+","",$parse_url["query"]); 
	$pagenav="共{$count}页 <a href='{$url}'>首页</a> <a href='{$url}&page={$up}'>上一页</a> <a href='{$url}&page={$down}'>下一页</a> <a href='{$url}&page={$count}'>尾页</a>";
	$pagenav.=" 共{$totle}条　跳转到 <input name='p' id='p'   value='{$page}'  style='width:40px;'/> 页 <a href='###' onclick=\"location.href='{$url}&page='+document.getElementById('p').value\">确定</a>";

}
}
//房间列表 房间分类$cid 显示房间数$num 列表模板$tpl   显示分页标签$displaypg
function roomlist($cid,$t,$num,$tpl,$skey=""){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}room where 1=1";
	if($cid!=0)$sql.=" and cid='$cid'";
	if($t!=0) $sql.=" and t='$t'";
	if($skey!="")$sql.=" and name like '%$skey%'";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by cid,`order` limit $firstcount,$displaypg";
	$query=$db->query($sql);
	
	return for_each($query,$tpl);
}
//分类类别列表 内嵌房间列表 分类ID $cid 列表显示数$num 分类模板$ctpl 房间模板 $rtpl 显示分页标签$displaypg
function classroomlist($cid,$num,$ctpl,$rtpl,$skey=""){
	global $db,$tablepre,$firstcount,$displaypg;
	$csql="select * from {$tablepre}roomclass where 1=1";
	if($cid!=0)$csql.=" and id='$cid'";
	
	$count=$db->num_rows($db->query($csql));
	pageft($count,$num,"");
	
	$csql.=" order by `order` limit $firstcount,$displaypg";
	$query=$db->query($csql);
	while($row=$db->fetch_row($query)){
			$t=$ctpl;
			foreach($row as $key=>$value){
			$t=str_replace('{'.$key.'}',$value,$t);	
			}
			if($rtpl!='')
			$t=str_replace('{roomlist}',roomlist($row['id'],0,$num,$rtpl,$skey),$t);
	$str.=$t;
	}
	return $str;
}
//礼物分类列表 内嵌礼物列表 分类ID $cid 列表显示数$num 分类模板$ctpl 房间模板 $rtpl 显示分页标签$displaypg
function classgiftlist($cid,$num,$ctpl,$rtpl="",$skey=""){
	global $db,$tablepre,$firstcount,$displaypg;
	$csql="select * from {$tablepre}gift_class where 1=1";
	if($cid!=0)$csql.=" and id='$cid'";
	$csql.=" order by `order` desc";
	$query=$db->query($csql);
	while($row=$db->fetch_row($query)){
			$t=$ctpl;
			foreach($row as $key=>$value){
			$t=str_replace('{'.$key.'}',$value,$t);	
			}
			if($rtpl!='')
			$t=str_replace('{giftlist}',giftlist($row['id'],0,$num,$rtpl,$skey),$t);
	$str.=$t;
	}
	return $str;
}

//礼物列表 房间分类$cid 推荐$t 显示房间数$num 列表模板$tpl   显示分页标签$displaypg
function giftlist($cid,$t,$num,$tpl,$skey=""){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select * from {$tablepre}gift_goods where 1=1";
	if($cid!=0)$sql.=" and cid='$cid'";
	if($t!=0) $sql.=" and t='$t'";
	if($skey!="")$sql.=" and name like '%$skey%'";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by id desc limit $firstcount,$displaypg";
	$query=$db->query($sql);
	
	return for_each($query,$tpl);
}

//用户礼物列表 用户ID$sid $t类型（送出0、收到1）显示条数$num 列表模板$tpl   显示分页标签$displaypg
function ugiftlist($sid,$t,$num,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select glist.*,gift.name,gift.price,u.nickname as snickname,u.uid  as suid from {$tablepre}gift_goods gift,{$tablepre}gift_list glist,{$tablepre}memberfields u where gift.id=glist.gid";
	if($t!=0){
		if($sid!=0)
		$sql.=" and glist.sid='$sid' and glist.uid=u.uid";
		else $sql.=" and glist.uid=u.uid";
	}
	else {
		if($sid!=0)
		$sql.=" and glist.uid='$sid' and glist.sid=u.uid";
		else
		$sql.=" and glist.sid=u.uid";
	}
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
		$sql.=" order by glist.id desc limit $firstcount,$displaypg";
	$query=$db->query($sql);
	
	return for_each($query,$tpl);
}
function sendgift($num,$gid,$sid,$msg){
	global $db,$tablepre,$onlineip,$discount;
	$msg=$db->totxt($msg);
	if($num<=0)return "0";//没有该物品
	$uid=$_SESSION['login_uid'];
	$ugold=(int)userinfo($uid,'{gold}');
	if($ugold<=0)return "-1";//金币不足
	$msg=$db->totxt($msg);
	$query=$db->query("select * from {$tablepre}gift_goods where id='$gid'");
	while($row=$db->fetch_row($query)){
		$tprice=$num*$row['price'];
		if($ugold>=$tprice){
			$db->query("update {$tablepre}members set gold=gold-$tprice where uid='$uid'");//扣除金币
			$db->query("insert into {$tablepre}gold_log(uid,gold,ip,dateline,txt)values('$uid','-{$tprice}','$onlineip','".gdate()."','赠送礼物:{$gid}|送给:{$sid}|份数:{$num}|价值:{$tprice}|还剩:".($ugold-$tprice)."')");//添加金币变更记录
			$db->query("insert into {$tablepre}gift_list(gid,uid,sid,msg,dateline,num)values('$gid','$uid','$sid','$msg','".gdate()."','$num')");//加入购买列表
			$db->query("update {$tablepre}members set gold=gold+".$tprice*$discount." where uid='$sid'");//礼物兑换成金币
			$db->query("update {$tablepre}gift_goods set sale=sale+$num where id='$gid'");//增加物品销售数
			return "1";
		}
		else return "-1";//金币不足
	}
	return "0";//没有该物品
}
function getUserInfo($uid){
	global $db,$tablepre;
	$query=$db->query("select m.*,ms.*
						  from {$tablepre}members m,{$tablepre}memberfields ms
						  where m.uid=ms.uid and m.uid='{$uid}'
						  ");
	return $db->fetch_row($query);
}
function randomCs($rid){
	global $db,$tablepre;
	$query=$db->query("select m.*,ms.*
						  from {$tablepre}members m,{$tablepre}memberfields ms
						  where m.uid=ms.uid and m.rid='{$rid}' and m.gid='4' order by rand() limit 1
						  ");
	return $db->fetch_row($query);
}

//显示用户信息 用户id $uid
function userinfo($uid,$tpl){
	global $db,$tablepre;
	if($uid=="")return "";
	$query=$db->query("select m.*,ms.*
						  from {$tablepre}members m,{$tablepre}memberfields ms
						  where m.uid=ms.uid and m.uid='{$uid}'
						  ");
	
	return for_each($query,$tpl);
}
function user_info($username,$tpl){
	global $db,$tablepre;
	if($username=="")return "";
	$query=$db->query("select m.*,ms.*
						  from {$tablepre}members m,{$tablepre}memberfields ms
						  where m.uid=ms.uid and m.username='{$username}'
						  ");
	
	return for_each($query,$tpl);
}
function userlist($num,$sql,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);
	
}
//最新活跃会员
function onlineuser($num,$timestamp,$tpl,$skey="",$goldorder="lastactivity",$sex=""){
	global $db,$tablepre,$firstcount,$displaypg;
	$time=gdate();
	$sql="select uid from {$tablepre}members where uid!=0";
	if($timestamp!=0)$sql.=" and lastactivity+$timestamp>$time";
	if($skey!="")$sql.=" and (username like '%$skey%' or fuser like '%$skey%' or tuser like '%$skey%' or uid in(select uid from {$tablepre}memberfields where  nickname like '%$skey%'))";
	if($sex!="")$sql.=" and sex='$sex'";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	if($goldorder=='1')$goldorder="gold";
        if($goldorder!="0")
        $sql.=" order by `{$goldorder}` desc ";
        $sql.=" limit $firstcount,$displaypg";
	$query=$db->query($sql);
	while($row=$db->fetch_row($query)){
			$t=$tpl;
			$t=userinfo($row['uid'],$t);
			$str.=$t;
		}
	return $str;
}

function rand_color(){       
    for($a=0;$a<6;$a++){    //采用#FFFFFF方法，       
        $d .= dechex(rand(0,15));//累加随机的数据--dechex()将十进制改为十六进制       
    }       
    return '#'.$d;       
}
//输出印象词条
function impression($uid,$type,$tpl){
	global $db,$tablepre;
	if($type==1) {$where=" and uid='$uid'"; $where1="ftime desc";}else $where1='rand()';
	$query=$db->query("select *,count(*) c from {$tablepre}membersapp1 where (fuid in(select sex from {$tablepre}members where uid='$uid') or fuid=2 or uid='$uid') $where group by txt order by {$where1} limit 20");
	return for_each($query,$tpl);
}
//最近访客
function membervisit($uid,$num,$tpl){
	global $db,$tablepre;
	$sql="select ms.*,app.fuid,app.ftime from {$tablepre}memberfields ms,{$tablepre}membersapp2 app where ms.uid=app.fuid and app.uid='$uid' order by ftime desc limit $num";
	$query=$db->query($sql);
	return for_each($query,$tpl);
}
//好友列表
function memberfriends($uid,$num,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select ms.*,ms.uid fuid,m.lastactivity from {$tablepre}memberfields ms,{$tablepre}members m where ms.uid=m.uid and m.uid in(select fuid from {$tablepre}membersapp3 where uid='$uid')";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by m.lastactivity desc limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);
}
//留言
function message($uid,$num,$tpl){
	global $db,$tablepre,$firstcount,$displaypg;
	$sql="select ms.*,app.id,app.uid as m_uid,app.fuid,app.ftime,app.tag,app.txt from {$tablepre}memberfields ms,{$tablepre}membersapp4 app where app.uid='$uid' and app.fuid=ms.uid";
	$count=$db->num_rows($db->query($sql));
	pageft($count,$num,"");
	$sql.=" order by app.ftime desc limit $firstcount,$displaypg";
	$query=$db->query($sql);
	return for_each($query,$tpl);
}
function for_each($query,$tpl){
	global $db,$tablepre;
	while($row=$db->fetch_row($query)){
		$t=$tpl;
		$row['txt']=$db->totxt($row['txt']);
		if($row['color']=='')$row['color']=rand_color();
		$row['_sex']=$row['sex'];
		$sex=array("女","男","保密");
		$row['sex']=$sex[$row['sex']];
		$row['showstars']="";
		
		//$row['showstars']=showstars($row['onlinetime']);
		$row['nowtime']=gdate();
		$row['dateline1']=date("Y-m-d H:i:s",$row['dateline']);
		$row['vip_level']="0";
		if($row['vip_expire']!='0'){
			$tmp=explode('-',$row['vip_expire']);
			if((int)$tmp[1]>gdate())$row['vip_level']=$tmp[0];
		}
		foreach($row as $key=>$value){
			$t=str_replace('{'.$key.'}',$value,$t);	
		}
	$str.=$t;
	}
	return $str;
}

function roomadmin($uid)
{
	global $db,$tablepre;	
	if($db->num_rows($db->query("select uid from {$tablepre}members where uid='$uid' and priv='1'"))>0){
		$query=$db->query("select id from {$tablepre}room");
		$i=0;
		while($row=$db->fetch_row($query)){
			$t[$i++]=$row[0];
			}
			return $t;
	}
	
	$query=$db->query("select rids from {$tablepre}roomadmin where uid='$uid' limit 1");
	while($row=$db->fetch_row($query))
	{
		return explode(',',$row['rids']);
	}
	return array();
}
function isonline($uid)
{	
	global $db,$tablepre;
	$time=gdate();
	$isonline=false;
	$str="离线";
	$query=$db->query("select * from {$tablepre}members where lastactivity>$time-70 and uid='$uid'");
	if($db->num_rows($query)>0){$isonline=true;$str="在线";}
	
	$query=$db->query("select a.* from {$tablepre}room a,{$tablepre}memberonlines b where a.id=b.rid and b.uid='$uid'");
	
	while($row=$db->fetch_row($query))
	{
		if($isonline){$str="聊天中";$str.='(<a href="javascript:void(0);" onclick=\'window.open("/?rid='.$row['id'].'","room","width="+screen.availWidth+",height="+screen.availHeight)\'>'.$row['name'].'</a>)';}
		
	}
	return $str;
}
function reonline()
{
	global $db,$tablepre,$u_id;
	$time=gdate();
	if(!isset($_SESSION['onlines_state']['time']))
	{
		$_SESSION['onlines_state']['time']=$time;
		$db->query("update {$tablepre}members set lastactivity=$time where uid='$u_id'");
	}
	$query_row=$db->fetch_row($db->query("select lastactivity from {$tablepre}members where uid='$u_id'"));
	$_time=(int)($time-$query_row['lastactivity']);
	
	$db->query("delete from {$tablepre}memberonlines where lastactivity<$time-600");
	$db->query("update {$tablepre}members set lastactivity='$time' where uid='$u_id'");
}
function gusetLogin(){
	global $db,$tablepre,$onlineip,$cfg;
	if(user_login($_COOKIE['guest'],'123123')!==true){
		newGuest();
		return true;
	}
	return true;
}
function newGuest(){
	global $db,$tablepre,$onlineip,$cfg;
	$guest="游客".substr(strtoupper(md5(uniqid(mt_rand(1000,9999)))),0,10);
	$regtime=gdate();
	$p=md5('123123');
	
	$db->query("insert into {$tablepre}members(username,password,sex,email,regdate,regip,lastvisit,lastactivity,gold,realname,gid,phone,state)	
	values('$guest','$p','2','','$regtime','$onlineip','$regtime','$regtime','0','0','2','0','1')");
	
	$uid=$db->insert_id();
	$db->query("update {$tablepre}members set username='u{$uid}' where uid='{$uid}'");
	$db->query("replace into {$tablepre}memberfields (uid,nickname,uface)	values('$uid','$guest','/face/rebot/".rand(10,40).".gif')	");
	$_SESSION['login_uid']=$uid;
	$_SESSION['login_user']='u'.$uid;
	$_SESSION['login_nick']=$guest;
	$_SESSION['login_gid']='0';
	$_SESSION['login_sex']='2';
	setcookie("guest", 'u'.$uid, gdate()+315360000,"/");
	$_COOKIE['guest']='u'.$uid;
	
	return $uid;
}
function user_login($u,$p){
	global $db,$tablepre,$onlineip,$cfg;
	
	$query=$db->query("select * from {$tablepre}members where username='$u' and password='".md5($p)."'");
	while($row=$db->fetch_row($query)){
		if($cfg['config']['regaudit']=='1'&&$row['state']=='0')
		return "用户未审核！";
		
		$_SESSION['login_uid']=$row['uid'];
		$_SESSION['login_user']=$row['username'];
		$_SESSION['login_nick']=$row['username'];
		$_SESSION['login_gid']=$row['gid'];
		$_SESSION['login_sex']=$row['sex'];
		$time=gdate();
		$_SESSION['onlines_state']['time']=$time;
		$db->query("update {$tablepre}members set lastvisit=lastactivity,regip='$onlineip' where uid='{$row[uid]}'");
		$db->query("update {$tablepre}members set lastactivity=$time where uid='{$row[uid]}'");
		$db->query("update {$tablepre}memberfields set logins=logins+1 where uid='{$row[uid]}'");
		$db->query("insert into  {$tablepre}msgs(rid,ugid,uid,uname,tuid,tname,mtime,ip,msg,`type`)
	values('{$cfg[config][id]}','{$row[gid]}','{$row[uid]}','{$row[username]}','{$cfg[config][defvideo]}','{$cfg[config][defvideonick]}','".gdate()."','{$onlineip}','用户登陆','1')
		");
		return true;
	}
	return "用户名或密码错误！";
}
function user_login_oauth($token){
	global $db,$tablepre,$onlineip,$cfg;
	$query=$db->query("select * from {$tablepre}members where uid=(select uid from {$tablepre}members_oauth where token='{$token}' limit 1 )");
	while($row=$db->fetch_row($query)){
		if($cfg['config']['regaudit']=='1'&&$row['state']=='0')
		return "用户未审核！";
		
		$_SESSION['login_uid']=$row['uid'];
		$_SESSION['login_user']=$row['username'];
		$_SESSION['login_nick']=$row['username'];
		$_SESSION['login_gid']=$row['gid'];
		$_SESSION['login_sex']=$row['sex'];
		$time=gdate();
		$_SESSION['onlines_state']['time']=$time;	
		
		$db->query("update {$tablepre}members set lastvisit=lastactivity,regip='$onlineip' where uid='{$row[uid]}'");
		$db->query("update {$tablepre}members set lastactivity=$time where uid='{$row[uid]}'");
		$db->query("update {$tablepre}memberfields set logins=logins+1 where uid='{$row[uid]}'");
		$db->query("insert into  {$tablepre}msgs(rid,ugid,uid,uname,tuid,tname,mtime,ip,msg,`type`)
	values('{$cfg[config][id]}','{$row[gid]}','{$row[uid]}','{$row[username]}','{$cfg[config][defvideo]}','{$cfg[config][defvideonick]}','".gdate()."','{$onlineip}','用户登陆','1')
		");
		return true;
	}
	return false;
}
function user_reg_oauth($openid,$usernick,$uimg){
	global $db,$tablepre,$onlineip,$cfg,$ipmax;
	$p=md5($openid);
	$regtime=gdate();
	$p=md5($p);
	if(isset($_COOKIE['tg']));
	$tuser=userinfo($_COOKIE['tg'],'{username}');
	if($cfg['config']['regaudit']=='1')$state='0';
	else $state='1';
	
	$db->query("insert into {$tablepre}members(username,password,sex,email,regdate,regip,lastvisit,lastactivity,gold,realname,gid,phone,fuser,tuser,state)	
	values('$openid','$p','2','$email','$regtime','$onlineip','$regtime','$regtime','0','$qq','1','$phone','$tuser','$tuser','$state')");
	$uid=$db->insert_id();
	$db->query("replace into {$tablepre}memberfields (uid,nickname)	values('$uid','$usernick')	");
	$db->query("delete from {$tablepre}members_oauth where token='$openid'");
	$db->query("insert into {$tablepre}members_oauth(uid,token,app,img)values('$uid','$openid','qq','$uimg')");
	$db->query("update {$tablepre}members set username='{$uid}' where uid='{$uid}'");
	//$img=@file_get_contents($uimg);
	//@file_put_contents(PPCHAT_ROOT."/face/p1/{$uid}.gif",$img);
	return user_login_oauth($openid);
}
function group_info($gid){
	global $db,$tablepre;
	$sql="select * from {$tablepre}auth_group where id ='$gid' limit 1";
	$query=$db->query($sql);
	while($row=$db->fetch_row($query)){
		return $row;
	}
	return NULL;
}
function auth_group($gid){
	global $db,$tablepre;
	
	$sql="select rules from {$tablepre}auth_group where id ='$gid' limit 1";
	$query=$db->query($sql);
	while($row=$db->fetch_row($query)){
		return $row[rules];
	}
	return NULL;
}
function check_auth($auth){
	$auth_rules=auth_group($_SESSION['login_gid']);
	if(stripos($auth_rules,$auth)!==false)return true;
	return false;
}
function check_user_auth($uid,$auth){
	$auth_rules=auth_group(userinfo($uid,'{gid}'));
	if(stripos($auth_rules,$auth)!==false)return true;
	return false;
}
/*移动端判断*/
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        //return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}
?>