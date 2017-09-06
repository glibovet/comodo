<footer class="footer">
    <img src="<?=RS?>img/footer-logo.png" alt="Logo" class="footer__logo">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-xs-12">
				<div class="footer__nav">
					<ul>
                    	<?php $i = 0; foreach($menu as $item) {									
							$activeClass = "";								
							$dopAlias = "";
							if ($item['alias'] == "company") {$dopAlias = "about-us/";}
							
							$href = RS.$lang."/".$item['alias']."/".$dopAlias;
							$ulDrop = "";							
							$i++;
							
							if ($i % 3 == 0) {$ulDrop = "</ul><ul>";}
							if ($i == count($menu)) {$ulDrop = "";}
							if ($item['alias'] == FA) {$activeClass = "active";}							
							?>
                            	<li><a class="<?= $activeClass ?>" href="<?=$href?>" rel="nofollow"><?= $item['name'] ?></a></li>
								<?= $ulDrop ?>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<p class="footer__social-caption">                       
						<?php $i=0; foreach ($site_translate as $translate){					
                            if ($translate['ru_text'] == "Социальные сети") {
                                $i++;
                                if ($i==1 ) {
                                    echo $translate['text'];
                                    }
                                }?>    
                        <?php }?>:</p>
				<ul class="footer__social">
					<span itemscope itemtype="http://schema.org/Organization">
                    <link itemprop="url" href="http://www.comodo.kiev.ua">
					<?php if ($fb_url) {?>
                    	<li><a itemprop="sameAs" href="<?=$fb_url?>" target="_blank" class="fb"></a></li>
                    <?php }?>
                    
					<?php if ($vk_url) {?>
                    	<li><a itemprop="sameAs" href="<?=$vk_url?>" target="_blank" class="vk"></a></li>
                    <?php }?>
                    
					<?php if ($gp_url) {?>
                    	<li><a itemprop="sameAs" href="<?=$gp_url?>" target="_blank" class="g-plus"></a></li>
                    <?php }?>
                    
					<?php if ($yt_url) {?>
                    	<li><a itemprop="sameAs" href="<?=$yt_url?>" target="_blank" class="youtube"></a></li>
                    <?php }?>   
                    
					<?php if ($in_url) {?>
                    	<li><a itemprop="sameAs" href="<?=$in_url?>" target="_blank" class="insta"></a></li>
                    <?php }?>  
                    </span>        
				</ul>
				<p class="footer__email"><?=TECHMAIL?></p>
				<p class="footer__developer">Сделано в <span><a href="https://kaminskiy-design.com.ua/" target="_blank">KamStudio</a></span></p>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="footer__contacts" itemscope="" itemtype="http://schema.org/Organization">
					<a href="#subscribe" class="footer__subscribe">                       
						<?php $i=0; foreach ($site_translate as $translate){					
                            if ($translate['ru_text'] == "Подписаться на рассылку") {
                                $i++;
                                if ($i==1 ) {
                                    echo $translate['text'];
                                    }
                                }?>    
                        <?php }?></a>
					<div class="footer__call">
						<div class="footer__phones">
                        	
							<?php 
                            $phones = explode(";", TECHPHONE);
                            foreach($phones as $phone) { 
                            $phonItem = ""; 
                            $phonItem = explode(" ", $phone);
                            $i=0;?>
                            <p class="footer__phone"><a itemprop="telephone" href="tel:<?=$phone?>">
                                <?php foreach ($phonItem as $item){
                                    $i++;
                                    $spanSt = "";
                                    $spanEn = "";
                                    if ($i<=1){$spanSt = "<span>";$spanEn = "</span>";} ?>
                                    <?=$spanSt.$item.$spanEn?>
                                <?php }?>
                            </a></p>
                            <?php }?>
						</div>
						<a href="#call-back" class="footer__request-call">                     
						<?php $i=0; foreach ($site_translate as $translate){					
                            if ($translate['ru_text'] == "Заказать звонок") {
                                $i++;
                                if ($i==1 ) {
                                    echo $translate['text'];
                                    }
                                }?>    
                        <?php }?></a>
					</div>
                    
                    <?php if($contactsMain){
						foreach ($contactsMain as $contact){?>
						<p class="footer__address" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
							<span itemprop="addressLocality"><?=$contact['city']?></span>, 
							<span itemprop="streetAddress"><?=$contact['adress']?></span>
						</p> 
					<?php }   
					 }?>
                         
				</div>
			</div>
		</div>
	</div>
	<div class="footer__bottom-line"></div>
</footer>