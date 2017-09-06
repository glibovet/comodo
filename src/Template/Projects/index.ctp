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
                    	<a itemprop="item" title="<?=PNAME?>">
							<span itemprop="name"><?=PNAME?></span>
        					<meta itemprop="position" content="2">
                        </a>
                    </li>
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
                            
                        <?=PNAME.$dopH1?>
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
						<div class="catalog__sorting-price">
							<span><?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "Сортировка по") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?></span>
							<select onChange="reloadProjectLine(this.value, '<?=CURR_URL?>');">
								<option value="new" <?php if(PROJECT_LINE == "new"){echo "selected";}?>>
								<?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "Новизне") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?></option>
								<option value="name" <?php if(PROJECT_LINE == "name"){echo "selected";}?>>
								<?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "Имени") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?></option>
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
							<input type="text" class="catalog__page-number" id="currPageInput" type="number" value="<?=$f_page_num?>" onChange="goCatalogPage(this.value);">
							<span class="catalog__page-sum"><?php $i=0; foreach ($site_translate as $translate){					
								if ($translate['ru_text'] == "из") {
									$i++;
									if ($i==1 ) {
										echo $translate['text'];
										}
									}?>    
							<?php }?> <count id="pagTotalCount"><?=$f_pages_count?></count></span>
                            <?php if ($f_page_num < $f_pages_count){?> 
								<button type="button" class="catalog__next-page" onClick="goCatalogPage(<?=$f_page_num+1?>);"></button>
                            <?php }?>
						</div>
					</div>
					<div class="catalog__inner projects_inner">
                    
                    <div id="ajaxProducts">
                            <div class="the_products">
						<?php foreach ($projectsList as $proj) {?>
                            <div class="catalog__item">
                                <a href="<?=$proj['alias']?>/">
                                    <div class="proj_list_img">
                                        <?= $this->Html->image(PJCIMG.$proj['img'], ['alt' => $proj['title']]); ?>
                                    </div>
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
                                        <p class="projects__name"><?=$proj['name']?></p>
                                    </div>
                                </a>
                            </div>
                        <?php }?>
						</div>
                    </div>
                    <!-- ajaxProducts -->
                    
                    </div>
					<div class="catalog__pagination" id="productsNavi">
                    	<?php include_once 'pagination.php';?>
					</div>
				</div>
			</div>
		</div>
	</section>