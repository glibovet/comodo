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

<section class="about__descr">
		<div class="container">
			<div class="about__descr-inner">
				<div class="about__caption">
					<p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "О нас") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
				</div>
				<div class="about__descr-text">
                	<?=PDET?>
				</div>
			</div>
		</div>
	</section>

	<?php if($companyWorkers){?>
        <section class="about">
            <div class="container">
                <div class="about__inner">
                    <?php foreach ($companyWorkers as $worker){?>
                        <div class="about__item">
                            <a href="<?=$worker['alias']?>/" class="about__item-img">
                                <?php if ($worker['avatar']){
									echo $this->Html->image(UIMG.$worker['avatar'], ['alt' => $worker['name']]);
								}else{
									echo $this->Html->image("noimage.png", ['alt' => $worker['name']]);
								}?>
                            </a>
                            <p class="about__item-qoute"><?=$worker['credo']?></p>
                            <a href="<?=$worker['alias']?>/" class="about__name">
                                <div class="about__name-inner">
                                    <p class="about__initials"><?=$worker['name']?> <?=$worker['fname']?></p>
                                    <p class="about__status"><?=$worker['position']?></p>
                                    <p class="about__email"><?=$worker['login']?></p>
                                </div>
                            </a>
                        </div>
                    <?php }?>
                </div>
            </div>
        </section>
    <?php }?>
