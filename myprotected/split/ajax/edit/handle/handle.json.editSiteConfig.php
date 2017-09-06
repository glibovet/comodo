<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'sitename'		=> $_POST['sitename'],
					'support_email'	=> $_POST['support_email'],
					'phone_number'	=> $_POST['phone_number'],					
					'fb_url'	=> $_POST['fb_url'],
					'vk_url'	=> $_POST['vk_url'],
					'gp_url'	=> $_POST['gp_url'],
					'yt_url'	=> $_POST['yt_url'],
					'in_url'	=> $_POST['in_url'],
					'blog_qnt'	=> $_POST['blog_qnt'],					
					'active'		=> $_POST['active'][0],
					'index'			=> $_POST['index'][0],
					'meta_title'	=> $_POST['meta_title'],
					'meta_keys'		=> $_POST['meta_keys'],
					'meta_desc'		=> $_POST['meta_desc'],
					'ua_meta_title'	=> $_POST['ua_meta_title'],
					'ua_meta_keys'	=> $_POST['ua_meta_keys'],
					'ua_meta_desc'	=> $_POST['ua_meta_desc'],
					'en_meta_title'	=> $_POST['en_meta_title'],
					'en_meta_keys'	=> $_POST['en_meta_keys'],
					'en_meta_desc'	=> $_POST['en_meta_desc'],
					'copyright'		=> $_POST['copyright'],
					'shop_adress'		=> $_POST['shop_adress'],
					'ua_shop_adress'	=> $_POST['ua_shop_adress'],
					'en_shop_adress'	=> $_POST['en_shop_adress'],					
					'map_frame'		=> $_POST['map_frame'],
					
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
		
	$data['query'] = $query;
		
	$ah->rs($query);
	
	
	
	$data['message'] = "Настройки успешно вступили в силу";
	