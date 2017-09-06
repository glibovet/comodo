<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		include('inc/head.php')
	?>
</head>
<body>
	<?php
		include('inc/language.php');

		include('inc/header.php');

		include('inc/breadcrumbs.php');
	?>

	<section class="project-card">
		<img src="img/project-card-img.jpg" alt="alt">
		<div class="project-card__inner">
			<h1>проект спальни Людовика</h1>
			<p class="project-card__architect">Архитектор: <a href="#">Шуляк Богдан</a></p>
			<div class="project-card__short-descr">
				<p class="project-card__short-descr-caption">Краткое описание:</p>
				<p class="project-card__short-descr-text">Очень оригинальная кровать от фабрики DV HOME, как и все,что производят мастера этой фабрики.Высокое ровное изголовье кровати всегда подчеркнет вкус и стиль ее владельца, а яркие и насыщенные расцветки, которые всегда присутствуют в арсенале фабрики, удовлетворят даже самых требовательных покупатели.Каркас кровати изготовлен из массива натурального дерева, для оббивки используется ткань ли натуральная кожа, пуговицы Капитоне могут быть заменены на декоративные пуговицы Swarovsky.</p>
			</div>
			<ul class="project-card__social">
				<li><a href="#" class="fb"></a></li>
				<li><a href="#" class="g-plus"></a></li>
				<li><a href="#" class="fb"></a></li>
				<li><a href="#" class="g-plus"></a></li>
				<li><a href="#" class="youtube"></a></li>
			</ul>
			<div class="project-card__buttons">
				<a href="#">все работы архитектора</a>
				<a href="#">договориться о встрече</a>
			</div>
		</div>
	</section>

	<section class="project-card__carousel lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel1.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel2.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel3.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel2.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel1.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel1.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel1.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel2.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel3.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel2.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel1.jpg" alt="alt"></a>
		<a href="img/project-card-img.jpg"><img src="img/project-card-carousel1.jpg" alt="alt"></a>
	</section>

	<?php
		include('inc/footer.php');

		include('inc/modal.php');

		include('inc/_js.php');
	?>
</body>
</html>