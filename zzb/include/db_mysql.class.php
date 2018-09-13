<?php
/***********************
Editor:Xianlin 
QQ:3350933991
***********************/
if(!defined('IN_PPCHAT')) {
	exit('Access Denied');
}
class dbstuff{
var $link;
function connect($host,$user,$passwd,$dbname='')
{
		if(!$this->link=@mysql_connect($host,$user,$passwd,1)) 
		$this->halt('Database connection failure');
		
		if($this->version() > '4.1') {
				global $charset, $dbcharset;
				$dbcharset = !$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8')) ? str_replace('-', '', $charset) : $dbcharset;
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $this->link);
		}
		if($dbname)
		mysql_select_db($dbname,$this->link) or die($this->halt("没有找到{$dbname}！ 请联系管理员！"));
}		
function close(){
	mysql_close($this->link);
}
function halt($str)
{
echo '<p style="font-family: Verdana, Tahoma; font-size: 11px; background: #FFFFFF;">'.$str.'</p>';
exit;
}
function query($sql)
{	
	if(!($re=mysql_query($sql,$this->link))&&$dbdebug)
	$this->halt('MySQL Query Error<br>'.mysql_error($this->link).'<br><br>'.$sql);
	return $re;
}
function query_cache($cname,$ltime,$sql){
	global $tablepre;
	$key = md5($sql);
	$time=time();
	$ltime+=$time;
	$query=$this->query("select * from {$tablepre}cache where k='$key'");
	if($this->num_rows($query)>0){
		$row=mysql_fetch_assoc($query);
		if((int)$row['ltime']>$time){return unserialize($row['v']);}
	}
	
	$this->query("delete from {$tablepre}cache where k='$key'");
	$nquery=$this->query($sql);
	while($r=$this->fetch_row($nquery)){
		$re[]=$r;
	}
	$val=serialize($re);
	$this->query("insert into {$tablepre}cache(k,v,ltime,cname)values('$key','$val','$ltime','$cname')");
	return $re;
}
function query_cache_clear($cname){
	global $tablepre;
	if($cname=="all")$this->query("delete from {$tablepre}cache");
	else $this->query("delete from {$tablepre}cache where cname='$cname'");
}
function fetch_row($query)
{
	return dhtmlspecialchars(mysql_fetch_assoc($query));
}
function num_rows($query)
{
	return @mysql_num_rows($query);
}
function insert_id() {
	return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
}
function result($query, $row = 0) {
	$query = @mysql_result($query, $row);
	return $query;
}
function totxt($str)
{
	$str=strip_tags($str);
	$str=str_replace("\r\n","",$str);
	$str=str_replace("\"","“",$str);
	$str=str_replace("'","‘",$str);
	$str=str_replace('\\',"/",$str);
	return $str;
}
function fhtml($str)
{
	//$str=trim($str);
	$str=str_replace("<","&lt;",$str);
	$str=str_replace(">","&gt;",$str);
	$str=str_replace("\n","<br>",$str);	
	return $str;
}
function version() {
	return mysql_get_server_info($this->link);
}
}
?>