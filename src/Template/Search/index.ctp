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
                                            if ($translate['ru_text'] == "Поиск") {
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

<section class="news__wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            	<h1 class="news__caption"><?php $i=0; foreach ($site_translate as $translate){					
					if ($translate['ru_text'] == "Результаты поиска") {
						$i++;
						if ($i==1 ) {
							echo $translate['text'];
							}
						}?>    
				<?php }?>: <?= SEARCH ?></h1>
            </div>
    	</div>
        
        <div class="tabs" id="description-and-reviews">
            <div class="tab-button-wrap">
                <p class="tab-button active" data-tab="description">
					<?php $i=0; foreach ($site_translate as $translate){					
                        if ($translate['ru_text'] == "Каталог") {
                            $i++;
                            if ($i==1 ) {
                                echo $translate['text'];
                                }
                            }?>    
                    <?php }?>
                </p>
                <p class="tab-button" data-tab="reviews">
					<?php $i=0; foreach ($site_translate as $translate){					
                        if ($translate['ru_text'] == "Новости") {
                            $i++;
                            if ($i==1 ) {
                                echo $translate['text'];
                                }
                            }?>    
                    <?php }?>
                </p>
            </div>
            <div class="tab-content active padding-top40" id="description">                    
                <?php if (!$searchProds) {?>
                    <div class="empty_cart" id="emptySearchProds">
						<?php $i=0; foreach ($site_translate as $translate){					
                            if ($translate['ru_text'] == "Нет результатов по данному запросу") {
                                $i++;
                                if ($i==1 ) {
                                    echo $translate['text'];
                                    }
                                }?>    
                        <?php }?>
                    </div>
                <?php }
                else {
                    foreach ($searchProds as $prodItem){
                    $formatProdPrice = number_format($prodItem['price'], 0, '.', '.');								
					$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', '.');								
					$prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";
					$prodIcon = "";
					$prodIconTxt = "";
					if ($prodItem['sale_id']){ $prodIcon = "discount"; $prodIconTxt = "%";}
					elseif ($prodItem['new_id']){ $prodIcon = "new"; $prodIconTxt = "new";}
					elseif ($prodItem['delivery']){ $prodIcon = "delivery"; $prodIconTxt = "";}?>
					
					<!-- PROD ITEM -->
					<div class="catalog__item col-md-4 col-sm-4" id="list_prod_<?=$prodItem['id']?>">
						<a href="<?=$prodUrl?>" onclick="mainScript.addToView(<?=$prodItem['id']?>);">
							<?= $this->Html->image(CIMG.$prodItem['img'], ['alt' => $prodItem['name']]); ?>
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
            <div class="tab-content padding-top40" id="reviews">            
                <div class="empty_cart" id="emptyCartPage"></div>
                
                <section class="blog">
					<?php if (!$searchArticles) {?>
                        <div class="empty_cart" id="emptySearchArts">
                            <?php $i=0; foreach ($site_translate as $translate){					
                                if ($translate['ru_text'] == "Нет результатов по данному запросу") {
                                    $i++;
                                    if ($i==1 ) {
                                        echo $translate['text'];
                                        }
                                    }?>    
                            <?php }?>
                        </div>
                    <?php }
                                                        
                    if ($searchArticles) {
                        foreach ($searchArticles as $k => $news){
                        $typeIcon = "text";
                        if ($news['video']){ $typeIcon = "video"; }
                        if ($news['gallery_id']){ $typeIcon = "photo"; }
                        if ($k >= 0){
                        $itemPos = "right";
                        if ($k % 2 == 0) {$itemPos = "left";}?>
                        
                                
                        <div class="events__item events__item--<?=$itemPos?>">
                            <?= $this->Html->image(BIMG.$news['filename'], ['alt' => $news['name']]); ?>
                            <div class="events__descr-border"></div>
                            <div class="events__descr">
                                <p class="events__descr-caption"><?= $news['name'] ?></p>
                                <p class="events__descr-text"><?= $this->App->next_sub_str(strip_tags($news['content']),350)  ?>...</p>
                                <a href="<?=RS.LANG."/news/".$news['cat_alias']?>/<?= $news['alias'] ?>/" class="events__read-more"><?php $i=0; foreach ($site_translate as $translate){					
                                        if ($translate['ru_text'] == "Читать подробнее") {
                                            $i++;
                                            if ($i==1 ) {
                                                echo $translate['text'];
                                                }
                                            }?>    
                                    <?php }?></a>
                            </div>
                        </div>
                        <?php }
                        }
                    }?>
                   
                    <div class="clear"></div>
                </section>
                
            </div>
        </div>
    </div>
</section>
