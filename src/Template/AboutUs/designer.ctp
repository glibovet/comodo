<?php $phonItem = explode(")", $worker['phone']);?>
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
							if ($translate['ru_text'] == "О нас") {
								$i++; 
								if ($i==1 ) {
									$trName = $translate['text'];
								}
							} 
						}?>
                        <a itemprop="item" href="<?=RS.LANG?>/company/about-us/" title="<?=$trName?>">
                        	<span itemprop="name"><?=$trName?></span>
        					<meta itemprop="position" content="2">
                        </a>
                    </li>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    	<a itemprop="item" title="<?=$worker['name']?> <?=$worker['fname']?> - <?=$worker['position']?>">
							<span itemprop="name"><?=$worker['name']?> <?=$worker['fname']?> - <?=$worker['position']?></span>
        					<meta itemprop="position" content="3">
                        </a>
                    </li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="catalog projects-designer-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">                	
					<?php include_once 'filters.php';?>						
				</div>
				<div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
					<div class="catalog__caption">
						<h1><?=$worker['position']?> <?=$worker['name']?> <?=$worker['fname']?></h1>
						<a href="<?=RS.LANG?>/company/about-us/"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Вернуться к списку дизайнеров") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
					</div>
					<div class="projects-designer__card">
						<div class="projects-designer__photo">
                            <?php if ($worker['avatar']){
								echo $this->Html->image(UIMG.$worker['avatar'], ['alt' => $worker['name']]);
							}else{
								echo $this->Html->image("noimage.png", ['alt' => $worker['name']]);
							}?>
							<div class="projects-designer__name">
								<div class="projects-designer__name-inner">
									<p class="projects-designer__initials"><?=$worker['name']?> <?=$worker['fname']?></p>
									<p class="projects-designer__status"><?=$worker['position']?></p>
								</div>
							</div>
						</div>
						<div class="projects-designer__card-descr">
							<p class="projects-designer__card-caption"><?=$worker['skills']?></p>
							<div class="projects-designer__contacts">
								<p class="projects-designer__contacts-location"><?=$worker['address']?></p>
								<p class="projects-designer__contacts-phone">
                                <a href="tel:<?=$worker['phone']?>">
									<?php $i=0; foreach ($phonItem as $item){
                                        $i++;
                                        $spanSt = "";
                                        $spanEn = "";
                                        if ($i==2){$spanSt = "<span>";}
                                        if ($i==1){$spanEn = ")";}
                                        if ($i==count($phonItem)){$spanEn = "</span>";} ?>
                                        <?=$spanSt.$item.$spanEn?>
                                    <?php }?>
                                </a>
                                </p>
								<p class="projects-designer__contacts-email"><?=$worker['login']?></p>
							</div>
                            <?php if ($worker['details']){?>
								<p class="projects-designer__card-qoute"><?=$worker['details']?></p>
                            <?php }?>
							<a href="#meeting" class="meeting"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Договориться о встрече") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
						</div>
					</div>
                    
                    <?php if ($projectsList) {?>
                        <div class="catalog__inner projects_inner">
                            <?php foreach ($projectsList as $proj) {?>
                                <div class="catalog__item">
                                    <a href="<?=RS.LANG?>/projects/<?=$proj['alias']?>/">
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
                    <?php }?>
                    
					<div class="catalog__pagination">
                    	<?php include_once 'pagination.php';?>
					</div>
				</div>
			</div>
		</div>
	</section>