<?php
	//播放页面控制器
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	require 'Main.php';

	class Play extends Main
	{
		public function __construct()
		{
			parent::__construct();	
		}
		
		//PC电脑端播放页面
		public function item()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$data['res']=$query->row_array();
				
				//授权访问检测开始
				$this->ipNoAccess($id);
				//授权访问检测结束
				
				//调用数据统计模型开始
				$this->load->model('Results_model','results');	
				$this->results->inserts($id);
				$data['results']=$this->results->getOneRow($id);
				//调用数据统计模型结束
				
				//调用模块模型开始
				$this->load->model('Pother_model','Pother');	
				$this->Pother->inserts(['id'=>$id],$msg);
				$data['pother']=$this->Pother->getOneRow($id);
				//调用模块模型结束
				
				$this->load->view('pc_play_item.php',$data);	
			}
			else
			{
				header('location:/404.html');exit();	
			}
		}
		
		//手机二维码
		public function phoneShowCode()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$res=$query->row_array();
				require FCPATH.'assets/phpqrcode/phpqrcode.php';
				$object = new \QRcode();
				//生成二维码。第二个参数是false，代表不保存路径
				$url=http_url().'m/index/'.$res['id'].'.html';
				$object->png($url,false);
			}				
		}
		
		//ajax获取对应的往期视频信息
		public function mvAjax()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_pother` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$this->ipNoAccess($id,'ajaxs');
				
				//maxId分割变量接受处理开始
				isset($_GET['maxMvId']) && trim($_GET['maxMvId'])!=''?$maxId=intval($_GET['maxMvId']):$maxId=0;
				$data['maxId']=$maxId;
				//maxId分割变量接受处理结束
				
				$data['pother']=$query->row_array();
				
				$this->load->view('pc_play_mv.php',$data);	
			}
			else
			{
				ajaxs(300,'没找到数据');	
			}
		}
		
		//ajax获取评论信息
		public function commentLists()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$this->ipNoAccess($id,'ajaxs');
				
				$data['res']=$query->row_array();
				
				//maxId分割变量接受处理开始
				isset($_GET['commentsMinID']) && trim($_GET['commentsMinID'])!=''?$commentsMinID=intval($_GET['commentsMinID']):$commentsMinID=0;
				isset($_GET['commentsMaxID']) && trim($_GET['commentsMaxID'])!=''?$commentsMaxID=intval($_GET['commentsMaxID']):$commentsMaxID=0;
				isset($_GET['commentsDate']) && trim($_GET['commentsDate'])!=''?$commentsDate=trim($_GET['commentsDate']):$commentsDate='';
				
				isset($_GET['indexNumber']) && trim($_GET['indexNumber'])!=''?$data['indexNumber']=intval($_GET['indexNumber']):$data['indexNumber']=1;
				//maxId分割变量接受处理结束
				
				$data['dataArray']=explode(',',$commentsDate);
				$data['commentsMinID']=$commentsMinID;
				$data['commentsMaxID']=$commentsMaxID;
				
				if($commentsDate=='' && $commentsMaxID==0 && $commentsMinID==0)
				{
					//加载置顶消息
					$data['Topquery']=$this->db->query("select * from `mv_comments_".$id."` where `top`='2'  and `show`=2 limit 0,1");	
				}
				
				if($commentsMinID==0)
				{
					$maxwhere='';
					if($data['commentsMaxID']>0)
					{
						$maxwhere= " and `id`<'".$data['commentsMaxID']."'";	
					}
					$data['query']=$this->db->query("select * from `mv_comments_".$id."` where `top`='1'  and `show`=2 ".$maxwhere." order by `id` desc limit 0,30");
				}
				else
				{
					$data['query']=$this->db->query("select * from `mv_comments_".$id."` where `top`='1'  and `show`=2 and `id`<'$commentsMinID' ".$maxwhere." order by `id` desc limit 0,30");	
				}
				
				
				$this->load->view('pc_play_comments.php',$data);	
			}
			else
			{
				ajaxs(300,'没找到数据');	
			}	
		}
		
		//ajax获取置顶的那条数据
		public function mvAjaxDing()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$this->ipNoAccess($id,'ajaxs');
				
				$data['res']=$query->row_array();
				
				$data['Topquery']=$this->db->query("select * from `mv_comments_".$id."` where `top`='2' and `show`=2 limit 0,1");	

				$this->load->view('pc_play_top_comments.php',$data);	
			}
			else
			{
				ajaxs(300,'没找到数据');	
			}				
		}
		
		//ajax获取单挑信息
		public function mvAjaxItem()
		{
			$id=intval($this->uri->segment(3));
			$cid=intval($this->uri->segment(4));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$this->ipNoAccess($id,'ajaxs');
				
				$data['res']=$query->row_array();
				
				$data['Topquery']=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid' and `show`=2 limit 0,1");	

				$this->load->view('pc_play_item_comments.php',$data);	
			}
			else
			{
				ajaxs(300,'没找到数据');	
			}	
		}
		
		//ajax获取单挑信息
		public function mvAjaxItems()
		{
			$id=intval($this->uri->segment(3));
			$cid=intval($this->uri->segment(4));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$this->ipNoAccess($id,'ajaxs');
				
				$data['res']=$query->row_array();
				
				$data['Topquery']=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid' and `show`=2 limit 0,1");	

				$this->load->view('pc_play_item_comment.php',$data);	
			}
			else
			{
				ajaxs(300,'没找到数据');	
			}				
		}
		
		//ajax获取最新的消息
		public function  mvAjaxNew()
		{
			$id=intval($this->uri->segment(3));
			$sql="select * from `mv_projects` where `id`='$id'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$this->ipNoAccess($id,'ajaxs');
				
				$data['res']=$query->row_array();
				
				//maxId分割变量接受处理开始
				isset($_GET['commentsMaxID']) && trim($_GET['commentsMaxID'])!=''?$commentsMaxID=intval($_GET['commentsMaxID']):$commentsMaxID=0;
				isset($_GET['commentsDate']) && trim($_GET['commentsDate'])!=''?$commentsDate=trim($_GET['commentsDate']):$commentsDate='';
				//maxId分割变量接受处理结束
				
				$data['dataArray']=explode(',',$commentsDate);
				$data['commentsMaxID']=$commentsMaxID;
				
				$data['query']=$this->db->query("select * from `mv_comments_".$id."` where `top`='1' and `show`=2 and `id`>'$commentsMaxID' order by `id` desc");	
				
				$this->load->view('pc_play_new_comments.php',$data);	
			}
			else
			{
				ajaxs(300,'没找到数据');	
			}	
		}
		
		//提交评论信息
		public function commentSub()
		{
			if(!$this->userInfo)
			{
				ajaxs(300,'没有获取登录信息！');
			}		
			else
			{
				if($this->userInfo['comment_state']!=1)
				{
					ajaxs(300,'您已被禁言，无法提交信息');	
				}
				isset($_POST['textSay']) && strlen(trim($_POST['textSay']))>0 && strlen(trim($_POST['textSay']))<1500 && substr_count($_POST['textSay'],'||||')<=0?$textSay=P('textSay'):ajaxs(300,'参数错误');
				isset($_POST['fileAll']) && strlen(trim($_POST['fileAll']))!=''?$fileAll=$_POST['fileAll']:ajaxs(300,'参数错误');
				
				$this->db->trans_begin();
				$id=intval($this->uri->segment(3));
				$sql="select * from `mv_projects` where `id`='$id'";
				$query=$this->db->query($sql);
				if($query->num_rows()>0)
				{
					$this->ipNoAccess($id,'ajaxs');//检测IP合法性
					
					$result=$query->row_array();
					if($result['insertState']!=1)
					{
						ajaxs(300,'抱歉：系统已关闭话题功能');	
					}
					$fileArray=[];
					if($fileAll!='' && $fileAll!='{}')
					{
						$fileAll=json_decode($fileAll,true);
						$i=0;
						foreach($fileAll as $file)
						{
							$fileArray[$i]['file']=self::copyImg($file);
							if(!$fileArray[$i]['file'])
							{
								self::delTmpFile($fileArray[$i]);
								ajaxs(300,'抱歉：图片上传失败，请重新上传');	
							}
							$i++;
						}	
					}
					$_array=[
						'uid'=>$this->userInfo['id'],
						'admins'=>0,
						'nickname'=>$this->userInfo['nickname'],
						'avatar'=>$this->userInfo['avatar'],
						'contents'=>$textSay,
						'time'=>time(),
						'ip'=>get_ip(),
						'honor'=>'',
						'up'=>0,
						'top'=>1,
						'reply'=>0,
						'replyJson'=>'',
						'upJson'=>'',
						'file'=>json_encode($fileArray),
						'show'=>2
					];
					if($result['checkState']==1)
					{
						$_array['show']=1;
					}
					$checkState=$result['checkState'];
					$this->db->insert('comments_'.$id,$_array);
					$insert_id=$this->db->insert_id();
					//累加总和数据
					$query=$this->db->query("select * from `mv_cnums` where `id`='$id'");
					if($query->num_rows()>0)
					{
						$result=$query->row_array();
						$_array=[
							'all'=>$result['all']+1,
							'pass'=>$result['pass'],
							'nopass'=>$result['nopass'],
							'time'=>time(),
						];
						if($checkState==1)
						{
							$_array['nopass']=$_array['nopass']+1;	
						}
						else
						{
							$_array['pass']=$_array['pass']+1;	
						}
						$this->db->update('cnums',$_array,['id'=>$id]);
					}
					else
					{
						$_array=[
							'id'=>$id,
							'all'=>1,
							'pass'=>0,
							'nopass'=>0,
							'time'=>time(),
						];	
						if($checkState==1)
						{
							$_array['nopass']=$_array['nopass']+1;	
						}
						else
						{
							$_array['pass']=$_array['pass']+1;	
						}
						$this->db->insert('cnums',$_array);
					}
					
					if($this->db->trans_status()===false)
					{
						$this->db->trans_rollback();
						ajaxs(300,'网络故障，请您稍后再试');
					}
					else
					{
						$this->db->trans_commit();
						
						if($checkState==2)
						{
							ajaxs(100,'发布成功++++'.$insert_id);
						}
						else
						{
							ajaxs(100,'发布成功，通过审核后会立即显示++++'.$insert_id);	
						}
					}
				}
				else
				{
					ajaxs(300,'没找到数据');	
				}
			}
		}
		
		//提交评论信息
		public function commentReSub()
		{
			if(!$this->userInfo)
			{
				ajaxs(300,'没有获取登录信息！');
			}		
			else
			{
				if($this->userInfo['comment_state']!=1)
				{
					ajaxs(300,'您已被禁言，无法提交信息');	
				}
				isset($_POST['textSay']) && strlen(trim($_POST['textSay']))>0 && strlen(trim($_POST['textSay']))<1500 && substr_count($_POST['textSay'],'||||')<=0?$textSay=P('textSay'):ajaxs(300,'参数错误');
				$this->db->trans_begin();
				$id=intval($this->uri->segment(3));
				$cid=intval($this->uri->segment(4));
				$sql="select * from `mv_projects` where `id`='$id'";
				$query=$this->db->query($sql);
				if($query->num_rows()>0)
				{
					$this->ipNoAccess($id,'ajaxs');//检测IP合法性
					$result=$query->row_array();
					if($result['replyState']!=1)
					{
						ajaxs(300,'抱歉：系统已关闭话题回复功能');	
					}
					
					$query=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid'");
					if($query->num_rows()>0)
					{
						$res=$query->row_array();
						$json=json_decode($res['replyJson'],true);
						
						$key=count($json);
						
						$json[$key]=[
							'id'=>date('YmdHis').substr(microtime(),2,8),
							'sayState'=>2,//2正常1.禁言
							'nickname'=>$this->userInfo['nickname'],
							'avatar'=>$this->userInfo['avatar'],
							'contents'=>$textSay,
							'honor'=>'',
							'state'=>1,
							'time'=>time()
						];
						$json[$key]['state']=$result['checkState'];
						
						$reShow=2;
						$c=0;
						for($i=0;$i<count($json);$i++)
						{
							if($json[$i]['state']==1)
							{
								$reShow=1;	
							}	
							if($json[$i]['state']==2)
							{
								$c++;	
							}	
						}
						
						$_array=[
							'replyJson'=>json_encode($json),
							'reShow'=>$reShow,
							'reply'=>$c,
						];
						if($json[$key]['state']==1)
						{
							$_array['reShow']=1;
							//更新一下对应的统计表
							$this->db->query("update `mv_cnums` set `all`=`all`+1,`nopass`=`nopass`+1 where `id`='$id'");	
						}
						else
						{
							$this->db->query("update `mv_cnums` set `all`=`all`+1,`pass`=`pass`+1 where `id`='$id'");	
						}
						//print_r($_array);die();
						
						$this->db->update('comments_'.$id,$_array,['id'=>$cid]);
						
						if($this->db->trans_status()===false)
						{
							$this->db->trans_rollback();
							ajaxs(300,'网络故障，请您稍后再试');
						}
						else
						{
							$this->db->trans_commit();
							if($result['checkState']==2)
							{
								ajaxs(100,'发布成功++++'.$cid);
							}
							else
							{
								ajaxs(100,'发布成功，通过审核后会立即显示++++'.$cid);	
							}
						}
						
						
					}
					else
					{
						ajaxs(300,'没找到数据');
					}
				}
				else
				{
					ajaxs(300,'没找到数据');	
				}
			}
		}
		
		//点赞
		public function commentReSubUp()
		{
			if(!$this->userInfo)
			{
				ajaxs(300,'没有获取登录信息！');
			}		
			else
			{
				if($this->userInfo['comment_state']!=1)
				{
					ajaxs(300,'您已被禁言，无法提交信息');	
				}
				$this->db->trans_begin();
				$id=intval($this->uri->segment(3));
				$cid=intval($this->uri->segment(4));
				$sql="select * from `mv_projects` where `id`='$id'";
				$query=$this->db->query($sql);
				if($query->num_rows()>0)
				{
					$this->ipNoAccess($id,'ajaxs');//检测IP合法性
					$result=$query->row_array();
					
					$query=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid'");
					if($query->num_rows()>0)
					{
						$res=$query->row_array();
						if(substr_count($res['upJson'],'User:'.$this->userInfo['id'].',')>0)
						{
							ajaxs('300','您已点赞，无需重复操作');	
						}
						$json=$res['upJson'].'User:'.$this->userInfo['id'].',';
						$_array=[
							'upJson'=>$json,
							'up'=>$res['up']+1
						];
						
						$this->db->update('comments_'.$id,$_array,['id'=>$cid]);
						
						if($this->db->trans_status()===false)
						{
							$this->db->trans_rollback();
							ajaxs(300,'网络故障，请您稍后再试');
						}
						else
						{
							$this->db->trans_commit();
							ajaxs(100,$_array['up']);
						}
						
						
					}
					else
					{
						ajaxs(300,'没找到数据');
					}
				}
				else
				{
					ajaxs(300,'没找到数据');	
				}
			}	
		}
		
		
		
		
	}