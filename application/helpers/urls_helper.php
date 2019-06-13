<?php

	//URL小助手文件
	
	//定义后台的URL的路径
	if(! function_exists('admin_url'))
	{
		function admin_url()
		{
			return http_url().'admins/';	
		}	
	}
	
	//定义前台的URL地址
	if(! function_exists('http_url'))
	{
		function http_url()
		{
			return base_url();	
		}
	}
		