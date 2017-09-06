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
	
	// Update category
	
	$cat_id = (int)$_POST['cat_id'];
	
	$query = "UPDATE [pre]shop_cat_prod_ref SET `cat_id`='$cat_id' WHERE `prod_id`=$item_id LIMIT 1";
	
	$ah->rs($query);
	
	// Update product Groups
	
	$product_groups = $_POST['product_groups'];
	
		$query = "SELECT M.id, M.name, M.block FROM [pre]shop_products_groups as M LEFT JOIN [pre]shop_prod_group_ref as R on M.id = R.group_id WHERE R.prod_id = $item_id LIMIT 100";
		$groupsMassive = $ah->rs($query);
	
	foreach($groupsMassive as $mas_item)
	{
		$find_ref = false;
		$di = -1;
		foreach($product_groups as $i => $group_id)
		{	
			if($mas_item['id']==$group_id)
			{
				$find_ref = true;
				$di = $i;
				break;
			}	
		}
		if(!$find_ref)
			{
				$query = "DELETE FROM [pre]shop_prod_group_ref WHERE `prod_id`=$item_id AND `group_id`=".$mas_item['id']." LIMIT 1";
				$ah->rs($query);
			}else
			{
				unset($product_groups[$di]);
			}
	}
	foreach($product_groups as $group_id)
	{
		$query = "INSERT INTO [pre]shop_prod_group_ref (`prod_id`,`group_id`) VALUES ('$item_id','$group_id')";
		$ah->rs($query);
	}
	
	// Update chars
	
	$prevent_cat_id = $_POST['prevent_cat_id'];
	
	$char = (isset($_POST['char']) ? $_POST['char'] : array());
	
	if($prevent_cat_id == $cat_id)
	{
		foreach($char as $char_id => $value)
		{
			$query = "UPDATE [pre]shop_chars_prod_ref SET `value`='$value' WHERE `char_id`=$char_id AND `prod_id`=$item_id LIMIT 1";
			$ah->rs($query);
		}
	}else
	{
		$query = "DELETE FROM [pre]shop_chars_prod_ref WHERE `prod_id`=$item_id LIMIT 100";
		$ah->rs($query);
		
		foreach($char as $char_id => $value)
		{
			$query = "INSERT INTO [pre]shop_chars_prod_ref (`prod_id`,`char_id`,`value`) VALUES ('$item_id','$char_id','$value')";
			$ah->rs($query);
		}
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
	
	$data['message'] = "Success save";
	