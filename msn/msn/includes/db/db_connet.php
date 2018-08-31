<?php 
error_reporting(0);
class DbConnet{
	private $db_name;
	private $db_user;
	private $db_pwd;
	private $db_host;
	private $db_prefix;
	private $_conn;
	private $pdo;
	private $dsn;

	function __construct(){
		$db_config = parse_ini_file(str_replace("\\", '/', dirname(__FILE__) ).'/../../configs/db_config.ini',true);
		$this->db_name=$db_config['mysqld']['dbname'];
		$this->db_user=$db_config['mysqld']['dbuser'];
		$this->db_pwd=$db_config['mysqld']['dbpwd'];
		$this->db_host=$db_config['mysqld']['dbhost'];
		$this->db_prefix=$db_config['mysqld']['dbprefix'];
		$this->dsn ="mysql:host=".$this->db_host.";dbname=".$this->db_name;
		
		$this->connect();
		
		
// 		$this->_conn = mysql_connect($this->db_host,$this->db_user,$this->db_pwd) or die("数据库链接错误");
// 		mysql_select_db($this->db_name,$this->_conn);
// 		mysql_query("set names 'utf8'");
	}
	
	private function __clone(){}
	
	private function connect(){
		try{
			
		$this->pdo = new PDO($this->dsn, $this->db_user, $this->db_pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES `utf8`', PDO::ATTR_PERSISTENT => FALSE));
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		
		}catch(PDOException $e){
			die('Error:' . $e->getMessage() . '<br/>');
		}
		
	} 
	
	/**
	 * 获取一行
	 */
	function getRow($sql,$param=''){
		
		$cmd = $this->pdo->prepare($sql);
		if(!empty($param)){
			$cmd->execute($param);
		}else{
			$cmd->execute();
		}
		return $cmd->fetch(PDO::FETCH_ASSOC);
// 		$sql ="SELECT * FROM ".$tablename;
// 		if(!empty($orderby)){
// 			$sql .=" order by ".$orderby;
// 		}
// 		$result=mysql_query($sql);
// 		//提取数据
// 		return mysql_fetch_row($result,MYSQL_ASSOC);
	}
	/**
	 * 根据条件获取一行
	 */
// 	function getRowByWhere($tablename,$where=''){
// 		$sql ="SELECT * FROM ".$tablename;
// 		if(!empty($where)){
// 			$sql .=' where '.$where;
// 		}
// 		$result=mysql_query($sql);
// 		//提取数据
// 		return mysql_fetch_row($result,MYSQL_ASSOC);
// 	}
	/**
	 * 获取全部
	 */
	function getAllRows($sql,$param=''){//PDO::FETCH_CLASS
		$cmd = $this->pdo->prepare($sql);
		if(!empty($param)){
			$cmd->execute($param);
		}else{
			$cmd->execute();
		}
		$res =$cmd->fetchAll(PDO::FETCH_CLASS);
		if(empty($res)){
			return '';
		}else{
			$data=array();
			foreach($res as $key =>$val){
				foreach($val as $k=>$v){
					$data[$key][$k]=$v;
				}
			}
			return $data;
		}
		
// 		$sql ="SELECT * FROM ".$table_name;
// 		if(!empty($where)){
// 			$sql .=' where 1=1 '.$where;
// 		}
// 		$result=mysql_query($sql);
// 		$array=array();
// 		while( $row=mysql_fetch_array($result,MYSQL_ASSOC) ){
// 			$array[]=$row;
// 		}
// 		//提取数据
// 		return  $array;
	}
	/**
	 * 根据用户名查找
	 */
	function getByUsername($username){
		
		$sql ="select * from msn_admin where login_name =:login_name";
		$param =array(':login_name'=>$username);
		$cmd = $this->pdo->prepare($sql);
		$cmd->execute($param);
		return $cmd->fetch(PDO::FETCH_ASSOC);
	}
// 	function query($sql){
// 		$result=mysql_query($sql);
// 		return $result;
// 	}
	
	public function query($sql, $para = NULL)
	{
		$sqlType = strtoupper(substr($sql, 0, 6));
		$cmd = $this->pdo->prepare($sql);
		if($para != NULL)
		{
			$cmd->execute($para);
		}
		else
		{
			$cmd->execute();
		}
		if($sqlType == "SELECT")
		{
			return $cmd->fetchAll();
		}
		if($sqlType == "INSERT")
		{
			return $this->pdo->lastInsertId();
		}
		return $cmd->rowCount();
	}
	
}