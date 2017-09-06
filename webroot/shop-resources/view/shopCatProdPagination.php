							<!-- PAGINATION text-center -->
							<div class="row">
								<div class="col-md-12">
									<ul class="pagination">
									<?php

									if($f_pages_count <= $f_pag_size)
									{
										for($i=1; $i <= $f_pages_count; $i++)
										{
										?>
											<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="<?php echo SELF_LINK . "page/" . $i ?>"><?php echo $i ?></a></li>
										
										<?php
										}
									}
									elseif( $f_page_num <= 3 )
									{
										for($i=1; $i <= $f_pag_size; $i++)
										{
										?>
											<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="<?php echo SELF_LINK . "page/" . $i ?>"><?php echo $i ?></a></li>
										
										<?php
										}
										?>
											<li><a href="<?php echo SELF_LINK . "page/" . ($f_page_num+1) ?>"><i class="fa fa-angle-right"></i></a></li>
											<li><a href="<?php echo SELF_LINK . "page/" . $f_pages_count ?>"><i class="fa fa-angle-double-right"></i></a></li>
										<?php
									}
									elseif( $f_pages_count > ($f_pag_size+2) && $f_page_num < ($f_pages_count-2) )
									{
										?>
										<li><a href="<?php echo SELF_LINK . "page/1/" ?>"><i class="fa fa-angle-double-left"></i></a></li>
										<li><a href="<?php echo SELF_LINK . "page/" . ($f_page_num-1) ?>"><i class="fa fa-angle-left"></i></a></li>
										<?php
										for($i=($f_page_num-2); $i <= ($f_page_num+2); $i++)
										{
										?>
											<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="<?php echo SELF_LINK . "page/" . $i ?>"><?php echo $i ?></a></li>
										
										<?php
										}
										?>
											<li><a href="<?php echo SELF_LINK . "page/" . ($f_page_num+1) ?>"><i class="fa fa-angle-right"></i></a></li>
											<li><a href="<?php echo SELF_LINK . "page/" . $f_pages_count ?>"><i class="fa fa-angle-double-right"></i></a></li>
										<?php
									}
									else{
										?>
										<li><a href="<?php echo SELF_LINK . "page/1/" ?>"><i class="fa fa-angle-double-left"></i></a></li>
										<li><a href="<?php echo SELF_LINK . "page/" . ($f_page_num-1) ?>"><i class="fa fa-angle-left"></i></a></li>
										<?php
										for($i=($f_pages_count-($f_pag_size-1)); $i <= $f_pages_count; $i++)
										{
										?>
											<li class="<?php echo ($i == $f_page_num ? "active" : "") ?>"><a href="<?php echo SELF_LINK . "page/" . $i ?>"><?php echo $i ?></a></li>
										
										<?php
										}
									}
									?>
									</ul>
								</div>

							</div>
							<!-- /PAGINATION -->
							