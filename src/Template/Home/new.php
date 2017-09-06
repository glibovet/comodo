<?php if ($newProdList){?>
<section class="new">
	<div class="new__top-line">
		<p><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Новинки нашего салона") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="new__caption"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Новинки") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></div>
			</div>
            
            <div class="col-xs-12 hide_cont">
			<?php foreach ($newProdList as $prodItem){ 
				$formatProdPrice = number_format($prodItem['price'], 0, '.', '.');								
				$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', '.');								
				$prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";
				$prodIcon = "";
				$prodIconTxt = "";?>				
				
                <!-- PROD ITEM -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="new__item">
                        <a href="<?=$prodUrl?>" onclick="mainScript.addToView(<?=$prodItem['id']?>);">
                        	<?php if ($prodItem['img']){
								echo $this->Html->image(CIMG.$prodItem['img'], ['alt' => $prodItem['name']]);
							}else{
								echo $this->Html->image("noimage.png", ['alt' => "NO IMAGE"]);
							}?>                        
                            <div class="new__descr">
                                <div class="new__see-more">
                                    <p><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Смотреть подробнее") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
                                </div>
                                <div class="new__descr-param">                                    
                                    <p class="catalog__descr-name"><?=$prodItem['obj_name']?></p>
                                    <p class="catalog__descr-value"><?=$prodItem['name']?></p>
                                </div>
                                <div class="new__descr-param">
                                    <p class="new__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Фабрика") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
                                    <p class="new__descr-value"><?=$prodItem['mf_name']?></p>
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
                </div>
            <?php }?>
            </div>
            
            
			<div class="col-xs-12 margin-top40 show_hide_cont hide_cont_btn active ">
				<a href="#" class="new__view-all"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Посмотреть все") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
			</div>
            
			<div class="col-xs-12 margin-top40 hide_hide_cont hide_cont_btn">
				<a href="#" class="new__view-all"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Свернуть") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
			</div>
		</div>
	</div>
</section>
<?php }?>