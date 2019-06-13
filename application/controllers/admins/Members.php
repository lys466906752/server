<?php

	//后台会员主页

	require 'Main.php';

	class Members extends Main
	{
			
		public function __construct()
		{
			parent::__construct();	
		}	
			
		//系统主页
		public function index()
		{
			$this->userState();
			$data['tag']='members';
			$this->load->view("admins/members/index.php",$data);	
		}	
		
		//ajax读取翻页信息
		public function indexList()
		{
			$this->userAjaxState();	
			$pagesize=18;
			$pageindex=intval($this->uri->segment(4));
			isset($_REQUEST["keywords"]) && trim($_REQUEST["keywords"])!=""?$keywords=trim($_REQUEST["keywords"]):$keywords="";
			isset($_REQUEST["state"]) && trim($_REQUEST["state"])!=""?$state=trim($_REQUEST["state"]):$state="";
			$where="";
			
			if($keywords!="")
			{
				$where.=" and (`nickname` like '%$keywords%')";
			}
			
			if($state!='')
			{
				$where.=" and (`comment_state`='$state')";	
			}
			
			$sql="select * from `".$this->db->dbprefix."users` where `id`>0 ".$where." order by `login_time` desc";
			$this->load->library("pagesclass");
			$sql=$this->pagesclass->indexs($sql,$pagesize,$pagecount,$pageall,$pageindex,$this->db);
			$data["query"]=$this->db->query($sql);
			$data["pagesize"]=$pagesize;
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["keywords"]=$keywords;
			$data["state"]=$state;
			$data["arrs"]=$this->pagesclass->page_number($pagecount,$pageindex);
			
			$this->load->view("admins/members/indexList.php",$data);	
		}
		
		//更改会员状态
		public function changeComments()
		{
			$this->userAjaxState();	
			$this->load->model('Admins_model','admins');
			isset($_POST['id']) && trim($_POST['id'])!=''?$id=P("id"):ajaxs(300,'参数错误');
			$state=intval($this->uri->segment(4));
			
			$this->load->model('Users_model','users');
			$res=$this->users->changeComments(['id'=>$id,'state'=>$state],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);		
		}
		
		//修改会员
		public function editUser()
		{
			if(!$this->adminInfo)
			{
				echo '<script>parent.editNickName(200,"登录失败");</script>';exit();
			}
			else
			{
				$id=intval($this->uri->segment(4));
				$this->load->model('Users_model','users');
				$data['res']=$this->users->getOneRow($id);
				if($data['res'])
				{
					$this->load->view('admins/members/editUser.php',$data);
				}
				else
				{
					echo '<script>parent.editNickName(300,"没有找到对应信息");</script>';exit();
				}	
			}
		}
		
		//修改会员程序
		public function updateUser()
		{
			$this->userAjaxState();	
			$this->load->model('Admins_model','admins');
			isset($_POST['nickname']) && trim($_POST['nickname'])!=''?$nickname=P("nickname"):ajaxs(300,'参数错误');
			isset($_POST['avatar']) && trim($_POST['avatar'])!=''?$avatar=P("avatar"):ajaxs(300,'参数错误');
			$id=intval($this->uri->segment(4));
			
			$this->load->model('Users_model','users');
			$res=$this->users->updateUser(['id'=>$id,'nickname'=>$nickname,'avatar'=>$avatar],$msg);
			if($res)
			{
				ajaxs(100,'更新成功');	
			}
			ajaxs(300,$msg);	
		}
		
		//查看会员详情
		public function selectUser()
		{
			if(!$this->adminInfo)
			{
				echo '<script>parent.editNickName(200,"登录失败");</script>';exit();
			}
			else
			{
				$id=intval($this->uri->segment(4));
				$this->load->model('Users_model','users');
				$data['res']=$this->users->getOneRow($id);
				if($data['res'])
				{
					$this->load->view('admins/members/selectUser.php',$data);
				}
				else
				{
					echo '<script>parent.editNickName(300,"没有找到对应信息");</script>';exit();
				}	
			}	
		}
		
		//删除会员
		public function del()
		{
			$this->userAjaxState();	
			$id=trim($this->input->post('id'),',');
			$this->load->model('Users_model','users');
			$res=$this->users->del($id,$msg);
			if($res)
			{
				ajaxs(100,'删除成功');
			}

			ajaxs(300,$msg);	
		}
		
	}