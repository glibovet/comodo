<?php if ($mpCatalog){?>
<div class="news">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="news__blog">
					<div class="news__blog-item--all-categories">
						<a href="<?=RS.LANG?>/news/" class="news__blog-item--all-categories-wrap">
							<div class="news__caption-all-categories">
								<p><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Блог") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></p>
							</div>
							<span><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Все новости") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></span>
						</a>
					</div>
                    <?php foreach ($mpBlogList as $news){?>
                        <div class="news__blog-item" style="background-image: url(<?=IMG.PJIMG.$news['filename']?>);">
                            <a href="<?=RS.LANG."/news/".$news['cat_alias']?>/<?= $news['alias'] ?>/">
                                <p class="news__blog-date"><span><?php if($news['dd']<10) { echo "0"; }?><?= $news['dd']; ?></span> <?php if($news['mm']<10) { echo "0"; }?><?= $news['mm']; ?>.<?= $news['yy']; ?></p>
                                <p class="news__blog-caption"><?= $news['name'] ?></p>
                                <p class="news__blog-text"><?= $this->App->next_sub_str(strip_tags($news['content']),175)  ?>...</p>
                            </a>
                        </div>
                    <?php }?>
				</div>
			</div>
            
			<div class="col-lg-6 col-md-12">
				<div class="news__action">
					<?=$this->Html->image("action-slider-border.png", ['alt' => "border", 'class' => "news__action-border-img"]);?>
					
					<?php if ($stockBanList){?>
                        <div class="sale__caption"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Акции") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></div>
                        <div class="news__action-border"></div>
                        <div class="news__action-slider">
                            <?php foreach ($stockBanList as $ban){
                                $href= "#";
                                $blank= "";
                                if ($ban['link']) {$href = $ban['link'];}
                                if ($ban['target']) {$blank = "_blank";}
                                ?>
                                <div class="news__action-slide"  style="background-image: url(<?=IMG.GIMG.$ban['file']?>);">
                                    <a href="<?=$href?>" target="<?=$blank?>">
                                        <p class="news__action-caption"><?=$ban['name']?></p>
                                        <p class="news__action-sub-caption"><?=$ban['data']?></p>
                                    </a>
                                </div>
                            <?php }?>
                        </div>
                    <?php }?>
                    
				</div>
			</div>          
           
		</div>
	</div>
</div>
<?php }?>