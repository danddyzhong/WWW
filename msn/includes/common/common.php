<?php 
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
//             $svar = addslashes($svar);
        }
    }
    return $svar;
}

if (!defined('DEDEREQUEST'))
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

//     var_dump($_REQUEST);exit;
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
/**
 *  短消息函数,可以在某个动作处理后友好的提示信息
 *
 * @param     string  $msg      消息提示信息
 * @param     string  $gourl    跳转地址
 * @param     int     $onlymsg  仅显示信息
 * @param     int     $limittime  限制时间
 * @return    void
 */
function ShowMsg($msg, $gourl, $onlymsg=0, $limittime=0)
{
	if(empty($GLOBALS['cfg_plus_dir'])) $GLOBALS['cfg_plus_dir'] = '..';

	$htmlhead  = "<html>\r\n<head>\r\n<title>提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">\r\n<meta name=\"renderer\" content=\"webkit\">\r\n<meta http-equiv=\"Cache-Control\" content=\"no-siteapp\" />";
	$htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>".(isset($GLOBALS['ucsynlogin']) ? $GLOBALS['ucsynlogin'] : '')."\r\n<center>\r\n<script>\r\n";
	$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

	$litime = ($limittime==0 ? 1000 : $limittime);
	$func = '';

	if($gourl=='-1')
	{
		if($limittime==0) $litime = 5000;
		$gourl = "javascript:history.go(-1);";
	}

	if($gourl=='' || $onlymsg==1)
	{
		$msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
	}
	else
	{
		//当网址为:close::objname 时, 关闭父框架的id=objname元素
		if(preg_match('/close::/',$gourl))
		{
			$tgobj = trim(preg_replace('/close::/', '', $gourl));
			$gourl = 'javascript:;';
			$func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
		}

		$func .= "      var pgo=0;
		function JumpUrl(){
		if(pgo==0){ location='$gourl'; pgo=1; }
	}\r\n";
	$rmsg = $func;
	$rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'>";
        $rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#DBEEBD url({$GLOBALS['cfg_plus_dir']}/img/wbg.gif)';'><b>提示信息！</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
        $rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
        $rmsg .= "document.write(\"";

        if($onlymsg==0)
        {
        if( $gourl != 'javascript:;' && $gourl != '')
        {
        $rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
        $rmsg .= "<br/></div>\");\r\n";
        $rmsg .= "setTimeout('JumpUrl()',$litime);";
        }
        else
        {
        $rmsg .= "<br/></div>\");\r\n";
        }
        }
        	else
        		{
            $rmsg .= "<br/><br/></div>\");\r\n";
	}
	$msg  = $htmlhead.$rmsg.$htmlfoot;
	}
    echo $msg;
}

/**
 *  获取验证码的session值
 *
 * @return    string
 */
function GetCkVdValue()
{
	@session_id($_COOKIE['PHPSESSID']);
	@session_start();
	return isset($_SESSION['securimage_code_value']) ? $_SESSION['securimage_code_value'] : '';
}
/**
 *  PHP某些版本有Bug，不能在同一作用域中同时读session并改注销它，因此调用后需执行本函数
 *
 * @return    void
 */
function ResetVdValue()
{
	@session_start();
	$_SESSION['securimage_code_value'] = '';
}
/**
 *  获取编辑器
 *
 * @access    public
 * @param     string  $fname 表单名称
 * @param     string  $fvalue 表单值
 * @param     string  $nheight 内容高度
 * @param     string  $etype 编辑器类型
 * @param     string  $gtype 获取值类型
 * @param     string  $isfullpage 是否全屏
 * @return    string
 */
function SpGetEditor($fname,$fvalue,$nheight="350",$etype="Basic",$gtype="print",$isfullpage="false",$bbcode=false)
{
	if(!isset($GLOBALS['cfg_html_editor']))
	{
		$GLOBALS['cfg_html_editor']='';
	}
	if($gtype=="")
	{
		$gtype = "print";
	}
	if($GLOBALS['cfg_html_editor']=='fck')
	{
		require_once(DEDEINC.'/FCKeditor/fckeditor.php');
		$fck = new FCKeditor($fname);
		$fck->BasePath        = $GLOBALS['cfg_cmspath'].'/include/FCKeditor/' ;
		$fck->Width        = '100%' ;
		$fck->Height        = $nheight ;
		$fck->ToolbarSet    = $etype ;
		$fck->Config['FullPage'] = $isfullpage;
		if($GLOBALS['cfg_fck_xhtml']=='Y')
		{
			$fck->Config['EnableXHTML'] = 'true';
			$fck->Config['EnableSourceXHTML'] = 'true';
		}
		$fck->Value = $fvalue ;
		if($gtype=="print")
		{
			$fck->Create();
		}
		else
		{
			return $fck->CreateHtml();
		}
	}
	else if($GLOBALS['cfg_html_editor']=='ckeditor')
	{
		require_once(DEDEINC.'/ckeditor/ckeditor.php');
		$CKEditor = new CKEditor();
		$CKEditor->basePath = $GLOBALS['cfg_cmspath'].'/include/ckeditor/' ;
		$config = $events = array();
		$config['extraPlugins'] = 'dedepage,multipic,addon';
		if($bbcode)
		{
			$CKEditor->initialized = true;
			$config['extraPlugins'] .= ',bbcode';
			$config['fontSize_sizes'] = '30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%';
			$config['disableObjectResizing'] = 'true';
			$config['smiley_path'] = $GLOBALS['cfg_cmspath'].'/images/smiley/';
			// 获取表情信息
			require_once(DEDEDATA.'/smiley.data.php');
			$jsscript = array();
			foreach($GLOBALS['cfg_smileys'] as $key=>$val)
			{
				$config['smiley_images'][] = $val[0];
				$config['smiley_descriptions'][] = $val[3];
				$jsscript[] = '"'.$val[3].'":"'.$key.'"';
			}
			$jsscript = implode(',', $jsscript);
			echo jsScript('CKEDITOR.config.ubb_smiley = {'.$jsscript.'}');
		}

		$GLOBALS['tools'] = empty($toolbar[$etype])? $GLOBALS['tools'] : $toolbar[$etype] ;
		$config['toolbar'] = $GLOBALS['tools'];
		$config['height'] = $nheight;
		$config['skin'] = 'kama';
		$CKEditor->returnOutput = TRUE;
		$code = $CKEditor->editor($fname, $fvalue, $config, $events);
		if($gtype=="print")
		{
			echo $code;
		}
		else
		{
			return $code;
		}
	}
	else {
		require_once(str_replace('\\','/',dirname(__FILE__)).'/../ckeditor/ckeditor.php');
		$CKEditor = new CKEditor();
		$CKEditor->basePath = '/includes/ckeditor/' ;
		$config = $events = array();
		$config['extraPlugins'] = 'dedepage,multipic,addon';
		if($bbcode)
		{
			$CKEditor->initialized = true;
			$config['extraPlugins'] .= ',bbcode';
			$config['fontSize_sizes'] = '30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%';
			$config['disableObjectResizing'] = 'true';
			$config['smiley_path'] = './../images/smiley/';
			// 获取表情信息
			require_once('./../data/smiley.data.php');
			$jsscript = array();
			foreach($GLOBALS['cfg_smileys'] as $key=>$val)
			{
				$config['smiley_images'][] = $val[0];
				$config['smiley_descriptions'][] = $val[3];
				$jsscript[] = '"'.$val[3].'":"'.$key.'"';
			}
			$jsscript = implode(',', $jsscript);
			echo jsScript('CKEDITOR.config.ubb_smiley = {'.$jsscript.'}');
		}

		$GLOBALS['tools'] = empty($toolbar[$etype])? $GLOBALS['tools'] : $toolbar[$etype] ;
		$config['toolbar'] = $GLOBALS['tools'];
		$config['height'] = $nheight;
		$config['skin'] = 'kama';
		$CKEditor->returnOutput = TRUE;
		$code = $CKEditor->editor($fname, $fvalue, $config, $events);
		if($gtype=="print")
		{
			echo $code;
		}
		else
		{
			return $code;
		}
	}
}
/**
 *  获取用户真实地址
 *
 * @return    string  返回用户ip
 */
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
