// JavaScript Document
var formLoad=true;
function uploadImgs()
{
	var cs=0;
	$("#uploadPicInner span").each(function(){
		cs=parseInt(cs)+1;	
	});	
	if(cs<5)
	{
		$('#file').click();
	}
	else
	{
		  layer.open({
			content: '最多仅允许上传五张！'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		  });
	}
}

/*function onSubmit()
{
	if(formLoad)
	{
		layer.closeAll();
		  layer.open({
			type: 2
			,content: '图片上传中，请稍等...'
		  });
		formLoad=false;	
		document.form.submit();	
	}
	else
	{
		 layer.open({
			content: '抱歉，其他图片上传还未完成，请稍等！'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		 });
	}

}
*/
var fileInteger=0;
var uploadFiles='';
$(function(){
	var eleFile = document.querySelector('#file');
	
	// 压缩图片需要的一些元素和对象
	var reader = new FileReader(), img = new Image();
	
	// 选择的文件对象
	var file = null;
	
	// 缩放图片需要的canvas
	var canvas = document.createElement('canvas');
	var context = canvas.getContext('2d');
	
	// base64地址图片加载完毕后
	img.onload = function () {
		// 图片原始尺寸
		var originWidth = this.width;
		var originHeight = this.height;
		// 最大尺寸限制
		var maxWidth = 1800, maxHeight = 1800;
		// 目标尺寸
		var targetWidth = originWidth, targetHeight = originHeight;
		// 图片尺寸超过400x400的限制
		if (originWidth > maxWidth || originHeight > maxHeight) {
			if (originWidth / originHeight > maxWidth / maxHeight) {
				// 更宽，按照宽度限定尺寸
				targetWidth = maxWidth;
				targetHeight = Math.round(maxWidth * (originHeight / originWidth));
			} else {
				targetHeight = maxHeight;
				targetWidth = Math.round(maxHeight * (originWidth / originHeight));
			}
		}
			
		// canvas对图片进行缩放
		canvas.width = targetWidth;
		canvas.height = targetHeight;
		// 清除画布
		context.clearRect(0, 0, targetWidth, targetHeight);
		// 图片压缩
		context.drawImage(img, 0, 0, targetWidth, targetHeight);
		// canvas转为blob并上传
		
		if(formLoad)
		{
		
		canvas.toBlob(function (blob) {
			// 图片ajax上传
			var xhr = new XMLHttpRequest();
			// 文件上传成功
			xhr.onreadystatechange = function() {
				console.log(xhr.status);
				if (xhr.status == 200) {
					layer.closeAll();
					formLoad=true;
					// xhr.responseText就是返回的数据
					fileInteger=parseInt(fileInteger)+1;
					imageFile=xhr.responseText;
					console.log(imageFile);
					if(imageFile!='' && uploadFiles!=imageFile)
					{
						uploadFiles=imageFile;
						$('#uploadPicInner').append('<span id="uploadFile_' + fileInteger + '"><input type="hidden" class="uploadFileValue" value="' + imageFile + '" /><img href="/' + imageFile + '" src="/' + imageFile + '" /><i onclick="deleteUploadFile(\'' + fileInteger + '\',\'' + imageFile + '\');">X</i></span>');
					}
				}
				else if(xhr.status == 0)
				{
					formLoad=false;
					layer.closeAll();
					layer.open({
					type: 2
					,content: '图片上传中，请稍等...'
					});						
				}
				else
				{
					layer.closeAll();
					 layer.open({
						content: '上传失败，请您稍后再试！'
						,skin: 'msg'
						,time: 2 //2秒后自动关闭
					 });	
				}
			};
			// 开始上传
			xhr.open("POST", apiUrl + 'muploads/phone', true);
			xhr.send(blob);    
		}, file.type || 'image/png' || 'image/jpg' || 'image/jpeg');
		
		}
	};
	
	// 文件base64化，以便获知图片原始尺寸
	reader.onload = function(e) {
		img.src = e.target.result;
	};
	eleFile.addEventListener('change', function (event) {
		file = event.target.files[0];
		// 选择的文件是图片
		if (file.type.indexOf("image") == 0) {
			reader.readAsDataURL(file);    
		}
	});		
});

/*function stopUpload(res)
{
	layer.closeAll();
	formLoad=true;	
	$('#fileInner').html('<input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />');
	if(res.indexOf("|")>=0)
	{
		arr=res.split("|");

		if(arr[0]==100)
		{
			fileInteger=parseInt(fileInteger)+1;
			$('#uploadPicInner').append('<span id="uploadFile_' + fileInteger + '"><input type="hidden" class="uploadFileValue" value="' + arr[1] + '" /><img href="/' + arr[1] + '" src="/' + arr[1] + '" /><i onclick="deleteUploadFile(\'' + fileInteger + '\',\'' + arr[1] + '\');">X</i></span>');
		}
		else if(arr[0]==300)
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
			content: '抱歉，操作过程出错，请重新尝试！'
			,skin: 'msg'
			,time: 2 //2秒后自动关闭
		 });
	}
}
*/
function deleteUploadFile(id,file)
{
	$('#uploadFile_' + id).remove();
	$.ajax({url:apiUrl + "muploads/del?file=" + file, 
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

