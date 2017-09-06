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

<title>Load MAKE STOCK ORDER</title>
</head>

<?php
	$app_id = 33;
	
	$id = $_POST['id'];
		
	$query = "SELECT * FROM [pre]stock_orders WHERE `id`='".$id."' ORDER BY id LIMIT 1";
			
			$orders_stmt	= $dbh->prepare($query);
			$orders_arr 	= $orders_stmt->execute();
			$orders 		= $orders_stmt->fetchallAssoc();
			
			$order = $orders[0];
			
	$query = "SELECT * FROM [pre]stock_order_products WHERE `order_id`='".$id."' ORDER BY id LIMIT 1000";
			
			$products_stmt	= $dbh->prepare($query);
			$products_arr 	= $products_stmt->execute();
			$products 		= $products_stmt->fetchallAssoc();
			
			//echo '<pre>'; print_r($products); echo '</pre>';
	
	$total_pos = 0;
	
	foreach($products as $pid)
	{	
		if($pid['shipped'] == $pid['quant']) $total_pos++;
	}
?>

<body>
	<div class="ipad-20" id="order_conteinter">
		<div class="order-title">Прием заказа № <?php echo $id ?> </div> 
		
        <div style="clear:both;"></div>
			
            <?php 
			if($total_pos < sizeof($products))
			{
			?>
                 
			<div class="zen-form-item">
				<label for="create-fname">Ввод штрих кода</label><br>
				<div class="zif-wrap">
                    	<input id="enter_code" class="my-field" type="text" placeholder="Введите штрих-код" value="" name="code" size="20" maxlength="20" 
                        	   onchange="enter_code($(this).val());" />
                </div>
            </div>
            
            
            <div class="zen-form-item">
				<div class="zif-wrap"><br>
                	Позиций <span id="total_position"><?php echo $total_pos ?></span>/<?php echo sizeof($products) ?>
                </div>
            </div>
            
            <div class="right">
            
            <div class="zen-form-item">
				Ячейка <span id="cur_shelf_id"></span>
            </div>
            
            <div class="zen-form-item">
				<button class="r-z-h-s-create" type="button" title="Ячейка полная" onclick="set_shelf_full();">Полная</button>
            </div>
            
            <div class="zen-form-item">
				<button class="r-z-h-s-create" type="button" title="Ячейка не пустая" onclick="set_shelf_no_empty();">Другую</button>
            </div>
            
             <?php
			}else{
				?>
            <div class="right">
                
			<div class="zen-form-item">
				<div class="zif-wrap"><br>
                	Позиций <span id="total_position"><?php echo $total_pos ?></span>/<?php echo sizeof($products) ?>
                </div>
            </div>
				<?php
				}
			?>
            
            <div class="zen-form-item"><br>
				<div class="zif-wrap">
                    	<a href="#" title="Распечатать накладную">Печать приходной накладной</a>
                </div>
            </div>
            
            </div>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрих-код</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">Кол-во</th>
                    </div>
                    <tbody>
                    <?php
						$cnt = 0;
                    	foreach($products as $pr)
						{
							$cnt++;
							
							$tr_class = "";
							if($cnt%2 == 1){ $tr_class = "trcolor"; }
							
							$shipped = "";
							if($pr['shipped'] == $pr['quant']){ $tr_class .= " shipped"; }
						?>
						<tr class="<?php echo $tr_class ?>" id="order-product-<?php echo $pr['id'] ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['category'] ?></td>
                            <td><span class="shipped_quant" id="shipped_quant_<?php echo $pr['id'] ?>"><?php echo $pr['shipped'] ?></span>
                            	/
								<?php echo $pr['quant'] ?>
                            </td>
                        </tr>
						<?php
						}
					?>
                    </tbody>
                </table>
            </div>
                        <div style="clear:both;"></div>
            <div id="order-data" style="display:none;">
            	<input id="real_sum" type="hidden" name="sum" value="0">
            </div>
            <div id="ajax-message"></div>
        <div id="preload_wrap" style="display:block;"></div>
    </div>
</body>
<script type="text/javascript" language="javascript">
	var cur_code = 0;
	
	$(function(){
			<?php 
			if($total_pos >= sizeof($products))
			{ 
				?>
				$('#get_order_button').removeClass('nonactive');
				$('#get_order_button').css('cursor','pointer');
				$('#get_order_button').attr('title','Принять заявку');
				<?php
			}else
			{
				?>
				$('#enter_code').focus();
				//$('#get_order_button').addClass('nonactive');
				<?php
			}
			?>
		})
	function enter_code(code)
	{
		cur_code = code;
		
		$('#ajax-message').html('Проверка...');
		var data = { order_id:<?php echo $id ?>,code:code }
		$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/enter-stock-code.php',data,function(){
				$('#enter_code').attr('value','');
			});
	}
	
	function set_shelf_full()
	{
		$('#ajax-message').html('Обновление ячейки...');
		var data = { order_id:<?php echo $id ?>,code:cur_code,fullness:2 }
		$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/change-stock-code-shelf.php',data,function(){
				$('#enter_code').attr('value','');
				$('#enter_code').focus();
			});
	}
	
	function set_shelf_no_empty()
	{
		$('#ajax-message').html('Обновление ячейки...');
		var data = { order_id:<?php echo $id ?>,code:cur_code,fullness:1 }
		$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/change-stock-code-shelf.php',data,function(){
				$('#enter_code').attr('value','');
				$('#enter_code').focus();
			});
	}
	
	function get_order()
	{
		if(!$('#get_order_button').hasClass('nonactive'))
		{
				$('#ajax-message').html('Обновление данных...');
				var data = { order_id:<?php echo $id ?> }
				$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/change-stock-order.php',data,function(){
					});
		}
	}
</script>

</html>