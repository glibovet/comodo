<?php 
	$typeIcon = "text";
	if ($blogArticle['video']){ $typeIcon = "video"; }
	if ($ArtGallery){ $typeIcon = "photo"; }
?>
<section class="banner">
		<h1> <?php if (LANG_PREFIX == "") { echo "Блог";}elseif (LANG_PREFIX == "en_") { echo "Blog";}?></h1>
	</section>

	<section class="bread-crumbs">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-16 col-lg-offset-4 col-md-20 col-md-offset-2 col-sm-22 col-sm-offset-1 col-xs-24">
					<ul>
						<li><a href="<?= RS ?>"><?=MAIN?></a></li>
						<li><a href="<?= RS ?>blog/">| <?php if (LANG_PREFIX == "") { echo "Блог";}elseif (LANG_PREFIX == "en_") { echo "Blog";}?></a></li>
						<li><a href="<?= RS ?>blog/<?= $blogArticle['alias'] ?>/">| <?= $blogArticle['name'] ?></a></li>
					</ul>
					<ul class="social-icon">
						<li><a href="#" class="f-facebook"></a></li>
						<li><a href="#" class="f-vk"></a></li>
						<li><a href="#" class="f-ok"></a></li>
					</ul>
					<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="facebook,vkontakte,odnoklassniki"></div>
				</div>
			</div>
		</div>
	</section>

	<?php if ($ArtGallery ){?>
    <section class="owl-carousel-blog" style="max-height: 70vh; overflow: hidden;">
    	<?php foreach ($ArtGallery as $gal){?>
            <div class="carousel-item">
                <?= $this->Html->image(GIMG.$gal['file'], ['alt' => $gal['title']]); ?>
            </div>
        <?php }?>
	</section>
    <?php }
	elseif ($blogArticle['video'] ){?>
    <section class="article_video">
    	<?=$blogArticle['video']?>
	</section>
    <?php }?>
    
    

	<div class="post-wrap">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-16 col-lg-offset-4 col-md-20 col-md-offset-2 col-sm-22 col-sm-offset-1 col-xs-24">
					<div class="post-2-page">
						<h2><?= $blogArticle['name'] ?></h2>
                        
						<?= $blogArticle['content'] ?>
                        
						<div class="date-and-type <?php if (!$ArtGallery && ! $blogArticle['video']){echo "date-txt-art";}?>">
							<?= $this->Html->image($typeIcon.'.png', ['alt' => $typeIcon]); ?>
							<p class="date">
                            	<span class="month"><?php if($blogArticle['mm']<10) { echo "0"; }?><?= $blogArticle['mm']; ?>.<?php if($blogArticle['dd']<10) { echo "0"; }?><?= $blogArticle['dd']; ?></span>
                                <span class="year"><?= $blogArticle['yy']; ?></span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="coments-wrap">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-16 col-lg-offset-4 col-md-20 col-md-offset-2 col-sm-22 col-sm-offset-1 col-xs-24">
					<div class="coments">
						<div class="title">
							<h3><?php if (LANG_PREFIX == "") { echo "КОММЕНТАРИИ <span>К ПОСТУ</span>";}elseif (LANG_PREFIX == "en_") { echo "Post <span>COMMENTS </ span>";}?><span class="count">/ <?php if (!$blogArticle['comm_count']){echo "0";} else {echo $blogArticle['comm_count'];} ?></span></h3>
						</div>
						<?php if (!$blogArticle['comm_count']){?>
                        <p class="first-coment"><?php if (LANG_PREFIX == "") { echo "Смелее! Ваш комментарий будет первым.";}elseif (LANG_PREFIX == "en_") { echo "Go ahead! Be first to comment.";}?> :)</p>
                        <?php }?>
						<form id="artCommForm" action="#" method="post"> 
                            <input type="hidden" name="art_id" value="<?= $blogArticle['id'] ?>">      
							<textarea name="coment" class="text-coment"></textarea>
                            <div class="response"></div>                                
							<button type="button" onClick="mainScript.addArtComm();"><?php if (LANG_PREFIX == "") { echo "отправить";}elseif (LANG_PREFIX == "en_") { echo "Send";}?></button>
							<button type="reset"><?php if (LANG_PREFIX == "") { echo "отменить";}elseif (LANG_PREFIX == "en_") { echo "cancel";}?></button>
						</form> 
                        
						<button type="button" id="showCommForm"><?php if (LANG_PREFIX == "") { echo "Коментировать";}elseif (LANG_PREFIX == "en_") { echo "Comment";}?></button>
                        
                        <div class="clear"></div>
                        
						<?php if ($artComments) { 
							foreach ($artComments as $comment) {?>
								<div class="coment-item">
									<p class="coment-title"><span class="name"><?= $comment['name'] ?></span><span class="date"><?php if($comment['mm']<10) { echo "0"; }?><?= $comment['mm']; ?>.<?php if($blogArticle['dd']<10) { echo "0"; }?><?= $comment['dd']; ?>.<?= $comment['yy']; ?></span></p>
									<p><?= $comment['comment'] ?></p>
								</div>
							<?php }
						}?>
					</div>
				</div>
			</div>
		</div>
	</div>