<?php 
session_start();
class userLogin{
	var $userPwd = '';
    var $userID = '';
    var $userName='';
    var $adminDir = '';
    var $userType = '';
    var $userChannel = '';
    var $userPurview = '';
    var $keepUserIDTag = 'msn_admin_id';
    var $keepUserNameTag = 'msn_admin_name';
    var $keepAdminStyleTag = 'msn_admin_style';
    var $adminStyle = 'dedecms';
    
	function __construct($admindir=''){
		global $admin_path;
		if(isset($_SESSION[$this->keepUserIDTag]))
		{
			$this->userID = $_SESSION[$this->keepUserIDTag];
			$this->userName = $_SESSION[$this->keepUserNameTag];
		}
		
		if($admindir!='')
		{
			$this->adminDir = $admindir;
		}
		else
		{
			$this->adminDir = $admin_path;
		}
	}
	
	function userLogin($admindir='')
	{
		$this->__construct($admindir);
	}
	
	/**
	 *  获取用户真实地址
	 *
	 * @return    string  返回用户ip
	 */
	private function GetIP()
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
	
	/**
	 *  检验用户是否正确
	 *
	 * @access    public
	 * @param     string    $username  用户名
	 * @param     string    $userpwd  密码
	 * @return    string
	 */
	public function checkUser($username, $userpwd)
	{
		
		include_once(str_replace("\\", '/', dirname(__FILE__) ).'./db/db_connet.php');
		//只允许用户名和密码用0-9,a-z,A-Z,'@','_','.','-'这些字符
		$this->userName = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $username);
		$this->userPwd = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $userpwd);
		$pwd = substr(md5($this->userPwd), 3, 9);
		$dbobj =new DbConnet();
		$row = $dbobj->getByUsername($username);
// 		var_dump($row);exit;
		if(!isset($row['login_pwd']))
		{
			return -1;
		}
		else if($pwd!=$row['login_pwd'])
		{
			return -2;
		}
		else
		{
			$loginip = $this->GetIP();
			$this->userID = $row['id'];
			$this->userName = $row['login_name'];
			$time=time();
// 			$inquery = "UPDATE `msn_admin` SET login_ip='$loginip',login_time='".time()."' WHERE id='".$row['id']."'";
			$inquery = "UPDATE `msn_admin` SET login_ip=?,login_time=? WHERE id=? ";
			$arr = array($loginip,$time,intval($row['id']));
 			$dbobj->query($inquery,$arr);
			return 1;
		}
	}
	
	public function PutCookie($key, $value, $kptime=0, $pa="/")
	{	
		$cfg_cookie_encode='00pMl0ABmgPUew79nWGoKS3xKteTqDl';
		$cfg_domain_cookie ='';
		setcookie($key, $value, time()+$kptime, $pa,$cfg_domain_cookie);
		setcookie($key.'__ckMd5', substr(md5($cfg_cookie_encode.$value),0,16), time()+$kptime, $pa,$cfg_domain_cookie);
	}
	/**
	 *  保持用户的会话状态
	 *
	 * @access    public
	 * @return    int    成功返回 1 ，失败返回 -1
	 */
	public function keepUser()
	{ 
		if($this->userID != '')
		{ 
			$_SESSION[$this->keepUserIDTag] = $this->userID;
			$_SESSION[$this->keepUserNameTag] = $this->userName;
			
			$this->PutCookie('MsnUserID', $this->userID, 3600 * 24, '/');
			$this->PutCookie('MsnLoginTime', time(), 3600 * 24, '/');
			return 1;
		}
		else
		{
			return -1;
		}
	
	}
	/**
	 *  获得用户的ID
	 *
	 * @access    public
	 * @return    int
	 */
	public function getUserID()
	{
		if($this->userID != '')
		{
			return $this->userID;
		}
		else
		{
			return -1;
		}
	}
	public function DropCookie($key)
    {
        $cfg_domain_cookie ='';
        setcookie($key, '', time()-360000, "/",$cfg_domain_cookie);
        setcookie($key.'__ckMd5', '', time()-360000, "/",$cfg_domain_cookie);
    }
	/**
	 *  结束用户的会话状态
	 *
	 * @access    public
	 * @return    void
	 */
	public function exitUser()
	{
		unset($_SESSION[$this->keepUserIDTag]);
		unset($_SESSION[$this->keepUseNameTag]);
		$this->DropCookie('MsnUserID');
		$this->DropCookie('MsnLoginTime');
		$_SESSION = array();
	}
}