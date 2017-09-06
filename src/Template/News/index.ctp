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

<section class="news__wrap">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
					<?php
						include 'news-category.php';
					?>
				</div>
				<div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
					<h1 class="news__caption">					          
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
					<?php if ($newsList){?>
                        <?php $n=0; foreach ($newsList as $news){
							$n++;
							$itemPos = "right";
							if ($n % 2 == 0) {$itemPos = "left";}?>
                            
                            <div class="events__item events__item--<?=$itemPos?>">
                                <?php if ($news['filename']){ 
									echo $this->Html->image(BIMG.$news['filename'], ['alt' => $news['name']]); 
								}?>
                                <div class="events__descr-border"></div>
                                <div class="events__descr">
                                    <p class="events__descr-caption"><?= $news['name'] ?></p>
                                    <p class="events__descr-text"><?= $this->App->next_sub_str(strip_tags($news['content']),350)  ?>...</p>
                                    <a href="<?=$news['cat_alias']?>/<?= $news['alias'] ?>/" class="events__read-more"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Читать подробнее") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
                                </div>
                            </div>
						<?php }?>
                        
                        <div class="news__pagination">
                        <?php
                            include 'pagination.php';
                        ?>
                        </div>
                    <?php }?>
				</div>
			</div>
		</div>
	</section>