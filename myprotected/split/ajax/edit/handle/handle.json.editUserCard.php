<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					$lang_prefix.'name'		=> strip_tags(trim($_POST[$lang_prefix.'name'])),
					'alias'					=> $_POST['alias'],					
					
					$lang_prefix.'fname'	=> strip_tags(trim($_POST[$lang_prefix.'fname'])),
					
					'login'					=> $_POST['login'],
					'phone'					=> $_POST['phone'],
					
					$lang_prefix.'position'	=> strip_tags(trim($_POST[$lang_prefix.'position'])),
					
					$lang_prefix.'delivery_address'	=> strip_tags(trim($_POST[$lang_prefix.'delivery_address'])),
					
					'block'					=> $_POST['block'][0],
					'worker'				=> $_POST['worker'][0],
					'active'				=> $_POST['active'][0],
					'male'					=> $_POST['male'][0],
					
					$lang_prefix.'skills'	=> strip_tags(trim($_POST[$lang_prefix.'skills'])),
										
					$lang_prefix.'credo'	=> strip_tags(trim($_POST[$lang_prefix.'credo'])),
														
					$lang_prefix.'details'	=> $_POST[$lang_prefix.'details'],				
					
					'type'					=> $_POST['type'],
					
					'order_id'					=> (int)$_POST['order_id'],
					
					'birthday'				=> date("Y-m-d H:i:s", strtotime($_POST['birthday'])),
					
					'dateModify'			=> date("Y-m-d H:i:s", time())
					);
					
	// File upload 
	
	$filename = "avatar";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/split/files/users/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"us_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename,
				'resize_path'	=>$file_path."crop/",
				'resize_w'		=>150,
				'resize_h'		=>150
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
	
	// Update user extra fields
	
	$ef = $_POST['ef'];
	
	foreach($ef as $ef_id => $ef_value)
	{
		$query = "SELECT id FROM [pre]user_ef_ref WHERE `user_id`='$item_id' AND `ef_id`='$ef_id' LIMIT 1";
		$ex_ref = $ah->rs($query);
		
		if($ex_ref)
		{
			$ex_id = $ex_ref[0]['id'];
			$query = "UPDATE [pre]user_ef_ref SET `value`='$ef_value' WHERE `id`='$ex_id'";
			$ah->rs($query);
		}else
		{
			$query = "INSERT INTO [pre]user_ef_ref (`user_id`,`ef_id`,`value`) VALUES ('$item_id','$ef_id','$ef_value')";
			$ah->rs($query);
		}
	}
	
	$data['message'] = "Success user save. ";
	
	// Change password
	
	if(isset($_POST['old-pass']))
	{
		$oldPass	= $_POST['old-pass'];
		$newPass	= $_POST['new-pass'];
		$newPassR	= $_POST['new-pass-r'];
		
		$query = "SELECT pass FROM [pre]users WHERE `id`='$item_id' LIMIT 1";
		$userData = $ah->rs($query);
		
		if($userData)
		{
			$userPass = $userData[0]['pass'];
			
			if( (md5($oldPass)==$userPass || ADMIN_TYPE==1) && trim($newPass) != "")
			{
				if($newPass===$newPassR)
				{
					$query = "UPDATE [pre]users SET `pass`='".md5($newPass)."' WHERE `id`='$item_id' LIMIT 1";
					$ah->rs($query);
					
					$letter = "<p>Здравствуйте, ".$cardUpd['name']." ".$cardUpd['fname']."!</p>";
					
					$letter .= "<p>Уведомляем Вас о том, что Ваш пароль для аккаунта <b>".$cardUpd['login']."</b> на сайте <u>http://comodo.kiev.ua</u> был изменен!</p>";
					
					$letter .= "<h4>Новые параметры для входа:</h4>";
					
					$letter .= "<table border='1'>
									<tr>
										<td style='padding:5px;'>Логин</td>
										<td style='padding:5px;'>".$cardUpd['login']."</td>
									</tr>
									<tr>
										<td style='padding:5px;'>Пароль</td>
										<td style='padding:5px;'>".$newPass."</td>
									</tr>
								</table>";
								
					$letter .= "<p>Если Вы не являетесь владельцем данного аккаунта - просто удалите это письмо.</p>";
					
					$ah->wp_send_letter($cardUpd['login'],"support@comodo.kiev.ua","Ваш пароль был изменен.",$letter);
					
					$data['message'] .= "Пароль успешно обновлен.";
				}else{
					$data['message'] .= "Пароли не совпадают!";
					}
			}else{
					if(trim($newPass) != "")
					{
						$data['message'] .= "Старый пароль введен неверно!";
					}
				}
		}
	}
	