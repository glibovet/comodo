<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'name'			=> $_POST['name'],
					'caption'		=> $_POST['caption'],
					'block'			=> $_POST['block'][0],
					
					'data'			=> $_POST['data'],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	$query = "SELECT id FROM [pre]galleries WHERE `name`='".$cardUpd['name']."' AND `id`!=$item_id LIMIT 1";
	$test_name = $ah->rs($query);
	
	if(strlen($cardUpd['name'])>1)
	{
			if(!$test_name)
			{
					
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
	
	// Upload files
	
	$filename = "images";
	
	if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0)
	{
		$file_path = "../../../../webroot/img/split/files/content/";
		
		$files_upload = $ah->mtvc_add_files_file_miltiple(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"gall_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename
				/*'resize_path'	=>$file_path."crop/",
				'resize_w'		=>300,
				'resize_h'		=>300,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0*/
			  ));
		if($files_upload)
		{
			foreach($files_upload as $file_upload)
			{
				$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('galleries', '$item_id', '$file_upload', '0', 'webroot/img/split/files/content/')";
				
				$ah->rs($query);
			}
		}
	}
	
	$data['message'] = "Галлерея успешно сохранена!";
	
				
		}else{
				$data['status'] = "failed";
				$data['message'] = "Галлерея с таким именем уже существует";
			}
	}else{
			$data['status'] = "failed";
			$data['message'] = "Укажите название Галлереи";
		}
	
	