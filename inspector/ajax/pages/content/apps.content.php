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
<title>Apps CONTENT</title>
</head>

<body>
	<fieldset>
    	<legend>Создать новый Application:</legend>
        <form name="create-app-form" action="ajax/heandlers/app.create.php" method="POST" target="_blank">
        	<input type="text" class="if" name="name" placeholder="application name" value="" id="new_app_name">
            <input type="text" class="if" name="alias" placeholder="application filename.php" value="" id="new_app_alias">
        
        <div class="clear"></div>    
            
		<textarea class="ifa" name="details" placeholder="Описание application" id="app_details"></textarea>
        
        <div class="clear"></div>    
            <button type="submit" class="mtvc-button add-button">Создать</button>
        </form>
    </fieldset>
    <div id="result_create_app"></div>
</body>
<script type="text/javascript" language="javascript">
	$(function(){
			$('form[name=create-app-form]').ajaxForm(function(){
					load_menu('apps');
				});
		});
</script>
</html>