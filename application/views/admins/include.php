  <tr>
    <td width="423" height="100"><img src="/assets/images/logo.png" width="290" height="83" /></td>
    <td width="577" align="right" valign="top" style="padding-top:30px;">欢迎您，<strong><?php echo $this->adminInfo['username'];?></strong>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="<?php echo admin_url();?>home/adminEdit/<?php echo $this->adminInfo['id'];?>.html">修改密码</a> | &nbsp;&nbsp;<a href="javascript:clearCache();">更新缓存</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="<?php echo http_url();?>login/out.html">退出</a></td>
  </tr>
  <tr>
    <td height="50" colspan="2" bgcolor="#0099CC" class="nav">
    	<span class="<?php if(!isset($tag)){echo 'actived';}?>"><a href="<?php echo admin_url();?>home/index.html">首页</a></span>
        <span class="<?php if(isset($tag) && $tag=='admin'){echo 'actived';}?>"><a href="<?php echo admin_url();?>home/adminIndex.html">平台管理员</a></span>
        <span class="<?php if(isset($tag) && $tag=='members'){echo 'actived';}?>"><a href="<?php echo admin_url();?>members/index.html">会员管理</a></span>
        <?php
        	if(isset($map) && $map=='projected')
			{
		?>
        <span class="<?php if(isset($tag) && $tag=='index'){echo 'actived';}?>"><a href="<?php echo admin_url();?>projecteds/index/<?php echo $res['id'];?>.html">直播控制</a></span>
        <span class="<?php if(isset($tag) && $tag=='projected'){echo 'actived';}?>"><a href="<?php echo admin_url();?>projecteds/family/<?php echo $res['id'];?>.html">频道管理</a></span>
        <span class="<?php if(isset($tag) && $tag=='result'){echo 'actived';}?>"><a href="<?php echo admin_url();?>projecteds/result/<?php echo $res['id'];?>.html">数据统计</a></span>
        <?php
			}
		?>
    </td>
  </tr>