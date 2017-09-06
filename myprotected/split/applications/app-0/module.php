<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file of Application << 9 >>
	
	$app_id = 9;
	
	$data = array();
	
	$data['loadsrc'] = "/".ADMIN_PATH.WP_FOLDER."/img/pulse.gif";
	$data['ajaxpath'] = "/".ADMIN_PATH.WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/content.load.php";
	
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
						 						'func'		=>	'load_card',
												'params'	=>	array(
																	  array(
																	 		'type' 	=> 1,
																	 		'value'	=> 'card_path'
												 					 		),
																	  array(
																	 		'type' 	=> 2,
																	 		'value'	=> 'id'
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
    