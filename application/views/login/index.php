<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="renderer" content="webkit">
        <title>军颐中医院技术直播管理系统</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="/assets/css/form-elements.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <style>
            body,p,textarea,input,div{font-family:"微软雅黑";}
            .form-bottom .help-block{color:#ff0;}
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->

        </head>
<body>


        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    
                    <div class="row">

                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>军颐中医院技术直播管理系统</h3>
                            		<p>Enter your username and password to log on:</p>
                        		</div>
                        		<div class="form-top-right">
                        			
                        		</div>    
                            </div>
                            <div class="form-bottom">

			                    <form role="form" action="<?php echo http_url();?>login/index.html"  method="post" class="login-form" id="login_form" name="login_form" onsubmit="return false;">
                                        
                                        <input type="hidden" name="csrfLogin" id="csrfLogin" value="<?php echo get_csrfToken($this->encrypt);?>">

                                        <div class="form-group"><label class="sr-only" for="form-username">账 号：</label><input type="text" class="form-username form-control" id="username" name="username" placeholder="请输入您的登录账号..."></div>

                                        <div class="form-group"><label class="sr-only" for="form-username">账 号：</label><input type="password" class="form-password form-control" id="passwd" name="passwd" placeholder="请输入您的登录密码..."></div>


			                        <button type="submit" class="btn" onclick="return login();"> 登 录 </button>
			                    </form>
             
		                    </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="/assets/js/jquery-1.11.1.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.backstretch.min.js"></script>
        <script src="/assets/js/scripts.js"></script>
        <script src="/assets/layer_pc/layer.js"></script>
        <!--[if lt IE 10]>
            <script src="/assets/js/placeholder.js"></script>
        <![endif]-->
        <script type="text/javascript">

            var form_load=0;

            function login()
            {
                var username=$("#username").val().replace(/(^\s*)|(\s*$)/g,"");
                var passwd=$("#passwd").val().replace(/(^\s*)|(\s*$)/g,"");
                var csrfLogin=$("#csrfLogin").val().replace(/(^\s*)|(\s*$)/g,"");
                if(form_load==0)
                {
                    if(csrfLogin=='')
                    {
                        layer.msg('抱歉：系统错误，请刷新页面重试！');
                    }
                    else if(username=="")
                    {
                        layer.tips('抱歉：请您输入登录账号!','#username');
                    }
                    else if(passwd=="")
                    {
                        layer.tips('抱歉：请您输入登录密码!','#passwd'); 
                    }
                    else if(passwd.length<6 || passwd.length>16)
                    {
                        layer.tips('抱歉：您输入的登录密码不正确!','#passwd');  
                    }
                    else
                    {
                        //ajax sends
                        var sub_url=$('#login_form').attr('action');
                        $.ajax({url:sub_url, 
                        type: 'POST', 
                        data:{username:username,passwd:passwd,csrfLogin:csrfLogin}, 
                        dataType: 'html', 
                        timeout: 15000, 
                            error:function(){
                                layer.closeAll();
                                form_load=0;
                                layer.msg("登录过程出现错误，请您稍后再试！");                  
                            },
                            beforeSend:function(){
                                form_load=1;
                                var index = layer.load(1, {
                                  shade: [0.8,'#333'] //0.1透明度的白色背景
                                });
                            },
                            success:function(result){
                                layer.closeAll();
                                form_load=0;
                                result=result.replace(/(^\s*)|(\s*$)/g,"");
                                if(result.indexOf('|')>=0)
                                {
                                    var arr=result.split('|');
                                    if(arr[0]==100)
                                    {
                                        layer.msg('登录成功');
                                        setTimeout('location="<?php echo admin_url();?>home/index.html"',1200);
                                    }   
                                    else
                                    {
                                        layer.msg(arr[1]);      
                                    }
                                }
                                else
                                {
                                    layer.msg('登录过程出现错误，请您稍后再试！');  
                                }
                            } 
                        });   
                    }
                }
                else
                {
                    layer.msg('正在登录中，请勿重复操作！');
                }

                return false;
            }
        </script>
    </body>

</html>