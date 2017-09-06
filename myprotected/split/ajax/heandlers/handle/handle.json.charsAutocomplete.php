<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	require_once "../../../../require.base.php";
	
	require_once "../../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$query = trim($_POST['term']);

	$data = array(
				"query"=>$query,
				"suggestions"=>array()
				);
	
	
	if($query!="")
	{ 
	
		$mass = explode(" ",$query);
	
		$q1 = $mass[0];
		$q2 = (isset($mass[1]) ? $mass[1] : "");
	
		$DBquery = "SELECT M.* FROM [pre]shop_chars_values as M WHERE `value`LIKE'%$q1%' LIMIT 100";
		
		$resultMass = $ah->rs($DBquery);
		
		if($resultMass)
		{
			$data['suggestions'] = $resultMass;
			/*
			foreach($resultMass as $item)
			{
				array_push($data['suggestions'],array('id'=>$item['id'],'char_id'=>$item['char_id'],
														'name'	=> $item['name'],
														'fname'	=> $item['fname'],
														'login'	=> $item['login'],
														'phone'	=> $item['phone'],
														'delivery_address' => $item['delivery_address'] 
														));
			}
			*/
		}
	} // end if $query != ""
	
	echo json_encode($data);	