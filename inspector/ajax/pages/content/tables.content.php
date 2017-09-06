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
<title>Tables CONTENT</title>
</head>

<body>
	<fieldset>
    	<legend>Создать новую таблицу:</legend>
        <form name="create-table-form" action="ajax/heandlers/table.create.php" method="POST" target="_blank">
        	<input type="text" class="ifield" name="table" placeholder="next_table" value="" id="new_table_name">
            <button type="submit" class="mtvc-button add-button">Создать таблицу</button>
        </form>
    </fieldset>
</body>
<script type="text/javascript" language="javascript">
	$(function(){
			$('form[name=create-table-form]').ajaxForm(function(){
					var table = $('#new_table_name').val();
					load_sub_menu('table',table);
				});
		});
</script>
</html>