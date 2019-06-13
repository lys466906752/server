<?php

	$id='';
	if(isset($Topquery) && $Topquery->num_rows()>0)
	{
		foreach($Topquery->result_array() as $array)
		{
?>
<input type="hidden" class="topDing" value="<?php echo $array['id'];?>" />
<label id="topComments">
<?php
	createPhoneCommentItem($array,$this->userInfo);
?>
</label>
<label id="newComments">
<span id="topCommentsSpan"></span>
</label>
<?php
		}
	}
	else
	{
		if($indexNumber==1)
		{
?>
    <input type="hidden" class="topDing" value="" />
    <label id="topComments">
    </label>
    <label id="newComments">
    	<span id="topCommentsSpan"></span>
    </label>
<?php		
		}
	}
?>
||||
<?php
	$lastId='';
	foreach($query->result_array() as $array)
	{
		$commentsMinID=$array['id'];
?>
	<?php
        //先判断是否有上一页数据，有，补漏
        if($commentsMinID!='' && $commentsMinID!=0 && $commentsMinID!=$array['id']+1)
        {
            //中间存在间隙，直接累加
            for($a=$commentsMinID-1;$a>$array['id'];$a--)
            {
    ?>
    <label id="cm_<?php echo $a?>" style="display:none;"></label>
    <?php
            }
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
		if($commentsMaxID==0 || $commentsMaxID=='')
		{
			$commentsMaxID=$array['id'];
		}
    	
	?>
    <?php
		$dateShow=false;
		if(!in_array(date('Y/m/d',$array['time']),$dataArray))
		{
			$dataArray[]=date('Y/m/d',$array['time']);
			$dateShow=true;
		}
	?>
<?php
	createPhoneCommentItem($array,$this->userInfo);
?>
<?php
	}
	echo '||||'.trim(implode(',',$dataArray),',').'||||'.$commentsMinID.'||||'.$commentsMaxID;
?>