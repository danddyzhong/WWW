<?php
function apiplus_curl($code,$row){
	if(!is_dir('cache'))
		mkdir('cache',0777);
	$cacheFile="./cache/{$code}.php";
	$fileTime=filemtime($cacheFile);
	if($fileTime){
		if(time()-$fileTime<5){
			include $cacheFile;
			if($data!="")return $data;
		}
	}
	
	$ch = curl_init();
	$api=array();
	$api['bjpk10']="http://api.1680210.com/pks/getLotteryPksInfo.do?lotCode=10001";
	$api['cqssc']="http://api.1680210.com/CQShiCai/getBaseCQShiCai.do?lotCode=10002";
	$api['jsk3']="http://api.1680210.com/lotteryJSFastThree/getBaseJSFastThree.do?lotCode=10007";
	$api['gdklsf']="http://api.1680210.com/klsf/getLotteryInfo.do?lotCode=10005";
	$api['cqklsf']="http://api.1680210.com/klsf/getLotteryInfo.do?lotCode=10009";
	$api['xjssc']="http://api.1680210.com/CQShiCai/getBaseCQShiCai.do?lotCode=10004";
	$api['bjkl8']="http://api.1680210.com/LuckTwenty/getBaseLuckTewnty.do?lotCode=10014";
	$api['hk6']="http://1680660.com/smallSix/findSmallSixInfo.do?lotCode=10048";
	$api['fc3d']="http://api.1680210.com/QuanGuoCai/getLotteryInfo1.do?&lotCode=10041";
	$api['pl3']="http://api.1680210.com/QuanGuoCai/getLotteryInfo1.do?&lotCode=10043";
	
	curl_setopt($ch, CURLOPT_URL, $api[$code]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_REFERER, "http://kj.1680210.com/");
	
	/*
	curl_setopt($ch, CURLOPT_URL, "http://122.10.67.252:8099/cpapi?code=$code&format=json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	*/
	/*
	//curl_setopt($ch, CURLOPT_URL, "http://a.apiplus.net/收费/{$code}-1.json");
		
	curl_setopt($ch, CURLOPT_URL, "http://f.apiplus.net/{$code}-1.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_REFERER, "http://opencai.net/apifree/");
	//*/
	$output=curl_exec($ch);
	curl_close($ch);
	
	file_put_contents($cacheFile,"<?php \n \$data='{$output}';");
	
	return $output;
}

function apiplus_data($code,$row){
	$json=apiplus_curl($_GET['code'],$_GET['n']);
	$json=json_decode($json,true);
	$json=$json["result"]["data"];
	$re=array();
	$re['data'][0]['expect']=$json['preDrawIssue'];
	$re['data'][0]['opencode']=$json['preDrawCode'];
	$re['data'][0]['opentime']=$json['preDrawTime'];
	$re['data'][0]['preDrawTime']=$json['drawTime'];
	
	$re['data'][0]["SN"]="PPChat.org 技术支持";
	$re['data'][0]["nowtime"]=date('Y-m-d H:i:s',time());
	//print_r($json);
	return json_encode($re);
}
echo apiplus_data($_GET['code'],$_GET['n']);
?>