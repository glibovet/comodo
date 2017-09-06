<section class="similar">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="similar__captions">
					<button class="active" data-tabName="similar__tab1">
                    <?php $i=0; foreach ($site_translate as $translate){					
						if ($translate['ru_text'] == "Предметы коллекции") {
							$i++;
							if ($i==1 ) {
								echo $translate['text'];
								}
							}?>    
					<?php }?> 
                    </button>
                    <button data-tabName="similar__tab2">
                    <?php $i=0; foreach ($site_translate as $translate){					
						if ($translate['ru_text'] == "Варианты отделки") {
							$i++;
							if ($i==1 ) {
								echo $translate['text'];
								}
							}?>    
					<?php }?>                     
                    </button>
				</div>
			</div>
		</div>
	</div>
	<div class="similar__tab similar__tab1">
		<div class="container">
			<div class="row <?=$openObjClass?>">
                <?php if ($allCollection){
					foreach ($allCollection as $prodItem){
					$prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";
					$formatProdPrice = number_format($prodItem['price'], 0, '.', '.');?>
                    
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="similar__item"  id="list_prod_<?=$prodItem['id']?>">
                            <a href="<?=$prodUrl?>" onclick="mainScript.addToView(<?=$prodItem['id']?>);">
                                <?= $this->Html->image(CIMG.$prodItem['img'], ['alt' => $prodItem['name']]); ?>
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
                                        <p class="similar__descr-name"><?=$prodItem['obj_name']?></p>
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
                                        <p class="similar__descr-value"><?=$prodItem['mf_name']?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php }
				}?>
			</div>
            
			<?php if ($allCollection && count($allCollection) >=9){?>            
                <button type="button" class="similar__view-all active open"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Смотреть всю коллекцию") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></button>
                <button type="button" class="similar__view-all close"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Свернуть") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></button>
            <?php }?>
		</div>
	</div>
	<div class="similar__tab similar__tab2">
		<div class="container">
			<div class="row <?=$openDecClass?> lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
            	<?php if ($prodDecors){
				foreach ($prodDecors as $prodDecor){?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="similar__item">
                            <a href="<?=IMG.FINIMG.$prodDecor['file']?>" title="<?=$prodDecor['title']?>">
                                <?= $this->Html->image(CFINIMG.$prodDecor['crop'], ['alt' => $prodDecor['title']]); ?>
                                <div class="similar__descr">
                                    <div class="similar__see-more">
                                        <p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Увеличить") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
                                    </div>
                                    <div class="similar__descr-param">
                                        <p class="similar__descr-value"><?=$prodDecor['title']?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php }
				}?>
			</div>
            
			<?php if ($prodDecors && count($prodDecors) >=9){?>
                <button type="button" class="similar__view-all active open"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Все") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></button>
                <button type="button" class="similar__view-all close"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Свернуть") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></button>
            <?php }?>
		</div>
	</div>
</section>