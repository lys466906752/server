<?php

	//前台核心文件
	
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Main extends CI_Controller
	{
		
		public $userInfo=false;
		
		public function __construct()
		{
			parent::__construct();
			//监听登录状态
			$this->checkLogin();
		}
	
		//登录回话检测
		private function checkLogin()
		{
			
			if(isset($_COOKIE['PC_Auth_Identity_User_Key']) && isset($_SESSION['PC_Auth_Identity_User']) && $_SESSION['PC_Auth_Identity_User']==$_COOKIE['PC_Auth_Identity_User_Key'])
			{
				$array=json_decode($this->encrypt->decode($_COOKIE['PC_Auth_Identity_User_Key']),true);
				$this->load->model('Users_model','users');
				$res=$this->users->getOneRow($array['id']);
				if($res && $res['pc_token']==$array['pc_token'])
				{
					$hashStr=$_SESSION['PC_Auth_Identity_User'];
					$this->session->set_userdata('PC_Auth_Identity_User',$hashStr);
					$this->input->set_cookie("PC_Auth_Identity_User_Key",$hashStr,36000);
					$this->userInfo=$res;
					return true;	
				}
				
				delete_cookie("PC_Auth_Identity_User_Key"); 
				$this->session->unset_userdata('PC_Auth_Identity_User');
				return false;
			}
			
			delete_cookie("PC_Auth_Identity_User_Key"); 
			$this->session->unset_userdata('PC_Auth_Identity_User');
			return false;

		}
		
		//常规登录check一下
		protected function userState()
		{
			
		}
		
		//ajax登录check一下
		protected function userAjaxState()
		{
			if(!$this->userInfo)
			{
				ajaxs(200,'登录失败');
			}		
		}
		
		//IP限制操作
		protected function ipNoAccess($id,$model='')
		{
			$this->load->model('Ip_model','ip');	
			$this->ip->inserts(['id'=>$id],$msg);
			$ips=$this->ip->getOneRow($id);	
			$userIp=get_ip();
			if($ips!='')
			{
				$ipArray=explode("\n",$ips['noallowedIp']);
				foreach($ipArray as $ipItem)
				{
					if(substr_count($ipItem,'*')<=0)
					{
						if($ipItem==$userIp)
						{
							if($model=='')
							{
								errorShow('No access.');
								
							}
							elseif($model=='ajaxs')
							{
								ajaxs(300,'No access.');	
							}
						}	
					}
					else
					{
						//正则匹配	
						$preg=str_replace('*','(.*)',$ipItem);
						$preg='$'.$preg.'$iUs';
						preg_match($preg,$userIp,$res);
						if(!empty($res))
						{
							if($model=='')
							{
								errorShow('No access.');
							}
							elseif($model=='ajaxs')
							{
								ajaxs(300,'No access.');	
							}
						}
					}
				}
			}
		}
		

		//移动图片
		protected static function copyImg($file)
		{
			if(is_file(FCPATH.$file))
			{
				$picName=substr($file,strrpos($file,'/')+1,1000000);
				$dir='upload';
				if(!is_dir(FCPATH.$dir))
				{
					mkdir(FCPATH.$dir);	
				}
				if(!is_dir(FCPATH.$dir.'/'.date('Ymd')))
				{
					mkdir(FCPATH.$dir.'/'.date('Ymd'));	
				}
				$filer=$dir.'/'.date('Ymd').'/'.$picName;
				if(copy(FCPATH.$file,FCPATH.$filer))
				{
					@unlink(FCPATH.$file);
					return $filer;
				}
				return false;
			}
			return false;	
		}
		
		//删除图片
		protected static function delTmpFile($array)
		{
			if(!empty($array))
			{
				foreach($array as $v)
				{
					if($v['file'] && $v['file']!='' && is_file(FCPATH.$v['file']))
					{
						@unlink(FCPATH.$v['file']);	
					}	
				}
			}	
		}		
		
	}