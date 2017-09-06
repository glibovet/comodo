<section class="viewed">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2 class="viewed__caption">просмотренные</h2>
			</div>
			<div class="col-xs-12">
            <?php if ($viewedProds) {?>
				<div class="viewed__carousel">
					
					<?php foreach ($viewedProds as $prodItem) {
                    $prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";
                    $formatProdPrice = number_format($prodItem['price'], 0, '.', '.');?>
                    <div class="viewed__item-wrap">
                        <div class="viewed__item">
                            <a href="<?=$prodUrl?>">
                                <?= $this->Html->image(CIMG.$prodItem['img'], ['alt' => $prodItem['name']]); ?>
                                <div class="viewed__descr">
                                    <div class="viewed__see-more">
                                        <p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Смотреть подробнее") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
                                    </div>
                                    <div class="viewed__descr-param">
                                        <p class="viewed__descr-name"><?=$prodItem['obj_name']?></p>
                                        <p class="viewed__descr-value"><?=$prodItem['name']?></p>
                                    </div>
                                    <div class="viewed__descr-param">
                                        <p class="viewed__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Фабрика") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
                                        <p class="viewed__descr-value"><?=$prodItem['mf_name']?></p>
                                    </div>
                                    <?php if($prodItem['price']){?>
                                        <div class="viewed__descr-param hidden">
                                            <p class="viewed__descr-name"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Цена") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
                                            <p class="viewed__descr-value"><?=$formatProdPrice?> <?=CURNAME?></p>
                                        </div>
                                    <?php }?>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php }?>
				</div>
                <?php }?>
			</div>
		</div>
	</div>
</section>