<?php if ($mpCompanyNews){?>
<section class="events">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="events__caption"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "События компании") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></div>
				
                <?php $n=0; foreach ($mpCompanyNews as $news){
					$n++;
					$itemPos = "right";
					if ($n % 2 == 0) {$itemPos = "left";}
					else{$itemPos = "right";}?>
                    
                    <div class="events__item events__item--<?=$itemPos?>">
						<?php if ($news['filename']){ 
							echo $this->Html->image(BIMG.$news['filename'], ['alt' => $news['name']]); 
						}?>
                        <div class="events__descr-border"></div>
                        <div class="events__descr">
                            <p class="events__descr-caption"><?= $news['name'] ?></p>
                            <p class="events__descr-text"><?= $this->App->next_sub_str(strip_tags($news['content']),350)  ?>...</p>
                            <a href="<?=RS.LANG."/news/".$news['cat_alias']?>/<?= $news['alias'] ?>/" class="events__read-more"><?php $i=0; foreach ($site_translate as $translate){					
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
                
			</div>
		</div>
	</div>
</section>
<?php }?>