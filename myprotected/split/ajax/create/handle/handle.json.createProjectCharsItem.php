<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$cardUpd = array(
					'name'			=> $_POST['name'],
					'ua_name'		=> $_POST['name'],
					'en_name'		=> $_POST['name'],
					'alias'			=> $_POST['alias'],
					'block'			=> $_POST['block'][0],
					'show_site'		=> $_POST['show_site'][0],
					'show_admin'	=> $_POST['show_admin'][0],
					'is_dinamic'	=> $_POST['is_dinamic'][0],
					
					'dateCreate'	=> date("Y-m-d H:i:s", time()),
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);
					
	$may_do_it = true;

	$is_dinamic = $cardUpd['is_dinamic'];

	/*
	if($is_dinamic)
	{
		$query = "SELECT id FROM [pre]shop_chars WHERE `group_id`=$group_id AND `is_dinamic`=1 LIMIT 1";
		$dinamic_isset = $ah->rs($query);

		if($dinamic_isset) $may_do_it = false;
	}
	*/

if($may_do_it) {

	// Create main table item

	$query = "INSERT INTO [pre]$appTable ";

	$fieldsStr = " ( ";

	$valuesStr = " ( ";

	$cntUpd = 0;
	foreach ($cardUpd as $field => $itemUpd) {
		$cntUpd++;

		$fieldsStr .= ($cntUpd == 1 ? "`$field`" : ", `$field`");

		$valuesStr .= ($cntUpd == 1 ? "'$itemUpd'" : ", '$itemUpd'");
	}

	$fieldsStr .= " ) ";

	$valuesStr .= " ) ";

	$query .= $fieldsStr . " VALUES " . $valuesStr;

	$data['block'] = $cardUpd['block'];

	$data['query'] = $query;

	$ah->rs($query);

	$item_id = mysql_insert_id();


	$data['item_id'] = $item_id;

	$data['status'] = "success";
	$data['message'] = "Новое свойство успешно добавлено!";

}else{
	$data['status'] = "failed";
	$data['message'] = "Динамичное свойство в данной группе уже существует!";
}
	