<?php
header( 'Content-Type:text/html;charset=utf-8 '); 
error_reporting(0);
set_time_limit(0);
$rootPath = str_replace("\\", '/', dirname(__FILE__) );
function str_rand($length = 32, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
     if(!is_int($length) || $length < 0) {
		     return false;
		     }
		    $string = '';
		    for($i = $length; $i > 0; $i--) {
		         $string .= $char[mt_rand(0, strlen($char) - 1)];
		    }
			
			   return $string;
	}
$btUrl = $_POST['hosturl'];

$filename=str_rand(2).$_POST['doid'].$_POST['ver'].".torrent";
$params =array(
		'action' =>$_POST['action'],
        'doid' =>$_POST['doid'],
        'ver' =>$_POST['ver'],
);

function request_post($url,$param){
	if(empty($url) || empty($param)){
		return false;
	}
		$postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
}


function request_post2($url){
	$postUrl = $url;
	$ch = curl_init();//初始化curl
	curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
	curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	curl_setopt ($ch, CURLOPT_REFERER, "https://www.bttwo.com/");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	$data = curl_exec($ch);//运行curl
	curl_close($ch);
	return $data;
}

$data = request_post($btUrl,$params);
echo  request_post($btUrl,$_POST);exit;
$res =request_post2($data);
var_dump($res);exit;
file_put_contents($rootPath."/uploads/downloads/".$filename,$res);
// echo $res;exit;
$furl = rawurlencode("/uploads/downloads/".$filename);
echo "/uploads/downloads/".$filename;exit;