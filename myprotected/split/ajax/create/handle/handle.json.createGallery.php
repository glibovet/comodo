<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$cardUpd = array(
					'name'			=> $_POST['name'],
					'caption'		=> $_POST['caption'],
					
					'block'			=> $_POST['block'][0],
					
					'data'		=> $_POST['data'],
					
					'adminMod'=>ADMIN_ID,
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	$query = "SELECT id FROM [pre]shop_products WHERE `name`='".$cardUpd['name']."' LIMIT 1";
	$test_name = $ah->rs($query);
	
	$item_id = 0;
	
	if(strlen($cardUpd['name'])>1)
	{
			if(!$test_name)
			{
				
				
				// Start of success saving
				
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
				
				$data['status'] = "success";
				$data['message'] = "Новая галлерея успешно создана";
				
				// End of success saving
				
		}else{
				$data['status'] = "failed";
				$data['message'] = "Галерея с таким именем уже существует!";
			}
	}else{
			$data['status'] = "failed";
			$data['message'] = "Укажите название Галлереи!";
		}
	
	