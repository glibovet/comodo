<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../../require.base.php";
	
	$app_id = 0; // TEMPLATE APPLICATION
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>Load CREATE ITEM</title>
</head>

<?php
	$card_data = unserialize($_POST['card_data']);
	
	if($card_data['files'] != null) $files_data = $card_data['files'];
	
	$table = $card_data['table'];
?>

<body>
	<?php
	if(sizeof($card_data) > 0 && $card_data['type'] != 'dialog')
	{
    //echo '<pre>'; print_r($card_data); echo '</pre>';
	?>
	<div class="ipad-20" id="order_conteinter">
    	<form name="create-item-form" action="<?php echo WP_FOLDER ?>ajax/insert/create-item.php" method="POST" target="_blank">
            
           <input type="hidden" name="item_data" value='<?php echo serialize(array()) ?>'>
           <input type="hidden" name="card_data" value='<?php echo serialize($card_data) ?>'>
        
        <?php
        foreach($card_data['fields'] as $field)
		{
			if($field['new_line'] != null)
			{
				?>
				<div class="clear"></div>
					<h4 class="new-line"><?php echo $field['new_line'] ?></h4>
				<div class="clear"></div>
				<?php
			}
			
			switch($field['type'])
			{
				case 'text':{ 
				?>
				<div class="zen-form-item">
					<label for="save-<?php echo $field['name'] ?>"><?php echo $field['title']; if($field['important']) echo "*"; ?></label><br>
					<div class="zif-wrap">
                		<input  id="save-<?php echo $field['name'] ?>"		class="my-field" 
                        		type="text" 								placeholder="<?php echo $field['default'] ?>" 
                        		value=""									name="<?php echo $field['name'] ?>" 
                                size="<?php echo $field['size'] ?>"			maxlength="<?php echo $field['maxlength'] ?>"
                                onchange="<?php echo $field['onchange'] ?>" />
                	</div>
            	</div>
				<?php
							break;
							}
				case 'textarea':
				{
					?>
					<div class="clear"></div>
            			<div class="zen-form-item">
                		<label for="save-<?php echo $field['name'] ?>"><?php echo $field['title']; ?></label><br>
							<div class="zif-wrap-date">
                				<textarea 	id="save-<?php echo $field['name'] ?>" class="my-field" 
 									   	placeholder="<?php echo $field['default'] ?>" 
                        	        	name="<?php echo $field['name'] ?>"></textarea>
                			</div>
            			</div>
            		<div class="clear"></div>
					<?php
					break;
				}
				case 'email':{ 
				?>
				<div class="zen-form-item">
					<label for="save-<?php echo $field['name'] ?>"><?php echo $field['title']; if($field['important']) echo "*"; ?></label><br>
					<div class="zif-wrap">
                		<input  id="save-<?php echo $field['name'] ?>"		class="my-field" 
                        		type="email" 								placeholder="<?php echo $field['default'] ?>" 
                        		value=""									name="<?php echo $field['name'] ?>" 
                                size="<?php echo $field['size'] ?>"			maxlength="<?php echo $field['maxlength'] ?>"
                                onchange="<?php echo $field['onchange'] ?>" />
                	</div>
            	</div>
				<?php
							break;
							}
				case 'password':{ 
				?>
				<div class="zen-form-item">
					<label for="save-<?php echo $field['name'] ?>"><?php echo $field['title']; if($field['important']) echo "*"; ?></label><br>
					<div class="zif-wrap">
                		<input  id="save-<?php echo $field['name'] ?>"		class="my-field" 
                        		type="password" 							placeholder="<?php echo $field['default'] ?>" 
                        		value=""									name="<?php echo $field['name'] ?>" 
                                size="<?php echo $field['size'] ?>"			maxlength="<?php echo $field['maxlength'] ?>"
                                onchange="<?php echo $field['onchange'] ?>" />
                	</div>
            	</div>
				<?php
							break;
							}
				case 'phone':{ 
				?>
				<div class="zen-form-item">
					<label for="save-<?php echo $field['name'] ?>"><?php echo $field['title']; if($field['important']) echo "*"; ?></label><br>
					<div class="zif-wrap">
                		<span>+</span>
                        <input  id="save-<?php echo $field['name'] ?>"		class="my-field" 
                        		type="phone" 								placeholder="<?php echo $field['default'] ?>" 
                        		value=""	name="<?php echo $field['name'] ?>" 
                                size="<?php echo $field['size'] ?>"			maxlength="<?php echo $field['maxlength'] ?>"
                                onchange="<?php echo $field['onchange'] ?>" />
                	</div>
            	</div>
				<?php
							break;
							}
				case 'datetime':{ 
				?>
				<div class="zen-form-item">
					<label for="save-<?php echo $field['name'] ?>"><?php echo $field['title']; if($field['important']) echo "*"; ?></label><br>
					<div class="zif-wrap-date">
                		<input  id="save-<?php echo $field['name'] ?>" class="my-field" 
                        		type="date" 							placeholder="<?php echo $item['default'] ?>" 
                                value="" 
                                name="<?php echo $field['name'] ?>" 	size="<?php echo $field['size'] ?>" />
                	</div>
            	</div>
				<?php
							break;
							}
				case 'radio':{ 
				$choices = array();
				foreach($field['data'] as $choice => $choice_val)
				{
					array_push($choices,$choice);
				}
				?>
				 <div class="zen-form-item">
					<label for="save-<?php echo $field['name'] ?>-yes"><?php echo $field['title']; if($field['important']) echo "*"; ?></label><br>
                	<div class="hidden">
                		<input  type="radio" name="<?php echo $field['name'] ?>[]" id="radio-<?php echo $field['name'] ?>-yes" 
                        		value="<?php echo $choices[0] ?>" <?php if($choices[0]) echo 'checked="checked"'; ?> >
                	    <input  type="radio" name="<?php echo $field['name'] ?>[]" id="radio-<?php echo $field['name'] ?>-no" 
                        		value="<?php echo $choices[1] ?>" <?php if(!$choices[0]) echo 'checked="checked"'; ?> >
                	</div>
					<div class="zif-wrap-rotator">
                		<div class="check_yn">
                    		<div class="item_yn <?php if($choices[0]) echo 'active'; ?>" 
                            	 id="<?php echo $field['name'] ?>-yes" 
                                 onclick="change_rotator('<?php echo $field['name'] ?>','yes','no');"><?php echo $field['data'][$choices[0]] ?></div>
                    	    <div class="item_yn <?php if(!$choices[0]) echo 'active'; ?>" 
                            	 id="<?php echo $field['name'] ?>-no" 
                                 onclick="change_rotator('<?php echo $field['name'] ?>','no','yes');"><?php echo $field['data'][$choices[1]] ?></div>
                    	</div>
                	</div>
            	</div>
				<?php
							break;
							}
				case 'select':{ 
				?>
				<div class="zen-form-item">
					<label for="save-<?php echo $field['name'] ?>"><?php echo $field['title']; if($field['important']) echo "*"; ?></label><br>
					<div class="zif-wrap-select styled-select">               	
						<select class="sampling_changed" id="save-<?php echo $field['name'] ?>" 
                        		name="<?php echo $field['name'] ?>" onchange='<?php echo $field['onchange'] ?>'
                         >
							<?php
							if($field['default'] != null && $field['default'] != '0')
							{
								?>
								<option value="0" selected="selected" data-skip="1"><?php echo $field['default'] ?></option>
								<?php
							}
                	        foreach($field['data'] as $option)
							{
								?><option value="<?php echo $option[$field['ref_field']] ?>" ><?php echo $option[$field['ref_name']] ?></option><?php
							}
							?>
						</select>
					</div>
				</div>
				<?php
							break;
							}
				default: break;
			}
		}
		?>
            
            <div class="clear"></div>
            
		<?php
		if(sizeof($card_data['extra_fields']) > 0)
		{
			?>
			<?php
		}
        foreach($card_data['extra_fields'] as $ef_iter => $ef)
		{
			?>
			<div class="wp-form-extra-fields-wrap" id="wp-form-extra-fields-wrap-<?php echo $ef_iter ?>">
			<br>
			<h4><?php echo $ef['title'] ?></h4>
            <br>
			<p>Выберите элемент из списка для загрузки формы.</p>
			<?php
			/*
			$refs = array(); // Буферный массив для хранения результатов SQL запросов
			
			switch($ef['type'])
			{
				case 'group':
				{
					$ef_refs	= $ef['refs'];
					$ef_group	= $ef['groups'];
						
						$ref_obj = $ef_refs[$ef_group['parent']];
						
						$query = "SELECT ";
						
						//echo '<hr> - '.$ref_obj['type'].' - <hr>';
						
						switch($ref_obj['type'])
						{
							case 'simple':
							{	
								$query_fields = "";
								$qf_cnt = 0;
								
								foreach($ref_obj['fields'] as $ro_field)
								{
									$qf_cnt++;
									if($qf_cnt == 1)
									{
										$query_fields .= $ro_field;
									}else
									{
										$query_fields .= ", ".$ro_field;
									}
								}
								
								$query .= $query_fields." FROM [pre]".$ref_obj['table'];
								
								$query_where = " WHERE 1 ";
								
								foreach($ref_obj['where'] as $ro_where)
								{
									if($ro_where['parent'] == 'item')
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$item[$ro_where['parent_field']]."' ";
									}else
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$refs[$ro_where['parent']][$ef_iter][$ro_where['parent_field']]."' ";
									}
								}
								
								$query .= $query_where." ORDER BY ".$ref_obj['order']." LIMIT ".$ref_obj['limit'];
								
									$_stmt	= $dbh->prepare($query);
									$_arr	= $_stmt->execute();
								
								$_res = $_arr->fetchallAssoc();
								
								$refs[$ef_group['parent']] = $_res;
								
								// Выполняем actions для текущей итерации
								
								break; // case SIMPLE
							}
							case 'join':
							{
								$query_fields = "";
								$qf_cnt = 0;
								
								foreach($ref_obj['fields'] as $ro_field)
								{
									$qf_cnt++;
									if($qf_cnt == 1)
									{
										$query_fields .= $ro_field;
									}else
									{
										$query_fields .= ", ".$ro_field;
									}
								}
								
								$query .= $query_fields." FROM [pre]".$ref_obj['table']." AS ".$ref_obj['as'];
								
								$query_join = "";
								$join_cnt = 0;
								
								foreach($ref_obj['join'] as $join)
								{
									$join_cnt++;
									$query_join .= " LEFT JOIN [pre]".$join['table']." AS ".$join['as']." ON ".$join['on']."  ";
								}
								
								$query .= $query_join;
								
								$query_where = " WHERE 1 ";
								
								foreach($ref_obj['where'] as $ro_where)
								{
									if($ro_where['parent'] == 'item')
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$item[$ro_where['parent_field']]."' ";
									}else
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$refs[$ro_where['parent']][$ef_iter][$ro_where['parent_field']]."' ";
									}
								}
								
								$query .= $query_where." ORDER BY ".$ref_obj['order']." LIMIT ".$ref_obj['limit'];
								
								echo $query;
								
									$_stmt	= $dbh->prepare($query);
									$_arr	= $_stmt->execute();
								
								$_res = $_arr->fetchallAssoc();
								
								$refs[$ef_group['parent']] = $_res;
								
								break; // case JOIN
							}
							default: break;
						}
						
							foreach($_res as $iter_cnt => $iter_data) // FOREACH IN GROUP
							{
								
								foreach($ef_group['actions'] as $action)
								{
									$iter_obj = $ef_refs[$action];
						
									$query = "SELECT ";
									
									//echo '<hr> --> '.$iter_obj['type'].' - <hr>';
						
									switch($iter_obj['type'])
									{
										case 'simple':
										{	
											$query_fields = "";
											$qf_cnt = 0;
								
											foreach($iter_obj['fields'] as $ro_field)
											{
												$qf_cnt++;
												if($qf_cnt == 1)
												{
													$query_fields .= $ro_field;
												}else
												{
													$query_fields .= ", ".$ro_field;
												}
											}
								
											$query .= $query_fields." FROM [pre]".$iter_obj['table'];
								
											$query_where = " WHERE 1 ";
								
											foreach($iter_obj['where'] as $ro_where)
											{
												if($ro_where['parent'] == 'item')
												{
													$query_where .= " AND ".$ro_where['ref_field']." = '".$item[$ro_where['parent_field']]."' ";
												}else
												{	
													$query_where .= " AND ".$ro_where['ref_field']." = '".$refs[$ro_where['parent']][$iter_cnt][$ro_where['parent_field']]."' ";
												}
											}
								
											$query .= $query_where." ORDER BY ".$iter_obj['order']." LIMIT ".$iter_obj['limit']; 
								
												$_stmt	= $dbh->prepare($query);
												$_arr	= $_stmt->execute();
								
											$_res = $_arr->fetchallAssoc();
								
											$refs[$action] = $_res;
								
											break; // case SIMPLE
										}
										case 'join':
										{
											$query_fields = "";
											$qf_cnt = 0;
								
											foreach($iter_obj['fields'] as $ro_field)
											{
												$qf_cnt++;
												if($qf_cnt == 1)
												{
													$query_fields .= $ro_field;
												}else
												{
													$query_fields .= ", ".$ro_field;
												}
											}
								
											$query .= $query_fields." FROM [pre]".$iter_obj['table']." AS ".$iter_obj['as'];
								
											$query_join = "";
											$join_cnt = 0;
								
											foreach($iter_obj['join'] as $join)
											{
												$join_cnt++;
												$query_join .= " LEFT JOIN [pre]".$join['table']." AS ".$join['as']." ON ".$join['on']."  ";
											}
								
											$query .= $query_join;
								
											$query_where = " WHERE 1 ";
								
											foreach($iter_obj['where'] as $ro_where)
											{
												if($ro_where['parent'] == 'item')
												{
													$query_where .= " AND ".$ro_where['ref_field']." = '".$item[$ro_where['parent_field']]."' ";
												}else
												{
													$query_where .= " AND ".$ro_where['ref_field']." = '".$refs[$ro_where['parent']][$iter_cnt][$ro_where['parent_field']]."' ";
												}
											}
								
											$query .= $query_where." ORDER BY ".$iter_obj['order']." LIMIT ".$iter_obj['limit'];
											
											$_stmt	= $dbh->prepare($query);
											$_arr	= $_stmt->execute();
								
											$_res = $_arr->fetchallAssoc();
								
											$refs[$action] = $_res;
											
											break; // case JOIN
										}
										default: break;
									}
									
								}
								
								// echo '<pre>REFS: '; print_r($refs); echo '</pre>'; die();
								
								?>
								 
                                 	<div class="clear"></div>
                        			<h4><?php echo $refs[$ef_group['title_parent']][0][$ef_group['title_value']] ?></h4>
                                    <?php
									
                                    foreach($refs[$ef_group['field']['field_parent']] as $ref_item)
									{
										//echo '<pre>REFS: '; print_r($ref_item); echo '</pre>'; die();
										
										$value = "";
										
										if($ref_item[$ef_group['field']['type']] == "DATETIME")
											{
										?>
											<div class="zen-form-item">
												<label  for="<?php echo $ef_group['field']['id'] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                                		title="<?php echo $ref_item[$ef_group['field']['field_title']] ?>"><?php echo $ref_item[$ef_group['field']['field_name']] ?></label><br>
												<div class="zif-wrap-date">
                								<input	id="<?php echo $ref_item[$ef_group['field']['id']] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                						class="my-field"
                                						type="date" 
                                        				placeholder="Выберите дату" 
                                        				value="" 
                                        				name="<?php echo $ef_group['field']['name'] ?>[<?php echo $ref_item[$ef_group['field']['field_num']] ?>]"
                                				/>
                								</div>
            								</div>
										<?php	
										}else
										{
										?>
											<div class="zen-form-item">
												<label  for="<?php echo $ef_group['field']['id'] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                                	  	title="<?php echo $ref_item[$ef_group['field']['field_title']] ?>"><?php echo $ref_item[$ef_group['field']['field_name']] ?></label><br>
												<div class="zif-wrap">
                								<input	id="<?php echo $ref_item[$ef_group['field']['id']] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                						class="my-field"
                                						type="text" 
                                        				placeholder="<?php echo $ref_item[$ef_group['field']['default']] ?>" 
                                        				value="" 
                                        				name="<?php echo $ef_group['field']['name'] ?>[<?php echo $ref_item[$ef_group['field']['field_num']] ?>]" 
                                        				size="<?php echo $ref_item[$ef_group['field']['size']] ?>"
                                     			  		maxlength="<?php echo $ref_item[$ef_group['field']['maxlength']] ?>"
                                				/>
                								</div>
            								</div>
										<?php
										}
									}
									
									?>
								<?php
								
							} // END FOREACH IN GROUP
					
					break; // case GROUP
				}
				case 'list':
				{
					break; // case LIST
				}
				default: break;
			}
			*/
			?>
			</div>
			<?php
		}
		
		if($card_data['editor'] != null && sizeof($card_data['editor']) > 0)
		{
			$editor = $card_data['editor'];
			?>
            <div class="clear"></div>
            	<div class="zen-form-item">
                	<label for="save-<?php echo $editor['field'] ?>"><?php echo $editor['title']; ?></label><br>
					<div class="zif-wrap-date">
                		<textarea 	id="save-<?php echo $editor['field'] ?>" class="my-field" 
 								   	placeholder="<?php echo $editor['default'] ?>"
                                	name="<?php echo $editor['field'] ?>" /></textarea>
                	</div>
            	</div>
            <div class="clear"></div>
			<?php
		}
		
		?>
       
       <div class="clear"></div>
        
        <?php
        if($card_data['admin_access'] != null && $card_data['admin_access'] == 1)
		{
			$query = "SELECT * FROM [pre]admin_menu WHERE `parent` = 0 ORDER BY order_id LIMIT 100";
			
			$_stmt	= $dbh->prepare($query);
			$_arr	= $_stmt->execute();
			
			$parents = $_arr->fetchallAssoc();
			
			foreach($parents as $parent)
			{
				$query = "SELECT * FROM [pre]admin_menu WHERE `parent`='".$parent['id']."' ORDER BY order_id LIMIT 100";
				
				$_stmt	= $dbh->prepare($query);
				$_arr	= $_stmt->execute();
				
				$childs = $_arr->fetchallAssoc();
				
				?>
				<div class="clear"></div>
                <h4 class="new-line" title="<?php echo $parent['details'] ?>"><?php echo $parent['name'] ?></h4>
            	<div class="clear"></div>
				<?php
				$acc = 1;
				
				foreach($childs as $child)
				{
				?>
				<div class="zen-form-item" title="<?php echo $child['details'] ?>">
					<label for="save-menu-<?php echo $child['id'] ?>-yes"><?php echo $child['name'] ?></label><br>
                	<div class="hidden">
                		<input  type="radio" name="admin_access[<?php echo $child['id'] ?>]" id="radio-menu-<?php echo $child['id'] ?>-yes" value="1" <?php if($acc) echo 'checked' ?> >
                	    <input  type="radio" name="admin_access[<?php echo $child['id'] ?>]" id="radio-menu-<?php echo $child['id'] ?>-no" value="0" <?php if(!$acc) echo 'checked' ?> >
                	</div>
					<div class="zif-wrap-rotator">
                		<div class="check_yn">
                    		<div class="item_yn <?php if($acc) echo 'active' ?>" 
                            	 id="menu-<?php echo $child['id'] ?>-yes" 
                                 onclick="change_rotator('menu-<?php echo $child['id'] ?>','yes','no');">Да</div>
                    	    <div class="item_yn <?php if(!$acc) echo 'active' ?>" 
                            	 id="menu-<?php echo $child['id'] ?>-no" 
                                 onclick="change_rotator('menu-<?php echo $child['id'] ?>','no','yes');">Нет</div>
                    	</div>
                	</div>
            	</div>	
				<?php
				}
			}
		}
		?>
            
        </form>
        
        <?php
        
		// Вывод управление файлами для текстового редактора
		
		if($card_data['editor'] != null && sizeof($card_data['editor']) > 0)
		{
			?>
            <div class="clear"></div>
            <h4 class="new-line">Управление файлами</h4>
            <div class="clear"></div>
            <form	name="editor-files-form" action="<?php echo WP_FOLDER ?>ajax/insert/editor-file-upload.php" 
            		enctype="multipart/form-data" target="_blank" method="POST">
            	
                <input type="hidden" name="table" value="files_ref">
                <input type="hidden" name="ref_table" value="<?php echo $card_data['table'] ?>">
                <input type="hidden" name="ref_id" value="0">
                <input type="hidden" name="file_path" value="<?php echo $editor['file_path'] ?>">
                <input type="hidden" name="admin_id" value="<?php echo ADMIN_ID ?>">
                <input type="file" name="file" class="hidden" id="editor-file-input" onchange="split_txt($(this).val());">
                
                <div class="zen-form-item">
					<label for="save-editor-input-file">Изображение</label><br>
					<div class="zif-wrap">
                		<input  id="save-editor-input-file"					class="my-field" 
                        		type="text" 								placeholder="../" 
                        		value=""									name="editor-input-file" 
                                size="25"									maxlength="255"
                                onchange="" 								disabled="disabled" />
                        <button class="my-field" type="button" title="Выбрать файл" onclick="check_file();">Выбрать</button>
                        <button class="my-close" type="button" title="Сбросить выбор" onclick="uncheck_file();">&nbsp;</button>
                	</div>
            	</div>
                
                <div class="zen-form-item">
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
                
                <div class="zen-form-item">
					<label for="save-file-link">Ссылка для перехода</label><br>
					<div class="zif-wrap">
                		<input  id="save-file-link"							class="my-field" 
                        		type="text" 								placeholder="#" 
                        		value=""									name="link" 
                                size="25"									maxlength="100"
                                onchange="" />
                	</div>
            	</div>
                
                <div class="zen-form-item">
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
                
                <div class="zen-form-item">
                	<label for="save-submit"></label><br>
					<div class="zif-wrap">
                        <button class="my-field-submit" type="submit" title="Загрузить файл">Загрузить</button>
                	</div>
            	</div>
            </form>
            
            <div class="clear"></div>
            
            <?php
            $query = "SELECT * FROM [pre]files_ref WHERE `ref_table`='".$card_data['table']."' AND `ref_id`='0' AND `adminMod`='".ADMIN_ID."' LIMIT 100";
			
			$_stmt = $dbh->prepare($query);
			$_arr = $_stmt->execute();
			
			$_res = $_arr->fetchallAssoc();
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
                	<img class="close-file-item" alt="X" title="Удалить файл" src="<?php echo WP_FOLDER ?>img/close-icon.png" onclick="delete_rf(<?php echo $rf['id'] ?>);">
                	<div class="item-inside">
                    	<img alt="File not found" src="/split/<?php echo $rf['path'] ?>crop/<?php echo $rf['crop'] ?>">
                    <div class="icode" contenteditable="true" 
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
		
		// Конец вывода управления файлами для текстового редактора
		
		foreach($files_data as $fd_count => $fd)
		{
			//$fd['update_table'] = $table;
			switch($fd['type'])
			{
				case 'one_photo':
				{
					$query = "SELECT id,".$fd['field']." FROM [pre]".$fd['table']." WHERE 1 ";
					
					foreach($fd['refs'] as $fd_ref)
					{
						if($fd_ref['source'] == 'item')
						{
							$query .= " AND `".$fd_ref['ref']."` = '".$item[$fd_ref['field']]."' ";
						}else
						{
							$query .= " AND `".$fd_ref['ref']."` = '".$refs[$fd_ref['source']][0][$fd_ref['field']]."' ";
						}
					}
					
					$query .= " LIMIT 1";
					
						$_stmt	= $dbh->prepare($query);
						$_arr	= $_stmt->execute();
					
						$_res = $_arr->fetchallAssoc();
					
					$_file_id = $_res[0]['id'];
					$_file = trim($_res[0][$fd['field']]);
					
					?>
					<div class="wp-form-extra-fields-wrap">
						<div class="clear"></div>
						<h4><?php echo $fd['group_title'] ?></h4>
                    	<div class="clear"></div>
                    
                    <div class="photo-frame" id="photo-frame-<?php echo $fd_count ?>">
           			<?php
            			if($_file != "" && $_file != "0")
						{
					?>
						<img alt="Photo Not Found" 
                        	 src="../<?php echo $fd['path'].$fd['crop'].$fd['crop_w']."x".$fd['crop_h']."_".$_file ?>" 
                        	 title="<?php echo $fd['title'] ?>"
                         >
					<?php
						}else
						{
					?>
            			<img alt="Photo" src="<?php echo WP_FOLDER."img/ava-tmp.png" ?>" title="Место под фото">
            		<?php
						}
					?>
            		</div>
            		<form id="f<?php echo $fd_count ?>" name="create-item-photo-form-<?php echo $fd_count ?>" 
                    	  action="<?php echo WP_FOLDER."ajax/insert/preload-item-photo.php" ?>" method="POST" enctype="multipart/form-data" target="_blank">
                		
                        <input  type="hidden" name="action" value="create">
                        <input	type="hidden" name="file_data" value='<?php echo serialize($fd) ?>' >
                        <input 	type="hidden" name="admin_id" value="<?php echo ADMIN_ID ?>">
                    	
                        <input 	name="file" type="file" class="hidden" id="item-photo-input-<?php echo $fd_count ?>" 
                    	   		onchange="$('#file-<?php echo $fd_count ?>-name').html($(this).val()); $('#file-submit-<?php echo $fd_count ?>').show(200);"
                    	>
                    	<div class="inside-photo-right">
                        <a  href="javascript:void(0);" 
                        	title="<?php echo $fd['action_title'] ?>" 
                            onclick="$('#item-photo-input-<?php echo $fd_count ?>').click();">Изменить</a>
                            
                    	<div id="file-<?php echo $fd_count ?>-name"></div>
                    	<div>
                        	<button type="submit" class="hidden" id="file-submit-<?php echo $fd_count ?>">Загрузить файл</button>
                        </div>
                        </div>
                	</form>
                    </div>
					<script type="text/javascript" language="javascript">
						$(function(){
									$('form[name=create-item-photo-form-<?php echo $fd_count ?>]').ajaxForm(function(){
										$('#photo-frame-<?php echo $fd_count ?>').html('<br><br>Loading...');
										var data = { admin_id:admin_id, file_data:'<?php echo serialize($fd) ?>' }
										$('#photo-frame-<?php echo $fd_count ?>').load('<?php echo WP_FOLDER."ajax/load/preload-item-photo.load.php" ?>',data,function(){
											
										$('#file-<?php echo $fd_count ?>-name').html('Файл загружен.');
										$('#file-submit-<?php echo $fd_count ?>').hide(200);
									});
								});
							});
                    </script>
					<?php
					break; // CASE ONE PHOTO
				} 
				case 'multi_photo':
				{
					break;
				} 
				case 'one_txt':
				{
					break;
				} 
				case 'multi_txt':
				{
					break;
				} 
				case 'one_doc':
				{
					break;
				} 
				case 'multi_doc':
				{
					break;
				} 
				case 'one_xls':
				{
					break;
				} 
				case 'multi_xls':
				{
					break;
				} case 'one_pdf':
				{
					break;
				} 
				case 'multi_pdf':
				{
					break;
				} 
				case 'one_csv':
				{
					break;
				} 
				case 'multi_csv':
				{
					break;
				} 
				case 'one_xml':
				{
					break;
				} 
				case 'multi_xml':
				{
					break;
				} 
				default: break;
			}
		}
		?>
        
        <div class="clear"></div>
        <div class="ajax" id="ajax-getter"></div>
        
    </div><!-- order_conteinter -->
    <?php
	}elseif($card_data['type'] == 'dialog')
	{
		?>
		<div class="ipad-20" id="order_conteinter">
    	<form name="create-item-form" action="<?php echo WP_FOLDER ?>ajax/insert/create-item.php" method="POST" target="_blank">
            
           <input type="hidden" name="item_data" value='<?php echo serialize(array()) ?>'>
           <input type="hidden" name="card_data" value='<?php echo serialize($card_data) ?>'>
           <input type="hidden" name="from_id" value="<?php echo ADMIN_ID ?>">
           <input type="hidden" name="to_id" value="0" id="to_id_dialog">
           
           		<div class="zen-form-item">
					<label for="save-to-user">Укажите получателя</label><br>
					<div class="zif-wrap">
                		<input  id="save-to-user"							class="my-field" 
                        		type="text" 								placeholder="Начните вводить имя" 
                        		value=""									name="to_name" 
                                size="115"									maxlength="115"
                                onkeypress="preload_users($(this).val());"
                                onchange="preload_users($(this).val());"
                                 />
                	</div>
                    <div class="clear"></div>
                    <div id="preload_users_wrap" class="hidden"></div>
            	</div>
                
                <div class="clear"></div>
            	<div class="zen-form-item">
                	<label for="save-message">Введите сообщение</label><br>
					<div class="zif-wrap-date">
                		<textarea 	id="save-message" class="my-field" 
 								   	placeholder="Сообщение"
                                	name="message" /></textarea>
                	</div>
            	</div>
            	<div class="clear"></div>
                
                
           
        </form>
        
		<?php
		
		// Вывод управление файлами для создания сообщения
		
		if(true)
		{
			?>
            <div class="clear"></div>
            <h4 class="new-line">Добавить файлы</h4>
            <div class="clear"></div>
            <form	name="dialog-files-form" action="<?php echo WP_FOLDER ?>ajax/insert/dialog-file-upload.php" 
            		enctype="multipart/form-data" target="_blank" method="POST">
            	
                <input type="hidden" name="table" value="dialog_files_ref">
                <input type="hidden" name="ref_table" value="users_dialogs">
                <input type="hidden" name="ref_id" value="0">
                <input type="hidden" name="file_path" value="files/dialogs/">
                <input type="hidden" name="admin_id" value="<?php echo ADMIN_ID ?>">
                <input type="file" name="file" class="hidden" id="editor-file-input" onchange="split_txt($(this).val());">
                
                <div class="zen-form-item">
					<label for="save-editor-input-file">Изображение</label><br>
					<div class="zif-wrap">
                		<input  id="save-editor-input-file"					class="my-field" 
                        		type="text" 								placeholder="../" 
                        		value=""									name="editor-input-file" 
                                size="25"									maxlength="255"
                                onchange="" 								disabled="disabled" />
                        <button class="my-field" type="button" title="Выбрать файл" onclick="check_file();">Выбрать</button>
                        <button class="my-close" type="button" title="Сбросить выбор" onclick="uncheck_file();">&nbsp;</button>
                	</div>
            	</div>
                
                <?php /* ?>
                <div class="zen-form-item">
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
                
                <div class="zen-form-item">
					<label for="save-file-link">Ссылка для перехода</label><br>
					<div class="zif-wrap">
                		<input  id="save-file-link"							class="my-field" 
                        		type="text" 								placeholder="#" 
                        		value=""									name="link" 
                                size="25"									maxlength="100"
                                onchange="" />
                	</div>
            	</div>
                
                <div class="zen-form-item">
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
                <?php */ ?>
                
                <div class="zen-form-item">
                	<label for="save-submit"></label><br>
					<div class="zif-wrap">
                        <button class="my-field-submit" type="submit" title="Загрузить файл">Загрузить</button>
                	</div>
            	</div>
            </form>
            
            <div class="clear"></div>
            
            <?php
            $query = "SELECT * FROM [pre]dialog_files_ref WHERE `ref_table`='users_dialogs' AND `ref_id`='0' AND `adminMod`='".ADMIN_ID."' LIMIT 100";
			
			$_stmt = $dbh->prepare($query);
			$_arr = $_stmt->execute();
			
			$_res = $_arr->fetchallAssoc();
			?>
            
            <div class="editor-files-wrapper" id="dialog-files-wrapper-1">
            <?php
            foreach($_res as $rf)
			{
				/*
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
				*/
			?>
            	<div class="item" id="rf-item-<?php echo $rf['id'] ?>">
                	<img class="close-file-item" alt="X" title="Удалить файл" src="<?php echo WP_FOLDER ?>img/close-icon.png" onclick="delete_dialog_rf(<?php echo $rf['id'] ?>);">
                	<div class="item-inside">
                    	<img alt="File not found" src="/split/<?php echo $rf['path'] ?>crop/<?php echo $rf['crop'] ?>">
                    
					<?php /* ?>
                    <div class="icode" contenteditable="true" 
                    	onmouseover="$(this).stop().animate({'bottom':'0px'},400,'easeInOutExpo');"
                        onmouseout="$(this).stop().animate({'bottom':'-80px'},400,'easeInOutExpo');">
                    	<xmp><?php echo $rf_data ?></xmp>
                    </div>
                    <?php */ ?>
					
                    </div>
                </div>
            <?php
			}
			?>
            </div>
            <div class="hidden" id="dialog-files-buffer"></div>
            
            <div class="clear"></div>
			<?php
		}
		
		// Конец вывода управления файлами для создания сообщения
		?>
		
        <div class="clear"></div>
        <div class="ajax" id="ajax-getter"></div>
        
        </div>
        
		<?php
		
	}else
	{
		echo '<p>Нет данных для шаблона создания элемента из списка.</p>';
	}
	?>
</body>

<script type="text/javascript" language="javascript">
	var admin_id = <?php echo ADMIN_ID ?>;
	$(function(){
			$('form[name=create-item-form]').ajaxForm(function(){
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/create-item.status.php" ?>',function(){
						});
				});
			$('form[name=editor-files-form]').ajaxForm(function(){
					var data = { admin_id:'<?php echo ADMIN_ID ?>', ref_table:'<?php echo $card_data['table'] ?>', ref_id:0 }
					$('#editor-files-buffer').load('<?php echo WP_FOLDER."ajax/load/buffer-last-file.php" ?>',data,function(){
							//$('#editor-files-buffer').show(400);
							$('#editor-files-wrapper-1').prepend($('#editor-files-buffer').html());
						});
				});
			$('form[name=dialog-files-form]').ajaxForm(function(){
					var data = { admin_id:'<?php echo ADMIN_ID ?>', ref_table:'users_dialogs', ref_id:0 }
					$('#dialog-files-buffer').load('<?php echo WP_FOLDER."ajax/load/buffer-last-dialog-file.php" ?>',data,function(){
							//$('#editor-files-buffer').show(400);
							$('#dialog-files-wrapper-1').prepend($('#dialog-files-buffer').html());
						});
				});
		});
	function preload_users(key)
	{
		$('#preload_users_wrap').html('<center>Loading...</center>');
		$('#preload_users_wrap').show();
		var data = { key:key }
		$('#preload_users_wrap').load('<?php echo WP_FOLDER."ajax/load/preload-users-by-key.php" ?>',data);
	}
	function set_key_choice(name,id)
	{
		$('#save-to-user').attr('value',name);
		$('#to_id_dialog').attr('value',id);
		$('#preload_users_wrap').hide();
	}
	function valid_phone(phone)
	{	
	}
	function change_rotator(id,place,loos)
	{
		$('#'+id+'-'+place).addClass('active');
		$('#'+id+'-'+loos).removeClass('active');
		
		$('#radio-'+id+'-'+place).click();
	}
	
	function submit_create_form(choice)
	{
		$('#ajax-getter').html('Loading...');
		$('form[name=create-item-form]').submit();
		
		switch(choice)
		{
			case 1: // Сохранить и дублировать
					{
						break;
					} 
			case 2: // Сохранить и редактировать
					{
						break;
					} 
			case 3: // Сохранить и закрыть
					{
						change_head(1); 
						load_app_content(content_path,<?php echo $app_id ?>);
						break;
					} 
			case 4: // Сохранить и создать
					{
						break;
					} 
			default: break;
		}
	}
	function reload_save_extra_fields(id,num,group)
	{
		var data = {
					id:id,
					num:num,
					group:group,
					item_data:'<?php echo serialize(array()) ?>',
					extra_fields:'<?php echo serialize($card_data['extra_fields']) ?>'
				   }
		$('#wp-form-extra-fields-wrap-'+num).html('Loading...');
		$('#wp-form-extra-fields-wrap-'+num).load('<?php echo WP_FOLDER ?>ajax/load/reload-save-extra-fields.php',data);
	}
	
	function check_file()
	{
		$('#editor-file-input').click();
	}
	function uncheck_file()
	{
		$('#editor-file-input').attr('value','');
		$('#save-editor-input-file').attr('value','../');
	}
	function split_txt(txt)
	{
		var n = txt.lastIndexOf("\\");
		//alert(txt.substr(n+1));
		$('#save-editor-input-file').attr('value',txt.substr(n+1));
	}
	function delete_rf(id)
	{
		$('#rf-item-'+id).load('<?php echo WP_FOLDER."ajax/load/delete-ref-file.php?id=" ?>'+id,function(){
				$('#rf-item-'+id).hide(400);
			});
	}
	function delete_dialog_rf(id)
	{
		$('#rf-item-'+id).load('<?php echo WP_FOLDER."ajax/load/delete-dialog-ref-file.php?id=" ?>'+id,function(){
				$('#rf-item-'+id).hide(400);
			});
	}
</script>

</html>