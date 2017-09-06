<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	//$uah_rate = $_POST['uah_rate'];
	//$rub_rate = $_POST['rub_rate'];
	//$eur_rate = $_POST['eur_rate'];
	
	$cardUpd = array(
					'order_email'	=> $_POST['order_email'],
					//'uah_rate'	=> (float)$_POST['uah_rate'],
					//'rub_rate'	=> (float)$_POST['rub_rate'],
					//'eur_rate'	=> (float)$_POST['eur_rate'],
					'terms'			=> $_POST['terms'],
					
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
	
	
	// Update shop_products table
	/*$query = "UPDATE [pre]shop_products SET 
			price 		= ROUND(usd_price*$uah_rate,0),
			rub_price 	= ROUND(usd_price*$rub_rate,0),
			eur_price 	= ROUND(usd_price*$eur_rate,0),
			
			sale_price 		= ROUND(usd_sale_price*$uah_rate,0),
			rub_sale_price 	= ROUND(usd_sale_price*$rub_rate,0),
			eur_sale_price 	= ROUND(usd_sale_price*$eur_rate,0)
				";
	$data['query'] = $query;
		
	$ah->rs($query);*/
	
	
	
	$data['message'] = "Настройки успешно вступили в силу";
	