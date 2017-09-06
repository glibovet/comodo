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

<title>Load CREATE ITEM STOCK</title>
</head>

<?php
	$app_id = 31;
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="create-item-form" action="<?php echo WP_FOLDER ?>ajax/insert/create-stock.php" method="POST" target="_blank">
            
            <div class="zen-form-item">
				<label for="create-name">Название*</label><br>
				<div class="zif-wrap">
                	<input id="create-name" class="my-field" type="text" placeholder="Введите название" value="" name="name" size="50" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-fname">Алиас*</label><br>
				<div class="zif-wrap">
                	<input id="create-fname" class="my-field" type="text" placeholder="Введите алиас" value="" name="alias" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Публикация</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" checked="checked">
                    <input type="radio" name="block[]" id="radio-block-no" value="1">
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn active" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-fname">Адрес*</label><br>
				<div class="zif-wrap">
                	<input id="create-fname" class="my-field" type="text" placeholder="Введите адрес" value="" name="adress" size="50" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-fname">GPS широта*</label><br>
				<div class="zif-wrap">
                	<input id="create-fname" class="my-field" type="text" placeholder="Введите широту" value="" name="gps_w" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-fname">GPS долгота*</label><br>
				<div class="zif-wrap">
                	<input id="create-fname" class="my-field" type="text" placeholder="Введите долготу" value="" name="gps_h" size="20" />
                </div>
            </div>
            
            <div class="clear"></div>
            
            <div id="wp-form-extra-fields-wrap">
            	<input type="hidden" name="ef_date[]" value="0">
                <input type="hidden" name="ef[]" value="0">
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
			$('form[name=create-item-form]').ajaxForm(function(){
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/create-stock.status.php" ?>',function(){
						});
				});
		});
	function change_rotator(id,place,loos)
	{
		$('#'+id+'-'+place).addClass('active');
		$('#'+id+'-'+loos).removeClass('active');
		
		$('#radio-'+id+'-'+place).click();
	}
	
	function submit_create_form(choice)
	{
		$('#ajax-getter').html('Loading...');
		$('form[name=create-item-form]').submit();
		
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