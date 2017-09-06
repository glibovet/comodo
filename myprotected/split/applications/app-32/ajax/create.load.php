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

<title>Load CREATE ITEM STOCK FIELD</title>
</head>

<?php
	$app_id = 32;
	
	$stocks_query = "SELECT * FROM [pre]stocks WHERE 1 ORDER BY id LIMIT 1000";
			
		$stocks_stmt = $dbh->prepare($stocks_query);
		$stocks_arr = $stocks_stmt->execute();
		$stocks = $stocks_stmt->fetchallAssoc();
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="create-item-form" action="<?php echo WP_FOLDER ?>ajax/insert/create-stock-field.php" method="POST" target="_blank">
            
            <div class="zen-form-item">
				<label for="create-stock">Склад</label><br>
				<div class="zif-wrap-select styled-select">               	
					<select class="sampling_changed" id="create-stock" name="stock_id" onchange="show_actual_zones($(this).val());">
						<option value="0" selected="selected" data-skip="1">Укажите склад</option>
						<?php
                        foreach($stocks as $stock)
						{
							?><option value="<?php echo $stock['id'] ?>"><?php echo $stock['name'] ?></option><?php
						}
						?>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
				<label for="create-object">Обьект создания</label><br>
				<div class="zif-wrap-select styled-select">               	
					<select class="sampling_changed" id="create-object" name="object_id" onchange="show_actual_form($(this).val());">
						<option value="0" selected="selected" data-skip="1">Зона</option>
						<option value="1">Стеллаж</option>
                        <option value="2">Секция</option>
                        <option value="3">Полка</option>
					</select>
				</div>
			</div>
            
            
            <div class="clear"></div>
            
            <span id="actual_form"> <!-- Стартовая форма полей для создания ЗОНЫ -->
            
            <div class="zen-form-item">
				<label for="create-name">Название* (ABC)</label><br>
				<div class="zif-wrap">
                	<input id="create-name" class="my-field" type="text" placeholder="Введите букву" value="" name="zona" size="20" maxlength="1" />
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
            
            </span><!-- actual_form -->
            
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
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/create-stock-field.status.php" ?>',function(){
						});
				});
		});
	
	function show_actual_form(object_id)
	{
		$('#actual_form').html('<center>Reloading form fields...</center>');
		var data = { object_id:object_id }
		$('#actual_form').load('<?php echo WP_FOLDER."ajax/load/reload-stock-form-fields.php" ?>',data,function(){
			});
	}
	
	function show_actual_zones(stock_id)
	{
		$('#actual_zones').html('<center>Reload zones...</center>');
		var data = { stock_id:stock_id }
		$('#actual_zones').load('<?php echo WP_FOLDER."ajax/load/reload-stock-zones.php" ?>',data,function(){
				show_actual_racks(-1);
				show_actual_sections(-1);
			});
	}
	
	function show_actual_racks(zone_id)
	{
		var stock_id = $('#create-stock').val();
		
		$('#actual_racks').html('<center>Reload racks...</center>');
		var data = { stock_id:stock_id, zone_id:zone_id }
		$('#actual_racks').load('<?php echo WP_FOLDER."ajax/load/reload-stock-racks.php" ?>',data,function(){
				show_actual_sections(-1);
			});
	}
	
	function show_actual_sections(rack_id)
	{
		var stock_id = $('#create-stock').val();
		var zone_id = $('#create-zona').val();
		$('#actual_sections').html('<center>Reload sections...</center>');
		var data = { stock_id:stock_id, zone_id:zone_id, rack_id:rack_id }
		$('#actual_sections').load('<?php echo WP_FOLDER."ajax/load/reload-stock-sections.php" ?>',data,function(){
			});
	}
		
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