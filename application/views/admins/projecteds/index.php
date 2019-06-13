<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title>军颐中医院技术直播管理系统</title>
<script src="/assets/js/jquery-1.8.0.min.js"></script>
<script src="/assets/layer_pc/layer.js"></script>
<script src="/assets/admin/js/jquery.zclip.min.js"></script>
<script type="text/javascript" src="/assets/js/zoom.js"></script>
<script>
	function showBigImg()
	{
		/*
		smallimg   // 小图
		bigimg  //点击放大的图片
		mask   //黑色遮罩
		*/
		var obj = new zoom('mask', 'bigimg','smallimg');
		obj.init();	
		sodoShowOrHide();
		setTimeout("showBigImg()",1000);
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
    <td  colspan="2" align="left" valign="middle" bgcolor="#f4f4f4" style="padding-top:20px; padding-bottom:20px;">
    <div style="width:960px; margin:0 auto; height:auto; background:#FFF; border-radius:18px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td width="42%" height="95" align="right" valign="top"><table width="406" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td width="406" height="30" align="left" valign="middle" style="padding-top:15px;"><strong style="font-size:16px;">直播监控</strong> <span id="liveState">
                <?php
                	if($res['state']==1)
					{
				?>
                <a href="javascript:openLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">开启观看页面直播</a>
                <?php
					}
					else
					{
				?>
                <a href="javascript:closeLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">关闭直播服务</a>
                <?php
					}
				?>
                </span>
                &nbsp;
                <span id="testLiveState">
                <?php
                	if($res['test']==1)
					{
				?>
                <a href="javascript:openTestLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">开启调试观看</a>
                <?php
					}
					else
					{
				?>
                <a href="javascript:closeTestLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">关闭调试观看</a>
                <?php
					}
				?>
                </span>
                </td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px dotted;"></div></td>
              </tr>
              <tr>
                <td height="60" align="left" valign="middle">
                <span id="noPlayInner" <?php echo (isset($res['state']) && $res['state']==1) && (isset($res['test']) && $res['test']==1)?'style="display:block"':'style="display:none"';?>>
                <?php
                	if($res['playBgFile']!='')
					{
				?>
                <img src="/<?php echo $res['playBgFile'];?>" width="391" height="225" />
                <?php
					}
					else
					{
				?>
                <div style="width:391px;height:225px; background:#000; color:#fff; text-align:center; line-height:225px;font-size:18px;">直播尚未开启</div>
                <?php
					}
				?>
                </span>
                <span id="PlayInner" <?php echo (isset($res['state']) && $res['state']==2) || (isset($res['test']) && $res['test']==2)?'style="display:block"':'style="display:none"';?>>
                <div id="id_junyi_video" style="width:391px; height:225px;"></div>
				<script src="//imgcache.qq.com/open/qcloud/video/vcplayer/TcPlayer-2.2.2.js" charset="utf-8"></script>
                 <script type="text/javascript">
					 var player =  new TcPlayer('id_junyi_video', {
					<?php
						if($res['playUrl']!='')
						{
					?>
					"m3u8": "<?php echo $res['playUrl'];?>",
					<?php
						}
						if($res['playFlvUrl']!='')
						{
					?>
					"flv": "<?php echo $res['playFlvUrl'];?>", //增加了一个flv的播放地址，用于PC平台的播放 请替换成实际可用的播放地址
					<?php
						}
					?>
					"autoplay" : false,      //iOS下safari浏览器，以及大部分移动端浏览器是不开放视频自动播放这个能力的
					<?php
						if($res['playBgFile']!='')
						{
					?>
					"coverpic" : "<?php echo base_url().$res['playBgFile'];?>",
					<?php
						}
					?>
					"width" :  '391',//视频的显示宽度，请尽量使用视频分辨率宽度
					"height" : '225',//视频的显示高度，请尽量使用视频分辨率高度
					"wording": {
							1002: "请确认已经开始直播，谢谢您的观看"
						}
					});
                 </script> 
                 </span>
                 
            
                </td>
              </tr>
              <tr>
                <td height="40" align="center" valign="middle"><strong>直播推流地址（HLS模式）</strong></td>
              </tr>
              <tr>
                <td height="40" align="center" valign="middle" style="padding-bottom:20px;"><input type="text" style="width:70%; padding-left:2%; padding-right:2%; border:#CCC 1px solid; line-height:30px; border-radius:5px;" value="<?php echo $res['pushUrl']==''?'未设置':$res['pushUrl'];?>" id="copy_value" readonly="readonly" /> &nbsp;&nbsp; <a href="javascript:copyToClipboard('<?php echo $res['pushUrl']==''?'未设置':$res['pushUrl'];?>');" id='copy' style="width:40px; font-size:12px; text-align:center; display:inline-block; line-height:22px; border-radius:3px; border:#1859a5 1px solid;color:#1859a5;">复制</a></td>
              </tr>
            </table></td>
            <td width="53%" align="left" valign="top"><table width="524" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="533" height="30" align="left" valign="middle" style="padding-top:15px;"><strong style="font-size:16px;">话题互动</strong> <span style="float:right;"><input type="checkbox" name="insertState" onclick="ajaxEditCheckBox(1);" <?php if($res['insertState']==1){?> checked="checked"<?php }?>  /> 允许用户发表 &nbsp;&nbsp;<input type="checkbox" name="replyState" onclick="ajaxEditCheckBox(2);" <?php if($res['replyState']==1){?> checked="checked"<?php }?>  /> 允许用户回复 &nbsp;&nbsp;<input type="checkbox" name="checkState" onclick="ajaxEditCheckBox(3);" <?php if($res['checkState']==1){?> checked="checked"<?php }?>  /> 发送内容需审核 &nbsp;&nbsp; <a href="javascript:clearComments('<?php echo $res['id'];?>');" style="width:40px; font-size:12px; text-align:center; display:inline-block; line-height:22px; border-radius:3px; border:#cc0000 1px solid;color:#cc0000;">清空</a></span></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px dotted;"></div></td>
              </tr>

              <tr>
                <td align="left" valign="middle">
                <div class="topBar">
                	<ul>
                    	
                    	<li class="actived" id="select_1"><a href="javascript:readSelect(1);">全部(<span id="allNums">--</span>)</a></li>
                        <li id="select_2"><a href="javascript:readSelect(2);">已通过(<span id="passNums">--</span>)</a></li>
                        <li id="select_3"><a href="javascript:readSelect(3);">未通过(<span id="nopassNums">--</span>)</a></li>
                    </ul>
                </div>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top">
                	<div style="width:100%; float:left; overflow:auto;height:400px;" class="indexListScroll">
                    	<div style="width:100%; float:left; height:auto;" id="contentsList">
                        	
                        </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td align="left" valign="middle">
                <div style="width:100%; float:left; padding-top:10px; border-top:#e4e4e4 1px solid;">
                	<textarea style="width:96%; border:#e4e4e4 1px dotted;outline:none;height:50px;padding-left:2%;padding-right:2%; font-family:'微软雅黑'; line-height:23px; resize:none;" placeholder="请输入..." id="sayText" name="sayText" onKeyUp="checkCommentsLength();"></textarea>
                </div>
                </td>
              </tr>
              
              
              <tr>
                <td height="60" align="left" valign="middle"><a href="javascript:editAvatar();" style="background:url(<?php echo $res['avatar']==''?'/assets/admin/images/defaultAvatar.jpg':'/'.$res['avatar'];?>) no-repeat; background-size:100%; width:30px; height:30px; display:inline-block;line-height:30px;font-size:16px" id="avatarSay">&nbsp;</a>
                &nbsp;
               
                <div class="faceDiv">
                	<ul>
                    <?php
                    	for($a=1;$a<=75;$a++)
						{
					?>
                    	<li><img src="/assets/images/face/em_<?php echo $a;?>.png" onClick="inserttag('[em_<?php echo $a;?>',']');"  /></li>
                    <?php
						}
					?>
                    </ul>
                </div>
                
                <div style="width:300px; height:auto; padding-top:10px; padding-bottom:10px; padding-left:5px;position:absolute;z-index:3; border:#e4e4e4 1px solid; background:#FFF; border-radius:5px; margin-top:5px; display:none;" id="fileInners">
                	
                </div>
                
                <a href="javascript:showFace();" style="background-size:100%; width:27px; height:27px; line-height:30px; color:#ccc; display:inline-block; border-radius:3px; border:#ccc 1px solid;font-size:16px; text-align:center;">☺</a>
                &nbsp;
                <a href="javascript:chooseImgItem();" style="background-size:100%; width:27px; height:27px; line-height:30px; color:#ccc; display:inline-block; border-radius:3px;border:#ccc 1px solid;font-size:16px; text-align:center;" id="uploadBtn">✚</a>
 				 
                 <iframe id="tarGet" name="tarGet" src="" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>
                    <form id="form" name="form" action="<?php echo admin_url();?>uploads/index" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet" style="display:none;">
                    <span  id="fileInner">
                  <input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />
                  </span>
                  </form>
                 
                 <span style="float:right;"><a href="javascript:sendComments();" style="width:auto; padding-left:25px; padding-right:25px; line-height:28px; background:#09C;color:#fff; text-align:center; display:inline-block; border-radius:4px;"> 发 送 </a></span></td>
              </tr>
            </table></td>
            </tr>
            
            
        </table>

    </div>
<style>
.faceDiv{position:absolute;z-index:2; height:auto; width:300px; border:#CCC 1px solid; border-radius:2px; background:#FFF; margin-top:-340px; margin-left:42px; display:none;}
.faceDiv ul{padding:0; margin:0; padding-top:5px;}
.faceDiv ul li{float:left; height:auto; line-height:35px;}
.faceDiv ul li img{width:20px; margin-left:5px; margin-right:5px; height:20px; margin-top:5px; cursor:pointer;}

.topBar{width:100%; float:left; border-bottom:#e4e4e4 1px solid; text-align:left;}
.topBar ul{padding:0; margin:0}
.topBar li{float:left;}
.topBar li a{width:auto; padding-left:20px; padding-right:20px; line-height:30px; display:inline-block;}
.topBar li a:hover{text-decoration:none;}
.topBar .actived a{width:auto; padding-left:20px; padding-right:20px; line-height:30px; display:inline-block; border-bottom:#1859a5 2px solid;font-weight:bold;}
.bigimg{width:600px;position: fixed;left: 0;top: 0; right: 0;bottom: 0;margin:auto;display: none;z-index:9999;border: 10px solid #fff;}
.mask{position: fixed;left: 0;top: 0; right: 0;bottom: 0;background-color: #000;opacity:0.7;filter: Alpha(opacity=70);z-index: 100;transition:all 1s;display: none}
.bigbox{width:840px;background: #fff;border:1px solid #ededed;margin:0 auto;border-radius: 10px;overflow: hidden;padding:10px;}
.bigbox>.imgbox{width:400px;height:250px;float:left;border-radius:5px;overflow: hidden;margin: 0 10px 10px 10px;}
.bigbox>.imgbox>img{width:100%;}
.imgbox:hover{cursor:zoom-in}
.mask:hover{cursor:zoom-out}
.mask>img{position: fixed;right:10px;top: 10px;width: 60px;}
.mask>img:hover{cursor:pointer}
.sodo img,.contentsRe img{width:30px;height:30px; margin-top:5px; margin-right:5px;}
</style>    
    </td>
  </tr>
</table>


<img src="" alt="" class="bigimg">
<div class="mask">
	<img src="<?php echo base_url();?>assets/images/close.png" alt="点击关闭">
</div>
<?php
	require VIEWPATH.'admins/bottom.php';
?>

<script>
	//swoole程序开始
	var ws;
	<?php
		//if(!isset($_SESSION['swooleAdminID']))
		//{
			//$_SESSION['swooleAdminID']='Date_'.date('Ymd').'_'.date('YmdHis').substr(microtime(),2,8).mt_rand(10000000,99999999);	
		//}
		$hash=create_sockets(2);
		$hash='jason2YU_'.$hash;
	?>
	var xiushi=true;
	var liveState='<?php echo $res['state'];?>';
	var mvId='<?php echo intval($this->uri->segment(4));?>';
	var wsConnects=true;
	function swooleLink()
	{
		ws = new WebSocket("ws://39.106.9.165:9502?token=<?php echo $hash;//$_SESSION['swooleAdminID'];?>");//连接服务器
		ws.onopen = function(event){
			swooleState=true;
			console.log(event);
		};
	
		ws.onmessage = function (event)
		{
			//根据接收的数据做相关对应处理
			console.log(event);
			var data=event.data;
			console.log(data);
			if(data.indexOf('A_')>=0)
			{
				//合法数据，根据对应值做相对应的处理
				var ask=data.split('A_');
				var projectId=parseInt(ask[0]);
				if(projectId==mvId)
				{
					
					var state=data.split('_');
					state[1]=parseInt(state[1]);
					console.log(state);
					if(state[1]==1)
					{
						//新消息过来了
						getNums();
						getTopsAll();		
					}
					else if(state[1]==2)
					{
						//新回复消息过来了
						var id=parseInt(state[2]);
						getNums();
						if($('.listComment_' + id).length>0)
						{
							//加载对应的回复信息那条数据，然后成功就替换掉数据
							getItemOne(id);	
						}	
	
					}
				}
			}
			else if(data.indexOf('B_')>=0)
			{
				//合法数据，根据对应值做相对应的处理
				var ask=data.split('B_');
				var projectId=parseInt(ask[0]);
				if(projectId==mvId)
				{
					var state=data.split('_');
					state[1]=parseInt(state[1]);
					if(state[1]==1)
					{
						//删除了某条信息
						id=parseInt(state[2]);
						if($('.listComment_' + id).length>0)
						{
							$('.listComment_' + id).remove();	
						}
						getNums();
					}	
					else if(state[1]==2)
					{
						//删除了某条信息下的消息
						id=parseInt(state[2]);
						if($('#Re_' + id + '_' + state[3]).length>0)
						{
							$('#Re_' + id + '_' + state[3]).remove();	
						}
						getNums();	
					}
					else if(state[1]==5 || state[1]==6)
					{
						//审核过了信息
						var id=parseInt(state[2]);
						getNums();
						if($('.listComment_' + id).length>0)
						{
							//加载对应的回复信息那条数据，然后成功就替换掉数据
							getItemOne(id);	
						}	
					}
					else if(state[1]==3 || state[1]==4 || state[1]==7)
					{
						//置顶操作
						pageIndex=1;
						minId=0;
						maxId=0;
						scrollState=true;
						xiushi=false;
						//$('#contentsList').html("");
						pageRead();
					}
					else if(state[1]==8)
					{
						//直播开启
						$('#liveState').html('<a href="javascript:closeLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">关闭直播服务</a>');	
						
						
						liveState=2;
						///alert('做点开启直播的事情');
						$('#noPlayInner').hide();
						$('#PlayInner').show();
						player.pause();
					}
					else if(state[1]==9)
					{
						//直播关闭
						$('#liveState').html('<a href="javascript:openLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">开启观看页面直播</a>');	
						
						liveState=1;
						closeTestLives();
						//alert('做点关闭直播的事情');
						$('#noPlayInner').show();
						$('#PlayInner').hide();
						player.pause();
					}
					else if(state[1]==18)
					{
						//浏览器新增多个连接
						wsConnects=false;
						//console.log("被通知到整改了");	
					}
				}
			}
		}
		
							
	
		ws.onclose = disConnect;

		
		ws.onerror = function(event){
			
		};
	}
	
	function reConnect()
	{
		clearTimeout(connectDo);
		ws = new WebSocket("ws://39.106.9.165:9502?token=<?php echo $hash;//$_SESSION['swooleAdminID'];?>");//连接服务器
		ws.onopen = function(event){
			swooleState=true;
			console.log(event);
		};
	
		ws.onmessage = function (event)
		{
			//根据接收的数据做相关对应处理
			//console.log(event);
			var data=event.data;
			console.log(data);
			if(data.indexOf('A_')>=0)
			{
				//合法数据，根据对应值做相对应的处理
				var ask=data.split('A_');
				var projectId=parseInt(ask[0]);
				if(projectId==mvId)
				{
					
					var state=data.split('_');
					state[1]=parseInt(state[1]);
					console.log(state);
					if(state[1]==1)
					{
						//新消息过来了
						getNums();
						getTopsAll();		
					}
					else if(state[1]==2)
					{
						//新回复消息过来了
						var id=parseInt(state[2]);
						getNums();
						if($('.listComment_' + id).length>0)
						{
							//加载对应的回复信息那条数据，然后成功就替换掉数据
							getItemOne(id);	
						}	
	
					}
				}
			}
			else if(data.indexOf('B_')>=0)
			{
				//合法数据，根据对应值做相对应的处理
				var ask=data.split('B_');
				var projectId=parseInt(ask[0]);
				if(projectId==mvId)
				{
					var state=data.split('_');
					state[1]=parseInt(state[1]);
					if(state[1]==1)
					{
						//删除了某条信息
						id=parseInt(state[2]);
						if($('.listComment_' + id).length>0)
						{
							$('.listComment_' + id).remove();	
						}
						getNums();
					}	
					else if(state[1]==2)
					{
						//删除了某条信息下的消息
						id=parseInt(state[2]);
						if($('#Re_' + id + '_' + state[3]).length>0)
						{
							$('#Re_' + id + '_' + state[3]).remove();	
						}
						getNums();	
					}
					else if(state[1]==5 || state[1]==6)
					{
						//审核过了信息
						var id=parseInt(state[2]);
						getNums();
						if($('.listComment_' + id).length>0)
						{
							//加载对应的回复信息那条数据，然后成功就替换掉数据
							getItemOne(id);	
						}	
					}
					else if(state[1]==3 || state[1]==4 || state[1]==7)
					{
						//置顶操作
						pageIndex=1;
						minId=0;
						maxId=0;
						scrollState=true;
						xiushi=false;
						//$('#contentsList').html("");
						pageRead();
					}
					else if(state[1]==8)
					{
						//直播开启
						$('#liveState').html('<a href="javascript:closeLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">关闭直播服务</a>');	
						liveState=2;
						///alert('做点开启直播的事情');
						$('#noPlayInner').hide();
						$('#PlayInner').show();
						player.pause();
					}
					else if(state[1]==9)
					{
						//直播关闭
						$('#liveState').html('<a href="javascript:openLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">开启观看页面直播</a>');	
						liveState=1;
						//alert('做点关闭直播的事情');
						$('#noPlayInner').show();
						$('#PlayInner').hide();
						player.pause();
					}
					else if(state[1]==18)
					{
						//浏览器新增多个连接
						wsConnects=false;
						//console.log("被通知到整改了");	
					}
				}
			}
		}
		
							
	
		ws.onclose = disConnect;

		
		ws.onerror = function(event){
			
		};			
	}
	
	var connectDo;
	var disConnect = function(){
		if(wsConnects)
		{
			connectDo=setTimeout(function(){
				reConnect();
			},4000);
		}
		else
		{
			swooleState=false;
			location='/noServer.html';
		}
	}
	
	$(function(){
		showBigImg();
		swooleLink();
		pageRead();	
		getNums();
		startNextPageInfo();
		clearErrorMsg();	
	});
	
	function clearErrorMsg()
	{
		if($('.vcp-error-tips').length>0)
		{
			$('.vcp-error-tips').html("");	
		}	
		setTimeout("clearErrorMsg()",100);
	}	
	
	//关闭直播
	function closeLives()
	{
		layer.confirm('您确定要关闭直播操作吗？', {
		  btn: ['是的','再想想'] //按钮
		}, function(){
		  closeLive();
		}, function(){
		  layer.closeAll();
		});		
	}
	
	function closeLive()
	{
		if(commentsLoad)
		{
			
			$.ajax({url:"<?php echo admin_url();?>projecteds/closeLive/<?php echo $res['id'];?>/", 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
		
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							ws.send(mvId + 'B_9');
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});				

		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}					
	}
	
	//开启或者关闭直播操作
	function openLives()
	{
		layer.confirm('您确定要开启直播操作吗？', {
		  btn: ['是的','再想想'] //按钮
		}, function(){
		  openLive();
		}, function(){
		  layer.closeAll();
		});			
	}
	
	//开启测试观看直播
	function openTestLives()
	{
		if(liveState==2)
		{
			layer.msg('已经开启全网直播，无法继续操作！');		
		}
		else
		{
		if(commentsLoad)
		{
			$.ajax({url:"<?php echo admin_url();?>projecteds/openTestLive/<?php echo $res['id'];?>/", 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
			
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							//开启直播
							$('#testLiveState').html('<a href="javascript:closeTestLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">关闭调试观看</a>');	
							$('#noPlayInner').hide();
							$('#PlayInner').show();
							player.pause();
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});
		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}
		}
	}
	
	function closeTestLives()
	{
		if(liveState==2)
		{
			layer.msg('已经开启全网直播，无法继续操作！');		
		}
		else
		{
		if(commentsLoad)
		{
			
			$.ajax({url:"<?php echo admin_url();?>projecteds/closeTestLive/<?php echo $res['id'];?>/", 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
		
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							$('#testLiveState').html('<a href="javascript:openTestLives();" style="width:auto; padding-left:11px; padding-right:11px; display:inline-block; line-height:28px; border-radius:5px; background:#fff;color:#333; margin-left:15px; border:#CCC 1px solid;font-size:12px;">开启调试观看</a>');
							$('#noPlayInner').show();
							$('#PlayInner').hide();
							player.pause();
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});				

		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}
		}		
	}
	
	function openLive()
	{
		if(commentsLoad)
		{
			
			$.ajax({url:"<?php echo admin_url();?>projecteds/openLive/<?php echo $res['id'];?>/", 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
		
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							ws.send(mvId + 'B_8');
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});				

		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}		
	}
	
	//清空评论信息
	function clearComments(id)
	{
		layer.confirm('您确定要清空所有数据吗？', {
		  btn: ['是的','再想想'] //按钮
		}, function(){
		  clearComment(id);
		}, function(){
		  layer.closeAll();
		});			
	}
	
	function clearComment(id)
	{
		if(commentsLoad)
		{
			
			$.ajax({url:"<?php echo admin_url();?>projecteds/clearComments/<?php echo $res['id'];?>/" + id, 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
		
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							ws.send(mvId + 'B_7');
							getNums();
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});				

		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}		
	}
	
	//获取单挑数据
	function getItemOne(id)
	{
		$.ajax({url:"<?php echo admin_url();?>projecteds/indexCommentsItem/<?php echo $res['id'];?>?id=" + id + '&selectId=' + selectId, 
		type: 'GET', 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){			
			},
			beforeSend:function(){
			},
			success:function(result){
				layer.closeAll();
				page_loads=true;
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				console.log(result);
				if(result=='')
				{
					$('.listComment_' + id).remove();			
				}	
				else
				{
					$('.listComment_' + id).html(result);	
				}
				sodoShowOrHide();
			} 
		});	
	}
	
	//获取最新加载的数据信息
	function getTopsAll()
	{
		$.ajax({url:"<?php echo admin_url();?>projecteds/indexCommentsNew/<?php echo $res['id'];?>?maxId=" + maxId + '&selectId=' + selectId, 
		type: 'GET', 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){			
			},
			beforeSend:function(){
			},
			success:function(result){
				layer.closeAll();
				page_loads=true;
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				if(result.indexOf("200|")==0 || result.indexOf("300|")==0)
				{
					var arr=result.split('|');
					layer.msg(arr[1]);
					if(arr[0]=="200")
					{
						setTimeout("location='<?php echo http_url();?>login.html'",1500);	
					}
				}
				else
				{
					if(result.indexOf("===Jason===")>=0)
					{
						var arr=result.split("===Jason===");	
						maxId=arr[2];	
						$('.topNew').remove();
						$('#topInner').after(arr[0]);
						//showBigImg();
					}
					else
					{
						layer.msg('数据读取错误，请您稍后再试！');			
					}	
				}				
			} 
		});				
	}
	
	function zanyizan(id)
	{
		if(commentsLoad)
		{
			
			$.ajax({url:"<?php echo admin_url();?>projecteds/zanyizan/<?php echo $res['id'];?>/" + id, 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
		
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							var zyz=parseInt($('#zyz_' + id).html())+1;
							$('#zyz_' + id).html(zyz);
							$('#zyz_' + id).css("font-weight","blod");
							$('#zyz_' + id).css("color","#cc0000");
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});				

		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}				
	}
	
	function delItem(id,nid)
	{
		if(commentsLoad)
		{
			
			$.ajax({url:"<?php echo admin_url();?>projecteds/delItem/<?php echo $res['id'];?>/" + id + '/' + nid, 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
		
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							ws.send(mvId + 'B_2_' + id + '_' + nid);
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});				

		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}		
	}
	
	function tongguoItem(id,nid)
	{
		if(commentsLoad)
		{
			
			$.ajax({url:"<?php echo admin_url();?>projecteds/tongguoItem/<?php echo $res['id'];?>/" + id + '/' + nid, 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					
					commentsLoad=true;
					layer.msg('网络故障，请您稍后再试！');			
				},
				beforeSend:function(){
					commentsLoad=false;	
								
				},
				success:function(result){
					
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");
		
					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]==100)
						{
							ws.send(mvId + 'B_6_' + id + '_' + nid);
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							layer.msg('登录状态已失效，请重新登录！');	
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						layer.msg('网络故障，请您稍后再试！');			
					}
			
				} 
			});				

		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}	
	}
	
	function sodoShowOrHide()
	{
		$(".sodo").mouseover(function(){
			$(this).find('span').show();
		});	
		$(".sodo").mouseout(function(){
			$(this).find('span').hide();
		});	
		$(".sodoRe").mouseover(function(){
			$(this).find('label').show();
		});	
		$(".sodoRe").mouseout(function(){
			$(this).find('label').hide();
		});
	}
	
	//swoole程序结束
	
	function readOneItem(id)
	{
		if($('.listComment_' + id).length>0)
		{
			//更新对应数据
			$.ajax({url:"<?php echo admin_url();?>projecteds/readOneItem/<?php echo $res['id'];?>/" + id, 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
				},
				beforeSend:function(){
								
				},
				success:function(result){
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result!='')
					{
						$('.listComment_' + id).html(result);	
					}
			
				} 
			});	
		}	
	}
	
	var nowId='';
	var cc='';
	function huifu(id,text)
	{
		$('#sayText').val(text);	
		nowId=id;
		cc=text;
		$('#uploadBtn').hide();
	}
	
	function checkCommentsLength()
	{
		var texter=$('#sayText').val().replace(/(^\s*)|(\s*$)/g,"");
		if(cc!='' && texter=='')
		{
			nowId='';
			cc='';
			$('#uploadBtn').show();
		}	
		
	}
	
	//提交评论内容
	var commentsLoad=true;
	function sendComments()
	{
		if(commentsLoad)
		{
			var fileParams=new Object();
			var i=0;
			$("#fileInners a").each(function(){
				fileParams[i]=$(this).find('.uploadFileValue').val();
				i=parseInt(i)+1;
			});	
			//console.log(fileParams);
			var textSay=$('#sayText').val().replace(/(^\s*)|(\s*$)/g,"");
			if(textSay=='')
			{
				layer.msg('您要说点什么呢？');	
			}
			else if(textSay.length<=0 || textSay.length>500)
			{
				layer.msg('内容长度请控制在1-500字之间');		
			}
			else if(textSay.split('||||')>=0)
			{
				layer.msg('内容不要填写非法字符');	
			}
			else
			{
				$.ajax({url:"<?php echo admin_url();?>projecteds/insertComments/<?php echo $res['id'];?>/", 
				type: 'POST',
				data:{textSay:textSay,fileAll:JSON.stringify(fileParams),nowId:nowId}, 
				dataType: 'html', 
				timeout: 15000, 
					error: function(){
						
						commentsLoad=true;
						layer.msg('网络故障，请您稍后再试！');			
					},
					beforeSend:function(){
						commentsLoad=false;	
									
					},
					success:function(result){
						
						commentsLoad=true;
						
						result=result.replace(/(^\s*)|(\s*$)/g,"");
						console.log(100);
						if(result.indexOf("|")>=0)
						{
							var arr=result.split('|');
							
							if(arr[0]==100)
							{
								layer.msg('发布成功');
								$('#sayText').val("");	
								$('#fileInners').html("");
								ws.send(mvId + 'A_1');
								if(arr[1].indexOf("++++")<0)
								{
									
									ws.send(mvId + 'B_5_' + arr[1]);
								}
								else
								{
							
									var as=arr[1].split("++++");
									ws.send(mvId + 'B_6_' + as[0]);//推送审核小评论模式	
								}
								$('#uploadBtn').show();
							}	
							else if(arr[0]==200)
							{
								//登录失败，弹出盒子	
								layer.msg('登录状态已失效，请重新登录！');	
								setTimeout("location='<?php echo http_url();?>login.html'",1500);	
							}
							else if(arr[0]==300 && arr[1].indexOf("图片上传失败")>=0)
							{
								layer.msg(arr[1]);
								$('#fileInners').html("");	
							}
						}
						else
						{
							layer.msg('网络故障，请您稍后再试！');			
						}
				
					} 
				});				
			}
		}	
		else
		{
			layer.msg("其他信息正在提交中，请稍等...");	
		}	
	}
	
	function shenhe(id)
	{
		if(form_loads==1)
		{
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/shenhe/<?php echo $res['id'];?>/" + id, 
			type: 'GET', 
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
							ws.send(mvId + 'B_5_' + id);
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

	function del(id)
	{
		if(form_loads==1)
		{
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/cdel/<?php echo $res['id'];?>/" + id, 
			type: 'GET', 
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
							ws.send(mvId + 'B_1_' + id);
							
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
	
	function ding(id)
	{
		if(form_loads==1)
		{
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/ding/<?php echo $res['id'];?>/" + id, 
			type: 'GET', 
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
							ws.send(mvId + 'B_3_' + id);
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
	
	function noDing(id)
	{
		if(form_loads==1)
		{
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/noding/<?php echo $res['id'];?>/" + id, 
			type: 'GET', 
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
							ws.send(mvId + 'B_4_' + id);
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
	
	function jinyan(id)
	{
		if(form_loads==1)
		{
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/jinyan/<?php echo $res['id'];?>/" + id, 
			type: 'GET', 
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
	
var fileParams=new Array();
function chooseImgItem()
{
	$('#file').click();	
}

var fileId=1;
var filePutValue='';
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
			$('#fileInner').html('<input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />');
			var timestamp1 = Date.parse(new Date());
			$("#fileInners").show();
			$("#fileInners").append('<a id="filePut_' + fileId + '" href="javascript:delImg(\'' + fileId + '\',\'' + arr[1] + '\')"><img src="/' + arr[1] + '" style="width:30px;height:30px;border:#CCC 1px dotted;margin-left:10px;" /><input type="hidden" class="uploadFileValue" value="' + arr[1] + '"></a>');
			if(filePutValue=='')
			{
				filePutValue=arr[1];	
			}
			else
			{
				filePutValue=filePutValue + ',' + arr[1];			
			}
			fileId=parseInt(fileId)+1;
			
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

//删除图片
function delImg(id,url)
{
	$("#filePut_" + id).remove();
	if(filePutValue.indexOf(",")>=0)
	{
		var reValue='';
		arr=filePutValue.split(",");
		for(var i=0;i<arr.length;i++)
		{
			if(arr[i]!=url)
			{
				if(reValue=='')
				{
					reValue=arr[i];		
				}	
				else
				{
					reValue=reValue + ',' + arr[i];	
				}
			}	
		}
		filePutValue=reValue;	
	}
	else
	{
		filePutValue='';	
	}
	if(filePutValue=='')
	{
		$("#fileInners").hide();	
	}
	//console.log(filePutValue);
	//ajax发送一个删除请求
	$.ajax({url:"<?php echo admin_url();?>projecteds/indexUploadFileDel/<?php echo $res['id'];?>?url=" + url, 
	type: 'GET', 
	dataType: 'html', 
	timeout: 15000, 
		success:function(result){
			
		} 
	});		
}     

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

function copyToClipboard (text) {
    if(text.indexOf('-') !== -1) {
        let arr = text.split('-');
        text = arr[0] + arr[1];
    }
    var textArea = document.createElement("textarea");
      textArea.style.position = 'fixed';
      textArea.style.top = '0';
      textArea.style.left = '0';
      textArea.style.width = '2em';
      textArea.style.height = '2em';
      textArea.style.padding = '0';
      textArea.style.border = 'none';
      textArea.style.outline = 'none';
      textArea.style.boxShadow = 'none';
      textArea.style.background = 'transparent';
      textArea.value = text;
      document.body.appendChild(textArea);
      textArea.select();

      try {
        var successful = document.execCommand('copy');
        var msg = successful ? '成功复制到剪贴板' : '该浏览器不支持点击复制到剪贴板';
       layer.msg(msg);
      } catch (err) {
        layer.msg('该浏览器不支持点击复制到剪贴板');
      }

      document.body.removeChild(textArea);
}
</script>
<script>
	var form_loads=1;

	//更新评论回复配置
	function ajaxEditCheckBox(id)
	{
		if(form_loads==1)
		{

			if(id==1)
			{
				var s_group = document.getElementsByName("insertState");
				var filed='insertState';	
			}
			else if(id==2)
			{
				var s_group = document.getElementsByName("replyState");	
				var filed='replyState';
			}
			else if(id==3)
			{
				var s_group = document.getElementsByName("checkState");	
				var filed='checkState';
			}
			var value=2;
			for(var i = 0; i< s_group.length; i++){
				if(s_group[i].checked==true){
					value=1;
				}
			}
			//提交数据
			layer.closeAll();
			form_loads=2;	
			$.ajax({url:"<?php echo admin_url();?>projecteds/indexEdit/<?php echo $res['id'];?>?act=1", 
			type: 'POST', 
			data:{filed:filed,value:value}, 
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
	
	//修改头像
	function editAvatar()
	{
		layer.open({
		  type: 2,
		  title: '编辑',
		  shadeClose: true,
		  shade: 0.9,
		  area: ['480px', '350px'],
		  content: '<?php echo admin_url();?>projecteds/indexAvatar/<?php echo $res['id'];?>.html' //iframe的url
		});		
	}
	
	var num_loads=true;
	//获取评论数量统计
	function getNums()
	{
		if(num_loads)
		{
			$.ajax({url:"<?php echo admin_url();?>projecteds/indexCommentsNums/<?php echo $res['id'];?>", 
			type: 'GET', 
			dataType: 'json', 
			timeout: 15000, 
				error: function(){
					num_loads=true;
					layer.msg('数据读取错误，请您稍后再试！');				
				},
				beforeSend:function(){
					num_loads=false;						
				},
				success:function(result){
					num_loads=true;
					if(typeof result.code != 'underfined')
					{
						
						if(parseInt(result.code)==100)
						{
							$("#allNums").html(result.alls);
							$("#passNums").html(result.pass);
							$("#nopassNums").html(result.nopass);
						}	
						else if(parseInt(result.code)==200)
						{
							layer.msg(result.message);
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
						else if(parseInt(result.code)==300)
						{
							layer.msg(result.message);
						}
						else
						{
							layer.msg('数据读取错误，请您稍后再试！');	
						}
					}	
					else
					{
						layer.msg('数据读取错误，请您稍后再试！');
					}
				} 
			});						
		}
	}
	
	//定义默认当前页
	var pageIndex=1;
	//定义一个ajax句柄变量，强控线控
	var page_loads=true;
	//读取最后获取时间节点
	var minId=0;
	var maxId=0;
	//设置下拉状态
	var scrollState=true;
	
	//切换查阅信息
	var selectId=1;
	function readSelect(id)
	{
		if(selectId!=id)
		{
		   $("#select_" + selectId).attr('class',''); 
		   $("#select_" + id).attr('class','actived');
		   selectId=id;
		   pageIndex=1;
		   minId=0;
		   maxId=0;
		   scrollState=true;
		   $('#contentsList').html("");
		   pageRead();
		}
	}	
	
	var scrollerState=true;
	//开始读取对应的下一页数据操作
	function startNextPageInfo(){

		$('.indexListScroll').scroll(function () {
			var scrollTop = $(".indexListScroll").scrollTop();
			var scrollHeight = $(".indexListScroll").height();
			var windowHeight = $("#contentsList").height();
			//console.log(scrollTop + '____' + scrollHeight + '______' + windowHeight);
			if(scrollTop + scrollHeight == windowHeight)
			{
				
				//开始加载下一页数据
				if(scrollState)
				{
					pageRead();
					//console.log('执行');
				}
			}
		});		
	}	
	
	//获取翻页信息
	function pageRead()
	{
		if(page_loads && scrollState)
		{
			$.ajax({url:"<?php echo admin_url();?>projecteds/indexComments/<?php echo $res['id'];?>?minId=" + minId + '&selectId=' + selectId + '&maxId=' + maxId, 
			
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.closeAll();
					page_loads=true;
					layer.msg('数据读取错误，请您稍后再试！');				
				},
				beforeSend:function(){
					/*var index = layer.load(1, {
						shade: [0.5,'#000'] //0.1透明度的白色背景
					});*/
					page_loads=false;						
				},
				success:function(result){
					layer.closeAll();
					page_loads=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf("200|")==0 || result.indexOf("300|")==0)
					{
						var arr=result.split('|');
						layer.msg(arr[1]);
						if(arr[0]=="200")
						{
							setTimeout("location='<?php echo http_url();?>login.html'",1500);	
						}
					}
					else
					{
						if(result.indexOf("===Jason===")>=0)
						{
							var arr=result.split("===Jason===");	
							minId=arr[1];	
							maxId=arr[2];
							//console.log(arr[0]);	
							if(arr[0].replace(/(^\s*)|(\s*$)/g,"")=='')
							{
								scrollState=false;	
							}
							else
							{
								
								
								if(!xiushi)
								{
									xiushi=true;	
									$('#contentsList').html("");
								}
								$('#contentsList').append(arr[0]);
								//showBigImg();
							}
								
						}
						else
						{
							layer.msg('数据读取错误，请您稍后再试！');			
						}	
					}				
				} 
			});	
		}	
	}

	
	function editNickName(code,msg)
	{
		layer.closeAll();
		if(code==100)
		{
			layer.msg('设置成功');		
			if(msg!='')
			{
				//设置一下对应的头像信息
				$("#avatarSay").css("background","url('/" + msg + "')");
				$("#avatarSay").css("background-size","100%");	
			}
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
	
	function inserttag(topen,tclose)
	{
		$('.faceDiv').hide();
		var themess = document.getElementById('sayText');
		themess.focus();
		if (document.selection) {
		var theSelection = document.selection.createRange().text;
		if(theSelection){
		document.selection.createRange().text = theSelection = topen+theSelection+tclose;
		}else{
		document.selection.createRange().text = topen+tclose;
		}
		theSelection='';
		
		}else{
		
			var scrollPos = themess.scrollTop;
			var selLength = themess.textLength;
			var selStart = themess.selectionStart;
			var selEnd = themess.selectionEnd;
			if (selEnd <= 2)
			selEnd = selLength;
			
			var s1 = (themess.value).substring(0,selStart);
			var s2 = (themess.value).substring(selStart, selEnd);
			var s3 = (themess.value).substring(selEnd, selLength);
			
			themess.value = s1 + topen + s2 + tclose + s3;
			
			themess.focus();
			themess.selectionStart = newStart;
			themess.selectionEnd = newStart;
			themess.scrollTop = scrollPos;
			
			return;
		}
	}	
	
	function showFace()
	{
		$('.faceDiv').show();	
	}	

	$(document).bind("click",function(e){ 
		var target = $(e.target); 
		if(target.closest(".faceDiv").length==0){ 
			$(".faceDiv").hide(); 
		} 
	});
	$(document).bind("click",function(e){ 
		var target = $(e.target); 
		if(target.closest("#fileInner").length==0){ 
			$("#fileInner").hide(); 
		} 
	});
</script>
</body>
</html>