<?php

	//上传控制器

	require 'Main.php';

	class Muploads extends Main
	{
			
		public function __construct()
		{
			parent::__construct();	
		}	
	
		//上传图片
		public function index()
		{
			isset($_GET['backFunction']) && trim($_GET['backFunction'])!=''?$backFunction=trim($_GET['backFunction']):$backFunction='';
			isset($_GET['field']) && trim($_GET['field'])!=''?$field=trim($_GET['field']):$field='file';
			$this->load->library("imgsclass");
			$file=$this->imgsclass->upload($_FILES[$field],$msg,'',['maxSize'=>'8000','cutState'=>true,'cutMaxWidth'=>1200,'cutMaxHeight'=>1200,'tmp'=>true]);	
			if($file)
			{
				iframeshow(100,$file,$backFunction);
			}
			else
			{
				iframeshow(300,$msg,$backFunction);	
			}	
		}
		
		//图片流上传
		public function phone()
		{
			if(!is_dir(FCPATH.'uploadtmp'))
			{
				mkdir(FCPATH.'uploadtmp');	
			}
			if(!is_dir(FCPATH.'uploadtmp/'.date('Ymd')))
			{
				mkdir(FCPATH.'uploadtmp/'.date('Ymd'));	
			}	
			
			$input = file_get_contents('php://input'); 
			$file='uploadtmp/'.date('Ymd').'/'.date('YmdHis').substr(microtime(),2,8).'.jpg';
			$fl=fopen(FCPATH.$file,'w');
			fwrite($fl,$input);
			fclose($fl);	
			echo $file;exit();	
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