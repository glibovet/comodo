<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Answer DELETE ITEMS</title>
</head>

<?php
	$items = $_POST['items'];
	$table = $_POST['table'];
?>

<body>
<?php 
	if(sizeof($items) == 0){ echo "Ни одна запись для удаления не найдена."; }
	
	foreach($items as $item_id)
	{
		$query = "SELECT * FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";

			$data_stmt = $dbh->prepare($query);
			$data_arr = $data_stmt->execute();
			$data = $data_arr->fetchallAssoc();
			
			$info = $data[0];
		
		if($table == "users_dialogs")
		{
			$delete_query = "DELETE FROM [pre]".$table." WHERE (`from_id`='".$info['from_id']."' AND `to_id`='".$info['to_id']."') OR 
							(`to_id`='".$info['from_id']."' AND `from_id`='".$info['to_id']."') LIMIT 10000";
		}else
		{
			$delete_query = "DELETE FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
		}

				$delete_stmt = $dbh->prepare($delete_query);
				$delete_arr = $delete_stmt->execute();
				
		$item_name = "[".$data[0]['id']."]";
		
		if($data[0]['name'] != null) $item_name .= " ".$data[0]['name'];
		
		?>
		<p>Запись <b><?php echo $item_name ?></b> успешно удалена из системы.</p>
		<?php
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>