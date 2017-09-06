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

<title>Load EDIT STOCK</title>
</head>

<?php
	$app_id = 31;
	
	$item_id = $_POST['id'];
	
	$item_query = "SELECT * FROM [pre]stocks WHERE `id`='".$item_id."' ORDER BY id LIMIT 1";
			
		$item_stmt = $dbh->prepare($item_query);
		$item_arr = $item_stmt->execute();
		$item = $item_arr->fetchallAssoc();
		
		$item = $item[0];
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="save-item-form" action="<?php echo WP_FOLDER ?>ajax/edit/edit-stock.php" method="POST" target="_blank">
            
            <input type="hidden" name="id" value="<?php echo $item_id ?>">
            
            <div class="zen-form-item">
				<label for="create-name">Название*</label><br>
				<div class="zif-wrap">
                	<input id="create-name" class="my-field" type="text" placeholder="Введите название" value="<?php echo $item['name'] ?>" name="name" size="50" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-fname">Алиас*</label><br>
				<div class="zif-wrap">
                	<input id="create-alias" class="my-field" type="text" placeholder="Введите алиас" value="<?php echo $item['alias'] ?>" name="alias" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Публикация</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" <?php if(!$item['block']) echo 'checked="checked"'; ?> >
                    <input type="radio" name="block[]" id="radio-block-no" value="1"<?php if($item['block']) echo 'checked="checked"'; ?>>
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if(!$item['block']) echo 'active'; ?>" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn <?php if($item['block']) echo 'active'; ?>" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-name">Адрес*</label><br>
				<div class="zif-wrap">
                	<input id="create-adress" class="my-field" type="text" placeholder="Введите адрес" value="<?php echo $item['adress'] ?>" name="adress" size="50" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-gps-w">GPS широта*</label><br>
				<div class="zif-wrap">
                	<input id="create-alias" class="my-field" type="text" placeholder="Введите GPS широту" value="<?php echo $item['gps_w'] ?>" name="gps_w" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-gps-h">GPS долгота*</label><br>
				<div class="zif-wrap">
                	<input id="create-alias" class="my-field" type="text" placeholder="Введите GPS долготу" value="<?php echo $item['gps_h'] ?>" name="gps_h" size="20" />
                </div>
            </div>
            
            <div class="clear"></div>
            
            <div id="wp-form-extra-fields-wrap">
            </div><!-- wp-form-extra-fields-wrap -->
            
        </form>
        
        	<div class="clear"></div>
        
        <div class="clear"></div>
        <div class="ajax" id="ajax-getter"></div>
        
    </div>
</body>
<script type="text/javascript" language="javascript">
	var admin_id = <?php echo ADMIN_ID ?>;
	$(function(){
			$('form[name=save-item-form]').ajaxForm(function(){
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/edit-stock.status.php" ?>',function(){
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
						load_content(content_path);
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