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
<title>Addplication EDIT</title>
</head>

<?php
	$id			= $_POST['id'];
	$name		= $_POST['name'];
	$alias		= $_POST['alias'];
	$block		= $_POST['block'];
	$details	= $_POST['details'];
	
	$dateModify	= date("Y-m-d H:i:s",time());
	
	$query = "UPDATE [pre]applications SET `name`='".$name."',`alias`='".$alias."' ,`block`='".$block."',`details`='".$details."',`dateModify`='".$dateModify."' WHERE `id`='".$id."'";

	$_stmt = $dbh->prepare($query);
	$_stmt->execute();
?>
<body>
	<?php
	?>
</body>
</html>