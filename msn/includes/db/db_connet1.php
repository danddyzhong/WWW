<?php 
class DbConnet{
	private $db_name;
	private $db_user;
	private $db_pwd;
	private $db_host;
	private $db_prefix;
	private $_conn;

	function __construct(){
		$db_config = parse_ini_file(str_replace("\\", '/', dirname(__FILE__) ).'/../../configs/db_config.ini',true);
		$this->db_name=$db_config['mysqld']['dbname'];
		$this->db_user=$db_config['mysqld']['dbuser'];
		$this->db_pwd=$db_config['mysqld']['dbpwd'];
		$this->db_host=$db_config['mysqld']['dbhost'];
		$this->db_prefix=$db_config['mysqld']['dbprefix'];
		$this->_conn = mysql_connect($this->db_host,$this->db_user,$this->db_pwd) or die("数据库链接错误");
		mysql_select_db($this->db_name,$this->_conn);
		mysql_query("set names 'utf8'");
	}
	/**
	 * 获取一行
	 */
	function getRow($tablename,$orderby=''){
		$sql ="SELECT * FROM ".$tablename;
		if(!empty($orderby)){
			$sql .=" order by ".$orderby;
		}
		$result=mysql_query($sql);
		//提取数据
		return mysql_fetch_row($result,MYSQL_ASSOC);
	}
	/**
	 * 根据条件获取一行
	 */
	function getRowByWhere($tablename,$where=''){
		$sql ="SELECT * FROM ".$tablename;
		if(!empty($where)){
			$sql .=' where '.$where;
		}
		$result=mysql_query($sql);
		//提取数据
		return mysql_fetch_row($result,MYSQL_ASSOC);
	}
	/**
	 * 获取全部
	 */
	function getAllRows($table_name,$where=''){
		$sql ="SELECT * FROM ".$table_name;
		if(!empty($where)){
			$sql .=' where 1=1 '.$where;
		}
		$result=mysql_query($sql);
		$array=array();
		while( $row=mysql_fetch_array($result,MYSQL_ASSOC) ){
			$array[]=$row;
		}
		//提取数据
		return  $array;
	}
	/**
	 * 根据用户名查找
	 */
	function getByUsername($username){
		$sql ="select * from msn_admin where login_name ='{$username}'";
		$result=mysql_query($sql);
		//提取数据
		return mysql_fetch_array($result,MYSQL_ASSOC);
	}
	function query($sql){
		$result=mysql_query($sql);
		return $result;
	}
	
}