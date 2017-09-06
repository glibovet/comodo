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

<section class="alphabet">
	<div class="container">
		<ul class="alphabet__inner">
        	<?php foreach ($alphabetList as $alphabet){?>
				<li><a href="javascript:void(0);" onclick="reloadMfsAbc('<?=$alphabet['letter']?>', '<?=CURR_URL?>');" class="alphabet__letter"><?=$alphabet['letter']?></a></li>
            <?php }?>
			<li><a href="javascript:void(0);" onclick="reloadMfsAbc('', '<?=CURR_URL?>');" class="alphabet__view-all"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Все") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a></li>
		</ul>
	</div>
</section>

<section class="factories__header">
    <div class="container">
        <div class="factories__caption">
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
            <p class="factories__caption-count"><span id="countMf"><?=$allMfCount['count_mf']?></span></p>
            <p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "результатов") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
        </div>
        <div class="factories__sorting">
            <button type="button" class="factories__view-btn1" onclick="reloadMfsColumn('tree', '<?=CURR_URL?>');"></button>
            <button type="button" class="factories__view-btn2" onclick="reloadMfsColumn('blocks', '<?=CURR_URL?>');"></button>
        </div>
    </div>
</section>

<section class="factories__list" id="mfList">
    <?php if($alphabetMf){?>
        <div class="container">
            <div class="response"></div>  
            <?php foreach ($alphabetMf as $alphMf){?>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="factories__list-character">
                            <p><?=$alphMf['letter']?></p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <ul class="factories__list-item">                        
                                <?php $i = 0; foreach ($alphMf['mfs'] as $mf){											
                                    $i++;
                                    $ulDrop = "";
                                    if ($i % 9 == 0) {$ulDrop = "</ul></div><div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'><ul class='factories__list-item'>";}
                                    if ($i == count($alphMf['mfs'])) {$ulDrop = "";}?>
                                    
                                    <li><a href="<?=$mf['alias']?>/"><?=$mf['name']?> (<?=$mf['count_prods']?>)</a></li>
                                    <?= $ulDrop ?>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php }?>
            
            <div class="factories__pagination">
                <?php if (!MFABC){include_once 'pagination.php';}?>
            </div>
        </div>
    <?php }
	elseif($blocksMf){?>
        <div class="container">
            <div class="factories__list four-column">        
            <?php foreach ($blocksMf as $mf) {?>
                    <a href="<?=RS.LANG?>/fabriki/<?=$mf['alias']?>/" class="factories__item">
                        <?php if ($mf['filename']){?>
                            <img src="<?=RS?>img/split/files/content/crop/<?= $mf['logo']?>" alt="<?= $mf['name']?>_logo" class="factories__logo">
                        <?php }
                        else {?>
                            <img src="<?=RS?>img/noimage.png" alt="<?= $mf['name']?>_logo" class="factories__logo">
                        <?php }?>
                        <p class="factories__item-caption"><?= $mf['name']?></p>
                        <hr>
                        
                        <?php if($mf['objects']){?>
                        <ul>
                            <?php foreach ($mf['objects'] as $obj) {?>
                                <li><?= $obj['name']?></li>
                            <?php }?>
                        </ul>
                        <?php }?>
                    </a>
            <?php }?>        
            </div>
            
            <div class="factories__pagination">
                <?php if (!MFABC){include_once 'pagination.php';}?>
            </div>
        </div>
    <?php }?>
</section>