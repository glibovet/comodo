<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file of Application << 19 >>
	
	$app_id = 0; // TEMPLATE APPLICATION
	
	$data = array();
	
	$data['loadsrc'] = "/".ADMIN_PATH.WP_FOLDER."/img/pulse.gif";
	$data['ajaxpath'] = "/".ADMIN_PATH.WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/content.load.php";
	
	$data['start_page'] = 1;
	$data['on_page'] = 10;
	
	if(isset($_COOKIE['on_page_'.$app_id]) && $_COOKIE['on_page_'.$app_id] != null && $_COOKIE['on_page_'.$app_id] > 5)
	{
		$data['on_page'] = $_COOKIE['on_page_'.$app_id];
	}
	
	$filtr_table = "shop_catalog";
	
	$filtr_1 = array(
					'search'	=> 'Поиск по категориям',
					'options'	=> array(
										 array(
										 	  'title'=>'Имени',
											  'value'=>'name'
											  ),
										 array(
											  'title'=>'ID',
											  'value'=>'id'
											  )
										 )
					);
	$filtr_2 = array(
					array(
						'select_title'	=> 'Опубликован',
						'select_name'	=> 'filtr[block]',
						'options'	=> array(
											array(
												'title'=>'Да',
												'value'=>'0'
												),
											array(
												'title'=>'Нет',
												'value'=>'1'
												)
											)
						)
					);
	$filtr_3 = array(
					array(
						 'title'	=>	'Название',
						 'value'	=>	'name',
						 ),
					array(
						 'title'	=>	'Состояние',
						 'value'	=>	'block',
						 ),
					array(
						 'title'	=>	'ID',
						 'value'	=>	'id',
						 ),
					
					);
	
	$tables = array(
					array(
						  'name'		=> 'shop_catalog',
						  'or_name'		=> 'CAT',
						  'ref_table'	=> '',
						  'ref_field'	=> '',
						  'ref_on'		=> '',
						  'fields'		=> array(
						  						array(
													 'field'=>'id',
													 'alias'=>'id'
													 ),
												array(
													 'field'=>'name',
													 'alias'=>'name'
													 ),
												array(
													 'field'=>'alias',
													 'alias'=>'alias'
													 ),
												array(
													 'field'=>'parent',
													 'alias'=>'parent'
													 ),
												array(
													 'field'=>'block',
													 'alias'=>'block'
													 ),
												array(
													 'field'=>'dateCreate',
													 'alias'=>'dateCreate'
													 )
												)
						 )
					);
	$fields = array(
					array(
						 'title'	=> 'Название',
						 'type'		=> 'conc_link',
						 'value'	=> array('name'),
						 'actions'	=> array(
						 					array(
						 						'func'		=>	'change_head',
												'params'	=>	array(
																	  array(
																	 		'type' 	=> 1,
																	 		'value'	=> 3
												 					 		)
																	  )
												 ),
											array(
						 						'func'		=>	'load_app_card',
												'params'	=>	array(
																	  array(
																	 		'type' 	=> 1,
																	 		'value'	=> 'card_path'
												 					 		),
																	  array(
																	 		'type' 	=> 2,
																	 		'value'	=> 'id'
												 					 		),
																	  array(
																	 		'type' 	=> 1,
																	 		'value'	=> 'card_data'
												 					 		)
																	  )
												 )
											),
							'rule' 	=> 'category_tree'
						 ),
					array(
						 'title'	=> 'Алиас',
						 'type'		=> 'text',
						 'value'	=> 'alias'
						 ),
					array(
						 'title'	=> 'Товаров',
						 'type'		=> 'sql_query',
						 'query'	=> 'SELECT COUNT(*) FROM [pre]shop_products as SP LEFT JOIN [pre]shop_cat_prod_ref as SCPR ON SP.id = SCPR.prod_id WHERE SCPR.cat_id = :1 ORDER BY SP.id LIMIT 10000',
						 'ref_field'=> 'id',
						 'col_type' => 'text',
						 'value'	=> 'COUNT(*)'
						 ),
					array(
						 'title'	=> 'Состояние',
						 'type'		=> 'block',
						 'value'	=> 'block'
						 ),
					array(
						 'title'	=> 'ID',
						 'type'		=> 'text',
						 'value'	=> 'id'
						 )
					);
					
	$query = "SELECT * FROM [pre]shop_catalog WHERE `parent`=0 ORDER BY id LIMIT 1000";
			
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		$parents = $_arr->fetchallAssoc();
		
	$query = "SELECT * FROM [pre]shop_chars_groups WHERE 1 ORDER BY id LIMIT 1000";
			
		$_stmt	= $dbh->prepare($query);
		$_arr 	= $_stmt->execute();
		$chars_groups = $_arr->fetchallAssoc();
	
	$card_data = array(
					  'table' 			=> 'shop_catalog',
					  'one_photo_field'	=> 'filename',
					  'fields'	=> array(
					  					array(
											 'title'		=> 'Название',
											 'name'			=> 'name',
											 'type'			=> 'text',
											 'default'		=> 'Название',
											 'size'			=> '25',
											 'maxlength'	=> '50',
											 'onchange'		=> '',
											 'important'	=>	1,
											 'valid'		=>	'3',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Алиас',
											 'name'			=> 'alias',
											 'type'			=> 'text',
											 'default'		=> 'Alias',
											 'size'			=> '25',
											 'maxlength'	=> '50',
											 'onchange'		=> '',
											 'important'	=>	1,
											 'valid'		=>	'3',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Публикация',
											 'name'			=> 'block',
											 'type'			=> 'radio',
											 'default'		=> '0',
											 'size'			=> '',
											 'maxlength'	=> '',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array(0=>'Да',1=>'Нет')
											 ),
										array(
											 'title'		=> 'Родитель',
											 'name'			=> 'parent',
											 'type'			=> 'select',
											 'default'		=> 'В корне',
											 'parent_field'	=> 'parent',		// Указываем поле из основной таблицы для сравнения с REF_FIELD из списка в SELECT
											 'ref_field'	=> 'id',
											 'ref_name'		=> 'name',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> $parents
											 ),
										array(
											 'title'		=> 'Группа характеристик',
											 'name'			=> 'specs_group_id',
											 'type'			=> 'select',
											 'parent_field'	=> 'specs_group_id',		// Указываем поле из основной таблицы для сравнения с REF_FIELD из списка в SELECT
											 'ref_field'	=> 'id',
											 'ref_name'		=> 'name',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> $chars_groups
											 ),
										array(
											 'title'		=> '',
											 'name'			=> 'details',
											 'type'			=> 'textarea',
											 'default'		=> 'Описание категории',
											 'size'			=> '255',
											 'maxlength'	=> '50',
											 'onchange'		=> '',
											 'important'	=>	1,
											 'valid'		=>	'3',
											 'edit'			=>  1,
											 'data'			=> array(),
											 'new_line'		=> 'Описание категории'
											 ),
										array(
											 'title'		=> 'Начало публикации',
											 'name'			=> 'startPublish',
											 'type'			=> 'datetime',
											 'default'		=> '0',
											 'size'			=> '',
											 'maxlength'	=> '',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array(),
											 'new_line'		=> 'Параметры публикации'
											 ),
										array(
											 'title'		=> 'Конец публикации',
											 'name'			=> 'finishPublish',
											 'type'			=> 'datetime',
											 'default'		=> '0',
											 'size'			=> '',
											 'maxlength'	=> '',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Title',
											 'name'			=> 'meta_title',
											 'type'			=> 'text',
											 'default'		=> 'Title',
											 'size'			=> '50',
											 'maxlength'	=> '100',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array(),
											 'new_line'		=> 'Мета данные'
											 ),
										array(
											 'title'		=> 'Keywords',
											 'name'			=> 'meta_keys',
											 'type'			=> 'text',
											 'default'		=> 'Keywords',
											 'size'			=> '50',
											 'maxlength'	=> '100',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Description',
											 'name'			=> 'meta_desc',
											 'type'			=> 'textarea',
											 'default'		=> 'Description',
											 'size'			=> '50',
											 'maxlength'	=> '100',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Индексация',
											 'name'			=> 'index',
											 'type'			=> 'radio',
											 'default'		=> '1',
											 'size'			=> '',
											 'maxlength'	=> '',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array(1=>'Да',0=>'Нет')
											 )
										),
						'extra_fields'	=>	array(),
						'files'			=>	array(
												  array(
												  		'type'			=> 'one_photo',
														'group_title'	=> 'Изображение категории',
														'table'			=> 'shop_catalog',
														'field' 		=> 'filename',
														'refs'			=> array(
																				array(
																					  'ref'		=>	'id',
																					  'source'	=>	'item',
																					  'field'	=>	'id'
																					  )
																				 ),
														'path'			=> WP_FOLDER.'files/shop/categories/',
														'crop'			=> 'crop/',
														'crop_w'		=> '150',
														'crop_h'		=> '150',
														'title'			=> 'Изображение категории',
														'action_title'	=> 'Загрузить изображение (1:1 jpeg/png)',
														'size'			=> 5, 	// Mb
														'rule'			=> 1, 	// 1:1
														'max_w'			=> 2500,
														'max_h'			=> 2500
														)
												  ),
						'save_rules'	=>	array()
					  );
	
	$smarty->assign("filtr_table",$filtr_table);
	$smarty->assign("filtr_1",$filtr_1);
	$smarty->assign("filtr_2",$filtr_2);
	$smarty->assign("filtr_3",$filtr_3);
	
	$smarty->assign("tables",$filtr_3);
	$smarty->assign("fields",$filtr_3);
	
	$smarty->assign("data",$data); // присваиваем переменной
	$smarty->display("view.tpl"); // выводим обработанный
	
?>

	<script type="text/javascript" language="javascript">
		$(function(){
			$('form[name=wp-filtr-form]').ajaxForm();
			var data = {
						filtr_table:'<?php echo $filtr_table ?>',
						tables:'<?php echo serialize($tables) ?>',
						fields:'<?php echo serialize($fields) ?>',
						card_data:'<?php echo serialize($card_data) ?>',
						
						app_id	:<?php echo $app_id ?>,
						ajaxpath:'<?php echo $data['ajaxpath'] ?>',
						start_page:<?php echo $data['start_page'] ?>,
						on_page:<?php echo $data['on_page'] ?>,
						first_load:1,
						}
			$('#inajax-1').load(data.ajaxpath,data);
			
			global_table_filtr = data.filtr_table;
			global_tables = data.tables;
			global_fields = data.fields;
		});
	</script>
    