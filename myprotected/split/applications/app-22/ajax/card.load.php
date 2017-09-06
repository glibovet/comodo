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

<title>Load CREATE ORDER</title>
</head>

<?php
	$app_id = 22;
	
	$id = $_POST['id'];
		
	$query = "SELECT * FROM [pre]shop_orders WHERE `id`='".$id."' ORDER BY id LIMIT 1";
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute();
			$order = $users_stmt->fetchallAssoc();
			$order = $order[0];
			
			$products = unserialize($order['products']);
			
			$products_data = array();
			
			//echo '<pre>'; print_r($products); echo '</pre>';
	
	foreach($products as $pid)
	{
		$product_id = $pid['id'];
		$cart_product_id = (isset($pid['prod_id']) ? $pid['prod_id'] : 0);
		$product_quant = $pid['quant'];
		
		$query = "SELECT * FROM [pre]shop_products WHERE `id`='".$product_id."' OR `id`='".$cart_product_id."' ORDER BY id LIMIT 1";
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute();
			$prod = $users_stmt->fetchallAssoc();
			
			$query = "SELECT * FROM [pre]shop_cat_prod_ref WHERE `prod_id`='".$product_id."' ORDER BY id LIMIT 1";
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute();
			$cat = $users_stmt->fetchallAssoc();
			$ref = $cat[0];
			
			$query = "SELECT * FROM [pre]shop_catalog WHERE `id`='".$ref['cat_id']."' ORDER BY id LIMIT 1";
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute();
			$cat = $users_stmt->fetchallAssoc();
			$cat = $cat[0];
			
			$prod[0]['cat'] = $cat['name'];
			$prod[0]['quant'] = $product_quant;
			$prod[0]['myid'] = $product_id;
			
			
			array_push($products_data,$prod[0]);
	}
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="create-order-form" action="#" method="POST" target="_blank">
                        <label> 
                        	<div style="padding:20px 20px 15px 0px; float:left;"> Заказ № <?php echo $id+5000 ?>: </div> 
                        </label>
                        
                        <div class="styled-select filtr-form-group">
                            <select name="status" id="order-status" class="sampling_changed">
                                <option <?php if($order['status'] == 'Не оформлен') echo ' selected ' ?> value="Не оформлен">Не оформлен</option>
                                <option <?php if($order['status'] == 'Оформлен') echo ' selected ' ?> value="Оформлен">Оформлен</option>
                                <option <?php if($order['status'] == 'Отгружен') echo ' selected ' ?> value="Отгружен">Отгружен</option>
                                <option <?php if($order['status'] == 'В пути') echo ' selected ' ?> value="В пути">В пути</option>
                                <option <?php if($order['status'] == 'Доставлен') echo ' selected ' ?> value="Доставлен">Доставлен</option>
                                <option <?php if($order['status'] == 'Отменен') echo ' selected ' ?> value="Отменен">Отменен</option>
                                <option <?php if($order['status'] == 'Возврат') echo ' selected ' ?> value="Возврат">Возврат</option>
                                <option <?php if($order['status'] == 'Возвращен') echo ' selected ' ?> value="Возвращен">Возвращен</option>
                            </select>
                        </div>
                        
                        <div class="styled-select filtr-form-group">
                            <select name="paid_status" id="order-paid-status" class="sampling_changed">
                                <option <?php if($order['paid_status'] == 'Не оплачен') echo ' selected ' ?> value="Не оплачен">Не Оплачен</option>
                                <option <?php if($order['paid_status'] == 'Оплачен') echo ' selected ' ?> value="Оплачен">Олачен</option>
                            </select>
                        </div>
                        
                        
                        <div style="padding:20px 20px 15px 0px; float:left;">На сумму: <span id="real_summ_view"><?php echo $order['sum'] ?></span> грн</div>
                        
                        <div style="clear:both;"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">Количество</th>
                        <th class="main-t-th" style="">Цена (грн)</th>
                        <th class="main-t-th" style="">Удалить</th>
                    </div>
                    <tbody>
                    <?php
						$cnt = 0;
                    	foreach($products_data as $pr)
						{
							$tr_class = "";
							if($cnt%2 == 1){ $tr_class = "trcolor"; }
						?>
						<tr class="<?php echo $tr_class ?>" id="order-product-<?php echo $pr['id'] ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['cat'] ?></td>
                            <td><input class="my-field order-quants" type="number" value="<?php echo $pr['quant'] ?>" size="5" maxlength="5" id="quant-<?php echo $pr['id'] ?>" myid="<?php echo $pr['myid'] ?>" mysum="<?php echo $pr['price'] ?>" name="quant[<?php echo $pr['id'] ?>]" onchange="recalc_sum();"></td>
                            <td class="order-product-price"><?php echo $pr['price'] ?></td>
                            <td>
                            <?php
                            	if($order['status'] == 'Не оформлен')
								{
									?>
									<img alt="DELETE" src="split/img/del.png" title="Удалить" onclick="delete_row(<?php echo $pr['id'] ?>);">
									<?php
								}else
								{
									echo 'Нет прав';
								}
							?>
                            </td>
                        </tr>
						<?php
						}
					?>
                    </tbody>
                </table>
            </div>
                        <div style="clear:both;"></div>
			<button class="r-z-h-s-create-sm filtr-form-group" type="button" onclick="save_edit();">Применить</button>
            <div id="order-data" style="display:none;">
            	<input id="real_sum" type="hidden" name="sum" value="<?php echo $order['sum'] ?>">
            </div>
            <div id="ajax-message"></div>
        </form>
        <div id="preload_wrap" style="display:block;"></div>
    </div>
</body>
<script type="text/javascript" language="javascript">
	var order_sum = <?php echo $order['sum'] ?>;
	
	var total_summ = 0;
	
	function save_edit()
	{
		var quants = [];
		
		$('.order-quants').each(function(){
				var cur_quant = $(this).val();
				var cur_id = $(this).attr('myid');
				
				quants[cur_id] =  cur_quant;
			});
			
		var sum = $('#real_sum').val();
		var paid_status = $('#order-paid-status').val();
		var status = $('#order-status').val();
		var data = {
					'quants[]':quants,
					status:status,
					paid_status:paid_status,
					sum:sum
					}
		$('#ajax-message').load("http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/save-order-edit.php?id=<?php echo $id ?>",data);
	}
	
	function recalc_sum()
	{
		var new_sum = 0;
		$('.order-quants').each(function(){
				var cur_quant = $(this).val();
				var cur_sum = $(this).attr('mysum');
				new_sum += cur_quant*cur_sum;
			});
			
		total_summ = new_sum;
		$('#real_sum').attr('value',total_summ);
		$('#real_summ_view').html(total_summ)
	}
	
	function delete_row(id)
	{
		$('#order-product-'+id).hide(200);
		$('#order-product-'+id)>html();
	}
</script>

</html>