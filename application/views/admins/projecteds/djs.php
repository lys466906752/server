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
<script src="/assets/date/WdatePicker.js"></script>
<script src="/assets/js/leftTime.min.js"></script>
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
        
        <div style="width:797px; float:right;min-height:350px;">
       	  <div style="width:775px; float:right; border-top-left-radius:5px; border-top-right-radius:5px; border:#e4e4e4 1px solid; height:45px; line-height:45px;color:#666; padding-left:15px; background:#f4f4f4;font-size:16px; border-bottom:none;">
            	直播倒计时
            </div>
            <div style="width:792px; float:right; height:auto; border-bottom-left-radius:5px; border-bottom-right-radius:5px; background:#e1e1e1; padding-top:15px; padding-bottom:15px;">
            	<table width="100%" height="22" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="58%" align="center" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="28%" height="53" align="center" valign="middle">倒计时：</td>
                        <td width="72%" height="53" align="left" valign="middle"><select name="timeOverShow" id="timeOverShow"  style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" >
                          <option value="2" <?php if($res['timeOverShow']==2){echo 'selected';}?>>显示</option>
                          <option value="1" <?php if($res['timeOverShow']==1){echo 'selected';}?>>关闭</option>
                        </select></td>
                      </tr>
                      <tr>
                        <td height="53" align="center" valign="middle">直播提示文字：</td>
                        <td height="53" align="left" valign="middle"><input type="text" name="timeOverText" id="timeOverText" value="<?php echo $res['timeOverText'];?>" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" /></td>
                      </tr>
                      <tr>
                        <td height="53" align="center" valign="middle">直播开始时间：</td>
                        <td height="53" align="left" valign="middle"><input type="text" name="timeOver" id="timeOver" value="<?php echo $res['timeOver']=='' || $res['timeOver']==0?'':date('Y-m-d H:i:s',$res['timeOver']);?>" style="width:250px;height:28px; line-height:28px; border:#CCC 1px solid; border-radius:5px; padding-left:3px; padding-right:3px; outline:none;" placeholder="请选择直播开始时间，选填项"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate" readonly="readonly"  /></td>
                      </tr>
 
                      <tr>
                        <td height="53" align="center" valign="middle">直播倒计时剩余：</td>
                        <td height="53" align="left" valign="middle" id="dateShow4"><span class="d">-</span>天 <span class="h">-</span>时 <span class="m">-</span>分 <span class="s">-</span>秒</td>
                      </tr>
                      <tr>
                        <td height="53" colspan="2" align="center" valign="middle"><a href="javascript:subEdit();" style="width:auto; padding-left:25px; padding-right:25px; line-height:28px; background:#09C;color:#fff; text-align:center; display:inline-block; border-radius:4px;"> 保 存 </a></td>
                      </tr>
                    </table></td>
                    <td width="42%" align="center" valign="top">
                   	  <div style="width:90%; float:left; text-align:center; line-height:40px;font-weight:bold;"> 展 示 效 果  </div>
                        
                   	  <div style="width:100%;text-align:center; padding-top:10px; float:left; min-height:400px;" id="testShow">
                        	
                           
                            
                            <div style="width:272px; height:541px; margin:0 auto; background:url(/assets/images/countdown.png) no-repeat top center; text-align:center; background-size:100%;" id='ydtInner'>
                           
                            </div>
                            
                        </div>
                        
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" valign="middle" style="padding-top:20px;"></td>
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
var timeOver=$('#timeOver').val();
var clearTime3;
$(function(){
	
	
	clearTime3=$.leftTime(timeOver,function(d){
		if(d.status){
			var $dateShow4=$("#dateShow4");
			$dateShow4.find(".d").html(d.d);
			$dateShow4.find(".h").html(d.h);
			$dateShow4.find(".m").html(d.m);
			$dateShow4.find(".s").html(d.s);
		}
	});
	
	show_C();
});

	function show_C()
	{
		timeOver=$('#timeOver').val();
		
		var timestamp = (new Date()).getTime();
		var date = new Date(timeOver);
		var time1 = date.getTime();
		//console.log(time1 + '_____' + timestamp);
		
		window.clearInterval(clearTime3);
		if(parseInt(time1)<=parseInt(timestamp))
		{
			$('.d').html("-");$('.h').html("-");$('.m').html("-");$('.s').html("-");	
		}
		else
		{
			clearTime3=$.leftTime(timeOver,function(d){
				if(d.status){
					var $dateShow4=$("#dateShow4");
					$dateShow4.find(".d").html(d.d);
					$dateShow4.find(".h").html(d.h);
					$dateShow4.find(".m").html(d.m);
					$dateShow4.find(".s").html(d.s);
				}
			});
		}
		setTimeout("show_C()",500);
	}

function subEdit()
{
	if(form_loads==1)
	{
		var timeOverText=$("#timeOverText").val().replace(/(^\s*)|(\s*$)/g,"");
		var timeOver=$("#timeOver").val().replace(/(^\s*)|(\s*$)/g,"");
		var timeOverShow=$("#timeOverShow").val().replace(/(^\s*)|(\s*$)/g,"");
	
		layer.closeAll();
		form_loads=2;	
		$.ajax({url:"<?php echo admin_url();?>projecteds/djsUpdate/<?php echo $res['id'];?>", 
		type: 'POST', 
		data:{timeOverShow:timeOverShow,timeOver:timeOver,timeOverText:timeOverText}, 
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