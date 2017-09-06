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
<title>Page Types CONTENT</title>
</head>

<body>
	<fieldset>
    	<legend>Создать новую страницу:</legend>
        <form name="create-page-form" action="ajax/heandlers/sitePage.create.php" method="POST" target="_blank">
        	<input type="text" class="if" name="name" placeholder="site page name" value="" id="new_page_name">
            <input type="text" class="if" name="alias" placeholder="alias" value="" id="new_page_alias">
        
        <div class="clear"></div>    
            
		<textarea class="ifa" name="details" placeholder="Описание страницы" id="new_page_details"></textarea>
        
        <div class="clear"></div>    
            <button type="submit" class="mtvc-button add-button">Создать</button>
        </form>
    </fieldset>
    <div id="result_create_page"></div>
</body>
<script type="text/javascript" language="javascript">
	$(function(){
			$('form[name=create-page-form]').ajaxForm(function(){
					load_menu('pageTypes');
				});
		});
</script>
</html>