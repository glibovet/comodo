<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'name'			=> $_POST['name'],
					'alias'			=> $_POST['alias'],
					'group_id'		=> $_POST['group_id'],
					'block'			=> $_POST['block'][0],
					'show_site'		=> $_POST['show_site'][0],
					'show_admin'	=> $_POST['show_admin'][0],
					'default'		=> $_POST['default'],
					'measure'		=> $_POST['measure'],
					'title'			=> $_POST['title'],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	// Update main table
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
		
	$data['query'] = $query;
		
	$ah->rs($query);
	
	
	
	$data['message'] = "Success save";
	