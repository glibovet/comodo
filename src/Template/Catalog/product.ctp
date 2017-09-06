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
                <ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumbs fixclear">
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?=RS.LANG?>/" title="<?=MNAME?>">
                        	<span itemprop="name"><?=MNAME?></span>
        					<meta itemprop="position" content="1">
                        </a>
                    </li>
                    <?php 
						$i = 0;
						$href = "".RS.LANG."/catalog/";
						
						foreach ($breadCr as $bread) {
						$i++;
						$href .= $bread['alias']."/";?>
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" title="<?=$bread['name']?>" href="<?=$href ?>">
                                <span itemprop="name"><?=$bread['name']?></span>
                                <meta itemprop="position" content="<?=$i+1?>">
                            </a>
                        </li>
					<?php }?>  
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" title="<?=$prodCard['obj_name']?> <?=strip_tags(str_replace('"','`',$prodCard['name']));?>">
                            <?php /*<span itemprop="name"><?=$prodCard['obj_name']?> */?><?=$prodCard['name']?></span>
                            <meta itemprop="position" content="<?=$i+2?>">
                        </a>
                    </li> 
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="card-info">
	<div class="card-info__inner">
		<div class="card-info__photo lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
        	<?php if ($prodImgs){?>
                    <a href="<?=IMG.PIMG.$prodImgs[0]['file']?>" title="<?=$prodImgs[0]['title']?>" class="card-info__big-lbox">
           				<?= $this->Html->image(PIMG.$prodImgs[0]['file'], ['alt' => $prodImgs[0]['title'], 'class' => 'card-info__big-photo']); ?>
                    </a>
                
                <div class="card-info__photo-slider">
                    <?php $i=0; foreach ($prodImgs as $img){ $i++;?>
                        <?php if ($i>=2){?>
                        	<a href="<?=IMG.PIMG.$img['file']?>" title="<?=$img['title']?>"></a>
                        <?php }?>
                        
                        <div class="card-info__photo-slide">
							<?= $this->Html->image(CIMG.$img['crop'], ['alt' => $img['title'], 'data-src' => IMG.PIMG.$img['file']]); ?>
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
			<h1><?php /*<?=$prodCard['obj_name']?> */?><?=$prodCard['name']?></h1>
			<div class="card-info__params-wrap">
				<ul class="card-info__params">
					<li class="factory"><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Фабрика") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span><span class="card-info__value"><a href="<?=RS.LANG?>/fabriki/<?=$prodCard['mf_alias']?>/"><?=$prodCard['mf_name']?></a></span>
                    </li>
                    
					<?php if ($prodCard['collection_name']){?>
                    <li class="collection"><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Коллекция") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span><span class="card-info__value"><a href="<?=RS.LANG?>/catalog/<?=$prodCard['cat_alias']?>/?filter=collections&value=<?=$prodCard['collection_id']?>"><?=$prodCard['collection_name']?></a></span></li>
                    <?php }?>
                    
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
                                        
                    <?php if ($prodColors){?>
                        <li><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Цвет") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span>
                                <span class="card-info__value">       
									<?php $i=0; foreach ($prodColors as $color){ $i++;
                                                $dopTxt=", ";
                                                if ($i == count($prodColors)){$dopTxt="";}
                                                ?>
                                        <?=$color['name'].$dopTxt?>
                                    <?php }?>
                                </span>
                        </li>
                    <?php }
					elseif ($prodCard['color']){?>
                        <li><span class="card-info__param"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Цвет") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</span>
                            <span class="card-info__value"><?=$prodCard['color']?></span>
                        </li>
                    <?php }?>
                    
				</ul>
				<div class="card-info__dimensions">
					<div class="hide_cont <?php if ($allCollection && count($allCollection) <=3) {echo "open";}?>">
						<?php if ($prodSizes){?>
                            <ul>
                                <li class="card-info__dimensions-caption">
                                	<?php /* echo $prodCard['obj_name']*/?> <?=$prodCard['name']?>:
                                </li>
                                <?php if ($prodSizes['width']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Длина") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodSizes['width']?>см</span></li>
                                <?php }?>
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
                                <?php if ($prodSizes['diameter']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Диаметр") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodSizes['diameter']?>см</span></li>
                                <?php }?>
                                <?php if (!$prodSizes['height'] && !$prodSizes['width'] && !$prodSizes['depth'] && !$prodSizes['diameter']){?>
                                    <li>
                                        <span class="card-info__dimensions-params">
                                        <?php $i=0; foreach ($site_translate as $translate){ if ($translate['ru_text'] == "По размерам клиента") { $i++; if ($i==1 ) {echo $translate['text'];} } }?>
                                         </span>
                                     </li>
                                <?php }?>
                            </ul>
                        <?php }?>
                        
                        <?php if ($objGroup){
                        foreach ($objGroup as $prodItem){?>
                            <ul class="">
                                <li class="card-info__dimensions-caption">
									<a href="<?=RS.LANG?>/catalog/product/<?=$prodItem['alias']?>">
										<?php /* echo $prodItem['obj_name']*/?> <?=$prodItem['name']?>:
									</a>
                                </li>
                                <?php if ($prodItem['width']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Длина") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodItem['width']?>см</span></li>
                                <?php }?>
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
                                <?php if ($prodItem['diameter']){?>
                                    <li><span class="card-info__dimensions-params"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Диаметр") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span><span class="card-info__dimensions-value"><?=$prodItem['diameter']?>см</span></li>
                                <?php }?>
                                
                                <?php if (!$prodItem['height'] && !$prodItem['width'] && !$prodItem['depth'] && !$prodItem['diameter']){?>
                                    <li>
                                        <span class="card-info__dimensions-params">
                                        <?php $i=0; foreach ($site_translate as $translate){ if ($translate['ru_text'] == "По размерам клиента") { $i++; if ($i==1 ) {echo $translate['text'];} } }?>
                                         </span>
                                     </li>
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
                        <li>
                        	<a data-pin-do="buttonBookmark" data-pin-tall="true" data-pin-round="true" data-pin-save="false" href="https://www.pinterest.com/pin/create/button/"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_round_red_32.png" /></a>
                        </li>
                        <li><a href="#" class="fb"></a></li>
                        <li><a href="#" class="vk"></a></li>
                        <li><a href="#" class="g-plus"></a></li>
                    </ul>           
                        
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="facebook,vkontakte,gplus"></div>
                    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
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