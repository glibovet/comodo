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

<?php foreach ($contactsData as $contact){?>
	<section class="contacts">
		<div class="container">
			<div class="contacts__inner">
            
				<div class="contacts__address">
					<p><span><?=$contact['city']?></span></p>
					<p><?=$contact['adress']?></p>
				</div>
                
				<div class="contacts__phone">
                	<?php 
					$phones = explode(";", $contact['phone_number']);
					foreach($phones as $phone) { 
					$phonItem = ""; 
					$phonItem = explode(" ", $phone);
					$i=0;?>
					<p>
                        <a href="tel:<?=$phone?>">
                            <?php foreach ($phonItem as $item){
                                $i++;
                                $spanSt = "";
                                $spanEn = "";
                                if ($i<=1){$spanSt = "<span>";$spanEn = "</span>";} ?>
                                <?=$spanSt.$item.$spanEn?>
                            <?php }?>
                        </a>
                    </p>
                    <?php }?>
				</div>
                
				<div class="contacts__timing">
					<?php if ($contact['work_time']){?>
                    	<p><span>Пн-Пт:</span> <?=$contact['work_time']?></p>
                    <?php }?>
                   	<?php if ($contact['sat_time']){?>
                    	<p><span>Сб:</span> <?=$contact['sat_time']?></p>
                    <?php }?>
                   	<?php if ($contact['sun_time']){?>
                    	<p><span>Вс:</span> <?=$contact['sun_time']?></p>
                    <?php }?>
				</div>
                
			</div>
		</div>
        
        <?php if ($contact['map_frame']){?>
            <div class="contacts__map">			
                <?=$contact['map_frame']?>
            </div>
        <?php }?>
        
	</section>
<?php }?>