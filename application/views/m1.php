<div class="contqh1 contqh" id="commentsHistoryInner" style="display:none;">
				<div class="borderleft"></div>
				 <ul id="commentsListAll">

				 </ul>
				 <div class="htfb_fabu">
				 	<div class="fabu"><img src="<?php echo base_url();?>assets/images/2.jpg" /><span>#发布#</span></div>
				 </div>
				 <div class="htfb" id="insertForm">
				 	<div class="htfb_bt">
						<span>话题发布</span><i onclick="closeInsertForm();">X</i>
					</div>
					<textarea placeholder="我也说几句..." id="textSay" name="textSay" onKeyUp="checkTextSay();"></textarea>
					<div class="tjtp" style="display:block;">
						<a id="uploadPicInner"></a>
                        
                        <img src="<?php echo base_url();?>assets/images/3.jpg" onclick="uploadImgs();" />
                        
                        <iframe id="tarGet" name="tarGet" src="" style="width:0;height:0;border:0px solid #fff;display:none;"></iframe>
                        <form id="form" name="form" action="<?php echo http_url();?>muploads/index" method="post" enctype="multipart/form-data" class="definewidth m20" target="tarGet" style="display:none;">
                        <span id="fileInner">
                        <input type="file" name="file" id="file" placeholder="请选择一张图片" accept="image/*"   />
       </span>
                        </form>    
                                           
					</div>

					<div class="biaoqing">
						<img src="<?php echo base_url();?>assets/images/15.png" class="smile_le" onclick="showOrHideFace();" />
						<div class="send_ri">
							<span>(500)</span>
							<a href="javascript:sendComments();">发送</a>
						</div>
						<div class="face_box" id="face_box">
							<div class="swiper-container1">
								<div class="swiper-wrapper">
									<div class="swiper-slide">
                                    	<?php for($i=1;$i<=21;$i++){?>
										<img src="<?php echo base_url();?>assets/images/face/<?php echo $i;?>.png" onClick="inserttag('[em_<?php echo $i;?>',']');" /><?php }?>
									</div>
									<div class="swiper-slide">
                                    	<?php for($i=22;$i<=42;$i++){?>
										<img src="<?php echo base_url();?>assets/images/face/<?php echo $i;?>.png" onClick="inserttag('[em_<?php echo $i;?>',']');" /><?php }?>
									</div>
									<div class="swiper-slide">
										<?php for($i=43;$i<=63;$i++){?>
										<img src="<?php echo base_url();?>assets/images/face/<?php echo $i;?>.png" onClick="inserttag('[em_<?php echo $i;?>',']');" /><?php }?>
									</div>
									<div class="swiper-slide">
										<?php for($i=64;$i<=75;$i++){?>
										<img src="<?php echo base_url();?>assets/images/face/<?php echo $i;?>.png" onClick="inserttag('[em_<?php echo $i;?>',']');" /><?php }?>
									</div>
								</div>
								<div class="swiper-pagination1" id="swiper-pagination1"> </div>
						</div>
							
						</div>
				 	</div>
				</div>
			</div>