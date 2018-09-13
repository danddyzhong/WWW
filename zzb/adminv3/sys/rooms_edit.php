<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sys_base')===false)exit("没有权限！");

if($act=="config_edit"){
	$arr[title]=$title;
	$arr[keys]=$keys;
	$arr[dc]=$dc;
	$arr[logo]=$logo;
	$arr[ico]=$ico;
	$arr[bg]=$bg;
	$arr[msgban]=$msgban;
	$arr[state]=$state;
	$arr[pwd]=$pwd;
	$arr[msgaudit]=$msgaudit;
	$arr[msglog]=$msglog;
	$arr[logintip]=$logintip;
	$arr[loginguest]=$loginguest;
	$arr[loginqq]=$loginqq;
	$arr[tongji]=$tongji;
	$arr[regban]=$regban;
	$arr[msgblock]=$msgblock;
	$arr[kcb]=$kcb;
	$arr[tserver]=$tserver;
	$arr[livefp]=$livefp;
	$arr[phonefp]=$phonefp;
	$arr[rebots]=$rebots;
	$arr[loginimg]=$loginimg;
	$arr[acl]=@implode(',',$gids);
    $arr[touzhu_url]=trim($touzhu_url);
	$arr[sysmsg_state]=$sysmsg_state;
	$arr[sysmsg_order]=$sysmsg_order;
	$arr[sysmsg_timer]=$sysmsg_timer;
	$arr[ggzl]=$ggzl;
	config_edit($arr,$id);
}


$query=$db->query("select * from  {$tablepre}config where id='$id'");
$row=$db->fetch_row($query);
?>
<!DOCTYPE HTML>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/bui-min.css" rel="stylesheet" type="text/css" />
<link href="../assets/css/page-min.css" rel="stylesheet" type="text/css" />
<!-- 下面的样式，仅是为了显示代码，而不应该在项目中使用-->
<link href="../assets/css/prettify.css" rel="stylesheet" type="text/css" />
<style type="text/css">
code {
	padding: 0px 4px;
	color: #d14;
	background-color: #f7f7f9;
	border: 1px solid #e1e1e8;
}
input, button {
	vertical-align:middle
}
</style>
</head>
<body>
<div class="container">
  <form action="" method="post" enctype="application/x-www-form-urlencoded">
    <table class="table table-bordered table-hover definewidth m10">
      <tr>
        <td class="tableleft" style="width:100px;">房间标题：</td>
        <td><input name="title" type="text" id="title" style="width:400px;" value="<?=$row[title]?>"/></td>
      </tr>
      <tr>
        <td class="tableleft">关 键 字：</td>
        <td><textarea name="keys" rows="2" id="keys" style="width:400px;"><?=$row[keys]?>
</textarea></td>
      </tr>
      <tr>
        <td class="tableleft">房间描述：</td>
        <td><textarea name="dc" id="dc" style="width:400px;"><?=$row[dc]?>
</textarea></td>
      </tr>
      <tr>
        <td class="tableleft">LOGO：</td>
        <td><input name="logo" type="text" id="logo" style="width:400px;" value="<?=$row[logo]?>"/>
          <button  type="button" class="button button-mini button-success"><span id="logo_up_bnt"></span></button></td>
      </tr>
      <tr>
        <td class="tableleft">ICO：</td>
        <td><input name="ico" type="text" id="ico" style="width:400px;" value="<?=$row[ico]?>"/>
          <button  type="button" class="button button-mini button-success" ><span id="ico_up_bnt"></span></button></td>
      </tr>
      <tr>
        <td class="tableleft">背景：</td>
        <td><input name="bg" type="text" id="bg" style="width:400px;" value="<?=$row[bg]?>"/>
          <button  type="button" class="button button-mini button-success" ><span id="bg_up_bnt"></span></button></td>
      </tr>
	        <tr>
        <td class="tableleft">课程表：</td>
        <td><input name="kcb" type="text" id="kcb" style="width:400px;" value="<?=$row[kcb]?>"/>
          <button  type="button" class="button button-mini button-success" ><span id="kcb_up_bnt"></span></button></td>
      </tr>
      <tr>
        <td class="tableleft">登录提示图片：</td>
        <td><input name="loginimg" type="text" id="loginimg" style="width:400px;" value="<?=$row[loginimg]?>"/>
          <button  type="button" class="button button-mini button-success" ><span id="loginimg_up_bnt"></span></button></td>
      </tr>
      <tr>
        <td class="tableleft">聊天过滤：</td>
        <td><textarea name="msgban" id="msgban" style="width:400px;"><?=$row[msgban]?>
</textarea></td>
      </tr>
      <tr>
        <td class="tableleft">房间状态：</td>
        <td><select name="state" id="state" style="width:60px;" onChange="if(this.value=='2')$('#pwd_s').show();else $('#pwd_s').hide(); ">
            <option value="<?=$row[state]?>">
            <?=$row[state]?>
            :不变</option>
            <option value="1">1开启</option>
            <option value="0">0关闭</option>
            <option value="2">2加密</option>
          </select>
          <label id="pwd_s" style="display:none"> 密码：
            <input name="pwd" type="text" id="pwd" value="<?=$row[pwd]?>"/>
          </label></td>
      </tr>
      <tr>
        <td class="tableleft">允许进入组：</td>
        <td>
<?php
$query=$db->query("select * from {$tablepre}auth_group order by id desc");
$group_arr=explode(',',$row['acl']);
while($trow=$db->fetch_row($query)){

	if(in_array($trow[id],$group_arr))$checked=" checked='CHECKED'";
	else $checked="";
	echo "  <label><input type='checkbox' name='gids[]' value='{$trow[id]}' {$checked}>{$trow[title]}</label> ";
 }
?>
</td>
      </tr>
      <tr>
        <td class="tableleft">&nbsp;</td>
        <td>消息屏蔽：
          <label for="msgblock"></label>
          <select name="msgblock" id="msgblock" style="width:70px;">
            <option value="<?=$row[msgblock]?>">
            <?=$row[msgblock]?>
            :不变</option>
            <option value="1">1是</option>
            <option value="0">0否</option>
          </select>
          &nbsp;消息记录：
          <label for="msglog"></label>
          <select name="msglog" id="msglog" style="width:70px;">
            <option value="<?=$row[msglog]?>">
            <?=$row[msglog]?>
            :不变</option>
            <option value="1">1是</option>
            <option value="0">0否</option>
          </select>
         &nbsp; 消息审核：
          <label for="msgaudit"></label>
          <select name="msgaudit" id="msgaudit" style="width:70px;">
            <option value="<?=$row[msgaudit]?>">
              <?=$row[msgaudit]?>
              :不变</option>
            <option value="1">1是</option>
            <option value="0">0否</option>
          </select></td>
      </tr>
      <tr>
        <td class="tableleft">&nbsp;</td>
        <td>登录提示：
          <label for="logintip"></label>
          <select name="logintip" id="select6" style="width:70px;">
            <option value="<?=$row[logintip]?>">
            <?=$row[logintip]?>
            :不变</option>
            <option value="1">1是</option>
            <option value="0">0否</option>
          </select>
          &nbsp;游客登录：
          <select name="loginguest" id="loginguest" style="width:70px;">
            <option value="<?=$row[loginguest]?>">
            <?=$row[loginguest]?>
            :不变</option>
            <option value="1">1是</option>
            <option value="0">0否</option>
          </select>

&nbsp;</td>
      </tr>
      <tr>
        <td class="tableleft">统计代码：</td>
        <td><textarea name="tongji" id="tongji" style="width:400px;"><?=tohtml($row[tongji])?>
</textarea></td>
      </tr>
    </table>
    <table class="table table-bordered table-hover definewidth m10">
          <tr style="display: none">
            <td class="tableleft" style="width:100px;">文字服务器：</td>
            <td><input name="tserver" type="text" id="tserver" style="width:400px;" value="<?=$row[tserver]?>"/></td>
      </tr>
          <tr>
            <td class="tableleft">电脑直播代码：</td>
            <td><textarea name="livefp" rows="10" id="livefp" style="width:99%; height:100px;"><?=$row[livefp]?></textarea>
              <br>
              <a href="../../ckplayer/demo.htm" target="_blank">示例</a></td>
          </tr>
          <tr>
            <td class="tableleft">手机直播代码：</td>
            <td><textarea name="phonefp" rows="10" id="phonefp" style="width:99%;height:100px;"><?=$row[phonefp]?></textarea></td>
          </tr>
                <tr>
        <td class="tableleft">公共助理：</td>
        <td><textarea name="ggzl" id="ggzl" style="width:400px;"><?=tohtml($row[ggzl])?>
        </textarea>
          QQ连接</td>
      </tr>
          <tr>
            <td class="tableleft">机器人在线：</td>
            <td><input name="rebots" type="text" id="rebots"  value="<?=$row[rebots]?>"/>
            </td>
          </tr>
        <tr>
            <td class="tableleft">投注地址：</td>
            <td>
                <input name="touzhu_url" type="text" id="touzhu_url" style="width:400px;" value="<?=$row[touzhu_url]?>"/>
            </td>
        </tr>
          <tr>
            <td class="tableleft">自动广播：</td>
            <td><select name="sysmsg_state" class="r" id="sysmsg_state">
            <option value="<?=$row[sysmsg_state]?>"><?=$row[sysmsg_state]?>-保持不变</option>
              <option value="1">1-开启</option>
              <option value="0">0-关闭</option>
            </select>
            <select name="sysmsg_order" class="r" id="sysmsg_order">
            <option value="<?=$row[sysmsg_order]?>"><?=$row[sysmsg_order]?>-保持不变</option>
              <option value="1">1-列表顺序循环</option>
              <option value="0">0-列表随机播出</option>
            </select>
           &nbsp; 播出频率
            <input name="sysmsg_timer" type="text" id="sysmsg_timer"  value="<?=$row[sysmsg_timer]?>"/>
            </td>
          </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td><button type="submit" class="button button-success"> 保存 </button><input type="hidden" name="act" value="config_edit"><input type="hidden" name="id" value="<?=$id?>"></td>
          </tr>
    </table>
  </form>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script>
<script>
  function swfupload_ok(fileObj,server_data){
	 
	 var data=eval("("+server_data+")") ;
	 $("#"+data.msg.info).val(data.msg.url);
  }
  $(function(){


  var swfdef={
	  // 按钮设置
	    file_post_name:"filedata",
		button_width: 30,
		button_height: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		button_text: '上传',
		button_text_style: ".upbnt{ color:#00F}",
		button_text_left_padding: 0,
		button_text_top_padding: 0,
		upload_success_handler : swfupload_ok,
		file_dialog_complete_handler:function(){this.startUpload();},
		file_queue_error_handler:function(){alert("选择文件错误");}
		}
  swfdef.flash_url="../../upload/swfupload/swfupload.swf";
  swfdef.button_placeholder_id="logo_up_bnt";
  swfdef.file_types="*.gif;*.jpg;*.png";
  swfdef.upload_url="../../upload/upload.php";
  swfdef.post_params={"info":"logo"}
  
  swfu = new SWFUpload(swfdef);
  
  var swfico=swfdef;
  swfico.button_placeholder_id="ico_up_bnt";
  swfico.file_types="*.ico";
  swfico.post_params={"info":"ico"}
  swfuico = new SWFUpload(swfico);
  
  var swfbg=swfdef;
  swfbg.button_placeholder_id="bg_up_bnt";
  swfbg.file_types="*.gif;*.jpg;*.png";
  swfbg.post_params={"info":"bg"}
  swfubg = new SWFUpload(swfbg);
  
  var swfkcb=swfdef;
  swfkcb.button_placeholder_id="kcb_up_bnt";
  swfkcb.file_types="*.gif;*.jpg;*.png";
  swfkcb.post_params={"info":"kcb"}
  swfukcb = new SWFUpload(swfkcb);

  var swfloginimg=swfdef;
  swfloginimg.button_placeholder_id="loginimg_up_bnt";
  swfloginimg.file_types="*.gif;*.jpg;*.png";
  swfloginimg.post_params={"info":"loginimg"}
  swfloginimg = new SWFUpload(swfloginimg);

	  
});


</script>
<body>
</html>
