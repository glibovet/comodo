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
							if ($translate['ru_text'] == "Фабрики") {
								$i++; 
								if ($i==1 ) {
									$trName = $translate['text'];
								}
							} 
						}?>
                        <a itemprop="item" href="<?=RS.LANG?>/fabriki/" title="<?=$trName?>">
                        	<span itemprop="name"><?=$trName?></span>
        					<meta itemprop="position" content="2">
                        </a>
                    </li>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    	<a itemprop="item" title="<?=$mfData['name']?>">
							<span itemprop="name"><?=$mfData['name']?></span>
        					<meta itemprop="position" content="3">
                        </a>
                    </li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="factories-more__card-wrap margin-top40">
		<div class="factories-more__card">
			<div class="factories-more__card-logo-wrap">				
                <?php if ($mfData['crop']){?>
                    <img src="<?=IMG.GCIMG.$mfData['crop']?>" alt="<?= $mfData['name']?>_logo" class="factories-more__card-logo">
                <?php }
                else {?>
                    <img src="<?=RS?>img/noimage.png" alt="<?= $mfData['name']?>_logo" class="factories-more__card-logo">
                <?php }?>
			</div>
			<div class="factories-more__card-descr">
				<h1><?=$mfData['name']?></h1>
                
				<?php if ($mfData['site']){?>
                	<h2><?=$mfData['site']?></h2>
                <?php }?>
                
				<div class="factories-more__card-list-wrap">
					<div class="factories-more__card-list">
                    
						<?php if ($mfObjects){?>
                            <h3><?php $i=0; foreach ($site_translate as $translate){					
                                                    if ($translate['ru_text'] == "Все предметы мебели") {
                                                        $i++;
                                                        if ($i==1 ) {
                                                            echo $translate['text'];
                                                            }
                                                        }?>    
                                                <?php }?>:</h3>
                            <ul class="hide_cont">
                                <?php foreach ($mfObjects as $object){
									$counObjProds = count($object['products']);?>
                                	<li>
                                        <a href="#prod_tabs" class="filter-btn" data-filter="filter-<?=$object['id']?>" onClick="reloadTabs(<?=$object['id']?>);">
                                        	<?=$object['name']?> <?php if ($object['products']){echo "(".$counObjProds.")";}?>
                                        </a>
                                    </li>
                                <?php }?>
                            </ul>
                            <?php if (count($mfObjects) >=6){?>
                                <button type="button" class="show_hide_cont hide_cont_btn active"><?php $i=0; foreach ($site_translate as $translate){					
                                                    if ($translate['ru_text'] == "Все") {
                                                        $i++;
                                                        if ($i==1 ) {
                                                            echo $translate['text'];
                                                            }
                                                        }?>    
                                                <?php }?></button>
                                 <button type="button" class="hide_hide_cont hide_cont_btn"><?php $i=0; foreach ($site_translate as $translate){					
                                                    if ($translate['ru_text'] == "Свернуть") {
                                                        $i++;
                                                        if ($i==1 ) {
                                                            echo $translate['text'];
                                                            }
                                                        }?>    
                                                <?php }?></button>
                         	<?php }
							}?>
					</div>
					<div class="factories-more__card-list">
						<?php if ($mfCollections){?>
                            <h3><?php $i=0; foreach ($site_translate as $translate){					
                                                    if ($translate['ru_text'] == "Все коллекции") {
                                                        $i++;
                                                        if ($i==1 ) {
                                                            echo $translate['text'];
                                                            }
                                                        }?>    
                                                <?php }?>:</h3>
                            <ul class="hide_cont">
                                <?php foreach ($mfCollections as $collection){
									//$counColProds = $collection['count_prods'];
									$counColProds = count($collection['products']);?>
                                	<li>
                                        <a href="<?=RS.LANG?>/catalog/<?=$collection['products'][0]['cat_alias']?>/?filter=collections&value=<?=$collection['id']?>">
                                        	<?=$collection['name']?> <?php if ($collection['products']){echo "(".$counColProds.")";}?>
                                        </a>
                                    </li>
                                <?php }?>
                            </ul>
                            <?php if (count($mfCollections) >=6){?>
                                <button type="button" class="show_hide_cont hide_cont_btn active"><?php $i=0; foreach ($site_translate as $translate){					
                                                    if ($translate['ru_text'] == "Все") {
                                                        $i++;
                                                        if ($i==1 ) {
                                                            echo $translate['text'];
                                                            }
                                                        }?>    
                                                <?php }?></button>
                                 <button type="button" class="hide_hide_cont hide_cont_btn"><?php $i=0; foreach ($site_translate as $translate){					
                                                    if ($translate['ru_text'] == "Свернуть") {
                                                        $i++;
                                                        if ($i==1 ) {
                                                            echo $translate['text'];
                                                            }
                                                        }?>    
                                                <?php }?></button>
                         	<?php }
							}?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="factories-more__text-container">
		<div class="container">
			<div class="factories-more__video-wrap">
				<?php if ($mfData['video']){
					echo $mfData['video'];
				}?>               
				<!--<video src="<?=RS?>video/Магия_Финляндии_в_4K.mp4" poster="<?=RS?><?=RS?>img/video-preview.jpg" id="factories-more__video"></video>
				<button class="factories-more__video-btn" type="button"></button>-->
			</div>
			<p class="factories-more__text-caption"><?=$mfData['name']?> <?php if ($mfData['country']){echo "(".$mfData['country'].")";}?></p>
			
            <?php if ($mfData['details']){?>
                <div class="factories-more__text-wrap hide_cont">
                    <div class="factories-more__text">
                        <?=$mfData['details']?>
                    </div>
                </div>
                
                <a href="#" class="factories-more__more-btn show_hide_cont hide_cont_btn margin-top15 active"><?php $i=0; foreach ($site_translate as $translate){					
                    if ($translate['ru_text'] == "Читать далее") {
                        $i++;
                        if ($i==1 ) {
                            echo $translate['text'];
                            }
                        }?>    
                <?php }?></a>
                <a href="#" class="factories-more__more-btn hide_hide_cont hide_cont_btn"><?php $i=0; foreach ($site_translate as $translate){					
                    if ($translate['ru_text'] == "Свернуть") {
                        $i++;
                        if ($i==1 ) {
                            echo $translate['text'];
                            }
                        }?>    
                <?php }?></a>            
			<?php }?>
        </div>
	</section>

	<?php if ($mfObjects || $mfProdsNobj){?>
    <a name="prod_tabs"></a>
    <section class="similar">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="similar__captions" data-toggle="buttons">
						<button class="active filter-btn" data-filter><?php $i=0; foreach ($site_translate as $translate){					
                                                    if ($translate['ru_text'] == "Все") {
                                                        $i++;
                                                        if ($i==1 ) {
                                                            echo $translate['text'];
                                                            }
                                                        }?>    
                                                <?php }?></button>
						<?php if ($mfObjects){
							foreach ($mfObjects as $object){?>
                        	<button id="tabFilter-<?=$object['id']?>" class="filter-btn" data-filter="filter-<?=$object['id']?>"><?=$object['name']?></button>
                        <?php }
						}?>
					</div>
				</div>
			</div>
		</div>
		<div class="similar__list">
			<div class="container">
				<div class="row">
					<div class="masonry">
						<?php if ($mfObjects){
							foreach ($mfObjects as $object){
								
								foreach ($object['products'] as $prodItem){	
									
								$formatProdPrice = number_format($prodItem['price'], 0, '.', '.');								
								$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', '.');								
								$prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";	?> 
                                                           
								<div class="similar__item" data-filter="filter-<?=$object['id']?>">
									<a href="<?=$prodUrl?>" onclick="mainScript.addToView(<?=$prodItem['id']?>);">
                                        <?php if ($prodItem['img']){
											echo $this->Html->image(CIMG.$prodItem['img'], ['alt' => $prodItem['name']]);
										}else{
											echo $this->Html->image("noimage.png", ['alt' => "NO IMAGE"]);
										}?>
										<div class="similar__descr">
											<div class="similar__see-more">
												<p><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Смотреть подробнее") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
											</div>
											<div class="similar__descr-param">
												<p class="similar__descr-name"><?=$object['name']?></p>
												<p class="similar__descr-value"><?=$prodItem['name']?></p>
											</div>
											<div class="similar__descr-param">
												<p class="similar__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Фабрика") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
												<p class="similar__descr-value"><?=$mfData['name']?></p>
											</div>
                                            
											<?php if($prodItem['price']){?>
                                                <!--<div class="similar__descr-param hidden">
                                                    <p class="similar__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
                                                        if ($translate['ru_text'] == "Цена") {
                                                            $i++;
                                                            if ($i==1 ) {
                                                                echo $translate['text'];
                                                                }
                                                            }?>    
                                                    <?php }?></p>
                                                    <p class="similar__descr-value"><?=$formatProdPrice?> <?=CURNAME?></p>
                                                </div>-->
                                            <?php }?>
										</div>
									</a>
								</div>
							<?php }
							}
						}?>
                        
                        <?php if ($mfProdsNobj){ 
							foreach ($mfProdsNobj as $prodItem){
								
							$formatProdPrice = number_format($prodItem['price'], 0, '.', '.');								
							$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', '.');								
							$prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";?>
                            
								<div class="similar__item" data-filter="no-filter">
									<a href="<?=$prodUrl?>" onclick="mainScript.addToView(<?=$prodItem['id']?>);">
                                        <?php if ($prodItem['img']){
											echo $this->Html->image(CIMG.$prodItem['img'], ['alt' => $prodItem['name']]);
										}else{
											echo $this->Html->image("noimage.png", ['alt' => "NO IMAGE"]);
										}?>
										<div class="similar__descr">
											<div class="similar__see-more">
												<p><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Смотреть подробнее") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
											</div>
											<div class="similar__descr-param">
												<p class="similar__descr-name"></p>
												<p class="similar__descr-value"><?=$prodItem['name']?></p>
											</div>
											<div class="similar__descr-param">
												<p class="similar__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Фабрика") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
												<p class="similar__descr-value"><?=$mfData['name']?></p>
											</div>
                                            
											<?php if($prodItem['price']){?>
                                                <!--<div class="similar__descr-param hidden">
                                                    <p class="similar__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
                                                        if ($translate['ru_text'] == "Цена") {
                                                            $i++;
                                                            if ($i==1 ) {
                                                                echo $translate['text'];
                                                                }
                                                            }?>    
                                                    <?php }?></p>
                                                    <p class="similar__descr-value"><?=$formatProdPrice?> <?=CURNAME?></p>
                                                </div>-->
                                            <?php }?>
										</div>
									</a>
								</div>
						<?php }	
						}?>
					</div>
                    <div class="col-xs-12 margin-top30 margin-bottom60">
                        <a href="<?=CURR_URL?>?oll_prods=1" class="new__view-all">
							<?php $i=0; foreach ($site_translate as $translate){ if ($translate['ru_text'] == "Посмотреть все") { $i++; if ($i==1 ) { echo $translate['text']; } } }?>
                        </a>
                    </div>
				</div>
			</div>
		</div>
	</section>
    <?php }?>