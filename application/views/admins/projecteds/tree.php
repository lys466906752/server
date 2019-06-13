<div class="leftTree">
    <ul>
        <li <?php echo !isset($leftTree)?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/family/<?php echo $res['id'];?>.html">观看页主题设置</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='zbydt'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/zbydt/<?php echo $res['id'];?>.html">直播引导图</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='djs'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/djs/<?php echo $res['id'];?>.html">直播倒计时</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='gzrsxssz'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/gzrsxssz/<?php echo $res['id'];?>.html">观众人数显示设置</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='zbckbj'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/zbckbj/<?php echo $res['id'];?>.html">直播窗口背景</a></li>
        <!--<li <?php echo isset($leftTree) && $leftTree=='logo'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/logo/<?php echo $res['id'];?>.html">视频Logo图片添加</a></li>-->
        <li <?php echo isset($leftTree) && $leftTree=='gzhsz'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/gzhsz/<?php echo $res['id'];?>.html">公众号设置</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='zdycd'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/zdycd/<?php echo $res['id'];?>.html">自定义菜单</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='zdyggl'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/zdyggl/<?php echo $res['id'];?>.html">自定义广告栏</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='hmdip'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/hmdip/<?php echo $res['id'];?>.html">黑名单IP</a></li>
        <li <?php echo isset($leftTree) && $leftTree=='share'?'class="actived"':'';?>><a href="<?php echo admin_url();?>projecteds/share/<?php echo $res['id'];?>.html">分享设置</a></li>
    </ul>
</div>