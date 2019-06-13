<?php
	
	//Text:针对系统自行编写的翻页类目;
	//Auth:Recson;
	//Date:2017-3-6;

	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Pagesclass
	{
		
		//对应的的翻页
		public function indexs($sql,$pagesize,&$pagecount,&$pageall,$pageindex,$db)
		{

			$this->db=$db;
			
			$_query=$this->db->query($sql);//执行出query对象
			
			$pageall=$_query->num_rows();//计算出对应的总行数
			
			//如果没数据，直接return对应信息
			if($pageall<=0){
				
				$pagecount=0;
				
				$pageall=0;
				
				$pageindex=1;
				
				return $sql." limit 0,0";
				
			}
			
			$pagecount=ceil($pageall/$pagesize);//计算出对应的总页数
			
			//计算出合理的当前页码数
			if(!$pageindex || $pageindex=="")
			{
				$pageindex=1;
			}
			else
			{
				//针对当前页码不是合法数字，并且小于1的情况做判断处理
				if(!is_numeric($pageindex) || substr_count($pageindex,".")!=0 || $pageindex<1)
				{
					$pageindex=1;
				}
				//如果比最后一页大的话，直接等同于最后一页
				elseif($pageindex>$pagecount)
				{
					$pageindex=$pagecount;;
				}
			}
			
			//计算出合理的翻页Sql语句，做批处理使用
			if($pageindex<$pagecount)
			{
				$_start=($pageindex-1)*$pagesize;
				$_sql=$sql." limit ".$_start.",".$pagesize;
			}
			else
			{
				if($pageall%$pagesize!=0)
				{
					$_start=($pageindex-1)*$pagesize;
					$_sql=$sql." limit ".$_start.",".($pageall%$pagesize);
				}
				else
				{
					$_start=($pageindex-1)*$pagesize;
					$_sql=$sql." limit ".$_start.",".$pagesize;
				}
			}
			
			return $_sql;
		}
		
		//对应的的翻页
		public function homes($sql,$pagesize,&$pagecount,&$pageall,$pageindex,$db)
		{
			$this->db=$db;
			
			$_query=$this->db->query($sql);//执行出query对象
			
			$pageall=$_query->num_rows();//计算出对应的总行数
			
			//如果没数据，直接return对应信息
			if($pageall<=0){
				
				$pagecount=0;
				
				$pageall=0;
				
				$pageindex=1;
				
				return $sql." limit 0,0";
				
			}
			
			$pagecount=ceil($pageall/$pagesize);//计算出对应的总页数
			
			//计算出合理的当前页码数
			if(!$pageindex || $pageindex=="")
			{
				return $_sql=$sql." limit 0,0";
			}
			else
			{
				//针对当前页码不是合法数字，并且小于1的情况做判断处理
				if(!is_numeric($pageindex) || substr_count($pageindex,".")!=0 || $pageindex<1)
				{
					return $_sql=$sql." limit 0,0";
				}
				//如果比最后一页大的话，直接等同于最后一页
				elseif($pageindex>$pagecount)
				{
					return $_sql=$sql." limit 0,0";
				}
			}
			
			//计算出合理的翻页Sql语句，做批处理使用
			if($pageindex<$pagecount)
			{
				$_start=($pageindex-1)*$pagesize;
				$_sql=$sql." limit ".$_start.",".$pagesize;
			}
			else
			{
				if($pageall%$pagesize!=0)
				{
					$_start=($pageindex-1)*$pagesize;
					$_sql=$sql." limit ".$_start.",".($pageall%$pagesize);
				}
				else
				{
					//show_it("page_error()");
					$_start=($pageindex-1)*$pagesize;
					$_sql=$sql." limit ".$_start.",".$pagesize;
				}
			}
			
			return $_sql;
		}
		
		//解析出翻页标签的方法，默认1-10页的模式
		public function page_number($pagecount,$pageindex)
		{
			//翻页编码解析函数
			$number=array();
		
			if($pagecount>10)
			{
				if($pageindex<=4)
				{
					$number=array("1","8");
				}
				elseif($pageindex+4>=$pagecount)
				{
					$number=array($pagecount-7,$pagecount);
				}
				else
				{
					$number=array($pageindex-3,$pageindex+4);
				}
			}
			else
			{
				$number=array("1",$pagecount);
			}
			
			return $number;
		}
		
		//解析出翻页标签的方法，默认1-10页的模式
		public function page_numbers($pagecount,$pageindex)
		{
			//翻页编码解析函数
			$number=array();
		
			if($pagecount>10)
			{
				if($pageindex<=5)
				{
					$number=array("1","10");
				}
				elseif($pageindex+5>=$pagecount)
				{
					$number=array($pagecount-9,$pagecount);
				}
				else
				{
					$number=array($pageindex-4,$pageindex+5);
				}
			}
			else
			{
				$number=array("1",$pagecount);
			}
			
			return $number;
		}
		
	}