<?php
	//评论的helper方法
	
	//获取图片高宽
	if(!function_exists('getImgWH'))
	{
		function getImgWH($img,&$w,&$h)
		{
			$w=1024;
			$h=1024;
			if(is_file(FCPATH.$img))
			{
				$img_info=getimagesize(FCPATH.$img);
				$w=$img_info[0];
				$h=$img_info[1];
			}	
		}	
	}
	
	//打印对应li信息
	if(!function_exists('createPhoneCommentItem'))
	{
		function createPhoneCommentItem($array,$userInfo,$li=true)
		{
?>
	<?php
    	if($li)
		{
	?>
    <li id="comments_<?php echo $array['id'];?>">
    <?php
		}
	?>
        <input type="hidden" class="datepick" value="<?php echo date('Y_m_d',$array['time']);?>" />
        <div class="rili rili_<?php echo date('Y_m_d',$array['time']);?>"><img src="/assets/images/20.jpg" /><span><?php echo date('Y/m/d',$array['time']);?></span></div>
        <div class="time"><i></i><span><?php echo date('H:i',$array['time']);?></span></div>
        <div class="discuss">
            <div class="discuss_bt">
                <img src="<?php echo '/'.$array['avatar'];?>" />
                <a><?php echo $array['nickname'];?></a>
                <?php
                    if($array['honor']!='')
                    {
                ?>
                <span class="guanfang"><?php echo $array['honor'];?></span>
                <?php
                    }
                ?>
                <?php
                    if($array['top']==2)
                    {
                ?>
                <span class="zhiding">顶</span>
                <?php
                    }
                ?>
            </div>
            <div class="discuss_pp">
                <p><?php echo get_ubb($array['contents']);?></p>
                <span class="my-gallery">
                <?php
            	$file=json_decode($array['file'],true);
				for($i=0;$i<count($file);$i++)
				{
					getImgWH($file[$i]['file'],$w,$h);
				?>
                <figure>
                <label class="img-dv"><a href="<?php echo base_url().$file[$i]['file'];?>" data-size="<?php echo $w;?>x<?php echo $h;?>"><img src="<?php echo base_url().$file[$i]['file'];?>"></a></label>
                <figcaption style="display:none;"><?php echo get_ubb($array['contents']);?></figcaption>
                </figure>
				<?php 
				}
				?>
                </span>
            </div>
            <div class="discuss_plzan">
                <a><img src="/assets/images/21.jpg" class="discuss_pl" onclick="javascript:openInsertForm('<?php echo $array['id'];?>','<?php echo str_replace("'","\'","回复".$array['nickname'].'：');?>');"  /><span onclick="javascript:openInsertForm('<?php echo $array['id'];?>','<?php echo str_replace("'","\'","回复".$array['nickname'].'：');?>');" id="reply_<?php echo $array['id'];?>"><?php echo $array['reply'];?></span></a>
                <a><label id="giveUpa_<?php echo $array['id'];?>" onclick="javascript:giveUp('<?php echo $array['id'];?>');"><img src="/assets/images/<?php $userInfo?$uid=$userInfo['id']:$uid=$_SESSION['visitSocket'];echo substr_count($array['upJson'],'User:'.$uid.',')>0?'23':'22';?>.jpg" class="discuss_zan" /></label><span id="upCount_<?php echo $array['id'];?>" onclick="javascript:giveUp('<?php echo $array['id'];?>');"><?php echo $array['up'];?></span></a>
            </div>
			<?php
                $replyJson=json_decode($array['replyJson'],true);
                for($z=0;$z<count($replyJson);$z++)
                {
                    if($replyJson[$z]['state']==2)
                    {
            ?>
            <div class="discuss_hf" id="Re_<?php echo $array['id'];?>_<?php echo $replyJson[$z]['id'];?>">
                <img src="<?php echo '/'.$replyJson[$z]['avatar'];?>" class="discuss_hf_img" />
                <div class="discuss_hf_ri">
                    <p class="discuss_hf_rip1">
                        <a><?php echo $replyJson[$z]['nickname'];?></a>
						<?php
                            if($replyJson[$z]['honor']!='')
                            {
                        ?>
                        <span class="guanfang"><?php echo $replyJson[$z]['honor'];?></span>
                        <?php
                            }
                        ?>
                    </p>
                    <div class="discuss_hf_rip2">
                        <p><?php echo get_ubb($replyJson[$z]['contents']);?></p>
                    </div> 
                    <div class="discuss_hf_time">
                     <?php echo date('Y/m/d H:i',$replyJson[$z]['time']);?>
                    </div>
                </div> 
            </div>
			<?php
					}
				}
            ?>           
        </div>
	<?php
    	if($li)
		{
	?>
    </li>
    <?php
		}
	?>			
<?php			
		}
	}
?>