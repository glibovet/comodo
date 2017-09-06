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
					// 'link'		=> strip_tags(trim($_POST['link'])),
					'type'		=> $_POST['type'],
					
					//'relation'	=> 0,
					
					'pos_id'		=> $_POST['pos_id'],
					'parent'		=> $_POST['parent'],
					'block'			=> $_POST['block'][0],
					
					'details'		=> $_POST['details'],
					'ua_details'	=> $_POST['details'],
					'en_details'	=> $_POST['details'],					
					
					'meta_title'	=> $_POST['meta_title'],
					'meta_keys'		=> $_POST['meta_keys'],
					'meta_desc'		=> $_POST['meta_desc'],					
					
					'ua_meta_title'	=> $_POST['meta_title'],
					'ua_meta_keys'	=> $_POST['meta_keys'],
					'ua_meta_desc'	=> $_POST['meta_desc'],					
					
					'en_meta_title'	=> $_POST['meta_title'],
					'en_meta_keys'	=> $_POST['meta_keys'],
					'en_meta_desc'	=> $_POST['meta_desc'],
					
					//'target'		=> $_POST['target'][0],
					//'top_view'		=> $_POST['top_view'][0],
					
					'gallery_id'	=> $_POST['gallery_id'],
					//'script_name'	=> strip_tags(trim($_POST['script_name'])),
					
					//'text_pos'		=> $_POST['text_pos'],
					//'gallery_pos'	=> $_POST['gallery_pos'],
					//'script_pos'	=> $_POST['script_pos'],
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	switch($cardUpd['type'])
	{
		case 2:
		{
			$cardUpd['relation'] = $_POST['relation-2']; // One category of materials
			break;
		}
		case 3:
		{
			$relation_3 = array();
			foreach($_POST['relation-3'] as $rel_id)
			{
				array_push($relation_3,$rel_id);
			}
			$cardUpd['relation'] = serialize($relation_3); // Many categories of materials
			break;
		}
		default: break;
	}
	
	$query = "SELECT id FROM [pre]menu WHERE `alias`='".$cardUpd['alias']."' LIMIT 1";
	$test_alias = $ah->rs($query);
				
	if(strlen($cardUpd['name'])>1)
	{
		if(!$test_alias)
		{
	
				// File upload 
				
				$filename = "filename";
				
				if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
				{
					$file_path = "../../../../split/files/content/";
					
					$file_update = $ah->mtvc_add_files_file(array(
							'path'			=>$file_path,
							'name'			=>5,
							'pre'			=>"menu_",
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
					
					// Upload files
				
					$filename = "docs";
					
					if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0)
					{
						$file_path = "../../../../split/files/documents/";
						
						$files_upload = $ah->mtvc_add_files_file_miltiple(array(
								'path'			=>$file_path,
								'name'			=>5,
								'pre'			=>"doc_",
								'size'			=>20,
								'rule'			=>0,
								'max_w'			=>2500,
								'max_h'			=>2500,
								'files'			=>$filename
							  ));
						if($files_upload)
						{
							foreach($files_upload as $file_upload)
							{
								$query = "INSERT INTO [pre]docs_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('menu', '$item_id', '$file_upload', '0', 'split/files/documents/')";
								
								$ah->rs($query);
							}
						}
					}
					
				}else
				{
					$data['item_id'] = 0;
				}
			
			}else{
			$data['status'] = "failed";
			$data['message'] = "Меню с таким Алиасом уже существует";
			}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Укажите Название пункта меню";
		}
	
	$data['message'] = "Новый пункт Меню успешно создан.";
	