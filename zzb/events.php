<?php
/**
 * 聊天主逻辑
 * 主要是处理 onMessage onClose
 */
require_once '/GatewayClient-3.0.10/Gateway.php';

/**
 * gatewayClient 3.0.0及以上版本加了命名空间
 * 而3.0.0以下版本不需要use GatewayClient\Gateway;
 **/
use GatewayClient\Gateway;

/**
 *====这个步骤是必须的====
 *这里填写Register服务的ip（通常是运行GatewayWorker的服务器ip，非0.0.0.0）和Register端口
 *注意Register服务端口在start_register.php中可以找到
 *这里假设GatewayClient和Register服务都在一台服务器上，ip填写127.0.0.1
 *注意：ip不能是0.0.0.0
 **/
Gateway::$registerAddress = '127.0.0.1:1236';
class Events{
	public static function onMessage($client_id, $message)
	{
		 // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
        
	}
}