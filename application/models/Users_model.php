<?php

	//会员的表模型

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Users_model extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();
		}

		//定义表名
		private function tableName()
		{

			return $this->db->dbprefix.'users';

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
		

		//更新会员状态
		public function changeComments($data,&$msg)
		{
			$msg='';
			$_array=[
				'comment_state'=>$data['state'],
			];
		
			if($this->db->update($this->tableName(),$_array,['id'=>$data['id']]))
			{
				$msg='修改成功';
				return true;
			}
			
			$msg='服务器错误，请稍后再试';
			return false;
			
		}
		
		//更新会员表
		public function updateUser($data,&$msg)
		{
			$msg='';
			$_array=[
				'nickname'=>$data['nickname'],
				'avatar'=>$data['avatar'],
			];
		
			if($this->db->update($this->tableName(),$_array,['id'=>$data['id']]))
			{
				$msg='修改成功';
				return true;
			}
			
			$msg='服务器错误，请稍后再试';
			return false;	
		}
		
		//删除方法
		public function del($id,&$msg)
		{

			$msg='';

			if($this->db->query("delete from `".$this->tableName()."` where `id` in(".$id.") "))
			{
				return true;
			}

			$msg='网络连接失败，请稍后再试';
			return false;
		}
	}