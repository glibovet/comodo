<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<ul>
					<li><a href="<?=RS.LANG?>/"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Главная") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a></li>
					<li><a href="#"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Блокнот") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?>. <?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Запрос цены") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="notebook-inner">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="notebook-inner__caption">
					<p><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Блокнот") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?>. <?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Запрос цены") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
				</div>
				<form action="#" id="orderForm" class="notebook-inner__table">
					<div class="notebook-inner__table-caption">
						<p class="notebook-inner__table-caption-descr"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Описание") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
						<p class="notebook-inner__table-caption-photo"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Фото") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
						<p class="notebook-inner__table-caption-count"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Количество") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
						<p class="notebook-inner__table-caption-name"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Цена со скидкой") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?> €</p>
						<p class="notebook-inner__table-caption-name"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Сумма") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?> €</p>
						<p class="notebook-inner__table-caption-name"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Срок поставки") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
						<p class="notebook-inner__table-caption-notes"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Примечание") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
					</div>
                    <?php if ($cartList){
						foreach($cartList as $cartItem){?>
                        <div class="notebook-inner__table-item" id="cart-item-<?= $cartItem['id'] ?>">
                            <p class="notebook-inner__table-item-descr"><span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Описание") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></span>
                            <?=$cartItem['obj_name']?> <?=$cartItem['prod_name']?>;<br>
                            <?=$cartItem['mf_name']?>: <?=$cartItem['mf_country']?>;<br>
                            <?php if ($cartItem['prod_height']){echo $cartItem['prod_height'];}?> <?php if ($cartItem['prod_width']){echo "x ".$cartItem['prod_width'];}?>  <?php if ($cartItem['prod_depth']){echo "x ".$cartItem['prod_depth'];}?><br>                       
                            <?php if ($cartItem['color']){?>
                            	<?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Цвет") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?>: <?=$cartItem['color']."<br>"?>;
                            <?php }?>
							<?php if ($cartItem['chars']){
								foreach($cartItem['chars'] as $char){?>
                            		<?=$char['char_name']?>: <?=$char['char_value']?>;<br>
                            	<?php }?>
                            <?php }?>
                            </p>
                            <a class="hcart_img" href="<?= RS.LANG ?>/catalog/product/<?= $cartItem['prod_alias'] ?>/">
								<?= $this->Html->image(CIMG.$cartItem['prod_crop'], ['alt' => $cartItem['prod_name']]); ?>
                            </a>
                            <div class="notebook-inner__table-count count">
                                <span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Количество") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></span>
                                <button type="button" class="minus"></button>
                                <input type="number" value="<?= $cartItem['quant'] ?>" class="value" onChange="mainScript.changeProdQty(<?= $cartItem['id'] ?>, this.value, <?= $cartItem['prod_id'] ?>);">
                                <button type="button" class="plus"></button>
                            </div>
                            <p class="notebook-inner__table-name"><span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Цена со скидкой") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?> €</span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "По запросу") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
                            <p class="notebook-inner__table-name"><span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Цена со скидкой") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?> €</span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "По запросу") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
                            <p class="notebook-inner__table-name"><span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Срок поставки") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></span><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Уточняется") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
                            <span class="notebook-inner__textarea-caption"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Примечание") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></span>
                            <textarea onChange="mainScript.cartProdComment(<?= $cartItem['id'] ?>, this.value);"><?= $cartItem['comment'] ?></textarea>
                            <button class="notebook-inner__table-remove" type="button" onClick="mainScript.delCartProd(<?= $cartItem['id'] ?>);"></button>
                        </div>
                    <?php }
					}?>
					<hr>
					<div class="notebook-inner__table-result hidden">
						<p><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Итого") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?>:</p>
						<p><span id="cartPageSum"><?=$formatCartSum?></span> <?=CURNAME?></p>
					</div>
                    <div class="response"></div>
					<a href="#send-request" type="button" class="notebook-inner__submit"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отправить запрос") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>
				</form>
			</div>
		</div>
	</div>
</section>