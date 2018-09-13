<?php
function sms_send($send_tel,$send_str)
{
	 $str_rec = '';
	//短信接口用户名 $uid
	$uid = 'SDK2563';
	//短信接口密码 $passwd
	$passwd = '';
	//发送到的目标手机号码 $telphone
	
	
	$telphone = $send_tel;
	//短信内容 $message
	$message = $send_str;

	//$message = iconv("gb2312","utf-8//IGNORE",$message);   //(如果出现乱码需强制转换)
	$message = rawurlencode($message);
	$gateway = "http://api.bjszrk.com/sdk/BatchSend.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$telphone}&Content={$message}&Cell=&SendTime=";
	//echo $gateway;
	$result = file_get_contents($gateway);
	if(0 <$result)
	{
		 $str_rec="1";
	}
	else
	{
		 $str_rec= "发送失败, 错误提示代码: ".$result;
	}
   return $str_rec;
}
?>