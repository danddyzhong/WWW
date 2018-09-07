/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 5.5.57-log : Database - msn
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`msn` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `msn`;

/*Table structure for table `msn_admin` */

DROP TABLE IF EXISTS `msn_admin`;

CREATE TABLE `msn_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `login_name` varchar(50) NOT NULL COMMENT '登录名',
  `login_pwd` varchar(50) NOT NULL COMMENT '密码',
  `login_ip` varchar(50) DEFAULT NULL COMMENT '登录ip地址',
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `creat_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `msn_admin` */

insert  into `msn_admin`(`id`,`login_name`,`login_pwd`,`login_ip`,`login_time`,`creat_time`) values 
(1,'admin','5c3f69656','123.249.9.59',1536149094,NULL);

/*Table structure for table `msn_index_article` */

DROP TABLE IF EXISTS `msn_index_article`;

CREATE TABLE `msn_index_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `body` mediumtext COMMENT '首页文章内容',
  `time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `msn_index_article` */

insert  into `msn_index_article`(`id`,`body`,`time`) values 
(1,'<div class=\"tb_con\">\r\n	<div class=\"reg\">\r\n		<div class=\"form_body\">\r\n			<div class=\"tip_title\">\r\n				请输入您的手机号码</div>\r\n			<div class=\"list_menue\">\r\n				<div class=\"reg_t active nav_titl\">\r\n					注册</div>\r\n				<div class=\"log_t nav_titl\">\r\n					登录</div>\r\n				<div class=\"clear\">\r\n					&nbsp;</div>\r\n			</div>\r\n			<div class=\"list_content\">\r\n				<div class=\"reg list_cont\">\r\n					<div class=\"error_tips\" id=\"innerTips\" style=\"display:none;\">\r\n						&nbsp;</div>\r\n					<form action=\"reg.php\" id=\"myForm\" type=\"post\">\r\n						<div>\r\n							<div class=\"le_tit\">\r\n								<font color=\"red\">*</font>手机号：</div>\r\n							<div class=\"ri_tit\">\r\n								 <input class=\"phone_number\" id=\"phonenum\" name=\"yzmtel\" placeholder=\"您的手机号\" type=\"text\" /></div>\r\n							<div class=\"clear\">\r\n								&nbsp;</div>\r\n						</div>\r\n						<div class=\"pwd_tit\">\r\n							<div class=\"le_tit\">\r\n								<font color=\"red\">*</font>密码：</div>\r\n							<div class=\"ri_tit\">\r\n								<input class=\"pwd\" id=\"pwd\" name=\"pwd\" type=\"password\" /></div>\r\n							<div class=\"clear\">\r\n								&nbsp;</div>\r\n						</div>\r\n						<div>\r\n							<div class=\"le_tit\">\r\n								<font color=\"red\">*</font>验证码：</div>\r\n							<div class=\"fascode ri_tit\">\r\n								<input autocomplete=\"off\" class=\"scform_srchtxt\" name=\"code\" placeholder=\"请输入您收到的验证码\" value=\"\" /><input class=\"scform_code button\" id=\"btn\" onclick=\"sendemail()\" type=\"button\" value=\"获取验证码\" /></div>\r\n							<div class=\"clear\">\r\n								&nbsp;</div>\r\n						</div>\r\n						<div class=\"bt\">\r\n							<input class=\"button\" onclick=\"return verifyInput();\" type=\"submit\" value=\"注册\" /> <input class=\"button button2\" type=\"reset\" value=\"重置\" /></div>\r\n					</form>\r\n				</div>\r\n				<div class=\"log list_cont\">\r\n					<div class=\"error_tips\" id=\"innerTips2\" style=\"display:none;\">\r\n						&nbsp;</div>\r\n					<form action=\"login.php\" id=\"loginForm\" type=\"post\">\r\n						<div>\r\n							<div class=\"le_tit\">\r\n								<font color=\"red\">*</font>手机号：</div>\r\n							<div class=\"ri_tit\">\r\n								<input class=\"phone_number\" id=\"phonenum2\" name=\"phonenum\" placeholder=\"您的手机号\" type=\"text\" /></div>\r\n							<div class=\"clear\">\r\n								&nbsp;</div>\r\n						</div>\r\n						<div class=\"pwd_tit\">\r\n							<div class=\"le_tit\">\r\n								<font color=\"red\">*</font>密码：</div>\r\n							<div class=\"ri_tit\">\r\n								<input class=\"pwd\" id=\"pwd2\" name=\"pwd\" type=\"password\" /></div>\r\n							<div class=\"clear\">\r\n								&nbsp;</div>\r\n						</div>\r\n						<div class=\"bt\">\r\n							<input class=\"button\" onclick=\"return verifyInput2();\" type=\"submit\" value=\"登录\" /> <input class=\"button button2\" type=\"reset\" value=\"重置\" /> <input class=\"donothing\" name=\"donothing\" type=\"hidden\" style=\'display:none;\' /></div>\r\n					</form>\r\n				</div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n<br />\r\n',NULL);

/*Table structure for table `msn_member` */

DROP TABLE IF EXISTS `msn_member`;

CREATE TABLE `msn_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `phone_number` varchar(11) NOT NULL COMMENT '电话号码',
  `phone_pwd` varchar(50) NOT NULL COMMENT '密码',
  `phone_address` varchar(100) DEFAULT NULL COMMENT '号码归属地',
  `ip_address` varchar(50) DEFAULT NULL COMMENT 'ip地址',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `msn_member` */

insert  into `msn_member`(`id`,`phone_number`,`phone_pwd`,`phone_address`,`ip_address`,`create_time`) values 
(1,'12323232323','qwewewe3423',NULL,NULL,NULL),
(5,'13556816137','adc3949ba',NULL,'36.37.199.187',1535711208);

/*Table structure for table `msn_member_article` */

DROP TABLE IF EXISTS `msn_member_article`;

CREATE TABLE `msn_member_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `body` mediumtext COMMENT '内容',
  `time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `msn_member_article` */

insert  into `msn_member_article`(`id`,`body`,`time`) values 
(1,'trjdfhdtd',1535518833);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
