<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../../require.base.php";
	
	class Card
	{
		public function deformat_date($val)
		{
			$result = "";
			$monthes = array('','января','февряля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
			
			if(strtotime($val) > strtotime(date("d.m.Y",time())." 00:00:00"))
								{
									$result = "Сегодня, ".date("H:i",strtotime($val));
		
								}elseif(strtotime($val) < strtotime(date("d.m.Y",time())." 00:00:00") &&
										strtotime($data[$item_num]['dateCreate']) > (strtotime(date("d.m.Y",time())." 00:00:00")-86400))
									{
										$result = "Вчера, ".date("H:i",strtotime($data[$item_num]['dateCreate']));
									}
								else
									{
										$result = date("d",strtotime($val))." ".$monthes[(int)date("m",strtotime($val))]." ".
																	date("Y",strtotime($val)).", ".
																	date("H:i",strtotime($val));
									}
			return $result;
		}
	}
	$obj = new Card();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>Load CREATE ORDER</title>
</head>

<?php
	$app_id = 6;
	
	$id = $_POST['id'];
		
	$query = "SELECT * FROM [pre]tasks WHERE `id`='".$id."' LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
			$task = $_res[0];
			//echo '<pre>'; print_r($taks); echo '</pre>';
		
	$is_busy = false;
	
	if($task['status'] == '0')
	{
		$query = "SELECT * FROM [pre]task_admin_ref WHERE `task_id`=".$id." ORDER BY id LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
	
		$_res = $_arr->fetchallAssoc();
		if(sizeof($_res) > 0 && $_res[0]['admin_id'] != ADMIN_ID)
		{
			$is_busy = true;
			$busy_amdin_id = $_res[0]['admin_id'];
			
			$query = "SELECT * FROM [pre]users WHERE `id`='".$busy_amdin_id."' LIMIT 1";
			
				$busy_name = "Неизвестным";
				
					$_stmt = $dbh->prepare($query);
					$_arr = $_stmt->execute();
		
					$_res = $_arr->fetchallAssoc();
							
				$busy_admin = $_res[0];
				$busy_name = $busy_admin['name']." ".$busy_admin['fname'];
		}else
		{
			$query = "INSERT INTO [pre]task_admin_ref (`task_id`,`admin_id`) VALUES ('".$id."','".ADMIN_ID."')";
			
			$_stmt = $dbh->prepare($query);
			$_stmt->execute();
		}
	}
	
	$query = "SELECT * FROM [pre]stock_orders WHERE `id`='".$task['stock_order_id']."' LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
			$order = $_res[0];
			//echo '<pre>'; print_r($taks); echo '</pre>';
	
	$query = "SELECT OP.id as id,OP.shipped as shipped,OP.name as name,OP.sku as sku,OP.code as code,OP.category as category,PR.quant as stock_quant,PR.price as shop_price,OP.quant as quant FROM [pre]stock_order_products AS OP
	LEFT JOIN [pre]shop_products AS PR ON OP.code = PR.code
	WHERE OP.order_id = '".$order['id']."' 
	ORDER BY 
	OP.status DESC 
	LIMIT 1000";		
							
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
			$products = $_arr->fetchallAssoc();
			
	
	$query = "SELECT * FROM [pre]users WHERE `id`='".$task['adminMod']."' LIMIT 1";
			
						$perf_name = "Неизвестно";
						if($task['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_name = $performer['name']." ".$performer['fname'];
						}
?>

<body>
	<div class="ipad-0-20" id="order_conteinter">
	<?php
    //echo '<pre>'; print_r($products); echo '</pre>';
	switch($task['type'])
	{
		case 1:{				// Оформление заявки на поставку
			if(!$task['status'])
			{
			?>
			<h4 class="new-line">Оформление заявки на поставку</h4>
            
            <div class="zen-form-item">
				<label for="create-fname">Ввод штрих-кода/артикула</label><br>
				<div class="zif-wrap">
                    	<input id="order_code" class="my-field" type="text" placeholder="Введите штрих код/артикул" 
                        value="" name="order_code" size="50" maxlength="50" />
                </div>
            </div>
            
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">На складе</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Удаление</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					foreach($products as $pr)
					{
						$cnt++;
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['category'] ?></td>
                            <td><?php echo $pr['stock_quant'] ?></td>
                            <td><input class="my-field order-quants" size="5" maxlength="5" type="number" name="quant[]" value="<?php echo $pr['quant'] ?>"></td>
                            <td><a href="#" onclick="delete_order_product(<?php echo $order['id'] ?>,<?php echo $pr['id'] ?>);">Удалить</a></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к заявке" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
			<div class="clear"></div>
			<?php
			}
			else
			{
				//echo 'Заявка уже оформлена.';
			?>
			<h4 class="new-line">Оформление заявки на поставку</h4>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">На складе</th>
                        <th class="main-t-th" style="">Кол-во</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					foreach($products as $pr)
					{
						$cnt++;
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['category'] ?></td>
                            <td><?php echo $pr['stock_quant'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Оформлено:</td>
                        <td><?php echo $perf_name.", ".$obj->deformat_date($task['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Комментарий:</td>
                        <td><?php echo $task['comment'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
			<?php
			}
			break;
			}
		case 2:{				// Подтверждение заявки на поставку
			if(!$task['status'])
			{
				//echo 'Подтверждение заявки на поставку';
				
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
			?>
			<h4 class="new-line">Подтверждение заявки на поставку</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">На складе</th>
                        <th class="main-t-th" style="">Кол-во</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					foreach($products as $pr)
					{
						$cnt++;
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['category'] ?></td>
                            <td><?php echo $pr['stock_quant'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к заявке" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Оформлено:</td>
                        <td><?php echo $perf_1_name.", ".$obj->deformat_date($task['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Комментарий:</td>
                        <td><?php echo $task_1['comment'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
			<?php
			}
			else
			{
				//echo 'Заявка уже подтверждена';
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
			?>
			<h4 class="new-line">Подтверждение заявки на поставку</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">На складе</th>
                        <th class="main-t-th" style="">Кол-во</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					foreach($products as $pr)
					{
						$cnt++;
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['category'] ?></td>
                            <td><?php echo $pr['stock_quant'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к заявке" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Статус:</td>
                        <td>Принято на склад</td>
                    </tr>
                    <tr>
                    	<td>Оформлено:</td>
                        <td><?php echo $perf_1_name.", ".$obj->deformat_date($task_1['dateModify']) ?></td>
                    </tr>
                    <tr>
                    <tr>
                    	<td>Подтверждено:</td>
                        <td><?php echo $perf_1_name.", ".$obj->deformat_date($task['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Комментарии:</td>
                        <td>
						<?php echo $perf_1_name.": ". $task_1['comment'] ?>
                        <br>
                        <?php echo $perf_name.": ". $task['comment'] ?>
                        </td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
			<?php
			}
			break;
			}
		case 3:{				// Подтверждение заявки производителем
			if(!$task['status'])
			{
				//echo 'Подтверждение заявки производителем';
			?>
			<h4 class="new-line">Подтверждение заявки производителем</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к заявке" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			else
			{
				//echo 'Производитель уже подтвердил заявку.';
			?>
			<h4 class="new-line">Подтверждение заявки производителем</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
                
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Возможная дата отгрузки:</td>
                        <td><?php echo "----" ?></td>
                    </tr>
                    <tr>
                    	<td>Комментарий:</td>
                        <td><?php echo $task['comment'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			break;
			}
		case 4:{				// Оплата заявки на поставку
			if(!$task['status'])
			{
				// echo 'Оплата заявки на поставку.';
				
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=3 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_3 = $_res[0];
			?>
			<h4 class="new-line">Оплата заявки на поставку</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
                
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к заявке" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
            
            <div class="clear"></div>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-pre-summ">Сумма предоплаты (30%)</label><br>
							<div class="zif-wrap-date">
                				<input	id="save-pre-summ" class="my-field" type="number"
 									   	placeholder="Сумма предоплаты" 
                        	        	name="pre-summ" value="<?php echo ceil(($total_summ*30)/100) ?>" />
                			</div>
            			</div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Возможная дата отгрузки:</td>
                        <td><?php echo "----" ?></td>
                    </tr>
                    <tr>
                    	<td>Комментарий:</td>
                        <td><?php echo $task_3['comment'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			else
			{
				// echo 'Предоплата заявки на поставку уже выполнена.';
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=2 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_2 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_2['adminMod']."' LIMIT 1";
			
						$perf_2_name = "Неизвестно";
						if($task_2['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_2_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=3 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_3 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_3['adminMod']."' LIMIT 1";
			
						$perf_3_name = "Неизвестно";
						if($task_3['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_3_name = $performer['name']." ".$performer['fname'];
						}
			?>
			<h4 class="new-line">Оплата заявки на поставку</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
                
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Оформлено менеджером:</td>
                        <td><?php echo $perf_1_name.", ".$obj->deformat_date($task_1['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Подтверждено руководителем:</td>
                        <td><?php echo $perf_2_name.", ".$obj->deformat_date($task_2['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Подтверждено производителем:</td>
                        <td><?php echo $perf_3_name.", ".$obj->deformat_date($task_3['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Возможная дата отгрузки:</td>
                        <td><?php echo "----" ?></td>
                    </tr>
                    <td>Комментарии:</td>
                        <td>
						<?php echo $perf_1_name.": ". $task_1['comment'] ?>
                        <br>
                        <?php echo $perf_2_name.": ". $task_2['comment'] ?>
                        <br>
                        <?php echo $perf_3_name.": ". $task_3['comment'] ?>
                        <br>
                        <?php echo $perf_name.": ". $task['comment'] ?>
                        </td>
                    <tr>
                    	<td>Предоплата поставки:</td>
                        <td><?php echo $perf_name.", ".$obj->deformat_date($task['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Сумма предоплаты:</td>
                        <td><?php echo $order['pre_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			break;
			}
		case 5:{				// Поставка товара производителем
			if(!$task['status'])
			{
				//echo 'Поставка товара производителем.';
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=4 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_4 = $_res[0];		
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_4['adminMod']."' LIMIT 1";
			
						$perf_4_name = "Неизвестно";
						if($task_4['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_4_name = $performer['name']." ".$performer['fname'];
						}
			?>
			<h4 class="new-line">Поставка товара производителем</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-date-arrive">Дата и время прибытия</label><br>
							<div class="zif-wrap-date">
                				<input	id="save-date-arrive" class="my-field" type="date"
 									   	placeholder="Дата прибытия" 
                        	        	name="date-arrive" value="" />
                			</div>
            			</div>
						
                        <div class="zen-form-item">
                		<label for="save-car-model">Описание машины</label><br>
							<div class="zif-wrap-date">
                				<input	id="save-car-model" class="my-field" type="text"
 									   	placeholder="Model" 
                        	        	name="car-model" value="" />
                			</div>
            			</div>
                        
                        <div class="zen-form-item">
                		<label for="save-car-num">Номер машины</label><br>
							<div class="zif-wrap-date">
                				<input	id="save-car-num" class="my-field" type="text"
 									   	placeholder="Number" 
                        	        	name="car-num" value="" />
                			</div>
            			</div>

			                
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к заявке" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Предоплата поставки:</td>
                        <td><?php echo $perf_4_name.", ".$obj->deformat_date($task_4['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Комментарий:</td>
                        <td><?php echo $task_4['comment'] ?></td>
                    </tr>
                    <tr>
                    	<td>Внесена предоплата:</td>
                        <td><?php echo $order['pre_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			else
			{
				//echo 'Поставка товара производителем уже выполнена.';
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=2 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_2 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_2['adminMod']."' LIMIT 1";
			
						$perf_2_name = "Неизвестно";
						if($task_2['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_2_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=3 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_3 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_3['adminMod']."' LIMIT 1";
			
						$perf_3_name = "Неизвестно";
						if($task_3['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_3_name = $performer['name']." ".$performer['fname'];
						}
			
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=4 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_4 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_4['adminMod']."' LIMIT 1";
			
						$perf_4_name = "Неизвестно";
						if($task_4['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_4_name = $performer['name']." ".$performer['fname'];
						}
			?>
			<h4 class="new-line">Поставка товара производителем</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
                
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Предоплата поставки:</td>
                        <td><?php echo $perf_4_name.", ".$obj->deformat_date($task_4['dateModify']) ?></td>
                    </tr>
                    <td>Комментарии:</td>
                        <td>
						<?php echo $perf_1_name.": ". $task_1['comment'] ?>
                        <br>
                        <?php echo $perf_2_name.": ". $task_2['comment'] ?>
                        <br>
                        <?php echo $perf_3_name.": ". $task_3['comment'] ?>
                        <br>
                        <?php echo $perf_4_name.": ". $task_4['comment'] ?>
                        <br>
                        <?php echo $perf_name.": ". $task['comment'] ?>
                        </td>
                    </tr>
                    <tr>
                    	<td>Внесена предоплата:</td>
                        <td><?php echo $order['pre_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>Дата и время прибытия:</td>
                        <td><?php echo $obj->deformat_date($order['date_arrive']) ?></td>
                    </tr>
                    <tr>
                    	<td>Описание машины:</td>
                        <td><?php echo $order['car_model'] ?></td>
                    </tr>
                    <tr>
                    	<td>Номер машины:</td>
                        <td><?php echo $order['car_num'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			break;
			}
		case 6:{				// Полная оплата поставки
			if(!$task['status'])
			{
				//echo 'Полная оплата поставки';
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=2 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_2 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_2['adminMod']."' LIMIT 1";
			
						$perf_2_name = "Неизвестно";
						if($task_2['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_2_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=3 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_3 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_3['adminMod']."' LIMIT 1";
			
						$perf_3_name = "Неизвестно";
						if($task_3['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_3_name = $performer['name']." ".$performer['fname'];
						}
			
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=4 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_4 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_4['adminMod']."' LIMIT 1";
			
						$perf_4_name = "Неизвестно";
						if($task_4['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_4_name = $performer['name']." ".$performer['fname'];
						}
						
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=5 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_5 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_5['adminMod']."' LIMIT 1";
			
						$perf_5_name = "Неизвестно";
						if($task_5['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_5_name = $performer['name']." ".$performer['fname'];
						}
			?>
			<h4 class="new-line">Полная оплата поставки</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-post-summ">Сумма оплаты</label><br>
							<div class="zif-wrap-date">
                				<input	id="save-post-summ" class="my-field" type="number"
 									   	placeholder="Сумма оплаты" 
                        	        	name="post-summ" value="<?php echo $total_summ - $order['pre_summ'] ?>" />
                			</div>
            			</div>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к заявке" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
            
            <div class="clear"></div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Предоплата поставки:</td>
                        <td><?php echo $perf_4_name.", ".$obj->deformat_date($task_4['dateModify']) ?></td>
                    </tr>
                    <td>Комментарии:</td>
                        <td>
						<?php echo $perf_1_name.": ". $task_1['comment'] ?>
                        <br>
                        <?php echo $perf_2_name.": ". $task_2['comment'] ?>
                        <br>
                        <?php echo $perf_3_name.": ". $task_3['comment'] ?>
                        <br>
                        <?php echo $perf_4_name.": ". $task_4['comment'] ?>
                        <br>
                        <?php echo $perf_5_name.": ". $task_5['comment'] ?>
                        </td>
                    </tr>
                    <tr>
                    	<td>Внесена предоплата:</td>
                        <td><?php echo $order['pre_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>Дата и время прибытия:</td>
                        <td><?php echo $obj->deformat_date($order['date_arrive']) ?></td>
                    </tr>
                    <tr>
                    	<td>Описание машины:</td>
                        <td><?php echo $order['car_model'] ?></td>
                    </tr>
                    <tr>
                    	<td>Номер машины:</td>
                        <td><?php echo $order['car_num'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			else
			{
				//echo 'Полная оплата поставки уже выполнена.';
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=2 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_2 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_2['adminMod']."' LIMIT 1";
			
						$perf_2_name = "Неизвестно";
						if($task_2['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_2_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=3 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_3 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_3['adminMod']."' LIMIT 1";
			
						$perf_3_name = "Неизвестно";
						if($task_3['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_3_name = $performer['name']." ".$performer['fname'];
						}
			
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=4 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_4 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_4['adminMod']."' LIMIT 1";
			
						$perf_4_name = "Неизвестно";
						if($task_4['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_4_name = $performer['name']." ".$performer['fname'];
						}
						
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=5 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_5 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_5['adminMod']."' LIMIT 1";
			
						$perf_5_name = "Неизвестно";
						if($task_5['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_5_name = $performer['name']." ".$performer['fname'];
						}
			?>
			<h4 class="new-line">Полная оплата поставки</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Предоплата поставки:</td>
                        <td><?php echo $perf_4_name.", ".$obj->deformat_date($task_4['dateModify']) ?></td>
                    </tr>
                    <td>Комментарии:</td>
                        <td>
						<?php echo $perf_1_name.": ". $task_1['comment'] ?>
                        <br>
                        <?php echo $perf_2_name.": ". $task_2['comment'] ?>
                        <br>
                        <?php echo $perf_3_name.": ". $task_3['comment'] ?>
                        <br>
                        <?php echo $perf_4_name.": ". $task_4['comment'] ?>
                        <br>
                        <?php echo $perf_5_name.": ". $task_5['comment'] ?>
                        <br>
                        <?php echo $perf_name.": ". $task['comment'] ?>
                        </td>
                    </tr>
                    <tr>
                    	<td>Внесена предоплата:</td>
                        <td><?php echo $order['pre_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>Дата и время прибытия:</td>
                        <td><?php echo $obj->deformat_date($order['date_arrive']) ?></td>
                    </tr>
                    <tr>
                    	<td>Описание машины:</td>
                        <td><?php echo $order['car_model'] ?></td>
                    </tr>
                    <tr>
                    	<td>Номер машины:</td>
                        <td><?php echo $order['car_num'] ?></td>
                    </tr>
                    <tr>
                    	<td>Оплата поставки:</td>
                        <td><?php echo $perf_name.", ".$obj->deformat_date($task['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Сумма оплаты:</td>
                        <td><?php echo $order['post_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			break;
			}
		case 7:{				// Прием товара
			if(!$task['status'])
			{
				//echo 'Прием товара';
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=2 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_2 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_2['adminMod']."' LIMIT 1";
			
						$perf_2_name = "Неизвестно";
						if($task_2['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_2_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=3 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_3 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_3['adminMod']."' LIMIT 1";
			
						$perf_3_name = "Неизвестно";
						if($task_3['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_3_name = $performer['name']." ".$performer['fname'];
						}
			
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=4 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_4 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_4['adminMod']."' LIMIT 1";
			
						$perf_4_name = "Неизвестно";
						if($task_4['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_4_name = $performer['name']." ".$performer['fname'];
						}
						
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=5 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_5 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_5['adminMod']."' LIMIT 1";
			
						$perf_5_name = "Неизвестно";
						if($task_5['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_5_name = $performer['name']." ".$performer['fname'];
						}
						
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=5 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_6 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_6['adminMod']."' LIMIT 1";
			
						$perf_6_name = "Неизвестно";
						if($task_6['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_6_name = $performer['name']." ".$performer['fname'];
						}
						
	$total_pos = 0;
	
	foreach($products as $pid)
	{	
		if($pid['shipped'] == $pid['quant']) $total_pos++;
	}
			?>
			<h4 class="new-line">Прием товара по заявке номер <b><?php echo $order['id'] ?></b></h4>
            
            <div class="clear"></div>
                      
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
            
            <input id="real_sum" type="hidden" name="sum" value="0">
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
            
            <div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-comment">Комментарии</label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-comment" class="my-field" 
 									   	placeholder="Ваш комментарий к приему товара" 
                        	        	name="comment"></textarea>
                			</div>
            			</div>
            
            <div class="clear"></div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <td>Комментарии:</td>
                        <td>
						<?php echo $perf_1_name.": ". $task_1['comment'] ?>
                        <br>
                        <?php echo $perf_2_name.": ". $task_2['comment'] ?>
                        <br>
                        <?php echo $perf_3_name.": ". $task_3['comment'] ?>
                        <br>
                        <?php echo $perf_4_name.": ". $task_4['comment'] ?>
                        <br>
                        <?php echo $perf_5_name.": ". $task_5['comment'] ?>
                        <br>
                        <?php echo $perf_6_name.": ". $task_6['comment'] ?>
                        </td>
                    </tr>
                    <tr>
                    	<td>Дата и время прибытия:</td>
                        <td><?php echo $obj->deformat_date($order['date_arrive']) ?></td>
                    </tr>
                    <tr>
                    	<td>Описание машины:</td>
                        <td><?php echo $order['car_model'] ?></td>
                    </tr>
                    <tr>
                    	<td>Номер машины:</td>
                        <td><?php echo $order['car_num'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			else
			{
				// echo 'Товар уже принят';
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=1 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_1 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_1['adminMod']."' LIMIT 1";
			
						$perf_1_name = "Неизвестно";
						if($task_1['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_1_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=2 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_2 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_2['adminMod']."' LIMIT 1";
			
						$perf_2_name = "Неизвестно";
						if($task_2['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_2_name = $performer['name']." ".$performer['fname'];
						}
						
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=3 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_3 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_3['adminMod']."' LIMIT 1";
			
						$perf_3_name = "Неизвестно";
						if($task_3['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_3_name = $performer['name']." ".$performer['fname'];
						}
			
			$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=4 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_4 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_4['adminMod']."' LIMIT 1";
			
						$perf_4_name = "Неизвестно";
						if($task_4['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_4_name = $performer['name']." ".$performer['fname'];
						}
						
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=5 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_5 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_5['adminMod']."' LIMIT 1";
			
						$perf_5_name = "Неизвестно";
						if($task_5['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_5_name = $performer['name']." ".$performer['fname'];
						}
						
				$query = "SELECT * FROM [pre]tasks WHERE `stock_order_id`='".$order['id']."' AND `type`=6 LIMIT 1";
			
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
				$task_6 = $_res[0];
				
				$query = "SELECT * FROM [pre]users WHERE `id`='".$task_6['adminMod']."' LIMIT 1";
			
						$perf_6_name = "Неизвестно";
						if($task_6['adminMod'] != '0')
						{
							$_stmt = $dbh->prepare($query);
							$_arr = $_stmt->execute();
		
							$_res = $_arr->fetchallAssoc();
							//echo '<pre>'; print_r($_res); echo '</pre>';
							
							$performer = $_res[0];
							$perf_6_name = $performer['name']." ".$performer['fname'];
						}
						
			?>
			<h4 class="new-line">Полная оплата поставки</h4>
            
            <div class="clear"></div>
                        
            <div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрихкод</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Цена</th>
                        <th class="main-t-th" style="">Сумма</th>
                    </div>
                    <tbody>
                    <?php
                    $cnt = 0;
					$total_summ = 0;
					foreach($products as $pr)
					{
						$cnt++;
						$total_summ += $pr['quant']*$pr['shop_price'];
						?>
						<tr class="<?php if($cnt%2 == 1) echo 'trcolor' ?>">
                        	<td><?php echo $pr['name'] ?></td>
                            <td><?php echo $pr['sku'] ?></td>
                            <td><?php echo $pr['code'] ?></td>
                            <td><?php echo $pr['quant'] ?></td>
                            <td><?php echo $pr['shop_price'] ?></td>
                            <td><?php echo $pr['quant']*$pr['shop_price'] ?></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </div>
            
            <table>
            	<tr>
                	<td>Всего позиций: </td> <td><?php echo $cnt ?></td>
                    <td>&nbsp;</td>
                    <td>Общая сумма: </td> <td><?php echo $total_summ ?></td>
                </tr>
            </table>
            
            <div class="clear"></div>
            	<h4 class="new-line">Счета и документация</h4>
                <div> ---- </div>
            <div class="clear"></div>
            
            <div class="clear"></div>
            	<h4 class="new-line">Информация</h4>
                <table>
                	<tr>
                    	<td>Автор:</td>
                        <td><?php echo $order['author'] ?></td>
                    </tr>
                    <tr>
                    	<td>Создан:</td>
                        <td><?php echo $obj->deformat_date($order['dateCreate']) ?></td>
                    </tr>
                    <tr>
                    	<td>Поставщик:</td>
                        <td><?php echo $order['supplier'] ?></td>
                    </tr>
                    <tr>
                    	<td>Предоплата поставки:</td>
                        <td><?php echo $perf_4_name.", ".$obj->deformat_date($task_4['dateModify']) ?></td>
                    </tr>
                    <td>Комментарии:</td>
                        <td>
						<?php echo $perf_1_name.": ". $task_1['comment'] ?>
                        <br>
                        <?php echo $perf_2_name.": ". $task_2['comment'] ?>
                        <br>
                        <?php echo $perf_3_name.": ". $task_3['comment'] ?>
                        <br>
                        <?php echo $perf_4_name.": ". $task_4['comment'] ?>
                        <br>
                        <?php echo $perf_5_name.": ". $task_5['comment'] ?>
                        <br>
                        <?php echo $perf_6_name.": ". $task_6['comment'] ?>
                        <br>
                        <?php echo $perf_name.": ". $task['comment'] ?>
                        </td>
                    </tr>
                    <tr>
                    	<td>Внесена предоплата:</td>
                        <td><?php echo $order['pre_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>Дата и время прибытия:</td>
                        <td><?php echo $obj->deformat_date($order['date_arrive']) ?></td>
                    </tr>
                    <tr>
                    	<td>Описание машины:</td>
                        <td><?php echo $order['car_model'] ?></td>
                    </tr>
                    <tr>
                    	<td>Номер машины:</td>
                        <td><?php echo $order['car_num'] ?></td>
                    </tr>
                    <tr>
                    	<td>Оплата поставки:</td>
                        <td><?php echo $perf_name.", ".$obj->deformat_date($task['dateModify']) ?></td>
                    </tr>
                    <tr>
                    	<td>Сумма оплаты:</td>
                        <td><?php echo $order['post_summ'] ?></td>
                    </tr>
                    <tr>
                    	<td>ID Поставки:</td>
                        <td><?php echo $order['id'] ?></td>
                    </tr>
                </table>
			<div class="clear"></div>
            <?php
			}
			break;
			}
		case 8:{				// Заказ с интернет магазина
			if(!$task['status'])
			{}
			else
			{}
			break;
			}
	}
	?>      <div id="order-data"></div>
            <div id="ajax-message"></div>
        
        <div id="preload_wrap" style="display:block;"></div>
    </div>
</body>
<script type="text/javascript" language="javascript">
	
	var cur_code = 0;

	$(function(){
		<?php
		switch($task['type'])
		{
			case 1:{
				if(!$task['status'])
				{
				?>
				$('#order_code').focus();
				$('#drop_task_button').hide();
				<?php
				}else
				{
				?>
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				<?php	
				}
				break;
				}
			case 2:{
				if(!$task['status'])
				{
				?>
				$('#form_task_button').html('Отправить заявку');
				$('#form_task_button').attr('title','Отправить заявку');
				$('#form_task_button').show();
				$('#drop_task_button').show();
				<?php
				}else
				{
				?>
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				<?php	
				}
				break;
				}
			case 3:{
				if(!$task['status'])
				{
				?>
				$('#form_task_button').html('Отправить');
				$('#form_task_button').attr('title','Отправить заявку');
				$('#form_task_button').show();
				$('#drop_task_button').hide();
				<?php
				}else
				{
				?>
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				<?php	
				}
				break;
				}
			case 4:{
				if(!$task['status'])
				{
				?>
				$('#form_task_button').html('Отправить');
				$('#form_task_button').attr('title','Отправить заявку отметив как предоплаченная');
				$('#form_task_button').show();
				$('#drop_task_button').hide();
				<?php
				}else
				{
				?>
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				<?php	
				}
				break;
				}
			case 5:{
				if(!$task['status'])
				{
				?>
				$('#form_task_button').html('Отправить поставку');
				$('#form_task_button').attr('title','Отправить');
				$('#form_task_button').show();
				$('#drop_task_button').hide();
				<?php
				}else
				{
				?>
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				<?php	
				}
				break;
				}
			case 6:{
				if(!$task['status'])
				{
				?>
				$('#form_task_button').html('Отправить');
				$('#form_task_button').attr('title','Отправить заявку');
				$('#form_task_button').show();
				$('#drop_task_button').hide();
				<?php
				}else
				{
				?>
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				<?php	
				}
				break;
				}
			case 7:{
				if(!$task['status'])
				{
				?>
				$('#get_order_button').show();
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				
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
			
			}else
				{
				?>
				$('#form_task_button').hide();
				$('#drop_task_button').hide();
				<?php	
				}
				break;
				}
			default: break;
		}
		
		if($is_busy)
		{
			?>
			$('#form_task_button').attr('onclick','');
			$('#form_task_button').html('Задание сейчас выполняет <?php echo $busy_name ?>');
			
			$('#get_order_button').hide();
			$('#drop_task_button').hide();
			$('#form_task_button').show();
			<?php
		}
		?>
		});
		
	function form_task()
	{
		var comment = $('#save-comment').val();
		
		var pre_summ = $('#save-pre-summ').val();
		if(pre_summ == 'undefined' || pre_summ == null) pre_summ = 0;
		
		var date_arrive = $('#save-date-arrive').val();
		if(date_arrive == 'undefined' || date_arrive == null) date_arrive = 0;
		
		var car_model = $('#save-car-model').val();
		if(car_model == 'undefined' || car_model == null) car_model = 0;
		
		var car_num = $('#save-car-num').val();
		if(car_num == 'undefined' || car_num == null) car_num = 0;
		
		var post_summ = $('#save-post-summ').val();
		if(post_summ == 'undefined' || post_summ == null) post_summ = 0;
		
		var data = { id:<?php echo $id ?>, order_id:<?php echo $order['id'] ?>, comment:comment, type:<?php echo $task['type'] ?>, 
					 pre_summ: pre_summ, date_arrive: date_arrive, car_model: car_model, car_num: car_num, post_summ: post_summ }
		$('#ajax-message').load('<?php echo WP_FOLDER."ajax/load/form_task.php" ?>',data,function(){
			});
	}
	
	
	function enter_code(code)
	{
		cur_code = code;
		
		$('#ajax-message').html('Проверка...');
		var data = { order_id:<?php echo $order['id'] ?>,code:code }
		$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/enter-stock-code.php',data,function(){
				$('#enter_code').attr('value','');
			});
	}
	
	function set_shelf_full()
	{
		$('#ajax-message').html('Обновление ячейки...');
		var data = { order_id:<?php echo $order['id'] ?>,code:cur_code,fullness:2 }
		$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/change-stock-code-shelf.php',data,function(){
				$('#enter_code').attr('value','');
				$('#enter_code').focus();
			});
	}
	
	function set_shelf_no_empty()
	{
		$('#ajax-message').html('Обновление ячейки...');
		var data = { order_id:<?php echo $order['id'] ?>,code:cur_code,fullness:1 }
		$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/change-stock-code-shelf.php',data,function(){
				$('#enter_code').attr('value','');
				$('#enter_code').focus();
			});
	}
	
	function get_order()
	{
		if(!$('#get_order_button').hasClass('nonactive'))
		{
			var comment = $('#save-comment').val();
			var task_id = <?php echo $id ?>;
			
				$('#ajax-message').html('Обновление данных...');
				var data = { order_id:<?php echo $order['id'] ?>, comment:comment, task_id: task_id }
				$('#ajax-message').load('http://www.zencosmetics.com.ua/wpmanager/split/ajax/heandlers/change-stock-order.php',data,function(){
					});
		}
	}
	
	function unset_task_admin_ref()
	{
		$('#unset_task_admin_ref_wrap').load('<?php echo WP_FOLDER."ajax/heandlers/unset_task_admin_ref.php" ?>');
	}
</script>

</html>