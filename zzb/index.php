<?php
// ini_set("display_errors",true);
// error_reporting(11);
require_once './include/common.inc.php';
error_reporting(0);

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

if(isMobile()){header('location:/room/m/?rid='.$rid);}
require_once PPCHAT_ROOT.'./include/json.php';
$json=new JSON_obj;
//房间状态
if($cfg['config']['state']=='2' and $_SESSION['room_'.$cfg['config']['id']]!=true){header("location:/room/login.php?rid={$rid}");exit();}
if($cfg['config']['state']=='0'){exit("<script>location.href='/room/error.php?msg=系统处于关闭状态！请稍候...'</script>");exit();}
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
// var_dump($userinfo['gid']);exit;
//允许组
//if(!in_array($userinfo['gid'],@explode(',',$cfg['config']['acl']))){exit("<script>location.href='/room/error.php?id={$rid}&msg=您所在组没有房间访问权限！'</script>");exit();}

//用户组
$re = $db->query("select * from {$tablepre}auth_group order by ov desc");
while($row=$db->fetch_row($re)){
// 	var_dump($row);
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
    //if($row[uid]==$uid)$who=" notmine ";



    if($row[tuid]!="ALL")$row[msg]="@$row[tname] ".$row[msg];
    if($row[tname]=="hongbao"){$who.=' hongbaomsg';$row[msg]='<div class="redbag-top" title="'.$row[msg].'" data-hid="'.$row[msgid].'" onclick="getHongBao($(this).data(\'hid\'))"><div class="fl"><img src="/room/images/hongbao.png" style="margin-top: 3px;"></div><div class="fl ml10" style="color:#fff;"><p style="font-weight:bold;margin-bottom:4px;color:#f30;font-size:14px;">'.$row[msg].'</p>领取红包</div></div><div style="padding:3px 10px;background: #fff;color: #333;">直播室红包</div>';}
    if($row[tname]=="gift"){$who.=' system';}
    if($row[tname]=="gethongbao"){
        $omsg='<div class="message-wrap"><div class="redbag-info1"><p style="color:#333;">'.$row['uname'].' 领取了 <span style="color:red;">'.$row['style'].'</span> 的红包 <span style="color:red;">'.$row['msgid'].'元</span></p></div><div class="clear"></div></div>'.$omsg;
        continue;
    }
    $omsg='<div class="chat-item '.$who.'" ><div class="user-img"> <div class="uimg"><img src="/face/img.php?t=p1&u='.$row[uid].'"/></div><div class="gimg"><img src="'.$group["m".$row[ugid]][ico].'"/></div></div><div class="chat-info"> <div class="chat-info-1"> <span class="chat-name"  onclick="ToUser.set(\''.$row[uid].'\',\''.$row[uname].'\')">'.$row[uname].'</span> <span class="chat-time">'.date('H:i:s',$row[mtime]).'</span></div><div class="chat-info-2"> <div class="chat-msg">'.$row[msg].'</div></div></div></div>'.$omsg;
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
            $myrebots.="<option value='x_r_i{$row[id]}' data-gid='{$row[gid]}'>{$row[name]}</option>";
        }

    }

}


//其他处理
$ts=explode(':',$cfg['config']['tserver']);
if(!isset($_SESSION['room_'.$uid.'_'.$cfg['config']['id']])){
//$db->query("insert into  {$tablepre}msgs(rid,ugid,uid,uname,tuid,tname,mtime,ip,msg,`type`)values('{$cfg[config][id]}','{$userinfo[gid]}','{$userinfo[uid]}','{$userinfo[username]}','{$cfg[config][defvideo]}','{$cfg[config][defvideonick]}','".gdate()."','{$onlineip}','登陆直播间','3')");
    $db->query("update {$tablepre}memberfields set logins=logins+1 where uid='{$uid}'");
    $_SESSION['room_'.$uid.'_'.$cfg['config']['id']]=1;
	$tuser=userinfo($_COOKIE['tg'],'{username}');
  	$db->query("update {$tablepre}members set tuser='{$tuser}' where uid='{$uid}'");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="renderer" content="webkit">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <title><?=$cfg['config']['title']?></title>
    <meta content="<?=$cfg['config']['keys']?>" name="keywords">
    <meta content="<?=$cfg['config']['dc']?>" name="description">
    <link rel="shortcut icon" type="image/x-icon" href="<?=$cfg['config']['ico']?>" />
    <link rel="bookmark" href="<?=$cfg['config']['ico']?>"/>
    <link href="/room/css/animate.min.css" rel="stylesheet" type="text/css"  />
    <link href="/room/css/barrager.css" rel="stylesheet" type="text/css"  />
    <link href="/room/css/css.css" rel="stylesheet" type="text/css"  />
    <!--<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
    <link href="/room/css/font-awesome.min.css" rel="stylesheet" type="text/css"  />
    <link href="/room/css/layim.css" rel="stylesheet" type="text/css"  />
    <link href="/room/css/responsiveslides.css" rel="stylesheet" type="text/css"  />
    <script src="/room/script/jquery.min.js"></script>
    <script src="/room/script/device.min.js"></script>
    <script src="/room/script/face.js"></script>
    <script src="/room/script/swfobject.js"></script>
    <script src="/room/script/WebSocket.js"></script>
    <script src="/room/script/jquery.select.js"></script>
    <script src="/room/script/jquery.barrager.js"></script>
    <script src="/room/script/jquery.cookie.js"></script>
    <script src="/room/script/jquery.nicescroll.min.js"></script>
    <script src="/room/script/kxbdSuperMarquee.js"></script>
    <script src="/room/script/layer.js"></script>
    <script src="/room/script/pastepicture.js"></script>
    <script src="/room/script/responsiveslides.js"></script>
    <script>
    if (window.WebSocket){
        console.log("This browser supports WebSocket!");
    } else {
        console.log("This browser does not support WebSocket.");
    }
    </script>
   
    <script src="/room/script/PPChat.Org.function.js?<?=time()?>"></script>
    <script src="/room/script/PPChat.Org.init.js?<?=time()?>"></script>
    <script>
        var _sn='<!--开发QQ:3350933991-->';
        var UserList;
        var ToUser;
        var VideoLoaded=false;
        var My={dm:'<?=$_SERVER['HTTP_HOST']?>',rid:'<?=$cfg['config']['id']?>',roomid:'<?=$_SERVER['HTTP_HOST']?>/<?=$cfg['config']['id']?>',chatid:'<?=$userinfo['uid']?>',name:'<?=$userinfo['username']?>',nick:'<?=$userinfo['nickname']?>',sex:'<?=$userinfo['sex']?>',age:'0',fuser:'<?=$mykf['username']?>',qx:'<?=check_auth('room_admin')?'1':'0'?>',ip:'<?=$onlineip?>',vip:'',color:'<?=$userinfo['gid']?>',cam:'<?=$mykf['username']?>',state:'0',mood:'<?=$userinfo['uface']?>',rst:'<?=$time?>',camState:'1',key:'<?=connectkey()?>'}

        var RoomInfo={banall:'<?=$cfg['config']['banall']?>',msgwin:'<?=$cfg['config']['msgwin']?>',loginTip:'<?=$cfg['config']['logintip']?>',Msglog:'<?=$cfg['config']['msglog']?>',msgBlock:'<?=$cfg['config']['msgblock']?>',msgAudit:'<?=$cfg['config']['msgaudit']?>',defaultTitle:document.title,MaxVideo:'10',VServer:'<?=$cfg['config']['vserver']?>',VideoQ:'',TServer:'<?=$ts[0]?>',TSPort:'<?=$ts[1]?>',PVideo:'<?=$cfg['config']['defvideo']?>',AutoPublicVideo:'0',AutoSelfVideo:'0',type:'1',PVideoNick:'<?=$cfg['config']['defvideonick']?>',OtherVideoAutoPlayer:'<?=$cfg['config']['livetype']?>',r:'<?=$cfg['config']['rebots']?>',loginImg:'<?=$cfg['config']['loginimg']?>'}
        var grouparr=new Array();
        <?=$grouparr?>
        var ReLoad;
        var isIE=document.all;
        var aSex=['<span class="sex-womon"></span>','<span class="sex-man"></span>',''];
        var aColor=['#FFF','#FFF','#FFF'];
        var msg_unallowable=<?=$json->encode($cfg['config']['msgban'])?>;
        var tuserqq;
    </script>
</head>
<body onResize="OnResize()" onUnload="OnUnload()" style="background-image:url(<?=$cfg['config']['bg']?>)" class="bg-skin">
<div id="UI_MainBox" >
    <script>if (!device.desktop()){window.location = '/room/m/?rid=<?=$rid?>';}</script>
    <div id="UI_Head">
        <div class="head">
            <div id="head_box" class="head_box">
                <div class="logo_bg">
                    <div class="logo"><img src="<?=$cfg['config']['logo']?>"></div>
                    <a href="javascript:void(0)" class="toggle-side" title="侧边切换" onClick="toggleLeft();" style="display:none"><i class="fa fa-bars"></i></a>
                    <div class="nav"> <a href="/room/ico.php?rid=<?=$cfg[config][id]?>" target="e"  class="btn active"><i class="fa fa-desktop"></i>保存到桌面</a>
                        <a href="javascript:void(0)" class="btn" onclick="join_favorite(document.location,document.title)"><i class="fa fa-star-o"></i>收藏</a>
                        <a href="javascript:void(0)" class="btn" id="view-m"><i class="fa fa-mobile" style="font-size:18px;vertical-align: middle;"></i>手机</a>
                        <?php
                        $query=$db->query("select * from {$tablepre}apps_manage where s='0' and p='1' and rid in ('{$cfg[config][id]}','0') order by ov desc ");
                        while($row=$db->fetch_row($query)){

                            $obj=$json->encode($row);
                            echo "
		<a href='javascript://'  class='btn' onClick='openApp({$obj})' id='app_1_$row[id]' style='color:{$row[bg]}'>
		<img src='$row[ico]' style='vertical-align: middle;    border: 0 none; width: 18px;'> {$row[title]}</a>
		</a>
		";
                        }
                        ?>
                        <!--<a href="javascript:void(0)" class="btn" onclick="openApp({&quot;id&quot;:&quot;3600&quot;,&quot;title&quot;:&quot;美女在线直播&quot;,&quot;ico&quot;:&quot;&quot;,&quot;url&quot;:&quot;/apps/zhibo.php&quot;,&quot;w&quot;:&quot;504&quot;,&quot;h&quot;:&quot;450&quot;,&quot;target&quot;:&quot;POPWin&quot;,&quot;position&quot;:&quot;top&quot;,&quot;s&quot;:&quot;0&quot;,&quot;ov&quot;:&quot;0&quot;})"><i class="fa fa-heart" style="color:red"></i>美女在线直播</a>--><!-- <a href="javascript:void(0)" class="btn toggle-room" onClick="toggleRoom()" ><i class="fa fa-map-signs"></i>切换直播室</a>--></div>


                </div>
                <div class="head_user">
                     
                    <a href="javascript:void(0)" class="toggle-skin" onClick="toggleSkin()" > <i class="fa fa-paint-brush"></i>换肤<i class="fa fa-caret-down"></i></a>
                    <?php
                    if($_SESSION['login_uid']>0&&$_SESSION['login_gid']!='2')
                    {
                        ?>
                        <a href="javascript:void(0)" class="userinfo" onClick="openWin(2,false,'/room/profiles.php?uid=<?=$userinfo['uid']?>',460,600)"><img src='<?=$userinfo['uface']?>' border="0" class="userimg"/>
                            <?=$userinfo['nickname']?><i class="fa fa-caret-down"></i>
                            </a>
                        <?php
                        if(stripos(auth_group($userinfo[gid]),'adminlogin')){
                            $_SESSION['admincp']=$userinfo['username'];
                            echo '<a href="/adminv3/" class="userlogout" target="_blank"><i class="fa fa-cloud"></i>管理中心</a>';
                        }
                        ?>
                        <a href='/room/minilogin.php?act=logout&rid=<?=$rid?>' class="userlogout"><i class="fa fa-sign-out"></i>退出</a>
                        <?php
                    }else{
                        ?>
                        <a href="javascript:void(0)"   onClick="openWin(2,false,'/room/profiles.php?uid=<?=$userinfo['uid']?>',460,600)" class="userlogin"><img src='<?=$group["m".$userinfo[gid]][ico]?>' border="0" style="width:20px; height:20px;vertical-align: middle;"/>
                            <?=$userinfo['nickname']?>
                        </a> <a href="javascript:void(0)" class="reg" onClick="openWin(2,false,'/room/minilogin.php?a=0&rid=<?=$rid?>',370,380)">注册</a> <a href="javascript:void(0)" class="login" onClick="openWin(2,false,'/room/minilogin.php?rid=<?=$rid?>',370,340)">登录</a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div id="UI_Left">
        <div id="Left_wrap">
            <div class="ads"   style="display:none">
                <div class="rslides" id="adImg">
                    <?php
                    if($userinfo[gid]=='0')
                        $sql="select * from {$tablepre}apps_appad where gv!='1' and (rid='{$cfg[config][id]}'  or rid='0') order by ov desc ";
                    else
                        $sql="select * from {$tablepre}apps_appad where gv!='0'  and (rid='{$cfg[config][id]}'  or rid='0')order by ov desc ";
                    $query=$db->query($sql);
                    while($row=$db->fetch_row($query)){
                        echo "
		<li><a href='$row[url]' target='_blank' title='$row[title]'><img src='$row[pic]' /></a></li>
		";
                    }
                    ?>
                </div>
            </div>
            <div class="apps">
                <?php
                $query=$db->query("select * from {$tablepre}apps_manage where s='0' and p='0' and rid in ('{$cfg[config][id]}','0') order by ov desc ");
                while($row=$db->fetch_row($query)){

                    $obj=$json->encode($row);
                    echo "
		<a href='javascript://' class='appico col{$row[col]} jb{$row[jb]}' onClick='openApp({$obj})' id='app_$row[id]' style='background-color:{$row[bg]}'>
		<img src='$row[ico]' /><br>
		<span>{$row[title]}</span>
		</a>
		";
                }
                ?>
                <div style="clear:both"></div>
            </div>
            <div class="tab_nav">
            <a href="javascript:void(0)" onClick="bt_SwitchListTab('myKf')" id="myKf" class="active" style="">客服/管理</a> 
            <a href="javascript:void(0)" onClick="bt_SwitchListTab('myKh')" id="myKh" class="active" style="<?=$userinfo['gid']!='3'?'display:none':''?>">我的客户<br>
                    <span id="OnlineOtherNum"></span></a> <a href="javascript:void(0)" onClick="bt_SwitchListTab('olUs')" id="olUs">在线会员<br>
                    <span id="OnlineUserNum"></span></a>
                <div style="clear:both"></div>
            </div>
        </div>
        <div id="tab_myKf" class="tab_div" style="<?=$userinfo['gid']=='3'?'display:none':''?>">
            <div class="kfjs">我的专属客服</div>
            <a href="javascript:void(0)"  onClick="callMyKf({'chatid':'<?=$mykf[uid]?>','nick':'<?=$mykf[nickname]?>'})" class="kfbase"> <span class="uimg"><img src="/face/img.php?t=p1&u=<?=$mykf[uid]?>"/></span> <span class="unick">
      <?=$mykf[nickname]?>
                    <br>
      <span class="uqq">QQ:
          <?=$mykf[realname]?>
      </span></span> </a>
            <div class="kfbtns">
                <a id="kfbt1" href="javascript:void(0)" class="btn1" onClick="callMyKf({'chatid':'<?=$mykf[uid]?>','nick':'<?=$mykf[nickname]?>'})"><i class="fa fa-comments"></i>在线私聊</a>
                <a id="kfbt2" href="http://wpa.qq.com/msgrd?v=3&uin=<?=$mykf[realname]?>&site=ppchat"  class="btn2" target="_blank"><i class="fa fa-qq"></i>QQ交谈</a> </div>
            <!--<div class="kfjs">客服介绍</div>-->
            <div class="kfbz">
                <?=tohtml($mykf[kfmsg])?>
            </div>
<!--              <div class="kfjs">在线管理</div> -->
<!--             <div class="OnLineUser"> -->
<!--                 <div id="group_manage" ></div> -->
<!--             </div> -->
        </div>
        <div id="tab_myKh" class="tab_div">
            <div id="OnLineUser_OhterList" class="OnLineUser">
                <div id="group_myuser"></div>
            </div>
        </div>
        <div id="tab_olUs" class="tab_div" style="<?=$userinfo['gid']!='3'?'display:none':''?>">
            <div id="OnlineUser_Find">
                <input name="" type="image" title="找人" onClick="bt_FindUser()" src="/room/images/search.png" style="float:right; margin:5px;" />
                <input name="finduser" type="text" id="finduser" placeholder="" />
            </div>
            <div id="OnLineUser_FindList" class="OnLineUser" style="display:none" ></div>
            <div id="OnLineUser" class="OnLineUser">
                <div id="group_my" ></div>
                <?=$groupli?>
                <div id="group_rebots"></div>
                <div style="clear:both"></div>
                <div onClick="bt_ulistmore(10);" style="text-align:center; cursor:pointer; padding:5px 0; display:none" class="bg_png">更多</div>
            </div>
        </div>
    </div>
    <div id="UI_Right">
        <div id="LivePanel">
            <div class="title">
                <!--
                <span class="uimg"><img src="/face/img.php?t=p1&amp;u=1210469"></span> <span id="defvideosrc">当前讲师：
                技术服务-系统开发		<span class="btn sx" onClick="showLive()"><i class="fa fa-refresh"></i>刷新</span>
                </span>
                <span class="btn sk" id="bt_defvideosrc" onClick="bt_defvideosrc()"><i class="fa fa-video-camera"></i>直播</span> -->
                <span class="btn dz" id="btn_touzhu"><i class="fa fa-download"></i>在线投注</span>

                <span class="btn " style="background: rgba(0, 0, 0, .4);" onclick="$(&quot;#OnLine_MV&quot;).html(&quot;<embed src=//weblbs.yystatic.com/s/22490906/22490906/yycomscene.swf quality=high width=100% height=100% align=middle allowscriptaccess=always  allowfullscreen=true wmode=transparent type=application/x-shockwave-flash autostart=true>&quot;)"><i class="fa fa-video-camera"></i>美女直播</span>

                <span class="btn " style="background: rgba(0, 0, 0, .4);" onclick="$(&quot;#OnLine_MV&quot;).html(&quot;<iframe src=/apps/kaijiang.php width=100% height=100%   allowTransparency=true></iframe>&quot;)"><i class="fa fa-angellist"></i>开奖直播</span>
                <span class="btn " style="background: rgba(0, 0, 0, .4);" onclick="$(&quot;#OnLine_MV&quot;).html(&quot;<iframe src=/apps/kaijiang/cplive.html width=100% height=100%   allowTransparency=true></iframe>&quot;)"><i class="fa fa-spinner"></i>文字开奖</span>

            </div>
            <script>
                $(function(){
                    $("#LivePanel .btn").click(function(){
                        $("#LivePanel .btn").css('background','rgba(0, 0, 0, .4)');
                        $("#LivePanel .btn").removeClass('dz');
                        $(this).addClass('dz');
                        $(this).css('background','');
                        if($(this).attr("id")=="btn_touzhu"){
                          	window.open('<?=$cfg['config']['touzhu_url']?>');return false;
                            if(!$("#NoticeList").is(':hidden')){
                                $("#OnLine_MV_touzhu").show();
                                $("#OnLine_MV_touzhu").height($("#OnLine_MV").height()+$(".NoticeList").outerHeight(true));;
                                $("#OnLine_MV").hide();
                                $(".NoticeList").hide();
                            }

                        }else if($("#NoticeList").is(':hidden')){
                            $("#OnLine_MV_touzhu").hide();
                            $("#OnLine_MV").show();
                            $(".NoticeList").show();
                        }
                    });
                });
            </script>
            <div id="OnLine_MV_touzhu" style="display:none">
                <!--<iframe src='<?=$cfg['config']['touzhu_url']?>' width=100% height=100%   allowTransparency=true></iframe>-->
            </div>
            <div id="OnLine_MV">
                <?=tohtml($cfg['config']['livefp'])?>
            </div>
            <div class="tip" style="display:None">投资有风险， 入市需谨慎</div>
        </div>
        <div  id="ppchat-gift" style="display: none">
            <div class="plugs hongbao"><div class="plugs-ico"><img src="/room/images/hongbao.png" title="红包"></div><div class="plugs-txt">红包</div></div>
            <div class="plugs qiandao"><div class="plugs-ico"><img src="/room/images/qiandao.png" title="签到"></div><div class="plugs-txt">签到</div></div>

            <div class="bottom-area c ">
                <div class="js-room-gift-area js-for-gift-list js-for-gift-item open-all-gifts">
                    <div class="give-area js-give-area c">
                        <div class="input-area js-gift-num-panel">
                            <input type="text" class="js-gift-buy-cnt-input" maxlength="4" value="1" id="gift-num">
                            <input type="hidden" class="js-gift-id-input" value="0" id="gift-id">
                            <input type="hidden" class="js-gift-id-input" value="0" id="gift-reuser-uid">
                            <input type="hidden" class="js-gift-id-input" value="0" id="gift-reuser-nick">
                            <div class="drop-down">
                                <ul>
                                    <li> <a href="javascript:;" class="js-gift-num-item" onclick="$('#gift-num').val(1314);$('.drop-down').hide();">1314</a></li>
                                    <li> <a href="javascript:;" class="js-gift-num-item" onclick="$('#gift-num').val(999);$('.drop-down').hide();">999</a></li>
                                    <li> <a href="javascript:;" class="js-gift-num-item" onclick="$('#gift-num').val(520);$('.drop-down').hide();">520</a></li>
                                    <li> <a href="javascript:;" class="js-gift-num-item" onclick="$('#gift-num').val(99);$('.drop-down').hide();">99</a></li>
                                    <li> <a href="javascript:;" class="js-gift-num-item" onclick="$('#gift-num').val(10);$('.drop-down').hide();">10</a></li>
                                </ul>
                            </div>
                            <a href="javascript:;" class="arrow js-gift-num-collapse" onclick='$(".drop-down").toggle();'></a> </div>
                        <a href="javascript:;" class="give-btn js-buy-btn" id="gift-send">赠送</a> </div>
                    <a href="javascript:;" class="gift-btn -collapse"></a>
                    <div class="gifts-content">
                        <div class="gifts-mask js-gifts-mask">
                            <div class="gifts-area js-gifts-area">
                                <ul class="c  js-for-gift-num-panel">
                                    <?php
                                    $query=$db->query("select * from {$tablepre}gift_goods order by price ");
                                    while($row=$db->fetch_row($query)){
                                        echo '<li class="show-gifts" id="gift'.$row[id].'" data-id="'.$row[id].'" data-price="'.$row[price].'" data-gif="'.$row[gif].'" data-title="'.$row[name].'" data-txt="'.$row[msg].'"> <a href="javascript:;" class="js-gift-item"> <i class="bg"></i> <img src="'.$row[img].'" alt=""> </a> </li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style=" clear:both"></div>
        <div class="NoticeList">
            <?php
            $query=$db->query("select * from {$tablepre}notice where rid='{$cfg[config][id]}' or rid='0' order by ov desc,id desc");
            while($row=$db->fetch_row($query)){
                $tab.="<a href='javascript:void(0)' id='notice_{$row[id]}' class='notice_tab'>{$row[title]}</a>";
                $txt.="<div id='notice_{$row[id]}_div' class='notice_div txt' style='display:none;'>".tohtml($row['txt'])."</div>";
            }
            $query=$db->query("select * from {$tablepre}apps_ad where rid='{$cfg[config][id]}'  or rid='0' order by ov desc,id desc limit 4");
            while($row=$db->fetch_row($query)){
                $li_ad.="<li><img src='$row[pic]' style='cursor:pointer;' onClick='openAd(\"$row[pic]\",\"$row[url]\")'></li>";
            }
            ?>
            <div class="tab"> <a href='javascript:void(0)' id='notice_0' class='notice_tab active'>品牌展示</a>
                <?=$tab?>
                <div style=" clear:both"></div>
            </div>
            <div id="NoticeList" style="height:118px;  ">
                <div id='notice_0_div' class='notice_div' style="height:100%;">
                    <div class="AdRslides" style="height:100%;">
                        <ul class="rslides" id="comImg">
                            <?=$li_ad?>
                        </ul>
                    </div>
                </div>
                <?=$txt?>
            </div>
        </div>
    </div>
    <div id="UI_Central">
        <div class="tips-div">
            <div class="tips">
                <div class="title"><i class="fa fa-podcast"></i> 公 告</div>
                <div class="txt">
                    <div id="marquee1">
                        <ul>
                            <?php
                            $re=$db->query("select * from {$tablepre}sysmsg where  (rid='{$cfg[config][id]}' or  rid='0') and `type`='1' order by id desc limit 3");
                            while($row=$db->fetch_row($re)){
                                echo "<li>".tohtml($row[txt])."</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="Y_pub_Tools">
                <!--<div class="title"><i class="fa fa-comments"></i> 互动</div>-->
                <div class="btns"> <a href="javascript:void(0)" onClick="bt_MsgClear();"><span class="clear">清屏</span></a>
                    <a href="javascript:void(0)" onClick="bt_toggleScroll();"><span class="scroll" id="bt_gundong" select="true" >滚动</span></a>
                </div>
            </div>
        </div>
        <div id="MsgBox">
            <div style="
            display: ;
    position: absolute;
    right: 10px;
    width: 45px;
    height: 100px;
"> 

         
            </div>
            <div id="MsgBox1" style="overflow:auto; height:368px; padding:0px 10px 0px 10px;position:relative">
                <div class="view-more-records"><a class="more-message" page="1">查看更多消息</a></div>
                <?=$omsg?>
            </div>
        </div>
        <div id="UI_Control">
            <div class="notice">
                <div class="title"> <i class="fa fa-volume-up"></i> </div>

                <div class="txt">
                    <div id="marquee2">
                        <ul>
                            <?php
                            $re=$db->query("select * from {$tablepre}sysmsg where   (rid='{$cfg[config][id]}'  or rid='0') and `type`='2' order by id desc limit 5");
                            while($row=$db->fetch_row($re)){
                                echo "<li>".tohtml($row[txt])."</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="qqbtns">
                <?php
                $arr = explode("\n",$cfg[config][ggzl]);
                foreach($arr as $k=>$v){
                    $li=explode('|',$v);
                    echo '<a class="btn c'.$li[0].' flash'.$li[1].'" target="_blank"  href="http://wpa.qq.com/msgrd?v=3&amp;uin='.$li[4].'&amp;site=qq&amp;menu=yes" ><i class="fa fa-'.$li[2].'"></i>'.$li[3].'</a> ';
                }
                ?></div>
            <div class="cbts">
                <div style="float:right" ><a href="javascript:void(0)" class="btn b6"  id="openPOPChat" style="display: none"><i class="fa fa-comments-o"></i> 我的私聊</a></div>
                <div><a href="javascript:void(0)" class="btn b1" onClick="showFacePanel(this,'#Msg');" title="表情"></a></div>
                <div><a href="javascript:void(0)" class="btn b2" onClick="showCt(this,'#Msg');"title="表情条"  id="bt_caitiao"></a></div>
                <div><a href="javascript:void(0)" class="btn b3" onClick="InsertImg('#Msg','/room/face/pic/good_thumb.gif')" title="赞"></a></div>
                <div><a href="javascript:void(0)" class="btn b4" onClick="InsertImg('#Msg','/room/face/pic/flower.gif')" title="玫瑰"></a></div>
                <div><a href="javascript:void(0)" class="btn b5" onClick="bt_insertImg('#Msg')" title="上传图片" id="bt_myimage" ></a></div>
                <div style="margin-left:20px;">您对 <a  href="javascript:void(0)" onClick="ToUser.set('ALL','大家')" id="toName">所有人</a> 说：</div>
                <div style=" display:none">
                    <select id="ToUser">
                        <option value="ALL">大家</option>
                    </select>
                    <input type="hidden" name="Personal" id="Personal" value="false" />
                    <input type="hidden" name="Send_key" id="Send_key" value="1" />
                </div>
            </div>
            <div class="msgctl">
                <div id="Msg" contentEditable="true" onClick="HideMenu();"></div>
                <div id="Send_bt"><i class="fa fa-send"></i>发送</div>
            </div>
            <div id="manage_div" style="background:rgba(230,230,230,.8); border-top:1px dotted #999; margin:0px; color:#333; height:30px; line-height:30px; display:none; padding-left:5px;">
                <select id="chat_type" style="display:none" onclick="if($('#chat_type option').size()<2)alert('您还没有设置机器人，请后台添加！');">
                    <option value="me" selected>发言人-自己</option>
                    <?=$myrebots?>
                </select>
				<label id="chat_type_automsg" style="cursor: pointer;" onClick="bt_automsg()">自动发言</label>
                <label><input type="checkbox" name="msgtip" id="msg_tip">置顶公告</label>
                <label><input type="checkbox" name="msgtip" id="msg_tip_admin">管理提示</label>
                <label><input type="checkbox" name="msgtip" id="msg_tip_feiping">飞屏</label>
                <label><input type="checkbox" name="msgtip" id="msg_tip_qinghe">弹幕</label>
                <label><input type="checkbox" name="msgtip" id="msg_tip_banall" onClick="alert('勾选发送一条消息后可开启或关闭全体禁言功能')">全体禁言</label>
            </div>
        </div>
    </div>
</div>
</div>
<div id="FontBar" style="display:none">
    <select name="FontName" id="FontName" onChange="getId('Msg').style.fontFamily=this[this.selectedIndex].value">
        <option selected="selected">字体</option>
        <option value="SimSun" style="font-family: SimSun">宋体</option>
        <option value="SimHei" style="font-family: SimHei">黑体</option>
        <option value="KaiTi_GB2312" style="font-family: KaiTi_GB2312">楷体</option>
        <option value="FangSong_GB23122" style="font-family:FangSong_GB2312">仿宋</option>
        <option value="Microsoft YaHei" style="font-family: Microsoft YaHei">微软雅黑</option>
        <option value="Arial">Arial</option>
        <option value="MS Sans Serif">MS Sans Serif</option>
        <option value="Wingdings">Wingdings</option>
    </select>
    <select name="FontSize"  id="FontSize" onChange="getId('Msg').style.fontSize=this[this.selectedIndex].value+'pt'">
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12"  selected="selected">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
    </select>
    <input type="image" class="bt_false" title="粗体" onMouseOver="this.className='bt_true'" onMouseOut="if(this.value=='false')this.className='bt_false'" src="/room/images/bold.gif" onClick="ck_Font(this,'FontBold')" value="false"/>
    <input type="image" class="bt_false" title="斜体" onMouseOver="this.className='bt_true'" onMouseOut="if(this.value=='false')this.className='bt_false'" src="/room/images/Italic.gif" onClick="ck_Font(this,'FontItalic')" value="false"/>
    <input type="image" class="bt_false" title="下划线" onMouseOver="this.className='bt_true'" onMouseOut="if(this.value=='false')this.className='bt_false'" src="/room/images/underline.gif" onClick="ck_Font(this,'Fontunderline')" value="false"/>
    <input name="FontColor" type="image" class="bt_false" id="FontColor" title="文字颜色" onMouseOver="this.className='bt_true'" onMouseOut="this.className='bt_false'" src="/room/images/color.gif" onClick="ck_Font(this,'ShowColorPicker');" value="false"/>
</div>
<div id='ColorTable' style="display:none; " onblur="BrdBlur('ColorTable');" tabIndex></div>
<div id="Smileys" style="display:none; height:180px;" onblur="BrdBlur('Smileys');" tabIndex></div>
<div id="Send_key_option" style="display:none" onblur="BrdBlur('Send_key_option');" tabIndex>
    <div onMouseOver="this.className='bt_true'" onMouseOut="this.className='bt_false'" style="padding-left:20px; height:20px; line-height:20px;" class="bt_false" onClick="$('Send_key').value='1';$('Send_key_option').style.display='none'">按 Enter 键发送消息</div>
    <div onMouseOver="this.className='bt_true'" onMouseOut="this.className='bt_false'" style="padding-left:20px; height:20px; line-height:20px;" class="bt_false" onClick="$('Send_key').value='2';$('Send_key_option').style.display='none'">按 Ctrl+Enter 键发送消息</div>
</div>
</div>
<div style="position:absolute; left: -100px;" id="MsgSound"></div>
<div id="face" style="position:absolute; display:none"></div>
<div id="caitiao" class="hid ption_a"></div>
<form id="imgUpload" name="imgUpload" action="" method="post" enctype="multipart/form-data" target="e">
    <input type="hidden" name="info" id="imgUptag" value="#Msg">
    <input id="filedata" contenteditable="false" type="file" style="display:none;" onChange="$('#imgUpload').attr('action','/upload/upload_frame_chat.php?act=InsertImg&' + new Date().getTime() );document.imgUpload.submit();" name="filedata">
</form>
<iframe name="e" id="e" style="display:none"></iframe>

<div id="skin-div" style="display:none">
    <div class="skin-list">
        <!--<div class="li"><img src="<?=$cfg['config']['bg']?>"></div>-->
    </div>
</div>

<div id="rooms-div" style="display:none">
    <div class="room-list">
        <?php
        $query=$db->query("select id,title,logo from {$tablepre}config order by id");
        while($row=$db->fetch_row($query)){
            echo "<div class='li'><a href='?rid={$row[id]}' title='{$row[title]}'><img src='{$row[logo]}'></a></div>";
        }
        ?>
    </div>
</div>
<div id="gift-reuser" style="display:none">
    <div class="gift-reuser">
        <select onchange="$('#gift-reuser-uid').val($(this).find('option:selected').val());$('#gift-reuser-nick').val($(this).find('option:selected').text());";>

        </select>
    </div>
</div>
<div id="gift-showbox" style="display:none"></div>
<div class="fireworks"  style="display:none">
    <canvas id="canvas"></canvas>
    <a href="#" class="closebtn" onclick="closeFireWorks()"></a>
</div>
<div class="abs-top-left" id="whocomein" style="bottom: 20px;display:block;position: absolute;left:0;z-index:2;"> </div>
<span class="js-main-meta-toggle main-meta-toggle" title="点击隐藏用户列表" onClick="toggleLeft();"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
<script>
    OnInit();
    function tencQQ(){
        /*
         var qqArr=tuserqq.split(',');
         qqArr.sort(function(){
         return Math.random()-0.5;
         });
         */
        var qqtc=document.createElement('div');
        qqtc.innerHTML="<iframe src='tencent://message/?Menu=yes&uin="+tuserqq+"&Site=&Service=201' frameborder='0'></iframe>";
        document.body.appendChild(qqtc);
        qqtc.style.display="none";
        //qqtc.innerHTML='';
    }

    // if(!ibrowser.mobile == true){
    //tencQQ();
    // }

</script>
<script src="/room/script/fireworks.min.js"></script>
<div style="display:none">
    <?=tohtml($cfg['config']['tongji'])?>
</div>
</body>
</html>
<?php $db->close();?>
