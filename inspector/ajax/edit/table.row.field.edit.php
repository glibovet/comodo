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
<title>Table ROW FIELD VALUE UPDATE</title>
</head>

<?php
	$table		= $_POST['table'];
	$field		= $_POST['field'];
	$id			= $_POST['id'];
	$value		= trim(str_replace("'","\'",$_POST['value']));
	
	$query = "UPDATE `".$table."` SET `".$field."`='".$value."' WHERE `id`='".$id."'";
?>
<body>
	<?php
		echo $query;
    	$update_stmt = $dbh->prepare($query);
		$update_stmt->execute();
	?>
</body>
</html>