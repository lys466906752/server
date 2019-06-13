<?php

	//上传控制器

	require 'Main.php';

	class Uploads extends Main
	{
			
		public function __construct()
		{
			parent::__construct();	
		}	
	
		//上传图片
		public function index()
		{
			isset($_GET['backFunction']) && trim($_GET['backFunction'])!=''?$backFunction=trim($_GET['backFunction']):$backFunction='';
			if(!$this->userInfo)
			{
				iframeshow(200,'登录失败',$backFunction);	
			}
			isset($_GET['field']) && trim($_GET['field'])!=''?$field=trim($_GET['field']):$field='file';
			$this->load->library("imgsclass");
			$file=$this->imgsclass->upload($_FILES[$field],$msg,'',['maxSize'=>'5000','cutState'=>true,'cutMaxWidth'=>1000,'cutMaxHeight'=>1000,'tmp'=>true]);	
			if($file)
			{
				iframeshow(100,$file,$backFunction);
			}
			else
			{
				iframeshow(300,$msg,$backFunction);	
			}	
		}
		
		//删除图片
		public function del()
		{
			isset($_GET['file']) && trim($_GET['file'])!='' && substr_count(trim($_GET['file']),'uploadtmp')==1?$file=trim($_GET['file']):ajaxs(300,'删除失败');
			if(is_file(FCPATH.$file))
			{
				@unlink(FCPATH.$file);	
			}	
		}
		
	}