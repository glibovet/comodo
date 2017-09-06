<section class="banner">
		<h1>Список <span>избранного</span></h1>
	</section>

	<section class="bread-crumbs">
		<div class="container">
			<div class="row">
				<ul>
					<li><a href="<?= RS ?>">Главная</a></li>
					<li><a href="#">| Список избранного</a></li>
				</ul>
			</div>
		</div>
	</section>

	<section class="selected">
		<div class="container-fluid">
			<div class="row">
            	
            	<div class="empty_cart" id="emptyCartPage"> 
					<?php if (!$likeList) {?>                       
						<?php if (LANG_PREFIX  == "en_") 
                        {echo "LIST &quotFAVORITES&quot EMPTY";}
                        elseif (LANG_PREFIX  == "ua_") 
                        {echo "СПИСОК &quotОБРАНЕ&quot ПОРОЖНІЙ";}
                        else {echo "СПИСОК &quotИЗБРАННОЕ&quot ПУСТ";}
					 }?>
			  	</div>
                <?php if ($likeList) {
					foreach ($likeList as $prodItem){
					$formatProdPrice = number_format($prodItem['price'], 0, '.', '.');								
					$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', '.');
					$prodIcon = "";
					$prodIconTxt = "";
					if ($prodItem['sale_id']){ $prodIcon = "discount"; $prodIconTxt = "%";}
					elseif ($prodItem['new_id']){ $prodIcon = "new"; $prodIconTxt = "new";}
					elseif ($prodItem['delivery']){ $prodIcon = "delivery"; $prodIconTxt = "";}?>
                    
                    <div class="catalog-item col-md-4 col-sm-4" id="prod<?=$prodItem['id']?>">
                        <div class="photo">
                        	<?= $this->Html->image(''.CIMG.$prodItem['prod_img1'].'', ['alt'=> $prodItem['name']]); ?>
                            <span class="<?=$prodIcon?>"><?=$prodIconTxt?></span>
                            <div class="view">
                                <a href="/catalog/product/<?=$prodItem['alias']?>/">Смотреть</a>
                            </div>
                        </div>
                        <div class="catalog-item-bottom">
                            <div class="descr">
                                <p class="name"><?=$prodItem['name']?></p>
                                <p class="price"><?=$formatProdPrice?> <span><?= CURNAME ?></p>
								<?php if($prodItem['sale_price']) {?>
                                    <p class="old-price"><?=$formatProdPriceSale?> <?=CURNAME?></p>
                                <?php }?>
                            </div>
                            <div class="like-wrap"><span class="like" onclick="mainScript.delFromLike(<?=$prodItem['id']?>);"></span></div>
                        </div>
                    </div>
                    
                <?php }
				} ?>
			</div>
		</div>
	</section>