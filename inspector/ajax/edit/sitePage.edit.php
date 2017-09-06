<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	require_once "../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sitePage CREATE</title>
</head>

<?php
	$name		= strip_tags(trim($_POST['name']));
	$alias		= strip_tags(trim($_POST['alias']));
	$details	= trim($_POST['details']);
	$sort		= $_POST['sort'];
	$divs		= $_POST['divs'];
	$ags		= $_POST['ags'];
	$blocks		= $_POST['blocks'];
	$block		= (int)$_POST['block'];
	
	$id		= (int)$_POST['id'];
	
	
	/*
	$test = $divs[0];
	$ex = explode("\n",$test);
	echo '<pre>'; print_r($ex); echo '</pre>'; die();
	*/
	
	echo '<pre>'; print_r($_POST); echo '</pre>'; // die();
	
	$details 	= str_replace("'","\'",$details);
	
	$data = array();
	foreach($ags as $i => $ag_id)
	{
		array_push($data,array('ag_id'=>$ag_id,'divs'=>$divs[$i],'block'=>$blocks[$i],'sort'=>$sort[$i]));
	}
	
	$mt = date("Y-m-d H:i:s",time());
?>
<body>
	<?php
	echo '<pre>'; print_r($data); echo '</pre>';
	
	$data 		= serialize($data);
	$data 		= str_replace("'","\'",$data);
	
	$query = "UPDATE [pre]page_types SET `name`='".$name."',`alias`='".$alias."',`details`='".$details."',`block`='".$block."',`data`='".$data."',`dateModify`='".$mt."' WHERE `id`='".$id."'";
	
	$_stmt = $dbh->prepare($query);
	$_stmt->execute();
	
	echo 'Successfull.';
	?>
</body>
</html>