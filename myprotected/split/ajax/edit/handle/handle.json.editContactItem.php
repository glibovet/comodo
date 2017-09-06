<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					$lang_prefix.'city'			=> strip_tags(trim($_POST[$lang_prefix.'city'])),
					
					'map_frame'		=> $_POST['map_frame'],
					'email'			=> $_POST['email'],
					'phone_number'	=> $_POST['phone_number'],		
										
					$lang_prefix.'adress'		=> strip_tags(trim($_POST[$lang_prefix.'adress'])),
					
					$lang_prefix.'work_time'	=> strip_tags(trim($_POST[$lang_prefix.'work_time'])),
					
					$lang_prefix.'sat_time'		=> strip_tags(trim($_POST[$lang_prefix.'sat_time'])),
					
					$lang_prefix.'sun_time'		=> strip_tags(trim($_POST[$lang_prefix.'sun_time'])),
					
					'block'			=> $_POST['block'][0]
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
	
	
	
	$data['message'] = "Контакт успешно сохранен. ".$lang_prefix;
	