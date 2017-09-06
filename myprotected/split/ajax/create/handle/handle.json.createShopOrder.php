<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'author_id'				=> ADMIN_ID,
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
					
					'code'					=> time(),
					'dateCreate'			=> date("Y-m-d H:i:s", time()),
					'dateModify'			=> date("Y-m-d H:i:s", time())
					);
	
	if($cardUpd['user_id']) // Fix user id
	{
	
		// Fix products
		
		$products = unserialize($cardUpd['products']);
		
		if($products)
		{
			// Calculate order
			
			$orderSum = 0;
			$productsQuant = 0;
			
			foreach($products as $product)
			{
				$curr_pprice = ($product['price_dif'] ? $product['price_dif'] : $product['price']);
				
				$orderSum += $product['quant']*$curr_pprice;
				$productsQuant += $product['quant'];
			}
			
			$cardUpd['sum'] = $orderSum;
			$cardUpd['products_quant'] = $productsQuant;
						
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
			$data['message'] = "Заказ успешно создан. №Заказа: ".($item_id+5000);
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// Отправка уведомления на почту
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
				$query = "SELECT * FROM [pre]users WHERE `id`='".$cardUpd['user_id']."' LIMIT 1";
				$RespUser = $ah->rs($query);
			
				$profile = $RespUser[0];
				$order_id = $item_id;
			
				$message_mail_client = "<h1>Спасибо, ".$profile['name']." ".$profile['fname'].", ваш заказ принят!</h1>";
				$message_mail_admin = "<h1>Оформлен новый заказ!</h1>";
				
				$message_mail = "<h2>Номер заказа: ".($order_id+5000)."</h2>";
				$message_mail .= "<br>";
				
				$message_mail = "<h2>Список товаров:</h2>";
				$message_mail .= "<table style=\"margin:10px 0px; border-top:1px solid #CCC; border-left:1px solid #CCC;\">";
				
				$message_mail .= "		<tr>
											<th style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">#</th>
											<th style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">Товар</th>
											<th style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">Количество</th>
											<th style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">Цена</th>
											<th style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">Итого</th>
										</tr>";
				
				$p_cnt = 0;
				
				$quant = 0;
				$summ = 0;
				
				foreach($products as $cd_item)
				{
					$query = "SELECT * FROM [pre]shop_products WHERE `id`='".$cd_item['prod_id']."' LIMIT 1";
					$prod_data = $ah->rs($query);
					
					$curr_pprice = ($cd_item['price_dif'] ? $cd_item['price_dif'] : $cd_item['price']);
					$curr_pname = ($cd_item['price_dif'] ? $cd_item['name']." (".$cd_item['char_value'].")" : $cd_item['name']);
					
					$quant += $cd_item['quant'];
					$summ += ($cd_item['quant']*$curr_pprice);
					
					if($prod_data)
					{
						$prod = $prod_data[0];
						
						$new_in_stock = $prod['in_stock']-$cd_item['quant'];
						$new_quant = $prod['quant']-$cd_item['quant'];
						
						if($new_in_stock < 0) $new_in_stock = 0;
						if($new_quant < 0) $new_quant = 0;
						
						$query = "UPDATE [pre]shop_products SET `quant`='".$new_quant."',`in_stock`='".$new_in_stock."' WHERE `id`='".$cd_item['prod_id']."' LIMIT 1";
						$ah->rs($query);
						
						$p_cnt++;
						$message_mail .= "<tr>
											<td style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">$p_cnt</td>
											<td style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">".$prod['name']."</td>
											<td style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\" align=\"center\">".$cd_item['quant']."</td>
											<td style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">".$curr_pprice." грн</td>
											<td style=\"padding:5px; border-bottom:1px solid #CCC; border-right:1px solid #CCC;\">".($cd_item['quant']*$curr_pprice)." грн</td>
										</tr>";
					}
				}
				$message_mail .= "</table>";
				
				$message_mail .= "<br><hr><br>";
				
				$message_mail .= "<p>Количество товаров: <strong>$quant</strong></p>";
				$message_mail .= "<p>Сумма заказа: <strong>$summ грн</strong></p>";

				$message_mail_client .= $message_mail;
				$message_mail_admin .= $message_mail;
				
				$subject_mail = "Новый заказ #".($order_id+5000)." на dveri-prestige.kiev.ua";
				
				
				$mail_from = "support@dveri-prestige.kiev.ua";
				
				
				$data['client_mail'] = $ah->wp_send_letter($profile['login'],$mail_from,$subject_mail,$message_mail_client,"Dveri-Prestige STORE");
				
				$data['admin_mail'] = $ah->wp_send_letter($mail_from,$mail_from,$subject_mail,$message_mail_admin, "Dveri-Prestige STORE");
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// Конец уведомления на почту
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		}
		else{
			$data['status'] = "failed";
			$data['message'] = "Список товаров не может быть пустым, заказ отклонен.";
			}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Пользователь не выбран, заказ отклонен.";
		}
	