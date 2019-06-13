<?php
	$max=40;
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
<li>
						<a title="<?php echo $array[$i]['title'];?>" onclick="playMv('<?php echo $array[$i]['title'];?>','<?php echo $array[$i]['appId'];?>','<?php echo $array[$i]['mvId'];?>')">
							<img src="<?php echo base_url().$array[$i]['file'];?>" />
							<div class="bofang_bg"><img src="<?php echo base_url();?>assets/images/bofang.png" /></div>
						</a>
						<p title="<?php echo $array[$i]['title'];?>"><?php echo $array[$i]['title'];?></p>
					</li>
<?php
					$a++;
				}
			}
		}
		echo '|||'.$nowId;
	}
?>