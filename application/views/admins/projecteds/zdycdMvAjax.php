<?php
	$max=20;
	$nowId=0;
	if(isset($pother['fourthContet']))
	{
		if($pother['fourthContet']=='')
		{
			echo '|||0';exit();	
		}
		$arr=json_decode($pother['fourthContet'],true);
		if(!isset($arr['list']))
		{
			echo '|||0';exit();		
		}
		$array=$arr['list'];
		$a=1;
		if(count($array)<1)
		{
			echo '|||0';exit();		
		}
		for($i=count($array)-1;$i>=0;$i--)
		{
			if($a<=$max)
			{
				if(($maxId!=0 && $array[$i]['id']<$maxId) || $maxId==0)
				{
					$nowId=$array[$i]['id'];
?>
<li style="float:left; padding-top:10px;" id="mid_<?php echo $array[$i]['id'];?>">
    <div style="width:150px; float:left; height:auto;padding-left:5px;">
        
        <p><img src="/<?php echo $array[$i]['file'];?>" style="width:150px; height:100px;" /></p>
        <p align="center"><strong style="text-decoration:underline;"><?php echo $array[$i]['title'];?></strong></p>
        <p align="center"><a href="javascript:editMV('<?php echo $array[$i]['id'];?>');">编辑</a>&nbsp;&nbsp;&nbsp;<a href="javascript:delMV('<?php echo $array[$i]['id'];?>');">删除</a></p>
    </div>
</li>
<?php
					$a++;
				}
			}
		}
		echo '|||'.$nowId;
	}
?>