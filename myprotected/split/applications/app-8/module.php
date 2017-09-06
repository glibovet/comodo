<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file of Application << 8 >>
	
	$app_id = 0; // TEMPLATE APPLICATION
	
	$data = array();
	
	$data['loadsrc'] = "/".ADMIN_PATH.WP_FOLDER."/img/pulse.gif";
	$data['ajaxpath'] = "/".ADMIN_PATH.WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/card.load.php";
	
	$data['start_page'] = 1;
	$data['on_page'] = 10;
	
	if(isset($_COOKIE['on_page_'.$app_id]) && $_COOKIE['on_page_'.$app_id] != null && $_COOKIE['on_page_'.$app_id] > 5)
	{
		$data['on_page'] = $_COOKIE['on_page_'.$app_id];
	}
	
	$filtr_table = "users";
	
	$filtr_1 = array(
					'search'	=> 'Поиск по пользователем',
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
						),
						array(
						'select_title'	=> 'Активирован',
						'select_name'	=> 'filtr[active]',
						'options'	=> array(
											array(
												'title'=>'Да',
												'value'=>'1'
												),
											array(
												'title'=>'Нет',
												'value'=>'0'
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
						 'title'	=>	'Активация',
						 'value'	=>	'active',
						 ),
					array(
						 'title'	=>	'Регистрация',
						 'value'	=>	'dateCreate',
						 ),
					array(
						 'title'	=>	'ID',
						 'value'	=>	'id',
						 ),
					
					);
	
	$tables = array(
					array(
						  'name'		=> 'users',
						  'or_name'		=> 'US',
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
													 'field'=>'fname',
													 'alias'=>'fname'
													 ),
												array(
													 'field'=>'type',
													 'alias'=>'type'
													 ),
												array(
													 'field'=>'block',
													 'alias'=>'block'
													 ),
												array(
													 'field'=>'active',
													 'alias'=>'active'
													 ),
												array(
													 'field'=>'dateCreate',
													 'alias'=>'dateCreate'
													 )
												)
						 ),
					array(
						  'name'		=> 'users_types',
						  'or_name'		=> 'UST',
						  'ref_table'	=> 'US',
						  'ref_field'	=> 'id',
						  'ref_on'		=> 'type',
						  'fields'		=> array(
						  						array(
													 'field'=>'name',
													 'alias'=>'group_name'
													 )
												)
						 )
					);
	$fields = array(
					array(
						 'title'	=> 'Пользователь',
						 'type'		=> 'conc_link',
						 'value'	=> array('name','fname'),
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
						 'title'	=> 'Группа',
						 'type'		=> 'text',
						 'value'	=> 'group_name'
						 ),
					array(
						 'title'	=> 'Опубликован',
						 'type'		=> 'block',
						 'value'	=> 'block'
						 ),
					array(
						 'title'	=> 'Состояние',
						 'type'		=> 'active',
						 'value'	=> 'active'
						 ),
					array(
						 'title'	=> 'Дата регистрации',
						 'type'		=> 'date',
						 'value'	=> 'dateCreate'
						 ),
					array(
						 'title'	=> 'ID',
						 'type'		=> 'text',
						 'value'	=> 'id'
						 )
					);
					
	$types_query = "SELECT * FROM [pre]users_types WHERE `block`=0 ORDER BY id LIMIT 1000";
			
		$types_stmt = $dbh->prepare($types_query);
		$types_arr = $types_stmt->execute();
		$types = $types_stmt->fetchallAssoc();
	
	$card_data = array(
					  'table' 			=> 'users',
					  'one_photo_field'	=> 'avatar',
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
											 'title'		=> 'Фамилия',
											 'name'			=> 'fname',
											 'type'			=> 'text',
											 'default'		=> 'Фамилия',
											 'size'			=> '25',
											 'maxlength'	=> '50',
											 'onchange'		=> '',
											 'important'	=>	1,
											 'valid'		=>	'3',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Email',
											 'name'			=> 'login',
											 'type'			=> 'email',
											 'default'		=> 'Email',
											 'size'			=> '25',
											 'maxlength'	=> '50',
											 'onchange'		=> 'valid_email($(this).val());',
											 'important'	=>	1,
											 'valid'		=>	'email',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Телефон',
											 'name'			=> 'phone',
											 'type'			=> 'phone',
											 'default'		=> '38 (096) 000-00-00',
											 'size'			=> '25',
											 'maxlength'	=> '20',
											 'onchange'		=> 'valid_phone($(this).val());',
											 'important'	=>	1,
											 'valid'		=>	'phone',
											 'edit'			=>  1,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Пароль',
											 'name'			=> 'pass',
											 'type'			=> 'password',
											 'default'		=> 'Password',
											 'size'			=> '30',
											 'maxlength'	=> '50',
											 'onchange'		=> '',
											 'important'	=>	1,
											 'valid'		=>	'6',
											 'edit'			=>  0,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Повторите пароль',
											 'name'			=> 're-pass',
											 'type'			=> 'password',
											 'default'		=> 'Re-password',
											 'size'			=> '30',
											 'maxlength'	=> '50',
											 'onchange'		=> '',
											 'important'	=>	1,
											 'valid'		=>	're-pass',
											 'edit'			=>  0,
											 'data'			=> array()
											 ),
										array(
											 'title'		=> 'Группа',
											 'name'			=> 'type',
											 'type'			=> 'select',
											 'parent_field'	=> 'type',		// Указываем поле из основной таблицы для сравнения с REF_FIELD из списка в SELECT
											 'ref_field'	=> 'id',
											 'ref_name'		=> 'name',
											 'onchange'		=> 'reload_save_extra_fields($(this).val(),0,"type");',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  0,
											 'data'			=> $types
											 ),
										array(
											 'title'		=> 'Дата рождения',
											 'name'			=> 'birthday',
											 'type'			=> 'datetime',
											 'default'		=> '',
											 'size'			=> '',
											 'maxlength'	=> '',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
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
											 'edit'			=>  0,
											 'data'			=> array(0=>'Да',1=>'Нет')
											 ),
										array(
											 'title'		=> 'Пол',
											 'name'			=> 'male',
											 'type'			=> 'radio',
											 'default'		=> '0',
											 'size'			=> '',
											 'maxlength'	=> '',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  1,
											 'data'			=> array('М'=>'М','Ж'=>'Ж')
											 ),
										array(
											 'title'		=> 'Активирован',
											 'name'			=> 'active',
											 'type'			=> 'radio',
											 'default'		=> '0',
											 'size'			=> '',
											 'maxlength'	=> '',
											 'onchange'		=> '',
											 'important'	=>	0,
											 'valid'		=>	'',
											 'edit'			=>  0,
											 'data'			=> array(0=>'Нет',1=>'Да')
											 )
										),
						'extra_fields'	=>	array(
												  array(
												  		'type'	=>	'group', // OR list
														'title'	=>	'Дополнительные поля для пользователя из группы',
														'refs'	=>	array(
																		 'ef_groups'	=> array(
																		 						'type'			=> 'simple',
																		 						'table'			=> 'users_types_extra_field_ref',
																								'where'			=> array(
																														array(
																															  'parent'		=> 'item',
																															  'parent_field'=> 'type',
																															  'ref_field'	=> 'group_id'	
																															  )																					
																														),
																								'fields'		=> array('ef_group_id'),
																								'order'			=> 'id',
																								'limit'			=> 100
																								),
																		 'ef_group'		=> array(
																		 						'type'			=> 'simple',
																		 						'table'			=> 'users_extra_fields_groups',
																								'where'			=> array(
																														array(
																															  'parent'		=> 'ef_groups',
																															  'parent_field'=> 'ef_group_id',
																															  'ref_field'	=> 'id'	
																															  )																					
																														),
																								'fields'		=> array('name'),
																								'order'			=> 'id',
																								'limit'			=> 1
																								),
																		 'extra_fields'	=> array(
																		 						'type'			=> 'join',
																		 						'table'		 	=> 'user_extra_fields',
																								'as'			=> 'EF',
																								'join'			=> array(
																														 array(
																														 	   'table'	=> 'users_ef_group_ref',
																															   'as'		=> 'REF',
																															   'on'		=> 'EF.id = REF.ef_id'
																															   )/*,
																														array(
																														 	   'table'	=> 'user_ef_ref',
																															   'as'		=> 'UEF',
																															   'on'		=> 'UEF.ef_id = REF.ef_id'
																															   )*/
																														 ),
																								'where'			=> array(
																														array(
																															  'parent'		=> 'ef_groups',
																															  'parent_field'=> 'ef_group_id',
																															  'ref_field'	=> 'REF.group_id'
																															  )/*,
																														array(
																															  'parent'		=> 'item',
																															  'parent_field'=> 'id',
																															  'ref_field'	=> 'UEF.user_id'
																															  )	*/																				
																														),
																								'fields'		=> array(
																														'EF.`name`		as name',
																														'EF.`details`	as details',
																														'EF.`length`	as length',
																														'EF.`default`	as def',
																														'REF.`ef_id`	as ef_id',
																														//'UEF.`value`	as value',
																														'EF.`type`		as type' // IMPORTANT FIELD
																														),
																								'order'			=> 'EF.id',
																								'limit'			=> 100
																								)
																		 ),
														'groups' => array(
																		 'parent'		=> 'ef_groups',
																		 'actions'		=> array(
																		 						 'ef_group',
																								 'extra_fields'
																								 ),
																		 'title_parent'	=> 'ef_group',
																		 'title_value'	=> 'name',
																		 'field'	=> array(
																								'id'			=> 'ef-value',
																								'name'			=> 'ef',
																								'field_parent'	=> 'extra_fields',
											 													'field_name'	=> 'name',
																								'field_title'	=> 'details',
											 													'field_type'	=> 'type',
																								'field_num'		=> 'ef_id',
																								'field_value'	=> array(
																		  												'table'	=> 'user_ef_ref',
																		  												'field'	=> 'value',
																		  												'where'	=> array(
																		  					 											array(
																							 	   											'field'			=> 'user_id',
																								   											'parent'		=> 'item',
																								   											'parent_field'	=>	'id'
																								   											  ),
																							 											array(
																							 	   											 'field'		=> 'ef_id',
																								   											 'parent'		=> 'extra_fields',
																								   											 'parent_field'	=>	'ef_id'
																								   								)
																															)
																		  												),
											 													'field_default'	=> 'def',
											 													'size'			=> 'length',
											 													'maxlength'		=> 'length',
											 													'onchange'		=> '',
											 													'data'			=> array()
																							)
																		 )
														)
												  ),
						'files'			=>	array(
												  array(
												  		'type'			=> 'one_photo',
														'group_title'	=> 'Управление аватаром пользователя',
														'table'			=> 'users',
														'field' 		=> 'avatar',
														'refs'			=> array(
																				array(
																					  'ref'		=>	'id',
																					  'source'	=>	'item',
																					  'field'	=>	'id'
																					  )
																				 ),
														'path'			=> WP_FOLDER.'files/users/',
														'crop'			=> 'crop/',
														'crop_w'		=> '150',
														'crop_h'		=> '150',
														'title'			=> 'Аватар пользователя',
														'action_title'	=> 'Загрузить аватарку (1:1 jpeg/png)',
														'size'			=> 5, 	// Mb
														'rule'			=> 1, 	// 1:1
														'max_w'			=> 2500,
														'max_h'			=> 2500
														)
												  ),
						'save_rules'	=>	array(
												  array(
												  		'post_field'	=> 'ef',
												  		'table'			=> 'user_ef_ref',
														'field'			=> 'value',
														'where'			=> array(
																		 		'item_id'	=>	'user_id',
																		 		'ef_id'		=>	'ef_id'
																		 		)
												  		)
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
		var card_path = '<?php echo $data['ajaxpath'] ?>';
		var card_data = '<?php echo serialize($card_data) ?>';
		
		
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
			// $('#inajax-1').load(data.ajaxpath,data);
			
			load_app_card(card_path, <?php echo ADMIN_ID ?>, card_data);
			
			global_table_filtr = data.filtr_table;
			global_tables = data.tables;
			global_fields = data.fields;
		});
	</script>
    