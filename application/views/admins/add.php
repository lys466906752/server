<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title>军颐中医院技术直播管理系统</title>
<script src="https://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
<script src="/assets/layer_pc/layer.js"></script>
<script src="/assets/date/WdatePicker.js"></script>
<script>

	var form_loads=1;

	function add_admin()
	{
		if(form_loads==1)
		{
			var title=$("#title").val().replace(/(^\s*)|(\s*$)/g,"");
			var startTime=$("#startTime").val().replace(/(^\s*)|(\s*$)/g,"");
			var playUrl=$("#playUrl").val().replace(/(^\s*)|(\s*$)/g,"");
			var playFlvUrl=$("#playFlvUrl").val().replace(/(^\s*)|(\s*$)/g,"");
			var pushUrl=$("#pushUrl").val().replace(/(^\s*)|(\s*$)/g,"");
			
			if(title=="")
			{
				layer.msg('请填写频道名称');			
			}
			else if(title.length>50)
			{
				layer.msg('频道名称长度不要超过50字');	
			}
			else
			{
				layer.closeAll();
				form_loads=2;	
				$.ajax({url:"<?php echo admin_url();?>home/insert", 
				type: 'POST', 
				data:{title:title,startTime:startTime,playUrl:playUrl,pushUrl:pushUrl,playFlvUrl:playFlvUrl}, 
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
								$("#title").val("");
								$("#startTime").val("");
								$("#playUrl").val("");
								$("#playFlvUrl").val("");
								$("#pushUrl").val("");
								setTimeout("location='<?php echo admin_url();?>home/index.html'",1500);
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

		}
		else
		{
			layer.msg('尚未其他进程运行中，请稍等...');	
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
	require 'include.php';
?>
  <tr>
    <td height="60" colspan="2" align="left" valign="middle" style="padding-top:15px;"><h2>添加直播频道</h2></td>
  </tr>
  <tr>
    <td height="12" colspan="2" align="left" valign="middle"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px solid;">
      
    </div></td>
  </tr>
  <tr>
    <td  colspan="2" align="left" valign="middle" style="padding-top:30px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="17%" height="55" align="center" valign="middle"><font color="#FF0000">*</font> 频道名称：</td>
          <td width="83%" height="55" align="left" valign="middle"><input type="text" name="title" id="title" style="width:90%; height:30px; line-height:30px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" placeholder="请输入频道名称，长度最多为50字" /></td>
        </tr>
        <tr>
          <td height="55" align="center" valign="middle">直播开始时间：</td>
          <td height="55" align="left" valign="middle"><input type="text" name="startTime" id="startTime" style="width:90%; height:30px; line-height:30px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" placeholder="请选择直播开始时间，选填项"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate" readonly="readonly" /></td>
        </tr>
        <tr>
          <td height="55" align="center" valign="middle">直播视频地址：</td>
          <td height="55" align="left" valign="middle"><input type="text" name="playUrl" id="playUrl" style="width:90%; height:30px; line-height:30px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" placeholder="请填写视频直播地址，从腾讯云后台即可查找，如有问题，联系技术索取，选填项" /></td>
        </tr>
        <tr>
          <td height="55" align="center" valign="middle">直播视频地址(flv)：</td>
          <td height="55" align="left" valign="middle"><input type="text" name="playFlvUrl" id="playFlvUrl" style="width:90%; height:30px; line-height:30px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" placeholder="请填写视频直播地址，从腾讯云后台即可查找，如有问题，联系技术索取，选填项"  value="" /></td>
        </tr>
        <tr>
          <td height="55" align="center" valign="middle">视频推流地址：</td>
          <td height="55" align="left" valign="middle"><input type="text" name="pushUrl" id="pushUrl" style="width:90%; height:30px; line-height:30px; padding-left:5px; padding-right:5px; border:#e4e4e4 1px solid; border-radius:3px;" placeholder="请填写视频推流地址，从腾讯云后台即可查找，如有问题，联系技术索取，选填项" /></td>
        </tr>
        <tr>
          <td height="50" colspan="2" align="center" valign="middle"><input type="submit" name="button" id="button" value=" 确 认 并 添 加" onclick="add_admin();" /></td>
        </tr>
      </table>
    
    </td>
  </tr>
</table>
<?php
	require 'bottom.php';
?>
</body>
</html>