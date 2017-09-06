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
<title>Table ROW FIELD NAME RENAME</title>
</head>

<?php
	$table		= $_POST['table'];
	$field		= $_POST['field'];
	$type		= $_POST['type'];
	$new_name	= $_POST['new_name'];
	
	$may_query = true;
	/*
	$test = strpos($type,"INT");
	if($test === false)
	{
		$test = strpos($type,"VARCHAR");
		if($test === false)
		{
			$test = strpos($type,"FLOAT");
			if($test === false)
			{
				$test = strpos($type,"TEXT");
				if($test === false)
				{
					$test = strpos($type,"DATETIME");
					if($test === false)
					{
						$may_query = false;
					}
				}
			}
		}
	}
	*/
	
	$query = "ALTER TABLE `".$table."` CHANGE `".$field."` `".$new_name."` ".$type;
?>
<body>
	<?php
		echo $query;
		if($may_query)
		{
			$update_stmt = $dbh->prepare($query);
			$update_stmt->execute();
		}
	?>
</body>
</html>