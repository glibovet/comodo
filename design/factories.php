<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		include('inc/head.php')
	?>
</head>
<body class="factories-page">
	<?php
		include('inc/language.php');

		include('inc/header.php');

		include('inc/breadcrumbs.php');

		include('inc/alphabet.php');
	?>

	<section class="factories__header">
		<div class="container">
			<div class="factories__caption">
				<h1>Фабрики</h1>
				<p class="factories__caption-count">283</p>
				<p>предложения</p>
			</div>
			<div class="factories__sorting">
				<button type="button" class="factories__view-btn1"></button>
				<button type="button" class="factories__view-btn2"></button>
			</div>
		</div>
	</section>

	<section class="factories">
		<div class="container">
<!-- 			<div class="factories__list four-column">
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
			</div> -->
			<div class="factories__list two-column">
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
				<a href="#" class="factories__item">
					<img src="img/factories-logo.jpg" alt="alt" class="factories__logo">
					<p class="factories__item-caption">SIGNORINI-COCO &amp; C.s.n.r.</p>
					<hr>
					<ul>
						<li>КАБИНЕТЫ</li>
						<li>МЯГКАЯ</li>
						<li>МЕБЕЛЬ</li>
						<li>ГОСТИНЫЕ</li>
						<li>СПАЛЬНИ</li>
						<li>СВЕТИЛЬНИКИ</li>
					</ul>
				</a>
			</div>
		</div>
		<?php
			include('inc/alphabet.php');
		?>
	</section>

	<?php
		include('inc/footer.php');

		include('inc/modal.php');

		include('inc/_js.php');
	?>
</body>
</html>