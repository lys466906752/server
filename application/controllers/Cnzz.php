<?php
	
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Cnzz extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();	
		}
		
		//流量简单访问统计
		public function index()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$result=$query->row_array();
				//开始记录pv数量
				$ip=get_ip();
				$ipQuery=$this->db->query("select * from `mv_visited_".$id."` where `ip`='$ip' limit 1");
				if($ipQuery->num_rows()>0)
				{
					$ipRes=$ipQuery->row_array();
					if($ipRes['date']!=date('Y-m-d'))
					{
						//不是今天	
						$_array=[
							'time'=>time(),
							'date'=>date('Y-m-d')
						];
						$this->db->update('visited_'.$id,$_array,['id'=>$ipRes['id']]);//更新一下日期
						$this->db->query("update `mv_results` set `ip`=`ip`+1 where `id`='$id'");		
					}
				}
				else
				{
					//不存在
					
					$_array=[
						'ip'=>$ip,
						'time'=>time(),
						'date'=>date('Y-m-d'),
						'pvdate'=>date('Y-m-d',time()-3600*24)
					];
					
					$this->db->insert('visited_'.$id,$_array);	
					$this->db->query("update `mv_results` set `ip`=`ip`+1 where `id`='$id'");				
				}
	
			}
		}
		
		//流量简单观看时效统计
		public function play()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$result=$query->row_array();
				if($result['state']==2)
				{
					//正在直播的时候，算观看有效时间
					isset($_GET['addTime']) && is_numeric($_GET['addTime']) && $_GET['addTime']>=3 && $_GET['addTime']<=8?$addTime=intval($_GET['addTime']):exit();//接收累加的时间
					$this->db->query("update `mv_results` set `lookTime`=`lookTime`+'$addTime' where `id`='$id'");//记录到库中
				}
			}
		}
		
		//流量简单观看地区pv统计
		public function address()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				
				$result=$query->row_array();
				if($result['state']==2)
				{
					//对地区做统计
					$ip=get_ip();
					//$ip='59.68.0.0';
					$addressJson=self::getInfo($ip);
					$addressArray=json_decode($addressJson,true);
					if(isset($addressArray['code']) && $addressArray['code']==0 && isset($addressArray['data']['region']) && $addressArray['data']['region']!='' && isset($addressArray['data']['city']) && $addressArray['data']['city']!='')
					{
						$pro=$addressArray['data']['region'];
						$query=$this->db->query("select * from `mv_region_".$id."` where `name` like '%$pro%' limit 1");
						$regionId=35;
						if($query->num_rows()>0)
						{
							$res=$query->row_array();
							$regionId=$res['id'];	
						}
						$this->db->query("update `mv_region_".$id."` set `counts`=`counts`+1 where `id`='$regionId'");
					}
					//对pv和uv做统计
					$ipQuery=$this->db->query("select * from `mv_visited_".$id."` where `ip`='$ip' limit 1");
					if($ipQuery->num_rows()>0)
					{
						$ipRes=$ipQuery->row_array();
						if($ipRes['pvdate']!=date('Y-m-d'))
						{
							//不是今天	
							$_array=[
								'time'=>time(),
								'pvdate'=>date('Y-m-d')
							];
							$this->db->update('visited_'.$id,$_array,['id'=>$ipRes['id']]);//更新一下日期
							$this->db->query("update `mv_results` set `uv`=`uv`+1 where `id`='$id'");	///www/wwwroot/bobo/		
						}
					}
					else
					{
						//没有数据，直接累加
						$_array=[
							'ip'=>$ip,
							'time'=>time(),
							'date'=>date('Y-m-d',time()-3600*24),
							'pvdate'=>date('Y-m-d')
						];
						
						$this->db->insert('visited_'.$id,$_array);	
						$this->db->query("update `mv_results` set `uv`=`uv`+1 where `id`='$id'");	
					}
					$this->db->query("update `mv_results` set `pv`=`pv`+1 where `id`='$id'");
				}
				
				
			}	
		}
		
		//curl获取IP信息
		private static function getInfo($ip)
		{
			//get curl获取
			$curl = curl_init();
			//设置抓取的url
			curl_setopt($curl, CURLOPT_URL, 'http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
			//设置头文件的信息作为数据流输出
			curl_setopt($curl, CURLOPT_HEADER,0);
			//设置获取的信息以文件流的形式返回，而不是直接输出。
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,8);
			curl_setopt($curl, CURLOPT_TIMEOUT,8);
			//执行命令
			$data = curl_exec($curl);
			//关闭URL请求
			curl_close($curl);
			//显示获得的数据
			return ($data);				
		}
			
	}