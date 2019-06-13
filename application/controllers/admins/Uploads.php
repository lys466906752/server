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
			if(!$this->adminInfo)
			{
				iframeshow(200,'登录失败',$backFunction);	
			}
			isset($_GET['field']) && trim($_GET['field'])!=''?$field=trim($_GET['field']):$field='file';
			$this->load->library("imgsclass");
			$file=$this->imgsclass->upload($_FILES[$field],$msg,'',['maxSize'=>'2048']);	
			if($file)
			{
				iframeshow(100,$file,$backFunction);
			}
			else
			{
				iframeshow(300,$msg,$backFunction);	
			}	
		}
		
		//上传广告图片
		public function ad()
		{
			isset($_GET['backFunction']) && trim($_GET['backFunction'])!=''?$backFunction=trim($_GET['backFunction']):$backFunction='';
			if(!$this->adminInfo)
			{
				iframeshow(200,'登录失败',$backFunction);	
			}
			isset($_GET['field']) && trim($_GET['field'])!=''?$field=trim($_GET['field']):$field='file';
			isset($_GET['id']) && trim($_GET['id'])!=''?$id=trim($_GET['id']):$id=1;
			isset($_POST['hashId']) && trim($_POST['hashId'])!=''?$hashId=trim($_POST['hashId']):$hashId=date('YmdHis').substr(microtime(),2,8);

			$this->load->library("imgsclass");
			$file=$this->imgsclass->upload($_FILES[$field],$msg,'',['maxSize'=>'2048']);	
			if($file)
			{
				iframeshow(100,$file.'|'.$id.'|'.$hashId,$backFunction);
			}
			else
			{
				iframeshow(300,$msg,$backFunction);	
			}	
		}
		
	}