							
							<div class="masonry-grid-fitrows row grid-space-20 products-list" id="products_body" style="min-height: 220px; position: relative;">
									<?php 
                                        $group_classes = array(
										'1' => 'purple',
										'2' => 'orange',
										'3' => 'red',
										'4' => 'green',
										'5' => 'blue'
										);
									//echo "<pre>"; print_r($prodList[0]); echo "</pre>";

									foreach ($prodList as $item) {
										
										$product_id = $item['id'];
								
										$curr_link = SELF_LINK . $item['alias'] . '/';
                                        
                                        $price = ( !$item['sale_price'] ?  $item['price'] :  $item['sale_price'] );
										$old_price = ( $item['sale_price'] ?  $item['price'] :  0 );
                                        
                                        if(!$price)
                                        {
                                            if($item['usd_price'])
                                            {
                                                $price = $item['usd_price']*USD_EX;
                                            }
                                            elseif($item['eur_price'])
                                            {
                                                $price = $item['eur_price']*EUR_EX;
                                            }
                                        }
                                        
                                        $price = number_format($price, 0, '.', ' ');
										?>
                                        
										<div class="col-md-4 col-sm-6 masonry-grid-item">
                                            <div class="listing-item">
                                            <?php
											if($item['product_groups'])
											{
												?>
												<a href="<?php echo $curr_link ?>" class="ribbon rib-<?php echo $group_classes[$item['product_groups'][0]['group_id']] ?>"><span class="<?php echo $group_classes[$item['product_groups'][0]['group_id']] ?>"><?php echo $item['product_groups'][0]['title'] ?></span></a>
												<?php
											}
											?>
                                            
                                         	<div class="col-md-3 prod_l_icons"><br>
												<?php
                                                    if($item['free_delivery'])
                                                    {
                                                        ?>
                                                        <div class="prod_free_delivery" title="Бесплатная доставка"></div>
                                                        <?php
                                                    }
                                                    
                                                    if($item['pres_id'])
                                                    {
                                                        ?>
                                                        <div class="prod_present" title=" Есть подарок"></div>
                                                        <?php
                                                    }
                                                    
                                                    elseif($item['sert_id'])
                                                    {
                                                        ?>
                                                        <div class="prod_sert_present" title=" Сертификат в подарок"></div>
                                                        <?php
                                                    }   
                                                ?>
                                            </div> 
                                                <div class="overlay-container">
                                                    <a href="<?php echo $curr_link ?>" class="" title="Перейти к просмотру"><img src="<?php echo PRODUCT_CROP_PATH.$item['file'] ?>" alt=""></a>
                                                </div>
                                                <div class="listing-item-body clearfix">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="title"><a href="<?php echo $curr_link ?>"><?php echo $item['name'] ?></a></h3>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php // <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae tempora debitis, sed illo officiis.</p> ?>
                                                    <div class="row" style="min-height:55px;">
                                                        <div class="col-md-<?php echo ($price ? '5' : '6') ?>" style=" <?php echo ($old_price ? "margin-top:-15px;" : "margin-top:7px;") ?>">
                                                                    <?php 
                                                                    if(!$price)
                                                                    {
                                                                        ?>
                                                                        <span class="price" style="font-size:16px;"><span class="small">Цену уточняйте</span></span>
                                                                        <?php
                                                                    }else
                                                                    {
                                                                        ?>
                                                                        <span class="price" style="font-size:17px;"><?php echo ($old_price ? "<span class='throught'>".$old_price."</span><br> ".$price : $price) ?> <span class="small">грн</span></span>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </div>
                                                        <div class="col-md-<?php echo ($price ? '3' : '6') ?>">
                                                                <center>
                                                                <a id="whish-<?php echo $item['id'] ?>" href="javascript:void(0)" onclick="toWhishList(<?php echo ($item['wish_id'] ? 0 : $item['id']) ?>);" 
                                                                    class="wishlist"
                                                                    title="wishlist"><i class="fa fa-heart<?php echo ($item['wish_id'] ? '' : '-o') ?>"></i></a>
                                                                </center>
                                                                <center>
                                                                <a id="compare-<?php echo $item['id'] ?>" 
                                                                    href="javascript:void(0)" onclick="toCompare(<?php echo ($item['comp_id'] ? 0 : $item['id']).",".$cat_id ?>);" 
                                                                    class="equals"><i class="fa fa-balance-scale"></i></a>
                                                                </center>
                                                                
                                                        </div>
                                                        <?php 
														if($price)
														{
														?>
                                                        <div class="col-md-4">
                                                            <span class="pull-right cart-buy-<?php echo $product_id ?>" style="margin-top:10px; font-size:14px;">
                                                                <a href="javascript:void(0);" onclick="add_product_to_cart(<?php echo $product_id ?>);">
                                                                    <?php 
                                                                        echo 
                                                                        (isset($item['quant_in_cart']) && $item['quant_in_cart']
                                                                        ? 
                                                                        '<i class="fa fa-check"></i> В корзине</button>'
                                                                        : 
                                                                        '<i class="fa fa-shopping-cart"></i> Купить</button>'
                                                                        ); 
                                                                    ?></a>
                                                            </span>
                                                        </div>
                                                        <?php 
														}
														?>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="addProdInfo">
        
                                                    <div class="hovTop"></div>
                                                    <div class="hovLeft"></div>
                                                    <div class="hovRight"></div>
                                                    <div class="hovBottom"></div>
                                                    
                                                    <br>
                                                    
                                                    <ul>
                                                    <?php
                                                    foreach($item['product_chars'] as $char)
                                                    {
                                                        ?><li><?php echo "<b>".$char['name']."</b>: ".$char['value2'] ?></li><?php
                                                    }
                                                    ?>
                                                    </ul>
                                                    <div class="clear"></div>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
									<?php
									}

								?>

							</div>
							<!-- /PRODUCT LIST -->