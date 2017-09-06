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

<title>Load EDIT STOCK ORDER</title>
</head>

<?php
	$app_id = 33;
	
	$item_id = $_POST['id'];
	
	$item_query = "SELECT * FROM [pre]stock_orders WHERE `id`='".$item_id."' ORDER BY id LIMIT 1";
			
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
	
	$keeps_query = "SELECT * FROM [pre]users WHERE `type` = :1 ORDER BY id LIMIT 1000";
			
		$keeps_stmt	= $dbh->prepare($keeps_query);
		$keeps_arr	= $keeps_stmt->execute(7); 		// Кладовщики
		$keeps		= $keeps_stmt->fetchallAssoc();
	
	$statuses = array("Сформирован","Готов к приему","Принят на склад","Доступен в продаже");
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="save-item-form" action="<?php echo WP_FOLDER ?>ajax/edit/edit-stock-order.php" method="POST" enctype="multipart/form-data" target="_blank">
            
            <input type="hidden" name="id" value="<?php echo $item_id ?>">
            
            <div class="zen-form-item">
				<label for="create-name">Файл поставки</label><br>
				<div class="zif-wrap">
                	<input id="create-file" class="my-field" type="file" value="" name="file" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-name">Поставщик</label><br>
				<div class="zif-wrap">
                	<input id="create-supplier" class="my-field" type="text" placeholder="Укажите поставщика" value="<?php echo $item['supplier'] ?>" name="supplier" size="20" maxlength="25" />
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
							?><option value="<?php echo $keep['id'] ?>" <?php if($keep['id'] == $item['user_id']) echo 'selected' ?> ><?php echo $keep['name']." ".$keep['fname'] ?></option><?php
						}
						?>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
				<label for="create-stock">Статус</label><br>
				<div class="zif-wrap-select styled-select">               	
					<select class="sampling_changed" id="create-status" name="status">
						<?php
                        foreach($statuses as $status_id => $status)
						{
							?><option value="<?php echo $status_id ?>" <?php if($status_id == $item['status']) echo 'selected' ?> ><?php echo $status ?></option><?php
						}
						?>
					</select>
				</div>
			</div>
            
            </form>
            
            <div class="clear"></div>
        
        <?php
        $query = "SELECT * FROM [pre]stock_order_products WHERE `order_id`='".$item_id."' ORDER BY id LIMIT 1000";
			
			$products_stmt	= $dbh->prepare($query);
			$products_arr 	= $products_stmt->execute();
			$products 		= $products_stmt->fetchallAssoc();
		?>
            
           	<div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                    	<th class="main-t-th check-col" style="line-height:37px; padding-left:4px;">
                        	<input	type="checkbox" 
                            		name="checkerAll" 
                                    class="table-checkbox" 
                                    id="checkAll"
                                    value="null" 
                                    onclick="select_all_checked(); scan_active_product_checked();">
                             <label	class="tab-check-lab" 
                            		for="checkAll">&nbsp;&nbsp;</label>
                        </th>
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрих-код</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">На складе</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">В продаже</th>
                    </div>
                    <tbody>
                    <?php
						$cnt = 0;
                    	foreach($products as $pr_num => $pr)
						{
							if($pr['in_shop'])
							{
								$products[$pr_num]['publish_class'] = 'published';
								$products[$pr_num]['in_shop'] = 'Да';
							}else
							{
								$products[$pr_num]['publish_class'] = 'not-published';
								$products[$pr_num]['in_shop'] = 'Нет';
							}
							if($pr['shipped'] == 0) $products[$pr_num]['shipped'] = "Нет";
							if($pr['shipped'] == $pr['quant']) $products[$pr_num]['shipped'] = "Весь";
						}
						foreach($products as $pr)
						{
							$cnt++;
							
							$tr_class = "";
							if($cnt%2 == 1){ $tr_class = "trcolor"; }
							
							$shipped = "";
							//if($pr['shipped'] == $pr['quant']){ $tr_class .= " shipped"; }
						?>
						<tr class="<?php echo $tr_class ?>" id="order-product-<?php echo $pr['id'] ?>">
                        	<td class="check-col">
                        		<input	type="checkbox" 
                            			name="checker<?php	echo $pr['id'] ?>" 
                            	        class="table-checkbox" 
                            	        id="check<?php 		echo $pr['id'] ?>"
                            	        value="<?php 		echo $pr['id'] ?>"
                            	        onchange="scan_active_product_checked();" >
                            	<label	class="tab-check-lab" 
                            			for="check<?php 	echo $pr['id'] ?>">&nbsp;&nbsp;</label>
                        	</td>
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['category'] ?></td>
                            <td><?php echo $pr['shipped'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td class="publication" id="td-pub-<?php echo $pr['id'] ?>">
                        	<div class="<?php echo $pr['publish_class'] ?>" id="pub-<?php echo $pr['id'] ?>"></div>
                            <span><?php echo $pr['in_shop'] ?></span>
                        </td>
                        </tr>
						<?php
						}
					?>
                    </tbody>
                </table>
            </div>
            
            <?php if($item['status'] == 2){ ?>
            
            <div class="zen-form-item">
            <button class="ibut nonactive" 
            		id="add_to_shop_button" 
                    type="button" 
                    title="Опция стент активна только после отметки товаров из заявки" 
                    onclick="add_to_shop();">Добавить в магазин</button>
            </div>
            
            <?php } ?>
            
            <br><br>
            
            <div class="clear"></div>
        	<div class="ajax" id="ajax-getter"></div>
            
            <br><br>
            
            <div class="card-information">
            	<p>Информация:</p>
                <table class="maintable">
                	<tr class="trcolor">
                    	<td>Автор:</td>
                        <td><?php echo $author['name']." ".$author['lname'] ?></td>
                    </tr>
                    <tr class="">
                    	<td>Создан:</td>
                        <td><?php echo $item['dateCreate'] ?> , <?php echo $item['ip_add'] ?></td>
                    </tr>
                    <tr class="trcolor">
                    	<td>Склад:</td>
                        <td><b><?php echo $item['stock_id'] ?></b></td>
                    </tr>
                    <tr class="">
                    	<td>Зона:</td>
                        <td><b><?php echo $item['zona'] ?></b></td>
                    </tr>
                    <tr class="trcolor">
                    	<td>Стеллаж:</td>
                        <td><b><?php echo $item['rack'] ?></b></td>
                    </tr>
                </table>
            </div>
            
            <div class="clear"></div>
            
            <div id="wp-form-extra-fields-wrap">
            </div><!-- wp-form-extra-fields-wrap -->
        
        	<div class="clear"></div>
        
    </div>
</body>
<script type="text/javascript" language="javascript">
	var admin_id = <?php echo ADMIN_ID ?>;
	$(function(){
			$('form[name=save-item-form]').ajaxForm(function(){
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/edit-stock.order.status.php" ?>',function(){
						});
				});
		});
	function change_rotator(id,place,loos)
	{
		$('#'+id+'-'+place).addClass('active');
		$('#'+id+'-'+loos).removeClass('active');
		
		$('#radio-'+id+'-'+place).click();
	}
	
	function add_to_shop()
	{
		var cur_items = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_item_id = $(this).val();
				if(cur_item_id != 'null')
				{
					cur_items.push(cur_item_id);
					
					$('#pub-'+cur_item_id).attr('class','published');
					$('#td-pub-'+cur_item_id+' span').html('Да');
				}
			});
		if(cur_items.length > 0)
		{
			var data = { 'items[]':cur_items }
			$('#ajax-getter').load('<?php echo WP_FOLDER ?>ajax/heandlers/add-products-to-shop.php',data,function(){
				});
		}else
		{
			$('#ajax-getter').html('Выберите небходимые продукты.');
		}
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
	
	function scan_active_product_checked()
	{
		var cur_items = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_item_id = $(this).val();
				if(cur_item_id != 'null')
				{
					cur_items.push(cur_item_id);
				}
			});
		if(cur_items.length > 0)
		{
			$('#add_to_shop_button').removeClass('nonactive');
			$('#add_to_shop_button').attr('title','Добавить выбранные в магазин');
			$('#add_to_shop_button').css('cursor','pointer');
		}else
		{
			$('#add_to_shop_button').addClass('nonactive');
			$('#add_to_shop_button').attr('title','Опция стент активна только после отметки товаров из заявки');
			$('#add_to_shop_button').css('cursor','auto');
		}
	}
</script>

</html>