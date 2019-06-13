<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title>军颐中医院技术直播管理系统</title>
<script src="https://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
<script src="/assets/layer_pc/layer.js"></script>
<script src="/assets/admin/js/jquery.zclip.min.js"></script>
<script src="/assets/admin/js/colpick.js"></script>
<link href="/assets/admin/css/main.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/css/colpick.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.nav a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px;float:left;}
.nav a:hover{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:}
.nav .actived a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:float:left;font-weight:bold; text-decoration:underline;}
.projecteds{width:100%; float:left; height:auto;}
.projecteds ul{padding:0; margin:0;}
.projecteds ul li{float:left; width:330px; height:auto; padding-bottom:15px; padding-top:10px;}

@font-face {
  font-family: 'iconfont';
  src: url('/assets/iconfont/iconfont.eot'); /* IE9*/
  src: url('/assets/iconfont/iconfont.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
  url('/assets/iconfont/iconfont.woff') format('woff'), /* chrome、firefox */
  url('/assets/iconfont/iconfont.ttf') format('truetype'), /* chrome、firefox、opera、Safari, Android, iOS 4.2+*/
  url('/assets/iconfont/iconfont.svg#iconfont') format('svg'); /* iOS 4.1- */
}
.iconfont{
    font-family:"iconfont" !important;
    font-size:16px;font-style:normal;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: 0.2px;
    -moz-osx-font-smoothing: grayscale;}
</style>
<script>
	var form_loads=1;
</script>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
	require VIEWPATH.'admins/include.php';
?>
  <tr>
    <td height="40" colspan="2" align="left" valign="middle" style="padding-top:15px;"><strong style="font-size:18px;"><?php echo $res['name'];?></strong> &nbsp;&nbsp;&nbsp; 观看地址：<a href="<?php echo http_url().'play/item/'.$res['id'];?>" target="_blank"><?php echo http_url().'play/item/'.$res['id'];?></a></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" valign="middle"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px solid;">
      
    </div></td>
  </tr>
  <tr>
    <td  colspan="2" align="left" valign="middle"style="padding-top:5px; padding-bottom:5px;">
    
    <div style="width:100%; margin:0 auto; height:auto; background:#f4f4f4; border-radius:18px;">
    	
        <?php
        	require 'tree.php';
		?>
        <iframe id="tarGet" name="tarGet" src="#" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>
        
        <div style="width:797px; float:right;min-height:350px;">
       	  <div style="width:775px; float:right; border-top-left-radius:5px; border-top-right-radius:5px; border:#e4e4e4 1px solid; height:45px; line-height:45px;color:#666; padding-left:15px; background:#f4f4f4;font-size:16px; border-bottom:none;">
           	自定义广告栏
        </div>
            <div style="width:792px; float:right; height:auto; border-bottom-left-radius:5px; border-bottom-right-radius:5px; background:#e1e1e1; padding-top:15px; padding-bottom:15px;">
            	<table width="100%" height="22" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="35" colspan="2" align="left" valign="top" style="padding-left:15px;color:#999;">1.删除广告栏会删除对应数据模块的数据记录；2.修改广告栏的图片或者链接，数据会在原有数据内容上进行叠加</td>
                  </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" valign="top" style="padding-left:15px; padding-right:15px;"><div style="width:100%; float:left; height:1px; border-bottom:#f4f4f4 1px solid;"></div></td>
                  </tr>

                  <tr>
                    <td height="35" colspan="2" align="left" valign="top" style="padding-left:15px;padding-right:15px;"><strong>顶部广告栏</strong><span style="font-size:12px;color:#999;">（最多可添加5个；完整图片尺寸：1500*480px；您可上传自定尺寸的图片，内容将居中；图片大小：2M以内；图片格式：PNG、JPG、JPEG、GIF）</span> <span style="float:right;"><a href="javascript:addTopAd();" style="width:auto; padding-left:18px; padding-right:18px; height:30px; line-height:30px; border-radius:5px; background:#090;color:#FFF; display:inline-block;">添加广告</a></span></td>
                  </tr>
                  <tr>
                    <td height="50" colspan="2" align="center" valign="top" style="padding-bottom:15px;">
                    <div id="topAder" style="width:100%; float:left; height:auto;">
                    <?php
						$while=true;
                    	if($res['ads']=='')
						{
							$while=false;
						}
						if($while)
						{
							$ads=json_decode($res['ads'],true);
							if(isset($ads['topAd']) && $ads['topAd']!='' && count($ads['topAd'])>0)
							{
								for($i=0;$i<count($ads['topAd']);$i++)
								{
					?>
                    	<label class="while" id="tb<?php echo $ads['topAd'][$i]['hashId'];?>"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;"><tr><td width="213" height="48" style="padding-left:10px;" id="upTopPicInner_<?php echo $ads['topAd'][$i]['hashId'];?>"><img src="/<?php echo $ads['topAd'][$i]['file'];?>"  style="width:200px; height:60px;cursor:pointer;"  onclick="upC('<?php echo $ads['topAd'][$i]['hashId'];?>');" /></td><td width="430" height="48" style="padding-right:10px;padding-left:10px;"><input type="text" class="topUrl" style="width:400px; height:32px; line-height:32px; border:#CCC 1px solid; border-radius:5px; padding-left:10px;" placeholder="请填写广告位连接地址" value="<?php echo $ads['topAd'][$i]['url'];?>" /></td><td width="101" align="left" valign="middle">PV：<?php echo $ads['topAd'][$i]['pv'];?></td><td width="48" height="48" align="left" valign="middle"><a href="javascript:removeTopFile('<?php echo $ads['topAd'][$i]['hashId'];?>');">删除</a></td></tr></table><form id="topFormSub<?php echo $ads['topAd'][$i]['hashId'];?>" name="topFormSub<?php echo $ads['topAd'][$i]['hashId'];?>" action="<?php echo admin_url();?>uploads/ad?field=topFile_<?php echo $ads['topAd'][$i]['hashId'];?>&backFunction=stopUploads&id=<?php echo $ads['topAd'][$i]['hashId'];?>" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet" style="display:none;"><span id="topFileInner_<?php echo $ads['topAd'][$i]['hashId'];?>"><input type="file" name="topFile_<?php echo $ads['topAd'][$i]['hashId'];?>" id="topFile_<?php echo $ads['topAd'][$i]['hashId'];?>" placeholder="请选择一张图片" onchange="topFormSub('<?php echo $ads['topAd'][$i]['hashId'];?>');" /></span><input type="hidden" class="topPic" id="topPic_<?php echo $ads['topAd'][$i]['hashId'];?>" value="<?php echo $ads['topAd'][$i]['file'];?>" /><input type="hidden" class="hashId" id="hashId_<?php echo $ads['topAd'][$i]['hashId'];?>" name="hashId" value="<?php echo $ads['topAd'][$i]['hashId'];?>" /><input type="hidden" class="pvId" name="pvId" value="<?php echo $ads['topAd'][$i]['pv'];?>" /></form></label>
                    <?php
								}
							}
						}
					?>
                    </div>

                    </td>
                  </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" valign="top" style="padding-left:15px; padding-right:15px;"><div style="width:100%; float:left; height:1px; border-bottom:#f4f4f4 1px solid;"></div></td>
                  </tr>
                  <tr>
                    <td height="35" colspan="2" align="left" valign="top" style="padding-left:15px;padding-right:15px;"><strong>中部广告栏</strong><span style="font-size:12px;color:#999;">（最多可添加10个；图片尺寸：1500*187.5px；图片大小：2M以内；图片格式：PNG、JPG、JPEG、GIF）</span> <span style="float:right;"><a href="javascript:addMiddleAd();" style="width:auto; padding-left:18px; padding-right:18px; height:30px; line-height:30px; border-radius:5px; background:#090;color:#FFF; display:inline-block;">添加广告</a></span></td>
                  </tr>
                  <tr>
                    <td height="50" colspan="2" align="center" valign="top" style="padding-bottom:15px;">
                    <div id="middleAder" style="width:100%; float:left; height:auto;">
                    <?php
						$while=true;
                    	if($res['ads']=='')
						{
							$while=false;
						}
						if($while)
						{
							$ads=json_decode($res['ads'],true);
							if(isset($ads['middleAd']) && $ads['middleAd']!='' && count($ads['middleAd'])>0)
							{
								for($i=0;$i<count($ads['middleAd']);$i++)
								{
					?>
                  <label class="while" id="tb<?php echo $ads['middleAd'][$i]['hashId'];?>"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;"><tr><td width="213" height="48" style="padding-left:10px;" id="upTopPicInner_<?php echo $ads['middleAd'][$i]['hashId'];?>"><img src="/<?php echo $ads['middleAd'][$i]['file'];?>"  style="width:200px; height:60px;cursor:pointer;"  onclick="upC('<?php echo $ads['middleAd'][$i]['hashId'];?>');" /></td><td width="430" height="48" style="padding-right:10px;padding-left:10px;"><input type="text" class="topUrl" style="width:400px; height:32px; line-height:32px; border:#CCC 1px solid; border-radius:5px; padding-left:10px;" placeholder="请填写广告位连接地址" value="<?php echo $ads['middleAd'][$i]['url'];?>" /></td><td width="101" align="left" valign="middle">PV：<?php echo $ads['middleAd'][$i]['pv'];?></td><td width="48" height="48" align="left" valign="middle"><a href="javascript:removeTopFile('<?php echo $ads['middleAd'][$i]['hashId'];?>');">删除</a></td></tr></table><form id="topFormSub<?php echo $ads['middleAd'][$i]['hashId'];?>" name="topFormSub<?php echo $ads['middleAd'][$i]['hashId'];?>" action="<?php echo admin_url();?>uploads/ad?field=topFile_<?php echo $ads['middleAd'][$i]['hashId'];?>&backFunction=stopUploads&id=<?php echo $ads['middleAd'][$i]['hashId'];?>" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet" style="display:none;"><span id="topFileInner_<?php echo $ads['middleAd'][$i]['hashId'];?>"><input type="file" name="topFile_<?php echo $ads['middleAd'][$i]['hashId'];?>" id="topFile_<?php echo $ads['middleAd'][$i]['hashId'];?>" placeholder="请选择一张图片" onchange="topFormSub('<?php echo $ads['middleAd'][$i]['hashId'];?>');" /></span><input type="hidden" class="topPic" id="topPic_<?php echo $ads['middleAd'][$i]['hashId'];?>" value="<?php echo $ads['middleAd'][$i]['file'];?>" /><input type="hidden" class="hashId" id="hashId_<?php echo $ads['middleAd'][$i]['hashId'];?>" name="hashId" value="<?php echo $ads['middleAd'][$i]['hashId'];?>" /><input type="hidden" class="pvId" name="pvId" value="<?php echo $ads['middleAd'][$i]['pv'];?>" /></form></label>
                    <?php
								}
							}
						}
					?>
                    </div>

                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" valign="middle" style="padding-top:20px;">
                    
                    	<a href="javascript:subEdit();" style="width:auto; padding-left:25px; padding-right:25px; line-height:28px; background:#09C;color:#fff; text-align:center; display:inline-block; border-radius:4px;"> 保 存 </a>
                    
                    </td>
                  </tr>
                </table>
            </div>
        </div>
        
    </div>
    
    
	<style>
        .leftTree{width:200px; float:left; height:auto; border:#e4e4e4 1px solid; background:#f4f4f4; border-radius:5px;}
        .leftTree ul{padding:0; margin:0}
        .leftTree li{float:left;width:100%;font-size:14px;}
        .leftTree li a{width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center;}
        .leftTree li a:hover{text-decoration:none;width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center; background:#CCC;color:#000; font-weight:bold;}
        .leftTree .actived a{text-decoration:none;width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center; background:#CCC;color:#000; font-weight:bold;}
    </style>    
    </td>
  </tr>
</table>
<?php
	require VIEWPATH.'admins/bottom.php';
?>
<script>
	
	function addMiddleAd()
	{
		topInteger=parseInt(topInteger)+1;
		var maxInteger=0;
		
		$("#middleAder .topPic").each(function(){
			maxInteger=parseInt(maxInteger)+1;
		});
		
		if(maxInteger<5)
		{
			var topTable='<label class="while" id="tb' + topInteger + '"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">';
			topTable=topTable+ '<tr>';
			topTable=topTable+ '<td width="213" height="48" style="padding-left:10px;" id="upTopPicInner_' + topInteger + '">';
			topTable=topTable+ '<div style="width:200px; height:60px; border:#CCC 1px dotted; background:#f4f4f4;font-size:18px; line-height:60px; text-align:center;color:#666; cursor:pointer;" onclick="upC(' + topInteger + ');"> + 上传图片 </div></td>';
			topTable=topTable+ '<td width="430" height="48" style="padding-right:10px;padding-left:10px;"><input type="text" class="topUrl" style="width:400px; height:32px; line-height:32px; border:#CCC 1px solid; border-radius:5px; padding-left:10px;" placeholder="请填写广告位连接地址" /></td>';
			topTable=topTable+ '<td width="101" align="left" valign="middle">PV：0</td>';
			topTable=topTable+ '<td width="48" height="48" align="left" valign="middle"><a href="javascript:removeTopFile(' + topInteger + ');">删除</a></td>';
			topTable=topTable+ '</tr>';
			topTable=topTable+ '</table>';
			topTable=topTable+ '<form id="topFormSub' + topInteger + '" name="topFormSub' + topInteger + '" action="<?php echo admin_url();?>uploads/ad?field=topFile_' + topInteger + '&backFunction=stopUploads&id=' + topInteger + '" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet" style="display:none;">';
			topTable=topTable+ '<span id="topFileInner_' + topInteger + '">';
			topTable=topTable+ '<input type="file" name="topFile_' + topInteger + '" id="topFile_' + topInteger + '" placeholder="请选择一张图片" onchange="topFormSub(' + topInteger + ');" />';
			topTable=topTable+ '</span>';
			topTable=topTable+ '<input type="hidden" class="topPic" id="topPic_' + topInteger + '" value="" /><input type="hidden" class="hashId" id="hashId_' + topInteger + '" name="hashId" value="" /><input type="hidden" class="pvId" name="pvId" value="0" /></form></label>';
			//console.log(topTable);
			$('#middleAder').append(topTable);	
		}
		else
		{
			layer.msg('最多可以添加五条');	
		}
	}

	var topInteger=0;
	function addTopAd()
	{
		topInteger=parseInt(topInteger)+1;
		
		var maxInteger=0;
		$("#topAder .topPic").each(function(){
			maxInteger=parseInt(maxInteger)+1;
		});
		
		if(maxInteger<5)
		{
			var topTable='<label class="while" id="tb' + topInteger + '"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">';
			topTable=topTable+ '<tr>';
			topTable=topTable+ '<td width="213" height="48" style="padding-left:10px;" id="upTopPicInner_' + topInteger + '">';
			topTable=topTable+ '<div style="width:200px; height:60px; border:#CCC 1px dotted; background:#f4f4f4;font-size:18px; line-height:60px; text-align:center;color:#666; cursor:pointer;" onclick="upC(' + topInteger + ');"> + 上传图片 </div></td>';
			topTable=topTable+ '<td width="430" height="48" style="padding-right:10px;padding-left:10px;"><input type="text" class="topUrl" style="width:400px; height:32px; line-height:32px; border:#CCC 1px solid; border-radius:5px; padding-left:10px;" placeholder="请填写广告位连接地址" /></td>';
			topTable=topTable+ '<td width="101" align="left" valign="middle">PV：0</td>';
			topTable=topTable+ '<td width="48" height="48" align="left" valign="middle"><a href="javascript:removeTopFile(' + topInteger + ');">删除</a></td>';
			topTable=topTable+ '</tr>';
			topTable=topTable+ '</table>';
			topTable=topTable+ '<form id="topFormSub' + topInteger + '" name="topFormSub' + topInteger + '" action="<?php echo admin_url();?>uploads/ad?field=topFile_' + topInteger + '&backFunction=stopUploads&id=' + topInteger + '" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet" style="display:none;">';
			topTable=topTable+ '<span id="topFileInner_' + topInteger + '">';
			topTable=topTable+ '<input type="file" name="topFile_' + topInteger + '" id="topFile_' + topInteger + '" placeholder="请选择一张图片" onchange="topFormSub(' + topInteger + ');" />';
			topTable=topTable+ '</span>';
			topTable=topTable+ '<input type="hidden" class="topPic" id="topPic_' + topInteger + '" value="" /><input type="hidden" class="hashId" id="hashId_' + topInteger + '" name="hashId" value="" /><input type="hidden" class="pvId" name="pvId" value="0" /></form></label>';
			$('#topAder').append(topTable);
		}
		else
		{
			layer.msg('最多可以添加五条');	
		}
	}
	
	function upC(id)
	{
		$('#topFile_' + id).click();	
	}
	
	function removeTopFile(id)
	{
		$('#tb' + id).remove();		
	}
	
	var formDo=true;
	var uploadId='';
	function topFormSub(id)
	{
		if(formDo)
		{
			uploadId=id;
			layer.closeAll();
			var index = layer.load(1, {
			  shade: [0.9,'#333'] //0.1透明度的白色背景
			});
			formDo=false;	
			console.log(id);
			$('#topFormSub' + id).submit();				
		}	
		else
		{
			layer.msg("还有其他图片正在上传，请稍等");	
		}
	}
	
	function stopUploads(res)
	{
		layer.closeAll();
		formDo=true;	
		if(res.indexOf("|")>=0)
		{
			arr=res.split("|");
			console.log(arr);
			if(arr[0]==100)
			{
				var id=arr[2];
				var hashId=arr[3];
				
				$('#topFileInner_' + id).html('<input type="file" name="topFile_' + id + '" id="topFile_' + id + '" placeholder="请选择一张图片" onchange="topFormSub(\'' + id + '\');" />');
				
				$('#upTopPicInner_' + id).html('<img src="/' + arr[1] + '"  style="width:200px; height:60px;cursor:pointer;"  onclick="upC(\'' + id + '\');" />');
				
				$('#topPic_' + id).val(arr[1]);
				$('#hashId_' + id).val(hashId);
			}
			else if(arr[0]==200)
			{
				location='<?php echo http_url();?>login.html';
			}
			else if(arr[0]==300)
			{
				
				$('#topFileInner_' + uploadId).html('<input type="file" name="topFile_' + id + '" id="topFile_' + id + '" placeholder="请选择一张图片" onchange="topFormSub(' + id + ');" />');
				layer.msg(arr[1]);
			}
		}
		else
		{
			$('#topFileInner_' + uploadId).html('<input type="file" name="topFile_' + id + '" id="topFile_' + id + '" placeholder="请选择一张图片" onchange="topFormSub(' + id + ');" />');
			layer.msg('操作过程出错，请您稍后再试！');
		}				
	}
</script>
<script>

function subEdit()
{
	if(form_loads==1)
	{
		var topVal='';
		var middleVal='';
		$("#topAder .while").each(function(){
			var hashId=$(this).find('.hashId').val();
			var topPic=$(this).find('.topPic').val();
			var topUrl=$(this).find('.topUrl').val();

			if(hashId!='' && topPic!='')
			{
				if(topVal=='')
				{
					topVal=hashId + '||||' + topPic + '||||' + topUrl;
				}
				else
				{
					topVal=topVal + '____' + hashId + '||||' + topPic + '||||' + topUrl;	
				}
			}
			
		});
		
		$("#middleAder .while").each(function(){
			var hashId=$(this).find('.hashId').val();
			var topPic=$(this).find('.topPic').val();
			var topUrl=$(this).find('.topUrl').val();

			if(hashId!='' && topPic!='')
			{
				if(middleVal=='')
				{
					middleVal=hashId + '||||' + topPic + '||||' + topUrl;
				}
				else
				{
					middleVal=middleVal + '____' + hashId + '||||' + topPic + '||||' + topUrl;	
				}
			}
			
		});
		
		//console.log(topVal);
	
		layer.closeAll();
		form_loads=2;	
		$.ajax({url:"<?php echo admin_url();?>projecteds/zdygglUpdate/<?php echo $res['id'];?>", 
		type: 'POST', 
		data:{middleVal:middleVal,topVal:topVal}, 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){
				layer.closeAll();
				form_loads=1;
				layer.msg('操作过程出错，请您稍后再试！');				
			},
			beforeSend:function(){
				var index = layer.load(1, {
					shade: [0.5,'#000'] //0.1透明度的白色背景
				});
				form_loads=2;								
			},
			success:function(result){
				layer.closeAll();
				form_loads=1;
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				if(result.indexOf("|")>0){
					arr=result.split("|");
					if(arr[0]==100){
						form_state=1;
						layer.msg(arr[1]);
					}else if(arr[0]==200){
						layer.msg('登录状态已失效，请重新登录！');	
						setTimeout("location='<?php echo http_url();?>login.html'",1500);			
					}else if(arr[0]==300){
						layer.msg(arr[1]);				
					}
				}else{
					layer.msg('操作过程出错，请您稍后再试！');				
				}						
			} 
		});	


	}
	else
	{
		layer.msg('尚未其他进程运行中，请稍等...');	
	}		
}
</script>
</body>
</html>