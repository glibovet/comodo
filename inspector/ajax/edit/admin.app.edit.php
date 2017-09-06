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
<title>Table INSERT FIELD</title>
</head>

<?php
	$table		= "[pre]admin_applications";
	$id			= $_POST['id'];
	$name		= $_POST['name'];
	$block		= $_POST['block'];
	$details	= $_POST['details'];
	
	$menu_id	= $_POST['menu_id'];
	
	$dateModify	= date("Y-m-d H:i:s",time());
	
	$update_admin_app_row_query = "UPDATE `".$table."` SET `name`='".$name."',`block`='".$block."',`details`='".$details."',`dateModify`='".$dateModify."' WHERE `id`='".$id."'";

	$menu_query = "SELECT * FROM [pre]admin_menu_app_ref WHERE `app_id`='".$id."' LIMIT 1";
?>
<body>
	<?php
		echo $update_admin_app_row_query;
    	$update_admin_app_row_stmt = $dbh->prepare($update_admin_app_row_query);
		$update_admin_app_row_stmt->execute();
		
		if($menu_id > 0)
		{	
			$menu_stmt = $dbh->prepare($menu_query);
			$menu_arr = $menu_stmt->execute();
	
			$ref = $menu_arr->fetchallAssoc();
			
			
			if(sizeof($ref) > 0 && $ref[0]['menu_id'] != $menu_id)
			{
				$del_query = "DELETE FROM [pre]admin_menu_app_ref WHERE `app_id`='".$id."'";
				
				$del_stmt = $dbh->prepare($del_query);
				$del_stmt->execute();
			}
				$ref_query = "INSERT INTO [pre]admin_menu_app_ref (`menu_id`,`app_id`) VALUES ('".$menu_id."','".$id."')";
				
				$ref_stmt = $dbh->prepare($ref_query);
				$ref_stmt->execute();
		}else
		{
			$del_query = "DELETE FROM [pre]admin_menu_app_ref WHERE `app_id`='".$id."'";
				
				$del_stmt = $dbh->prepare($del_query);
				$del_stmt->execute();
		}
	?>
</body>
</html>