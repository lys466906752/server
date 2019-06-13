<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="renderer" content="webkit"> 
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title><?php echo $res['name'];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/style.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/layer_pc/layer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zoom.js"></script>
<!-- 引入播放器 css 文件 -->
<link rel="stylesheet" href="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.css" rel="stylesheet">
<!-- 如需在IE8、9浏览器中初始化播放器，浏览器需支持Flash并在页面中引入 -->
<!--[if lt IE 9]>
<script src="//imgcache.qq.com/open/qcloud/video/tcplayer/ie8/videojs-ie8.js"></script>
<![endif]-->
<!-- 引入播放器 js 文件 -->
<script src="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.min.js"></script>
<!-- 示例 CSS 样式可自行删除 -->

<script>
	var Domains="<?php echo http_url().'m/index/'.$res['id'].'.html';?>";
	//手机适配
	if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
	try{
		if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
			window.location.href= Domains;
		}
	}catch(e){}
	}
</script>
<?php
	//设置一下背景颜色
	if($res['backColor'])
	{
?>
<style>
.zb_box{background:<?php echo $res['backColor'];?>}
</style>
<?php
	}
?>
</head>
<body>    
                   
<div class="zb_box">
<div class="banner_bg"> <img src="<?php echo isset($res['bgFile']) && $res['bgFile']!=''?base_url().$res['bgFile']:base_url().'assets/images/2.jpg';?>"/> </div>
<div class="container">
		<div class="cont_top"> 
				<img src="<?php echo isset($res['logo']) && $res['logo']!=''?base_url().$res['logo']:base_url().'assets/images/f9.png';?>" alt="" />
				<div class="cont_top_2"> <span><?php echo $res['name'];?></span>
						<div> 
                        <?php
                        	if($res['playNumsState']==2)
							{
						?>
                        <span><img src="<?php echo base_url();?>assets/images/3.png"/><i id="nowAtHere">--</i></span>
                       	<?php
							}
						?>
                        		<?php
                                	if($res['shareState']==2)
									{
								?>
								<div class="share"><img src="<?php echo base_url();?>assets/images/4.png"/><i>分享</i>
										<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a></div>
										<script>
										window._bd_share_config={
											"common":{
												"bdSnsKey":{},
												"bdText":"<?php echo $res['shareTitle'];?>",
												"bdDesc":"<?php echo $res['shareContents'];?>",
												"bdUrl":"<?php echo http_url();?>play/item/<?php echo $res['id'];?>.html",
												"bdPic":"<?php echo base_url().$res['logo'];?>",
												"bdMini":"2",
												"bdMiniList":false,
												"bdPic":"",
												"bdStyle":"1",
												"bdSize":"24"
											},
											"share":{},
										};
										with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)
										];
										</script> 
								</div>
                                <?php
									}
								?>
						</div>
				</div>
                <?php
                	if($res['mobileCodeShow']==2)
					{
				?>
				<div class="cont_top_3">
					<!--<a><img src="images/5.png" /><span>门户</span></a>-->
					<a class="cont_top_3a2"><img src="<?php echo base_url();?>assets/images/6.png" /><span>手机观看</span></a>
					<img src="<?php echo http_url();?>play/phoneShowCode/<?php echo $res['id'];?>" />
				</div>
                <?php
                	}
				?>
		</div>
		<div class="cont_banner">
        	<label id="StartInner">
            	<div id="id_junyi_video" style="width:100%; height:auto;"></div>
				<?php
					if($res['state']==2 && $res['playUrl']!='')
					{
				?>
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
						"autoplay" : <?php echo $res['state']==2?'true':'false';?>,      //iOS下safari浏览器，以及大部分移动端浏览器是不开放视频自动播放这个能力的
						<?php
							if($res['playBgFile']!='')
							{
						?>
						"coverpic" : "<?php echo base_url().$res['playBgFile'];?>",
						<?php
							}
						?>
						"width" :  '865',//视频的显示宽度，请尽量使用视频分辨率宽度
						"height" : '585'//视频的显示高度，请尽量使用视频分辨率高度
						});							
		
                 </script> 
				 <?php
					}
				 ?>
            </label>
            

			<img src="<?php echo $res['playBgFile']==''?base_url().'assets/images/8.gif':base_url().$res['playBgFile'];?>" id="noStartInner" />
			<div class="daojitime">
				<h2>剩余时间为：</h2> 
			   <div id = "timer"> 
			   </div> 
			</div>

            <?php
            	if($res['gongzhonghaoState']==2)
				{
			?>
			<div class="guanzhu">
				<a><img src="<?php echo base_url();?>assets/images/10.png" /> 关 注</a> 
			</div>
            <?php
				}
			?>
            
            <?php
            	if($res['gongzhonghaoState']==2)
				{
			?>
			<div class="weixin" <?php echo $res['gongzhonghaoShow']==2?'style="display:block;"':'style="display:none;"';?>>
					<p class="wx_p1"><?php echo $res['name'];?></p>
					<img src="<?php echo isset($res['gongzhonghaoFile']) && $res['gongzhonghaoFile']!=''?base_url().$res['gongzhonghaoFile']:base_url().'assets/images/9.png';?>" />
					<p class="wx_p2">扫描关注公众号</p>
					<span>X</span>
				</div>
            <?php
				}
			?>
		</div> 
        
		<?php
            //先设置一个默认的数组，用来做冒泡排序
            $_arr=[
                [
                    'id'=>1,
                    'name'=>$pother['fristName']==''?'暂未设置':$pother['fristName'],
                    'sort'=>$pother['frist'],
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
        ?>        
        
		<div class="cont_spans">
        	<?php
            	for($i=0;$i<count($_arr);$i++)
            	{
			?>
            <span><?php echo $_arr[$i]['name'];?></span>
            <?php
				}
			?>
			<!--<span><?php echo $pother['fristName'];?></span>
			<span><?php echo $pother['secondName'];?></span>
			<span><?php echo $pother['thirdName'];?></span>
			<span><?php echo $pother['fourthName'];?></span>-->
		</div>

		<div class="cont_cont">
		<?php
			$i=0;
        	require("pc".$_arr[$i]["id"].".php");
			$i=1;
			require("pc".$_arr[$i]["id"].".php");
			$i=2;
			require("pc".$_arr[$i]["id"].".php");
			$i=3;
			require("pc".$_arr[$i]["id"].".php");
		?>
		</div>
</div>
<div class="footer" <?php if(isset($res['bottomColor']) && $res['bottomColor']!=''){?>style="background-color:<?php echo $res['bottomColor'];?>"<?php }?>>
	<p><span><?php echo $res['bottomText'];?></span><a href="javascript:showLiLi();">12318 全国文化市场举报网站</a></p>
</div>
<a class="totop" href="javascript:scroll(0,0)"><img src="<?php echo base_url();?>assets/images/top.jpg" /></a>
</div>
<style>
#myListLoad{color:#999;}
</style>

<img src="" alt="" class="bigimg">
<div class="mask">
	<img src="<?php echo base_url();?>assets/images/close.png" alt="点击关闭">
</div>
<div id="tong"></div>
<div id="tongBg" onClick="closeTong();"></div>
<style>
#tong{width:630px; height:auto; position:fixed;z-index:911;display:none;}
#tongBg{position:fixed;background:#000000;filter:alpha(opacity=80);Opacity:0.8;width:2000px; height:1200px;left:0px;top:0px;z-index:910;display:none;}
#showFaceA{height:auto;}
</style>

	<script type="text/javascript">
			<?php
				if(!$this->userInfo)
				{
			?>
				var loginState=false;
			<?php
				}
				else
				{
			?>
				var loginState=true;
			<?php
				}
			?>
			var playNumsState=<?php echo $res['playNumsState'];//是否开启显示?>;
			var playNumsStateType=<?php echo $res['playNumsStateType'];//显示的人数形式?>;
			var playNumsSuccess=<?php echo $res['playNumsSuccess'];//显示实际人数的倍数?>;
			var playNumsDefaults=<?php echo $res['playNumsDefaults'];//默认多少人?>;
			
			function showLogin()
			{
				$('#loginDiv').show();
			}
			function closeLoginDiv()
			{
				$('#loginDiv').hide();
			}
			
			//获取当前在线人数操作
			function getOneline(people)
			{
				if(playNumsState==2 && $('#nowAtHere').length>0)
				{
					//做显示操作
					if(playNumsStateType==1)
					{
						var nums=parseInt(playNumsSuccess*people)+playNumsDefaults;	
						$('#nowAtHere').html(nums);		
					}	
					else
					{
						$('#nowAtHere').html(people);		
					}
				}
			}
			
			//显示表情
			function showFaceA()
			{
				$('#showFaceA').show();	
			}
		
			//监听发布区域表情消失
			var bindState=false;
			function bindFace()
			{

					$(document).bind("click",function(e){ 
						
						var target = $(e.target); 
						if(target.closest("#niLoginDiv").length==0){ 
							$("#loginDiv").hide(); 
						} 
						
						//alert(100);
						if(target.closest("#commentsHistoryInner").length==0 ){
							$(".smile_le").hide(); 
						}
		
						if(!loginState)
						{
							if(target.closest(".changeLg").length==0 && target.closest(".denglufs_dis").length==0 && target.closest(".first_dis").length==0 && target.closest(".biaoqing").length==0 && target.closest(".send").length==0 && target.closest(".giveUpa").length==0){ 
								$(".denglufs_dis").hide(); 
							}
						} 
						else
						{
							if(target.closest(".changeLg").length==0 && target.closest(".denglufs_dis").length==0 && target.closest(".first_dis").length==0){ 
								$(".denglufs_dis").hide(); 
							}	
						}
					});
				
			}
			
			
			function showBigImg()
			{
				/*
				smallimg   // 小图
				bigimg  //点击放大的图片
				mask   //黑色遮罩
				*/
				var obj = new zoom('mask', 'bigimg','smallimg');
				obj.init();	
			}
			
			function getPlayAddress()
			{
				$.ajax({url:apiUrl + "cnzz/address/" + mvId, 
				type: 'GET', 
				dataType: 'html', 
				timeout: 15000, 
					error: function(){	
					},
					beforeSend:function(){						
					},
					success:function(result){	
					} 
				});					
			}
						
			function randomer(lower, upper) {
				return Math.floor(Math.random() * (upper - lower)) + lower;
			}

			var playTimeSet;
			var playTimeSetAll=<?php echo $res['state']==2?"true":"false";?>;		
	
			function getPlayTime(times)
			{
				$.ajax({url:apiUrl + "cnzz/play/" + mvId + '?addTime=' + times, 
				type: 'GET', 
				dataType: 'html', 
				timeout: 15000, 
					error: function(){	
						var times=parseInt(randomer(3,8));
						clearTimeout(playTimeSet);
						if(playTimeSetAll)
						{
							playTimeSet=setTimeout("getPlayTime(" + times + ")",times*1000);
						}
					},
					beforeSend:function(){						
					},
					success:function(result){	
						var times=parseInt(randomer(3,8));
						clearTimeout(playTimeSet);
						if(playTimeSetAll)
						{
							playTimeSet=setTimeout("getPlayTime(" + times + ")",times*1000);
						}
					} 
				});					
			}
			
			function clearErrorMsg()
			{
				if($('.vcp-error-tips').length>0)
				{
					$('.vcp-error-tips').html("");	
				}	
				setTimeout("clearErrorMsg()",100);
			}
		
			$(function(){
				clearErrorMsg();
				showBigImg();
				bindFace();
				getPlayAddress();
				var timeSub=parseInt(randomer(3,8));
				getPlayTime(timeSub);
				//分享
				$(".bdsharebuttonbox").hide();
				$(".share").hover(function(){
					$(".bdsharebuttonbox").show();
				},function(){
					$(".bdsharebuttonbox").hide();
				})
				//头部二维码
				$(".cont_top_3>img").hide();
				$(".cont_top_3a2 img").hover(function(){
					$(".cont_top_3>img").show();
					},function(){
						$(".cont_top_3>img").hide();
					})
				//中间关注弹窗微信二维码 
				$(".guanzhu a").click(function(){
					$(".weixin").show();
					})
				$(".weixin span").click(function(){
					$(".weixin").hide();
					})
				//切换
				$(".cont_spans span:eq(0)").addClass("ons");
				$(".cont_cont .contqh:gt(0)").hide();
				$(".cont_spans span").click(function(){
					$(this).addClass("ons").siblings("span").removeClass("ons");
					var cont_qhs=$(this).index();
					$(".cont_cont .contqh").eq(cont_qhs).show().siblings(".contqh").hide();
					if(document.getElementById("mvHistoryInner").style.display=='block' || document.getElementById("mvHistoryInner").style.display=='')
					{
						ajaxMvAllow=true;
					}
					else
					{
						ajaxMvAllow=false;	
					}
					if(document.getElementById("commentsHistoryInner").style.display=='block' || document.getElementById("commentsHistoryInner").style.display=='')
					{
						ajaxCommentsAllow=true;
					}
					else
					{
						ajaxCommentsAllow=false;	
					}
					
				})
				<?php
					if($res['state']==2)
					{
				?>
				$('#StartInner').show();
				$('#noStartInner').hide();
				$('.daojitime').hide();
				$('.weixin').hide();
				//player.play();
				<?php
					}
					else
					{
				?>
				$('#StartInner').hide();
				$('#noStartInner').show();
				<?php
					if($res['timeOverShow']==2)
					{
				?>
				$('.daojitime').show();
				<?php
					}
				?>
				//player.togglePlay();
				<?php
					}
				?>
				/*if(!loginState)
				{
					//登录弹窗提示 ;
					$(".first").click(function(){
						$(".denglufs").show();
						$(".denglufsp1 a").click(function(){
							$(".denglufs").hide();
						})
					})
				}
				$(".first_dis").click(function(){
					$(this).parent(".denglu_dis").siblings(".denglufs_dis").show(); 
					$(".denglufs_dis .denglufsp1 a").click(function(){
						$(".denglufs_dis").hide();
					})
				})*/
				

				//评论
				$(".discuss_pl").toggle(function(){
					$(this).parent().parent().siblings(".denglu_dis").show();
					$(this).find('textare').focus();
					
				},function(){
					 $(this).parent().parent().siblings(".denglu_dis").hide();
				})
				//zan

					//倒计时
									readComments();
					})
					
				//往期回顾
				function backHistoryShow()
				{
					$(".contqh4 li").hover(function(){
						$(this).find(".bofang_bg").show();
						$(this).siblings().find(".bofang_bg").hide();
					},function(){
						$(".contqh4 li").find(".bofang_bg").hide();
					})
				}
				

				function changeLogin()
				{
					$('#changeLogin').show();	
				}
				
				function closeLogin()
				{
					$('#changeLogin').hide();	
				}

				
				
	
	</script>
    <script>
    	//新方法
		var apiUrl='<?php echo http_url();?>';
		var mvId=<?php echo $res['id'];?>;
		var playState=false;//当前直播状态
		var swooleState=false;
		
		<?php
			//if(!isset($_SESSION['swooleFid']))
			//{
				//$_SESSION['swooleFid']='Date_'.date('Ymd').'_'.date('YmdHis').substr(microtime(),2,8).mt_rand(10000000,99999999);	
			//}
			//$hash=date('Ymd','1537233256').'_1';
			$hash=create_sockets(1).'_'.$res['id'].'_'.md5(mt_rand(100,999));
		?>
		var ws;
		var wser;
		var wsConnects=true;
		
		function swooleLink()
		{
			
			ws = new WebSocket("ws://39.106.9.165:9502?token=<?php echo $hash;//echo $_SESSION['swooleFid'];?>");//连接服务器
			
			ws.onopen = function(event){
				swooleState=true;
				console.log('open');
				console.log(event);
			};
		
			ws.onmessage = function (event)
			{
				//根据接收的数据做相关对应处理
				var data=event.data;
				console.log('one');
				console.log(data);
				if(data.indexOf('B_')>=0)
				{
					//合法数据，根据对应值做相对应的处理
					var ask=data.split('B_');
					var projectId=parseInt(ask[0]);
					
					if(projectId==mvId)
					{
						//同一个项目下的开始调用
						var state=data.split('_');
						state[1]=parseInt(state[1]);
						if(state[1]==1)
						{
							//删除了某条信息
							id=parseInt(state[2]);
							
							var topDing=$('#topDing').val();
							if(topDing!='' && topDing==id)
							{
								//是置顶的这条信息，做对应处理
								$('#topComments').html("");
								$('#topDing').val("");
								//更改下面的样式高度
								noPadding();
							}
							else
							{
								if($('#comments_' + id).length>0)
								{
									var dates=$('#comments_' + id).find('.datepick').val();	
									$('#comments_' + id).remove();
									
									showLiLi();
									
								}
							}
	
						}	
						else if(state[1]==2)
						{
							//删除了某条信息下的消息
							id=parseInt(state[2]);
							if($('#Re_' + id + '_' + state[3]).length>0)
							{
								$('#Re_' + id + '_' + state[3]).remove();
								var ints=parseInt($('#reply_' + id).html())-1;
								$('#reply_' + id).html(ints);
							}
	
						}
						else if(state[1]==7)
						{
							//清空数据操作，重新加载数据
							readCommentState=true;
							ajaxCommentsGet=true;
							commentsMinID=0;
							commentsMaxID=0;
							commentsDate='';
							indexPage=true;
							indexNumber=1;
							$('#commentsListAll').html("");
							readComments();
							
						}
						else if(state[1]==8)
						{
							//开启了直播
							setTimeout("location='<?php echo http_url();?>play/item/<?php echo $res['id'];?>.html'",5000);
						}
						else if(state[1]==9)
						{
							//alert("做点关闭直播的事情");
							$('#StartInner').hide();
							$('#noStartInner').show();
							player.togglePlay();
						}
						else if(state[1]==11)
						{
							//做人数的操作
							//alert("做点关闭直播的事情");
							getOneline(parseInt(state[2]));
						}
						else if(state[1]==18)
						{
							//浏览器新增多个连接
							wsConnects=false;
							//console.log("被通知到整改了");	
						}
						else if(state[1]==6)
						{
							//审核通过了信息下的某条小信息
							console.log("new message");
							id=parseInt(state[2]);
							if($('#comments_' + id).length>0)
							{
								//存在，更新信息
								ajaxReadItemComment(id);	
							}
						}
						else if(state[1]==5)
						{
							console.log("new message");
							//信息审核通过
							id=parseInt(state[2]);
							if($('#cm_' + id).length>0)
							{
								//直接读取存放数据	
								//alert("单条信息哦");
								$('#cm_' + id).show();
								ajaxReadItemComments(id);
							}	
							else
							{
								//判断是否小于最小值，然后设置对应信息
								if(id<commentsMinID)
								{
									//还有可以下拉的余地，开启下拉功能
									ajaxCommentsGet=true;	
								}
								else
								{
									//新加载最新的数据信息
									//alert('new msg!');
									ajaxReadNewComments();	
								}	
							}
						}
						else if(state[1]==4)
						{
							//取消置顶
							id=parseInt(state[2]);
							$('#topComments').html("");
							$('.topDing').val("");
							if($('#cm_' + id).length>0)
							{
								//存在区间位置，直接ajax读取这条信息
								$('#cm_' + id).show();
								ajaxReadItemComments(id);
								showLiLi();		
							}
							else
							{
								if(id<commentsMinID)
								{
									//还有可以下拉的余地，开启下拉功能
									ajaxCommentsGet=true;	
									showLiLi();
								}
								else
								{
									//加载最新的数据
									ajaxReadNewComments();		
								}	
								
							}
						}
						else if(state[1]==3)
						{
							
							//置顶操作,先清空对应消息，做个空包裹层
							id=parseInt(state[2]);
							
							if($('#comments_' + id).length>0)
							{
								var dates=$('#comments_' + id).find('.datepick').val();	
								$('#comments_' + id).html("");
								$('#comments_' + id).wrapAll('<label id="cm_' + id + '" style="display:none;"></label>');
								$('#cm_' + id).html("");
								
								showLiLi();
								
							}	
							
							var topDing=$('.topDing').val();
							if(topDing!='')
							{
								var topHtml=document.getElementById("topComments").innerHTML;
								//说明之前置顶数据存在，挪位置
								if($('#cm_' + topDing).length>0)
								{
									//存在位置，直接丢进去
									$('#cm_' + topDing).html(topHtml);	
									$('#cm_' + topDing).show();
	
									showLiLi();
									
									
								}	
							}
							showLiLi();
							//获取置顶消息
							getDing(id);
							ajaxReadNewComments();
						}
					}
					else
					{
						var state=data.split('_');
						state[1]=parseInt(state[1]);
						if(state[1]==18)
						{
							//浏览器新增多个连接
							wsConnects=false;
						}
					}
				}
			}
			
			ws.onclose = disConnect;
			
			ws.onerror = function(event){
				//console.log('error');
				//console.log(event);
			};
		
		}
		
		function reConnect()
		{
			//重复做点连接事情
			ws = new WebSocket("ws://39.106.9.165:9502?token=<?php echo $hash;//echo $_SESSION['swooleFid'];?>");//连接服务器
			
			ws.onopen = function(event){
				swooleState=true;
				console.log('open');
				console.log(event);
			};
		
			ws.onmessage = function (event)
			{
				//根据接收的数据做相关对应处理
				var data=event.data;
				console.log('tow');
				console.log(data);
				if(data.indexOf('B_')>=0)
				{
					//合法数据，根据对应值做相对应的处理
					var ask=data.split('B_');
					var projectId=parseInt(ask[0]);
					if(projectId==mvId)
					{
						//同一个项目下的开始调用
						var state=data.split('_');
						state[1]=parseInt(state[1]);
						if(state[1]==1)
						{
							//删除了某条信息
							id=parseInt(state[2]);
							
							var topDing=$('#topDing').val();
							if(topDing!='' && topDing==id)
							{
								//是置顶的这条信息，做对应处理
								$('#topComments').html("");
								$('#topDing').val("");
								//更改下面的样式高度
								noPadding();
							}
							else
							{
								if($('#comments_' + id).length>0)
								{
									var dates=$('#comments_' + id).find('.datepick').val();	
									$('#comments_' + id).remove();
									
									showLiLi();
									
								}
							}
	
						}	
						else if(state[1]==2)
						{
							//删除了某条信息下的消息
							id=parseInt(state[2]);
							if($('#Re_' + id + '_' + state[3]).length>0)
							{
								$('#Re_' + id + '_' + state[3]).remove();
								var ints=parseInt($('#reply_' + id).html())-1;
								$('#reply_' + id).html(ints);
							}
	
						}
						else if(state[1]==7)
						{
							//清空数据操作，重新加载数据
							readCommentState=true;
							ajaxCommentsGet=true;
							commentsMinID=0;
							commentsMaxID=0;
							commentsDate='';
							indexPage=true;
							indexNumber=1;
							$('#commentsListAll').html("");
							readComments();
							
						}
						else if(state[1]==8)
						{
							//开启了直播
							setTimeout("location='<?php echo http_url();?>play/item/<?php echo $res['id'];?>.html'",5000);
						}
						else if(state[1]==9)
						{
							//alert("做点关闭直播的事情");
							$('#StartInner').hide();
							$('#noStartInner').show();
							<?php
								if($res['timeOverShow']==2)
								{
							?>
							$('.daojitime').show();
							<?php
								}
							?>
							player.togglePlay();
						}
						else if(state[1]==11)
						{
							//做人数的操作
							//alert("做点关闭直播的事情");
							getOneline(parseInt(state[2]));
						}
						else if(state[1]==18)
						{
							//浏览器新增多个连接
							wsConnects=false;
							//console.log("被通知到整改了");	
						}
						else if(state[1]==6)
						{
							console.log("new message");
							//审核通过了信息下的某条小信息
							id=parseInt(state[2]);
							if($('#comments_' + id).length>0)
							{
								//存在，更新信息
								ajaxReadItemComment(id);	
							}
						}
						else if(state[1]==5)
						{
							console.log("new message");
							//信息审核通过
							id=parseInt(state[2]);
							if($('#cm_' + id).length>0)
							{
								//直接读取存放数据	
								$('#cm_' + id).show();
								ajaxReadItemComments(id);
							}	
							else
							{
								//判断是否小于最小值，然后设置对应信息
								if(id<commentsMinID)
								{
									//还有可以下拉的余地，开启下拉功能
									ajaxCommentsGet=true;	
								}
								else
								{
									//新加载最新的数据信息
									//alert('new msg!');
									ajaxReadNewComments();	
								}	
							}
						}
						else if(state[1]==4)
						{
							//取消置顶
							id=parseInt(state[2]);
							$('#topComments').html("");
							$('.topDing').val("");
							if($('#cm_' + id).length>0)
							{
								//存在区间位置，直接ajax读取这条信息
								$('#cm_' + id).show();
								ajaxReadItemComments(id);
								showLiLi();		
							}
							else
							{
								if(id<commentsMinID)
								{
									//还有可以下拉的余地，开启下拉功能
									ajaxCommentsGet=true;	
									showLiLi();
								}	
								else
								{
									ajaxReadNewComments();	
								}
							}
						}
						else if(state[1]==3)
						{
							
							//置顶操作,先清空对应消息，做个空包裹层
							id=parseInt(state[2]);
							
							if($('#comments_' + id).length>0)
							{
								var dates=$('#comments_' + id).find('.datepick').val();	
								$('#comments_' + id).html("");
								$('#comments_' + id).wrapAll('<label id="cm_' + id + '" style="display:none;"></label>');
								$('#cm_' + id).html("");
								
								showLiLi();
								
							}	
							
							var topDing=$('.topDing').val();
							if(topDing!='')
							{
								var topHtml=document.getElementById("topComments").innerHTML;
								//说明之前置顶数据存在，挪位置
								if($('#cm_' + topDing).length>0)
								{
									//存在位置，直接丢进去
									$('#cm_' + topDing).html(topHtml);	
									$('#cm_' + topDing).show();
	
									showLiLi();
									
									
								}	
							}
							showLiLi();
							//获取置顶消息
							getDing(id);
							ajaxReadNewComments();
						}
					}
					else
					{
						var state=data.split('_');
						state[1]=parseInt(state[1]);
						if(state[1]==18)
						{
							//浏览器新增多个连接
							wsConnects=false;
						}
					}
				}
			}
			
			ws.onclose = disConnect;
			
			ws.onerror = function(event){
			};			
		}
		
		var disConnect = function(){
			if(wsConnects)
			{
				setTimeout(function(){
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
			defaultClick();
			getHistoryMV();
			swooleLink();	
		});
		
		//默认点击第一个
		function defaultClick()
		{
			var clickState=true;
			$('.cont_cont .contqh').each(function(){
				if(clickState)
				{
					$(this).show();clickState=false;
				}	
			});	
		}
		
		//没有置顶信息，更改第一个div的padding，使之平衡
		function noPadding()
		{
		}
		
		//获取最新的消息
		var newCommentState=true;
		function ajaxReadNewComments()
		{
			if(newCommentState)
			{
			$.ajax({url:apiUrl + "play/mvAjaxNew/" + mvId + '?commentsMaxID=' + commentsMaxID + '&commentsDate=' + commentsDate, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					newCommentState=true;
				},
				beforeSend:function(){
					newCommentState=false;					
				},
				success:function(result){
					newCommentState=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf('||||')>=0)
					{
					
						var arr=result.split('||||');
						arr[0]=arr[0].replace(/(^\s*)|(\s*$)/g,"");
						arr[1]=arr[1].replace(/(^\s*)|(\s*$)/g,"");
						$('#topCommentsSpan').after(arr[1]);
						showBigImg();
						noPadding();	
						commentsMaxID=parseInt(arr[4]);
						commentsDate=arr[2];
						
						commentsDateStr=arr[5];
						showLiLi();
					}	
					

				} 
			});
			}
		}
		
		function showLiLi()
		{
			var timeDate='';
			$("#newComments li").each(function(){
				var datepick=$(this).find('.datepick').val();
				//alert(datepick);
				if(timeDate=='')
				{
					timeDate=datepick;	
				}
				else
				{
					if(timeDate.indexOf(datepick)<0)
					{
						timeDate=timeDate + ',' + datepick;	
					}
				}
				
				if($(this).find('.zhiding').length>0)
				{
					$(this).find('.zhiding').remove();	
				}
				
			});

			
			console.log(timeDate);
			
			if(timeDate!='')
			{
				if(timeDate.indexOf(',')>=0)
				{
					var timeDateArray=timeDate.split(',');
					for(var i=0;i<timeDateArray.length;i++)
					{
						loadLi(timeDateArray[i]);	
					}	
				}	
				else
				{
					loadLi(timeDate);	
				}
			}
		}
		
		//整合li的日期
		function loadLi(dates)
		{
			console.log(dates);
			var a=0;
			$("#newComments .listComment_" + dates + '_A').each(function(){
				if(a==0)
				{
					$(this).show();	
				}
				else
				{
					$(this).hide();		
				}
				a=parseInt(a)+1;
			});

			var a=0;
			$("#newComments .listComment_" + dates + '_B').each(function(){
				if(a==0)
				{
					$(this).hide();	
				}
				else
				{
					$(this).find('.shu1').css("margin-top",'-18px');
					$(this).show();	
				}
				a=parseInt(a)+1;
			});	

			var topDing=$('.topDing').val();

			if(typeof topDing!='undefined' && topDing!='')
			{
				var a=0;
				$("#newComments li").each(function(){
					if(a==0)
					{
						$(this).css("padding-top",'10px');	
					}
					a=parseInt(a)+1;
				});	
			}
			else
			{
				var a=0;
				$("#newComments li").each(function(){
					if(a==0)
					{
						
						$(this).css("padding-top",'0px');	
					}
					a=parseInt(a)+1;
				});	
			}
			bindFace();
			//noPadding();
		}
		
		//获取单挑的信息
		function ajaxReadItemComments(id)
		{
			$.ajax({url:apiUrl + "play/mvAjaxItem/" + mvId + '/' + id, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.msg('往期数据获取失败，程序员小哥哥已在抓紧时间修复了！');			
				},
				beforeSend:function(){
									
				},
				success:function(result){
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					$('#cm_' + id).html(result);
					showLiLi();
					noPadding();
				} 
			});		
		}
		
		//获取单挑的信息
		function ajaxReadItemComment(id)
		{
			$.ajax({url:apiUrl + "play/mvAjaxItems/" + mvId + '/' + id, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.msg('往期数据获取失败，程序员小哥哥已在抓紧时间修复了！');			
				},
				beforeSend:function(){
									
				},
				success:function(result){
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					$('#comments_' + id).html(result);
					showLiLi();
					noPadding();
				} 
			});		
		}
		
		//获取置顶的消息
		function getDing(id)
		{
			$.ajax({url:apiUrl + "play/mvAjaxDing/" + mvId, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					layer.msg('往期数据获取失败，程序员小哥哥已在抓紧时间修复了！');			
				},
				beforeSend:function(){
									
				},
				success:function(result){
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					$('#topComments').html(result);
					if(result!='')
					{
						$('.topDing').val(id);	
					}
					
					var dates=$('#topComments').find('.datepick').val();	
					showLiLi();
				} 
			});	
		}
		
		//获取往期回归数据
		var ajaxMvAllow=false;
		var maxMvId=0;
		var ajaxMVLoad=true;
		var ajaxMVGet=true;
		function getHistoryMV()
		{
			if(ajaxMVLoad && ajaxMVGet)
			{
				$.ajax({url:apiUrl + "play/mvAjax/" + mvId + "?maxMvId=" + maxMvId, 
				type: 'GET', 
				dataType: 'html', 
				timeout: 15000, 
					error: function(){
						$('#myListLoad').hide();
						ajaxMVLoad=true;
						layer.msg('往期数据获取失败，程序员小哥哥已在抓紧时间修复了！');			
					},
					beforeSend:function(){
						ajaxMVLoad=false;	
						$('#myListLoad').show();							
					},
					success:function(result){
						
						ajaxMVLoad=true;
						$('#myListLoad').hide();		
						result=result.replace(/(^\s*)|(\s*$)/g,"");
						if(result.indexOf('|||')>=0)
						{
							var arr=result.split('|||');
							maxMvId=parseInt(arr[1]);
							if(scrollerState)
							{
								startNextPageInfo();	
							}
							if(arr[0]!='')
							{
								$('#mvList').append(arr[0]);
								backHistoryShow();		
							}	
							else
							{
								ajaxMVGet=false;
							}
						}	
						else
						{
							if(result.indexOf("300|")>=0)
							{
								var arr=result.split('|');	
								layer.msg(arr[1]);
							}
							else
							{
								//layer.msg('往期数据获取失败，程序员小哥哥已在抓紧时间修复了！');
							}
						}		
					} 
				});
			}			
		}
		
		function playMv(title,appId,mvId){ 
			$('#tong').html('<iframe src="//1255817036.vod2.myqcloud.com/vod-player/' + appId + '/' + mvId + '/tcplayer/console/vod-player.html?autoplay=false&width=1920&height=1080" id="tcPy"  name="tcPy" frameborder="0" scrolling="no" width="640" height="360" allowfullscreen ></iframe>');
			gray_while=true;
			show_boxs();
		}
		
		var gray_all;
		var gray_while=false;
		//提示兼容模式信息
		function show_boxs()
		{
			if(gray_while)
			{
				var web_height=document.body.clientHeight;//获取网页的当前高度
				var web_width1=screen.width;//获取网页的当前高度
				var web_height1=document.documentElement.clientHeight;//获取网页的当前高度1
				var web_width=document.documentElement.clientWidth;//获取网页的当前宽度
				if(web_height1>web_height){//根据不同浏览器定位来判断当前浏览器的高度
					web_height=web_height1;
				}	
				//console.log(web_width + '______' + web_height);
				//if(web_width1>web_width){//根据不同浏览器定位来判断当前浏览器的高度
					//web_width=web_width1;
				//}		
				//设置网页的宽度和高度
				document.getElementById("tongBg").style.height=web_height + "px";
				document.getElementById("tongBg").style.width=web_width + "px";		
				document.getElementById("tongBg").style.display="block";
				document.getElementById("tong").style.display="block";
				document.body.style.overflow="hidden";
				//获取中间盒子的高度和宽度
				var div_h=document.getElementById("tong").offsetHeight;
				var div_w=document.getElementById("tong").offsetWidth;
				//获取中间盒子的高度和宽度
				//计算数据让悬浮盒子居中
				document.getElementById("tong").style.left=(web_width-div_w)/2 + "px";
				document.getElementById("tong").style.top=parseInt((web_height1-div_h))/2 + "px";
				clearTimeout(gray_all);
				gray_all=setTimeout("show_boxs()",100);	
			}
		}
		
		function closeTong()
		{
			gray_while=false;
			clearTimeout(gray_all);	
			$('#tong').show();
			document.getElementById("tongBg").style.display="none";
			document.getElementById("tong").style.display="none";
			$('#tong').html('<iframe src="//1255817036.vod2.myqcloud.com/vod-player/1255817036/5285890781951173543/tcplayer/console/vod-player.html?autoplay=false&width=1920&height=1080" frameborder="0" scrolling="no" width="100%" height="1080" allowfullscreen ></iframe>');
			document.body.style.overflow="auto";
		}
		
		var scrollerState=true;
		//开始读取对应的下一页数据操作
		function startNextPageInfo(){
			scrollerState=false;
			$(window).scroll(function () {
				var scrollTop = $(this).scrollTop();
				var scrollHeight = $(document).height();
				var windowHeight = $(this).height();
				if (scrollTop + windowHeight == scrollHeight) {
					//开始加载下一页数据
					if(ajaxMvAllow)
					{
						getHistoryMV();
					}
					if(ajaxCommentsAllow)
					{
						readComments();	
					}
				}
			});		
		}


		
	function inserttag(topen,tclose)
	{
		$('.smile_le').hide();
		var themess = document.getElementById('textSay');
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

	function inserttagRe(topen,tclose,id)
	{
		$('.smile_le').hide();
		var themess = document.getElementById('reContent_' + id);
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
    </script>
	<script>
	<?php
		if($res['timeOver']!='' && is_numeric($res['timeOver']) && $res['timeOver']>time() && $res['timeOverShow']==2){
	?>
				var timeOut;
				function timer() 
				{
					//$('.daojitime').show();
					var ts = (new Date(<?php echo date('Y',$res['timeOver']);?>, <?php echo date('m',$res['timeOver']);?>, <?php echo date('d',$res['timeOver']);?>, <?php echo date('H',$res['timeOver']);?>, <?php echo date('i',$res['timeOver']);?>, <?php echo date('s',$res['timeOver']);?>)) - (new Date());
					var timestamp = Date.parse(new Date())/1000; <!--当前时间戳-->
					var clickTime= <?php echo $res['timeOver'];?>;
					console.log(parseInt(clickTime));
					console.log(parseInt(timestamp));
					if(parseInt(clickTime)<=parseInt(timestamp))
					{
						clearTimeout(timeOut);
						$('.daojitime').hide();
					}
					else
					{
						var monthDay=mGetDate();
						var dd = parseInt(ts / 1000 / 60 / 60 / 24, 10)-monthDay;
						var hh = parseInt(ts / 1000 / 60 / 60 % 24, 10);
						var mm = parseInt(ts / 1000 / 60 % 60, 10);
						var ss = parseInt(ts / 1000 % 60, 10);
						dd = checkTime(dd);
						hh = checkTime(hh);
						mm = checkTime(mm);
						ss = checkTime(ss);
						document.getElementById("timer").innerHTML = dd + "天" + hh + "时" + mm + "分" + ss + "秒";
						clearTimeout(timeOut);
						//console.log(100);
						timeOut=setTimeout("timer()",1000);
					}
				}
				
				function mGetDate(){
					 var date = new Date();
					 var year = date.getFullYear();
					 var month = date.getMonth()+1;
					 var d = new Date(year, month, 0);
					 return parseInt(d.getDate());
				}
				
				function checkTime(i)
				{
				  if (i < 10) {
				  i = "0" + i;
				 }
				  return i;
				}
				$(function(){
					timer();
				});
	<?php
		}
		else
		{
	?>
		function noClickTime()
		{
			$('.daojitime').hide();
		}
		
		$(function(){
			noClickTime();
		});
	<?php
		}
	?>
	</script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/upload.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/comments.js"></script>
    <script type="text/javascript" src="<?php echo http_url().'cnzz/index/'.$res['id'].'.html';?>"></script>
</body>
</html>
