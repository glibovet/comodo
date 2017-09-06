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
					'site'			=> $_POST['site'],
					'video'			=> $_POST['video'],	
					
					$lang_prefix.'country'		=> strip_tags(trim($_POST[$lang_prefix.'country'])),
					$lang_prefix.'details'		=> $_POST[$lang_prefix.'details'],
					
					$lang_prefix.'meta_title'	=> strip_tags(trim($_POST[$lang_prefix.'meta_title'])),
					$lang_prefix.'meta_keys'	=> strip_tags(trim($_POST[$lang_prefix.'meta_keys'])),
					$lang_prefix.'meta_desc'	=> strip_tags(trim($_POST[$lang_prefix.'meta_desc'])),
										
					//'cat_id'		=> $_POST['cat_id'],
					'block'			=> $_POST['block'][0],
					
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
					
	
	$query = "SELECT id FROM [pre]$appTable WHERE `alias`='".$cardUpd['alias']."' AND `id`!=$item_id LIMIT 1";
	$test_alias = $ah->rs($query);
	
	if(strlen($cardUpd[$lang_prefix.'name'])>1)
	{
		if(!$test_alias || true)
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
					
			$ah->rs($query);			
			
			
		}else{
			$data['status'] = "failed";
			$data['message'] = "Производитель с таким Алиасом уже существует";
			}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Укажите Название Производитель";
		}
	
	$data['message'] = "Производитель успешно сохранен. ".$lang_prefix;
	