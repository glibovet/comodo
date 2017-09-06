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
	
	//admin data
	
	$aQuery = "SELECT * FROM [pre]users WHERE `id`='".ADMIN_ID."' LIMIT 1";
	
	$adminDataArr = $ah->rs($aQuery);
	
	$adminData = $adminDataArr[0];
	
	define("ADMIN_TYPE",$adminData['type']);
	
	// INI DATA
	
	$data = array('status'=>"error",'message'=>"Tech error",'choice'=>$choice);
	
	$lpx = (isset($_POST['lpx']) ? $_POST['lpx'] : '');
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
		
		$data['status'] = "success";
	}
	
	echo json_encode($data);