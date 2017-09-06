<!-- CONTENT -->
<section>
	<div class="container">

		<!-- options -->
		<div class="row shop-top-options">

			<div class="col-sm-12 col-md-12 center">


				<h2 class="p-name-h2">
					
					<span class="p-name-txt">
						<span class="p-name-top"></span>
							<?= PNAME ?>
						<span class="p-name-bot"></span>
					</span>
					
				</h2>

			</div>
		</div>
		<!-- /options -->
		
		<div class="row"><!-- Rviews LIST  -->
        	<?php foreach ($reviews as $review){ 
        	//$revDate = date_format($review['dateCreate'], 'd.m.y'); ?>
		
			<div class="reviews-item"><!-- Rviews ITEM  -->
				<div class="reviews-border"></div>
				
				<div class="col-md-2 col-sm-2">
					<div class="reviews-img  lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
						<div class="reviews-img-quant">+<?= $review['quant_img'] ?></div>
						<a href="<?= UIMG.$review['img'] ?>">
							<div class="reviews-img-hover"></div>
                            <?= $this->Html->image(''.UIMG.$review['img'].'', ['alt' => ''.$review['user_name'].'', 'class'=>'img-responsive',  'data-zoom-image'=>''.UIMG.$review['img'].'']); ?>
						</a>
						
						<div class="reviews-gal hidden">
							<?php 
							$i = 0;
							foreach ($reviewFiles as $file){ 
							if ($file['ref_id'] == $review['id']){ 
								$i++; if ($i>=2){?>
									<a href="<?= UIMG.$file['file'] ?>">
										<?= $this->Html->image(''.UIMG.$file['file'].'', ['alt' => ''.$review['user_name'].'', 'class'=>'img-responsive',  'data-zoom-image'=>''.UIMG.$file['file'].'']); ?>
									</a>
							  <?php }
						  		}
                          }?>
						</div>
					
					</div>
				</div>
				
				
				
				<div class="col-md-10 col-sm-10 reviews-info">
					<div class="reviews-evaluation eval-<?= $review['rating'] ?>"></div>                            
					
					<div class="reviews-txt"><?= $review['comment'] ?></div>                            
					
					<div class="reviews-footer bold_font">
						<div class="reviews-name"><?= $review['user_name'] ?></div>                                
						<div class="reviews-date"><?= $review['date'] ?></div>
					</div>
				</div>
			</div><!-- /Reviews ITEM -->
            
				
		<?php }?>
        
		</div><!-- /Reviews LIST -->
                
		<div class="col-md-12 col-sm-12 margin-top60  margin-bottom30 center">
			<button type="button" onClick=" $('#addReview').slideDown(900);" class="lis_btn lis_btn_or fw_btn">Добавить отзыв</button>
		</div>
	</div><!-- /container -->
</section>

<form id="addReview" action="/home/review/" method="post" enctype="multipart/form-data">
	<section class="cart_form_block">
		<div class="container">
			<!-- CART FORM -->
			<div class="row shop_cart_row"> 
				<h3 class="cart_form_header">
					<span>Ваш отзыв очень важен для нас!</span> 
					Заполните пожалуйста форму
				</h3>
				<div class="orange_border"></div>
				
				<div class="form-group margin-top40">
					<label for="review" class="col-sm-3 footer-label">Ваш отзыв</label>
					<div class="col-sm-9">
						<textarea class="footer-input" id="review" name="review" placeholder="Ваш отзыв"></textarea>
					</div>
				</div>
				
				<div class="form-group margin-top60">
					<label for="size" class="col-sm-3 footer-label">Ваша оценка</label>
					<div class="col-sm-9">
						<input type="hidden" id="size" name="size" value="5">
						<ul id="product-size-dd" class="review-evaluation">
							<li class="active"><a data-val="5" href="#">5</a></li>
							<li><a data-val="4" href="#">4</a></li>
							<li><a data-val="3" href="#">3</a></li>
							<li><a data-val="2" href="#">2</a></li>
							<li><a data-val="1" href="#">1</a></li>
						</ul>
					</div>
				</div>
				
				<div class="form-group margin-top30">
					<label for="" class="col-sm-12 footer-label">Загрузить фото Вашей обновки. Возможно загрузить не более 5 фотографий. </label>
				</div>
				
				<div class="form-group review-files">
					<label for="files" class="col-sm-3 footer-label review-camera"></label>
					<div class="col-sm-9">
						<input type="file" multiple='true' min='1' max='5' class="footer-input" id="files" name="files[]" placeholder="Кликните для загрузки">
					</div>
				</div>
				
				<div class="col-md-12 center margin-top60  margin-bottom60">
					<button type="submit"  class="lis_btn lis_btn_or fw_btn">Отправить отзыв</button>
                    <?php 
					/* onClick="mainScript.addReview();" */
					?>
                    <div class="response"></div>
				</div>
				
			</div>
		</div>
	</section> 
</form> 