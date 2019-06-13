<table width="100%" border="0" cellspacing="0" cellpadding="0" class="myList">
               
  <tr>
            <td height="60" align="left" valign="middle" style="padding-top:15px;" colspan="8">
            
            
            <a href="javascript:del_all();" style="width:auto; background:#cc0000; padding-left:30px; padding-right:30px; line-height:35px; border-radius:5px;color:#fff; display:inline-block;"> 删除会员 </a> &nbsp;&nbsp;&nbsp;&nbsp; <select id="state" name="state"><option value="">--全部状态--</option><option value="1" <?php if($state==1){echo 'selected';}?>>--允许发言--</option><option value="2" <?php if($state==2){echo 'selected';}?>>--禁止发言--</option></select> &nbsp; <input type="text" id="keywords" name="keywords" value="<?php echo $keywords;?>"> <input type="button" value="搜索" onClick="searchUsers();"> <span style="float:right; text-align:right; padding-top:15px;">当前一共有 <strong style="color:#F00;" id="allNums"><?php echo $pageall;?></strong> 个会员</span></td>
          </tr>
          <tr>
            <td height="12" align="left" valign="middle" colspan="8"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px solid;"></div></td>
          </tr>         
          

        <tr style="font-weight:bold;">
          <td width="4%" align="center" valign="middle"><input type="checkbox" name="sx" id="sx" onClick="choose_all();" /></td>
          <td width="8%" align="center" valign="middle">状态</td>
          <td width="21%" height="38" align="center" valign="middle">昵称</td>
          <td width="8%" height="38" align="center" valign="middle">头像</td>
          <td width="23%" height="38" align="center" valign="middle">上次登录时间</td>
          <td width="12%" height="38" align="center" valign="middle">上次登录IP</td>
          <td width="13%" height="38" align="center" valign="middle">登录总次数</td>
          <td width="11%" height="38" align="center" valign="middle">操作</td>
        </tr>
        <tr>
          <td height="5" colspan="8" align="center" valign="middle">
          <div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px solid;"></div>
          </td>
          </tr>
        <?php
        	foreach($query->result_array() as $array)
			{
		?>
  <tr style="color:#666;">
          <td width="4%" align="center" valign="middle"><input type="checkbox" name="cid" id="cid" value="<?php echo $array['id'];?>" /></td>
          <td width="8%" align="center" valign="middle">
         	<span id="state_<?php echo $array['id'];?>">
            	<?php
                	if($array['comment_state']==1)
					{
				?>
                <a style="font-weight:bold;color:#099;" href="javascript:close_comments(<?php echo $array['id'];?>);">正常发言</a>
                <?php
					}
					else
					{
				?>
                <a style="font-weight:bold;color:#cc0000;" href="javascript:open_comments(<?php echo $array['id'];?>);">禁止发言</a>
                <?php
					}
				?>
            </span>
          </td>
          <td width="21%" height="38" align="center" valign="middle"><strong><?php echo str_replace($keywords,'<span style="background:#cc0000;color:#fff;">'.$keywords.'</span>',$array['nickname']);?></strong></td>
          <td width="8%" height="38" align="center" valign="middle"><img src="/<?php echo $array['avatar'];?>" style="width:30px;height:30px;border-radius:50%;"></td>
          <td width="23%" height="38" align="center" valign="middle"><?php echo $array['login_time']=='' || $array['login_time']==0?'暂无':date('Y-m-d H:i:s',$array['login_time']);?></td>
          <td width="12%" height="38" align="center" valign="middle"><?php echo $array['login_ip']==''?'暂无':$array['login_ip'];?></td>
          <td width="13%" height="38" align="center" valign="middle"><?php echo $array['login_count'];?></td>
          <td width="11%" height="38" align="center" valign="middle"><a href="javascript:editUser(<?php echo $array['id'];?>);">编辑</a> &nbsp;&nbsp; <a href="javascript:selectUser(<?php echo $array['id'];?>);">详情</a></td>
        </tr>
        <tr>
        <td height="5" colspan="8" align="center" valign="middle">
        	<div style="width:100%; float:left; height:1px; border-bottom:#e4e4e4 1px solid;"></div>
        </td>
        </tr>
        <?php
			}
        ?>
        <?php
        	if($pagecount>1)
			{
		?>
        <tr>
        <td height="5" colspan="8" align="center" valign="middle" style="line-height:35px;">
        	<a href="javascript:reads(1);" style="margin-left:5px;">首页</a> 
            
            <?php
            	for($a=$arrs[0];$a<=$arrs[1];$a++)
				{
			?>
            <?php
            	if($a==$pageindex)
				{
			?>
            <strong style="margin-left:5px;"><?php echo $a;?></strong>
            <?php
				}
				else
				{
			?>
            <a href="javascript:reads(<?php echo $a;?>);" style="margin-left:5px;"><?php echo $a;?></a>
            <?php
				}
			?>
            <?php
				}
			?>
            
            <a href="javascript:reads(<?php echo $pagecount;?>);" style="margin-left:5px;">末页</a>
            
            <span  style="margin-left:5px;">一共有 <strong><?php echo $pagecount;?></strong> 页</span>
        </td>
        </tr>
		<?php
			}
		?>
      </table>