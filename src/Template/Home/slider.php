<?php if ($mainBanList){?>
<!-- OWL SLIDER 
    
    Note: 'cover' class = if background image used!
    Nice backgrounds: 
        assets/images/demo/layerslider/slide-b-bg-yellow.jpg
        assets/images/demo/layerslider/bg4.jpg
        assets/images/demo/layerslider/slide-b-1.png
-->
<div class="slider cover margin-bottom40 new_home_slider" style="background-image:url('<?=IMG?>slide-b-bg.jpg')">

    <div class="container">

        <!-- add class "controlls-over" if you need the button controlls over the image -->
        <div class="bottom-pagination owl-carousel controlls-over controls-hover-only" data-plugin-options='{"stopOnHover":false, "slideSpeed":1500, "autoPlay":3000, "items": 1, "autoHeight": false, "navigation": true, "pagination": true, "transitionStyle":"fadeUp"}'><!-- transitionStyle: fade, backSlide, goDown, fadeUp,  -->
            <?php foreach ($mainBanList as $ban){
				$href= "#";
				$blank= "";
				if ($ban['link']) {$href = $ban['link'];}
				if ($ban['target']) {$blank = "_blank";}
				?>
				<div class="text-center">
                    <a href="<?=$href?>" target="<?=$blank?>">        
                        <?=$this->Html->image(GIMG.$ban['file'], ['alt' => $ban['name'], 'class' => 'img-responsive']);?>
                    </a>
                </div>
			<?php }?>
        </div>


    </div>

</div>
<!-- /OWL SLIDER -->
<?php }?>