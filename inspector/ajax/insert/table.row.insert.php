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
	$table	= $_POST['table'];
	$field	= $_POST['field'];
	
	$set_str = "";
	
	$cnt = 0;
	foreach($field as $name => $value)
	{
		$name = str_replace("'","",$name);
		$cnt++;
		if($cnt == 1)
		{
			$set_str .= "`".$name."`='".trim(str_replace("'","\'",$value))."'";
		}else
		{
			$set_str .= ", `".$name."`='".trim(str_replace("'","\'",$value))."'";
		}
	}
	
	$insert_row_query = "INSERT INTO ".$table." SET ".$set_str;
?>
<body>
	<?php
		echo $insert_row_query;
		
    	$insert_row_stmt = $dbh->prepare($insert_row_query);
		$insert_row_stmt->execute();
	?>
</body>
</html>