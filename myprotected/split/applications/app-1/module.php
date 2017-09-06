<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file
	
	function deformat_date($val)
		{
			$result = "";
			$monthes = array('','янв.','фев.','мар.','апр.','мая','июня','июля','авг.','сен.','окт.','нбр.','дек.');
			
			if(strtotime($val) > strtotime(date("d.m.Y",time())." 00:00:00"))
								{
									$result = "Сегодня, ".date("H:i",strtotime($val));
		
								}elseif(strtotime($val) < strtotime(date("d.m.Y",time())." 00:00:00") &&
										strtotime($data[$item_num]['dateCreate']) > (strtotime(date("d.m.Y",time())." 00:00:00")-86400))
									{
										$result = "Вчера, ".date("H:i",strtotime($val));
									}
								else
									{
										$result = date("d",strtotime($val))." ".$monthes[(int)date("m",strtotime($val))]." ".
																	", ".
																	date("H:i",strtotime($val));
									}
			return $result;
		}
	
	function next_sub_str($str,$len)
	{
		return implode(array_slice(explode('<br>',wordwrap($str,$len,'<br>',false)),0,1));
	}
	
	$user_query = "SELECT * FROM [pre]users WHERE `id`= :1 AND `block`= :2";
			
	$user_stmt = $dbh->prepare($user_query);
	$user_arr = $user_stmt->execute(ADMIN_ID,0);
		
	$user = $user_arr->fetchallAssoc();
	
	$paid_orders_query = "SELECT * FROM [pre]shop_orders WHERE `status`= :1 AND `paid_status` = :2 ORDER BY id LIMIT 1000";
			
		$paid_orders_stmt = $dbh->prepare($paid_orders_query);
		$paid_orders_arr = $paid_orders_stmt->execute('Оформлен','Оплачен');
		
	$paid_orders = $paid_orders_arr->fetchallAssoc();
	
	foreach($paid_orders as $paid_id => $paid)
	{
		$paid_orders[$paid_id]['date_paid'] = deformat_date($paid['dateCreate']);
	}
	
	$query = "SELECT * FROM [pre]users_dialogs WHERE `to_id`='".ADMIN_ID."' AND `status`=0 LIMIT 10000";
	
	$_stmt = $dbh->prepare($query);
	$_arr = $_stmt->execute();
	
	$messages = $_arr->fetchallAssoc();
	
	$query = "SELECT * FROM [pre]tasks WHERE `status`= 0 ORDER BY id LIMIT 1000";
			
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
	$tasks = $_arr->fetchallAssoc();
	
	$user[0]['mess_quant'] = sizeof($paid_orders) + sizeof($messages) + sizeof($tasks); // Количество новых сообщений
	
	foreach($messages as $m_id => $mess)
	{
		$query = "SELECT name,fname FROM [pre]users WHERE `id`='".$mess['from_id']."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
		$_res = $_arr->fetchallAssoc();
		
		$messages[$m_id]['friend_name'] = next_sub_str($_res[0]['name']." ".$_res[0]['fname'],15);
		$messages[$m_id]['sub_mess'] = next_sub_str($mess['message'],50);
		$messages[$m_id]['date_mess'] = deformat_date($mess['dateCreate']);
	}
	
	//******************************************************************************************************
	
	$parents_query = "SELECT * FROM [pre]admin_menu WHERE `type`= :1 AND `parent`= :2 AND `block`= :3 ORDER BY order_id";
			
	$parents_stmt = $dbh->prepare($parents_query);
	$parents_arr = $parents_stmt->execute(1,0,0);
		
	$parents = $parents_arr->fetchallAssoc();
	
	$data = array();
	
	foreach($parents as $parent)
	{
		$childs_query = "SELECT * FROM [pre]admin_menu WHERE `parent`= :1 AND `block`= :2 ORDER BY order_id";
			
		$childs_stmt = $dbh->prepare($childs_query);
		$childs_arr = $childs_stmt->execute($parent['id'],0);
		
		$childs = $childs_arr->fetchallAssoc();
		
		foreach($childs as $child_h => $child_v)
		{
			$query = "SELECT * FROM [pre]user_type_access WHERE `access` = 1 AND `menu_id` = '".$childs[$child_h]['id']."' AND `type_id` = '".$user[0]['type']."' LIMIT 1";
			
			$_stmt = $dbh->prepare($query);
			$_arr = $_stmt->execute();
		
			$_res = $_arr->fetchallAssoc();
			
			if(sizeof($_res) == 0)
			{
				unset($childs[$child_h]);
				continue;
			}
			
			$childs[$child_h]['class'] = "";
			if(isset($_GET['item']))
			{
				if($child_v['id'] == $_GET['item'])
				{
					$childs[$child_h]['class'] = "active";
				}
			}
		}
		
		$parent['class'] = "l-z-left-menu-materials";
		$parent['classto'] = "";
		$parent['link'] = "javascript:void(0);";
		$parent['active'] = "";
		if(!isset($_GET['control']) && $parent['alias'] == 'personal')
		{
			$parent['active'] = " active";
			$parent['classto'] = " lzrm-item";
		}elseif(isset($_GET['control']) && $_GET['control'] == $parent['alias'])
		{
			$parent['active'] = " active";
			$parent['classto'] = " lzrm-item";
		}
		
		switch($parent['alias'])
		{
			case 'personal'	: $parent['class'] = "l-z-left-menu-user"; break;
			case 'users'	: $parent['class'] = "l-z-left-menu-all_users"; break;
			case 'shop'		: $parent['class'] = "l-z-left-menu-shop"; break;
			case 'settings'	: $parent['class'] = "l-z-left-menu-settings"; break;
			case 'help'		: $parent['class'] = "l-z-left-menu-help"; break;
			default: break;
		}
		
		$parent['childs'] = $childs;
		
		array_push($data,$parent);
	}
	
	$paid_order_card_path = "split/applications/app-6/ajax/card.load.php";
	
	$smarty->assign("data",$data);
	$smarty->assign("user",$user[0]);
	$smarty->assign("paid_orders_card_path",$paid_order_card_path);
	$smarty->assign("paid_orders",$paid_orders);
	$smarty->assign("quant_paid_orders",sizeof($paid_orders)+sizeof($tasks));
	$smarty->assign("messages",$messages);
	$smarty->assign("quant_messages",sizeof($messages));
	$smarty->display("view.tpl"); // выводим обработанный