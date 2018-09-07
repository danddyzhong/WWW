<?php
/**
 * User: XIGU LGD
 * Date: 2018/06/25
 * Time: 14:50
 * Dec : xigu php sdk
 */
class Xigu
{
    // API请求地址
    const BaseUrl = "http://sms.vlcms.com/api.php/user/";
	
    //开发者账号 APIID。
    private $appid;

    //开发者账号 APIKEY
    private $apikey;
    
    public function  __construct($options)
    {
        if (is_array($options) && !empty($options)) {
            $this->appid = isset($options['appid']) ? $options['appid'] : '';
            $this->apikey = isset($options['apikey']) ? $options['apikey'] : '';
        } else {
            throw new Exception("非法参数");
        }
    }

    
    private function getResult($url, $body = null)
    {
        $o = "";
        foreach ( $body as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $body = substr($o,0,-1);
        
        $data = $this->connection($url,$body);
        if (isset($data) && !empty($data)) {
            $result = $data;
        } else {
            $result = '没有返回数据';
        }
        return $result;
    }

    /**
     * @param $url    请求链接
     * @param $body   post数据
     */
	 
    private function connection($url, $body)
    {
        $postUrl = $url;
        $curlPost = $body;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }

    /**
	单条发送短信的function，适用于注册/找回密码/认证/操作提醒等单个用户单条短信的发送场景
     * @param $mobile       接收短信的手机号码
     * @param $templateid   短信模板，可在后台短信产品→选择应用→短信发送→签名/模板管理-模板ID，查看该模板ID
     * @param null $param   变量参数，多个参数使用英文逗号隔开（如：param=“a,b,c”）
     * @return mixed|string 
     * @throws Exception
     */
    public function SendSms($templateid,$param=null,$mobile){
        $url = self::BaseUrl . 'send_sms';
        $data = array(
            'appid'=>$this->appid,
            'apikey'=>$this->apikey,
            'templateid'=>$templateid,
			'param'=>$param,
			'phone'=>$mobile,
        );
        $data = $this->getResult($url, $data);
        return $data;
    }
	
	 /**
	 群发送短信的function，适用于运营/告警/批量通知等多用户的发送场景
     * @param $mobileList   接收短信的手机号码，多个号码将用英文逗号隔开，如“18088888888,15055555555,13100000000”
     * @param $templateid   短信模板，可在后台短信产品→选择应用→短信发送→签名/模板管理-模板ID，查看该模板ID
     * @param null $param   变量参数，多个参数使用英文逗号隔开（如：param=“a,b,c”）
     * @return mixed|string 
     * @throws Exception
     */
	public function SendSms_Batch($templateid,$param=null,$mobileList){
        $url = self::BaseUrl . 'send_sms_batch';
        $data = array(
            'appid'=>$this->appid,
            'apikey'=>$this->apikey,
            'templateid'=>$templateid,
			'param'=>$param,
			'phone'=>$mobileList,
        );
        $data = $this->getResult($url, $data);
        return $data;
    }
    
    /**
     * 短信发送记录
     * @param $start_date   开始日期
     * @param $end_date     结束日期
     * @param $phone        查询的手机号
     * @param $page_num     页码，默认值为1，最大不超过查询结果的总页数
     * @param $page_size    每页个数，最大100个，默认50个
     * @param $type         选择短信类型，默认为0，获取验证通知及会员营销短信记录；1，获取验证类短信；2，获取会员营销短信；4，获取通知类短信。
     */
    function send_record(){
        $url = self::BaseUrl . 'send_record';
        $data = array(
            'appid'=>$this->appid,
            'apikey'=>$this->apikey,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'phone'=>$phone,
            'page_num'=>$page_num,
            'page_size'=>$page_size,
            'type'=>$type,
        );
        $data = $this->getResult($url, $data);
        return $data;
    }
    
    /**
     * 账户余额查询
     */
    function account_balance(){
        $url = self::BaseUrl . 'account_balance';
        $data = array(
            'appid'=>$this->appid,
            'apikey'=>$this->apikey,
        );
        $data = $this->getResult($url, $data);
        return $data;
    }
} 