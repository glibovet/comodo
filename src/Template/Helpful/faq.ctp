<!-- CONTENT -->
<section>
	<div class="container">

		<!-- options -->
		<div class="row shop-top-options">

			<div class="col-sm-12 col-md-12 center">


				<h2 class="p-name-h2">
					
					<span class="p-name-txt">
						<span class="p-name-top"></span>
							<?= $pName ?>
						<span class="p-name-bot"></span>
					</span>
					
				</h2>

			</div>
		</div>
		<!-- /options -->
		
		<div class="row"><!-- faq LIST  -->
        	<?php foreach ($faqInfo as $faq){  ?>
		
			<div class="reviews-item faq-item  relative"><!-- faq ITEM  -->
				<div class="reviews-border fw_border"></div>
				
				<div class="col-md-1 col-sm-1 faq-lz">
					<div class="reviews-img faq-img">
                       <?= $this->Html->image('B_ico.png', ['alt' => 'question']); ?>
					</div>
				</div>
				
				
				
				<div class="col-md-11 col-sm-11 faq-rz reviews-info">
					<div class="faq-q bold_font"><?= $faq['question'] ?></div>                            
					
					<div class="reviews-txt faq-a"><?= $faq['answer'] ?></div> 
				</div> 
                
                <div class="faq-toogle toogle-show active"></div> 
                <div class="faq-toogle toogle-hide"></div>               
                
			</div><!-- /faq ITEM -->
            
				
		<?php }?>
        
		</div><!-- /faq LIST -->
	</div><!-- /container -->
</section>