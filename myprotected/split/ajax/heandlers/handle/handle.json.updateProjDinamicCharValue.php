<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "project_chars_ref";
	
	$refId = (int)$_POST['refId'];
	$char_id = (int)$_POST['charId'];
	$defVal = strip_tags(trim($_POST['defVal']));
	
	
	
	$data['status']="failed";
	$data['message']="Unknown reference Char ID";
	
	$sem = false;
	
	if($refId)
	{
		$field_to_update = strip_tags($_POST['field']);
		
		if($defVal)
		{
			switch($field_to_update)
			{
				case 'value':
				{
					$value = strip_tags(trim($_POST['value']));
					
					$findValQuery = "SELECT id FROM [pre]project_chars_values WHERE `char_id`='$char_id' AND `value`='$value' LIMIT 1";
					$findVal = $ah->rs($findValQuery);
					
					if($findVal)
					{
						$charValId = $findVal[0]['id'];
					}else
					{
						$query = "INSERT INTO [pre]project_chars_values (`char_id`,`value`) 
																VALUES('$char_id','$value')";
						$ah->rs($query);
						$charValId = mysql_insert_id();
					}
					
					$query = "UPDATE [pre]$appTable SET `val_id`='$charValId'  WHERE `id`=$refId LIMIT 1";
					$ah->rs($query);
					
					$sem = true;
					break;
				}
				case 'ua_value':
				{
					$ua_value = strip_tags(trim($_POST['value']));
					
					$findValQuery = "SELECT id FROM [pre]project_chars_values WHERE `char_id`='$char_id' AND `value`='$defVal' LIMIT 1";
					$findVal = $ah->rs($findValQuery);
					
					if($findVal)
					{
						$charValId = $findVal[0]['id'];
					
						$query = "UPDATE [pre]project_chars_values SET `ua_value`='$ua_value' WHERE `id`='$charValId' LIMIT 1";
						$ah->rs($query);
					}else
					{
						$query = "INSERT INTO [pre]project_chars_values (`char_id`,`value`,`ua_value`) 
																VALUES('$char_id','$defVal','$ua_value')";
						$ah->rs($query);
						$charValId = mysql_insert_id();
					}
					
					$query = "UPDATE [pre]$appTable SET `val_id`='$charValId'  WHERE `id`=$refId LIMIT 1";
					$ah->rs($query);
					
					$sem = true;
					break;
				}
				case 'en_value':
				{
					$en_value = strip_tags(trim($_POST['value']));
					
					$findValQuery = "SELECT id FROM [pre]project_chars_values WHERE `char_id`='$char_id' AND `value`='$defVal' LIMIT 1";
					$findVal = $ah->rs($findValQuery);
					
					if($findVal)
					{
						$charValId = $findVal[0]['id'];
					
						$query = "UPDATE [pre]project_chars_values SET `en_value`='$en_value' WHERE `id`='$charValId' LIMIT 1";
						$ah->rs($query);
					}else
					{
						$query = "INSERT INTO [pre]project_chars_values (`char_id`,`value`,`en_value`) 
																VALUES('$char_id','$defVal','$en_value')";
						$ah->rs($query);
						$charValId = mysql_insert_id();
					}
					
					$query = "UPDATE [pre]$appTable SET `val_id`='$charValId'  WHERE `id`=$refId LIMIT 1";
					$ah->rs($query);
					
					$sem = true;
					break;
				}
				case 'price_dif':
				{
					$price_dif = (float)$_POST['value'];
					
					$query = "UPDATE [pre]$appTable SET `price_dif`='$price_dif' WHERE `id`=$refId LIMIT 1";
					$ah->rs($query);
			
					$sem = true;
					break;
				}
				default:break;
			}
		}
		if($sem)
		{
			$data['status']="success";
			$data['message']="Success";
		}
	}
	