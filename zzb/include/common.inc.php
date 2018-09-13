<?php 
error_reporting(0);
ini_set("display_errors",true);
session_start();
define('IN_PPCHAT',str_replace("\\", '/', dirname(__FILE__)));
define('PPCHAT_ROOT',IN_PPCHAT."/../");
include_once("/global.func.php");
include("/db_mysql.class.php");
include("/../config.inc.php");
$db = new dbstuff();
$timeoffset =8*3600;
function GetIP()
{
	static $realip = NULL;
	if ($realip !== NULL)
	{
		return $realip;
	}
	if (isset($_SERVER))
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			/* 取X-Forwarded-For中第x个非unknown的有效IP字符? */
			foreach ($arr as $ip)
			{
				$ip = trim($ip);
				if ($ip != 'unknown')
				{
					$realip = $ip;
					break;
				}
			}
		}
		elseif (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else
		{
			if (isset($_SERVER['REMOTE_ADDR']))
			{
				$realip = $_SERVER['REMOTE_ADDR'];
			}
			else
			{
				$realip = '0.0.0.0';
			}
		}
	}
	else
	{
		if (getenv('HTTP_X_FORWARDED_FOR'))
		{
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_CLIENT_IP'))
		{
			$realip = getenv('HTTP_CLIENT_IP');
		}
		else
		{
			$realip = getenv('REMOTE_ADDR');
		}
	}
	preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
	$realip = ! empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
	return $realip;
}
$onlineip =GETIP();
$db->connect($dbhost,$dbuser,$dbpw,$dbname);
// $dbdebug =true;
function _RunMagicQuotes(&$svar)
{
	if(!get_magic_quotes_gpc())
	{
		if( is_array($svar) )
		{
			foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
		}
		else
		{
			if( strlen($svar)>0 && preg_match('#^(cfg_|GLOBALS|_GET|_POST|_COOKIE|_SESSION)#',$svar) )
			{
				exit('Request var not allow!');
			}
			$svar = addslashes($svar);
		}
	}
	return $svar;
}
if (!defined('ZZBREQUEST'))
{
	//检查和注册外部提交的变量   (2011.8.10 修改登录时相关过滤)
	function CheckRequest(&$val) {
		if (is_array($val)) {
			foreach ($val as $_k=>$_v) {
				if($_k == 'nvarname') continue;
				CheckRequest($_k);
				CheckRequest($val[$_k]);
			}
		} else
		{
			if( strlen($val)>0 && preg_match('#^(cfg_|GLOBALS|_GET|_POST|_COOKIE|_SESSION)#',$val)  )
			{
				exit('Request var not allow!');
			}
		}
	}

	//var_dump($_REQUEST);exit;
	CheckRequest($_REQUEST);
	CheckRequest($_COOKIE);
	foreach(Array('_GET','_POST','_COOKIE') as $_request)
	{
		foreach($$_request as $_k => $_v)
		{
			if( strlen($_k)>0 && preg_match('/^(cfg_|GLOBALS)/i',$_k) ){
				exit('Request var not allow!');
			}

			if($_k == 'nvarname') ${$_k} = $_v;
			else ${$_k} = _RunMagicQuotes($_v);
		}

	}
}
$cfg['config']=$db->fetch_row($db->query("select * from {$tablepre}config where id='{$rid}'"));
// if(strpos($_SERVER['REQUEST_URI'],'adminv3') && !isset($_SESSION['admincp'])){
// 	$act ="user_login";
// }
// if(substr()){
	
// }

