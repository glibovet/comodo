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
					'block'			=> $_POST['block'][0],
					'show_site'		=> $_POST['show_site'][0],
					'show_admin'	=> $_POST['show_admin'][0],
					'is_dinamic'	=> $_POST['is_dinamic'][0],
					
					'dateModify'	=> date("Y-m-d H:i:s", time())
					);

$may_do_it = true;

$is_dinamic = $cardUpd['is_dinamic'];

/*
if($is_dinamic)
{
	$query = "SELECT id FROM [pre]shop_chars WHERE `group_id`=$group_id AND `is_dinamic`=1 AND `id`!=$item_id LIMIT 1";
	$dinamic_isset = $ah->rs($query);

	if($dinamic_isset) $may_do_it = false;
}
*/

if($may_do_it) {

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
	
	
	
	$data['message'] = "Успешное сохранение. ".$lang_prefix;

}else{
	$data['status'] = "failed";
	$data['message'] = "Динамичное свойство в данной группе уже существует!";
}
