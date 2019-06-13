<?php
	foreach($query->result_array() as $array)
	{
?>
<div style="width:100%; float:left; height:auto; border-bottom:#CCC 1px solid;" class="listComment_<?php echo $array['id'];?>">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td width="8%" rowspan="3" align="left" valign="top" style="padding-top:15px;"><img src="<?php echo '/'.$array['avatar'];?>" width="32" height="32" /></td>
        <td width="92%" style="padding-top:15px;font-size:12px;">
        <span style="color:#09C;"><?php echo $array['nickname'];?></span> 
        <?php
        	if($array['honor']!='')
			{
		?>
        <a style="background:#09C;color:#fff; width:auto; padding-left:5px; padding-right:5px; height:18px; line-height:18px; display:inline-block;font-size:12px; border-radius:3px; margin-left:5px;"><?php echo $array['honor'];?></a>
        <?php
			}
		?>
        <?php
        	if($array['top']==2)
			{
		?>
        <a style="background:#F96;color:#fff; width:auto; padding-left:5px; padding-right:5px; height:18px; line-height:18px; display:inline-block;font-size:12px; border-radius:3px; margin-left:5px;">顶</a>
        <?php
			}
		?>
        <?php
        	if($array['show']==2)
			{
		?>
        <a style="color:#093; width:auto; padding-left:5px; padding-right:5px; height:18px; line-height:18px; display:inline-block;font-size:14px; border-radius:3px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><i class="iconfont">&#xea18;</i></a>
        <?php
			}
		?>
        <span style="float:right;color:#999; padding-right:10px;">
            <a href="javascript:zanyizan('<?php echo $array['id'];?>');" style="display:inline-block; width:auto; margin-right:20px;">  <i class="iconfont" style="color:#999;font-size:10px;<?php echo substr_count($array['upJson'],'Admin:'.$this->adminInfo['id'].',')>0?'font-weight:blod;color:#cc0000;':'';?>"><label id="zyz_<?php echo $array['id'];?>"><?php echo $array['up'];?></label> &#xeaa2;</i></a> <?php echo date('Y-m-d H:i:s',$array['time']);?>
        </span>
        </td>
        </tr>
        <tr>
        <td style="line-height:25px;font-size:13px;color:#666; padding-top:10px; padding-bottom:3px;font-size:12px;padding-right:10px;" class="sodo"><?php echo get_ubb($array['contents']);?>
        
        <span style="float:right;display:none;">
            <a href="javascript:huifu('<?php echo $array['id'];?>','<?php echo '回复 '.str_replace("'","\'",$array['nickname']);?>：');" style="border:#09C 1px solid; display:inline-block; width:auto; padding-left:5px; padding-right:5px; line-height:18px; text-align:center;color:#09C; font-size:12px; border-radius:3px;">回复</a>
            <?php
            	if($array['top']==1)
				{
			?>
            <a href="javascript:ding('<?php echo $array['id'];?>');" style="border:#09C 1px solid; display:inline-block; width:auto; padding-left:5px; padding-right:5px; line-height:18px; text-align:center;color:#09C; font-size:12px; border-radius:3px;">顶</a>
            <?php
				}
			?>
        	<?php
            	if($array['show']==1)
				{
			?>
            <a href="javascript:shenhe('<?php echo $array['id'];?>');" style="border:#09C 1px solid; display:inline-block; width:auto; padding-left:5px; padding-right:5px; line-height:18px; text-align:center;color:#09C; font-size:12px; border-radius:3px;">通过</a>
            <?php
				}
			?>
            <a href="javascript:del('<?php echo $array['id'];?>');" style="border:#09C 1px solid; display:inline-block; width:auto; padding-left:5px; padding-right:5px; line-height:18px; text-align:center;color:#09C; font-size:12px; border-radius:3px;">删除</a>
            <?php
            	if($array['noSay']==1 && $array['admins']==0)
				{
			?>
            <a href="javascript:jinyan('<?php echo $array['id'];?>');" style="border:#09C 1px solid; display:inline-block; width:auto; padding-left:5px; padding-right:5px; line-height:18px; text-align:center;color:#09C; font-size:12px; border-radius:3px;">禁言</a>
            <?php
				}
			?>

        </span>
        
        </td>
        </tr>
        <?php
        	if($array['file']!='')
			{
				$fileAll=json_decode($array['file'],true);
				if(!empty($fileAll))
				{
		?>
        <tr>
        <td align="right" valign="middle" style="padding-bottom:10px;min-height:30px;padding-right:10px;">
			<?php
            	for($i=0;$i<count($fileAll);$i++)
				{
			?>
            <a style="float:left; margin-right:15px;"><img src="/<?php echo $fileAll[$i]['file'];?>" style="width:50px;height:50px;"  class="smallimg" /></a>
            <?php
				}
			?>      
        </td>
        </tr>
        <?php
				}
			}
		?>
    </table>
<?php
        	if($array['replyJson']!='')
			{
				$replyJson=json_decode($array['replyJson'],true);
				if(!empty($replyJson))
				{

            	for($i=0;$i<count($replyJson);$i++)
				{

		?>
        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="sodoRe" id="Re_<?php echo $array['id'];?>_<?php echo $replyJson[$i]['id'];?>">
        
         <tr>
          <td>
          	<div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px dotted;"></div>
          </td>
          </tr>
          <tr>
            <td style="font-size:12px;height:50px; padding-left:7%;" class="contentsRe"><font style="color:#666;"><?php echo $replyJson[$i]['nickname'];?></font>：<?php echo get_ubb($replyJson[$i]['contents']); if($replyJson[$i]['state']==2){echo '&nbsp;&nbsp;<font color=green>√</font>';}?> <span style="float:right;color:#999;"><?php echo date('Y-m-d H:i',$replyJson[$i]['time']);?></span></td>
          </tr>
         
          <tr>
          	<td>
            <label style="float:right; margin-bottom:10px; display:none;">

        	<?php
            	if($replyJson[$i]['state']==1)
				{
			?>
            <a href="javascript:tongguoItem('<?php echo $array['id'];?>','<?php echo $replyJson[$i]['id'];?>');" style="border:#09C 1px solid; display:inline-block; width:auto; padding-left:5px; padding-right:5px; line-height:18px; text-align:center;color:#09C; font-size:12px; border-radius:3px;">通过</a>
            <?php
				}
			?>
            <a href="javascript:delItem('<?php echo $array['id'];?>','<?php echo $replyJson[$i]['id'];?>');" style="border:#09C 1px solid; display:inline-block; width:auto; padding-left:5px; padding-right:5px; line-height:18px; text-align:center;color:#09C; font-size:12px; border-radius:3px;">删除</a>

        </label>
            
            </td>
          </tr>
        </table>
        <?php
				}
				}
			}
		?>
</div>
<?php
	}
?>