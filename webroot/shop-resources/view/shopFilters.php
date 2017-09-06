<!-- CONTENT -->
			<section>
				<div class="container">

				<?php
				if($catsList)
				{
					?>
					<!-- PRODUCT CATEGORIES -->
					<div class="row">

						<?php
						foreach($catsList as $item)
						{
							?>
						<div class="col-sm-4 col-md-4">
							<div class="box-content thumbnail text-center">
								<a href="<?php echo $curr_page/RS.$item['alias'].'/' ?>" class="item-image"><!-- image -->
									<img class="img-responsive" src="<?php echo CAT_IMG_PATH.$item['filename'] ?>" alt="">
								</a>
								<div class="caption text-left"><!-- name -->
									<h4 class="nomargin elipsis"><?php echo $item['name'];?></h4>
								</div>
							</div>
						</div>
							<?php
						}
						?> 

						
					</div>
					<!-- /PRODUCT CATEGORIES -->
					<?php
				}
				?>
				
				<?php
				if($prodList)
				{
				?>
					<div class="row">

						<!--FILTERS-->	
						<div class="col-md-3 hidden-sm">

						<form id="filtersAction" name="catProductsFilterForm" action="#" method="POST">

							<input type="hidden" name="filter_group_id" value="<?php echo $filter_group_id ?>" />

							<input type="hidden" name="cat_id" value="<?php echo $cat_id ?>" />

							<input type="hidden" name="curr_link" value="<?php echo $curr_link ?>" />

							<div class="sky-form shop-filter">

							<h4>Цена</h4>
							<div class="form-group">
								<input id="range_3" type="text" name="range_3" value="<?php echo $max_min_price['MIN(M.price)'] ?>;<?php echo $max_min_price['MAX(M.price)']?>"/>
							</div>
							</div>
					

						<?php

							foreach($filter_chars_list as $filter)
							 { 
							 	$char_id = $filter['id'];
							 	?>
					        		
					        	<div class="sky-form shop-filter" id="products-filter-list-<?php echo $char_id ?>">
					        		<h4><?php echo $filter['name']?></h4>
							
					        		<?php
					        		foreach($filter['values'] as $curr_value)
					        		{
					        			$ref_id = $curr_value['ref_id'];

					        			$ref_md5 = md5( $char_id . trim(mb_strtolower($curr_value['value'])) );

					        			if(isset($_SESSION['prods_filter']) && isset($_SESSION['prods_filter'][$cat_id]) && isset($_SESSION['prods_filter'][$cat_id][$char_id]))
					        			{
					        				$checked = ( in_array( $curr_value['value'], $_SESSION['prods_filter'][$cat_id][$char_id] ) ? "checked" : "" );
					        				?>
											<label class="checkbox" id="<?php echo $ref_md5 ?>">
						        				<input type="checkbox" <?php echo $checked ?> name="filter[<?php echo $char_id ?>][]" value="<?php echo $curr_value['value']?>" onchange="mainScript.catProductsFilterReload();" />
						        				<i></i> <?php echo $curr_value['value']." ".$curr_value['measure'] ?> <span class="small">(<?php echo $curr_value['values_count'] ?>)</span>
						        			</label>
						        			<?php
					        			}else{
					        				$disabled = ($curr_value['values_count']==0 ? 'disabled' : ' ');
						        			?>
											<label class="checkbox" id="<?php echo $ref_md5 ?>">
						        				<input <?php echo $disabled ?> type="checkbox" name="filter[<?php echo $char_id ?>][]" value="<?php echo $curr_value['value']?>" onchange="mainScript.catProductsFilterReload();" />
						        				<i></i> <?php echo $curr_value['value']." ".$curr_value['measure'] ?> <span class="small">(<?php echo $curr_value['values_count'] ?>)</span>
						        			</label>
						        			<?php
						        		}
					        		}
					        		?>
					        	</div>

					        	<?php
					        }

						?>

							
						</form>

						</div><!-- left column col-3 -->

						<div class="col-md-9" id="ajaxCatProdList">
							<?php
								//include("shopCatProdPagination.php");

								include_once("shopCatProdList.php");
								
								include("shopCatProdPagination.php");
							?>
						</div><!-- right column col-9 -->

					</div><!-- end of row: prodList -->

				<?php 
				} // end of: if products list
				?>


				</div><!-- page container -->
			</section>
			<!-- /CONTENT -->