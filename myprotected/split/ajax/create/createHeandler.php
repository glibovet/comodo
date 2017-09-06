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
	
	$lpx = ($_POST['lpx'] ? $_POST['lpx'] : '');
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = ru
	$lang_fields = $ah->getAvailableLangs();
	
	// INCLUDE HANDLE SCRIPT
	
	$handleName = "handle/handle.json.".$actionName.".php";
	
	if(file_exists($handleName))
	{
		foreach($_POST as $indx => $postItem)
		{
			if(!is_array($postItem)) $_POST[$indx] = addslashes($postItem);
		}
		
		include_once($handleName);
	}
	
	echo json_encode($data);