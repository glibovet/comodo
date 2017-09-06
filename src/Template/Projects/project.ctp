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
                        <?php 
						$trName = "";
						$i=0;
						foreach ($site_translate as $translate) { 
							if ($translate['ru_text'] == "Наши проекты") {
								$i++; 
								if ($i==1 ) {
									$trName = $translate['text'];
								}
							} 
						}?>
                        <a itemprop="item" href="<?=RS.LANG?>/projects/" title="<?=$trName?>">
                        	<span itemprop="name"><?=$trName?></span>
        					<meta itemprop="position" content="2">
                        </a>
                    </li>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    	<a itemprop="item" title="<?=strip_tags(str_replace('"','`',$project['name']));?>">
							<span itemprop="name"><?=$project['name']?></span>
        					<meta itemprop="position" content="3">
                        </a>
                    </li>
				</ul>
			</div>
		</div>
	</div>
</section>


<section class="project-card">
		<?= $this->Html->image(PJIMG.$project['img'], ['alt' => $project['title']]); ?>
		<div class="project-card__inner">
			<h1><?=$project['name']?></h1>
			<p class="project-card__architect"><?=$project['worker_position']?>: <a href="<?=RS.LANG?>/company/about-us/<?=$project['worker_alias']?>"><?=$project['worker_name']?> <?=$project['worker_fname']?></a></p>
			<div class="project-card__short-descr">
				<p class="project-card__short-descr-caption"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Краткое описание") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?>:</p>
				<div class="project-card__short-descr-text">
                	<?=$project['content']?>
                </div>
			</div>
            
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
            
			<div class="project-card__buttons">
				<a href="<?=RS.LANG?>/company/about-us/<?=$project['worker_alias']?>"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Все работы архитектора") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
				<a href="#meeting"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Договориться о встрече") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
			</div>
		</div>
	</section>

	<?php if ($projectGal){?>
        <section class="project-card__carousel lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
            <?php foreach ($projectGal as $gallery){?>
            	<a href="<?=IMG.PJIMG.$gallery['file']?>">
                	<?= $this->Html->image(PJCIMG.$gallery['crop'], ['alt' => $gallery['title']]); ?>
                </a>
            <?php }?>
        </section>
    <?php }?>