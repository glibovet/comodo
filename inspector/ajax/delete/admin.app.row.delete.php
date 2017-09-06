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
<title>DELETE ADMIN APPLICATION</title>
</head>

<?php
	$table	= "[pre]admin_applications";
	$id		= $_POST['id'];
	
	$delete_row_query = "DELETE FROM `".$table."` WHERE `id`='".$id."' LIMIT 1";
	$delete_ref_query = "DELETE FROM [pre]admin_menu_app_ref WHERE `app_id`='".$id."' LIMIT 100";
?>
<body>
	<?php
		echo $delete_row_query;
    	$delete_row_stmt = $dbh->prepare($delete_row_query);
		$delete_row_stmt->execute();
		
		$delete_ref_stmt = $dbh->prepare($delete_ref_query);
		$delete_ref_stmt->execute();
		
		require_once("../../controller.php");
		$controller = new Controller();
		
		$controller->mtvc_RemoveDir("../../../wpmanager/split/applications/app-".$id);
		
		//mkdir("../../../wpmanager/split/applications/app-S",0777);
		//$controller->mtvc_Read_and_Copy_data_from_dir("../../../wpmanager/split/applications/app-N/","../../../wpmanager/split/applications/app-S/");
	?>
</body>
</html>