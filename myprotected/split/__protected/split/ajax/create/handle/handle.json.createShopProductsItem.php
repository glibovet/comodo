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
					'block'			=> $_POST['block'][0],
					'index'			=> $_POST['index'][0],
					'price'			=> $_POST['price'],
					'quant'			=> $_POST['quant'],
					'sku'			=> $_POST['sku'],
					'code'			=> $_POST['code'],
					'details'		=> $_POST['details'],
					'title'			=> $_POST['title'],
					'keys'			=> $_POST['keys'],
					'desc'			=> $_POST['desc'],
					'date_start'	=> date("Y-m-d H:i:s", strtotime($_POST['date_start'])),
					'date_finish'	=> date("Y-m-d H:i:s", strtotime($_POST['date_finish'])),
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
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
	
	// Ref with category
	
	$cat_id = (int)$_POST['cat_id'];
	
	$query = "INSERT INTO [pre]shop_cat_prod_ref (`cat_id`,`prod_id`) VALUES ('$cat_id','$item_id')";
	
	$ah->rs($query);
	
	// Ref with product Groups
	
	$product_groups = $_POST['product_groups'];
	
	foreach($product_groups as $group_id)
	{
		$query = "INSERT INTO [pre]shop_prod_group_ref (`prod_id`,`group_id`) VALUES ('$item_id','$group_id')";
		$ah->rs($query);
	}
	
	// Ref with chars
	
	$char = (isset($_POST['char']) ? $_POST['char'] : array());
	
	foreach($char as $char_id => $value)
	{
		$query = "INSERT INTO [pre]shop_chars_prod_ref (`prod_id`,`char_id`,`value`) VALUES ('$item_id','$char_id','$value')";
		$ah->rs($query);
	}
	
	// Upload files
	
	$filename = "images";
	
	if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0)
	{
		$file_path = "../../../../split/files/shop/products/";
		
		$files_upload = $ah->mtvc_add_files_file_miltiple(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"prod_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename
			  ));
		if($files_upload)
		{
			foreach($files_upload as $file_upload)
			{
				$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('shop_products', '$item_id', '$file_upload', '0', 'split/files/shop/products/')";
				
				$ah->rs($query);
			}
		}
	}
	
	$data['message'] = "Success create";
	