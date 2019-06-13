<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title>军颐中医院技术直播管理系统</title>
<script src="https://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
<script src="/assets/layer_pc/layer.js"></script>
<link href="/assets/admin/css/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.nav a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px;float:left;}
.nav a:hover{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:}
.nav .actived a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:float:left;font-weight:bold; text-decoration:underline;}
.projecteds{width:100%; float:left; height:auto;}
.projecteds ul{padding:0; margin:0;}
.projecteds ul li{float:left; width:330px; height:auto; padding-bottom:15px; padding-top:10px;}
</style>
</head>

<body>
<table width="369" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="369" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="42%" height="45" align="center" valign="middle">用户昵称：</td>
          <td width="58%" height="45" align="left" valign="middle"><strong><?php echo $res['nickname'];?></strong></td>
        </tr>
        <tr>
          <td height="45" align="center" valign="middle">发言状态：</td>
          <td height="45" align="left" valign="middle">
          		<?php
                	if($res['comment_state']==1)
					{
				?>
            <a style="font-weight:bold;color:#099;">正常发言</a>
                <?php
					}
					else
					{
				?>
            <a style="font-weight:bold;color:#cc0000;">禁止发言</a>
                <?php
					}
				?>
          </td>
        </tr>
        <tr>
          <td height="55" align="center" valign="middle">头像预览：</td>
          <td height="55" align="left" valign="middle">
            <img src="/<?php echo $res['avatar'];?>" id="avatarsImg2" width="65" height="65" /></td>
        </tr>
        <tr>
          <td height="45" align="center" valign="middle">最后登录时间：</td>
          <td height="45" align="left" valign="middle"><?php echo $res['login_time']=='' || $res['login_time']==0?'暂无数据':date('Y-m-d H:i:s',$res['login_time']);?></td>
        </tr>
        <tr>
          <td height="45" align="center" valign="middle">最后登录IP：</td>
          <td height="45" align="left" valign="middle"><?php echo $res['login_ip']==''?'暂无数据':$res['login_ip'];?></td>
        </tr>
        <tr>
          <td height="45" align="center" valign="middle">上上次登录时间IP：</td>
          <td height="45" align="left" valign="middle"><?php echo $res['last_time']=='' || $res['last_time']==0?'暂无数据':date('Y-m-d H:i:s',$res['last_time']);?></td>
        </tr>
        <tr>
          <td height="45" align="center" valign="middle">上上次登录IP：</td>
          <td height="45" align="left" valign="middle"><?php echo $res['last_ip']==''?'暂无数据':$res['last_ip'];?></td>
        </tr>
        <tr>
          <td height="45" align="center" valign="middle">登录总次数：</td>
          <td height="45" align="left" valign="middle"><?php echo $res['login_count']==''?'暂无数据':$res['login_count'];?></td>
        </tr>
        <tr>
          <td height="45" align="center" valign="middle">最后登录浏览器信息：</td>
          <td height="45" align="left" valign="middle"><?php echo $res['user_agent']==''?'暂无数据':$res['user_agent'];?></td>
        </tr>
        </table>
    
    </td>
  </tr>
</table>
</body>
</html>