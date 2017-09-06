<?php if ($companyBanList){?>
<section class="about-us">
	<div class="about-us__logo">
		<div class="about-us__caption">
			<p><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "О нас") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></p>
		</div>
		<a href="<?=RS.LANG."/company/about-us/"?>"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Читать о компании") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></a>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
				<div class="about-us__counts">
					<?php $i = 0; foreach ($companyBanList as $ban){
						$i++;
						$href= "#";
						$blank= "";
						if ($ban['link']) {$href = $ban['link'];}
						if ($ban['target']) {$blank = "_blank";}
						?>
                        <div class="about-us__count about-us__count--<?=$i?>" style="background-image: url('<?=IMG.GIMG.$ban['file']?>');">
                            <p><?=$ban['name']?></p>
                        </div>
                    <?php }?>
					<div class="about-us__button-wrap">
						<a href="<?=RS.LANG."/company/about-us/"?>"><?php $i=0; foreach ($site_translate as $translate){					
												if ($translate['ru_text'] == "Читать о компании") {
													$i++;
													if ($i==1 ) {
														echo $translate['text'];
														}
													}?>    
											<?php }?></a>
					</div>
					<?=$this->Html->image("chair.png", ['alt' => "CHAIR", 'class' => "about-us__chair"]);?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php }?>
