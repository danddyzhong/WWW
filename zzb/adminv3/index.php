<?php
require_once '../include/common.inc.php';
require_once 'function.php';
$auth_rules=auth_group($_SESSION['login_gid']);
?>
<!DOCTYPE HTML>
<html>
 <head>
  <title><?=$cfg['config']['title']?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="assets/css/main-min.css" rel="stylesheet" type="text/css" />
 </head>
 <body>

  <div class="header">
    
      <div class="dl-title">
          <span class="dl-title-text"><?=$cfg['config']['title']?></span>
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user"><?=$_SESSION[admincp]?></span><a href="login.php?act=user_logout" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
        <li class="nav-item dl-selected" <?php if(stripos($auth_rules,'sys_')===false)echo " style='display:none'";?>><div class="nav-item-inner nav-home">系统设置</div></li>
        <li class="nav-item" <?php if(stripos($auth_rules,'users_')===false)echo " style='display:none'";?>><div class="nav-item-inner nav-supplier">用户管理</div></li>
      <!--   <li class="nav-item" <?php if(stripos($auth_rules,'biz_')===false)echo " style='display:none'";?>><div class="nav-item-inner nav-supplier">商务管理</div></li>
		<li class="nav-item" <?php if(stripos($auth_rules,'apps_')===false)echo " style='display:none'";?>><div class="nav-item-inner nav-order">应用管理</div></li>
		<li class="nav-item" <?php if(stripos($auth_rules,'tongji_')===false)echo " style='display:none'";?>><div class="nav-item-inner nav-marketing">统计</div></li>-->
      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>
  <script type="text/javascript" src="assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="./assets/js/bui.js"></script>
  <script type="text/javascript" src="./assets/js/config.js"></script>

  <script>
    BUI.use('common/main',function(){
      var config = [{
          id:'sys', 
          menu:[{
              text:'默认房间设置',
              items:[
                <?php if(stripos($auth_rules,'sys_base')!==false) echo "{id:'1',text:'默认配置',href:'sys/base.php'},";?>
				]
			  },{
			  text:'多房间设置',
              items:[
			  <?php if(stripos($auth_rules,'sys_rooms')!==false) echo "{id:'3',text:'房间管理',href:'sys/rooms.php'},";?>
			  ]
		      },{
			  text:'管理设置',
              items:[
				<?php if(stripos($auth_rules,'sys_ban')!==false) echo "{id:'2',text:'用户&IP屏蔽',href:'sys/ban.php'},";?>
				<?php if(stripos($auth_rules,'sys_notice')!==false) echo " {id:'3',text:'公告板-自定义标签',href:'sys/notice.php'},";?>
				<?php if(stripos($auth_rules,'sys_notice')!==false) echo " {id:'3_1',text:'公告板-品牌展示',href:'apps/app_ad.php'},";?>
				<?php if(stripos($auth_rules,'sys_notice')!==false) echo " {id:'3_1',text:'公告板-轮播广告',href:'apps/app_appad.php'},";?>
				<?php if(stripos($auth_rules,'sys_log')!==false) echo "{id:'4',text:'日志管理',href:'sys/log.php'},";?> 
				<?php if(stripos($auth_rules,'sys_log')!==false) echo "{id:'4',text:'日志-聊天记录',href:'sys/log.php?type=0'},";?>          
                <?php if(stripos($auth_rules,'sysmsg')!==false) echo " {id:'5',text:'广播&公告&提示',href:'sys/sysmsg.php'},";?>
                <?php if(stripos($auth_rules,'sys_base')!==false) echo " {id:'6',text:'手机自定义标签',href:'sys/mobile_nav.php'},";?>
			  ]
              }]
          },{
            id:'users',
            menu:[{
                text:'用户管理',
                items:[
				<?php if(stripos($auth_rules,'users_admin')!==false) echo "{id:'1',text:'用户管理',href:'users/users.php'},";?>
				<?php if(stripos($auth_rules,'users_admin')!==false) echo "{id:'1',text:'游客管理',href:'users/users.php?gid=2'},";?>
				<?php if(stripos($auth_rules,'users_group')!==false) echo "{id:'2',text:'分组管理',href:'users/group.php'},";?>          
                <?php if(stripos($auth_rules,'users_rebots')!==false) echo "{id:'3',text:'机器人管理',href:'users/rebots.php'},";?>  
				  
                ]
              }]
          },{
            id:'biz',
            menu:[{
                text:'充值提现',
                items:[
				<?php if(stripos($auth_rules,'biz_goldvip')!==false) echo "{id:'0',text:'用户充值',href:'biz/users.php?fuser={$_SESSION[admincp]}'},";?>
				<?php if(stripos($auth_rules,'biz_goldvip')!==false) echo "{id:'1',text:'虚拟币记录',href:'biz/gold_log.php'},";?> 
                <?php if(stripos($auth_rules,'biz_tixian')!==false) echo "{id:'0',text:'用户提现',href:'biz/tixian.php'},";?>  
				  
                ]
              },{
				text:'礼物中心',
                items:[
				<?php if(stripos($auth_rules,'biz_gift')!==false) echo "{id:'2',text:'礼物中心',href:'biz/gift.php'},";?>
				]
			  }
			  ,{
				text:'充值支付',
                items:[
				<?php if(stripos($auth_rules,'biz_order')!==false) echo "{id:'3',text:'商品管理',href:'biz/payitem.php'},";?>
				<?php if(stripos($auth_rules,'biz_order')!==false) echo "{id:'4',text:'订单管理',href:'biz/payorder.php'},";?>
				]
			  },{
				text:'商务模块',
                items:[
				<?php if(stripos($auth_rules,'biz_hongbao')!==false) echo "{id:'5',text:'红包记录',href:'biz/hongbao.php'},";?>
				<?php if(stripos($auth_rules,'biz_qiandao')!==false) echo "{id:'6',text:'签到记录',href:'biz/qiandao.php'},";?>
				<?php if(stripos($auth_rules,'biz_qiandao')!==false) echo "{id:'6',text:'签到奖励',href:'biz/qiandao_setting.php'},";?>
				]
			  }]
          },{
            id:'app',
            menu:[{
                text:'应用列表',
                items:[
				<?php if(stripos($auth_rules,'apps_hd')!==false) echo "{id:'1',text:'喊单系统',href:'apps/app_hd.php'},";?>
				<?php if(stripos($auth_rules,'apps_wt')!==false) echo "{id:'2',text:'问题答疑',href:'apps/app_wt.php'},";?>
				<?php if(stripos($auth_rules,'apps_jyts')!==false) echo "{id:'3',text:'交易提示',href:'apps/app_jyts.php'},";?>
				<?php if(stripos($auth_rules,'apps_scpl')!==false) echo "{id:'4',text:'市场评论',href:'apps/app_scpl.php'},";?>
				<?php if(stripos($auth_rules,'apps_files')!==false) echo "{id:'5',text:'共享文档',href:'apps/app_files.php'},";?>
				<?php if(stripos($auth_rules,'apps_rank')!==false) echo "{id:'6',text:'服务排行榜',href:'apps/app_rank.php'},";?>
				<?php if(stripos($auth_rules,'apps_vod')!==false) echo "{id:'6',text:'视频库管理',href:'apps/app_vod.php'},";?>  
                ]
              },
			  {
                text:'边栏应用',
                items:[
				<?php if(stripos($auth_rules,'apps_manage')!==false) echo "{id:'tab',text:'应用管理',href:'apps/app_manage.php'}";?>
                  
                ]
              }]
          },{
			 id:'tj',
			 menu:[{
                text:'讲师统计',
                items:[
				<?php if(stripos($auth_rules,'tongji_reg')!==false) echo "{id:'1',text:'发展会员数',href:'tongji/tj_reg.php?type=newuser'},";?>
				<?php if(stripos($auth_rules,'tongji_reg')!==false) echo "{id:'2',text:'访客数',href:'tongji/tj_login.php?type=loginroom'},";?>
				<?php if(stripos($auth_rules,'tongji_reg')!==false) echo "{id:'3',text:'在线统计',href:'tongji/tj_online.php'},";?>
                  
                  
				  
				  
				  
				  
                ]
              }]
		  }];
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
 </body>
</html>
