<?php
	//session_destroy();die();
	require_once(FCPATH."API/qqConnectAPI.php");
	$qc = new QC();
	$qc->qq_login();
	