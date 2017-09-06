<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tables MENU</title>
</head>

<?php
	$table = $_GET['name'];
	
	$table_query = "SHOW COLUMNS FROM ".$table;
		$table_stmt = $dbh->prepare($table_query);
		$table_stmt->execute();
                	
	$table_result_arr = $table_stmt->fetchallAssoc();
	
	$table_fields = array();
	
	foreach($table_result_arr as $table_result)
	{
		array_push($table_fields,array(
										'Field'		=>$table_result['Field'],
										'Type'		=>$table_result['Type'],
										'Null'		=>$table_result['Null'],
										'Key'		=>$table_result['Key'],
										'Default'	=>$table_result['Default'],
										'Extra'		=>$table_result['Extra']
										));
	}
	
	$info_query = "SELECT * FROM [pre]tables_info WHERE `table_name`='".$table."' LIMIT 1";
	
		$info_stmt = $dbh->prepare($info_query);
		$info_arr = $info_stmt->execute();
	
		$info = $info_arr->fetchallAssoc();
	
	if(sizeof($info) == 0)
	{
		$insert_info_query = "INSERT INTO [pre]tables_info (`table_name`,`details`,`fields`) VALUES ('".$table."','Без описания.','')";
		
			$insert_info_stmt = $dbh->prepare($insert_info_query);
			$insert_info_stmt->execute();
		
		$info_query = "SELECT * FROM [pre]tables_info WHERE `table_name`='".$table."' LIMIT 1";
	
			$info_stmt = $dbh->prepare($info_query);
			$info_arr = $info_stmt->execute();
	
			$info = $info_arr->fetchallAssoc();
	}
?>

<body>
		<button class="right red" type="button" onclick="$('#delete_table_wrap').slideToggle(0);">Удалить таблицу</button>
        <button class="right brown" type="button" onclick="$('#add_table_row_wrap').slideToggle(0);">+ Добавить строку</button>
        <button class="right brown" type="button" onclick="$('#add_table_field_wrap').slideToggle(0);">+ Добавить поле</button>
        <button class="right brown" type="button" onclick="$('#page_content').html(loader); $('#page_content').load('ajax/load/table.view.load.php?name=<?php echo $table ?>');">Содержание</button>
        <button class="right brown" type="button" onclick="load_sub_menu('table','<?php echo $table ?>');">Структура</button>
		<h3>Таблица <input	type="text" name="table_name" placeholder="<?php echo $table ?>" value="<?php echo $table ?>" 
        					onchange="$('#result_action').load('ajax/edit/table.rename.edit.php?table=<?php echo $table ?>&new_name='+$(this).val());" />
        
        <span id="loadProgress"></span></h3>
        
        <div id="delete_table_wrap" class="hidden">
        	<fieldset>
                <legend>Вы уверены что хотите удалить таблицу?</legend>
                <form name="delete_table_form" action="ajax/delete/table.delete.self.php" method="POST" target="_blank">
                	<input type="hidden" name="table" value="<?php echo $table ?>">
                    <button class="red" type="submit">Да, удалить таблицу</button>
                    <button class="green" type="button" onclick="$('#delete_table_wrap').hide(100);">Нет, отменить действие</button>
                </form>
         	</fieldset>
        </div>
        
        <div id="add_table_field_wrap" class="hidden">
        	<fieldset>
                <legend>Добавить новое поле в таблицу:</legend>
                <form name="add_table_field_form" action="ajax/insert/table.insert.php" method="POST" target="_blank">
                <input type="hidden" name="table" value="<?php echo $table ?>">
                <table>
                	<tr>
                    	<td>Имя поля:</td>
                        <td><input type="text" name="fieldname" value=""></td>
                    </tr>
                    <tr>
                    	<td>Вставить после:</td>
                        <td>
                        	<select name="fieldafter">
                            	<?php
                                foreach($table_fields as $table_res)
								{
									?>
									<option value="<?php echo $table_res['Field'] ?>"><?php echo $table_res['Field'] ?></option>
									<?php
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td>Тип поля:</td>
                        <td>
                        	<select name="fieldtype">
                            	<option value="VARCHAR">VARCHAR</option>
                                <option value="INT">INT</option>
                                <option value="FLOAT">FLOAT</option>
                                <option value="TEXT">TEXT</option>
                                <option value="DATETIME">DATETIME</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td>Размер:</td>
                        <td><input type="number" name="fieldsize" value="255"></td>
                    </tr>
                    <tr>
                    	<td>По умолчанию:</td>
                        <td><input type="text" name="fielddefault" value="0"></td>
                    </tr>
                    <tr>
                    	<td>Индекс?</td>
                        <td>
                        	<select name="fieldindex">
                            	<option value="0">Нет</option>
                                <option value="1">Да</option>
                            </select>	
                        </td>
                    </tr>
                </table>
                <button class="green" type="submit" onclick="$('#loadProgress').html(loader);">Добавить</button>
                </form>
            </fieldset>
        </div>
        
        <div id="add_table_row_wrap" class="hidden">
        	<fieldset>
                <legend>Добавить новую строку в таблицу:</legend>
                <form name="add_table_row_form" action="ajax/insert/table.row.insert.php" method="POST" target="_blank">
                <input type="hidden" name="table" value="<?php echo $table ?>">
                <table>
                	<?php
                    	foreach($table_fields as $field)
						{
							if($field['Extra'] == 'auto_increment'){ ?><tr class="hidden"><td><?php echo $field['Field'] ?>:</td><td><input type="hidden" name="field['<?php echo $field['Field'] ?>']" value="NULL"></td></tr><?php }
							elseif($field['Field'] == 'dateCreate' || $field['Field'] == 'dateModify')
							{ 
							?>
                            	<tr class="hidden"><td><?php echo $field['Field'] ?>:</td><td><input type="hidden" name="field['<?php echo $field['Field'] ?>']" value="<?php echo date("Y-m-d H:i:s") ?>"></td></tr>
							<?php 
							}else // else 1
							{
								$field_type = "text";
								if($field['Type'] == 'datetime')
								{
									$field_type = "date";
								}
								elseif($field['Type'] == 'text')
								{
									$field_type = "textarea";
								}else
								{
									$posInt = strpos($field['Type'], 'int');
									$posFloat = strpos($field['Type'], 'int');
									
									if($posInt || $posFloat)
									{
										$field_type = "number";
									}
								}
							if($field_type == "textarea")
							{
								?>
								<tr>
                    				<td><?php echo $field['Field'] ?>:</td>
                        			<td><textarea name="field['<?php echo $field['Field'] ?>']" placeholder="Text..."></textarea></td>
                    			</tr>
								<?php
							}else
							{	
								?>
								<tr>
                    				<td><?php echo $field['Field'] ?>:</td>
                        			<td><input type="<?php echo $field_type ?>" name="field['<?php echo $field['Field'] ?>']" value="<?php echo $field['Default'] ?>"></td>
                    			</tr>
								<?php
							}
							} // end else 1
						}
					?>
                </table>
                <button class="green" type="submit" onclick="$('#loadProgress').html(loader);">Добавить</button>
                </form>
            </fieldset>
        </div>
        
       <div id="page_content">
                <table class="bordered">
                	<tr>
                    	<th>#</th>
                        <th>Поле</th>
                        <th>Тип</th>
                        <th>Null</th>
                        <th>Key</th>
                        <th>Default</th>
                        <th>Extra</th>
                        <th>Удалить</th>
                    </tr>
				<?php
					$cnt = 0;
					//$row_name = "Tables_in_".$db_name;
					foreach($table_fields as $table_res)
					{
						$cnt++;
						?>
						<tr>
                    		<td class="first-column"><?php echo $cnt ?></td>
                    	    <td title="<?php echo $table_res['Field'] ?>">
								<?php
                                if($table_res['Extra'] != "auto_increment")
								{
								?>
                                <form name="form_edit_field" id="form_edit_field_<?php echo $table_res['Field'] ?>" action="ajax/edit/table.field.rename.edit.php" method="POST" target="_blank">
                					<input type="hidden" name="table" value="<?php echo $table ?>">
                                    <input type="hidden" name="field" value="<?php echo $table_res['Field'] ?>">
                                    <input type="hidden" name="type" value="<?php echo $table_res['Type'] ?>">
                                    <input	type="text" name="new_name" placeholder="<?php echo $table_res['Field'] ?>" value="<?php echo $table_res['Field'] ?>"
                                    		onchange="$('#form_edit_field_<?php echo $table_res['Field'] ?>').submit();">
								</form>
                                <?php
                                }else{ echo $table_res['Field']; }
								?>
							</td>
                    	    <td><?php echo $table_res['Type'] ?></td>
                    	    <td><?php echo $table_res['Null'] ?></td>
                    	    <td><?php echo $table_res['Key'] ?></td>
                    	    <td><?php echo $table_res['Default'] ?></td>
                    	    <td><?php echo $table_res['Extra'] ?></td>
                            <td class="last-column">
                            	<form name="del_table_field_form" action="ajax/delete/table.delete.php" method="POST">
                					<input type="hidden" name="table" value="<?php echo $table ?>">
                                    <input type="hidden" name="field" value="<?php echo $table_res['Field'] ?>">
                                	<button title="Моментальное удаление!" class="red" type="submit" onclick="$('#loadProgress').html(loader);">Удалить</button>
								</form>
                            </td>
                    	</tr>
						<?php
						//echo '<pre>'; print_r($table_result); echo '</pre>';
					}
				?>
                </table>
       <div id="result_action"></div>
       
       <div class="clear"></div>
       <div class="table-info">
       		<?php echo $info[0]['details'] ?>
       </div>
       
        </div>
</body>

<script type="text/javascript" language="javascript">
	$('form[name=add_table_field_form]').ajaxForm(function(){
			load_sub_menu('table','<?php echo $table ?>');
		});
	$('form[name=del_table_field_form]').ajaxForm(function(){
			load_sub_menu('table','<?php echo $table ?>');
		});
	$('form[name=add_table_row_form]').ajaxForm(function(){
			load_sub_menu('table','<?php echo $table ?>');
		});
	$('form[name=form_edit_field]').ajaxForm(function(){
			$('#result_action').html('Поле переименованно');
		});
	$('form[name=delete_table_form]').ajaxForm(function(){
			$('.hidden').hide(100);
			$('#page_content').html('<center>Таблица <b><?php echo $table ?></b> удалена.</center>');
		});
</script>

</html>