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

<title>Application CARD</title>
</head>


<?php
	$id = $_GET['name'];
	
	$query = "SELECT * FROM [pre]applications WHERE `id`='".$id."'";
	
	$_stmt = $dbh->prepare($query);
	$_res = $_stmt->execute();
	
	$data = $_res->fetchallAssoc();
	$item = $data[0];
?>

<body>
	<h4><?php echo $item['name']; ?></h4>
    <div class="wrap">
    
    <fieldset>
    	<legend>Редактировать Application:</legend>
        <form name="edit-app-form" action="ajax/edit/app.edit.php" method="POST" target="_blank">
        	<input type="hidden" name="id" value="<?php echo $id ?>">
        
        	<input type="text" class="if" name="name" placeholder="application name" value="<?php echo $item['name'] ?>">
            <input type="text" class="if" name="alias" placeholder="application filename.php" value="<?php echo $item['alias'] ?>">
        	
            <select class="if" name="block">
            	<option value="0" <?php if(!$item['block']) echo 'selected'; ?> >Включен</option>
                <option value="1" <?php if($item['block']) echo 'selected'; ?>>Выключен</option>
            </select>
        
        <div class="clear"></div>    
            
		<textarea class="ifa" name="details" placeholder="Описание application" id="app_details"><?php echo $item['details'] ?></textarea>
        
        <div class="clear"></div>    
            <button type="submit" class="mtvc-button add-button">Сохранить</button>
        </form>
    </fieldset>
    <div id="result_edit_app"></div>
    
    </div>
</body>

<script type="text/javascript" language="javascript">
	$(function(){
			$('form[name=edit-app-form]').ajaxForm(function(){
					$('#result_edit_app').html('Saving...');
					setTimeout(function(){
							$('#result_edit_app').html('Success save application data.');
						},400);
				});
		});
</script>

</html>