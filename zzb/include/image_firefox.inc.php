<?php 
session_start();
session_cache_limiter("private, must-revalidate");

srand((double)microtime()*1000000);
//$str=numstr(4);
//$_SESSION['backValidate']=$str;

$str=jjf();
//生成验证码图片
if (function_exists("Imagepng")){
	$type = 'png';
}else if (function_exists("Imagejpeg")){
	$type = 'jpeg';
}else{
	$type = 'gif';
}
header("Content-type: image/".$type);
$width= 40;
$height= 20;
$im = imagecreate($width,$height); //制定图片背景大小

$black = ImageColorAllocate($im, 0,0,0); //设定三种颜色
$white = ImageColorAllocate($im, 255,255,255); 
$gray = ImageColorAllocate($im, 200,200,200); 

imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $gray );//背景位置
imagecolortransparent($im,$gray);
imagestring($im, 5, 2, 1, $str, $black);

$ImageFun='Image'.$type;
$ImageFun($im);
ImageDestroy($im); 

//生成随机数 
function mystr($length) { 
    $str = ''; 
    for ($i = 0; $i < $length; $i++) 
    { 
        $rand = mt_rand(1,35); 
        if ($rand < 10) 
            $str .= $rand; 
        else 
			if (chr($rand + 87)!="o") $str .= chr($rand + 87); 
    } 
    return $str; 
} 

//生成随机数 
function numstr($length) { 
    $str = ''; 
    for ($i = 0; $i < $length; $i++) 
    { 
        $rand = mt_rand(0,9); 
		$str .= $rand; 
    } 
    return $str; 
}
//加减法
function jjf(){
    $t1=mt_rand(5,9);
    $t2=mt_rand(0,5);
    $t3=mt_rand(0,1);
    if($t3){
        $t4=$t1+$t2;
        $str="{$t1}+{$t2}=";
    }

    else {
        $t4=$t1-$t2;
        $str="{$t1}-{$t2}=";
    }

    $_SESSION['backValidate']=$t4;
    return $str;
}
?>