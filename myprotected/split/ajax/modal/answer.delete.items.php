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
		// Get info by item
		
		$query = "SELECT * FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
		
		$data_stmt = $dbh->prepare($query);
		$data_arr = $data_stmt->execute();
		$data = $data_arr->fetchallAssoc();
			
		$info = $data[0];
		
		$is_continue = false;
		
		switch($table)
		{	
			case 'users_types':
			{
				$mQuery = "SELECT id FROM [pre]users WHERE `type`=$item_id LIMIT 1";
				$m_stmt = $dbh->prepare($mQuery);
				$m_arr = $m_stmt->execute();
				$m_data = $m_arr->fetchallAssoc();
				
				if($m_data)
				{
					$is_continue = true;
					?>
						<p>Группа <b><?php echo $info['name'] ?></b> не может быть удалена, поскольку она не пустая.</p>
					<?php
				}
				break;
			}
			default:
			{
				break;
			}
		}
		
		if($is_continue) continue;
		
		if($table == "users_dialogs")
		{
			$delete_query = "DELETE FROM [pre]".$table." WHERE (`from_id`='".$info['from_id']."' AND `to_id`='".$info['to_id']."') OR 
							(`to_id`='".$info['from_id']."' AND `from_id`='".$info['to_id']."') LIMIT 10000";
		}
		elseif($table == "shop_products")
		{
			$delete_chars = "DELETE FROM `osc_shop_chars_prod_ref` WHERE `prod_id`='".$item_id."' ";
			
			$delete_stmt = $dbh->prepare($delete_chars);
			$delete_arr = $delete_stmt->execute();
				
			$delete_query = "DELETE FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
			
			//echo "<pre>"; print_r($delete_chars); echo "</pre>"; 
			//echo "<pre>"; print_r($delete_query); echo "</pre>";  exit();
		}
		else
		{
			$delete_query = "DELETE FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
			//echo "<pre>"; print_r($delete_query); echo "</pre>";  exit();
		}

				$delete_stmt = $dbh->prepare($delete_query);
				$delete_arr = $delete_stmt->execute();
				
		$item_name = "[".$info['id']."]";
		
		if(isset($info['name'])) $item_name .= " ".$info['name'];
		
		?>
		<p>Запись <b><?php echo $item_name ?></b> успешно удалена из системы.</p>
		<?php
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>