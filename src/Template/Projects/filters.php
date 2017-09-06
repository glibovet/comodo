<div class="filters">
<form action="#" method="POST" id="projects_filter_form">
    <input type="hidden" name="main_cat" value="1" />
    <input type="hidden" name="child_cat" value="1" />

    <input type="hidden" name="filter_group_id" value="1" />
    <input type="hidden" name="curr_link" value="<?= $ri_url ?>" />
    <input type="hidden" name="sort_vector" id="sort_vector" value="<?= $sort_vector ?>" />
    <input type="hidden" name="filter_prods_by_page" id="filter_prods_by_page" value="<?= $filter_prods_by_page ?>" />
    
    <div class="filters__caption">
        <p><?php $i=0; foreach ($site_translate as $translate){					
			if ($translate['ru_text'] == "Фильтр проектов") {
				$i++;
				if ($i==1 ) {
					echo $translate['text'];
					}
				}?>    
		<?php }?></p>
    </div>
    <!-- CHARS -->
    <div class="char_wrap">
        
    <?php if (isset($filter_chars) && $filter_chars): ?>
		<?php foreach ($filter_chars as $key => $value): ?>
            <?php if ($value['values']): ?>
                <div class="type filter_checkbox chars_items filter" >
                    <?php if ($value['name']): ?>
                        <div class="filter__caption"><?= $value['name']; ?>
                            <div class="filter__p-m-wrap">
                                <button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
                                    <span class="tcon-visuallyhidden">+</span>
                                </button>	
                            </div>
                        </div>
                        <?php
						// echo "<pre>"; print_r($value); echo "</pre>";
						
						// echo "<pre>"; print_r($checked_chars); echo "</pre>";
						?>
                        <ul class="filter__list">
                    <?php endif ?>
                    
                    <?php foreach ($value['values'] as $v_key => $char){ 

                            $activeStatus = "";
                            $checkedStatus = "";
                            $disabledStatus = "";
                            $count = 0;
                            $continueStatus = true;

                            if(isset($checked_chars[$value['id']])){
								
								if(in_array($char['val_id'],$checked_chars[$value['id']])){
                                    
									$activeStatus = "active";
                                    $checkedStatus = "checked";
                                    $continueStatus = false;
                                }
                            }
                            if($continueStatus){
                                $countStatus = false;
                                if(isset($charsList[$value['id']])){
                                    foreach($charsList[$value['id']]['values_count'] as $currCharsGroup){
                                        if($currCharsGroup['value']==$char['value']){
                                            $countStatus = true;
                                            $count = $currCharsGroup['count'];
                                            break;
                                        }
                                    }
                                }
                                if(!$count){
                                    $disabledStatus = "disabled";
                                    $disabledStatus = "disabled";
                                }
                            }
                    /*
                        <label class="filter_check <?= $activeStatus ?> <?= $disabledStatus ?>" id="<?= md5($value['id'] . trim(mb_strtolower($char['value'])) ) ?>">
                            <input type="checkbox" <?= $checkedStatus ?> <?= $disabledStatus ?> name="filter[<?= $value['id']; ?>][]" value="<?= $char['value']; ?>"/>
                            <?= $char['value'].' '.$value['measure']; ?>

                            <z class="<?= $checkedStatus ?>">(<span class="count"><?= $count ?></span>)</z>
                        </label>
                   */
				   	$labelID = md5($value['id'] . trim(mb_strtolower($char['value'])) );
				   ?>
                        <li class="filter__list-item filter_check <?= $activeStatus ?> <?= $disabledStatus ?>" id="<?= $labelID ?>">
                        	<input type="checkbox" <?= $checkedStatus ?> <?= $disabledStatus ?> name="filter[<?= $value['id']; ?>][]" value="<?= $char['val_id']; ?>" id="param-<?= $labelID ?>" />
                            <label for="param-<?= $labelID ?>">
								<?= $char['value'] ?>
                            	<z class="<?= $checkedStatus ?>">(<span class="count"><?= $count ?></span>)</z>
                            </label>
                        </li>
                    <?php 
                    } 
                    ?>
                    </ul>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    
    <?php
	
    if($filter_users)
	{
		?>
        <div class="type filter_checkbox chars_items filter" id="filter-by-mfs">
            <div class="filter__caption"><?php $i=0; foreach ($site_translate as $translate){					
					if ($translate['ru_text'] == "Архитектор") {
						$i++;
						if ($i==1 ) {
							echo $translate['text'];
							}
						}?>    
				<?php }?>
                <div class="filter__p-m-wrap">
                    <button type="button" class="tcon tcon-plus tcon-plus--minus filter__p-m" aria-label="add item">
                        <span class="tcon-visuallyhidden">+</span>
                    </button>	
                </div>
            </div>
            <ul class="filter__list">
            <?php
            foreach($filter_users as $uid_i => $item)
			{
				$activeStatus = "";
				$checkedStatus = "";
				$disabledStatus = "";
				$count = 0;
				$continueStatus = true;

					
				if(in_array($item['id'],$checked_users)){
					
					$activeStatus = "active";
					$checkedStatus = "checked";
					$continueStatus = false;
				}
				
				if($continueStatus){
					if(!$item['count']){
						$disabledStatus = "disabled";
						$disabledStatus = "disabled";
					}
				}
				
				$labelID = $item['ref_md5']; //md5("mf_id".$item['id'] . trim(mb_strtolower($item['name'])) );
				 ?>
                    <li class="filter__list-item filter_check" id="<?= $labelID ?>">
                        <input type="checkbox" <?= $checkedStatus ?> <?= $disabledStatus ?> name="users[]" value="<?= $item['id'] ?>" id="param-<?= $labelID ?>" />
                        <label for="param-<?= $labelID ?>">
                            <?= $item['name'] ?>
                            <z class="<?= $checkedStatus ?>">(<span class="count"><?= $item['count'] ?></span>)</z>
                        </label>
                    </li>
                <?php 
			}
			?>
            </ul>
        </div>
        <!-- END OF USERS FILTER GROUP -->
		<?php
	}
	
	?>
    
    </div>
    <!-- chars wrap -->
</form>
</div>