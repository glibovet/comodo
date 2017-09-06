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
<title>Tables MENU</title>
</head>

<body>
	<form name="filtr-tables-form" action="#" method="POST">
    	<input type="text" name="table" value="" placeholder="Введите ключ для фильтра" id="filtr-key" onchange="filtr_db_tables($(this).val())" style="width:200px; margin:0px 0px 10px 0px;">
        <button type="button" onclick="filtr_db_tables($('#filtr-key').val());" class="hidden">OK</button>
    </form>
    
	<ul class="left-menu">
                <?php
					$tables_query = "SHOW TABLES";
					$tables_stmt = $dbh->prepare($tables_query);
					$tables_stmt->execute();
                	
					$tables_result_arr = $tables_stmt->fetchallAssoc();
					
					$cnt = 0;
					$row_name = "Tables_in_".$db_name;
					
					foreach($tables_result_arr as $tables_result)
					{
						$cnt++;
						//$table_name = str_replace($dbh->pre,"",$tables_result->$row_name);
						$table_name = $tables_result[$row_name];
						
						$table_details = "Без описания";
						
						$query = "SELECT * FROM [pre]tables_info WHERE `table_name`='".$table_name."' LIMIT 1";
						
						$details_stmt = $dbh->prepare($query);
						$details_arr = $details_stmt->execute();
						
						$details = $details_arr->fetchallAssoc();
						
						if(sizeof($details) > 0) $table_details = $details[0]['details'];
						?>
						<li inspector_rel="<?php echo $table_name ?>" class="tables-list-item" title="<?php echo $table_details ?>" id="table-<?php echo $table_name ?>" 
                        	onclick="load_sub_menu('table','<?php echo $table_name ?>');" >&rsaquo; <?php echo $table_name ?></li>
						<?php
					}
				?>
	</ul>
    <div id="filtr-tables-result"></div>
</body>
<script type="text/javascript" language="javascript">
	$(function(){
			$('form[name=filtr-tables-form]').ajaxForm();
			
			$('#filtr-key').focus();
		});
	function filtr_db_tables(key)
	{
		var data = { key : key }
		$('#filtr-tables-result').load('ajax/heandlers/filtr-db-tables.php',data);
	}
</script>
</html>