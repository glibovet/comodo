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
	$name	= trim($_POST['name']);
	$alias	= trim($_POST['alias']);
	$details	= trim($_POST['details']);
?>
<body>
	<?php
	echo '<pre>'; print_r($_POST); echo '</pre>';
	
	$query = "INSERT INTO [pre]applications (`name`,`alias`,`details`) VALUES ('".$name."','".$alias."','".$details."')";
	
	$_stmt = $dbh->prepare($query);
	$_stmt->execute();
	
	echo 'Successfull.';
	?>
</body>
</html>