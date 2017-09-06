<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'code'			=> $_POST['code'],
					'fullness'		=> $_POST['fullness'],
					'stock_id'		=> $_POST['stock_id'],
					'block'			=> $_POST['block'][0],
					
					'dateCreate'	=> date("Y-m-d H:i:s", time())
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
	$data['message'] = "Новая складская ячейка успешно создана";
	