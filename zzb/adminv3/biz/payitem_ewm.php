<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'biz_order')===false)exit("没有权限！");
switch($act){
	case "delewm":
		$db->query("delete from {$tablepre}payitem_ewm where id='$eid'");
	break;
	case "addewm":
		$db->query("insert into {$tablepre}payitem_ewm(sn,ewm,pid,etype)values('{$sn}','{$ewm}','{$id}','{$ttype}')");
	break;
}
$row=$db->fetch_row($db->query("select * from {$tablepre}payitem where id='{$id}'"));
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
code { padding: 0px 4px; color: #d14; background-color: #f7f7f9; border: 1px solid #e1e1e8; }
input,select{vertical-align:middle;}
.liw { width:160px; height:25px; line-height:25px;}
input, button {
	vertical-align:middle
}
</style>
</head>
<body>
<div class="container" style="margin-bottom:50px;">



  
<table class="table table-bordered table-hover definewidth m10">
          <tr>
            <td width="30" class="tableleft" style="width:80px;">商品信息：</td>
            <td>
            名称：<?=$row['sn']?> 价值￥<?=$row['rmb']?> 充值虚拟币：<?=$row['v']?>
            </td>
      </tr>
          <tr>
            <td rowspan="2" class="tableleft">二维码列表：</td>
            <td>
            <?php
            $query=$db->query("select * from {$tablepre}payitem_ewm where pid='$id' order by id desc");
			while($xx=$db->fetch_row($query)){
			echo "[{$xx[etype]}][{$xx[sn]}] <a href='{$xx[ewm]}' target=_blank>{$xx[ewm]}</a> <a href='?act=delewm&eid={$xx[id]}&id={$id}'>删除</a><br>";
			}
			?>
            &nbsp;</td>
          </tr>
          <tr>
            <td>
			<form action="?id=<?=$id?>" method="post" enctype="application/x-www-form-urlencoded">
			<table class="table table-bordered table-hover definewidth m10">
			<tr><td width=100>二维码图片：</td><td>
			<select name="ttype">
            <option value="alipay">支付宝</option>
            <option value="weixin">微信</option>
          </select>
			<input name="ewm" type="text" id="ewm"  class="input-large"  /> 
			<button  type="button" class="button button-mini button-success" ><span id="ewm_up_bnt"></span></button></td></tr>
			<tr><td>二维码备注:</td><td><input name="sn" type="text" id="sn"  /><input name="act" type="hidden" value="addewm">  <button type="submit" class="button button-mini button-success"><i class="x-icon x-icon-small icon-wrench  icon-white"></i>添加</button></td></tr>
			<tr><td> </td><td><font style="color:red">1、生成二维码时备注名称不能重复，并且添加商品二维码备注名称必须和生成时保持一致。<br>2、二维码越多，占用提示率越低。</font></td></tr>
			</table>
            </form>           
             
            </td>
          </tr>
    </table>

  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
  </div>

</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
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

		var swfbg=swfdef;
		  swfbg.button_placeholder_id="ewm_up_bnt";
		  swfbg.file_types="*.gif;*.jpg;*.png";
		  swfbg.post_params={"info":"ewm"}
		  swfubg = new SWFUpload(swfbg);
	});
  </script>

    <script type="text/javascript">
        BUI.use('bui/calendar',function(Calendar){
            var datepicker = new Calendar.DatePicker({
              trigger:'.calendar-time',
              showTime:true,
              autoRender : true
            });
        });
		  

      </script>
</body>
</html>

