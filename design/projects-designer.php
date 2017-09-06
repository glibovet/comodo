<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		include('inc/head.php')
	?>
</head>
<body class="projects-designer-page">
	<?php
		include('inc/language.php');

		include('inc/header.php');

		include('inc/breadcrumbs.php');
	?>

	<section class="catalog">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
					<div class="filters">
						<div class="filters__caption">
							<p>фильтр проектов</p>
						</div>
						<div class="filter">
							<div class="filter__caption">Подкатегории
								<div class="filter__p-m-wrap">
									<button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
										<span class="tcon-visuallyhidden">add item</span>
									</button>	
								</div>
							</div>
							<ul class="filter__list">
								<li class="filter__list-item"><input type="checkbox" id="param_1"><label for="param_1">Спальный гарнитур</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_2"><label for="param_2">Кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_3"><label for="param_3">Круглые кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_4"><label for="param_4">Кровать с балдахином</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_5"><label for="param_5">Тумбы прикроватные</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_6"><label for="param_6">Туалетные столики</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_1"><label for="param_7">Спальный гарнитур</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_2"><label for="param_8">Кровати</label></li>
							</ul>
						</div>
						<div class="filter">
							<div class="filter__caption">Ценовой диапазон
								<div class="filter__p-m-wrap">
									<button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
										<span class="tcon-visuallyhidden">add item</span>
									</button>	
								</div>
							</div>
							<ul class="filter__list">
								<li class="filter__list-item"><input type="checkbox" id="param_9"><label for="param_9">Круглые кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_10"><label for="param_10">Кровать с балдахином</label></li>
							</ul>
						</div>
						<div class="filter">
							<div class="filter__caption">Стиль
								<div class="filter__p-m-wrap">
									<button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
										<span class="tcon-visuallyhidden">add item</span>
									</button>	
								</div>
							</div>
							<ul class="filter__list">
								<li class="filter__list-item"><input type="checkbox" id="param_11"><label for="param_11">Спальный гарнитур</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_12"><label for="param_12">Кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_13"><label for="param_13">Круглые кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_14"><label for="param_14">Кровать с балдахином</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_15"><label for="param_15">Тумбы прикроватные</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_16"><label for="param_16">Туалетные столики</label></li>
							</ul>
						</div>
						<div class="filter">
							<div class="filter__caption">Фабрики
								<div class="filter__p-m-wrap">
									<button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
										<span class="tcon-visuallyhidden">add item</span>
									</button>	
								</div>
							</div>
							<ul class="filter__list">
								<li class="filter__list-item"><input type="checkbox" id="param_17"><label for="param_17">Спальный гарнитур</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_18"><label for="param_18">Кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_19"><label for="param_19">Круглые кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_20"><label for="param_20">Кровать с балдахином</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_21"><label for="param_21">Тумбы прикроватные</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_22"><label for="param_22">Туалетные столики</label></li>
							</ul>
						</div>
						<div class="filter">
							<div class="filter__caption">Цвет
								<div class="filter__p-m-wrap">
									<button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
										<span class="tcon-visuallyhidden">add item</span>
									</button>	
								</div>
							</div>
							<ul class="filter__list">
								<li class="filter__list-item"><input type="checkbox" id="param_23"><label for="param_23">Спальный гарнитур</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_24"><label for="param_24">Кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_25"><label for="param_25">Круглые кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_26"><label for="param_26">Кровать с балдахином</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_27"><label for="param_27">Тумбы прикроватные</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_28"><label for="param_28">Туалетные столики</label></li>
							</ul>
						</div>
						<div class="filter">
							<div class="filter__caption">Материал
								<div class="filter__p-m-wrap">
									<button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
										<span class="tcon-visuallyhidden">add item</span>
									</button>	
								</div>
							</div>
							<ul class="filter__list">
								<li class="filter__list-item"><input type="checkbox" id="param_29"><label for="param_29">Спальный гарнитур</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_30"><label for="param_30">Кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_31"><label for="param_31">Круглые кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_32"><label for="param_32">Кровать с балдахином</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_33"><label for="param_33">Тумбы прикроватные</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_34"><label for="param_34">Туалетные столики</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_35"><label for="param_35">Спальный гарнитур</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_36"><label for="param_36">Кровати</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_37"><label for="param_37">Круглые кровати</label></li>
							</ul>
						</div>
						<div class="filter">
							<div class="filter__caption">Страна производитель
								<div class="filter__p-m-wrap">
									<button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
										<span class="tcon-visuallyhidden">add item</span>
									</button>	
								</div>
							</div>
							<ul class="filter__list">
								<li class="filter__list-item"><input type="checkbox" id="param_38"><label for="param_38">Кровать с балдахином</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_39"><label for="param_39">Тумбы прикроватные</label></li>
								<li class="filter__list-item"><input type="checkbox" id="param_40"><label for="param_40">Туалетные столики</label></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
					<div class="catalog__caption">
						<h1>Архитектор Верещинская валентина</h1>
						<a href="#">Вернуться к списку проектов</a>
					</div>
					<div class="projects-designer__card">
						<div class="projects-designer__photo">
							<img src="img/about-photo1.jpg" alt="alt">
							<div class="projects-designer__name">
								<div class="projects-designer__name-inner">
									<p class="projects-designer__initials">Лидия Романец</p>
									<p class="projects-designer__status">Владелец</p>
								</div>
							</div>
						</div>
						<div class="projects-designer__card-descr">
							<p class="projects-designer__card-caption">Дизайн интерьера, 3D визуализация </p>
							<div class="projects-designer__contacts">
								<p class="projects-designer__contacts-location">Украина,  г. Киев </p>
								<p class="projects-designer__contacts-phone">050 <span>442-30-14</span></p>
								<p class="projects-designer__contacts-email">lida@gmail.com</p>
							</div>
							<p class="projects-designer__card-qoute">Прежде всего, я стремлюсь услышать и понять человека, который обратился ко мне как к профессионалу, а уже потом стараюсь сделать результат работы радостным для всех. Все свои проекты разрабатываю и веду сама, поэтому каждый сделанный мною интерьер индивидуален. Наивысшей оценкой для меня есть и остается состояние людей.</p>
							<a href="#meeting" class="meeting">Договориться о встрече</a>
						</div>
					</div>
					<div class="catalog__inner">
						<div class="catalog__item">
							<a href="#">
								<img src="img/new3.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new2.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new1.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new3.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new1.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new3.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new2.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new1.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
						<div class="catalog__item">
							<a href="#">
								<img src="img/new3.jpg" alt="alt">
								<div class="catalog__descr">
									<div class="catalog__see-more">
										<p>смотреть подробнее</p>
									</div>
									<p class="projects__name">Дизайн покоев людовика 14</p>
								</div>
							</a>
						</div>
					</div>
					<div class="catalog__pagination">
						<ul>
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
						</ul>
						<button type="button">Далее</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
		include('inc/footer.php');

		include ('inc/modal.php');

		include('inc/_js.php');
	?>
</body>
</html>