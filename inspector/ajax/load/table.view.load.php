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
<title>Tables MENU</title>
</head>

<?php
	$table = $_GET['name'];
	
	$on_page = 10;
	$start_page = 1;
	$pages = 1;
	
	
	$table_query = "SELECT COUNT(*) FROM ".$table;
	$table_stmt = $dbh->prepare($table_query);
	$table_result = $table_stmt->execute();
	
	$table_rows = $table_result->fetchallAssoc();
	
	$pages = ceil($table_rows[0]['COUNT(*)']/$on_page);
	
	if(isset($_POST['start_page']))
	{
		$start_page = $_POST['start_page'];
	}
	
	$table_query = "SELECT * FROM ".$table." WHERE 1 LIMIT ".($start_page-1)*$on_page.",".$on_page;
	$table_stmt = $dbh->prepare($table_query);
	$table_result = $table_stmt->execute();
	
	$table_rows = $table_result->fetchallAssoc();
?>

<body>
	<?php
    	if(sizeof($table_rows) > 0)
		{
	?>
                <table class="bordered">
                	<tr>
                    	<th>Копирование</th>
						<?php
                        	foreach($table_rows[0] as $fieldname => $value)
							{
								?>
								<th><?php echo $fieldname ?></th>
								<?php
							}
						?>
                        <th>Удаление</th>
                    </tr>
				<?php
					$cnt = 0;
					//$row_name = "Tables_in_".$db_name;
					foreach($table_rows as $row_name => $table_row)
					{
						?>
						<tr>
                        	<td>
                            <form name="copy_table_row_form" action="ajax/heandlers/table.row.copy.php" method="POST" target="_blank">
                				<input type="hidden" name="table" value="<?php echo $table ?>">
                                <input type="hidden" name="id" value="<?php echo $table_row['id'] ?>">
                               	<button title="Моментальное копирование!" class="green" type="submit" onclick="$('#loadProgress').html(loader);">Копировать</button>
							</form>
                            </td>
							<?php
                            foreach($table_row as $fieldname => $fieldvalue)
							{
								if($fieldname != 'id' && $fieldname != 'content' && $fieldname != 'details' && $fieldname != 'data' && $fieldname != 'text')
								{
								?>
								<td title="<?php echo $fieldname ?>">
									<input	type="text" id="row-<?php echo $fieldname ?>-<?php echo $table_row['id'] ?>" name="<?php echo $fieldname ?>" value="<?php echo $fieldvalue ?>" 
                                    		onchange="update_table_row('<?php echo $table ?>','<?php echo $fieldname ?>',<?php echo $table_row['id'] ?>);" title="<?php echo $fieldvalue ?>">
                                </td>
								<?php
								}elseif($fieldname != 'id')
								{
								?>
								<td title="<?php echo $fieldname ?>">
									<textarea	id="row-<?php echo $fieldname ?>-<?php echo $table_row['id'] ?>" name="<?php echo $fieldname ?>" title="<?php echo $fieldvalue ?>"
                                    			onchange="update_table_row('<?php echo $table ?>','<?php echo $fieldname ?>',<?php echo $table_row['id'] ?>);"><?php echo $fieldvalue ?></textarea>
                                </td>
								<?php
								}else
								{
								?>
								<td title="<?php echo $fieldname ?>"><?php echo $fieldvalue ?></td>
								<?php
								}
							}
							?>
                            <td>
                            	<?php
                                if(isset($table_row['id']))
								{
								?><form name="del_table_row_form" action="ajax/delete/table.row.delete.php" method="POST">
                					<input type="hidden" name="table" value="<?php echo $table ?>">
                                    <input type="hidden" name="id" value="<?php echo $table_row['id'] ?>">
                                	<button title="<?php echo $table_row['id'] ?> | Моментальное удаление!" class="red" type="submit" onclick="$('#loadProgress').html(loader);">Удалить</button>
								</form>
                                <?php
								}else
								{
									echo 'Без ID';
								}
								?>
                            </td>
                        </tr>
						<?php
					}
				?>
                </table>
     <?php
		}else{
			echo '<p>Таблица пуста.</p>';
			}
	 ?>
     <div class="inajax" id="table_row_update_result"></div>
     
     <div class="innavi">
     	<?php
        for($i = 1; $i <= $pages; $i++)
		{
			?>
			<a	href="#" 
            	onclick="reload_table_page('<?php echo $table ?>',<?php echo $i ?>);" 
            	class="<?php if($i == $start_page) echo 'active' ?>" 
                title="Переключить страницу"><?php echo $i ?></a>
			<?php
		}
		?>
     </div>
     
</body>

<script type="text/javascript" language="javascript">
	
	function update_table_row(table,field,id)
	{
		var value = $('#row-'+field+'-'+id).val();
		var data = {
					table:table,
					field:field,
					id:id,
					value:value
					}
		$('#table_row_update_result').load('ajax/edit/table.row.field.edit.php',data);
	}
	
	function reload_table_page(table,page)
	{
		var data = {
					table:table,
					start_page:page
					}
		$('#page_content').html(loader); 
		$('#page_content').load('ajax/load/table.view.load.php?name=<?php echo $table ?>',data);
	}
	
	$(function(){
			$('form[name=del_table_row_form]').ajaxForm(function(){
				load_sub_menu('table','<?php echo $table ?>');
			});
			$('form[name=copy_table_row_form]').ajaxForm(function(){
				$('#page_content').html(loader); 
				$('#page_content').load('ajax/load/table.view.load.php?name=<?php echo $table ?>',function(){
						$('#loadProgress').html('');
					});
			});
		});
</script>

</html>