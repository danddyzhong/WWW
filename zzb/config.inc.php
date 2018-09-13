<?php
error_reporting(0);		
	//-------请不要用记事本编辑，用npp++ 等utf8编辑器
	$dbhost = '127.0.0.1:3306';			// 数据库服务器
	$dbuser = 'root';			// 数据库用户名
	$dbpw = '123456';				// 数据库密码
	$dbname = 'zzb';			// 数据库名开
	$tablepre = 'live_';   			// 表名前缀, 同一数据库安装多个请修改此处

    //请不要用记事本编辑，用npp++ 等utf8编辑器
	$dbdebug=true;
	$dbcharset = '';			// MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照论坛字符集设定
	$charset = 'utf-8';			// 页面默认字符集, 可选 'gbk', 'big5', 'utf-8'
	$def_cfg='1';
	$goldname="金币";
	$discount=0.5;//礼物折扣率
	$adminemail = 'admin@your.com';		// 系统管理员 Email
	date_default_timezone_set("Asia/Shanghai");
	$timeoffset = 0; //时差 单位 秒
	$upgrade=15; //15小时升一级
	$tserver_key="this is key!!!";//服务器连接密钥！
	$ipmax=5;//同一IP每天限制注册次数
?>