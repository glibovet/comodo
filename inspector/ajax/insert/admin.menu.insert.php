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
	//echo '<pre>'; print_r($_POST); echo '</pre>';
	$table		= "[pre]admin_menu";
	$type		= 1;
	$name	 	= $_POST['name'];
	$alias	 	= $_POST['alias'];
	$parent	 	= $_POST['parent'];
	$order_id	= $_POST['order_id'];
	$details	= $_POST['details'];
	$dateCreate	= date("Y-m-d H:i:s",time());
	$dateModify	= date("Y-m-d H:i:s",time());
	
	$insert_admin_menu_query = "INSERT INTO ".$table." (`id`,`type`,`parent`,`assign`,`name`,`alias`,`filename`,`order_id`,`details`,`block`,`link`,`dateCreate`,`dateModify`,`adminMod`) VALUES 
	(NULL,'".$type."','".$parent."','0','".$name."','".$alias."','0','".$order_id."','".$details."','0','#','".$dateCreate."','".$dateModify."','1');";
?>
<body>
	<?php
		echo $insert_admin_menu_query;
    	$insert_admin_menu_stmt = $dbh->prepare($insert_admin_menu_query);
		$insert_admin_menu_stmt->execute();
	?>
</body>
</html>