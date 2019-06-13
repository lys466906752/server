<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<title>军颐中医院技术直播管理系统</title>
<script src="https://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
<script src="/assets/layer_pc/layer.js"></script>

<script src="/assets/admin/js/echarts.min.js"></script>
<script>

var china = [];

function paintMap(R) {
    var attr = {
        "fill": "#b0d0ec",
        "stroke": "#ddd",
        "stroke-width": 1.5,
        "stroke-linejoin": "round"
    };
	<?php
		foreach($regions->result_array() as $region)
		{
			if($region['data']!='')
			{
	?>
    china.<?php echo $region['name'];?> = {
        name: "<?php echo $region['name'];?>",
		count: "<?php echo $region['counts'];?>",
        path: R.path("<?php echo $region['data'];?>").attr(attr)
    };
	<?php
			}
		}
	?>
    
}
</script>
<script src="/assets/admin/js/china.js"></script>

<link href="/assets/admin/css/main.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/css/colpick.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.nav a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px;float:left;}
.nav a:hover{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:}
.nav .actived a{width:auto; line-height:50px; padding-left:40px; padding-right:40px; color:#FFF;font-size:16px; background:#1859a5;display:float:left;font-weight:bold; text-decoration:underline;}
.projecteds{width:100%; float:left; height:auto;}
.projecteds ul{padding:0; margin:0;}
.projecteds ul li{float:left; width:330px; height:auto; padding-bottom:15px; padding-top:10px;}

@font-face {
  font-family: 'iconfont';
  src: url('/assets/iconfont/iconfont.eot'); /* IE9*/
  src: url('/assets/iconfont/iconfont.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
  url('/assets/iconfont/iconfont.woff') format('woff'), /* chrome、firefox */
  url('/assets/iconfont/iconfont.ttf') format('truetype'), /* chrome、firefox、opera、Safari, Android, iOS 4.2+*/
  url('/assets/iconfont/iconfont.svg#iconfont') format('svg'); /* iOS 4.1- */
}
.iconfont{
    font-family:"iconfont" !important;
    font-size:16px;font-style:normal;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: 0.2px;
    -moz-osx-font-smoothing: grayscale;}

#ChinaMap{padding-right:100px;padding-left:10px;padding-bottom:10px;margin:0px auto;padding-top:10px;position:relative;text-align:center;}
#tiplayer{padding-right:5px;padding-left:5px;z-index:1000;min-height:1em;background:#000;max-width:250px;padding-bottom:5px;font:12px 'Microsoft YaHei',Arial,宋体,Tahoma,Sans-Serif;color:#fff;padding-top:5px;position:absolute;text-align:left;word-wrap:break-word;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
.ToolTip{padding-right:5px;padding-left:5px;z-index:1000;min-height:1em;background:#000;max-width:350px;padding-bottom:5px;font:12px 'Microsoft YaHei',Arial,宋体,Tahoma,Sans-Serif;color:#fff;padding-top:5px;position:absolute;text-align:left;word-wrap:break-word;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
.ToolTip{border-right:#c5b270 1px solid;padding-right:15px;border-top:#c5b270 1px solid;padding-left:15px;background:#fffbd6;padding-bottom:0px;border-left:#c5b270 1px solid;color:#bb861c;line-height:30px;padding-top:0px;border-bottom:#c5b270 1px solid;top:30px;}
</style>

<script>
	var form_loads=1;


</script>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
	require VIEWPATH.'admins/include.php';
?>
  <tr>
    <td height="40" colspan="2" align="left" valign="middle" style="padding-top:15px;"><strong style="font-size:18px;"><?php echo $res['name'];?></strong> &nbsp;&nbsp;&nbsp; 观看地址：<a href="<?php echo http_url().'play/item/'.$res['id'];?>" target="_blank"><?php echo http_url().'play/item/'.$res['id'];?></a></td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" valign="middle"><div style="width:100%; float:left; height:1px; border-bottom:#CCC 1px solid;"> </div></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" valign="middle">
      <table width="998" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="40" colspan="5"><strong>直播概况</strong></td>
        </tr>
        <tr>
          <td height="40" align="center" valign="middle" bgcolor="#f4f4f4">直播时长</td>
          <td height="40" align="center" valign="middle" bgcolor="#f4f4f4">观众数(UV)</td>
          <td height="40" align="center" valign="middle" bgcolor="#f4f4f4">观看量(PV)</td>
          <td height="40" align="center" valign="middle" bgcolor="#f4f4f4">IP个数</td>
          <td height="40" align="center" valign="middle" bgcolor="#f4f4f4">观看总时长</td>
        </tr>
        <tr>
          <td height="50" align="center" valign="middle"><?php echo ceil($results['playTime']/60);?>分钟</td>
          <td height="50" align="center" valign="middle"><?php echo $results['uv'];?>人</td>
          <td height="50" align="center" valign="middle"><?php echo $results['pv'];?>次</td>
          <td height="50" align="center" valign="middle"><?php echo $results['ip'];?>个</td>
          <td height="50" align="center" valign="middle"><?php echo ceil($results['lookTime']/60);?>分钟</td>
        </tr>
      </table>
      <table width="998" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="40" colspan="2"><strong>观看量地域分布</strong></td>
        </tr>
        <tr>
          <td height="40">
            <div id="ChinaMap">
            
                <div id="map"></div>
                
                <div id="ToolTip" class="ToolTip" style="left:10px">
                    <div id="areaInfo"></div>
                    <div id="cityInfo"></div>
                </div>
                
               
                
            </div>
          </td>
          <td align="left" valign="top"><table width="234" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="35" align="center" valign="middle"><strong style="color:#999;">观看排名(PV)</strong></td>
            </tr>
            <tr>
              <td height="45" align="center" valign="top">
              	<div style="width:234px; height:30px; border:#CCC 1px solid; background:#66C;color:#FFF; border-top-left-radius:5px; border-top-right-radius:5px; float:left;">
                	<div style="width:60px; float:left; line-height:30px; text-align:center;">排名</div>
                    <div style="width:60px; float:left; line-height:30px; text-align:center;">省份</div>
                    <div style="width:114px; float:left; line-height:30px; text-align:center;">观看量</div>
                </div>
                
                <div style="width:234px; height:400px; overflow:auto; float:left;border-bottom:#CCC 1px solid;">
				<?php
					$i=0;
					foreach($regions->result_array() as $region)
					{
						$i++;
                ?>
                    <div style="width:232px; height:30px;color:#333; float:left; border-left:#CCC 1px solid; border-right:#ccc 1px solid; border-bottom:#CCC 1px solid;">
                        <div style="width:60px; float:left; line-height:30px; text-align:center;"><?php echo $i;?></div>
                        <div style="width:60px; float:left; line-height:30px; text-align:center;"><?php echo $region['name'];?></div>
                        <div style="width:112px; float:left; line-height:30px; text-align:center;"><?php echo $region['counts'];?></div>
                    </div>
                <?php
					}
				?>    
                </div>

              </td>
            </tr>
          </table></td>
        </tr>
      </table>
      
    </td>
  </tr>
  <tr>
    <td  colspan="2" align="left" valign="middle"style="padding-top:5px; padding-bottom:5px;">
    
    
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" valign="middle" style="padding-top:20px;"></td>
                  </tr>
                </table>
            </div>
        </div>
        
    </div>
    
    
	<style>
        .leftTree{width:200px; float:left; height:auto; border:#e4e4e4 1px solid; background:#f4f4f4; border-radius:5px;}
        .leftTree ul{padding:0; margin:0}
        .leftTree li{float:left;width:100%;font-size:14px;}
        .leftTree li a{width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center;}
        .leftTree li a:hover{text-decoration:none;width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center; background:#CCC;color:#000; font-weight:bold;}
        .leftTree .actived a{text-decoration:none;width:100%;line-height:50px; border-bottom:#CCC 1px dotted; float:left; text-align:center; background:#CCC;color:#000; font-weight:bold;}
    </style>    
    </td>
  </tr>
</table>
<?php
	require VIEWPATH.'admins/bottom.php';
?>

</body>
</html>