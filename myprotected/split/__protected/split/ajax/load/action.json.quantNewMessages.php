<?php // ajax json action
	require_once "../../../require.base.php";
	require_once "../../adminHelper.class.php";
	
	$data = array('status'=>"error",'message'=>"Tech error");
	
	$ah = new adminHelper();

	$quant = 0;
	
	$query = "SELECT COUNT(*) FROM [pre]shop_orders WHERE `status`= :1 AND `paid_status` = :2 ORDER BY id LIMIT 1000";
			
	$_stmt = $dbh->prepare($query);
	$_arr = $_stmt->execute('Оформлен','Оплачен');
		
		$_res = $_arr->fetchallAssoc();
		$quant = (int)$_res[0]['COUNT(*)'];
	
	$query = "SELECT COUNT(*) FROM [pre]tasks WHERE `status`= 0 ORDER BY id LIMIT 1000";
			
	$_stmt = $dbh->prepare($query);
	$_arr = $_stmt->execute();
		
		$tasks = $_arr->fetchallAssoc();
		$quant += $tasks[0]['COUNT(*)'];
	
	$query = "SELECT * FROM [pre]users_dialogs WHERE `to_id`='".ADMIN_ID."' AND `status`=0 ORDER BY dateCreate DESC LIMIT 10000";
	
	$_stmt = $dbh->prepare($query);
	$_arr = $_stmt->execute();
	
		$_res = $_arr->fetchallAssoc();
		$dialogs = $_res;
	
	$last_name = "";
	$last_message = "";
	$last_date = "";
	
	
	if(count($_res) > 0)
	{
		$lastM = $_res[0];
		
		$query = "SELECT name,fname FROM [pre]users WHERE `id`='".$lastM['from_id']."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
			$_res = $_arr->fetchallAssoc();
		
		$last_name		= $ah->next_sub_str($_res[0]['name']." ".$_res[0]['fname'],15);
		$last_message	= $ah->next_sub_str($lastM['message'],50);
		$last_date		= $ah->deformat_date($lastM['dateCreate']);
		
		$last_mess = '<li id="mess_loop_'.$lastM['id'].'" title="Прочитать" onclick="document.location.href = mess_path;"><span class="left">'.$last_name.'</span><span class="right">'.$last_date.'</span><br>'.$last_message.'</li>';
	}
	
	$quant += count($dialogs);
	
	$data['status'] = "success";
	
	$data['last_mess']	= $last_mess;
	$data['last_name']	= $last_name;
	$data['last_date']	= $last_date;
	$data['quant']		= $quant;
	
	$data['mess_path'] = "index.php?control=personal&item=29&id=".$lastM['id'];
	
echo json_encode($data);
