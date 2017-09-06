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
					'pos_id'		=> $_POST['pos_id'],
					'order_id'		=> $_POST['order_id'],					
					'block'			=> $_POST['block'][0],
					
					$lang_prefix.'data'		=> $_POST[$lang_prefix.'data'],
					'link'			=> $_POST['link'],
					'target'		=> $_POST['target'][0],
					//'startPublish'	=> date("Y-m-d H:i:s", strtotime($_POST['startPublish'])),
					//'finishPublish'	=> date("Y-m-d H:i:s", strtotime($_POST['finishPublish'])),
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	// File big upload 
	
	$filename = "file";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/split/files/content/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"bst_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename
			  ));
		if($file_update)
		{
			$cardUpd[$filename] = $file_update;
			
			$curr_filename = $_POST['curr_filename'];
			
			unlink($file_path.$curr_filename);
		}
	}
	
	// File mob upload 
	
	$filename = "file_sm";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/split/files/content/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"bst_mob_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>1366,
				'max_h'			=>768,
				'files'			=>$filename
			  ));
		if($file_update)
		{
			$cardUpd[$filename] = $file_update;
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
			
	$ah->rs($query);
	
	
	$data['message'] = "Баннер успешно сохранен. ".$lang_prefix;
	