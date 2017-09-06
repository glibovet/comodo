<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'question'		=> $_POST['question'],
					'ua_question'	=> $_POST['ua_question'],
					'en_question'	=> $_POST['en_question'],
					
					'answer'		=> $_POST['answer'],
					'ua_answer'		=> $_POST['ua_answer'],
					'en_answer'		=> $_POST['en_answer'],
					
					'block'			=> $_POST['block'][0],
					'order_id'		=> $_POST['order_id'],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
						
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
	
	$data['message'] = "FAQ #$item_id успешно сохранен.";
	