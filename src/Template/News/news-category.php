<div class="news__category">
	<div class="news__category-caption">
		<p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Категории новостей") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
	</div>
    
	<?php if($newsCat) {?>
        <ul class="news__category-list">
            <?php foreach ($newsCat as $cat) {
				$dopClass = "";
				if($cat['alias'] == LA) {$dopClass = "active";}
				?>
            	<li><a class="<?=$dopClass?>" href="<?=RS.LANG?>/news/<?=$cat['alias']?>"><?=$cat['name']?> 
                <span>(<?=$cat['art_count']?> <?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "статьи") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'].")";
                                                    }
                                                }?>    
                                        <?php }?></span>
                </a></li>
            <?php }?>
        </ul>
    <?php }?>    
	<a href="<?=RS.LANG?>/news/" class="news__category-view-all"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Читать все новости") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a>
    
	<?php if($lastNewsList) {?>
        <div class="news__new-article">
            <p class="news__new-article-caption"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Недавние статьи") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
            <div class="news__new-article-slider">                
                <ul class="news__new-article-list">
                	<?php $i = 0; foreach ($lastNewsList as $lastArt) {										
						$i++;
						$ulDrop = "";
						if ($i % 4 == 0) {$ulDrop = "</ul><ul class='news__new-article-list'>";}
						if ($i == count($lastNewsList)) {$ulDrop = "";}?>
                    	<li>
                            <a href="<?=RS.LANG?>/news/<?=$lastArt['cat_alias']?>/<?=$lastArt['alias']?>/"><?=$lastArt['name']?></a>
                            <p><?php if($lastArt['dd']<10) { echo "0"; }?><?= $lastArt['dd']; ?>.<?php if($lastArt['mm']<10) { echo "0"; }?><?= $lastArt['mm']; ?>.<?= $lastArt['yy']; ?></p>
                        </li>
                        <?= $ulDrop ?>
                    <?php }?> 
                </ul>
            </div>
        </div>
    <?php }?> 
</div>