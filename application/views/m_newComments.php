||||
<?php
	$lastId='';
	$dataArrayer=[];
	foreach($query->result_array() as $array)
	{
		if($commentsMaxID<$array['id'])
		{
			$commentsMaxID=$array['id'];
		}
?>
<?php

	if($lastId=='' || $lastId==0)
	{
		$lastId=$array['id'];	
	}
	else
	{
		if($lastId!=$array['id']+1)
		{
			//中间存在间隙，直接累加
			for($a=$lastId-1;$a>$array['id'];$a--)
			{
?>
			<label id="cm_<?php echo $a?>" style="display:none;"></label>
<?php
			}
		}
		$lastId=$array['id'];	
	}
?>
<?php
	createPhoneCommentItem($array,$this->userInfo);
?>
<?php
	}
	echo '||||'.trim(implode(',',$dataArray),',').'||||0||||'.$commentsMaxID.'||||'.trim(implode(',',$dataArrayer),',');
?>