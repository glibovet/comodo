<?php 
$openObjClass = "";
$openDecClass = "";
if ($allCollection && count($allCollection) <=8) {$openObjClass = "open";}
if ($prodDecors && count($prodDecors) <=8) {$openDecClass = "open";}
?>

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
                                        
                    <?php 
						$href = "".RS.LANG."/catalog/";
						
						foreach ($breadCr as $bread) {
						$href .= $bread['alias']."/";?>
                        
						<li><a href="<?=$href ?>"><?=$bread['name']?></a></li>
					<?php }?> 
                    <li><a><?=$prodCard['obj_name']?> <?=$prodCard['name']?></a></li>   
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="card-info">
	<div class="card-info__inner">
		<div class="card-info__photo">
        	<?php if ($prodImgs){?>
           			<?= $this->Html->image(PIMG.$prodImgs[0]['file'], ['alt' => $prodImgs[0]['title'], 'class' => 'card-info__big-photo']); ?>
                
                <div class="card-info__photo-slider">
                    <?php foreach ($prodImgs as $img){?>
                        <div class="card-info__photo-slide">
                            <?= $this->Html->image(CIMG.$img['crop'], ['alt' => $img['title']]); ?>
                        </div>
					<?php }?>
                </div>
            <?php }
			else{?>
				<?= $this->Html->image("noimage.png", ['alt' => "NO IMAGE", 'class' => 'card-info__big-photo']); ?>
			<?php }?>
		</div>
		<div class="card-info__descr">
        	
          <form id="toCartForm" method="post" action="#">                               
          	<input type="hidden" id="prod_id" name="prod_id" value="<?= $prodCard['id'] ?>" /> 
            <?php if ($prodCard['mf_crop']){?>
				<?= $this->Html->image(GCIMG.$prodCard['mf_crop'], ['alt' => $prodCard['mf_name'], 'class' => 'card-info__brand-logo']); ?>
            <?php }?> 
			<h1><?=$prodCard['obj_name']?> <?=$prodCard['name']?></h1>
			<div class="card-info__params-wrap">
				<ul class="card-info__params">
					<li class="factory"><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Фабрика") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span><span class="card-info__value"><a href="<?=RS.LANG?>/fabriki/<?=$prodCard['mf_alias']?>/"><?=$prodCard['mf_name']?></a></span></li>
					<li class="collection"><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Коллекция") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span><span class="card-info__value"><a href="<?=RS.LANG?>/catalog/<?=$prodCard['cat_alias']?>/?filter=collections&value=<?=$prodCard['collection_id']?>"><?=$prodCard['collection_name']?></a></span></li>
					<?php if ($prodCard['code']){?>
                    	<li><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Код") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span><span class="card-info__value"><?=$prodCard['code']?></span></li>
                    <?php }?>
                    <?php if ($prodCard['sku']){?>
						<li><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Артикул") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span><span class="card-info__value"><?=$prodCard['sku']?></span></li>
                    <?php }?>
                    <?php if ($prodChars){
						foreach($prodChars as $char){
							if ($char['values']){?>
                            <li><span class="card-info__param"><?=$char['name']?>:</span>
                                <?php if (count($char['values']) >=2){?>
                                <select name="char[<?=$char['char_id']?>]" class="card-info__value card-info__value--select">
                                    <?php $i=0; foreach($char['values'] as $char_val){?>
                                        <option value="<?=$char_val['ref_id']?>"><?=$char_val['value']?></option>
                                    <?php }?>
                                </select>
                                <?php }else{?>
                                	<input type="hidden" name="char[<?=$char['char_id']?>]" value="<?=$char['values'][0]['ref_id']?>">
                                	<span class="card-info__value"><?=$char['values'][0]['value']?></span>
                                <?php }?>
                            </li>
                    <?php }
						}
					}?>
                    
                    <?php if ($prodCard['color']){?>
                        <li><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Цвет") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span>
                            <span class="card-info__value"><?=$prodCard['color']?></span>
                            <!--<select class="card-info__value card-info__value--select">
                                <option selected><?=$prodCard['color']?></option>
                            </select>-->
                        </li>
                    <?php }?>
				</ul>
				<div class="card-info__dimensions">
					<div class="hide_cont <?php if ($allCollection && count($allCollection) <=3) {echo "open";}?>">
						<?php if ($prodSizes){?>
                            <ul>
                                <li class="card-info__dimensions-caption"><?=$prodCard['name']?>:</li>
                                <?php if ($prodSizes['height']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Высота") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodSizes['height']?>см</span></li>
                                <?php }?>
                                <?php if ($prodSizes['width']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Ширина") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodSizes['width']?>см</span></li>
                                <?php }?>
                                <?php if ($prodSizes['depth']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Глубина") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodSizes['depth']?>см</span></li>
                                <?php }?>
                            </ul>
                        <?php }?>
                        
                        <?php if ($allCollection){
                        foreach ($allCollection as $prodItem){?>
                            <ul>
                                <li class="card-info__dimensions-caption"><?=$prodItem['obj_name']?>:</li>
                                <?php if ($prodItem['height']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Высота") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodItem['height']?>см</span></li>
                                <?php }?>
                                <?php if ($prodItem['width']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Ширина") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodItem['width']?>см</span></li>
                                <?php }?>
                                <?php if ($prodItem['depth']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Глубина") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodItem['depth']?>см</span></li>
                                <?php }?>
                            </ul>
                        <?php }
                        }?>
					</div>                    
                    
                    <?php if (count($allCollection) >=4){?>
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
					<?php }?>
                </div>
			</div>
			<div class="card-info__short-descr">
				<p class="card-info__short-descr-caption"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Краткое описание") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</p>
				<hr>
				<div class="card-info__short-descr-text">
                <?=$prodCard['details']?>
                </div>
			</div>
			<div class="card-info__descr-footer">
				<button type="button" onclick="mainScript.addToCart();" data-toggle="modal" data-target="#modal-6"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "В блокнот") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></button>
                <div class="share_block">
                    <ul class="project-card__social">
                        <li><a href="#" class="fb"></a></li>
                        <li><a href="#" class="vk"></a></li>
                        <li><a href="#" class="g-plus"></a></li>
                    </ul>           
                        
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="facebook,vkontakte,gplus"></div>
                </div>
			</div>
            
            <div class="clear"></div>                
            <div class="response"></div>
		  </form>
        </div>
	</div>
</section>

<?php

	include('variants.php');

	include('viewed.php');
?>