/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 5.5.53 : Database - zzb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zzb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `zzb`;

/*Table structure for table `live_apps_ad` */

DROP TABLE IF EXISTS `live_apps_ad`;

CREATE TABLE `live_apps_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(500) DEFAULT NULL COMMENT '标题',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `ov` int(3) DEFAULT NULL COMMENT '排序',
  `rid` int(2) DEFAULT NULL COMMENT '房间',
  `pic` varchar(100) DEFAULT NULL COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `live_apps_ad` */

insert  into `live_apps_ad`(`id`,`title`,`url`,`ov`,`rid`,`pic`) values 
(1,'zzb','www.aaa.com',1,1,'/upload/upfile/day_180908/201809081429557940.jpg');

/*Table structure for table `live_apps_appad` */

DROP TABLE IF EXISTS `live_apps_appad`;

CREATE TABLE `live_apps_appad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(500) DEFAULT NULL COMMENT '标题',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `ov` int(2) DEFAULT NULL COMMENT '排序',
  `gv` int(2) DEFAULT NULL COMMENT '广告类型',
  `rid` int(2) DEFAULT NULL COMMENT '房间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `live_apps_appad` */

/*Table structure for table `live_apps_rebots` */

DROP TABLE IF EXISTS `live_apps_rebots`;

CREATE TABLE `live_apps_rebots` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `img` varchar(50) DEFAULT NULL COMMENT '图片',
  `name` varchar(300) DEFAULT NULL COMMENT '昵称',
  `gid` int(5) DEFAULT NULL COMMENT '用户组',
  `fuser` varchar(200) DEFAULT NULL,
  `weeks` varchar(50) DEFAULT NULL,
  `hl` varchar(50) DEFAULT NULL,
  `ol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `live_apps_rebots` */

insert  into `live_apps_rebots`(`id`,`img`,`name`,`gid`,`fuser`,`weeks`,`hl`,`ol`) values 
(2,'/face/rebot/8.gif','忙着耍酷',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(3,'/face/rebot/37.gif','浅夏韵歌',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(4,'/face/rebot/40.gif','空虚的生活√',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(5,'/face/rebot/10.gif','漓刺',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(6,'/face/rebot/23.gif','孤妄',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(7,'/face/rebot/14.gif','花尽千霜默',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(8,'/face/rebot/37.gif','青石铺的老街',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(9,'/face/rebot/34.gif','与君多别离',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(10,'/face/rebot/16.gif','梦璃子',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00'),
(11,'/face/rebot/20.gif','萌哒哒的傲气',3,'admin','0,1,2,3,4,5,6','08:00:00','02:00:00');

/*Table structure for table `live_auth_group` */

DROP TABLE IF EXISTS `live_auth_group`;

CREATE TABLE `live_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `rules` varchar(1500) DEFAULT NULL COMMENT '分组权限',
  `title` varchar(500) DEFAULT NULL COMMENT '分组名称',
  `sn` varchar(150) DEFAULT NULL,
  `ico` varchar(150) DEFAULT NULL COMMENT '头像',
  `type` int(2) DEFAULT NULL,
  `ov` int(11) DEFAULT NULL COMMENT '排序相关',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `live_auth_group` */

insert  into `live_auth_group`(`id`,`rules`,`title`,`sn`,`ico`,`type`,`ov`) values 
(1,'users_rebots,users_group,users_del,users_admin,tongji_reg,sysmsg,sys_rooms,sys_notice,sys_log,sys_base,sys_ban,biz_tixian,biz_qiandao,biz_order,biz_order,biz_hongbao,biz_goldvip,biz_gift,apps_wt,apps_vod,apps_scpl,apps_manage,apps_jyts,apps_hd,apps_files,adminlogin,wt_view,wt_re,wt_add,user_kick,user_info_gl,user_info,scpl_view,scpl_add,room_admin,rebots_msg,msg_style,msg_send,msg_ptp,msg_priv,msg_block,msg_audit,jyts_view,jyts_add,hd_view,hd_add,files_view,files_add,def_videosrc','管理员','管理员','/room/images/group/s.png',0,0),
(2,'wt_view,msg_style,msg_ptp','游客','未知游客','/upload/upfile/day_180909/201809091227029355.png',0,1),
(3,'msg_send','试用会员','注册会员','/upload/upfile/day_180908/201809082216222554.png',0,2),
(4,'users_rebots,users_admin,sys_log,sys_ban,apps_hd,apps_files,adminlogin,wt_view,wt_re,user_kick,user_info,scpl_view,scpl_add,room_admin,rebots_msg,msg_style,msg_send,msg_ptp,msg_block,msg_audit,jyts_view,hd_view,hd_add,files_view,files_add','客服','客服人员','/upload/upfile/day_180909/201809091408173993.gif',0,3),
(5,'users_del,users_admin,sys_ban,user_kick,msg_block','直播室巡检员','直播室巡检','/upload/upfile/day_180911/201809112230005121.jpg',0,4),
(6,'sys_ban,apps_wt,apps_scpl,apps_jyts,apps_hd,apps_files,adminlogin,wt_view,wt_re,user_info,scpl_view,scpl_add,msg_style,msg_send,msg_ptp,jyts_view,jyts_add,hd_view,hd_add,files_view,files_add,def_videosrc','分析师 ','分析师','/upload/upfile/day_180911/201809112231446727.jpg',0,5);

/*Table structure for table `live_auth_rule` */

DROP TABLE IF EXISTS `live_auth_rule`;

CREATE TABLE `live_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `rulename` varchar(50) NOT NULL COMMENT '权限名',
  `title` varchar(100) DEFAULT NULL COMMENT '权限中文名',
  `type` int(2) NOT NULL COMMENT '0后台权限 1：前台权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `live_auth_rule` */

insert  into `live_auth_rule`(`id`,`rulename`,`title`,`type`) values 
(1,'sys_users','系统管理员',0),
(2,'msg_priv','私聊',1),
(3,'user_info','用户资料查看权限',1),
(4,'user_kick','踢人',1),
(5,'send_Msgblock','屏蔽',1),
(6,'msg_send','发言',1),
(7,'msg_audit','信息审核',1),
(8,'msg_ptp','指定人发言',1),
(9,'room_admin','聊天室管理权限',1);

/*Table structure for table `live_ban` */

DROP TABLE IF EXISTS `live_ban`;

CREATE TABLE `live_ban` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `ip` varchar(16) DEFAULT NULL COMMENT 'ip',
  `losttime` int(11) DEFAULT NULL COMMENT 'time',
  `sn` varchar(100) DEFAULT NULL COMMENT 'sn',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `live_ban` */

/*Table structure for table `live_config` */

DROP TABLE IF EXISTS `live_config`;

CREATE TABLE `live_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `login_uid` int(11) DEFAULT NULL COMMENT 'login_uid',
  `loginguest` int(2) DEFAULT NULL COMMENT '游客登录',
  `title` varchar(150) DEFAULT NULL COMMENT '网站标题',
  `keys` varchar(250) DEFAULT NULL COMMENT '关键字',
  `dc` varchar(500) DEFAULT NULL COMMENT '站点描述',
  `logo` varchar(200) DEFAULT NULL COMMENT 'logo',
  `ico` varchar(100) DEFAULT NULL COMMENT 'ico',
  `bg` varchar(200) DEFAULT NULL COMMENT 'bg',
  `kcb` varchar(1000) DEFAULT NULL COMMENT '课程表',
  `loginimg` varchar(200) DEFAULT NULL COMMENT '登录提示的图片',
  `regban` tinytext COMMENT '注册过滤',
  `msgban` tinytext COMMENT '聊天过滤',
  `state` int(2) DEFAULT NULL COMMENT '房间状态 1开启0关闭2加密',
  `pwd` varchar(150) DEFAULT NULL COMMENT '密码',
  `msgblock` int(2) DEFAULT NULL COMMENT '消息屏蔽（1是0否）',
  `msglog` int(2) DEFAULT NULL COMMENT '消息记录(1是0否)',
  `msgaudit` int(2) DEFAULT NULL COMMENT '消息审核(1是0)',
  `msgwin` int(2) DEFAULT NULL COMMENT '主动私聊(1是0否)',
  `logintip` int(2) DEFAULT NULL COMMENT '登录提示(1是0否)',
  `loginqq` int(2) DEFAULT NULL COMMENT '第三方登录(1是0否)',
  `regaudit` int(2) DEFAULT NULL COMMENT '注册审核(1是0否)',
  `chkphone` int(2) DEFAULT NULL COMMENT '手机验证(1是0否)',
  `tserver` varchar(150) DEFAULT NULL COMMENT '文字服务',
  `livefp` varchar(150) DEFAULT NULL COMMENT '电脑直播代码',
  `phonefp` varchar(150) DEFAULT NULL COMMENT '手机直播代码',
  `rebots` int(8) DEFAULT NULL COMMENT '机器人在线（数字大于用户机器人总数，否则用户机器人发言异常',
  `sysmsg_state` int(2) DEFAULT NULL COMMENT '自动广播(1是0否)',
  `sysmsg_order` int(2) DEFAULT NULL COMMENT '自动广播（1-列表顺序循环 0-列表随机播出',
  `sysmsg_timer` int(3) DEFAULT NULL COMMENT '播出频率',
  `ggzl` text COMMENT '图标参数说明：参数1|参数2|参数3|参数4|参数5<br>',
  `touzhu_url` varchar(200) DEFAULT NULL COMMENT '投注地址',
  `tongji` varchar(500) DEFAULT NULL COMMENT '统计代码',
  `copyright` varchar(500) DEFAULT NULL COMMENT '版权信息',
  `acl` varchar(100) DEFAULT NULL COMMENT '允许进入组',
  `banall` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `live_config` */

insert  into `live_config`(`id`,`login_uid`,`loginguest`,`title`,`keys`,`dc`,`logo`,`ico`,`bg`,`kcb`,`loginimg`,`regban`,`msgban`,`state`,`pwd`,`msgblock`,`msglog`,`msgaudit`,`msgwin`,`logintip`,`loginqq`,`regaudit`,`chkphone`,`tserver`,`livefp`,`phonefp`,`rebots`,`sysmsg_state`,`sysmsg_order`,`sysmsg_timer`,`ggzl`,`touzhu_url`,`tongji`,`copyright`,`acl`,`banall`) values 
(1,NULL,1,'zzb','zzb','zzb','/upload/upfile/day_180905/201809051547206987.png','/upload/upfile/day_180907/201809071919414557.ico','/upload/upfile/day_180907/201809072008588573.jpg','','','','黑平台|返佣|骗子|加群|网址|垃圾|QQ|qq|微信|加微|VX|购彩环境|合并|快乐彩票|（五）|代理方案|100元佣金|网站|.com|注册|体验彩金|精准免费计划软件|出款|取款|。com|.cn|.nte|点com|快乐彩票（五）',1,'',0,1,0,0,1,0,0,0,'127.0.0.1:7272','<iframe src=/apps/kaijiang/cplive.html width=100% height=100%   allowTransparency=true></iframe>','',20,1,1,300,'1|1|qq|代理专员|1437347093\r\n2|0|star|红包专员|1437347093\r\n3|1|rmb|提现专员|1437347093\r\n1|0|coffee|客服专员|1437347093','','','','3,2,1',0);

/*Table structure for table `live_cs` */

DROP TABLE IF EXISTS `live_cs`;

CREATE TABLE `live_cs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) DEFAULT NULL,
  `rid` int(2) DEFAULT NULL,
  `fid` int(5) DEFAULT NULL COMMENT '客服id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=519 DEFAULT CHARSET=utf8;

/*Data for the table `live_cs` */

insert  into `live_cs`(`id`,`uid`,`rid`,`fid`) values 
(501,0,1,3),
(502,0,1,3),
(506,9,1,10),
(509,8,1,10),
(511,3,1,10),
(512,1,1,8),
(513,10,1,3),
(514,11,1,10),
(515,12,1,10),
(516,13,1,10),
(517,14,1,10),
(518,15,1,10);

/*Table structure for table `live_memberfields` */

DROP TABLE IF EXISTS `live_memberfields`;

CREATE TABLE `live_memberfields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `uface` varchar(250) DEFAULT NULL COMMENT '头像',
  `logins` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `sn` varchar(150) DEFAULT NULL,
  `kfmsg` varchar(500) DEFAULT NULL COMMENT '自我介绍',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `live_memberfields` */

insert  into `live_memberfields`(`id`,`uid`,`nickname`,`uface`,`logins`,`sn`,`kfmsg`) values 
(1,1,'admin','/face/rebot/25.gif',15,NULL,''),
(3,3,'游客AB4F8BF934','/face/rebot/25.gif',59,'',''),
(4,0,'danddy',NULL,0,NULL,NULL),
(5,0,'dandddy',NULL,0,NULL,NULL),
(6,0,'danddy',NULL,0,NULL,NULL),
(7,0,'danddy',NULL,0,NULL,NULL),
(8,0,'danddy',NULL,0,NULL,NULL),
(9,0,'danddy',NULL,0,NULL,NULL),
(10,0,'danddy',NULL,0,NULL,NULL),
(11,0,'danddy',NULL,0,NULL,NULL),
(12,0,'danddy',NULL,0,NULL,NULL),
(13,0,'danddy',NULL,0,NULL,NULL),
(14,4,'danddy',NULL,0,NULL,NULL),
(15,5,'danddy',NULL,0,NULL,NULL),
(16,6,'danddy',NULL,0,NULL,NULL),
(17,7,'danddy',NULL,0,NULL,NULL),
(18,8,'danddy','/face/rebot/1.gif?1536326743?',34,'',''),
(19,9,'游客C3DF0D322E','/face/rebot/36.gif',37,'',''),
(20,10,'客服1','/face/rebot/39.gif?1536727740?',4,'','绕弯儿'),
(21,11,'游客92850372E5','/face/rebot/20.gif',38,NULL,NULL),
(22,12,'游客756F2266B2','/face/rebot/18.gif',25,NULL,NULL),
(23,13,'游客9B84D7F99D','/face/rebot/16.gif',7,NULL,NULL),
(24,14,'danddy2',NULL,2,NULL,NULL),
(25,15,'danddy3',NULL,2,NULL,NULL);

/*Table structure for table `live_members` */

DROP TABLE IF EXISTS `live_members`;

CREATE TABLE `live_members` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `gid` int(11) NOT NULL COMMENT '分组id',
  `username` varchar(80) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `sex` int(2) DEFAULT NULL COMMENT '性别',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `regdate` int(11) DEFAULT NULL COMMENT '注册时间',
  `regip` varchar(16) DEFAULT NULL COMMENT 'ip地址',
  `lastvisit` int(11) DEFAULT NULL COMMENT '上次访问的时间',
  `lastactivity` int(11) DEFAULT NULL COMMENT '上次动作时间',
  `gold` int(11) DEFAULT NULL COMMENT '金币',
  `realname` varchar(50) DEFAULT NULL COMMENT '真名',
  `phone` varchar(50) DEFAULT NULL COMMENT '电话',
  `state` int(2) DEFAULT NULL COMMENT '状态',
  `fuser` varchar(30) DEFAULT NULL,
  `tuser` varchar(30) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL COMMENT '房间号',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `live_members` */

insert  into `live_members`(`uid`,`gid`,`username`,`password`,`sex`,`email`,`regdate`,`regip`,`lastvisit`,`lastactivity`,`gold`,`realname`,`phone`,`state`,`fuser`,`tuser`,`rid`) values 
(1,1,'admin','e10adc3949ba59abbe56e057f20f883e',2,NULL,1536185643,'127.0.0.1',1536779151,1536764728,0,'1437347093','',1,'管理员','danddy',1),
(3,2,'u3','4297f44b13955235245b2497399d7a93',2,'',1536185643,'127.0.0.1',1536424112,1536439955,0,'0','0',1,'','',1),
(8,3,'danddy','e10adc3949ba59abbe56e057f20f883e',2,'',1536353937,'127.0.0.1',1536775918,1536777166,0,'1437347093','',1,'','客服1',1),
(9,2,'u9','4297f44b13955235245b2497399d7a93',2,'',1536442492,'127.0.0.1',1536527402,1536527333,0,'0','0',1,'','客服1',1),
(10,4,'客服1','e10adc3949ba59abbe56e057f20f883e',2,NULL,1536474563,'127.0.0.1',1536758467,1536755801,0,'3530722895','13556816137',1,'','u3',1),
(11,2,'u11','4297f44b13955235245b2497399d7a93',2,'',1536510331,'127.0.0.1',1536778649,1536778642,0,'0','0',1,NULL,'客服1',1),
(12,2,'u12','4297f44b13955235245b2497399d7a93',2,'',1536527415,'127.0.0.1',1536773498,1536773498,0,'0','0',1,NULL,'客服1',1),
(13,2,'u13','4297f44b13955235245b2497399d7a93',2,'',1536694899,'127.0.0.1',1536776013,1536773702,0,'0','0',1,NULL,'客服1',1),
(14,3,'danddy2','e10adc3949ba59abbe56e057f20f883e',2,'',1536695093,'127.0.0.1',1536695093,1536695093,0,'1437347','',1,'客服1','客服1',1),
(15,3,'danddy3','e10adc3949ba59abbe56e057f20f883e',2,'',1536695141,'127.0.0.1',1536695141,1536695141,0,'18899','',1,'客服1','客服1',1);

/*Table structure for table `live_msgs` */

DROP TABLE IF EXISTS `live_msgs`;

CREATE TABLE `live_msgs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `rid` int(11) DEFAULT NULL,
  `ugid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `uname` varchar(150) DEFAULT NULL,
  `tuid` int(11) DEFAULT NULL,
  `tname` varchar(150) DEFAULT NULL,
  `mtime` int(11) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `msg` varchar(300) DEFAULT NULL COMMENT '登录备注',
  `type` int(2) DEFAULT NULL COMMENT '类型',
  `p` varchar(50) DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `style` varchar(300) DEFAULT NULL COMMENT '样式',
  `msgid` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=592 DEFAULT CHARSET=utf8;

/*Data for the table `live_msgs` */

insert  into `live_msgs`(`id`,`rid`,`ugid`,`uid`,`uname`,`tuid`,`tname`,`mtime`,`ip`,`msg`,`type`,`p`,`state`,`style`,`msgid`) values 
(1,1,0,2,'u2',0,'',1536169513,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(2,1,0,2,'u2',0,'',1536169539,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(3,1,0,2,'u2',0,'',1536169540,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(4,1,0,2,'u2',0,'',1536169540,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(5,1,0,2,'u2',0,'',1536169540,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(6,1,0,2,'u2',0,'',1536169540,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(7,1,0,2,'u2',0,'',1536169540,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(8,1,0,2,'u2',0,'',1536169541,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(9,1,0,2,'u2',0,'',1536169541,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(10,0,1,0,'danddy',0,'',1536170210,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(11,1,0,2,'u2',0,'',1536173745,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(12,1,0,2,'u2',0,'',1536173746,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(13,1,0,2,'u2',0,'',1536173746,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(14,1,0,2,'u2',0,'',1536173746,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(15,1,0,2,'u2',0,'',1536173747,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(16,1,0,2,'u2',0,'',1536173747,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(17,1,0,2,'u2',0,'',1536173747,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(18,1,0,2,'u2',0,'',1536173747,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(19,1,0,2,'u2',0,'',1536173747,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(20,1,2,3,'u3',0,'',1536187332,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(21,1,2,3,'u3',0,'',1536187354,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(22,1,2,3,'u3',0,'',1536241332,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(23,1,2,3,'u3',0,'',1536241386,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(24,1,2,3,'u3',0,'',1536253501,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(25,1,2,3,'u3',0,'',1536323252,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(26,1,2,3,'u3',0,'',1536339366,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(27,1,2,3,'u3',0,'',1536342151,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(28,1,2,3,'u3',0,'',1536348278,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(29,1,2,3,'u3',0,'',1536348289,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(30,1,2,3,'u3',0,'',1536348292,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(31,1,2,3,'u3',0,'',1536348305,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(32,1,2,3,'u3',0,'',1536349821,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(33,1,2,3,'u3',0,'',1536350196,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(34,0,1,0,'danddy',0,'',1536350728,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(35,1,2,3,'u3',0,'',1536350955,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(36,0,1,0,'dandddy',0,'',1536351187,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(37,0,1,0,'danddy',0,'',1536351228,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(38,0,1,0,'danddy',0,'',1536352736,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(39,0,1,0,'danddy',0,'',1536352837,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(40,0,1,0,'danddy',0,'',1536352909,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(41,0,1,0,'danddy',0,'',1536352964,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(42,0,1,0,'danddy',0,'',1536352981,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(43,0,1,0,'danddy',0,'',1536353054,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(44,0,1,0,'danddy',0,'',1536353083,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(45,0,1,4,'danddy',0,'',1536353185,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(46,0,1,5,'danddy',0,'',1536353517,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(47,0,1,6,'danddy',0,'',1536353747,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(48,0,1,7,'danddy',0,'',1536353869,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(49,0,1,8,'danddy',0,'',1536353937,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(50,0,1,8,'danddy',0,'',1536353937,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(51,1,2,3,'u3',0,'',1536354016,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(52,0,1,8,'danddy',0,'',1536354023,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(53,1,2,3,'u3',0,'',1536355200,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(54,0,3,8,'danddy',0,'',1536355212,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(55,1,2,3,'u3',0,'',1536355554,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(56,0,3,8,'danddy',0,'',1536355559,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(57,1,2,3,'u3',0,'',1536356052,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(58,1,2,3,'u3',0,'',1536356261,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(59,1,2,3,'u3',0,'',1536357355,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(60,1,2,3,'u3',0,'',1536357760,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(61,1,2,3,'u3',0,'',1536358612,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(62,1,2,3,'u3',0,'',1536409129,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(63,1,2,3,'u3',0,'',1536418377,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(64,1,2,3,'u3',0,'',1536419142,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(65,1,2,3,'u3',0,'',1536420412,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(66,1,2,3,'u3',0,'',1536424112,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(67,1,2,3,'u3',0,'',1536439955,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(68,0,3,8,'danddy',0,'',1536442774,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(69,1,2,9,'u9',0,'',1536442933,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(70,1,2,9,'u9',0,'',1536445065,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(71,1,2,9,'u9',0,'',1536447193,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(72,0,3,8,'danddy',0,'',1536448066,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(73,1,2,9,'u9',0,'',1536448072,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(74,1,2,9,'u9',0,'',1536495648,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(75,1,2,9,'u9',0,'',1536496030,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(76,1,2,9,'u9',0,'',1536496856,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(77,1,2,9,'u9',0,'',1536497507,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(78,1,3,8,'danddy',0,'',1536497526,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(79,1,2,9,'u9',0,'',1536498905,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(80,1,2,9,'u9',0,'',1536503899,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(81,1,2,9,'u9',0,'',1536504815,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(82,1,2,9,'u9',0,'',1536507702,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(83,1,2,9,'u9',0,'',1536509874,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(84,1,4,10,'客服1',0,'',1536510355,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(85,1,2,9,'u9',0,'',1536511201,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(86,1,2,9,'u9',0,'',1536516682,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(87,1,2,9,'u9',0,'',1536519928,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(89,1,2,9,'游客C3DF0D322E',0,'大家',1536521614,'127.0.0.1','eeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f0a9caae'),
(90,1,2,9,'游客C3DF0D322E',0,'大家',1536521635,'127.0.0.1','eddeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','48774859'),
(91,1,2,9,'游客C3DF0D322E',0,'大家',1536522179,'127.0.0.1','ererewr ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2f0b8662'),
(92,1,2,9,'游客C3DF0D322E',0,'大家',1536522255,'127.0.0.1','sadssdsdsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3e315dd6'),
(93,1,2,9,'游客C3DF0D322E',0,'大家',1536522255,'127.0.0.1','sadssdsdsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3e315dd6'),
(94,1,2,9,'游客C3DF0D322E',0,'大家',1536522458,'127.0.0.1','555',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','516d1d2c'),
(95,1,2,9,'游客C3DF0D322E',0,'大家',1536523425,'127.0.0.1','eeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','11479d6e'),
(96,1,2,9,'游客C3DF0D322E',0,'大家',1536523436,'127.0.0.1','eerree',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f61e4963'),
(97,1,2,9,'游客C3DF0D322E',0,'大家',1536523540,'127.0.0.1','jjjjj',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','bd19c89b'),
(98,1,2,9,'游客C3DF0D322E',0,'大家',1536523751,'127.0.0.1','dfdf ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','58c75417'),
(99,1,2,9,'游客C3DF0D322E',0,'大家',1536523759,'127.0.0.1','wereree',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','dde1b87d'),
(100,1,2,9,'游客C3DF0D322E',0,'大家',1536523763,'127.0.0.1','werwerwerwe',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','903d0ee4'),
(101,1,2,9,'游客C3DF0D322E',0,'大家',1536523772,'127.0.0.1','dgdfgfg',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','71a97a4b'),
(102,1,1,1,'admin',0,'',1536524553,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(103,1,2,9,'u9',0,'',1536524583,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(104,1,3,8,'danddy',0,'',1536524589,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(105,1,3,8,'danddy',0,'大家',1536524604,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b627ad61'),
(106,1,3,8,'danddy',0,'大家',1536524674,'127.0.0.1','ewrwerwe',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e44845b6'),
(107,1,3,8,'danddy',0,'大家',1536524676,'127.0.0.1','eeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','05d4b6e7'),
(108,1,3,8,'danddy',0,'大家',1536524683,'127.0.0.1','e',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b3244b93'),
(109,1,3,8,'danddy',0,'大家',1536524856,'127.0.0.1','455',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2c28900d'),
(110,1,3,8,'danddy',0,'大家',1536525283,'127.0.0.1','ssss',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','02cbb8b5'),
(111,1,3,8,'danddy',0,'大家',1536525293,'127.0.0.1','sssss',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7526ab72'),
(112,1,3,8,'danddy',0,'大家',1536525313,'127.0.0.1','ssssss',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','901c977f'),
(113,1,3,8,'danddy',0,'大家',1536525414,'127.0.0.1','lllll',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7d341631'),
(114,1,3,8,'danddy',0,'大家',1536525425,'127.0.0.1','tyyyyyy',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','595f3d3b'),
(115,1,3,8,'danddy',0,'大家',1536525834,'127.0.0.1','<img src=\"/room/face/pic/bba_thumb.gif\" onresizestart=\"return false\" contenteditable=\"false\">',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0566069d'),
(116,1,3,8,'danddy',0,'大家',1536525838,'127.0.0.1','<img src=\"/room/face/pic/good_thumb.gif\">',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cbe6e469'),
(117,1,3,8,'danddy',0,'大家',1536525847,'127.0.0.1','<img src=\"/room/face/colorbar/xh.gif\">',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','011a2803'),
(118,1,3,8,'danddy',0,'大家',1536526172,'127.0.0.1','ddddddddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3c5a46bc'),
(119,1,3,8,'danddy',0,'大家',1536526180,'127.0.0.1','fdgfgfdgdfgdfg',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0b754535'),
(120,1,2,9,'u9',0,'',1536527333,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(121,1,3,8,'danddy',0,'',1536527476,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(122,1,2,12,'u12',0,'',1536527529,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(123,1,2,12,'游客756F2266B2',0,'大家',1536528000,'127.0.0.1','22222',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e36d1e63'),
(124,1,2,12,'游客756F2266B2',0,'大家',1536528017,'127.0.0.1','ghjhggh',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d6e8352c'),
(125,1,2,12,'游客756F2266B2',0,'大家',1536528186,'127.0.0.1','54+65653',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6b1cde38'),
(126,1,2,12,'游客756F2266B2',0,'大家',1536528945,'127.0.0.1','kkkkk',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f138f08c'),
(127,1,2,12,'游客756F2266B2',0,'大家',1536528954,'127.0.0.1','kkkkkk',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','73bc02e7'),
(128,1,3,8,'danddy',0,'',1536529958,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(129,1,3,8,'danddy',0,'大家',1536530200,'127.0.0.1','4455',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','133b70e1'),
(130,1,2,12,'u12',0,'',1536530722,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(131,1,2,12,'游客756F2266B2',0,'大家',1536530739,'127.0.0.1','111',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ffc27a36'),
(132,1,2,12,'游客756F2266B2',0,'大家',1536530872,'127.0.0.1','12222',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','64b522bd'),
(133,1,2,12,'游客756F2266B2',0,'大家',1536530936,'127.0.0.1','erewrerer',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fc9a3212'),
(134,1,2,12,'游客756F2266B2',0,'大家',1536531051,'127.0.0.1','5555',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','32dac164'),
(135,1,2,12,'游客756F2266B2',0,'大家',1536533082,'127.0.0.1','rtrerr',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b964b7b3'),
(136,1,2,12,'游客756F2266B2',0,'大家',1536533246,'127.0.0.1','trytrtryt',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2067b70c'),
(137,1,2,12,'u12',0,'',1536593926,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(138,1,2,12,'游客756F2266B2',0,'大家',1536594711,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','66df0c8d'),
(139,1,2,12,'游客756F2266B2',0,'大家',1536594955,'127.0.0.1','dddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','9253bcd0'),
(140,1,2,12,'游客756F2266B2',0,'大家',1536595253,'127.0.0.1','eeeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0fbb176f'),
(141,1,2,12,'游客756F2266B2',0,'大家',1536595322,'127.0.0.1','eeeeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f7627c9d'),
(142,1,2,12,'游客756F2266B2',0,'大家',1536595330,'127.0.0.1','nnnnnn',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0e8cc6e1'),
(143,1,2,12,'游客756F2266B2',0,'大家',1536595909,'127.0.0.1','2222',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a6894c85'),
(144,1,2,12,'游客756F2266B2',0,'大家',1536601816,'127.0.0.1','323233',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6e7d21a7'),
(145,1,2,12,'游客756F2266B2',0,'大家',1536603883,'127.0.0.1','121212',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','339fc4d3'),
(146,1,2,12,'游客756F2266B2',0,'大家',1536606755,'127.0.0.1','eeeeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a5b914a6'),
(147,1,2,12,'游客756F2266B2',0,'大家',1536606917,'127.0.0.1','333',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4cc57409'),
(148,1,2,12,'游客756F2266B2',0,'大家',1536606936,'127.0.0.1','ffgfg',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8bdcb4e9'),
(149,1,2,12,'游客756F2266B2',0,'大家',1536607047,'127.0.0.1','wwwwww',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e8845967'),
(150,1,2,12,'游客756F2266B2',0,'大家',1536607447,'127.0.0.1','4',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d459d8e7'),
(151,1,2,12,'游客756F2266B2',0,'大家',1536607674,'127.0.0.1','33333',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e838e30a'),
(152,1,2,12,'游客756F2266B2',0,'大家',1536607747,'127.0.0.1','eeeeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','05bb8306'),
(153,1,2,12,'游客756F2266B2',0,'大家',1536608080,'127.0.0.1','jjjjj',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','019e3919'),
(154,1,2,12,'游客756F2266B2',0,'大家',1536608203,'127.0.0.1','dfsdfsdfsfsd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8c12e8a9'),
(155,1,2,12,'游客756F2266B2',0,'大家',1536608382,'127.0.0.1','dddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4619875d'),
(156,1,2,12,'游客756F2266B2',0,'大家',1536608764,'127.0.0.1','ffff',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','64b35481'),
(157,1,2,12,'游客756F2266B2',0,'大家',1536609264,'127.0.0.1','22222',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','45a4710d'),
(158,1,2,12,'游客756F2266B2',0,'大家',1536609301,'127.0.0.1','色温翁无',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d22038db'),
(159,1,2,12,'游客756F2266B2',0,'大家',1536609324,'127.0.0.1','lllll',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','46da1a64'),
(160,1,2,12,'游客756F2266B2',0,'大家',1536609418,'127.0.0.1','辅导辅导费',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8d4329d2'),
(161,1,2,12,'游客756F2266B2',0,'大家',1536609986,'127.0.0.1','eeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e48a2cf1'),
(162,1,2,12,'游客756F2266B2',0,'大家',1536610061,'127.0.0.1','dddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','63331252'),
(163,1,2,12,'游客756F2266B2',0,'大家',1536610215,'127.0.0.1','反反复复付付',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4afa6516'),
(164,1,2,12,'游客756F2266B2',0,'大家',1536610310,'127.0.0.1','地方大幅度',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','44c52134'),
(165,1,2,12,'游客756F2266B2',0,'大家',1536610368,'127.0.0.1','4545345',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ea25c76a'),
(166,1,2,12,'游客756F2266B2',0,'大家',1536611025,'127.0.0.1','的点点滴滴',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','69676942'),
(167,1,2,12,'游客756F2266B2',0,'大家',1536611110,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','983dda11'),
(168,1,2,12,'游客756F2266B2',0,'大家',1536611181,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','960aa6d0'),
(169,1,2,12,'游客756F2266B2',0,'大家',1536611373,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8449a1fc'),
(170,1,2,12,'游客756F2266B2',0,'大家',1536611493,'127.0.0.1','萨达撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a868d854'),
(171,1,2,12,'游客756F2266B2',0,'大家',1536611667,'127.0.0.1','当时所发生的',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','53d7d815'),
(172,1,2,12,'游客756F2266B2',0,'大家',1536611881,'127.0.0.1','大萨达撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a13ad929'),
(173,1,2,12,'游客756F2266B2',0,'大家',1536611955,'127.0.0.1','对方水电费是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8f4766da'),
(174,1,2,12,'游客756F2266B2',0,'大家',1536612359,'127.0.0.1','二恶烷若无若无',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','60668d88'),
(175,1,2,12,'游客756F2266B2',0,'大家',1536612712,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','020d100a'),
(176,1,2,12,'游客756F2266B2',0,'大家',1536612847,'127.0.0.1','三生三世',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','30c389d9'),
(177,1,2,12,'游客756F2266B2',0,'大家',1536612941,'127.0.0.1','额鹅鹅鹅',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3901a2bc'),
(178,1,2,12,'游客756F2266B2',0,'大家',1536614933,'127.0.0.1','大萨达撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d8e24179'),
(179,1,2,12,'游客756F2266B2',0,'大家',1536615120,'127.0.0.1','是是是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e84dda9e'),
(180,1,2,12,'游客756F2266B2',0,'大家',1536615124,'127.0.0.1','三生三世',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ae3d55ad'),
(181,1,2,12,'游客756F2266B2',0,'大家',1536615558,'127.0.0.1','的点点滴滴',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7e35050c'),
(182,1,2,12,'游客756F2266B2',0,'大家',1536615632,'127.0.0.1','三生三世',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','5ee2a24a'),
(183,1,2,12,'游客756F2266B2',0,'大家',1536615651,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','011d8ef1'),
(184,1,2,12,'游客756F2266B2',0,'大家',1536615661,'127.0.0.1','5555 ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3110db8f'),
(185,1,2,12,'游客756F2266B2',0,'大家',1536615674,'127.0.0.1','4453453534',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','07847ee8'),
(186,1,2,12,'游客756F2266B2',0,'大家',1536615774,'127.0.0.1','水电费水电费对方',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','76520d6b'),
(187,1,2,12,'游客756F2266B2',0,'大家',1536615782,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d03ecb3d'),
(188,1,2,12,'游客756F2266B2',0,'大家',1536615797,'127.0.0.1','34324324',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7a898996'),
(189,1,2,11,'u11',0,'',1536616245,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(190,1,2,11,'游客92850372E5',0,'大家',1536616264,'127.0.0.1','rrtetr',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','39073cb7'),
(191,1,2,12,'游客756F2266B2',0,'大家',1536616606,'127.0.0.1','的发送到发送到',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a1210d0c'),
(192,1,2,12,'游客756F2266B2',0,'大家',1536616779,'127.0.0.1','的点点滴滴',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6e0576d2'),
(193,1,2,12,'游客756F2266B2',0,'大家',1536616825,'127.0.0.1','是的发送到三',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','08980567'),
(194,1,2,12,'游客756F2266B2',0,'大家',1536616846,'127.0.0.1','山东人发顺丰对方',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','06f2f7af'),
(195,1,2,12,'游客756F2266B2',0,'大家',1536616880,'127.0.0.1','是的富人思维方式对方',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8b390e74'),
(196,1,2,12,'游客756F2266B2',0,'大家',1536617284,'127.0.0.1','ASADAte',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f73eb974'),
(197,1,2,12,'游客756F2266B2',0,'大家',1536617420,'127.0.0.1','额热热无若',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e7c8d631'),
(198,1,2,12,'游客756F2266B2',0,'大家',1536617456,'127.0.0.1','fgsdgdsfdfd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b2777b46'),
(199,1,2,12,'游客756F2266B2',0,'大家',1536617718,'127.0.0.1','sdfdsfdsf',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','bdcdeff1'),
(200,1,2,12,'游客756F2266B2',0,'大家',1536617740,'127.0.0.1','dfdffddddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cf62e48f'),
(201,1,2,12,'游客756F2266B2',0,'大家',1536619024,'127.0.0.1','sdsadsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0f2d8ecb'),
(202,1,2,12,'游客756F2266B2',0,'大家',1536619029,'127.0.0.1','sdsdsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','19e87b01'),
(203,1,2,12,'游客756F2266B2',0,'大家',1536619162,'127.0.0.1','ffff',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','51ca995b'),
(204,1,2,12,'游客756F2266B2',0,'大家',1536619186,'127.0.0.1','ddddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','064fecc9'),
(205,1,2,12,'u12',0,'',1536667750,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(206,1,2,12,'游客756F2266B2',0,'大家',1536667780,'127.0.0.1','sdsdsdsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','5b914cad'),
(207,1,2,12,'游客756F2266B2',0,'大家',1536667800,'127.0.0.1','ssssss',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','66d03b74'),
(208,1,2,12,'游客756F2266B2',0,'大家',1536670232,'127.0.0.1','fdfdfd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cbc9c081'),
(209,1,2,12,'游客756F2266B2',0,'大家',1536670367,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ee9e45f7'),
(210,1,2,12,'游客756F2266B2',0,'大家',1536670379,'127.0.0.1','eeeeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2ca74873'),
(211,1,2,12,'游客756F2266B2',0,'大家',1536670396,'127.0.0.1','nihao',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b2b6937a'),
(212,1,2,12,'游客756F2266B2',0,'大家',1536670649,'127.0.0.1','sdddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2a2d7df9'),
(213,1,2,12,'游客756F2266B2',0,'大家',1536671031,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cd72a359'),
(214,1,2,12,'游客756F2266B2',0,'大家',1536671069,'127.0.0.1','eeeeee',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','bdee03aa'),
(215,1,2,12,'游客756F2266B2',0,'大家',1536671728,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','50df3bb7'),
(216,1,2,12,'游客756F2266B2',0,'大家',1536671862,'127.0.0.1','dddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b499acca'),
(217,1,2,12,'游客756F2266B2',0,'大家',1536672088,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','320c09d8'),
(218,1,2,12,'游客756F2266B2',0,'大家',1536672174,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','99b69e7f'),
(219,1,2,12,'游客756F2266B2',0,'大家',1536672181,'127.0.0.1','yyyyy',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','df6cb4f0'),
(220,1,2,12,'游客756F2266B2',0,'大家',1536672272,'127.0.0.1','sssss',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','36ec1f36'),
(221,1,2,12,'游客756F2266B2',0,'大家',1536672281,'127.0.0.1','你好',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','04db344a'),
(222,1,2,12,'游客756F2266B2',0,'大家',1536672292,'127.0.0.1','我想你了',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6593a4c3'),
(223,1,2,12,'游客756F2266B2',0,'大家',1536672308,'127.0.0.1','来自世界的恐惧',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2bf60fe0'),
(224,1,2,12,'游客756F2266B2',0,'大家',1536672323,'127.0.0.1','天外飞仙',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8b9ce429'),
(225,1,2,11,'u11',0,'',1536672340,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(226,1,2,12,'游客756F2266B2',0,'大家',1536672358,'127.0.0.1','你好啊360 我是谷歌',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','45b64d7e'),
(227,1,2,11,'游客92850372E5',0,'大家',1536672384,'127.0.0.1','rrrr',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1235d333'),
(228,1,2,12,'游客756F2266B2',0,'大家',1536672391,'127.0.0.1','你好',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','76eb6a49'),
(229,1,2,11,'游客92850372E5',0,'大家',1536672401,'127.0.0.1','ddddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ba42e2a3'),
(230,1,2,12,'游客756F2266B2',0,'大家',1536672476,'127.0.0.1','的点点滴滴',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4eca5fc8'),
(231,1,2,11,'游客92850372E5',0,'大家',1536672499,'127.0.0.1','我是你大爷',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e85e0f58'),
(232,1,2,11,'游客92850372E5',0,'大家',1536672665,'127.0.0.1','呃呃呃呃呃呃呃',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','faec0d16'),
(233,1,2,11,'游客92850372E5',0,'大家',1536672710,'127.0.0.1','呜呜呜呜',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0e583c6f'),
(234,1,2,12,'游客756F2266B2',0,'大家',1536673173,'127.0.0.1','打扰对方',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b8794764'),
(235,1,2,12,'游客756F2266B2',0,'大家',1536678997,'127.0.0.1','额鹅鹅鹅',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','00e3daf5'),
(236,1,2,11,'游客92850372E5',0,'大家',1536679004,'127.0.0.1','而额外热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e847de3c'),
(237,1,2,12,'游客756F2266B2',0,'大家',1536679010,'127.0.0.1','额问问无',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fd6a8d5f'),
(238,1,2,11,'游客92850372E5',0,'大家',1536679020,'127.0.0.1','额鹅鹅鹅',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','66f97ec6'),
(239,1,2,12,'游客756F2266B2',0,'大家',1536679028,'127.0.0.1','hi',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','46f7d1ef'),
(240,1,2,12,'游客756F2266B2',0,'大家',1536679099,'127.0.0.1','而噩噩',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','35f4c897'),
(241,1,2,11,'游客92850372E5',0,'大家',1536679104,'127.0.0.1','通融通融',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c88b00d4'),
(242,1,2,11,'游客92850372E5',0,'大家',1536679111,'127.0.0.1','热同仁堂',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cdde4747'),
(243,1,2,11,'游客92850372E5',0,'大家',1536679118,'127.0.0.1','让他让他人',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d3d129f8'),
(244,1,2,12,'游客756F2266B2',0,'大家',1536679134,'127.0.0.1','坎坎坷坷扩',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','46314202'),
(245,1,2,11,'游客92850372E5',0,'大家',1536679138,'127.0.0.1','天通苑',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2e4d2929'),
(246,1,2,11,'游客92850372E5',0,'大家',1536679157,'127.0.0.1','热热热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7d0ae631'),
(247,1,2,12,'游客756F2266B2',0,'大家',1536679202,'127.0.0.1','同仁堂',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','884b25d6'),
(248,1,2,11,'游客92850372E5',0,'大家',1536679206,'127.0.0.1','尔特太热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','13ceebd5'),
(249,1,2,11,'游客92850372E5',0,'大家',1536679213,'127.0.0.1','热热热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0d2e4870'),
(250,1,2,12,'游客756F2266B2',0,'大家',1536679225,'127.0.0.1','热热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7ad21afd'),
(251,1,2,12,'游客756F2266B2',0,'大家',1536679233,'127.0.0.1','热同仁堂',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d5af73bd'),
(252,1,2,11,'游客92850372E5',0,'大家',1536679243,'127.0.0.1','问问',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1c2f1ed7'),
(253,1,2,11,'游客92850372E5',0,'大家',1536679269,'127.0.0.1','而威尔',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4c29d752'),
(254,1,2,12,'游客756F2266B2',0,'大家',1536679276,'127.0.0.1','吞吞吐吐',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fa455e24'),
(255,1,2,12,'游客756F2266B2',0,'大家',1536679338,'127.0.0.1','56565656565656',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cd1d9201'),
(256,1,2,11,'游客92850372E5',0,'大家',1536679375,'127.0.0.1','额鹅鹅鹅',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ce36c258'),
(257,1,2,11,'游客92850372E5',0,'大家',1536679394,'127.0.0.1','顺丰到付 ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ae0879f3'),
(258,1,2,12,'游客756F2266B2',0,'大家',1536679581,'127.0.0.1','3434 ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','eddc5b57'),
(259,1,2,11,'游客92850372E5',0,'大家',1536679586,'127.0.0.1','额鹅鹅鹅',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','33c9885e'),
(260,1,2,11,'游客92850372E5',0,'大家',1536679590,'127.0.0.1','667676',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c1e4e71f'),
(261,1,2,11,'游客92850372E5',0,'大家',1536679673,'127.0.0.1','尔尔',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','560e7c14'),
(262,1,2,11,'游客92850372E5',0,'大家',1536679678,'127.0.0.1','热热热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','10caf7d1'),
(263,1,2,12,'游客756F2266B2',0,'大家',1536679685,'127.0.0.1','dfdfd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4ad15b66'),
(264,1,2,12,'游客756F2266B2',0,'大家',1536680015,'127.0.0.1','dddd dddd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','dc3a641a'),
(265,1,2,11,'游客92850372E5',0,'大家',1536680226,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','900cd2e9'),
(266,1,2,11,'游客92850372E5',0,'大家',1536680238,'127.0.0.1','尔尔',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fcbc1f57'),
(267,1,2,11,'游客92850372E5',0,'大家',1536680444,'127.0.0.1','21212',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','96dd65db'),
(268,1,2,11,'游客92850372E5',0,'大家',1536680641,'127.0.0.1','额鹅鹅鹅',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7c116463'),
(269,1,2,11,'游客92850372E5',0,'大家',1536680660,'127.0.0.1','瑞福特让他人',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','af22ce0f'),
(270,1,2,11,'游客92850372E5',0,'大家',1536680777,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e93abc7f'),
(271,1,2,12,'游客756F2266B2',0,'大家',1536680807,'127.0.0.1','eererer',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6cbe08d5'),
(272,1,2,12,'游客756F2266B2',0,'大家',1536680814,'127.0.0.1','rtrtrtrtrt',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','820ce040'),
(273,1,2,12,'游客756F2266B2',0,'大家',1536680824,'127.0.0.1','rerererer',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b97c4404'),
(274,1,2,11,'游客92850372E5',0,'大家',1536681020,'127.0.0.1','的地方双方都',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4f08e3f8'),
(275,1,2,12,'游客756F2266B2',0,'大家',1536681025,'127.0.0.1','weweweww',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','911d354e'),
(276,1,2,12,'游客756F2266B2',0,'大家',1536681028,'127.0.0.1','wewewewewe',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','15e6f8b2'),
(277,1,2,12,'游客756F2266B2',0,'大家',1536681085,'127.0.0.1','ewewe对方的说法',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8f335968'),
(278,1,2,11,'游客92850372E5',0,'大家',1536681090,'127.0.0.1','喂喂喂',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e4d1da7d'),
(279,1,2,11,'游客92850372E5',0,'大家',1536681217,'127.0.0.1','萨达撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','561ba786'),
(280,1,2,12,'游客756F2266B2',0,'大家',1536681220,'127.0.0.1','的单身多所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','284dcd13'),
(281,1,2,12,'游客756F2266B2',0,'大家',1536681378,'127.0.0.1','各位人人',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','5856ea6c'),
(282,1,2,11,'游客92850372E5',0,'大家',1536681381,'127.0.0.1','3污染温热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ee9d0eb2'),
(283,1,2,11,'游客92850372E5',0,'大家',1536681397,'127.0.0.1','爱的速递所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','43580507'),
(284,1,2,12,'游客756F2266B2',0,'大家',1536681402,'127.0.0.1','萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7aa4753f'),
(285,1,2,11,'游客92850372E5',0,'大家',1536681412,'127.0.0.1','喂喂喂',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','85d60dc1'),
(286,1,2,12,'游客756F2266B2',0,'大家',1536681416,'127.0.0.1','耳朵翁翁',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','572744a8'),
(287,1,2,11,'游客92850372E5',0,'大家',1536681463,'127.0.0.1','任务热若',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ad6f5892'),
(288,1,2,12,'游客756F2266B2',0,'大家',1536681513,'127.0.0.1','色调所多所多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7eda88bd'),
(289,1,2,11,'游客92850372E5',0,'大家',1536681526,'127.0.0.1','问问',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e44cb0ab'),
(290,1,2,11,'游客92850372E5',0,'大家',1536681606,'127.0.0.1','啥电视',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4a805c54'),
(291,1,2,12,'游客756F2266B2',0,'大家',1536681611,'127.0.0.1','二二热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','90f20672'),
(292,1,2,11,'游客92850372E5',0,'大家',1536681623,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','32b66ce6'),
(293,1,2,12,'游客756F2266B2',0,'大家',1536681627,'127.0.0.1','大萨达撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7832f8c5'),
(294,1,2,11,'游客92850372E5',0,'大家',1536681772,'127.0.0.1','完全二翁',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a2a668f6'),
(295,1,2,12,'游客756F2266B2',0,'大家',1536681775,'127.0.0.1','是是是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d34f1049'),
(296,1,2,11,'游客92850372E5',0,'大家',1536681778,'127.0.0.1','说是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','866bcb60'),
(297,1,2,12,'游客756F2266B2',0,'大家',1536681805,'127.0.0.1','驱蚊器二翁',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','bbc61c8f'),
(298,1,2,11,'游客92850372E5',0,'大家',1536681809,'127.0.0.1','是撒多所多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1564ba87'),
(299,1,2,12,'游客756F2266B2',0,'大家',1536681893,'127.0.0.1','热热热',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c3780403'),
(300,1,2,12,'游客756F2266B2',0,'大家',1536682011,'127.0.0.1','三生三世',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fb15f7c1'),
(301,1,2,11,'游客92850372E5',0,'大家',1536682033,'127.0.0.1','读的书',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c8df9c3e'),
(302,1,2,11,'游客92850372E5',0,'大家',1536682938,'127.0.0.1','萨达撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4dace46f'),
(303,1,2,12,'游客756F2266B2',0,'大家',1536682955,'127.0.0.1','企鹅窝群二无',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','bfded944'),
(304,1,2,12,'游客756F2266B2',0,'大家',1536683001,'127.0.0.1','色调所多所多所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f89d43d3'),
(305,1,2,12,'游客756F2266B2',0,'大家',1536683008,'127.0.0.1','3434343',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cb372839'),
(306,1,2,11,'游客92850372E5',0,'大家',1536683012,'127.0.0.1','对方水电费但是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','eedf64b9'),
(307,1,2,11,'游客92850372E5',0,'大家',1536683039,'127.0.0.1','萨达所大所按时禾嘉股份湖广会馆',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a2e73db1'),
(308,1,2,11,'游客92850372E5',0,'大家',1536683115,'127.0.0.1','萨达所大所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','5565924d'),
(309,1,2,11,'游客92850372E5',0,'大家',1536683125,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8cda473e'),
(310,1,2,11,'游客92850372E5',0,'大家',1536683143,'127.0.0.1','敖德萨多所多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','5b4d017f'),
(311,1,2,12,'游客756F2266B2',0,'大家',1536683221,'127.0.0.1','萨达撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c0c2d6dd'),
(312,1,2,11,'游客92850372E5',0,'大家',1536683231,'127.0.0.1','哦哦哦哦哦哦哦',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ad151ed3'),
(313,1,2,11,'游客92850372E5',0,'大家',1536683265,'127.0.0.1','爱迪生多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6b2e9517'),
(314,1,2,11,'游客92850372E5',0,'大家',1536683271,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b7d15c64'),
(315,1,2,12,'游客756F2266B2',0,'大家',1536683276,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','da7606c7'),
(316,1,2,11,'游客92850372E5',0,'大家',1536683357,'127.0.0.1','辅导辅导',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1e2db324'),
(317,1,2,11,'游客92850372E5',0,'大家',1536683372,'127.0.0.1','是是是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0faade78'),
(318,1,2,12,'游客756F2266B2',0,'大家',1536683376,'127.0.0.1','三生三世',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','206a10ae'),
(319,1,2,11,'游客92850372E5',0,'大家',1536683399,'127.0.0.1','但事实上',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','99f53e9a'),
(320,1,2,12,'游客756F2266B2',0,'大家',1536683517,'127.0.0.1','萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','381501ed'),
(321,1,2,11,'游客92850372E5',0,'大家',1536683522,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','24081598'),
(322,1,2,11,'游客92850372E5',0,'大家',1536683527,'127.0.0.1','好尴尬湖广会馆',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3c1729a3'),
(323,1,2,11,'游客92850372E5',0,'大家',1536683551,'127.0.0.1','把你那边',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','9fc43318'),
(324,1,2,12,'游客756F2266B2',0,'大家',1536683582,'127.0.0.1','萨达所大所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','85cfd117'),
(325,1,2,11,'游客92850372E5',0,'大家',1536683832,'127.0.0.1','大萨达撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a57893ca'),
(326,1,2,11,'游客92850372E5',0,'大家',1536683873,'127.0.0.1','问问',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f58b2ef5'),
(327,1,2,12,'游客756F2266B2',0,'大家',1536683879,'127.0.0.1','萨达撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','50ada3fc'),
(328,1,2,11,'游客92850372E5',0,'大家',1536683954,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','642e3788'),
(329,1,2,12,'游客756F2266B2',0,'大家',1536683960,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4cbb37ad'),
(330,1,2,12,'游客756F2266B2',0,'大家',1536684718,'127.0.0.1','大萨达撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2ba9bbf3'),
(331,1,2,12,'游客756F2266B2',0,'大家',1536684886,'127.0.0.1','萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','565c8afe'),
(332,1,2,12,'游客756F2266B2',0,'大家',1536689635,'127.0.0.1','www',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','df11da4d'),
(333,1,2,12,'u12',0,'',1536693542,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(334,1,2,12,'u12',0,'',1536693632,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(335,1,2,12,'游客756F2266B2',0,'大家',1536694323,'127.0.0.1','萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','67e238be'),
(336,1,2,12,'游客756F2266B2',0,'大家',1536694330,'127.0.0.1','是的发送到发送到',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b10e71f9'),
(337,1,2,12,'游客756F2266B2',0,'大家',1536694338,'127.0.0.1','辅导辅导费',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e78ff0eb'),
(338,1,2,11,'游客92850372E5',0,'大家',1536694363,'127.0.0.1','萨达撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','9ee843c7'),
(339,1,2,11,'游客92850372E5',0,'大家',1536694368,'127.0.0.1','更换，即可将很快',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ca303287'),
(340,1,2,11,'游客92850372E5',0,'大家',1536694740,'127.0.0.1','是的发生大幅度',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','35cd1914'),
(341,1,2,12,'游客756F2266B2',0,'大家',1536694746,'127.0.0.1','萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','76d12f4e'),
(342,1,2,12,'游客756F2266B2',0,'大家',1536694753,'127.0.0.1','3232323',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','12a37598'),
(343,1,2,11,'游客92850372E5',0,'大家',1536694760,'127.0.0.1','多发的所发生的',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ec831f81'),
(344,1,2,12,'游客756F2266B2',0,'大家',1536694777,'127.0.0.1','阿斯顿撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7bf66c6c'),
(345,1,2,11,'游客92850372E5',0,'大家',1536694781,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c11cb741'),
(346,1,2,12,'游客756F2266B2',0,'大家',1536694806,'127.0.0.1','站下载X',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1adbecc0'),
(347,1,2,11,'游客92850372E5',0,'大家',1536694809,'127.0.0.1','萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0963eabe'),
(348,1,2,12,'游客756F2266B2',0,'大家',1536694822,'127.0.0.1','减肥的时刻放款速度快',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e2c2fbe8'),
(349,1,2,11,'游客92850372E5',0,'大家',1536694824,'127.0.0.1','但是是的发送到',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1c334a55'),
(350,1,2,13,'游客9B84D7F99D',0,'大家',1536694917,'127.0.0.1','dfdsfsd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1d9850d3'),
(351,1,2,13,'游客9B84D7F99D',0,'大家',1536694938,'127.0.0.1','ie浏览器',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','24e01c9c'),
(352,1,2,11,'游客92850372E5',0,'大家',1536694960,'127.0.0.1','谷歌浏览器',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b5554188'),
(353,1,2,11,'游客92850372E5',0,'大家',1536694974,'127.0.0.1','360',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','cca9b78e'),
(354,1,3,8,'danddy',0,'',1536695031,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(355,1,1,14,'danddy2',0,'',1536695093,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(356,1,3,14,'danddy2',0,'',1536695093,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(357,1,1,15,'danddy3',0,'',1536695141,'127.0.0.1','用户注册',2,NULL,NULL,NULL,NULL),
(358,1,3,15,'danddy3',0,'',1536695141,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(359,1,2,12,'u12',0,'',1536695177,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(360,1,2,12,'游客756F2266B2',0,'大家',1536695200,'127.0.0.1','hhhh ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','25356560'),
(361,1,3,8,'danddy',0,'大家',1536695244,'127.0.0.1','sdjsadj ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7059111b'),
(362,1,3,8,'danddy',0,'大家',1536695249,'127.0.0.1','sdfdfhdj ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e90c5d52'),
(363,1,3,14,'danddy2',0,'大家',1536695262,'127.0.0.1','adhsahdashj ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8e8ee302'),
(364,1,3,14,'danddy2',0,'大家',1536695302,'127.0.0.1','dfdkfd ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1138753d'),
(365,1,3,14,'danddy2',0,'大家',1536695383,'127.0.0.1','dsdsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','54e00975'),
(366,1,1,1,'admin',0,'大家',1536696922,'127.0.0.1','ssdsdsd ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','31baa932'),
(367,1,1,1,'admin',0,'大家',1536696933,'127.0.0.1','我是管理员',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c6eec699'),
(368,1,3,14,'danddy2',0,'大家',1536696967,'127.0.0.1','dsad ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','424c6518'),
(369,1,3,14,'danddy2',0,'大家',1536696971,'127.0.0.1','dsdd ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','053500e1'),
(370,1,3,14,'danddy2',0,'大家',1536696987,'127.0.0.1','dsdsds ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6a50e992'),
(371,1,1,1,'admin',0,'大家',1536696995,'127.0.0.1','大萨达撒大',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e4c46c71'),
(372,1,1,1,'admin',0,'大家',1536697240,'127.0.0.1','地方大幅度',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a818ac43'),
(373,1,1,1,'admin',8,'danddy',1536697328,'127.0.0.1','你好',NULL,'true',0,'',''),
(374,1,1,1,'admin',8,'danddy',1536697333,'127.0.0.1','水电费水电费',NULL,'true',0,'',''),
(375,1,1,1,'admin',8,'danddy',1536697358,'127.0.0.1','你好',NULL,'true',0,'',''),
(376,1,3,14,'danddy2',0,'大家',1536697631,'127.0.0.1','sadsd ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a319f7c6'),
(377,1,1,1,'admin',0,'大家',1536697651,'127.0.0.1','是非得失大富科技',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','899d2827'),
(378,1,1,1,'admin',0,'大家',1536697657,'127.0.0.1','常出现',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','da5750e6'),
(379,1,1,1,'admin',8,'danddy',1536697693,'127.0.0.1','对方水电费但是',NULL,'true',0,'',''),
(380,1,1,1,'admin',8,'danddy',1536697709,'127.0.0.1','萨达萨达',NULL,'true',0,'',''),
(381,1,1,1,'admin',8,'danddy',1536697764,'127.0.0.1','喂喂喂群',NULL,'true',0,'',''),
(382,1,1,1,'admin',8,'danddy',1536697777,'127.0.0.1','大萨达撒大',NULL,'true',0,'',''),
(383,1,1,1,'admin',8,'danddy',1536698158,'127.0.0.1','123',NULL,'true',0,'',''),
(384,1,1,1,'admin',8,'danddy',1536698176,'127.0.0.1','的范德萨发的',NULL,'true',0,'',''),
(385,1,1,1,'admin',0,'大家',1536699030,'127.0.0.1','萨达撒多撒',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','afcc8e0c'),
(386,1,1,1,'admin',0,'大家',1536699035,'127.0.0.1','额外热无若',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','9f30e22b'),
(387,1,1,1,'admin',0,'大家',1536699080,'127.0.0.1','第三方士大夫',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8cbe5b83'),
(388,1,1,1,'admin',8,'danddy',1536699234,'127.0.0.1','发的所发生的',NULL,'true',0,'',''),
(389,1,3,14,'danddy2',0,'大家',1536699405,'127.0.0.1','dsafdf ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','73b2e3ab'),
(390,1,3,14,'danddy2',0,'大家',1536699415,'127.0.0.1','dsfdsfds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','99b27da6'),
(391,1,3,14,'danddy2',0,'大家',1536699418,'127.0.0.1','dsfdsfdsfs',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e9cf9bd7'),
(392,1,1,1,'admin',8,'danddy',1536699625,'127.0.0.1','热污染翁',NULL,'true',1,'',''),
(393,1,1,1,'admin',8,'danddy',1536699751,'127.0.0.1','大萨达撒',NULL,'true',1,'',''),
(394,1,1,1,'admin',8,'danddy',1536699823,'127.0.0.1','大萨达撒',NULL,'true',1,'',''),
(395,1,1,1,'admin',8,'danddy',1536700147,'127.0.0.1','而额外热无吧',NULL,'true',1,'',''),
(396,1,1,1,'admin',8,'danddy',1536700293,'127.0.0.1','奥术大师大所',NULL,'true',1,'',''),
(397,1,3,8,'danddy',1,'admin',1536700360,'127.0.0.1','sdrsed ',NULL,'true',0,'',''),
(398,1,1,1,'admin',14,'danddy2',1536700789,'127.0.0.1','大萨达撒大',NULL,'true',1,'',''),
(399,1,3,14,'danddy2',1,'admin',1536700799,'127.0.0.1','dsfhfdjsfj ',NULL,'true',0,'',''),
(400,1,3,14,'danddy2',1,'admin',1536700804,'127.0.0.1','sdfhsdjfsj ',NULL,'true',0,'',''),
(401,1,1,1,'admin',8,'danddy',1536700829,'127.0.0.1','你好',NULL,'true',1,'',''),
(402,1,3,8,'danddy',1,'admin',1536700836,'127.0.0.1','nihao',NULL,'true',0,'',''),
(403,1,1,1,'admin',14,'danddy2',1536700861,'127.0.0.1','你好啊',NULL,'true',1,'',''),
(404,1,3,14,'danddy2',1,'admin',1536700879,'127.0.0.1','hello!',NULL,'true',0,'',''),
(405,1,1,1,'admin',14,'danddy2',1536700892,'127.0.0.1','很高心见到你',NULL,'true',1,'',''),
(406,1,3,14,'danddy2',1,'admin',1536700905,'127.0.0.1','很高兴见到你',NULL,'true',0,'',''),
(407,1,1,1,'admin',14,'danddy2',1536700951,'127.0.0.1','我也是',NULL,'true',1,'',''),
(408,1,3,14,'danddy2',1,'admin',1536700960,'127.0.0.1','我也是',NULL,'true',0,'',''),
(409,1,3,14,'danddy2',0,'大家',1536702333,'127.0.0.1','<img src=\"/room/face/pic/angrya_thumb.gif\" onresizestart=\"return false\" contenteditable=\"false\">',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2fd52e0b'),
(410,1,3,8,'danddy',0,'大家',1536702364,'127.0.0.1','ssssss',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','89bc4e7a'),
(411,1,1,1,'admin',0,'大家',1536702464,'127.0.0.1','fdsfdssdf',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e802006b'),
(412,1,3,14,'danddy2',0,'大家',1536706926,'127.0.0.1','晚上发斯蒂芬',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c275b325'),
(413,1,1,1,'admin',0,'大家',1536706970,'127.0.0.1','sfsdfsdf ',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','bd0efac5'),
(414,1,1,1,'admin',0,'大家',1536706994,'127.0.0.1','serferf ',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','da29f718'),
(415,1,3,8,'danddy',0,'大家',1536707002,'127.0.0.1','dsfdsf ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','932dff1c'),
(416,1,3,8,'danddy',0,'大家',1536707016,'127.0.0.1','adasdsadas ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e3756bc2'),
(417,1,1,1,'admin',0,'大家',1536707251,'127.0.0.1','adasdasda',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0af1d898'),
(418,1,3,14,'danddy2',0,'大家',1536707265,'127.0.0.1','安达市多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','441a3cd1'),
(419,1,3,14,'danddy2',0,'大家',1536707268,'127.0.0.1','阿斯顿撒多撒多所多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','62ffe92c'),
(420,1,3,14,'danddy2',0,'大家',1536707270,'127.0.0.1','爱仕达多撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','2783150a'),
(421,1,3,14,'danddy2',0,'大家',1536707272,'127.0.0.1','萨达撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','493154bd'),
(422,1,3,14,'danddy2',0,'大家',1536707274,'127.0.0.1','是撒多所多所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e9d13c5b'),
(423,1,3,14,'danddy2',0,'大家',1536707277,'127.0.0.1','萨达撒多撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b9b7f715'),
(424,1,3,14,'danddy2',0,'大家',1536707280,'127.0.0.1','阿斯顿撒多撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3791c721'),
(425,1,3,14,'danddy2',0,'大家',1536707284,'127.0.0.1','萨达撒多撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c10eec86'),
(426,1,3,14,'danddy2',0,'大家',1536707289,'127.0.0.1','萨达撒多撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ae65fc08'),
(427,1,3,14,'danddy2',0,'大家',1536707292,'127.0.0.1','萨达撒多撒多撒多所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fe719906'),
(428,1,3,14,'danddy2',0,'大家',1536707307,'127.0.0.1','黑平台',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','adf7ea25'),
(429,1,3,14,'danddy2',0,'大家',1536707321,'127.0.0.1','黑平台',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','95b19533'),
(430,1,3,14,'danddy2',0,'大家',1536707368,'127.0.0.1','<span style=\"color: rgb(51, 51, 51); background-color: rgb(231, 235, 242);\">黑平台</span>',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ebffdbf0'),
(431,1,3,8,'danddy',0,'大家',1536707389,'127.0.0.1','fdsdfsdjfs ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7e72428d'),
(432,1,2,12,'u12',0,'',1536754400,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(433,1,2,12,'游客756F2266B2',0,'大家',1536754497,'127.0.0.1','adsads',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0315bbfe'),
(434,1,2,11,'u11',0,'',1536754572,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(435,1,2,11,'游客92850372E5',0,'大家',1536754578,'127.0.0.1','fdsfds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','bc2571a9'),
(436,1,2,11,'游客92850372E5',0,'大家',1536754586,'127.0.0.1','你好',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ddd3c4d3'),
(437,1,1,1,'admin',0,'',1536755773,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(438,1,1,1,'admin',0,'大家',1536755776,'127.0.0.1','sdfsdfdfd',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','af028f69'),
(439,1,4,10,'客服1',0,'',1536755801,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(440,1,4,10,'客服1',0,'大家',1536755809,'127.0.0.1','你好、',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4c435b16'),
(441,1,4,10,'客服1',0,'大家',1536755822,'127.0.0.1','你好',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b933d8f0'),
(442,1,2,13,'u13',0,'',1536755851,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(443,1,3,8,'danddy',0,'',1536755887,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(444,1,3,8,'danddy',0,'大家',1536755897,'127.0.0.1','sjfdsfjs ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4fdf5f07'),
(445,1,3,8,'danddy',0,'大家',1536755903,'127.0.0.1','dgsdsadjas ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','335da972'),
(446,1,2,12,'u12',0,'',1536755922,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(447,1,3,8,'danddy',0,'大家',1536755943,'127.0.0.1','游客在吗',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0c8d3076'),
(448,1,4,10,'客服1',0,'大家',1536756474,'127.0.0.1','发的顺丰到付',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','92ae1c5e'),
(449,1,4,10,'客服1',0,'大家',1536756481,'127.0.0.1','大幅度萨达撒多撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','06d4c1ed'),
(450,1,4,10,'客服1',0,'大家',1536756579,'127.0.0.1','飒飒大师',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8bf00dec'),
(451,1,4,10,'客服1',0,'大家',1536757378,'127.0.0.1','大萨达多所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7b0eb206'),
(452,1,3,8,'danddy',0,'大家',1536757390,'127.0.0.1','萨达撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ffb8a11f'),
(453,1,3,8,'danddy',0,'大家',1536757422,'127.0.0.1','第三方士大夫但是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','31fed613'),
(454,1,3,8,'danddy',0,'大家',1536757594,'127.0.0.1','萨达撒多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','586eb2cd'),
(455,1,3,8,'danddy',0,'大家',1536757701,'127.0.0.1','你好',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','31091d0e'),
(456,1,3,8,'danddy',0,'大家',1536757748,'127.0.0.1','萨达撒多撒所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','48023cb0'),
(457,1,3,8,'danddy',0,'大家',1536757759,'127.0.0.1','的士速递多多多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','7acc1838'),
(458,1,3,8,'danddy',0,'大家',1536757862,'127.0.0.1','双方的发生',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','46f4cf43'),
(459,1,3,8,'danddy',0,'大家',1536758099,'127.0.0.1','大萨达撒大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c6a48a3f'),
(460,1,3,8,'danddy',0,'大家',1536758475,'127.0.0.1','是第三方对方',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1a2d59fd'),
(461,1,3,8,'danddy',0,'大家',1536758499,'127.0.0.1','首都师范大 ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fe30f870'),
(462,1,3,8,'danddy',0,'大家',1536758628,'127.0.0.1','是对方多福多寿',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b00fedb7'),
(463,1,1,1,'admin',0,'',1536759715,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(464,1,2,11,'u11',0,'',1536759766,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(465,1,1,1,'admin',0,'',1536759785,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(466,1,1,1,'admin',0,'大家',1536759791,'127.0.0.1','asdfsf',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3d419c5c'),
(467,1,1,1,'admin',0,'大家',1536759802,'127.0.0.1','sdhjkjhkhjkjk',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4c25aefc'),
(468,1,1,1,'admin',0,'大家',1536762643,'127.0.0.1','esfsdf ',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','838f1272'),
(469,1,1,1,'admin',0,'大家',1536763187,'127.0.0.1','fdsfdsfdsfdsf',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','204db912'),
(470,1,1,1,'admin',0,'大家',1536763215,'127.0.0.1','sdsadad',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','425bd0e3'),
(471,1,1,1,'admin',0,'大家',1536763310,'127.0.0.1','gdsgdfdfd',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8e78044d'),
(472,1,2,12,'u12',0,'',1536764089,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(473,1,1,1,'admin',0,'',1536764099,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(474,1,2,13,'u13',0,'',1536764133,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(475,1,3,8,'danddy',0,'',1536764149,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(476,1,3,8,'danddy',1,'admin',1536764184,'127.0.0.1','wwwddss',NULL,'true',0,'',''),
(477,1,3,8,'danddy',1,'admin',1536764187,'127.0.0.1','sadsadasdss',NULL,'true',0,'',''),
(478,1,3,8,'danddy',1,'admin',1536764189,'127.0.0.1','adssad',NULL,'true',0,'',''),
(479,1,1,1,'admin',0,'大家',1536764202,'127.0.0.1','asdasdsasa',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','34bf72da'),
(480,1,3,8,'danddy',0,'大家',1536764216,'127.0.0.1','asdsadsadsasa',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a16f1c56'),
(481,1,3,8,'danddy',0,'大家',1536764218,'127.0.0.1','sadsadsads',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','53babe68'),
(482,1,2,12,'u12',0,'',1536764225,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(483,1,1,1,'admin',0,'大家',1536764231,'127.0.0.1','asdsadasdsa',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ba3e5850'),
(484,1,3,8,'danddy',0,'大家',1536764236,'127.0.0.1','asdasdadsa',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b34f4f2d'),
(485,1,3,8,'danddy',10,'客服1',1536764298,'127.0.0.1','sadsadasda',NULL,'true',0,'',''),
(486,1,2,12,'游客756F2266B2',10,'客服1',1536764453,'127.0.0.1','kjkljo;',NULL,'true',0,'',''),
(487,1,1,1,'admin',0,'',1536764728,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(488,1,3,8,'danddy',1,'admin',1536764781,'127.0.0.1','dfdsfdsfds',NULL,'true',0,'',''),
(489,1,3,8,'danddy',0,'大家',1536764794,'127.0.0.1','dfdfdf',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c1b21aa6'),
(490,1,2,11,'u11',0,'',1536764843,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(491,1,3,8,'danddy',0,'大家',1536764861,'127.0.0.1','sdasdsada',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6e533ce2'),
(492,1,1,1,'admin',8,'danddy',1536764951,'127.0.0.1','fsdfdsfsdf',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e927754f'),
(493,1,1,1,'admin',8,'danddy',1536764962,'127.0.0.1','sdfdfdsfdsf',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6e910be1'),
(494,1,1,1,'admin',8,'danddy',1536764971,'127.0.0.1','dfdsfdsfsd',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','9a97a799'),
(495,1,1,1,'admin',0,'大家',1536764976,'127.0.0.1','fdfdsds',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','5e701368'),
(496,1,3,8,'danddy',0,'大家',1536764990,'127.0.0.1','dsfsdfsdfsd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d12e6916'),
(497,1,3,8,'danddy',0,'大家',1536765003,'127.0.0.1','dsfsfds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','94e52e4f'),
(498,1,3,8,'danddy',0,'大家',1536765035,'127.0.0.1','sfdssds ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','950e3c7b'),
(499,1,3,8,'danddy',0,'大家',1536765414,'127.0.0.1','dsdsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c48e7a58'),
(500,1,3,8,'danddy',0,'大家',1536765491,'127.0.0.1','dsdsdsd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','5a674c1d'),
(501,1,3,8,'danddy',0,'大家',1536765522,'127.0.0.1','sasadasasa  ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8a80e014'),
(502,1,3,8,'danddy',11,'游客92850372E5',1536765564,'127.0.0.1','wdsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','66e9403d'),
(503,1,3,8,'danddy',11,'游客92850372E5',1536765579,'127.0.0.1','sdfsdfsfs',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f522b28a'),
(504,1,3,8,'danddy',0,'大家',1536765586,'127.0.0.1','dsdsfsdfsdfs',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f82ca067'),
(505,1,3,8,'danddy',0,'大家',1536765591,'127.0.0.1','sdsdsdsd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ce8e1d43'),
(506,1,3,8,'danddy',0,'大家',1536765594,'127.0.0.1','ssdddsds',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4ba4b3d9'),
(507,1,3,8,'danddy',0,'大家',1536765616,'127.0.0.1','sasasaa',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1c4ee589'),
(508,1,3,8,'danddy',0,'大家',1536765620,'127.0.0.1','assaassasa',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','09af54e2'),
(509,1,3,8,'danddy',0,'大家',1536766068,'127.0.0.1','adsdsdsada d ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','415fddc3'),
(510,1,3,8,'danddy',0,'大家',1536766105,'127.0.0.1','hhhhh',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','49a0863c'),
(511,1,3,8,'danddy',0,'大家',1536766203,'127.0.0.1','你好',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6caa1ed6'),
(512,1,3,8,'danddy',0,'大家',1536766583,'127.0.0.1','是的发送到发送到',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','57ac6d03'),
(513,1,3,8,'danddy',0,'大家',1536766682,'127.0.0.1','阿森松岛所多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','3d2977c2'),
(514,1,3,8,'danddy',0,'大家',1536766809,'127.0.0.1','谁说的撒多撒多',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','61212d23'),
(515,1,3,8,'danddy',0,'大家',1536767085,'127.0.0.1','的第三方第三方',NULL,'ture',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b1a1c1ac'),
(516,1,3,8,'danddy',0,'大家',1536767155,'127.0.0.1','的士速递所',NULL,'true',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','dc52f09c'),
(517,1,3,8,'danddy',0,'大家',1536767163,'127.0.0.1','社发顺丰的',NULL,'true',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','b95141a2'),
(518,1,3,8,'danddy',0,'大家',1536767173,'127.0.0.1','违法东方闪电',NULL,'true',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','84f8b624'),
(519,1,1,1,'admin',0,'大家',1536767197,'127.0.0.1','wwadsad ',NULL,'false',1,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0289f216'),
(520,1,3,8,'danddy',0,'大家',1536767222,'127.0.0.1','萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','847a46e3'),
(521,1,3,8,'danddy',0,'大家',1536767425,'127.0.0.1','撒大多数',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6202d7ce'),
(522,1,3,8,'danddy',0,'大家',1536767520,'127.0.0.1','啥电视多发的所发生的',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d46fb713'),
(523,1,3,8,'danddy',0,'大家',1536768018,'127.0.0.1','都是啥地方',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e214bef9'),
(524,1,3,8,'danddy',0,'大家',1536768224,'127.0.0.1','是的范德萨是的',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','8cab297d'),
(525,1,3,8,'danddy',0,'大家',1536768333,'127.0.0.1','是多发的所发生的',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c9db4b78'),
(526,1,3,8,'danddy',0,'大家',1536769597,'127.0.0.1','奥术大师多撒',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','04777c47'),
(527,1,3,8,'danddy',0,'大家',1536769713,'127.0.0.1','对方水电费是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','930280ff'),
(528,1,3,8,'danddy',0,'大家',1536769730,'127.0.0.1','第三方士大夫是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','c5229899'),
(529,1,2,12,'u12',0,'',1536773498,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(530,1,3,8,'danddy',0,'',1536773505,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(531,1,3,8,'danddy',0,'',1536773608,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(532,1,3,8,'danddy',0,'大家',1536773612,'127.0.0.1','565665',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','33562cc8'),
(533,1,3,8,'danddy',0,'大家',1536773658,'127.0.0.1','sdsadsd ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1b0f2b6a'),
(534,1,2,13,'u13',0,'',1536773702,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(535,1,3,8,'danddy',0,'大家',1536773716,'127.0.0.1','fsdfsdfds ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','9ad8b959'),
(536,1,3,8,'danddy',0,'大家',1536773794,'127.0.0.1','dsfsdfs ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','59de31dd'),
(537,1,3,8,'danddy',0,'大家',1536773808,'127.0.0.1','asdasdasd',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','56616958'),
(538,1,3,8,'danddy',0,'大家',1536773825,'127.0.0.1','nihao ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','4832b0cd'),
(539,1,1,1,'admin',8,'danddy',1536773982,'127.0.0.1','递四方速递',NULL,'true',0,'',''),
(540,1,1,1,'admin',0,'大家',1536775084,'127.0.0.1','额鹅鹅鹅',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','84bd349a'),
(541,1,1,1,'admin',0,'大家',1536775101,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','1e2dc71b'),
(542,1,1,1,'admin',0,'大家',1536775107,'127.0.0.1','顶顶顶顶',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a35784ff'),
(543,1,1,1,'admin',0,'大家',1536775128,'127.0.0.1','多多少少多所多所',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','ef830320'),
(544,1,1,1,'admin',0,'大家',1536775155,'127.0.0.1','第三方第三方的发生',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f37c6dc3'),
(545,1,1,1,'admin',0,'大家',1536775174,'127.0.0.1','是的冯绍峰的',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','d5d50110'),
(546,1,1,1,'admin',0,'大家',1536775197,'127.0.0.1','的非官方大哥大',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','272f7c0c'),
(547,1,1,1,'admin',0,'大家',1536775433,'127.0.0.1','是的冯绍峰的是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','096c7caf'),
(548,1,3,0,'青石铺的老街',0,'大家',1536775455,'127.0.0.1','xcxzczx',NULL,'false',0,'','rebotmsg'),
(549,1,3,0,'青石铺的老街',0,'大家',1536775461,'127.0.0.1','xcxc',NULL,'false',0,'','rebotmsg'),
(550,1,3,0,'忙着耍酷',0,'大家',1536775469,'127.0.0.1','向创新政策性',NULL,'false',0,'','rebotmsg'),
(551,1,3,0,'忙着耍酷',0,'大家',1536775506,'127.0.0.1','方式发送到',NULL,'false',0,'','rebotmsg'),
(552,1,3,0,'忙着耍酷',0,'大家',1536775530,'127.0.0.1','置顶公告2018-09-12',NULL,'false',0,'','rebotmsg'),
(553,1,3,0,'忙着耍酷',0,'大家',1536775530,'127.0.0.1','置顶公告2018-09-12',NULL,'false',0,'','rebotmsg'),
(554,1,3,0,'忙着耍酷',0,'大家',1536775743,'127.0.0.1','大宝你好',NULL,'false',0,'','rebotmsg'),
(555,1,3,0,'忙着耍酷',0,'大家',1536775771,'127.0.0.1','敖德萨多所',NULL,'false',0,'','rebotmsg'),
(556,1,3,8,'danddy',0,'大家',1536775856,'127.0.0.1','rterter',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','a065bb61'),
(557,1,3,8,'danddy',0,'大家',1536775864,'127.0.0.1','rtertertrtrte',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','e0abfaf8'),
(558,1,2,11,'u11',0,'',1536775902,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(559,1,3,8,'danddy',0,'',1536775918,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(560,1,3,0,'漓刺',0,'大家',1536776066,'127.0.0.1','突然有人讨厌他人',NULL,'false',0,'','rebotmsg'),
(561,1,3,0,'漓刺',0,'大家',1536776076,'127.0.0.1','通过梵蒂冈梵蒂冈',NULL,'false',0,'','rebotmsg'),
(562,1,1,1,'admin',0,'大家',1536776287,'127.0.0.1','第三方士大夫',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','fcdb36af'),
(563,1,1,1,'admin',0,'大家',1536776545,'127.0.0.1','是对方多福多寿',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6dfed955'),
(564,1,1,1,'admin',0,'大家',1536776562,'127.0.0.1','阿斯蒂芬萨达萨达',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','6b66472e'),
(565,1,3,8,'danddy',0,'大家',1536777091,'127.0.0.1','是是是',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','40bf5c4d'),
(566,1,2,11,'u11',0,'',1536777151,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(567,1,3,8,'danddy',0,'',1536777166,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(568,1,3,8,'danddy',0,'大家',1536777171,'127.0.0.1','sfsdfsd ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','f86addca'),
(569,1,3,8,'danddy',0,'大家',1536778437,'127.0.0.1','ssdfsd ',NULL,'false',0,'font-weight:;font-style:; text-decoration:;color:; font-family:; font-size:','0c4a1387'),
(570,1,2,11,'u11',0,'',1536778474,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(571,1,2,11,'u11',0,'',1536778479,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(572,1,2,11,'u11',0,'',1536778480,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(573,1,2,11,'u11',0,'',1536778481,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(574,1,2,11,'u11',0,'',1536778481,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(575,1,2,11,'u11',0,'',1536778481,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(576,1,2,11,'u11',0,'',1536778482,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(577,1,2,11,'u11',0,'',1536778482,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(578,1,2,11,'u11',0,'',1536778483,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(579,1,2,11,'u11',0,'',1536778484,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(580,1,2,11,'u11',0,'',1536778484,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(581,1,2,11,'u11',0,'',1536778485,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(582,1,2,11,'u11',0,'',1536778485,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(583,1,2,11,'u11',0,'',1536778486,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(584,1,2,11,'u11',0,'',1536778486,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(585,1,2,11,'u11',0,'',1536778487,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(586,1,2,11,'u11',0,'',1536778487,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(587,1,2,11,'u11',0,'',1536778488,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(588,1,2,11,'u11',0,'',1536778599,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(589,1,2,11,'u11',0,'',1536778599,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(590,1,2,11,'u11',0,'',1536778600,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL),
(591,1,2,11,'u11',0,'',1536778642,'127.0.0.1','用户登陆',1,NULL,NULL,NULL,NULL);

/*Table structure for table `live_notice` */

DROP TABLE IF EXISTS `live_notice`;

CREATE TABLE `live_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(500) DEFAULT NULL COMMENT '标题',
  `txt` text COMMENT '内容',
  `ov` int(3) DEFAULT NULL COMMENT '排序',
  `type` int(2) DEFAULT NULL COMMENT '类型',
  `rid` int(2) DEFAULT NULL COMMENT '房间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `live_notice` */

insert  into `live_notice`(`id`,`title`,`txt`,`ov`,`type`,`rid`) values 
(1,'test1','testset',1,0,1);

/*Table structure for table `live_rebots` */

DROP TABLE IF EXISTS `live_rebots`;

CREATE TABLE `live_rebots` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `rebots` text COMMENT '机器人名字列表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `live_rebots` */

insert  into `live_rebots`(`id`,`rebots`) values 
(1,'温火\r\n罪三生\r\n懒得热情\r\n逃孽\r\n今晚月色真美\r\n青灯古城\r\n戏子的戏言\r\n凉城古巷\r\n语隔秋烟\r\n君长安\r\n时不我予\r\n风月无骨\r\n挥袖抚琴\r\n永夜月同孤\r\n与君多别离\r\n晚妆楼台\r\n青石铺的老街\r\n轻解罗衫\r\n忙着耍酷\r\n骑士.\r\n抽烟.\r\n老子最酷.\r\n踌躇.\r\n厌世.\r\n孤妄\r\n咒歌\r\n苏姬\r\n冷希\r\n傀心\r\n嗜魄\r\n寒魇\r\n泠魅\r\n孜幽\r\n逐玥\r\n倾尘\r\n蚩殁\r\n离殇\r\n陌霏\r\n寒言\r\n凉兮\r\n残瞳\r\n未情\r\n怜眸\r\n魂韵\r\n赤歌\r\n邪魅\r\n漓刺\r\n血泪\r\n骨枯\r\n墨羽\r\n七罪\r\n焚音\r\n锁蝶\r\n梵歌\r\n没有结果的等待｀\r\n╰雪茄、麻痹心\r\n继续沉沦づ\r\nD3ath” -亡魂\r\n空虚的生活√\r\nia紫竹情\r\n一宁会发光i\r\n思念Dè糖衣\r\n念之森蓝\r\n花尽千霜默\r\n涟彩寻\r\n☆雪妮の紫萦儿\r\n萌哒哒的傲气\r\n南葵思暖\r\n浅夏韵歌\r\n梦璃子\r\n神泣百花杀\r\n黑市夫人');

/*Table structure for table `live_sysmsg` */

DROP TABLE IF EXISTS `live_sysmsg`;

CREATE TABLE `live_sysmsg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `txt` text COMMENT 'text信息内容',
  `type` int(2) DEFAULT NULL COMMENT '信息类型（0：系统消息，1：置顶公告，2：管理提示）',
  `rid` int(5) DEFAULT NULL COMMENT '房间id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `live_sysmsg` */

insert  into `live_sysmsg`(`id`,`txt`,`type`,`rid`) values 
(1,'第一条置顶公告，欢迎观临！！！',1,1),
(2,'第二条置顶公告！',1,1),
(3,'第三条置顶公告！',1,1),
(4,'<span pingfang=\"\" sc=\"\" lantinghei=\"\" microsoft=\"\" yahei=\"\" arial=\"\" sans-serif=\"\" tahoma=\"\" font-size:=\"\" 16px=\"\"><span style=\"color:#ffff00;\">任何一个时代都是赚钱的时代!</span></span>',2,1),
(5,'<span style=\"font-family: arial; font-size: 13px;\"><span style=\"color:#ffff33;\">拥有一颗钻石的一部分,也要比完全拥有一块莱茵石好得多</span></span>',2,1),
(6,'<span pingfang=\"\" sc=\"\" lantinghei=\"\" microsoft=\"\" yahei=\"\" arial=\"\" sans-serif=\"\" tahoma=\"\" font-size:=\"\" 16px=\"\"><span style=\"color:#ffff33;\">股市中最好笑的事是买入和卖出股票的双方都认为他们的决策是最聪明的</span></span>',2,1),
(7,'<span style=\"color: rgb(255, 255, 255); font-family: Arial, &quot;Microsoft Yahei&quot;; font-size: 14px; background-color: rgba(0, 0, 0, 0.3);\">进入聊天室的游客，想要发言权限，进微信群，查看更多计划的，请加微信：</span><br />',0,1),
(8,'置顶公告2018-09-12',1,1),
(9,'置顶公告2018-09-12',1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
