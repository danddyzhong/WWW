<?php
require_once '../../include/common.inc.php';
if($_GET['rid']==""){
    if($_COOKIE["rid"]!=""){
        $rid=$_COOKIE['rid'];
    }else{
        $rid=1;
    }
}else{
    $rid=$_GET['rid'];
    $_COOKIE["rid"]=$_GET['rid'];
    setcookie("rid", $rid, gdate()+315360000,'/');
}


$cfg['config']=$db->fetch_row($db->query("select * from {$tablepre}config where id='{$rid}'"));
if(empty($cfg['config'])){
    header("location:/room/error.php?msg=您选择的房间不存在");
}

if(!isset($_SESSION['login_uid'])&&$_COOKIE["ppchat_user"]!=""&&$_COOKIE["ppchat_user_pwd"]!=""){
    user_login($_COOKIE["ppchat_user"],$_COOKIE["ppchat_user_pwd"]);
}
if($cfg['config']['loginguest']=='0'&&$_SESSION['login_gid']<=0)header('location:/room/minilogin.php?rid='.$rid);
require_once PPCHAT_ROOT.'/include/json.php';
$json=new JSON_obj;
//房间状态
if($cfg['config']['state']=='2' and $_SESSION['room_'.$cfg['config']['id']]!=true){header("location:/room/login.php?1");exit();}
if($cfg['config']['state']=='0'){exit("<script>location.href='/room/error.php?msg=系统处于关闭状态！请稍候……'</script>");exit();}
//游客登录
if(!isset($_SESSION['login_uid']) and $cfg['config']['loginguest']=="1"){gusetLogin();}
//是否登录
if(!isset($_SESSION['login_uid'])){exit("<script>location.href='/room/minilogin.php'</script>");exit();}

$uid=$_SESSION['login_uid'];
$time=gdate();

//分配客服并获取客服信息
$db->query("delete from {$tablepre}cs where fid=0");
$mykf=getUserInfo($_COOKIE['tg']);

$query=$db->query("select * from  {$tablepre}cs where rid='{$cfg[config][id]}' and uid='{$uid}'");

if($db->num_rows($query)<1){
    if($mykf['uid']==""){
        $mykf=randomCs($cfg[config][id]);
        $db->query("delete from {$tablepre}cs where rid='{$cfg[config][id]}' and uid='{$uid}'");
        $db->query("insert into {$tablepre}cs(rid,uid,fid)values('{$cfg[config][id]}','{$uid}','{$mykf[uid]}')");
        setcookie("tg", $mykf[uid], gdate()+315360000,'/');
    }else{
        $db->query("insert into {$tablepre}cs(rid,uid,fid)values('{$cfg[config][id]}','{$uid}','{$mykf[uid]}')");
        setcookie("tg", $mykf[uid], gdate()+315360000,'/');
    }
}else{
    $kft=$db->fetch_row($query);
    $mykf=getUserInfo($kft['fid']);
    if(!$mykf){
        $mykf=randomCs($cfg[config][id]);
        $db->query("delete from {$tablepre}cs where rid='{$cfg[config][id]}' and uid='{$uid}'");
        $db->query("insert into {$tablepre}cs(rid,uid,fid)values('{$cfg[config][id]}','{$uid}','{$mykf[uid]}')");
    }
    setcookie("tg",$mykf['uid'], gdate()+315360000,'/');$_COOKIE['tg']=$mykf['uid'];

}

//用户信息		
$db->query("update {$tablepre}members set lastvisit='$time',regip='$onlineip',rid='{$cfg[config][id]}' where uid='{$uid}' and gid!='3'");
$userinfo=getUserInfo($uid);
$_SESSION['login_gid']=$userinfo['gid'];

//黑名单
$query=$db->query("select * from {$tablepre}ban where (username='{$userinfo[username]}' or ip='{$onlineip}') and losttime>".gdate()." limit 1");
while($row=$db->fetch_row($query)){
    exit("<script>location.href='/room/error.php?msg=用户名或IP受限！过期时间".date("Y-m-d H:i:s",$row['losttime'])."'</script>");exit();
}
//允许组
if(!in_array($userinfo['gid'],@explode(',',$cfg['config']['acl']))){exit("<script>location.href='/room/error.php?id={$rid}&msg=您所在组没有房间访问权限！'</script>");exit();}

//用户组
$re = $db->query("select * from {$tablepre}auth_group order by ov desc");
while($row=$db->fetch_row($re)){
    $groupli.="<div id='group_{$row[id]}' class='group'></div>";
    $grouparr.="grouparr['{$row[id]}']=".json_encode($row).";\n";
    $group["m".$row[id]]=$row;
}
//聊天历史记录
$re = $db->query("select * from {$tablepre}msgs where rid='".$cfg['config']['id']."' and p='false' and state!='1' and `type`='0'    order by id desc limit 20 ");

while($row=$db->fetch_row($re)){
    $row['msg']=tohtml($row['msg']);
    $who=" notmine";
    if($row[ugid]=='2'||$row[ugid]=='5'){$who.=' manage';}
    else if($row[ugid]=='3'||$row[ugid]=='4'){$who.=' teacher';}
    if($row[uid]==$uid)$who=" notmine ";



    if($row[tuid]!="ALL")$row[msg]="@$row[tname] ".$row[msg];
    if($row[tname]=="hongbao"){$who.=' hongbaomsg';$row[msg]='<div class="redbag-top" title="'.$row[msg].'" data-hid="'.$row[msgid].'" onclick="getHongBao($(this).data(\'hid\'))"><div class="fl"><img src="/room/images/hongbao.png" style="margin-top: 3px;"></div><div class="fl ml10" style="color:#fff;"><p style="font-weight:bold;margin-bottom:4px;color:#f30;font-size:13px;">'.$row[msg].'</p>领取红包</div></div><div style="padding:3px 10px;background: #fff;color: #333;">直播室红包</div>';}
    if($row[tname]=="gift"){$who.=' system';}
    if($row[tname]=="gethongbao"){
        $omsg='<div class="message-wrap"><div class="redbag-info1"><p style="color:#333;">'.$row['uname'].' 领取了 <span style="color:red;">'.$row['style'].'</span> 的红包 <span style="color:red;">'.$row['msgid'].'元</span></p></div><div class="clear"></div></div>'.$omsg;
        continue;
    }
    $omsg='<div class="chat-item '.$who.'"  ><div class="user-img"> <div class="uimg"><img src="/face/img.php?t=p1&u='.$row[uid].'"/></div><div class="gimg"><img src="'.$group["m".$row[ugid]][ico].'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name"  onclick="ToUser.set(\''.$row[uid].'\',\''.$row[uname].'\')">'.$row[uname].'</span> <span class="chat-time">'.date('H:i:s',$row[mtime]).'</span></div><div class="chat-info-2"> <div class="chat-msg">'.$row[msg].'</div></div></div></div>'.$omsg;
}
$omsg.='<li class="history-hr-wrap"><div class="history-hr"></div><div class="history-hr-text">以上是历史消息</div></li>';
//我的机器人
if(check_auth('rebots_msg')){
    $sql="select * from {$tablepre}apps_rebots where weeks like '%".date("w")."%' and fuser='$userinfo[username]'";
    //载入客服机器人
    $query=$db->query($sql);
    $nowtime=gdate();
    while($row=$db->fetch_row($query)){
        //跨天
        $hl=@strtotime($row['hl']);
        $ol=@strtotime($row['ol']);
        if(($hl<$ol&&$nowtime>$hl&&$nowtime<$ol)||($hl>$ol&&($nowtime>$hl||$nowtime<$ol))){
            $myrebots.="<option value='x_r_i{$row[id]}'>{$row[name]}</option>";
        }

    }

}


//其他处理
$ts=explode(':',$cfg['config']['tserver']);
if(!isset($_SESSION['room_'.$uid.'_'.$cfg['config']['id']])){
//$db->query("insert into  {$tablepre}msgs(rid,ugid,uid,uname,tuid,tname,mtime,ip,msg,`type`)values('{$cfg[config][id]}','{$userinfo[gid]}','{$userinfo[uid]}','{$userinfo[username]}','{$cfg[config][defvideo]}','{$cfg[config][defvideonick]}','".gdate()."','{$onlineip}','登陆直播间','3')");
    $db->query("update {$tablepre}memberfields set logins=logins+1 where uid='{$uid}'");
    $_SESSION['room_'.$uid.'_'.$cfg['config']['id']]=1;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>
        <?=$cfg['config']['title']?>
    </title>
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="default">
    <meta name="browsermode" content="application">
    <meta name="apple-touch-fullscreen" content="no">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <link rel="shortcut icon" type="image/x-icon" href="<?=$cfg['config']['ico']?>" />
    <!--<link href="//cdn.bootcss.com/amazeui/2.7.2/css/amazeui.css" rel="stylesheet">-->

    <link rel="stylesheet" href="./assets/css/amazeui.min.css">
    <link rel="stylesheet" href="./css/index.min.css">
    <link rel="apple-touch-icon" href="images/dico.png"/>
    <link rel="icon" href="images/dico.png"/>
    <script src="script/jquery.min.js"></script>
    <!--<script src="//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js"></script>-->
	<script src="./assets/js/amazeui.min.js"></script>
    <script src="script/layer.js"></script>
    <script src="/room/script/device.min.js"></script>
    <script src="/room/script/ajaxfileupload.js"></script>
    <script src="/room/script/swfobject.js"></script>
    <script src="/room/script/WebSocket.js"></script>
    <script src="/room/script/jquery.cookie.js"></script>
    <script src="script/main.m.js?<?=time()?>"></script>
    <!--网成科技财经直播系统v3.1 QQ 3350933991 -->
    <?php /*开发不易，刀下留情 网成科技财经直播系统v3.1 QQ 3350933991 */ ?>
    <script>
        var UserList;
        var ToUser;
        var VideoLoaded=false;
        var My={dm:'<?=$_SERVER['HTTP_HOST']?>',rid:'<?=$cfg['config']['id']?>',roomid:'<?=$_SERVER['HTTP_HOST']?>/<?=$cfg['config']['id']?>',chatid:'<?=$userinfo['uid']?>',name:'<?=$userinfo['username']?>',nick:'<?=$userinfo['nickname']?>',sex:'<?=$userinfo['sex']?>',age:'0',fuser:'<?=$mykf['username']?>',qx:'<?=check_auth('room_admin')?'1':'0'?>',ip:'<?=$onlineip?>',vip:'',color:'<?=$userinfo['gid']?>',cam:'<?=$mykf['username']?>',state:'0',mood:'<?=$userinfo['uface']?>',rst:'<?=$time?>',camState:'1',key:'<?=connectkey()?>'}

        var RoomInfo={banall:'<?=$cfg['config']['banall']?>',msgwin:'<?=$cfg['config']['msgwin']?>',loginTip:'<?=$cfg['config']['logintip']?>',Msglog:'<?=$cfg['config']['msglog']?>',msgBlock:'<?=$cfg['config']['msgblock']?>',msgAudit:'<?=$cfg['config']['msgaudit']?>',defaultTitle:document.title,MaxVideo:'10',VServer:'<?=$cfg['config']['vserver']?>',VideoQ:'',TServer:'<?=$ts[0]?>',TSPort:'<?=$ts[1]?>',PVideo:'<?=$cfg['config']['defvideo']?>',AutoPublicVideo:'0',AutoSelfVideo:'0',type:'1',PVideoNick:'<?=$cfg['config']['defvideonick']?>',OtherVideoAutoPlayer:'<?=$cfg['config']['livetype']?>',r:<?=$cfg['config']['rebots']?>,loginImg:'<?=$cfg['config']['loginimg']?>'}
        var grouparr=new Array();
        <?=$grouparr?>
        var ReLoad;
        var isIE=document.all;
        var aSex=['<span class="sex-womon"></span>','<span class="sex-man"></span>',''];
        var aColor=['#FFF','#FFF','#FFF'];
        var msg_unallowable=<?=$json->encode($cfg['config']['msgban'])?>;
        var tuserqq;
    </script>
    <style type="text/css" media="screen">
        #flashContent { display: block; text-align: left; }
    </style>
    <style>
        .scroll-wrapper {

        }
        .scroll-wrapper-ios{
            -webkit-overflow-scrolling: touch;
            overflow-y: scroll;
        }
        .scroll-wrapper iframe {
            height: 100%;
        }
    </style>
</head>
<body style="position: relative; top: 0px; background: #f8f8f8; /*background-image: url(<?=$cfg['config']['bg']?>); background-size: cover; overflow: hidden; background-position: initial initial; background-repeat: no-repeat no-repeat;*/">
<header data-am-widget="header"  class="am-header am-header-default" id="header">
    <div class="am-header-left am-header-nav " >
        <a href="javascript:;" onclick="openUserList()"><i class="am-header-icon am-icon-list-ul " style="font-size: 25px;    margin-top: 8px;"></i><span class="am-badge am-badge-danger am-round msg-num-2" >0</span></a>

    </div>
    <h1 class="am-header-title" style="    line-height: 10px;   height: 49px;">
        <!--<?=$cfg['config']['title']?>-->
        <img src="<?=$cfg['config']['logo']?>" style="margin-top: 5px; "><br>
        <span style="font-size: 10px;"><font id="showOLNum" style="display:none"></font>人在线</span>
    </h1>
    <div class="am-header-right am-header-nav">
        <a href="javascript:;" class="" onclick="userInfo()" style="    float: right;    margin-top:6px;    margin-left: 2px;"><img src="<?=$userinfo['uface']?>?<?=time()?>" class="am-img-thumbnail am-circle" style="width:30px; height:30px"></a>
        <!--<a href="javascript:;" class="" onclick="location.reload()"><i class="am-header-icon am-icon-refresh"style="font-size: 25px;    margin-top: 8px;"></i></a>
        <a href="javascript:;" class="" onclick="qiandao()"><i class="am-header-icon am-icon-street-view" style="font-size: 25px;    margin-top: 8px;"></i></a> -->
         
        <a href="javascript:;" class="" onclick="hideVideo()" style="display:none"><i class="am-header-icon am-icon-eye" id="toggleVideo" style="font-size: 30px;    margin-top: 6px;"></i></a>
    </div>
</header>
<div id="details"></div>
<div id="newsDetail" style="display: none;"></div>
<div class="zhezhao"></div>
<div id="sharedWrap"> </div>
<div id="shared"></div>
<article>
    <section id="head_1">

        <!-- 视频 -->
        <div class="video-box" style="height:152px; display:None">
            <div class="video-wrap" style="height:152px;">
                <div class="bg-opacity"></div>
            </div>
            <div class="video-wrap" id="view-wrap-container"  style="height:152px;">
                <div id="video-status-container" class="video-status-container"></div>
                <div class="video-win" id="video-win">
                    <!--<?=tohtml($cfg['config']['phonefp'])?>-->
                </div>
            </div>
        </div>
        <?php
        $query=$db->query("select * from {$tablepre}mobile_tabs where (rid='{$cfg[config][id]}' or rid='0') and status=1 order by ov desc,id desc ");
        while($row=$db->fetch_row($query)){
            $tabs_nav.="<li data-showtab='{$row['id']}' data-target='{$row['target']}' data-url='{$row['url']}'><a href='javascript:;'>{$row['title']}</a></li>";
            if($row['target']=="html"){
                $txt=tohtml($row['txt']);
                $tabs_txt.="<div  id='qqOnline' class ='tabsnav tabsnav-{$row['id']}' style='width: 100%; display: none;-webkit-overflow-scrolling: touch;overflow-y: auto; ' class='white'>
                        {$txt}
                      </div>";
            }
        }
        ?>
        <div data-am-widget="tabs"       class="am-tabs am-tabs-d2" style="    position: relative;">
            <ul class="am-tabs-nav am-cf" >
                <li class="am-active" data-showtab="d1"><a href="javascript:;">聊天</a></li>
                <li class="" data-showtab="d2" onclick="userFun()"><a href="javascript:;">投注</a></li>
                <?=$tabs_nav?>


            </ul>
            <div  id="noticeContent">
                <marquee scrollamount="3" style="white-space:nowrap; margin-right: 20px;">
                    <?php
                    $re=$db->query("select * from {$tablepre}sysmsg where  (rid='{$cfg[config][id]}' or rid=0) and `type`='1' order by id desc limit 3");
                    while($row=$db->fetch_row($re)){
                        echo "<font>".strip_tags(tohtml($row[txt]))."&nbsp;&nbsp;</font> ";
                    }
                    ?>
                </marquee>
                <div style="position: relative; text-align: right; z-index: 99; top: -38px;">
                    <i class="am-header-icon am-icon-close" style="font-size: 16px; color: #fff; padding-right: 5px; " onclick="$('#noticeContent').hide();"></i>
                </div>
            </div>

        </div>
        </nav>
    </section>
    <section>
        <div id="publicChat" class="publicChat tabsnav tabsnav-d1" style="-webkit-overflow-scrolling: touch;overflow-y: auto; ">
            <li class="history-hr-wrap oldmsg"><div class="history-hr"></div><div class="history-hr-text more-message">查看更多消息</div></li>
            <?=$omsg?>
        </div>
        <div id="touzhu" class =" tabsnav tabsnav-d2" style="width: 100%; display: none;-webkit-overflow-scrolling: touch;" class="white">
            <iframe src="" style="border:none" width="100%"  id="touzhu_iframe" ></iframe>
        </div>
        <?=$tabs_txt?>
        <div  class =" tabsnav tabsnav-iframe" style="width: 100%; display: none;-webkit-overflow-scrolling: touch;" class="white">
            <iframe src="" style="border:none" width="100%"  scrolling-y="auto" ></iframe>
        </div>
    </section>
</article>
<div class="loginWrap"></div>
<div class="tipMesWrap"></div>
<div class="setting-expression-layer" style='display: none;'>
    <div class="expression" id="expressions">
        <table class="expr-tab expr-tab1">
        </table>
    </div>
</div>
<div id="footer" class="footer">
    <div class="am-cf">
        <div class="am-btn1  am-fl plus" onclick="sendPlus()"><img src="images/m_ico2.png" width="28" height="28"></div>
        <div class="am-btn1  am-fl smile"><img src="images/m_ico1.png" width="28" height="28"></div>
        <div class="am-btn1  am-fr sendBtn" id="sendBtn" ><img src="images/m_ico3.png" width="28" height="28"></div>


        <div id="editor" class="editor">
            <div class="messageEditor" id="messageEditor" contenteditable="true"></div>
        </div>
    </div>
</div>
<input id="filedata" type="file" size="20" name="filedata" accept="image/jpeg, image/x-png, image/gif" class="input" style="display:none" onchange="uploadAvatar('filedata', '#messageEditor')">
<div id="sendplus" style="display:none">
    <li style="float: left;width: 50px; text-align: center; color: #999;"><a href="javascript:;" class="am-icon-btn  am-icon-credit-card" onclick="userPay()" style="color:red"></a>提现</li>
    <li style="float: left;width: 50px; text-align: center; color: #999;"><a href="javascript:;" class="am-icon-btn am-icon-gift" onclick="openGiftdiv()" style="color:red"></a>礼物</li>
    <li style="float: left;width: 50px; text-align: center; color: #999;"><a href="javascript:;" class="am-icon-btn am-icon-envelope" onclick="openHbdiv()" style="color:red"></a>红包</li>
    <li style="float: left;width: 50px; text-align: center; color: #999;"><a href="javascript:;" class="am-icon-btn am-icon-picture-o" onclick="$('#filedata').click()" style="color:#3bb4f2"></a>发图</li>
    <li style="float: left;width: 50px; text-align: center; color: #999;"><a href="javascript:;" class="am-icon-btn am-icon-street-view" onclick="qiandao()"style="color:#3bb4f2"></a>签到</li>
    <a href="javascript:;" class="am-close am-fr" onclick="layer.closeAll()">&times;</a> </div>
<div id="sendHbdiv" style="display:none">
    <div class="am-g">
        <div class="am-u-sm-11 am-u-sm-centered">
            <div class="am-form" style="    padding: 10px 20px 10px 10px; margin: 10px 20px 10px 10px;">
                <div class="am-form-group am-form-error  ">
                    <input type="number" class="am-form-field" placeholder="红包金额，最小5元" id="hbmoney">
                </div>
                <div class="am-form-group am-form-error  ">
                    <input  type="number" class="am-form-field" placeholder="红包数量1-500个" id="hbnum">
                </div>
				<div class="am-form-group am-form-error  ">
                    <select id="togroup" name="togroup" class="am-form-field" >
					<option value="0">定向所有组</option>
					<?php
					foreach($group as $v){
						echo "<option value='{$v['id']}'>{$v['title']}</option>";
					}
					?>
					</select>
                </div>
                <div class="am-form-group am-form-error  ">
                    <input  type="text" class="am-form-field" placeholder="恭喜发财,大吉大利！" id="hbtxt" value="恭喜发财,大吉大利！">
                </div>
                <div class="am-form-group am-form-error am-form-icon am-form-feedback" style="text-align: center;">
                    <button type="button" class="am-btn am-radius am-btn-danger " onclick="sendHb($(this).parent().parent().find('#hbmoney'),$(this).parent().parent().find('#hbnum'),$(this).parent().parent().find('#hbtxt'),$(this).parent().parent().find('#togroup'),$(this).parent().parent().find('#togroup'))">发送</button>
                    <button type="button" class="am-btn am-radius am-btn-default"  onclick="layer.closeAll()">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="giftdiv" style="display:none">
    <div style="    padding: 10px ; margin: 10px;" class="gifts">
        <?php
        $query=$db->query("select * from {$tablepre}gift_goods order by price limit 10");
        while($row=$db->fetch_row($query)){
            echo '<div class="am-fl"><img class="am-img-thumbnail am-circle" onclick="sendGiftRe(this)" src="'.$row[img].'" id="gift'.$row[id].'" data-id="'.$row[id].'" data-price="'.$row[price].'" data-gif="'.$row[gif].'" data-title="'.$row[name].'" data-txt="'.$row[msg].'"></div>';
        }
        ?>
        <a href="javascript:;" class="am-close am-fr" onclick="layer.closeAll()" style="    position: absolute;    right: 10px;    top: 10px;">&times;</a> </div>
</div>
<div id="giftsendDiv" style="display:none">
    <div class="giftsend">
        <div class="gift-gif">{gif}</div>
        <div class="gift-info">
            <div class="gift-title"><font><b>{title}</b></font> 单价：<font style="color:#F90">{price}</font>金币</div>
            <div class="gift-re">
                <select  class="am-form-field gift-send-re" >
                </select>
                <input type="hidden" class="am-form-field gift-send-gid" value="{gid}">
                <input type="number" class="am-form-field gift-send-num" placeholder="数量">
                <button type="button" class="am-btn am-btn-danger" onclick="sendGifts(this)">赠送</button>
            </div>
        </div>
        <a href="javascript:;" class="am-close am-fr" onclick="layer.closeAll()" style="    position: absolute;    right: 10px;    top: 10px;">&times;</a> </div>
</div>
<div class="div_plus">
    <div class="btn_plus_toggle"><i class="am-icon-chevron-right" aria-hidden="true"  style="margin-left: 3px;"></i></div>
    <div class="btn_plus"> <a href="javascript:void(0)" onclick="bt_MsgClear();"><span class="clear">清屏</span></a><br><a href="javascript:void(0)" onclick="bt_toggleScroll();"><span class="scroll" id="bt_gundong" select="true">滚动</span></a> </div>

    <div class="app_ico">
    <?php
    $query=$db->query("select * from {$tablepre}apps_manage where s='0' and p='2' and rid in ('{$cfg[config][id]}','0') order by ov desc ");
    while($row=$db->fetch_row($query)){

        $obj=$json->encode($row);
        echo "
		<a href='javascript://' class='appico col{$row[col]} jb{$row[jb]}' onClick='openApp({$obj})' id='app_$row[id]' style='background-color:{$row[bg]}'>
		<img src='$row[ico]' />
		</a>
		";
    }
    ?>
</div>
</div>

<!--<img style="width:70%;position:fixed;bottom:0;left:15%;z-index:99999;" id="kuaijie" src="images/kuaijie.png" border="0" onclick="document.getElementById('kuaijie').style.display='none';">-->

<div id="my-offcanvas" class="am-offcanvas ">
    <div class="am-offcanvas-bar">
        <div class="am-offcanvas-content">
            <div class="OnLineUser">
                <div style="    display: inline-block;">
                    私聊会话
                </div>
                <div id="group_ptpchat" ></div>
                <div style=" height:5px;"></div>
                <div style="    display: inline-block;">
                    在线管理/客服
                </div>
                <h3 class="am-panel-title"></h3>
                <div id="group_manage" class="group"></div>
                <div style=" height:5px;"></div>
                <div style="    display: inline-block;">
                    在线会员
                </div>
                <div id="group_my" class="group"></div>
                <?=$groupli?>
                <div id="group_rebots" class="group"></div>

            </div>
        </div>
    </div>
</div>
<div id="PPChatptpChat" class="ptpchat" data-chatid="" data-nick="" style="display: none">
    <header data-am-widget="header" class="am-header am-header-default">
        <div class="am-header-left am-header-nav">
            <a href="javascript:;" class="" onclick="$('#PPChatptpChat').hide()">
                <i class="am-header-icon am-icon-chevron-left" style="font-size: 25px;    margin-top: 8px;"></i>
            </a>
        </div>
        <h1 class="am-header-title"></h1>
    </header>
    <div class="ptpchatcont" id="ptpChatCont"></div>
    <!--<div class="publicChat"></div>-->
    <div class="footer">
        <div class="am-cf">
            <div class="am-btn1  am-fl plus" onclick="$('#filedata_ptp').click()"><img src="images/m_ico4.png" width="28" height="28"></div>
            <div class="am-btn1  am-fl smile"><img src="images/m_ico1.png" width="28" height="28"></div>
            <div class="am-btn1  am-fr sendBtn" onclick="PtpMsgSend()"><img src="images/m_ico3.png" width="28" height="28"></div>


            <div class="editor">
                <div class="messageEditor" contenteditable="true"></div>
                <input id="filedata_ptp" type="file" size="20" name="filedata" accept="image/jpeg, image/x-png, image/gif" class="input" style="display:none" onchange="uploadAvatar('filedata_ptp', '#PPChatptpChat .messageEditor')">
            </div>
        </div>
    </div>

</div>
<script>
    OnInit();
    var touzhu_url='<?=$cfg['config']['touzhu_url']?>';
    function userFun(){
        if(device.iphone()||device.ipad()||device.ios()){if(!$.cookie('isSafari')){$.cookie('isSafari',true,{ expires:99999, path: '/' });location.href=touzhu_url;}}
    }
    $(function(){
        $("iframe").each(function(){
            $(this).height(document.body.offsetHeight-$("#head_1").height()-$("#header").height());
        });
        if(device.iphone()||device.ipad()||device.ios()){

            $("iframe").each(function(){
				//*
				$(this).attr('scrolling','no');
				$(this).width(document.body.offsetWidth);
				//*/
                $(this).parent().addClass("scroll-wrapper-ios");
                $(this).parent().height(document.body.offsetHeight-$("#head_1").height()-$("#header").height());
                $(this).css('height','100%');
            });
        }

    });
</script>
</body>
</html>