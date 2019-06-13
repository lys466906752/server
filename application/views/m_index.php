<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $res['name'];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/phonestyle.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/swiper.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/PhotoSwipe/photoswipe.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/PhotoSwipe/default-skin/default-skin.css" />
<!-- 引入播放器 css 文件 -->
<link rel="stylesheet" href="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.css" rel="stylesheet">
<!-- 如需在IE8、9浏览器中初始化播放器，浏览器需支持Flash并在页面中引入 -->
<!--[if lt IE 9]>
<script src="//imgcache.qq.com/open/qcloud/video/tcplayer/ie8/videojs-ie8.js"></script>
<![endif]-->
<!-- 如果需要在 Chrome Firefox 等现代浏览器中通过H5播放hls，需要引入 hls.js -->
<script src="//imgcache.qq.com/open/qcloud/video/tcplayer/lib/hls.min.0.8.8.js"></script>
<!-- 引入播放器 js 文件 -->
<script src="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.min.js"></script>
<!-- 示例 CSS 样式可自行删除 -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/adaptive.js"></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-1.8.0.min.js'></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/layer_mobile/layer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/m.upload.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/m.comments.js"></script>
<script>
	var Domains="<?php echo http_url().'play/item/'.$res['id'].'.html';?>";
	//手机适配
	if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){

	}
	else
	{
		window.location.href= Domains;		
	}
</script>
<script>
	
	var apiUrl='<?php echo http_url();?>';
	var mvId='<?php echo $res['id'];?>';
	
	//广告点击
	var adLoad=true;
	function adGO(id,url,type)
	{
		if(adLoad)
		{
			$.ajax({url:apiUrl + "m/ad/" + mvId + '/' + type + '?id=' + id, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					adLoad=true;					
				},
				beforeSend:function(){
					adLoad=false;				
				},
				success:function(result){
					adLoad=true;	
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					url=url.replace(/(^\s*)|(\s*$)/g,"");
					if(url!='')
					{
						location=url;	
					}
				} 
			});					
		}	
	}
	
	//获取对应的历史直播信息
	var ajaxMvAllow=false;
	var maxMvId=0;
	var ajaxMVLoad=true;
	var ajaxMVGet=true;

	function getHistoryMV()
	{
		if(ajaxMVLoad && ajaxMVGet)
		{
			$.ajax({url:apiUrl + "m/mvAjax/" + mvId + "?maxMvId=" + maxMvId, 
			type: 'GET', 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					ajaxMVLoad=true;
					layer.open({
						content: '数据获取失败，请您稍后再试！'
						,skin: 'msg'
						,time: 2 //2秒后自动关闭
					});		
				},
				beforeSend:function(){
					ajaxMVLoad=false;							
				},
				success:function(result){
					ajaxMVLoad=true;
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
							layer.open({
								content: arr[1]
								,skin: 'msg'
								,time: 2 //2秒后自动关闭
							});
						}
						else
						{
							layer.open({
								content: '数据获取失败，请您稍后再试！'
								,skin: 'msg'
								,time: 2 //2秒后自动关闭
							});
						}
					}		
				} 
			});
		}			
	}
	
	//ajax读取对应的评论信息
	var readCommentState=true;
	var ajaxCommentsGet=true;
	
	var commentsMinID=0;
	var commentsMaxID=0;
	var commentsDate='';
	
	var indexPage=true;
	var indexNumber=1;
	var ajaxCommentsAllow=true;
	
	function readComments()
	{
		if(readCommentState && ajaxCommentsGet)
		{
			$.ajax({url:apiUrl + "m/commentLists/" + mvId + '?commentsMinID=' + commentsMinID + '&commentsMaxID=' + commentsMaxID + '&commentsDate=' + commentsDate + '&indexNumber=' + indexNumber, 
			type: 'GET',
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					readCommentState=true;		
				},
				beforeSend:function(){
					readCommentState=false;				
				},
				success:function(result){
					readCommentState=true;
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					if(result.indexOf('||||')>=0)
					{
						indexNumber=2;
						var arr=result.split('||||');
						arr[0]=arr[0].replace(/(^\s*)|(\s*$)/g,"");
						arr[1]=arr[1].replace(/(^\s*)|(\s*$)/g,"");
						if(indexPage)
						{
							indexPage=false;
							if(arr[0]=='' && arr[1]=='')
							{
								ajaxCommentsGet=false;	
							}
							else
							{
								$('#commentsListAll').append(arr[0]);
								$('#newComments').append(arr[1]);
								showBigImg();
								showLiLi();
								//noPadding();	
							}
						}
						else
						{
							if(arr[1]!='')
							{
								if(arr[0].replace(/(^\s*)|(\s*$)/g,"")!='')
								{
									$('#commentsListAll').append(arr[0]);
								}
								$('#newComments').append(arr[1]);
								showBigImg();
								showLiLi();
								//noPadding();	
							}	
							else
							{
								ajaxCommentsGet=false;
							}
						}
						commentsMaxID=parseInt(arr[4]);
						commentsMinID=parseInt(arr[3]);
						commentsDate=arr[2];
					}	
					else
					{
						if(result.indexOf("300|")>=0)
						{
							var arr=result.split('|');	
							layer.open({
								content: arr[1]
								,skin: 'msg'
								,time: 2 //2秒后自动关闭
							});
						}
						else
						{
							layer.open({
								content: '数据获取失败，请您稍后再试！'
								,skin: 'msg'
								,time: 2 //2秒后自动关闭
							});
						}
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
	
	function loadLi(timeDate)
	{
		var a=0;
		$("#newComments .rili_" + timeDate).each(function(){
			if(a==0)
			{
				$(this).show();	
			}
			else
			{
				$(this).remove();		
			}
			a=parseInt(a)+1;
		});	
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
	
	//播放视频
	var player;
	var i=0;
	function playMv(appId,mvId)
	{
		goTop();
		i=parseInt(i)+1;
		$('#playBgFileInner').hide();$('#playHistoryMvInner').show();
		$('#playHistoryMvInner').html('<video id="player-container-id-' + i + '" preload="auto" playsinline webkit-playinline x5-playinline style="width:6.4rem;min-height:248px;"></video>');
		
		player = TCPlayer("player-container-id-" + i, { // player-container-id 为播放器容器ID，必须与html中一致
			fileID: mvId, // 请传入需要播放的视频filID 必须
			appID: appId, // 请传入点播账号的appID 必须
			autoplay: true, //是否自动播放
			controls:'none'
			//其他参数请在开发文档中查看
		});	
		player.play();	
		$('#StartInner').hide();
		
	}
	
	//达到页面顶部
	function goTop()
	{
		window.scrollTo(0,0);
	}
	
	var commentsLoad=true;
	//提交点赞信息
	function giveUp(id)
	{
		if(commentsLoad)
		{
			
				$.ajax({url:apiUrl + "m/commentReSubUp/" + mvId + '/' + id, 
				type: 'GET',
				dataType: 'html', 
				timeout: 15000, 
					error: function(){
						
						commentsLoad=true;
						layer.open({
							content: '网络故障，请您稍后再试！'
							,skin: 'msg'
							,time: 2 //2秒后自动关闭
						});			
			
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
							if(arr[0]==100)
							{
								$('#upCount_' + id).html(arr[1]);	
								$('#giveUpa_' + id).html('<img src="/assets/images/23.jpg" class="discuss_zan" >');	
							}	
							else
							{
								layer.open({
									content: arr[1]
									,skin: 'msg'
									,time: 2 //2秒后自动关闭
								});								

							}
						}
						else
						{

							layer.open({
								content: '网络故障，请您稍后再试！'
								,skin: 'msg'
								,time: 2 //2秒后自动关闭
							});			
						}
				
					} 
				});				
		}	
		else
		{
			layer.open({
				content: '其他信息正在提交中，请您稍后再试！'
				,skin: 'msg'
				,time: 2 //2秒后自动关闭
			});		
		}		
	}

	$(function(){
		readComments();
		getHistoryMV();	
		swooleLink();
		ajaxReadPass();
		clickTimeHeight();
		var times=parseInt(randomer(3,8));
		getPlayTime(times);
		clearErrorMsg();
		getPlayAddress();
	});
	
	function clearErrorMsg()
	{
		if($('.vcp-error-tips').length>0)
		{
			$('.vcp-error-tips').html("");	
		}	
		setTimeout("clearErrorMsg()",100);
	}
	
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
	var wsConnects=true;
	
	function swooleLink()
	{
		ws = new WebSocket("ws://39.106.9.165:9502?token=<?php echo $hash;//echo $_SESSION['swooleFid'];?>");//连接服务器
		
		ws.onopen = function(event){
			swooleState=true;
			console.log(event);
		};
	
		ws.onmessage = function (event)
		{
			//根据接收的数据做相关对应处理
			var data=event.data;
			//console.log(data);
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
							showLiLi();
						}
						else
						{
							if($('#comments_' + id).length>0)
							{
								$('#comments_' + id).remove();
								showLiLi();
							}
						}
						ajaxReadPass();
	
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
						ajaxReadPass();
						$('#commentsListAll').html("");
						readComments();
						
					}
					else if(state[1]==8)
					{
						//开启了直播
						//alert("做点开启直播的事情");
						//playTimeSetAll=true;	
						//getPlayAddress();
						//$('#StartInner').show();
						//$('#playBgFileInner').hide();
						//$('.daojitime').hide();
						//playerZB.play();
						//$('#playHistoryMvInner').html("");
						//$('#playHistoryMvInner').hide();
						setTimeout("location='<?php echo http_url();?>play/item/<?php echo $res['id'];?>.html'",5000);
					}
					else if(state[1]==9)
					{
						//alert("做点关闭直播的事情");
						$('#StartInner').hide();
						$('#playBgFileInner').show();
						playerZB.togglePlay();
						playTimeSetAll=false;
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
						id=parseInt(state[2]);
						if($('#comments_' + id).length>0)
						{
							//存在，更新信息
							ajaxReadItemComment(id);	
						}
						ajaxReadPass();
					}
					else if(state[1]==5)
					{
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
						ajaxReadPass();
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
			//console.log(event);
		};
	
	}
	
	function reConnect()
	{
		clearTimeout(connectDo);
		ws = new WebSocket("ws://39.106.9.165:9502?token=<?php echo $hash;//echo $_SESSION['swooleFid'];?>");//连接服务器
		
		ws.onopen = function(event){
			swooleState=true;
			console.log(event);
		};
	
		ws.onmessage = function (event)
		{
			//根据接收的数据做相关对应处理
			var data=event.data;
			//console.log(data);
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
							showLiLi();
						}
						else
						{
							if($('#comments_' + id).length>0)
							{
								$('#comments_' + id).remove();
								showLiLi();
							}
						}
						ajaxReadPass();
	
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
						ajaxReadPass();
						$('#commentsListAll').html("");
						readComments();
						
					}
					else if(state[1]==8)
					{
						//开启了直播
						//alert("做点开启直播的事情");
						//playTimeSetAll=true;	
						//getPlayAddress();
						//$('#StartInner').show();
						//$('#playBgFileInner').hide();
						//$('.daojitime').hide();
						//playerZB.play();
						//$('#playHistoryMvInner').html("");
						//$('#playHistoryMvInner').hide();
						setTimeout("location='<?php echo http_url();?>play/item/<?php echo $res['id'];?>.html'",5000);
					}
					else if(state[1]==9)
					{
						//alert("做点关闭直播的事情");
						$('#StartInner').hide();
						$('#playBgFileInner').show();
						<?php
							if($res['timeOverShow']==2)
							{
						?>
						$('.daojitime').show();
						<?php
							}
						?>
						playerZB.togglePlay();
						playTimeSetAll=false;
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
						id=parseInt(state[2]);
						if($('#comments_' + id).length>0)
						{
							//存在，更新信息
							ajaxReadItemComment(id);	
						}
						ajaxReadPass();
					}
					else if(state[1]==5)
					{
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
						ajaxReadPass();
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
			//console.log(event);
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
	
	//获取最新的消息
	var newCommentState=true;
	function ajaxReadNewComments()
	{
		if(newCommentState)
		{
			newCommentState=false;
			$.ajax({url:apiUrl + "m/mvAjaxNew/" + mvId + '?commentsMaxID=' + commentsMaxID + '&commentsDate=' + commentsDate, 
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
						commentsMaxID=parseInt(arr[4]);
						console.log(commentsMaxID);
						commentsDate=arr[2];
						
						commentsDateStr=arr[5];
						showLiLi();
					}	
					
		
				} 
			});	
		}		
	}
	
	//获取置顶的消息
	function getDing(id)
	{
		$.ajax({url:apiUrl + "m/mvAjaxDing/" + mvId, 
		type: 'GET', 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){
	
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
				showLiLi();
			} 
		});	
	}

	//获取单挑的信息
	function ajaxReadItemComments(id)
	{
		$.ajax({url:apiUrl + "m/mvAjaxItem/" + mvId + '/' + id, 
		type: 'GET', 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){
		
			},
			beforeSend:function(){
								
			},
			success:function(result){
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				$('#cm_' + id).html(result);
				showLiLi();
			} 
		});		
	}
	
	//获取单挑的信息
	function ajaxReadItemComment(id)
	{
		$.ajax({url:apiUrl + "m/mvAjaxItems/" + mvId + '/' + id, 
		type: 'GET', 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){
		
			},
			beforeSend:function(){
								
			},
			success:function(result){
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				$('#comments_' + id).html(result);
				showLiLi();
			} 
		});		
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
	
	//获取当前的评论总数目
	function ajaxReadPass()
	{
		$.ajax({url:apiUrl + "m/mvPassCount/" + mvId, 
		type: 'GET', 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){
	
			},
			beforeSend:function(){
								
			},
			success:function(result){
				result=result.replace(/(^\s*)|(\s*$)/g,"");
				$('#commentsCount').html(result);

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
				//if(playTimeSetAll)
				//{
				playTimeSet=setTimeout("getPlayTime(" + times + ")",times*1000);
				//}
			} 
		});					
	}	
	
	//获取当前在线人数操作
	function getOneline(people)
	{
		if(playNumsState==2 && $('#nowAtHere').length>0)
		{
			var nums=0;
			//做显示操作
			if(playNumsStateType==1)
			{
				nums=parseInt(playNumsSuccess*people)+playNumsDefaults;	
			}	
			else
			{
				nums=people;	
			}
			nums=parseInt(nums);
			if(nums>0 && nums<=999)
			{
				nums=nums;	
			}
			else if(nums>1000 && nums<=9999)
			{
				var num = new Number(nums/1000);
				nums=num.toFixed(1) + '千';	
			}
			else
			{
				var num = new Number(nums/10000);
				nums=num.toFixed(1) + '万';	
			}
			
			$('#nowAtHere').html(nums);	
		}
	}
	
	function clickTimeHeight()
	{
		var height=$('#playBgFileUrl').height();
		$('.daojitime').css('height',height + 'px');
		setTimeout('clickTimeHeight()',500);	
	}


</script>
<?php
	if($res['shareState']==2)
	{
?>
<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript"></script>
<script>
	function wxShare()
	{
		$.ajax({url:apiUrl + "weixin/gets/" + mvId, 
		type: 'json', 
		dataType: 'html', 
		timeout: 15000, 
			error: function(){	
				
			},
			beforeSend:function(){						
			},
			success:function(result){	
				wx.config({
					debug: false,// 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。移动端会通过弹窗来提示相关信息。如果分享信息配置不正确的话，可以开了看对应报错信息
					appId: result.appId,
					timestamp: result.timestamp,
					nonceStr: result.nonceStr,
					signature: result.signature,
					jsApiList: [//需要使用的JS接口列表,分享默认这几个，如果有其他的功能比如图片上传之类的，需要添加对应api进来
						'checkJsApi',
						'onMenuShareTimeline',//
						'onMenuShareAppMessage',
						'onMenuShareQQ',
						'onMenuShareWeibo'
					]
				});				
			} 
		});	
	}
	
	$(function(){
		wxShare();	
	});
	
	window.share_config = {
		 "share": {
			"imgUrl": "<?php echo $res['logo']!=''?base_url().$res['logo']:base_url().'assets/images/1.jpg';?>",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
			"desc" : "<?php echo $res['shareContents'];?>",//摘要,如果分享到朋友圈的话，不显示摘要。
			"title" : '<?php echo $res['shareTitle'];?>',//分享卡片标题
			"link": window.location.href,//分享出去后的链接，这里可以将链接设置为另一个页面。
			"success":function(){//分享成功后的回调函数
			},
			'cancel': function () { 
				// 用户取消分享后执行的回调函数
			}
		}
	};  
	
	wx.ready(function () {
		wx.onMenuShareAppMessage(share_config.share);//分享给好友
		wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
		wx.onMenuShareQQ(share_config.share);//分享给手机QQ
	});
</script>
<?php
	}
?>
</head>

<body>
<style>
#playBgFileInner img{width:100%;}
.contqh2 img{width:100%;}
</style>
<div class="zb_box">
	<?php
    	$ads=json_decode($res['ads'],true);
		if(isset($ads['topAd']) && !empty($ads['topAd']))
		{
	?>
	<div class="hengtiao swiper-container_ht">
		<div class="swiper-wrapper">
        	<?php
            	for($i=0;$i<count($ads['topAd']);$i++)
				{
			?>
			<a href="javascript:adGO('<?php echo $ads['topAd'][$i]['hashId'];?>','<?php echo $ads['topAd'][$i]['url'];?>',1);" class="swiper-slide"><img src="<?php echo base_url().$ads['topAd'][$i]['file'];?>" /></a>
            <?php
				}
			?>
		</div>
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div> 	
	</div>
    <?php
		}
	?>
	<?php
    	if($res['mobileStartShow']==2)
		{
	?>
	<div class="zb_imga1"><img src="<?php echo $res['mobileStartFile']==''?base_url().'assets/images/1.gif':base_url().$res['mobileStartFile'];?>" /></div>
    <?php
		}
	?>
    <?php
    	if($res['gongzhonghaoState']==2)
		{
	?>
	<div class="weixin_box">
		<div class="weixin_bg"></div>
		<div class="weixin_cont">
				<p class="wx_p1"><?php echo $res['gongzhonghaoName'];?></p>
				<img src="<?php echo $res['gongzhonghaoFile']!=''?base_url().$res['gongzhonghaoFile']:base_url().'assets/images/2.png';?>" />
				<p class="wx_p2">长按关注公众号</p>
		</div>
	</div>
    <?php
		}
	?>
	<div class="banner_zb">
    	
        <span id="playBgFileInner">
			<img src="<?php echo $res['playBgFile']!=''?base_url().$res['playBgFile']:base_url().'assets/images/8.gif';?>" id="playBgFileUrl" /> 
        </span>
        <label class="daojitime">
     			<h2>剩余时间为：</h2> 
			   <div id = "timer"> 
			   </div> 
        </label>
        <label id="StartInner" style="display:none;">
        <div id="id_junyi_video" style="width:100%; height:auto;"></div>
		<?php
			if($res['playUrl']!='')
            {
		?>
        <script src="//imgcache.qq.com/open/qcloud/video/vcplayer/TcPlayer-2.2.2.js" charset="utf-8"></script>
         <script type="text/javascript">
             var playerZB =  new TcPlayer('id_junyi_video', {
            <?php
                if($res['playUrl']!='' && $res['state']==2)
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
            "coverpic" : "",
            "width" :  '100%',//视频的显示宽度，请尽量使用视频分辨率宽度
            "height" : '248',//视频的显示高度，请尽量使用视频分辨率高度
			"wording": {
					1002: "请确认已经开始直播，谢谢您的观看",
					2: "请确认已经开始直播，谢谢您的观看"
				}
            });
         </script> 
		<?php
			}
		?>
        </label>  
             
        <span id="playHistoryMvInner" style="display:none;">
        	
        </span>
        <?php
    	if($res['gongzhonghaoState']==2)
		{
		?>
		<div class="guanzhu"><img src="<?php echo base_url();?>assets/images/gz.png" />关注</div>
        <?php
		}
		?>
		<div class="ban_ribot">
			<a><img src="<?php echo base_url();?>assets/images/p1.png" /><span id="nowAtHere">--</span></a>
			<a><img src="<?php echo base_url();?>assets/images/p2.png" /><span id="commentsCount">0</span></a>
		</div>
	</div>
    <?php
    	$ads=json_decode($res['ads'],true);
		if(isset($ads['middleAd']) && !empty($ads['middleAd']))
		{
	?>
	<div class="hengtiao swiper-container_ht">
		<div class="swiper-wrapper">
        	<?php
            	for($i=0;$i<count($ads['middleAd']);$i++)
				{
			?>
			<a href="javascript:adGO('<?php echo $ads['middleAd'][$i]['hashId'];?>','<?php echo $ads['middleAd'][$i]['url'];?>',2);" class="swiper-slide"><img src="<?php echo base_url().$ads['middleAd'][$i]['file'];?>" /></a>
            <?php
				}
			?>
		</div>
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div> 	
	</div>
    <?php
		}
	?>
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
	<div class="cont_qhbox">
		<div class="cont_spans">
			<?php
            	for($i=0;$i<count($_arr);$i++)
            	{
			?>
			<span><?php echo $_arr[$i]['name'];?></span>
            <?php
				}
			?>
		</div>
		<div class="cont_cont">
		<?php
			$i=0;
			require("m".$_arr[$i]["id"].".php");
			$i=1;
			require("m".$_arr[$i]["id"].".php");
			$i=2;
			require("m".$_arr[$i]["id"].".php");
			$i=3;
			require("m".$_arr[$i]["id"].".php");
        ?>
		</div>
	</div>
</div>
 
    
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
<div class="pswp__bg"></div>
<div class="pswp__scroll-wrap">
    <div class="pswp__container">
        <div class="pswp__item"></div>
        <div class="pswp__item"></div>
        <div class="pswp__item"></div>
    </div>
    <div class="pswp__ui pswp__ui--hidden">
        <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <!--<button class="pswp__button pswp__button&#45;&#45;share" title="Share"></button>-->
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
            <div class="pswp__preloader">
                <div class="pswp__preloader__icn">
                    <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div>
        </div>
        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
        </button>
        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
        </button>
        <div class="pswp__caption">
            <div class="pswp__caption__center"></div>
        </div>
    </div>
</div>
</div>

<script>   

$(function(){
	defaultClick();	
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

$(".zb_imga1").click(function(){
	$(this).fadeOut();
	})
$(".weixin_bg").click(function(){
	$(".weixin_box").hide();
	})
	
	//guanzhu 
	$(".banner_zb").toggle(function(){
		$(".guanzhu").hide();
		},function(){
		$(".guanzhu").show();		
	})
	
	//关注微信号
	$(".guanzhu").click(function(){
		$(".weixin_box").show();
		})
	//横条切换
	var swiper = new Swiper('.swiper-container_ht', { 
				paginationClickable: true,
				centeredSlides: true,
				autoplay: 2500,
				autoplayDisableOnInteraction: false,
				loop:true,
				 navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
			});	
	 //四个板块切换
	 $(".cont_cont .contqh:gt(0)").hide();
	 $(".cont_spans span:eq(0)").addClass("ons");
	 $(".cont_spans span").click(function(){
		 $(this).addClass("ons").siblings("span").removeClass("ons");
		  var span_on=$(this).index();
		  $(".cont_cont .contqh").eq(span_on).show().siblings(".contqh").hide();
		  
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

		 });
	//点赞
	$(".discuss_zan").click(function(){
		$(this).attr("src","images/23.jpg");
	});
	//发布 
	$(".htfb").fadeOut();$(".face_box").fadeOut(); 
	$(".fabu").click(function(){
		$(".htfb").show();
		
		$(".smile_le").toggle(function(){
			$(".face_box").show(); 
		},function(){
			$(".face_box").hide(); 
		});
		$(".htfb_bt i").click(function(){
			$(".htfb").hide(); 
		});
	});
	 
	
	$(".discuss_pl").click(function(){
		$(".htfb").show();
	});
	
		 var swiper = new Swiper('.swiper-container1', {
				pagination: '.swiper-pagination1',
				paginationClickable: true,
				centeredSlides: true,
				autoplay: 2500,
				autoplayDisableOnInteraction: false,
				loop:true,
			});
			
	<?php
		if($res['state']==2)
		{
	?>
	$('#StartInner').show();
	$('#playBgFileInner').hide();
	$('.daojitime').hide();
	$('.weixin_box').hide();
	//playerZB.pause();
	<?php
		}
		else
		{
	?>
	$('#StartInner').hide();
	$('#playBgFileInner').show();
	<?php
		if($res['timeOverShow']==2)
		{
	?>
	$('.daojitime').show();
	<?php
		}
	?>
	//playerZB.togglePlay();
	<?php
		}
	?>

				 
</script> 
<script type="text/javascript" src="<?php echo http_url().'cnzz/index/'.$res['id'].'.html';?>"></script>
<script src="<?php echo base_url();?>assets/PhotoSwipe/photoswipe.js"></script>
<script src="<?php echo base_url();?>assets/PhotoSwipe/photoswipe-ui-default.min.js"></script>
<script>

    var initPhotoSwipeFromDOM = function(gallerySelector) {
        // 解析来自DOM元素幻灯片数据（URL，标题，大小...）
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item,
                divEl;
            for(var i = 0; i < numNodes; i++) {
                figureEl = thumbElements[i]; // <figure> element
                // 仅包括元素节点
                if(figureEl.nodeType !== 1) {
                    continue;
                }
                divEl = figureEl.children[0];
                linkEl = divEl.children[0]; // <a> element
                size = linkEl.getAttribute('data-size').split('x');
                // 创建幻灯片对象
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };
                if(figureEl.children.length > 1) {
                    item.title = figureEl.children[1].innerHTML;
                }
                if(linkEl.children.length > 0) {
                    // <img> 缩略图节点, 检索缩略图网址
                    item.msrc = linkEl.children[0].getAttribute('src');
                }
                item.el = figureEl; // 保存链接元素 for getThumbBoundsFn
                items.push(item);
            }
            return items;
        };

        // 查找最近的父节点
        var closest = function closest(el, fn) {
            return el && ( fn(el) ? el : closest(el.parentNode, fn) );
        };

        // 当用户点击缩略图触发
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;
            var eTarget = e.target || e.srcElement;
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });
            if(!clickedListItem) {
                return;
            }
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;
            for (var i = 0; i < numChildNodes; i++) {
                if(childNodes[i].nodeType !== 1) {
                    continue;
                }
                if(childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }
            if(index >= 0) {
                openPhotoSwipe( index, clickedGallery );
            }
            return false;
        };

        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
                params = {};
            if(hash.length < 5) {
                return params;
            }
            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if(!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if(pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }
            if(params.gid) {
                params.gid = parseInt(params.gid, 10);
            }
            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;
            items = parseThumbnailElements(galleryElement);
            // 这里可以定义参数
            options = {
                barsSize: {
                    top: 100,
                    bottom: 100
                },
                fullscreenEl : false,
                shareButtons: [
                    {id:'wechat', label:'分享微信', url:'#'},
                    {id:'weibo', label:'新浪微博', url:'#'},
                    {id:'download', label:'保存图片', url:'{{raw_image_url}}', download:true}
                ],
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),
                getThumbBoundsFn: function(index) {
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();
                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                }
            };
            if(fromURL) {
                if(options.galleryPIDs) {
                    for(var j = 0; j < items.length; j++) {
                        if(items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }
            if( isNaN(options.index) ) {
                return;
            }
            if(disableAnimation) {
                options.showAnimationDuration = 0;
            }
            gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        var galleryElements = document.querySelectorAll( gallerySelector );
        for(var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i+1);
            galleryElements[i].onclick = onThumbnailsClick;
        }
        var hashData = photoswipeParseHash();
        if(hashData.pid && hashData.gid) {
            openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
        }
    };
		
	function showBigImg()
	{
		initPhotoSwipeFromDOM('.my-gallery');
	}
	
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
</body>
</html>
