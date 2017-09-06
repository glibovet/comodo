<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	// SQL: ALTER TABLE  `a_test` ADD  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY AFTER  `test`
	
	// SQL: ALTER TABLE  `a_test` ADD  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '0'
	
	// SQL: ALTER TABLE  `a_test` ADD  `rtetrt` FLOAT( 10 ) NOT NULL DEFAULT  '5' AFTER  `name`
	
	// SQL: ALTER TABLE `a_test` DROP `test`
	
	require_once "../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Table INSERT FIELD</title>
</head>

<?php
	$table		= "[pre]admin_menu";
	$id			= $_POST['id'];
	$name		= $_POST['name'];
	$alias		= $_POST['alias'];
	$parent		= $_POST['parent'];
	$order_id	= $_POST['order_id'];
	$block		= $_POST['block'];
	$details	= $_POST['details'];
	$dateModify	= date("Y-m-d H:i:s",time());
	
	$update_admin_menu_row_query = "UPDATE `".$table."` SET `name`='".$name."',`alias`='".$alias."',`parent`='".$parent."',`order_id`='".$order_id."',`block`='".$block."',`details`='".$details."',`dateModify`='".$dateModify."' WHERE `id`='".$id."'";
?>
<body>
	<?php
		echo $update_admin_menu_row_query;
    	$update_admin_menu_row_stmt = $dbh->prepare($update_admin_menu_row_query);
		$update_admin_menu_row_stmt->execute();
	?>
</body>
</html>