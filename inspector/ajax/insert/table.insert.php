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
	$table		 	= $_POST['table'];
	$fieldname	 	= $_POST['fieldname'];
	$fieldafter	 	= $_POST['fieldafter'];
	$fieldtype	 	= $_POST['fieldtype'];
	$fieldsize	 	= $_POST['fieldsize'];
	$fielddefault	= $_POST['fielddefault'];
	$fieldindex		= $_POST['fieldindex'];
	
	if($fieldindex == '0') $fieldindex = "";
	
	if($fieldindex == 1){ $fieldindex =  "AUTO_INCREMENT PRIMARY KEY"; $fielddefault = "";}
	else{ 
		if($fieldtype != 'INT' && $fieldtype != 'FLOAT' && $fieldtype != 'DATETIME')
		{
			echo '<p>Filed Type = '.$fieldtype.'</p>';
			$fieldindex = "CHARACTER SET utf8 COLLATE utf8_general_ci";
		}
		//if($fielddefault == 'VARCHAR')$fieldindex = "CHARACTER SET utf8 COLLATE utf8_general_ci"; 
		if($fieldtype != 'TEXT' && $fieldtype != 'DATETIME'){ $fielddefault = "DEFAULT  '".$fielddefault."'"; } else { $fielddefault = ""; }
		}
	
	if($fieldsize > 0){ $fieldtype = $fieldtype."( ".$fieldsize." )"; }
	
	$insert_field_query = "ALTER TABLE  `".$table."` ADD  `".$fieldname."` ".$fieldtype." ".$fieldindex." NOT NULL ".$fielddefault." AFTER `".$fieldafter."`";
?>
<body>
	<?php
		echo $insert_field_query;
    	$insert_field_stmt = $dbh->prepare($insert_field_query);
		$insert_field_stmt->execute();
                	
		$insert_field_result = new DB_Result($insert_field_stmt);
	?>
</body>
</html>