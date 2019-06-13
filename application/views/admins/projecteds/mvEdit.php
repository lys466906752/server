<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title>军颐中医院技术直播管理系统</title>
<script src="https://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
<script src="/assets/layer_pc/layer.js"></script>
<script>

	var form_loads=1;

	function add_admin()
	{
		
		if(form_loads==1)
		{
			var nickname=$("#nickname").val().replace(/(^\s*)|(\s*$)/g,"");
			var avatar=$("#avatar").val().replace(/(^\s*)|(\s*$)/g,"");
			var mvId=$("#mvId").val().replace(/(^\s*)|(\s*$)/g,"");
			var appId=$("#appId").val().replace(/(^\s*)|(\s*$)/g,"");

			if(nickname=="")
			{
				layer.msg('请设置一个标题吧');			
			}
			else if(nickname.length>=50)
			{
				layer.msg('标题长度别超过50个字');
			}
			else if(avatar=='')
			{
				layer.msg("请上传一张封面图");	
			}
			else if(mvId=='' || appId=='')
			{
				layer.msg("AppId和视频Id不能为空");		
			}
			else
			{
				layer.closeAll();
				form_loads=2;	
				$.ajax({url:"<?php echo admin_url();?>projecteds/mvAddUpdate/<?php echo $res['id'];?>?mid=<?php echo $result['id'];?>", 
				type: 'POST', 
				data:{title:nickname,file:avatar,appId:appId,mvId:mvId},
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
								$("#nickname").val("");
								$("#avatar").val("");
								parent.editNickName(100,arr[1]);
							}else if(arr[0]==200){
								parent.editNickName(200,"登录失败");		
							}else if(arr[0]==300){
								parent.editNickName(300,arr[1]);						
							}
						}else{
							layer.msg('操作过程出错，请您稍后再试！');				
						}						
					} 
				});	

			}

		}
		else
		{
			layer.msg('尚未其他进程运行中，请稍等...');	
		}
	}
</script>
<script type="text/javascript">	
	var form_loads=1;
	//提交对应的表单
	function onSubmit()
	{

		if(form_loads==1)
		{
			layer.closeAll();
			var index = layer.load(1, {
			  shade: [0.9,'#333'] //0.1透明度的白色背景
			});
			form_loads=2;	
			document.form.submit();	
		}
		else
		{
			layer.msg('抱歉：还有进程数据正在处理中，请稍等...');
		}

	}

	//上传成功回调
	function stopUpload(res)
	{
		//alert(res);
		layer.closeAll();
		form_loads=1;	
		if(res.indexOf("|")>=0)
		{
			arr=res.split("|");

			if(arr[0]==100)
			{
				//alert(arr[2]);
				$('#avatar').val(arr[1]);
				$('#fileInner').html('<input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />');
				var timestamp1 = Date.parse(new Date());
				document.getElementById('avatarsImg').src='/' + arr[1] + '?' + timestamp1;
				$('#avatarsImg').show();
				
			}
			else if(arr[0]==200)
			{
				location='<?php echo http_url();?>login.html';
			}
			else if(arr[0]==300)
			{
				$('#fileInner').html('<input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />');
				layer.msg(arr[1]);
			}
		}
		else
		{
			$('#fileInner').html('<input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />');
			layer.msg('操作过程出错，请您稍后再试！');
		}
	}         		
</script>
<link href="/assets/admin/css/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.nav a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px;float:left;}
.nav a:hover{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:}
.nav .actived a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:float:left;font-weight:bold; text-decoration:underline;}
.projecteds{width:100%; float:left; height:auto;}
.projecteds ul{padding:0; margin:0;}
.projecteds ul li{float:left; width:330px; height:auto; padding-bottom:15px; padding-top:10px;}
</style>
</head>

<body>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="31%" height="55" align="center" valign="middle"><font color="#FF0000">*</font> 视频标题：</td>
          <td width="69%" height="55" align="left" valign="middle"><input type="text" name="nickname" id="nickname" style="width:90%; height:28px; line-height:28px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" value="<?php echo $result['title'];?>" placeholder="请为视频取一个标题名称吧" /></td>
        </tr>
        <tr>
          <td height="55" align="center" valign="middle"><font color="#FF0000">*</font> 视频封面：</td>
          <td height="55" align="left" valign="middle">
          <iframe id="tarGet" name="tarGet" src="#" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>
          	<form id="form" name="form" action="<?php echo admin_url();?>uploads/index" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet">
            <span  id="fileInner">
          <input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />
          </span>
          </form></td>
        </tr>
        <tr>
          <td height="55" align="center" valign="middle">封面预览：</td>
          <td height="55" align="left" valign="middle"><input type="hidden" id="avatar" name="avatar" value="<?php echo $result['file'];?>" /><img src="/<?php echo $result['file'];?>" id="avatarsImg" width="165" height="65" /></td>
        </tr>
        
        <tr>
          <td height="55" align="center" valign="middle"><font color="#FF0000">* </font>视频ID：</td>
          <td height="55" align="left" valign="middle"><input type="text" name="mvId" id="mvId" style="width:90%; height:28px; line-height:28px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" value="<?php echo isset($result['mvId']) && $result['mvId']!=''?$result['mvId']:"";?>" placeholder="请填写视频地址" /></td>
        </tr>
        <tr>
          <td width="31%" height="55" align="center" valign="middle"><font color="#FF0000">*</font> AppId：</td>
          <td width="69%" height="55" align="left" valign="middle"><input type="text" name="appId" id="appId" style="width:90%; height:28px; line-height:28px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" value="<?php echo isset($result['appId']) && $result['appId']!=''?$result['appId']:"";?>" placeholder="请填写视频地址" /></td>
        </tr>
        <tr>
          <td height="50" colspan="2" align="center" valign="middle"><input type="submit" name="button" id="button" value=" 保 存  " onclick="add_admin();" /></td>
        </tr>
      </table>
    
    </td>
  </tr>
</table>
</body>
</html>