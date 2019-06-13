<?php
	
	//项目控制器
	
	require 'Main.php';

	class Projecteds extends Main
	{
			
		public function __construct()
		{
			parent::__construct();	
		}
		
		//检测当前的项目合法性
		private function getProjectInfo($id)
		{
			$this->load->model('Projects_model','projects');	
			$res=$this->projects->getOneRow($id);
			return $res;
		}
		
		//获取项目的总评论条数
		protected function getProjectNum($id)
		{
			$query=$this->db->query("select * from `".$this->db->dbprefix."cnums` where `id`='$id'");
			if($query->num_rows()<=0)
			{
				$_array=[
					'id'=>$id,
					'all'=>0,
					'pass'=>0,
					'nopass'=>0,
					'time'=>time()
				];
				$this->db->insert('cnums',$_array);
				return $this->getProjectNum($id);	
			}	
			else
			{
				return $query->row_array();		
			}
		}
		
		//主页
		public function index()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='index';
			$data['map']='projected';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/index.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}	
		}
		
		//修改主页的信息
		public function indexEdit()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			isset($_GET['act']) && is_numeric($_GET['act'])?$act=intval($_GET['act']):ajaxs(300,'参数错误');
			if($act==1)
			{
				//直接处理发帖的相关数据信息
				isset($_POST['filed']) && trim($_POST['filed'])!=''?$filed=trim($_POST['filed']):ajaxs(300,'参数错误');
				isset($_POST['value']) && trim($_POST['value'])!=''?$value=trim($_POST['value']):ajaxs(300,'参数错误');	
				$this->load->model('Projects_model','projects');	
				$res=$this->projects->editOther(['filed'=>$filed,'value'=>$value,'id'=>$id],$msg);
				if($res)
				{
					ajaxs(100,'更新成功');	
				}
				ajaxs(300,$msg);	
				
				
			}	
		}
		
		//开启直播
		public function openLive()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			if($res['state']==1)
			{
				$this->db->query("update `mv_projects` set `endTime`='".time()."',`state`='2' where `id`='$id'");
				ajaxs(100,'直播开启成功');	
			}	
			else
			{
				ajaxs(300,'直播已开启，请勿重复操作');		
			}
		}
		
		//关闭直播
		public function closeLive()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			if($res['state']==2)
			{
				$time=time();
				$useTime=$time-$res['endTime'];
				$this->db->query("update `mv_projects` set `state`='1',`endTime`='$time' where `id`='$id'");
				$this->load->model('Results_model','results');	
				$this->results->inserts($id);
				$result=$this->results->getOneRow($id);
				$_array=[
					'playTime'=>$result['playTime']+$useTime,
					'time'=>time()
				];
				$this->db->update('results',$_array,['id'=>$id]);
				ajaxs(100,'直播关闭成功');	
			}	
			else
			{
				ajaxs(300,'直播已经关闭，请勿重复操作');		
			}
		}
		
		//开启调试观看
		public function openTestLive()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			if($res['test']==1)
			{
				
				$this->db->query("update `mv_projects` set `test`='2' where `id`='$id'");
				ajaxs(100,'成功开启调试观看');	
			}	
			else
			{
				ajaxs(300,'调试观看已开启，请勿重复操作');		
			}
		}
		
		//关闭调试观看
		public function closeTestLive()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			if($res['test']==2)
			{
				
				$this->db->query("update `mv_projects` set `test`='1' where `id`='$id'");
				ajaxs(100,'成功关闭调试观看');	
			}	
			else
			{
				ajaxs(300,'调试观看已关闭，请勿重复操作');		
			}
		}
		
		//ajax加载对应信息
		public function indexComments()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			$pageindex=intval($this->uri->segment(5));
			isset($_GET['minId']) && is_numeric($_GET['minId'])?$minId=intval($_GET['minId']):$minId=0;
			isset($_GET['maxId']) && is_numeric($_GET['maxId'])?$maxId=intval($_GET['maxId']):$maxId=0;
			isset($_GET['selectId']) && is_numeric($_GET['selectId'])?$selectId=intval($_GET['selectId']):$selectId=1;
			$data['minId']=$minId;
			$data['maxId']=$maxId;
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$where='';
			$pagesize=30;
			if($selectId==2 || $selectId==3)
			{
				if($selectId==2)
				{
					$where=" and `show`='2' and `reShow`='2'";		
				}
				else
				{
					$where=" and (`show`='1' or `reShow`='1')";		
				}
			}
			if($minId==0)
			{
				//第一页的查询
				$data['query']=$this->db->query("select * from `".$this->db->dbprefix."comments_".$id."` where `top`=1 ".$where." order by `id` desc limit 0,".$pagesize);
				//echo "select * from `".$this->db->dbprefix."comments_".$id."` where `top`=1 ".$where." order by `id` desc limit 0,30";
			}
			else
			{
				//第二页的查询
				$data['query']=$this->db->query("select * from `".$this->db->dbprefix."comments_".$id."` where `id`<'$minId' and `top`=1 ".$where." order by `id` desc limit 0,".$pagesize);
				//echo "select * from `".$this->db->dbprefix."comments_".$id."` where `id`<'$minId' and `top`=1 ".$where." order by `id` desc limit 0,30";	
			}
			
			$data['top']='';
			if($minId==0)
			{
				//读取一下置顶的那条信息
				$topQuery=$this->db->query("select * from `".$this->db->dbprefix."comments_".$id."` where `top`=2 ".$where." limit 0,1");
				if($topQuery->num_rows()>0)
				{
					$data['top']=$topQuery->row_array();		
				}
			}
			
			$this->load->view('admins/projecteds/indexComments.php',$data);
				
		}
		
		//ajax清空表
		public function clearComments()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$this->db->query("truncate table `mv_comments_".$id."`");
			$this->db->query("update `mv_cnums` set `all`=0,`pass`=0,`nopass`=0,`time`='".time()."' where `id`='$id'");
			ajaxs(100,'清空成功');					
		}
		
		//获取最新的消息
		public function indexCommentsNew()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			$pageindex=intval($this->uri->segment(5));
			isset($_GET['minId']) && is_numeric($_GET['minId'])?$minId=intval($_GET['minId']):$minId=0;
			isset($_GET['maxId']) && is_numeric($_GET['maxId'])?$maxId=intval($_GET['maxId']):$maxId=0;
			isset($_GET['selectId']) && is_numeric($_GET['selectId'])?$selectId=intval($_GET['selectId']):$selectId=1;
			$data['minId']=$minId;
			$data['maxId']=$maxId;
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$where='';
			if($selectId==2 || $selectId==3)
			{
				if($selectId==2)
				{
					$where=" and `show`='2' and `reShow`='2'";		
				}
				else
				{
					$where=" and `show`='1' or `reShow`='1'";		
				}
				
			}

			$data['query']=	$this->db->query("select * from `".$this->db->dbprefix."comments_".$id."` where `id`>'$maxId' and `top`=1 ".$where." order by `id` desc");	
			
			$this->load->view('admins/projecteds/indexCommentsTop.php',$data);	
		}
		
		//获取单挑信息
		public function indexCommentsItem()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			isset($_GET['id']) && is_numeric($_GET['id'])?$cid=intval($_GET['id']):$cid=0;
			isset($_GET['selectId']) && is_numeric($_GET['selectId'])?$selectId=intval($_GET['selectId']):$selectId=1;
			$where='';
			if($selectId==2 || $selectId==3)
			{
				if($selectId==2)
				{
					$where=" and `show`='2' and `reShow`='2'";		
				}
				else
				{
					$where=" and (`show`='1' or `reShow`='1')";		
				}
				
			}
			$data['query']=	$this->db->query("select * from `".$this->db->dbprefix."comments_".$id."` where `id`='$cid'".$where." ");	
			if($data['query']->num_rows()>0)
			{
				$this->load->view('admins/projecteds/indexCommentsItem.php',$data);
			}
			
		}
		
		//通过一下点评信息
		public function tongguoItem()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$cid=intval($this->uri->segment(5));
			$nid=trim($this->uri->segment(6));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$query=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid'");
			if($query->num_rows()>0)
			{
				$reShow=2;
				$c=0;
				$array=$query->row_array();
				$arr=json_decode($array['replyJson'],true);
				for($i=0;$i<count($arr);$i++)
				{
					if($arr[$i]['id']==$nid)
					{
						$arr[$i]['state']=2;	
					}
					else
					{
						if($arr[$i]['state']==1)
						{
							$reShow=1;	
						}	
					}
					if($arr[$i]['state']==2)
					{
						$c++;	
					}	
				}
				//print_r($arr);die();
				$_array=[
					'reShow'=>$reShow,
					'replyJson'=>json_encode($arr),
					'reply'=>$c
				];
				$this->db->update('comments_'.$id,$_array,['id'=>$cid]);
				$this->getAllZZ($id,$all,$pass,$nopass);
				$this->db->query("update `mv_cnums` set `all`='$all',`pass`='$pass',`nopass`='$nopass',`time`='".time()."' where `id`='$id'");
				ajaxs(100,'审核通过');
			}
			else
			{
				ajaxs(300,'没有找到对应信息');	
			}	
		}
		
		//删除点评下的消息
		public function delItem()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$cid=intval($this->uri->segment(5));
			$nid=trim($this->uri->segment(6));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$query=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid'");
			if($query->num_rows()>0)
			{
				$reShow=2;
				$array=$query->row_array();
				$arr=json_decode($array['replyJson'],true);
				
				$_arr=[];
				$a=0;
				$c=0;
				for($i=0;$i<count($arr);$i++)
				{
					if($arr[$i]['id']!=$nid)
					{
						$_arr[$a]=$arr[$i];
						if($_arr[$a]['state']==1)
						{
							$reShow=1;	
						}
						$a++;
					}
				}
				
				for($i=0;$i<count($_arr);$i++)
				{
					if($_arr[$i]['state']==2)
					{
						$c++;	
					}
				}

				$_array=[
					'reShow'=>$reShow,
					'replyJson'=>json_encode($_arr),
					'reply'=>$c
				];
				$this->db->update('comments_'.$id,$_array,['id'=>$cid]);
				$this->getAllZZ($id,$all,$pass,$nopass);
				$this->db->query("update `mv_cnums` set `all`='$all',`pass`='$pass',`nopass`='$nopass',`time`='".time()."' where `id`='$id'");
				ajaxs(100,'删除成功');
			}
			else
			{
				ajaxs(300,'没有找到对应信息');	
			}				
		}
		
		
		
		//发布消息
		public function insertComments()
		{
			$this->userAjaxState();	
			isset($_POST['textSay']) && strlen(trim($_POST['textSay']))>5 && strlen(trim($_POST['textSay']))<1500 && substr_count($_POST['textSay'],'||||')<=0?$textSay=P('textSay'):ajaxs(300,'参数错误');
			isset($_POST['fileAll']) && strlen(trim($_POST['fileAll']))!=''?$fileAll=$_POST['fileAll']:ajaxs(300,'参数错误');
			isset($_POST['nowId']) && strlen(trim($_POST['nowId']))!=''?$nowId=$_POST['nowId']:$nowId='';
			
			if($nowId=='' || !is_numeric($nowId))
			{
				$this->db->trans_begin();
				$id=intval($this->uri->segment(4));
				$res=$this->getProjectInfo($id);
				if(!$res)
				{
					ajaxs(300,'没找到对应信息');	
				}
				$sql="select * from `mv_projects` where `id`='$id'";
				$query=$this->db->query($sql);
				if($query->num_rows()>0)
				{
					
					$result=$query->row_array();
					$fileArray=[];
					if($fileAll!='' && $fileAll!='{}')
					{
						$fileAll=json_decode($fileAll,true);
						$i=0;
						foreach($fileAll as $file)
						{
							$fileArray[$i]['file']=$file;
							$i++;
						}	
					}
					$_array=[
						'uid'=>0,
						'admins'=>$res['id'],
						'nickname'=>$res['nickname'],
						'avatar'=>$res['avatar']==''?'upload/20180911/2018091115353051494600.jpg':$res['avatar'],
						'contents'=>$textSay,
						'time'=>time(),
						'ip'=>get_ip(),
						'honor'=>$res['honor'],
						'up'=>0,
						'top'=>1,
						'reply'=>0,
						'replyJson'=>'',
						'upJson'=>'',
						'file'=>json_encode($fileArray),
						'show'=>2
					];
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
						$_array['pass']=$_array['pass']+1;	
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
						$_array['pass']=$_array['pass']+1;	
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
						ajaxs(100,$insert_id);
					}
				}
				else
				{
					ajaxs(300,'没找到数据');	
				}	
				
			}
			else
			{
				$this->db->trans_begin();
				$id=intval($this->uri->segment(4));
				$res=$this->getProjectInfo($id);
				if(!$res)
				{
					ajaxs(300,'没找到对应信息');	
				}
				$sql="select * from `mv_projects` where `id`='$id'";
				$query=$this->db->query($sql);
				$cid=$nowId;
				if($query->num_rows()>0)
				{
					
					$result=$query->row_array();
					
					$query=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid'");
					if($query->num_rows()>0)
					{
						$res1=$query->row_array();
						$json=json_decode($res1['replyJson'],true);
						
						$key=count($json);
						
						$json[$key]=[
							'id'=>date('YmdHis').substr(microtime(),2,8),
							'sayState'=>2,//2正常1.禁言
							'nickname'=>$res['nickname'],
							'avatar'=>$res['avatar']==''?'upload/20180911/2018091115353051494600.jpg':$res['avatar'],
							'contents'=>$textSay,
							'honor'=>$res['honor'],
							'state'=>2,
							'time'=>time()
						];
						
						$c=0;
						
						for($i=0;$i<count($json);$i++)
						{
							if($json[$i]['state']==2)
							{
								$c++;	
							}	
						}
							
						$_array=[
							'replyJson'=>json_encode($json),
							'reply'=>$c
						];
						
						$this->db->query("update `mv_cnums` set `all`=`all`+1,`pass`=`pass`+1 where `id`='$id'");	
						
						$this->db->update('comments_'.$id,$_array,['id'=>$cid]);
						
						if($this->db->trans_status()===false)
						{
							$this->db->trans_rollback();
							ajaxs(300,'网络故障，请您稍后再试');
						}
						else
						{
							$this->db->trans_commit();
							ajaxs(100,$cid.'++++500');
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
		public function zanyizan()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$cid=intval($this->uri->segment(5));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$query=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid'");
			if($query->num_rows()>0)
			{
				$array=$query->row_array();
				if(substr_count($array['upJson'],'Admin:'.$this->adminInfo['id'].',')>0)
				{
					ajaxs(300,'抱歉：您已点过赞');	
				}		
				else
				{
					$_array=[
						'upJson'=>$array['upJson'].'Admin:'.$this->adminInfo['id'].',',
						'up'=>$array['up']+1,
					];	
					$this->db->update('comments_'.$id,$_array,['id'=>$cid]);
					ajaxs(100,'点赞成功');
				}
			}
			else
			{
				ajaxs(300,'没有找到对应信息');	
			}
		}
		
		//顶一下
		public function ding()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$cid=intval($this->uri->segment(5));
			if($this->db->query("update `mv_comments_".$id."` set `top`='2' where `id`='$cid'"))
			{
				$this->db->query("update `mv_comments_".$id."` set `top`='1' where `id`!='$cid'");
				ajaxs(100,'置顶成功');	
			}	
			else
			{
				ajaxs(300,'网路连接失败');	
			}	
		}
		
		//取消置顶
		public function noding()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$cid=intval($this->uri->segment(5));
			if($this->db->query("update `mv_comments_".$id."` set `top`='1' where `id`='$cid'"))
			{
				ajaxs(100,'成功取消置顶');	
			}	
			else
			{
				ajaxs(300,'网路连接失败');	
			}			
		}
		
		//审核消息
		public function shenhe()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$cid=intval($this->uri->segment(5));
			if($this->db->query("update `mv_comments_".$id."` set `show`='2' where `id`='$cid'"))
			{
				$this->getAllZZ($id,$all,$pass,$nopass);
				$this->db->query("update `mv_cnums` set `all`='$all',`pass`='$pass',`nopass`='$nopass',`time`='".time()."' where `id`='$id'");
				ajaxs(100,'审核成功');	
			}	
			else
			{
				ajaxs(300,'网路连接失败');	
			}
		}
	
		//获取最新的信息，做统计
		private function getAllZZ($id,&$all,&$pass,&$nopass)
		{
			$query=$this->db->query("select count(`id`) as `count` from `mv_comments_".$id."`");
			$res=$query->row_array();
		
			$res['count']=='' || $res['count']==0?$all=0:$all=$res['count'];
			
			$query=$this->db->query("select count(`id`) as `count` from `mv_comments_".$id."` where `show`='2' and `reShow`='2'");
			$res=$query->row_array();
			$res['count']=='' || $res['count']==0?$pass=0:$pass=$res['count'];
			
			$query=$this->db->query("select count(`id`) as `count` from `mv_comments_".$id."` where `show`='1' or `reShow`='1'");
			$res=$query->row_array();
			$res['count']=='' || $res['count']==0?$nopass=0:$nopass=$res['count'];
		}
		
		//删除消息
		public function cdel()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$cid=intval($this->uri->segment(5));
			if($this->db->query("delete from `mv_comments_".$id."` where `id`='$cid'"))
			{
				$this->getAllZZ($id,$all,$pass,$nopass);
				$this->db->query("update `mv_cnums` set `all`='$all',`pass`='$pass',`nopass`='$nopass',`time`='".time()."' where `id`='$id'");
				ajaxs(100,'删除成功');	
			}	
			else
			{
				ajaxs(300,'网路连接失败');	
			}	
		}
		
		//禁言信息
		public function jinyan()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$cid=intval($this->uri->segment(5));
			$query=$this->db->query("select * from `mv_comments_".$id."` where `id`='$cid'");
			if($query->num_rows()>0)
			{
				$result=$query->row_array();
				$this->db->query("update `mv_comments_".$id."` set `noSay`='2' where `id`='$cid'");
				if($result['uid']==0 && $result['admins']>0)
				{
					//管理员
					ajaxs(100,'管理员发布信息，无法禁言');	
				}
				else
				{
					if($result['uid']>0)
					{
						$this->db->query("update `mv_users` set `comment_state`='2' where `id`='".$result['uid']."'");	
					}	
					else
					{
						//查询ip把ip累加到黑名单
						$this->load->model('Ip_model','ip');	
						$this->ip->inserts(['id'=>$id],$msg);
						$querys=$this->db->query("select * from `mv_ip` where `id`='$id'");
						$results=$querys->row_array();
						$str=$results['noallowedIp']."\n".$result['ip'];
						$_array=[
							'noallowedIp'=>trim($str,"\n")
						];
						$this->db->update('ip',$_array,['id'=>$id]);
					}
					ajaxs(100,'禁言成功');	
				}
			}
			else
			{
				ajaxs(300,'没有找到对应数据');	
			}
			
			
		}
		
		//获取条数信息
		public function indexCommentsNums()
		{
			if(!$this->adminInfo)
			{
				echo json_encode(['code'=>200,'message'=>'登录失败']);exit();	
			}	
			else
			{
				$id=intval($this->uri->segment(4));
				$res=$this->getProjectInfo($id);	
				if(!$res)
				{
					echo json_encode(['code'=>300,'message'=>'频道信息获取有误']);exit();			
				}
				else
				{
					$this->getAllZZ($id,$all,$pass,$nopass);
					echo json_encode(['code'=>100,'alls'=>$all,'pass'=>$pass,'nopass'=>$nopass]);exit();	
				}
			}
		}
		
		//修改头像的显示窗口
		public function indexAvatar()
		{
			if(!$this->adminInfo)
			{
				echo '<script>parent.editNickName(200,"登录失败");</script>';exit();
			}
			else
			{
				$id=intval($this->uri->segment(4));
				$data['res']=$this->getProjectInfo($id);	
				if(!$data['res'])
				{
					echo '<script>parent.editNickName(300,"没有找到频道信息");</script>';exit();		
				}
				else
				{
					$this->load->view('admins/projecteds/indexAvatar.php',$data);	
				}	
			}	
		}
		
		//删除图片
		public function indexUploadFileDel()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			isset($_GET['url']) && trim($_GET['url'])!=''?$url=trim($_GET['url']):ajaxs(300,'参数错误');
			if(is_file(FCPATH.$url))
			{
				@unlink(FCPATH.$url);	
			}				
		}
		
		//修改头像等信息
		public function indexAvatarUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['nickname']) && trim($_POST['nickname'])!=''?$nickname=trim($_POST['nickname']):ajaxs(300,'参数错误');
			isset($_POST['avatar']) && trim($_POST['avatar'])!=''?$avatar=trim($_POST['avatar']):$avatar='';
			isset($_POST['honor']) && trim($_POST['honor'])!=''?$honor=trim($_POST['honor']):$honor='';	
			$this->load->model('Projects_model','projects');	
			$res=$this->projects->editNickName(['nickname'=>$nickname,'avatar'=>$avatar,'honor'=>$honor,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);
					
		}
		
		
		
		/**********************频道设置开始****************************/
		
		//观看页主题设置
		public function family()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/family.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}	
		}
		
		//提交观看页主题设置
		public function familyUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['mobileCodeShow']) && trim($_POST['mobileCodeShow'])!=''?$mobileCodeShow=trim($_POST['mobileCodeShow']):ajaxs(300,'参数错误');
			isset($_POST['logoVal']) && trim($_POST['logoVal'])!=''?$logoVal=trim($_POST['logoVal']):$logoVal='';
			isset($_POST['bgFileVal']) && trim($_POST['bgFileVal'])!=''?$bgFileVal=trim($_POST['bgFileVal']):$bgFileVal='';	
			isset($_POST['backColor']) && trim($_POST['backColor'])!=''?$backColor=trim($_POST['backColor']):$backColor='';	
			isset($_POST['bottomColor']) && trim($_POST['bottomColor'])!=''?$bottomColor=trim($_POST['bottomColor']):$bottomColor='';	
			isset($_POST['bottomText']) && trim($_POST['bottomText'])!=''?$bottomText=trim($_POST['bottomText']):$bottomText='';	

			$this->load->model('Projects_model','projects');	
			$res=$this->projects->familyUpdate(['mobileCodeShow'=>$mobileCodeShow,'logoVal'=>$logoVal,'bgFileVal'=>$bgFileVal,'backColor'=>$backColor,'bottomText'=>$bottomText,'bottomColor'=>$bottomColor,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);	
		}
		
		//直播引导图
		public function zbydt()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='zbydt';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/zbydt.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}				
		}
		
		//直播引导图更新
		public function zbydtUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['mobileStartShow']) && trim($_POST['mobileStartShow'])!=''?$mobileStartShow=trim($_POST['mobileStartShow']):ajaxs(300,'参数错误');
			isset($_POST['mobileStartFile']) && trim($_POST['mobileStartFile'])!=''?$mobileStartFile=trim($_POST['mobileStartFile']):$mobileStartFile='';

			$this->load->model('Projects_model','projects');	
			$res=$this->projects->zbydtUpdate(['mobileStartShow'=>$mobileStartShow,'mobileStartFile'=>$mobileStartFile,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);				
		}
		
		//手机二维码
		public function phoneShowCode()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if($res)
			{
				require FCPATH.'assets/phpqrcode/phpqrcode.php';
				$object = new \QRcode();
				//生成二维码。第二个参数是false，代表不保存路径
				$url=http_url().'m/index/'.$res['id'].'.html';
				$object->png($url,false);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}				
		}
		
		//引导图预览二维码
		public function ydtShowCode()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if($res)
			{
				require FCPATH.'assets/phpqrcode/phpqrcode.php';
				$object = new \QRcode();
				//生成二维码。第二个参数是false，代表不保存路径
				$url=admin_url().'projecteds/ydtPhoneShow/'.$res['id'];
				$object->png($url,false);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}				
		}
		
		//引导图手机模式预览
		public function ydtPhoneShow()
		{
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if($res)
			{
				$this->load->view('admins/projecteds/ydtPhoneShow.php',['res'=>$res]);
			}	
		}
		
		//直播倒计时
		public function djs()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='djs';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/djs.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}			
		}
		
		//倒计时更新
		public function djsUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['timeOverShow']) && trim($_POST['timeOverShow'])!=''?$timeOverShow=trim($_POST['timeOverShow']):ajaxs(300,'参数错误');
			isset($_POST['timeOver']) && trim($_POST['timeOver'])!=''?$timeOver=trim($_POST['timeOver']):$timeOver='';
			isset($_POST['timeOverText']) && trim($_POST['timeOverText'])!=''?$timeOverText=trim($_POST['timeOverText']):$timeOverText='';

			$this->load->model('Projects_model','projects');	
			$res=$this->projects->djsUpdate(['timeOverShow'=>$timeOverShow,'timeOver'=>$timeOver,'timeOverText'=>$timeOverText,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);	
		}
		
		//观众人数显示设置
		public function gzrsxssz()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='gzrsxssz';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/gzrsxssz.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}	
		}
		
		//观众人数显示更新
		public function gzrsxsszUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['playNumsState']) && trim($_POST['playNumsState'])!=''?$playNumsState=trim($_POST['playNumsState']):ajaxs(300,'参数错误');
			isset($_POST['playNumsSuccess']) && trim($_POST['playNumsSuccess'])!=''?$playNumsSuccess=trim($_POST['playNumsSuccess']):$playNumsSuccess='';
			isset($_POST['playNumsDefaults']) && trim($_POST['playNumsDefaults'])!=''?$playNumsDefaults=trim($_POST['playNumsDefaults']):$playNumsDefaults='';
			isset($_POST['playNumsStateType']) && trim($_POST['playNumsStateType'])!=''?$playNumsStateType=trim($_POST['playNumsStateType']):$playNumsStateType='';

			$this->load->model('Projects_model','projects');	
			$res=$this->projects->gzrsxsszUpdate(['playNumsStateType'=>$playNumsStateType,'playNumsDefaults'=>$playNumsDefaults,'playNumsSuccess'=>$playNumsSuccess,'playNumsState'=>$playNumsState,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);	
		}
		
		//直播窗口背景
		public function zbckbj()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='zbckbj';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/zbckbj.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}				
		}
		
		//直播窗口背景更新
		public function zbckbjUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['playBgFile']) && trim($_POST['playBgFile'])!=''?$playBgFile=trim($_POST['playBgFile']):ajaxs(300,'参数错误');
			$this->load->model('Projects_model','projects');	
			$res=$this->projects->zbckbjUpdate(['playBgFile'=>$playBgFile,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);		
		}
		
		//公众号设置
		public function gzhsz()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='gzhsz';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/gzhsz.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}				
		}
		
		//更新公众号设置
		public function gzhszUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['gongzhonghaoState']) && trim($_POST['gongzhonghaoState'])!=''?$gongzhonghaoState=trim($_POST['gongzhonghaoState']):ajaxs(300,'参数错误');
			isset($_POST['gongzhonghaoShow']) && trim($_POST['gongzhonghaoShow'])!=''?$gongzhonghaoShow=trim($_POST['gongzhonghaoShow']):ajaxs(300,'参数错误');
			isset($_POST['gongzhonghaoFile']) && trim($_POST['gongzhonghaoFile'])!=''?$gongzhonghaoFile=trim($_POST['gongzhonghaoFile']):$gongzhonghaoFile='';
			isset($_POST['gongzhonghaoName']) && trim($_POST['gongzhonghaoName'])!=''?$gongzhonghaoName=trim($_POST['gongzhonghaoName']):$gongzhonghaoName='';
			$this->load->model('Projects_model','projects');	
			$res=$this->projects->gzhszUpdate(['gongzhonghaoState'=>$gongzhonghaoState,'gongzhonghaoShow'=>$gongzhonghaoShow,'gongzhonghaoFile'=>$gongzhonghaoFile,'gongzhonghaoName'=>$gongzhonghaoName,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);	
		}
		
		//视频logo设置
		public function logo()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='logo';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/logo.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}			
		}
		
		//视频logo更新
		public function logoUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['mvLogoState']) && trim($_POST['mvLogoState'])!=''?$mvLogoState=trim($_POST['mvLogoState']):ajaxs(300,'参数错误');
			isset($_POST['mvLogoStateWay']) && trim($_POST['mvLogoStateWay'])!=''?$mvLogoStateWay=trim($_POST['mvLogoStateWay']):ajaxs(300,'参数错误');
			isset($_POST['mvFile']) && trim($_POST['mvFile'])!=''?$mvFile=trim($_POST['mvFile']):$mvFile='';

			$this->load->model('Projects_model','projects');	
			$res=$this->projects->logoUpdate(['mvLogoState'=>$mvLogoState,'mvLogoStateWay'=>$mvLogoStateWay,'mvFile'=>$mvFile,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);				
		}
		
		//广告设置
		public function zdyggl()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='zdyggl';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/zdyggl.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}	
		}
		
		//广告数据更新
		public function zdygglUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['middleVal']) && trim($_POST['middleVal'])!=''?$middleVal=trim($_POST['middleVal']):$middleVal='';
			
			isset($_POST['topVal']) && trim($_POST['topVal'])!=''?$topVal=trim($_POST['topVal']):$topVal='';

			$this->load->model('Projects_model','projects');	
			$res=$this->projects->zdygglUpdate(['topVal'=>$topVal,'middleVal'=>$middleVal,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);	
		}
		
		//网站访问黑名单
		public function hmdip()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='hmdip';
			if($data['res'])
			{
				$this->load->model('Ip_model','ip');	
				$this->ip->inserts(['id'=>$data['res']['id']],$msg);
				$data['ips']=$this->ip->getOneRow($data['res']['id']);
				$this->load->view('admins/projecteds/hmdip.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}		
		}
		
		public function hmdipUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['noallowedIp']) && trim($_POST['noallowedIp'])!=''?$noallowedIp=trim($_POST['noallowedIp']):$noallowedIp='';
			$this->load->model('Ip_model','ip');	
			$res=$this->ip->hmdipUpdate(['noallowedIp'=>$noallowedIp,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);	
		}
		
		//分享设置
		public function share()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='share';
			if($data['res'])
			{
				$this->load->view('admins/projecteds/share.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}	
		}
		
		//更新分享设置信息
		public function shareUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['shareTitle']) && trim($_POST['shareTitle'])!=''?$shareTitle=trim($_POST['shareTitle']):$shareTitle='';
			isset($_POST['shareContents']) && trim($_POST['shareContents'])!=''?$shareContents=trim($_POST['shareContents']):$shareContents='';
			isset($_POST['shareState']) && trim($_POST['shareState'])!=''?$shareState=trim($_POST['shareState']):ajaxs(300,'参数错误');

			$this->load->model('Projects_model','projects');	
			$res=$this->projects->shareUpdate(['shareTitle'=>$shareTitle,'shareContents'=>$shareContents,'shareState'=>$shareState,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);	
		}
		
		//自定义菜单操作
		public function zdycd()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='zdycd';
			if($data['res'])
			{
				$this->load->model('Pother_model','Pother');	
				$this->Pother->inserts(['id'=>$data['res']['id']],$msg);
				$data['pother']=$this->Pother->getOneRow($data['res']['id']);
				
				$this->load->view('admins/projecteds/zdycd.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}				
		}
		
		//自定义菜单数据添加
		public function zdycdUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['fristName']) && trim($_POST['fristName'])!=''?$fristName=trim($_POST['fristName']):$fristName='';
			isset($_POST['frist']) && trim($_POST['frist'])!=''?$frist=trim($_POST['frist']):$frist='';
			isset($_POST['secondName']) && trim($_POST['secondName'])!=''?$secondName=trim($_POST['secondName']):$secondName='';
			isset($_POST['secondContet']) && trim($_POST['secondContet'])!=''?$secondContet=trim($_POST['secondContet']):$secondContet='';
			isset($_POST['second']) && trim($_POST['second'])!=''?$second=trim($_POST['second']):$second='';
			isset($_POST['thirdName']) && trim($_POST['thirdName'])!=''?$thirdName=trim($_POST['thirdName']):$thirdName='';
			isset($_POST['thirdContet']) && trim($_POST['thirdContet'])!=''?$thirdContet=trim($_POST['thirdContet']):$thirdContet='';
			isset($_POST['third']) && trim($_POST['third'])!=''?$third=trim($_POST['third']):$third='';
			isset($_POST['fourthName']) && trim($_POST['fourthName'])!=''?$fourthName=trim($_POST['fourthName']):$fourthName='';
			isset($_POST['fourth']) && trim($_POST['fourth'])!=''?$fourth=trim($_POST['fourth']):$fourth='';
			
			$this->load->model('Pother_model','Pother');	
			$res=$this->Pother->zdycdUpdate(['fristName'=>$fristName,'secondContet'=>$secondContet,'secondName'=>$secondName,'thirdName'=>$thirdName,'thirdContet'=>$thirdContet,'fourthName'=>$fourthName,'frist'=>$frist,'second'=>$second,'third'=>$third,'fourth'=>$fourth,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);		
		}
		
		//添加视频页面
		public function mvAdd()
		{
			if(!$this->adminInfo)
			{
				echo '<script>parent.editNickName(200,"登录失败");</script>';exit();
			}
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='zdycd';
			if($data['res'])
			{
				$this->load->model('Pother_model','Pother');	
				$this->Pother->inserts(['id'=>$data['res']['id']],$msg);
				$data['pother']=$this->Pother->getOneRow($data['res']['id']);
				$this->load->view('admins/projecteds/mvAdd.php',$data);
			}
			else
			{
				echo '<script>parent.editNickName(200,"抱歉：没有找到这条信息");</script>';exit();
			}
		}
		
		//添加视频程序处理
		public function mvAddInser()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['title']) && trim($_POST['title'])!=''?$title=trim($_POST['title']):ajaxs(300,'参数错误');
			isset($_POST['file']) && trim($_POST['file'])!=''?$file=trim($_POST['file']):ajaxs(300,'参数错误');
						isset($_POST['mvId']) && trim($_POST['mvId'])!=''?$mvId=trim($_POST['mvId']):ajaxs(300,'参数错误');
			isset($_POST['appId']) && trim($_POST['appId'])!=''?$appId=trim($_POST['appId']):ajaxs(300,'参数错误');
			
			$this->load->model('Pother_model','Pother');	
			$res=$this->Pother->mvAddInser(['title'=>$title,'file'=>$file,'appId'=>$appId,'mvId'=>$mvId,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);
		}
		
		//修改视频页面
		public function mvEdit()
		{
			if(!$this->adminInfo)
			{
				echo '<script>parent.editNickName(200,"登录失败");</script>';exit();
			}
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='projected';
			$data['map']='projected';
			$data['leftTree']='zdycd';
			if($data['res'])
			{
				$this->load->model('Pother_model','Pother');	
				$this->Pother->inserts(['id'=>$data['res']['id']],$msg);
				$data['pother']=$this->Pother->getOneRow($data['res']['id']);
				
				isset($_GET['mid']) && trim($_GET['mid'])!=''?$mid=intval($_GET['mid']):ajaxs(300,'没有找到对应信息');
				$fourthContet=$data['pother']['fourthContet'];
				if($fourthContet==''){ajaxs(300,'没有找到对应信息');}
				$arr=json_decode($fourthContet,true);
				$data['result']='';
				if(isset($arr['list']))
				{
					for($i=0;$i<count($arr['list']);$i++)
					{
						if($arr['list'][$i]['id']==$mid)
						{
							$data['result']=$arr['list'][$i];	
						}		
					}	
				}
				else
				{
					ajaxs(300,'没有找到对应信息');	
				}
				if($data['result']==''){ajaxs(300,'没有找到对应信息');	}
				$this->load->view('admins/projecteds/mvEdit.php',$data);
			}
			else
			{
				echo '<script>parent.editNickName(200,"抱歉：没有找到这条信息");</script>';exit();
			}
		}
		
		//修改视频信息
		public function mvAddUpdate()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			
			isset($_POST['title']) && trim($_POST['title'])!=''?$title=trim($_POST['title']):ajaxs(300,'参数错误');
			isset($_POST['file']) && trim($_POST['file'])!=''?$file=trim($_POST['file']):ajaxs(300,'参数错误');
			isset($_POST['mvId']) && trim($_POST['mvId'])!=''?$mvId=trim($_POST['mvId']):ajaxs(300,'参数错误');
			isset($_POST['appId']) && trim($_POST['appId'])!=''?$appId=trim($_POST['appId']):ajaxs(300,'参数错误');
			isset($_GET['mid']) && trim($_GET['mid'])!=''?$mid=intval($_GET['mid']):ajaxs(300,'没有找到对应信息');
			
			$this->load->model('Pother_model','Pother');	
			$res=$this->Pother->mvAddUpdate(['title'=>$title,'file'=>$file,'appId'=>$appId,'mvId'=>$mvId,'mid'=>$mid,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');
			}
			ajaxs(300,$msg);	
		}
		
		//修改视频信息
		public function mvAddDel()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$res=$this->getProjectInfo($id);
			if(!$res)
			{
				ajaxs(300,'当前频道信息获取失败');	
			}

			isset($_GET['mid']) && trim($_GET['mid'])!=''?$mid=intval($_GET['mid']):ajaxs(300,'没有找到对应信息');
			
			$this->load->model('Pother_model','Pother');	
			$res=$this->Pother->mvAddDel(['mid'=>$mid,'id'=>$id],$msg);
			if($res)
			{
				ajaxs(100,'删除成功');
			}
			ajaxs(300,$msg);	
		}
		
		//ajax读取视频信息
		public function zdycdMvAjax()
		{
			$this->userAjaxState();	
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			if(!$data['res'])
			{
				ajaxs(300,'当前频道信息获取失败');	
			}
			$this->load->model('Pother_model','Pother');	
			$this->Pother->inserts(['id'=>$data['res']['id']],$msg);
			$data['pother']=$this->Pother->getOneRow($data['res']['id']);
			isset($_GET['maxId']) && trim($_GET['maxId'])!=''?$maxId=intval($_GET['maxId']):$maxId=0;
			$data['maxId']=$maxId;
			$this->load->view('admins/projecteds/zdycdMvAjax.php',$data);				
		}
		
		/**********************频道设置结束****************************/
		
		
		/**********************统计开始****************************/
		public function result()
		{
			$this->userState();
			$id=intval($this->uri->segment(4));
			$data['res']=$this->getProjectInfo($id);
			$data['tag']='result';
			$data['map']='projected';
			if($data['res'])
			{
				$this->load->model('Region_model','region');	
				$this->region->createTable($data['res']['id']);
				
				$this->load->model('Results_model','results');	
				$this->results->inserts($data['res']['id']);
				$data['results']=$this->results->getOneRow($data['res']['id']);
				
				$data['regions']=$this->region->getRows($data['res']['id']);
				
				$this->load->view('admins/projecteds/result.php',$data);
			}
			else
			{
				error('抱歉：没有找到当前这条信息');
			}				
		}
		/**********************统计结束****************************/
		
		public function clearCache()
		{
			$this->userAjaxState();	
			for($i=3;$i<=1000;$i++)
			{
				$dir=FCPATH.'uploadtmp/'.date('Ymd',time()-$i*24*3600);
				echo $dir;
				clearFileCache($dir);	
			}
			ajaxs(100,'删除成功');
		}
		
	}