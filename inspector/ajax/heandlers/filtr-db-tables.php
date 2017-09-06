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
	$key	= trim($_POST['key']);
	
	$query = "SELECT table_name FROM [pre]tables_info WHERE `table_name`LIKE'%".$key."%' OR `details`LIKE'%".$key."%' LIMIT 1000";
	
	$filtr_stmt = $dbh->prepare($query);
	$filtr_arr = $filtr_stmt->execute();
	
	$filtr = $filtr_arr->fetchallAssoc();
?>
<body>
	<script type="text/javascript" language="javascript">
	<?php
		if(sizeof($filtr) > 0)
		{
			?>
			$('.tables-list-item').hide();
			<?php
			foreach($filtr as $table)
			{
				?>
				
				$('#table-<?php echo $table['table_name'] ?>').show();
				<?php
			}
		}
	?>
	</script>
</body>
</html>