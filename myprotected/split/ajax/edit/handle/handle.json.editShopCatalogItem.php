<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					$lang_prefix.'name'			=> strip_tags(trim($_POST[$lang_prefix.'name'])),
					
					'alias'			=> $_POST['alias'],
					'block'			=> $_POST['block'][0],
					'index'			=> $_POST['index'][0],
					'specs_group_id'=> $_POST['charsGroup'],
					'parent'		=> $_POST['parent'],
					
					$lang_prefix.'details'		=> $_POST[$lang_prefix.'details'],		
					
					$lang_prefix.'meta_title'	=> $_POST[$lang_prefix.'meta_title'],
					$lang_prefix.'meta_keys'	=> $_POST[$lang_prefix.'meta_keys'],
					$lang_prefix.'meta_desc'	=> $_POST[$lang_prefix.'meta_desc'],
					
					//'startPublish'	=> date("Y-m-d H:i:s", strtotime($_POST['startPublish'])),
					//'finishPublish'	=> date("Y-m-d H:i:s", strtotime($_POST['finishPublish'])),
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
$query = "SELECT id FROM [pre]shop_catalog WHERE `alias`='".$cardUpd['alias']."' AND `id`!=$item_id LIMIT 1";
$test_alias = $ah->rs($query);					

if(strlen($cardUpd[$lang_prefix.'name'])>1)
{
	if(!$test_alias)
	{
					
	// File upload 
	
	$filename = "filename";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/split/files/shop/categories/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"cat_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>500,
				'max_h'			=>375,
				'files'			=>$filename
			  ));
		if($file_update)
		{
			$cardUpd[$filename] = $file_update;
			
			$curr_filename = $_POST['curr_filename'];
			
			unlink($file_path.$curr_filename);
		}
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
		
	$data['block'] = $cardUpd['block'];
	
	$data['query'] = $query;
		
	$ah->rs($query);
	
	// Update chars group
	
	if(isset($_POST['charsGroup']))
	{
		$charsGroup = $_POST['charsGroup'];
		
		$query = "SELECT `id`,`group_id` FROM [pre]shop_cat_chars_group_ref WHERE `cat_id`=$item_id LIMIT 1";
		$result = $ah->rs($query);
		
		if($charsGroup==0)
		{
			$query = "DELETE FROM [pre]shop_cat_chars_group_ref WHERE `cat_id`=$item_id";
			$ah->rs($query);
		
		}elseif($result)
		{
			if($result[0]['group_id'] != $charsGroup)
			{
				$query = "UPDATE [pre]shop_cat_chars_group_ref SET `group_id`=$charsGroup WHERE `id`='".$result[0]['id']."' LIMIT 1";
				$ah->rs($query);
			}
		}else
		{
			$query = "INSERT INTO [pre]shop_cat_chars_group_ref (`cat_id`,`group_id`) VALUES ('$item_id','$charsGroup')";
			$ah->rs($query);
		}
	}
	
	$data['message'] = "Успешное сохранение! ".$lang_prefix;
	
	}else{
		$data['status'] = "failed";
		$data['message'] = "Категория с таким Алиасом уже существует.";
		}
}
else{
	$data['status'] = "failed";
	$data['message'] = "Укажите название категории.";
	}
	