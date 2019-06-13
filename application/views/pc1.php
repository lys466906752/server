<div class="contqh1 contqh" id="commentsHistoryInner" style="display:none;">
            	<?php
                	if(!$this->userInfo)
					{
				?>
				<div class="talk1" id="niLoginDiv">
					<div class="denglu first" onClick="showLogin();">
						<textarea></textarea>
						<span>请先<i>登录</i></span>
						<a><i>0</i>/<span>500</span></a>
					</div>
                    
					<div class="denglufs" id="loginDiv">
						<p class="denglufsp1"><span>请选择登录方式</span><a href="javascript:closeLoginDiv();"><img src="<?php echo base_url();?>assets/images/17.png" /></a></p>
						<p class="denglufsp2">
							<a class="denglufsqq" href="<?php echo http_url();?>users/qq/<?php echo $res['id'];?>.html"><img src="<?php echo base_url();?>assets/images/19.jpg" /></a>
						</p>
					</div>
                    	
					<div class="denglutp_box" onClick="showLogin();">
						<div class="denglu_photo first">

						<span>+</span>
						</div>
						<div class="denglu_send">
							<div class="smile_le">
                            	<?php
                                	for($i=1;$i<=75;$i++)
									{
								?><img src="<?php echo base_url();?>assets/images/face/em_<?php echo $i;?>.png" /><?php }?>
							</div>
							<a class="send">发送</a> 
							<img src="<?php echo base_url();?>assets/images/15.png" class="biaoqing" id="faceA" /> 
                            
						</div>
					</div>
				</div>
                <?php
					}
					else
					{
				?>
				<div class="talk2">
					<div class="denglu">
						<textarea placeholder="我也说几句......" id="textSay" name="textSay" onKeyUp="checkCommentsLength();"></textarea> 
						<a><i id="commentLenth">0</i>/<span>500</span></a>
					</div>

					<div class="denglufs" id="changeLogin">
						<p class="denglufsp1"><span>请选择登录方式</span><a href="javascript:closeLogin();"><img src="<?php echo base_url();?>assets/images/17.png" /></a></p>
						<p class="denglufsp2">
							<a class="denglufsqq" href="<?php echo http_url();?>users/qq/<?php echo $res['id'];?>.html"><img src="<?php echo base_url();?>assets/images/19.jpg" /></a>
						</p>
					</div>
					
					<div class="denglutp_box">
						<div class="denglu_photo first">
                        
						<div class="denglu_tp" id="uploadPicInner">
							
						</div>
                        
                        <iframe id="tarGet" name="tarGet" src="" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>
                        <form id="form" name="form" action="<?php echo http_url();?>uploads/index" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet" style="display:none;">
                        <span id="fileInner">
                        <input type="file" name="file" id="file" placeholder="请选择一张图片" onchange="onSubmit();" />
                        </span>
                        </form>

						<span onClick="uploadImgs();">+</span>
						</div>
						<div class="denglu_send">
							<a class="send" href="javascript:sendComments();">发送</a>
							<div class="smile_le" id="showFaceA">
							<?php
                                for($i=1;$i<=75;$i++)
                                {
                            ?><img src="<?php echo base_url();?>assets/images/face/em_<?php echo $i;?>.png" onClick="inserttag('[em_<?php echo $i;?>',']');"  /><?php }?>
                            </div>
							
							 <img src="<?php echo base_url();?>assets/images/15.png" id="biaoqingA" class="biaoqing" onClick="showFaceA();" />
							<div class="wxqq_name">
								<span><?php echo $this->userInfo['nickname'];?></span>
								<a href="javascript:changeLogin();">切换</a>
							</div> 
						</div>
					</div>
				</div>

              	<?php
					}
				?>
				<!--话题信息开始--> 
                <ul class="discuss" id="commentsListAll"> 
                </ul>
                <!--话题信息结束-->
			</div>