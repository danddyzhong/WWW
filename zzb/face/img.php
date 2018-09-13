<?php
$u=$_GET['t'].'/'.$_GET['u'].".gif";
if(file_exists($u))header("Location: $u");
else 
{	
	if($_GET['t']=='p1'){
		$img="p1/null.gif";	
		
		if(stripos($u,'x_r_i')!=false){
			require_once '../include/common.inc.php';

			$xid=str_replace('x_r_i','',$u);
			$query=$db->query("select img from {$tablepre}apps_rebots where id ='$xid'");
			$r=@$db->fetch_row($query);
			if(trim($r[img])=="")$r[img]="p1/null.gif";
			$img=$r[img];
		}
	}
	
	else
	$img="p2/null.gif";
	
	header("Location: $img");
}
?>