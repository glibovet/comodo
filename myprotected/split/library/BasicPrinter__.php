<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Core system
	
class BasicPrinter
{
   		public function __construct()
		{
		} 
		
		public function pre($arr,$name="Массив")
		{
			echo '<br><pre>'.$name.": "; print_r($arr); echo '</pre><br>';
		}
		public function rs($query)
		{
			try
			{
				$_stmt	= $this->dbh->prepare($query);
				//echo '<p>'.$query.'</p>';
				$_res	= $_stmt->execute();
				$_arr 	= $_res->fetchallAssoc();
				
				return $_arr;
			}catch(Exception $e)
			{
				echo 'WP WARNING: '.$e;
				return array();
			}
		}
		public function hr($header)
		{
			return "
			<div class='clear'></div><br>
                <h4 class='new-line'>$header</h4>
            <div class='clear'></div>
			";
		}
		public function clear()
		{
			return "<div class='clear'></div>";
		}
		
		public function print_hidden($name,$value)
		{
			return "
			
			<div class='zen-form-item'>
                	<input	id='save-$name' class='my-field' type='hidden' value='$value' name='$name' />
            </div>
			
            ";
		}
		public function print_input($title,$name,$hold,$value,$size=25,$onchange="")
		{
			return "
			
			<div class='zen-form-item'>
				<label for='save-$name'>$title</label><br>
				<div class='zif-wrap'>
                	<input	id='save-$name' class='my-field' type='text' placeholder='$hold' onchange=\"$onchange\" onkeyup=\"$onchange\" 
                    		value='$value' name='$name' size='$size' />
                </div>
            </div>
			
            ";
		}
		public function print_redactor($title,$name,$value)
		{
			return "
			<div class='clear'></div>
           		<div class='zen-form-item'>
					<label for='save-$name'>$title</label><br>
					<div class='zif-wrap'>
                		<textarea	id='save-$name' class='my-txtarea redactor' placeholder='HTML editor' 
                        			name='$name'>$value</textarea>
                	</div>
            	</div>
            <div class='clear'></div>
			";
		}
		public function print_area($title,$name,$hold,$value)
		{
			return 
			"
			<div class='clear'></div>
           		<div class='zen-form-item'>
					<label for='save-$name'>$title</label><br>
					<div class='zif-wrap'>
                		<textarea	id='save-$name' class='my-txtarea' placeholder='$hold' 
                        			name='$name'>$value</textarea>
                	</div>
            	</div>
            <div class='clear'></div>
			";
		}
		public function print_date($title,$name,$value)
		{
			$value = date("Y-m-d",strtotime($value));
			
			if($value == "1970-01-01") $value = "";
			
			return "
			<div class='zen-form-item'>
				<label for='save-$name'>$title</label><br>
				<div class='zif-wrap-date'>
                	<input id='save-$name' class='my-field' type='date' 
                    	   value='".$value."' name='$name' />
                </div>
            </div>
			";
		}
		
		public function print_select($title,$currValue,$list,$fieldValue,$fieldTitle,$name,$change,$first=array(),$type=false)
		{
			$result = "";
			
			$result .= "
				<div class='zen-form-item'>
					<label for='save-$name'>$title</label><br>
						<div class='zif-wrap-select styled-select'>               	
							<select class='sampling_changed' id='save-$name' name='$name' onChange='$change'>";
							
			if($first)
			{
				$curr_selected = ($first[$fieldValue]==$currValue ? "selected" : "");
				$result .= "<option $curr_selected value='".$first[$fieldValue]."'>".$first[$fieldTitle]."</option>";
			}
			
			if($type)
			{
				switch($type)
				{
					case 'brandTree':
					{
						foreach($list as $item)
						{
							$result .= "<optgroup label='".$item[$fieldTitle]."' value='".$item[$fieldValue]."'></optgroup>";
							foreach($item['childs'] as $child)\
							{
								$curr_selected = ($child[$fieldValue]==$currValue ? "selected" : "");
								$result .= "<option $curr_selected value='".$child[$fieldValue]."'> - ".$child[$fieldTitle]."</option>";
							}
						}
						break;
					}
					default:break;
				}
			}else
			{
				foreach($list as $item)
				{
					$curr_selected = ($item[$fieldValue]==$currValue ? "selected" : "");
					$result .= "<option $curr_selected value='".$item[$fieldValue]."'>".$item[$fieldTitle]."</option>";
				}
			}
			
            $result .=     "</select>
						</div>
				</div>
			";
			
			return $result;
		}
		
		public function print_select_tree_rec($tree_table,$value,$parent=0,$level=0)
		{
			$query = "SELECT id,parent,name FROM [pre]$tree_table WHERE `parent`=".$parent." ORDER BY id LIMIT 1000";
			$items = $this->rs($query);
			foreach($items as $item)
			{
				?>
					<option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $value) echo ' selected'; ?> ><?php 
											for($i = 0; $i < $level;$i++)
											{
												echo "&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											echo "- ".$item['name']; ?></option>
				<?php
					
					$this->print_select_tree_rec($tree_table,$value,$item['id'],$level+1);
			}
		}
		public function print_select_tree($title,$name,$hold,$value,$change,$tree_table)
		{
			?>
			<div class="zen-form-item">
				<label for="save-<?php echo $name ?>"><?php echo $title ?></label><br>
				<div class="zif-wrap-select styled-select">               	
					<select class="sampling_changed" id="save-<?php echo $name ?>" name="<?php echo $name ?>" onChange="<?php echo $change ?>">
						<?php
                        if($hold)
						{
							?><option value="0" selected ><?php echo $hold ?></option><?php
						}
						$this->print_select_tree_rec($tree_table,$value);
						?>
					</select>
				</div>
			</div>
			<?php
		}
		public function print_multiselect($title,$name,$data,$values)
		{
			?>
			<div class="zen-form-item">
				<label for="save-<?php echo $name ?>"><?php echo $title ?></label><br>
				<div class="zif-wrap-select styled-select" style="height:100px;">               	
					<select style="height:100px;" class="sampling_changed" id="save-<?php echo $name ?>" name="<?php echo $name ?>[]" multiple size="7">
						<?php
						foreach($data as $item)
						{
							$in_arr = false;
							foreach($values as $val){ if($val['id'] == $item['id']) { $in_arr = true; break; } }
							?><option value="<?php echo $item['id'] ?>" <?php if($in_arr) echo 'selected' ?> ><?php echo $item['name'] ?></option><?php
						}
						?>
					</select>
				</div>
			</div>
			<?php
		}
		public function print_rotator($title,$name,$value,$reverse = false)
		{
			$ans = ($reverse ? !$value : $value);
			
			$ff_ans = ($reverse ? 'no' : 'yes');
			$fs_ans = ($reverse ? 'yes' : 'no');
			
			$sf_ans = ($reverse ? 'yes' : 'no');
			$ss_ans = ($reverse ? 'no' : 'yes');
			
			return "
			
			<div class='zen-form-item'>
				<label for='radio-$name-yes'>$title</label><br>
                <div class='hidden'>
                	<input type='radio' name='".$name."[]' id='radio-$name-yes' value='0' ".(!$value ? " checked" : "")." >
                    <input type='radio' name='".$name."[]' id='radio-$name-no' value='1' ".($value ? " checked" : "")." >
                </div>
				<div class='zif-wrap-rotator'>
                	<div class='check_yn'>
                    	<div class='item_yn  ".(!$ans ? " active" : "")."' id='$name-$ff_ans' onClick=\"change_rotator('$name','$ff_ans','$fs_ans');\">Нет</div>
                        <div class='item_yn  ".($ans ? " active" : "")."' id='$name-$sf_ans' onClick=\"change_rotator('$name','$sf_ans','$ss_ans');\">Да</div>
                    </div>
                </div>
            </div>
			
            ";
		}
		
		public function print_image_mono($header, $field, $value, $path, $appTable ,$id)
		{
			$result = "
			 <div class='clear'></div>
        	
            <input type='file' name='$field' class='hidden' id='editor-file-input' onChange=\"split_txt($(this).val());\">
                
                <div class='zen-form-item'>
					<label for='save-editor-input-file'>$header</label><br>
					<div class='zif-wrap'>
                		<input  id='save-editor-input-file'					class='my-field' 
                        		type='text' 								placeholder='../' 
                        		value=''									name='editor-input-file' 
                                size='25'									maxlength='255'
                                onchange='' 								disabled='disabled' />
                        <button class='my-field' type='button' title='Выбрать файл' onClick=\"check_file();\">Выбрать</button>
                        <button class='my-close' type='button' title='Сбросить выбор' onClick=\"uncheck_file();\">&nbsp;</button>
                	</div>
            	</div>
                
        	<div class='clear'></div>
            <div class='editor-files-wrapper' id='editor-files-wrapper-$field'>";
            if(file_exists("../../../../..".$path.$value) && trim($value) != "")
			{
				$result .= "
				<div class='item' id='media-item-$field'>
                	<img class='close-file-item' alt='X' title='Удалить файл' src='".WP_FOLDER."img/close-icon.png' onClick=\"delete_media_item('$appTable','$id','$field','$path','$value');\">
					<div class='item-inside'>
                    	<a class='theater' href='".$path.$value."' title='Modal view' rel='group'>
							<img alt='File not found' src='".$path.$value."'>
						</a>
                    <div class='icode hidden' contenteditable='true' 
                    	onmouseover=\"$(this).stop().animate({'bottom':'0px'},400,'easeInOutExpo');\"
                        onmouseout=\"$(this).stop().animate({'bottom':'-80px'},400,'easeInOutExpo');\">
                    	<xmp>XMP_TEXT</xmp>
                    </div>
                    </div>
                </div>";
			}
			$result .= "
			</div>
            <div class='hidden' id='editor-files-buffer'></div>
            
            <div class='clear'></div>
			";
			
			return $result;
		}
		
		public function show_card_images()
		{
			?>
			 <div class="clear"></div>
        
            <form	name="editor-files-form" action="<?php echo WP_FOLDER ?>ajax/insert/editor-file-upload.php" 
            		enctype="multipart/form-data" target="_blank" method="POST">
            	
                <input type="hidden" name="table" value="files_ref">
                <input type="hidden" name="ref_table" value="shop_products">
                <input type="hidden" name="ref_id" value="<?php echo $this->id ?>">
                <input type="hidden" name="file_path" value="files/shop/products/">
                <input type="hidden" name="admin_id" value="<?php echo ADMIN_ID ?>">
                <input type="file" name="file" class="hidden" id="editor-file-input" onChange="split_txt($(this).val());">
                
                <div class="zen-form-item">
					<label for="save-editor-input-file">Изображение</label><br>
					<div class="zif-wrap">
                		<input  id="save-editor-input-file"					class="my-field" 
                        		type="text" 								placeholder="../" 
                        		value=""									name="editor-input-file" 
                                size="25"									maxlength="255"
                                onchange="" 								disabled="disabled" />
                        <button class="my-field" type="button" title="Выбрать файл" onClick="check_file();">Выбрать</button>
                        <button class="my-close" type="button" title="Сбросить выбор" onClick="uncheck_file();">&nbsp;</button>
                	</div>
            	</div>
                
                <div style="display:none;">
                <div class="zen-form-item hidden">
					<label for="save-file-link-yes">Ссылка?</label><br>
                	<div class="hidden">
                		<input  type="radio" name="is_link[]" id="radio-file-link-yes" value="1">
                	    <input  type="radio" name="is_link[]" id="radio-file-link-no" value="0" checked >
                	</div>
					<div class="zif-wrap-rotator">
                		<div class="check_yn">
                    		<div class="item_yn" 
                            	 id="file-link-yes" 
                                 onclick="change_rotator('file-link','yes','no');">Да</div>
                    	    <div class="item_yn active" 
                            	 id="file-link-no" 
                                 onclick="change_rotator('file-link','no','yes');">Нет</div>
                    	</div>
                	</div>
            	</div>
                
                <div class="zen-form-item hidden">
					<label for="save-file-link">Ссылка для перехода</label><br>
					<div class="zif-wrap">
                		<input  id="save-file-link"							class="my-field" 
                        		type="text" 								placeholder="#" 
                        		value=""									name="link" 
                                size="25"									maxlength="100"
                                onchange="" />
                	</div>
            	</div>
                
                <div class="zen-form-item hidden">
					<label for="save-file-target-yes">Новая вкладка</label><br>
                	<div class="hidden">
                		<input  type="radio" name="is_target[]" id="radio-file-target-yes" value="1">
                	    <input  type="radio" name="is_target[]" id="radio-file-target-no" value="0" checked >
                	</div>
					<div class="zif-wrap-rotator">
                		<div class="check_yn">
                    		<div class="item_yn" 
                            	 id="file-target-yes" 
                                 onclick="change_rotator('file-target','yes','no');">Да</div>
                    	    <div class="item_yn active" 
                            	 id="file-target-no" 
                                 onclick="change_rotator('file-target','no','yes');">Нет</div>
                    	</div>
                	</div>
            	</div>
                </div><!-- none -->
                
                <div class="zen-form-item">
                	<label for="save-submit"></label><br>
					<div class="zif-wrap">
                        <button class="my-field-submit" type="submit" title="Загрузить файл">Загрузить</button>
                	</div>
            	</div>
            </form>
        
        
        	<div class="clear"></div>
            
            <?php
            $query = "SELECT * FROM [pre]files_ref 
						WHERE `ref_table`='".$this->table."' 
						AND `ref_id`='".$this->id."' 
						LIMIT 100";
			$_res = $this->rs($query);
			?>
            
            <div class="editor-files-wrapper" id="editor-files-wrapper-1">
            <?php
            foreach($_res as $rf)
			{
				$rf_data = '';
				if($rf['is_link'])
				{
					$rf_data .= '<a href="'.$rf['href'].'" ';
					if($rf['target'])
					{
						$rf_data .= 'target="_blank" ';
					}
					$rf_data .= '>';
				}
				
				$rf_data .= '<img alt="Not found" src="/'.WP_FOLDER.$rf['path'].$rf['file'].'">'; 
				
				if($rf['is_link'])
				{
					$rf_data .= '</a>';
				}
			?>
            	<div class="item" id="rf-item-<?php echo $rf['id'] ?>">
                	<img class="close-file-item" alt="X" title="Удалить файл" src="<?php echo WP_FOLDER ?>img/close-icon.png" onClick="delete_rf(<?php echo $rf['id'] ?>);">
                	<div class="item-inside">
                    	<img alt="File not found" src="/split/<?php echo $rf['path'] ?>crop/<?php echo $rf['crop'] ?>">
                    <div class="icode hidden" contenteditable="true" 
                    	onmouseover="$(this).stop().animate({'bottom':'0px'},400,'easeInOutExpo');"
                        onmouseout="$(this).stop().animate({'bottom':'-80px'},400,'easeInOutExpo');">
                    	<xmp><?php echo $rf_data ?></xmp>
                    </div>
                    </div>
                </div>
            <?php
			}
			?>
            </div>
            <div class="hidden" id="editor-files-buffer"></div>
            
            <div class="clear"></div>
			<?php
		}
		
		// Функция правильной урезки строки по количеству символов
		public function cropStr($str, $size)
		{ 
  			return mb_substr($str,0,mb_strrpos(mb_substr($str,0,$size,'utf-8'),' ','utf-8'),'utf-8');
		}
		
		public function __destruct(){}
}