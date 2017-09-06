<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = 'shop_products';
	
	$id = $_POST['id'];
	
	$field = $_POST['field'];
	
	$path = $_POST['path'];
	
	$filename = $_POST['filename'];
	
	$root_path = "../../../..";
	
	$filepath = $root_path.$path.$filename;
	
	if(file_exists($filepath))
	{
		unlink($filepath);
	}
	
	$query = "UPDATE [pre]$appTable set `$field`='' WHERE `id`='$id' LIMIT 1";
	
	$ah->rs($query);
	
	$data['message'] = "Success file delete";
	