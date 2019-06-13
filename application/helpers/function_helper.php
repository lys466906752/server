<?php
	//生成对应的socket数据
	if(! function_exists('create_sockets'))
	{
		function create_sockets($act)
		{
			@session_start();
			if(!is_dir(FCPATH.'assets/sockets'))
			{
				mkdir(FCPATH.'assets/sockets');	
			}
			if(!is_dir(FCPATH.'assets/sockets/visited'))
			{
				mkdir(FCPATH.'assets/sockets/visited');	
			}
			if(!is_dir(FCPATH.'assets/sockets/admins'))
			{
				mkdir(FCPATH.'assets/sockets/admins');	
			}
			if($act==1)
			{
				//游客
				if(!isset($_SESSION['visitSocket']))
				{
					$date=date('Ymd');
					if(!is_dir(FCPATH.'assets/sockets/visited/'.$date))
					{
						mkdir(FCPATH.'assets/sockets/visited/'.$date);	
					}	
					$file=date('YmdHis').substr(microtime(),2,8).mt_rand(1000,9999);
					$filer=fopen(FCPATH.'assets/sockets/visited/'.$date.'/'.$file.'.php','w');
					fwrite($filer,'test');
					fclose($filer);
					clearSocketsTmp();
					$_SESSION['visitSocket']=$date.'_'.$file;
					return $date.'_'.$file;
				}
				else
				{
					$_SESSION['visitSocket']=$_SESSION['visitSocket'];
					return $_SESSION['visitSocket'];	
				}
			}
			else
			{
				//后台管理员
				if(!isset($_SESSION['visitAdminSocket']))
				{
					$date=date('Ymd');
					if(!is_dir(FCPATH.'assets/sockets/admins/'.$date))
					{
						mkdir(FCPATH.'assets/sockets/admins/'.$date);	
					}	
					$file=date('YmdHis').substr(microtime(),2,8).mt_rand(1000,9999);
					$filer=fopen(FCPATH.'assets/sockets/admins/'.$date.'/'.$file.'.php','w');
					fwrite($filer,'test');
					fclose($filer);
					clearSocketsTmp();
					$_SESSION['visitAdminSocket']=$date.'_'.$file;
					return $date.'_'.$file;
				}	
				else
				{
					$_SESSION['visitAdminSocket']=$_SESSION['visitAdminSocket'];
					return $_SESSION['visitAdminSocket'];	
				}
			}
		}	
	}
	
	//清空对应的socket临时垃圾文件
	if(! function_exists('clearSocketsTmp'))
	{
		function clearSocketsTmp()
		{
			for($i=3;$i<=365;$i++)
			{
				$date=date('Ymd',time()-$i*3600*24);
				clearFileCache(FCPATH.'assets/sockets/visited/'.$date);	
				clearFileCache(FCPATH.'assets/sockets/admins/'.$date);	
			}	
		}	
	}
	
	//清理缓存
	if(! function_exists('clearFileCache'))
	{
		function clearFileCache($cachePath)
		{
			if(is_dir($cachePath))
			{
				return dirFileDels($cachePath);	
			}
			return true;
		}
	}

	//删除文件夹及以下的文件
	if(! function_exists('dirFileDels'))
	{
		function dirFileDels($dir)
		{
			$dh=opendir($dir);
			while ($file=readdir($dh)) 
			{
				if($file!="." && $file!="..") 
				{
					
					$fullpath=$dir."/".$file;
					
					if(!is_dir($fullpath))
					{
						unlink($fullpath);
					} 
					else
					{
						dirFileDels($fullpath);
					}
					
				}
			}
			closedir($dh);
			//删除当前文件夹：
			if(rmdir($dir))
			{
				return true;
			}
			else
			{
				return false;
			}				
		}	
	}

	//获取IP地址信息
	if (! function_exists('get_ip'))
	{
		function get_ip()
		{
			
			if (getenv('HTTP_CLIENT_IP')) {
				$ip = getenv('HTTP_CLIENT_IP');
			}
			elseif (getenv('HTTP_X_FORWARDED_FOR')) {
				$ip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_X_FORWARDED')) {
				$ip = getenv('HTTP_X_FORWARDED');
			}
			elseif (getenv('HTTP_FORWARDED_FOR')) {
				$ip = getenv('HTTP_FORWARDED_FOR');
			
			}
			elseif (getenv('HTTP_FORWARDED')) {
				$ip = getenv('HTTP_FORWARDED');
			}
			else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			
			return $ip;	
		}
	}
	
	//获取表情
	if( ! function_exists('get_ubb'))
	{
		/*function get_ubb($str) {
			$str = preg_replace("/(\[)em(.*?)(\])/i", "<img src=\"/assets/images/face/em\\2.png\" />", $str);
			return $str;
		}*/
		function get_ubb($str) {
			for($i=1;$i<=75;$i++)
			{
				$replace='[em_'.$i.']';
				$replaceImg='<img src="/assets/images/face/em_'.$i.'.png">';	
				$str = str_replace($replace,$replaceImg,$str);
			}	
			return $str;
		}
	}
	
	//获取发布者的浏览器信息
	if(! function_exists('user_agent'))
	{
		function user_agent()
		{
			return isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"]!="" ?$_SERVER["HTTP_USER_AGENT"]:"未知";
		}
	}	
	
	//获取Token信息
	if(! function_exists('get_token'))
	{
		function get_token()
		{
			return sha1(microtime().mt_rand(1000,9999)).sha1(uniqid());	
		}	
	}
	
	//Post或者Get数据操作
	if(! function_exists('P'))
	{
		function P($key)
		{
			return isset($_POST[$key])?htmlspecialchars(trim($_POST[$key])):"";
		}	
		
	}
	
	//获取配置文件的信息
	if(! function_exists('select_config'))
	{
		function select_config($url)
		{
			if(is_file(FCPATH.'assets/config/'.$url.'.config.php'))
			{
				return require FCPATH.'assets/config/'.$url.'.config.php';
			}
			return false;
		}
	}
	
	//ajax数据提交返回
	if (!function_exists('ajaxs'))
	{
		function ajaxs($code,$msg)
		{
			$msg = str_replace("|","",$msg);
			$code = str_replace("|","",$code);
			echo $code."|".$msg;exit();
		}
	}
	

	//frame输出
	if(!function_exists('iframeshow'))
	{
		function iframeshow($number,$desc,$funcs=null)
		{
			if($funcs=="")
			{
				$funcs="stopUpload";
			}
			echo '<script language="javascript" type="text/javascript">window.parent.window.'.$funcs.'("'.$number.'|'.$desc.'");</script>';exit();
		}
	}
	
	//Post或者Get数据操作
	if(! function_exists('P'))
	{
		function P($key)
		{
			return isset($_POST[$key])?htmlspecialchars(trim($_POST[$key])):"";
		}	
	}
	
	//成功提示跳转
	if(! function_exists('success'))
	{
		function success($text,$url=null,$time=null)
		{
			require FCPATH."assets/views/success.php";
		}
	}
	
	//错误提示跳转
	if(! function_exists('error'))
	{
		function error($text,$url=null,$time=null)
		{
			require FCPATH."assets/views/error.php";
		}
	}	
	
	//错误404页面
	if(! function_exists('errorShow'))
	{
		function errorShow($show,$code=500)
		{
			header('HTTP/1.1 '.$code.' Service Unavailable.', TRUE, $code);
			require FCPATH."assets/views/errorShow.php";
			exit();	
		}	
	}
	
	
	function cutIt($filePath)
	{
			
		$extName=strtolower(substr($filePath,strrpos($filePath,'.')+1,1000));	
			
		if(strtolower($extName)=="jpg" || strtolower($extName)=="jpeg")
		{
			$im=imagecreatefromjpeg(FCPATH.$filePath);//参数是图片的存方路径
		}
		elseif(strtolower($extName)=="png")
		{
			$im=imagecreatefrompng(FCPATH.$filePath);//参数是图片的存方路径
		}
		elseif(strtolower($extName)=="gif")
		{
			$im=imagecreatefromgif(FCPATH.$filePath);//参数是图片的存方路径
		}						

		$picWidth = imagesx($im);
		$picHeight = imagesy($im);
		if($picWidth>MaxW || $picHeight>MaxH)
		{
			if(strtolower($extName)!="gif")
			{
				img_tailoring($filePath,$extName);
			}
		}	
		
	}

	function img_tailoring($file,$ext_name)
	{
		
		$_Path=FCPATH.$file;
		
		$filetype=".".$ext_name;
		
		if(strtolower($ext_name)=="jpg" || strtolower($ext_name)=="jpeg")
		{
			$im=imagecreatefromjpeg($_Path);//参数是图片的存方路径
		}
		elseif(strtolower($ext_name)=="png")
		{
			$im=imagecreatefrompng($_Path);//参数是图片的存方路径
		}
		
		img_resizeimage($im,$file,$filetype);//调用上面的函数	
		
	}

	function img_resizeimage($im,$file,$filetype)
	{
		$maxwidth=MaxW;
		$maxheight=MaxH;
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
		$resizewidth_tag=false;
		
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