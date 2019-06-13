// JavaScript Document
var formLoad=true;
function uploadImgs()
{
	var cs=0;
	$("#uploadPicInner a").each(function(){
		cs=parseInt(cs)+1;	
	});	
	if(cs<5)
	{
		$('#file').click();
	}
	else
	{
		layer.msg("最多可以上传五张！");	
	}
}
function onSubmit()
{
	if(formLoad)
	{
		layer.closeAll();
		var index = layer.load(1, {
		  shade: [0.9,'#333'] //0.1透明度的白色背景
		});
		formLoad=false;	
		document.form.submit();	
	}
	else
	{
		layer.msg('抱歉：还有进程数据正在处理中，请稍等...');
	}

}

var fileInteger=0;

function stopUpload(res)
{
	//alert(res);
	layer.closeAll();
	formLoad=true;	
	$('#fileInner').html('<input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />');
	if(res.indexOf("|")>=0)
	{
		arr=res.split("|");

		if(arr[0]==100)
		{
			fileInteger=parseInt(fileInteger)+1;
			$('#uploadPicInner').append('<a id="uploadFile_' + fileInteger + '"><input type="hidden" class="uploadFileValue" value="' + arr[1] + '" /><img src="/' + arr[1] + '"  class="smallimg" /><p style="font-size:12px;color:#999; text-align:center;padding-right:10px;padding-top:5px;"> <label onclick="deleteUploadFile(\'' + fileInteger + '\',\'' + arr[1] + '\');">删 除</label> </p></a>');
			showBigImg();
		}
		else if(arr[0]==200)
		{
			//出现登录的box
			changeLogin();
		}
		else if(arr[0]==300)
		{
			layer.msg(arr[1]);
		}
	}
	else
	{
		layer.msg('操作过程出错，请您稍后再试！');
	}
}

function deleteUploadFile(id,file)
{
	$('#uploadFile_' + id).remove();
	$.ajax({url:apiUrl + "uploads/del?file=" + file, 
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