// JavaScript Document
function inserttag(topen,tclose)
{
	$('#face_box').hide();
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

var ajaxCommentsAllow=true;
var commentsLoad=true;
function sendComments()
{
	if(commentsLoad)
	{
		var fileParams=new Object();
		var i=0;
		$("#uploadPicInner span").each(function(){
			fileParams[i]=$(this).find('.uploadFileValue').val();
			i=parseInt(i)+1;
		});	
		console.log(fileParams);
		var textSay=$('#textSay').val().replace(/(^\s*)|(\s*$)/g,"");
		if(textSay=='')
		{
		  layer.open({
			content: '请说点什么呢？' 
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		  });

		}
		else if(reId!='' && textSay==reText)
		{
			layer.open({
			content: '请说点什么呢？'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		  });	
		}
		else if(textSay.length<1 || textSay.length>500)
		{
		  layer.open({
			content: '内容长度请控制在1-500字之间！'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		  });		
		}
		else if(textSay.indexOf('||||')>=0)
		{
		  layer.open({
			content: '内容不要填写非法字符！'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		  });	
		}
		else
		{
			$.ajax({url:apiUrl + "m/commentSub/" + mvId + '/' + reId, 
			type: 'POST',
			data:{textSay:textSay,fileAll:JSON.stringify(fileParams)}, 
			dataType: 'html', 
			timeout: 15000, 
				error: function(){
					
					commentsLoad=true;
				  layer.open({
					content: '网络错误，请稍后再试！'
					,skin: 'msg'
					,time: 2 //2秒后自动关闭
				  });	
			
				},
				beforeSend:function(){
					commentsLoad=false;	
					layer.open({
						type: 2
						,content: '发布中...'
					});								
				},
				success:function(result){
					layer.closeAll();
					commentsLoad=true;
					
					result=result.replace(/(^\s*)|(\s*$)/g,"");

					if(result.indexOf("|")>=0)
					{
						var arr=result.split('|');
						
						if(arr[0]==100 || arr[0]==1000)
						{
							$('#textSay').val("");	
							$('#uploadPicInner').html("");
							closeInsertForm();
							var as=arr[1].split('++++');
	
							  layer.open({
								content: as[0]
								,skin: 'msg'
								,time: 2 //2秒后自动关闭
							  });
							  
							if(arr[0]==100)
							{  
								//新发布一条主信息
								ws.send(mvId + 'A_1');
								if(as[0].indexOf("审核")<0)
								{
									ws.send(mvId + 'B_5_' + parseInt(as[1]));
								}
							}
							else
							{
								//回复的某条信息
								ws.send(mvId + 'A_2_' + as[1]);
								if(as[0].indexOf("审核")<0)
								{
									ws.send(mvId + 'B_6_' + parseInt(as[1]));
								}	
							}
						}	
						else
						{

							layer.open({
								content: arr[1]
								,skin: 'msg'
								,time: 2 //2秒后自动关闭
							});

							if(arr[0]==200)
							{
								//登录失败，弹出盒子	
								//changeLogin();
							}
							else if(arr[0]==300 && arr[1].indexOf("图片上传失败")>=0)
							{
								$('#uploadPicInner').html("");	
							}
						}
					}
					else
					{
						 layer.open({
							content: '网络错误，请稍后再试！'
							,skin: 'msg'
							,time: 2 //2秒后自动关闭
						 });			
					}
			
				} 
			});				
		}
	}	
	else
	{
		layer.open({
			content: "其他信息正在提交中，请稍等..."
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		});		

	}
}

var reId='';
var reText='';

function openInsertForm(id,text)
{
	
	$('#textSay').val(text);
	reId=id;
	reText=text;	
	$('#insertForm').show();
	$('.tjtp').hide();
	$('#textSay').focus();
	$('#textSay').focusEnd(); 	
}

function closeInsertForm()
{
	$('#textSay').val('');
	reId='';
	reText='';	
	$('#insertForm').hide();
	$('.tjtp').show();
	$('#face_box').hide();		
}

function checkTextSay()
{
	var textSay=$('#textSay').val().replace(/(^\s*)|(\s*$)/g,"");
	if(textSay=='')
	{
		reId='';
		reText='';
		$('.tjtp').show();	
	}	
}

function showOrHideFace()
{
	if(document.getElementById('face_box').style.display=='none')
	{
		$('#face_box').show();
	}	
	else
	{
		$('#face_box').hide();	
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