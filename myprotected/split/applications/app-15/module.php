<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file of Application << 9 >>
	
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
	
	$filtr_table = "banners";
	
	$filtr_1 = array(
					'search'	=> 'Поиск по баннерам',
					'options'	=> array(
										 array(
										 	  'title'=>'Имени',
											  'value'=>'name'
											  ),
										 array(
										 	  'title'=>'Алиасу',
											  'value'=>'alias'
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
						 'title'	=>	'Дата создания',
						 'value'	=>	'dateCreate',
						 ),
					array(
						 'title'	=>	'ID',
						 'value'	=>	'id',
						 ),
					
					);
	
	$tables = array(
					array(
						  'name'		=> 'banners',
						  'or_name'		=> 'BAN',
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
													 'field'=>'block',
													 'alias'=>'block'
													 ),
												array(
													 'field'=>'startPublish',
													 'alias'=>'startPublish'
													 ),
												array(
													 'field'=>'finishPublish',
													 'alias'=>'finishPublish'
													 )
												)
						 ),
					array(
						  'name'		=> 'site_positions',
						  'or_name'		=> 'POS',
						  'ref_table'	=> 'BAN',
						  'ref_field'	=> 'id',
						  'ref_on'		=> 'pos_id',
						  'fields'		=> array(
						  						array(
													 'field'=>'name',
													 'alias'=>'pos_name'
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
											)
						 ),
					array(
						 'title'	=> 'Позиция',
						 'type'		=> 'text',
						 'value'	=> 'pos_name'
						 ),
					array(
						 'title'	=> 'Начало показа',
						 'type'		=> 'date',
						 'value'	=> 'startPublish'
						 ),
					array(
						 'title'	=> 'Конец показа',
						 'type'		=> 'date',
						 'value'	=> 'finishPublish'
						 ),
					array(
						 'title'	=> 'Публикация',
						 'type'		=> 'block',
						 'value'	=> 'block'
						 ),
					array(
						 'title'	=> 'ID',
						 'type'		=> 'text',
						 'value'	=> 'id'
						 )
					);
					
	
	$positions_query = "SELECT * FROM [pre]site_positions WHERE 1 ORDER BY id LIMIT 1000";
			
		$positions_stmt	= $dbh->prepare($positions_query);
		$positions_arr 	= $positions_stmt->execute();
		$positions 		= $positions_stmt->fetchallAssoc();
	
	$card_data = array(
					  'table' 			=> 'banners',
					  'one_photo_field'	=> '',
					  'editor'			=> array(
					  							 'field'		=>	'data',
												 'title'		=>	'Содержание баннера',
												 'default'		=>	'Код баннера генерируется исходя из настроек выше.',
												 'file_path'	=>	'files/banners/',
												 'redactor'		=>   0
												 ),
					  'fields'	=> array(
					  					array(
											 'title'		=> 'Имя',
											 'name'			=> 'name',
											 'type'			=> 'text',
											 'default'		=> 'Имя',
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
											 'title'		=> 'Позиция',
											 'name'			=> 'pos_id',
											 'type'			=> 'select',
											 'parent_field'	=> 'pos_id',		// Указываем поле из основной таблицы для сравнения с REF_FIELD из списка в SELECT
											 'ref_field'	=> 'id',
											 'ref_name'		=> 'name',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> $positions
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
											 'data'			=> array(),
											 'new_line'		=> 'Мета данные'
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
						'extra_fields'	=>	array(
												  ),
						'files'			=>	array(
												 ),
						'save_rules'	=>	array(
												 )
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
    