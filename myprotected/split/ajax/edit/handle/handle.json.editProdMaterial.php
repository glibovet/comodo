<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					$lang_prefix.'name'			=> strip_tags(trim($_POST[$lang_prefix.'name'])),
					'order_id'		=> $_POST['order_id']
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
	
	// Update product Groups
	
	$cat_groups = $_POST['cat_groups'];
	
		$query = "SELECT M.id, M.name, M.block FROM [pre]shop_catalog as M LEFT JOIN [pre]shop_obj_cat_ref as R on M.id = R.cat_id WHERE R.obj_id = $item_id LIMIT 100";
		
		$groupsMassive = $ah->rs($query);
		
		//echo "<pre>"; print_r($groupsMassive); echo "</pre>";  exit();
	
	foreach($groupsMassive as $mas_item)
	{
		$find_ref = false;
		$di = -1;
		foreach($cat_groups as $i => $group_id)
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
				$query = "DELETE FROM [pre]shop_obj_cat_ref WHERE `obj_id`=$item_id AND `cat_id`=".$mas_item['id']." LIMIT 1";
				$ah->rs($query);
			}else
			{
				unset($cat_groups[$di]);
			}
	}
	foreach($cat_groups as $group_id)
	{
		$query = "INSERT INTO [pre]shop_obj_cat_ref (`obj_id`,`cat_id`) VALUES ('$item_id','$group_id')";
		$ah->rs($query);
	}
	
	
	
	$data['message'] = "Предмет продукта успешно сохранен. ".$lang_prefix;
	