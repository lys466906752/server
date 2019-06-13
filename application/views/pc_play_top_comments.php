<?php
	if(isset($Topquery))
	{
		foreach($Topquery->result_array() as $array)
		{
			$dateShow=true;
?>
<li id="comments_<?php echo $array['id'];?>">
	<input type="hidden" class="datepick" value="<?php echo date('Y_m_d',$array['time']);?>" />

	<div class="riqi_box listComment_<?php echo date('Y_m_d',$array['time']);?>_A" style="height:60px;<?php echo $dateShow?"display:block;":"display:none;";?>">
        <div class="riqi"><img src="<?php echo base_url();?>assets/images/20.jpg" alt="" /><?php echo date('Y/m/d',$array['time']);?></div>
        <div class="shu1"></div>
    </div>
    
    <div class="riqi_box listComment_<?php echo date('Y_m_d',$array['time']);?>_B" style="height:24px;<?php echo $dateShow?"display:none;":"display:block;";?>">
        <div class="shu1"></div>
    </div>

    <div class="discuss1">
        <div class="discuss_time">
            <span class="circle"></span>
            <span class="time_fm"><?php echo date('H:i',$array['time']);?></span>
        </div>
        <div class="discuss_ri">
            <div class="discuss_ri_name">
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
            <div class="discuss_ri_pp">
            <p class="contentItem"><?php echo get_ubb($array['contents']);?></p>
            <div>
            <?php
            	$file=json_decode($array['file'],true);
				for($i=0;$i<count($file);$i++)
				{
			?>
            <a><img src="<?php echo base_url().$file[$i]['file'];?>" class="smallimg"/></a>
			<?php
				}	
			?>
            </div>
            </div>
            <div class="discuss_ri_bot">
                <p>
                    <a href="javascript:showReCommentInner('<?php echo $array['id'];?>');"><img src="<?php echo base_url();?>assets/images/21.jpg" class="discuss_pl" /><span id="reply_<?php echo $array['id'];?>"><?php echo $array['reply'];?></span></a>
                    <a class="giveUpa" href="javascript:<?php if(!$this->userInfo){?>loginShow('<?php echo $array['id'];?>');<?php }else{?>giveUp('<?php echo $array['id'];?>');<?php }?>"><label id="giveUpa_<?php echo $array['id']?>"><img src="<?php echo base_url();?>assets/images/<?php echo substr_count($array['upJson'],'User:'.$this->userInfo['id'].',')>0?'23':'22';?>.jpg" class="discuss_zan"  /></label><span id="upCount_<?php echo $array['id'];?>"><?php echo $array['up'];?></span></a>
                </p>
                <div class="denglu_dis" id="commentReInner_<?php echo $array['id'];?>">
                    <textarea class="first_dis" id="reContent_<?php echo $array['id'];?>" <?php if(!$this->userInfo){?> onClick="loginShow('<?php echo $array['id'];?>');"<?php }?> onKeyUp="checkReCommentsLength(<?php echo $array['id'];?>);">回复<?php echo $array['nickname'];?>：</textarea>
                    <?php
                    	if(!$this->userInfo)
						{
					?>
                    <span class="first_dis" onClick="loginShow('<?php echo $array['id'];?>');">请先<i>登录</i></span>
                    <?php
						}
					?>
                    <a><i id="reContentInner_<?php echo $array['id'];?>">0</i>/<span>500</span></a>
                    <div class="denglu_send_dis">
                            <div class="smile_le" id="faceRe_<?php echo $array['id'];?>">
                                <?php
                                for($i=1;$i<=75;$i++)
                                {
                            ?><img src="<?php echo base_url();?>assets/images/face/em_<?php echo $i;?>.png" onClick="inserttagRe('[em_<?php echo $i;?>',']','<?php echo $array['id'];?>');"  /><?php }?>
                            </div>
                            <a class="send" <?php if(!$this->userInfo){?> onClick="loginShow('<?php echo $array['id'];?>');"<?php }else{?> onClick="subReComments('<?php echo $array['id'];?>','<?php echo str_replace("'","\'","回复".$array['nickname'].'：');?>');"<?php }?>>发送</a> 
                            <img src="<?php echo base_url();?>assets/images/15.png" class="biaoqing" <?php if(!$this->userInfo){?> onClick="loginShow('<?php echo $array['id'];?>');"<?php }else{?> onClick="showReFace('<?php echo $array['id'];?>');"<?php }?> />  
                         <?php
                         	if($this->userInfo)
							{
						 ?>   

                        <div class="wxqq_name">
                            <span><?php echo $this->userInfo['nickname'];?></span>
                            <a href="javascript:loginShow('<?php echo $array['id'];?>');" class="changeLg">切换</a>
                        </div> 
                        <?php
							}
						?>
                    </div>
                </div>
                <?php
                	$replyJson=json_decode($array['replyJson'],true);
					for($z=0;$z<count($replyJson);$z++)
					{
						if($replyJson[$z]['state']==2)
						{
				?>
                <div class="junyi_dafu" style="display:block;" id="Re_<?php echo $array['id'];?>_<?php echo $replyJson[$z]['id'];?>">
                    <img src="<?php echo '/'.$replyJson[$z]['avatar'];?>" />
                    <div class="junyi_dafu_ri">
                        <div class="junyi_dafu_name">
                            <a><?php echo $replyJson[$z]['nickname'];?></a>
                            <?php
                            	if($replyJson[$z]['honor']!='')
								{
							?>
                            <span class="guanfang"><?php echo $replyJson[$z]['honor'];?></span>
                            <?php
								}
							?>
                            <div class="junyi_dafu_time">
                                <?php echo date('Y/m/d H:i',$replyJson[$z]['time']);?>
                            </div>
                        </div>
                        <p><?php echo get_ubb($replyJson[$z]['contents']);?></p>
                    </div>
                </div>
                <?php
						}
					}
				?>
                <div class="denglufs_dis" id="loginInner_<?php echo $array['id'];?>">
                    <p class="denglufsp1"><span>请选择登录方式</span><a href="javascript:closeReLogin('<?php echo $array['id'];?>');"><img src="<?php echo base_url();?>assets/images/17.png" /></a></p>
                    <p class="denglufsp2">
                        <a class="denglufsqq" href="<?php echo http_url();?>users/qq/<?php echo $res['id'];?>.html"><img src="<?php echo base_url();?>assets/images/19.jpg" /></a>
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</li>
<?php
		}
	}
?>