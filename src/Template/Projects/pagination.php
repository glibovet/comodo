<ul>
    
	<?php

        if($f_pages_count <= $f_page_size)
        {
            for($i=1; $i <= $f_pages_count; $i++)
            {
            ?>
                 <?php if ($i==1){?>
                 	<li><a href="<?=RS.LANG."/".LANG_URL?>">1</a></li>
                 <?php } else{?>                 
                 	<li><a class="<?php echo ($i == $f_page_num ? "active" : "") ?>" href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
                 <?php } ?>                
            <?php
            }
        }
        elseif( $f_page_num <= 3 )
        {
            for($i=1; $i <= $f_page_size; $i++)
            {
            ?>
                 <?php if ($i==1){?>
                 	<li><a href="<?=RS.LANG."/".LANG_URL?>">1</a></li>
                 <?php } else{?>                 
                 	<li><a class="<?php echo ($i == $f_page_num ? "active" : "") ?>" href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
                 <?php } ?>
            
            <?php
            }
            ?>
                <li><a href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num+1) ?>);">...</a></li>
                <li><a class="pageCounterNum" href="javascript:void(0);" onClick="goCatalogPage(<?php echo $f_pages_count ?>);"><?= $f_pages_count ?></a></li>
            <?php
        }
        elseif( $f_pages_count > ($f_page_size+2) && $f_page_num < ($f_pages_count-2) )
        {
            ?>
            <li><a href="<?=RS.LANG."/".LANG_URL?>">1</a></li>
            <li><a class="pageCounterNum" href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num-1) ?>);">...</a></li>
            <?php
            for($i=($f_page_num-2); $i <= ($f_page_num+2); $i++)
            {
            ?>
                <li><a class="<?php echo ($i == $f_page_num ? "active" : "") ?>" href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
            
            <?php
            }
            ?>
                <li><a class="pageCounterNum" href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num+1) ?>);">...</a></li>
                <li><a class="pageCounterNum" href="javascript:void(0);" onClick="goCatalogPage(<?php echo $f_pages_count ?>);"><?= $f_pages_count ?></a></li>
            <?php
        }
        else{
            ?>
            <li><a class="pageCounterNum" href="<?=RS.LANG."/".LANG_URL?>">1</a></li>
            <li><a class="pageCounterNum" href="javascript:void(0);" onClick="goCatalogPage(<?php echo ($f_page_num-1) ?>);">...</a></li>
            <?php
            for($i=($f_pages_count-($f_page_size-1)); $i <= $f_pages_count; $i++)
            {
            ?>
                <li><a class="<?php echo ($i == $f_page_num ? "active" : "") ?>" href="javascript:void(0);" onClick="goCatalogPage(<?php echo $i ?>);"><?php echo $i ?></a></li>
            
            <?php
            }
        }
     ?>
</ul>
<?php if ($f_page_num < $f_pages_count){?> 
	<button type="button" onClick="goCatalogPage(<?=$f_page_num+1?>);">Далее</button>
<?php }?>