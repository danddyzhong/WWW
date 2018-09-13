<?php
require_once '../../include/common.inc.php';
require_once '../function.php';
if(stripos(auth_group($_SESSION['login_gid']),'users_admin')===false)exit("没有权限！");
$auth_rule_userdel=false;
if(stripos(auth_group($_SESSION['login_gid']),'users_del')!==false)$auth_rule_userdel=true;

switch($act){
    case "user_del":
        if(stripos(auth_group($_SESSION['login_gid']),'users_del')===false)exit("没有权限！");
        user_del(implode(',',$id));
        header("location:?gid=".$gid);
        break;
    case "delguest":
        $db->query("delete from chat_members where uid in (select uid from chat_memberfields where nickname like '游客%')");
        $db->query("delete from chat_memberfields where nickname like '游客%'");
        break;
}

function userlist1($num,$sql,$tpl){
    global $db,$tablepre,$firstcount,$displaypg;
    $re=$db->query_cache("user_count",60*60*4,"select count(*) as c from (".str_replace(',ms.*','',$sql).") as t");
    foreach($re as $row){
        $c=$row[c];
    }

    pageft($c,$num,"");
    $sql.=" limit $firstcount,$displaypg";
    echo "<!--"."select count(*) as c from (".str_replace(',ms.*','',$sql).") as t"."-->";
    $query=$db->query($sql);
    return for_each($query,$tpl);

}
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
    </style>
    <script>
        Date.prototype.Format = function (fmt) { //author: meizz
            var o = {
                "M+": this.getMonth() + 1, //月份
                "d+": this.getDate(), //日
                "h+": this.getHours(), //小时
                "m+": this.getMinutes(), //分
                "s+": this.getSeconds(), //秒
                "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                "S": this.getMilliseconds() //毫秒
            };
            if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            for (var k in o)
                if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            return fmt;
        }
        function ftime(time){
            return new Date(time*1000).Format("yyyy-MM-dd hh:mm"); ;
        }
        function ftime2(time){
            if(time>(60*60*24)) return parseInt(time/(60*60*24))+"天";
            else if(time>(60*60))return parseInt(time/(60*60))+"小时";
            else if(time>60)return parseInt(time/60)+"分钟";
            else return parseInt(time)+"秒";
        }
        function sgid(id){
            var arr=new Array();
            if(isNaN(id)) return '';
            <?php
            $query=$db->query("select * from {$tablepre}auth_group order by id desc");
            while($row=$db->fetch_row($query)){
                echo "arr['{$row[id]}']='$row[title]';";
            }
            ?>
            return arr[id];
        }
    </script>
</head>
<body>
<div class="container"  >
    <form  class="form-horizontal" action="" method="get">
        <ul class="breadcrumb">
            <li class="active" style="width:100%">
                <?php
                if($auth_rule_userdel){
                    ?>
                    <button type="button" class="button button-success" id="add_group_bt" style="float:right;margin: 0px 6px;" onclick="openUserAdd()"><i class="icon icon-plus icon-white"></i> 添加</button>

                    <button type="button"  class="button  button-danger"  onClick="if(confirm('确定删除？'))$('#hd_list').submit()" style="float:right;margin: 0px 6px;">删除所选</button>

                    <button type="button"  class="button  button-inverse"  onClick="if(confirm('确定删除？'))location.href='users.php?gid=0&act=delguest'" style="float:right;margin: 0px 6px;">清空游客</button>
                <?php }?>
                用户名：
                <input type="text" name="username" id="rolename"class="abc input-default" placeholder="" value="<?=$username?>">
                昵称：
                <input type="text" name="nickname"  class="abc input-default" placeholder=""  value="<?=$nickname?>">
                <!--所属客服ID：
	  <input type="text" name="tuser"  class="abc input-default" placeholder=""  value="<?=$tuser?>">
	  -->
                IP：
                <input type="text" name="ip" id="ip"class="abc input-default" placeholder="" value="<?=$ip?>">
                <input type="hidden" name="gid" value="<?=$gid?>">
                <input type="hidden" name="fuser" value="<?=$fuser?>"><select name="mod" id="mod">
                    <option value="1">精准查询-快</option>
                    <option value="0">模糊查询-慢</option>
                </select>
                &nbsp;&nbsp;
                <button type="submit"  class="button ">查询</button>

                &nbsp;&nbsp; </li>

        </ul>
    </form>
    <form action="" method="POST" enctype="application/x-www-form-urlencoded"  class="form-horizontal" id="hd_list">
        <input type="hidden" name="gid" value="<?=$gid?>">
        <input type="hidden" name="act" value="user_del">
        <table  class="table table-bordered table-hover definewidth m10">
            <thead>
            <tr style="font-weight:bold" >
                <td width="40" align="center" bgcolor="#FFFFFF">用户ID</td>
                <td width="19" align="center" bgcolor="#FFFFFF"><input type="checkbox" onClick="$('.ids').attr('checked',this.checked); "></td>
                <td width="30" align="center" bgcolor="#FFFFFF">房间</td>
                <td align="center" bgcolor="#FFFFFF">用户名</td>
                <td align="center" bgcolor="#FFFFFF">昵称</td>

                <td width="80" align="center" bgcolor="#FFFFFF">手机</td>
                <td width="60" align="center" bgcolor="#FFFFFF">QQ</td>
                <td width="60" align="center" bgcolor="#FFFFFF">用户组</td>
                <td width="100" align="center" bgcolor="#FFFFFF">注册时间</td>
                <td width="90" align="center" bgcolor="#FFFFFF">IP</td>
                <td width="100" align="center" bgcolor="#FFFFFF">最近登录</td>
                <td width="30" align="center" bgcolor="#FFFFFF">审核</td>
                <td width="120" align="center" bgcolor="#FFFFFF">操作</td>
            </tr>
            </thead>
            <?php
			$sql="select m.*,ms.nickname  from {$tablepre}members m,{$tablepre}memberfields ms";
			$where="  where m.uid=ms.uid and m.uid!=0";
			if($username!=""){
				if($mod=="0")
				$where.=" and m.username like '%$username%'";
				else $where.=" and m.username = '$username'";
			}
			if($nickname!=""){
				if($mod=="0")
				$where.=" and ms.nickname like '%$nickname%'";
				else $where.=" and  ms.nickname = '$nickname'";
				
			}
			if($ip!=""){
				$where.=" and  m.regip = '$ip'";
				
			}
			 
			if($gid!=""){
				$where.=" and m.gid='$gid'";
			}else{
				$where.=" and m.gid!='0'";
			}

			if($_SESSION['login_gid']=='3'){ 
			  $sql.=",{$tablepre}cs cs ";
			  $where.=" and cs.uid=m.uid and cs.fid='{$_SESSION['login_uid']}'";
			} 
			 $sql=$sql.$where." order by m.uid desc"; 
            if(!$auth_rule_userdel)$display_delbutton='style="display:none"';
            echo userlist(20,$sql,'
    <tr>
      <td bgcolor="#FFFFFF" align="center">{uid}</td>
	  <td align="center" bgcolor="#FFFFFF"><input type="checkbox" class="ids" name="id[]" value="{uid}"></td>
	  <td align="center" bgcolor="#FFFFFF">{rid}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">{username}</td>
      <td align="center" bgcolor="#FFFFFF">{nickname}</td>

	  <td align="center" bgcolor="#FFFFFF">{phone}&nbsp;</td>
	  <td align="center" bgcolor="#FFFFFF">{realname}&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(sgid({gid})); </script>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><script>document.write(ftime({regdate})); </script></td>
	  <td align="center" bgcolor="#FFFFFF">{regip}</td>
      <td align="center" bgcolor="#FFFFFF" title="登录IP:{regip}" onClick="alert(\'登录IP:{regip}\')"><script>document.write(ftime({lastvisit})); </script></td>
	  <td align="center" bgcolor="#FFFFFF">{state}</td>
      <td align="center" bgcolor="#FFFFFF">
      <button type="button" class="button button-mini button-info" onClick="openUser({uid},0)" ><i class="x-icon x-icon-small icon-wrench icon-white"></i>设置</button>
      <button type="button" class="button button-mini button-danger" onclick="if(confirm(\'确定删除用户？\'))location.href=\'?act=user_del&id[]={uid}&gid='.$gid.'\'" '.$display_delbutton.'><i class="x-icon x-icon-small icon-trash icon-white"></i>删除</button></td>
    </tr>
')?>
            <!--<?=$sql?>-->
        </table>
    </form>
    <ul class="breadcrumb">
        <li class="active"><?=$pagenav?>
        </li>
    </ul>
</div>
<script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bui.js"></script>
<script type="text/javascript" src="../assets/js/config.js"></script>
<script type="text/javascript" src="../../upload/swfupload/swfupload.js"></script>
<script>
    BUI.use('bui/overlay',function(Overlay){
        dialog = new Overlay.Dialog({
            title:'用户设置',
            width:630,
            height:650,
            buttons:[],
            bodyContent:''
        });
    });
    function openUser(id,type){
        dialog.set('bodyContent','<iframe src="user_edit.php?id='+id+'&type='+type+'" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
        dialog.updateContent();
        dialog.show();
    }
    function openUserAdd(){
        dialog.set('bodyContent','<iframe src="user_add.php" scrolling="yes" frameborder="0" height="100%" width="100%"></iframe>');
        dialog.updateContent();
        dialog.show();
    }

</script>
</body>
</html>
