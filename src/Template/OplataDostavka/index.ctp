	<section class="banner">
		<h1>Оплата / Доставка</h1>
	</section>
	
	
	<section class="bread-crumbs">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-20 col-lg-offset-4 col-md-18 col-md-offset-6 col-sm-18 col-sm-offset-6 col-xs-24 col-xs-offset-0">
					<ul>
						<li><a href="/"><?=MAIN?></a></li>
						<?php $alias=""; foreach ($breadCr as $bCramp){
							$alias .=$bCramp['alias']."/";
							?>
							<li><a href="<?=RS.$alias?>">| <?=$bCramp['name']?></a></li>                    
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="payment-and-delivery">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-lg-offset-6 col-md-16 col-md-offset-4 col-sm-20 col-sm-offset-2 col-xs-24 col-xs-0">
					<div class="tabs" id="payment-and-delivery">
						<div class="tab-button-wrap">
                            <?php $i = 0; foreach ($deliveryList as $item){
								$i++; 
								$dopClass = "";
								if ($i <= 1){$dopClass = "active";}?>
                            	<p class="tab-button <?=$dopClass?>" data-tab="<?=$item['alias']?>"><?=$item['name']?></span></p>
                            <?php }?>
                        </div>
                        
                        <?php $i = 0; foreach ($deliveryList as $item){
								$i++; 
								$dopClass = "";
								if ($i <= 1){$dopClass = "active";}?>
                                <div class="tab-content <?=$dopClass?>" id="<?=$item['alias']?>">
                                	<?=$item['content']?>
                                </div>
                        <?php }?>
					</div>
				</div>
			</div>
		</div>
	</section>