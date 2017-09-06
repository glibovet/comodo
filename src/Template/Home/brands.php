<?php if ($mpMf){?>
<section class="brands">
	<div class="container">
		<div class="row">
        
			<?php foreach ($mpMf as $mf){?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?=RS.LANG."/fabriki/".$mf['alias']?>">
                    	<?php if ($mf['filename']){
							echo $this->Html->image(GCIMG.$mf['crop'], ['alt' => $mf['name']." - ".$mf['country']]);
						}else{
							echo $this->Html->image("noimage.png", ['alt' => $mf['name']." - ".$mf['country']]);
						}?>
                    </a>
                </div>
            <?php }?>
            
		</div>
        <div class="col-xs-12 margin-top40">
            <a href="<?=RS.LANG."/fabriki/"?>" class="new__view-all"><?php $i=0; foreach ($site_translate as $translate){					
				if ($translate['ru_text'] == "Посмотреть все") {
					$i++;
					if ($i==1 ) {
						echo $translate['text'];
						}
					}?>    
			<?php }?></a>
		</div>
	</div>
</section>
<?php }?>