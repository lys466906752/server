<?php
	
	//Text:针对系统图片上传处理等类;
	//Auth:Recson;
	//Date:2017-3-6;
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	ini_set('memory_limit', '1024M');
	
	class Imgsclass
	{
		
		public $img_configs; //图片配置变量
		
		public $img_forSystem;  //图片对应的默认配置信息
		
		public function __construct()
		{
			$this->img_configs=array(
			
				'uploadType'=>'image',
				'uploadExtName'=>array('png','jpg'),
				'cutState'=>false,
				'cutMaxWidth'=>1000,
				'cutMaxHeight'=>1000,
				'maxSize'=>false,	
				'tmp'=>false
			);
		}
		
		//上传处理函数
		public function upload($file,&$msg,$ordName='',$conf='')
		{
			if(is_array($conf) && !empty($conf))
			{
				$this->img_configs=array_merge($this->img_configs,$conf);	
			}
			
			$dir='upload';
			if($this->img_configs['tmp'])
			{
				$dir='uploadtmp';	
			}
			
			$imgName=$file['name'];
			$imgType=$file['type'];
			$imgTmpName=$file['tmp_name'];
			$imgError=$file['error'];
			$imgSize=$file['size'];
			
			
			if($imgName=='')
			{
				$msg="请选择上传文件";
				return false;	
			}
			elseif($imgError>0)
			{
				$msg="系统错误";
				return false;	
			}
			elseif(substr_count($imgType,$this->img_configs['uploadType'])<=0)
			{
				$msg="不支持上传文件类型";
				return false;	
			}
			elseif($this->img_configs['maxSize'] && $this->img_configs['maxSize']*1000<$imgSize)
			{
				$msg="上传文件超出".$this->img_configs['maxSize']."Kb";
				return false;	
			}
			else
			{
				$extName=strtolower(substr($imgName,strrpos($imgName,'.')+1,1000));
				$extName==""?$extName='png':$extName;
				
				if(!in_array($extName,$this->img_configs['uploadExtName']))
				{
					$msg="不支持上传文件类型";
					return false;
				}
				if(!is_uploaded_file($imgTmpName))
				{
					$msg="系统错误，请联系管理员解决";
					return false;	
				}
				
				if(!is_dir(FCPATH.$dir))
				{
					mkdir(FCPATH.$dir);	
				}
				if(!is_dir(FCPATH.$dir.'/'.date('Ymd')))
				{
					mkdir(FCPATH.$dir.'/'.date('Ymd'));	
				}
				
				$file=$dir.'/'.date('Ymd').'/'.date('YmdHis').substr(microtime(),2,8).'.'.$extName;
				
				if($ordName!='')
				{
					$file=$ordName;	
				}
				
				if(move_uploaded_file($imgTmpName,FCPATH.$file))
				{
					$msg="success";
					
					if($this->img_configs['cutState'])
					{
						//需要裁剪切割

						if($extName=="jpg" || $extName=="jpeg")
						{
							$im=imagecreatefromjpeg(FCPATH.$file);//参数是图片的存方路径
						}
						elseif($extName=="png")
						{
							$im=imagecreatefrompng(FCPATH.$file);//参数是图片的存方路径
						}
						elseif($extName=="gif")
						{
							$im=imagecreatefromgif(FCPATH.$file);//参数是图片的存方路径
						}						

						$picWidth = imagesx($im);
						$picHeight = imagesy($im);
						
						if($picWidth>$this->img_configs['cutMaxWidth'] || $picHeight>$this->img_configs['cutMaxHeight'])
						{
							$this->img_tailoring($file,$extName);
							
							return $file;
						}	
					}
					
					return $file;
				}
				
				$msg="系统错误，请联系管理员解决";
				return false;
			}
			
		}
		
		public function img_tailoring($file,$ext_name)
		{
			
			$_Path=FCPATH.$file;
			
			$filetype=".".$ext_name;
			
			if($ext_name=="jpg" || $ext_name=="jpeg")
			{
				$im=imagecreatefromjpeg($_Path);//参数是图片的存方路径
			}
			elseif($ext_name=="png")
			{
				$im=imagecreatefrompng($_Path);//参数是图片的存方路径
			}
			elseif($ext_name=="gif")
			{
				$im=imagecreatefromgif($_Path);//参数是图片的存方路径
			}
			
			return $this->img_resizeimage($im,$file,$filetype);//调用上面的函数	
			
		}
		
		public function img_resizeimage($im,$file,$filetype)
		{
			$maxwidth=$this->img_configs['cutMaxWidth'];
			$maxheight=$this->img_configs['cutMaxHeight'];
			$pic_width = imagesx($im);
			$pic_height = imagesy($im);
			$resizeheight_tag=false;
			if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
			{
				if($maxwidth && $pic_width>$maxwidth)
				{
					$widthratio = $maxwidth/$pic_width;
					$resizewidth_tag = true;
				}
		
				if($maxheight && $pic_height>$maxheight)
				{
					$heightratio = $maxheight/$pic_height;
					$resizeheight_tag = true;
				}
		
				if($resizewidth_tag && $resizeheight_tag)
				{
					if($widthratio<$heightratio)
						$ratio = $widthratio;
					else
						$ratio = $heightratio;
				}
		
				if($resizewidth_tag && !$resizeheight_tag)
					$ratio = $widthratio;
				if($resizeheight_tag && !$resizewidth_tag)
					$ratio = $heightratio;
				
				$newwidth = $pic_width * $ratio;
				$newheight = $pic_height * $ratio;
		
				if(function_exists("imagecopyresampled"))
				{
					
					$newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
					
					imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
				}
				else
				{
					
					$newim = imagecreate($newwidth,$newheight);
					
					imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
					
				}
				
				imagejpeg($newim,FCPATH.$file);
				imagedestroy($newim);
				
				return $file;
			}
			else
			{
				return $file;
			}				
		}
		
	
	}