<?php

	//用户控制器
	
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Users extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();	
		}
		
		//随机选择用户登录
		public function randLogin()
		{
			$query=$this->db->query("select * from `mv_users` order by rand() limit 1");
			if($query->num_rows()>0)
			{
				$res=$query->row_array();
				
				//更新会员登录信息开始	
				$_array=[
					'login_time'=>time(),
					'login_ip'=>get_ip(),
					'last_time'=>$res['login_time'],
					'last_ip'=>$res['login_ip'],
					'login_count'=>$res['login_count']+1,
					'pc_token'=>get_token(),
					'user_agent'=>user_agent()
				];	
				$this->db->update('users',$_array,['id'=>$res['id']]);
				//更新会员登录信息结束
				
				$res=array_merge($res,$_array);//重新整合会员数据库信息
				
				$hashStr=$this->encrypt->encode(json_encode($res));

				$this->session->set_userdata('PC_Auth_Identity_User',$hashStr);
				
				$this->input->set_cookie("PC_Auth_Identity_User_Key",$hashStr,36000);
				
				
			}	
			else
			{
				errorShow('No member info selected.');
			}
		}
		
		//qq登录
		public function qq()
		{
			//$this->randLogin();
			/*echo '<script>alert("随机找了个会员，模拟登录成功了！");history.go(-1);</script>';*/	
            $this->qqGoto();
		}
		
		//qq跳转界面
		public function qqGoto()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$data['res']=$query->row_array();
				$_SESSION['playId']=$id;
				$this->load->view("user_qq.php",$data);	
			}
			else
			{
				header('location:/404.html');exit();
			}
		}
		
		//qq登录回调
		public function backqq()
		{
			require_once(FCPATH."API/qqConnectAPI.php");
			$qc = new QC();
			$tokens=$qc->qq_callback();
			$users["openid"]=$qc->get_openid();
			$qc1 = new QC($tokens,$users["openid"]);
			$msgs = $qc1->get_user_info();
			$query=$this->db->query("select * from `mv_users` where `open_id`='".$users["openid"]."' limit 1");
			if($query->num_rows()>0)
			{
				$res=$query->row_array();
				$_array=[
					'login_time'=>time(),
					'login_ip'=>get_ip(),
					'last_time'=>$res['login_time'],
					'last_ip'=>$res['login_ip'],
					'login_count'=>$res['login_count']+1,
					'pc_token'=>get_token(),
					'user_agent'=>user_agent()
				];	
				$this->db->update('users',$_array,['id'=>$res['id']]);
				//更新会员登录信息结束
				
				$res=array_merge($res,$_array);//重新整合会员数据库信息
				
				$hashStr=$this->encrypt->encode(json_encode($res));

				$this->session->set_userdata('PC_Auth_Identity_User',$hashStr);
				
				$this->input->set_cookie("PC_Auth_Identity_User_Key",$hashStr,36000);
										
				header("location:".http_url()."play/item/".$_SESSION['playId'].".html");exit();
				
			}
			else
			{
				//开始注册数据，并登录
				$passwd=mt_rand(100000,999999);
				$nickname='qq用户';
				if(isset($msgs["nickname"]) && trim($msgs["nickname"])!='')
				{
					$nickname=$msgs["nickname"];		
				}
				$avatar="assets/images/defaultAvatar.jpg";
				if(isset($msgs['figureurl_1']) && trim($msgs['figureurl_1'])!='')
				{
					$avatar=$this->get_avatar($msgs['figureurl_1'],$avatar);
				}
				$avatar=str_replace('/www/wwwroot/bobo/','',$avatar);
				$_array=[
					'nickname'=>$nickname,
					'avatar'=>$avatar,
					'login_time'=>time(),
					'login_ip'=>get_ip(),
					'last_time'=>time(),
					'last_ip'=>get_ip(),
					'login_count'=>1,
					'open_id'=>$users["openid"],
					'mobile_token'=>get_token(),
					'pc_token'=>get_token(),
					'user_agent'=>user_agent(),
					'comment_state'=>1
				];
				$this->db->insert('users',$_array);
				$id=$this->db->insert_id();
				$_array['id']=$id;
				
				$hashStr=$this->encrypt->encode(json_encode($_array));
				$this->session->set_userdata('PC_Auth_Identity_User',$hashStr);
				$this->input->set_cookie("PC_Auth_Identity_User_Key",$hashStr,36000);
				header("location:".http_url()."play/item/".$_SESSION['playId'].".html");exit();
			}
		}
		
		//远程获取对应的图片信息
		public function get_avatar($urls,$pic)
		{
			if($urls=="")
			{
				return $pic;
			}
			ob_start();  
			readfile($urls);
			$return_content=ob_get_contents(); 
			ob_end_clean(); 
			if($return_content && !is_null($return_content))
			{
				$dir=FCPATH.'upload/'.date('Ymd');
				if(!is_dir($dir))
				{
					mkdir($dir);
				}
			
				$pics=$dir."/".date("YmdHis").substr(microtime(),2,8).'.png';
				$file=fopen($pics,'w');
				fwrite($file,$return_content);
				fclose($file);
				//echo $pics;die();
				if(is_file($pics))
				{
					//做数据合法的判断
					$imageInfo=getimagesize($pics);
					if($imageInfo && isset($imageInfo['bits']) && $imageInfo['bits']>0)
					{
						//echo FCPATH;
						//echo $pic;die();
						return str_replace(FCPATH,'',$pics);	
					}
					else
					{
						@unlink($pics);
						return str_replace(FCPATH,'',$pic);	
					}
				}
				else
				{
					return str_replace(FCPATH,'',$pic);	
				}
				
					
			}	
			
			return str_replace(FCPATH,'',$pic);
		}
		
	}