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

<title>Load CREATE ITEM STOCK ORDER</title>
</head>

<?php
	$app_id = 33;
	
	$keeps_query = "SELECT * FROM [pre]users WHERE `type` = :1 ORDER BY id LIMIT 1000";
			
		$keeps_stmt	= $dbh->prepare($keeps_query);
		$keeps_arr	= $keeps_stmt->execute(7); 		// Кладовщики
		$keeps		= $keeps_stmt->fetchallAssoc();
		
	$stocks_query = "SELECT * FROM [pre]stocks WHERE 1 ORDER BY id LIMIT 1000";
			
		$stocks_stmt = $dbh->prepare($stocks_query);
		$stocks_arr = $stocks_stmt->execute();
		$stocks = $stocks_stmt->fetchallAssoc();
	
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="create-item-form" action="<?php echo WP_FOLDER ?>ajax/insert/create-stock-order.php" method="POST" enctype="multipart/form-data" target="_blank">
            
            <div class="zen-form-item">
				<label for="create-name">Файл поставки</label><br>
				<div class="zif-wrap">
                	<input id="create-file" class="my-field" type="file" value="" name="file" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-name">Поставщик</label><br>
				<div class="zif-wrap">
                	<input id="create-supplier" class="my-field" type="text" placeholder="Укажите поставщика" value="" name="supplier" size="20" maxlength="25" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-stock">Ответственный</label><br>
				<div class="zif-wrap-select styled-select">               	
					<select class="sampling_changed" id="create-user" name="user_id">
						<option value="0" selected="selected" data-skip="1">Укажите кладовщика</option>
						<?php
                        foreach($keeps as $keep)
						{
							?><option value="<?php echo $keep['id'] ?>"><?php echo $keep['name']." ".$keep['lname'] ?></option><?php
						}
						?>
					</select>
				</div>
			</div>
            
            <div class="clear"></div>
            
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
				<label for="create-stock">Зона</label><br>
				<div class="zif-wrap-select styled-select" id="actual_zones">               	
					<select class="sampling_changed" id="create-zona" name="zona" onchange="show_actual_racks($(this).val());">
						<option value="0" selected="selected" data-skip="1">Укажите зону</option>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
				<label for="create-stock">Стеллаж</label><br>
				<div class="zif-wrap-select styled-select" id="actual_racks">               	
					<select class="sampling_changed" id="create-rack" name="rack">
						<option value="0" selected="selected" data-skip="1">Укажите стеллаж</option>
					</select>
				</div>
			</div>
            
            
            
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
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/create-stock-order.status.php" ?>',function(){
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
	
	function show_actual_zones(stock_id)
	{
		$('#actual_zones').html('<center>Reload zones...</center>');
		var data = { stock_id:stock_id }
		$('#actual_zones').load('<?php echo WP_FOLDER."ajax/load/reload-stock-zones.php" ?>',data,function(){
				show_actual_racks(-1);
				//show_actual_sections(-1);
			});
	}
	
	function show_actual_racks(zone_id)
	{
		var stock_id = $('#create-stock').val();
		
		$('#actual_racks').html('<center>Reload racks...</center>');
		var data = { stock_id:stock_id, zone_id:zone_id }
		$('#actual_racks').load('<?php echo WP_FOLDER."ajax/load/reload-stock-racks.php" ?>',data,function(){
				//show_actual_sections(-1);
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
</script>

</html>