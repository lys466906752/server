<?php 
	
	//微信分享控制器
	error_reporting(0);
	
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Weixin extends CI_Controller {
	
		public static $APPID='wx4b0b3efd92f1aaea';
		public static $APPSECRET='cede2c87b424a35d918c9fbfb4f5034d';
		
		public function gets()
		{
			// 获取token
			$token = $this->getAccessToken();
			// 获取ticket
			$ticketList = $this->getJsApiTicket($token['accessToken']);
			$ticket = $ticketList['ticket'];
			// 该URL为使用JSSDK接口的URL
			$id=intval($this->uri->segment(3));
			$url = http_url().'m/index/'.$id.'.html';
		
			// 时间戳
			$timestamp = time();
			// 随机字符串
			$nonceStr = $this->createNoncestr();
			// 这里参数的顺序要按照 key 值 ASCII 码升序排序 j -> n -> t -> u
			$string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
			$signature = sha1($string);
			$signPackage = [
				"appId" => self::$APPID,
				"nonceStr" => $nonceStr,
				"timestamp" => $timestamp,
				"url" => $url,
				"signature" => $signature,
				"rawString" => $string,
				"ticket" => $ticket,
				"token" => $token['accessToken']
			];
			
			//print_r($_SESSION);
			
			// 提供数据给前端
			echo json_encode($signPackage);exit();
		}
		
		//远程获取数据
		private static function httpGet($url) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($curl, CURLOPT_TIMEOUT, 500 );
			curl_setopt($curl, CURLOPT_URL, $url );
			$res = curl_exec($curl);
			curl_close($curl);
			return $res;
		}
		
		//获取getAccessToken;
		protected function getAccessToken()
		{
			if(isset($_SESSION['weixinRes']))
			{
				$weixinRes=json_decode($_SESSION['weixinRes'],true);
				$token=$weixinRes;
			}
			
			if(isset($token))
			{
				//格式化数据库的timestamp
				$time = strtotime($token['time']);
			}
			
			//accessToken过期或不存在时
			if(!isset($time) || ($time + $token['expiresIn'] < time() || $token['accessToken'] == NULL)){
				$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::$APPID."&secret=".self::$APPSECRET;
				// 微信返回的信息
				$returnData = json_decode(self::httpGet($url));
				// 组装数据
				$resData['accessToken'] = $returnData->access_token;
				$resData['expiresIn'] = $returnData->expires_in;
				$resData['time'] = date("Y-m-d H:i",time());
				// 把数据存进数据库
				$res = $resData;
				//setcookie('weixinRes',json_encode($resData),time()+3600*24*7,'/');//生成一个记录值，防止二次刷新重取
				$_SESSION['weixinRes']=json_encode($resData);
			}else{
				$res = $token;
			}
			return $res;
		}
		
		public function getJsApiTicket($accessToken) {
			// jsapi_ticket 应该全局存储与更新
			// 获取数据库中的jsapi_ticket
			$expiresIn=0;
			if(isset($_SESSION['weixinTicket']))
			{
				$weixinTicket=json_decode($_SESSION['weixinTicket'],true);
				$ticket=$weixinTicket;
				$weixinRes=json_decode($_SESSION['weixinRes'],true);
				$token=$weixinRes;
				$expiresIn=$token['expiresIn'];
			}
			if(isset($ticket))
			{
				$time=strtotime($ticket['time']);
			}
			// 如果ticket失效
			if(!isset($time) || ($time + $expiresIn < time() || $ticket['ticket'] == NULL)){
				$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&&type=jsapi";
				// 微信返回的信息
				$returnData = json_decode(self::httpGet($url));
				// 组装数据
				$resData['ticket'] = $returnData->ticket;
				$resData['expiresIn'] = $returnData ->expires_in;
				$resData['time'] = date("Y-m-d H:i",time());
				$resData['errcode'] = $returnData->errcode;
				// 把数据存进数据库
				$res = $resData;
				$_SESSION['weixinTicket']=json_encode($resData);
				//setcookie('weixinTicket',json_encode($resData),time()+3600*24*7,'/');//生成一个记录值，防止二次刷新重取
			}else{
				$res = $ticket;
			}
			return $res;
		}
		
		private static function createNoncestr($length = 16) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$str = "";
			for($i = 0; $i < $length; $i ++) {
				$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
			}
			return $str;
		}


	}

