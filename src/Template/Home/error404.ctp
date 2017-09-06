<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<ul>
					<li><a href="<?=RS.LANG?>/"><?php $i=0; foreach ($site_translate as $translate){					
                                            if ($translate['ru_text'] == "Главная") {
                                                $i++;
                                                if ($i==1 ) {
                                                    echo $translate['text'];
                                                    }
                                                }?>    
                                        <?php }?></a></li>
					<li><?=$metaTitle?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="delivery__caption">
		<div class="container">
			<div class="delivery__caption-inner">
				<h1 class="site_title"><?=$metaTitle?></h1>
			</div>
		</div>
</section>

<section class="seo">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="main-article">
                	<p><?=$errDesc?></p>
				</div>
			</div>
		</div>
	</div>
</section>