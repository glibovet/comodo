<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);	
	
	$cardUpd = array(
					'name'			=> strip_tags(trim($_POST['name'])),
					'ua_name'		=> strip_tags(trim($_POST['name'])),
					'en_name'		=> strip_tags(trim($_POST['name'])),
					'alias'			=> $_POST['alias'],
					'user_id'		=> $_POST['user_id'],
					
					'pos_id'		=> $_POST['pos_id'],
					'block'			=> $_POST['block'][0],
					
					'content'		=> $_POST['content'],
					'ua_content'	=> $_POST['content'],
					'en_content'	=> $_POST['content'],				
					
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
	
	
	$query = "SELECT id FROM [pre]projects WHERE `alias`='".$cardUpd['alias']."' LIMIT 1";
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
				
				}else
				{
					$data['item_id'] = 0;
				}
				
				// Ref with chars
				
				$char = (isset($_POST['char']) ? $_POST['char'] : array());
				$char2 = (isset($_POST['char2']) ? $_POST['char2'] : array());
				$char3 = (isset($_POST['char3']) ? $_POST['char3'] : array());
				$char4 = (isset($_POST['char4']) ? $_POST['char4'] : array());
				$char5 = (isset($_POST['char5']) ? $_POST['char5'] : array());
				$char6 = (isset($_POST['char6']) ? $_POST['char6'] : array());
				
				foreach($char as $char_id => $value)
				{
					if($value)
					{
						$ua_value = (isset($char3[$char_id]) ? $char3[$char_id] : $value);
						$en_value = (isset($char5[$char_id]) ? $char5[$char_id] : $value);
						$is_filter = 1;
				
						$findValQuery = "SELECT id FROM [pre]project_chars_values WHERE `char_id`='$char_id' AND `value`='$value' LIMIT 1";
						$findVal = $ah->rs($findValQuery);
						
						if($findVal)
						{
							$charValId = $findVal[0]['id'];
					
							$query = "UPDATE [pre]project_chars_values SET `ua_value`='$ua_value',`en_value`='$en_value' WHERE `id`='$charValId' LIMIT 1";
							$ah->rs($query);
						}else
						{
							$query = "INSERT INTO [pre]project_chars_values (`char_id`,`value`,`ua_value`,`en_value`) 
																	VALUES('$char_id','$value','$ua_value','$en_value')";
							$ah->rs($query);
							$charValId = mysql_insert_id();
						}
						
						$query = "INSERT INTO [pre]project_chars_ref (`project_id`,`char_id`,`val_id`,`filter`) 
														VALUES ('$item_id','$char_id','$charValId','$is_filter')";
						$ah->rs($query);
					}
				}
				
				// Upload files				
				$filename = "images";
				
				if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
				{
					$file_path = "../../../../webroot/img/split/files/projects/";
					
					$files_upload = $ah->mtvc_add_files_file_miltiple(array(
							'path'			=>$file_path,
							'name'			=>5,
							'pre'			=>"proj_",
							'size'			=>10,
							'rule'			=>0,
							'max_w'			=>1920,
							'max_h'			=>1080,
							'files'			=>$filename,
							'resize_path'	=>$file_path."crop/",
							'resize_w'		=>400,
							'resize_h'		=>300,
							'resize_path_2'	=>"0",
							'resize_w_2'	=>0,
							'resize_h_2'	=>0
						  ));
					if($files_upload)
					{
						foreach($files_upload as $file_upload)
						{
							$query = "INSERT INTO [pre]project_files_ref (`ref_id`, `file`, `crop`) VALUES ('$item_id', '$file_upload', '400x300_".$file_upload."')";
							
							$ah->rs($query);
						}
					}
				}
				
				
		}else{
			$data['status'] = "failed";
			$data['message'] = "Проект с таким Алиасом уже существует";
			}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Укажите Название проекта";
		}
	
	$data['message'] = "Новый проект успешно создан.";
	