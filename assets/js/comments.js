// JavaScript Document
var ajaxCommentsAllow=true;
var commentsLoad=true;
function sendComments()
{
	if(commentsLoad)
	{
		var fileParams=new Object();
		var i=0;
		$("#uploadPicInner a").each(function(){
			fileParams[i]=$(this).find('.uploadFileValue').val();
			i=parseInt(i)+1;
		});	
		console.log(fileParams);
		var textSay=$('#textSay').val().replace(/(^\s*)|(\s*$)/g,"");
		if(textSay=='')
		{
			layer.msg('您要说点什么呢？');	
		}
		else if(textSay.length<1 || textSay.length>500)
		{
			layer.msg('内容长度请控制在1-500字之间');		
		}
		else if(textSay.indexOf('||||')>=0)
		{
			layer.msg('内容不要填写非法字符');	
		}
		else
		{
			$.ajax({url:apiUrl + "play/commentSub/" + mvId, 
			type: 'POST',
			data:{textSay:textSay,fileAll:JSON.stringify(fileParams)}, 
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
						
						if(arr[0]==100)
						{
							$('#textSay').val("");	
							$('#uploadPicInner').html("");
							var as=arr[1].split('++++');
							layer.msg(as[0]);
							ws.send(mvId + 'A_1');
							if(as[0].indexOf("审核")<0)
							{
								ws.send(mvId + 'B_5_' + parseInt(as[1]));
							}
						}	
						else
						{
							layer.msg(arr[1]);
							if(arr[0]==200)
							{
								//登录失败，弹出盒子	
								changeLogin();
							}
							else if(arr[0]==300 && arr[1].indexOf("图片上传失败")>=0)
							{
								$('#uploadPicInner').html("");	
							}
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


//提交回复信息
function subReComments(id,nickname)
{
	if(commentsLoad)
	{
		var textSay=$('#reContent_' + id).val().replace(/(^\s*)|(\s*$)/g,"");
		if(textSay=='' || textSay==nickname)
		{
			layer.msg('您要说点什么呢？');	
		}
		else if(textSay.length<1 || textSay.length>500)
		{
			layer.msg('内容长度请控制在1-500字之间');		
		}
		else if(textSay.indexOf('||||')>=0)
		{
			layer.msg('内容不要填写非法字符');	
		}
		else
		{
			$.ajax({url:apiUrl + "play/commentReSub/" + mvId + '/' + id, 
			type: 'POST',
			data:{textSay:textSay}, 
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
						
						if(arr[0]==100)
						{
							$('#reContent_' + id).val(nickname);
							
							var as=arr[1].split('++++');
							layer.msg(as[0]);
							ws.send(mvId + 'A_2_' + as[1]);
							if(as[0].indexOf("审核")<0)
							{
								ws.send(mvId + 'B_6_' + parseInt(as[1]));
							}
								
						}
						else
						{	
							layer.msg(arr[1]);
							if(arr[0]==200)
							{
								//登录失败，弹出盒子	
								loginShow(id);
							}
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

function checkCommentsLength()
{
	var textSay=$('#textSay').val().replace(/(^\s*)|(\s*$)/g,"");
	$('#commentLenth').html(parseInt(textSay.length));
		
}

//ajax读取对应的评论信息
var readCommentState=true;
var ajaxCommentsGet=true;

var commentsMinID=0;
var commentsMaxID=0;
var commentsDate='';

var indexPage=true;
var indexNumber=1;

function readComments()
{
	if(readCommentState && ajaxCommentsGet)
	{
		$.ajax({url:apiUrl + "play/commentLists/" + mvId + '?commentsMinID=' + commentsMinID + '&commentsMaxID=' + commentsMaxID + '&commentsDate=' + commentsDate + '&indexNumber=' + indexNumber, 
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
							noPadding();	
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
							noPadding();	
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
						layer.msg(arr[2]);
					}
					else
					{
						layer.msg('往期数据获取失败，程序员小哥哥已在抓紧时间修复了！');
					}
				}	
			} 
		});	
	}
}

//提交点赞信息
function giveUp(id)
{
	if(commentsLoad)
	{
		
			$.ajax({url:apiUrl + "play/commentReSubUp/" + mvId + '/' + id, 
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
						if(arr[0]==100)
						{
							$('#upCount_' + id).html(arr[1]);	
							$('#giveUpa_' + id).html('<img src="/assets/images/23.jpg" class="discuss_zan" >');	
						}	
						else if(arr[0]==200)
						{
							//登录失败，弹出盒子	
							loginShow(id);
						}
						else
						{
							layer.msg(arr[1]);
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

$.fn.setCursorPosition = function(position){
 if(this.length == 0) return this;
 return $(this).setSelection(position, position);
}
 
$.fn.setSelection = function(selectionStart, selectionEnd) {
 if(this.length == 0) return this;
 input = this[0];
 
 if (input.createTextRange) {
 var range = input.createTextRange();
 range.collapse(true);
 range.moveEnd('character', selectionEnd);
 range.moveStart('character', selectionStart);
 range.select();
 } else if (input.setSelectionRange) {
 input.focus();
 input.setSelectionRange(selectionStart, selectionEnd);
 }
 
 return this;
}
 
$.fn.focusEnd = function(){
 this.setCursorPosition(this.val().length);
  return this;
}



//显示回复的区间
function showReCommentInner(id)
{

	if(document.getElementById('commentReInner_' + id).style.display=='block')
	{
		$('#commentReInner_' + id).hide();	
	}
	else
	{
		if(!loginState)
		{
			$('#reContent_' + id).val("");	
		}
		$('#commentReInner_' + id).show();	
		$('#reContent_' + id).focus();
		$('#reContent_' + id).focusEnd(); 
	}
}

//显示登录框
function loginShow(id)
{
	$('#loginInner_' + id).show();		
}

//关闭登录框
function closeReLogin(id)
{
	$('#loginInner_' + id).hide();		
}

//显示表情
function showReFace(id)
{
	$('#faceRe_' + id).show();	
}

//显示每个输入的长度
function checkReCommentsLength(id)
{
	var textSay=$('#reContent_' + id).val().replace(/(^\s*)|(\s*$)/g,"");
	$('#reContentInner_' + id).html(parseInt(textSay.length));
		
}