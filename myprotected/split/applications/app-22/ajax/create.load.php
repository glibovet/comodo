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
	
	$on_page = $_POST['on_page'];;
	$start_page = $_POST['start_page'];
	$pages = 1;
		
	$query = "SELECT COUNT(*) FROM [pre]shop_orders WHERE 1 ORDER BY id";
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute();
			$users = $users_stmt->fetchallAssoc();
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="create-order-form" action="http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/create-order.php" method="POST" target="_blank">
            <input id="order-code" class="filtr-form-group mat-field" type="text" placeholder="Введите штрих-код" value="" name="code" />
            <input id="order-sum" class="filtr-form-group mat-field" type="text" placeholder="Сумма заказа: 0 грн" disabled="disabled" name="sum" value_sum="0" />
                        <div class="styled-select filtr-form-group">
                            <select name="user_id" class="sampling_changed" id="uid">
                                <option  selected="selected" data-skip="1" value="0">Выберите заказчика</option>
                                <option value="3">Monami</option>
                                <option value="4">Bonjur</option>
                                <option value="5">Barbaris</option>
                            </select>
                        </div>
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">Доступно</th>
                        <th class="main-t-th" style="">Количество</th>
                        <th class="main-t-th" style="">Цена (грн)</th>
                        <th class="main-t-th" style="">Удалить</th>
                    </div>
                    <tbody></tbody>
                </table>
            </div>
                        <div style="clear:both;"></div>
			<button class="r-z-h-s-create-sm filtr-form-group" type="button" onclick="submit_order();">Создать</button>
            <div id="order-data" style="display:none;">
            	<input id="real_sum" type="hidden" name="sum" value="0">
            </div>
            <div id="ajax-message"></div>
        </form>
        <div id="preload_wrap" style="display:block;"></div>
    </div>
</body>
<script type="text/javascript" language="javascript">
	var total_summ = 0;
	
	$(function(){
			window.onkeypress = pressed;
		});
	
	function pressed(e)
	{
    	var key = e.keyCode || e.which;
		//alert(key);
		if(key == 13)
		{
			var code = $('#order-code').val();
			reload_products(code);
		}
	}
	
	function reload_products(code)
	{
		$('#preload_wrap').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/load/product.php?code='+code,function(){
				var name = $('#code-name').val();
				var cat = $('#code-cat').val();
				var dostupno = $('#code-dost').val();
				var quant = 1;
				var sum = parseInt($('#code-sum').val());
				var row_id = $('#code-id').val();
				
				var message = $('#code-message').val();
		
		var content = '<tr id="myrow-'+row_id+'"><td>'+name+'</td><td>'+cat+'</td><td>'+dostupno+'</td><td><input class="my-field order-quants" type="number" value="'+quant+'" size="5" maxlength="5" id="quant-'+row_id+'" mysum="'+sum+'" name="quant['+row_id+']" onchange="recalc_sum();"></td><td>'+sum+'</td><td><img alt="DEL" src="split/img/del.png" onclick="delete_row('+row_id+');"></td></tr>';
		
		if(message == "")
		{
			//summ += sum;
			//$('#order-sum').attr('placeholder','Сумма заказа: '+summ+' грн');
			//$('#real_sum').attr('value',summ);
			
			$('#main-table').append(content);
			
			 var order_data = '<div id="list-product-'+row_id+'"><input type="hidden" name="products[]" value="'+row_id+'"></div>';
			 
			 $('#order-data').append(order_data);
			 
			 recalc_sum();
		}
		$('#ajax-message').html(message);
		$('#order-code').attr('value','');
			});
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
		$('#order-sum').attr('placeholder','Сумма заказа: '+total_summ+' грн')
	}
	
	function delete_row(id)
	{
		$('#myrow-'+id).hide(200);
		$('#list-product-'+id).html('');
		$('#list-product-'+id).attr('id','');
	}
	
	$(function(){
			$('form[name=create-order-form]').ajaxForm(function(){
					$('#order_conteinter').html("<center>Заказ успешно сформирован.</center>");
				});
		});
		
	function submit_order()
	{
		var may_order = true;
		
		var uid = $('#uid').val();
		
		if(uid == 0){ may_order = false; }
		
		if(may_order)
		{
			$('form[name=create-order-form]').submit();
		}else
		{
			$('#ajax-message').html("Пожалуйста, сначала выберите заказчика.");
		}
	}
</script>

</html>