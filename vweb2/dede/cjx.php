<?php

/**
 * @version    $Id cjx.php 1001 2011-8-14 qjp $
 * @copyright  Copyright (c) 2010-2011,qjp
 * @license    This is NOT a freeware, use is subject to license terms
 * @link       http://www.qjp.name
 */

require(dirname(__FILE__)."/config.php");

if(!defined('PLUGINS')){
	header("Location: ".$cfg_cmsurl."/Plugins/run.php");
	exit;
}

if(!function_exists("dede_htmlspecialchars")){
	function dede_htmlspecialchars($str) {
		global $cfg_soft_lang;
	    if (version_compare(PHP_VERSION, '5.4.0', '<')) return htmlspecialchars($str);
	    if ($cfg_soft_lang=='gb2312') return htmlspecialchars($str,ENT_COMPAT,'ISO-8859-1');
	    else return htmlspecialchars($str);
	}
}

require DEDEADMIN.'/apps/CaiJiXia/cjx.class.php';

$allow_version = array('V55','V56','V57');
if(!in_array(substr($cfg_version,0,3),$allow_version))
{
	Showmsg('很抱歉，本插件只支持dedecms V5.5 V5.6 V5.7 版本',1,2);
	exit;
}

$m = isset($_REQUEST['m'])?$_REQUEST['m']:'';

$action = 'ac_'.($ac = empty($ac)?'index':$ac);
$instance = new admin_cjx;
if (method_exists ( $instance, $action ) === TRUE)
	$instance->$action();
else
	Showmsg('没有此操作',1,2);

?>
