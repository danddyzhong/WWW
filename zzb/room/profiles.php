<?php
require_once '../include/common.inc.php';
switch($act){
	case "edit":
		$uid=$_SESSION['login_uid'];
		$guestexp = '^Guest|'.$cfg['config']['regban']."Guest";
		if(preg_match("/\s+|{$guestexp}/is", $nickname)&&!check_auth('room_admin')){
			$msg="<script>$('.tab').hide();$('#tab_2').show();alert('昵称禁用！');</script>";
			$db->query("update {$tablepre}memberfields set mood='$mood' where uid='$uid'");
			$db->query("update {$tablepre}members set  email='$email',realname='$realname',phone='$phone',sex='$sex' where uid='$uid'");
		}
		else{
			$db->query("update {$tablepre}memberfields set nickname='$nickname',mood='$mood',kfmsg='$kfmsg' where uid='$uid'");
			$db->query("update {$tablepre}members set  email='$email',realname='$realname',phone='$phone',sex='$sex' where uid='$uid'");
			header("location:?uid={$uid}");
		}
	break;
	case "editpwd":
		$uid=$_SESSION['login_uid'];
		if($pwd1!=$pwd2){
			$msg="<script>$('.tab').hide();$('#tab_3').show();alert('新密码不一致！');</script>";
		}else{
			$query=$db->query("select * from {$tablepre}members where uid='$uid' and password='".md5($oldpwd)."'");
			if($db->num_rows($query)>0){
				$db->query("update {$tablepre}members set  password='".md5($pwd1)."' where uid='$uid'");
				$msg="<script>$('.tab').hide();$('#tab_3').show();alert('密码已修改！');</script>";
			}
			else
			$msg="<script>$('.tab').hide();$('#tab_3').show();alert('旧密码错误！');</script>";
		}
	break;
    case "edit_uface":
      $img='/face/p1/'.$_SESSION['login_uid'].'.gif';
      if(substr($uface,0,14)=='data:image/png'){
        $filename='../face/p1/'.$_SESSION['login_uid'].'.gif';
        $handle = fopen($filename, 'w+');
        $uface=base64_decode(str_replace('data:image/png;base64,','',$uface));
        fwrite($handle, $uface);
        fclose($handle);
      }else{
        $img=$uface;
        @copy('..'.$uface,'../face/p1/'.$_SESSION['login_uid'].'.gif');
      }
      $img.='?'.time();
      $db->query("update {$tablepre}memberfields set uface='$img?' where uid='{$_SESSION['login_uid']}'");
    break;
}

if(stripos($uid,'x')!==false)$uid=$_SESSION['login_uid'];
$userinfo=$db->fetch_row($db->query("select m.*,ms.* from {$tablepre}members m,{$tablepre}memberfields ms  where m.uid=ms.uid and m.uid='{$uid}'")); 
?>
<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
<link href="../images/base.css" rel="stylesheet" type="text/css"  />
<link href="css/cropbox.css" rel="stylesheet" type="text/css"  />
<script src="script/jquery-1.11.1.min.js"></script>
<script src="script/swfobject.js" ></script>
<title>用户资料</title>
<style>
  ::-webkit-scrollbar { width: 5px; height: 5px}
  ::-webkit-scrollbar-button:vertical { display: none}
  ::-webkit-scrollbar-track:vertical { background-color: #000}
  ::-webkit-scrollbar-track-piece { background-color: #eee}
  ::-webkit-scrollbar-thumb:vertical { margin-right: 5px; background-color: #bbb}
  ::-webkit-scrollbar-thumb:vertical:hover { background-color: #999}
  ::-webkit-scrollbar-corner:vertical { background-color: #535353}
  ::-webkit-scrollbar-resizer:vertical { background-color: #FF6E00}
  *{font-family: 'Microsoft YaHei UI', 'Microsoft YaHei', SimSun, 'Segoe UI', Tahoma, Helvetica, Sans-Serif;}
.main,html,body { width: 460px; background: #FDFDFD }
.head { height: 119px; padding-top: 30px; background: url(images/b1.jpg) no-repeat }
#nav {  width: 460px; background:#f8f8f8;    border-bottom: #e8e8e8 1px solid; }
#nav a { float: left; display: block; padding: 5px; width: 60px; color: #666; text-align: center; text-decoration: none; font-size: 14px;border-bottom: #f8f8f8 2px solid;}
#nav .active { color: #ff6464;border-bottom: #ff6464 2px solid;}
#tab { width: 460px; height: 400px; overflow: hidden; font-size: 12px; color: #666 }
#tab td { height: 30px; line-height: 30px; }
#tab tr { border-bottom: 1px dotted #EEEEEE }
#tab input {  border:0px; border-bottom:1px solid #333; width:240px;}
.th { width: 60px; padding-right: 10px; color: #333 }
.user_pic{ width:120px; height:150px; position:absolute; top:203px; right:0px; border:5px solid #FFF}
.user_pic img{width:110px; height:150px; border:1px #CCCCCC solid; padding:1px; }
.bc { border:0px; padding:2px;width:40px; height:20px; color:#FFF; background: #0C0}
.user_edit_pic{ width:460px; height:350px; position:absolute;top:203px; right:0px; background:#FDFDFD; text-align:center; padding-top:30px; display:none}
  #tab_4  .user_upface{
    height: 294px; padding: 15px 9px 5px 11px; margin-right: -10px; margin-top: -10px; width: 440px; overflow: auto; overflow-x: hidden;
  }
  #tab_4 .tx-list{
    height: 294px; padding: 15px 9px 5px 11px; margin-right: -10px; margin-top: -10px; width: 440px; overflow: auto; overflow-x: hidden;
  }

  #tab_4 .tx-list ul{width: 100%; overflow: hidden;}
  #tab_4 .tx-list ul li{width: 15%;height: 15%; float: left; overflow: hidden; margin: 0.8%;}
  #tab_4 .tx-list ul li img{width: 100%; border-radius: 50%;  }
  .user_save { height: 36px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; border-top: #e8e8e8 1px solid; text-align: center; margin: 0 -10px;   padding: 20px 0; text-align: center; }
  position: relative;
  text-align: center;
</style>
</head>

<body style="">
<div class="main">
  <div class="head">
    <div class="m10 fl" style="text-shadow:2px 2px 2px #000;">
      <div class="fl mr10" style="width:74px; height:74px;"><img  id="uface_img" src='<?=$userinfo['uface']?>?<?=time()?>' style="width:74px; height:74px; border:0px; border-radius: 100%;border: #3189c1 2px solid;"/></div>
      <div class="fl" style="width:350px; height:74px;">
        <div style="height:34px; overflow:hidden"><span class="ttff f24 cfff">
          <?=$userinfo['nickname']?>
          </span> &nbsp;<span class="ttff  f14 cfff">
          <?=$userinfo['username']?>
          </span></div>
        <div>
          <?=showstars($userinfo['onlinetime'])?>
        </div>
        <div class="ttff f14 cfff" style="height:20px; overflow:hidden">
          <?php $arr=group_info($userinfo['gid']); echo $arr['title']."-".$arr['sn'];?>
        </div>
      </div>
    </div>
    <div class="cl"></div>
    <div class="fl" id="nav">

    <a href="javascript://" onClick="$('.tab').hide();$('#tab_1').show()" class="active">用户资料</a>
    <?php
    if($_SESSION['login_gid']>0&&$_SESSION['login_uid']==$uid){
	?>
    <a href="javascript://" onClick="$('.tab').hide();$('#tab_2').show()">编辑资料</a>
      <a href="javascript://" onClick="$('.tab').hide();$('#tab_4').show()">修改头像</a>
    <a href="javascript://" onClick="$('.tab').hide();$('#tab_3').show()">修改密码</a>
      <a href="javascript://" style="float: right" onClick="top.location.href='/room/minilogin.php?act=logout&rid=<?=$rid?>'">退出</a>
    <?php }?>
    </div>
    <div class="cl"></div>
  </div>
  <div id="tab">
    <div id="tab_1" style="margin:10px;" class="ttff tab ">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="th">用户性别：</td>
          <td><?php $sex=array("女","男","保密");echo  $sex[$userinfo['sex']];?>&nbsp;&nbsp;&nbsp;&nbsp;
		  ￥：<font style="color:#F60"><?=$userinfo['money']?></font>
		  <a href="/user/withdraw.php" style="color:#666">提现</a>
		  </td>
        </tr>
        <tr>
          <td  class="th">登录次数：</td>
          <td><!--<?php echo round($userinfo['onlinetime'] / 60/60, 2).'小时';?>&nbsp;-->
            <?=$userinfo['logins']?>
            次</td>
        </tr>
        <tr>
          <td class="th">注册时间：</td>
          <td><?php echo date('Y-m-d H:i:s',$userinfo['regdate']);?>&nbsp;</td>
        </tr>
        <tr>
          <td  class="th">用户组：</td>
          <td><?php $arr=group_info($userinfo['gid']); echo $arr['title']."-".$arr['sn'];?>
            &nbsp;</td>
        </tr>
<?php
if($userinfo['gid']=='3'){


?>
        <tr>
          <td class="th">客服手机：</td>
          <td><?=$userinfo['phone']?>
            &nbsp;</td>
        </tr>
        <tr>
          <td class="th">客服QQ：</td>
          <td><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$userinfo['realname']?>&site=qq&menu=yes">
    <?=$userinfo['realname']?></a>
            &nbsp;</td>
        </tr>
<?php
}
//后台管理资料
if(check_auth('user_info_gl')){

?>
        <tr>
          <td class="th">登录IP：</td>
          <td><?=$userinfo['regip']?>
            &nbsp;</td>
        </tr>
        <tr>
          <td class="th">邮箱：</td>
          <td><?=$userinfo['email']?>
            &nbsp;</td>
        </tr>
        <tr>
          <td class="th">手机：</td>
          <td><?=$userinfo['phone']?>
            &nbsp;</td>
        </tr>
        <tr>
          <td class="th">QQ：</td>
          <td><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$userinfo['realname']?>&site=qq&menu=yes">
    <?=$userinfo['realname']?></a>
            &nbsp;</td>
        </tr>
        <tr>
          <td class="th">用户客服：</td>
          <td>
          	<?=user_info($userinfo['fuser'],'{nickname}')?>
          </td>
        </tr>
        <tr>
          <td class="th">推广人：</td>
          <td>
            <?=user_info($userinfo['tuser'],'{nickname}')?>
          </td>
        </tr>
        <tr>
          <td class="th">备注：</td>
          <td><?=$userinfo['sn']?>
            &nbsp;</td>
        </tr>
        <?php }
//end后台管理资料
?>
      </table>
      <div class="user_pic" style="display:none"><img src="../face/img.php?t=p2&u=<?=$userinfo['uid']?>"></div>
    </div>
    
    <div id="tab_2" style="margin:10px;" class="ttff tab hide">
    <form action="" method="post" enctype="application/x-www-form-urlencoded">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
        <tr>
          <td class="th">用户昵称：</td>
          <td><input name="nickname" type="text" id="nickname" value="<?=$userinfo['nickname']?>" style="width:120px;">

          <select name="sex" id="sex" style="display: none">
            <option value="<?=$userinfo['sex']?>"><?php $sex=array("女","男","保密");echo  $sex[$userinfo['sex']];?></option>
            <option value="1">男</option>
            <option value="0">女</option>
            <option value="2">保密</option>
          </select>
          <input type="hidden" name="uid" value="<?=$userinfo['uid']?>"><input type="hidden" name="act" value="edit"></td>
        </tr>
        <tr>
          <td class="th">联系邮箱：</td>
          <td><input name="email" type="text" id="email" value="<?=$userinfo['email']?>" style=" width:115px">QQ:<input name="realname" type="text" id="realname" value="<?=$userinfo['realname']?>" style=" width:100px;"></td>
        </tr>
        
                <tr>
          <td  class="th">联系手机：</td>
          <td><input name="phone" type="text" id="phone" value="<?=$userinfo['phone']?>"> 
            </td>
        </tr>
		<tr>
          <td colspan="2"  class="th">自我介绍：</td>
          </tr>
		<tr>
		  <td colspan="2"  class="th"><textarea row=4 name="kfmsg" id="kfmsg" style="width:100%; height: 80px;" ><?=strip_tags(tohtml($userinfo['kfmsg']))?></textarea></td>
		  </tr>
                                <tr>
          <td> <input type="submit" value="保存" class="bc" style="width:60px; height: 30px; border:0px;  margin-top: 5px;    background: #ff6464;color: #fff; border-radius: 5px;"></td>
          <td></td>
        </tr>
      </table>
      </form>
      <div class="user_pic" style="display:none"><img src="../face/img.php?t=p2&u=<?=$userinfo['uid']?>"></div>
      <div class="user_edit_pic"><div id="epf"></div>
      <input type="button" onClick="saveToServer();" class="bc"  value="确定"  style="width:40px; border:0px;"> 
      <input type="button" onClick="$('.user_edit_pic').hide()" class="bc"  value="取消" style="width:40px; border:0px; background:#666"></div>
    </div>

<div id="tab_3" style="margin:10px;" class="ttff tab hide">
    <form action="" method="post" enctype="application/x-www-form-urlencoded">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
        <tr>
          <td class="th">旧密码：</td>
          <td><input name="oldpwd" type="password" id="oldpwd" ><input type="hidden" name="uid" value="<?=$userinfo['uid']?>"><input type="hidden" name="act" value="editpwd"></td>
        </tr>
        <tr>
          <td  class="th">新密码：</td>
          <td><input name="pwd1" type="password" id="pwd1">  </td>
        </tr>
        <tr>
          <td class="th">确认密码：</td>
          <td><input name="pwd2" type="password" id="pwd2"></td>
        </tr>
                                <tr>
                                  <td ><input type="submit" value="保存" class="bc" style="width:60px; height: 30px; border:0px;  margin-top: 5px;    background: #ff6464;color: #fff; border-radius: 5px;"></td>
                                  <td>&nbsp;</td>
          </tr>
      </table>
      </form>
    </div>
    <div id="tab_4" class="ttff tab hide">
      <form action="" method="post" enctype="application/x-www-form-urlencoded">
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
        <div class="user_upface" style="display: none">
          <div class="container">
            <div class="imageBox">
              <div class="thumbBox"></div>
              <div class="spinner" style="display: none"></div>
            </div>
            <div class="action">
              <div class="new-contentarea tc">
                <a href="javascript:void(0)" class="upload-img">
                  <label for="upload-file">上传</label>
                </a>
                <input type="file" class="" name="upload-file" id="upload-file" />
              </div>
              <input type="button" id="btnCrop"  class="Btnsty_peyton" value="预览">

              <input type="button" id="btnZoomOut" class="Btnsty_peyton" value="-" style="width: 20px!important;" >
              <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+" style="width: 20px!important;margin-right: 17px;" >
            </div>
            <div class="cropped"></div>
          </div>
        </div>
        <div class="user_save">
          <input type="button" onclick="toggleUface(this);" value="上传头像" class="bc" style="width:60px; height: 30px; border:0px;  margin-top: 5px;    background: #0C0;color: #fff; border-radius: 5px;">
          <input type="submit" value="保存头像" class="bc" style="width:60px; height: 30px; border:0px;  margin-top: 5px;    background: #ff6464;color: #fff; border-radius: 5px;">
        </div>
      </form>
    </div>
  </div>
</div>

<?=$msg?>
<script src="script/cropbox.js"></script>
<script>
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

$(function() {
  $("#nav a").click(function(){
    $("#nav a").removeClass("active");
    $(this).addClass("active");
  });
  $("#tab_4 img").click(function(){
      $("#uface").val($(this).attr('src'));
      $("#uface_img")[0].src=$(this).attr('src');
  });
})

</script>
<script type="text/javascript">
$(function() {
    var options =
    {
      thumbBox: '.thumbBox',
      spinner: '.spinner',
      imgSrc: 'img/avatar.jpg'
    }
    var cropper = $('.imageBox').cropbox(options);
    $('#upload-file').on('change', function(){
      var reader = new FileReader();
      reader.onload = function(e) {
        options.imgSrc = e.target.result;
        cropper = $('.imageBox').cropbox(options);

      }
      reader.readAsDataURL(this.files[0]);
      this.files = [];
    })
    $('#btnCrop').on('click', function(){
      var img = cropper.getDataURL();
      $("#uface").val(img);
      $("#uface_img")[0].src=img;

      $('.cropped').html('');
      $('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;" ><p>64px*64px</p>');
      $('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
      $('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:180px;margin-top:4px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>');
    })
    $('#btnZoomIn').on('click', function(){
      cropper.zoomIn();
    })
    $('#btnZoomOut').on('click', function(){
      cropper.zoomOut();
    })
  });
</script>
</body>
</html>
