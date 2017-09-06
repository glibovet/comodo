<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumbs fixclear">
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?=RS.LANG?>/" title="<?=MNAME?>">
                        	<span itemprop="name"><?=MNAME?></span>
        					<meta itemprop="position" content="1">
                        </a>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <?php 
						$trName = "";
						$i=0;
						foreach ($site_translate as $translate) { 
							if ($translate['ru_text'] == "Каталог") {
								$i++; 
								if ($i==1 ) {
									$trName = $translate['text'];
								}
							} 
						}?>
                        <a itemprop="item" href="<?=RS.LANG?>/catalog/" title="<?=$trName?>">
                        	<span itemprop="name"><?=$trName?></span>
        					<meta itemprop="position" content="2">
                        </a>
                    </li>
                    <?php 
						$i = 0;
						$href = "".RS.LANG."/catalog/";
						
						foreach ($breadCr as $bread) {
						$i++;
						$href .= $bread['alias']."/";
						if ($i >= count($breadCr)) {
							$href = "";
							}
						?>
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" title="<?=$bread['name']?>" href="<?=$href ?>">
                                <span itemprop="name"><?=$bread['name']?></span>
                                <meta itemprop="position" content="<?=$i+2?>">
                            </a>
                        </li>
					<?php }?>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="catalog">
		<div class="container">
			<div class="row">
            
				<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
					<?php include_once 'filters.php';?>
				</div>
                
				<div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
					<div class="catalog__caption">
						<h1>                        
                        <?php 
						$dopH1 = "";
						if ($f_page_num >= 2) { 
							$i=0;
							foreach ($site_translate as $translate) { 
								if ($translate['ru_text'] == "Страница") {
									$i++; 
									if ($i==1 ) {
										$dopH1 = " - ".$translate['text']." №".$f_page_num;
									}
								} 
							} 
						}?>
                        
						<?=$catName.$dopH1?>
                        </h1>
						<p class="catalog__caption-result"><?php $i=0; foreach ($site_translate as $translate){					
						if ($translate['ru_text'] == "результатов") {
							$i++;
							if ($i==1 ) {
								echo $translate['text'];
								}
							}?>    
						<?php }?> <span id="prodsTotalRows"><?=$f_total_rows?></span></p>
					</div>
					<div class="catalog__sorting">
						<button type="button" class="catalog__view-btn1" onClick="reloadProdsColumn(2);"></button>
						<button type="button" class="catalog__view-btn2" onClick="reloadProdsColumn(3);"></button>
						<div class="catalog__sorting-price hidden">
							<span><?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "Цена") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?></span>
							<select onChange="reloadPriceLine(this.value);">
								<option value="asc" <?php if(PRICE_LINE == ""){echo "selected";}?>>
									<?php $i=0; foreach ($site_translate as $translate){					
                                    if ($translate['ru_text'] == "По возростанию") {
                                        $i++;
                                        if ($i==1 ) {
                                            echo $translate['text'];
                                            }
                                        }?>    
                                	<?php }?>
                                </option>
								<option value="desc" <?php if(PRICE_LINE == "DESC"){echo "selected";}?>>
                                	<?php $i=0; foreach ($site_translate as $translate){					
                                    if ($translate['ru_text'] == "По убиванию") {
                                        $i++;
                                        if ($i==1 ) {
                                            echo $translate['text'];
                                            }
                                        }?>    
                                	<?php }?>
                                </option>
							</select>
						</div>
						<div class="catalog__sorting-view margin-left0">
							<span><?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "Вид") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?></span>
							<select onChange="reloadProdsQty(this.value, '<?=CURR_URL?>');"> 
								<option value="12" <?php if(PR_QTY == 12){echo "selected";}?>>12</option>
								<option value="18" <?php if(PR_QTY == 18){echo "selected";}?>>18</option>
								<option value="24" <?php if(PR_QTY == 24){echo "selected";}?>>24</option>  
                                
							</select>
						</div>
						<div class="catalog__page">
                        
                        	<span class="catalog__page-title"><?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "Страница") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?></span>                            
                            <?php if ($f_page_num >= 2){?> 
								<button type="button" class="catalog__prev-page" onClick="goCatalogPage(<?=$f_page_num-1?>);"></button>
                            <?php }?>
							<input class="catalog__page-number" type="number" id="currPageInput" value="<?=$f_page_num?>" onChange="goCatalogPage(this.value);" />
							<span class="catalog__page-sum"><?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "из") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?> <count id="pagTotalCount"><?=$f_pages_count?></count></span>
                            <?php if ($f_page_num < $f_pages_count){?> 
								<button type="button" class="catalog__next-page" onClick="goCatalogPage( ( parseInt($('#currPageInput').val()) + 1 ) );"></button>
                            <?php }?>
						</div>
					</div>
					<div class="catalog__inner <?=PR_COLUMN?>-column">
                    
                        <div id="ajaxProducts">
                            <div class="the_products">
                    
						<?php if(!$prodList){?>
							<h3 class="center col-red"><?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "Не найдено товаров по заданному фильтру") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?></h3>
					    <?php }
						else{
						foreach ($prodList as $prodItem){ 
							$formatProdPrice = number_format($prodItem['price'], 0, '.', '.');								
							$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', '.');								
							$prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";
							$prodIcon = "";
							$prodIconTxt = "";
							if ($prodItem['sale_id']){ $prodIcon = "discount"; $prodIconTxt = "%";}
							elseif ($prodItem['new_id']){ $prodIcon = "new"; $prodIconTxt = "new";}
							elseif ($prodItem['delivery']){ $prodIcon = "delivery"; $prodIconTxt = "";}?>
                            
                        	<!-- PROD ITEM -->
                            <div class="catalog__item" id="list_prod_<?=$prodItem['id']?>">
                                <a href="<?=$prodUrl?>" onclick="mainScript.addToView(<?=$prodItem['id']?>);">
                                    <?php if ($prodItem['img']){
										echo $this->Html->image(CIMG.$prodItem['img'], ['alt' => $prodItem['name']]);
									}else{
										echo $this->Html->image("noimage.png", ['alt' => "NO IMAGE"]);
									}?>
                                    <div class="catalog__descr">
                                        <div class="catalog__see-more">
                                            <p><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Смотреть подробнее") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
                                        </div>
                                        <div class="catalog__descr-param">
                                            <p class="catalog__descr-name"><?=$prodItem['obj_name']?></p>
                                            <p class="catalog__descr-value"><?=$prodItem['name']?></p>
                                        </div>
                                        <div class="catalog__descr-param">
                                            <p class="catalog__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Фабрика") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
                                            <p class="catalog__descr-value"><?=$prodItem['mf_name']?></p>
                                        </div>
                                        <?php if($prodItem['price']){?>
                                            <div class="catalog__descr-param hidden">
                                                <p class="catalog__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
													if ($translate['ru_text'] == "Цена") {
														$i++;
														if ($i==1 ) {
															echo $translate['text'];
															}
														}?>    
												<?php }?></p>
                                                <p class="catalog__descr-value"><?=$formatProdPrice?> <?=CURNAME?></p>
                                            </div>
                                        <?php }?>
                                    </div>
                                </a>
                            </div>
                            <!-- /PROD ITEM -->
                         <?php }
						 } ?>
                         
                         </div>
                    </div>
                <div class="clear"></div>
                        
					</div>
					<div class="catalog__pagination" id="productsNavi">
                    	<?php include_once 'pagination.php';?>
					</div>
				</div>
			</div>
		</div>
	</section>
    
<?php if ($category['details'] && $showSeo && LANG == "ru"){?>
<section class="seo">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="main-article">
					<?=$category['details']?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php }?>
