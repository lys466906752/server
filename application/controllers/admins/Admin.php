<?php

	//后台主页

	class Admin extends CI_Controller
	{
			
		public function index()
		{
			$this->load->view("admins/admin");	
		}	
			
	}