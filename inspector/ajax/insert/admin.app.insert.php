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
<title>Table INSERT ADMIN APP</title>
</head>

<?php
	// echo '<pre>'; print_r($_POST); echo '</pre>'; 
	$table		= "[pre]admin_applications";
	$name	 	= $_POST['name'];
	$details	= $_POST['details'];
	$menu_id	= $_POST['menu_id'];
	
	$dateCreate	= date("Y-m-d H:i:s",time());
	$dateModify	= date("Y-m-d H:i:s",time());
	
	$insert_admin_app_query = "INSERT INTO ".$table." (`id`,`alias`,`name`,`details`,`dateCreate`,`dateModify`,`block`) VALUES 
	(NULL,'0','".$name."','".$details."','".$dateCreate."','".$dateModify."','0');";
?>
<body>
	<?php
		echo $insert_admin_app_query;
    	$insert_admin_app_stmt = $dbh->prepare($insert_admin_app_query);
		$insert_admin_app_stmt->execute();
		
		$last_app_query = "SELECT id FROM [pre]admin_applications WHERE 1 ORDER BY id DESC LIMIT 1";
		
		$last_app_stmt = $dbh->prepare($last_app_query);
		$last_app_result = $last_app_stmt->execute();
		
		$last_app = $last_app_result->fetchallAssoc();
		
		$last_app_id = $last_app[0]['id'];
		
		require_once("../../controller.php");
		$controller = new Controller();
		
		
		mkdir("../../../myprotected/split/applications/app-".$last_app_id,0777);
		$controller->mtvc_Read_and_Copy_data_from_dir("../../../myprotected/split/applications/app-N/","../../../myprotected/split/applications/app-".$last_app_id."/");
	
		if($menu_id > 0)
		{
			$ref_query = "INSERT INTO [pre]admin_menu_app_ref (`menu_id`,`app_id`) VALUES ('".$menu_id."','".$last_app_id."')";
			
			$ref_stmt = $dbh->prepare($ref_query);
			$ref_stmt->execute();
		}
	?>
</body>
</html>