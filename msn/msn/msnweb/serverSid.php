<?php
//载入ucpass类
error_reporting(0);
require_once('lib/Xigu.class.php');

//初始化必填
//填写在管理中心短信产品页面的APIID
$options['appid']='MDAwMDAwMDAwMK62sLB_iqCuf3vNmLDM';
//填写在管理中心短信产品页面的APIKEY
$options['apikey']='MDAwMDAwMDAwMLq5qLJ_inawgHvJ3bDc';
// $options['apikey']='sss';

//初始化 $options必填
$xigu = new Xigu($options);