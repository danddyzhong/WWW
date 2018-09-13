<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'apps_hd')===false)exit("没有权限！");
if($act=="app_hd_add"){
	
	app_hd_add($ktime,$ptime,$sp,$kcj,$lx,$cw,$zsj,$zyj,$username,$pcj,$sn);
	$id=$db->insert_id();
	$type='edit';
}else if($act=="app_hd_edit"){
	app_hd_edit($id,$ktime,$ptime,$sp,$kcj,$lx,$cw,$zsj,$zyj,$username,$pcj,$sn);
}

$query=$db->query("select * from {$tablepre}apps_hd where id='$id'");
if($db->num_rows($query)>0)$row=$db->fetch_row($query);
else {$row[ktime]=gdate();$row[ptime]=gdate();}

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
</style>
</head>
<body>
<div class="container" style="margin-bottom:50px;">

<form action="?id=<?=$id?>&type=<?=$type?>" method="post" enctype="application/x-www-form-urlencoded">

  
<table class="table table-bordered table-hover definewidth m10">
          <tr>
            <td width="30" class="tableleft" style="width:80px;">开仓时间：</td>
            <td><input name="ktime" type="text" id="ktime" value="<?=date('Y-m-d H:i:s',$row[ktime])?>"  class="calendar calendar-time" /></td>
            <td width="80">平仓时间：</td>
            <td><input name="ptime" type="text" id="ptime" value="<?=date('Y-m-d H:i:s',$row[ptime])?>"  class="calendar calendar-time" /></td>
      </tr>
          <tr>
            <td class="tableleft">商品：</td>
            <td><input name="sp" type="text" id="sp" value="<?=$row[sp]?>"></td>
            <td>开仓价：</td>
            <td><input name="kcj" type="text" id="kcj" value="<?=$row[kcj]?>"></td>
          </tr>
          <tr>
            <td class="tableleft">类型：</td>
            <td><select name="lx" id="lx">
            <option value="<?=$row[lx]?>"><?=$row[lx]?></option>
              <option value="现价买入">现价买入</option>
              <option value="现价卖出">现价卖出</option>
              <option value="到价买入">到价买入</option>
              <option value="到价卖出">到价卖出</option>
              <option value="限价买入">限价买入</option>
              <option value="限价卖出">限价卖出</option>
            </select></td>
            <td>仓位：</td>
            <td><input name="cw" type="text" id="cw" value="<?=$row[cw]?>">
            %</td>
          </tr>
          <tr>
            <td class="tableleft">止损价：</td>
            <td><input name="zsj" type="text" id="zsj" value="<?=$row[zsj]?>"></td>
            <td>止盈价：</td>
            <td><input name="zyj" type="text" id="zyj" value="<?=$row[zyj]?>"></td>
          </tr>
          <tr>
            <td class="tableleft">分析师：</td>
            <td><input name="username" type="text" id="username" value="<?=$row[username]?>"></td>
            <td>平仓价：</td>
            <td><input name="pcj" type="text" id="pcj" value="<?=$row[pcj]?>"></td>
          </tr>
          <tr>
            <td class="tableleft">备注：</td>
            <td colspan="3"><textarea name="sn" id="sn" style="width:350px"><?=$row[sn]?></textarea></td>
          </tr>
    </table>

  <div style="position:fixed; bottom:0; background: #FFF; width:100%; padding-top:5px;">
    <button type="submit"  class="button button-success">确定</button>
    <button type="button"  class="button" onclick="window.parent.dialog.close()">关闭</button>
    <input type="hidden" name="act" value="app_hd_<?=$type?>">
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="hidden" name="type" value="<?=$type?>">
</div>
  </form>

</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 
<script type="text/javascript" src="../assets/js/bui.js"></script> 
<script type="text/javascript" src="../assets/js/config.js"></script> 
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
