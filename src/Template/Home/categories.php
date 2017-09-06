<?php if ($mpCatalog){?>
<div class="card-info__inner main_cat_inner">
<section class="categories">
	<div class="categories__slide hide_cont">
    
		<div class="categories__item--all-categories show_hide_cont hide_cont_btn active">
			<a href="#" class="categories__item--all-categories-wrap">
				<div class="categories__caption-all-categories">
					<p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Категории") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
				</div>
				<span><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Все категории") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span>
			</a>
		</div>
        
        <?php foreach ($mpCatalog as $catalog){?>
            <div class="categories__item">
                <a href="<?=RS.LANG?>/catalog/<?=$catalog['alias']?>/">
                    <?php if ($catalog['filename']){
						echo $this->Html->image(CATIMG.$catalog['filename'], ['alt' => $catalog['name']]);
					}else{
						echo $this->Html->image("noimage.png", ['alt' => "NO IMAGE"]);
					}?>
                    <p class="categories__caption"><?=$catalog['name']?></p>
                    <div class="categories__count"><?=$catalog['count_prods']?></div>
                    <div class="categories__text"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Предложения") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></div>
                </a>
            </div>
        <?php }?>
        
        <div class="categories__item--all-categories hide_hide_cont hide_cont_btn">
			<a href="#" class="categories__item--all-categories-wrap">
				<div class="categories__caption-all-categories">
					<p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Категории") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
				</div>
				<span><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Свернуть") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span>
			</a>
		</div>
	</div>
</section>
</div>
<?php }?>