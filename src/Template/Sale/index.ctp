        <!-- CONTENT -->
        <section>
            <div class="container">
    
                <!-- options -->
                <div class="row shop-top-options">
    
                    <div class="col-sm-12 col-md-12 center">
    
    
                        <h2 class="p-name-h2">
                        	
                        	<span class="p-name-txt">
                                <span class="p-name-top"></span>                                                           
									<?php if (LANG_PREFIX == "en_") { echo "Outlet";}
                                    elseif (LANG_PREFIX == "ua_") { echo "Outlet";}
                                    else { echo "Outlet";}
                                    ?>
                                <span class="p-name-bot"></span>
                            </span>
                            
                        </h2>
    
                    </div>
                </div>
                <!-- /options -->
                
                <div class="row">           	
                    
                    <!-- PRODUCT LIST -->
                    <div class="col-md-12">
    
                        <div class="row">
        
                            <?php
                             foreach ($saleList as $prodItem){ 
							 	$formatProdPrice = number_format($prodItem['price'], 0, '.', ' ');								
							 	$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', ' '); ?>
                                
                                <div class="col-md-4 col-sm-4" id="prod<?= $prodItem['prod_id']; ?>"> <!-- item -->
                                    <div class="prod_icons">
                                    	<?php if ($prodItem['sale_id']){?>                                        	
                                            <div class="prod_icons_item prod_icon_sale"><span>- <?=$prodItem['sale']?></span></div>
                                       <?php }elseif ($prodItem['new_id']){?>
                                            <div class="prod_icons_item prod_icon_new"></div>
                                        <?php } ?>
                                    </div>
                                    
                                    <a class="shop-item-list" href="/catalog/product/<?=$prodItem['alias']?>/">
                                    
                                        <figure class="backface"><!-- image -->
                                            <span class="face"><?= $this->Html->image(''.CIMG.$prodItem['prod_img1'].'', ['class'=>'img-responsive']); ?></span>
                                            <span class="face back"><?= $this->Html->image(''.CIMG.$prodItem['prod_img2'].'', ['class'=>'img-responsive']); ?></span>
                                        </figure><!-- /image -->
                                    </a>
                                    
                                    <div class="list-prod-info"><!-- title and price -->
                                            <div class="list-prod-like">
                                                <button type="button" class="<?php if ($prodItem['prod_like']){echo "active";} ?> <?=$prodItem['prod_like']?>" onclick="mainScript.addToLike(<?=$prodItem['prod_id']?>, '<?=$prodItem['alias']?>');"></button>
                                            </div>
                                            <div class="list-prod-txt">
                                                <div class="p-item-response"></div>
                                                <div class="list-prod-name"><?=$prodItem['name']?></div>
                                                <?php if ($prodItem['sale_price']){?>
                                                    <div class="list-price-block">
                                                        <div class="list-price bold_font"><?=$formatProdPrice ?> <span><?= CURNAME ?></span></div> 
                                                        <div class="list-price line-through"><?=$formatProdPriceSale ?> <span><?= CURNAME ?></span></div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="list-price-block">
                                                        <div class="list-price bold_font"><?=$formatProdPrice ?> <span><?= CURNAME ?></span></div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                    </div><!-- /title and price -->
                                    
                                </div><!-- /item -->
                            <?php } ?>
                        
                        </div>
                    
                    </div><!-- /PRODUCT LIST -->
                </div>
            </div>
          
        </section>