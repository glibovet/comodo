<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "project_chars_ref";
	
	$refId = (int)$_POST['refId'];
	
	$data['status']="failed";
	$data['message']="Unknown reference Char ID";
	
	if($refId)
	{
		$query = "DELETE FROM [pre]$appTable WHERE `id`=$refId LIMIT 1";
		$ah->rs($query);
		
		$data['status']="success";
		$data['message']="Success";
	}
	