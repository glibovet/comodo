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
<title>Action DISACTIVATE ITEMS</title>
</head>

<?php
	$items = $_POST['items'];
	$table = $_POST['table'];
?>

<body>
<button class="close-modal" onclick="close_modal();">Закрыть окно</button>
    <div class="modalW" id="modalW-1">
<?php 
	if(sizeof($items) == 0){ echo "Ни одна запись не найдена."; }
	
	foreach($items as $item_id)
	{
		$query = "SELECT * FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";

		$data_stmt = $dbh->prepare($query);
		$data_arr = $data_stmt->execute();
		$data = $data_arr->fetchallAssoc();
		
		$update_query = "UPDATE [pre]".$table." SET `block`=1 WHERE `id`='".$item_id."' LIMIT 1";

		$update_stmt = $dbh->prepare($update_query);
		$update_arr = $update_stmt->execute();
		
		$item_name = "[".$data[0]['id']."]";
		
		if($data[0]['name'] != null) $item_name .= " ".$data[0]['name'];
		
		?>
		<p>Запись <b><?php echo $item_name ?></b> заблокирована.</p>
		<?php
	}
?>
	</div>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>