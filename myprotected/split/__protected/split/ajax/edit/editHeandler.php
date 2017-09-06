<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	// GET POST
	
	$choice = (int)$_POST['choice'];
	
	$actionName = $_POST['action'];
	
	// INI DATA
	
	$data = array('status'=>"error",'message'=>"Tech error",'choice'=>$choice);
	
	// INCLUDE HANDLE SCRIPT
	
	$handleName = "handle/handle.json.".$actionName.".php";
	
	if(file_exists($handleName))
	{
		foreach($_POST as $indx => $postItem)
		{
			if(!is_array($postItem)) $_POST[$indx] = str_replace("'","\'",$postItem);
		}
		
		include_once($handleName);
		
		$data['status'] = "success";
	}
	
	echo json_encode($data);