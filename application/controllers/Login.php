<?php

	//登录控制器
	
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Login extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();	
		}
		
		//登录首页
		public function index()
		{
			
			if(isset($_POST) && !empty($_POST))
			{
				//是否post请求提交
				$username=P('username');
				$passwd=P('passwd');
				$csrfLogin=P('csrfLogin');
				//检查csrf信息
				if(!check_csrfToken($this->encrypt,$csrfLogin))
				{
					ajaxs(300,'网页数据读取失败，请刷新重试');
				}
				
				$this->load->model('Admins_model','admins');
				
				$res=$this->admins->logins($username,$passwd);

				if($res)
				{
					ajaxs(100,'登录成功');
				}

				ajaxs(300,'用户名或密码错误！');
			}
			else
			{
				$this->load->view("login/index.php");	
			}
			
		}
		
		//退出登录
		public function out()
		{
			delete_cookie("PC_Auth_Identity_Key"); 
			$this->session->unset_userdata('PC_Auth_Identity');
			header("location:".http_url().'login.html');
			exit();	
		}
	}