<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
$bodyId = "";
$bodyClass = "";
//if (FA == "home") {$bodyId = ""; $bodyClass = "home";}

if (LA == "home" || LA == $lang) {$bodyId = ""; $bodyClass = "home";}

else {$bodyId = ""; $bodyClass = "";}
?>
<!DOCTYPE html>
<html lang="<?=LANG?>">
<head>
	<meta name="robots" content="index, follow"/>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   	<?php if (isset ($f_page_num) && $f_page_num >=2) {?>
    	<title><?= $metaTitle.", №".$f_page_num ?></title>
    <?php } else{?>
    	<title><?= $metaTitle?></title>
    <?php } ?>
    
    <meta name="keywords" content="<?= $metaKeys ?>">
    
    <?php if (!isset ($f_page_num) || $f_page_num ==1) {?>
    	<meta name="description" content="<?= $metaDesc ?>">
    <?php } ?>
    
    <?php foreach ($site_langs as $s_lang){
		$altLang = $s_lang['alias'];
		$altHref = $_SERVER['SERVER_NAME']."/".$s_lang['alias']."/".LANG_URL;
		
		if ($s_lang['alias'] == "ua"){$altLang = "uk";}
		if ($s_lang['alias'] == "ru" && LA == "home"){$altHref = $_SERVER['SERVER_NAME']."/";}
		?>
        
        <link rel="alternate" href="<?=$altHref?>" hreflang="<?=$altLang?>" />

	<?php } ?>
    
    <?php if (isset ($f_pages_count)) {
		$relNextPage = $f_page_num+1;
		$relNextLink = "http://".$_SERVER['SERVER_NAME'].RS.LANG."/".LANG_URL."?page=".$relNextPage;
		
		$relPrevPage = $f_page_num-1;
		$relPrevLink = "http://".$_SERVER['SERVER_NAME'].RS.LANG."/".LANG_URL."?page=".$relPrevPage; ?>
        
    	<?php if ($f_page_num!=1){?>
        	<link rel="prev" href="<?=$relPrevLink?>">
        <?php }?>
        
    	<?php if ($f_page_num<$f_pages_count){?>
        	<link rel="next" href="<?=$relNextLink?>">
        <?php }?>
        
    <?php }?>
    
    <?= $this->Html->meta('icon') ?>
    <link rel="apple-touch-icon" href="<?= RS ?>apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= RS ?>apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= RS ?>apple-touch-icon-114x114.png">
        
    <!-- HOME CSS -->
    <?= $this->Html->css('libs/bootstrap-grid/bootstrap-grid-3.3.1.min.css') ?>
    <?= $this->Html->css('libs/transformicons/transformicons.css') ?>
    <?= $this->Html->css('libs/owl-carousel/owl.pack.css') ?>
    <?= $this->Html->css('libs/owl-carousel/owl.theme.css') ?>
    <?= $this->Html->css('libs/remodal/jquery.remodal.css') ?>
    <?= $this->Html->css('libs/JScrollPane2/jquery.jscrollpane.css') ?>
    <?= $this->Html->css('libs/magnific-popup/magnific-popup.css') ?>
    
    <?php if (LA == "home" || LA == $lang) {?>
	<!-- MAIN SLIDER CSS -->
    <?= $this->Html->css('libs/main-slider/essentials.css') ?>
    <?= $this->Html->css('libs/main-slider/layout.css') ?>
    <?= $this->Html->css('libs/main-slider/font-awesome.css') ?>    
    <?php }?>
    
    <?= $this->Html->css('fonts.css') ?>
    <?= $this->Html->css('main.css') ?>
    <?= $this->Html->css('media.css') ?>
    <?= $this->Html->css('final.css') ?>   
    
    <!-- Facebook Pixel Code -->
	<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1011062228915062'); 
    fbq('track', 'Переходы на www.comodo.kiev.ua');
    </script>
    <noscript>
    <img height="1" width="1" 
    src="https://www.facebook.com/tr?id=1011062228915062&ev=PageView
    &noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    
    <!-- GoogleAnalytics Code -->
    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-41294185-1', 'auto');
	  ga('send', 'pageview');
	  setTimeout(function(){ga('send', 'event', 'New Visitor', location.pathname);}, 30000);
	  ga('require', 'ec');	
	</script>    
    <!-- End GoogleAnalytics Code -->
 
</head>

<body id="<?= $bodyId ?>" class="<?= $bodyClass ?>">
	<?php include "header.php"?>        
    
     <?= $this->fetch('content') ?>
    
    <?php include "footer.php" ?>
    
    <?php include "modals.php" ?>

<!-- JAVASCRIPT HOME -->
<?= $this->Html->script('libs/jquery/jquery-2.2.0.min.js') ?> 

<script>	
	$.fn.curr_url = '<?php echo CURR_URL ?>';
	$.fn.currency = '<?php echo strtolower(CURNAME) ?>';
</script>

<?= $this->Html->script('jquery.cookie.js') ?> 
<?= $this->Html->script('libs/jquery/jquery.inputmask.bundle.js') ?> 

<?= $this->Html->script('libs/transformicons/transformicons.min.js') ?>
<?= $this->Html->script('libs/owl-carousel/owl.carousel.min.js') ?>
<?= $this->Html->script('libs/remodal/jquery.remodal.js') ?>
<?= $this->Html->script('libs/JScrollPane2/jquery.jscrollpane.min.js') ?>
<?= $this->Html->script('libs/magnific-popup/jquery.magnific-popup.min.js') ?>
<?= $this->Html->script('libs/lightbox/lightbox.js') ?>
<?= $this->Html->script('libs/masonry-filter/imagesloaded.js') ?>
<?= $this->Html->script('libs/masonry-filter/masonry-3.1.4.js') ?>
<?= $this->Html->script('libs/masonry-filter/masonry.filter.js') ?>



<?= $this->Html->script('main.js') ?>
<?= $this->Html->script('final.js') ?>


<?php if (LA == "home" || LA == $lang) {?>
	<!-- MAIN SLIDER JS -->
	<?= $this->Html->script('libs/main-slider/scripts.js') ?>
<?php }?>

<?php 
	// echo $this->Html->script('livereload.js'); 
	/* <script src="//localhost:8585/livereload.js"></script> */  
?>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'FSg6Rg0BE1';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter43605574 = new Ya.Metrika({ id:43605574, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ecommerce:"dataLayer" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/43605574" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->  

</body>
</html>
