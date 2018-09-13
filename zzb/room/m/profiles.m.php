<?php
require_once '../../include/common.inc.php';
if($_SESSION['login_gid']<1){header("location:/room/minilogin.php");exit();}
$uid=$_SESSION['login_uid'];

switch($act){
  case "edit":
    $guestexp = '^Guest|'.$cfg['config']['regban']."Guest";
    if(preg_match("/\s+|{$guestexp}/is", $nickname)&&!check_auth('room_admin')){
      $db->query("update {$tablepre}memberfields set kfmsg='$kfmsg' where uid='$uid'");
      $db->query("update {$tablepre}members set  email='$email',realname='$realname',phone='$phone',sex='$sex' where uid='$uid'");
      exit("<script>alert('昵称禁用！');</script>");
    }
    else{
      $db->query("update {$tablepre}memberfields set nickname='$nickname',kfmsg='$kfmsg' where uid='$uid'");
      $db->query("update {$tablepre}members set  email='$email',realname='$realname',phone='$phone',sex='$sex' where uid='$uid'");
      exit("<script>alert('资料修改成功！');parent.window.location.reload();</script>");
    }
    break;
  case "editpwd":
    if($pwd1!=$pwd2){
      exit("<script>alert('新密码不一致！');</script>");
    }else{
      $query=$db->query("select * from {$tablepre}members where uid='$uid' and password='".md5($oldpwd)."'");
      if($db->num_rows($query)>0){
        $db->query("update {$tablepre}members set  password='".md5($pwd1)."' where uid='$uid'");
        exit("<script>alert('密码修改成功！');</script>");
      }
      else{
        exit("<script>alert('旧密码错误！');</script>");
      }
    }
    break;
  case "edit_uface":
    $img='/face/p1/'.$uid.'.gif';
    if(substr($uface,0,14)=='data:image/png'){
      $filename='../../face/p1/'.$uid.'.gif';
      $handle = fopen($filename, 'w+');
      $uface=base64_decode(str_replace('data:image/png;base64,','',$uface));
      fwrite($handle, $uface);
      fclose($handle);
    }else{
      $img=$uface;
      @copy('../..'.$uface,'../face/p1/'.$uid.'.gif');
    }
    $img.='?'.time();
    $db->query("update {$tablepre}memberfields set uface='$img' where uid='{$uid}'");
    exit("<script>alert('头像修改成功！');</script>");
    break;
}


$userinfo=$db->fetch_row($db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.uid='{$uid}'"));
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width">
  <title>用户中心
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
  <link rel="stylesheet" href="./css/profiles.min.css">
  <link rel="apple-touch-icon" href="images/dico.png"/>
  <link rel="icon" href="images/dico.png"/>
  <script src="../script/jquery-1.11.1.min.js"></script>
  <script src="./assets/js/amazeui.min.js"></script>
  <!--<script src="//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js"></script>-->
  <script src="script/layer.js"></script>
  <script src="script/iscroll-zoom-min.js"></script>
  <script src="script/hammer.min.js"></script>
  <script src="script/lrz.all.bundle.js"></script>
  <script src="script/PhotoClip.js"></script>
  <script>
    function bt_logout(){
      layer.open({
        content: '确定退出登录？'
        ,btn: ['是', '否']
        ,yes: function(index){
          location.href='/room/minilogin.php?act=logout';
          layer.close(index);
        }
      });
    }
    function openPopIfrmae(title,src){

      var html='  <header data-am-widget="header" class="am-header am-header-default iframe_header"><div class="am-header-left am-header-nav" ><a href="javascript:;"  onclick="layer.closeAll()" style="height: 35px;    line-height: 35px;" >';
      html+='    <i class="am-header-icon am-icon-chevron-left" style="font-size: 25px;    margin-top: 8px;"></i>          </a></div>';
      html+=' <h1 class="am-header-title">'+title+'</h1>';
      html+='<div class="am-header-right am-header-nav"></div></header>';
      html+='<iframe frameborder=0 width=100% height=100% marginheight=0 marginwidth=0 scrolling=auto src="'+src+'"></iframe>';
      var pageii = layer.open({
        type: 1
        ,content: html
        ,anim: 'up'
        ,style: 'position:fixed; left:0; top:0; width:100%; height:100%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s;    border-radius: 0px;'
      });
      $("#layui-m-layer"+pageii+" .layui-m-layercont").height($(window).height()-$("#layui-m-layer"+pageii+" .iframe_header").height());
      $("#layui-m-layer"+pageii+" .layui-m-layercont iframe").height($("#layui-m-layer"+pageii+" .layui-m-layercont").height());
    }
    function toggleUface(e){
      if(e.value=='上传头像'){
        e.value='选择头像';
        $('.user_upface').show();
        $('.tx-list').hide();
        $('.bc').click(function(){$('#btnCrop').click();});
      }else{
        e.value='上传头像';
        $('.user_upface').hide();
        $('.tx-list').show();
        $('.bc').click(function(){});
      }
    }
    $(function(){
      $(".tx-list img").click(function(){
        $("#uface").val($(this).attr('src'));
        $("#uface_img")[0].src=$(this).attr('src');
      });
    })
  </script>

</head>
<body style=" background: #f8f8f8; /*background-image: url(); background-size: cover; overflow: hidden; background-position: initial initial; background-repeat: no-repeat no-repeat;*/">
  <header data-am-widget="header" class="am-header am-header-default am-header-fixed header" >
    <div class="am-header-left am-header-nav">
      <a href="index.php" style="height: 35px;    line-height: 35px;" >
        <i class="am-header-icon am-icon-chevron-left" style="font-size: 25px;    margin-top: 8px;"></i>
      </a>
    </div>
    <h1 class="am-header-title">用户中心</h1>
    <div class="am-header-right am-header-nav" >
      <a href="javascript:bt_logout();"  style="height: 35px;    line-height: 35px;" ><i class="am-header-icon am-icon-power-off" style="font-size: 25px;    margin-top: 8px;"></i></a>
    </div>
  </header>
  <div class="main">
    <div class="head">
      <div class="uface"><img src="<?=$userinfo['uface']?>?<?=time()?>" id="uface_img"> </div>
      <div class="unick"><?=$userinfo['nickname']?></div>
    </div>
    <div data-am-widget="tabs"    data-am-tabs-noswipe="1"     class="am-tabs am-tabs-d2 info-tabs"   >
      <ul class="am-tabs-nav am-cf">
        <li class="am-active"><a href="[data-tab-panel-0]">资料信息</a></li>
        <li class=""><a href="[data-tab-panel-1]">编辑资料</a></li>
        <li class=""><a href="[data-tab-panel-2]">修改头像</a></li>
        <li class=""><a href="[data-tab-panel-3]">修改密码</a></li>
      </ul>
      <div class="am-tabs-bd" >
        <div data-tab-panel-0 class="am-tab-panel am-active">
          <ul class="am-list am-list-static">
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >金币：</div>
                <div class="am-u-sm-9"><?=$userinfo['gold']?>个 <a href="javascript:;" onclick="openPopIfrmae('金币兑换','/user/recharge.php');" style="color:#ec971f">兑换</a></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >余额：</div>
                <div class="am-u-sm-9"><?=$userinfo['money']?>元 <a href="javascript:;" onclick="openPopIfrmae('充值提现','/user/withdraw.php');"  style="color:#ec971f">提现</a></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >登录名</div>
                <div class="am-u-sm-9"><?=$userinfo['username']?></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >用户组</div>
                <div class="am-u-sm-9"><?php $arr=group_info($userinfo['gid']); echo $arr['title']."-".$arr['sn'];?></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >注册时间</div>
                <div class="am-u-sm-9"><?php echo date('Y-m-d H:i:s',$userinfo['regdate']);?></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >最近登录</div>
                <div class="am-u-sm-9"><?php echo date('Y-m-d H:i:s',$userinfo['lastactivity']);?> (<?=$userinfo['logins']?>次)</div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >登录IP</div>
                <div class="am-u-sm-9"><?=$userinfo['regip']?></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >邮箱</div>
                <div class="am-u-sm-9"><?=$userinfo['email']?></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >QQ</div>
                <div class="am-u-sm-9"><?=$userinfo['realname']?></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >手机</div>
                <div class="am-u-sm-9"><?=$userinfo['phone']?></div>
              </div>
            </li>
          </ul>
        </div>
        <div data-tab-panel-1 class="am-tab-panel ">
          <form action="" method="post" enctype="application/x-www-form-urlencoded" target="e">
            <input type="hidden" value="edit" name="act">
          <ul class="am-list am-list-static">
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >昵称</div>
                <div class="am-u-sm-9"><input type="text" class="input" placeholder="昵称" value="<?=$userinfo['nickname']?>" name="nickname"></div>
              </div>
            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >邮箱</div>
                <div class="am-u-sm-9"><input type="text" class="input" placeholder="邮箱" value="<?=$userinfo['email']?>" name="email"></div>
              </div>


            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >QQ</div>
                <div class="am-u-sm-9"><input type="number" class="input" placeholder="QQ" value="<?=$userinfo['realname']?>" name="realname"></div>
              </div>


            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >手机</div>
                <div class="am-u-sm-9"><input type="number" class="input" placeholder="手机" value="<?=$userinfo['phone']?>" name="phone"></div>
              </div>


            </li>
            <li>
              <div  class="am-g">
                <div class="am-u-sm-3 label" >自我介绍</div>
                <div class="am-u-sm-9"><textarea row=4 name="kfmsg" id="kfmsg" style="width:100%; height: 80px;"  placeholder="自我介绍" ><?=strip_tags(tohtml($userinfo['kfmsg']))?></textarea></div>
              </div>

            </li>
            <li style="text-align: center">
              <button type="submit" class="am-btn am-btn-danger am-radius">保 存</button>
            </li>
          </ul>
            </form>
        </div>
        <div data-tab-panel-2 class="am-tab-panel ">
          <form action="" method="post" enctype="application/x-www-form-urlencoded" target="e">
            <input type="hidden" name="act" value="edit_uface">
            <input type="hidden" name="uface" id="uface">
            <div class="tx-list">
              <ul>
                <li><img src="/face/rebot/1.gif"></li>
                <li><img src="/face/rebot/2.gif"></li>
                <li><img src="/face/rebot/3.gif"></li>
                <li><img src="/face/rebot/4.gif"></li>
                <li><img src="/face/rebot/5.gif"></li>
                <li><img src="/face/rebot/6.gif"></li>
                <li><img src="/face/rebot/7.gif"></li>
                <li><img src="/face/rebot/8.gif"></li>
                <li><img src="/face/rebot/9.gif"></li>
                <li><img src="/face/rebot/10.gif"></li>
                <li><img src="/face/rebot/11.gif"></li>
                <li><img src="/face/rebot/12.gif"></li>
                <li><img src="/face/rebot/13.gif"></li>
                <li><img src="/face/rebot/14.gif"></li>
                <li><img src="/face/rebot/15.gif"></li>
                <li><img src="/face/rebot/16.gif"></li>
                <li><img src="/face/rebot/17.gif"></li>
                <li><img src="/face/rebot/18.gif"></li>
                <li><img src="/face/rebot/19.gif"></li>
                <li><img src="/face/rebot/20.gif"></li>
                <li><img src="/face/rebot/21.gif"></li>
                <li><img src="/face/rebot/22.gif"></li>
                <li><img src="/face/rebot/23.gif"></li>
                <li><img src="/face/rebot/24.gif"></li>
                <li><img src="/face/rebot/25.gif"></li>
                <li><img src="/face/rebot/26.gif"></li>
                <li><img src="/face/rebot/27.gif"></li>
                <li><img src="/face/rebot/28.gif"></li>
                <li><img src="/face/rebot/29.gif"></li>
                <li><img src="/face/rebot/30.gif"></li>
                <li><img src="/face/rebot/31.gif"></li>
                <li><img src="/face/rebot/32.gif"></li>
                <li><img src="/face/rebot/33.gif"></li>
                <li><img src="/face/rebot/34.gif"></li>
                <li><img src="/face/rebot/35.gif"></li>
                <li><img src="/face/rebot/36.gif"></li>
                <li><img src="/face/rebot/37.gif"></li>
                <li><img src="/face/rebot/38.gif"></li>
                <li><img src="/face/rebot/39.gif"></li>
                <li><img src="/face/rebot/40.gif"></li>
                <li><img src="/face/rebot/41.gif"></li>
                <li><img src="/face/rebot/42.gif"></li>
              </ul>
            </div>
            <script>
              var pc ;
              function simg1(e){
                pc = new PhotoClip('#clipArea');
                pc.load(e.files[0]);
              }
              function vimg1(str){
                $("#uface").val(str);
                $("#uface_img")[0].src=str;
              }
            </script>
            <div class="user_upface" style="display: none;height: 180px; overflow: hidden">
              <div id="clipArea" style="height: 180px;"></div>
              <div style="position: relative; top: -35px; text-align: center; z-index: 2;">
                <input type="button" onclick="$('#simg').click()" value="打开图片" class="op" style="width:60px; height: 25px; border:0px;  margin-top: 5px;    background: #2b8ae8;color: #fff; border-radius: 5px; display: ">
                <input type="button" onclick="vimg1(pc.clip());" id="btnCrop" value="预览头像" class="op" style="width:60px; height: 25px; border:0px;  margin-top: 5px;    background: #2b8ae8;color: #fff; border-radius: 5px; display: " >

              </div>
              <input id="simg" type="file" size="20" name="filedata" class="input" style="display:none" onchange="simg1(this)" accept="image/jpeg, image/x-png, image/gif">

            </div>
            <div class="user_save">
              <input type="button" onclick="toggleUface(this);" value="上传头像" class="bc" style="width:60px; height: 30px; border:0px;  margin-top: 5px;    background: #0C0;color: #fff; border-radius: 5px;">
              <input type="submit" value="保存头像" class="bc" style="width:60px; height: 30px; border:0px;  margin-top: 5px;    background: #ff6464;color: #fff; border-radius: 5px;">
            </div>

          </form>
        </div>
        <div data-tab-panel-3 class="am-tab-panel ">
          <form action="" method="post" enctype="application/x-www-form-urlencoded" target="e">
            <input type="hidden" value="editpwd" name="act">
            <ul class="am-list am-list-static">
              <li>
                <div  class="am-g">
                  <div class="am-u-sm-3 label" >旧密码</div>
                  <div class="am-u-sm-9"><input name="oldpwd" type="password" id="oldpwd"  class="input" ><input type="hidden" name="uid" value="<?=$userinfo['uid']?>"><input type="hidden" name="act" value="editpwd"></div>
                </div>
              </li>
              <li>
                <div  class="am-g">
                  <div class="am-u-sm-3 label" >新密码</div>
                  <div class="am-u-sm-9"><input name="pwd1" type="password" id="pwd1"  class="input"></div>
                </div>


              </li>
              <li>
                <div  class="am-g">
                  <div class="am-u-sm-3 label" >确认密码</div>
                  <div class="am-u-sm-9"><input name="pwd2" type="password" id="pwd2"  class="input"></div>
                </div>


              </li>
              <li style="text-align: center">
                <button type="submit" class="am-btn am-btn-danger am-radius">保 存</button>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>
<iframe name="e" style="display: none"></iframe>

</body>
</html>