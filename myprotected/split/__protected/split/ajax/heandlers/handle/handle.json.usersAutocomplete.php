<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	/*
	require_once "../../../../require.base.php";
	
	require_once "../../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$query = trim($_GET['query']);

	$data = array(
				"query"=>$query,
				"suggestions"=>array()
				);
				
	$mass = explode(" ",$query);
	
	$q1 = $mass[0];
	$q2 = (isset($mass[1]) ? $mass[1] : "");
	
	$DBquery = "SELECT if,name,fname FROM [pre]users WHERE (`name`LIKE'%$q1%' AND `fname`LIKE'%$q2%') OR (`name`LIKE'%$q2%' AND `fname`LIKE'%$q1%') OR `id`='$query' LIMIT 100";
	$resultMass = $ah->rs($DBquery);
	
	if($resultMass)
	{
		foreach($resultMass as $item)
		{
			array_push($data['suggestions'],array('value'=>$item['name']." ".$item['fname'],'data'=>$item['id']));
		}
	}
	
	echo json_encode($data);
	*/
	
	$query = $_POST['term'];

	$data = array(
				"query"=>$query,
				"suggestions"=>array(
									array("value"=>"Ukraine Bavariya","data"=>51),
									array("value"=>"Italy","data"=>53)
									)
				);
	//$data = array("Ukraine","France");
	echo json_encode($data);
	
	