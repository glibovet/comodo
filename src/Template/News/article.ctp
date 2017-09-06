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
                        <a itemprop="item" href="<?=RS.LANG?>/news/<?=$newsArticle['cat_alias']?>/" title="<?=$newsArticle['cat_name']?>">
                        	<span itemprop="name"><?=$newsArticle['cat_name']?></span>
        					<meta itemprop="position" content="2">
                        </a>
                    </li>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    	<a itemprop="item" title="<?=strip_tags(str_replace('"','`',$newsArticle['name']));?>">
							<span itemprop="name"><?=$newsArticle['name']?></span>
        					<meta itemprop="position" content="3">
                        </a>
                    </li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="news-more">
		<div class="container">
			<div class="row mob-news-flex">
				<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
					<?php
						include 'news-category.php';
					?>
				</div>
                
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
					<div class="news-more__content">
						<?php if ($newsArticle['filename']){?>
							<?= $this->Html->image(BIMG.$newsArticle['filename'], ['alt' => $newsArticle['name']]); ?>
                        <?php }?>
                        
						<h1><?=$newsArticle['name']?></h1>
						<hr>
						<?=$newsArticle['content']?>
					</div>
                    
                    <?php if ($ArtGallery){?>
                        <section class="project-card__carousel article_carousel lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
                            <?php foreach ($ArtGallery as $gallery){?>
                                <a href="<?=IMG.GIMG.$gallery['file']?>">
                                    <?= $this->Html->image(GIMG.$gallery['file'], ['alt' => $gallery['title']]); ?>
                                </a>
                            <?php }?>
                        </section>
                    <?php }?>
                    
					<div class="news-more__nav">
						<?php if ($newsArticle['prev_news']){?>
                        	<a href="<?=RS.LANG?>/news/<?=$newsArticle['cat_alias']?>/<?=$newsArticle['prev_news']?>/" class="news-more__nav-prev">Предыдущая статья</a>
                        <?php }?>
                        <?php if ($newsArticle['next_news']){?>
							<a href="<?=RS.LANG?>/news/<?=$newsArticle['cat_alias']?>/<?=$newsArticle['next_news']?>/" class="news-more__nav-next">Следующая статья</a>
                        <?php }?>
					</div>
                    
				</div> 
                
			</div>
		</div>
	</section>