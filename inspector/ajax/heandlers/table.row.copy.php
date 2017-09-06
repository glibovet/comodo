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
	$table	= $_POST['table'];
	$id	= $_POST['id'];
	
	$query = "SELECT * FROM `".$table."` WHERE `id`='".$id."' LIMIT 1";
?>
<body>
	<?php
		//echo $query;
		
    	$copy_row_stmt = $dbh->prepare($query);
		$copy_row_stmt->execute();
		
		$copy_row = $copy_row_stmt->fetchallAssoc();
		
		
		// Определяем структуру таблицы
		
		$table_query = "SHOW COLUMNS FROM ".$table;
		$table_stmt = $dbh->prepare($table_query);
		$table_stmt->execute();
                	
		$table_result = new DB_Result($table_stmt);
		
		$table_fields = array();
	
		while($table_result->Next())
		{
			array_push($table_fields,array(
										'Field'		=>$table_result->Field,
										'Type'		=>$table_result->Type,
										'Null'		=>$table_result->Null,
										'Key'		=>$table_result->Key,
										'Default'	=>$table_result->Default,
										'Extra'		=>$table_result->Extra
										));
		}
		
		// Струвкрута таблицы орпеделена
		
		
		$insert_query = "INSERT INTO `".$table."` (";
		// foreach columns name
		$cnt = 0;
		foreach($table_fields as $cur_field)
		{
			$cnt++;
			if($cnt == 1)
			{
				$insert_query .= "`".$cur_field['Field']."`";
			}else
			{
				$insert_query .= ", `".$cur_field['Field']."`";
			}
		}
		$insert_query .=") VALUES (";
		// foreach columns value
		$cnt = 0;
		foreach($copy_row[0] as $row_name => $row_value)
		{
			$cnt++;
			if($cnt == 1)
			{
				if(strtolower($row_name) == 'id')
				{
					$insert_query .= "'NULL'";
				}else
				{
					$insert_query .= "'".$row_value."'";
				}
			}else
			{
				if(strtolower($row_name) == 'id')
				{
					$insert_query .= ", 'NULL'";
				}else
				{
					$insert_query .= ", '".$row_value."'";
				}
			}
		}
		$insert_query .= ");";
		
		//echo $insert_query;
		
		$insert_row_stmt = $dbh->prepare($insert_query);
		$insert_row_stmt->execute();
	?>
</body>
</html>