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

<section class="delivery__caption">
		<div class="container">
			<div class="delivery__caption-inner">
				<h3 class="site_title">Каталог продукции</h3>
			</div>
		</div>
</section>

<?php if ($mpCatalog){?>
<div class="card-info__inner main_cat_inner">
<section class="categories">
	<div class="categories__slide show_cont">
	<?php foreach ($mpCatalog as $catalog){?>
        <div class="categories__item">
            <a href="<?=RS.LANG?>/catalog/<?=$catalog['alias']?>/">
                <?php if ($catalog['filename']){
                    echo $this->Html->image(CATIMG.$catalog['filename'], ['alt' => $catalog['name']]);
                }else{
                    echo $this->Html->image("noimage.png", ['alt' => "NO IMAGE"]);
                }?>
                <p class="categories__caption"><?=$catalog['name']?></p>
                <div class="categories__count"><?=$catalog['count_prods']?></div>
                <div class="categories__text"><?php $i=0; foreach ($site_translate as $translate){					
                                        if ($translate['ru_text'] == "Предложения") {
                                            $i++;
                                            if ($i==1 ) {
                                                echo $translate['text'];
                                                }
                                            }?>    
                                    <?php }?></div>
            </a>
        </div>
    <?php }?>
    </div>
</section>
</div>
<?php }?>

<section class="delivery">
    <div class="delivery__inner">
        <div class="container">
        	<p><br><br></p>
            <h1 class="site_title">мебель италии, элитная итальянская мебель, каталог итальянской мебели</h1>
            <div> <div><p>В разделе каталог продукции Вы можете ознакомиться с <strong>итальянской мебелью</strong> по различным категориям. Поскольку у каждого человека разные взгляды на стиль и дизайн любимой мебели, в этом разделе можно максимально быстро и удобно найти именно ту мебель, которая больше всего подойдет в Ваш интерьер или дополнит уже созданный.<br><br></p> 
<p>Фабрики разделяются по ценовой категории, что позволяет максимально вписаться в бюджет, который Вы готовы потратить на свой дом. <em>Вся мебель, которую предлагает наша компания качественная  - это проверенно многими годами работы нашей компании.</em> Поэтому, не смотря на ценовую категорию покупаемой мебели – Вы получите добротный товар, который будет служить Вам годами.<br><br></p> 
<p>Поскольку у дизайнеров <strong>итальянских фабрик</strong> очень плодотворная фантазия, для более простого поиска мебели – обратите внимание на стили. В <strong>разделе классика</strong> можно найти как и дворцовую классику с золотым декором, так простую классику в стиле кантри или бидермайер.  Любая коллекция классической мебели создается для создания интерьера в полном объеме:  фабрика предлагает мебель начиная от мебели в прихожую, гостиную, мягкую мебель, мебель в спальни, детские, также кухни, заканчивая мебелью в ванные комнаты. Все это делается водном стиле, но с множеством вариантов отделки и декоров.  Также мы предлагаем большой выбор <strong>мебели в современном стиле</strong>, который отличается своей индивидуальностью, большим выбором отделок и возможностью компоновать элементы между собой. Фабрики предлагают шкафы-купе со скрытыми направляющими, очень выгодное и красивое решения для Вашего дома.&nbsp;<br><strong>Мебель в стиле арт-дэко</strong> – это уникальные вещи, который могут «подружиться» как с мебель в классическом стиле, так и современном, даже в стиле «хай-тек». Красивые, дизайнерские вещи подчеркнут убранство любого интерьера и придадут уют и богатство.<br><br></p> 
<p>Также наша компания готова предложить Вам <strong>мебель по нашей складкой программе</strong>. Мебель может быть доставлена уже на следующий день с момента заказа.<br><br>Если Вам понравилась мебель, которая представлена на нашем сайте, обращайтесь к менеджерам нашей студии, и мы с удовольствием <strong>поможем Вам укомплектовать Ваш дом</strong>. Поскольку мебель, которая находиться у нас на сайте – это только малая часть наших возможностей, пожалуйста уточняйте у нас о возможности привести мебель не представленных на нашем сайте фабрик. Мы сможем помочь Вам в поставке мебели, света, аксессуаров и т.д. с Германии, Испании, Бельгии, Австрии и других стран Европы.<br><br><em>С нетерпением ждем Вас в нашей студии.</em><br></p></div></div>
        </div>
    </div>
</section>
