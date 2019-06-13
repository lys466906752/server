<?php

	//管理员表模型层

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Admins_model extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();
		}

		//定义表名
		private function tableName()
		{

			return $this->db->dbprefix.'admins';

		}
		
		//查询所有
		public function getRows()
		{

			$query=$this->db->query("select * from `".$this->tableName()."` order by `login_time` desc");

			return $query;
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

		//查询单条数据集
		public function getOneRowForUsername($username)
		{
			$query=$this->db->query("select * from `".$this->tableName()."` where `username`='$username' limit 1");

			if($query->num_rows()>0)
			{
				return $query->row_array();
			}	

			return false;
		}
		
		//查询单条数据集
		public function getOneRowForDir($dir)
		{
			$query=$this->db->query("select * from `".$this->tableName()."` where `dir`='$dir' limit 1");

			if($query->num_rows()>0)
			{
				return $query->row_array();
			}	

			return false;	
		}

		//登录方法
		public function logins($username,$passwd)
		{
            /*$a = sha1(sha1($passwd).'77668779');
            print_r($a);die;*/
			$res=$this->getOneRowForUsername($username);
			if($res)
			{
				if($res['passwd']!=sha1(sha1($passwd).$res['salt']))
				{
					return false;
				}

				$_array=[
					'login_time'=>time(),
					'login_ip'=>get_ip(),
					'last_time'=>$res['login_time'],
					'last_ip'=>$res['login_ip'],
					'count'=>$res['count']+1,
					'token'=>get_token()
				];

				$this->db->update($this->tableName(),$_array,['id'=>$res['id']]);

				//写入到对应的session文件中
				$res=array_merge($res,$_array);

				$hashStr=$this->encrypt->encode(json_encode($res));

				$this->session->set_userdata('PC_Auth_Identity',$hashStr);
				
				$this->input->set_cookie("PC_Auth_Identity_Key",$hashStr,36000);

				return $res;
			}
			
			return false;
		}
		
		//添加方法
		public function inserts($data,&$msg)
		{
			$msg='';
			$res=$this->getOneRowForUsername($data['username']);
			if(!$res)
			{
				$_array=[
					'username'=>$data['username'],
					'passwd'=>$data['passwd'],
					'salt'=>mt_rand(10000000,99999999),
					'login_time'=>time(),
					'login_ip'=>get_ip(),
					'last_time'=>time(),
					'last_ip'=>get_ip(),
					'count'=>0,
					'token'=>get_token(),
				];
				$_array['passwd']=sha1(sha1($_array['passwd']).$_array['salt']);
				if($this->db->insert($this->tableName(),$_array))
				{
					$msg='添加成功';
					return true;
				}
				
				$msg='服务器错误，请稍后再试';
				return false;
			}

			$msg='用户名已存在';
			return false;
		}
		
		//修改方法
		public function updates($data,&$msg)
		{
			$msg='';
			$res=$this->getOneRow($data['id']);

			if($res)
			{
				if(sha1(sha1($data['passwd']).$res['salt'])==$res['passwd'])
				{
					$msg='新密码不能与旧密码一样';
					return false;
				}
				
				$array=[
					'passwd'=>sha1(sha1($data['passwd']).$res['salt']),
				];
				
				if($this->db->update($this->tableName(),$array,['id'=>$data['id']]))
				{
					return true;
				}

				$msg='服务器错误，请稍后再试';
				return false;
			}

			$msg='没有找到这条信息';
			return false;
		}
		
		//删除方法
		public function del($id,&$msg)
		{

			$msg='';

			if($this->db->query("delete from `".$this->tableName()."` where `id` in(".$id.") and `username`!='root' "))
			{
				return true;
			}

			$msg='服务器错误，请稍后再试';
			return false;
		}
		
	}