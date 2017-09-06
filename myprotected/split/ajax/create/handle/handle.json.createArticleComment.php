<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'user_id'		=> (int)$_POST['user_id'],
					//'art_id'		=> (int)$_POST['art_id'],
					
					//'name'			=> $_POST['name'],
					//'caption'		=> $_POST['caption'],
					'comment'		=> $_POST['comment'],
					
					'rating'		=> (int)$_POST['rating'],
					
					'block'			=> $_POST['block'][0],
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	if(strlen($cardUpd['comment'])>4 && $cardUpd['user_id'])
	{
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
		
		// Update sccess values to menu items
		
		$ac = $_POST['ac'];
		
		foreach($ac as $menu_id => $access)
		{
			$query = "INSERT INTO [pre]user_type_access (`type_id`,`menu_id`,`access`) VALUES ('$item_id','$menu_id','$access')";
			$ah->rs($query);
			unset($ac[$menu_id]);
		}
		
		// Upload files
				
				$filename = "images";
				
				if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
				{
					$file_path = "../../../../webroot/img/split/files/users/";
					
					$files_upload = $ah->mtvc_add_files_file_miltiple(array(
							'path'			=>$file_path,
							'name'			=>5,
							'pre'			=>"comm_",
							'size'			=>10,
							'rule'			=>0,
							'max_w'			=>3333,
							'max_h'			=>3333,
							'files'			=>$filename,
							'resize_path'	=>$file_path."crop/",
							'resize_w'		=>386,
							'resize_h'		=>585,
							'resize_path_2'	=>"0",
							'resize_w_2'	=>0,
							'resize_h_2'	=>0
						  ));
					if($files_upload)
					{
						foreach($files_upload as $file_upload)
						{
							$query = "INSERT INTO [pre]files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('article_comments', '$item_id', '$file_upload', '0', 'webroot/img/split/files/users/')";
							
							$ah->rs($query);
						}
					}
				}
		
		$data['status'] = "success";
		$data['message'] = "Новый отзыв успешно создан";
	}else
	{
		$data['status']='failed';
		$data['message']='Необходимо заполнить все поля';
	}
	