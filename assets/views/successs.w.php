<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $text;?></title>
<style type="text/css">
body,td,th {
	font-size: 12px;
	font-family:'微软雅黑';
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script language="javascript" src="/public/js/jquery.js"></script>
<script language="javascript" src="/public/layer_pc/layer.js"></script>
<script>
	$(document).ready(function (){
		show_bgs();
		times();
	});
	function show_bgs()
	{
		var web_height=document.body.clientHeight;//获取网页的当前高度
		var web_width1=screen.width;//获取网页的当前高度
		var web_height1=document.documentElement.clientHeight;//获取网页的当前高度1
		var web_width=document.documentElement.clientWidth;//获取网页的当前宽度
		if(web_height1>web_height){//根据不同浏览器定位来判断当前浏览器的高度
			web_height=web_height1;
		}	
		//if(web_width1>web_width){//根据不同浏览器定位来判断当前浏览器的高度
			//web_width=web_width1;
		//}		
		//设置网页的宽度和高度
		document.getElementById("bgs").style.height=web_height + "px";
		document.getElementById("bgs").style.width=web_width + "px";		
		document.getElementById("bgs").style.display="block";
		document.getElementById("grays").style.height=web_height + "px";
		document.getElementById("grays").style.width=web_width + "px";		
		document.getElementById("grays").style.display="block";
		
		var div_h=$("#boxs").outerHeight();
		var div_w=$("#boxs").outerWidth();
		
		document.getElementById("boxs").style.left=(web_width-div_w)/2 + "px";
		document.getElementById("boxs").style.top=parseInt((web_height1-div_h))/2 + "px";
		$("#boxs").show();		
		
		setTimeout("show_bgs()",100);		
	}
	<?php
		if($url=="")
		{
			if(isset($_SERVER['HTTP_REFERER']) && trim($_SERVER['HTTP_REFERER'])!="")
			{
				$url=$_SERVER['HTTP_REFERER'];	
			}	
			else
			{
				$url=http_url();	
			}
		}
	?>
	var time=<?php echo $time+1;?>;
	function times()
	{
		time=time-1;
		if(time<=0)
		{
			location="<?php echo $url;?>";	
		}	
		else
		{
			$("#cls").html(time);
			setTimeout("times()",1000);	
		}
	}
	
</script>
<style>
	#bgs{width:100%;float:left; height:1000px;background:url(/public/images/go_bg.jpg); background-size:cover;}
	#grays{position:fixed;width:auto;height:auto;background:#000;filter:alpha(Opacity=80);-moz-opacity:0.8;opacity:0.8;z-index:15;display:none;}
</style>
</head>

<body>
<div id="grays"></div>
<div id="boxs" style="width:600px; height:230px; position:fixed;z-index:18; background:#FFF; border-radius:5px;box-shadow:-2px 0 2px #e4e4e4,2px 0 2px #e4e4e4,0 -2px 2px #e4e4e4,0 2px 2px #e4e4e4;">
	<div style="width:97%; float:left; height:40px; border-bottom:#CCC 1px solid; line-height:40px; padding-left:3%;font-size:14px;font-weight:normal;color:#666;">
    	同城巧遇网：
    </div>
    <div style="width:97%; float:left; height:140px; border-bottom:#CCC 1px solid; line-height:40px; padding-left:3%;font-size:14px;font-weight:;">
    
    <div style="background:url(/public/images/sign-check-icon.png) 30px 40px no-repeat; width:118px; height:138px; float:left;"></div>
    <div style="width:400px; float:left; height:138px; line-height:138px; text-align:left;font-size:18px;"><?php echo $text;?></div>
    
    </div>
    <div style="width:97%; float:left; height:40px; padding-left:3%;font-size:14px; text-align:right; padding-top:10px;">
    	<a href="<?php echo $url;?>" style="width:auto; display:inline-block; padding-left:15px; padding-right:15px; height:30px; line-height:30px; background:#cc0000;color:#fff; text-decoration:none; border-radius:2px;margin-right:20px;"> <span id="cls"><?php echo $time;?></span> 秒后自动返回 </a> 
        
        <a href="<?php echo http_url();?>" style="width:auto; display:inline-block; padding-left:15px; padding-right:15px; height:30px; line-height:30px; background:#ccc;color:#666; text-decoration:none; border-radius:2px; margin-right:20px;">返回首页</a>
    </div>
</div>
<div id="bgs"></div>
</body>
</html>