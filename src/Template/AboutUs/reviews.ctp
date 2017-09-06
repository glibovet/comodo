<section class="banner">
	<h1><?= PNAME ?></h1>
</section>


<section class="bread-crumbs">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-20 col-lg-offset-4 col-md-18 col-md-offset-6 col-sm-18 col-sm-offset-6 col-xs-24 col-xs-offset-0">
				<ul>
					<li><a href="/"><?=MAIN?></a></li>
                    <?php $alias=""; foreach ($breadCr as $bCramp){
						$alias .=$bCramp['alias']."/";
						?>
						<li><a href="<?=RS.$alias?>">| <?=$bCramp['name']?></a></li>                    
                    <?php }?>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="reviews">
    <div class="container">
        <div class="col-lg-16 col-lg-offset-4">
            <h2><?php if (LANG_PREFIX == "") { echo "Приветствуем Вас, наши друзья и партнёры!";}elseif (LANG_PREFIX == "en_") { echo "We welcome you, our friends and partners!";}?></h2>
            <h3><?php if (LANG_PREFIX == "") { echo "Компания It Fur Line стремится предоставить высокий уровень обслуживания для своих клиентов. Мы будем рады Вашим отзывам и предложениям =)";}elseif (LANG_PREFIX == "en_") { echo "It Fur Line Company is committed to providing a high level of service to its customers. We welcome your feedback and suggestions =)";}?></h3>
            <hr>

            <?php if ($siteComments){
				foreach ($siteComments as $comment) {?>
                <div class="reviews-item">
                    <p><span class="rating">                    
					<?php $i=0; while ($i<$comment['rating']){ $i++;?>
                        <i></i>
                    <?php }?>	
                    </span><span class="name"><?= $comment['name'] ?></span></p>
                    <?php if ($comment['caption']) {?> <p class="title"><?= $comment['caption'] ?></p> <?php }?>
                    <p><?= $comment['comment'] ?></p>
                </div>
                <?php }
			}?>
            
            <div class="write-reviews">
                <p><?php if (LANG_PREFIX == "") { echo "Ваш отзыв";}elseif (LANG_PREFIX == "en_") { echo "Your review";}?></p>
            </div>
             <form action="#" id="siteCommForm" method="post">
                <div class="reviews-text">
                    <div class="input-wrap">
                    <label><input type="text" placeholder="<?php if (LANG_PREFIX == "") { echo "Тема";}elseif (LANG_PREFIX == "en_") { echo "Subject";}?>" name="title"></label>
                    </div>
                    <div class="input-wrap">
                    <label><textarea placeholder="<?php if (LANG_PREFIX == "") { echo "Текс сообщения";}elseif (LANG_PREFIX == "en_") { echo "Comment";}?>" name="coment"></textarea></label>
                    </div>
                </div>
                <div class="reviews-rating">
                    <p><?php if (LANG_PREFIX == "") { echo "Оцените нас";}elseif (LANG_PREFIX == "en_") { echo "Rate us";}?></p>
                    <ul>
                        <li><input type="radio" name="rating" id="one-star" value="5"><label for="one-star"></label></li>
                        <li><input type="radio" name="rating" id="two-star" value="4"><label for="two-star"></label></li>
                        <li><input type="radio" name="rating" id="three-star" value="3"><label for="three-star"></label></li>
                        <li><input type="radio" name="rating" id="four-star" value="2"><label for="four-star"></label></li>
                        <li><input type="radio" name="rating" id="five-star" value="1"><label for="five-star"></label></li>
                    </ul>
                </div>
                <div class="response"></div>   
                <button type="button" onClick="mainScript.addSiteComm();"><?php if (LANG_PREFIX == "") { echo "Отправить";}elseif (LANG_PREFIX == "en_") { echo "Send";}?></button>
            </form>
        </div>
    </div>
</section>