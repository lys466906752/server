<?php

	//分表的表模型

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Pother_model extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();
		}

		//定义表名
		private function tableName()
		{

			return $this->db->dbprefix.'pother';

		}
		
		//查询单条数据集
		public function getOneRowForName($name)
		{
			$query=$this->db->query("select * from `".$this->tableName()."` where `name`='$name' limit 1");

			if($query->num_rows()>0)
			{
				return $query->row_array();
			}	

			return false;
		}
		
		//查询单条，除了某ID
		public function getOneRowForNameNoId($name,$id)
		{
			$query=$this->db->query("select * from `".$this->tableName()."` where `name`='$name' and `id`!='$id' limit 1");

			if($query->num_rows()>0)
			{
				return $query->row_array();
			}	

			return false;	
		}
		
		//查询单条数据集根据ID
		public function getOneRow($id)
		{

			$query=$this->db->query("select * from `".$this->tableName()."` where `id`='$id' limit 1");

			if($query->num_rows()>0)
			{
				return $query->row_array();
			}	

			return false;
		}
		
		//查询所有
		public function getRows()
		{

			$query=$this->db->query("select * from `".$this->tableName()."` order by `id` desc");

			return $query;
		}
		
		//添加方法
		public function inserts($data,&$msg)
		{
			$msg='';
			$res=$this->getOneRow($data['id']);
			if(!$res)
			{
				$_array=[
					'id'=>$data['id'],
				];
				if($this->db->insert($this->tableName(),$_array))
				{
					$msg='添加成功';
					return true;
				}
				
				$msg='服务器错误，请稍后再试';
				return false;
			}

			$msg='频道名称已经存在，请更换';
			return false;
		}
		
		//更新配置信息
		public function zdycdUpdate($data,&$msg)
		{
			$msg='';
			$_array=[
				'fristName'=>$data['fristName'],
				'secondName'=>$data['secondName'],
				'secondContet'=>$data['secondContet'],
				'thirdName'=>$data['thirdName'],
				'thirdContet'=>$data['thirdContet'],
				'fourthName'=>$data['fourthName'],
				'frist'=>$data['frist'],
				'second'=>$data['second'],
				'third'=>$data['third'],
				'fourth'=>$data['fourth'],
			];
			if($_array['fristName']=='')
			{
				unset($_array['fristName']);	
			}
			if($_array['secondName']=='')
			{
				unset($_array['secondName']);	
			}
			if($_array['secondContet']=='')
			{
				unset($_array['secondContet']);	
			}
			if($_array['thirdName']=='')
			{
				unset($_array['thirdName']);	
			}
			if($_array['thirdContet']=='')
			{
				unset($_array['thirdContet']);	
			}
			if($_array['fourthName']=='')
			{
				unset($_array['fourthName']);	
			}
			if($_array['frist']=='')
			{
				unset($_array['frist']);	
			}
			if($_array['second']=='')
			{
				unset($_array['second']);	
			}
			if($_array['third']=='')
			{
				unset($_array['third']);	
			}
			if($_array['fourth']=='')
			{
				unset($_array['fourth']);	
			}
			if($this->db->update($this->tableName(),$_array,['id'=>$data['id']]))
			{
				$msg='修改成功';
				return true;
			}
			
			$msg='服务器错误，请稍后再试';
			return false;
			
		}
		
		//更新视频信息
		public function mvAddInser($data,&$msg)
		{
			$msg='';
			$res=$this->getOneRow($data['id']);
			if($res)
			{
				
				if($res['fourthContet']=='')
				{
					$arrs=[
						'id'=>1,
						'list'=>[
							[
								"id"=>1,
								"title"=>$data['title'],
								"file"=>$data['file'],
								"appId"=>$data['appId'],
								"mvId"=>$data['mvId'],
								"time"=>time()
							]
						]
					];					
				}
				else
				{
					$json=json_decode($res['fourthContet'],true);
					$arrs=[];
					if(isset($json['id']))
					{
						$arrs['id']=$json['id']+1;	
					}
					else
					{
						if(!isset($json['list']))
						{
							$arrs['id']=1;	
						}
						else
						{
							$maxInt=1;
							for($i=0;$i<count($json['list']);$i++)
							{
								if(isset($json['list'][$i]['id']) && $json['list'][$i]['id']>=$maxInt)
								{
									$maxInt=$json['list'][$i]['id'];	
								}	
							}	
							$arrs['id']=$maxInt;	
						}
					}
					
					if(isset($json['list']))
					{
						$arrs['list']=$json['list'];
						$arrs['list'][]=[
								"id"=>$arrs['id'],
								"title"=>$data['title'],
								"file"=>$data['file'],
								"appId"=>$data['appId'],
								"mvId"=>$data['mvId'],
								"time"=>time()
						];
					}
					else
					{
						$arrs['list']=[
							[
								"id"=>1,
								"title"=>$data['title'],
								"file"=>$data['file'],
								"appId"=>$data['appId'],
								"mvId"=>$data['mvId'],
								"time"=>time()
							]
						];	
					}
					
				}
				
				//print_r($arrs);exit();
				
				$_array=[
					'fourthContet'=>json_encode($arrs),
				];
				
				if($this->db->update($this->tableName(),$_array,['id'=>$data['id']]))
				{
					$msg='更新成功';
					return true;
				}
				
				$msg='服务器错误，请稍后再试';
				return false;
			}

			$msg='数据信息不存在，请稍后再试';
			return false;	
		}
		
		//更新视频信息
		public function mvAddUpdate($data,&$msg)
		{
			$msg='';
			$res=$this->getOneRow($data['id']);
			if($res)
			{
				$validate=false;
				if($res['fourthContet']=='')
				{
					$msg='没找到数据，请稍后再试';
					return false;			
				}
				else
				{
					$json=json_decode($res['fourthContet'],true);

					if(!isset($json['id']))
					{
						$msg='没找到数据，请稍后再试';
						return false;
					}
					
					if(isset($json['list']))
					{
						for($i=0;$i<count($json['list']);$i++)
						{
							if($json['list'][$i]['id']==$data['mid'])
							{
								$json['list'][$i]['file']=$data['file'];	
								$json['list'][$i]['title']=$data['title'];	
								$json['list'][$i]['appId']=$data['appId'];	
								$json['list'][$i]['mvId']=$data['mvId'];	
								$json['list'][$i]['time']=time();
								$validate=true;	
							}	
						}
					}
					else
					{
						$msg='没找到数据，请稍后再试';
						return false;
					}
					
				}
				if(!$validate)
				{
					$msg='没找到数据，请稍后再试';
					return false;	
				}
				
				$_array=[
					'fourthContet'=>json_encode($json),
				];
				
				if($this->db->update($this->tableName(),$_array,['id'=>$data['id']]))
				{
					$msg='更新成功';
					return true;
				}
				
				$msg='服务器错误，请稍后再试';
				return false;
			}

			$msg='数据信息不存在，请稍后再试';
			return false;	
		}
		
		//删除视频信息
		public function mvAddDel($data,&$msg)
		{
			$msg='';
			$res=$this->getOneRow($data['id']);
			if($res)
			{
				$validate=false;
				if($res['fourthContet']=='')
				{
					$msg='没找到数据，请稍后再试';
					return false;			
				}
				else
				{
					$json=json_decode($res['fourthContet'],true);

					if(!isset($json['id']))
					{
						$msg='没找到数据，请稍后再试';
						return false;
					}
					
					$arr=[];
					$arr['id']=$json['id'];
					
					$a=0;
					if(isset($json['list']))
					{
						for($i=0;$i<count($json['list']);$i++)
						{
							if($json['list'][$i]['id']!=$data['mid'])
							{
								$arr['list'][$a]=$json['list'][$i];
								$a++;
							}
							else
							{
								$validate=true;		
							}	
						}
					}
					else
					{
						$msg='没找到数据，请稍后再试';
						return false;
					}
					
				}
				if(!$validate)
				{
					$msg='没找到数据，请稍后再试';
					return false;	
				}
				
				$_array=[
					'fourthContet'=>json_encode($arr),
				];
				
				if($this->db->update($this->tableName(),$_array,['id'=>$data['id']]))
				{
					$msg='删除成功';
					return true;
				}
				
				$msg='服务器错误，请稍后再试';
				return false;
			}

			$msg='数据信息不存在，请稍后再试';
			return false;	
		}
		
	}