<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "project_chars_ref";
	
	$prodId	= (int)$_POST['prodId'];
	$charId = (int)$_POST['charId'];
	
	$data['status']="failed";
	$data['append_item_html']="";
	
	if($prodId && $charId)
	{
		$query = "INSERT INTO [pre]$appTable (`char_id`,`project_id`) VALUES ('$charId','$prodId')";
		$ah->rs($query);
		
		$refID = mysql_insert_id();
		
		if($refID)
		{
			
			$data['status']="success";
			
			ob_start();
			
			?>
            	<tr id="dinamic_char_value_<?php echo $refID ?>">
                    <td><input attrID="<?php echo $refID ?>" chartype='dinamyc' id="d_char_val_value<?php echo $refID ?>" class="my-field autocomplete" size="15" type="text" value="" placeholder="RU" onChange="save_proj_dinamic_char_value_text(<?php echo $refID ?>,<?php echo $charId ?>,'value',$(this).val(),$(this).parent().parent().find('#d_char_val_value<?php echo $refID ?>').val())" /></td>                                        
                    <td><input id="d_char_ua_val_ua_value<?php echo $refID ?>" class="my-field" size="15" type="text" value="" placeholder="UA" onChange="save_proj_dinamic_char_value_text(<?php echo $refID ?>,<?php echo $charId ?>,'ua_value',$(this).val(),$(this).parent().parent().find('#d_char_val_value<?php echo $refID ?>').val())" /></td>
                    <td><input id="d_char_en_val_en_value<?php echo $refID ?>" class="my-field" size="15" type="text" value="" placeholder="EN" onChange="save_proj_dinamic_char_value_text(<?php echo $refID ?>,<?php echo $charId ?>,'en_value',$(this).val(),$(this).parent().parent().find('#d_char_val_value<?php echo $refID ?>').val())" /></td>
                    
                    <td><button class="close-option r-z-h-s-close" type="button" title="Удалить" onclick="delete_proj_dinamic_char(<?php echo $refID ?>);"></button></td>
                </tr>
			<?php
			$data['append_item_html'] = ob_get_contents();
		
			ob_get_clean();
		}
	}
	