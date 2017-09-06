<section class="banner">
		<h1><?= PNAME ?></h1>
	</section>

	<section class="bread-crumbs">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-20 col-lg-offset-4 col-md-18 col-md-offset-6 col-sm-18 col-sm-offset-6 col-xs-24 col-xs-offset-0">
					<ul>
						<li><a href="<?= RS ?>"><?=MAIN?></a></li>
						<li><a href="">| <?= PNAME ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="blog">
		<div class="container">
			<div class="row">
				<?php foreach ($blogList as $k => $item){
					$typeIcon = "text";
					if ($item['video']){ $typeIcon = "video"; }
					if ($item['gallery_id']){ $typeIcon = "photo"; }
					if ($k == 0){?>
                    <div class="col-lg-24">
                        <div class="post">
                            <a href="<?=$item['alias']?>/">
                                <div class="photo">
                                    <?= $this->Html->image(BIMG.$item['filename'], ['alt' => $item['name']]); ?>
                                    <div class="photo-hover"></div>
                                    <?= $this->Html->image('blog-plus.png', ['alt' => '', 'class' => 'plus']); ?>
                                    <div class="date-and-type">
                                        <?= $this->Html->image($typeIcon.'.png', ['alt' => $typeIcon]); ?>
                                        <p class="date">
                                            <span class="month"><?php if($item['mm']<10) { echo "0"; }?><?= $item['mm']; ?>.<?php if($item['dd']<10) { echo "0"; }?><?= $item['dd']; ?></span>
                                            <span class="year"><?= $item['yy']; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="descr">
                                <h2><?= $item['name'] ?></h2>
                                <p><?= $this->App->next_sub_str(strip_tags($item['content']),350)  ?>... </p>
                            </div>
                        </div>
                    </div>
                <?php }
				}?>
                
                <?php foreach ($blogList as $k => $item){
					$typeIcon = "text";
					if ($item['video']){ $typeIcon = "video"; }
					if ($item['gallery_id']){ $typeIcon = "photo"; }
					if ($k >= 1){?>
                    <div class="col-lg-12 col-md-12 col-xs-24 blogPost">
                        <div class="post">
                            <a href="<?=$item['alias']?>/">
                                <div class="photo">
                                    <?= $this->Html->image(BIMG.$item['filename'], ['alt' => $item['name']]); ?>
                                    <div class="photo-hover"></div>
                                    <?= $this->Html->image('blog-plus.png', ['alt' => '', 'class' => 'plus']); ?>
                                    <!--<ul class="social-icon">
                                        <li><a href="#" class="f-instagram"></a></li>
                                        <li><a href="#" class="f-facebook"></a></li>
                                        <li><a href="#" class="f-vk"></a></li>
                                        <li><a href="#" class="f-ok"></a></li>
                                    </ul>-->
                                    <div class="date-and-type">
                                        <?= $this->Html->image($typeIcon.'.png', ['alt' => $typeIcon]); ?>
                                        <p class="date">
                                            <span class="month"><?php if($item['mm']<10) { echo "0"; }?><?= $item['mm']; ?>.<?php if($item['dd']<10) { echo "0"; }?><?= $item['dd']; ?></span>
											<span class="year"><?= $item['yy']; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="descr">
                                <h2><?= $item['name'] ?></h2>
								<p><?= $this->App->next_sub_str(strip_tags($item['content']),350)  ?>... </p>
                            </div>
                        </div>
                    </div>
                <?php }
				}?>
                
               
                <div class="clear"></div>
                
			</div>
			<div class="row">
				<div class="col-xs-24">
					<ul class="catalog-nav">
                    	
                    <?php

						if($f_pages_count <= $f_page_size)
						{
							for($i=1; $i <= $f_pages_count; $i++)
							{
							?>
								<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
							<?php
							}
						}
						elseif( $f_page_num <= 3 )
						{
							for($i=1; $i <= $f_page_size; $i++)
							{
							?>
								<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
							
							<?php
							}
							?>
								<li><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num+1) ?>);"><i class="fa fa-angle-right"></i></a></li>
								<li><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo $f_pages_count ?>);"><i class="fa fa-angle-double-right"></i></a></li>
							<?php
						}
						elseif( $f_pages_count > ($f_page_size+2) && $f_page_num < ($f_pages_count-2) )
						{
							?>
							<li><a href="javascript:void(0);" onClick="goCatalogPage(1) ?>);"><i class="fa fa-angle-double-left"></i></a></li>
							<li><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num-1) ?>);"><i class="fa fa-angle-left"></i></a></li>
							<?php
							for($i=($f_page_num-2); $i <= ($f_page_num+2); $i++)
							{
							?>
								<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
							
							<?php
							}
							?>
								<li><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num+1) ?>);"><i class="fa fa-angle-right"></i></a></li>
								<li><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo $f_pages_count ?>);"><i class="fa fa-angle-double-right"></i></a></li>
							<?php
						}
						else{
							?>
							<li><a href="javascript:void(0);" onClick="goCatalogPage(1);"><i class="fa fa-angle-double-left"></i></a></li>
							<li><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num-1) ?>);"><i class="fa fa-angle-left"></i></a></li>
							<?php
							for($i=($f_pages_count-($f_page_size-1)); $i <= $f_pages_count; $i++)
							{
							?>
								<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
							
							<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</section>