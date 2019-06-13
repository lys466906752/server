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
	var pageHis=1;
	var form_status=0;
	var state='';
	var keywords='';
	
	function searchUsers()
	{
		state=$('#state').val();
		keywords=$('#keywords').val();	
		reads(1);
	}
	
	function reads(page)
	{
		pageHis=page;
		$.ajax({url:"<?php echo admin_url();?>members/indexList/" + page + '?state=' + state + '&keywords=' + keywords, 
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
					$('.projecteds').html(result);
				}
			}
		});			
	}

	$(function(){
		reads(1);	
	});
	
	function del_all(){
		var s_group = document.getElementsByName("cid");
		var s_group_value="";
		for(var i = 0; i< s_group.length; i++){
			if(s_group[i].checked==true){
				//alert(group[i].value);
				if(s_group_value==""){
					s_group_value=s_group[i].value;	
				}else{
					s_group_value=s_group_value + "," + s_group[i].value;
				}
			}
		}	
		if(s_group_value=="")
		{
			layer.msg('请选择要删除的数据');
		}
		else
		{
			del_it(s_group_value);	
		}			
	}	
	
	//删除
	function del_it(id)
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
			$.ajax({url:"<?php echo admin_url();?>members/del", 
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
							reads(pageHis);
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


	function close_comments(id)
	{
		if(form_status==0 || form_status==3){
			$.ajax({url:"<?php echo admin_url();?>members/changeComments/2", 
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
							$('#state_' + id).html('<a style="font-weight:bold;color:#cc0000;" href="javascript:open_comments(' + id + ');">禁止发言</a>');

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
	
	function open_comments(id)
	{
		if(form_status==0 || form_status==3){
			$.ajax({url:"<?php echo admin_url();?>members/changeComments/1", 
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
							$('#state_' + id).html('<a style="font-weight:bold;color:#099;" href="javascript:close_comments(' + id + ');">正常发言</a>');

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
	
	function choose_all()
	{
		//选择信息
		var s_group = document.getElementsByName("sx");
		var s_group_value="";
		for(var i = 0; i< s_group.length; i++){
			if(s_group[i].checked==true){
				s_group_value=s_group[i].value;
			}
		}
		var s_group = document.getElementsByName("cid");
		for(var i = 0; i< s_group.length; i++){
			if(s_group_value!=""){
				s_group[i].checked=true;
			}else{
				s_group[i].checked=false;	
			}
		}	
	}	
	
	function editUser(id)
	{
		layer.open({
		  type: 2,
		  title: '修改会员',
		  shadeClose: true,
		  shade: 0.8,
		  area: ['580px', '300px'],
		  content: '<?php echo admin_url();?>members/editUser/' + id //iframe的url
		}); 	
	}
	
	function selectUser(id)
	{
		layer.open({
		  type: 2,
		  title: '会员详情',
		  shadeClose: true,
		  shade: 0.8,
		  area: ['480px', '500px'],
		  content: '<?php echo admin_url();?>members/selectUser/' + id //iframe的url
		}); 	
	}
	
	function editNickName(code,msg)
	{
		layer.closeAll();
		if(code==100)
		{
			layer.msg(msg);
			setTimeout("reads(" + pageHis + ")",1500);
		}
		else
		{
			layer.msg(msg);		
		}
		if(code==200)
		{
			setTimeout("location='<?php echo http_url();?>login.html'",1500);		
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
	require VIEWPATH.'admins/include.php';
?>

  <tr>
    <td height="12" colspan="2" align="left" valign="middle" >
    <div class="projecteds">
   
      
    </div>
    </td>
  </tr>
</table>
<?php
	require VIEWPATH.'admins/bottom.php';
?>
</body>
</html>