<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="80" align="center" valign="middle" style="color:#999;">© 2018 北京市军颐中医院网络直播系统 由军颐技术部制作 参与人员：yuanyaru、zhaoxin、wangzhuang、lilin、jason</td>
  </tr>
</table>
<script>
	var cState=true;
	function clearCache()
	{
		if(cState)
		{
			$.ajax({url:"<?php echo admin_url();?>projecteds/clearCache", 
			type: 'GET',
			dataType: 'html', 
			timeout: 1500000, 
				error: function(){
					cState=true;
					layer.closeAll();
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					cState=false;
					var index = layer.load(1, {
						shade: [0.8,'#000'] //0.1透明度的白色背景
					});
				},
				success:function(result){
					
					cState=true;
					layer.closeAll();
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					
					layer.msg('清除成功！');
					
			
				} 
			});					
		}	
	}
</script>