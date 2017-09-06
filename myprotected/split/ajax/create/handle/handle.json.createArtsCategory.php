<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$cardUpd = array(
					'name'			=> $_POST['name'],
					'ua_name'		=> $_POST['name'],
					'en_name'		=> $_POST['name'],
					'alias'			=> $_POST['alias'],
					'block'			=> $_POST['block'][0],
					//'details'		=> $_POST['details'],
					//'ua_details'		=> $_POST['details'],
					//'en_details'		=> $_POST['details'],
					
					'meta_title'	=> $_POST['meta_title'],
					'meta_keys'		=> $_POST['meta_keys'],
					'meta_desc'		=> $_POST['meta_desc'],
					
					'ua_meta_title'	=> $_POST['meta_title'],
					'ua_meta_keys'	=> $_POST['meta_keys'],
					'ua_meta_desc'	=> $_POST['meta_desc'],
					
					'en_meta_title'	=> $_POST['meta_title'],
					'en_meta_keys'	=> $_POST['meta_keys'],
					'en_meta_desc'	=> $_POST['meta_desc'],
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	// File upload 
	
	$filename = "filename";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/split/files/projects/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"cat_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename
			  ));
		if($file_update)
		{
			$cardUpd[$filename] = $file_update;
		}
	}
	
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
		
	$ah->rs($query);
	
	$item_id = mysql_insert_id();
	
	if($item_id)
	{
		$data['item_id'] = $item_id;
	}else
	{
		$data['item_id'] = 0;
	}
	
	$data['message'] = "Новая категория материалов успешно создана.";
	