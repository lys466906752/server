<?php
	if(isset($Topquery))
	{
		foreach($Topquery->result_array() as $array)
		{
			$dateShow=false;
?>
<?php
	createPhoneCommentItem($array,$this->userInfo,false);
?>
<?php
		}
	}
?>