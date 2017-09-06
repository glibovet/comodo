<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = 0;
	
	$password = $_POST['new-password'];
	
	$cardUpd = array(
					'name'				=> strip_tags(trim($_POST['name'])),
					'ua_name'			=> strip_tags(trim($_POST['name'])),
					'en_name'			=> strip_tags(trim($_POST['name'])),
					'alias'				=> $_POST['alias'],
					
					'fname'				=> strip_tags(trim($_POST['fname'])),
					'ua_fname'			=> strip_tags(trim($_POST['fname'])),
					'en_fname'			=> strip_tags(trim($_POST['fname'])),
					
					'login'				=> $_POST['login'],
					'phone'				=> $_POST['phone'],
					
					'position'			=> strip_tags(trim($_POST['position'])),
					'ua_position'		=> strip_tags(trim($_POST['position'])),
					'en_position'		=> strip_tags(trim($_POST['position'])),
					
					'delivery_address'		=> strip_tags(trim($_POST['delivery_address'])),
					'ua_delivery_address'	=> strip_tags(trim($_POST['delivery_address'])),
					'en_delivery_address'	=> strip_tags(trim($_POST['delivery_address'])),
					
					'block'			=> $_POST['block'][0],
					'worker'		=> $_POST['worker'][0],
					'active'		=> $_POST['active'][0],
					'male'			=> $_POST['male'][0],
					
					'skills'			=> strip_tags(trim($_POST['skills'])),
					'ua_skills'			=> strip_tags(trim($_POST['skills'])),
					'en_skills'			=> strip_tags(trim($_POST['skills'])),
					
					'credo'				=> strip_tags(trim($_POST['credo'])),
					'ua_credo'			=> strip_tags(trim($_POST['credo'])),
					'en_credo'			=> strip_tags(trim($_POST['credo'])),
					
					'details'			=> $_POST['details'],
					'ua_details'		=> $_POST['details'],
					'en_details'		=> $_POST['details'],
					
					'type'			=> $_POST['type'],			
					
					'order_id'		=> (int)$_POST['order_id'],
					'birthday'		=> date("Y-m-d H:i:s", strtotime($_POST['birthday'])),
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	if(filter_var($cardUpd['login'],FILTER_VALIDATE_EMAIL))
	{
		
	if(strlen($cardUpd['name']) > 2)
	{
	
	$query = "SELECT id FROM [pre]users WHERE `login`='".$cardUpd['login']."' LIMIT 1";
	$findUser = $ah->rs($query);
	
	if(!$findUser)
	{
	
	$pass = ($password!="" ? $password : substr(md5(time()+rand(1000,9999),8)));
	
	$cardUpd['pass'] = md5($pass);
	
	// File upload 
	
	$filename = "avatar";
	
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
	{
		$file_path = "../../../../webroot/img/split/files/users/";
		
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"it_",
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
	
	// Update user extra fields
	
	$ef = $_POST['ef'];
	
	foreach($ef as $ef_id => $ef_value)
	{
		$query = "INSERT INTO [pre]user_ef_ref (`user_id`,`ef_id`,`value`) VALUES ('$item_id','$ef_id','$ef_value')";
		$ah->rs($query);
	}
	
	
	$letter = ($cardUpd['male'] == 'M' ? "Уважаемый" : "Уважаемая");
	
	$letter .= " ".$cardUpd['name']." ".$cardUpd['fname']."! <br> Ваш аккаунт на сайте itfurline.com успешно зарегистрирован! <br><hr><br>";
	
	$letter .= "<h4>Данные для входа авторизации:</h4>";
	
	$letter.= "<b>Login</b>: ".$cardUpd['login'];
	$letter.= "<br><b>Password</b>: ".$pass;
	
	$ah->wp_send_letter($cardUpd['login'],"support@itfurline.com","Успешная авторизация",$letter,'ItFurLine STORE');
	
	$data['status'] = "success";
	$data['message'] = "Success user save";
	
	
	
			}else
			{
				$data['status'] = "failed";
				$data['message'] = "Пользователь с таким логином уже существует.";
			}
		}else
		{
			$data['status'] = "failed";
			$data['message'] = "Пожалуйста, укажите Имя пользователя";
		}
	
	}else
	{
		$data['status'] = "failed";
		$data['message'] = "Не корректный Email";
	}
	