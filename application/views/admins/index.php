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
	//删除
	var form_status=0;
	
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
			$.ajax({url:"<?php echo admin_url();?>home/del", 
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
							$('#li_' + id).remove();
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
	
	function repairIt(id)
	{
		if(form_status==0 || form_status==3){
			$.ajax({url:"<?php echo admin_url();?>home/repair", 
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
    <td height="60" colspan="2" align="left" valign="middle" style="padding-top:15px;"><a href="<?php echo admin_url();?>home/add.html" style="width:auto; background:#096; padding-left:30px; padding-right:30px; line-height:35px; border-radius:5px;color:#fff; display:inline-block;"> + 添加直播频道</a> <span style="float:right; text-align:right; padding-top:15px;">当前一共有 <strong><?php echo $query->num_rows();?></strong> 个直播频道</span></td>
  </tr>
  <tr>
    <td height="12" colspan="2" align="left" valign="middle"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px solid;"></div></td>
  </tr>
  <tr>
    <td height="12" colspan="2" align="left" valign="middle">
    <div class="projecteds">
    	<ul>
        <?php
        	foreach($arrayList as $arrays)
			{
		?>
        	<li id="li_<?php echo $arrays['id'];?>">
            	<div style="width:320px;height:auto; border:#fff 1px solid; margin:0 auto; filter:progid:DXImageTransform.Microsoft.Shadow(color=#909090,direction=120,strength=4);-moz-box-shadow: 2px 2px 10px #909090;-webkit-box-shadow: 2px 2px 10px #909090;box-shadow:2px 2px 10px #909090;">
                	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="23%" rowspan="4" align="center" valign="top" style="padding-top:10px;"><a href="<?php echo admin_url();?>projecteds/index/<?php echo $arrays['id'];?>.html"><img src="<?php echo $arrays['logo']==''?'/assets/images/f9.png':'/'.$arrays['logo'];?>" width="60" height="60" /></a></td>
                        <td width="77%" height="30" align="left" valign="middle"><a href="<?php echo admin_url();?>projecteds/index/<?php echo $arrays['id'];?>.html"><strong><?php echo $arrays['name'];?></strong></a></td>
                      </tr>
                      <tr>
                        <td height="30"><a href="<?php echo admin_url();?>projecteds/index/<?php echo $arrays['id'];?>.html" style="color:#666;">直播开始时间：<?php echo $arrays['timeOver']=='' || $arrays['timeOver']==0?'暂未设置':date('Y-m-d H:i:s',$arrays['timeOver']);?></a></td>
                      </tr>
                      <tr>
                        <td height="25"><a href="<?php echo admin_url();?>projecteds/index/<?php echo $arrays['id'];?>.html"  style="color:#CCC;font-size:12px;">最后直播时间：<?php echo $arrays['endTime']=='' || $arrays['endTime']==0?'暂无数据':date('Y-m-d H:i:s',$arrays['endTime']);?></a></td>
                      </tr>
                      <tr>
                        <td height="25" style="font-size:12px;"><a href="<?php echo admin_url();?>projecteds/index/<?php echo $arrays['id'];?>.html">观看量：<strong style="color:#09C"><?php echo $arrays['pv'];?></strong> 次 &nbsp;  观看总时长：<strong style="color:#09C"><?php echo intval($arrays['lookTime']/60);?></strong>分钟</a></td>
                      </tr>
                      <tr>
                        <td height="55" colspan="2" align="right" valign="middle"><a href="<?php echo admin_url();?>home/edit/<?php echo $arrays['id'];?>.html" style="width:auto; padding-left:10px; padding-right:10px; line-height:22px; background:#e4e4e4; border-radius:5px;color:#999; display:inline-block; padding-left:15px; padding-right:15px; margin-right:15px;">编辑</a> <a href="javascript:deleteOne('<?php echo $arrays['id'];?>');" style="width:auto; padding-left:10px; padding-right:10px; line-height:22px; background:#cc0000; border-radius:5px;color:#fff; display:inline-block; padding-left:15px; padding-right:15px; margin-right:15px;">删除</a> <a href="javascript:repairIt('<?php echo $arrays['id'];?>');" style="width:auto; padding-left:10px; padding-right:10px; line-height:22px; background:#333; border-radius:5px;color:#fff; display:inline-block; padding-left:15px; padding-right:15px; margin-right:15px;">修复</a></td>
                      </tr>
                    </table>
              </div>
            </li>
        <?php
			}
		?>
        </ul>
    </div>
    </td>
  </tr>
</table>
<?php
	require 'bottom.php';
?>
</body>
</html>