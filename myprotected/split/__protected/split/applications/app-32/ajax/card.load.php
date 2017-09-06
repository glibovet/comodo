<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../../require.base.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>Load EDIT STOCK SHELF</title>
</head>

<?php
	$app_id = 32;
	
	$item_id = $_POST['id'];
	
	$item_query = "SELECT * FROM [pre]stock_fields WHERE `id`='".$item_id."' ORDER BY id LIMIT 1";
			
		$item_stmt = $dbh->prepare($item_query);
		$item_arr = $item_stmt->execute();
		$item = $item_arr->fetchallAssoc();
		
	$item = $item[0];
	
	$author_id = $item['adminMod'];
	
	$author_query = "SELECT * FROM [pre]users WHERE `id` = :1 LIMIT 1";
	
		$author_stmt = $dbh->prepare($author_query);
		$author_arr = $author_stmt->execute($author_id);
		$author = $author_arr->fetchallAssoc();
		
	$author = $author[0];
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="save-item-form" action="<?php echo WP_FOLDER ?>ajax/edit/edit-stock-shelf.php" method="POST" target="_blank">
            
            <input type="hidden" name="id" value="<?php echo $item_id ?>">
            
            <div class="zen-form-item">
				<label for="create-name">Штрих-код</label><br>
				<div class="zif-wrap">
                	<input id="create-code" class="my-field" type="text" placeholder="Введите штрих-код" value="<?php echo $item['code'] ?>" name="code" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Публикация</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" <?php if(!$item['block']) echo 'checked="checked"'; ?> >
                    <input type="radio" name="block[]" id="radio-block-no" value="1" <?php if($item['block']) echo 'checked="checked"'; ?>>
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if(!$item['block']) echo 'active'; ?>" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn <?php if($item['block']) echo 'active'; ?>" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            </form>
            
            <div class="clear"></div>
            
            <div class="card-information">
            	<p>Информация:</p>
                <p>Автор: <?php echo $author['name']." ".$author['lname'] ?></p>
                <p>Создан: <?php echo $item['dateCreate'] ?> , <?php echo $item['ip_add'] ?></p>
                <p>ID ячейки: <b><?php echo $item['id'] ?></b></p>
            </div>
            
            <div class="clear"></div>
            
            <div id="wp-form-extra-fields-wrap">
            </div><!-- wp-form-extra-fields-wrap -->
        
        	<div class="clear"></div>
        
        <div class="clear"></div>
        <div class="ajax" id="ajax-getter"></div>
        
    </div>
</body>
<script type="text/javascript" language="javascript">
	var admin_id = <?php echo ADMIN_ID ?>;
	$(function(){
			$('form[name=save-item-form]').ajaxForm(function(){
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/edit-stock-shelf.status.php" ?>',function(){
						});
				});
		});
	function change_rotator(id,place,loos)
	{
		$('#'+id+'-'+place).addClass('active');
		$('#'+id+'-'+loos).removeClass('active');
		
		$('#radio-'+id+'-'+place).click();
	}
	
	function submit_save_form(choice)
	{
		$('#ajax-getter').html('Loading...');
		$('form[name=save-item-form]').submit();
		
		switch(choice)
		{
			case 1: // Сохранить и дублировать
					{
						break;
					} 
			case 2: // Сохранить и редактировать
					{
						break;
					} 
			case 3: // Сохранить и закрыть
					{
						change_head(1); 
						load_app_content(content_path,<?php echo $app_id ?>);
						break;
					} 
			case 4: // Сохранить и создать
					{
						break;
					} 
			default: break;
		}
	}
</script>

</html>