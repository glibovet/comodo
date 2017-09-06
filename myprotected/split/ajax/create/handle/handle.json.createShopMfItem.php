<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'name'			=> strip_tags(trim($_POST['name'])),
					'ua_name'		=> strip_tags(trim($_POST['name'])),
					'en_name'		=> strip_tags(trim($_POST['name'])),
					
					'alias'			=> $_POST['alias'],
					'site'			=> $_POST['site'],
					'video'			=> $_POST['video'],					
					
					'country'		=> strip_tags(trim($_POST['country'])),
					'ua_country'	=> strip_tags(trim($_POST['country'])),
					'en_country'	=> strip_tags(trim($_POST['country'])),	
					
					'details'		=> $_POST['details'],
					'ua_details'	=> $_POST['details'],
					'en_details'	=> $_POST['details'],				
					
					'meta_title'	=> strip_tags(trim($_POST['meta_title'])),
					'ua_meta_title'	=> strip_tags(trim($_POST['meta_title'])),
					'en_meta_title'	=> strip_tags(trim($_POST['meta_title'])),						
					
					'meta_keys'		=> strip_tags(trim($_POST['meta_keys'])),
					'ua_meta_keys'	=> strip_tags(trim($_POST['meta_keys'])),
					'en_meta_keys'	=> strip_tags(trim($_POST['meta_keys'])),						
					
					'meta_desc'		=> strip_tags(trim($_POST['meta_desc'])),
					'ua_meta_desc'	=> strip_tags(trim($_POST['meta_desc'])),
					'en_meta_desc'	=> strip_tags(trim($_POST['meta_desc'])),
					
					//'cat_id'		=> $_POST['cat_id'],
					'block'			=> $_POST['block'][0],
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
	// File upload 
	
	$filename = "filename";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/split/files/content/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"mf_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename,
				'resize_path'	=>$file_path."crop/",
				'resize_w'		=>170,
				'resize_h'		=>145,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		if($file_update)
		{
			$cardUpd[$filename] = $file_update;
			$cardUpd['crop'] = "170x145_".$file_update;
			
			$curr_filename = $_POST['curr_filename'];
			
			unlink($file_path.$curr_filename);
		}
	}				
	
	
	$query = "SELECT id FROM [pre]$appTable WHERE `alias`='".$cardUpd['alias']."' LIMIT 1";
	$test_alias = $ah->rs($query);
	
	if(strlen($cardUpd['name'])>1)
	{
		if(!$test_alias)
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
					
				$ah->rs($query);
				
				$item_id = mysql_insert_id();
				
				if($item_id)
				{
					$data['item_id'] = $item_id;	
					$data['message'] = "Новый производитель успешно создан.";			
				
				}else
				{
					$data['item_id'] = 0;
				}			
				
				
		}else{
			$data['status'] = "failed";
			$data['message'] = "Производитель с таким Алиасом уже существует";
			}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Укажите Название производителя";
		}
	
	
	
	