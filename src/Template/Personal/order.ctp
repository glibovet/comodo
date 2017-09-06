<?php  
	$prodSum = "";
	$order_num = 5000 + $order['id'];
	
	$products  = unserialize($order['products']);	// Список товаров в заказе
	
	$dopStatusClass = "yes"; $dopStatusHtml = "Подтвержден";
	$dopStatusClass2 = "not"; $dopStatusHtml2 = "Не проведен";
	$display = "none";
	if ($order['status'] <= 1) {$dopStatusClass = "not"; $dopStatusHtml = "Не подтвержден"; $display = "block";} 
	if ($order['status'] == 5) {$dopStatusClass = "not"; $dopStatusHtml = "Отменен";} 
	if ($order['status'] == 4) {$dopStatusClass2 = "yes"; $dopStatusHtml2 = "Проведен";} 
 ?>    
    <section class="banner">
            <h1>Личный <span>кабинет</span></h1>
    </section>
    
    <section class="bread-crumbs">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-20 col-lg-offset-4 col-md-18 col-md-offset-6 col-sm-18 col-sm-offset-6 col-xs-24 col-xs-offset-0">
                    <ul>
                        <li><a href="/">Главная</a></li>
                        <li><a href="<?=RS.FA?>/">| Личный кабинет</a></li>                        
                        <li><a href="">| Заказ №<?=$order_num?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

	<section class="data-and-history" style="padding-top: 0;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-lg-offset-6 col-md-16 col-md-offset-4 col-sm-20 col-sm-offset-2 col-xs-24 col-xs-0">
					<div class="tabs" id="data-and-history">		                                           
                        <div class="tab-content active" id="history">
                            <div class="order-preview">
                                <div class="order-info">
                                    <p class="number-and-date">Заказ <span class="number">№<?=$order_num?></span><span class="date"> от <?php echo date("d.m.Y",strtotime($order['dateCreate'])) ?></span></p>
                                    <p class="status">
                                    <span class="<?=$dopStatusClass?>"><?=$dopStatusHtml?></span>
                                    <span class="<?php if($order['paid_status'] == "Оплачен"){echo "yes";} else{echo"not";}?>"><?= $order['paid_status'] ?></span>
                                    <span class="<?=$dopStatusClass2?>"><?=$dopStatusHtml2?></span>
                                    </p>
                                </div>
                                <p class="order-preview-title"><span class="model">Модель</span><span class="price">Цена</span><span class="count">Количество</span></p>
                                <?php foreach ($products as $product) { 
									$prodSum += ($product[''.RATE_PREFIX.'price']*$product['quant']);
									$formatProdPrice = number_format($product['price'], 0, '.', '.');?>
                                    
									<div class="order-item">
										<?= $this->Html->image(CIMG.$product['img'], ['alt' =>$product['name']]);?>
										<div class="model">
											<h6><?= $product['name']?></h6>
											<i class="size"><?= $product['size']?></i>
											<p class="code">код: <?= $product['sku']?></p>
										</div>
										<p class="price"><?= $formatProdPrice ?> <?= CURNAME ?></p>
										<p class="count"><span><?= $product['quant'] ?></span></p>
									</div>
								<?php } 
								$formatProdSum = number_format($prodSum, 0, '.', '.');?>
                                
                                <div class="sum-and-cancel">
                                    <p class="sum">Общая сумма:   <span><?= $formatProdSum ?> <?= CURNAME ?></span></p>
                                    <button type="button" style="display:<?=$display?>" onClick="mainScript.callOffOrder(<?= $order['id'] ?>);">отменить заказ</button>
                                </div>                                
            					<p class="response clear"></p>
                                
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>