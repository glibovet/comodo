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
		
		<div class="row"><!-- faq LIST  -->
        	<?php foreach ($faq as $faq){  ?>
		
			<div class="reviews-item"><!-- faq ITEM  -->
				<div class="reviews-border"></div>
				
				<div class="col-md-2 col-sm-2">
					<div class="reviews-img">
                       <?= $this->Html->image('B_ico.png', ['alt' => 'question']); ?>
					</div>
				</div>
				
				
				
				<div class="col-md-10 col-sm-10 reviews-info">
					<div class="reviews-evaluation eval-<?= $faq['question'] ?>"></div>                            
					
					<div class="reviews-txt"><?= $faq['answer'] ?></div>  
				</div>
			</div><!-- /faq ITEM -->
            
				
		<?php }?>
        
		</div><!-- /faq LIST -->
	</div><!-- /container -->
</section>