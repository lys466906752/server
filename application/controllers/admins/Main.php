<?php

	//后台核心类文件
	
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Main extends CI_Controller
	{
		
		public $adminInfo=false;
		
		public function __construct()
		{
			parent::__construct();
			//监听登录状态
			$this->checkLogin();
		}
	
		//登录回话检测
		private function checkLogin()
		{
			
			if(isset($_COOKIE['PC_Auth_Identity_Key']) && isset($_SESSION['PC_Auth_Identity']) && $_SESSION['PC_Auth_Identity']==$_COOKIE['PC_Auth_Identity_Key'])
			{
				$array=json_decode($this->encrypt->decode($_COOKIE['PC_Auth_Identity_Key']),true);
				$this->load->model('Admins_model','admins');
				$res=$this->admins->getOneRow($array['id']);
				if($res && $res['username']==$array['username'] && $res['token']==$array['token'])
				{
					
					$hashStr=$_SESSION['PC_Auth_Identity'];
					$this->session->set_userdata('PC_Auth_Identity',$hashStr);
					$this->input->set_cookie("PC_Auth_Identity_Key",$hashStr,36000);
					$this->adminInfo=$res;
					return true;	
				}
				
				delete_cookie("PC_Auth_Identity_Key"); 
				$this->session->unset_userdata('PC_Auth_Identity');
				return false;
			}
			
			delete_cookie("PC_Auth_Identity_Key"); 
			$this->session->unset_userdata('PC_Auth_Identity');
			return false;

		}
		
		//常规登录check一下
		protected function userState()
		{
			if(!$this->adminInfo)
			{
				header("location:".http_url().'login.html');exit();	
			}	
		}
		
		//ajax登录check一下
		protected function userAjaxState()
		{
			if(!$this->adminInfo)
			{
				ajaxs(200,'登录失败');
			}		
		}
		
	}