<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = 'files_ref';
	
	$id = $_POST['id'];
	
	$path = $_POST['path'];
	
	$root_path = "../../../..";
	
	
	$data = array();
	
	$query = "SELECT * FROM [pre]$appTable WHERE `id`=$id LIMIT 1";
	
	$data = $ah->rs($query);
	
	if($data)
	{
		$data = $data[0];
		
		$filepath = $root_path.$path.$data['file'];
		$croppath = $root_path.$path."crop/".$data['crop'];
	
	
		if(file_exists($filepath) && trim($data['file']) != "")
		{
			unlink($filepath);
		}
		
		if(file_exists($croppath) && trim($data['crop']) != "")
		{
			unlink($croppath);
		}
		
		$query = "DELETE FROM [pre]$appTable WHERE `id`='$id' LIMIT 1";
		
		$ah->rs($query);
		
		$data['message'] = "Success file delete";
	}else
	{
		$data['message'] = 'File not found';
	}
	