<div class="language">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<ul>
                	<?php foreach ($site_langs as $s_lang){
						$dopClass =""; 
						if ($s_lang['alias'] == $lang){$dopClass ="active";}
						?>
                    	<li><a class="<?=$dopClass?>" href="javascript:void(0);" onClick="reloadLang('<?=$s_lang['alias']?>', '<?=$s_lang['alias']."/".LANG_URL?>');"><?=$s_lang['alias']?></a></li>
                    <?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<header class="header">
	<div class="header__top-line">
		<div class="header__top-line-inner">
			<div class="header__soc-and-search">
            
				<ul class="header__social">
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
                
                <?php $i=0; foreach ($site_translate as $translate){					
					if ($translate['ru_text'] == "Поиск") {
						$i++;
						if ($i==1 ) {
							$searc_plder = $translate['text'];
							}
						}?>    
                <?php }?>
                <div class="relative">
                	<input type="text" class="header__search searchInput" placeholder="<?=$searc_plder?>" value="" onChange="reloadSaerch('<?=LANG?>', $(this).val());" >
                	<a class="h_search_btn" title="search" href="javascript:void(0);" onClick="reloadSaerch('<?=LANG?>', $(this).parent().find('input').val());"></a>
				</div>  
			</div>
			<div class="header__cart">
				<a href="#" class="header__cart-link"><span class="header__cart-text">
                <?php $i=0; foreach ($site_translate as $translate){					
					if ($translate['ru_text'] == "Корзина") {
						$i++;
						if ($i==1 ) {
							echo $translate['text'];
							}
						}?>    
                <?php }?>
                </span><span class="header__cart-count"> (<span id="header_cart"><?=$cartQty?></span>)</span></a>
                <div class="header__notebook-baner <?php if (!$cartQty){echo "hide";} ?>">
                    <div class="header__baner-inner" id="prodCartList">
                        <?php if ($mainCartList){
                        foreach ($mainCartList as $cartItem) { ?>								
                                <div class="header__notebook-baner-item" id="h-cart-item-<?= $cartItem['id'] ?>">
                                    <a class="hcart_img" href="<?= RS.LANG ?>/catalog/product/<?= $cartItem['prod_alias'] ?>/">
                                        <?= $this->Html->image(CIMG.$cartItem['prod_crop'], ['alt' => $cartItem['prod_name']]); ?>
                                    </a>
                                    <div class="header__notebook-baner-text">
                                        <p class="header__notebook-baner-caption">
                                            <a class="hcart_img" href="<?= RS.LANG ?>/catalog/product/<?= $cartItem['prod_alias'] ?>/">
                                                <?= $cartItem['prod_name'] ?>
                                            </a>
                                        </p>
                                        <p class="header__notebook-baner-count"><span id="h-cart-pqty-<?= $cartItem['id'] ?>"><?= $cartItem['quant'] ?></span> шт</p>
                                    </div>
                                </div>
                        <?php }
                        }?>
                    </div>
                    <a href="#send-request" class="send-request-btn">                    
                        <?php $i=0; foreach ($site_translate as $translate){					
                            if ($translate['ru_text'] == "Отправить запрос") {
                                $i++;
                                if ($i==1 ) {
                                    echo $translate['text'];
                                    }
                                }?>    
                        <?php }?>                    
                    </a>
                    <a class="h_go_to_cart" href="<?=RS.LANG?>/cart/">                                      
                        <?php $i=0; foreach ($site_translate as $translate){					
                            if ($translate['ru_text'] == "Перейти в блокнот") {
                                $i++;
                                if ($i==1 ) {
                                    echo $translate['text'];
                                    }
                                }?>    
                        <?php }?>  
                    </a>
                </div>
			</div>
			<?php if (LA == "home" || LA == $lang){?>
                <span class="header__logo">
                    <img src="<?=RS?>img/logo.png" alt="Logo" class="header__logo-img">
                </span>
            <?php }else{?>
                <a href="<?=RS?>" class="header__logo">
                    <img src="<?=RS?>img/logo.png" alt="Logo" class="header__logo-img">
                </a>
            <?php }?>
			<div class="header__contacts" itemscope="" itemtype="http://schema.org/Organization">
				<div class="header__address">
					<?php if($contactsMain){
						foreach ($contactsMain as $contact){?>
                    	<p itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
							<span itemprop="addressLocality"><?=$contact['city']?></span>, 
							<span itemprop="streetAddress"><?=$contact['adress']?></span>
                        </p> 
                    <?php }   
                   	 }?>
				</div>
				<div class="header__phone">
					<?php 
                    $phones = explode(";", TECHPHONE);
                    foreach($phones as $phone) { 
					$phonItem = ""; 
					$phonItem = explode(" ", $phone);
					$i=0;
					$phoneCopy = $phone
					?>
                   	<p><a itemprop="telephone" href="tel:<?=str_replace(array(" ", "-"), "", $phoneCopy)?>">
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
			</div>
			<a href="#call-back" class="header__request-call">
			<?php $i=0; foreach ($site_translate as $translate){					
                if ($translate['ru_text'] == "Заказать звонок") {
                    $i++;
                    if ($i==1 ) {
                        echo $translate['text'];
                        }
                    }?>    
            <?php }?>  
            </a>
		</div>
	</div>
	<nav class="header__nav">
		<div class="header__nav-inner">
			<ul>
            	<?php foreach($menu as $item) {							
					$dropClass = "";													
					$activeClass = "";
					$href = RS.$lang."/".$item['alias']."/";
					$ulOp = "";
					$ulCl = "";
					if ($item['drop'] || $item['type'] == 4) {$dropClass = "drop-down"; $href = "#"; $ulCl = "</ul></div>";}					
					if ($item['drop']) { $ulOp = "<div class='header__drop-down-list'><ul>"; }
					if ($item['type'] == 4) {$ulOp = "<div class='header__drop-down-list header__drop-down-list--catalog'><ul>";}
					if ($item['alias'] == FA) {$activeClass = "active";}
					?>
						<li><a href="<?= $href ?>" class="<?= $dropClass." ".$activeClass ?>"><?= $item['name'] ?></a>
							<?= $ulOp ?>
								<?php if ($item['type'] == 4) {
									$i = 0;
									foreach($catalog as $catIitem) {										
									$i++;
									$ulDrop = "";
									if ($i % 6 == 0) {$ulDrop = "</ul><ul>";}
									if ($i == count($catalog)) {$ulDrop = "";}?>
										<li><a href="<?= RS.$lang ?>/catalog/<?= $catIitem['alias'] ?>/"><?= $catIitem['name'] ?></a></li>
                                        <?= $ulDrop ?>
								<?php }
								} ?>
								<?php if ($item['submenu']) {
									foreach($item['submenu'] as $subItem) {?>
										<li><a href="<?= RS.$lang."/".$item['alias'] ?>/<?= $subItem['alias'] ?>/"><?= $subItem['name'] ?></a></li>
								<?php }
								} ?>
							<?= $ulCl ?>
						</li>
				<?php } ?>
            
				
			</ul>
		</div>
	</nav>
	<button type="button" class="tcon tcon-menu--xbutterfly header__menu-btn" aria-label="toggle menu">
	 	<span class="tcon-menu__lines" aria-hidden="true"></span>
	 	<span class="tcon-visuallyhidden">toggle menu</span>
	</button>
	<div class="header__bottom-line">
		<p class="header__bottom-line-text">Home interior</p>
	</div>
</header>
