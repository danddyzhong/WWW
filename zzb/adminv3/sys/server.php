<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'sys_server')===false)exit("没有权限！");

if($act=="config_edit"){
	$arr[tserver]=$tserver;
	$arr[livefp]=$livefp;
	$arr[phonefp]=$phonefp;
	$arr[rebots]=$rebots;
	
	
	$arr[sysmsg_state]=$sysmsg_state;
	$arr[sysmsg_order]=$sysmsg_order;
	$arr[sysmsg_timer]=$sysmsg_timer;
	$query=$db->query("delete from {$tablepre}rebots where rid='1'");
	config_edit($arr,1);
}


$query=$db->query("select * from  {$tablepre}config where id=1");
$row=$db->fetch_row($query);
?>
<!DOCTYPE HTML>
<html>
 <head>
  <title> </title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <link href="../assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/bui-min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/page-min.css" rel="stylesheet" type="text/css" />   <!-- 下面的样式，仅是为了显示代码，而不应该在项目中使用-->
   <link href="../assets/css/prettify.css" rel="stylesheet" type="text/css" />
   <style type="text/css">
    code {
      padding: 0px 4px;
      color: #d14;
      background-color: #f7f7f9;
      border: 1px solid #e1e1e8;
    }
   </style>
 </head>
 <body>
  
    
    <div class="container">
     <form action="" method="post" enctype="application/x-www-form-urlencoded">
        <table class="table table-bordered table-hover definewidth m10">
          <tr>
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
            <td class="tableleft">机器人在线：</td>
            <td><input name="rebots" type="text" id="rebots"  value="<?=$row[rebots]?>"/> 数字大于用户机器人总数，否则用户机器人发言异常
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
           &nbsp; 时间间隔 
            <input name="sysmsg_timer" type="text" id="sysmsg_timer"  value="<?=$row[sysmsg_timer]?>"/>
            </td>
          </tr>
          <tr>
            <td class="tableleft">&nbsp;</td>
            <td><button type="submit" class="button button-success"> 保存 </button><input type="hidden" name="act" value="config_edit"></td>
          </tr>
        </table>
      </form>
     
 </div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script> 

<body>
</html>  