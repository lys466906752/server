<?php
	
	//设置一个redis连接开始
	global $redis;
	$redis=new Redis();
	$redis->connect('127.0.0.1', 6379);	
	$redis->auth('Jason2Xiaoyu'); 
	$redis->select(2); 
	//设置一个redis连接结束
	
	$members=$redis->get('members');
	$admins=$redis->get('admins');
	echo '<pre>';
	echo '这是会员的内存信息';
	print_r($members);
	echo '<pre>';
	echo '这是管理员的内存信息';
	print_r($admins);
	