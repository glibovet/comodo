<div class="tab-content" id="history">
    <p class="title"><span class="number">Заказ</span><span class="count">Количество</span><span class="price">Цена</span><span class="status">Статус</span></p>
     <?php foreach ($userOrders as $order) { 
		$prodSum = "";
		$prodQty = "";
		$order_num = 5000 + $order['id'];
		
		$products  = unserialize($order['products']);	// Список товаров в заказе
		foreach ($products as $product) { 
		$prodSum += ($product[''.RATE_PREFIX.'price']*$product['quant']);
		$prodQty += $product['quant']; 
		$formatProdSum = number_format($prodSum, 0, '.', '.');
		
		$dopStatusClass = "yes"; $dopStatusHtml = "Подтвержден";
		$dopStatusClass2 = "not"; $dopStatusHtml2 = "Не проведен";
		if ($order['status'] <= 1) {$dopStatusClass = "not"; $dopStatusHtml = "Не подтвержден";} 
		if ($order['status'] == 5) {$dopStatusClass = "not"; $dopStatusHtml = "Отменен";} 
		if ($order['status'] == 4) {$dopStatusClass2 = "yes"; $dopStatusHtml2 = "Проведен";} 
		} ?>
        <!-- item -->
        	<div class="item">
                <div class="number-wrap">
                    <a href="/personal/<?php echo $order_num ?>/">№<?php echo $order_num ?></a>
                    <p>от <?php echo date("d.m.Y",strtotime($order['dateCreate'])) ?></p>
                </div>
                <div class="count-wrap">
                    <div class="count"><?php echo $prodQty ?></div>
                </div>
                <p class="price"><?php echo $formatProdSum ?> <?= CURNAME ?></p>
                <div class="status-wrap">
                    <p class="status">
                        <span class="<?=$dopStatusClass?>"><?=$dopStatusHtml?></span>
                    </p>
                    <p class="status">
                        <span class="<?php if($order['paid_status'] == "Оплачен"){echo "yes";} else{echo"not";}?>"><?= $order['paid_status'] ?></span><br>
                        <span class="<?=$dopStatusClass2?>"><?=$dopStatusHtml2?></span>
                    </p>
                </div>
            </div>
		<!-- /item -->
	<?php }?>
</div>