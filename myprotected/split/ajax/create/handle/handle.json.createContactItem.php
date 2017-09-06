<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'city'			=> strip_tags(trim($_POST['city'])),
					'ua_city'		=> strip_tags(trim($_POST['city'])),
					'en_city'		=> strip_tags(trim($_POST['city'])),
					
					'map_frame'		=> $_POST['map_frame'],
					'email'			=> $_POST['email'],
					'phone_number'	=> $_POST['phone_number'],		
					
					'adress'		=> strip_tags(trim($_POST['adress'])),
					'ua_adress'		=> strip_tags(trim($_POST['adress'])),
					'en_adress'		=> strip_tags(trim($_POST['adress'])),
					
					'work_time'		=> strip_tags(trim($_POST['work_time'])),
					'ua_work_time'	=> strip_tags(trim($_POST['work_time'])),
					'en_work_time'	=> strip_tags(trim($_POST['work_time'])),
					
					'sat_time'		=> strip_tags(trim($_POST['sat_time'])),
					'ua_sat_time'	=> strip_tags(trim($_POST['sat_time'])),
					'en_sat_time'	=> strip_tags(trim($_POST['sat_time'])),
					
					'sun_time'		=> strip_tags(trim($_POST['sun_time'])),
					'ua_sun_time'	=> strip_tags(trim($_POST['sun_time'])),
					'en_sun_time'	=> strip_tags(trim($_POST['sun_time'])),
					
					'block'			=> $_POST['block'][0]
					
					);
					
	// Create main table item
	
	$query = "INSERT INTO [pre]$appTable ";
	
	$fieldsStr = " ( ";
	
	$valuesStr = " ( ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		
		$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
		
		$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
	}
	
	$fieldsStr .= " ) ";
	
	$valuesStr .= " ) ";
	
	$query .= $fieldsStr." VALUES ".$valuesStr;
		
	$data['block'] = $cardUpd['block'];
	
	$data['query'] = $query;
		
	$ah->rs($query);
	
	$item_id = mysql_insert_id();
	
	
	$data['item_id'] = $item_id;
	
	$data['status'] = "success";
	$data['message'] = "Контакт успешно создан";
	