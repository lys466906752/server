<?php
	if(isset($Topquery))
	{
		foreach($Topquery->result_array() as $array)
		{
			$dateShow=true;
?>
<?php
	createPhoneCommentItem($array,$this->userInfo);
?>
<?php
		}
	}
?>