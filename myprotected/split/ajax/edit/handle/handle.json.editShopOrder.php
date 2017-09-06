<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'user_id'				=> $_POST['user_id'],
					
					'client_name'			=> $_POST['client_name'],
					'client_fname'			=> $_POST['client_fname'],
					'client_phone'			=> $_POST['client_phone'],
					'client_email'			=> $_POST['client_email'],
					
					'products'				=> $_POST['productsJsData'],
					'status'				=> $_POST['status'],
					
					'paid_status'			=> $_POST['paid_status'],
					'pay_method'			=> $_POST['pay_method'],
					'delivery_method'		=> $_POST['delivery_method'],
					'delivery_address'		=> $_POST['delivery_address'],
					'delivery_date'			=> date("d-m-Y", strtotime($_POST['delivery_date'])),
					'delivery_time'			=> $_POST['delivery_time'],
					'details'				=> $_POST['details'],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	$old_order_status = $_POST['old_order_status'];
	$new_order_status = $_POST['status'];
					
	if(isset($_POST['productsJsData']) && $_POST['productsJsData'] != "")
	{
		$prods = unserialize($_POST['productsJsData']);
		
		$nSum = 0;
		$nPq = 0;
		
		foreach($prods as $prod)
		{
			$query = "SELECT price,quant,in_stock FROM [pre]shop_products WHERE `id`='".$prod['prod_id']."' LIMIT 1";
			$prodCurr = $ah->rs($query);
			
			if($prodCurr)
			{
				$pr = $prodCurr[0];
				
				$curr_pprice = ($prod['price_dif'] ? $prod['price_dif'] : $prod['price']);
				
				$nPq += $prod['quant'];
				$nSum += ($prod['quant']*$curr_pprice);
				
				if($old_order_status!=5 && $new_order_status==5)
				{
					
					$new_quant = $pr['quant']+$prod['quant'];
					$new_in_stock = $pr['in_stock']+$prod['quant'];
					
					if($new_quant < 0) $new_quant = 0;
					if($new_in_stock < 0) $new_in_stock = 0;
					
					$query = "UPDATE [pre]shop_products SET `quant`='$new_quant', `in_stock`='$new_in_stock' WHERE `id`='".$prod['prod_id']."' LIMIT 1";
					$ah->rs($query);
				}
				
				if($old_order_status==5 && $new_order_status!=5)
				{
					
					$new_quant = $pr['quant']-$prod['quant'];
					$new_in_stock = $pr['in_stock']-$prod['quant'];
					
					if($new_quant < 0) $new_quant = 0;
					if($new_in_stock < 0) $new_in_stock = 0;
					
					$query = "UPDATE [pre]shop_products SET `quant`='$new_quant', `in_stock`='$new_in_stock' WHERE `id`='".$prod['prod_id']."' LIMIT 1";
					$ah->rs($query);
				}
				
			}
		}
		
		$cardUpd['sum'] = $nSum;
		$cardUpd['products_quant'] = $nPq;
	}
					
	// Update main table
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
		
	//$data['query'] = $query;
		
	$ah->rs($query);
	
	$data['old_status'] = $old_order_status;
	$data['new_status'] = $new_order_status;
		
	if($old_order_status != $new_order_status)
	{
		$new_status = "New status";
		
		$query = "SELECT name FROM [pre]shop_order_statuses WHERE `id`='$new_order_status' LIMIT 1";
		$newStatus = $ah->rs($query);
		
		if($newStatus)
		{
			$new_status = $newStatus[0]['name'];
			
			$query = "SELECT * FROM [pre]users WHERE `id`='".$cardUpd['user_id']."' LIMIT 1";
			$RespUser = $ah->rs($query);
			
			$R = $RespUser[0];
			
			$client_message = "
								<p>Уважаемый ".$R['name']." ".$R['fname'].", Ваш заказ №".(5000+$item_id)." на сайте itfurline.com сменил статус.</p>
								<p>Статус заказа: <b>$new_status</b></p>
								<br>
								<p>С уважением, администрация <a href='http://itfurline.com'>itfurline.com</a></p>
								";
								
			$ah->wp_send_letter($R['login'],"info@itfurline.com","Новый статус по заказу #".(5000+$item_id),$client_message);
		}
	}
	
	$data['message'] = "Success order saved";
	