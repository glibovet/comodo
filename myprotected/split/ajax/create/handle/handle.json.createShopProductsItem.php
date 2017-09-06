<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cat_id = (int)$_POST['cat_id'];
	
	$mf_id = (int)$_POST['mf_id'];	
	
	$model = trim(strip_tags($_POST['model']));
	
	$color_id = (int)$_POST['color_id'];
	
	$mat_id = (int)$_POST['mat_id'];
	
	$query = "SELECT * FROM [pre]shop_colors WHERE `id`=$color_id LIMIT 1";
	$color = $ah->rs($query);
	
	$query = "SELECT uah_rate, rub_rate, eur_rate FROM [pre]shop_settings WHERE `id`=1 LIMIT 1";
	$rates = $ah->rs($query);
	
	$uah_rate = $rates['0']['uah_rate'];
	$rub_rate = $rates['0']['rub_rate'];
	$eur_rate = $rates['0']['eur_rate'];
	
	/*if($_POST['sale_per']){
		$sale_per = (float)$_POST['sale_per'];
		$newPrice = ROUND(((float)$_POST['usd_sale_price']*$uah_rate)-((((float)$_POST['usd_sale_price']*$uah_rate)*($sale_per))/100),2);
		$newRubPrice = ROUND(((float)$_POST['usd_sale_price']*$rub_rate)-((((float)$_POST['usd_sale_price']*$rub_rate)*($sale_per))/100),2);
		$newEurPrice = ROUND(((float)$_POST['usd_sale_price']*$eur_rate)-((((float)$_POST['usd_sale_price']*$eur_rate)*($sale_per))/100),2);
		$newUsdPrice = (float)$_POST['usd_sale_price']-(((float)$_POST['usd_sale_price']*$sale_per)/100);
		
		$newPrice = ceil(($_POST['usd_sale_price']*$uah_rate)-((((float)$_POST['usd_sale_price']*$uah_rate)*($sale_per))/100));
		$newRubPrice = ceil(($_POST['usd_sale_price']*$rub_rate)-((((float)$_POST['usd_sale_price']*$rub_rate)*($sale_per))/100));
		$newEurPrice = ceil(($_POST['usd_sale_price']*$eur_rate)-((((float)$_POST['usd_sale_price']*$eur_rate)*($sale_per))/100));
		$newUsdPrice = ceil($_POST['usd_sale_price']-(((float)$_POST['usd_sale_price']*$sale_per)/100));
		
		}else{
			$sale_per = (float)$_POST['sale'];
			$newPrice = ROUND((float)$_POST['usd_price']*$uah_rate,2);
			$newRubPrice = ROUND((float)$_POST['usd_price']*$rub_rate,2);
			$newEurPrice = ROUND((float)$_POST['usd_price']*$eur_rate,2);
			$newUsdPrice = (float)$_POST['usd_price'];
			
			$newPrice = ceil($_POST['usd_price']*$uah_rate);
			$newRubPrice = ceil($_POST['usd_price']*$rub_rate);
			$newEurPrice = ceil($_POST['usd_price']*$eur_rate);
			$newUsdPrice = ceil($_POST['usd_price']);
			}
	
	// color func
	
	if(!$color_id)
	{
		$color_name = trim(strip_tags($_POST['color_name']));
		$ua_color_name = trim(strip_tags($_POST['ua_color_name']));
		$en_color_name = trim(strip_tags($_POST['en_color_name']));
		$color_value = trim(strip_tags($_POST['color_value']));
		
		if($color_name && strlen($color_value)==7)
		{
			$query = "INSERT INTO [pre]shop_colors (`name`, `ua_name`, `en_name`, `value`) VALUES ('$color_name', '$ua_color_name', '$en_color_name', '$color_value')";
			$ah->rs($query);
			
			$color_id = mysql_insert_id();
		}
	}*/
		
	$cardUpd = array(
					'name'			=> strip_tags(trim($_POST['name'])),
					'ua_name'		=> strip_tags(trim($_POST['name'])),
					'en_name'		=> strip_tags(trim($_POST['name'])),
					'alias'			=> $_POST['alias'],
					'block'			=> $_POST['block'][0],
					'index'			=> $_POST['index'][0],					
					//'video'			=> $_POST['video'],
					
					//'model'			=> $model,
					'color_id'		=> $color_id,
					
					//'deliver_id'	=> (int)$_POST['deliver_id'],
					'cat_id'		=> (int)$_POST['cat_id'],
					'mf_id'			=> (int)$_POST['mf_id'],
					'collection_id'	=> (int)$_POST['collection_id'],
					'obj_id'		=> (int)$_POST['obj_id'],

					//'usd_price'			=> $newUsdPrice,
					//'usd_sale_price'	=> (float)$_POST['usd_sale_price'],
					
					//'price' 		=> $newPrice,
					//'rub_price'		=> $newRubPrice,
					'eur_price' 	=> (float)$_POST['eur_price'],
					
					//'sale'	=> $sale_per,
					
					//'sale_price' 		=> ceil ($_POST['usd_sale_price']*$uah_rate),
					//'rub_sale_price' 	=> ceil ($_POST['usd_sale_price']*$rub_rate),
					//'eur_sale_price' 	=> ceil ($_POST['usd_sale_price']*$eur_rate),
					
					//'dop_text'		=> $_POST['dop_text'],
					
					'quant'			=> (int)$_POST['quant'],
					
								
					//'proportions'		=> $_POST['proportions'],
					'width'			=> (float)$_POST['width'],
					'depth'			=> (float)$_POST['depth'],
					'height'		=> (float)$_POST['height'],
					'diameter'		=> (float)$_POST['diameter'],
					//'weight'		=> (float)$_POST['weight'],
					
					'in_stock'		=> $_POST['in_stock'],
					'sku'			=> $_POST['sku'],
					//'code'			=> $_POST['code'],
					'details'		=> $_POST['details'],
					'ua_details'	=> $_POST['details'],
					'en_details'	=> $_POST['details'],
					
					'title'			=> $_POST['title'],
					'keys'			=> $_POST['keys'],
					'desc'			=> $_POST['desc'],
					
					'ua_title'		=> $_POST['title'],
					'ua_keys'		=> $_POST['keys'],
					'ua_desc'		=> $_POST['desc'],
					
					'en_title'		=> $_POST['title'],
					'en_keys'		=> $_POST['keys'],
					'en_desc'		=> $_POST['desc'],
					//'date_start'	=> date("Y-m-d H:i:s", strtotime($_POST['date_start'])),
					//'date_finish'	=> date("Y-m-d H:i:s", strtotime($_POST['date_finish'])),
					
					'adminMod'=>ADMIN_ID,
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	if($cardUpd['in_stock'] > $cardUpd['quant']) $cardUpd['in_stock'] = $cardUpd['quant'];
					
	$query = "SELECT id FROM [pre]shop_products WHERE `alias`='".$cardUpd['alias']."' LIMIT 1";
	$test_alias = $ah->rs($query);
	
	$query = "SELECT id FROM [pre]shop_products WHERE `sku`='".$cardUpd['sku']."' LIMIT 1";
	$test_sku = $ah->rs($query);	
	
	if(strlen($cardUpd['name'])>1)
	{
		if(strlen($cardUpd['sku'])>1)
		{
			if(!$test_alias)
			{
				if(!$test_sku)
				{
					if($cat_id)
					{
					if($mf_id)
					{
				
				// Start of success saving
				
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
				
				//echo "<pre>"; print_r($query); echo "</pre>";  exit();
					
				$ah->rs($query);	
				
				$item_id = mysql_insert_id();
				
				
				$data['item_id'] = $item_id;
				
				// Ref with assessuares
				
				$query = "UPDATE [pre]shop_prod_access_ref SET `prod_id`=$item_id WHERE `prod_id`=0 LIMIT 1000";
				$ah->rs($query);
				
				// Ref with category
				
				/*$query = "INSERT INTO [pre]shop_cat_prod_ref (`cat_id`,`prod_id`) VALUES ('$cat_id','$item_id')";
				
				$ah->rs($query);*/
				
				
	
				// Ref with color Groups	
				$color_groups = $_POST['color_groups'];
				
				foreach($color_groups as $group_id)
				{
					$query = "INSERT INTO [pre]shop_color_prod_ref (`prod_id`,`color_id`) VALUES ('$item_id','$group_id')";
					$ah->rs($query);
				}
				
				// Ref with product Groups				
				$product_groups = $_POST['product_groups'];
				
				foreach($product_groups as $group_id)
				{
					$query = "INSERT INTO [pre]shop_prod_group_ref (`prod_id`,`group_id`) VALUES ('$item_id','$group_id')";
					$ah->rs($query);
				}
				
				// Ref with chars
				
				$char = (isset($_POST['char']) ? $_POST['char'] : array());
				$char2 = (isset($_POST['char2']) ? $_POST['char2'] : array());
				$char3 = (isset($_POST['char3']) ? $_POST['char3'] : array());
				$char4 = (isset($_POST['char4']) ? $_POST['char4'] : array());
				$char5 = (isset($_POST['char5']) ? $_POST['char5'] : array());
				$char6 = (isset($_POST['char6']) ? $_POST['char6'] : array());
				
				foreach($char as $char_id => $value)
				{
					if($value)
					{
						$ua_value = (isset($char3[$char_id]) ? $char3[$char_id] : "");
						$en_value = (isset($char5[$char_id]) ? $char5[$char_id] : "");
						$is_filter = 1;
				
						$findValQuery = "SELECT id FROM [pre]shop_chars_values WHERE `char_id`='$char_id' AND `value`='$value' LIMIT 1";
						$findVal = $ah->rs($findValQuery);
						
						if($findVal)
						{
							$charValId = $findVal[0]['id'];
					
							$query = "UPDATE [pre]shop_chars_values SET `ua_value`='$ua_value',`en_value`='$en_value' WHERE `id`='$charValId' LIMIT 1";
							$ah->rs($query);
						}else
						{
							$query = "INSERT INTO [pre]shop_chars_values (`char_id`,`value`,`ua_value`,`en_value`) 
																	VALUES('$char_id','$value','$ua_value','$en_value')";
							$ah->rs($query);
							$charValId = mysql_insert_id();
						}
						
						$query = "INSERT INTO [pre]shop_chars_prod_ref (`prod_id`,`char_id`,`val_id`,`filter`) 
														VALUES ('$item_id','$char_id','$charValId','$is_filter')";
						$ah->rs($query);
					}
				}
				
				// Upload files
				
				$filename = "images";
				
				if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
				{
					$file_path = "../../../../webroot/img/split/files/shop/products/";
					
					$files_upload = $ah->mtvc_add_files_file_miltiple(array(
							'path'			=>$file_path,
							'name'			=>5,
							'pre'			=>"prod_",
							'size'			=>10,
							'rule'			=>0,
							'max_w'			=>1920,
							'max_h'			=>1080,
							'files'			=>$filename,
							'resize_path'	=>$file_path."crop/",
							'resize_w'		=>400,
							'resize_h'		=>300,
							'resize_path_2'	=>"0",
							'resize_w_2'	=>0,
							'resize_h_2'	=>0
						  ));
					if($files_upload)
					{
						foreach($files_upload as $file_upload)
						{
							$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('shop_products', '$item_id', '$file_upload', '400x300_".$file_upload."', 'webroot/img/split/files/shop/products/')";
							
							$ah->rs($query);
						}
					}
				}
				
				// Upload video
			
				$filename = "video";
				
				if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0)
				{
					$file_path = "../../../../webroot/img/split/files/shop/products/video/";
					
					$file_update = $ah->mtvc_add_files_file(array(
							'path'			=>$file_path,
							'name'			=>5,
							'pre'			=>"video_",
							'size'			=>20,
							'rule'			=>0,
							'max_w'			=>2500,
							'max_h'			=>2500,
							'files'			=>$filename
						  ));
					if($file_update)
					{
						//$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('prod_video', '$item_id', '$file_update', '0', 'webroot/img/split/files/shop/products/video/')";
						$query = "UPDATE [pre]shop_products SET `video`='$file_update' WHERE `id`=$item_id LIMIT 1";			
						$ah->rs($query);
							
					}
				}
				
				
				$data['status'] = "success";
				$data['message'] = "Новый товар успешно создан";
				
				// End of success saving
				
				
					}else{
						$data['status'] = "failed";
						$data['message'] = "Укажите производителя";
					}
					}else{
						$data['status'] = "failed";
						$data['message'] = "Укажите категорию товара";
					}
				}else{
					$data['status'] = "failed";
					$data['message'] = "Товар с таким Артикулом уже существует";
				}
			}else{
					$data['status'] = "failed";
					$data['message'] = "Товар с таким Алиасом уже существует";
				}
		}else{
				$data['status'] = "failed";
				$data['message'] = "Укажите артикул товара";
			}
	}else{
			$data['status'] = "failed";
			$data['message'] = "Укажите название товара";
		}
	
	