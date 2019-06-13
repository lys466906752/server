<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title>军颐中医院技术直播管理系统</title>
<script src="https://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
<script src="/assets/layer_pc/layer.js"></script>
<script charset="utf-8" src="/assets/kindeditor/kindeditor.zdycd.js"></script>
<script charset="utf-8" src="/assets/kindeditor/lang/zh_CN.js"></script>

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
  	<style>
 		.leftTree{width:200px; float:left; height:auto; border:#e4e4e4 1px solid; background:#f4f4f4; border-radius:5px;}
        .leftTree ul{padding:0; margin:0}
        .leftTree li{float:left;width:100%;font-size:14px;}
        .leftTree li a{width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center;}
        .leftTree li a:hover{text-decoration:none;width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center; background:#CCC;color:#000; font-weight:bold;}
        .leftTree .actived a{text-decoration:none;width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center; background:#CCC;color:#000; font-weight:bold;}
        .menus{width:316px; height:40px;float:left; background:#f4f4f4;}
       
        .menus a{float:left;width:77px; border:#CCC 1px solid; text-align:center; line-height:38px;}
        .menus .actives a{float:left;width:77px; border:#cc0000 1px solid; text-align:center; line-height:38px;}
        
    </style>       
        <div style="width:797px; float:right;min-height:350px;">
       	  <div style="width:775px; float:right; border-top-left-radius:5px; border-top-right-radius:5px; border:#e4e4e4 1px solid; height:45px; line-height:45px;color:#666; padding-left:15px; background:#f4f4f4;font-size:16px; border-bottom:none;">
            	自定义菜单
            </div>
            <div style="width:792px; float:right; height:auto; border-bottom-left-radius:5px; border-bottom-right-radius:5px; background:#e1e1e1; padding-top:15px; padding-bottom:15px;">

            	<table width="100%" height="22" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="45%" align="center" valign="top">
                    	<div style="width:318px; height:462px; background:url(/assets/images/menu-head.png) #f8f8f8 no-repeat; margin:0 auto;">
                        	<div style="width:316px; float:left; border:#CCC 1px solid; border-top:none; height:auto; margin-top:233px;">
                            	<div class="menus">
                                
									<?php
                                    	//先设置一个默认的数组，用来做冒泡排序
										$_arr=[
											[
												'id'=>1,
												'name'=>$pother['fristName']==''?'暂未设置':$pother['fristName'],
												'sort'=>$pother['frist']
											],
											[
												'id'=>2,
												'name'=>$pother['secondName']==''?'暂未设置':$pother['secondName'],
												'sort'=>$pother['second']
											],
											[
												'id'=>3,
												'name'=>$pother['thirdName']==''?'暂未设置':$pother['thirdName'],
												'sort'=>$pother['third']
											],
											[
												'id'=>4,
												'name'=>$pother['fourthName']==''?'暂未设置':$pother['fourthName'],
												'sort'=>$pother['fourth']
											],
										];
										
										
										for($i=1;$i<count($_arr);$i++)
										{
											for($x=0;$x<count($_arr)-$i;$x++)
											{

													//开始比对做冒泡
													$l=$x+1;
													if($_arr[$x]['sort']>$_arr[$l]['sort'])
													{
														$a=$_arr[$x];
														$b=$_arr[$l];
														//交换位置
														$_arr[$x]=$b;
														$_arr[$l]=$a;
													}	
		
											}	
										}
										
										//print_r($_arr);
									?>                                
                                
                                	<?php
                                    	for($i=0;$i<count($_arr);$i++)
										{
                                    ?>
                                	<span <?php if($i==0){echo 'class="actives" ';}?>id="ac<?php echo $_arr[$i]['id'];?>"><a href="javascript:showM(<?php echo $_arr[$i]['id'];?>);" id="menu_<?php echo $_arr[$i]['id'];?>"><?php echo $_arr[$i]['name'];?></a></span>
                                    <?php
                                    	}
									?>
                               	  <!--<span class="actives" id="ac1"><a href="javascript:showM(1);" id="menu_1"><?php echo isset($pother['fristName']) && $pother['fristName']!=''?$pother['fristName']:'暂未设置';?></a></span>
                                    
                                  <span id="ac2"><a href="javascript:showM(2);" id="menu_2"><?php echo isset($pother['secondName']) && $pother['secondName']!=''?$pother['secondName']:'暂未设置';?></a></span>
                                    
                                   <span id="ac3"><a href="javascript:showM(3);" id="menu_3"><?php echo isset($pother['thirdName']) && $pother['thirdName']!=''?$pother['thirdName']:'暂未设置';?></a></span>
                                    
                                   <span id="ac4"><a href="javascript:showM(4);" id="menu_4"><?php echo isset($pother['fourthName']) && $pother['fourthName']!=''?$pother['fourthName']:'暂未设置';?></a></span>-->
                                    
                                    
                                    
                                    
                                    
                              </div>
                                <div style="width:316px; text-align:center; float:left; height:auto;">
                                	<p><img src="<?php echo admin_url();?>projecteds/phoneShowCode/<?php echo $res['id'];?>" width="128" height="128" style="border:#CCC 1px dotted;" /></p>
                                    <p>手机扫描二维码查看显示效果</p>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="" align="center" valign="top">
                    
                    <table width="403" height="484" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="403" align="left" valign="top" bgcolor="#CCCCCC">
                        
                        
                        <table width="401" border="0" align="center" cellpadding="0" cellspacing="0" id="contents1" style="display:none;">
                          <tr>
                            <td height="45" align="center" valign="middle">&nbsp;</td>
                            <td height="45" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">名称：</td>
                            <td width="314" height="45" align="left" valign="middle"><input type="text" name="fristName" id="fristName" value="<?php echo $pother['fristName'];?>" placeholder="请输入名称" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">排序：</td>
                            <td width="314" height="45" align="left" valign="middle"><input type="text" name="frist" id="frist" value="<?php echo $pother['frist'];?>" placeholder="请填写整形数字，数字越小排名越靠前" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td height="100" colspan="2" align="center" valign="middle">
                            	<a href="javascript:fristNameEdit();" style="width:auto; padding-left:25px; padding-right:25px; line-height:28px; background:#09C;color:#fff; text-align:center; display:inline-block; border-radius:4px;"> 保 存 </a>
                            </td>
                          </tr>
                        </table>
                        
                        
                        
                        <table width="401" border="0" align="center" cellpadding="0" cellspacing="0" id="contents2" style="display:none;">
                          <tr>
                            <td height="45" align="center" valign="middle">&nbsp;</td>
                            <td height="45" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="45" align="center" valign="middle">名称：</td>
                            <td height="45" align="left" valign="middle"><input type="text" name="secondName" id="secondName" value="<?php echo $pother['secondName'];?>" placeholder="请输入名称" style="width:270px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">排序：</td>
                            <td width="314" height="45" align="left" valign="middle"><input type="text" name="second" id="second" value="<?php echo $pother['second'];?>" placeholder="请填写整形数字，数字越小排名越靠前" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">内容：</td>
                            <td width="314" height="45" align="left" valign="middle"><textarea id="secondContet" name="secondContet" style="resize:none;width:250px; height:180px;"><?php echo $pother['secondContet'];?></textarea></td>
                          </tr>
                          <tr>
                            <td height="100" colspan="2" align="center" valign="middle">
                            	<a href="javascript:secondContetEdit();" style="width:auto; padding-left:25px; padding-right:25px; line-height:28px; background:#09C;color:#fff; text-align:center; display:inline-block; border-radius:4px;"> 保 存 </a>
                            </td>
                          </tr>
                        </table>
                        
                        <table width="401" border="0" align="center" cellpadding="0" cellspacing="0" id="contents3" style="display:none;">
                          <tr>
                            <td height="45" align="center" valign="middle">&nbsp;</td>
                            <td height="45" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="45" align="center" valign="middle">名称：</td>
                            <td height="45" align="left" valign="middle"><input type="text" name="thirdName" id="thirdName" value="<?php echo $pother['thirdName'];?>" placeholder="请输入名称" style="width:270px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">排序：</td>
                            <td width="314" height="45" align="left" valign="middle"><input type="text" name="third" id="third" value="<?php echo $pother['third'];?>" placeholder="请填写整形数字，数字越小排名越靠前" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">内容：</td>
                            <td width="314" height="45" align="left" valign="middle"><textarea id="thirdContet" name="thirdContet" style="resize:none;width:250px; height:180px;"><?php echo $pother['thirdContet'];?></textarea></td>
                          </tr>
                          <tr>
                            <td height="100" colspan="2" align="center" valign="middle">
                            	<a href="javascript:thirdContetEdit();" style="width:auto; padding-left:25px; padding-right:25px; line-height:28px; background:#09C;color:#fff; text-align:center; display:inline-block; border-radius:4px;"> 保 存 </a>
                            </td>
                          </tr>
                        </table>
                        
                        
                        <table width="401" border="0" align="center" cellpadding="0" cellspacing="0" id="contents4" style="display:none;">
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">&nbsp;</td>
                            <td width="314" height="45" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="45" align="center" valign="middle">名称：</td>
                            <td height="45" align="left" valign="middle"><input type="text" name="fourthName" id="fourthName" value="<?php echo $pother['fourthName'];?>" placeholder="请输入名称" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td width="87" height="45" align="center" valign="middle">排序：</td>
                            <td width="314" height="45" align="left" valign="middle"><input type="text" name="fourth" id="fourth" value="<?php echo $pother['fourth'];?>" placeholder="请填写整形数字，数字越小排名越靠前" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                          </tr>
                          <tr>
                            <td height="45" colspan="2" align="center" valign="middle">
                            	<div style="width:380px;height:400px; overflow:auto; margin:0 auto;" id="indexListScroll">
                                	<div style="width:100%; height:auto; float:left;" id="indexItems">
                                    	<ul>
                                        	<li style="float:left; padding-top:20px;">
                                            	<div style="width:148px; float:left; height:98px;padding-left:5px;font-size:16px; border:#e4e4e4 1px dotted; cursor:pointer; background:#cc0000;color:#fff; border-radius:5px; line-height:98px;" onclick="addMV();">
                                                	+ 点击添加视频
                                                </div>
                                            </li>
                                        <span id="mvLists">
                                        	
                                        </span>
                                        </ul>
                                    </div>
                                </div>
                                
                            </td>
                          </tr>
                          <tr>
                            <td height="100" colspan="2" align="center" valign="middle">
                            	<a href="javascript:fourthNameEdit();" style="width:auto; padding-left:25px; padding-right:25px; line-height:28px; background:#09C;color:#fff; text-align:center; display:inline-block; border-radius:4px;"> 保 存 </a>
                            </td>
                          </tr>
                        </table>
                        
                        
                        
                        </td>
                      </tr>
                    </table>
                    
                    

                    
                    
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" valign="middle" style="padding-top:20px;"></td>
                  </tr>
                </table>
            </div>
        </div>
        
    </div>
    
    
   
    </td>
  </tr>
</table>
<?php
	require VIEWPATH.'admins/bottom.php';
?>
<script type="text/javascript">
	
	//展示添加视频页面
	function addMV()
	{
		layer.open({
		  type: 2,
		  title: '添加视频',
		  shadeClose: true,
		  shade: 0.8,
		  area: ['580px', '400px'],
		  content: '<?php echo admin_url();?>projecteds/mvAdd/<?php echo $res['id'];?>' //iframe的url
		}); 			
	}
	
	//展示修改视频页面
	function editMV(id)
	{
		layer.open({
		  type: 2,
		  title: '修改视频',
		  shadeClose: true,
		  shade: 0.8,
		  area: ['580px', '400px'],
		  content: '<?php echo admin_url();?>projecteds/mvEdit/<?php echo $res['id'];?>?mid=' + id //iframe的url
		}); 			
	}
	
	function editNickName(code,msg)
	{
		layer.closeAll();
		if(code==100)
		{
			layer.msg(msg);
			maxId=0;
			$('#mvLists').html("");
			ajaxGet=true;
			ajaxRead();		
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
	
	//ajax读取视频信息
	$(function(){
		ajaxRead();	
		scrollShow();
		clickFrist();
	});
	
	//模拟点击第一个
	function clickFrist()
	{
		var clicks=true;
		var loadId='';
		$(".menus span").each(function(){
			var id=$(this).find('a').attr("id");
			id=id.replace('menu_','');

			if(clicks)
			{
				$('#contents' + id).show();
				clicks=false;
			}
			
		});			
	}
	
	//下拉加载更多的方法
	function scrollShow()
	{
		$("#indexListScroll").scroll(function(){
			
			var scrollTop = $("#indexListScroll").scrollTop();
			var scrollHeight = $("#indexListScroll").height();
			var windowHeight = $("#indexItems").height();
			
			if(scrollTop + scrollHeight == windowHeight)
			{
				if(ajaxLoad && ajaxGet)
				{
					//加载下一页数据
					ajaxRead();	
				}	
			}
		});		
	}	
	
	var maxId=0;
	var ajaxLoad=true;
	var ajaxGet=true;
	function ajaxRead()
	{
		if(ajaxLoad && ajaxGet)
		{
			$.ajax({url:"<?php echo admin_url();?>projecteds/zdycdMvAjax/<?php echo $res['id'];?>?maxId=" + maxId, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					ajaxLoad=true;
					layer.msg('操作过程出错，请您稍后再试！');				
				},
				beforeSend:function(){
					ajaxLoad=false;								
				},
				success:function(result){
					ajaxLoad=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf('|||')>=0)
					{
						var arr=result.split('|||');
						maxId=parseInt(arr[1]);
						if(arr[0]!='')
						{
							$('#mvLists').append(arr[0]);		
						}	
						else
						{
							ajaxGet=false;
						}
					}	
					else
					{
						layer.msg('操作过程出错，请您稍后再试！');	
					}		
				} 
			});
		}
		else
		{
			layer.msg('程序处理中，请稍等');	
		}
	}
	
	//提交删除请求
	function delMV(id)
	{
		if(form_loads)
		{
			
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/mvAddDel/<?php echo $res['id'];?>?mid=" + id, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					form_loads=true;
					layer.msg('操作过程出错，请您稍后再试！');				
				},
				beforeSend:function(){
					var index = layer.load(1, {
						shade: [0.5,'#000'] //0.1透明度的白色背景
					});
					form_loads=false;								
				},
				success:function(result){
					layer.closeAll();
					form_loads=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("|")>0){
						arr=result.split("|");
						if(arr[0]==100){
							form_loads=true;
							layer.msg(arr[1]);
							$('#mid_' + id).remove();
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
	
	KindEditor.ready(function(K) {
		window.secondContet100 = K.create('#secondContet'); 
	});
	KindEditor.ready(function(K) {
		window.secondContet200 = K.create('#thirdContet'); 
	});	

	function showM(id)
	{
		for(var i=1;i<=4;i++)
		{
			$('#ac' + i).attr('class','');
			$('#contents' + i).hide();	
		}	
		$('#ac' + id).attr('class','actives');	
		$('#contents' + id).show();	
	}

	var form_loads=true;
	function fristNameEdit()
	{
		if(form_loads)
		{
			var fristName=$("#fristName").val().replace(/(^\s*)|(\s*$)/g,"");
			var frist=$("#frist").val().replace(/(^\s*)|(\s*$)/g,"");
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/zdycdUpdate/<?php echo $res['id'];?>?act=1", 
			type: 'POST', 
			data:{fristName:fristName,frist:frist}, 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					form_loads=true;
					layer.msg('操作过程出错，请您稍后再试！');				
				},
				beforeSend:function(){
					var index = layer.load(1, {
						shade: [0.5,'#000'] //0.1透明度的白色背景
					});
					form_loads=false;								
				},
				success:function(result){
					layer.closeAll();
					form_loads=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("|")>0){
						arr=result.split("|");
						if(arr[0]==100){
							form_loads=true;
							layer.msg(arr[1]);
							if(fristName=='')
							{
								fristName='暂未设置';	
							}
							$('#menu_1').html(fristName);
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
	
	function fourthNameEdit()
	{
		if(form_loads)
		{
			var fourthName=$("#fourthName").val().replace(/(^\s*)|(\s*$)/g,"");
			var fourth=$("#fourth").val().replace(/(^\s*)|(\s*$)/g,"");
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/zdycdUpdate/<?php echo $res['id'];?>?act=1", 
			type: 'POST', 
			data:{fourthName:fourthName,fourth:fourth}, 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					form_loads=true;
					layer.msg('操作过程出错，请您稍后再试！');				
				},
				beforeSend:function(){
					var index = layer.load(1, {
						shade: [0.5,'#000'] //0.1透明度的白色背景
					});
					form_loads=false;					
				},
				success:function(result){
					layer.closeAll();
					form_loads=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("|")>0){
						arr=result.split("|");
						if(arr[0]==100){
							form_loads=true;
							layer.msg(arr[1]);
							if(fourthName=='')
							{
								fourthName='暂未设置';	
							}
							$('#menu_4').html(fourthName);
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
	
	function secondContetEdit()
	{
		if(form_loads)
		{
			var secondName=$("#secondName").val().replace(/(^\s*)|(\s*$)/g,"");
			secondContet100.sync();
			var secondContet=$("#secondContet").val();
			var second=$("#second").val().replace(/(^\s*)|(\s*$)/g,"");
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/zdycdUpdate/<?php echo $res['id'];?>?act=1", 
			type: 'POST', 
			data:{secondName:secondName,secondContet:secondContet,second:second}, 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					form_loads=true;
					layer.msg('操作过程出错，请您稍后再试！');				
				},
				beforeSend:function(){
					var index = layer.load(1, {
						shade: [0.5,'#000'] //0.1透明度的白色背景
					});
					fform_loads=false;							
				},
				success:function(result){
					layer.closeAll();
					form_loads=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("|")>0){
						arr=result.split("|");
						if(arr[0]==100){
							form_loads=true;
							layer.msg(arr[1]);
							if(secondName=='')
							{
								secondName='暂未设置';	
							}
							$('#menu_2').html(secondName);
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
	
	function thirdContetEdit()
	{
		if(form_loads)
		{
			var thirdName=$("#thirdName").val().replace(/(^\s*)|(\s*$)/g,"");
			secondContet200.sync();
			var thirdContet=$("#thirdContet").val();
			var third=$("#third").val().replace(/(^\s*)|(\s*$)/g,"");
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/zdycdUpdate/<?php echo $res['id'];?>?act=1", 
			type: 'POST', 
			data:{thirdName:thirdName,thirdContet:thirdContet,third:third}, 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					form_loads=true;
					layer.msg('操作过程出错，请您稍后再试！');				
				},
				beforeSend:function(){
					var index = layer.load(1, {
						shade: [0.5,'#000'] //0.1透明度的白色背景
					});
					form_loads=false;					
				},
				success:function(result){
					layer.closeAll();
					form_loads=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("|")>0){
						arr=result.split("|");
						if(arr[0]==100){
							form_loads=true;
							layer.msg(arr[1]);
							if(thirdName=='')
							{
								thirdName='暂未设置';	
							}
							$('#menu_3').html(thirdName);
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