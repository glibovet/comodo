<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'name'			=> str_replace("'","\'",$_POST['name']),
					'rus_name'		=> str_replace("'","\'",$_POST['rus_name']),
					'cat_id'		=> $_POST['cat_id'],
					'block'			=> $_POST['block'][0],
					
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
	
	
	
	$data['message'] = "Поставщик успешно сохранен";
	