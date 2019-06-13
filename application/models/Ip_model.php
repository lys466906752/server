<?php

	//黑名单IP表模型

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Ip_model extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();
		}

		//定义表名
		private function tableName()
		{

			return $this->db->dbprefix.'ip';

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
					'noallowedIp'=>'',
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
		
		//更新黑名单信息
		public function hmdipUpdate($data,&$msg)
		{
			$msg='';
			$_array=[
				'noallowedIp'=>$data['noallowedIp'],
			];
			if($this->db->update($this->tableName(),$_array,['id'=>$data['id']]))
			{
				$msg='修改成功';
				return true;
			}
			
			$msg='服务器错误，请稍后再试';
			return false;
			
		}
		
	}