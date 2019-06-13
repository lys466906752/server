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
	var form_status=0;
	
	function reads()
	{
		$.ajax({url:"<?php echo admin_url();?>home/adminIndexList", 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
			error: function(){
				layer.closeAll();
				reads();
			},
			beforeSend:function(){
				var index = layer.load(1, {
				  shade: [0.2,'#000'] //0.1透明度的白色背景
				});									
			},
			success:function(result){
				layer.closeAll();
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				if(result.indexOf("200")>=0 && result.indexOf("登录失败")>=0)
				{
					location='<?php echo http_url();?>login.html';	
				}
				else
				{
					var arr=result.split('|||');
					var tables = $('.myList');
					var addtr = $(arr[0]);
					$("#allNums").html(arr[1]);
					addtr.appendTo(tables); 

				}
			}
		});			
	}

	$(function(){
		reads();	
	});
	
	//删除
	function deleteOne(id)
	{
		layer.confirm('您确定要删除吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
			del_rs(id);
		}, function(){
			layer.closeAll();
		});	
	}
	
	function del_rs(id)
	{
		if(form_status==0 || form_status==3){
			$.ajax({url:"<?php echo admin_url();?>home/adminDel", 
			type: 'POST', 
			data:{id:id},
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					form_status=3;	
					layer.msg('处理失败，请您稍后再试！');			
				},
				beforeSend:function(){
					layer.closeAll();
					var index = layer.load(3,{
						shade: [0.2,'#333333'] //0.1透明度的白色背景
					});
					form_status=1;	
				},
				success:function(result){
					form_status=3;
					layer.closeAll();
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("|")>0){
						arr=result.split("|");
						if(arr[0]==100){
							layer.msg(arr[1])		
							$('#item_line_' + id).remove();
							$('#item_' + id).remove();
						}else if(arr[0]==200){	
							layer.msg('登录状态已失效，请重新登录！');		
							setTimeout("location='<?php echo http_url();?>login.html'",1500);			
						}else if(arr[0]==300){
							layer.msg(arr[1]);						
						}
					}else{
						layer.msg('处理失败，请您稍后再试！');							
					}
				} 
			});
		}else{
			layer.msg('其他任务运行未结束，请您稍后再试！');						
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
    <td height="60" colspan="2" align="left" valign="middle" style="padding-top:15px;"><a href="<?php echo admin_url();?>home/adminAdd.html" style="width:auto; background:#096; padding-left:30px; padding-right:30px; line-height:35px; border-radius:5px;color:#fff; display:inline-block;"> + 添加管理员</a> <span style="float:right; text-align:right; padding-top:15px;">当前一共有 <strong style="color:#F00;" id="allNums"></strong> 个管理员</span></td>
  </tr>
  <tr>
    <td height="12" colspan="2" align="left" valign="middle"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px solid;"></div></td>
  </tr>
  <tr>
    <td height="12" colspan="2" align="left" valign="middle" >
    <div class="projecteds">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="myList">
        <tr style="font-weight:bold;">
          <td width="14%" height="38" align="center" valign="middle">ID编号</td>
          <td width="13%" height="38" align="center" valign="middle">用户名</td>
          <td width="26%" height="38" align="center" valign="middle">上次登录时间</td>
          <td width="22%" height="38" align="center" valign="middle">上次登录IP</td>
          <td width="16%" height="38" align="center" valign="middle">登录总次数</td>
          <td width="9%" height="38" align="center" valign="middle">操作</td>
        </tr>
        <tr>
          <td height="5" colspan="6" align="center" valign="middle">
          <div style="width:100%;float:left;height:2px;border-bottom:#CCC 1px dotted;"></div>
          </td>
          </tr>

      </table>
    </div></td>
  </tr>
</table>
<?php
	require 'bottom.php';
?>
</body>
</html>