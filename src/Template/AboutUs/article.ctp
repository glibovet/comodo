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

<section class="delivery__caption">
		<div class="container">
			<div class="delivery__caption-inner">
				<p><?=PNAME?></p>
			</div>
		</div>
</section>

<section class="delivery">
    <div class="delivery__inner">
        <div class="container">
            <?=$companyInfo['details']?>
        </div>
    
		<?php if ($pageGallery){?>
            <section class="project-card__carousel lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
                <?php foreach ($pageGallery as $gallery){?>
                    <a href="<?=IMG.GIMG.$gallery['file']?>">
                        <?= $this->Html->image(GIMG.$gallery['file'], ['alt' => $gallery['title']]); ?>
                    </a>
                <?php }?>
            </section>
        <?php }?>

    </div>
</section>
