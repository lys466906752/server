<?php
	foreach($query->result_array() as $arrays)
	{
?>
<tr style="color:#666;" id="item_<?php echo $arrays['id'];?>">
    <td height="40" align="center" valign="middle"><?php echo $arrays['id'];?></td>
    <td height="40" align="center" valign="middle"><?php echo $arrays['username'];?></td>
    <td height="40" align="center" valign="middle"><?php echo date('Y-m-d H:i:s',$arrays['login_time']);?></td>
    <td height="40" align="center" valign="middle"><?php echo $arrays['login_ip'];?></td>
    <td height="40" align="center" valign="middle"><?php echo $arrays['count'];?></td>
    <td height="40" align="center" valign="middle"><a href="<?php echo admin_url();?>home/adminEdit/<?php echo $arrays['id'];?>.html">编辑</a> &nbsp;|&nbsp; <a href="javascript:deleteOne('<?php echo $arrays['id'];?>');">删除</a></td>
</tr>
<tr id="item_line_<?php echo $arrays['id'];?>">
    <td height="5" colspan="6" align="center" valign="middle">
    	<div style="width:100%;float:left;height:2px;border-bottom:#CCC 1px dotted;"></div>
    </td>
</tr>
<?php
	}
	echo '|||'.$query->num_rows();
?>