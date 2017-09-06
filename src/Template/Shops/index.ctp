<section class="banner">
		<h1><?php if (LANG_PREFIX == "") { echo "Наши";}elseif (LANG_PREFIX == "en_") { echo "Our";}?> <span><?= PNAME ?></span></h1>
</section>

<section class="bread-crumbs">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-20 col-lg-offset-4 col-md-18 col-md-offset-6 col-sm-18 col-sm-offset-6 col-xs-24 col-xs-offset-0">
				<ul>
					<li><a href="/"><?= MAIN ?></a></li>
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

<section class="shops stat_page">
	
	<div class="container">
		<div class="center margin-bottom40"><?= $this->Html->image('logo.png', ['alt' => 'logo']); ?></div>
		<div class="descr margin-bottom40">
			<?= PDET ?>
		</div>
	</div>
	
</section>